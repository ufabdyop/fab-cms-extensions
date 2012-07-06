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
<?php $this->load->view('_blocks/header')?>
	
	<div id="main_inner" class="row sixteen columns">
            <?php
                if (!isset($breadcrumb)) {
                    $breadcrumb = fuel_nav(array('render_type' => 'breadcrumb', 'active_class' => 'active', 'container_tag_id' => 'breadcrumb', 'delimiter' => ' : ', 'order' => 'desc', 'home_link' => 'Utah Nanofab', 'display_current' => true));            
                }
                echo $breadcrumb;
		if (isset($title)) {
			echo "<h2 class=\"title\">$title</h2>\n";
		}
		echo $error_html . $message_html;
                echo fuel_var('body', ''); 
                if (isset($content)) {
                        echo $content;
                }
            ?>
	<?php
//This little block of code lets you pick a color an manipulate some elements on the page
/*
            <div id="swatch">
                <script language="javascript">
                    var targets = '#login_link, .message';
                    var attribute = 'background-color';
                    function show_colors(id) {
                        id = '#' + id.substr(7);
                        
                        $(targets).css(attribute, id);
                        
                    }
                </script>
<div id="swatch_cc0000" style="width: 50px; height: 50px;  background-color: #cc0000;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_77797c" style="width: 50px; height: 50px;  background-color: #77797c;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_bb8d49" style="width: 50px; height: 50px;  background-color: #bb8d49;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>

<div id="swatch_990000" style="width: 50px; height: 50px;  background-color: #990000;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_965b50" style="width: 50px; height: 50px;  background-color: #965b50;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_c0a89e" style="width: 50px; height: 50px;  background-color: #c0a89e;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_8f5917" style="width: 50px; height: 50px;  background-color: #8f5917;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_ceac75" style="width: 50px; height: 50px;  background-color: #ceac75;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_dac092" style="width: 50px; height: 50px;  background-color: #dac092;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_60663e" style="width: 50px; height: 50px;  background-color: #60663e;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_70764d" style="width: 50px; height: 50px;  background-color: #70764d;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_adb091" style="width: 50px; height: 50px;  background-color: #adb091;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_556170" style="width: 50px; height: 50px;  background-color: #556170;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_87909d" style="width: 50px; height: 50px;  background-color: #87909d;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_aebdc5" style="width: 50px; height: 50px;  background-color: #aebdc5;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_3b5664" style="width: 50px; height: 50px;  background-color: #3b5664;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_648587" style="width: 50px; height: 50px;  background-color: #648587;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>
<div id="swatch_8abfbe" style="width: 50px; height: 50px;  background-color: #8abfbe;float: left;"
        onclick="show_colors(this.id)">&nbsp;</div>

            </div>
*/
?>
	</div>
	
<?php $this->load->view('_blocks/footer')?>
