<? if (function_exists("is_logged_in")) { $username = get_username(); } ?>
<?
//this function is used to denote a category on the nav is the currently selected category
?>
<?$error_html = "";?>
<?if (isset($errors) && $errors) {
	$error_html = "<br/><ul id=\"errors\">\n";
	foreach($errors as $e) {
		$error_html .= "<li>$e</li>\n";
	}
	$error_html .= "</ul>\n";
}
?>
<?$message_html = "";?>
<?if (isset($messages) && $messages) {
	$message_html = "<br/><ul id=\"messages\">\n";
	foreach($messages as $e) {
		$message_html .= "<li>$e</li>\n";
	}
	$message_html .= "</ul>\n";
}
?>
<!-- begin #content -->

<div id="content"<?=isset($content_class) ? ' class="' . $content_class . '"' : ''?>>
			<?if (isset($breadcrumb)) {?><div id="breadcrumbs"><?=$breadcrumb?></div><?}?>
			<?if (isset($title)) {?><h2><?=$title?></h2><?}?>
			<?echo $error_html . "\n" . $message_html; ?>
			<?=(isset($content) ? $content : '')?>
			<?
			if (isset($content_views)) {
				foreach($content_views as $view) {
					$this->load->view($view);
				}
			}
			?>
<!-- end #content --></div>

