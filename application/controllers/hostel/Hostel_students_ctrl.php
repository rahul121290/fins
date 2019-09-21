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
        $this->db->join('hostel_students hs','hs.adm_no = s.adm_no AND hs.ses_id = s.ses_id AND hs.sch_id = s.sch_id AND hs.med_id = s.medium AND hs.status = 1','LEFT');
        $result = $this->db->get_where('students s',array('s.ses_id'=>$data['session'],'s.sch_id'=>$data['school'],'s.adm_no'=>$data['admission_no'],'s.status'=>1))->result_array();
		//print_r($this->db->last_query());die;
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
            
            $this->db->select('SUM(hostel_amount) hostel_amount');
            $result = $this->db->get_where('hostel_fee_payment',array('ses_id'=>$ses_id,'sch_id'=>$sch_id,'adm_no'=>$adm_no,'status'=>1))->result_array();
            //print_r($this->db->last_query());die;;
            if(count($result) > 0){
                $result[0]['total'] = $student_fee[0]['total'];
                $result[0]['previous_paid'] = $result[0]['hostel_amount'];
                $result[0]['pay_amount'] = $student_fee[0]['total'] - $result[0]['hostel_amount'];
                $result[0]['pending_amount'] = 0.00;
                echo json_encode(array('data'=>$result,'status'=>200));
            }else{
                echo json_encode(array('data'=>$this->lang->line('hostel_record_not_found'),'status'=>500));
            }
        }
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
       
       $data['hostel_amount'] = $this->input->post('pay_amount');
       $data['taxable_amount'] = $this->input->post('taxable_amount');
       $data['cgst'] = $this->input->post('cgst');
       $data['sgst'] = $this->input->post('sgst');
       $data['paid_amount'] = $this->input->post('total_amount');
       
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
           echo json_encode(array('msg'=>$this->lang->line('payment_success'),'receipt_no'=>$data['receipt_no'],'status'=>200));
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
        
        $this->db->trans_begin();
        $this->db->select('hfi_id');
        $check = $this->db->get_where('hostel_fee_installment',array('ses_id'=>$data['ses_id'],'sch_id'=>$data['sch_id'],'adm_no'=>$data['adm_no'],'status'=>1))->result_array();
        if(count($check) > 0){
            //----------update---------------
            $this->db->where('hfi_id',$check[0]['hfi_id']);
            $this->db->update('hostel_fee_installment',$data);
        }else{
            $this->db->insert('hostel_fee_installment',$data);
        }
        
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            echo json_encode(array('msg'=>$this->lang->line('otp_failed'),'status'=>500));
        }
        else
        {
            $this->db->trans_commit();
            $username = $this->session->userdata('username');
            $sms = 'Adm No. '.$data['adm_no'].', Hostel fee installment extension request OTP is '.$data['otp'].' - Sent by '.$username.' on '.date('d-M-Y').'.';
            $mobile = '9131782047';
           $this->my_function->send_sms($mobile,$sms);
            echo json_encode(array('msg'=>$this->lang->line('otp_success'),'status'=>200));
        }
        
    }
    
    function submit_otp(){
        $data['ses_id'] = $this->input->post('ses_id');
        $data['sch_id'] = $this->input->post('sch_id');
        $data['adm_no'] = $this->input->post('adm_no');
        $data['pay_month'] = $this->input->post('pay_month');
        $data['otp'] = $this->input->post('otp');
        
        $this->db->trans_begin();
        $reesult = $this->db->select('hfi_id')->get_where('hostel_fee_installment',array('otp'=>$data['otp'],'ses_id'=>$data['ses_id'],'sch_id'=>$data['sch_id'],'adm_no'=>$data['adm_no'],'installment'=>$data['pay_month'],'status'=>1))->result_array();
        if(count($reesult) > 0){
            $this->db->where('hfi_id',$reesult[0]['hfi_id']);
            $this->db->update('hostel_fee_installment',array('otp'=>null));
            
            $this->db->where(array('ses_id'=>$data['ses_id'],'sch_id'=>$data['sch_id'],'adm_no'=>$data['adm_no'],'status'=>1));
            $this->db->update('hostel_students',array('fee_installment'=>3));
        }else{
            echo json_encode(array('msg'=>$this->lang->line('otp_mismatch'),'status'=>500));
            die;
        }
        
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            echo json_encode(array('msg'=>$this->lang->line('otp_mismatch'),'status'=>500));
        }
        else
        {
            $this->db->trans_commit();
            echo json_encode(array('msg'=>$this->lang->line('otp_submit_successfull'),'status'=>200));
        } 
    }
    
    function studentList(){
        $data['session'] = $this->input->post('session');
        $data['school'] = $this->input->post('school');
        $data['medium'] = $this->input->post('medium');
        $data['class_id'] = $this->input->post('class_id');
        $data['student_status'] = $this->input->post('student_status');
        $data['search_box'] = $this->input->post('search_box');
        
        $condition = 's.status = 1 AND s.hostler = "Yes"';
        if($data['session']){
            $condition .= ' AND s.ses_id = '.$data['session'];
        }
        if($data['school']){
            $condition .= ' AND s.sch_id = '.$data['school'];
        }
        if($data['medium']){
            $condition .= ' AND s.medium = '.$data['medium'];
        }
        if($data['class_id']){
            $condition .= ' AND s.class_id = '.$data['class_id'];
        }
        if($data['student_status']){
            $condition .= ' AND hs.std_status = "'.$data['student_status'].'"';
        }
        if($data['search_box']){
            $condition .= ' AND (s.adm_no = "'.$data['search_box'].'" OR s.name LIKE "'.$data['search_box'].'%")';
        }
        
        $this->db->select('s.ses_id,s.sch_id,s.adm_no,s.name,s.f_name,s.contact_no,IFNULL(hs.f_contact_no,"") f_contact_no,IFNULL(hs.m_contact_no,"") m_contact_no,
                          IF(hs.hs_id IS null,"pending","updated") details_status,hs.std_status,
                          IFNULL(hfs.total,0) hostel_fee,
                          IFNULL((SELECT SUM(paid_amount) FROM hostel_fee_payment WHERE ses_id = s.ses_id AND sch_id = s.sch_id AND adm_no = s.adm_no AND status = 1),0) paid_fee
                        ');
        $this->db->join('hostel_students hs','hs.adm_no = s.adm_no AND hs.ses_id = s.ses_id AND hs.sch_id = s.sch_id AND hs.status = 1','LEFT');
        $this->db->join('hostel_fee_structure hfs','hfs.ses_id = s.ses_id AND hfs.sch_id = s.sch_id AND hfs.student_status = hs.std_status AND hfs.status = 1','LEFT');
        $this->db->where($condition);
        $result = $this->db->get_where('students s')->result_array();
        
        $all_total_fee = 0;
        $all_paid_fee = 0;
        $all_pending_fee = 0;
        
        if(count($result) > 0){
            
            foreach($result as $res){
                $all_total_fee += $res['hostel_fee'];
                $all_paid_fee += $res['paid_fee'];
            }
            $all_pending_fee = $all_total_fee - $all_paid_fee;
            
            echo json_encode(array('data'=>$result,'all_total_fee'=>$all_total_fee,'all_paid_fee'=>$all_paid_fee,'all_pending_fee'=>$all_pending_fee,'status'=>200));
        }else{
            echo json_encode(array('data'=>$this->lang->line('hostel_record_not_found'),'status'=>500));
        }
    }
    
    function studentPrintList(){
        $data['session'] = $this->input->post('session');
        $data['school'] = $this->input->post('school');
        $data['medium'] = $this->input->post('medium');
        $data['class_id'] = $this->input->post('class_id');
        $data['installment'] = $this->input->post('installment');
        $data['pay_status'] = $this->input->post('pay_status');
        $data['search_box'] = $this->input->post('search_box');
        $condition = 's.status = 1';
        if($data['session']){
            $condition .= ' AND s.ses_id = '.$data['session'];
        }
        if($data['school']){
            $condition .= ' AND s.sch_id = '.$data['school'];
        }
        if($data['medium']){
            $condition .= ' AND s.medium = '.$data['medium'];
        }
        if($data['class_id']){
            $condition .= ' AND s.class_id = '.$data['class_id'];
        }
        
        if($data['search_box']){
            $condition .= ' AND (s.adm_no = "'.$data['search_box'].'" OR s.name LIKE "'.$data['search_box'].'%")';
        }
        
        if($data['pay_status'] == 1){
            $condition .= ' AND hfp.hfp_id IS NOT NULL';
        }else if($data['pay_status'] == 0 && $data['pay_status'] != ''){
            $condition .= ' AND hfp.hfp_id IS NULL';
        }
       
        if($data['installment']){
            $condition1 = ' AND hfp.installment = '.$data['installment'];
        }
        
        $this->db->select('s.adm_no,hs.std_status,s.f_name,hs.f_contact_no,s.name,s.contact_no,hfs.total total_fee,sch.school_name,c.class_name,sec.section_name,
                            IFNULL((SELECT SUM(hostel_amount) FROM hostel_fee_payment WHERE ses_id = s.ses_id AND sch_id = s.sch_id AND adm_no = s.adm_no AND installment <= '.$data['installment'].' AND status = 1),0) paid_fee,
                            IFNULL((SELECT SUM(cgst+sgst) FROM hostel_fee_payment WHERE ses_id = s.ses_id AND sch_id = s.sch_id AND adm_no = s.adm_no AND installment <= '.$data['installment'].' AND status = 1),0) paid_gst,
                            IFNULL((SELECT DATE_FORMAT(pay_date,"%d-%M-%Y") FROM hostel_fee_payment WHERE ses_id = s.ses_id AND sch_id = s.sch_id AND adm_no = s.adm_no AND installment <= '.$data['installment'].' AND status = 1 ORDER BY hfp_id DESC LIMIT 1),"-") paid_date,
                            IF(hfp_id is NULL,"Pending","Paid") pay_status,IFNULL(u.username,"-") username');
        $this->db->join('hostel_fee_payment hfp','hfp.adm_no = s.adm_no AND hfp.ses_id = s.ses_id AND hfp.sch_id = s.sch_id '.$condition1.'','LEFT');
        $this->db->join('users u','u.id = hfp.created_by','LEFT');
        $this->db->join('hostel_students hs','hs.adm_no = s.adm_no AND hs.ses_id = s.ses_id AND hs.sch_id = s.sch_id');
        $this->db->join('hostel_fee_structure hfs','hfs.ses_id = hs.ses_id AND hfs.sch_id = hs.sch_id AND hfs.student_status = hs.std_status');
        $this->db->join('school sch','sch.sch_id=s.sch_id');
        $this->db->join('class c','c.c_id = s.class_id');
        $this->db->join('section sec','sec.sec_id = s.sec_id','LEFT');
        $this->db->where($condition);
        if($data['installment'] == 3){
            $this->db->where('hfp.installment',$data['installment']);
        }
        $result = $this->db->get_where('students s')->result_array();
        //print_r($this->db->last_query());die;
        $this->db->select('username');
        $user = $this->db->get_where('users',array('status'=>1,'id'=>$this->session->userdata('user_id')))->result_array();
        
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'username'=>$user[0]['username'],'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found.','status'=>500));
        }
    }
    
    function fee_receipt(){
        $receipt_no = $this->input->post('receipt_no');    
        $this->db->select('*,DATE_FORMAT(hfp.pay_date,"%d-%M-%Y") pay_date,IFNULL(sec.section_name,"") section_name');
        $this->db->join('students s','s.adm_no = hfp.adm_no AND s.ses_id = hfp.ses_id AND s.sch_id = hfp.sch_id AND s.status = 1');
        $this->db->join('school sch','sch.sch_id=s.sch_id');
        $this->db->join('class c','c.c_id = s.class_id');
        $this->db->join('section sec','sec.sec_id = s.sec_id','LEFT');
        $result = $this->db->get_where('hostel_fee_payment hfp',array('hfp.status'=>1,'hfp.receipt_no'=>$receipt_no))->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'record not found.','status'=>500));
        }
    }
    
    function hostel_mis_details(){
        $data['session'] = $this->input->post('session');
        $data['school'] = $this->input->post('school');
        $data['from_date'] = $this->input->post('from_date');
        $data['to_date'] = $this->input->post('to_date');
        
        
        $this->db->select('COUNT(*) total_hostler');
        $this->db->where(array('hs.ses_id'=>$data['session'],'hs.sch_id'=>$data['school']));
        $total_students = $this->db->get_where('hostel_students hs',array('hs.status'=>1))->result_array();
        if(count($total_students) > 0){
            $result['total_students'] = $total_students[0]['total_hostler'];
        }else{
            $result['total_students'] = 0;
        }
        
        $this->db->select('SUM(hfs.total) total_fee');
        $this->db->join('hostel_fee_structure hfs','hfs.ses_id = hs.ses_id AND hfs.sch_id = hs.sch_id AND hfs.student_status = hs.std_status AND hfs.status = 1');
        $this->db->where(array('hs.ses_id'=>$data['session'],'hs.sch_id'=>$data['school']));
        $total_fee = $this->db->get_where('hostel_students hs',array('hs.status'=>1))->result_array();
        if($total_fee[0]['total_fee'] > 0){
            $result['total_fee'] = $total_fee[0]['total_fee'];
        }else{
            $result['total_fee'] = 0;
        }
        
        $this->db->select('SUM(hostel_amount) paid_fee');
        $this->db->where(array('hfp.ses_id'=>$data['session'],'hfp.sch_id'=>$data['school']));
        $total_paid_fee = $this->db->get_where('hostel_fee_payment hfp',array('hfp.status'=>1))->result_array();
        if($total_paid_fee[0]['paid_fee'] > 0){
            $result['total_paid_fee'] = $total_paid_fee[0]['paid_fee'];
        }else{
            $result['total_paid_fee'] = 0;
        }
        
        $this->db->select('SUM(cgst+sgst) paid_gst');
        $this->db->where(array('hfp.ses_id'=>$data['session'],'hfp.sch_id'=>$data['school']));
        $total_paid_fee = $this->db->get_where('hostel_fee_payment hfp',array('hfp.status'=>1))->result_array();
        if($total_paid_fee[0]['paid_gst'] > 0){
            $result['total_paid_gst'] = $total_paid_fee[0]['paid_gst'];
        }else{
            $result['total_paid_gst'] = 0;
        }
        
        
        $this->db->select('SUM(hostel_amount) paid_fee');
        $this->db->where(array('pay_date >= '=>$data['from_date'],'pay_date <='=>$data['to_date']));
        $this->db->where(array('hfp.ses_id'=>$data['session'],'hfp.sch_id'=>$data['school']));
        $paid_fee = $this->db->get_where('hostel_fee_payment hfp',array('hfp.status'=>1))->result_array();
        if($paid_fee[0]['paid_fee'] > 0){
            $result['paid_fee'] = $paid_fee[0]['paid_fee'];
        }else{
            $result['paid_fee'] = 0;
        }
        
        $this->db->select('SUM(cgst+sgst) paid_gst');
        $this->db->where(array('pay_date >= '=>$data['from_date'],'pay_date <='=>$data['to_date']));
        $this->db->where(array('hfp.ses_id'=>$data['session'],'hfp.sch_id'=>$data['school']));
        $paid_fee = $this->db->get_where('hostel_fee_payment hfp',array('hfp.status'=>1))->result_array();
        if($paid_fee[0]['paid_gst'] > 0){
            $result['paid_gst'] = $paid_fee[0]['paid_gst'];
        }else{
            $result['paid_gst'] = 0;
        }
        
        $this->db->select('
                           IFNULL(SUM(IF(hfpm.method_name = "cash",hfpm.amount,0)),0) cash,
                           IFNULL(SUM(IF(hfpm.method_name = "cheque",hfpm.amount,0)),0) cheque,
                           IFNULL(SUM(IF(hfpm.method_name = "dd",hfpm.amount,0)),0) dd,
                           IFNULL(SUM(IF(hfpm.method_name = "pos",IF(hfpm.card_name = "credit_card",hfpm.amount,0),0)),0) credit_card,
                           IFNULL(SUM(IF(hfpm.method_name = "pos",IF(hfpm.card_name = "debit_card",hfpm.amount,0),0)),0) debit_card
        ');
        $this->db->join('hostel_fee_payment hfp','hfp.receipt_no = hfpm.receipt_no');
        $this->db->where(array('pay_date >= '=>$data['from_date'],'pay_date <='=>$data['to_date']));
        $this->db->where(array('hfp.ses_id'=>$data['session'],'hfp.sch_id'=>$data['school']));
        $result['pay_method'] = $this->db->get_where('hfp_method hfpm',array('hfpm.status'=>1))->result_array();
        
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found.','status'=>500));
        }   
    }
    
    
}