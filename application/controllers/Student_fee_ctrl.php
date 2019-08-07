<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_fee_ctrl extends CI_Controller {
    var $permission;
    function __construct(){
        parent :: __construct();
        $this->load->library('My_function');
    }
    
    function studentList(){
        $data['ses_id'] = $this->input->post('session');
        $data['sch_id'] = $this->input->post('school');
        $data['medium'] = $this->input->post('medium');
        $data['class_id'] = $this->input->post('class_name');
        $data['sec_id'] = $this->input->post('section');
        $data['search_data'] = $this->input->post('search_data');
        
        $condition = 's.status = 1';
        if(!empty($data['ses_id'])){
            $condition .= ' AND s.ses_id = '.$data['ses_id']; 
        }
        if(!empty($data['sch_id'])){
            $condition .= ' AND s.sch_id = '.$data['sch_id'];
        }
        if(!empty($data['medium'])){
            $condition .= ' AND s.medium = '.$data['medium'];
        }
        if(!empty($data['class_id'])){
            $condition .= ' AND s.class_id = '.$data['class_id'];
        }
        if(!empty($data['sec_id'])){
            $condition .= ' AND s.sec_id = '.$data['sec_id'];
        }
        if(!empty($data['search_data'])){
            $condition .= ' AND s.adm_no = '.$data['search_data'];
        }
        
        $this->db->select('s.ses_id,s.sch_id,s.medium,s.adm_no,c.class_name,sec.section_name,s.name,s.f_name,IFNULL(sg.sg_name,"") sg_name,s.contact_no');
        $this->db->join('class c','c.c_id=s.class_id AND c.status = 1');
        $this->db->join('section sec','sec.sec_id=s.sec_id','LEFT');
        $this->db->join('medium m','m.med_id=s.medium');
        $this->db->join('sub_group sg','sg.sg_id = s.sub_group','LEFT');
        $this->db->where($condition);
        $result = $this->db->get_where('students s')->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'record not found.','status'=>500));
        }
    }
      
    
    function feeDetailList(){
        $ses_id = $this->input->post('ses_id');
        $sch_id = $this->input->post('sch_id');
        $med_id = $this->input->post('med_id');
        $adm_no = $this->input->post('adm_no');
        
        $this->db->select('s.*,fc.fc_name,bs.bus_stoppage,bs.price bus_fee,c.class_name');
        $this->db->join('class c','c.c_id = s.class_id AND c.status = 1');
        $this->db->join('fee_criteria fc','fc.fc_id = s.fee_criteria AND fc.status = 1');
        $this->db->join('bus_structure bs','bs.bs_id = s.bus_id AND bs.ses_id = s.ses_id AND bs.status = 1','LEFT');
        $this->db->where(array('s.ses_id'=>$ses_id,'s.sch_id'=>$sch_id,'s.medium'=>$med_id,'s.adm_no'=>$adm_no));
        $result['student'] = $this->db->get_where('students s',array('s.status'=>1))->result_array();
        
        if(count($result['student']) > 0){
            $condition = 'fsm.status = 1';
            $condition .=' AND fsm.ses_id = '.$ses_id;
            $condition .=' AND fsm.sch_id = '.$sch_id;
            $condition .=' AND fsm.med_id = '.$med_id;
            $condition .=' AND fsm.class_id = '.$result['student'][0]['class_id'];
            $condition .=' AND cfs.fc_id = '.$result['student'][0]['fee_criteria'];
            
            $this->db->select('ft.ft_id,ft.name,fc.fc_id,fc.fc_name,cfs.amount');
            $this->db->join('fee_structure_master fsm','fsm.fs_id = cfs.fsm_id');
            $this->db->join('fee_criteria fc','fc.fc_id = cfs.fc_id');
            $this->db->join('fee_type ft','ft.ft_id = cfs.ft_id');
            $this->db->where($condition);
            $result['fee_structure'] = $this->db->get_where('class_fee_structure cfs')->result_array();
            
            $this->db->select('*');
            $fee_month = $this->db->get_where('fee_month',array('status'=>1))->result_array();
            $result['fee_month'] = array();
            
            $current_date = date('Y-m-d');
            foreach($fee_month as $month){
                $temp = array();
                $temp['fm_id'] =  $month['fm_id'];
                $temp['name'] =  $month['name'];
                $temp['fee'] =  $result['fee_structure'][4]['amount'] * $month['total_month'];
                $temp['bus_fee'] = $result['student'][0]['bus_fee'] * $month['total_month'];
                $temp['due_date'] = $month['due_date'];
                //--------------get late fee--------------
                $last_date_of_month =  date("Y-m-t", strtotime($month['due_date']));
                $temp['late_fee'] = 0;
                if(strtotime($current_date) > strtotime($last_date_of_month)){
                    $temp['late_fee'] = 200;
                }else if(strtotime($current_date) > strtotime($month['due_date']) ){
                    $datediff = strtotime($current_date) - strtotime($month['due_date']);
                    $datediff =  round($datediff / (60 * 60 * 24));
                    $temp['late_fee'] = 5 * $datediff;
                }
                //--------------**********--------------
                $result['fee_month'][] = $temp;
            }
            
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Student record not found.','status'=>500));
        }
        
    }
    
}