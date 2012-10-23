<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

require_once('fuel_users_model.php');

class Users_model extends Fuel_users_model {
    
    var $proxy_model;
//    
//    function __construct() {
//        $proxy_model = new Fuel_users_model();
//    }
//
    function valid_coral_user($user, $pwd) {
        $obj =& get_instance();
        $obj->load->helper('login_helper');
        $logged_in = login($user, $pwd);
        if ($logged_in) {
            //check if user exists in fuel
            $fuel_user = $this->find_existing_fuel_user($user);
            if ($fuel_user) {
                $fuel_user['super_admin'] = 'yes';
            }
            
            $fuel_user['active'] = 'yes';
            $fuel_user['user_name'] = get_username();
            $fuel_user['password'] = 'abcdefgabcdefgac891ff546eaeb6e81';
            $fuel_user['email'] = get_email();
            list( $fuel_user['first_name'], $fuel_user['last_name'] ) = get_first_and_last_names();
            $fuel_user['language'] = 'english';
            $fuel_user['reset_key'] = '';
            
            if (has_role('staff')) {

                $fuel_user['super_admin'] = 'yes';

                //if they don't exist in fuel, create them
                $fuel_user['id'] = $this->save($fuel_user);
            } else {
                define('FUELIFY', FALSE);
            }
            return $fuel_user;
        }
        return false;
    }
    function valid_user($user, $pwd) {
        $fuel_user = $this->valid_coral_user($user, $pwd);
        if ($fuel_user) {
            return $fuel_user;
        }

        return parent::valid_user($user, $pwd);
    }
    
    function find_existing_fuel_user($user) {
        $where = array('user_name' => $user, 'active' => 'yes');
        return $this->find_one_array($where);
    }
//
//    function list_items($limit = NULL, $offset = NULL, $col = 'email', $order = 'desc') {
//        return $proxy_model->list_items($limit, $offset, $col, $order);
//    }
//
//    function user_info($user_id) {
//        return $proxy_model->user_info($user_id);
//    }
//
//    function reset_password($email) {
//        return $proxy_model->reset_password($email);
//    }
//
//    function user_exists($email) {
//        return $proxy_model->user_exists($email);
//    }
//
//    function options_list($key = 'id', $val = 'name', $where = array(), $order = 'name') {
//        return $proxy_model->options_list($key, $val, $where, $order);
//    }
//
//    function form_fields($values = null) {
//        return $proxy_model->form_fields($values);
//    }
//
//    function on_before_validate($values) {
//        return $proxy_model->on_before_validate($values);
//    }
//
//    function on_before_clean($values) {
//        return $proxy_model->on_before_clean($values);
//    }
//
//    function on_after_save($values) {
//        return $proxy_model->on_after_save($values);
//    }
//
//    function delete($where) {
//        return $proxy_model->delete($where);
//    }
//
//    function is_new_email($email) {
//        return $proxy_model->is_new_email($email);
//    }
//
//    function is_editable_email($email, $id) {
//        return $proxy_model->is_editable_email($email, $id);
//    }
//
}
