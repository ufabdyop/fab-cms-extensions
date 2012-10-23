<?php
require_once(FUEL_PATH.'models/base_module_model.php');

class equipment_model extends Base_module_model {
	public static $coral_eq_url = 'http://coral.nanofab.utah.edu/coral/xml/equipment/Area.xml';
	public static $hierarchy = null;
	protected $dsn = 'coral_eq';

	//member vars
	var $name;
	var $html;
	var $problem_html;
	var $summary;
	var $picture;
	var $owner;
	var $up_down_status;
	var $reports_url;
	var $interlocked;
	var $number_reservations;
	var $location;
	var $x;
	var $y;
	var $map;
	var $display_on_website;
	var $billing_rate;
	var $processes;
	var $precious_metals;
	var $mailing_list;
	var $map_width ;
	var $map_height ;
	var $move_date ;
	var $move_date_type ;
	var $svn_folder_path ;
	var $svn_file ;
	var $svn_user ;
	var $svn_pass ;
	var $svn_repo ;
	private $db_handle;
        
        

	private function get_folder_path() {
		return $this->name;
	}

	public function get_owner_map() {
		//maps categories to owners
		$bbaker = array('name' => 'Brian Baker', 'url' => site_url('BrianBaker'));
		$ryant = array('name' => 'Ryan Taylor', 'url' => site_url('RyanTaylor'));
		$tolsen = array('name' => 'Tony Olsen', 'url' => site_url('TonyOlsen'));
		$cfisher = array('name' => 'Charles Fisher', 'url' => site_url('CharlesFisher'));
		$vandev = array('name' => 'Brian van Devener', 'url' => site_url('BrianvanDevener'));
		$owner_map = array( 'Deposition' => $bbaker,
					'Etching' => $cfisher,
					'Packaging' => $cfisher,
					'Furnaces' => $tolsen,
					'Lithography' => $bbaker,
					'CMP' => $bbaker,
					'Microscopy Core' => $vandev,
					'Benches and Hoods' => $cfisher,
					'Test Measure Inspect' => $bbaker,
					'Support Equipment' => $ryant
					);
		return $owner_map;
	}

	/*
	Video_Feed
	Reservation Schedule
	Chemicals_Required?
	DI Water Required?
	*/

	function __construct()
	{
		parent::__construct('equipment');
		$this->create_hierarchy();

		//set up svn connection
		$obj =& get_instance();
		$obj->load->config('equipment_config');
		$this->db_handle = $obj->load->database('coral_eq', true);
		$obj->config->item('map_path');
		$this->svn_user = null;
		$this->svn_pass = null;
		$this->svn_repo = $obj->config->item('svn_repo');
		require_once('svn_file.php');
		$this->svn_file = new svn_file();
		return $this->svn_file->connect($this->svn_repo, 
								$obj->config->item('svn_config_dir'),
								$this->svn_user,
								$this->svn_pass,
								$obj->config->item('svn_storage_dir'),
								$obj->config->item('svn_storage_dir_anonymous'),
								$obj->config->item('svn_config_dir_anonymous')
								);
	}

	//uses credentials to authenticate to svn and get role-appropriate file listings
	function authenticate($username, $password) {
		$this->load->config('equipment_config');
		$this->config->item('map_path');
		$this->svn_user = $username;
		$this->svn_pass = $password;
		$this->svn_repo = $this->config->item('svn_repo');
		require_once('svn_file.php');
		$this->svn_file = new svn_file();
		return $this->svn_file->connect($this->svn_repo, 
								$this->config->item('svn_config_dir'),
								$username,
								$password,
								$this->config->item('svn_storage_dir'),
								$this->config->item('svn_storage_dir_anonymous'),
								$this->config->item('svn_config_dir_anonymous')
								);
	}

