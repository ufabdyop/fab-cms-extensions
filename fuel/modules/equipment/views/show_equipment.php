<?
if (!isset($equipment)) {
	$content = "<p>There is currently no information available for this tool.  Please <a href=\"mailto:nanofab-support@coe.utah.edu\">contact Nanofab staff</a> for more information.</p>";
	$this->load->view($this->config->item('main_view'), array('title' => 'Equipment Not Found', 
					'content_class' => 'equipment',
					'content' => $content
					));
	exit();
}
$content = $equipment->html;
if (!$content) {
	$content = "<p>There is currently no information available for this tool.  Please <a href=\"mailto:nanofab-support@coe.utah.edu\">contact Nanofab staff</a> for more information.</p>";
}
$marker_style = "";
$box_style = 'background: url(' . site_url($equipment->map) . ') no-repeat scroll left top #FFFFFF; height: ' . $equipment->map_height . 'px; position: relative; width: ' . $equipment->map_width . 'px; display: none;';
if ($equipment->location) {
	list($x, $y) = explode(',', $equipment->location);
	$marker_style = ' width: 30px; height: 30px; position: absolute; left: ' . ($x - 25) . 'px; top: ' . ($y - 30) . 'px; ';
} 

/*if ($marker_style) {
	$content .= '
	<h3>Location</h3>
	<a href="#" onclick="javascript:jQuery(\'#box\').slideToggle(500); this.text = (this.text == \'Hide Map\' ? \'Show Map\' : \'Hide Map\'); return false;" >Show Map</a>
	<button onclick="javascript:jQuery(\'#box\').slideToggle(500); this.value = (this.value == \'Hide Map\' ? \'Show Map\' : \'Hide Map\'); return false;" >Show Map</button>
	<div id="box" style="' . $box_style . '"><div id="marker" style="' . $marker_style . '">&nbsp;</div></div>
	';
}*/
if ($marker_style) {
	$content .= '
	<h3>Location</h3>
	<input type="button" id="location" value="Show Map" onclick="javascript:jQuery(\'#box\').slideToggle(500); x=document.getElementById(\'location\');x.value = (x.value == \'Show Map\' ? \'Hide Map\' : \'Show Map\');" ></input>
	<div id="box" style="' . $box_style . '"><div id="marker" style="' . $marker_style . '">&nbsp;</div></div>
	';
}
if (isset($folders)) {
	foreach ($folders as $folder => $contents) {
		if ($contents) {	
			if ($folder != 'public') {
				$content .= "<h3>" . ucwords($folder) . " Files</h3>\n";
			} else {
				$content .= "<h3>Files</h3>\n";
			}
			foreach ($contents as $section) {
				$content .= "<h4 class=\"equipment_file\">{$section['category']}:</h4>\n";
				$file_count = 0;
				foreach ($section['files'] as $file_label => $file_name) {
					$file_count++ ;
					$row_class = ($file_count % 2 == 1) ? " new_row " : "";
					$file_icon = pathinfo($file_name, PATHINFO_EXTENSION);
					if (! in_array( $file_icon , array('pdf', 'doc', 'docx', 'zip', 'exe', 'jpg', 'png', 'txt'))) {
						$file_icon = 'misc';
					}
					$content .= "<a class=\"tool_file $file_icon $row_class\" href=\"" . site_url('equipment/download_file/' . urlencode($equipment->name) . '/' . $folder . '/' . urlencode($section['category']) . '/' . urlencode($file_label) . '/' . urlencode($file_name)) . "\">$file_label</a>\n";
				}
			}
		}
	}	
}
$content.=$equipment->problem_html;
if ($equipment->number_reservations>0)
	$content .= "<h3>Reservations Calendar</h3>\n" 
		. "<a href=\"" . site_url("equipment/reservations/" . urlencode($equipment->name)) . "/1\">Download iCal for Reservation Calendar</a> "
			."<script type=\"text/javascript\">function hide_cal(){document.getElementById(\"iframe\").innerHTML=\"<button onclick='show_cal();'>Show Calendar</button>\";};function show_cal(){document.getElementById(\"iframe\").innerHTML=\"<button onclick='hide_cal();'>Hide Calendar</button><iframe src='" . site_url("equipment/reservations/" . urlencode($equipment->name)) . "/2' width=100% height=100%\></iframe>\";}</script><p id=\"iframe\"><button type=\"button\" onclick='show_cal();'>Show Calendar</button></p>";
if (!is_logged_in() ) {
	$content .= "<h3>Log In</h3>\n";
	$content .= "<p><a href=\"" . site_url('fuel/login') . "/" . uri_safe_encode(uri_string()) . "\">Log in for more information</a>.</p>";
}
if (has_role('staff')) {
	$content .= "<h3>Administration</h3>\n";
	$content .= "<p><a class=\"edit_link\" href=\"http://www.nanofab.utah.edu/tool-move-checklist?mact=ToolMove,m2,DisplayChecklist&item=".urlencode($equipment->name)."\"> Tool Move Checklist </a>";
	$content .= "<a class=\"edit_link\" href=\"" . site_url('equipment/edit/' . urlencode($equipment->name) ) . "\">Edit Tool Info</a></p>";
}
$this->load->view($this->config->item('main_view'), array('title' =>  $equipment->name, 
				'content_class' => 'equipment',
				'content' => $content,
                                'custom_css' => array(
                                    css_path('equipment.css', 'equipment')
                                    ),
				'breadcrumb' => $equipment->breadcrumb()
				));
?>

