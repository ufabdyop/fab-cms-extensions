<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* TinyMCE Inclusion Class
*
* @package        CodeIgniter
* @subpackage    Libraries
* @category    WYSIWUG
* @author        WackyWebs.net - Tom Glover
* @link        http://codeigniter.com/user_guide/libraries/zip.html
*/

class Tinymce {
/*
* Create Head Code - this converts $mode value to TinyMCE editors
* $Mode is the mode TinyMCE runs in - Please view TinyMCE manual for more detail
* $Theme is this style of running, eg advance or basic, defult advance
* $ToolLoc is the vertical location of the toolbar, Defult = 'top'
* $ToolAligh is the Horizontal Location of the toolbar, DeFult = 'left'
* $Resizeabe - Can the Client resize it on there web page.
* use in controllers like so:
* $data ['head'] = $this->tinymce->createhead('mode','theme','toolbar loc','toolbar align','resizable')
*/
function Createinitscript($Mode = 'textareas', $Theme = 'advanced', $ToolLoc = 'Top', $ToolAlign = 'left', $Resizable = 'false')
{
$baseJs = '/lib/tinymce/jscripts';
return <<<EOF

<script>
$(document).ready( function() {
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
</script>

EOF;
}
/*
* Create Text Box
* Does not have to use variable in creation as can just return textarea, without
* $FullCode - True = Outputs full text area codein form tag! False = just the Tag no
* Form Wrap - Defult = False
* $Methord - Post or Get - Required if FC=True - String
* $Action - Controller to Call on Submission - Required if FC=True - String - Can use
* URL Helper
* $data ['head'] = $this->tinymce->createhead('Fullcode','Methord','Action')
*/
function Textarea($FullCode = FALSE, $Methord = "POST", $Action = '')

{
if ($FullCode === TRUE){
$mce = "<form action=\"$Action\" method=\"$Methord\"></form>";
$mce .= "<textarea name=\"TinyMCE\" cols=\"30\" rows=\"50\"></textarea>";
$mce .= "<input name=\"Submit\" type=\"button\" value=\"Submit\">";
$mce .= "</form>";
return $mce ;// Outputs to view file - String
}else{
$mce = "<textarea name=\"TinyMCE\" cols=\"30\" rows=\"50\"></textarea>";
return $mce ;// Outputs to view file - String
}
}
}

?> 
