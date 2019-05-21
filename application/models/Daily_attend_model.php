<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_attend_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
    }

    function attendanceEntryServer($data,$final){
        $this->sdb = $this->load->database('server',true);
        $this->sdb->trans_begin();

        $check_master = $this->sdb->get_where('daily_attendance_master',$data)->result_array();
        if(count($check_master) >0 ){
           $this->sdb->where($data);
           $this->sdb->update('daily_attendance_master',array('status'=>0));
            
            //--------insert--------------------
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            
           $this->sdb->insert('daily_attendance_master',$data);
            $dam_id =$this->sdb->insert_id();
            
            $class_attendance = array();
            foreach ($final as $final_data){
                $temp = $final_data;
                $temp['dam_id'] = $dam_id;
                $class_attendance[] = $temp;
            }
            
           $this->sdb->insert_batch('daily_student_attendance',$class_attendance);
        }else{
            //--------insert--------------------
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            
           $this->sdb->insert('daily_attendance_master',$data);
           $dam_id = $this->sdb->insert_id();
            
            $class_attendance = array();
            foreach ($final as $final_data){
                $temp = $final_data;
                $temp['dam_id'] = $dam_id;
                $class_attendance[] = $temp;
            }
            
           $this->sdb->insert_batch('daily_student_attendance',$class_attendance);
        }
        if ($this->sdb->trans_status() === FALSE)
        {
            $this->sdb->trans_rollback();
            return false;
        }
        else
        {
            $this->sdb->trans_commit();
            unset($data['created_by']);
            unset($data['created_at']);

            return $this->attendanceEntry($data,$final);
        } 
            
    }

    function attendanceEntry($data,$final){
        $this->db->trans_begin();
        
        $check_master = $this->db->get_where('daily_attendance_master',$data)->result_array();
        
        if(count($check_master) >0 ){
            $this->db->where($data);
            $this->db->update('daily_attendance_master',array('status'=>0));
            
            //--------insert--------------------
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            
            $this->db->insert('daily_attendance_master',$data);
            $dam_id = $this->db->insert_id();
            
            $class_attendance = array();
            foreach ($final as $final_data){
                $temp = $final_data;
                $temp['dam_id'] = $dam_id;
                $class_attendance[] = $temp;
            }
            $this->db->insert_batch('daily_student_attendance',$class_attendance);
        }else{
            //--------insert--------------------
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            
            $this->db->insert('daily_attendance_master',$data);
            $dam_id =$this->db->insert_id();

            $class_attendance = array();
            foreach ($final as $final_data){
                $temp = $final_data;
                $temp['dam_id'] = $dam_id;
                $class_attendance[] = $temp;
            }
            $this->db->insert_batch('daily_student_attendance',$class_attendance);
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

}