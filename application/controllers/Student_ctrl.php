<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Student_ctrl extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('student_model');
        $this->load->library('My_function');
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
        //print_r($this->db->last_query());die;
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
        $this->db->order_by('s.roll_no','ASC');
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
	
	function export_records(){
		$data['ses_id'] = $this->session->userdata('session_id');
		$data['sch_id'] = $this->session->userdata('school_id');
		$data['medium'] = $this->input->post('medium');
		$data['class_id'] = $this->input->post('class_name');
		$data['sub_group'] = $this->input->post('sub_group');
		$data['sec_id'] = $this->input->post('section');
		
		$condition = 's.status = 1';
		if(!empty($data['ses_id'])){
			$condition .= ' AND s.ses_id = '.$data['ses_id'];	
		}
		if(!empty($data['sch_id'])){
			$condition .= ' AND s.sch_id = '.$data['sch_id'];	
		}
		if(!empty($data['medium'])){
			$condition .= ' AND s.medium = '.$data['medium'];	
		}
		if(!empty($data['class_id'])){
			$condition .= ' AND s.class_id = '.$data['class_id'];	
		}
		if(!empty($data['sub_group'])){
			$condition .= ' AND s.sub_group = '.$data['sub_group'];	
		}
		if(!empty($data['sec_id'])){
			$condition .= ' AND s.sec_id = '.$data['sec_id'];	
		}
		
		$this->db->select('s.*,ses.session_name,m.med_name,c.class_name,sec.section_name,sg.sg_name');
		$this->db->join('session ses','ses.ses_id = s.ses_id');
		$this->db->join('medium m','m.med_id = s.medium');
		$this->db->join('class c','c.c_id = s.class_id');
		$this->db->join('section sec','sec.sec_id = s.sec_id');
		$this->db->join('sub_group sg','sg.sg_id = s.sub_group','LEFT');
		$this->db->where($condition);
		$result = $this->db->get_where('students s')->result_array();
		//print_r($this->db->last_query());die;
		if(count($result) > 0){
			//-------------generate excel file------------------------
			$phpExcel = new PHPExcel();
			$prestasi = $phpExcel->setActiveSheetIndex(0);
			
			//----------put index name-------------------
			$prestasi->setCellValue('A1', 'adm_no');
			$prestasi->setCellValue('B1', 'roll_no');
			$prestasi->setCellValue('C1', 'session_name');
			$prestasi->setCellValue('D1', 'sch_id');
			$prestasi->setCellValue('E1', 'medium');
			$prestasi->setCellValue('F1', 'class');
			$prestasi->setCellValue('G1', 'section');
			$prestasi->setCellValue('H1', 'sub_group');
			$prestasi->setCellValue('I1', 'fit');
			$prestasi->setCellValue('J1', 'elective');
			$prestasi->setCellValue('K1', 'name');
			$prestasi->setCellValue('L1', 'f_name');
			$prestasi->setCellValue('M1', 'm_name');
			$prestasi->setCellValue('N1', 'dob');
			$prestasi->setCellValue('O1', 'gender');
			$prestasi->setCellValue('P1', 'cast');
			$prestasi->setCellValue('Q1', 'contact_no');
			$prestasi->setCellValue('R1', 'email_id');
			$prestasi->setCellValue('S1', 'aadhar_no');
			$prestasi->setCellValue('T1', 'height');
			$prestasi->setCellValue('U1', 'weight');
			$prestasi->setCellValue('V1', 'address');
			$prestasi->setCellValue('W1', 'hostel_id');
			$prestasi->setCellValue('X1', 'hostler');
			$prestasi->setCellValue('Y1', 'bus_id');
			$prestasi->setCellValue('Z1', 'bus');
			$prestasi->setCellValue('AA1', 'blood_group');
			$prestasi->setCellValue('AB1', 'guardian');
			$prestasi->setCellValue('AC1', 'local_address');
			$prestasi->setCellValue('AD1', 'medical');
			$prestasi->setCellValue('AE1', 'tc');
			$prestasi->setCellValue('AF1', 'photo');
			$prestasi->setCellValue('AG1', 'admission_date');
					
			//---------------------put data in excel----------------------------
			$no=0;
			$rowexcel = 1;
			foreach($result as $row){
				$no++;
				$rowexcel++;
				$prestasi->setCellValue('A'.$rowexcel, $row["adm_no"]);
				$prestasi->setCellValue('B'.$rowexcel, $row["roll_no"]);
				$prestasi->setCellValue('C'.$rowexcel, $row["session_name"]);
				$prestasi->setCellValue('D'.$rowexcel, $row["sch_id"]);
				$prestasi->setCellValue('E'.$rowexcel, $row["med_name"]);
				$prestasi->setCellValue('F'.$rowexcel, $row["class_name"]);
				$prestasi->setCellValue('G'.$rowexcel, $row["section_name"]);
				$prestasi->setCellValue('H'.$rowexcel, $row["sg_name"]);
				$prestasi->setCellValue('I'.$rowexcel, $row["fit"]);
				$prestasi->setCellValue('J'.$rowexcel, $row["elective"]);
				$prestasi->setCellValue('K'.$rowexcel, $row["name"]);
				$prestasi->setCellValue('L'.$rowexcel, $row["f_name"]);
				$prestasi->setCellValue('M'.$rowexcel, $row["m_name"]);
				$prestasi->setCellValue('N'.$rowexcel, $row["dob"]);
				$prestasi->setCellValue('O'.$rowexcel, $row["gender"]);
				$prestasi->setCellValue('P'.$rowexcel, $row["cast"]);
				$prestasi->setCellValue('Q'.$rowexcel, $row["contact_no"]);
				$prestasi->setCellValue('R'.$rowexcel, $row["email_id"]);
				$prestasi->setCellValue('S'.$rowexcel, $row["aadhar_no"]);
				$prestasi->setCellValue('T'.$rowexcel, $row["height"]);
				$prestasi->setCellValue('U'.$rowexcel, $row["weight"]);
				$prestasi->setCellValue('V'.$rowexcel, $row["address"]);
				$prestasi->setCellValue('W'.$rowexcel, $row["hostel_id"]);
				$prestasi->setCellValue('X'.$rowexcel, $row["hostler"]);
				$prestasi->setCellValue('Y'.$rowexcel, $row["bus_id"]);
				$prestasi->setCellValue('Z'.$rowexcel, $row["bus"]);
				$prestasi->setCellValue('AA'.$rowexcel, $row["blood_group"]);
				$prestasi->setCellValue('AB'.$rowexcel, $row["guardian"]);
				$prestasi->setCellValue('AC'.$rowexcel, $row["local_address"]);
				$prestasi->setCellValue('AD'.$rowexcel, $row["medical"]);
				$prestasi->setCellValue('AE'.$rowexcel, $row["tc"]);
				$prestasi->setCellValue('AF'.$rowexcel, $row["photo"]);
				$prestasi->setCellValue('AG'.$rowexcel, $row["admission_date"]);
			}
			
			$date =date('U');
			$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
			
			if(!is_dir('./student_records')){
				mkdir('./student_records');
			}
			$sg_name= '';
			if(!empty($result[0]['sg_name'])){
				$sg_name= '_Group_'.$result[0]['sg_name'];
			}
			$filename = "student_records/Class_".$result[0]['class_name']."_Sec_".$result[0]['section_name']."_".$sg_name."_".$date.".xlsx";
			//----------save excel file----------------------------
			//print_r($filename);die;
			$objWriter->save($filename);
			echo json_encode(array('path'=>$filename,'status'=>200));
		}else{
			echo json_encode(array('msg'=>'record not found.','status'=>500));
		}
		
	}
	
	function discontinue_student_list(){
	    $data['session'] = $this->input->post('session');
	    $data['school'] = $this->input->post('school');
	    $data['medium'] = $this->input->post('medium');
	    $data['search_box'] = $this->input->post('search_box');
	    
	    $condition = 's.status = 0';
	    if(!empty($data['session'])){
	        $condition .= ' AND s.ses_id = '.$data['session'];
	    }
	    if(!empty($data['school'])){
	        $condition .= ' AND s.sch_id = '.$data['school'];
	    }
	    if(!empty($data['medium'])){
	        $condition .= ' AND s.medium = '.$data['medium'];
	    }
	    if(!empty($data['search_box'])){
	        $condition .= ' AND (s.adm_no = "'.$data['session'].'" OR s.name LIKE "'.$data['search_box'].'%")';
	    }
	    
	    
	    $this->db->select('s.std_id,s.adm_no,c.class_name,sec.section_name,s.name,s.f_name,fc.fc_name,IFNULL(sc.name,"-") staff_child');
	    $this->db->join('class c','c.c_id = s.class_id AND c.status = 1');
	    $this->db->join('section sec','sec.sec_id = s.sec_id AND sec.status = 1');
	    $this->db->join('fee_criteria fc','fc.fc_id = s.fee_criteria');
	    $this->db->join('staff_child sc','sc.sc_id = s.staff_child','LEFT');
	    $this->db->where($condition);
	    $this->db->order_by('discontinue_date','DESC');
	    $result = $this->db->get_where('students s')->result_array();
	    
	    if(count($result) > 0){
	        echo json_encode(array('data'=>$result,'status'=>200));
	    }else{
	        echo json_encode(array('msg'=>'record not found.','status'=>500));
	    }
	}
	
	function std_restore(){
	    $std_id = $this->input->post('std_id');
	    
	    $this->db->where('std_id',$std_id);
	    $result = $this->db->update('students',array('status'=>1));
	    if($result){
	        echo json_encode(array('msg'=>'Student restore successfully','status'=>200));
	    }else{
	        echo json_encode(array('msg'=>'Something went wrong.','status'=>500));
	    }
	}
	
	function std_delete(){
	    $std_id = $this->input->post('std_id');
	    
	    $this->db->where('std_id',$std_id);
	    $result = $this->db->delete('students');
	    if($result){
	        echo json_encode(array('msg'=>'Student Delete successfully','status'=>200));
	    }else{
	        echo json_encode(array('msg'=>'Something went wrong.','status'=>500));
	    }
	}
    
}