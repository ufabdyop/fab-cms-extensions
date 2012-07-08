<?php
require_once(FUEL_PATH.'/libraries/Fuel_base_controller.php');

class equipment extends Fuel_base_controller {

	var $_row_class = "";
	function __construct() {
		parent::__construct(FALSE);	
		//$this->debug = true;
		$this->load->library('session');
		$this->load->helper('login');
		$this->load->helper('url');
		$this->load->helper('breadcrumb');
		$this->load->config('equipment_config');
	}

	//utility function I used once to update the urls for all the equipment
	function _manualurls() {
		$this->load->model('equipment_model', 'eq');
		$all_equipment = $this->eq->get_all();
		foreach($all_equipment as $item) {
			//$eq_obj = $this->eq->load_by_name($item);
			//$dir = $eq_obj->get_svn_directory() . "\n"; 
			//if (preg_match('!/.*/!', $dir)) {
			//	echo $dir;
				$this->db->where('name', $item);
				$this->db->update('eqmgr.equipment', array('manualurl' => 'http://www.nanofab.utah.edu/ci_plugins/index.php/equipment/show_eq/' . urlencode($item)));
			//}
		}
	}
	
	function index()
	{
		$this->list_all();
	}
	
	function test_path() {
		$this->load->model('equipment_model', 'eq');
		$eq = $this->eq->load_by_name('Cambridge Fiji F200');
		$eq->authenticate(get_username(), get_password());
		$folders = $eq->folders();
		//var_dump($folders);
	}
	
	function test_svn() {
		$this->load->model('svn_file');
		$success = $this->svn_file->connect('http://www.nanofab.utah.edu/svn', '/tmp/foo', 'ryant', 'lililinuxusb', '/tmp/bar');
		$array = $this->svn_file->add_directory('/equipment/public/deposition/ald/cambridge-fiji-f200/SOP/Cambridge NanoTech ALD', 'Adding equipment directory');
		//$array = $this->svn_file->add_directory('/equipment/public', 'Adding equipment directory');
	}
	function filename_encode($filename) {
			$str = preg_replace('/[^A-Za-z\\-_0-9 ]+/', '-', $filename);
			if ($filename == 'none') {
				$str = '';
			}
			$str = preg_replace('/-+/', '-', $str);
			return $str;
	}
	function directory_encode($directory) {
			$str = preg_replace('/[^A-Za-z\\-_0-9]+/', '-', $directory);
			if ($directory == 'none') {
				$str = '';
			}
			$str = preg_replace('/-+/', '-', $str);
			$str = strtolower($str);
			return $str;
	}
	function show_eq($equipment = null) {
		if ($equipment != null) {
			//debugging
			$equipment = urldecode($equipment);
			$this->load->model('equipment_model', 'equipment');
			$equipment = $this->equipment->load_by_name($equipment);
			if (is_logged_in() && $equipment) {
				$equipment->authenticate(get_username(), get_password());
			}

			if ($equipment) {
				$folders = $equipment->folders();
			} else {
				$folders = null;
			}		
			$admin = has_role('admin');
			$this->load->view('show_equipment', array('equipment' => $equipment, 'admin' => $admin, 'folders' => $folders, 'curpage' => $this->_get_curpage()));
		}
	}
	function reservations_mobile($equipment=null){
		if ($equipment != null) {
			$equipment = urldecode($equipment);
			$this->load->model('equipment_model', 'equipment');
			$equipment = $this->equipment->load_by_name($equipment);
			$code=$equipment->ical_mobile($equipment->name);
			echo $code;
		}

	}
	function reservations($equipment = null,$option = null) {
		if ($equipment != null) {
			//debugging
			$equipment = urldecode($equipment);
			$this->load->model('equipment_model', 'equipment');
			$equipment = $this->equipment->load_by_name($equipment);
			$equipment->download_ical($equipment->name,$option);
			if ($option==2){
				$filename = str_replace(" ","",$equipment->name);
				$filename = str_replace(",","",$filename);
				header('Location: /phpicalendar/month.php?cal='.$filename);
			}
		}
	}

	function up_down_status() {
		$this->load->model('equipment_model', 'equipment');
		$content = "<table>";
		$content .= $this->_make_header_row('Equipment Name', 'Equipment Status');
		$equipment = $this->equipment->get_all_dates();
		foreach ($equipment as $eq) {
			$eq['up_down_status'] = "Up";
			if ($eq['problems']) {
				$eq['up_down_status'] = "Problem";
			}
			if ($eq['shutdowns']) {
				$eq['up_down_status'] = "Down";
			}
			$tool_text = '<a href="' . site_url('equipment/show_eq/' . urlencode($eq['name'])) . '">' . $eq['name'] . '</a>';
			$content .= $this->_make_row($tool_text, $eq['up_down_status']);
		}
		$content .= "</table>";
		$this->load->view($this->config->item('main_view'), array('title' => 'Equipment Status Report', 'content' => $content));	
	}

