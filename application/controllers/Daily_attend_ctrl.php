<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily_attend_ctrl extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Daily_attend_model');
        $this->load->library(array('ion_auth'));
    }
 
    public function getSubjects(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $medium = $this->input->post('medium');
        $class = $this->input->post('class_name');
        $sub_group = $this->input->post('sub_group');
        $section = $this->input->post('section');
        $sub_type = $this->input->post('sub_type');
        
        if($this->ion_auth->is_admin()){ //-----------login member is admin---------------------
            $this->db->select('sa.sub_id,s.sub_name,st.st_name');
            $this->db->join('subject s','s.sub_id=sa.sub_id');
            $this->db->join('sub_type st','st.st_id=s.st_id');
            if(!empty($sub_group)){
                $this->db->where('sa.sg_id',$sub_group);
            }
            $this->db->order_by('s.short_order','ASC');
            $result = $this->db->get_where('subject_allocation sa',array('sa.ses_id'=>$session,'sa.sch_id'=>$school,'sa.med_id'=>$medium,'sa.class_id'=>$class,'sa.st_id'=>$sub_type,'sa.status'=>1))->result_array();
        }else{
            //-------------check login member is teacher--------------------
            $this->db->select('t_id,email');
            $this->db->where('email=(SELECT `email` FROM `users` WHERE `id` ='.$this->session->userdata('user_id').')');
            $teacher = $this->db->get_where('teacher')->result_array();
            if(count($teacher)>0){
                //-----------get teacher subjects-------------------------
                $this->db->select('sa.sub_id,s.sub_name,subt.st_name');
                $this->db->join('subject_allocation sa','sa.sa_id=st.sa_id');
                $this->db->join('subject s','s.sub_id=sa.sub_id');
                $this->db->join('sub_type subt','subt.st_id=s.st_id');
                $this->db->where('st.t_id',$teacher[0]['t_id']);
                $this->db->where(array('sa.ses_id'=>$session,'sa.sch_id'=>$school,'sa.med_id'=>$medium,'sa.class_id'=>$class,'sa.st_id'=>$sub_type,'sa.status'=>1));
                if(!empty($sub_group)){
                    $this->db->where('sa.sg_id',$sub_group);
                }
                $this->db->order_by('s.short_order','ASC');
                $result = $this->db->get_where('sub_teacher st',array('st.status'=>1))->result_array();
            }
        }
        
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'This class not allotted any subjecs.','status'=>500));
        }
    }
    
    
    public function getStudentsRecords(){
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->session->userdata('school_id');
        $data['attendance_date'] = $this->input->post('attendance_date');
        $data['period'] = $this->input->post('period');
        $data['med_id'] = $this->input->post('medium');
        $data['class_id'] = $this->input->post('class_name');
        
        if(!empty($this->input->post('sub_group'))){
            $data['sg_id'] = $this->input->post('sub_group');
        }
        
        $data['sec_id'] = $this->input->post('section');
        $data['st_id'] = $this->input->post('sub_type');
        //$data['sub_id'] = $this->input->post('subject');
        $data['status'] = 1;
        
        //------------master table---------------------------
        $this->db->select('dam_id');
        $master_record = $this->db->get_where('daily_attendance_master',$data)->result_array();
        if(count($master_record) > 0){
            $master_id = $master_record[0]['dam_id'];
        }else{
            $master_id = 0;
        }
        
        //--------------get studdet records with marks--------------------------------------
        $this->db->select('sd.std_id,sd.name,sd.adm_no,sd.roll_no,c.class_name, sec.section_name,IF(la.std_id<>"", "L", dsa.attendance) as attendance');
        $this->db->join('class c','c.c_id=sd.class_id');
        $this->db->join('section sec','sec.sec_id=sd.sec_id');
        $this->db->join('daily_student_attendance dsa','dsa.std_id = sd.std_id AND dsa.dam_id ='.$master_id.'','LEFT');
        $this->db->join('leave_application la','la.std_id = sd.std_id AND "'.$data['attendance_date'].'" BETWEEN la.from_date AND la.to_date','LEFT',false);
        $this->db->order_by('sd.roll_no','ASC');
        $students = $this->db->get_where('students sd',array('sd.ses_id'=>$data['ses_id'],'sd.sch_id'=>$data['sch_id'],'sd.medium'=>$data['med_id'],'sd.class_id'=>$data['class_id'],'sd.sec_id'=>$data['sec_id'],'sd.status'=>1))->result_array();
        //print_r($this->db->last_query());die;
        if(count($students)>0){
            echo json_encode(array('students'=>$students,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'Students not found..!','status'=>500));
        }
    }
    
    function attendanceEntry(){
        $data['ses_id'] = $this->session->userdata('session_id');  
        $data['sch_id'] = $this->session->userdata('school_id');
        $data['attendance_date'] = $this->input->post('attendance_date');
        $data['period'] = $this->input->post('period');
        $data['med_id'] = $this->input->post('medium');
        $data['class_id'] = $this->input->post('class_name');
        
        if(!empty($this->input->post('sub_group'))){
            $data['sg_id'] = $this->input->post('sub_group');
        }
        
        $data['sec_id'] = $this->input->post('section');
        $data['st_id'] = $this->input->post('sub_type');
        $data['sub_id'] = $this->input->post('subject');
        
        $attendance = json_decode($this->input->post('attendance'),true);
        
        $final = array();
        foreach($attendance as $atten){
            $temp['adm_no'] = $atten[0]['adm_no'];
            $temp['std_id'] = $atten[1]['std_id'];
            $temp['roll_no'] = $atten[2]['roll_no'];
            $temp['attendance'] = $atten[3]['attendance'];
            $temp['created_by'] = $this->session->userdata('user_id');
            $temp['created_at'] = date('Y-m-d H:i:s');
            $final[] = $temp;
        }
        
         $result = $this->Daily_attend_model->attendanceEntryServer($data,$final);
         if($result){
             echo json_encode(array('feedback'=>'Insert Successfully','status'=>200));
         }else{
             echo json_encode(array('feedback'=>'Falied Proccess Attendance Entry, Please try again.','status'=>500));
         }
    }



}