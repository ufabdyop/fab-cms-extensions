<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php zp_apply_filter('theme_head'); ?>
		<title><?php echo getBareGalleryTitle(); ?></title>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo pathurlencode($zenCSS); ?>" type="text/css" />
	</head>
	<body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<div id="main">
			<div id="gallerytitle">
				<h2>
					<?php printHomeLink('', ' | '); ?>
					<a href="<?php echo html_encode(getGalleryIndexURL()); ?>" title="<?php echo gettext('Gallery Index'); ?>"><?php echo gettext('Gallery Index'); ?></a> |
					<em><?php echo gettext('Register') ?></em>
				</h2>
			</div>
			<h2><?php echo gettext('User Registration') ?></h2>
			<?php printRegistrationForm(); ?>
		</div>
		<?php if (function_exists('printLanguageSelector')) {
			printLanguageSelector();
		} ?>
		<div id="credit">
			<?php printZenphotoLink(); ?>
		</div>
		<?php
		printAdminToolbox();
		zp_apply_filter('theme_body_close');
		?>
	</body>
</html>
