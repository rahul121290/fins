<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hostel_students_model extends CI_Model{
    function __construct(){
        parent :: __construct();
    }
    
    function addStudentDetails($data,$final){
        $this->db->trans_begin();
        
        $result = $this->db->select('hs_id')->get_where('hostel_students',array('ses_id'=>$data['ses_id'],'sch_id'=>$data['sch_id'],'med_id'=>$data['med_id'],'adm_no'=>$data['adm_no']))->result_array();
        
        if(count($result) > 0){
            $this->db->where('hs_id',$result[0]['hs_id']);
            $this->db->update('hostel_students',$data);
            
            if($data['cousin'] == 'Yes'){
                $cusion_data = [];
                foreach($final as $key => $cusion){
                    $cusion_data[] = $cusion;
                    $cusion_data[$key]['hsd_id'] = $result[0]['hs_id'];
                }
                //-----------delete old records------------
                $this->db->where('hs_id',$result[0]['hs_id']);
                $this->db->delete('hostel_students');
                
                //----------insert new----------------
                $this->db->insert_batch('cousin_details',$cusion_data);
                
            }else{
                //-----------delete old records---------------
                $this->db->where('hs_id',$result[0]['hs_id']);
                $this->db->delete('hostel_students');
            }
            
            //--------------log---------------------------
            $user = $this->session->userdata('username');
            $event_name = 'Update Hostel Details';
            $table_name = 'hostel_students';
            $table_id = $result[0]['hs_id'];
            $this->my_function->add_log($user,$event_name,$table_name,$table_id);
            
        }else{
            $this->db->insert('hostel_students',$data);
            
            $hsd_id = $this->db->insert_id();
            
            if($data['cousin'] == 'Yes'){    
                $cusion_data = [];
                foreach($final as $key => $cusion){
                    $cusion_data[] = $cusion;
                    $cusion_data[$key]['hsd_id'] = $hsd_id;
                }
                //print_r($cusion_data);die;
                $this->db->insert_batch('cousin_details',$cusion_data);
            }
            
            //--------------log---------------------------
            $user = $this->session->userdata('username');
            $event_name = 'Add Hostel Details';
            $table_name = 'hostel_students';
            $table_id = $hsd_id;
            $this->my_function->add_log($user,$event_name,$table_name,$table_id);
        }
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        } 
    }
    
    function paymentHostelFee($data,$final){
        $this->db->trans_begin();
        
        $this->db->insert('hostel_fee_payment',$data);
        
        $this->db->insert_batch('hfp_method',$final);
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
        
    }
    
    
}