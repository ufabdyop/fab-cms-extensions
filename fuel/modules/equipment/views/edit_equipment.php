<?
ob_start();
?>
<!--
  Created using http://jsbin.com/
  Source can be edited via http://jsbin.com/akiwo/edit
-->
<?
$eq = $equipment;
$display_on_web = ($eq->hidden  ? "" : " checked");
?>
<meta charset=utf-8 />
<title>Tool Info Collection</title>
<!--[if IE]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?$head = ob_get_contents();
ob_end_clean();
ob_start();
?>
<form name="tools" method="post" action="#" class="equipment">
<textarea name="html" style="height: 800px; width: 650px;">
<?=$eq->html?>
</textarea>
<?
if (isset($maps)) {
	?>
	<label>Map</label>
	<select name="map_id" onchange="document.getElementById('box').style.background-image = 'none'">
		<?foreach($maps as $m) {
			$checked = ( $eq->map_id == $m['id'] ? " selected" : "" );
			echo "\t<option value=\"{$m['id']}\" $checked>{$m['description']}</option>\n";
		}?>
	</select><br/>
	<?
}
?>
<table>
	<tr>
		<td>
			Location (click map)
		</td>
		<td>
			<input type="text" name="location" id="location" value="<?=(isset($eq->x) ? trim($eq->x) . ", " . trim($eq->y) : "")?>"></input>
		</td>
	<td></td>
	</tr>
</table>
  <div id="box" style="position: relative; width: <?=$eq->map_width?>px; height: <?=$eq->map_height?>px;  background-image: url(<?=$eq->map?>)"><div id="marker" style="left: <?=($eq->x - 25)?>px; top: <?=($eq->y - 30)?>px;"></div></div>
  <p id="position"></p>
<table>
	<tr>
		<td>
Tool Summary (shown on category page):
		</td>
		<td>
<textarea id="summary" name="summary"><?=$eq->summary?></textarea>
		</td>
	<td></td>
	</tr>
	<tr>
		<td>
Billing Rate
		</td>
		<td>
<input type="text" name="billing_rate" value="<?=$eq->billing_rate?>"></input>
		</td>
	<td></td>
	</tr>
	<tr>
		<td>
Display On Website
		</td>
		<td>
<input type="checkbox" name="display_on_web"<?=$display_on_web?>></input>
		</td>
	<td></td>
	</tr>
</table>
	<h2>Files</h2>
	<?
$this->load->view('equipment_file_table', array('equipment' => $eq));
?>
	<h3>Add file</h3>
<div id="upload_form">
	<form name="uploader">
	<table>
		<tr>
			<th>Access Level</th>
			<th>Category</th>
			<th>Link Label</th>
			<th>Upload</th>
		</tr>
		<tr>
		    <td>
			<select name="access" id="access">
			    <option value="">Select Access Level</option>
			    <option value="member">Members Only</option>
			    <option value="staff">Staff Only</option>
			    <option value="public">Public Access</option>
			</select>
			</td>
		    <td><input type="text" name="category" value="" id="category" /></td>
		    <td><input type="text" name="file_label" value="" id="file_label" /></td>
		    <td>
				<a class="uploader" href="<?=site_url('uploader/form')?>" onclick="return new_upload();">Upload File</a>
			</td>
		</tr>
		<tr class="messages">
			<td colspan="4">
			<div id="floating_message_box" style="display: none;">&nbsp;</div>
			<div id="upload-progbar" style="border: 1px solid #0f9; display: none;">&nbsp;</div></td>
		</tr>
	</table>
	</form>
</div>
<div id="uploader_div">
<iframe style="display: none;" src="<?=site_url('uploader/form')?>" name="uploader" id="uploader_frame" ></iframe>
</div>
<script>
 // PHP-compatible urlencode() for Javascript
