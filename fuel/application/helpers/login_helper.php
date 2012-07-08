<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	//
	function session_check() {
	    $obj =& get_instance();
	    $obj->load->library('session');
	    $obj->load->config('login_config');
	    $prefix = $obj->config->item('login_prefix'); //prefix for session vars
	    $expiration = $obj->config->item('login_expiration'); 
	    //var_dump($obj->session);
	    
		//either we've received their credentials through a post, or they are already logged in
		if (!is_logged_in()) {
			redirect_to_login();
		}
	}

	//returns true if a user is logged in
	function is_logged_in() {
		$obj =& get_instance();
		$obj->load->library('session');
		$obj->load->config('login_config');
		$prefix = $obj->config->item('login_prefix'); //prefix for session vars
		$expiration = $obj->config->item('login_expiration'); 
	
		//var_dump('hello');
		if (get_username() && ( time() - $obj->session->userdata('last_activity') < $expiration * 60 ) ) {
			return true;
		}
		return false;
	}
	
	//returns true if the current user is an admin
	function is_admin() {
		return get_status() == 'admin';
	}

	//returns true if the current user is an admin
	function is_superadmin() {
		return get_status() == 'superadmin';
	}

	function get_first_and_last_names() {
		$username = get_username();
		$obj =& get_instance();
		$DB = $obj->load->database('coral', true);
		$DB->where('name', $username);
		$row = $DB->get('rscmgr.member')->result();
		return array($row[0]->firstname, $row[0]->lastname);
	}
	
	
	//returns the user's admin_status
	function get_status() {
		//TODO: have this check for user status against coral
		return false;
	}

	//redirects to the controller for login
	function redirect_to_login($error_msg = null) {
		$obj =& get_instance();
		$obj->load->config('login_config');
		$obj->load->helper('url');
	        $obj->load->library('session');
		if ($obj->session->flashdata('redirect')) {
			$obj->session->keep_flashdata('redirect');
		} else {
			$obj->session->set_flashdata('redirect', $obj->uri->uri_string());
		}
		if ($error_msg != null) {
			$obj->session->set_flashdata('error_msg', $error_msg);
		}
		
		//only redirect if we are not already at the login page
		if (strcmp('/' . $obj->config->item('login_controller'), $obj->uri->uri_string()) != 0 ) {
			redirect($obj->config->item('login_controller'));
		}
	}

	//return the email address of someone who is logged in
	function get_email() {
		$obj =& get_instance();
		$obj->load->library('session');
		$obj->load->config('login_config');
		$prefix = $obj->config->item('login_prefix'); //prefix for session vars
		return $obj->session->userdata("${prefix}_email");
	}

	//return the username  of someone who is logged in
	function get_username() {
		$obj =& get_instance();
		$obj->load->library('session');
		$obj->load->config('login_config');
		$prefix = $obj->config->item('login_prefix'); //prefix for session vars
		return $obj->session->userdata("${prefix}_username");
	}

	//return the password  of someone who is logged in
	function get_password() {
		$obj =& get_instance();
		$obj->load->library('session');
		$obj->load->config('login_config');
		$prefix = $obj->config->item('login_prefix'); //prefix for session vars
		return $obj->session->userdata("${prefix}_password");
	}

	//log a user out
	function logout() {
		unset_cmsms_login();
		$obj =& get_instance();
		$obj->load->config('login_config');
		$obj->load->library('session');
		$prefix = $obj->config->item('login_prefix'); //prefix for session vars
		$obj->session->unset_userdata("${prefix}_username");
                logout_zenphoto_admin();
	}
	
	//logs a user in using the posted email and password
	function login($username, $password) {
		$obj =& get_instance();
		$obj->load->library('session');
		$obj->load->config('login_config');
		$prefix = $obj->config->item('login_prefix'); //prefix for session vars

		$obj->load->library('AdLDAP');
		$result = $obj->adldap->authenticate($username, $password);
		if ($result) {
			$obj->session->set_userdata("${prefix}_username",  $username);
			$obj->session->set_userdata("${prefix}_password",  $password);
                        
                        $email = load_email();
			$obj->session->set_userdata("${prefix}_email",  $email);
			$is_admin = has_role('admin') || has_role('staff');
			//set_cms_state();
                        
			if ($is_admin) {
                            login_zenphoto_admin();
			} 
		} else {
		}
		return $result;
	}

	function unset_cmsms_login() {
		  $obj =& get_instance();
                $obj->load->config('login_config');
		$username = $obj->config->item('login_cmsms_username');
		$userid = $obj->config->item('login_cmsms_userid');
		$dirname  = $obj->config->item('login_cmsms_root_dir');
		$key = cms_session_teardown($dirname);
		if (isset($_SESSION['cms_admin_username'] ) ) {
			unset ($_SESSION['cms_admin_username'] );
		}
		if (isset($_SESSION['login_user_username'] ) ) {
			unset ($_SESSION['login_user_username'] );
		}
		if (isset($_SESSION['cms_admin_user_id'] ) ) {
			unset ($_SESSION['cms_admin_user_id'] );
		}
		$obj->session->unset_userdata('cmsuserkey');
	}

	function set_cms_state() {
		$obj =& get_instance();
		$obj->load->config('login_config');
		$dirname  = $obj->config->item('login_cmsms_root_dir');
		$key = cms_session_setup($dirname);
	}

	function set_cmsms_login() {
		$obj =& get_instance();
		$obj->load->config('login_config');
		$username = $obj->config->item('login_cmsms_username');
		$userid = $obj->config->item('login_cmsms_userid');
		$dirname  = $obj->config->item('login_cmsms_root_dir');
		$key = cms_session_setup($dirname);
		$_SESSION['cms_admin_username'] = $username;
		$_SESSION['login_user_username'] = $username;
		$_SESSION['cms_admin_user_id'] = $userid;
		$obj->session->set_userdata('cmsuserkey', $key);
	}

	function cms_session_teardown($dirname) {

		$session_key = substr(md5($dirname), 0, 8);

		#Setup session with different id and start it
		@session_name('CMSSESSID' . $session_key);
		@ini_set('url_rewriter.tags', '');
		@ini_set('session.use_trans_sid', 0);
		if(!@session_id())
		{
		    #Trans SID sucks also...
		    @ini_set('url_rewriter.tags', '');
		    @ini_set('session.use_trans_sid', 0);
		    @session_start();
		}
		if( isset($_SESSION['cmsuserkey']) )
		{
			// maybe change this algorithm.
			unset($_SESSION['cmsuserkey'] );
		}
	}
	function cms_session_setup($dirname) {

		$session_key = substr(md5($dirname), 0, 8);

		#Setup session with different id and start it
		@session_name('CMSSESSID' . $session_key);
		@ini_set('url_rewriter.tags', '');
		@ini_set('session.use_trans_sid', 0);
		if(!@session_id())
		{
		    #Trans SID sucks also...
		    @ini_set('url_rewriter.tags', '');
		    @ini_set('session.use_trans_sid', 0);
		    @session_start();
		}
		if( !isset($_SESSION['cmsuserkey']) )
		{
			// maybe change this algorithm.
			$key = substr(str_shuffle(md5($dirname.time().session_id())),-8);
			$_SESSION['cmsuserkey'] = $key;
			return $key;
		}
		return ($_SESSION['cmsuserkey']);
	}

	function get_roles($username) {
            if ($username === 0 || $username === false ) {
                return array();
            }
            $obj =& get_instance();
            $DB = $obj->load->database('coral', true);
            $DB->where('member', $username);
            $DB->where('active', '1');
            $results = $DB->get('rscmgr.lab_role')->result_array();
            $roles = array();
            foreach($results as $row) { $roles[] = $row['role'];
            }
            return $roles;
	}
	function has_role($role) {
		$roles = get_roles(get_username());
		return in_array($role, $roles);
	}
        function load_email() {
            $obj =& get_instance();
            $DB = $obj->load->database('coral', true);
            $DB->where('name', get_username());
            $results = $DB->get('rscmgr.member')->result_array();
            if ($results) {
                return $results[0]['email'];
            }
            return false;
        }
        
        function login_zenphoto_admin() {
            define('WEBPATH', 'gallery');
            require_once(WEBPATH . "/zp-core/template-functions.php");
            require_once(WEBPATH . "/zp-core/admin-globals.php");
            
            global $_zp_loggedin;
            global $_zp_authority;
            $_zp_authority->handleLogon(true);
            $_zp_loggedin = ADMIN_RIGHTS;
            
        }
        function logout_zenphoto_admin() {
            define('WEBPATH', 'gallery');
            require_once(WEBPATH . "/zp-core/template-functions.php");
            require_once(WEBPATH . "/zp-core/admin-globals.php");
            
            global $_zp_loggedin;
            global $_zp_authority;
            $_zp_authority->handleLogout();
            
        }
	function login_url() {
		$forward = uri_safe_encode(uri_string());
		return site_url('fuel/login' . "/$forward") ;
	}
	function login_link() {
		return '<a href="' . login_url() . '" >Login</a>' . "\n";
	}
        

?>

