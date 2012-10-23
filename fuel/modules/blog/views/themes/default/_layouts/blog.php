<?php $this->load->view('_blocks/header')?>
	
	<div id="main_inner" class="eleven columns">
		<?php echo fuel_var('body', ''); ?>
	</div>
	<div id="right" class="three columns">
		<?php echo $this->fuel_blog->sidemenu(array('search', 'authors', 'categories', 'links', 'archives'))?>
	</div>

	
	<div class="clear"></div>
	
<?php $this->load->view('_blocks/footer')?>
