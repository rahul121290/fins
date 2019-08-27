<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class New_admission_ctrl extends CI_Controller {
    var $permission;
    function __construct(){
        parent :: __construct();
        $this->load->library(array('ion_auth','My_function'));
        if ($this->ion_auth->logged_in()){
            $this->permission = $this->my_function->user_permission();
            $this->load->model('Student_model');
        }else{
            redirect('auth/login');
        }
    }
    
    function check_related(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $adm_no = $this->input->post('adm_no');
        
        $this->db->select('s.name,s.f_name,s.adm_no,c.class_name,sec.section_name,sch.school_name');
        $this->db->join('class c','c.c_id = s.class_id');
        $this->db->join('section sec','sec.sec_id = s.sec_id');
        $this->db->join('school sch','sch.sch_id = s.sch_id');
        $result = $this->db->get_where('students s',array('s.status'=>1,'s.adm_no'=>$adm_no,'s.ses_id'=>$session,'s.sch_id'=>$school))->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'record not found','status'=>500));
        }
    }
    
    function student_record(){
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->input->post('school');
        $data['medium'] = $this->input->post('medium');
        $data['class_id'] = $this->input->post('class_id');
        $data['sec_id'] = $this->input->post('section');
        
        $condition = 'status = 1';
        if(!empty($data['ses_id'])){
            $condition .= ' AND ses_id ='.$data['ses_id'];
        }
        if(!empty($data['sch_id'])){
            $condition .= ' AND sch_id ='.$data['sch_id'];
        }
        if(!empty($data['medium'])){
            $condition .= ' AND medium ='.$data['medium'];
        }
        if(!empty($data['class_id'])){
            $condition .= ' AND class_id ='.$data['class_id'];
        }
        if(!empty($data['sec_id'])){
            $condition .= ' AND sec_id ='.$data['sec_id'];
        }
        
        $this->db->select('*');
        $this->db->where($condition);
        $result = $this->db->get_where('students')->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found.','status'=>500));
        }
    }
    
    public function add_student(){
        $std_id = $this->input->post('std_id');
        $old_image = $this->input->post('old_image');
        
        $data['ses_id'] = $this->input->post('session');
        $data['sch_id'] = $this->input->post('school');
        $data['medium'] = $this->input->post('medium');
        
        $data['fee_criteria'] = $this->input->post('fee_criteria');
        $data['staff_child'] = $this->input->post('staff_child');
        if(empty($data['staff_child'])){
            $data['staff_child'] = null;
        }
        
        $data['related_std'] = $this->input->post('related_adm_no');
        if(empty($data['related_std'])){
            $data['related_std'] = null;
        }
        
        $data['adm_no'] = $this->input->post('adm_no');
        $data['roll_no'] = $this->input->post('roll_no');
        $data['name'] = $this->input->post('name');
        
        $data['class_id'] = $this->input->post('class_id');
        $data['sec_id'] = $this->input->post('sec_id');
        $data['fit'] = $this->input->post('fit');
        $data['elective'] = $this->input->post('elective');
        $data['sub_group'] = $this->input->post('sub_group');
        $data['f_name'] = $this->input->post('f_name');
        $data['m_name'] = $this->input->post('m_name');
        $data['dob'] = $this->input->post('dob');
        $data['gender'] = $this->input->post('gender');
        $data['admission_date'] = $this->input->post('admission_date');
        $data['cast'] = $this->input->post('cast');
        $data['blood_group'] = $this->input->post('blood_group');
        $data['aadhar_no'] = $this->input->post('aadhar_no');
        $data['address'] = $this->input->post('address');
        $data['guardian'] = $this->input->post('guardian');
        $data['local_address'] = $this->input->post('local_address');
        $data['contact_no'] = $this->input->post('contact_no');
        $data['email_id'] = $this->input->post('email_id');
        $data['medical'] = $this->input->post('medical');
        $data['height'] = $this->input->post('height');
        $data['weight'] = $this->input->post('weight');
        $data['tc'] = $this->input->post('tc');
        $data['hostel_id'] = $this->input->post('hostel');
        $data['hostler'] = $this->input->post('hostler');
        
        $data['bus_id'] = $this->input->post('bus_stoppage');
        $data['bus'] = $this->input->post('bus');
        
        $data['created_by'] = $this->session->userdata('user_id');
        $data['created_at'] = date('Y-m-d H:i:s');
       // print_r($data);die;
       
        $result = $this->Student_model->add_student($std_id,$old_image,$data);
        
        if($result){
            $mobile = $data['contact_no'];
            $sms = 'Dear Parent, thank you for choosing Shakuntala Vidyalaya for a bright future of your ward. The admission is confirmed.';
            $this->my_function->send_sms($mobile,$sms);
            
            echo json_encode(array('msg'=>'Admission successfully.',
                'ses_id'=>$data['ses_id'],
                'sch_id'=>$data['sch_id'],
                'med_id'=>$data['medium'],
                'adm_no'=>$data['adm_no'],
                'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Admission process failed, Please try again.','status'=>500));
        }
    }
}