	function move_status() {
		//see the function move_status_deprecated for displaying a simple table of move start / finish dates
		header('Location: /ci_plugins/tmp/uploads/openmsp/html/gantt.html');
	}
	function move_status_deprecated() {
		$this->load->model('equipment_model', 'equipment');
		$equipment = $this->equipment->get_all_dates();
		$content = "<table>";
		$content .= $this->_make_header_row('Equipment Name', 'Equipment Status', 'Scheduled Move Date', 'Scheduled Finish Date', 'Type of Move');
		foreach ($equipment as $eq) {
			$eq['up_down_status'] = "Up";
			if ($eq['problems']) {
				$eq['up_down_status'] = "Problem";
			}
			if ($eq['shutdowns']) {
				$eq['up_down_status'] = "Down";
			}
			$tool_text = $eq['name'];
			if (has_role('staff')) {
				$tool_text = '<a href="/tool-move-checklist?mact=ToolMove,m2,DisplayChecklist&item=' . urlencode($eq['name']) . '">' . $eq['name'] . '</a>' . "\n";
			}
			$content .= $this->_make_row($tool_text, $eq['up_down_status'], $eq['move_date'], $eq['move_edate'], $this->_humanize($eq['move_date_type']));
		}
		$content .= "</table>";
		$this->load->view($this->config->item('main_view'), array('title' => 'Equipment Move Dates', 'content' => $content));	
	}
	function _humanize($str) {
		return ucwords(str_replace('_', ' ', $str));
	}
	function _make_header_row() {
		$td_or_th = "th";
		$args = func_get_args();
		$str = "<tr>";
		foreach($args as $arg) {
			$str .= "<$td_or_th>$arg</$td_or_th>";
		}
		$str .= "</tr>";
		return $str;
	}
	function _make_row() {
		$td_or_th = "td";
		$args = func_get_args();
		$this->_row_class = ($this->_row_class == "odd" ? "even" : "odd" );
		$str = "<tr>";
		foreach($args as $arg) {
			$str .= "<$td_or_th class=\"$this->_row_class\">$arg</$td_or_th>";
		}
		$str .= "</tr>";
		return $str;
	}

	function list_all($category = null) {
		if ($category == null) {
			$this->load->model('equipment_model', 'equipment');
			$categories = $this->equipment->get_categories();
			//var_dump($categories);
			$i = 0;
			foreach ($categories as $cat) {
				if($cat[0] == 'Microscopy Core') {
					unset($categories[$i]);
				}
				$i++;
			}
			$microscopy_subset = $this->equipment->get_by_category('Microscopy Core');
			$microscopy_equipment = $microscopy_subset['none'] ;
			$this->load->view('equipment_list', array('categories' => $categories, 'microscopy' => $microscopy_equipment));	
		}
	}
	function _category_breadcrumb($category = null) {
		return breadcrumb(array(site_url('equipment') => 'Equipment', $category => $category));
	}
	function edit_category($category = null) {
		if (has_role('staff')) {
			$this->load->model('equipment_model', 'equipment');
			$this->load->model('category_model', 'category');
			$category = urldecode($category);
			$this->category->load_by_name($category);
			if (isset($_POST) && isset($_POST['html'])) {
				$this->category->html = $this->input->post('html');
				$this->category->save();
			}
			$subcategories = $this->equipment->get_by_category($category);
			$this->load->helper('form');
			$admin_html = form_open(current_url());
			$admin_html .= '<textarea name="html">' . $this->category->html . '</textarea>
							<input type="submit" name="submit" value="Save Changes" />';
			$admin_html .= form_close();
			$this->load->library('tinymce');
			$admin_html .= $this->tinymce->createinitscript();
			$template_data = array('category' => $category, 
														'subcategories' => $subcategories,
														'breadcrumb' => $this->_category_breadcrumb($category));	
			$template_data['admin_html'] = $admin_html;
			$this->load->view('equipment_category', $template_data);
		}
	}
	function list_by_category($category = null) {
		if ($category == null) {
			$this->list_all();		
		} else {
			$this->load->model('equipment_model', 'equipment');
			$this->load->model('category_model', 'category');
			$category = urldecode($category);
			$this->category->load_by_name($category);
			if (has_role('staff')) {
				$subcategories = $this->equipment->get_by_category($category);
				//$subcategories = $this->equipment->get_visible_by_category($category);
			} else {
				$subcategories = $this->equipment->get_visible_by_category($category);
			}

			$template_data = array('category' => $category, 
														'subcategories' => $subcategories,
														'breadcrumb' => $this->_category_breadcrumb($category));	
			$site_url = site_url();
			$this->category->html = preg_replace('/\{site_url\(\'(.*?)\'\)\}/', "$site_url/$1", $this->category->html);
			$template_data['category_html'] = $this->category->html;
			if (has_role('staff') ) {
				$str = "<h3>Administration</h3>";
				$str .= anchor(site_url('equipment/edit_category/'. $category), 'Edit ', array('class' => 'edit_link') );
				$template_data['admin_html'] = $str;
			}
			$this->load->view('equipment_category', $template_data);
		}
	}
	function save_changes($name) {
		if (has_role('staff')) {
			$this->load->helper('json');
			$json = new Services_JSON();
			$post = $json->decode($_POST['inputs']);
			$equipment_name = urldecode($name);
			$this->load->model('equipment_model', 'equip');
			$eq = $this->equip->load_by_name($equipment_name);
			if ($eq) {
				$display_on_web = false;
				foreach($post as $data) {
					switch ($data->name) {
						case 'billing_rate':
							if ($data->value) {
								$eq->set_billing_rate($data->value);
							}
							break;
							
						case 'display_on_web':
							if ($data->value) {
								$eq->set_hidden( '0');
								$display_on_web = true;
							}
							break;
							
						case 'location':
							$eq->set_location($data->value);
							break;
							
							/*
						case 'owner':
							$eq->add_owner($data->value);
							break;
							*/

						case 'summary':
							$save_data = $this->_strip_p_tags($data->value);
							$eq->set_summary($save_data);
							break;
						
						case 'html':
							$eq->set_html($data->value);
							break;
						
						case 'map_id':
							$eq->set_map($data->value);
							break;

						default:
							break;
					}
				}
				if ( !$display_on_web ) {
					$eq->set_hidden('1');
				}
			}
			$eq->save();
		} else {
			die('Error: not logged in');
		}
	}

