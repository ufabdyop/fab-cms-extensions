<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

require_once('users_model.php');

class My_users_model {
    
    var $proxy_model;
    
    function __construct() {
        $proxy_model = new Users_model();
    }
    function valid_user($user, $pwd) {
        return $proxy_model->valid_user($user, $pwd);
    }
    function list_items($limit = NULL, $offset = NULL, $col = 'email', $order = 'desc') {
            return $proxy_model->list_items($limit, $offset , $col , $order );
    }
    function user_info($user_id) {
            return $proxy_model->user_info($user_id);
    }
    function reset_password($email) {
            return $proxy_model->reset_password($email);
    }
    function user_exists($email) {
            return $proxy_model->user_exists($email);
    }
    function options_list($key = 'id', $val = 'name', $where = array(), $order = 'name') {
            return $proxy_model->options_list($key , $val , $where , $order );
    }
    function form_fields($values = null) {
            return $proxy_model->form_fields($values );
    }
    function on_before_validate($values) {
            return $proxy_model->on_before_validate($values);
    }
    function on_before_clean($values) {
            return $proxy_model->on_before_clean($values);
    }
    function on_after_save($values) {
            return $proxy_model->on_after_save($values);
    }
    function delete($where) {
            return $proxy_model->delete($where);
    }
    function is_new_email($email) {
            return $proxy_model->is_new_email($email);
    }
    function is_editable_email($email, $id) {
            return $proxy_model->is_editable_email($email, $id);
    }
    
}
