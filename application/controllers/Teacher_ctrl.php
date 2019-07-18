<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_ctrl extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('teacher_model');
    }
    
    private function _ShowMsgs($successfull, $successMsg, $failureMsg){
        if($successfull){
            echo json_encode(array('feedback'=>$successMsg,'feedback_class'=>'alert-success','status'=>200));
        }else{
            echo json_encode(array('feedback'=>$failureMsg,'feedback_class'=>'alert-danger','status'=>500));
        }
    }
    
    public function eidtData(){
        $id = $this->input->post('id');
        $result = $this->db->select('*')->get_where('teacher',array('t_id'=>$id,'status'=>1))->result_array();
        
        $ct_data = $this->db->select('*')->get_where('class_teacher',array('t_id'=>$id,'status'=>1))->result_array();
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'ct_data'=>$ct_data,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function deleteRecord(){
        $delete_id = $this->input->post('delete_id');
        $this->_ShowMsgs(
            $this->teacher_model->deleteRecord($delete_id),"Delete Record Successfully.","Failed Delete Record,Please try again."
            );
    }
    
    public function checkUniqueEmail(){
        $emailId = $this->input->post('emailId');
        $result = $this->db->select('email')->get_where('teacher',array('email'=>$emailId,'status'=>1))->result_array();
        
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('result'=>'email id not found.','status'=>500));
        }
    }
    
    public function submitTeacherData(){
      //  if($this->input->post('class_teacher') == 'yes'){
        //    $this->form_validation->set_rules('medium','medium','required');
          //  $this->form_validation->set_rules('class','class','required');
      //      if($this->input->post('class') >= '14'){
       //         $this->form_validation->set_rules('sub_group','sub_group','required');
      //      }
      //      $this->form_validation->set_rules('section','section','required');
     //   }
        
        //$this->form_validation->set_rules('teacher_name','teacher_name','required');
        //$this->form_validation->set_rules('gender','gender','required');
        //$this->form_validation->set_rules('dob','dob','required');
        //$this->form_validation->set_rules('email','email','required');
        //$this->form_validation->set_rules('prmt_address','prmt_address','required');
        //$this->form_validation->set_rules('alter_address','alter_address','required');
        //$this->form_validation->set_rules('designation','designation','required');
        //$this->form_validation->set_rules('qualifications','qualifications','required');
        
      //  if($this->form_validation->run()){
            
            $ct_id = $this->input->post('ct_id');
            $class_teacher['class_teacher'] = $this->input->post('class_teacher');
            $class_teacher['medium'] = $this->input->post('medium');
            $class_teacher['class'] = $this->input->post('class');
            $class_teacher['section'] = $this->input->post('section');
            
            if(!empty($this->input->post('sub_group'))){
                $class_teacher['sub_group'] = $this->input->post('sub_group');
            }
            
            $tid = $this->input->post('t_id');
            $data['teacher_name'] = $this->input->post('teacher_name');
            $data['gender'] = $this->input->post('gender');
            $data['dob'] = $this->input->post('dob');
            $data['phone'] = $this->input->post('phone');
            $data['email'] = $this->input->post('email');
            $data['prmt_address'] = $this->input->post('prmt_address');
            $data['alter_address'] = $this->input->post('alter_address');
            $data['designation'] = $this->input->post('designation');
            $data['qualifications'] = $this->input->post('qualifications');
            $data['old_image'] = $this->input->post('old_image');
            if($tid != ''){
                $this->_ShowMsgs(
                    $this->teacher_model->submitTeacherData($tid,$data,$ct_id,$class_teacher),"Teacher Update Successfully","Teacher Data Failed to Update, Please try again."
                    );
            }else{
                $this->_ShowMsgs(
                    $this->teacher_model->submitTeacherData($tid,$data,$ct_id,$class_teacher),"Teacher Insert Successfully","Teacher Data Failed to Insert, Please try again."
                    );    
            }
            
       // }else{
        //    echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        //}
        
    }
    
    public function getSubjects(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $medium = $this->input->post('medium');
        $class_name = $this->input->post('class_name');
        $sub_group = $this->input->post('sub_group');
        $sub_type = $this->input->post('sub_type');
        $section = $this->input->post('section');
        
        $this->db->select('st.st_id,sa.sa_id,s.sub_name,st.t_id, st.status');
        $this->db->join('sub_teacher st','st.sa_id = sa.sa_id AND st.sec_id = '.$section.'','LEFT');
        $this->db->join('subject s','s.sub_id=sa.sub_id');
        $this->db->order_by('s.short_order','ASC');
        if(!empty($sub_group)){
            $this->db->where('sa.sg_id',$sub_group);
        }
        $result = $this->db->get_where('subject_allocation sa',array('sa.ses_id'=>$session,'sa.sch_id'=>$school,'sa.med_id'=>$medium,'sa.class_id'=>$class_name,'sa.st_id'=>$sub_type,'sa.status'=>1))->result_array();
        //print_r($this->db->last_query());die;
		
        $teachers = $this->db->select('t_id,teacher_name')->order_by('teacher_name','ASC')->get_where('teacher',array('school_id'=>$school,'status'=>1))->result_array();
        
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'teachers'=>$teachers,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function allocateSubjectTeacher(){
        $data['t_id'] = $this->input->post('t_id');
        $data['sa_id'] = $this->input->post('sa_id');
        $data['sec_id'] = $this->input->post('section');
        $data['created_by'] = $this->session->userdata('user_id');
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->_ShowMsgs(
            $this->teacher_model->allocateSubjectTeacher($data),"teacher allocate subject successfully"," falied to teacher allocate subject, please try again."
            );
    }
    
    public function ListOfSubjectTeacher(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $medium = $this->input->post('medium');
        $class_name = $this->input->post('class_name');
        $sub_group = $this->input->post('sub_group');
        $section = $this->input->post('section');
        
        $condition = '';
        if($session){
            $condition.=' AND sa.ses_id='.$session;
        }
        if($school){
            $condition.=' AND sa.sch_id='.$school;
        }
        if($medium){
            $condition.=' AND sa.med_id='.$medium;
        }
        if($class_name){
            $condition.=' AND sa.class_id='.$class_name;
        }
        if($sub_group){
            $condition.=' AND sa.sg_id='.$sub_group;
        }
        
        if(!empty($sub_group)){
            $this->db->select('sec.section_name,c.class_name,sg.sg_name,sub_t.st_name,sub.sub_name,t1.teacher_name');
        }else{
            $this->db->select('sec.section_name,c.class_name,sub_t.st_name,sub.sub_name,t1.teacher_name');
        }
        $this->db->join('subject_allocation sa','sa.sa_id=st.sa_id AND sa.status = 1');
        $this->db->join('class c','c.c_id = sa.class_id AND c.status = 1');
        $this->db->join('sub_type sub_t','sub_t.st_id=sa.st_id AND sub_t.status = 1');
        $this->db->join('section sec','sec.sec_id = st.sec_id AND sec.status = 1');
        if(!empty($sub_group)){
            $this->db->join('sub_group sg','sg.sg_id=sa.sg_id AND sg.status = 1');
        }
        $this->db->join('subject sub','sub.sub_id = sa.sub_id AND sub.status = 1');
        $this->db->join('teacher t1','t1.t_id=st.t_id AND t1.status = 1','LEFT');
        $this->db->where('1=1 '.$condition);
        $result = $this->db->get_where('sub_teacher st',array('st.status'=>1,'st.sec_id'=>$section))->result_array();
       // print_r($this->db->last_query());die;
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
}