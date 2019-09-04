<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hostel_students_ctrl extends CI_Controller {
    function __construct(){
        parent :: __construct();
        $this->load->model('hostel/Hostel_students_model','hostel_students_model');
        $this->lang->load('vivaarta_lang', 'english');
        $this->load->library('My_function');
    }
    
    function getStudentDetails(){
        $data['session'] = $this->session->userdata('session_id');
        $data['school'] = $this->input->post('school');
        $data['admission_no'] = $this->input->post('admission_no');
        
        if($data['school'] == 1){
            $school = 'shakuntala';
        }else if($data['school'] == 2){
            $school = 'sharda';
        }else{
            $school = 'shakuntala(cg)';
        }
        $adm_no = $data['admission_no'];
        $path = base_url().'assets/images/'.$school.'/students/';
        
        $this->db->select('*');
        $result = $this->db->get_where('students',array('ses_id'=>$data['session'],'sch_id'=>$data['school'],'adm_no'=>$data['admission_no'],'status'=>1))->result_array();
        if(count($result) > 0){
            
            echo json_encode(array('data'=>$result,'img_path'=>$path,'status'=>200));
        }else{
            echo json_encode(array('msg'=>$this->lang->line('hostel_record_not_found'),'status'=>500));
        }
    }
    
    function addStudentDetails(){
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->input->post('school');
        $data['med_id'] = $this->input->post('medium');
        $data['std_status'] = $this->input->post('std_status');
        $data['hd_id'] = $this->input->post('hostel_name');
        $data['adm_no'] = $this->input->post('adm_no');
        $data['f_contact_no'] = $this->input->post('f_contact_no');
        $data['m_contact_no'] = $this->input->post('m_contact_no');
        $data['guardian_name'] = $this->input->post('guardian_name');
        $data['guardian_add'] = $this->input->post('local_address');
        $data['guardian_pin_code'] = $this->input->post('guardian_pin_code');
        $data['guardian_contact_no'] = $this->input->post('g_contact_no');
        $data['previous_school'] = $this->input->post('preSchool');
        $data['class_passed'] = $this->input->post('preClass');
        $data['per_of_marks'] = $this->input->post('per_of_marks');
        $data['father_acc_no'] = $this->input->post('f_acc_no');
        $data['std_acc_no'] = $this->input->post('std_acc_no');
        $data['cousin'] = $this->input->post('cousin');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $this->session->userdata('user_id');
        
        $old_father_image = $this->input->post('old_father_image');
        $old_mother_image = $this->input->post('old_mother_image');
        $old_gurardian_image = $this->input->post('old_gurardian_image');
        
        if($data['sch_id'] == 1){
            $school = 'shakuntala';
        }else if($data['sch_id'] == 2){
            $school = 'sharda';
        }else{
            $school = 'shakuntala(cg)';
        }
        
        $adm_no = $data['adm_no'];
        
        if(!is_dir('./assets/images/hostel/'.$school.'/'.$adm_no)){
            mkdir('./assets/images/hostel/'.$school.'/'.$adm_no);
        }
        $path = './assets/images/hostel/'.$school.'/'.$adm_no.'/';
        
        //------------------fathers image--------------------
        if(!empty($_FILES['father_image']['name'])){
            //---------uploading process----------------
            $imagename=$_FILES['father_image']['name']; //get file name
            $ext=pathinfo($imagename,PATHINFO_EXTENSION); // get file extention--
            $data['f_image'] = 'f_image.'.$ext; // replace name acording to admission number
            $temp = $_FILES['father_image']['tmp_name'];
            move_uploaded_file($temp,$path.$data['f_image']);
        }
        else{
            $data['f_image'] = $old_father_image;
        }
        
        //------------------mother image--------------------
        if(!empty($_FILES['mother_image']['name'])){
            //---------uploading process----------------
            $imagename=$_FILES['mother_image']['name']; //get file name
            $ext=pathinfo($imagename,PATHINFO_EXTENSION); // get file extention--
            $data['m_image'] = 'm_image.'.$ext; // replace name acording to admission number
            $temp = $_FILES['mother_image']['tmp_name'];
            move_uploaded_file($temp,$path.$data['m_image']);
        }
        else{
            $data['m_image'] = $old_mother_image;
        }
        
        //------------------Gurardian's image--------------------
        if(!empty($_FILES['gurardian_image']['name'])){
            //---------uploading process----------------
            $imagename=$_FILES['gurardian_image']['name']; //get file name
            $ext=pathinfo($imagename,PATHINFO_EXTENSION); // get file extention--
            $data['g_image'] = 'g_image.'.$ext; // replace name acording to admission number
            $temp = $_FILES['gurardian_image']['tmp_name'];
            move_uploaded_file($temp,$path.$data['g_image']);
        }
        else{
            $data['g_image'] = $old_mother_image;
        }
        
        $cousin_details = json_decode($this->input->post('cousin_details'),true);
        
        $final = [];
        foreach($cousin_details as $cousin){
            $temp = [];
            $temp['c_name'] = $cousin[0]['name'];
            $temp['c_father_name'] = $cousin[1]['fname'];
            $temp['class_id'] = $cousin[2]['class_name'];
            $temp['sec_id'] = $cousin[3]['section'];
            $temp['since_session'] = $cousin[4]['since_ses'];
            $temp['created_at'] = date('Y-m-d H:i:s');
            $temp['created_by'] = $this->session->userdata('user_id');
            $final[] = $temp;
        }
        
        $result = $this->hostel_students_model->addStudentDetails($data,$final);
        if($result){
            echo json_encode(array('msg'=>$this->lang->line('add_hostel_student_details'),'ses_id'=>$data['ses_id'],'sch_id'=>$data['sch_id'],'adm_no'=>$data['adm_no'],'status'=>200));
        }else{
            echo json_encode(array('msg'=>$this->lang->line('failed_to_add_hostel_student_details'),'status'=>500));
        }   
    }
    
    function getPaymentAmount(){
        $ses_id = $this->input->post('ses_id');
        $sch_id = $this->input->post('sch_id');
        $adm_no = $this->input->post('adm_no');
        $pay_month = $this->input->post('pay_month');
        
        $this->db->select('*');
        $result = $this->db->get_where('hostel_fee_payment',array('ses_id'=>$ses_id,'sch_id'=>$sch_id,'adm_no'=>$adm_no,'status'=>1,'installment'=>$pay_month))->result_array();
        if(count($result) > 0){
            echo json_encode(array('msg'=>$this->lang->line('already_paid'),'status'=>500));
            die;
        }
        
        if($pay_month == 1){
            $this->db->select('*');
            $this->db->join('hostel_fee_structure hfs','hfs.ses_id = hs.ses_id AND hfs.sch_id = hs.sch_id AND hfs.student_status = hs.std_status AND hfs.status = 1');
            $student_fee = $this->db->get_where('hostel_students hs',array('hs.ses_id'=>$ses_id,'hs.sch_id'=>$sch_id,'hs.adm_no'=>$adm_no,'hs.status'=>1))->result_array();
            if(count($student_fee) > 0){
                $student_fee[0]['pay_amount'] = ($student_fee[0]['total'] / 2);
                $student_fee[0]['previous_paid'] = 0.00;
                $student_fee[0]['pending_amount'] = ($student_fee[0]['total'] - ($student_fee[0]['total'] / 2));
                
                echo json_encode(array('data'=>$student_fee,'status'=>200));
            }else{
                echo json_encode(array('msg'=>'something went wrong.','status'=>500));
            }
        }else{
            $this->db->select('*');
            $this->db->join('hostel_fee_structure hfs','hfs.ses_id = hs.ses_id AND hfs.sch_id = hs.sch_id AND hfs.student_status = hs.std_status AND hfs.status = 1');
            $student_fee = $this->db->get_where('hostel_students hs',array('hs.ses_id'=>$ses_id,'hs.sch_id'=>$sch_id,'hs.adm_no'=>$adm_no,'hs.status'=>1))->result_array();
            
            $this->db->select('*');
            $this->db->order_by('hfp_id','DESC');
            $this->db->limit(1);
            $result = $this->db->get_where('hostel_fee_payment',array('ses_id'=>$ses_id,'sch_id'=>$sch_id,'adm_no'=>$adm_no,'status'=>1))->result_array();
            if(count($result) > 0){
                $result[0]['total'] = $student_fee[0]['total'];
                $result[0]['previous_paid'] = $result[0]['paid_amount'];
                $result[0]['pay_amount'] = $result[0]['pending_amount'];
                $result[0]['pending_amount'] = 0.00;
                echo json_encode(array('data'=>$result,'status'=>200));
            }else{
                echo json_encode(array('data'=>$this->lang->line('hostel_record_not_found'),'status'=>500));
            }
        }
        
//         $this->db->select('*');
//         $this->db->where(array('ses_id'=>$ses_id,'sch_id'=>$sch_id,'adm_no'=>$adm_no,'status'=>1));
//         $this->db->order_by('hfp_id','DESC');
//         $payment_details = $this->db->get_where('hostel_fee_payment')->result_array();
//         if(count($payment_details) > 0){
            
//         }else{
//             $this->data['fee_details']['total_amount'] = $student_fee[0]['total'];
//             $this->data['fee_details']['paid_amount'] = 0;
//             $this->data['fee_details']['pending_amount'] = 0;
//             $this->data['fee_details']['installment'] = 1;
//         }
        
        
    }
    
    function paymentHostelFee(){
       $this->db->select('MAX(receipt_no) receipt_no');
       $receipt_no = $this->db->get_where('hostel_fee_payment')->result_array();
       if(count($receipt_no) > 0 ){
           $data['receipt_no'] = $receipt_no[0]['receipt_no'] + 1;
       }else{
           $data['receipt_no'] = 1;
       }
        
        $data['ses_id'] = $this->input->post('ses_id');
        $data['sch_id'] = $this->input->post('sch_id');
        $data['med_id'] = $this->input->post('medium');
        $data['adm_no'] = $this->input->post('adm_no');
        $data['installment'] = $this->input->post('pay_month');
        $data['paid_amount'] = $this->input->post('pay_amount');
        $data['pending_amount'] = $this->input->post('pending_amount');
        $data['pay_date'] = date('Y-m-d');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $this->session->userdata('user_id');
        
        //------------------*****--------------------------
        $pay_option = $this->input->post('pay_option');
        
        $final = [];
        foreach($pay_option as $pay_opt){
            $temp = [];
            $temp['receipt_no'] = $data['receipt_no'];
            $temp['method_name'] = $pay_opt[0]['pay_method'];
            $temp['amount'] = $pay_opt[1]['amount'];
            $temp['card_name'] = $pay_opt[2]['card'];
            $temp['trans_amount'] = $pay_opt[3]['trns_amount'];
            $temp['method_no'] = $pay_opt[4]['method_no'];
            $temp['method_date'] = $pay_opt[5]['date'];
            $temp['bank_name'] = $pay_opt[6]['bank_name'];
            $temp['created_at'] = date('Y-m-d H:i:s');
            $temp['created_by'] = $this->session->userdata('user_id');
            $final[] = $temp; 
        }
        
        $result = $this->hostel_students_model->paymentHostelFee($data,$final);
        if($result){
            echo json_encode(array('msg'=>$this->lang->line('payment_success'),'status'=>200));
        }else{
            echo json_encode(array('msg'=>$this->lang->line('payment_success_failed'),'status'=>500));
        }
        
    }
    
    function enablePayAmount(){
        $data['installment'] = $this->input->post('pay_month');
        $data['ses_id'] = $this->input->post('ses_id');
        $data['sch_id'] = $this->input->post('sch_id');
        $data['adm_no'] = $this->input->post('adm_no');
        $data['otp'] = $this->my_function->generateNumericOTP();
        $data['appy_date'] = date('Y-m-d');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $this->session->userdata('user_id');
        
        $result = $this->db->insert('hostel_fee_installment',$data);
        
        if($result){
            echo json_encode(array('msg'=>$this->lang->line('otp_success'),'status'=>200));
        }else{
            echo json_encode(array('msg'=>$this->lang->line('otp_failed'),'status'=>500));
        } 
    }
    
}