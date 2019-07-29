<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_fee extends CI_Controller {
    var $permission;
    function __construct(){
        parent :: __construct();
        $this->load->library('My_function');
    }
    
    
    function fee_genrate($medium,$class_id,$fee_month){
        $session_id = $this->session->userdata('session_id');
        $school_id = $this->session->userdata('school_id');
        
        $this->db->select('s.adm_no,fs.*,IFNULL(b.price,"0") bus_fee,');
        $this->db->join('fees_structure fs','fs.sch_id = s.sch_id AND fs.ses_id = s.ses_id AND fs.class_id = '.$class_id.' AND fs.status = 1');
        $this->db->join('hostel h','h.hid = s.hostel_id AND h.ses_id = '.$session_id.' AND h.sch_id = '.$school_id.' AND h.status = 1','LEFT');
        $this->db->join('bus_structure b','b.bs_id = s.bus_id AND b.school_id = '.$school_id.' AND b.ses_id = '.$session_id.' AND b.status = 1','LEFT');
        $result = $this->db->get_where('students s',array('s.ses_id'=>$session_id,'s.sch_id'=>$school_id,'s.class_id'=>$class_id,'s.status'=> 1))->result_array();
        
        $final_array = array();
        foreach($result as $student_fee){
            
            $temp = array();
            $temp['ses_id'] = (int)$session_id;
            $temp['sch_id'] = (int)$school_id;
            // $temp['std_id'] = (int)$student_fee['std_id'];
            $temp['adm_no'] = $student_fee['adm_no'];
            $temp['month_id'] = $fee_month;
            if($temp['month_id'] == $student_fee['admission_month']){
                $temp['amalgamated_fee'] = $student_fee['amalgam_fee'];
                $temp['admission_fee'] = $student_fee['admission_fee'];
            } else {
                $temp['amalgamated_fee'] = 0;
                $temp['admission_fee'] = 0;
            }
            $temp['tution_fee'] = $student_fee['tuition_fee'];
            $temp['lab_fee'] = $student_fee['lab_fee'];
            $temp['bus_fee'] = $student_fee['bus_fee'];
            $temp['hostel_fee'] = 0;
            $temp['let_fee'] = 0;
            $temp['other_fee'] = 0;
            $temp['exam_fee'] = 0;
            $temp['library_fee'] = $student_fee['library_fee'];
            $temp['optional_sub_fee'] = $student_fee['optional_sub_fee'];
            $temp['previous_balance'] = 0;
            $temp['fee_waiver_amount'] = 0;
            $temp['total'] = $temp['amalgamated_fee'] +
            $temp['admission_fee'] +
            $temp['tution_fee'] +
            $temp['lab_fee'] +
            $temp['bus_fee'] +
            $temp['hostel_fee'] +
            $temp['let_fee'] +
            $temp['other_fee'] +
            $temp['exam_fee'] +
            $temp['library_fee'] +
            $temp['optional_sub_fee'] +
            $temp['previous_balance'];
            $temp['created_at'] = date('Y-m-d h:i:s');
            $final_array[] = $temp;
        }
        
        $this->db->insert_batch('student_fee',$final_array);
    }
    
    
    function generate_hostel_fee($class,$month){
        $ses = $this->session->userdata('session_id');
        $sch = $this->session->userdata('school_id');
        
        $this->db->select('*');
        $this->db->join('hostel h','h.hid = s.hostel_id AND h.status = 1');
        $result = $this->db->get_where('students s',array('s.ses_id'=>$ses,'s.sch_id'=>$sch,'s.class_id'=>$class,'s.hostler'=>"Yes",'s.status'=>1))->result_array();
        $final_arr = [];
        if(count($result) > 0){
            foreach($result as $std_details){
                $temp = [];
                $temp['ses_id'] = $ses;
                $temp['sch_id'] = $sch;
                $temp['adm_no'] = $std_details['adm_no'];
                $temp['hostel_id'] = $std_details['hid'];
                $temp['hostel_id'] = $std_details['hid'];
                $temp['year_amount'] = $std_details['price'];
                $temp['created_at'] = date('Y-m-d H:i:s');
                $temp['created_by'] = 1;
                $final_arr[] = $temp;
            }
            $insert = $this->db->insert_batch('hostel_fee',$final_arr);
            if($insert){
                echo "hostel fee generated successfully";
            }else{
                echo "hostel fee generation failed";
            }
        }
    }
    
    
    function getAdmNoRecord(){
        $session = $this->input->post('session');
        $school = $this->input->post('school');
        $month = $this->input->post('month');
        $adm_no = $this->input->post('adm_no');
        
        $this->db->select('s.ses_id,s.sch_id,s.medium,s.class_id,s.sec_id,s.sub_group,s.std_id,s.photo,s.aadhar_no,s.name,s.roll_no,s.adm_no,
                           DATE_FORMAT(s.admission_date, "%d-%M-%Y") as admission_date,
                           s.f_name,s.m_name,
                           DATE_FORMAT(s.dob, "%d-%M-%Y") as dob,
                           s.gender,s.contact_no,s.tc,s.address,
                           c.class_name,
                           sec.section_name,
                           m.med_name,sg.sg_name,s.fit,sb.sub_name,
                           fw.amount,fw.remark,
                           IF(fw.approved IS NULL,"Apply",IF(fw.approved = 1,"approved","applied")) AS fwaiver,sf.pay_status,sf.receipt_no
                        ');
        if($session != 0){
            $this->db->where('s.ses_id',(int)$session);
        }
        if($school != 0){
            $this->db->where('s.sch_id',(int)$school);
        }

        $this->db->join('class c','c.c_id=s.class_id AND c.status = 1');
        $this->db->join('section sec','sec.sec_id=s.sec_id','LEFT');
        $this->db->join('medium m','m.med_id=s.medium');
        $this->db->join('sub_group sg','sg.sg_id = s.sub_group','LEFT');
        $this->db->join('subject sb','sb.sub_id = s.elective','LEFT');
        $this->db->join('fee_waiver fw','fw.admission_no = s.adm_no AND fw.month_id = '.(int)$month.' AND fw.school_id = '.(int)$school.' AND fw.session = '.(int)$session.' AND fw.status = 1','LEFT');
        $this->db->JOIN('student_fee sf','sf.adm_no = s.adm_no AND sf.sch_id = '.(int)$school.' AND sf.ses_id = '.(int)$session.' AND sf.status = 1 AND sf.month_id = '.(int)$month.'','LEFT');
        $result = $this->db->get_where('students s',array('s.status'=>1,'s.adm_no'=>$adm_no))->result_array();
        //print_r($this->db->last_query());die;
        
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'recrod not found.!','status'=>500));
        }
    }
    
    
    public function getStudentData(){
        $session = $this->input->post('session');
        $school = $this->input->post('school');
        $medium = $this->input->post('medium');
        $class = $this->input->post('class');
        $sub_group = $this->input->post('sub_group');
        $section = $this->input->post('section');
        $month = $this->input->post('month');
        
        $condition = '';
        
        if(!empty($session)){
            $condition  .=" AND s.ses_id =".$session;
        }
        if(!empty($school)){
            $condition  .=" AND s.sch_id =".$school;
        }
        if(!empty($medium)){
            $condition  .=" AND s.medium =".$medium;
        }
        if(!empty($class)){
            $condition  .=" AND s.class_id =".$class;
        }
        if(!empty($fit)){
            $condition  .=" AND s.fit ='".$fit."' ";
        }
        if(!empty($sub_group)){
            $condition  .=" AND s.sub_group =".$sub_group;
        }
        if(!empty($section)){
            $condition  .=" AND s.sec_id =".$section;
        }
        
        $this->db->select('s.ses_id,s.sch_id,s.medium,s.class_id,s.sec_id,s.sub_group,s.std_id,s.photo,s.aadhar_no,s.name,s.roll_no,s.adm_no,
                           DATE_FORMAT(s.admission_date, "%d-%M-%Y") as admission_date,
                           s.f_name,s.m_name,
                           DATE_FORMAT(s.dob, "%d-%M-%Y") as dob,
                           s.gender,s.contact_no,s.tc,s.address,
                           c.class_name,
                           sec.section_name,
                           m.med_name,sg.sg_name,s.fit,sb.sub_name,
                           fw.amount,fw.remark,
                           IF(fw.approved IS NULL,"Apply",IF(fw.approved = 1,"approved","applied")) AS fwaiver,
                           sf.pay_status,
                           sf.receipt_no
                        ');
        $this->db->join('class c','c.c_id=s.class_id');
        $this->db->join('section sec','sec.sec_id=s.sec_id');
        $this->db->join('medium m','m.med_id=s.medium');
        $this->db->join('sub_group sg','sg.sg_id = s.sub_group','LEFT');
        $this->db->join('subject sb','sb.sub_id = s.elective','LEFT');
        $this->db->join('fee_waiver fw','fw.admission_no = s.adm_no AND fw.month_id= '.(int)$month.' AND fw.school_id = '.(int)$school.' AND fw.session = '.(int)$session.' AND fw.status = 1','LEFT');
        $this->db->join('student_fee sf','sf.adm_no = s.adm_no AND sf.sch_id ='.$school.' AND sf.ses_id = '.$session.' AND sf.status = 1 AND sf.month_id = '.$month.'');
        $this->db->where('s.status = 1'.$condition);
        $result = $this->db->get_where('students s',array('s.status'=>1))->result_array();
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'recrod not found.!','status'=>500));
        }
    }
    
    function student_fee_detail(){
        $data = array();
        $data['adm_no'] = $this->input->post('adm_no');
        $data['session'] = $this->input->post('session');
        $data['school'] = $this->input->post('school');
        $data['medium'] = $this->input->post('medium');
        $data['class'] = $this->input->post('class_name');
        $data['sub_group'] = $this->input->post('sub_group');
        $data['section'] = $this->input->post('section');
        $data['month'] = $this->input->post('month');
        
        $this->db->select('*');
        $month_list = $this->db->get_where('month',array('status'=>1,'m_id >='=>$data['month']))->result_array();
        
        $this->db->select('s.sibling,s.std_id,s.adm_no,s.roll_no,s.name,s.f_name,s.contact_no,s.email_id,s.aadhar_no,s.photo,c.class_name,sec.section_name as section_name,s.sub_group as subgroup,
                            sf.*,
                            sf.created_at,
                            IFNULL(fw.amount,"") apply_amount,
                            IF(fw.approved = NULL,"",fw.approved) fee_waiver,
                            hf.hf_id,
                            IFNULL(hf.year_amount,"") hostel_fee,
                            IFNULL((SELECT due_amount FROM hostel_fee_status WHERE hf_id = hf.hf_id AND status = 1 ORDER BY hfs_id DESC  LIMIT 1),hf.year_amount) as due_amount,
                            IFNULL((SELECT instalment FROM hostel_fee_status WHERE hf_id = hf.hf_id AND status = 1 ORDER BY hfs_id DESC  LIMIT 1),0) as instalment
                            ');
        $this->db->join('class c',' c.c_id = s.class_id AND c.status = 1');
        $this->db->join('section sec','sec.sec_id = s.sec_id AND sec.status = 1');
        $this->db->join('student_fee sf','sf.adm_no = s.adm_no AND sf.ses_id = '.$data['session'].' AND sf.sch_id = '.$data['school'].' AND sf.status = 1');
        $this->db->join('hostel_fee hf','hf.adm_no = s.adm_no AND hf.ses_id = '.$data['session'].' AND hf.sch_id = '.$data['school'].' AND hf.status = 1','LEFT');
        $this->db->join('fee_waiver fw','fw.admission_no = s.adm_no AND fw.session = '.$data['session'].' AND fw.school_id = '.$data['school'].' AND fw.medium = '.$data['medium'].' AND fw.month_id = '.$data['month'].' AND fw.status = 1','LEFT');
        $result = $this->db->get_where('students s',array('s.status'=>1,'s.ses_id'=>$data['session'],'s.sch_id'=>$data['school'],'s.adm_no'=>$data['adm_no'],'sf.month_id'=>$data['month']))->result_array();
        //print_r($this->db->last_query());die;
        if(count($result)>0){
            $let_fee = 0;
            $fee_generated_date = $result[0]['created_at'];
            $current_date = date('Y-m-d');
            $last_date_of_month =  date("Y-m-t", strtotime($current_date));
            
            //------get current month 15 tarik-------------
            
            $month = date('m');
            $year = date('Y');
            
            $days_15 = $year.'-'.$month.'-'.'15';
            
            if(strtotime($current_date) > strtotime($days_15) ){ // check current date is greater of mid days
                $datediff = strtotime($current_date) - strtotime($days_15);
                $datediff =  round($datediff / (60 * 60 * 24));
                $let_fee = 5 * $datediff;
            }else if(strtotime($current_date) > strtotime($last_date_of_month)){
                $let_fee = 200;
            }
            
            $result[0]['let_fee'] = $let_fee;
            $result[0]['grand_total'] = $let_fee + $result[0]['total'];
            
            //print_r($result);die;
            echo json_encode(array('data'=>$result,'month'=>$month_list,'status'=>200));
        } else {
            echo json_encode(array('msg'=>'fee not generated.','status'=>500));
        }
    }
    
    function apply_fee_waiver(){
        $data = array();
        $data['session'] = (int)$this->input->post('session');
        $data['school_id'] = (int)$this->input->post('school');
        $data['admission_no'] = $this->input->post('adm_no');
        
        $this->db->select('*');
        $studentdetail = $this->db->get_where('students',array(
            'ses_id'=>(int)$data['session'],
            'sch_id' => (int)$data['school_id'],
            'adm_no' => $data['admission_no']
        )
            )->result_array();
            if(count($studentdetail)>0){
                $data['medium'] = (int)$studentdetail[0]['medium'];
                $data['class_id'] = (int)$studentdetail[0]['class_id'];
                $data['section_id'] = (int)$studentdetail[0]['sec_id'];
                if($studentdetail[0]['sub_group'] != ''){
                    $data['sub_group'] = (int)$studentdetail[0]['sub_group'];
                }
                $data['month_id'] = (int)$this->input->post('month');
                $data['amount'] = $this->input->post('amount');
                $data['remark'] = $this->input->post('reason');
                $data['approved'] = 0;
                $data['applied_on'] = date('Y-m-d h:i:s');
                $data['created_by'] = $this->session->userdata('user_id');
                
                if($this->db->insert('fee_waiver',$data)){
                    echo json_encode(array('msg'=>'Applied for fee waiver.','status'=>200));
                } else {
                    echo json_encode(array('status'=>500));
                }
            } else {
                echo json_encode(array('status'=>500));
            }
    }
    
    
    
    function fee_waiver_apply(){
        $data['adm_no'] = $this->input->post('adm_no');
        $data['session'] = $this->input->post('session');
        $data['school'] = $this->input->post('school');
        $data['amount'] = $this->input->post('amount');
        $data['month'] = $this->input->post('month');
        
        $this->db->trans_begin();
        $this->db->select('*');
        $result = $this->db->get_where('students',array(
            'sch_id' => (int)$data['school'],
            'ses_id' => (int)$data['session'],
            'adm_no' => $data['adm_no'],
            'status' => 1))->result_array();
        
        $otp = $this->my_function->generateNumericOTP();
        
        if(count($result)>0){
            $fee_waiver = array();
            $fee_waiver['session'] = $data['session'];
            $fee_waiver['school_id'] = $data['school'];
            $fee_waiver['admission_no'] = $data['adm_no'];
            $fee_waiver['medium'] = $result[0]['medium'];
            $fee_waiver['month_id'] = $data['month'];
            
            $fee_waiver['amount'] = $data['amount'];
            $fee_waiver['otp'] = $otp;
            $fee_waiver['remark'] = 'offline';
            $fee_waiver['applied_on'] = date('Y-m-d h:i:s');
            $fee_waiver['created_by'] = $this->session->userdata('user_id');
            
            $this->db->select('fw_id');
            $preCheck = $this->db->get_where('fee_waiver',array('session'=>$data['session'],'school_id'=>$data['school'],'admission_no'=>$data['adm_no'],'medium'=>$result[0]['medium'],'month_id'=>$data['month']))->result_array();
            if(count($preCheck) > 0 ){
                $this->db->where('fw_id',$preCheck[0]['fw_id']);
                $this->db->update('fee_waiver',$fee_waiver);
            }else{
                $this->db->insert('fee_waiver',$fee_waiver);
            }
        }else{
            echo json_encode(array('msg'=>'student record not found.','status'=>500));
        }
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(array('msg'=>'Apply fee waiver failed, Please try again.','status'=>500));
        }
        else {
            $this->db->trans_commit();
            $mobile = '8817721954';
            $msg = 'Fee waiver request OTP is '.$otp.' for '.$result[0]['name'].', Admn No. '.$data['adm_no'].'. Amt: '.$data['amount'].' - '.$this->session->userdata('username');
            $this->my_function->send_sms($mobile,$msg);
            echo json_encode(array('msg'=>'Apply fee waiver successfully.','status'=>200));
        }
    }
    
    function check_otp(){
        $data = array();
        $data['adm_no'] = $this->input->post('adm_no');
        $data['session'] = $this->input->post('session');
        $data['school'] = $this->input->post('school');
        $data['amount'] = $this->input->post('amount');
        $data['month'] = $this->input->post('month');
        $data['otp'] = $this->input->post('otp');
        
        //--------update------------
        $this->db->select('fw_id');
        $res = $this->db->get_where('fee_waiver',array('session' => (int)$data['session'],'school_id' => (int)$data['school'],'admission_no' => $data['adm_no'],'approved' => 0,'otp' => $data['otp'],'status'=>1))->result_array();
        if(count($res) > 0){
            $this->db->where('fw_id',$res[0]['fw_id']);
            $result =  $this->db->update('fee_waiver',array('otp' => '','approved' => 1,'approved_by' => $this->session->userdata('user_id')));
            if($result){
                echo json_encode(array('msg'=>'otp submit successfully','status'=>200));
            }else{
                echo json_encode(array('msg'=>'otp submit failed, Please try again.','status'=>500));
            }
        }else{
            echo json_encode(array('msg'=>'Wrong OTP','status'=>500));
        }
    }
    
    
    
    function fee_submit(){
        $fee_str = $this->input->post('fs_id');
        $current_month = date('m');
        $month = $this->input->post('month');
        $session = $this->session->userdata('session_id');
        $school_id = $this->session->userdata('school_id');
        $adm_no = $this->input->post('adm_no');
        
        if($this->input->post('pay_method') == 'cheque'){
            $data['pay_type_no'] = $this->input->post('cheque_pay_method1');
            $data['pay_type_date'] = $this->input->post('cheque_pay_method2');
            $data['bank_name'] = $this->input->post('cheque_pay_method3');
        }else if($this->input->post('pay_method') == 'dd'){
            $data['pay_type_no'] = $this->input->post('dd_pay_method1');
            $data['pay_type_date'] = $this->input->post('dd_pay_method2');
            $data['bank_name'] = $this->input->post('dd_pay_method3');
        }
        
        $this->db->trans_begin();
        
        $hfs_id = NULL;
        
        $hf_id = $this->input->post('hf_id');
        
        if(!empty($hf_id)){
            $hostel_fee['hf_id'] = $this->input->post('hf_id');
            $hostel_fee['month_id'] = date('m');
            $hostel_fee['pay_amount'] = $this->input->post('hostel_paid_amount');
            $hostel_fee['due_amount'] = (int)$this->input->post('hostel_due_amount') - (int)$this->input->post('hostel_paid_amount');
            $hostel_fee['instalment'] = (int)$this->input->post('instalment') + 1;
            $hostel_fee['created_at'] = date('Y-m-d H:i:s');
            $hostel_fee['created_by'] = $this->session->userdata('user_id');
            
            $this->db->insert('hostel_fee_status',$hostel_fee);
            
            $hfs_id = $this->db->insert_id();
        }
        
        $this->db->select('MAX(receipt_no) as receipt_no');
        $result = $this->db->get_where('student_fee')->result_array();
        
        $receipt_no = $result[0]['receipt_no'] + 1;
        
        foreach($month as $months){
            if($months <= $current_month){
                $data['receipt_no'] = $receipt_no;
                $data['hfs_id'] = $hfs_id;
                $data['let_fee'] = $this->input->post('let_fee');
                $data['paid_amount'] = $this->input->post('month_fee') + $this->input->post('let_fee');
                $data['updated_by'] = $this->session->userdata('user_id');
                $data['pay_mode'] = 'offline';
                $data['pay_type'] = $this->input->post('pay_method');
                $data['pay_status'] = 1;
                
                $this->db->where(array('ses_id'=>$session,'sch_id'=>$school_id,'adm_no'=>$adm_no,'month_id'=>$months));
                $this->db->update('student_fee',$data);
            }else{
                $data['receipt_no'] = $receipt_no;
                $data['hfs_id'] = NULL;
                $data['let_fee'] = 0;
                $data['paid_amount'] = $this->input->post('month_fee');
                $data['updated_by'] = $this->session->userdata('user_id');
                $data['pay_mode'] = 'offline';
                $data['pay_type'] = $this->input->post('pay_method');
                $data['pay_status'] = 1;
                
                $this->db->where(array('ses_id'=>$session,'sch_id'=>$school_id,'adm_no'=>$adm_no,'month_id'=>$months));
                $this->db->update('student_fee',$data);
            }
        }
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            echo json_encode(array('msg'=>'Payment failed, Please try again.','status'=>500));
        }else{
            $this->db->trans_commit();
            echo json_encode(array('msg'=>'Payment successfully.','receipt_no'=>$receipt_no,'status'=>200));
        }
        
    }
    
}