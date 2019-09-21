<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_ctrl extends CI_Controller {    
    function __construct(){
        parent :: __construct();
        $this->load->model('attendance_model');
    }
    
    private function _ShowMsgs($successfull, $successMsg, $failureMsg){
        if($successfull){
            echo json_encode(array('feedback'=>$successMsg,'feedback_class'=>'alert-success','status'=>200));
        }else{
            echo json_encode(array('feedback'=>$failureMsg,'feedback_class'=>'alert-danger','status'=>500));
        }
    }
    
    public function listData(){
        $user_id = $this->session->userdata('user_id');
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        
        $this->db->select('ct.med_id,ct.class_id,ct.sec_id,ct.sg_id,t.email');
        $this->db->join('teacher t','t.t_id=ct.t_id');
        $this->db->where('t.email=(SELECT `email` FROM `users` WHERE `id` ='.$user_id.')');
        $teacher = $this->db->get_where('class_teacher ct',array('ct.ses_id'=>$session,'sch_id'=>$school,'ct.status'=>1))->result_array();
        
            $this->db->select('am_id,med_name,class_name,et_name,total_days');
            $this->db->join('medium m ','m.med_id=am.med_id');
            $this->db->join('class c','c.c_id=am.class_id');
            $this->db->join('exam_type et','et.et_id=am.et_id');
            if(count($teacher)>0){
                $result = $this->db->get_where('attendance_master am',array('am.ses_id'=>$session,'am.sch_id'=>$school,'am.med_id'=>$teacher[0]['med_id'],'class_id'=>$teacher[0]['class_id'],'am.status'=>1))->result_array();
            }else{
                $result = $this->db->get_where('attendance_master am',array('am.ses_id'=>$session,'am.sch_id'=>$school,'am.status'=>1))->result_array();
            }
            
        if(count($result)>0){
           echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function deleteRecord(){
        $delete_id = $this->input->post('deleteId');
        $this->_ShowMsgs(
            $this->attendance_model->deleteRecord($delete_id),"Delete Successfully.","Faield to Delete, Please try again."
            );
    }
    
    public function editData(){
        $edit_id = $this->input->post('edit_id');
        $result = $this->db->select('*')->get_where('attendance_master',array('am_id'=>$edit_id,'status'=>1))->result_array();
        if(count($result)>0){
           echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function class_attendance(){
        $data['session'] = $this->session->userdata('session_id');
        $data['school'] = $this->session->userdata('school_id');
        
        $id = $this->input->post('id');
        $data['medium'] = $this->input->post('medium');
        $data['exam_type'] = $this->input->post('exam_type');
        $data['class_name'] = $this->input->post('class_name');
        $data['class_attendace'] = $this->input->post('class_attendace');
        
        if(empty($id)){
            $this->_ShowMsgs(
                $this->attendance_model->class_attendance($data),"Attendance record added!","Failed to Insert, Please try again."
                );
        }else{
            $this->_ShowMsgs(
                $this->attendance_model->updateAttendance($id,$data),"Attendance record updated!","Failed to Update,Please try again."
                );
        }
    }
    
    public function getExamType(){
        $medium = $this->input->post('medium');
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $result = $this->db->select('et_id,et_name')->get_where('exam_type',array('ses_id'=>$session,'status'=>1))->result_array();
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function getPresentDays() {
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $medium = $this->input->post('medium');
        $exam_type = $this->input->post('exam_type');
        $class_name = $this->input->post('class_name');
        $sub_group = $this->input->post('sub_group');
        $result=  $this->db->select('am_id,total_days')->get_where('attendance_master',array('ses_id'=>$session,'sch_id'=>$school,'med_id'=>$medium,'class_id'=>$class_name,'et_id'=>$exam_type,'status'=>1))->result_array();
        
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function StudentRecords(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $medium = $this->input->post('medium');
        $exam_type = $this->input->post('exam_type');
        $class_name = $this->input->post('class_name');
        $section = $this->input->post('section');
        $sub_group = $this->input->post('sub_group');
        
        if($sub_group){
            $sg_con = ' AND sg_id ='.$sub_group;
        }else{
            $sg_con = '';
        }
        
        
        $this->db->select('s.std_id,s.adm_no,s.roll_no,s.name,IFNULL(sa.present_days,"") as present_days,IFNULL(sa.absent_days,"") as absent_days');
        $this->db->join('std_attendance sa','s.std_id=sa.std_id AND sa.am_id = (Select am_id FROM attendance_master WHERE ses_id = '.$session.' AND sch_id = '.$school.' AND med_id = '.$medium.' AND class_id = '.$class_name.' AND et_id = '.$exam_type.' AND status = 1)','left');
        if(!empty($sub_group)){
            $this->db->where('sub_group',$sub_group);
        }
        $result  = $this->db->get_where('students s',array('s.ses_id'=>$session,'s.sch_id'=>$school,'s.medium'=>$medium,'class_id'=>$class_name,'sec_id'=>$section,'s.status'=>1))->result_array();
        //print_r($this->db->last_query());die;
        $attendance =  $this->db->select('am_id,total_days')->get_where('attendance_master',array('ses_id'=>$session,'sch_id'=>$school,'med_id'=>$medium,'class_id'=>$class_name,'et_id'=>$exam_type,'status'=>1))->result_array();
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'class_attendance'=>$attendance,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    
    public function submitAttendance(){
        $data['std_id'] = $this->input->post('id');
        $data['adm_no'] = $this->input->post('adm_no');
        $data['roll_no'] = $this->input->post('roll_no');
        $data['total_days'] = $this->input->post('total_days');
        $data['attendance'] = $this->input->post('attendance');
        $data['am_id'] = $this->input->post('am_id');
        $data['created_by'] = $this->session->userdata('user_id');
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->_ShowMsgs(
            $this->attendance_model->submitAttendance($data),"Submit Successfully","Failed to submit,Please try again."
            );
    }
    
    
}