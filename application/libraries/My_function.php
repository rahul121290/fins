<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_function{
    
    protected $CI;
    
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    
    public function check_permission(){
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->load->database();
        $user_id = $CI->session->userdata('user_id');
        
        $CI->db->select('permission');
        $result = $CI->db->get_where('users',array('id'=>$user_id))->result_array();
        if(count($result)>0){
            if($result[0]['permission'] == '0'){
                return 'admin';
            }else if($result[0]['permission'] == '1'){
                return 'teacher';
            }else{
                return 'class_teacher';
            }
        }
    }
 
}
