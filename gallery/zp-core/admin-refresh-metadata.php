<?php
/**
 * This template is used to reload metadata from images. Running it will process the entire gallery,
 * supplying an album name (ex: loadAlbums.php?album=newalbum) will only process the album named.
 * @package admin
 */

// force UTF-8 Ø

define('OFFSET_PATH', 1);
require_once(dirname(__FILE__).'/admin-globals.php');
require_once(dirname(__FILE__).'/template-functions.php');

if (isset($_REQUEST['album'])) {
	$localrights = ALBUM_RIGHTS;
} else {
	$localrights = NULL;
}
admin_securityChecks($localrights, $return = currentRelativeURL(__FILE__));

XSRFdefender('refresh');

$gallery = new Gallery();
$imageid = '';
if (isset($_GET['refresh'])) {
	if (isset($_GET['id'])) {
		$imageid = sanitize_numeric($_GET['id']);
	}
	$imageid = $gallery->garbageCollect(true, true, $imageid);
}

if (isset($_GET['prune'])) {
	$type = 'prune&amp;';
	$title = gettext('Refresh Database');
	$finished = gettext('Finished refreshing the database');
	$incomplete = gettext('Database refresh is incomplete');
	$allset = gettext("We're all set to refresh the database");
	$continue = gettext('Continue refreshing the database.');
} else {
	$type = '';
	$title = gettext('Refresh Metadata');
	$finished = gettext('Finished refreshing the metadata');
	$incomplete = gettext('Metadata refresh is incomplete');
	$allset = gettext("We're all set to refresh the metadata");
	$continue = gettext('Continue refreshing the metadata.');
}

if (isset($_REQUEST['album'])) {
	$tab = 'edit';
} else {
	$tab = 'utilities';
}
$albumparm = $folder = $albumwhere = $imagewhere = $id = $r = '';
if (isset($_REQUEST['return'])) {
	$ret = sanitize_path($_REQUEST['return']);
	if (substr($ret, 0, 1) == '*') {
		if (empty($ret) || $ret == '*.' || $ret == '*/') {
			$r = '?page=edit';
		} else {
			$r = '?page=edit&amp;album='.pathurlencode(substr($ret, 1)).'&amp;tab=subalbuminfo';
		}
	} else {
		$r = '?page=edit&amp;album='.pathurlencode($ret);
	}
	$backurl = 'admin-edit.php'.$r;
} else {
	$ret = '';
	$backurl = 'admin.php';
}

if (db_connect()) {
	if (isset($_REQUEST['album'])) {
		if (isset($_POST['album'])) {
			$alb = sanitize(urldecode($_POST['album']));
		} else {
			$alb = sanitize($_GET['album']);
		}
		$folder = sanitize_path($alb);
		if (!empty($folder)) {
			$album = new Album($gallery, $folder);
			if (!$album->isMyItem(ALBUM_RIGHTS)) {
				if (!zp_apply_filter('admin_managed_albums_access',false, $return)) {
					header('Location: ' . FULLWEBPATH . '/' . ZENFOLDER . '/admin.php');
					exit();
				}
			}
		}
		$albumparm = '&amp;album='.pathurlencode($folder);
	}
	if (isset($_GET['refresh'])) {
		if (empty($imageid)) {
			$metaURL = $backurl;
		} else {
			if (!empty($ret)) $ret = '&amp;return='.$ret;
			$metaURL = $redirecturl = '?'.$type.'refresh=continue&amp;id='.$imageid.$albumparm.$ret.'&XSRFToken='.getXSRFToken('refresh');
		}
	} else {
		if ($type !== 'prune&amp;') {
			if (!empty($folder)) {
				$album = new Album($gallery, $folder);
				if (!$album->isMyItem(ALBUM_RIGHTS)) {
					if (!zp_apply_filter('admin_managed_albums_access',false, $return)) {
						header('Location: ' . FULLWEBPATH . '/' . ZENFOLDER . '/admin.php');
						exit();
					}
				}
				$sql = "SELECT `id` FROM ". prefix('albums') . " WHERE `folder`=".db_quote($folder);
				$row = query_single_row($sql);
				$id = $row['id'];
			}

			if (!empty($id)) {
				$imagewhere = "WHERE `albumid`=$id";
				$r = " $folder";
				$albumwhere = "WHERE `parentid`=$id";
			}
		}
		if (isset($_REQUEST['return'])) $ret = sanitize_path($_REQUEST['return']);
		if (!empty($ret)) $ret = '&amp;return='.$ret;
		$metaURL = $starturl = '?'.$type.'refresh=start'.$albumparm.'&amp;XSRFToken='.getXSRFToken('refresh').$ret;
	}
}

printAdminHeader($tab,'refresh');
if (!empty($metaURL)) {
	?>
	<meta http-equiv="refresh" content="1; url=<?php echo $metaURL; ?>" />
	<?php
}
echo "\n</head>";
echo "\n<body>";
printLogoAndLinks();
echo "\n" . '<div id="main">';
printTabs();
echo "\n" . '<div id="content">';
echo "<h1>".$title."</h1>";
if (isset($_GET['refresh']) && db_connect()) {
	if (empty($imageid)) {
		?>
		<h3><?php echo $finished; ?></h3>
		<p><?php echo gettext('you should return automatically. If not press: '); ?></p>
		<p><a href="<?php echo $backurl; ?>">&laquo; <?php echo gettext('Back'); ?></a></p>
		<?php
	} else {
		?>
		<h3><?php echo $incomplete; ?></h3>
		<p><?php echo gettext('This process should continue automatically. If not press: '); ?></p>
		<p><a href="<?php echo $redirecturl; ?>" title="<?php echo $continue; ?>" style="font-size: 15pt; font-weight: bold;">
			<?php echo gettext("Continue!"); ?></a>
		</p>
		<?php
	}

} else if (db_connect()) {
	echo "<h3>".gettext("database connected")."</h3>";
	if ($type !== 'prune&amp;') {
		if (!empty($id)) {
			$sql = "UPDATE " . prefix('albums') . " SET `mtime`=0".($gallery->getAlbumUseImagedate()?", `date`=NULL":'')." WHERE `id`=$id";
			query($sql);
		}
		$sql = "UPDATE " . prefix('albums') . " SET `mtime`=0 $albumwhere";
		query($sql);
		$sql = "UPDATE " . prefix('images') . " SET `mtime`=0 $imagewhere;";
		query($sql);
	}
	if (!empty($folder) && empty($id)) {
		echo "<p> ".sprintf(gettext("<em>%s</em> not found"),$folder)."</p>";
	} else {
		if (empty($r)) {
			echo "<p>".$allset."</p>";
		} else {
			echo "<p>".sprintf(gettext("We're all set to refresh the metadata for <em>%s</em>"),$r)."</p>";
		}
		echo '<p>'.gettext('This process should start automatically. If not press: ').'</p>';
		?>
		<p><a href="<?php echo $starturl.'&amp;XSRFToken='.getXSRFToken('refresh'); ?>"
					title="<?php echo gettext("Refresh image metadata."); ?>" style="font-size: 15pt; font-weight: bold;">
			<?php echo gettext("Go!"); ?></a>
		</p>
		<?php
	}
} else {
	echo "<h3>".gettext("database not connected")."</h3>";
	echo "<p>".gettext("Check your configuration file to make sure you've got the right username, password, host, and database. If you haven't created the database yet, now would be a good time.");
}

echo "\n" . '</div>';
echo "\n" . '</div>';

printAdminFooter();

echo "\n</body>";
echo "\n</html>";
?>



