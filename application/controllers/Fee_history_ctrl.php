<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fee_history_ctrl extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Fee_history_model');
    }
    
    function getFeeHistory(){
        $data['session'] = $this->input->post('session');
        $data['school'] = $this->input->post('school');
        $data['medium'] = $this->input->post('medium');
        $data['class'] = $this->input->post('class');
        $data['adm_no'] = $this->input->post('adm_no');
        $data['from_date'] = $this->input->post('from_date');
        $data['to_date'] = $this->input->post('to_date');
        
        $data['fee_status'] = $this->input->post('fee_status');
        $data['fee_waiver'] = $this->input->post('fee_waiver');
        
        $condition = '';
        if($data['session']){
            $condition.=' s.ses_id = '.$data['session'];
        }
        if($data['school']){
            $condition.=' AND s.sch_id = '.$data['school'];
        }
        if($data['medium']){
            $condition.=' AND s.medium = '.$data['medium'];
        }
        if($data['class']){
            $condition.=' AND s.class_id = '.$data['class'];
        }
        
        if($data['adm_no']){
            $condition.=' AND s.adm_no = '.$data['adm_no'];
        }
        
        if($data['from_date']){
            $condition.=' AND CAST(sf.created_at as DATE) >= "'.$data['from_date'].'"';
        }
        if($data['to_date']){
            $condition.=' AND CAST(sf.created_at as DATE) <= "'.$data['to_date'].'"';
        }
        
        if($data['fee_status'] != ""){
            $condition.=' AND sf.pay_status = '.$data['fee_status'];
        }
        
        if($data['fee_waiver']){
            $condition.=' AND sf.fee_waiver_amount > 0 ';
        }
        
        //---------------total generated fee---------------------------
        $this->db->select('IFNULL( (SUM(sf.total)-SUM(sf.fee_waiver_amount)),"0") total_amount');
        $this->db->join('student_fee sf','sf.adm_no = s.adm_no AND sf.ses_id = '.$data['session'].' AND sf.sch_id = '.$data['school'].' AND sf.status = 1','LEFT');
        $this->db->where($condition);
        $generated_fee = $this->db->get_where('students s',array('s.status'=>1))->result_array();
        
        //----------fee waiver-------------------------
        $this->db->select('IFNULL(SUM(sf.fee_waiver_amount),0) as fee_waiver');
        $this->db->join('student_fee sf','sf.adm_no = s.adm_no AND sf.ses_id = '.$data['session'].' AND sf.sch_id = '.$data['school'].' AND sf.status = 1','LEFT');
        $this->db->where($condition);
        $fee_waiver = $this->db->get_where('students s',array('s.status'=>1))->result_array();
        
        //--------------total collected amount---------------------------
        $this->db->select('IFNULL( (SUM(sf.total)-SUM(sf.fee_waiver_amount)),"0") collected_amount');
        $this->db->join('student_fee sf','sf.adm_no = s.adm_no AND sf.ses_id = '.$data['session'].' AND sf.sch_id = '.$data['school'].' AND sf.status = 1','LEFT');
        $this->db->where($condition);
        $collected_amount = $this->db->get_where('students s',array('s.status'=>1,'sf.pay_status'=>1))->result_array();
        
        //----------student record with fee------------------------------------
        $this->db->select('s.adm_no,s.name,c.class_name,sec.section_name,s.f_name,s.contact_no,IFNULL(sf.fee_waiver_amount,0) as fee_waiver,IFNULL(sf.total,"") as total,IFNULL(sf.pay_status,0) pay_status');
        $this->db->join('student_fee sf','sf.adm_no = s.adm_no AND sf.ses_id = '.$data['session'].' AND sf.sch_id = '.$data['school'].' AND sf.status = 1','LEFT');
        $this->db->join('class c','c.c_id = s.class_id');
        $this->db->join('section sec','sec.sec_id = s.sec_id');
        $this->db->where($condition);
        $result['student_history'] = $this->db->get_where('students s',array('s.status'=>1))->result_array();
        //print_r($this->db->last_query());die;
        //-------------pending fee--------------------------------------
        $result['fee_waiver'] = $fee_waiver[0]['fee_waiver'];
        $result['generated_fee'] = $generated_fee[0]['total_amount'];
        $result['collected_amount'] = $collected_amount[0]['collected_amount'];
        $result['pending_amount'] = $generated_fee[0]['total_amount'] - $collected_amount[0]['collected_amount'];
        //print_r($result);die;
        if(count($result)>0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'record not found.','status'=>500));
        }
    }
    
    function getAllRecords(){
        //---------------total generated fee---------------------------
        $this->db->select('IFNULL( (SUM(total)-SUM(fee_waiver_amount)),"0") total_amount');
        $generated_fee = $this->db->get_where('student_fee',array('status'=>1))->result_array();
        
        //--------------total collected amount---------------------------
        $this->db->select('IFNULL( (SUM(total)-SUM(fee_waiver_amount)),"0") collected_amount');
        $collected_amount = $this->db->get_where('student_fee',array('status'=>1,'pay_status'=>1))->result_array();
        
        //-------------fee waiver-----------------------------------------
        $this->db->select('IFNULL(SUM(fee_waiver_amount),"0") as fee_waiver');
        $fee_waiver = $this->db->get_where('student_fee',array('status'=>1,'pay_status'=>1))->result_array();
        
        //-------------pending fee--------------------------------------
        $result['fee_waiver'] = $fee_waiver[0]['fee_waiver'];
        $result['generated_fee'] = $generated_fee[0]['total_amount'];
        $result['collected_amount'] = $collected_amount[0]['collected_amount'];
        $result['pending_amount'] = $generated_fee[0]['total_amount'] - $collected_amount[0]['collected_amount'];
        
        if(count($result)>0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'record not found.','status'=>500));
        }
    }
    
}