	function download_file($file_path = null) {
		$ary = func_get_args($file_path);
		if (sizeof($ary) != 5) {
			die('Error, wrong number of arguments.');
		}
		$tool = urldecode($ary[0]);
		$access = $ary[1];
		$category = urldecode($ary[2]);
		$label = urldecode($ary[3]);
		$filename = urldecode($ary[4]);
		$this->load->model('equipment_model', 'equipment');
		$eq = $this->equipment->load_by_name($tool);
		$eq->authenticate(get_username(), get_password());
		$eq->stream_file($access, $category, $label);
	}


	function delete_file($file_path = null) {
		$ary = func_get_args($file_path);
		if (sizeof($ary) != 5) {
			die('Error, wrong number of arguments.');
		}
		$tool = urldecode($ary[0]);
		$access = $ary[1];
		$category = urldecode($ary[2]);
		$label = urldecode($ary[3]);
		$filename = urldecode($ary[4]);
		$this->load->model('equipment_model', 'equipment');
		$eq = $this->equipment->load_by_name($tool);
		$eq->authenticate(get_username(), get_password());
		try {
			$eq->delete_file($access, $category, $label);
		} catch (Exception $e) {
		}
		$this->load->view('equipment_file_table', array('equipment' => $eq));
	}

	function get_equipment_file_table($tool = null) {
		if ($tool == null) {
			die('Please choose a tool');
		}
		$tool = urldecode($tool);
		$this->load->model('equipment_model', 'equipment');
		$eq = $this->equipment->load_by_name($tool);
		$eq->authenticate(get_username(), get_password());
		$this->load->view('equipment_file_table', array('equipment' => $eq));
	}

