<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Student_ctrl extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('student_model');
    }
    
    private function _ShowMsgs($successfull, $successMsg, $failureMsg){
        if($successfull){
            echo json_encode(array('feedback'=>$successMsg,'feedback_class'=>'alert-success','status'=>200));
        }else{
            echo json_encode(array('feedback'=>$failureMsg,'feedback_class'=>'alert-danger','status'=>500));
        }
    }
    
    public function check_admission_no(){
		$sch_id = $this->session->userdata('school_id');
        $adm_no = $this->input->post('admission_no');
        $result = $this->db->select('adm_no')->get_where('students',array('adm_no'=>$adm_no,'status'=>1,'sch_id'=>$sch_id))->result_array();
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'addmission no not match.','status'=>500));
        }
    }
    
    
    public function check_roll_no(){
        $roll_no = $this->input->post('roll_no');
        
        $result = $this->db->select('roll_no')->get_where('students',array('roll_no'=>$roll_no,'status'=>1,'sch_id'=>$sch_id))->result_array();
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'addmission no not match.','status'=>500));
        }
    }
    
    public function add_student(){
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->session->userdata('school_id');
        
        $std_id = $this->input->post('std_id');
        $old_image = $this->input->post('old_image');
        
        $data['adm_no'] = $this->input->post('adm_no');
        $data['roll_no'] = $this->input->post('roll_no');
        $data['name'] = $this->input->post('name');
        $data['medium'] = $this->input->post('medium');
        $data['class_id'] = $this->input->post('class_id');
        $data['sec_id'] = $this->input->post('sec_id');
        $data['fit'] = $this->input->post('fit');
        $data['elective'] = $this->input->post('elective');
        $data['sub_group'] = $this->input->post('sub_group');
        $data['f_name'] = $this->input->post('f_name');
        $data['m_name'] = $this->input->post('m_name');
        $data['dob'] = $this->input->post('dob');
        $data['gender'] = $this->input->post('gender');
        $data['admission_date'] = $this->input->post('admission_date');
        $data['cast'] = $this->input->post('cast');
        $data['blood_group'] = $this->input->post('blood_group');
        $data['aadhar_no'] = $this->input->post('aadhar_no');
        $data['address'] = $this->input->post('address');
        $data['guardian'] = $this->input->post('guardian');
        $data['local_address'] = $this->input->post('local_address');
        $data['contact_no'] = $this->input->post('contact_no');
        $data['email_id'] = $this->input->post('email_id');
        $data['medical'] = $this->input->post('medical');
        $data['height'] = $this->input->post('height');
        $data['weight'] = $this->input->post('weight');
        $data['tc'] = $this->input->post('tc');
        $data['hostel_id'] = $this->input->post('hostel');
        $data['hostler'] = $this->input->post('hostler');
        
        $data['bus_id'] = $this->input->post('bus_stoppage');
        $data['bus'] = $this->input->post('bus');
        
        $data['created_by'] = $this->session->userdata('user_id');
        $data['created_at'] = date('Y-m-d H:i:s');
        
        if(!empty($std_id)){
            $this->_ShowMsgs(
                $this->student_model->add_student($std_id,$old_image,$data),"Student Update Successfully.","Student Failed to Update, Please try again."
                );
        }else{
            $this->_ShowMsgs(
                $this->student_model->add_student($std_id,$old_image,$data),"Student Insert Successfully.","Student Failed to Insert, Please try again."
                );
            }
        
        }
    
       function getAdmNoRecord(){
		$sch_id = $this->session->userdata('school_id'); 
        $adm_no = $this->input->post('adm_no');
        $this->db->select('s.std_id,s.photo,s.aadhar_no,s.name,s.roll_no,s.adm_no,
                           DATE_FORMAT(s.admission_date, "%d-%M-%Y") as admission_date,
                           s.f_name,s.m_name,
                           DATE_FORMAT(s.dob, "%d-%M-%Y") as dob,
                           s.gender,s.contact_no,s.tc,s.address,
                           c.class_name,
                           sec.section_name,
                           m.med_name,sg.sg_name,s.fit,sb.sub_name
                        ');
        $this->db->join('class c','c.c_id=s.class_id');
        $this->db->join('section sec','sec.sec_id=s.sec_id');
        $this->db->join('medium m','m.med_id=s.medium');
        $this->db->join('sub_group sg','sg.sg_id = s.sub_group','LEFT');
        $this->db->join('subject sb','sb.sub_id = s.elective','LEFT');
        $result = $this->db->get_where('students s',array('s.status'=>1,'s.adm_no'=>$adm_no,'s.sch_id'=>$sch_id))->result_array();
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'recrod not found.!','status'=>500));
        }
    }
    
    
    public function getStudentData(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $medium = $this->input->post('medium');
        $class = $this->input->post('class');
        $fit = $this->input->post('fit');
        $sub_group = $this->input->post('sub_group');
        $section = $this->input->post('section');
        
        $condition = '';
        
        if(!empty($session)){
            $condition  .=" AND s.ses_id =".$session;
        }
        if(!empty($school)){
            $condition  .=" AND s.sch_id =".$school;
        }
        if(!empty($medium)){
            $condition  .=" AND s.medium =".$medium;
        }
        if(!empty($class)){
            $condition  .=" AND s.class_id =".$class;
        }
        if(!empty($fit)){
            $condition  .=" AND s.fit ='".$fit."' ";
        }
        if(!empty($sub_group)){
            $condition  .=" AND s.sub_group =".$sub_group;
        }
        if(!empty($section)){
            $condition  .=" AND s.sec_id =".$section;
        }
        
        $this->db->select('s.std_id,s.photo,s.aadhar_no,s.name,s.roll_no,s.adm_no,
                           DATE_FORMAT(s.admission_date, "%d-%M-%Y") as admission_date,
                           s.f_name,s.m_name,
                           DATE_FORMAT(s.dob, "%d-%M-%Y") as dob,
                           s.gender,s.contact_no,s.tc,s.address,
                           c.class_name,
                           sec.section_name,
                           m.med_name,sg.sg_name,s.fit,sb.sub_name,s.blood_group,s.guardian,s.address,s.local_address,s.medical,s.cast,s.height,s.weight,s.hostler,h.hostel_name,bs.bus_stoppage,s.bus
                        ');
        $this->db->join('class c','c.c_id=s.class_id');
        $this->db->join('section sec','sec.sec_id=s.sec_id');
        $this->db->join('medium m','m.med_id=s.medium');
        $this->db->join('sub_group sg','sg.sg_id = s.sub_group','LEFT');
        $this->db->join('subject sb','sb.sub_id = s.elective','LEFT');
        $this->db->join('hostel h','h.hid = s.hostel_id','LEFT');
        $this->db->join('bus_structure bs','bs.bs_id = s.bus_id','LEFT');
        $this->db->where('1=1 '.$condition);
        $result = $this->db->get_where('students s',array('s.status'=>1))->result_array();
        //print_r($this->db->last_query());die;
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'recrod not found.!','status'=>500));
        }
    }
    
    public function getEditData(){
        $stdId = $this->input->post('id');
        $this->db->select('*');
        $result = $this->db->get_where('students',array('std_id'=>$stdId,'status'=>1))->result_array();
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function deleteRecord(){
        $delete_id = $this->input->post('delete_id');
        $this->_ShowMsgs(
            $this->student_model->deleteRecord($delete_id),"Student Record Delete Successfully","Student Record Failed to Delete,Please try again."
            );
    }
    
    public function csv_import(){
        if(!empty($_FILES['students_csv']['name'])){
            $school = $this->session->userdata('school_id');
            $session = $this->session->userdata('session_id');
            $path = $_FILES['students_csv']['tmp_name'];
            $object = PHPExcel_IOFactory::load($path);
            
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                
                for($row=2; $row <= $highestRow; $row++){
                    $col = 0;
                    $adm_no = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $roll_no = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $medium = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $class_id = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $sec_id = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $sub_group = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $fit = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $elective = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $name = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $f_name = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $m_name = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $dob = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    //$dob = date('Y-m-d',strtotime($dob));
                    $gender = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $cast = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $contact_no = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $email_id = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $aadhar_no = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $height = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $weight = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $address = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $hostel_id = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $hostler = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $blood_group = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $guardian = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $local_address = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $medical = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $tc = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $photo = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                    $admission_date = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                   // $admission_date  = date('Y-m-d', strtotime($admission_date));
                   
                    $data[] = array(
                        'adm_no'=>$adm_no,
                        'roll_no'=>$roll_no,
                        'medium'=>$medium,
                        'sch_id'=>$school,
                        'ses_id' => $session,
                        'class_id'=>$class_id,
                        'sec_id'=>$sec_id,
                        'sub_group'=>$sub_group,
                        'fit'=>$fit,
                        'elective'=>$elective,
                        'name'=>$name,
                        'f_name'=>$f_name,
                        'm_name'=>$m_name,
                        'dob'=>$dob,
                        'gender'=>$gender,
                        'cast'=>$cast,
                        'contact_no'=>$contact_no,
                        'email_id'=>$email_id,
                        'aadhar_no'=>$aadhar_no,
                        'height'=>$height,
                        'weight'=>$weight,
                        'address'=>$address,
                        'hostel_id'=>$hostel_id,
                        'hostler'=>$hostler,
                        'blood_group'=>$blood_group,
                        'guardian'=>$guardian,
                        'local_address'=>$local_address,
                        'medical'=>$medical,
                        'tc'=>$tc,
                        'photo'=>$photo,
                        'admission_date'=>$admission_date,
                        'created_by' => $this->session->userdata('user_id'),
                        'created_at' => date( 'Y-m-d H:i:s')
                    );
                }//end of for loop      
            }
            //print_r($data);die;
            $result = $this->db->insert_batch('students', $data);
            if($result){
                echo  json_encode(array('feedback'=>'CSV Import Successfully.','status'=>200));
            }else{
                echo  json_encode(array('feedback'=>'Somthing went wrong.','status'=>500));
            }
        }
    }
    
}