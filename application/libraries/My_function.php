<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_function{
    
    protected $CI;
    
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    
    public function permission_link(){
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->load->database();
        $user_id = $CI->session->userdata('user_id');
        
        $CI->db->select('g.name');
        $CI->db->join('users u','u.id = ug.user_id');
        $CI->db->join('groups g','g.id = ug.group_id');
        $result = $CI->db->get_where('users_groups ug',array('u.id'=>$user_id))->result_array();
        return $result[0]['name'];
    }
    
    
    public function user_permission(){
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->load->database();
        $user_id = $CI->session->userdata('user_id');
        
        $CI->db->select('permission');
        $result = $CI->db->get_where('users',array('id'=>$user_id))->result_array();
        
        $data = $result[0]['permission'];
        $data = explode(",",$data);
        return $data;
        //return $result;
    }
 
}
