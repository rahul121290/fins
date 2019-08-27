<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Attendance_model extends CI_Model{
    
    public function class_attendance($data){
        $final = array();
        foreach($data['class_name'] as $class){
            $temp = array();
            $temp['ses_id'] = $data['session'];
            $temp['sch_id'] = $data['school'];
            $temp['med_id'] = $data['medium'];
            $temp['et_id'] = $data['exam_type'];
            $temp['class_id'] = $class;
            $temp['total_days'] = $data['class_attendace'];
            $temp['created_by'] = $this->session->userdata('user_id');
            $temp['created_at'] = date('Y-m-d H:i:s');
            $final[] = $temp;
        }
         $this->db->insert_batch('attendance_master',$final);
         
         //-----------log report---------------
         $event = 'Add Attendance Master';
         $user = $this->session->userdata('user_id');
         $table_name = 'attendance_master';
         $table_id = $this->db->insert_id();
         $this->my_function->add_log($user,$event,$table_name,$table_id);
         return true;
    }
    
    public function deleteRecord($delete_id){
        $this->db->where('am_id',$delete_id);
        return $this->db->update('attendance_master',array('status'=>0));
    }
    
    public function updateAttendance($id,$data){
        $data1['ses_id'] = $data['session'];
        $data1['sch_id'] = $data['school'];
        $data1['med_id'] = $data['medium'];
        $data1['et_id'] = $data['exam_type'];
        $data1['class_id'] = $data['class_name'];
        $data1['total_days'] = $data['class_attendace'];

        $this->db->where('am_id',$id);
        $this->db->update('attendance_master',$data1);
        
        //-----------log report---------------
        $event = 'Update Attendance Master';
        $user = $this->session->userdata('user_id');
        $table_name = 'attendance_master';
        $table_id = $id;
        $this->my_function->add_log($user,$event,$table_name,$table_id);
        
        return true;
        
    }
    
    public function submitAttendance($data){
        $this->db->trans_begin();
        $this->db->select('sa_id,status');
        $result = $this->db->get_where('std_attendance',array('am_id'=>$data['am_id'],'std_id'=>$data['std_id'],'adm_no'=>$data['adm_no'],'roll_no'=>$data['roll_no'],'status'=>1))->result_array();
        
        if(count($result)>0){
            //----------------update-----------------
            $absent_days = ($data['total_days'] - $data['attendance']);

            $this->db->where('sa_id',$result[0]['sa_id']);
            $this->db->update('std_attendance',array('present_days'=>$data['attendance'],'absent_days'=>$absent_days,'created_by'=>$data['created_by'],'created_at'=>$data['created_at']));
        }else{
            $data1['am_id'] = $data['am_id'];
            $data1['std_id'] = $data['std_id'];
            $data1['adm_no'] = $data['adm_no'];
            $data1['roll_no'] = $data['roll_no'];
            $data1['present_days'] = $data['attendance'];
            $data1['absent_days'] = ($data['total_days'] - $data['attendance']);
            $data1['created_by'] = $data['created_by'];
            $data1['created_at'] = $data['created_at'];
            $this->db->insert('std_attendance',$data1);
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