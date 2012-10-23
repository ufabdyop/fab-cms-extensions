<?ob_start();?>
<h3>Fabrication</h3>
<p class="message">View our plans for the <a href="<?=site_url('equipment/move_status')?>">equipment move schedule</a>.</p> 
<table width="100%" border="1" align="center" class="equipment_listing_table pretty_table">
	<tr><th>Category</th><th>Owner</th></tr>
	<?foreach($categories as $cat) {?>
		<tr><td><a href="<?=site_url('equipment/list_by_category'). '/' . urlencode($cat[0])?>"><?=$cat[0]?></a></td><td><a href="<?=$cat[1]['url']?>"><?=$cat[1]['name']?></a></td></tr>
	<?}?>
</table>
<script lang="javascript">
	function show_dialg() {
		var contact_dialog = '<div>Please contact York Smith at york.r.smith -at- gmail.com.</div>'; 
		jQuery(contact_dialog).dialog();
		return false;
	}
</script>
<h3>Micron Microscopy Core</h3>
<table width="100%" border="1" align="center" class="equipment_listing_table pretty_table">
	<tr><th>Category</th><th>Owner</th></tr>
	<?foreach($microscopy as $tool) {
		if ($tool == 'SEM, Hitachi S-4800') {
		?>
		<tr><td><a href="<?=site_url('equipment/show_eq'). '/' . urlencode($tool)?>"><?=$tool?></a></td><td><a href="#" onclick="show_dialg(); return false;">York Smith</a></td></tr>
	<?
		} else if ($tool == 'dbFIB, FEI Helios NanoLab 650') {
	?>
		<tr><td><a href="<?=site_url('equipment/show_eq'). '/' . urlencode($tool)?>"><?=$tool?></a></td><td><a href="/index/about-us/RandyPolson">Randy Polson</a></td></tr>
	<?
		} else {
	?>
		<tr><td><a href="<?=site_url('equipment/show_eq'). '/' . urlencode($tool)?>"><?=$tool?></a></td><td><a href="/BrianvanDevener">Brian van Devener</a></td></tr>
		<?}?>
	<?}?>
</table>
<h3>Affiliated Labs</h3>
<p>Didn&#039;t find the tools or instruments you were looking for?  You might find what you need with some of our <a href="/index/about-us/affiliatedlabs">affiliated labs</a> on campus.</p>
<div id="monalisa_panda_contact">
</div>
<?
$content = ob_get_contents();
ob_end_clean();
$breadcrumb = breadcrumb();
$view = $this->config->item('main_view');
$this->load->view($view, array('title' => 'Equipment Listing', 'content' => $content, 'breadcrumb' => $breadcrumb,
				'custom_css' => array('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css')));
?>

