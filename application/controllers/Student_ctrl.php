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
        
        $data['std_status'] = $this->input->post('admission_status');
        $data['fee_criteria'] = $this->input->post('fee_criteria');
        $data['staff_child'] = $this->input->post('staff_child');
        $data['related_std'] = $this->input->post('related_std');
        $data['related_std_board'] = $this->input->post('related_std_board');
        
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
                $this->student_model->add_student($std_id,$old_image,$data),"Student record updated.","Student Failed to Update, Please try again."
                );
        }else{
            $this->_ShowMsgs(
                $this->student_model->add_student($std_id,$old_image,$data),"New student added!","Student Failed to Insert, Please try again."
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
                           m.med_name,sg.sg_name,s.fit,sb.sub_name,fc.fc_name fee_criteria,IFNULL(s.related_std,"-") related_std,IFNULL(s.related_std_board,"-") related_std_board,IFNULL(sc.name,"-") staff_child
                        ');
        $this->db->join('fee_criteria fc','fc.fc_id = s.fee_criteria');
        $this->db->join('staff_child sc','sc.sc_id = s.staff_child','LEFT');
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
                           fc.fc_name fee_criteria,IFNULL(s.related_std,"-") related_std,IFNULL(s.related_std_board,"-") related_std_board,IFNULL(sc.name,"-") staff_child,m.med_name,sg.sg_name,s.fit,sb.sub_name,s.blood_group,s.guardian,s.address,s.local_address,s.medical,s.cast,s.height,s.weight,s.hostler,h.hostel_name,bs.bus_stoppage,s.bus
                        ');
        $this->db->join('fee_criteria fc','fc.fc_id = s.fee_criteria');
        $this->db->join('staff_child sc','sc.sc_id = s.staff_child','LEFT');
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
    
	function csv_update(){
	    if(!empty($_FILES['csv_file']['name'])){
	        $path = $_FILES['csv_file']['tmp_name'];
	        $object = PHPExcel_IOFactory::load($path);
	        
	        foreach($object->getWorksheetIterator() as $worksheet){
	            $highestRow = $worksheet->getHighestRow();
	            $highestColumn = $worksheet->getHighestColumn();
	            
	            for($row=2; $row <= $highestRow; $row++){
	                $col = 0;
	                $school = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
	                if($school == 'shakuntala'){
	                    $school = 1;
	                }
	                $medium = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
	                if($medium == 'English'){
	                    $medium = 1;
	                }else if($medium == 'Hindi'){
	                    $medium = 2;
	                }
	                $class = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
	                if($class == 'NURSERY' || $class == 'Nursery'){
	                    $class = 1;
	                }else if($class == 'LKG'){
	                    $class = 2;
	                }else if($class == 'UKG'){
	                    $class = 3;
	                }else if($class == 'I'){
	                    $class = 4;
	                }else if($class == 'II'){
	                    $class = 5;
	                }else if($class == 'III'){
	                    $class = 6;
	                }else if($class == 'IV'){
	                    $class = 7;
	                }else if($class == 'V'){
	                    $class = 8;
	                }else if($class == 'VI'){
	                    $class = 9;
	                }else if($class == 'VII'){
	                    $class = 10;
	                }else if($class == 'VIII'){
	                    $class = 11;
	                }else if($class == 'IX'){
	                    $class = 12;
	                }else if($class == 'X'){
	                    $class = 13;
	                }else if($class == 'XI'){
	                    $class = 14;
	                }else if($class == 'XII'){
	                    $class = 15;
	                }
	                $section = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
	                if($section == 'A'){
	                    $section = 1;
	                }else if($section == 'B'){
	                    $section = 2;
	                }else if($section == 'C'){
	                    $section = 3;
	                }else if($section == 'D'){
	                    $section = 4;
	                }else if($section == 'E'){
	                    $section = 5;
	                }else if($section == 'F'){
	                    $section = 6;
	                }else if($section == 'G'){
	                    $section = 7;
	                }else if($section == 'H'){
	                    $section = 8;
	                }else if($section == 'I'){
	                    $section = 9;
	                }else if($section == 'J'){
	                    $section = 10;
	                }
	                $adm_no = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
	                $adm_status = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
	                
	                if($adm_status == 'New'){
	                    $adm_status = 'new_student';
	                }else if($adm_status == 'Old'){
	                    $adm_status = 'old_student';
	                }
	                $fee_criteria = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
	                if($fee_criteria == 'general'){
	                    $fee_criteria = 1;
	                }else if($fee_criteria == 'sibling'){
	                    $fee_criteria = 2;
	                }else if($fee_criteria == 'RTE'){
	                    $fee_criteria = 3;
	                }else if($fee_criteria == 'staff'){
	                    $fee_criteria = 4;
	                }
	                $sibling_adm_no = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
	                $staff_child = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
	                if($staff_child == 'first_child'){
	                    $staff_child = 1;
	                }else if($staff_child == 'second_child'){
	                    $staff_child = 2;
	                }
	                $hostller = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
	                if($hostller == 'YES'){
	                    $hostller = 'Yes';
	                }else if($hostller == 'NO'){
	                    $hostller = 'No';
	                }
	                
	                $data[] = array(
	                    'school'=>$school,
	                    'medium'=>$medium,
	                    'class'=>$class,
	                    'section'=>$section,
	                    'adm_no'=>(int)$adm_no,
	                    'adm_status'=>$adm_status,
	                    'fee_criteria'=>$fee_criteria,
	                    'sibling_adm_no'=>$sibling_adm_no,
	                    'staff_child'=>$staff_child,
	                    'hostller'=>$hostller
	                );
	            }//end of for loop
	        }
	     // print_r($data);die;
	        $this->db->trans_begin();
	        foreach($data as $data1){
	            $this->db->where(array('ses_id'=>3,'sch_id'=>$data1['school'],'medium'=>$data1['medium'],'adm_no'=>$data1['adm_no']));
	            $this->db->update('students',array('std_status'=>$data1['adm_status'],'fee_criteria'=>$data1['fee_criteria'],'staff_child'=>$data1['staff_child'],'related_std'=>$data1['sibling_adm_no'],'hostler'=>$data1['hostller'],'status'=>1));
	         //   print_r($this->db->last_query());die;
	        }
	        if ($this->db->trans_status() === FALSE)
	        {
	            $this->db->trans_rollback();
	            echo json_encode(array('msg'=>'Update Failed, Please try again.','status'=>500));
	        }
	        else
	        {
	            $this->db->trans_commit();
	            echo json_encode(array('msg'=>'Students Update Successfully','status'=>200));
	        }
	        
	    }
	}
	
	function print_record(){
	    $data['session'] = $this->session->userdata('session_id');
	    $data['sibling'] = $this->input->post('sibling');
	    $data['school'] = $this->input->post('school');
	    $data['medium'] = $this->input->post('medium');
	    $data['class_name'] = $this->input->post('class_name');
	    $data['section'] = $this->input->post('section');
	    $data['search_box'] = $this->input->post('search_box');
	    
	    $condition = 's.status = 1';
	    
	    if($data['sibling']){
	        $condition .=' AND s.fee_criteria = '.$data['sibling'];
	    }
	    
	    if($data['session']){
	        $condition .=' AND s.ses_id = '.$data['session'];
	    }
	    if($data['school']){
	        $condition .=' AND s.sch_id = '.$data['school'];
	    }
	    if($data['medium']){
	        $condition .=' AND s.medium = '.$data['medium'];
	    }
	    if($data['class_name']){
	        $condition .=' AND s.class_id = '.$data['class_name'];
	    }
	    if($data['section']){
	        $condition .=' AND s.sec_id = '.$data['section'];
	    }
	    
	    if($data['search_box']){
	        $condition .=' AND (s.adm_no = '.$data['search_box'] .'OR s.name  LIKE "'.$data['search_box'].'%")';
	    }
	    
	    $this->db->select('s.adm_no,s.name,s.f_name,s.contact_no,c.class_name,sec.section_name,fc.fc_name,IFNULL(sc.name,"") staff_child,sch.sch_id,sch.school_name,related_std,related_std_board');
	    $this->db->join('school sch','sch.sch_id = s.sch_id');
	    $this->db->join('class c','c.c_id = s.class_id');
	    $this->db->join('section sec','sec.sec_id = s.sec_id');
	    $this->db->join('fee_criteria fc','fc.fc_id = fee_criteria');
	    $this->db->join('staff_child sc','sc.sc_id = s.staff_child','LEFT');
	    $this->db->where($condition);
	    $result = $this->db->get_where('students s')->result_array();
	    
	    $final = [];
	    
	    if(count($result) > 0){
	        foreach($result as $key => $res){
	            $flag = 1;
	            $temp = [];
	            $temp['adm_no'] = $res['adm_no'];
	            $temp['name'] = $res['name'];
	            $temp['f_name'] = $res['f_name'];
	            $temp['contact_no'] = $res['contact_no'];
	            $temp['class_name'] = $res['class_name'];
	            $temp['section_name'] = $res['section_name'];
	            $temp['fc_name'] = $res['fc_name'];
	            $temp['staff_child'] = $res['staff_child'];
	            if($res['sch_id'] == 3){
	                $temp['school_name'] = 'CG Board';
	            }else{
	                $temp['school_name'] = 'CBSE';
	            }
	             
	            $temp['related_std'] = $res['related_std'];
	            $temp['related_std_board'] = $res['related_std_board'];
	            
	            if($res['related_std']){
	                $this->db->select('s.adm_no,s.name,s.f_name,s.contact_no,c.class_name,sec.section_name,fc.fc_name,IFNULL(sc.name,"") staff_child,sch.sch_id,sch.school_name');
	                $this->db->join('school sch','sch.sch_id = s.sch_id');
	                $this->db->join('class c','c.c_id = s.class_id');
	                $this->db->join('section sec','sec.sec_id = s.sec_id');
	                $this->db->join('fee_criteria fc','fc.fc_id = fee_criteria');
	                $this->db->join('staff_child sc','sc.sc_id = s.staff_child','LEFT');
	                $this->db->where(array('s.ses_id'=>$data['session'],'s.adm_no'=>$res['related_std'],'s.sch_id'=>$res['related_std_board']));
	                $result1 = $this->db->get_where('students s')->result_array();
	               // print_r($this->db->last_query());die;
	                
	                if(count($result1) > 0){
	                    $temp['related_adm_no'] = $result1[0]['adm_no'];
	                    $temp['related_name'] = $result1[0]['name'];
	                    $temp['related_f_name'] = $result1[0]['f_name'];
	                    $temp['related_contact_no'] = $result1[0]['contact_no'];
	                    $temp['related_class_name'] = $result1[0]['class_name'];
	                    $temp['related_section_name'] = $result1[0]['section_name'];
	                    $temp['related_fc_name'] = $result1[0]['fc_name'];
	                    $temp['related_staff_child'] = $result1[0]['staff_child'];
	                    
	                    if($result1[0]['sch_id'] == 3){
	                        $temp['related_school_name'] = 'CG Board';
	                    }else{
	                        $temp['related_school_name'] = 'CBSE';
	                    }
	                    
	                }else{
	                    $flag = 0;
	                    $temp['related_adm_no'] = "";
	                    $temp['related_name'] = "";
	                    $temp['related_f_name'] = "";
	                    $temp['related_contact_no'] = "";
	                    $temp['related_class_name'] = "";
	                    $temp['related_section_name'] = "";
	                    $temp['related_fc_name'] = "";
	                    $temp['related_staff_child'] = "";
	                }
	            }else{
	                if($flag == 1){
	                    $temp['related_adm_no'] = "";
	                    $temp['related_name'] = "";
	                    $temp['related_f_name'] = "";
	                    $temp['related_contact_no'] = "";
	                    $temp['related_class_name'] = "";
	                    $temp['related_section_name'] = "";
	                    $temp['related_fc_name'] = "";
	                    $temp['related_staff_child'] = "";
	                }   
	            }
	            $final[] = $temp;
	        }
	    }
	  //  print_r($final);die;
	    if(count($final) > 0){
	        echo json_encode(array('data'=>$final,'status'=>200));
	    }else{
	        echo json_encode(array('msg'=>'record not found.','status'=>500));
	    }
	}
	
	function add_feedback(){
	    $af_id = $this->input->post('af_id');
	    $data['medium'] = $this->input->post('medium');
	    $data['feedback'] = $this->input->post('feedback');
	    $data['created_at'] = date('Y-m-d H:i:s');
	    $data['created_by'] = $this->session->userdata('user_id');
	    
	    $this->db->trans_begin();
	    if(!empty($af_id)){
	        //-----------update---------------
	        $this->db->where('af_id',$af_id);
	        $this->db->update('assessment_feedback',$data);
	    }else{
	        //------------insert-------------
	        $this->db->insert('assessment_feedback',$data);
	    }
	    
	    if ($this->db->trans_status() === FALSE)
	    {
	        $this->db->trans_rollback();
	        echo json_encode(array('msg'=>'Feedback adding failed, Please try again.','status'=>500));
	    }
	    else
	    {
	        $this->db->trans_commit();
	        echo json_encode(array('msg'=>'Feedback added successfully','status'=>200));
	    }
	    
	}
	
	function delinquents_report(){
    	$data['ses_id'] = $this->session->userdata('session_id');
    	$data['sch_id'] = $this->session->userdata('school_id');
    	$data['medium'] = $this->input->post('medium');
    	$data['class_id'] = $this->input->post('class_name');
    	$data['sec_id'] = $this->input->post('section');
    	$data['warning'] = $this->input->post('warning');
    	$condition = 's.status = 1';
    	if($data['ses_id']){
    	    $condition .=' AND s.ses_id = '.$data['ses_id'];
    	}
    	if($data['sch_id']){
    	    $condition .=' AND s.sch_id = '.$data['sch_id'];
    	}
    	if($data['medium']){
    	    $condition .=' AND s.medium = '.$data['medium'];
    	}
    	if($data['class_id']){
    	    $condition .=' AND s.class_id = '.$data['class_id'];
    	}
    	if($data['sec_id']){
    	    $condition .=' AND s.sec_id = '.$data['sec_id'];
    	}
    	if($data['warning']){
    	    $condition .=' AND sf.warning_no = '.$data['warning'];
    	}
    	
    	$this->db->select('sf.custom_msg,s.ses_id,s.sch_id,s.medium,s.class_id,s.sec_id,s.adm_no,s.roll_no,s.name,s.f_name,s.contact_no,c.class_name,sec.section_name,DATE_FORMAT(sf.created_at,"%d-%M-%Y") submit_date,sf.warning_no,IFNULL(sf.feedback_ids,0) feedback_ids,IFNULL(sf.action_taken,0) action_taken');
    	$this->db->join('class c','c.c_id = s.class_id');
    	$this->db->join('section sec','sec.sec_id = s.sec_id');
    	$this->db->join('student_feedback sf','sf.adm_no = s.adm_no AND sf.ses_id = s.ses_id AND sf.sch_id = s.sch_id AND s.medium = sf.med_id AND sf.status = 1');
    	$this->db->where($condition);
    	$this->db->order_by('s.class_id,s.sec_id');
    	$students = $this->db->get_where('students s')->result_array();
    	
    	if(count($students) > 0){
    	   $final = [];
    	   foreach($students as $key => $std){
    	       $final[$key] = $std;
    	       $final[$key]['delinquents'] = $this->db->select('*')->where('af_id IN ('.$std['feedback_ids'].')')->get_where('assessment_feedback')->result_array();
    	       $final[$key]['action_taken'] = $this->db->select('*')->where('at_id IN ('.$std['action_taken'].')')->get_where('action_taken')->result_array();
    	   }
    	   if(count($final) > 0){
    	       echo json_encode(array('data'=>$final,'status'=>200));
    	   }else{
    	       echo json_encode(array('msg'=>'Record not found.','status'=>500));
    	   }
    	}else{
    	    echo json_encode(array('msg'=>'Record not found.','status'=>500));
    	}
    	
	}
	
	function student_delinquents_details(){
	    $data['ses_id'] = $this->session->userdata('session_id');
	    $data['sch_id'] = $this->session->userdata('school_id');
	    $data['adm_no'] = $this->input->post('adm_no');
	    
	    $this->db->select('*');
	    $this->db->where($data);
	    $student = $this->db->get_where('students',array('status'=>1))->result_array();
	    
	    
	    $this->db->select('*,DATE_FORMAT(created_at,"%d-%M-%Y") created_at');
	    $this->db->where($data);
	    $result = $this->db->get_where('student_feedback',array('status'=>1))->result_array();
	    
	    $final = [];
	    if(count($result) > 0){
	        foreach($result as $res){
	            $temp = [];
	            $temp['warning_no'] = $res['warning_no'];
	            $temp['created_at'] = $res['created_at'];
	            $temp['custom_msg'] = $res['custom_msg'];
	            //----------------delinquents------------------------
	            if($res['feedback_ids'] == ''){
	                $res['feedback_ids'] = 0;
	            }
	            $delinquents = $this->db->select('*')->where('af_id IN('.$res['feedback_ids'].')')->get_where('assessment_feedback',array('status'=>1))->result_array();
	            $temp['delinquents'] = $delinquents;
	            
	            //----------------action_taken------------------------
	            if($res['action_taken'] == ''){
	                $res['action_taken'] = 0;
	            }
	            $action_taken = $this->db->select('*')->where('at_id IN('.$res['action_taken'].')')->get_where('action_taken',array('status'=>1))->result_array();
	            $temp['action_taken'] = $action_taken;
	            $final[] = $temp;
	        }
	    }
	    
	    if(count($final) > 0){
	        echo json_encode(array('data'=>$final,'student'=>$student,'status'=>200));
	    }else{
	        echo json_encode(array('msg'=>'Record not found.','status'=>500));
	    }    
	}
	
// 	function delinquents_report(){
// 	    $data['ses_id'] = $this->session->userdata('session_id');
// 	    $data['sch_id'] = $this->session->userdata('school_id');
// 	    $data['medium'] = $this->input->post('medium');
// 	    $data['class_id'] = $this->input->post('class_name');
// 	    $data['sec_id'] = $this->input->post('section');
	    
// 	    $condition = 's.status = 1';
// 	    if($data['ses_id']){
// 	        $condition .=' AND s.ses_id = '.$data['ses_id'];
// 	    }
// 	    if($data['sch_id']){
// 	        $condition .=' AND s.sch_id = '.$data['sch_id'];
// 	    }
// 	    if($data['medium']){
// 	        $condition .=' AND s.medium = '.$data['medium'];
// 	    }
// 	    if($data['class_id']){
// 	        $condition .=' AND s.class_id = '.$data['class_id'];
// 	    }
// 	    if($data['sec_id']){
// 	        $condition .=' AND s.sec_id = '.$data['sec_id'];
// 	    }
	    
// 	    $this->db->select('s.ses_id,s.sch_id,s.medium,s.class_id,s.sec_id,s.adm_no,s.roll_no,s.name,s.f_name,s.contact_no,c.class_name,sec.section_name');
// 	    $this->db->join('class c','c.c_id = s.class_id');
// 	    $this->db->join('section sec','sec.sec_id = s.sec_id');
// 	    $this->db->where($condition);
// 	    $students = $this->db->get_where('students s')->result_array();
	   
// 	    $final = [];
// 	    if(count($students) > 0){
// 	        foreach($students as  $std){
// 	            $temp = [];
// 	            $temp['adm_no'] = $std['adm_no'];
// 	            $temp['roll_no'] = $std['roll_no'];
// 	            $temp['class_name'] = $std['class_name'];
// 	            $temp['section_name'] = $std['section_name'];
// 	            $temp['name'] = $std['name'];
// 	            $temp['f_name'] = $std['f_name'];
// 	            $temp['contact_no'] = $std['contact_no']; 
	            
// 	            $this->db->select('*');
// 	            $this->db->where(array('ses_id'=>$std['ses_id'],'sch_id'=>$std['sch_id'],'med_id'=>$std['medium'],'adm_no'=>$std['adm_no']));
// 	            $student_feedback = $this->db->get_where('student_feedback',array('status'=>1))->result_array();
	            
// 	            if(count($student_feedback) > 0){
// 	                foreach($student_feedback as $s_feedback){
// 	                    $temp_delinq = [];
// 	                    $temp_act_taken = [];
// 	                    $temp_delinq['date'] = $s_feedback['created_at'];
// 	                    $temp_delinq['warning_no'] = $s_feedback['warning_no'];
// 	                    //-----------delinquents-----------------
// 	                    if($s_feedback['feedback_ids'] == ''){
// 	                        $s_feedback['feedback_ids'] = 0;
// 	                    }
// 	                    $this->db->select('*');
// 	                    $this->db->where('af_id IN ('.$s_feedback['feedback_ids'].')');
// 	                    $delinquents = $this->db->get_where('assessment_feedback',array('status'=>1))->result_array();
// 	                    $temp_delinq['data'] = $delinquents;
	                    
// 	                    //-----------Action taken-----------------
// 	                    if($s_feedback['action_taken'] == ''){
// 	                        $s_feedback['action_taken'] = 0;
// 	                    }
	                    
// 	                    $this->db->select('*');
// 	                    $this->db->where('at_id IN ('.$s_feedback['action_taken'].')');
// 	                    $action_taken = $this->db->get_where('action_taken',array('status'=>1))->result_array();
// 	                    $temp_act_taken = $action_taken;
	                    
// 	                    $temp['delinquents'][] = $temp_delinq;
// 	                    $temp['action_taken'][] = $temp_act_taken;
// 	                }
	                
// 	            }
// 	            $final[] = $temp;
// 	        }
	        
// 	        if(count($final) > 0){
// 	            echo json_encode(array('data'=>$final,'status'=>200));
// 	        }else{
// 	            echo json_encode(array('msg'=>'Record not found.','status'=>500));
// 	        }
	        
// 	    }
	    
// 	}
	
}