	//return array of file folders of the following format
	/**
	 array(      
	 			'staff' => array (
						'category' => 'some category', 
						'files' => array( 
									'label1' => 'filename1',
									'label2' => 'filename2')
								),
	 			'member' => array (
						'category' => 'some category', 
						'files' => array( 
									'label1' => 'filename1',
									'label2' => 'filename2')
								),
	 			'public' => array (
						'category' => 'some category', 
						'files' => array( 
									'label1' => 'filename1',
									'label2' => 'filename2')
								)
			)
	Depending on privileges, may only return 'public' array, etc. 
	Can contain any number of categories.
	This comes from the svn structure of 
		repobase/access/path/to/equipment/name/category/label/file
	For example, an SOP for the Cambridge ALD with a filename of cambridge-sop.pdf 
	and desired link name of Cambridge ALD Deposition that is available to all members 
	would be stored in the svn as:
		http://www.nanofab.utah.edu/svn/member/deposition/ald/cambridge-fiji-f200/SOP/Cambridge+ALD+Deposition/cambridge-sop.pdf

		Notice that the /path/to/equipment/name/ portion of url is directory_encoded (function below)
		where the /category/label parts are encoded using rawurlencode

	 * 
	 **/
	function folders() {
		if (!isset($this->svn_file)) {
			throw new Exception('Not authenticated');
		}
		$return_ary = array('staff' => array(), 'member' => array(), 'public' => array() );
		foreach(array_keys($return_ary) as $key) {
			$directory = $this->get_svn_directory($key);

			try {
				$categories = $this->svn_file->get_directories($directory);
				foreach($categories as $cat) {
					$files = $this->svn_file->get_directories($directory . '/' . $cat);
					$file_ary = array();
					foreach ($files as $f) {
						$file_label = urldecode($f);
						$file_name = $this->svn_file->get_files($directory . '/' . $cat . '/' . $f);
						if ($file_name && isset($file_name[0])) {
								$file_ary[$file_label] = urldecode($file_name[0]);
						}
					}
					if ($files) {
								$return_ary[$key][] = array('category' => urldecode($cat),
															'files' => $file_ary);
					}
				}
			} catch (Exception $e) {
				//debugging
				//svn_file->get_directories for the staff and member directories will throw exceptions without proper credentials
			}
		}
		return $return_ary;
	}

	function get_path_segments() {
	}

	function breadcrumb($include_view_link = false) {
		$separator = "&nbsp;:&nbsp;";
		$category = $this->get_full_path_array();
		$category_name = "";
		if ($category && isset($category[0])) {
			$category_name = ucwords(($category[0]));
			$category = urlencode($category[0]);
			$category_breadcrumb =   $separator . '<a href="' . site_url('equipment/list_by_category/' . $category) . '"> '. $category_name .' </a> ';
			$category_link =   site_url('equipment/list_by_category/' . $category) ;
		}
		$equipment_home = site_url("/equipment");
		$equipment_link = $separator . '<a href="' . $equipment_home .'">Equipment</a>';
		$last_item = $include_view_link = ($include_view_link) ? "<a href=\"" . site_url('equipment/show_eq/' . urlencode($this->name)) . "\">" . $this->name . "</a>" : '<span class="lastitem">' . $this->name . '</span>';
		$tool_link = site_url('equipment/show_eq/' . urlencode($this->name));
		$tool_name = $this->name;
		//return '<a href="/">Utah Nanofab</a>' . $equipment_link . $category_breadcrumb . $separator . $last_item ;
		return breadcrumb(array($equipment_home => 'Equipment', $category_link => $category_name, $tool_link => $tool_name));
	}

	public function stream_file($access, $category, $label) {
		$category_path = ($this->get_svn_directory($access) . 
									'/' . $this->filename_encode($category) );
		$svn_path = $category_path . '/' . $this->filename_encode($label) ; 
		$files = $this->svn_file->get_files($svn_path);
		if($files) {
			$fileName = $files[0];
			$filePath = $this->svn_file->get_file($svn_path . '/' . $fileName);
			set_time_limit(0); //Set the execution time to infinite.
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header ('Content-Disposition: attachment; filename="' . urldecode($fileName) . '"');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filePath));
			ob_clean();
			flush();
			readfile($filePath); //readfile will stream the file.
			exit;
		} else {
			die("File not found");
		}
	}
	public function delete_file($access, $category, $label) {
		$category_path = ($this->get_svn_directory($access) . 
									'/' . $this->filename_encode($category) );
		$svn_path = $category_path . '/' . $this->filename_encode($label) ; 


		//check if there is more than one file in the last directory (this is not allowed)
		$files = $this->svn_file->get_files($svn_path);
		foreach($files as $f) {
			$this->svn_file->delete_file($svn_path . '/' . $f);
		}
		$this->svn_file->delete_file($svn_path );

		if ($this->svn_file->is_empty($category_path)) {
			 $this->svn_file->delete_file($category_path );
		}
	}

