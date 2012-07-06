<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{#advanced_dlg.image_title}</title>
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script type="text/javascript" src="../../utils/mctabs.js"></script>
	<script type="text/javascript" src="../../utils/form_utils.js"></script>
	<script type="text/javascript" src="js/image.js"></script>
</head>
<body id="image" style="display:none"onload="ImageDialog.getImageData();">
<?php 
$SafeFile = $_FILES['ufile']['name']; 
$SafeFile = str_replace("#", "No.", $SafeFile); 
$SafeFile = str_replace("$", "Dollar", $SafeFile); 
$SafeFile = str_replace("%", "Percent", $SafeFile); 
$SafeFile = str_replace("^", "", $SafeFile); 
$SafeFile = str_replace("&", "and", $SafeFile); 
$SafeFile = str_replace("*", "", $SafeFile); 
$SafeFile = str_replace("?", "", $SafeFile); 
$uploaddir = "../../../../../../tmp/img/"; 
$path = $uploaddir.$SafeFile; 
$type_array=array("image/gif","image/jpeg","image/pjpeg","image/png");
if($ufile != none){
	if (in_array($_FILES['ufile']['type'],$type_array)){
    if(copy($_FILES['ufile']['tmp_name'], $path)){
		echo "Successfully uploaded";
		
    } else { 
		echo "<h2 style='color:red'>File could not be uploaded</h2>"."<meta http-equiv='refresh' content='2;url=javascript:history.go(-1)'>\n";
    } 
	}
	else 
		echo "<h2 style='color:red'>File type is not supported</h2>"."<meta http-equiv='refresh' content='2;url=javascript:history.go(-1)'>\n";
} 
?>
<form onsubmit="ImageDialog.update();return false;" action="#">
	<div class="tabs">
		<ul>
			<li id="general_tab" class="current"><span><a href="javascript:mcTabs.displayTab('general_tab','general_panel');" onmousedown="return false;">{#advanced_dlg.image_title}</a></span></li>
		</ul>
	</div>

	<div class="panel_wrapper">
		<div id="general_panel" class="panel current">
			<table border="0" cellpadding="4" cellspacing="0">
				<tr>
					<td class="nowrap"><label for="src">{#advanced_dlg.image_src}</label></td>
					<td><table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><input id="src" name="src" type="text" class="mceFocus" value="http://www.nanofab.utah.edu/tmp/img/<? echo $_FILES['ufile']['name'];?>" style="width: 200px" onchange="ImageDialog.getImageData();" /></td>
							<td><a href="upload.php"><img src="img/icon.gif"></img></a></td>							
							<td id="srcbrowsercontainer">&nbsp;</td>
						</tr>
					</table></td>
				</tr>
				<tr>
					<td><label for="image_list">{#advanced_dlg.image_list}</label></td>
					<td><select id="image_list" name="image_list" onchange="document.getElementById('src').value=this.options[this.selectedIndex].value;document.getElementById('alt').value=this.options[this.selectedIndex].text;"></select></td>
				</tr>
				<tr>
					<td class="nowrap"><label for="alt">{#advanced_dlg.image_alt}</label></td>
					<td><input id="alt" name="alt" type="text" value="" style="width: 200px" /></td>
				</tr>
				<tr>
					<td class="nowrap"><label for="align">{#advanced_dlg.image_align}</label></td>
					<td><select id="align" name="align" onchange="ImageDialog.updateStyle();">
						<option value="">{#not_set}</option>
						<option value="baseline">{#advanced_dlg.image_align_baseline}</option>
						<option value="top">{#advanced_dlg.image_align_top}</option>
						<option value="middle">{#advanced_dlg.image_align_middle}</option>
						<option value="bottom">{#advanced_dlg.image_align_bottom}</option>
						<option value="text-top">{#advanced_dlg.image_align_texttop}</option>
						<option value="text-bottom">{#advanced_dlg.image_align_textbottom}</option>
						<option value="left">{#advanced_dlg.image_align_left}</option>
						<option value="right">{#advanced_dlg.image_align_right}</option>
					</select></td>
				</tr>
				<tr>
					<td class="nowrap"><label for="width">{#advanced_dlg.image_dimensions}</label></td>
					<td><input id="width" name="width" type="text" value="" size="3" maxlength="5" />
					 x 
					<input id="height" name="height" type="text" value="" size="3" maxlength="5" /></td>
				</tr>
				<tr>
				<td class="nowrap"><label for="border">{#advanced_dlg.image_border}</label></td>
				<td><input id="border" name="border" type="text" value="" size="3" maxlength="3" onchange="ImageDialog.updateStyle();" /></td>
				</tr>
				<tr>
					<td class="nowrap"><label for="vspace">{#advanced_dlg.image_vspace}</label></td>
					<td><input id="vspace" name="vspace" type="text" value="" size="3" maxlength="3" onchange="ImageDialog.updateStyle();" /></td>
				</tr>
				<tr>
					<td class="nowrap"><label for="hspace">{#advanced_dlg.image_hspace}</label></td>
					<td><input id="hspace" name="hspace" type="text" value="" size="3" maxlength="3" onchange="ImageDialog.updateStyle();" /></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="mceActionPanel">
		<input type="submit" id="insert" name="insert" value="{#insert}" />
		<input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
	</div>
</form>
</body>
</html>
