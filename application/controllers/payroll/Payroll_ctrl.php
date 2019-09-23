<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_ctrl extends CI_Controller {
    function __construct(){
        parent :: __construct();
        $this->load->model('payroll/Payroll_model','payroll_model');
        $this->lang->load('vivaarta_lang', 'english');
        $this->load->library('My_function');
    }
    
    function emp_sub_type(){
        $emp_type = $this->input->post('emp_type');
        $this->db->select('*');
        $result = $this->db->get_where('payroll_employee_sub_type',array('status'=>1,'pet_id'=>$emp_type))->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('data'=>$this->lang->line('something_went_wrong'),'status'=>500));
        }
    }
    
    function employee_edit_details(){
        $emp_id = $this->input->post('edit_id');
        $this->db->select('*');
        $result = $this->db->get_where('payroll_employee_details',array('status'=>1,'emp_id'=>$emp_id))->result_array();
        if(count($result) > 0){
            $emp_sub_type = $this->db->select('*')->get_where('payroll_employee_sub_type',array('status'=>1,'pet_id'=>$result[0]['emp_type']))->result_array();
            echo json_encode(array('data'=>$result,'emp_sub_type'=>$emp_sub_type,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found.','status'=>500));
        }
    }
    
    function master_entry(){
        $id = $this->input->post('m_id');
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->session->userdata('school_id');
        $data['emp_type'] = 1;
        $data['da_percentage'] = $this->input->post('da_percentage');
        $data['pa_percentage'] = $this->input->post('pa_percentage');
        $data['samiti_pf'] = $this->input->post('samiti_pf');
        $data['emp_pf'] = $this->input->post('emp_pf');
        $data['samiti_esic'] = $this->input->post('samiti_esic');
        $data['emp_esic'] = $this->input->post('emp_esic');
        $data['samiti_t_ded'] = $this->input->post('samiti_t_ded');
        $data['emp_t_ded'] = $this->input->post('emp_t_ded');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $this->session->userdata('user_id');
        
        $result = $this->payroll_model->master_entry($id,$data);
        if($result){
            echo json_encode(array('msg'=>$this->lang->line('master_record_updated'),'status'=>200));
        }else{
            echo json_encode(array('msg'=>$this->lang->line('master_record_update_error'),'status'=>500));
        }
    }
    
    function advance_id_list(){
        $data['edit_id'] = $this->input->post('edit_id');
        $this->db->select('*');
        $result = $this->db->get_where('payroll_advance',array('status'=>1,'e_ad_id'=>$data['edit_id']))->result_array();
        if(count($result) > 0){
            $employee = $this->db->select('emp_id,emp_name,emp_generated_id')->get_where('payroll_employee_details',array('status'=>1,'sch_id'=>$result[0]['sch_id'],'ses_id'=>$result[0]['ses_id']))->result_array();
            
            echo json_encode(array('data'=>$result,'employee'=>$employee,'status'=>200));
        }else{
            echo json_encode(array('data'=>'Record not found','status'=>500));
        }
    }
    
    function school_employee_list(){
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->input->post('sch_id');
        
        $this->db->select('emp_id,emp_name,emp_generated_id');
        $result = $this->db->get_where('payroll_employee_details',array('status'=>1,'ses_id'=>$data['ses_id'],'sch_id'=>$data['sch_id']))->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found.','status'=>500));
        }
    }
    
    function advance_list(){
        $this->db->select('pa.*,DATE_FORMAT(pa.advance_date,"%d-%M-%Y") advance_date,ped.emp_name');
        $this->db->join('payroll_employee_details ped','ped.emp_id = pa.emp_id AND ped.status = 1');
        $result = $this->db->get_where('payroll_advance pa',array('pa.status'=>1))->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found.','status'=>500));
        }
    }
    
    function advance_submit(){
        $e_ad_id = $this->input->post('e_ad_id');
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['month'] = $this->input->post('month');
        $data['sch_id'] = $this->input->post('school');
        $data['emp_id'] = $this->input->post('employee');
        $data['advance_date'] = date('Y-m-d');
        $data['advance_amount'] = $this->input->post('advance');
        $data['created_by'] = $this->session->userdata('user_id');
        $data['created_at'] = date('Y-m-d H:i:s');
        if(!empty($e_ad_id)){
            $this->db->where('e_ad_id',$e_ad_id);
            $result = $this->db->update('payroll_advance',$data);
        }else{
            $result = $this->db->insert('payroll_advance',$data);
        }
        if($result){
            echo json_encode(array('msg'=>$this->lang->line('advance_added_success'),'status'=>200));
        }else{
            echo json_encode(array('msg'=>$this->lang->line('advance_added_failed'),'status'=>500));
        }
    }
    
    function delete_advance(){
        $id = $this->input->post('delete_id');
        $this->db->where('e_ad_id',$id);
        $result = $this->db->update('payroll_advance',array('status'=>0));
        if($result){
            echo json_encode(array('msg'=>$this->lang->line('record_delete_success'),'status'=>200));
        }else{
            echo json_encode(array('msg'=>$this->lang->line('record_delete_failed'),'status'=>500));
        }
    }
    
    function employee_attendance_list(){
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->input->post('sch_id');
        $data['emp_type'] = $this->input->post('emp_type');
        $data['emp_sub_type'] = $this->input->post('emp_sub_type');
        $data['month'] = $this->input->post('month');
        
        $condtion = 'ped.status = 1';
        $condt = 'status = 1';
        
        if($data['ses_id']){
            $condtion .= ' AND ped.ses_id = '.$data['ses_id'];
            $condt .= ' AND ses_id = '.$data['ses_id'];
        }
        if($data['sch_id']){
            $condtion .= ' AND ped.sch_id = '.$data['sch_id'];
            $condt .= ' AND sch_id = '.$data['sch_id'];
        }
        if($data['emp_type']){
            $condtion .= ' AND ped.emp_type = '.$data['emp_type'];
            $condt .= ' AND emp_type = '.$data['emp_type'];
        }
        if($data['emp_sub_type']){
            $condtion .= ' AND ped.emp_sub_type = '.$data['emp_sub_type'];
            $condt .= ' AND emp_sub_type = '.$data['emp_sub_type'];
        }
        if($data['month']){
            $condt .= ' AND month = '.$data['month'];
        }
        
        $this->db->select('ped.*,et.name et_name,st.sub_type_name,IFNULL(pa.present,"") present,IFNULL(pa.absent,"") absent');
        $this->db->join('payroll_employee_type et','et.pet_id = ped.emp_type');
        $this->db->join('payroll_employee_sub_type st','st.est_id = ped.emp_sub_type');
        $this->db->join('payroll_attendance pa','pa.emp_id = ped.emp_id AND pa.pam_id = (SELECT pam_id FROM payroll_attendance_master WHERE '.$condt.')','LEFT');
        $this->db->where($condtion);
        $result = $this->db->get_where('payroll_employee_details ped')->result_array();
        
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found','status'=>500));
        }
    }
    
    function emp_attendance(){
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->input->post('sch_id');
        $data['emp_type'] = $this->input->post('emp_type');
        $data['emp_sub_type'] = $this->input->post('emp_sub_type');
        $data['month'] = $this->input->post('month');
        
        $emp_attendance = $this->input->post('emp_attendance');
        
        $final = [];
        foreach($emp_attendance as $emp_atten){
            $temp = [];
            $temp['emp_id'] = $emp_atten[0]['emp_id'];
            $temp['present'] = $emp_atten[1]['attendance'];
            $temp['absent'] = 30 - $emp_atten[1]['attendance'];
            $temp['created_by'] = $this->session->userdata('user_id');
            $temp['created_at'] = date('Y-m-d H:i:s');
            $final[] = $temp;
        }
        
        $result = $this->payroll_model->emp_attendance($data,$final);
        
        if($result){
            echo json_encode(array('msg'=>$this->lang->line('atten_submit_success'),'status'=>200));
        }else{
            echo json_encode(array('msg'=>$this->lang->line('atten_submit_failed'),'status'=>500));
        }
        
    }
    
    
    function employee_list(){
        $data['ses_id'] = $this->input->post('ses_id');
        $data['sch_id'] = $this->input->post('sch_id');
        $data['emp_type'] = $this->input->post('emp_type');
        $data['emp_sub_type'] = $this->input->post('emp_sub_type');
        $data['gender'] = $this->input->post('gender');
        
        $condtion = 'ped.status = 1';
        if($data['ses_id']){
            $condtion .= ' AND ped.ses_id = '.$data['ses_id'];
        }
        if($data['sch_id']){
            $condtion .= ' AND ped.sch_id = '.$data['sch_id'];
        }
        if($data['emp_type']){
            $condtion .= ' AND ped.emp_type = '.$data['emp_type'];
        }
        if($data['emp_sub_type']){
            $condtion .= ' AND ped.emp_sub_type = '.$data['emp_sub_type'];
        }
        if($data['gender']){
            $condtion .= ' AND ped.gender = '.$data['gender'];
        }
        
        
        $this->db->select('ped.*,et.name et_name,st.sub_type_name');
        $this->db->join('payroll_employee_type et','et.pet_id = ped.emp_type');
        $this->db->join('payroll_employee_sub_type st','st.est_id = ped.emp_sub_type');
        $this->db->where($condtion);
        $result = $this->db->get_where('payroll_employee_details ped')->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found','status'=>500));
        }
    }
    
    
    function submit_new_employee(){
        $data = $this->input->post();
        $id = $this->input->post('emp_id');
        
        if(!is_dir('./assets/images/payroll/employees')){
            mkdir('./assets/images/payroll/employees');
        }
        $path = './assets/images/payroll/employees/';
        
        if(!empty($_FILES['emp_image']['name'])){
            //------------remove old image------------------
            if(!empty($data['old_emp_image']) && file_exists($path.$data['old_emp_image']))
            {
                unlink($path.$data['old_emp_image']);
            }
            //---------uploading process----------------
            $imagename=$_FILES['emp_image']['name']; //get file name
            $ext=pathinfo($imagename,PATHINFO_EXTENSION); // get file extention--
            $data['emp_image'] = time().'.'.$ext; // replace name acording to admission number
            $temp = $_FILES['emp_image']['tmp_name'];
            move_uploaded_file($temp,$path.$data['emp_image']);
        }
        else{
            $data['emp_image'] = $data['old_emp_image'];
        }
        
        unset($data['old_emp_image']);
        unset($data['emp_id']);
        //print_r($data);die;
        $result = $this->payroll_model->submit_new_employee($id,$data);
        if($result){
            echo json_encode(array('msg'=>$this->lang->line('new_employee_added'),'status'=>200));
        }else{
            echo json_encode(array('msg'=>$this->lang->line('new_employee_error'),'status'=>500));
        }
    }
    
    
}