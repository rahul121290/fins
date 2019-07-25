<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helth_model extends CI_Model {
    
    public function select_box_data(){
        $this->db->select('*');
        $data['session']  = $this->db->get_where('session', array('status'=>1))->result_array();
        
        $this->db->select('*');
        $data['class'] = $this->db->get_where('class',array('status'=>1))->result_array();
        
        $this->db->select('*');
        $data['section'] = $this->db->get_where('section', array('status'=>1))->result_array();
        
        return $data;
    }
    
    public function search_data($data){
        $this->db->select('s.*, c.class_name, sec.section_name');
        $this->db->join('class c','c.c_id=s.class_id');
        $this->db->join('section sec','sec.sec_id=s.sec_id');
        if($data['sub_group'] != NULL){
            $this->db->where('s.sub_group',$data['sub_group']);
        }
        $result = $this->db->get_where('students s', array('s.ses_id'=>$data['session'],'s.sch_id'=>$data['school'],'s.class_id'=>$data['class_id'],'s.sec_id'=>$data['section'],'s.medium'=>$data['medium'],'s.status'=>1))->result_array();
        //print_r($this->db->last_query());die;
        return $result;
    }
    
}//end of class..........