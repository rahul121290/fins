<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generate_fee_ctrl extends CI_Controller {
    function __construct(){
        parent :: __construct();
        $this->load->library('My_function');
        //$this->server = $this->load->database('server',true);
    }
    
    function generate_fee(){
        $ses_id = $this->session->userdata('session_id');
        $sch_id = $this->input->post('sch_id');
        $class_id = $this->input->post('class_id');
        
        $condition = 's.status = 1';
        if($ses_id){
            $condition .= ' AND s.ses_id = '.$ses_id;
        }
        if($sch_id){
            $condition .= ' AND s.sch_id = '.$sch_id;
        }
        
        $current_month = (int)date('m');
        
        if($current_month == 4 || $current_month == 5){
            $month_fee = 2;
            $bus_fee = 1;
            $fee_month = 1;
        }else if($current_month == 6){
            $month_fee = 1;
            $bus_fee = 1;
            $fee_month = 2;
        }else if($current_month == 7){
            $month_fee = 1;
            $bus_fee = 1;
            $fee_month = 3;
        }else if($current_month == 8){
            $month_fee = 1;
            $bus_fee = 1;
            $fee_month = 4;
        }else if($current_month == 9 || $current_month == 10){
            $month_fee = 2;
            $bus_fee = 2;
            $fee_month = 5;
        }else if($current_month == 11){
            $month_fee = 1;
            $bus_fee = 1;
            $fee_month = 6;
        }else if($current_month == 12){
            $month_fee = 1;
            $bus_fee = 1;
            $fee_month = 7;
        }else if($current_month == 1){
            $month_fee = 1;
            $bus_fee = 1;
            $fee_month = 8;
        }else if(($current_month == 2 && $class_id == 13) || ($current_month == 3 && $class_id == 15)){
            $month_fee = 2;
            $bus_fee = 1;
            $fee_month = 9;
        }else if(($current_month == 2 && $class_id != 13) || ($current_month == 3 && $class_id != 15)){
            $month_fee = 2;
            $bus_fee = 2;
            $fee_month = 9;
        }
        
        $this->db->trans_begin();
//         $this->server->select('*');
//         $this->server->limit(1);
//         $check = $this->server->get_where('student_fee',array('status'=>1,'ses_id'=>$ses_id,'sch_id'=>$sch_id,'month_ids'=>$fee_month))->result_array();
//         if(count($check) > 0){
//             echo json_encode(array('msg'=>'Already generated fee','status'=>500));
//             die;
//         }else{
        $this->db->select('s.ses_id,s.sch_id,s.medium,s.class_id,s.sec_id,s.adm_no,IFNULL(s.bus_id,"NULL") bus_id,IFNULL(s.bus,"No") bus,
                MAX(IF(ft.ft_id = 1, cfs.amount, 0)) as admission_fee,
                MAX(IF(ft.ft_id = 2, cfs.amount, 0)) as amalgamated_fund,
                MAX(IF(ft.ft_id = 3, cfs.amount, 0)) as lab_fee,
                MAX(IF(ft.ft_id = 4, cfs.amount, 0)) as optional_sub,
                MAX(IF(ft.ft_id = 5, cfs.amount, 0)) as tuition_fee,
                IFNULL(bs.price,0) bus_fee
        ');
        $this->db->join('bus_structure bs','bs.bs_id = s.bus_id AND bs.status = 1 AND s.bus = "Yes"','LEFT');
        $this->db->join('class_fee_structure cfs','cfs.fc_id = s.fee_criteria AND (cfs.staff_child  = s.staff_child OR cfs.staff_child  IS NULL) AND cfs.fsm_id = (SELECT fs_id FROM fee_structure_master WHERE ses_id = '.$ses_id.' AND sch_id = '.$sch_id.' AND class_id = s.class_id AND status = 1 ORDER BY fs_id DESC LIMIT 1)');
        $this->db->join('fee_type ft','ft.ft_id = cfs.ft_id');
        $this->db->where($condition);
        $this->db->group_by('s.adm_no');
        $this->db->order_by('s.class_id');
        $result = $this->db->get_where('students s',array('s.adm_no'=>4071))->result_array();
       //print_r($this->db->last_query());die;
        $final = [];
        if(count($result) > 0){
            foreach($result as $data){
                $temp = [];
                $temp['receipt_no'] = null;
                $temp['ses_id'] = $data['ses_id'];
                $temp['sch_id'] = $data['sch_id'];
                $temp['med_id'] = $data['medium'];
                $temp['adm_no'] = $data['adm_no'];
                $temp['bus_id'] = $data['bus_id'];
                $temp['month_ids'] = $fee_month;
                $temp['fw_id'] = null;
                if($fee_month == 1){
                    $temp['admission_fee'] = $data['admission_fee'];
                    $temp['amalgamated_fund'] = $data['amalgamated_fund'];
                    $temp['lab_fee'] = $data['lab_fee'];
                    $temp['optional_sub'] = $data['optional_sub'];
                    $temp['session_fee_ids'] = '1,2,3,4';
                }else{
                    $temp['admission_fee'] = null;
                    $temp['amalgamated_fund'] = null;
                    $temp['lab_fee'] = null;
                    $temp['optional_sub'] = null;
                    $temp['session_fee_ids'] = null;
                }
                $temp['tuition_fee'] = $data['tuition_fee'];
                $temp['bus_fee'] = $data['bus_fee'];
                $temp['late_fee'] = null;
                $temp['fee_waiver'] = null;
                $temp['total_fee'] = $temp['admission_fee'] + 
                                     $temp['amalgamated_fund'] + 
                                     $temp['lab_fee'] + 
                                     $temp['optional_sub'] + 
                                     ($temp['tuition_fee'] * $month_fee)+ 
                                     ($temp['bus_fee'] * $bus_fee);
                $temp['paid_amount'] = null;
                $temp['payment_date'] = null;
                $temp['pay_method'] = NULL;
                $temp['payment_id'] = null;
                $temp['pay_mode'] = NULL;
                $temp['created_at'] = date('Y-m-d H:i:s');
                $temp['created_by'] = 1;
                $final[] = $temp;
            }
            $insert = $this->server->insert_batch(' student_fee',$final);
        }else{
            echo json_encode(array('msg'=>'Record not found. fee structure not generated','status'=>500));
            die;
            }
        //}
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            echo json_encode(array('msg'=>'Something Error.','status'=>500));
        }
        else{
            $this->db->trans_commit();
            echo json_encode(array('msg'=>'Insert successfully','status'=>200));
        }
    }
 
    function send_fee_sms(){
        $data['session'] = $this->session->userdata('session_id');
        $data['school'] = $this->input->post('school');
        $data['class_id'] = $this->input->post('class_id');
        
        $current_month = (int)date('m');
        if($current_month == 4 || $current_month == 5){
            $fee_month_id = 1;
            $month_name = 'April + May';
        }else if($current_month == 6){
            $fee_month_id = 2;
            $month_name = 'June';
        }else if($current_month == 7){
            $fee_month_id = 3;
            $month_name = 'July';
        }else if($current_month == 8){
            $fee_month_id = 4;
            $month_name = 'Aug';
        }else if($current_month == 9 || $current_month == 10){
            $fee_month_id = 5;
            $month_name = 'Sep + Oct.';
        }else if($current_month == 11){
            $fee_month_id = 6;
            $month_name = 'November';
        }else if($current_month == 12){
            $fee_month_id = 7;
            $month_name = 'December';
        }else if($current_month == 1){
            $fee_month_id = 8;
            $month_name = 'January';
        }else if($current_month == 2 || $current_month == 3){
            $fee_month_id = 9;
            $month_name = 'Feb + March';
        }
                
        $this->db->select('*');
        $checkexist = $this->db->get_where('fee_month_sms',array('ses_id'=>$data['session'],'fm_id'=>$fee_month_id,'sch_id'=>$data['school'],'class_id'=>$data['class_id'],'status'=>1))->result_array();
        
        if(count($checkexist) > 0){
            echo json_encode(array('msg'=>'Already send SMS','status'=>500));
            die;
        }else{
            //-----------send sms------------
            $this->server->select('s.name,s.contact_no,sf.total_fee');
            $this->server->join('student_fee sf','s.adm_no = sf.adm_no AND s.ses_id = sf.ses_id AND s.sch_id = sf.sch_id AND sf.status = 1');
            $student_fee = $this->server->get_where('students s',array('s.status'=>1,'s.ses_id'=>$data['session'],'s.sch_id'=>$data['school'],'s.class_id'=>$data['class_id']))->result_array();
            if(count($student_fee) > 0){
                //-----------insert in table------------
                $this->db->insert('fee_month_sms',
                    array('ses_id'=>$data['session'],
                        'fm_id'=>$fee_month_id,
                        'sch_id'=>$data['school'],
                        'class_id'=>$data['class_id'],
                        'created_by'=>$this->session->userdata('user_id'),
                        'created_at'=>date('Y-m-d H:i:s')
                    ));
                    /////////////send sms///////////////////////
                foreach($student_fee as $std_fee){
                    $sms = 'Dear Parent, Shakuntala Vidyalaya Fee of Rs. '.$std_fee['total_fee'].', due on 15-'.date('m').'-'.date('Y').', has been generated and presented in Parent Portal. Please login to pay online by due date. Avoid late fee. Transaction charges applicable.';
//                     print_r($sms);
//                     print_r($std_fee['contact_no']);die;
                    //$this->my_function->send_sms($sms,$std_fee['contact_no']);
                }
                echo json_encode(array('msg'=>'SMS Send Successfully','status'=>200));
            }else{
                echo json_encode(array('msg'=>'Student record not found.','status'=>500));
            }
        }
    }
    
}
