<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fees_payment_ctrl extends CI_Controller {
    function __construct(){
        parent :: __construct();
        $this->load->model('fees_payment_model');
    }
    
    public function getStudentRecord(){
        $session = $this->session->userdata('user_id');
        $school = $this->session->userdata('school_id');
        
        $data['medium'] = $this->input->post('medium');
        $data['class_name'] = $this->input->post('class_name');
        $data['section'] = $this->input->post('section');
        $data['sub_group'] = $this->input->post('sub_group');
        $data['month'] = $this->input->post('month');
        $data['fees_type'] = $this->input->post('fees_type');
        
        $condition = ' AND s.status=1';
        $category_con = ' AND status=1';
        
        if(!empty($session)){
            $category_con .=' AND ses_id='.$session;
        }
        if(!empty($school)){
            $category_con .=' AND sch_id='.$school;
        }
        if(!empty($data['medium'])){
            $condition .= ' AND s.medium='.$data['medium'];
            $category_con .=' AND med_id='.$data['medium'];
        }
        if(!empty($data['class_name'])){
            $condition .= ' AND s.class_id='.$data['class_name'];
            $category_con .=' AND class_id='.$data['class_name'];
        }
        if(!empty($data['section'])){
            $condition .= ' AND s.sec_id='.$data['section'];
            $category_con .=' AND sec_id='.$data['section'];
        }
        if(!empty($data['sub_group'])){
            $condition .= ' AND s.sub_group='.$data['sub_group'];
            $category_con .=' AND sg_id='.$data['sub_group'];
        }
        if(!empty($data['fees_type'])){
            $category_con .=' AND fees_type='.$data['fees_type'];
        }
        if(!empty($data['month'])){
            $category_con .=' AND month='.$data['month'];
        }
        
        $this->db->select('*');
        if(!empty($data['fees_type'])){
            $this->db->where('ft_id',$data['fees_type']);
        }
        $fees_category = $this->db->get_where('fees_sub_type')->result_array();
        
        $select_con = '';
        foreach($fees_category as $fc){
            $select_con .= "IF(IsNULL(t1.".$fc['name']."),'',".$fc['name'].") as ".$fc['name'].",";
        }
        
        $this->db->select('s.adm_no,s.roll_no,s.name,t1.main_fees,'.$select_con.'t1.discount,t1.total_fees,t1.fine,t1.mode,t1.note');
        $this->db->join('(SELECT * FROM `fees_structure_category` WHERE f_id = (SELECT f_id FROM `fees_structure` WHERE 1=1'.$category_con.')) t1','t1.adm_no=s.adm_no','LEFT');
        $this->db->where('1=1'.$condition);
        $this->db->order_by('s.adm_no','ASC');
        $result = $this->db->get_where('students s')->result_array();
        
        $this->db->select('pm_name');
        $payment_mode = $this->db->get_where('payment_mode',array('status'=>1))->result_array();
        
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'category'=>$fees_category,'payment_mode'=>$payment_mode,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function submitFeesRecords(){
        if(!empty($this->session->userdata('session_id'))){
            $data1['ses_id'] = $this->session->userdata('session_id');
        }
        if(!empty($this->session->userdata('school_id'))){
            $data1['sch_id'] = $this->session->userdata('school_id');
        }
        if(!empty($this->input->post('medium'))){
            $data1['med_id'] = $this->input->post('medium');
        }
        if(!empty($this->input->post('class_name'))){
            $data1['class_id'] = $this->input->post('class_name');
        }
        if(!empty($this->input->post('section'))){
            $data1['sec_id'] = $this->input->post('section');
        }
        if(!empty($this->input->post('sub_group'))){
            $data1['sg_id'] = $this->input->post('sub_group');
        }
        if(!empty($this->input->post('month'))){
            $data1['month'] = $this->input->post('month');
        }
        if(!empty($this->input->post('fees_type'))){
            $data1['fees_type'] = $this->input->post('fees_type');
        }
        $data1['created_by'] = $this->session->userdata('user_id');
        $data1['created_at'] = date('Y-m-d H:i:s');
        
        $data['adm_no'] = $this->input->post('adm_no');
        $data['roll_no'] = $this->input->post('roll_no');
        $data['std_name'] = $this->input->post('std_name');
        $data['admission_fees'] = $this->input->post('admission_fees');
        $data['month_fees'] = $this->input->post('month_fees');
        $data['total_fees'] = $this->input->post('total_fees');
        $data['payment_mode'] = $this->input->post('payment_mode');
        
        $this->db->select('name');
        $category_name = $this->db->get_where('fees_sub_type',array('ft_id'=>$data1['fees_type'],'status'=>1))->result_array();
        
        $final = array();
        foreach($data['adm_no'] as $adm_no_key => $adm_no_val){
            foreach($data['roll_no'] as $roll_no_key => $roll_no_val){
                foreach ($data['std_name'] as $name_key=> $name_val){
                    $temp = array();
                    if($adm_no_key == $roll_no_key && $adm_no_key == $name_key){
                        $temp['adm_no'] = $adm_no_val;
                        $temp['roll_no'] = $roll_no_val;
                        $temp['student_name'] = $name_val;
                        
                        if(!empty($data['admission_fees'])){
                            foreach($data['admission_fees'] as $adm_fees_key => $adm_fees){
                                if($adm_no_key == $adm_fees_key){
                                    $temp['main_fees'] = $adm_fees;
                                }
                            }
                        }
                        
                        if(!empty($data['month_fees'])){
                            foreach($data['month_fees'] as $month_fees_key => $month_fees){
                                if($adm_no_key == $month_fees_key){
                                    $temp['main_fees'] = $month_fees;
                                }
                            }
                        }
                        
                        
                        foreach($category_name as $category){
                            $cat_data[$category['name']] = $this->input->post($category['name']);
                            foreach($cat_data[$category['name']] as $key => $value){
                                if($adm_no_key == $key){
                                    $temp[$category['name']] = $value;
                                }
                            }
                        }
                        
                        if(!empty($data['total_fees'])){
                            foreach($data['total_fees'] as $total_fees_key => $total_fees){
                                if($adm_no_key == $total_fees_key){
                                    $temp['total_fees'] = $total_fees;
                                }
                            }
                        }
                        
                        if(!empty($data['payment_mode'])){
                            foreach($data['payment_mode'] as $mode_key => $mode){
                                if($adm_no_key == $mode_key){
                                    $temp['mode'] = $mode;
                                }
                            }
                        }
                        $final[] = $temp;
                    }
                }              
            }
        }
        
        $result = $this->fees_payment_model->submitFeesRecords($data1,$final);
        
        if($result){
            echo json_encode(array('feedback'=>'Insert Successfully.','status'=>200));
        }else{
            echo json_encode(array('feedback'=>'Insert Failed,Please try again.','status'=>500));
        }
        
    }
    
    public function generateCSV(){
        $data['session'] = $this->input->post('session');
        $data['school'] = $this->session->userdata('school_id');
        $data['medium'] = $this->input->post('medium');
        $data['class_name'] = $this->input->post('class_name');
        $data['sub_group'] = $this->input->post('sub_group');
        $data['section'] = $this->input->post('section');
        
        $this->db->select('*');
        $fees_category = $this->db->get_where('fees_sub_type')->result_array();
        
        $select_con = '';
        foreach($fees_category as $fc){
            $select_con .= "IF(IsNULL(fsc.".$fc['name']."),'',".$fc['name'].") as ".$fc['name'].",";
        }
          
        $codition = ' AND fs.status = 1';
        if(!empty($data['session'])){
            $codition .=' AND fs.ses_id ='.$data['session'];
        }
        if(!empty($data['school'])){
            $codition .=' AND fs.sch_id ='.$data['school'];
        }
        if(!empty($data['medium'])){
            $codition .=' AND fs.med_id ='.$data['medium'];
        }
        if(!empty($data['class_name'])){
            $codition .=' AND fs.class_id ='.$data['class_name'];
        }
        if(!empty($data['section'])){
            $codition .=' AND fs.sec_id ='.$data['section'];
        }
        
        $select_group = '';
        if(!empty($data['sub_group'])){
            $codition .=' AND fs.sg_id ='.$data['sub_group'];
            $select_group = 'sg.sg_name,'; 
        }
        
        $this->db->select('c.class_name,sec.section_name,'.$select_group.'fsc.adm_no,fsc.roll_no,fsc.student_name, IF(IsNULL(m.m_name),"Admission_fees",m.m_name) as fees_type,fsc.main_fees,'.$select_con.'fsc.discount,fsc.fine,fsc.total_fees');
        $this->db->join('fees_structure_category fsc','fsc.f_id=fs.f_id');
        $this->db->join('month m','fs.month=m.m_id','LEFT');
        $this->db->join('fees_type ft','ft.ft_id=fs.fees_type','LEFT');
        $this->db->join('class c','c.c_id=fs.class_id');
        $this->db->join('section sec','sec.sec_id=fs.sec_id');
        if(!empty($data['sub_group'])){
            $this->db->join('sub_group sg','sg.sg_id=fs.sg_id');
        }
        $this->db->where('1=1'.$codition);
        $this->db->order_by('fsc.adm_no','ASC');
        $this->db->order_by('ft.ft_id','ASC');
        $this->db->order_by('m.m_id','ASC');
        $result = $this->db->get_where('fees_structure fs')->result_array();
        $sql = $this->db->last_query();
        $query = $this->db->query($sql);
       
        //-------------generate csv file------------------------   
        $phpExcel = new PHPExcel();
        $prestasi = $phpExcel->setActiveSheetIndex(0);

        $field = 'A';
        $num = 1;
        foreach ($query->list_fields() as $field_name){
            $prestasi->setCellValue($field++.$num, $field_name);
        }
        
        $rowexcel = 1;
        foreach($result as $row){
            $field1 = 'A';
            $rowexcel++;
            foreach ($query->list_fields() as $field_name){
                $prestasi->setCellValue($field1++.$rowexcel,$row[$field_name]);
            }
        }
        
        $date =date('U');
        $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        
        if(!is_dir('./fees_backup')){
            mkdir('./fees_backup');
        }
        
        $sg_name = '';
        if(!empty($result[0]['sg_name'])){
            $sg_name = $result[0]['sg_name'];
        }
        $filename = "fees_backup/FeesRecord_".$result[0]['class_name']."_".$result[0]['section_name']."_".$sg_name."_".$date.".xlsx";
        
         $objWriter->save($filename);
        
         echo json_encode(array('file_path'=>$filename,'status'=>200));
    }
     
}   
