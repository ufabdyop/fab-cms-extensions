<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link type="text/css" href="/lib/jqueryui/css/ui-lightness/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="/lib/jqueryui/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/lib/jqueryui/js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript">
	$(document).ready( function () {
				window.parent.file_uploaded(<?=( $success ? true : false )?>);
			});
</script>
</head>
<body>
<?if ($success) {?>
<p>Upload Success</p>
<?} else { ?>
<p>Upload Error</p>
<p><?=$error?></p>
<?}  ?>
</body>
</html>
