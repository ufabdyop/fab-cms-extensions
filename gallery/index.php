<?php
$_zp_script_timer['start'] = microtime();
// force UTF-8 Ø
require_once(dirname(__FILE__).'/zp-core/global-definitions.php');
define('OFFSET_PATH', 0);
require_once(ZENFOLDER . "/template-functions.php");
checkInstall();
//$_zp_script_timer['require'] = microtime();
//rss feeds
if(isset($_GET['rss']) || isset($_GET['rss-news']) || isset($_GET['rss-comments'])) {
	require_once(dirname(__FILE__). '/'.ZENFOLDER.'/functions-rss.php');
	rssHitcounter();
	startRSSCache();

	//gallery RSS
	if(isset($_GET['rss'])) {
		if (!getOption('RSS_album_image')) {
			header("HTTP/1.0 404 Not Found");
			header("Status: 404 Not Found");
			include(ZENFOLDER. '/404.php');
			exit();
		}
		require_once(ZENFOLDER .'/'.PLUGIN_FOLDER . "/image_album_statistics.php");
		include(dirname(__FILE__). "/".ZENFOLDER.'/rss/rss.php');
	}

	//Zenpage News RSS
	if(isset($_GET['rss-news'])) {
		if (!getOption('RSS_articles')) {
			header("HTTP/1.0 404 Not Found");
			header("Status: 404 Not Found");
			include(ZENFOLDER. '/404.php');
			exit();
		}
		include(dirname(__FILE__). "/".ZENFOLDER.'/rss/rss-news.php');
	}

	//Comments RSS
	if(isset($_GET['rss-comments'])) {
		if (!getOption('RSS_comments')) {
			header("HTTP/1.0 404 Not Found");
			header("Status: 404 Not Found");
			include(ZENFOLDER. '/404.php');
			exit();
		}
		include(dirname(__FILE__). "/".ZENFOLDER.'/rss/rss-comments.php');
	}
	endRSSCache();
	exit();
}
//$_zp_script_timer['rss'] = microtime();
/**
 * Invoke the controller to handle requests
 */
require_once(dirname(__FILE__). "/".ZENFOLDER.'/controller.php');
$_zp_obj = '';
//$_zp_script_timer['controller'] = microtime();
// Display an arbitrary theme-included PHP page
if (isset($_GET['p'])) {
	$theme = prepareCustomPage();
// Display an Image page.
} else if (in_context(ZP_IMAGE)) {
	$theme = prepareImagePage();

// Display an Album page.
} else if (in_context(ZP_ALBUM)) {
	$theme = prepareAlbumPage();
	// Display the Index page.
} else if (in_context(ZP_INDEX)) {
	$theme = prepareIndexPage();
}

//$_zp_script_timer['page'] = microtime();
if (!isset($theme)) {
	$theme = setupTheme();
}
//$_zp_script_timer['theme setup'] = microtime();
$custom = SERVERPATH.'/'.THEMEFOLDER.'/'.internalToFilesystem($theme).'/functions.php';
if (file_exists($custom)) {
	require_once($custom);
} else {
	$custom = false;
}

if (DEBUG_PLUGINS) {
	debugLog('Loading the "theme" plugins.');
}
$_zp_loaded_plugins = array();
foreach (getEnabledPlugins() as $extension=>$loadtype) {
	if ($loadtype&THEME_PLUGIN) {
		if (DEBUG_PLUGINS) {
			list($usec, $sec) = explode(" ", microtime());
			$start = (float)$usec + (float)$sec;
		}
		require_once(getPlugin($extension.'.php'));
		if (DEBUG_PLUGINS) {
				list($usec, $sec) = explode(" ", microtime());
				$end = (float)$usec + (float)$sec;
				debugLog(sprintf('    '.$extension.'('.($priority & PLUGIN_PRIORITY).')=>%.4fs',$end-$start));
			}
//		$_zp_script_timer['load '.$extension] = microtime();
	}
	$_zp_loaded_plugins[] = $extension;
}
if ($zp_request) {
	$_zp_obj = zp_apply_filter('load_theme_script',$_zp_obj);
}
//$_zp_script_timer['theme scripts'] = microtime();
if ($zp_request && file_exists(SERVERPATH . "/" . internalToFilesystem($_zp_obj))) {
	if (checkAccess($hint, $show)) { // ok to view
		setThemeColumns();
	} else {
		if (is_object($_zp_HTML_cache)) {	//	don't cache the logon page or you can never see the real one
			$_zp_HTML_cache->abortHTMLCache();
		}
		$_zp_gallery_page = 'password.php';
		$_zp_obj = SERVERPATH.'/'.THEMEFOLDER.'/'.$theme.'/password.php';
		if (!file_exists(internalToFilesystem($_zp_obj))) {
			$_zp_obj = SERVERPATH.'/'.ZENFOLDER.'/password.php';
		}
	}
	// Include the appropriate page for the requested object, and a 200 OK header.
	header ('Content-Type: text/html; charset=' . LOCAL_CHARSET);
	header("HTTP/1.0 200 OK");
	header("Status: 200 OK");
	header('Last-Modified: ' . ZP_LAST_MODIFIED);
	zp_apply_filter('theme_headers');
	include(internalToFilesystem($_zp_obj));
} else {
	// If the requested object does not exist, issue a 404 and redirect to the theme's
	// 404.php page, or a 404.php in the zp-core folder.
	if (is_object($_zp_HTML_cache)) {
		$_zp_HTML_cache->abortHTMLCache();
	}
	list($album, $image) = rewrite_get_album_image('album','image');
	debug404($album, $image, $theme);
	$_zp_gallery_page = '404.php';
	$errpage = THEMEFOLDER.'/'.internalToFilesystem($theme).'/404.php';
	header ('Content-Type: text/html; charset=' . LOCAL_CHARSET);
	header("HTTP/1.0 404 Not Found");
	header("Status: 404 Not Found");
	zp_apply_filter('theme_headers');
	if (file_exists(SERVERPATH . "/" . $errpage)) {
		if ($custom) require_once($custom);
		include($errpage);
	} else {
		include(ZENFOLDER. '/404.php');
	}
}
//$_zp_script_timer['theme script load'] = microtime();
exposeZenPhotoInformations($_zp_obj, $_zp_loaded_plugins, $theme);
//$_zp_script_timer['expose information'] = microtime();
db_close();	// close the database as we are done
echo "\n";
list($usec, $sec) = explode(' ', array_shift($_zp_script_timer));
$first = $last = (float)$usec + (float)$sec;
$_zp_script_timer['end'] = microtime();
foreach ($_zp_script_timer as $step=>$time) {
	list($usec, $sec) = explode(" ", $time);
	$cur = (float)$usec + (float)$sec;
	printf("<!-- ".gettext('Zenphoto script processing %1$s:%2$.4f seconds')." -->\n",$step,$cur-$last);
	$last = $cur;
}
if (count($_zp_script_timer)>1) printf("<!-- ".gettext('Zenphoto script processing total:%.4f seconds')." -->\n",$last-$first);
if (is_object($_zp_HTML_cache)) {
	$_zp_HTML_cache->endHTMLCache();
}

?>