<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	//include('../config.php');
	$config['user_table'] = 'users';
	$config['login_view'] = 'login';
	$config['login_controller'] = 'login';
	$config['login_expiration'] = '60'; //in minutes
	$config['login_prefix'] = 'li'; //used for session data
	$config['login_landing_page'] = '/admin/index.php'; //first page a user goes to after logging in
	$config['login_cmsms_username'] = 'ldapadmin'; //user for cmsms to impersonate after login
	$config['login_cmsms_userid'] = '20'; //user for cmsms to impersonate after login
	//$config['login_cmsms_root_dir'] = $config['root_path'] ;
	$config['admin_login_landing_page'] = ''; //first page a user goes to after logging in
	$config['superadmin_login_landing_page'] = ''; //first page a user goes to after logging in

	$config['forgot_password_view'] = ''; //first page a user goes to after logging in

	$config['forgot_password_from'] = 'noreply@eng.utah.edu'; //first page a user goes to after logging in
	$ldap_options = array();
	$ldap_options['account_suffix'] = "@users.coe.utah.edu";
    
    /**
    * The base dn for your domain
    * 
    * @var string
    */
	$ldap_options['base_dn'] = "DC=users,DC=coe,DC=utah,DC=edu"; 
	
    /**
    * Array of domain controllers. Specifiy multiple controllers if you
    * would like the class to balance the LDAP queries amongst multiple servers
    * 
    * @var array
    */
    $ldap_options['domain_controllers'] = array ("tybee.coe.utah.edu");
	$config['ldap_options'] = $ldap_options;

	



?>


