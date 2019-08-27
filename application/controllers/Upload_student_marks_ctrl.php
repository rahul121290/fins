<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_student_marks_ctrl extends CI_Controller {
    function __construct(){
        parent :: __construct();
       // $this->server = $this->load->database('server',true);
    }
    
    function upload_student_marks(){
        if(!empty($_FILES['student_marks']['name'])){
            $path = $_FILES['student_marks']['tmp_name'];
            $object = PHPExcel_IOFactory::load($path);
            
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                
                $final = array();
                
                    for($row=2; $row <= $highestRow; $row++){
                        $col = 0;
                            $col = 0;
                            $temp = array();
                            $temp['admission_no'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            $temp['session'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            $temp['school_id'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            $temp['medium'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            if($temp['medium'] == 'English'){
                                $temp['medium'] = 1;
                            }else if($temp['medium'] == 'Hindi'){
                                $temp['medium'] = 2;
                            }else{
                                $temp['medium'] = $temp['medium'];
                            }
                            $temp['class'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            $temp['section'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            $temp['sub_group'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            if($temp['sub_group'] == 'NULL'){
                                $temp['sub_group'] = null;
                            }else if($temp['sub_group'] == 'Maths'){
                                $temp['sub_group'] = 1;
                            }else if($temp['sub_group'] == 'Boilogy'){
                                $temp['sub_group'] = 2;
                            }else if($temp['sub_group'] == 'Commerce'){
                                $temp['sub_group'] = 3;
                            }
                            
                            $temp['exam_type'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            if($temp['exam_type'] == 'Pre Mid'){
                                $temp['exam_type'] = 1;
                            }else if($temp['exam_type'] == 'Mid'){
                                $temp['exam_type'] = 2;
                            }else if($temp['exam_type'] == 'Post Mid'){
                                $temp['exam_type'] = 3;
                            }else if($temp['exam_type'] == 'Final'){
                                $temp['exam_type'] = 4;
                            }
                            $temp['sub_type'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            if($temp['sub_type'] == 'Scholastic' || $temp['sub_type'] == 'scholastic'){
                                $temp['sub_type'] = 1;
                            }else if($temp['sub_type'] == 'Co-Scholastic' || $temp['sub_type'] == 'co-scholastic'){
                                $temp['sub_type'] = 2;
                            }else if($temp['sub_type'] == 'elective'){
                                $temp['sub_type'] = 3;
                            }else{
                                $temp['sub_type'] = $temp['sub_type'];
                            }
                            $temp['subject'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            if($temp['subject'] == 'Economincs' || $temp['subject'] == 'Economics'){
                                $temp['subject'] = 20;
                            }else if($temp['subject'] == 'Accounts'){
                                $temp['subject'] = 27;
                            }else if($temp['subject'] == 'Work Experience'){
                                $temp['subject'] = 29;
                            }else{
                            $subjects = $this->db->select('*')->get_where('subject',array('status'=>1))->result_array();
                                foreach($subjects as $sub){
                                    if($sub['sub_name'] == $temp['subject']){
                                        $temp['subject'] = $sub['sub_id'];
                                    }else{
                                        $temp['subject'] = $temp['subject'];
                                    }
                                }
                            }
                            
                            $temp['marks'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            if($temp['class'] <= 13){
                                $temp['marks_out_of'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            }
                            if($temp['class'] > 13){
                                $temp['practical_marks'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                                if($temp['practical_marks'] == 'NULL'){
                                    $temp['practical_marks'] = NULL;
                                }
                                $temp['marks_out_of'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                                $temp['practical_out_of'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                                $temp['created_at'] = date('Y-m-d H:i:s');
                                $temp['ip'] = $this->input->ip_address();
                            }
                            $final[] = $temp;
                }
            }
            
            print_r($final);die;
            $this->server->trans_begin();
            $this->server->insert_batch('student_marks',$final);
            if ($this->server->trans_status() === FALSE){
                $this->server->trans_rollback();
                return false;
            }
            else{
                $this->server->trans_commit();
                return true;
            }
        }
    }
    
   
}