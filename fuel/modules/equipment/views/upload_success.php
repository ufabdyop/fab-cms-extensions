<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link type="text/css" href="/lib/jqueryui/css/ui-lightness/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="/lib/jqueryui/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/lib/jqueryui/js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript">
	function closeme() {
		window.parent.jQuery('#' + '<?=$form_id?>' ).dialog('close');
	}
</script>
</head>
<body bgcolor="#ffffff" text="#000000">
<div id="uploadform" title="Upload">
	<form action="" method="post" enctype="multipart/form-data" > 
		<input type="file" name="file" /> 
		<input type="submit" name="submit" value="Submit" /> 
	</form>
</div>
</body>
</html>
