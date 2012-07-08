<?php
/**
Simple model for getting html from DB for each parent category of equipment
*/
class maps_model extends CI_Model {
        protected $dsn = 'coral_eq';

	//member vars
        var $all_maps = null;

	function get_all() {
            if (!$this->all_maps) {
		$obj =& get_instance();
		$obj->load->database('coral_eq');
		$results = $obj->db->get('coralutah.equipment_maps')->result_array();
                $this->all_maps = $results;
            }
            return $this->all_maps;
	}
}
?>
