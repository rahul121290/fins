<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_sync_ctrl extends CI_Controller {
    function __construct(){
        parent :: __construct();
        $this->server = $this->load->database('server',true);
    }
    
    
    function sync_fee_details(){
        $this->db->trans_begin();
        //------------server to local------------------------
        $this->db->select('MAX(online_fee_id) online_fee_id');
        $local = $this->db->get_where('student_fee',array('status'=>1,'pay_status'=>1,'pay_mode'=>'Online'))->result_array();
        
        $this->server->select('MAX(online_fee_id) online_fee_id');
        $server = $this->server->get_where('student_fee',array('status'=>1,'pay_status'=>1,'pay_mode'=>'Online'))->result_array();
        
        if((int)$server[0]['online_fee_id'] > (int)$local[0]['online_fee_id']){
            
            $this->server->select('offline_fee_id,online_fee_id,adm_no,ses_id,sch_id,med_id,session_fee_ids,month_ids,bus_id,fw_id,admission_fee,amalgamated_fund,lab_fee,optional_sub,tuition_fee,bus_fee,late_fee,fee_waiver,total_fee,paid_amount,payment_date,payment_id,pay_mode,pay_method,pay_status,created_at,created_by,updated_at,updated_by,status');
            $result = $this->server->get_where('student_fee',array('status'=>1,'pay_status'=>1,'pay_mode'=>'Online','online_fee_id >'=>(int)$local[0]['online_fee_id']))->result_array();
            if(count($result) > 0){
                $this->db->select('MAX(receipt_no) receipt_no');
                $receipt_no = $this->db->get_where('student_fee',array('status'=>1,'pay_status'=>1,'pay_mode'=>'Online'))->result_array();
                $receipt_no = $receipt_no[0]['receipt_no'];
                $final = array();
                foreach($result as $key => $res){
                    $temp = array();
                    $temp = $res;
                    $temp['receipt_no'] = $receipt_no++;
                    $final[] = $temp;
                }
                $this->db->insert_batch('student_fee',$final);
            }
        }
        
        //-------------------local to server-----------------------------
        $this->db->select('MAX(offline_fee_id) offline_fee_id');
        $local = $this->db->get_where('student_fee',array('status'=>1,'pay_mode'=>'Offline'))->result_array();
        
        $this->server->select('MAX(offline_fee_id) offline_fee_id');
        $server = $this->server->get_where('student_fee',array('status'=>1,'pay_mode'=>'Offline'))->result_array();
        if((int)$local[0]['offline_fee_id'] > (int)$server[0]['offline_fee_id']){
            $this->db->select('offline_fee_id,online_fee_id,receipt_no,adm_no,ses_id,sch_id,med_id,session_fee_ids,month_ids,bus_id,fw_id,admission_fee,amalgamated_fund,lab_fee,optional_sub,tuition_fee,bus_fee,late_fee,fee_waiver,total_fee,paid_amount,payment_date,payment_id,pay_mode,pay_method,pay_status,created_at,created_by,updated_at,updated_by,status');
            $result = $this->db->get_where('student_fee',array('status'=>1,'pay_status'=>1,'pay_mode'=>'Offline','offline_fee_id >'=>(int)$server[0]['offline_fee_id']))->result_array();
            if(count($result) > 0){
                //----------data insert in server---------------------
                $this->server->insert_batch('student_fee',$result);
            }
        }
        
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            echo json_encode(array('msg'=>'something went wrong','status'=>500));
        }
        else
        {
            $this->db->trans_commit();
            echo json_encode(array('msg'=>'Student fee sync successfully','status'=>200));
        }
        
    }
    
    
    function data_sync(){//--------------for subject allocation--------------------------
        $this->db->trans_begin();
        $this->db->select('*');
        $sub_allocation = $this->db->get_where('temp_subject_allocation')->result_array();
        if(count($sub_allocation) > 0){
            foreach($sub_allocation as $key => $data){
                $this->server->select('sa_id');
                $check = $this->server->get_where('subject_allocation',array('sa_id'=>$data['sa_id']))->result_array();
                if(count($check) > 0){
                    $this->server->where('sa_id',$check[0]['sa_id']);
                    unset($sub_allocation[$key]['id']);
                    $this->server->update('subject_allocation',$sub_allocation[$key]);
                }else{
                    unset($sub_allocation[$key]['id']);
                    $this->server->insert('subject_allocation',$sub_allocation[$key]);
                }
            }
            
        }
//         else{
//             echo json_encode(array('subject allocation record not found.','status'=>500));
//         }
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            echo json_encode(array('subject allocation something went wrong.','status'=>500));
        }
        else{
            $this->db->trans_commit();
            $this->db->empty_table('temp_subject_allocation');
            $this->teacher_sync();
        }
    }
    
    function teacher_sync(){
        //-----------------teacher-----------------------
        $this->db->trans_begin();
        $this->db->select('*');
        $teacher = $this->db->get_where('temp_teacher')->result_array();
        if(count($teacher) > 0){
            foreach($teacher as $key => $data){
                $this->server->select('t_id');
                $check = $this->server->get_where('teacher',array('t_id'=>$data['t_id']))->result_array();
                if(count($check) > 0){
                    $this->server->where('t_id',$check[0]['t_id']);
                    unset($teacher[$key]['tt_id']);
                    $this->server->update('teacher',$teacher[$key]);
                }else{
                    unset($teacher[$key]['tt_id']);
                    $this->server->insert('teacher',$teacher[$key]);
                }
            }
        }
//         else{
//             echo json_encode(array('teacher record not found.','status'=>500));
//         }
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            echo json_encode(array('teacher something went wrong.','status'=>500));
        }
        else{
            $this->db->trans_commit();
            $this->db->empty_table('temp_teacher');
            $this->class_teacher_sync();
        }
    }
    
    
    function class_teacher_sync(){//-----------------class teacher-----------------------
        $this->db->trans_begin();
        $this->db->select('*');
        $class_teacher = $this->db->get_where('temp_class_teacher')->result_array();
        if(count($class_teacher) > 0){
            foreach($class_teacher as $key => $data){
                $this->server->select('t_id');
                $check = $this->server->get_where('class_teacher',array('ct_id'=>$data['ct_id']))->result_array();
                if(count($check) > 0){
                    $this->server->where('ct_id',$check[0]['ct_id']);
                    unset($class_teacher[$key]['tct_id']);
                    $this->server->update('class_teacher',$class_teacher[$key]);
                }else{
                    unset($class_teacher[$key]['tct_id']);
                    $this->server->insert('class_teacher',$class_teacher[$key]);
                }
            }
            
        }
//         else{
//             echo json_encode(array('class_teacher record not found.','status'=>500));
//         }
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            echo json_encode(array('class_teacher something went wrong.','status'=>500));
        }
        else{
            $this->db->trans_commit();
            $this->db->empty_table('temp_class_teacher');
            $this->subj_teacher_sync();
        }
    }
    
    function subj_teacher_sync(){//-----------------class teacher-----------------------
        $this->db->trans_begin();
        $this->db->select('*');
        $sub_teacher = $this->db->get_where('temp_sub_teacher')->result_array();
        if(count($sub_teacher) > 0){
            foreach($sub_teacher as $key => $data){
                $this->server->select('st_id');
                $check = $this->server->get_where('sub_teacher',array('st_id'=>$data['st_id']))->result_array();
                if(count($check) > 0){
                    $this->server->where('st_id',$check[0]['st_id']);
                    unset($sub_teacher[$key]['tst_id']);
                    $this->server->update('sub_teacher',$sub_teacher[$key]);
                }else{
                    unset($sub_teacher[$key]['tst_id']);
                    $this->server->insert('sub_teacher',$sub_teacher[$key]);
                }
            }
            
        }
//         else{
//             echo json_encode(array('sub teacher record not found.','status'=>500));
//         }
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            echo json_encode(array('sub teacher something went wrong.','status'=>500));
        }
        else{
            $this->db->trans_commit();
            $this->db->empty_table('temp_sub_teacher');
            $this->student_sync();
        }
    }
    
    function student_sync(){
        $this->db->trans_begin();
        $this->db->select('*');
        $students = $this->db->get_where('temp_students')->result_array();
        if(count($students) > 0){
            foreach($students as $key => $data){
                $this->server->select('std_id');
                $check = $this->server->get_where('students',array('std_id'=>$data['std_id']))->result_array();
                if(count($check) > 0){
                    $this->server->where('std_id',$check[0]['std_id']);
                    unset($students[$key]['tstd_id']);
                    $this->server->update('students',$students[$key]);
                }else{
                    unset($students[$key]['tstd_id']);
                    $this->server->insert('students',$students[$key]);
                }
            }   
        }
        //         else{
        //             echo json_encode(array('sub teacher record not found.','status'=>500));
        //         }
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            echo json_encode(array('student something went wrong.','status'=>500));
        }
        else{
            $this->db->trans_commit();
            $this->db->empty_table('temp_students');
            echo json_encode(array('Sync Successfully','status'=>200));
        }
    }
    
    
}