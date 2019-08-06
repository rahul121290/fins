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
    
    public function add_student(){
        $std_id = $this->input->post('std_id');
        $old_image = $this->input->post('old_image');
        
        $data['ses_id'] = $this->input->post('session');
        $data['sch_id'] = $this->input->post('school');
        $data['medium'] = $this->input->post('medium');
        
        $data['fee_criteria'] = $this->input->post('fee_criteria');
        $data['staff_child'] = null;
        if(!empty($data['staff_child'])){
            $data['staff_child'] = $this->input->post('staff_child');
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
         
            $this->db->trans_begin();
            
            $session_id = $data['ses_id'];
            $school_id = $data['sch_id'];
            $class_id = $data['class_id'];
            
            //---------generate hostel fee---------------------------
            $this->db->select('*');
            $this->db->join('hostel h','h.hid = s.hostel_id AND h.status = 1');
            $result = $this->db->get_where('students s',array('s.adm_no'=>$data['adm_no'],'s.ses_id'=>$session_id,'s.sch_id'=>$school_id,'s.class_id'=>$class_id,'s.hostler'=>"Yes",'s.status'=>1))->result_array();
            if(count($result) > 0){
                $final_arr['ses_id'] = $session_id;
                $final_arr['sch_id'] = $school_id;
                $final_arr['adm_no'] = $result[0]['adm_no'];
                $final_arr['hostel_id'] = $result[0]['hid'];
                $final_arr['hostel_id'] = $result[0]['hid'];
                $final_arr['year_amount'] = $result[0]['price'];
                $final_arr['created_at'] = date('Y-m-d H:i:s');
                $final_arr['created_by'] = $this->session->userdata('user_id');
                $insert = $this->db->insert('hostel_fee',$final_arr);
            }
            
            //-----------*****************------------------------------
            
            //----------------generate month fee-----------------------
            
            $this->db->select('s.adm_no,fs.*,IFNULL(b.price,"0") bus_fee,');
            $this->db->join('fees_structure fs','fs.sch_id = s.sch_id AND fs.ses_id = s.ses_id AND fs.class_id = '.$class_id.' AND fs.status = 1');
            $this->db->join('hostel h','h.hid = s.hostel_id AND h.ses_id = '.$session_id.' AND h.sch_id = '.$school_id.' AND h.status = 1','LEFT');
            $this->db->join('bus_structure b','b.bs_id = s.bus_id AND b.school_id = '.$school_id.' AND b.ses_id = '.$session_id.' AND b.status = 1','LEFT');
            $result = $this->db->get_where('students s',array('s.adm_no'=>$data['adm_no'],'s.ses_id'=>$session_id,'s.sch_id'=>$school_id,'s.class_id'=>$class_id,'s.status'=> 1))->result_array();
            $final_array = array();
            $months = $this->db->get_where('month',array('status'=>1))->result_array();
            if(count($months) > 0){
                foreach($months as $month){
                    $temp = array();
                    $temp['ses_id'] = (int)$session_id;
                    $temp['sch_id'] = (int)$school_id;
                    // $temp['std_id'] = (int)$student_fee['std_id'];
                    $temp['adm_no'] = $result[0]['adm_no'];
                    $temp['month_id'] = $month['m_id'];
                    if($temp['month_id'] == $result[0]['admission_month']){
                        $temp['amalgamated_fee'] = $result[0]['amalgam_fee'];
                        $temp['admission_fee'] = $result[0]['admission_fee'];
                    } else {
                        $temp['amalgamated_fee'] = 0;
                        $temp['admission_fee'] = 0;
                    }
                    $temp['tution_fee'] = $result[0]['tuition_fee'];
                    $temp['lab_fee'] = $result[0]['lab_fee'];
                    $temp['bus_fee'] = $result[0]['bus_fee'];
                    $temp['hostel_fee'] = 0;
                    $temp['let_fee'] = 0;
                    $temp['other_fee'] = 0;
                    $temp['exam_fee'] = 0;
                    $temp['library_fee'] = $result[0]['library_fee'];
                    $temp['optional_sub_fee'] = $result[0]['optional_sub_fee'];
                    $temp['previous_balance'] = 0;
                    $temp['fee_waiver_amount'] = 0;
                    $temp['total'] = $temp['amalgamated_fee'] + $temp['admission_fee'] + $temp['tution_fee'] + $temp['lab_fee'] + $temp['bus_fee'] + $temp['hostel_fee'] + $temp['let_fee'] + $temp['other_fee'] + $temp['exam_fee'] + $temp['library_fee'] + $temp['optional_sub_fee'] + $temp['previous_balance'];
                    $temp['created_at'] = date('Y-m-d h:i:s');
                    $final_array[] = $temp;
                }
                //print_r($final_array);die;
                $this->db->insert_batch('student_fee',$final_array);
            }
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                echo json_encode(array('msg'=>'insert failed','status'=>500));
            }
            else{
                $this->db->trans_commit();
                echo json_encode(array('adm_no'=>$data['adm_no'],'msg'=>'insert successfully','status'=>200));
            }
            
        }//end of if result/////////
    }
    
    function admission_fee_details(){
        $ses_id = $this->session->userdata('session_id');
        $sch_id = $this->input->post('sch_id');
        $adm_no = $this->input->post('adm_no');
        $this->db->select('s.ses_id,s.sch_id,s.medium,s.class_id,s.sub_group,s.name,s.f_name,s.gender,s.contact_no,s.sibling,
                            IFNULL(fs.admission_fee,0) admission_fee,
                            IFNULL(fs.amalgam_fee,0) amalgam_fee,
                            IFNULL(fs.tuition_fee,0) tuition_fee,
                            IF(s.sibling = "Yes",IFNULL(fs.sibling_rebate,0),0) sibling_rebate,
                            IFNULL(fs.lab_fee,0) lab_fee,
                            IFNULL(fs.library_fee,0) library_fee,
                            IFNULL(fs.optional_sub_fee,0) optional_sub_fee,
                            IFNULL(h.price,0) hostel_fee,
                            IFNULL(bs.price,0) bus_fee,
                            ((IFNULL(fs.admission_fee,0) + IFNULL(fs.amalgam_fee,0) + IFNULL(fs.tuition_fee,0) + IFNULL(fs.lab_fee,0) + IFNULL(fs.library_fee,0) + IFNULL(fs.optional_sub_fee,0) + IFNULL(h.price,0) + IFNULL(bs.price,0)) - IF(s.sibling = "Yes",IFNULL(fs.sibling_rebate,0),0) ) grand_total
                            ');
        $this->db->join('fees_structure fs','fs.sch_id = s.sch_id AND fs.ses_id = s.ses_id AND fs.med_id = s.medium AND fs.class_id = s.class_id AND fs.status = 1');
        $this->db->join('bus_structure bs','bs.bs_id = s.bus_id AND bs.school_id = s.sch_id AND bs.ses_id = s.ses_id AND s.bus = "Yes" AND bs.status = 1','LEFT');
        $this->db->join('hostel h','h.hid = s.hostel_id AND s.hostler = "Yes" AND h.status = 1','LEFT');
        $result = $this->db->get_where('students s',array('s.status'=>1,'s.ses_id'=>$ses_id,'s.sch_id'=>$sch_id,'s.adm_no'=>$adm_no))->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'record not found.','status'=>500));
        }
    }
    
}