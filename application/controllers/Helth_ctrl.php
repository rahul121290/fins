<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Helth_ctrl extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation','session'));
        $this->load->database();
        $this->load->model(array('Admin_model','helth_model'));
    }

    public function select_box_data(){
        $result = $this->helth_model->select_box_data();
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('status'=>500));
        }
    }
    
    public function search_data(){
        $data['school'] = $this->session->userdata('school_id');
        $data['session'] = $this->input->post('session');
        $data['medium'] = $this->input->post('medium');
        $data['class_id'] = $this->input->post('class_id');
        $data['section'] = $this->input->post('section');
        $data['sub_group'] = $this->input->post('sub_group');
        
        $result = $this->helth_model->search_data($data);
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));            
        }else{
            echo json_encode(array('status'=>500));
        }
    }
	
	function health_insert(){
				$data['stu_id'] = $this->input->post('stu_id');
				$data['question_1'] = $this->input->post('question_1');
				$data['question_2'] = $this->input->post('question_2');
				$data['question_3'] = $this->input->post('question_3'); 
				$data['question_4_1'] = $this->input->post('question_4_1');
				$data['question_4_2'] = $this->input->post('question_4_2');
				$data['question_5_1'] = $this->input->post('question_5_1');
				$data['question_5_2'] = $this->input->post('question_5_2');
				$data['question_6_1'] = $this->input->post('question_6_1');
				$data['question_6_2'] = $this->input->post('question_6_2');
				$data['question_7'] = $this->input->post('question_7'); 
				$data['question_8_1'] = $this->input->post('question_8_1'); 
				
				if($this->input->post('question_8_2') != ''){
				    $question_8_2 = $this->input->post('question_8_2');
				    $data['question_8_2'] = implode(', ', $question_8_2); // ------ convert to string-----
				}
				
				$data['question_8_3'] = $this->input->post('question_8_3'); 
				$data['question_9'] = $this->input->post('question_9');  
				$data['question_9_1'] = $this->input->post('question_9_1');
				$data['question_9_2'] = $this->input->post('question_9_2');
				$data['question_9_3'] = $this->input->post('question_9_3');
				$data['question_9_4'] = $this->input->post('question_9_4');
				$data['question_9_5'] = $this->input->post('question_9_5');
				$data['question_10'] = $this->input->post('question_10');
				$data['question_10_1'] = $this->input->post('question_10_1');
				$data['question_10_2'] = $this->input->post('question_10_2');
				$data['question_10_3'] = $this->input->post('question_10_3');
				$data['question_10_4'] = $this->input->post('question_10_4');
				$data['school_id'] = $this->session->userdata('school_id');
				$data['class_id'] = $this->input->post('class');
				$data['section_id'] = $this->input->post('section_id');
				$data['session_id'] = $this->input->post('session_id');
				$data['medium'] = $this->input->post('medium');
				
				$this->db->select('*');
				$result = $this->db->get_where('health_activity',array(
						'stu_id'=>$data['stu_id'],
						'school_id'=>$data['school_id'],
						'session_id'=> $data['session_id'],
						'medium' => $data['medium'],
						'status'=>1
				))->result_array();
				if(count($result)>0){
					$this->db->where(array(
							'stu_id'=>$data['stu_id'],
							'school_id'=>$data['school_id'],
							'session_id'=> $data['session_id'],
							'medium' => $data['medium'])
							);
					$this->db->update('health_activity',$data);
					echo json_encode(array('msg'=>'Update Successfully','status'=>200));
				}
				else{
					$data['created_at'] = date('d-m-y h:i:s');
					$data['created_by'] = $this->session->userdata('user_id');
					
					$this->db->insert('health_activity',$data);
					echo json_encode(array('msg'=>'Insert Successfully','status'=>200));
				}
				
	}
	
	public function health_record_fetch(){
	    $data['school_id'] = (int)$this->session->userdata('school_id');
	    $data['session_id'] = (int)$this->Admin_model->current_session();
	    $data['student_id'] = $this->input->post('student_id');
	    $data['medium'] = $this->input->post('medium');
	    
	    $this->db->select('*');
	    $health_activity = $this->db->get_where('health_activity',array('school_id'=>$data['school_id'],'session_id'=>$data['session_id'],'medium'=>$data['medium'],'stu_id'=>$data['student_id'],'status'=>1))->result_array();
	   
	    if(count($health_activity) > 0){
	        $this->db->select('s.*, sec.name as section_name, cs.name as class_name');
	        $this->db->join('section sec','sec.id=s.section','innor');
	        $this->db->join('class cs','cs.c_id=s.class_id','innor');
	        $sutdent = $this->db->get_where('student s',array('s.s_id'=>$health_activity[0]['stu_id'],'s.status'=>1))->result_array();
	       
	    }
	    
	    if(count($sutdent) > 0){
	        echo json_encode(array('student'=>$sutdent,'health_activity'=>$health_activity,'status'=>200));
	    }else{
	        echo json_encode(array('msg'=>'record not submitted.!','status'=>500));
	    }
	}
	
	public function fetcheditdata(){
	    $data['student_id'] = $this->input->post('student_id');
	    $data['school_id'] = $this->input->post('school_id');
	    $data['session'] = $this->input->post('session');
	    $data['medium'] = $this->input->post('medium');
	    $data['class_id'] = $this->input->post('class_id');
	    
	    $this->db->select('*');
	    $result  = $this->db->get_where('health_activity',array('stu_id'=>$data['student_id'],'school_id'=>$data['school_id'],'session_id'=>$data['session'],'medium'=>$data['medium'],'class_id'=>$data['class_id'],'status'=>1))->result_array();

	    if(count($result) > 0){
	        echo json_encode(array('result'=>$result,'status'=>200));
	    }else{
	        echo json_encode(array('status'=>500));
	    }
	}
	
	
	
    	
    public function editData(){
        $data = array();
        $data['school_id'] = (int)$this->session->userdata('school_id');
        $data['session_id'] = (int)$this->Admin_model->current_session();
        $data['admission_no'] = (int)$this->input->post('admission_no');
        $data['s_id'] = (int)$this->input->post('s_id');
        $data['medium'] = $this->input->post('medium');
        $data['class_id'] = (int)$this->input->post('class_id');
        $data['section'] = (int)$this->input->post('section');
        $data['sub_group'] = $this->input->post('subject_group');

        
        $this->db->select('
                            gt.g_id as g_id,
                            gt.session_id as session_id,
                            gt.school_id as school_id,
                            gt.medium as medium,
                            gt.subject_group as subject_group,
                            gt.student_admission_no as admission_no,
                           	gt.student_student_id as s_id,
                            gt.student_name as name,
                            gt.student_aadhar_card_no as adhar_no,
                            gt.student_dob as dob,
                            gt.student_sex as mft,
                            gt.student_blood_group as blood_group,
                            gt.mother_name as m_name,
                            gt.mother_dob as m_dob,
                            gt.mother_weight as m_weight,
                            gt.mother_height as m_height,
                            gt.mother_blood_group as m_blood_group,
                            gt.mother_aadhar_card_no as m_adhar,
                            gt.father_name as f_name,
                            gt.father_dob as f_dob,
                            gt.father_weight as f_weight,
                            gt.father_height as f_height,
                            gt.father_blood_group as f_blood_group,
                            gt.father_aadhar_card_no as f_adhar,
                            gt.monthly_income as month_income,
                            gt.address as address,
                            gt.phone_no as phone,
                            gt.mobile_no as mobile,
                            gt.children_special_needs as cwsn_specify
                      ');
        if($data['sub_group'] != NULL){
            $this->db->where('gt.subject_group',$data['sub_group']);
        }
        $result = $this->db->get_where('general_table gt', array('gt.session_id'=>$data['session_id'],'gt.school_id'=>$data['school_id'],'gt.student_admission_no'=>$data['admission_no'],'gt.student_student_id'=>$data['s_id'],'gt.status'=>1))->result_array();
        if(count($result) > 0){
            echo json_encode(array('result'=>$result, 'status'=>200));
        } 
        else{
            
            $this->db->select('s.s_id as s_id,
                              s.session as session_id,
                              s.school_id as school_id,
                              s.medium as medium,
                              s.admission_no as admission_no,
                              s.subject_group as subject_group,
                              s.name as name,
                              s.aadhar as adhar_no,
                              s.dob as dob,
                              s.gender as mft,
                              s.blood_group as blood_group,
                              s.mother_name as m_name,
                              s.father_name as f_name,
                              s.address as address,
                              s.contact_no as mobile');
            
            if($data['sub_group'] != NULL){
                $this->db->where('s.subject_group',$data['sub_group']);
            }
            $student_table = $this->db->get_where('student s', array('s.s_id'=>$data['s_id'],'s.session'=>$data['session_id'],'s.school_id'=>$data['school_id'],'s.admission_no'=>$data['admission_no'],'s.status'=>1))->result_array();
            echo json_encode(array('result'=>$student_table,'status'=>200));
        }
    }
    
    public function general_activity(){
        $data = $this->input->post();
        
        if($data['g_id'] != NULL){
           $this->db->where('g_id',$data['g_id']);
            unset($data['g_id']);
           $result = $this->db->update('general_table', $data);
           echo json_encode(array('result'=>$result,'msg'=>'Update Successfully','status'=>200));
        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('user_id');
            $result = $this->db->insert('general_table', $data);
            echo json_encode(array('result'=>$result,'msg'=>'Insert Successfully','status'=>200));
        }
    }
    
    public function print_data(){
        $data = array();
        $data['school_id'] = (int)$this->session->userdata('school_id');
        $data['session_id'] = (int)$this->Admin_model->current_session();
        $data['admission_no'] = (int)$this->input->post('admission_no');
        $data['s_id'] = (int)$this->input->post('s_id');
        $data['medium'] = $this->input->post('medium');
        $data['class_id'] = (int)$this->input->post('class_id');
        $data['section'] = (int)$this->input->post('section');
        $data['sub_group'] = $this->input->post('subject_group');
        
        $this->db->select('
                            gt.g_id as g_id,
                            gt.session_id as session_id,
                            gt.school_id as school_id,
                            gt.medium as medium,
                            gt.subject_group as subject_group,
                            gt.student_admission_no as admission_no,
                           	gt.student_student_id as s_id,
                            gt.student_name as name,
                            gt.student_aadhar_card_no as adhar_no,
                            DATE_FORMAT(gt.student_dob, "%d-%m-%Y") as dob,
                            gt.student_sex as mft,
                            gt.student_blood_group as blood_group,
                            gt.mother_name as m_name,
                            gt.mother_dob as m_dob,
                            gt.mother_weight as m_weight,
                            gt.mother_height as m_height,
                            gt.mother_blood_group as m_blood_group,
                            gt.mother_aadhar_card_no as m_adhar,
                            gt.father_name as f_name,
                            gt.father_dob as f_dob,
                            gt.father_weight as f_weight,
                            gt.father_height as f_height,
                            gt.father_blood_group as f_blood_group,
                            gt.father_aadhar_card_no as f_adhar,
                            gt.monthly_income as month_income,
                            gt.address as address,
                            gt.phone_no as phone,
                            gt.mobile_no as mobile,
                            gt.children_special_needs as cwsn_specify
                      ');
        if($data['sub_group'] != NULL){
            $this->db->where('gt.subject_group',$data['sub_group']);
        }
        $result = $this->db->get_where('general_table gt', array('gt.session_id'=>$data['session_id'],'gt.school_id'=>$data['school_id'],'gt.student_admission_no'=>$data['admission_no'],'gt.student_student_id'=>$data['s_id'],'gt.status'=>1))->result_array();
        if(count($result) > 0){
            echo json_encode(array('result'=>$result, 'status'=>200));
        }else{
            echo json_encode(array('msg'=>'record not submited.!','status'=>500));
        }
    }
       
}//end of class..........



