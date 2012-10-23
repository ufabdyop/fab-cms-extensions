<?php
/**
 * provides the Plugins tab of admin
 * @package admin
 */

// force UTF-8 Ø

define('OFFSET_PATH', 1);
require_once(dirname(__FILE__).'/admin-globals.php');

admin_securityChecks(NULL, currentRelativeURL(__FILE__));

$gallery = new Gallery();
$_GET['page'] = 'plugins';

/* handle posts */
if (isset($_GET['action'])) {
	if ($_GET['action'] == 'saveplugins') {
		XSRFdefender('saveplugins');
		$filelist = getPluginFiles('*.php');
		foreach ($filelist as $extension=>$path) {
			$extension = filesystemToInternal($extension);
			$opt = 'zp_plugin_'.$extension;
			if (isset($_POST[$opt])) {
				$value = sanitize_numeric($_POST[$opt]);
				if (!getOption($opt)) {
					$option_interface = NULL;
					require_once($path);
					if (is_string($option_interface)) {
						$if = new $option_interface;	//	prime the default options
					}
				}
				setOption($opt, $value);
			} else {
				setOption($opt, 0);
			}
		}
		header("Location: " . FULLWEBPATH . "/" . ZENFOLDER . "/admin-plugins.php?saved");
		exit();
	}
}
$saved = isset($_GET['saved']);
printAdminHeader('plugins');
zp_apply_filter('texteditor_config', '','zenphoto');
?>
<script type="text/javascript">
<!--
function toggleDetails(plugin) {
	toggle(plugin+'_show');
	toggle(plugin+'_hide');
}

function truncateDesc(text) {
	text = text.replace(/(<script.*?script>)/ig,"");	//strip scripts
	text = text.replace(/(<.*?>)/ig," ");							//strip tags
	if (text.length <= 70) return text;
	ls = 0;
	for (i=0;i<text.length;i++) {
		if (text[i] == ' ' && i>ls) ls = i;
		if (i >= 69) break;
	}
	if (ls == 0) ls == i;
	return text.substring(0,ls)+'...'
}

//-->
</script>
<?php
echo "\n</head>";
echo "\n<body>";
printLogoAndLinks();
echo "\n" . '<div id="main">';
$paths = getPluginFiles('*.php');
$filelist = array_keys($paths);
natcasesort($filelist);
printTabs();
echo "\n" . '<div id="content">';

/* Page code */

if ($saved) {
	echo '<div class="messagebox fade-message">';
	echo  "<h2>".gettext("Applied")."</h2>";
	echo '</div>';
}

?>
<h1><?php echo gettext('Plugins'); ?></h1>
<p>
<?php
echo gettext("Plugins provide optional functionality for Zenphoto.").' ';
echo gettext("They may be provided as part of the Zenphoto distribution or as offerings from third parties.").' ';
echo sprintf(gettext("Third party plugins are placed in the <code>%s</code> folder and are automatically discovered."),USER_PLUGIN_FOLDER).' ';
echo gettext("If the plugin checkbox is checked, the plugin will be loaded and its functions made available to theme pages. If the checkbox is not checked the plugin is disabled and occupies no resources.");
?>
</p>
<p class='notebox'><?php echo gettext("<strong>Note:</strong> Support for a particular plugin may be theme dependent! You may need to add the plugin theme functions if the theme does not currently provide support."); ?>
</p>
<form action="?action=saveplugins" method="post">
	<?php XSRFToken('saveplugins');?>
	<input type="hidden" name="saveplugins" value="yes" />
<p class="buttons">
<button type="submit" value="<?php echo gettext('Apply') ?>" title="<?php echo gettext("Apply"); ?>"><img src="images/pass.png" alt="" /><strong><?php echo gettext("Apply"); ?></strong></button>
<button type="reset" value="<?php echo gettext('Reset') ?>" title="<?php echo gettext("Reset"); ?>"><img src="images/reset.png" alt="" /><strong><?php echo gettext("Reset"); ?></strong></button>
</p><br clear="all" /><br /><br />
<table class="bordered options">
<tr>
<th><?php echo gettext("Available Plugins"); ?></th>
<th colspan="2">
	<?php echo gettext("Description"); ?>
