<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fees_payment_model extends CI_Model {
    
    public function submitFeesRecords($data1,$final){
        $condition = '';
        if(!empty($data1['ses_id'])){
            $condition .=' AND ses_id='.$data1['ses_id']; 
        }
        if(!empty($data1['sch_id'])){
            $condition .=' AND sch_id='.$data1['sch_id'];
        }
        if(!empty($data1['med_id'])){
            $condition .=' AND med_id='.$data1['med_id'];
        }
        if(!empty($data1['class_id'])){
            $condition .=' AND class_id='.$data1['class_id'];
        }
        if(!empty($data1['sec_id'])){
            $condition .=' AND sec_id='.$data1['sec_id'];
        }
        if(!empty($data1['sg_id'])){
            $condition .=' AND sg_id='.$data1['sg_id'];
        }
        if(!empty($data1['month'])){
            $condition .=' AND month='.$data1['month'];
        }
        if(!empty($data1['fees_type'])){
            $condition .=' AND fees_type='.$data1['fees_type'];
        }
        
        $this->db->trans_begin();
        $this->db->where('1=1'.$condition);
        $this->db->update('fees_structure',array('status'=>0));
        
        $this->db->insert('fees_structure',$data1);
        $last_id = $this->db->insert_id();//--------get last inserted id--------------
        
        $final_insert = array();
        foreach($final as $final_data){
            $final_data['f_id'] = $last_id;
            $final_data['created_by'] = $data1['created_by'];
            $final_data['created_at'] = $data1['created_at'];
            $final_insert[] = $final_data;
        }
        $this->db->insert_batch('fees_structure_category',$final_insert); //--------store marks array in mm_id-----------------------
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