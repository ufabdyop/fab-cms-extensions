<?php

// force UTF-8 Ø

if (!defined('WEBPATH')) die();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php echo getBareImageTitle();?> | <?php echo getBareAlbumTitle();?> | <?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
	<?php if(zp_has_filter('theme_head','colorbox_css')) { ?>
		<script type="text/javascript">
			// <!-- <![CDATA[
			$(document).ready(function(){
				$(".colorbox").colorbox({
					inline:true,
					href:"#imagemetadata",
					close: '<?php echo gettext("close"); ?>'
					});
				$("a.thickbox").colorbox({
					maxWidth:"98%",
					maxHeight:"98%",
					close: '<?php echo gettext("close"); ?>'
				});
			});
			// ]]> -->
		</script>
	<?php } ?>
		<?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
</head>
<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">
<div id="header">
		<h1><?php echo getGalleryTitle();?></h1>
	<div class="imgnav">
			<?php if (hasPrevImage()) { ?>
			<div class="imgprevious"><a href="<?php echo html_encode(getPrevImageURL());?>" title="<?php echo gettext("Previous Image"); ?>">&laquo; <?php echo gettext("prev"); ?></a></div>
			<?php } if (hasNextImage()) { ?>
			<div class="imgnext"><a href="<?php echo html_encode(getNextImageURL());?>" title="<?php echo gettext("Next Image"); ?>"><?php echo gettext("next"); ?> &raquo;</a></div>
			<?php } ?>
		</div>
	</div>

<div id="content">

	<div id="breadcrumb">
	<h2><a href="<?php echo getGalleryIndexURL(false);?>" title="<?php gettext('Index'); ?>"><?php echo gettext("Index"); ?></a> &raquo; <?php printParentBreadcrumb(""," &raquo; "," &raquo; "); printAlbumBreadcrumb("  ", " &raquo; "); ?>
			 <strong><?php printImageTitle(true); ?></strong> (<?php echo imageNumber()."/".getNumImages(); ?>)
			</h2>
		</div>
	<div id="content-left">

	<!-- The Image -->
 <?php
 //
 if (function_exists('printjCarouselThumbNav')) {
	printjCarouselThumbNav(6,50,50,50,50,FALSE);
 }
 else {
	if (function_exists("printPagedThumbsNav")) {
		printPagedThumbsNav(6, FALSE, gettext('prev thumbs'), gettext('next thumbs'), 40, 40);
	}
 }

 ?>

	<div id="image">
		<?php if(getOption("Use_thickbox") && !isImageVideo()) {
			$boxclass = " class=\"thickbox\"";
			$tburl = getUnprotectedImageURL();
		} else {
			$boxclass = "";
			$tburl = getFullImageURL();
		}
		if (!empty($tburl)) {
			?>
			<a href="<?php echo html_encode($tburl); ?>"<?php echo $boxclass; ?> title="<?php echo getBareImageTitle();?>">
			<?php
		}
		printCustomSizedImageMaxSpace(getBareImageTitle(),580,580); ?>
		<?php
		if (!empty($tburl)) {
			?>
			</a>
			<?php
		}
		?>
	</div>
	<div id="narrow">
		<div id="imagedesc"><?php printImageDesc(true); ?></div>
		 <?php if(getTags()) { echo gettext('<strong>Tags:</strong>'); } printTags('links', '', 'taglist', ', '); ?>
		<br style="clear:both;" /><br />
		<?php if (function_exists('printSlideShowLink')) {
			echo '<span id="slideshowlink">';
			printSlideShowLink(gettext('View Slideshow'));
			echo '</span>';
		}
		?>

		<?php
		if (getImageMetaData()) {
			echo printImageMetadata(NULL, 'colorbox');
		}
		?>

		<br style="clear:both" />
		<?php if (function_exists('printRating')) printRating(); ?>
		<?php if (function_exists('printGoogleMap')) printGoogleMap(); ?>
		<?php if (function_exists('printShutterfly')) printShutterfly(); ?>

</div>
		<?php if (function_exists('printCommentForm')) {
				printCommentForm();
		 } ?>

</div><!-- content-left -->

<div id="sidebar">
<?php include("sidebar.php"); ?>
</div>

	<div id="footer">
	<?php include("footer.php"); ?>
	</div>


	</div><!-- content -->

</div><!-- main -->
<?php
printAdminToolbox();
zp_apply_filter('theme_body_close');
?>
</body>
</html>