function urlencode(s) {
	s = encodeURIComponent(s);
	return s.replace(/~/g,'%7E').replace(/%20/g,'+');
}
function open_upload_form(equipment, access, category, file_label ) {
	$('#uploader_frame').attr('src', '<?=site_url('equipment/upload_form')?>/' + equipment + '/' + access + '/' + category + '/' + file_label);
	$('#uploader_frame').dialog({title: 'Upload File'});
	return false;
}
function new_upload() {
	var file_label = '';
	var category = '';
	var access_level = $('#access').val();

	if (access_level == '') {
		alert('Please choose access level');
		return false;
	}

	if ( $('#category').val() == '' ) {
		alert('Please enter a category');
		return false;
	}

	if ( $('#file_label').val() == '' ) {
		alert('Please enter a file label');
		return false;
	}

	file_label = $('#file_label').val();
	category = $('#category').val();
	file_label = urlencode(file_label);
	category  = urlencode(category );
	access_level = urlencode(access_level);
	$('#uploader_frame').attr('src', '<?=site_url('equipment/upload_form/' . urlencode($eq->name))?>/' +access_level + '/' + category + '/' + file_label);
	$('#uploader_frame').dialog({title: 'Upload File'});
	return false;
}
function file_uploaded(success) {
	if (success) {
		$('#files').load('<?=site_url('equipment/get_equipment_file_table/'. urlencode($eq->name))?>');
		$('#uploader_frame').animate( {opacity: 0}, 3000, 
			function() {
				$('#uploader_frame').dialog('close');
				$('#uploader_frame').css('opacity', 1);
			}	
		);
	}
}
$(document).ready(function() {
  $('#box').click(function(e) {
    var offset = $(this).offset();
	$('#marker').css('display', 'block');
	$('#marker').css('left', (e.pageX - offset.left - 25));
	$('#marker').css('top', (e.pageY - offset.top - 30));
    $('#location').attr('value', ((e.pageX - offset.left) + ", " + Math.round(e.pageY - offset.top)));
  });
});

$(document).ready(function() {
	tinyMCE.init({
			mode : "textareas",
			 theme : "advanced",
			plugins : "emotions,spellchecker,advhr,insertdatetime,preview", 
		//relative_urls : true,
		convert_urls : false,
		document_base_url : "http://www.nanofab.utah.edu/",
					
			// Theme options - button# indicated the row# only
			theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect",
			theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,|,code,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "insertdate,inserttime,|,spellchecker,advhr,,removeformat,|,sub,sup,|,charmap",      
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true

	});
});
var temp_sval;

function save_changes() {
	var htmldata = tinyMCE.get('html').getContent();
	$('#html').val( htmldata );
	var summarydata = tinyMCE.get('summary').getContent();
	$('#summary').val( summarydata ); //should remove enclosing p tag from tinymce
	var postdata = (JSON.stringify($(':input').serializeArray() ));
	jQuery.ajax({
				url: '<?=site_url('equipment/save_changes/' . urlencode($eq->name))?>', data: { inputs: postdata },
				type: 'post',
				success:
					function() {
						alert('Changes saved');
					},
				error: 
					function() {
						alert('Error saving changes.');
					}
			});
}
</script>
<input type="submit" value="Submit" onclick="javascript:save_changes();"></input>
</form>
<br/>
<a href="<?=site_url('equipment/show_eq/' . $eq->name)?>">View Page</a>
<p id="position"></p>

<?$body = ob_get_contents();
ob_end_clean();
$this->load->view($this->config->item('main_view'), array('custom_head' => array($head), 
								'breadcrumb' => $eq->breadcrumb(true), 
								'content' => $body, 
								'custom_js' => array(js_path('valums-uploader/client/fileuploader.js', 'equipment'),
                                                                                    site_url('assets/js/tinymce/jscripts/tiny_mce/tiny_mce.js')),
								'custom_css' => array(
                                                                    css_path('valums-uploader/client/fileuploader.css', 'equipment'),
                                                                    css_path('equipment.css', 'equipment'),
									'http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css'
                                                                    ),
								'title' => 'Edit ' . $eq->name, 
								'content_class' => 'equipment' ));
?>



