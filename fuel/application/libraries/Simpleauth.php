<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class Simpleauth {
    var $db;
    var $ci_handle;
    var $prefix;
    var $expiration;
    
    function __construct() {
        $obj =& get_instance();
        $obj->load->library('session');
        $obj->load->config('login_config');
        $this->ci_handle = $obj;
        $this->db = $obj->load->database('coral', true);
        $this->prefix = $obj->config->item('login_prefix'); //prefix for session vars
        $this->expiration = $obj->config->item('login_expiration'); 
    }
	//
	function session_check() {
	    //var_dump($obj->session);
	    
		//either we've received their credentials through a post, or they are already logged in
		if (!$this->is_logged_in()) {
			$this->redirect_to_login();
		}
	}

	//returns true if a user is logged in
	function is_logged_in() {
	
		if ($this->get_username() && ( time() - $this->ci_handle->session->userdata('last_activity') < $this->expiration * 60 ) ) {
			return true;
		}
		return false;
	}
	
	//returns true if the current user is an admin
	function is_admin() {
		return $this->get_status() == 'admin';
	}

	//returns true if the current user is an admin
	function is_superadmin() {
		return $this->get_status() == 'superadmin';
	}

	function get_first_and_last_names() {
		$username = $this->get_username();
		$this->db->where('name', $username);
		$row = $this->db->get('rscmgr.member')->result();
		return array($row[0]->firstname, $row[0]->lastname);
	}
	
	
	//returns the user's admin_status
	function get_status() {
		//TODO: have this check for user status against coral
		return false;
	}

	//redirects to the controller for login
	function redirect_to_login($error_msg = null) {
		$this->ci_handle->load->helper('url');
		if ($this->ci_handle->session->flashdata('redirect')) {
			$this->ci_handle->session->keep_flashdata('redirect');
		} else {
			$this->ci_handle->session->set_flashdata('redirect', $this->ci_handle->uri->uri_string());
		}
		if ($error_msg != null) {
			$this->ci_handle->session->set_flashdata('error_msg', $error_msg);
		}
		
		//only redirect if we are not already at the login page
		if (strcmp('/' . $this->ci_handle->config->item('login_controller'), $this->ci_handle->uri->uri_string()) != 0 ) {
			redirect($this->ci_handle->config->item('login_controller'));
		}
	}

	//return the email address of someone who is logged in
	function get_email() {
		$prefix = $this->prefix;
		return $obj->session->userdata("${prefix}_email");
	}

	//return the username  of someone who is logged in
	function get_username() {
		$prefix = $this->prefix;
		return $obj->session->userdata("${prefix}_username");
	}

	//return the password  of someone who is logged in
	function get_password() {
		$prefix = $this->prefix;
		return $obj->session->userdata("${prefix}_password");
	}

	//log a user out
	function logout() {
		$prefix = $this->prefix;
		$obj->session->unset_userdata("${prefix}_username");
		$obj->session->unset_userdata("${prefix}_password");
	}
	
	//logs a user in using the posted email and password
	function login($username, $password) {
		$prefix = $this->prefix;

		$this->ci_handle->load->library('AdLDAP');
		$result = $this->ci_handle->adldap->authenticate($username, $password);
		if ($result) {
			$this->ci_handle->session->set_userdata("${prefix}_username",  $username);
			$this->ci_handle->session->set_userdata("${prefix}_password",  $password);
                        
                        $email = $this->load_email();
			$this->ci_handle->session->set_userdata("${prefix}_email",  $email);
			$is_admin = $this->has_role('admin') || $this->has_role('staff');
		} else {
		}
		return $result;
	}

	function get_roles($username) {
            if ($username === 0 || $username === false ) {
                return array();
            }
            $this->db->where('member', $username);
            $this->db->where('active', '1');
            $results = $this->db->get('rscmgr.lab_role')->result_array();
            $roles = array();
            foreach($results as $row) { $roles[] = $row['role'];
            }
            return $roles;
	}
	function has_role($role) {
		$roles = $this->get_roles($this->get_username());
		return in_array($role, $roles);
	}
        function load_email() {
            $this->db->where('name', $this->get_username());
            $results = $this->db->get('rscmgr.member')->result_array();
            if ($results) {
                return $results[0]['email'];
            }
            return false;
        }
}
?>

