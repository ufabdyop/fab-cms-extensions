<?ob_start();?>
<?
$this->load->model('equipment_model', 'equipment');
foreach($subcategories as $subcat => $equipment) {
	$buffer = "<div class=\"equipment seven columns\">";
	if ($subcat != 'none') {
		$buffer .= "<h3>$subcat</h3> \n";
	}
	foreach($equipment as $eq) {
		$url = site_url('equipment/show_eq/' . urlencode($eq));
		$name = $eq;
		$eq_obj = $this->equipment->load_by_name($name);
		$buffer .= '<ul class="equipment_listing">     ' . "\n";
		$buffer .= "<li><a href=\"$url\">$name</a> " . (isset($eq_obj->summary) ? $eq_obj->summary : '') . "</li>\n";     
		$buffer .= "</ul>\n";
	}
	$buffer .= "</div>";
	echo $buffer;
}
echo "<div class=\"sixteen columns\">\n";
$category_html = (isset($category_html) ? $category_html : "");
echo $category_html;
$admin_html = (isset($admin_html) ? $admin_html : "");
echo $admin_html;
echo "</div>\n";
?>


<?
$content = ob_get_contents();
ob_end_clean();
$this->load->view($this->config->item('main_view'), array('title' => $category, 'content' => $content, 
								'breadcrumb' => $breadcrumb,
								'custom_js' => array('/lib/tinymce/jscripts/tiny_mce/tiny_mce.js'),
								));
?>
