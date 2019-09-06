<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_fee_ctrl extends CI_Controller {
    function __construct(){
        parent :: __construct();
        $this->load->library('My_function');
        $this->load->model('Student_fee_model');
    }
    
    
    function related_std_details(){
        $adm_no = $this->input->post('adm_no');
        $this->db->select('s.*,c.class_name,sec.section_name,IFNULL(sg.sg_name,"") sg_name');
        $this->db->join('fee_criteria fc','fc.fc_id = s.fee_criteria');
        $this->db->join('class c','c.c_id = s.class_id');
        $this->db->join('section sec','sec.sec_id = s.sec_id');
        $this->db->join('sub_group sg','sg.sg_id = s.sub_group','LEFT');
        $this->db->order_by('s.adm_no');
        $result = $this->db->get_where('students s',array('s.status'=>1,'s.adm_no'=>$adm_no))->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'record not found.','status'=>500));
        }
    }
    
    
    function update_records(){
        $std_id = $this->input->post('std_id');
        $data['std_status'] = $this->input->post('admission_status');
        $data['fee_criteria'] = $this->input->post('fee_criteria');
        $data['staff_child'] = $this->input->post('staff_child');
        if(empty($data['staff_child'])){
            $data['staff_child'] = null;
        }
        $data['related_std'] = $this->input->post('related_std');
        $data['related_std_board'] = $this->input->post('related_std_board');
        if(empty($data['related_std_board'])){
            $data['related_std_board'] = null;
        }
        if(empty($data['related_std'])){
            $data['related_std'] = null;
        }
        $data['class_id'] = $this->input->post('class_id');
        $data['sec_id'] = $this->input->post('section');
        $data['hostler'] = $this->input->post('hostler');
        $data['bus'] = $this->input->post('bus');
        $data['bus_id'] = $this->input->post('bus_stoppage');
        
        $this->db->where('std_id',$std_id);
        $result = $this->db->update('students',$data);
        
        //-----------log report---------------
        $event = 'Update Student';
        $user = $this->session->userdata('user_id');
        $table_name = 'students';
        $table_id = $std_id;
        $this->my_function->add_log($user,$event,$table_name,$table_id);
        
        if($result){
            echo json_encode(array('msg'=>'Update successfull.','status'=>200));
        }else{
            echo json_encode(array('msg'=>'Update failed, Please try again.','status'=>500));
        }
    }
    
    function recordList(){
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->input->post('school');
        $data['medium'] = $this->input->post('medium');
        $data['class_id'] = $this->input->post('class_name');
        $data['sec_id'] = $this->input->post('section');
        $data['search_data'] = $this->input->post('search_box');
        
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
            $condition .= ' AND (s.adm_no = "'.$data['search_data'].'" OR s.name LIKE "'.$data['search_data'].'%")';
        }
        
        $this->db->select('s.*,IFNULL(sf.name,"") staff_child,fc.fc_name fee_criteria,c.class_name,sec.section_name,IFNULL(sg.sg_name,"-") sg_name,IFNULL(bs.bus_stoppage,"-") bus_stoppage');
        $this->db->join('fee_criteria fc','fc.fc_id = s.fee_criteria');
        $this->db->join('class c','c.c_id = s.class_id');
        $this->db->join('section sec','sec.sec_id = s.sec_id');
        $this->db->join('sub_group sg','sg.sg_id = s.sub_group','LEFT');
        $this->db->join('bus_structure bs','bs.bs_id = s.bus_id','LEFT');
        $this->db->join('staff_child sf','sf.sc_id = s.staff_child','LEFT');
        $this->db->where($condition);
        $this->db->order_by('s.adm_no');
        $result = $this->db->get_where('students s')->result_array();
        
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'record not found.','status'=>500));
        }
    }
    
    function studentEditRecord(){
        $std_id = $this->input->get('std_id');
        
        $this->db->select('*');
        $result = $this->db->get_where('students s',array('status'=>1,'std_id'=>$std_id))->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'record not found.','status'=>500));
        }
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
            $condition .= ' AND (s.adm_no = "'.$data['search_data'].'" OR s.name LIKE "%'.$data['search_data'].'%")';
        }
        
        $this->db->select('fc.fc_name,s.ses_id,s.sch_id,s.medium,s.adm_no,c.class_name,sec.section_name,s.name,s.f_name,IFNULL(sg.sg_name,"") sg_name,s.contact_no');
        $this->db->join('class c','c.c_id=s.class_id AND c.status = 1');
        $this->db->join('section sec','sec.sec_id=s.sec_id','LEFT');
        $this->db->join('medium m','m.med_id=s.medium');
        $this->db->join('sub_group sg','sg.sg_id = s.sub_group','LEFT');
        $this->db->join('fee_criteria fc','fc.fc_id = s.fee_criteria');
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
        
        $this->db->select('s.*,IFNULL(s.bus_id,"") bus_id,s.staff_child staff_child_id,m.med_name,fc.fc_name,bs.bus_stoppage,bs.price bus_fee,c.class_name,IFNULL(sc.name,"") staff_child');
        $this->db->join('class c','c.c_id = s.class_id AND c.status = 1');
        $this->db->join('fee_criteria fc','fc.fc_id = s.fee_criteria AND fc.status = 1');
        $this->db->join('staff_child sc','sc.sc_id = s.staff_child','LEFT');
        $this->db->join('medium m','m.med_id = s.medium');
        $this->db->join('bus_structure bs','bs.bs_id = s.bus_id AND bs.ses_id = s.ses_id AND bs.status = 1','LEFT');
        $this->db->where(array('s.ses_id'=>$ses_id,'s.sch_id'=>$sch_id,'s.medium'=>$med_id,'s.adm_no'=>$adm_no));
        $result['student'] = $this->db->get_where('students s',array('s.status'=>1))->result_array();
        //print_r($this->db->last_query());die;
        if(count($result['student']) > 0){
            $condition = 'fsm.status = 1';
            $condition .=' AND fsm.ses_id = '.$ses_id;
            $condition .=' AND fsm.sch_id = '.$sch_id;
            $condition .=' AND fsm.med_id = '.$med_id;
            $condition .=' AND fsm.class_id = '.$result['student'][0]['class_id'];
            $condition .=' AND cfs.fc_id = '.$result['student'][0]['fee_criteria'];
            if(!empty($result['student'][0]['staff_child_id'])){
                $condition .=' AND cfs.staff_child = '.$result['student'][0]['staff_child_id'];
            }
            $session_fee = '0';
            $month_fee = '0';
            $this->db->select('GROUP_CONCAT(session_fee_ids) as session_fee, GROUP_CONCAT(month_ids) as month_fee');
            $ckeck_paid_fee = $this->db->get_where('student_fee',array('status'=>1,'ses_id'=>$ses_id,'sch_id'=>$sch_id,'med_id'=>$med_id,'adm_no'=>$adm_no))->result_array();
            
            if(count($ckeck_paid_fee) > 0){
                if($ckeck_paid_fee[0]['session_fee'] != null){
                    $session_fee = $ckeck_paid_fee[0]['session_fee'];
                }
                if($ckeck_paid_fee[0]['month_fee'] != null){
                    $month_fee = $ckeck_paid_fee[0]['month_fee'];
                }
            }
            
            $this->db->select('ft.ft_id,ft.name,fc.fc_id,fc.fc_name,cfs.amount,IF(t1.name IS NULL,"Pending","Paid") fee_status');
            $this->db->join('fee_structure_master fsm','fsm.fs_id = cfs.fsm_id');
            $this->db->join('fee_criteria fc','fc.fc_id = cfs.fc_id');
            $this->db->join('fee_type ft','ft.ft_id = cfs.ft_id');
            $this->db->join('(SELECT * FROM fee_type WHERE ft_id IN ('.$session_fee.')) t1','t1.ft_id = ft.ft_id','LEFT');
            $this->db->where($condition);
            if($result['student'][0]['std_status'] == 'old_student'){ //----old student not show admission fee----
                $this->db->where('ft.ft_id <> 1');
            }
            if($result['student'][0]['class_id'] < 12){ //---nursury to class VIII not show lab fee and option sub fee----
                $this->db->where('ft.ft_id NOT IN (3,4)');
            }
            $this->db->where('ft.ft_id <> 5'); //---tution fee always not including in seesion fee-----------
            $result['session_fee'] = $this->db->get_where('class_fee_structure cfs')->result_array();
            //print_r($this->db->last_query());die;
            
            $this->db->select('fm.*,DATE_FORMAT(fm.due_date,"%d-%m-%Y") as show_due_date,t1.amount tution_fee');
            $this->db->join('(SELECT fsm.ses_id,cfs.amount,cfs.staff_child
                             FROM class_fee_structure cfs
                             JOIN fee_structure_master fsm ON fsm.fs_id = cfs.fsm_id
                             WHERE fsm.status = 1 AND fsm.ses_id = '.$ses_id.' AND fsm.sch_id = '.$sch_id.' AND fsm.med_id = '.$med_id.' AND fsm.class_id = '.$result['student'][0]['class_id'].' AND cfs.fc_id = '.$result['student'][0]['fee_criteria'].'
                             AND cfs.ft_id = 5) t1','t1.ses_id = fm.ses_id',false);
            $this->db->where('fm_id NOT IN ('.$month_fee.')');
            if(!empty($result['student'][0]['staff_child_id'])){
                $this->db->where('t1.staff_child',$result['student'][0]['staff_child_id']);
            }
            
            $current_month = (int)date('m');
            if($current_month == 4 || $current_month == 5){
                $fee_month_id = 1;
            }else if($current_month == 6){
                $fee_month_id = 2;
            }else if($current_month == 7){
                $fee_month_id = 3;
            }else if($current_month == 8){
                $fee_month_id = 4;
            }else if($current_month == 9 || $current_month == 10){
                $fee_month_id = 5;
            }else if($current_month == 11){
                $fee_month_id = 6;
            }else if($current_month == 12){
                $fee_month_id = 7;
            }else if($current_month == 1){
                $fee_month_id = 8;
            }else if($current_month == 2 || $current_month == 3){
                $fee_month_id = 9;
            }
            
            //$fee_month = $this->db->get_where('fee_month fm',array('fm.status'=>1,'fm_id <='=>$fee_month_id))->result_array();
            
            $fee_month = $this->db->get_where('fee_month fm',array('fm.status'=>1))->result_array();
            
            $result['fee_month'] = array();
            if(count($fee_month) > 0){
                $current_date = date('Y-m-d');
                foreach($fee_month as $month){
                    if($month['tution_fee'] > 0 ||  $result['student'][0]['bus_fee'] > 0){
                        $temp = array();
                        $temp['fm_id'] =  $month['fm_id'];
                        $temp['name'] =  $month['name'];
                        $temp['fee'] =  $month['tution_fee'] * $month['total_month'];
                        $temp['due_date'] = $month['show_due_date'];
                        //------------class 10th and class 12 not march bus fee not include-------------
                        if(($result['student'][0]['class_id'] == 13 && $month['fm_id'] == 9) || ($result['student'][0]['class_id'] == 15 && $month['fm_id'] == 9)){
                            $temp['bus_fee'] = $result['student'][0]['bus_fee'] * 1;
                        }else{
                            $temp['bus_fee'] = $result['student'][0]['bus_fee'] * $month['bus_month'];
                        }
                        
                        //--------------get late fee--------------
                        $last_date_of_month =  date("Y-m-t", strtotime($month['due_date']));
                        $temp['late_fee'] = 0;
                        if($temp['fee'] > 0){
                            if(strtotime($current_date) > strtotime($last_date_of_month)){
                                $temp['late_fee'] = 200;
                            }else if(strtotime($current_date) > strtotime($month['due_date']) ){
                                $datediff = strtotime($current_date) - strtotime($month['due_date']);
                                $datediff =  round($datediff / (60 * 60 * 24));
                                $temp['late_fee'] = 5 * $datediff;
                            }
                        }
                        $result['fee_month'][] = $temp;
                    }
                    //--------------**********--------------
                    
                }
            }
            
            //-------------fee waiver-----------------------------
            $this->db->select('*');
            $this->db->where(array('ses_id'=>$ses_id,'sch_id'=>$sch_id,'med_id'=>$med_id,'month_id'=>date('m'),'adm_no'=>$adm_no));
            $result['fee_waiver'] = $this->db->get_where('fee_waiver',array('status'=>1))->result_array();
            
            echo json_encode(array('data'=>$result,'fee_month'=>$fee_month_id,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Student record not found.','status'=>500));
        }
    }
    
    function fee_waiver_apply(){
        $data['ses_id'] = $this->input->post('ses_id');
        $data['sch_id'] = $this->input->post('sch_id');
        $data['med_id'] = $this->input->post('med_id');
        $data['adm_no'] = $this->input->post('adm_no');
        $data['month_id'] = $this->input->post('month_id');
        $amount = $this->input->post('amount');
        $remark = $this->input->post('remark');
        $otp = $this->my_function->generateNumericOTP();
        
        $this->db->trans_begin();
        $this->db->select('*');
        $this->db->where($data);
        $result = $this->db->get_where('fee_waiver',array('status'=>1))->result_array();
        if(count($result) > 0){
            //------------Update------------------
            $this->db->where($data);
            $this->db->update('fee_waiver',array(
                'approved'=>0,
                'amount' => $amount,
                'remark' => $remark,
                'otp' => $otp,
                'waiver_mode' => 'Offline',
                'applied_on' => date('Y-m-d h:i:s'),
                'created_by' => $this->session->userdata('user_id')
            ));
        }else{
            //------------insert------------------
            $data['approved'] = 0;
            $data['amount'] = $amount;
            $data['remark'] = $remark;
            $data['otp'] = $otp;
            $data['waiver_mode'] = 'Offline';
            $data['applied_on'] = date('Y-m-d h:i:s');
            $data['created_by'] = $this->session->userdata('user_id');
            
            $this->db->insert('fee_waiver',$data);
        }
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(array('msg'=>'Apply fee waiver failed, Please try again.','status'=>500));
        }else {
            $this->db->trans_commit();
            $this->db->select('*');
            $student = $this->db->get_where('students',array(
                'ses_id' => (int)$data['ses_id'],
                'sch_id' => (int)$data['sch_id'],
                'medium' => (int)$data['med_id'],
                'adm_no' => $data['adm_no'],
                'status' => 1))->result_array();
            
            if(count($student)> 0 ){
                //$mobile = '7999328025';
                $mobile = '8817721954';
                $msg = 'Fee waiver request OTP is '.$otp.' for '.$student[0]['name'].', Adm No. '.$data['adm_no'].'. Amt: '.$amount.' - '.$this->session->userdata('username');
                $this->my_function->send_sms($mobile,$msg);
            }else{
                print_r('OTP Not Send.');die;
            }
            echo json_encode(array('msg'=>'Apply fee waiver successfully.','status'=>200));
        }
    }
    
    function check_otp(){
        $data['ses_id'] = $this->input->post('ses_id');
        $data['sch_id'] = $this->input->post('sch_id');
        $data['med_id'] = $this->input->post('med_id');
        $data['adm_no'] = $this->input->post('adm_no');
        $data['month_id'] = $this->input->post('month_id');
        $data['otp'] = $this->input->post('otp');
        
        $this->db->select('fw_id');
        $this->db->where($data);
        $result = $this->db->get_where('fee_waiver',array('status'=>1))->result_array();
        if(count($result) > 0){
            $this->db->where('fw_id',$result[0]['fw_id']);
            $this->db->update('fee_waiver',array('otp'=>'','approved'=>1));
            
            echo json_encode(array('msg'=>'successfull','fw_id'=>$result[0]['fw_id'],'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Enter valid OTP','status'=>500));
        }
        
    }
    
    function fee_payment(){
        $this->db->select('MAX(receipt_no) as receipt_no');
        $receipt = $this->db->get_where('student_fee',array('pay_mode'=>'Offline'))->result_array();
        
        $this->db->select('MAX(offline_fee_id) as offline_fee_id');
        $offline_fee_id = $this->db->get_where('student_fee',array('pay_mode'=>'Offline'))->result_array();
        
        $data['receipt_no'] = $receipt[0]['receipt_no'] + 1;
        $data['offline_fee_id'] = $offline_fee_id[0]['offline_fee_id'] + 1;
        
        $data['ses_id'] = $this->input->post('ses_id');
        $data['sch_id'] = $this->input->post('sch_id');
        $data['med_id'] = $this->input->post('med_id');
        $data['adm_no'] = $this->input->post('adm_no');
        $data['payment_date'] = date('Y-m-d');
        
        $data['bus_id'] = $this->input->post('bus_id');
        if(empty($data['bus_id'])){
            $data['bus_id'] = null;
        }
        $data['fw_id'] = $this->input->post('fw_id');
        if(empty($data['fw_id'])){
            $data['fw_id'] = null;
        }
        $data['session_fee_ids'] = $this->input->post('session_fee');
        if(empty($data['session_fee_ids'])){
            $data['session_fee_ids'] = null;
        }
        
        $data['admission_fee'] = $this->input->post('admission_fee');
        $data['amalgamated_fund'] = $this->input->post('amalgamated_fund');
        $data['lab_fee'] = $this->input->post('lab_fee');
        $data['optional_sub'] = $this->input->post('optional_sub');
        $data['tuition_fee'] = $this->input->post('tuition_fee');
        $data['bus_fee'] = $this->input->post('bus_fee');
        
        $data['month_ids'] = $this->input->post('month_ids');
        $data['late_fee'] = $this->input->post('late_fee');
        if(!empty($data['fw_id'])){
            $data['fee_waiver'] = $this->input->post('fee_waiver_amount');
        }else{
            $data['fee_waiver'] = 0;
        }
        $data['paid_amount'] = $this->input->post('paid_amount');
        $data['total_fee'] = $data['fee_waiver'] + $data['paid_amount'];
        $data['pay_mode'] = 'Offline';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $this->session->userdata('user_id');
        
        $pay_option = json_decode($this->input->post('pay_option'),true);
       
        $pay_method = [];
        foreach($pay_option as $pay){
           $temp = [];
           $temp['receipt_no'] = $data['receipt_no'];
           $temp['method_name'] = $pay[0]['pay_method'];
           $temp['amount'] = $pay[1]['amount'];
           $temp['card_name'] = $pay[2]['card'];
           if(empty($temp['card_name'])){
               $temp['card_name'] = null;
           }
           $temp['trans_amount'] = $pay[3]['trns_amount'];
           if(empty($temp['trans_amount'])){
               $temp['trans_amount'] = null;
           }
           $temp['method_no'] = $pay[4]['method_no'];
           if(empty($temp['method_no'])){
               $temp['method_no'] = null;
           }
           $temp['method_date'] = $pay[5]['date'];
           if(empty($temp['method_date'])){
               $temp['method_date'] = null;
           }
           $temp['bank_name'] = $pay[6]['bank_name'];
           if(empty($temp['bank_name'])){
               $temp['bank_name'] = null;
           }
           $temp['created_at'] = date('Y-m-d H:i:s');
           $temp['created_by'] = $this->session->userdata('user_id');
           $pay_method[] = $temp;    
       }
       
      $result =  $this->Student_fee_model->fee_payment($data,$pay_method);
      if($result){
          //$mobile = $this->input->post('contact_no');
		  $mobile = '8817721954';
          $sms = 'Dear Parent, the fee payment of '.$this->input->post('student_name').' has been received. Amount : '.$data['paid_amount'].'. Regards SVR';
          // print_r($sms);die;
          $this->my_function->send_sms($mobile,$sms);
          echo json_encode(array('msg'=>'Submit successfully','receipt_no'=>$data['receipt_no'],'status'=>200));
      }else{
          echo json_encode(array('msg'=>'Submit Failed, Please try again.','status'=>500));
      }
       
    }
    
    function fee_receipt(){
        $receipt = $this->input->get('receipt_no');
        $this->db->select('DATE_FORMAT(sf.created_at,"%d-%m-%Y") receipt_date,sf.receipt_no,sf.payment_date,s.ses_id,s.sch_id,s.medium,s.class_id,
                    c.class_name,sec.section_name,s.fee_criteria,s.staff_child,s.adm_no,s.name,s.f_name,
                    sf.session_fee_ids,
                    sf.month_ids,
                    sf.late_fee,
                    sf.bus_id,
                    bs.price bus_fee,
                    sf.fw_id,
                    sf.fee_waiver,
                    sf.total_fee,
                    sf.paid_amount
                    ');
        $this->db->join('students s','s.ses_id = sf.ses_id AND s.sch_id = sf.sch_id AND s.medium = sf.med_id AND s.adm_no = sf.adm_no AND s.status = 1');
        $this->db->join('bus_structure bs','bs.bs_id = sf.bus_id AND bs.ses_id = sf.ses_id AND bs.status = 1','LEFT');
        $this->db->join('class c','c.c_id = s.class_id');
        $this->db->join('section sec','sec.sec_id = s.sec_id');
        $result['student'] = $this->db->get_where('student_fee sf',array('sf.status'=>1,'sf.receipt_no'=>$receipt))->result_array();
        //print_r($this->db->last_query());die;
        if(count($result['student']) > 0){
            //-------------session fee------------------------------
            $session_fee = '0';
            if($result['student'][0]['session_fee_ids'] != '' || $result['student'][0]['session_fee_ids'] != null){
                $session_fee = $result['student'][0]['session_fee_ids'];
            }
            
            $ses_id = $result['student'][0]['ses_id'];
            $sch_id = $result['student'][0]['sch_id'];
            $med_id = $result['student'][0]['medium'];
            $class_id = $result['student'][0]['class_id'];
            $fee_criteria = $result['student'][0]['fee_criteria'];
            $staff_child = $result['student'][0]['staff_child'];
            
            $condition = 'fsm.status = 1';
            $condition .=' AND fsm.ses_id = '.$ses_id;
            $condition .=' AND fsm.sch_id = '.$sch_id;
            $condition .=' AND fsm.med_id = '.$med_id;
            $condition .=' AND fsm.class_id = '.$class_id;
            $condition .=' AND cfs.fc_id = '.$fee_criteria;
            if(!empty($staff_child)){
                $condition .=' AND cfs.staff_child = '.$staff_child;
            }
            
            $this->db->select('ft.ft_id,ft.name,fc.fc_id,fc.fc_name,cfs.amount');
            $this->db->join('fee_structure_master fsm','fsm.fs_id = cfs.fsm_id AND fsm.status = 1');
            $this->db->join('fee_criteria fc','fc.fc_id = cfs.fc_id');
            $this->db->join('fee_type ft','ft.ft_id = cfs.ft_id AND ft.ft_id IN ('.$session_fee.')');
            $this->db->where($condition);
            $result['session_fee'] = $this->db->get_where('class_fee_structure cfs')->result_array();
            
            //-----------------month fee--------------------------

            $month_ids = '0';
            if($result['student'][0]['month_ids'] != '' || $result['student'][0]['month_ids'] != null){
                $month_ids = $result['student'][0]['month_ids'];
            }
            
            
            if(!empty($staff_child)){
                $where_con = ' AND cfs.staff_child = '.$staff_child;
            }else{
                $where_con = '';
            }
            
            $this->db->select('fm.*,t1.amount tution_fee');
            $this->db->join('(SELECT fsm.ses_id,cfs.amount
                             FROM class_fee_structure cfs
                             JOIN fee_structure_master fsm ON fsm.fs_id = cfs.fsm_id
                             WHERE fsm.status = 1 AND fsm.ses_id = '.$ses_id.' AND fsm.sch_id = '.$sch_id.' AND fsm.med_id = '.$med_id.' AND fsm.class_id = '.$class_id.'
                             AND cfs.ft_id = 5 AND cfs.fc_id = '.$fee_criteria.$where_con.') t1','t1.ses_id = fm.ses_id',false);
            $this->db->where('fm_id IN ('.$month_ids.')');
            $fee_month = $this->db->get_where('fee_month fm',array('fm.status'=>1))->result_array();
            
           // print_r($this->db->last_query());die;
            
            $result['month_fee'] = array();
            if(count($fee_month) > 0){
                $current_date = date('Y-m-d');
                foreach($fee_month as $month){
                    $temp = array();
                    $temp['fm_id'] =  $month['fm_id'];
                    $temp['name'] =  $month['name'];
                    $temp['fee'] =  $month['tution_fee'] * $month['total_month'];
                    //------------class 10th and class 12 not march bus fee not include-------------
                    if(($class_id== 13 && $month['fm_id'] == 9) || ($class_id == 15 && $month['fm_id'] == 9)){
                        $temp['bus_fee'] = $result['student'][0]['bus_fee'] * 1;
                    }else{
                        $temp['bus_fee'] = $result['student'][0]['bus_fee'] * $month['bus_month'];
                    }
                    //--------------**********--------------
                    $result['month_fee'][] = $temp;
                }
            }
            $result['word_amount'] = ucwords($this->my_function->number_to_word($result['student'][0]['paid_amount']));
        }
        
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('data'=>'Record not found.','status'=>500));
        }
    }
    
    
    function fee_report(){
        $data['session'] = $this->input->post('session');
        $data['school'] = $this->input->post('school');
        $data['medium'] = $this->input->post('medium');
        $data['class_name'] = $this->input->post('class_name');
        $data['section'] = $this->input->post('section');
        $data['fee_criteria'] = $this->input->post('fee_criteria');
        $data['search_box'] = $this->input->post('search_box');
        
        $data['fee_month'] = $this->input->post('fee_month');
        $data['fee_status'] = $this->input->post('fee_status');
        
        
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
        if($data['class_name']){
            $condition .= ' AND s.class_id = '.$data['class_name'];
        }
        if($data['section']){
            $condition .= ' AND s.sec_id = '.$data['section'];
        }
        if($data['fee_criteria']){
            $condition .= ' AND s.fee_criteria = '.$data['fee_criteria'];
        }
        
        if($data['fee_month']){
            $condition1 = ' AND sf.month_ids LIKE "%'.$data['fee_month'].'%"';
        }else{
            $condition1 = '';
        }
        if($data['fee_status'] == 1){
            $condition .= ' AND sf.pay_status = '.$data['fee_status'];
        }else if($data['fee_status'] == 0){
            $condition .= ' AND sf.pay_status IS NULL';
        }
        
        if($data['search_box']){
            $condition .= ' AND (s.adm_no = "'.$data['search_box'].'" OR s.name LIKE "'.$data['search_box'].'%")';
        }
        
        $this->db->select('s.*,
                        IFNULL(s.related_std,"-") related_std,
                        IFNULL(s.bus,"No") bus,
                        c.class_name,
                        sec.section_name,
                        fc.fc_name,
                        IFNULL(sc.name,"") staff_child,
                        GROUP_CONCAT(sf.month_ids) month_ids,IF(sf.pay_status IS NULL,"Pending","Paid") fee_status');
        $this->db->join('student_fee sf','sf.adm_no = s.adm_no AND sf.ses_id = s.ses_id AND sf.sch_id = s.sch_id AND sf.status = 1 '.$condition1.'','LEFT');
        $this->db->join('class c','c.c_id = s.class_id');
        $this->db->join('section sec','sec.sec_id = s.sec_id');
        $this->db->join('fee_criteria fc','fc.fc_id = s.fee_criteria');
        $this->db->join('staff_child sc','sc.sc_id = s.staff_child','LEFT');
        $this->db->where($condition);
        $this->db->group_by('s.adm_no');
        $result = $this->db->get_where('students s',array('s.status'=>1))->result_array();
       //print_r($this->db->last_query());die;
        $final = [];
        if(count($result) > 0){
            if($data['fee_month']){
                $month_con = 'fm_id ='.$data['fee_month'];
            }else{
                $current_month = (int)date('m');
                if($current_month == 4 || $current_month == 5){
                    $c_month = 1;
                }else if($current_month == 6){
                    $c_month = 2;
                }else if($current_month == 7){
                    $c_month = 3;
                }else if($current_month == 8){
                    $c_month = 4;
                }else if($current_month == 9 || $current_month == 10){
                    $c_month = 5;
                }else if($current_month == 11){
                    $c_month = 6;
                }else if($current_month == 12){
                    $c_month = 7;
                }else if($current_month == 1){
                    $c_month = 8;
                }else if($current_month == 2 || $current_month == 3){
                    $c_month = 9;
                }
                $month_con = 'fm_id <='.$c_month;
            }
            
            foreach($result as $student){
                $temp = [];
                $temp = $student;
                if($student['month_ids'] > 0){
                    $paid_month_ids = $student['month_ids'];
                }else{
                    $paid_month_ids = '0';
                }
                $fee_month = $this->db->select('group_concat(name) month_name')->where('fm_id IN('.$paid_month_ids.')')->get_where('fee_month',array('status'=>1))->result_array();
                if($fee_month[0]['month_name'] != null){
                    $paid_month = $fee_month[0]['month_name'];
                    $pending_month = '';
                }else{
                    $paid_month = '';
                    $pending_month = $this->db->select('group_concat(name) month_name')->where('fm_id NOT IN('.$paid_month_ids.')')->where($month_con)->get_where('fee_month',array('status'=>1))->result_array();
                    if($pending_month[0]['month_name'] != null){
                        $pending_month = $pending_month[0]['month_name'];
                    }else{
                        $pending_month = '';
                    }
                }
                $temp['paid_month'] = $paid_month;
                $temp['pending_month'] = $pending_month;
               
                $final[] = $temp;
            }
        }
        
        if(count($final) > 0){
            echo json_encode(array('data'=>$final,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found.','status'=>500));
        }
        
    }
    
    
    function student_fee_details(){
        $data['session'] = $this->input->post('session');
        $data['school'] = $this->input->post('school');
        $data['medium'] = $this->input->post('medium');
        $data['class_name'] = $this->input->post('class_name');
        $data['section'] = $this->input->post('section');
        $data['fee_criteria'] = $this->input->post('fee_criteria');
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
        if($data['class_name']){
            $condition .= ' AND s.class_id = '.$data['class_name'];
        }
        if($data['section']){
            $condition .= ' AND s.sec_id = '.$data['section'];
        }
        if($data['fee_criteria']){
            $condition .= ' AND s.fee_criteria = '.$data['fee_criteria'];
        }
        if($data['search_box']){
            $condition .= ' AND (s.adm_no = "'.$data['search_box'].'" OR s.name LIKE "'.$data['search_box'].'%")';
        }
        
        $this->db->select('s.std_id,s.ses_id,s.sch_id,IFNULL(s.related_std,"-") related_std,s.medium,s.adm_no,s.name,s.f_name,IFNULL(s.bus,"No") bus,c.class_name,sec.section_name,fc.fc_name,IFNULL(sc.name,"") staff_child,
                MAX(IF(ft.ft_id = 1, cfs.amount, 0)) as admission_fee,
                MAX(IF(ft.ft_id = 2, cfs.amount, 0)) as amalgamated_fund,
                MAX(IF(ft.ft_id = 3, cfs.amount, 0)) as lab_fee,
                MAX(IF(ft.ft_id = 4, cfs.amount, 0)) as optional_sub,
                MAX(IF(ft.ft_id = 5, cfs.amount, 0)) as tuition_fee,
                (MAX(IF(ft.ft_id = 1, cfs.amount, 0)) +
                    MAX(IF(ft.ft_id = 2, cfs.amount, 0)) + 
                    MAX(IF(ft.ft_id = 3, cfs.amount, 0)) +
                    MAX(IF(ft.ft_id = 4, cfs.amount, 0)) +
                    (MAX(IF(ft.ft_id = 5, cfs.amount, 0)) * 12 ) +
                    IF(s.class_id = 13 OR s.class_id = 15,IFNULL(bs.price,0)*10,IFNULL(bs.price,0)*11 ) ) total
        '); 
        $this->db->join('bus_structure bs','bs.bs_id = s.bus_id AND bs.status = 1 AND s.bus = "Yes"','LEFT');
        $this->db->join('class_fee_structure cfs','cfs.fc_id = s.fee_criteria AND cfs.staff_child  = s.staff_child OR cfs.staff_child  IS NULL AND cfs.fc_id = s.fee_criteria AND cfs.fsm_id = (SELECT fs_id FROM fee_structure_master WHERE ses_id = s.ses_id AND sch_id = s.sch_id AND med_id = s.medium AND class_id = s.class_id AND status = 1 ORDER BY fs_id DESC LIMIT 1)');
        $this->db->join('fee_type ft','ft.ft_id = cfs.ft_id');
        $this->db->join('class c','c.c_id = s.class_id');
        $this->db->join('section sec','sec.sec_id = s.sec_id');
        $this->db->join('fee_criteria fc','fc.fc_id = s.fee_criteria');
        $this->db->join('staff_child sc','sc.sc_id = s.staff_child','LEFT');
        $this->db->where($condition);
        $this->db->group_by('s.adm_no');
        $this->db->order_by('s.class_id','ASC');
        $result = $this->db->get_where('students s')->result_array();
        
        $this->db->select('s.std_id,s.ses_id,s.sch_id,s.adm_no,SUM(sf.paid_amount) as paid_fee,IFNULL(GROUP_CONCAT(sf.month_ids),0) paid_month');
        $this->db->join('student_fee sf','sf.adm_no = s.adm_no AND sf.ses_id = s.ses_id AND sf.sch_id = s.sch_id AND sf.med_id = s.medium AND sf.status = 1','LEFT');
        $this->db->where($condition);
        $this->db->group_by('s.adm_no');
        $this->db->order_by('s.adm_no');
        $paid_details = $this->db->get_where('students s')->result_array();
        
        $this->db->select('*');
        $fee_month = $this->db->get_where('fee_month',array('status'=>1))->result_array();
        
        $final = [];
        $paid_fee = 0;
        $pending_fee = 0;
        $total_fee = 0;
        
        if(count($result) > 0 && count($paid_details) > 0){
            foreach($result as $total_detail){
                foreach($paid_details as $paid){
                    if($total_detail['adm_no'] == $paid['adm_no']){
                        $temp = [];
                        $temp['std_id'] = $total_detail['std_id'];
                        $temp['ses_id'] = $total_detail['ses_id'];
                        $temp['sch_id'] = $total_detail['sch_id'];
                        $temp['medium'] = $total_detail['medium'];
                        $temp['adm_no'] = $total_detail['adm_no'];
                        
                        $temp['class_name'] = $total_detail['class_name'];
                        $temp['section_name'] = $total_detail['section_name'];
                        $temp['fc_name'] = $total_detail['fc_name'];
                        $temp['related_std'] = $total_detail['related_std'];
                        $temp['staff_child'] = $total_detail['staff_child'];
                        
                        $temp['name'] = $total_detail['name'];
                        $temp['f_name'] = $total_detail['f_name'];
                        $temp['bus'] = $total_detail['bus'];
                        $temp['total'] = $total_detail['total'];
                        $temp['paid_fee'] = $paid['paid_fee'];
                        $temp['pending_fee'] = $temp['total'] - $temp['paid_fee'];
                        
                        $temp['pending_month'] = ''; 
                        $paid_month = explode(",",$paid['paid_month']);
                        
                            foreach($fee_month as $month){
                                $flag = 0;
                                foreach($paid_month as $pmonth){
                                    if($month['fm_id'] == $pmonth){
                                        $flag = 1;
                                        //$temp['pending_month'] .= $month['name'].', ';
                                    }
                            }
                            if($flag == 0){
                                $temp['pending_month'] .= $month['name'].', ';
                            }
                        }
                        
                        if($temp['fc_name'] == 'RTE'){
                            $temp['pending_month'] = 'No Fee';
                        }
                        
                        $paid_fee += $temp['paid_fee'];
                        $pending_fee += $temp['pending_fee'];
                        $total_fee += $temp['total'];
                        
                        $final[] = $temp;
                        
                    }
                }
            }
        }
        
        if(count($final) > 0){
            echo json_encode(array('data'=>$final,'paid_fee'=>$paid_fee,'pending_fee'=>$pending_fee,'total_fee'=>$total_fee,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found.','status'=>500));
        }
    }
    
    function day_wise_report(){
        $data['ses_id'] = $this->input->post('session');
        $data['sch_id'] = $this->input->post('school');
        $data['med_id'] = $this->input->post('medium');
        $data['from_date'] = $this->input->post('from_date');
        $data['to_date'] = $this->input->post('to_date');
        
        //-------------get month total fee----------------------
        $current_month = (int)date('m');
        if($current_month == 4 || $current_month == 5){
            $fee_month = 1;
            $paid_fee_month = '4,5';
        }else if($current_month == 6){
            $fee_month = 2;
            $paid_fee_month = '6';
        }else if($current_month == 7){
            $fee_month = 3;
            $paid_fee_month = '7';
        }else if($current_month == 8){
            $fee_month = 4;
            $paid_fee_month = '8';
        }else if($current_month == 9 || $current_month == 10){
            $fee_month = 5;
            $paid_fee_month = '9,10';
        }else if($current_month == 11){
            $fee_month = 6;
            $paid_fee_month = '11';
        }else if($current_month == 12){
            $fee_month = 7;
            $paid_fee_month = '12';
        }else if($current_month == 1){
            $fee_month = 8;
            $paid_fee_month = '1';
        }else if($current_month == 2 || $current_month == 3){
            $fee_month = 9;
            $paid_fee_month = '2,3';
        }
        
        $result['month_total'] = 0;
        
        $this->db->select('*');
        $check = $this->db->get_where('fee_month_total',array('fm_id'=>$fee_month,'ses_id'=>$data['ses_id'],'sch_id'=>$data['sch_id'],'status'=>1))->result_array();
        if(count($check) > 0){
            $result['month_total'] = $check[0]['amount'];
        }else{
            $this->all_fee_details($data['ses_id'],$data['sch_id']);
            $check = $this->db->get_where('fee_month_total',array('fm_id'=>$fee_month,'ses_id'=>$data['ses_id'],'sch_id'=>$data['sch_id'],'status'=>1))->result_array();
            $result['month_total'] = $check[0]['amount'];
        }
        
        
        //---------------get month paid fee-------------------------
        $result['month_paid'] = 0;
        $result['month_pending'] = 0;
        $this->db->select('SUM(paid_amount) paid_amount');
        $this->db->where('MONTH(payment_date) IN ('.$paid_fee_month.')');
        $month_paid = $this->db->get_where('student_fee',array('ses_id'=>$data['ses_id'],'sch_id'=>$data['sch_id'],'status'=>1))->result_array();
        if(!empty($month_paid[0]['paid_amount'])){
            $result['month_paid'] = $month_paid[0]['paid_amount'];
            $result['month_pending'] = $result['month_total'] - $month_paid[0]['paid_amount'];
        }
        //----------------daily report----------------------------
        $condition = 'sf.status = 1';
        $condition1 = 'status = 1';
        if(!empty($data['ses_id'])){
            $condition .= ' AND sf.ses_id = '.$data['ses_id'];
            $condition1 .= ' AND ses_id = '.$data['ses_id'];
        }
        if(!empty($data['sch_id'])){
            $condition .= ' AND sf.sch_id = '.$data['sch_id'];
            $condition1 .= ' AND sch_id = '.$data['sch_id'];
        }
        if(!empty($data['med_id'])){
            $condition .= ' AND sf.med_id = '.$data['med_id'];
            $condition1 .= ' AND med_id = '.$data['med_id'];
        }
      
        if(!empty($data['from_date'])){
            $condition .= ' AND sf.payment_date >= "'.$data['from_date'].'"';
            $condition1 .= ' AND payment_date >= "'.$data['from_date'].'"';
        }
        
        if(!empty($data['to_date'])){
            $condition .= ' AND sf.payment_date <= "'.$data['to_date'].'"';
            $condition1 .= ' AND payment_date <= "'.$data['to_date'].'"';
        }
        
        
        $this->db->select('
                           IFNULL(SUM(sf.paid_amount),0) paid_amount,
                           IFNULL(SUM(sf.admission_fee),0) admission_fee,
                           IFNULL(SUM(sf.amalgamated_fund),0) amalgamated_fund,
                           IFNULL(SUM(sf.lab_fee),0) lab_fee,
                           IFNULL(SUM(sf.optional_sub),0) optional_sub,
                           IFNULL(SUM(sf.tuition_fee),0) bus_fee,
                           IFNULL(SUM(sf.late_fee),0) late_fee,
                           IFNULL(SUM(sf.paid_amount),0) paid_amount,
                           IFNULL(SUM(sf.fee_waiver),0) fee_waiver,
                           IFNULL(SUM(sf.tuition_fee),0) tuition_fee,
                           IFNULL((SELECT SUM(paid_amount) FROM student_fee WHERE '.$condition1.' AND pay_mode = "Offline"),0) total_offline,
                           IFNULL((SELECT SUM(paid_amount) FROM student_fee WHERE '.$condition1.' AND pay_mode = "Online"),0) total_online
                ');
        $this->db->where($condition);
        $result['student_fee'] = $this->db->get_where('student_fee sf',array('sf.status'=>1))->result_array();

        $this->db->select('
                           IFNULL(SUM(IF(fpm.method_name = "cash",fpm.amount,0)),0) cash,
                           IFNULL(SUM(IF(fpm.method_name = "cheque",fpm.amount,0)),0) cheque,
                           IFNULL(SUM(IF(fpm.method_name = "dd",fpm.amount,0)),0) dd,
                           IFNULL(SUM(IF(fpm.method_name = "pos",IF(fpm.card_name = "credit_card",fpm.amount,0),0)),0) credit_card,
                           IFNULL(SUM(IF(fpm.method_name = "pos",IF(fpm.card_name = "debit_card",fpm.amount,0),0)),0) debit_card
        ');
        $this->db->join('student_fee sf','sf.receipt_no = fpm.receipt_no');
        $this->db->where('sf.payment_date >=',$data['from_date']);
        $this->db->where('sf.payment_date <=',$data['to_date']);
        $this->db->where($condition);
        $result['pay_method'] = $this->db->get_where('fee_pay_method fpm',array('fpm.status'=>1))->result_array();
        
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found.','status'=>500));
        }
    }
    
    function all_fee_details($session,$school){
        $this->db->trans_begin();
        $current_month = (int)date('m');
        
        if($current_month == 4 || $current_month == 5){ //-------------admission month-------------
            
            $this->db->select('IFNULL(bs.price * 1,0) bus_fee,
                MAX(IF(cfs.ft_id = 1, IF(s.std_status = "new_student",cfs.amount,0), 0)) as admission_fee,
                MAX(IF(cfs.ft_id = 2, cfs.amount, 0)) as amalgamated_fund,
                MAX(IF(cfs.ft_id = 3, cfs.amount, 0)) as lab_fee,
                MAX(IF(cfs.ft_id = 4, cfs.amount, 0)) as optional_sub,
                MAX(IF(cfs.ft_id = 5, cfs.amount * 2, 0)) as tution_fee
        ',false);
            $this->db->join('fee_structure_master fsm','fsm.ses_id = s.ses_id AND fsm.sch_id = s.sch_id AND fsm.med_id = s.medium AND fsm.class_id = s.class_id AND fsm.status = 1');
            $this->db->join('class_fee_structure cfs','cfs.fsm_id = fsm.fs_id AND cfs.fc_id = s.fee_criteria AND (cfs.staff_child = s.staff_child OR cfs.staff_child IS NULL)');
            $this->db->join('bus_structure bs','bs.bs_id = s.bus_id AND bs.school_id = s.sch_id AND bs.ses_id = s.ses_id AND s.status = 1 AND s.bus = "Yes"','LEFT');
            $this->db->group_by('s.std_id');
            $shakuntala = $this->db->get_where('students s',array('s.ses_id'=>$session,'s.sch_id'=>$school,'s.status'=>1))->result_array();
        }else if($current_month == 9 || $current_month == 10){
            
            $this->db->select('IFNULL(bs.price * 2,0) bus_fee,
                MAX(IF(cfs.ft_id = 1, IF(s.std_status = "new_student",cfs.amount,0), 0)) as admission_fee,
                MAX(IF(cfs.ft_id = 2, cfs.amount, 0)) as amalgamated_fund,
                MAX(IF(cfs.ft_id = 3, cfs.amount, 0)) as lab_fee,
                MAX(IF(cfs.ft_id = 4, cfs.amount, 0)) as optional_sub,
                MAX(IF(cfs.ft_id = 5, cfs.amount * 2, 0)) as tution_fee
        ',false);
            $this->db->join('fee_structure_master fsm','fsm.ses_id = s.ses_id AND fsm.sch_id = s.sch_id AND fsm.med_id = s.medium AND fsm.class_id = s.class_id AND fsm.status = 1');
            $this->db->join('class_fee_structure cfs','cfs.fsm_id = fsm.fs_id AND cfs.fc_id = s.fee_criteria AND (cfs.staff_child = s.staff_child OR cfs.staff_child IS NULL)');
            $this->db->join('bus_structure bs','bs.bs_id = s.bus_id AND bs.school_id = s.sch_id AND bs.ses_id = s.ses_id AND s.status = 1 AND s.bus = "Yes"','LEFT');
            $this->db->group_by('s.std_id');
            $shakuntala = $this->db->get_where('students s',array('s.ses_id'=>$session,'s.sch_id'=>$school,'s.status'=>1))->result_array();
        }else if($current_month == 2|| $current_month == 3){
            $this->db->select('IFNULL(IF(s.class_id = 13 OR s.class_id = 15,(bs.price * 1),(bs.price * 2) ), 0) bus_fee,
                MAX(IF(cfs.ft_id = 1,0, 0)) as admission_fee,
                MAX(IF(cfs.ft_id = 2,0, 0)) as amalgamated_fund,
                MAX(IF(cfs.ft_id = 3,0, 0)) as lab_fee,
                MAX(IF(cfs.ft_id = 4,0, 0)) as optional_sub,
                MAX(IF(cfs.ft_id = 5, cfs.amount * 2, 0)) as tution_fee
        ',false);
            $this->db->join('fee_structure_master fsm','fsm.ses_id = s.ses_id AND fsm.sch_id = s.sch_id AND fsm.med_id = s.medium AND fsm.class_id = s.class_id AND fsm.status = 1');
            $this->db->join('class_fee_structure cfs','cfs.fsm_id = fsm.fs_id AND cfs.fc_id = s.fee_criteria AND (cfs.staff_child = s.staff_child OR cfs.staff_child IS NULL)');
            $this->db->join('bus_structure bs','bs.bs_id = s.bus_id AND bs.school_id = s.sch_id AND bs.ses_id = s.ses_id AND s.status = 1 AND s.bus = "Yes"','LEFT');
            $this->db->group_by('s.std_id');
            $shakuntala = $this->db->get_where('students s',array('s.ses_id'=>$session,'s.sch_id'=>$school,'s.status'=>1))->result_array();
        }
        else{
            $this->db->select('IFNULL(bs.price,0) bus_fee,
                MAX(IF(cfs.ft_id = 1,0, 0)) as admission_fee,
                MAX(IF(cfs.ft_id = 2,0, 0)) as amalgamated_fund,
                MAX(IF(cfs.ft_id = 3,0, 0)) as lab_fee,
                MAX(IF(cfs.ft_id = 4,0, 0)) as optional_sub,
                MAX(IF(cfs.ft_id = 5, cfs.amount, 0)) as tution_fee
        ',false);
            $this->db->join('fee_structure_master fsm','fsm.ses_id = s.ses_id AND fsm.sch_id = s.sch_id AND fsm.med_id = s.medium AND fsm.class_id = s.class_id AND fsm.status = 1');
            $this->db->join('class_fee_structure cfs','cfs.fsm_id = fsm.fs_id AND cfs.fc_id = s.fee_criteria AND (cfs.staff_child = s.staff_child OR cfs.staff_child IS NULL)');
            $this->db->join('bus_structure bs','bs.bs_id = s.bus_id AND bs.school_id = s.sch_id AND bs.ses_id = s.ses_id AND s.status = 1 AND s.bus = "Yes"','LEFT');
            $this->db->group_by('s.std_id');
            $shakuntala = $this->db->get_where('students s',array('s.ses_id'=>$session,'s.sch_id'=>$school,'s.status'=>1))->result_array();
        }
        
        $month_fee = 0;
        foreach($shakuntala as $svr){
            $month_fee += $svr['bus_fee'] + $svr['admission_fee'] + $svr['amalgamated_fund'] + $svr['lab_fee'] + $svr['optional_sub'] + $svr['tution_fee'];
        }
        
        if($current_month == 4 || $current_month == 5){
            $fee_month = 1;
        }else if($current_month == 6){
            $fee_month = 2;
        }else if($current_month == 7){
            $fee_month = 3;
        }else if($current_month == 8){
            $fee_month = 4;
        }else if($current_month == 9 || $current_month == 10){
            $fee_month = 5;
        }else if($current_month == 11){
            $fee_month = 6;
        }else if($current_month == 12){
            $fee_month = 7;
        }else if($current_month == 1){
            $fee_month = 8;
        }else if($current_month == 2 || $current_month == 3){
            $fee_month = 9;
        }
        
        $this->db->select('mt_id');
        $result = $this->db->get_where('fee_month_total',array(
            'fm_id'=>$fee_month,
            'ses_id'=>$session,
            'sch_id'=>$school,
            'amount'=>$month_fee,
            'status'=>1
        ))->result_array();
        
        if(count($result) > 0){
            //--------update-----------------
           $this->db->where('mt_id',$result[0]['mt_id']);
           $this->db->update('fee_month_total',array(
               'fm_id'=>$fee_month,
               'ses_id'=>$session,
               'sch_id'=>$school,
               'amount'=>$month_fee,
               'created_at'=>date('Y-m-d H:i:s'),
               'created_by'=>$this->session->userdata('user_id')
           ));
        }else{
            //--------update-----------------
            $this->db->insert('fee_month_total',array(
                'fm_id'=>$fee_month,
                'ses_id'=>$session,
                'sch_id'=>$school,
                'amount'=>$month_fee,
                'created_at'=>date('Y-m-d H:i:s'),
                'created_by'=>$this->session->userdata('user_id')
            ));
        }
        
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }
    
    
    function student_report(){
        $data['ses_id'] = $this->input->post('ses_id');
        $data['sch_id'] = $this->input->post('sch_id');
        $data['adm_no'] = $this->input->post('adm_no');
        
        
        $this->db->select('s.ses_id,s.sch_id,s.adm_no,s.name,s.f_name,c.class_name,sec.section_name,fc.fc_name,IFNULL(sc.name,"") staff_child,IFNULL(s.bus,"No") bus,
                MAX(IF(ft.ft_id = 1, cfs.amount, 0)) as admission_fee,
                MAX(IF(ft.ft_id = 2, cfs.amount, 0)) as amalgamated_fund,
                MAX(IF(ft.ft_id = 3, cfs.amount, 0)) as lab_fee,
                MAX(IF(ft.ft_id = 4, cfs.amount, 0)) as optional_sub,
                MAX(IF(ft.ft_id = 5, cfs.amount, 0)) as tuition_fee,
                (MAX(IF(ft.ft_id = 1, cfs.amount, 0)) +
                    MAX(IF(ft.ft_id = 2, cfs.amount, 0)) +
                    MAX(IF(ft.ft_id = 3, cfs.amount, 0)) +
                    MAX(IF(ft.ft_id = 4, cfs.amount, 0)) +
                    (MAX(IF(ft.ft_id = 5, cfs.amount, 0)) * 12 ) +
                    IF(s.class_id = 13 OR s.class_id = 15,IFNULL(bs.price,0)*10,IFNULL(bs.price,0)*11 ) ) total
        ');
        $this->db->join('bus_structure bs','bs.bs_id = s.bus_id AND bs.status = 1 AND s.bus = "Yes"','LEFT');
        $this->db->join('class_fee_structure cfs','cfs.fc_id = s.fee_criteria AND cfs.staff_child  = s.staff_child OR cfs.staff_child  IS NULL 
        AND cfs.fc_id = s.fee_criteria AND cfs.fsm_id = (SELECT fs_id FROM fee_structure_master WHERE ses_id = '.$data['ses_id'].' 
        AND sch_id = '.$data['sch_id'].' AND med_id = s.medium AND class_id = s.class_id AND status = 1 ORDER BY fs_id DESC LIMIT 1)');
        $this->db->join('fee_type ft','ft.ft_id = cfs.ft_id');
        $this->db->join('class c','c.c_id = s.class_id');
        $this->db->join('section sec','sec.sec_id = s.sec_id');
        $this->db->join('fee_criteria fc','fc.fc_id = s.fee_criteria');
        $this->db->join('staff_child sc','sc.sc_id = s.staff_child','LEFT');
        $this->db->where(array('s.ses_id'=>$data['ses_id'],'s.sch_id'=>$data['sch_id'],'s.adm_no'=>$data['adm_no']));
        $this->db->group_by('s.adm_no');
        $this->db->order_by('s.adm_no');
        $student_details = $this->db->get_where('students s')->result_array();
        
        $paid_fee = 0;
        
        $this->db->select('*');
        $student_fee = $this->db->get_where('student_fee',array('status'=>1,'ses_id'=>$data['ses_id'],'sch_id'=>$data['sch_id'],'adm_no'=>$data['adm_no']))->result_array();        
        $final = array();
        if(count($student_fee) > 0){
            foreach($student_fee as $key => $fee){
                $temp = array();
                $this->db->select('GROUP_CONCAT(name) fee_month');
                $this->db->where('fm_id IN ('.$fee['month_ids'].')');
                $this->db->group_by('ses_id');
                $fee_month = $this->db->get_where('fee_month',array('status'=>1,'ses_id'=>$data['ses_id']))->result_array();
                
                if($fee['session_fee_ids'] != null || $fee['session_fee_ids'] != ''){
                    $ft_ids = $fee['session_fee_ids'];
                }else{
                    $ft_ids = 0;
                }
                $this->db->select('GROUP_CONCAT(name) fee_type');
                $this->db->where('ft_id IN ('.$ft_ids.')');
                $fee_type = $this->db->get_where('fee_type',array('status'=>1))->result_array();
                
                $temp = $fee;
                $temp['fee_month'] = $fee_month[0]['fee_month'];
                $temp['session_fee'] = $fee_type[0]['fee_type'];
                
                $paid_fee += $fee['paid_amount'];
                
                $final[] = $temp;
            }
        }
        
        $total_fee = $student_details[0]['total'];
        $pending_fee = $student_details[0]['total'] - $paid_fee;
        if(count($student_details) > 0){
            echo json_encode(array('data'=>$final,'student_details'=>$student_details,'total_fee'=>$total_fee,'paid_fee'=>$paid_fee,'pending_fee'=>$pending_fee,'status'=>200));
        }else{
            echo json_encode(array('data'=>'student recor not found.','status'=>500));
        }
    }
    
    function student_discontinue(){
        $ses_id = $this->input->post('ses_id');
        $sch_id = $this->input->post('sch_id');
        $adm_no = $this->input->post('adm_no');
        
        $this->db->where(array('ses_id'=>$ses_id,'sch_id'=>$sch_id,'adm_no'=>$adm_no));
        $result = $this->db->update('students',array('status'=>0,'discontinue_date'=>date('Y-m-d H:i:s')));
        if($result){
            $this->all_fee_details($ses_id,$sch_id);
            echo json_encode(array('msg'=>'Student Discontinue Successfully','status'=>200));
        }else{
            echo json_encode(array('msg'=>'Something went wrong, Please try again.','status'=>500));
        }
        
    }
    
}