	function upload_file_valums() {
		$this->load->helper('valums_uploader');
		$this->load->helper('json');
		$json = new Services_JSON();

		// list of invalid extensions, ex. array("jpeg", "xml", "bmp")
		$disallowedExtensions = array("php" );

		// max file size in bytes how about 100MB?
		$sizeLimit = 100 * 1024 * 1024;

		$uploader = new qqFileUploader($disallowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload('tmp/uploads/');

		if (isset($result['success']) && $result['success'] == true) {
				
			//put it in the svn
			$this->load->model('equipment_model', 'equipment');
			$eq = $this->equipment->load_by_name(urldecode($_GET['equipment']));
			$eq->authenticate(get_username(), get_password());
			$extension = pathinfo($result['originalFilename'], PATHINFO_EXTENSION);
			$eq->store_file($result['filename'], $_GET['access_level'], $_GET['category'], $_GET['file_label'], $_GET['file_label'] . '.' . $extension);
			
		}
		// to pass data through iframe you will need to encode all html tags
		echo htmlspecialchars($json->encode($result), ENT_NOQUOTES);
	}

	function edit($equipment = null) {
		if ($equipment == null) {
			$errors[] = 'No equipment name.';
			$this->load->view($this->config->item('main_view'), array('errors' => $errors));
		}
		if (!has_role('staff')) {
			$errors[] = 'Please log in.';
			$current_url = parse_url(current_url(), PHP_URL_PATH);
			$config = array( 'errors' => $errors, 
							'content' => 'You are not logged in.  You can log in <a href="' . login_url() . '">here</a>.' );
			$this->load->view($this->config->item('main_view'), $config);
		} else {
			//load maps
                        $this->load->model('maps_model', 'maps');
                        $maps = $this->maps->get_all();
                        //$maps = array();
                        
			$equipment = urldecode($equipment);
			$this->load->model('equipment_model', 'equipment');
			$equipment = $this->equipment->load_by_name($equipment);
			$equipment->authenticate(get_username(), get_password());
			$this->load->view('edit_equipment', array('equipment' => $equipment, 'maps' => $maps));
		}
	}
	function upload_file () {

		$config['upload_path'] = $this->config->item('upload_path');
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file'))
		{
			var_dump($config);
			$data = array('error' => $this->upload->display_errors(), 'formid' => 'upform', 'success' => false);
			$this->load->view('file_uploaded', $data);
		}
		else
		{
			try {
				$result = $this->upload->data();
				$equipment = $this->input->post('equipment');
				$access_level = $this->input->post('access');
				$category = $this->input->post('category');
				$file_label = $this->input->post('label');

					
				//put it in the svn
				$this->load->model('equipment_model', 'equipment');
				$eq = $this->equipment->load_by_name($equipment);
				if ($eq == null) {
					throw new Exception('No equipment found by that name.');
				}
				$eq->authenticate(get_username(), get_password());
				$extension = pathinfo($result['orig_name'], PATHINFO_EXTENSION);
				$res = $eq->store_file($result['full_path'], $access_level, $category, $file_label, $file_label . '.' . $extension);

				$data = array('upload_data' => $this->upload->data(), 'formid' => 'upform', 'success' => true);
				$this->load->view('file_uploaded', $data);
			} catch (Exception $e) {
				$data = array('upload_data' => $this->upload->data(), 'formid' => 'upform', 'success' => false, 'error' => 'Error Uploading File');
				$this->load->view('file_uploaded', $data);
			}
		}
	}

	function upload_form() {
		$args = func_get_args();
		if (sizeof($args) != 4) {
			die('Error, wrong number of arguments.');
		}
		$data = array();
		$data['equipment'] = urldecode( $args[0] );
		$data['access'] = urldecode( $args[1] );
		$data['category'] = urldecode( $args[2] );
		$data['label'] = urldecode( $args[3] );

		$data['form_id'] = 'upform';
		$this->load->view('upload_form', $data);
	}

	function process_upload() {
		$args = func_get_args();

		$config['upload_path'] = $this->config->item('upload_path');
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);
		//var_dump($_FILES);

		if ( ! $this->upload->do_upload('file'))
		{
			$error = array('error' => $this->upload->display_errors(), 'formid' => 'upform', 'success' => false);
			$this->load->view('file_uploaded', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data(), 'formid' => 'upform', 'success' => true);
			$this->load->view('file_uploaded', $data);
		}
	}
	function _fix_html() {
		$this->load->database('coral_eq');
		//$rows = $this->db->query('select * from coralutah.equipment_extended where html like \'%<hr />%\'')->result_array();
		$i = 0;
		if (isset($_POST['html'])) {
			$query = "update coralutah.equipment_extended set data_gathered = 't', html = '" . addslashes($_POST['html']) . "' where item = '" . $_POST['item'] . "';";
			$this->db->query($query);
			//echo $query;
		}

		$rows = $this->db->query('select * from coralutah.equipment_extended where html is not null and data_gathered = \'f\' order by item')->result_array();

		foreach($rows as $r) {
			$i++;
			$html = $r['html'];
			echo '<form name="form' . $i . '" method="POST" action="#">';
			echo '<textarea name="' . 'html' . '" style="width: 600px; height: 600px;">' . "\n";
			echo $html;
			echo '</textarea>';
			echo '<input name="item" value="' . $r['item'] . '" />' . "\n";
			echo '<input type="submit" name="submit" />';
			echo '</form>' . "\n";
			echo $html;
		}
	}

	function _strip_p_tags($html) {
		$ret = trim($html);
		if ( strrpos( $ret, '</p>') == (strlen($ret) - 4) ) {
			if ( strpos( $ret, '<p>') === 0 ) {
				 $ret = substr($ret, 3, strlen($ret) - 7);
			}
		}
		return $ret;
	}

	function _get_curpage() {
			$current_url = parse_url(current_url(), PHP_URL_PATH);
			return $current_url;
	}
}


