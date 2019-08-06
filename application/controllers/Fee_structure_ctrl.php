<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fee_structure_ctrl extends CI_Controller {
    var $permission;
    function __construct(){
        parent :: __construct();
        $this->load->model('Fee_structure_model');
    }
    
    function feeList(){
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->input->post('sch_id');
        $data['med_id'] = $this->input->post('med_id');
        $data['class_id'] = $this->input->post('class_id');
        
        $this->db->select('ft.ft_id,name,
            MAX(IF(fc_id = 1, amount, "")) as general,
            MAX(IF(fc_id = 2, amount, "")) as sibling,
            MAX(IF(fc_id = 3, amount, "")) as rte,
            MAX(IF(fc_id = 4 AND staff_child = 1, amount, "")) as new_staff_first_child,
            MAX(IF(fc_id = 4 AND staff_child = 2, amount, "")) as new_staff_second_child,
            MAX(IF(fc_id = 5 AND staff_child = 1, amount, "")) as old_staff_first_child,
            MAX(IF(fc_id = 5 AND staff_child = 2, amount, "")) as old_staff_second_child
        ');
        $this->db->join('class_fee_structure cfs','cfs.ft_id = ft.ft_id AND cfs.fsm_id = (SELECT fs_id FROM fee_structure_master WHERE ses_id = '.$data['ses_id'].' AND sch_id = '.$data['sch_id'].' AND med_id = '.$data['med_id'].' AND class_id = '.$data['class_id'].' AND status = 1 ORDER BY fs_id DESC LIMIT 1)','LEFT');
        $this->db->group_by('ft.ft_id');
        $result = $this->db->get_where('fee_type ft',array('ft.status'=>1))->result_array();
       // print_r($this->db->last_query());die;
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'record not found.','status'=>500));
        }
    }
    
    function submit_fee(){
        $master['ses_id'] = $this->session->userdata('session_id');
        $master['sch_id'] = $this->input->post('sch_id');
        $master['med_id'] = $this->input->post('med_id');
        $master['class_id'] = $this->input->post('class_id');
        
        $data['general'] = $this->input->post('general');
        $data['sibling'] = $this->input->post('sibling');
        $data['rte'] = $this->input->post('rte');
        $data['new_staff_first_child'] = $this->input->post('new_staff_first_child');
        $data['new_staff_second_child'] = $this->input->post('new_staff_second_child');
        $data['old_staff_first_child'] = $this->input->post('old_staff_first_child');
        $data['old_staff_second_child'] = $this->input->post('old_staff_second_child');
        
        $final = array();
        foreach($data['general'] as $general){
            $temp  = array();
            $temp['ft_id'] = $general[0]['ft_id'];
            $temp['fc_id'] = '1';
            $temp['staff_child'] = null;
            $temp['amount'] = $general[1]['amount'];
            $final[] = $temp;
        }
        
        foreach($data['sibling'] as $sibling){
            $temp  = array();
            $temp['ft_id'] = $sibling[0]['ft_id'];
            $temp['fc_id'] = '2';
            $temp['staff_child'] = null;
            $temp['amount'] = $sibling[1]['amount'];
            $final[] = $temp;
        }
        foreach($data['rte'] as $rte){
            $temp  = array();
            $temp['ft_id'] = $rte[0]['ft_id'];
            $temp['fc_id'] = '3';
            $temp['staff_child'] = null;
            $temp['amount'] = $rte[1]['amount'];
            $final[] = $temp;
        }
        foreach($data['new_staff_first_child'] as $new_staff_first_child){
            $temp  = array();
            $temp['ft_id'] = $new_staff_first_child[0]['ft_id'];
            $temp['fc_id'] = '4';
            $temp['staff_child'] = 1;
            $temp['amount'] = $new_staff_first_child[1]['amount'];
            $final[] = $temp;
        }
        foreach($data['new_staff_second_child'] as $new_staff_second_child){
            $temp  = array();
            $temp['ft_id'] = $new_staff_second_child[0]['ft_id'];
            $temp['fc_id'] = '4';
            $temp['staff_child'] = 2;
            $temp['amount'] = $new_staff_second_child[1]['amount'];
            $final[] = $temp;
        }
        
        foreach($data['old_staff_first_child'] as $old_staff_first_child){
            $temp  = array();
            $temp['ft_id'] = $old_staff_first_child[0]['ft_id'];
            $temp['fc_id'] = '5';
            $temp['staff_child'] = 1;
            $temp['amount'] = $old_staff_first_child[1]['amount'];
            $final[] = $temp;
        }
        
        foreach($data['old_staff_second_child'] as $old_staff_second_child){
            $temp  = array();
            $temp['ft_id'] = $old_staff_second_child[0]['ft_id'];
            $temp['fc_id'] = '5';
            $temp['staff_child'] = 2;
            $temp['amount'] = $old_staff_second_child[1]['amount'];
            $final[] = $temp;
        }
        
        $result = $this->Fee_structure_model->submit_fee($master,$final);
        if($result){
            echo json_encode(array('msg'=>'submit successfully','status'=>200));
        }else{
            echo json_encode(array('msg'=>'submit failed,please try again.','status'=>500));
        }
    }
    
}