</th>
<tr>
	<td></td>
	<td colspan="2">
		<span class="pluginextrahide" style="display:none">
		<p class="buttons"><a href="javascript:toggleExtraInfo('','plugin',false);" title ="<?php echo gettext('hide all description details'); ?>" ><?php echo gettext('hide all'); ?></a></p>
	</span>
	<span class="pluginextrashow" >
		<p class="buttons"><a href="javascript:toggleExtraInfo('','plugin',true);" title ="<?php echo gettext('show all description details'); ?>" ><?php echo gettext('show all'); ?></a></p>
	</span>
	</td>
</tr>
</tr>
<?php
foreach ($filelist as $extension) {
	$opt = 'zp_plugin_'.$extension;
	$third_party_plugin = strpos($paths[$extension],ZENFOLDER) === false;
	$pluginStream = file_get_contents($paths[$extension]);
	$parserr = 0;
	if ($str = isolate('$plugin_description', $pluginStream)) {
		if (false === eval($str)) {
			$parserr = $parserr | 1;
			$plugin_description = gettext('<strong>Error parsing <em>plugin_description</em> string!</strong>.');
		}
	} else {
		$plugin_description = '';
	}
	if ($str = isolate('$plugin_notice', $pluginStream)) {
		if (false === eval($str)) {
			$parserr = $parserr | 1;
		}
	} else {
		$plugin_notice = '';
	}
	if ($str = isolate('$plugin_author', $pluginStream)) {
		if (false === eval($str)) {
			$parserr = $parserr | 2;
			$plugin_author = gettext('<strong>Error parsing <em>plugin_author</em> string!</strong>.');
		}
	} else {
		$plugin_author = '';
	}
	if ($str = isolate('$plugin_version', $pluginStream)) {
		if (false === eval($str)) {
			$parserr = $parserr | 4;
			$plugin_version = ' '.gettext('<strong>Error parsing <em>plugin_version</em> string!</strong>.');
		}
	} else {
		$plugin_version = '';
	}
	if ($third_party_plugin) {
		if ($str = isolate('$plugin_URL', $pluginStream)) {
			if (false === eval($str)) {
				$parserr = $parserr | 8;
				$plugin_URL = gettext('<strong>Error parsing <em>plugin_URL</em> string!</strong>.');
			}
		} else {
			$plugin_URL = '';
		}
	} else {
		$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_".PLUGIN_FOLDER."---".basename($paths[$extension]).".html";
	}
	if ($str = isolate('$plugin_disable', $pluginStream)) {
		if (false === eval($str)) {
			$parserr = $parserr | 8;
			$plugin_URL = gettext('<strong>Error parsing <em>plugin_disable</em> string!</strong>.');
		} else {
			if ($plugin_disable) {
				setOption($opt, 0);
			}
		}
	} else {
		$plugin_disable = false;
	}
	$currentsetting = getOption($opt);
	$plugin_is_filter = 1|THEME_PLUGIN;
	if ($str = isolate('$plugin_is_filter', $pluginStream)) {
		eval($str);
		if ($plugin_is_filter < THEME_PLUGIN) {
			if ($plugin_is_filter < 0) {
				$plugin_is_filter = abs($plugin_is_filter)|THEME_PLUGIN|ADMIN_PLUGIN;
			} else {
				if ($plugin_is_filter == 1) {
					$plugin_is_filter = 1|THEME_PLUGIN;
				} else {
					$plugin_is_filter = $plugin_is_filter|CLASS_PLUGIN;
				}
			}
		}
		if ($currentsetting && $currentsetting != $plugin_is_filter) {
			setOption($opt, $plugin_is_filter);	//	the script has changed its setting!
		}
	}
	$optionlink = isolate('$option_interface', $pluginStream);
	if ($optionlink = isolate('$option_interface', $pluginStream)) {
		$optionlink = FULLWEBPATH.'/'.ZENFOLDER.'/admin-options.php?page=options&amp;tab=plugin&amp;show-'.$extension.'#'.$extension;
	} else {
		$optionlink = NULL;
	}
	?>
	<tr>
		<td width="30%">
			<label id="<?php echo $extension; ?>_lbl">
				<?php
				if ($third_party_plugin) {
					$path = stripSuffix($paths[$extension]).'/logo.png';
					if (file_exists($path)) {
						$ico = str_replace(SERVERPATH, WEBPATH, $path);
					} else {
						$ico = 'images/place_holder_icon.png';
					}
				} else {
					$ico = 'images/zp_gold.png';
				}
				?>
				<img class="zp_logoicon" src="<?php echo $ico; ?>" alt="" />
				<span class="icons" id="<?php echo $extension;?>_checkbox">
				<?php
				$attributes = '';
				if ($parserr || $plugin_disable) {
					$optionlink = false;
					$attributes .= ' disabled="disabled"';
				} else {
					if ($currentsetting > THEME_PLUGIN) {
						$attributes .= ' checked="checked"';
					}
				}
				?>
				<input type="checkbox" name="<?php echo $opt; ?>" id="<?php echo $opt; ?>" value="<?php echo $plugin_is_filter; ?>"<?php echo $attributes; ?>	/>
			</span>
			<?php
		echo $extension;
		if (!empty($plugin_version)) {
			echo ' v'.$plugin_version;
		}
		if ($plugin_disable) {
			?>
			<br />
			<a href="javascript:toggleDetails('<?php echo $extension;?>');">
				<?php printf(gettext('This plugin is disabled: %s'),''); ?>
			</a>
			<?php
		}
		?>
		</label>
		</td>
		<td>
			<span class="icons"><a href="javascript:toggleDetails('<?php echo $extension;?>');" title ="<?php echo gettext('toggle description details'); ?>" ><img src="images/info_toggle.png" alt="" /></a></span>
		</td>
		<td>
		<span id="<?php echo $extension; ?>_show" class="pluginextrashow"></span>
		<span id="<?php echo $extension; ?>_hide" style="display: none;" class="pluginextrahide">
			<span id="<?php echo $extension; ?>_desc"><?php echo $plugin_description; ?></span>
			<script type="text/javascript">$('#<?php echo $extension; ?>_show').html(truncateDesc($('#<?php echo $extension; ?>_desc').html()));</script>

			<?php
			if (!empty($plugin_URL)) {
				?>
				<br />
				<?php
				if ($parserr & 8) {
					echo $plugin_URL;
				} else {
					?>
					<a href="<?php echo $plugin_URL; ?>"><strong><?php echo gettext("Usage information"); ?></strong></a>
					<?php
				}
			}
			if (!empty($plugin_author)) {
				?>
				<br />
				<?php
				if (!($parserr & 2)) {
					?>
					<strong><?php echo gettext("Author"); ?></strong>
					<?php
				}
				echo $plugin_author;
			}
			if ($optionlink) {
				?>
				<br />
				<a href="<?php echo $optionlink; ?>" ><?php echo gettext("Change plugin options"); ?></a>
				<?php
			}
			if ($plugin_disable) {
				?>
				<p id="showdisable_<?php echo $extension; ?>" style="display:none" class="warningbox">
					<?php
					if ($plugin_disable) {
						echo $plugin_disable;
					}
					?>
				</p>
				<?php
			}
			if ($plugin_notice) {
				?>
				<p id="show_<?php echo $extension; ?>" style="display:none" class="notebox">
					<?php
					if ($plugin_notice) {
						if ($plugin_disable) {
							echo '<br /><br />';
						}
						echo $plugin_notice;
					}
					?>
				</p>
				<?php
			}
			?>
			</span>
		</td>
	</tr>
	<?php
	}
?>
</table>
<br />
<p class="buttons">
<button type="submit" value="<?php echo gettext('Apply') ?>" title="<?php echo gettext("Apply"); ?>"><img src="images/pass.png" alt="" /><strong><?php echo gettext("Apply"); ?></strong></button>
<button type="reset" value="<?php echo gettext('Reset') ?>" title="<?php echo gettext("Reset"); ?>"><img src="images/reset.png" alt="" /><strong><?php echo gettext("Reset"); ?></strong></button>
</p><br />
<?php
echo "</form>\n";

echo "\n" . '</div>';  //content
printAdminFooter();
echo "\n" . '</div>';  //main
echo "\n</body>";
echo "\n</html>";
?>



