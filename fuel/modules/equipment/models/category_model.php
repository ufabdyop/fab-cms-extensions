<?php
/**
Simple model for getting html from DB for each parent category of equipment
*/
class category_model extends CI_Model {
	
	//member vars
	var $name = null;
	var $html = null;

	function load_by_name($name) {
		$this->name = $name;
		$obj =& get_instance();
		$db = $obj->load->database('coral_eq', true);
		$db->where('category', $name);
		$results = $db->get('coralutah.category_html')->row();
		if ($results) {
			$this->html = $results->html;
		}
	}

	function save() {
		$obj =& get_instance();
		$db = $obj->load->database('coral_eq', true);
		$db->where('category', $this->name);
		$results = $db->get('coralutah.category_html')->result();
		if ($results) {
			$db->where('category', $this->name);
			$db->update('coralutah.category_html', array(
							'category' => $this->name,
							'html' => $this->html,
						));
		} else {
			$db->insert('coralutah.category_html', array(
							'category' => $this->name,
							'html' => $this->html,
						));
		}
	}
}
?>
