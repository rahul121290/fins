<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prospectus_ctrl extends CI_Controller {
    function __construct(){
        parent :: __construct();
        $this->load->model('Prospectus_model');
    }
    
    function sellingProspectus(){
        $p_id = $this->input->post('p_id');
        $data['reg_no'] = $this->input->post('reg_no');
        $data['selling_date'] = $this->input->post('selling_date');
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->input->post('school');
        $data['med_id'] = $this->input->post('medium');
        $data['class_id'] = $this->input->post('class_id');
        $data['name'] = $this->input->post('name');
        $data['phone'] = $this->input->post('phone');
        $data['alternate_no'] = $this->input->post('alternate_no');
        $data['address'] = $this->input->post('address');
        $data['amount'] = $this->input->post('amount');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $this->session->userdata('user_id');
        
        $result = $this->Prospectus_model->sellingProspectus($p_id,$data);
        if($result){
            echo json_encode(array('msg'=>'Successfully Submit','status'=>200));
        }else{
            echo json_encode(array('msg'=>'Failed, Please try again.','status'=>500));
        }
    }
    
    function allList(){
        $data['sch_id'] = $this->input->get('sch_id');
        $data['med_id'] = $this->input->get('med_id');
        $data['class_id'] = $this->input->get('class_id');
        $data['from_date'] = $this->input->get('from_date');
        $data['to_date'] = $this->input->get('to_date');
        
        $condition = 'p.status = 1';
        if(!empty($data['sch_id'])){
            $condition .=' AND p.sch_id = '.$data['sch_id'];
        }
        if(!empty($data['med_id'])){
            $condition .=' AND p.med_id = '.$data['med_id'];
        }
        if(!empty($data['class_id'])){
            $condition .=' AND p.class_id = '.$data['class_id'];
        }
        if(!empty($data['from_date'])){
            $condition .=' AND p.selling_date >= "'.$data['from_date'].'"';
        }
        if(!empty($data['to_date'])){
            $condition .=' AND p.selling_date <= "'.$data['to_date'].'"';
        }
        
        $this->db->select('p.*,DATE_FORMAT(p.selling_date,"%d-%M-%Y") selling_date,s.session_name,c.class_name,m.med_name');
        $this->db->join('session s','s.ses_id = p.ses_id AND s.status = 1');
        $this->db->join('class c','c_id = p.class_id AND c.status = 1');
        $this->db->join('medium m','m.med_id = p.med_id AND m.status = 1');
        $this->db->where($condition);
        $result = $this->db->get_where('prospectus p')->result_array();
        //print_r($this->db->last_query());die;
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'record not found.','status'=>500));
        }
    }
    
    function deleteRecord(){
        $delete_id = $this->input->post('delete_id');
        $this->db->where('p_id',$delete_id);
        $result = $this->db->update('prospectus',array('status'=>0));
        if($result){
            echo json_encode(array('msg'=>'Delete Successfull','status'=>200));
        }else{
            echo json_encode(array('msg'=>'Delete Failed','status'=>500));
        }
    }
    
    function editRecord(){
        $edit_id = $this->input->post('edit_id');
        
        $this->db->select('*');
        $result = $this->db->get_where('prospectus',array('status'=>1,'p_id'=>$edit_id))->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'record not found.','status'=>500));
        }
    }
    
}