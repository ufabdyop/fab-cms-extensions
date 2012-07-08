<?php
require_once(FUEL_PATH.'/libraries/Fuel_base_controller.php');

class map extends Fuel_base_controller {

	function __construct() {
		parent::__construct(FALSE);	
	}

	function path($id) {
		$this->load->config('equipment_config');
		$this->load->model('maps_model', 'maps');
		$maps = $this->maps->get_by_id($id);
		echo $this->config->item('map_path') . '/' . $maps['filename'];
	}

}


