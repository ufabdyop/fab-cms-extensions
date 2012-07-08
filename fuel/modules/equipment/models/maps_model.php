<?php
require_once(FUEL_PATH.'models/base_module_model.php');


/**
Simple model for getting html from DB for each parent category of equipment
*/
class maps_model extends Base_module_model {
	
        protected $dsn = 'coral_eq';

	//member vars
        var $all_maps = null;
	function __construct()
	{
		parent::__construct('equipment');
	}

	function get_all() {
            if (!$this->all_maps) {
		$obj =& get_instance();
		$db = $obj->load->database('coral_eq', true);
		$results = $db->get('coralutah.equipment_maps')->result_array();
                $this->all_maps = $results;
            }
            return $this->all_maps;
	}
}
?>