/**
 * Stores a file in the svn
 * @param: $filepath: the local name of the file to store
 * @param: $access: desired access level for file (staff, member, public)
 * @param: $category: category of file
 * @param: $label: label for file link
 * @param: $filename: name for file in storage
 **/
	public function store_file($filepath, $access, $category, $label, $filename)
	{

		$new_file = false;
		$svn_path = ($this->get_svn_directory($access) . 
									'/' . $this->filename_encode($category)) ; 

		//check for category directory existence
		$exists = $this->svn_file->file_exists( $svn_path );
		if (!$exists) {
			$new_file = true;
			$this->svn_file->add_directory($svn_path);
		} 

		//check for label directory existence
		$svn_path .= '/' . $this->filename_encode($label) ; 
		$exists = $this->svn_file->file_exists( $svn_path );
		if (!$exists) {
			$new_file = true;
			$this->svn_file->add_directory($svn_path);
		} 

		//check for file existence
		$bottom_directory = $svn_path;
		$filename = $this->filename_encode($filename);
		$svn_path .= '/' . $filename;
		$exists = $this->svn_file->file_exists( $svn_path );
		if (!$exists) {
			$new_file = true;
			$this->svn_file->add_file($svn_path, $filepath);
		} 

		//check if there is more than one file in the last directory (this is not allowed)
		$files = $this->svn_file->get_files($bottom_directory);
		foreach($files as $f) {
			if ($f != $filename) {
				$this->svn_file->delete_file($bottom_directory . '/' . $f);
			}
		}

		//if the file already existed, commit a new revision
		if (!$new_file) {
			$this->svn_file->commit_file($svn_path, $filepath);
		}

	}

	/**
	 * returns the path to this piece of equipment 
	 * example return value:
	 * array( 'Deposition', 'ALD', 'Cambridge Fiji F200' )
	 **/
	function get_full_path_array() {
		$pieces = array();
		$x = self::$hierarchy;
		$name = $this->name;
		$pieces[] = $name;

		$ancestor_xpath_suffix =  '/parent::area';
		$xpath = "//machine[@name='$name']" ;
		$xpath .= $ancestor_xpath_suffix;

		while ( $nodes = $x->xpath($xpath)) {
			array_unshift($pieces, (string)($nodes[0]['name']));
			$xpath .= $ancestor_xpath_suffix;
		}

		//remove root directory (in our case nanofab-utah-edu)
		array_shift($pieces);

		return $pieces;
	}

	/**
	 * returns the path to the root folder in the svn for this piece of equipment
	 **/
	function get_svn_directory($access = null ) {
		$x = self::$hierarchy;
		$cats = array();
		$name = $this->name;
		$directory = $this->directory_encode($name);

		$ancestor_xpath_suffix =  '/parent::area';
		$xpath = "//machine[@name='$name']" ;
		$xpath .= $ancestor_xpath_suffix;

		while ( $nodes = $x->xpath($xpath)) {
			$directory = $this->directory_encode((string)($nodes[0]['name'])) . '/' . $directory ;
			$xpath .= $ancestor_xpath_suffix;
		}

		if ($access != null ) {
			$directory = $access . '/' . $directory;
		}
		return '/' . $directory;
	}

	/**
	 * converts a string for a file category string
	 **/
	function filename_encode($filename) {
			$str = preg_replace('/[^A-Za-z\\-_0-9,\\. ]+/', '-', $filename);
			if ($filename == 'none') {
				$str = '';
			}
			$str = str_replace(' ', '+', $str);
			return $str;
	}

	/**
	 * converts a string for a piece of equipment to a directory string
	 * ie. change "AFM, bruker dimension icon" to "afm-bruker-dimension-icon"
	 **/
	function directory_encode($directory) {
			$str = preg_replace('/[^A-Za-z\\-_0-9\\.]+/', '-', $directory);
			if ($directory == 'none') {
				$str = '';
			}
			$str = preg_replace('/-+/', '-', $str);
			$str = strtolower($str);
			return $str;
	}

	function create_hierarchy() {
		if (self::$hierarchy == null) {
			$url = self::$coral_eq_url;
			$xml = `curl $url`;

			self::$hierarchy = new SimpleXMLElement($xml);
			/*
			foreach($x->area->area as $a) {
				if (isset($a->machine)) {
					echo "<h3>" . $a['name'] . "</h3>\n";
					foreach($a->machine as $m) {
						$name = trim($m['name']);
						echo "<p class=\"" . $eq[$name]  . "\">{$m['name']}</p>\n";
					}
				}   
				foreach($a->area as $b) {
					echo "<h3>" . $a['name'] . " - " . $b['name'] . "</h3>\n";
					foreach($b->machine as $n) {
						$name = trim($n['name']);
						echo "<p class=\"" . $eq[$name]  . "\">{$n['name']}</p>\n";
					}
				}   
			}
			*/
		}
	}

	function get_categories() {
		$x = self::$hierarchy;
		$cats = array();
		$map = $this->get_owner_map();
		$base = $x->lab;
		foreach($base->area as $a) {
			$name = (string)$a['name'];
			if (isset($map[$name])) {
				$cats[] = array($a['name'], $map[$name]);
			} else {
			}
		}
		return $cats;
	}
	function get_visible_by_category($category = null) {
		$subcats = $this->get_by_category($category);
		foreach(array_keys($subcats) as $j) {
			//loop over tool set to remove tools that are not for web display
			$obj =& get_instance();
			$db = $this->db_handle;
			$db->where('hidden', '1');
			$db->select('name');
			$query_result = $db->get('eqmgr.equipment')->result_array();
			$hidden_tools = array();
			foreach($query_result as $q) {
				$hidden_tools[] = $q['name'];
			}
			for ($i = sizeof($subcats[$j]) - 1; $i >= 0; $i--) {
				if ( in_array( $subcats[$j][$i], $hidden_tools)) {
					unset($subcats[$j][$i]);
				} 
			}
			if (empty($subcats[$j])) {
				unset($subcats[$j]);
			}
		}
		return ($subcats);
	}
	function get_by_category($category = null) {
		if ($category == null) {
			return null;
		}
		$x = self::$hierarchy;
		$cats = array();

		$nodes = $x->xpath("/xml/lab/area[@name='$category']");

		foreach($nodes as $a) {
			if (isset($a->machine)) {
				foreach($a->machine as $m) {
					$name = trim($m['name']);
					$cats['none'][] =  $name;
				}
			}   
			foreach($a->area as $b) {
				$cat = trim($b['name']);
				foreach($b->machine as $n) {
					$name = trim($n['name']);
					$cats[$cat][] =  $name;
				}
			}   
		}
		return $cats;
	}
	public function load_problems($name){
		$sql=" SELECT * FROM 
			(select 'Problem' as \"type\", * from eqmgr.problems 
			UNION
			select 'Shutdown' as \"type\", * from eqmgr.shutdowns ) as subquery
			where item='$name' and completed='0' 
			order by reported desc";
		$db = $this->db_handle;
		$problem=$db->query($sql)->result_array();
		$html_ext="";
		for ($i=0;$i<count($problem);$i++){	
			if (isset($problem[$i])){
				$prob=$problem[$i];
				if ($i % 2 ==0)$html_ext.="<tr style=\"background:#CCC\">";	
				else $html_ext.="<tr style=\"background:#C0C0C0\">";
				if ($prob['reported']!="")
					$html_ext.="<td>".$prob['reported']."</td>";
				$html_ext.="<td>".$prob['type']."</td>";
				if ($prob['definition']!="")
					$html_ext=$html_ext."<td>".$prob['definition']."</td>";
				else $html_ext=$html_ext."<td>No Definition</td>";
				if ($prob['defmessage']!="")
					$html_ext=$html_ext."<td>".$prob['defmessage']."</td>";
				else $html_ext=$html_ext."<td>No Message</td>";
				$html_ext=$html_ext."</tr>";
			}
		}	
		if (count($problem)>0){
			$html_ext="<h3>Equipment Status</h3><table class=\"equipment_status\"><tr><th>Reported</th><th>Type of Issue</th><th>Definition</th><th>Details</th></tr>".$html_ext."</table>";
		}
		else 
			$html_ext="<h3>Equipment Status</h3>&#8730; Tool is Up";
		return $html_ext;
	}
	function ical_mobile($name=null){
		$now = time();
		$today=date("ymd", $now);
		$oneweeklater = $now + 7 * 24 * 60 * 60;
		$oneweeklater_human = date("ymd", $oneweeklater);
		$n=0;$k=0;
		$sql="SELECT * FROM resmgr.reservation WHERE item='$name' and stale='0' and bdate>='$today' and bdate<'$oneweeklater_human' order by bdate asc";
		$db = $this->db_handle;
		$cal=$db->query($sql)->result_array();
		$n=count($cal);
		$i=0;
		$lastday=$today-1;
		$l=0;
		$code="<style> body {background:#000000;} .class0 {background:#CCC;} .class1 {background:#C0C0C0;}</style>";
		if ($n==0){
			$code.="<center style=\"color: white\">No reservation has been found within 7 days.</center>"."<meta http-equiv='refresh' content='2;url=javascript:history.back()'>\n";
			return $code;
		}
		$code.="<center><table border=0>";
		while($i<$n-1){
			$k=$i;		
			$start=strtotime($cal[$i]['bdate']);
			//echo $start."<br>";
			$end=strtotime($cal[$i]['edate']);
			$starti=strtotime($cal[++$i]['bdate']);
			$endi=strtotime($cal[$i]['edate']);
			while ($starti<=$end && $endi>=$end){
				$end=$endi;
				if ($i<$n-1){
				$starti=strtotime($cal[++$i]['bdate']);
				$endi=strtotime($cal[$i]['edate']);
				}
				else break;
			}
			$date_start=date("Ymd",$start);
			$date_end=date("Ymd",$end);
			$time_start=date("H:i",$start);
			$time_end=date("H:i",$end);
			if ($date_start>$lastday){
				$code.="<tr style='background:#999'><td colspan=4>".date("Y-m-d	l",strtotime($date_start))."</td></tr>";
				$l=0;
				$lastday=$date_start;
			}
			while ($date_start<$date_end){
				$code.="<tr class='class".($l%2)."'><td>$time_start</td><td>23:59</td><td>".$cal[$k]['project']."</td><td>".$cal[$k]['agent']."</td></tr>";
				$l+=1;
				$date_start=date("Ymd",strtotime($date_start)+strtotime("+1 day")-time());
				$time_start="00:00";
				//$sd=new DateTime($date_start);
				$code.="<tr style='background:#999'><td colspan=4>".date("Y-m-d	l",strtotime($date_start))."</td></tr>";
				$lastday=$date_start;
				$l=0;
			}
			$code.="<tr class='class".($l%2)."'><td>".$time_start."</td><td>".$time_end."</td><td>".$cal[$k]['project']."</td><td>".$cal[$k]['agent']."</td></tr>";
			$l+=1;
			
		}
		return $code."</table></CENTER>";
	}
	function download_ical($name = null,$option = null,$bdate = null){
		if ($bdate == null) {
			$bdate = mktime(0, 0, 0, date('m'), 0, date('Y'));
		} else {
			$bdate = strtotime($bdate);
		}
		$bdate = date('Y-m-d', $bdate);
		$n=0;$k=0;
		require_once 'iCalcreator.class.php';
		$sql="SELECT * FROM resmgr.reservation WHERE item='$name' and stale='0' and bdate > '$bdate' order by bdate asc";
		$db= $this->db_handle;
		$cal=$db->query($sql)->result_array();
		$n=count($cal);
		$i=0;
		$calendar = new vcalendar( array( 'unique_id' => 'nanofab.utah.edu'));
		//$calendar->setProperty( "X-WR-TIMEZONE", "America/Denver" );
		while($i<$n){
			$k=$i;
			$start=strtotime($cal[$i]['bdate']);
			$end=strtotime($cal[$i]['edate']);

			$i++;
			$starti = false;
			$endi = false;
			 if ( isset($cal[$i])) {
				$starti = $cal[$i]['bdate'];
				$endi = strtotime($cal[$i]['edate']);
			 }
			while ($starti<=$end && $endi>=$end){
				$end=$endi;
				if ($i<$n-1){
				$starti=strtotime($cal[++$i]['bdate']);
				$endi=strtotime($cal[$i]['edate']);
				}
				else break;
			}
			
			$date_start=date("Ymd",$start);
			$date_end=date("Ymd",$end);
			$time_start=date("H:i",$start);
			$time_end=date("H:i",$end);
			while ($date_start<$date_end){
				$end1=strtotime($date_start."235900");
				$e=& $calendar->newComponent('vevent');
				$e->setProperty( 'dtstart'
							   , date("Ymd\THis",$start));
				$e->setProperty( 'dtend'
							   , date("Ymd\THis",$end1));
				$e->setProperty( 'summary'
							   , 'Project: '.$cal[$k]['project'].' \nAgent: '.$cal[$k]['agent'] );				
				$date_start=date("Ymd",strtotime($date_start)+strtotime("+1 day")-time());
				$time_start="00:00";
				$start=strtotime($date_start."000000");
			}			
		
			$e=& $calendar->newComponent('vevent');
			$e->setProperty( 'dtstart'
						   , date("Ymd\THis",$start));
			$e->setProperty( 'dtend'
						   , date("Ymd\THis",$end));
			$e->setProperty( 'summary'
						   , 'Project: '.$cal[$k]['project'].' \nAgent: '.$cal[$k]['agent'] );						   
		}
		if ($n>0) {
			$string=$calendar->createCalendar();
			$filename = str_replace(" ","",$name).".ics";
			$filename = str_replace(",", "", $filename);
                        $dir = $this->config->item('calendar_dir');
			$myFile="$dir/".$filename;
			$fh=fopen($myFile,"w")or die("can't open file");
			fwrite($fh,trim($string));
			fclose($fh);
			if ($option==1) {
				header("Content-Disposition: attachment; filename=\"".str_replace(" ","",$name).".ics\"");
				ob_end_clean();
				echo file_get_contents($myFile);
				//$calendar->returnCalendar();
			}
		} else {
			echo "<h2 style=\"color:red\">The Reservation of the tool ".$name." </h1>is not available to download</h2>"."<meta http-equiv='refresh' content='2;url=javascript:history.go(-1)'>\n";
		}
	}
	function load_by_name($name) {
		$sql = "select * from eqmgr.equipment eq left join coralutah.equipment_extended ext on eq.name = ext.item left join coralutah.equipment_maps mp on ext.map_id = mp.id where eq.name='$name'\n";
		$obj =& get_instance();
		$db =  $this->db_handle;
		$equipments = $db->query($sql)->result_array();
		$sql1="SELECT oid FROM resmgr.reservation WHERE item='$name' and stale='0' order by bdate asc";
		$num_res=$db->query($sql1)->num_rows();
		if (isset($equipments[0])) {
			$eq = $equipments[0];
			$eq_obj = new equipment_model();
			$this->load->config('equipment_config');
			$map_path = $this->config->item('map_path');
			$eq_obj->map = $map_path . $eq['filename'];
			$eq_obj->map_width = $eq['width'];
			$eq_obj->map_height = $eq['height'];
			//$html_ext=$this->load_problems($name);
			$eq_obj->problem_html=$this->load_problems($name);
			$eq_obj->html = $eq['html'];		
			$eq_obj->summary = $eq['summary'];
			$eq_obj->image_url = $eq['image_url'];
			$eq_obj->reports_url = $eq['reports_url'];
			$eq_obj->display_on_web = $eq['display_on_web'];
			$eq_obj->modified = $eq['modified'];
			$eq_obj->current_url = $eq['current_url'];
			$eq_obj->di_water = $eq['di_water'];
			$eq_obj->billing_rate = $eq['billing_rate'];
			$eq_obj->name = $eq['name'];
			$eq_obj->id = $eq['id'];
			$eq_obj->map_id = $eq['map_id'];
			$eq_obj->lab = $eq['lab'];
			$eq_obj->agent = $eq['agent'];
			$eq_obj->interlocked = $eq['interlocked'];
			$eq_obj->enabled = $eq['enabled'];
			$eq_obj->description = $eq['description'];
			$eq_obj->location = $eq['location'];
			$eq_obj->manualurl = $eq['manualurl'];
			$eq_obj->historyurl = $eq['historyurl'];
			$eq_obj->hidden = $eq['hidden'];
			$eq_obj->warnings = $eq['warnings'];
			$eq_obj->problems = $eq['problems'];
			$eq_obj->shutdowns = $eq['shutdowns'];
			$eq_obj->move_date = $eq['move_date'];
			$eq_obj->move_edate = $eq['move_edate'];
			$eq_obj->move_date_type = $eq['move_date_type'];
			$eq_obj->mailing_list = preg_replace('/[^A-Za-z\\-_0-9]/', '-', $name);
			$eq_obj->mailing_list = 'coraleq-' . strtolower($eq_obj->mailing_list) . '@eng.utah.edu';
			if ($eq_obj->location) {
				$x_y_array = explode(',', $eq_obj->location);
				if (sizeof($x_y_array == 2)) {
					$eq_obj->x = $x_y_array[0];
					$eq_obj->y = $x_y_array[1];
				}
			}
			$eq_obj->number_reservations = $num_res;
			$eq_obj->up_down_status = "Up";
			if ($eq_obj->problems) {
				$eq_obj->up_down_status = "Problem";
			}
			if ($eq_obj->shutdowns) {
				$eq_obj->up_down_status = "Down";
			}

			return $eq_obj;
		} else {
			return null;
		}
	}
	function set_hidden($hidden) {
		$this->db_handle->where('name', $this->name);
		return $this->db_handle->update('eqmgr.equipment', array('hidden' => $hidden) );
	}
	function set_map($map) {
		$this->db_handle->where('item', $this->name);
		return $this->db_handle->update('coralutah.equipment_extended', array('map_id' => $map) );
	}
	function set_location($location) {
		$this->db_handle->where('name', $this->name);
		return $this->db_handle->update('eqmgr.equipment', array('location' => $location) );
	}
	function set_value ($name, $value) {
		$this->db_handle->where('item', $this->name);
		$success = $this->db_handle->update('coralutah.equipment_extended', array($name => $value) );
		return $success;
	}
	function set_summary ($value) {
		$this->set_value('summary', $value);
	}
	function set_billing_rate ($value) {
		$this->db_handle->where('item', $this->name);
		$success = $this->db_handle->update('coralutah.equipment_extended', array('billing_rate' => $value) );
		return $success;
	}
	function set_html($html) {
		$this->db_handle->where('item', $this->name);
		$success = $this->db_handle->update('coralutah.equipment_extended', array('html' => $html) );
		return $success;
	}
	function set_move_date($md) {
		$this->db_handle->where('item', $this->name);
		$success = $this->db_handle->update('coralutah.equipment_extended', array('move_date' => $md) );
		return $success;
	}
	function set_move_edate($md) {
		$this->db_handle->where('item', $this->name);
		$success = $this->db_handle->update('coralutah.equipment_extended', array('move_edate' => $md) );
		return $success;
	}
	function set_move_date_type($md) {
		$this->db_handle->where('item', $this->name);
		$success = $this->db_handle->update('coralutah.equipment_extended', array('move_date_type' => $md) );
		return $success;
	}
	function save() {
		//nothing yet
	}
	
	function get_all_objects($sql_clause = "") {
		$names = $this->get_all($sql_clause);
		$objects = array();
		foreach ($names as $name) {
			$obj = $this->load_by_name($name);
			$objects[] = $obj;
		}
		return $objects;
	}
	
	function get_all_dates() {
		return $this->db_handle->query('SELECT name, problems, shutdowns, move_date, move_edate, move_date_type FROM eqmgr.equipment as e left join coralutah.equipment_extended as ee on e.name = ee.item order by move_date, name')->result_array();
	}
	
	function get_all($sql_clause = "") {
		$equipments = $this->db_handle->query('SELECT * FROM eqmgr.equipment ')->result_array();
		$eq_ary = array();
		foreach($equipments as $eq) {
			$eq_ary[] = $eq['name'];	
		}	
		return $eq_ary;
	}

      /** 
       * function get_hierarchy_array()
       *
       * return a tree representing all tools
       * 
       * @return Array, an array of all equipment
       */
	    function get_hierarchy_array() {
		$cats = $this->get_categories();
		$eq_array = array();
		foreach($cats as $cat) {
		    $string_category = (string)($cat[0]);
		    $eq_array[$string_category] = $this->get_by_category($string_category) ;
		}   
		$cats = $eq_array;
		$return_array = array();
		foreach ($cats as $cat => $subcat_array) {
		    foreach ($subcat_array as $subcat => $tools) {
			foreach ($tools as $tool) {
			    $return_array[] = array($cat, $subcat, $tool);
			}
		    }
		}
		return $return_array;
	    }   

	
	// --------------------------------------------------------------------

      /** 
       * function SaveForm()
       *
       * insert form data
       * @param $form_data - array
       * @return Bool - TRUE or FALSE
       */

	function SaveForm($form_data)
	{
		$this->db->insert('equip', $form_data);
		
		if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;
	}

}
?>
