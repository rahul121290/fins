<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Subject_allocation_model extends CI_Model{
 
    public function subject_allocate($data){
        $this->db->trans_begin();
        $this->db->select('sa_id,status');
        $this->db->where('ses_id',$data['ses_id']);
        $this->db->where('sch_id',$data['sch_id']);
        $this->db->where('med_id',$data['med_id']);
        $this->db->where('class_id',$data['class_id']);
        $this->db->where('st_id',$data['st_id']);

        if(!empty($data['sg_id'])){
            $this->db->where('sg_id',$data['sg_id']);
        }
        
        $this->db->where('sub_id',$data['sub_id']);
        $result = $this->db->get('subject_allocation')->result_array();
        
        if(count($result) > 0){
            if($result[0]['status'] == 1){//--if status is 1 then 0 update----
                $this->db->where('sa_id', (int)$result[0]['sa_id']);
                $this->db->update('subject_allocation',array('status'=>0));
            }else{//---if status is 0 then 1 update---------------
                $this->db->where('sa_id',(int)$result[0]['sa_id']);
                $this->db->update('subject_allocation',array('status'=>1));
            }
        }//end of if count result condition
        else{
                //-------if not record in data then entry-------------------
                $this->db->insert('subject_allocation', $data);
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
    }//-------end of function-----------------
    
    public function entry_ouf_of_marks($data){
        $this->db->trans_begin();
        
        $this->db->select('out_of_id');
        $result = $this->db->get_where('out_of_marks',array('sa_id'=>(int)$data['sa_id'],'et_id'=>(int)$data['et_id']))->result_array();
        
        if(count($result) > 0 ){
               //----if data is already exist then update marks---------------------
                $this->db->where('out_of_id', $result[0]['out_of_id']);
                $this->db->update('out_of_marks',array('out_of'=>$data['out_of']));
        }else{
            //-------data not in table then insert-----------------------
            $this->db->insert('out_of_marks',$data);
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
    
    public function outOfPracticalMarks($data){
        $this->db->trans_begin();
        $this->db->select('out_of_id');
        $result = $this->db->get_where('out_of_marks',array('sa_id'=>(int)$data['sa_id'],'et_id'=>(int)$data['et_id']))->result_array();
        if(count($result) > 0 ){
           //----if data is already exist then update marks---------------------
            $this->db->where('out_of_id', $result[0]['out_of_id']);
            $this->db->update('out_of_marks',array('practical'=>$data['practical']));
        }else{
            //-------data not in table then insert-----------------------
            $this->db->insert('out_of_marks',$data);
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