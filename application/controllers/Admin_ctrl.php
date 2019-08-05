<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_ctrl extends CI_Controller {
    var $permission;
    function __construct(){
        parent :: __construct();
        $this->load->library(array('ion_auth','My_function'));
        if ($this->ion_auth->logged_in()){
            $this->permission = $this->my_function->user_permission();
        }else{
            redirect('auth/login');
        }
    }
    
    function _load_view(){
        if ($this->ion_auth->logged_in()){
            $this->data['site_name'] = 'Vivartha';
            $this->data['site_title'] = 'Vivartha';
            $this->load->view("template/temp", $this->data);
        }else{
            redirect('auth/login');
        }
    }
    
    function _admin_class_teacher_access(){
        if ($this->ion_auth->logged_in()){
            $user_id = $this->session->userdata('user_id');
            $session = $this->session->userdata('session_id');
            $school = $this->session->userdata('school_id');
            
//             $this->db->select('ct.med_id,ct.class_id,ct.sec_id,ct.sg_id,t.email');
//             $this->db->join('teacher t','t.t_id=ct.t_id');
//             $this->db->where('t.email=(SELECT `email` FROM `users` WHERE `id` ='.$user_id.')');
//             $is_class_teacher = $this->db->get_where('class_teacher ct',array('ct.ses_id'=>$session,'sch_id'=>$school,'ct.status'=>1))->result_array();
           
            $this->db->select('ct.med_id,ct.class_id,ct.sec_id,ct.sg_id');
            $this->db->join('users u','u.t_id = ct.t_id AND u.id = '.$user_id);
            $is_class_teacher = $this->db->get_where('class_teacher ct',array('ct.ses_id'=>$session,'sch_id'=>$school,'ct.status'=>1))->result_array();
            
            if(count($is_class_teacher) > 0){
                $medium = 'med_id='.$is_class_teacher[0]['med_id'];
                $class = 'c_id='.$is_class_teacher[0]['class_id'];
                $section1 = 'sec_id='.$is_class_teacher[0]['sec_id'];
               // $group = 'sg_id='.$is_class_teacher[0]['sg_id'];
			   //$medium = '1=1';
                //$class = '1=1';
                $section = '1=1';
                $group = '1=1';
            }else{
                $medium = '1=1';
                $class = '1=1';
                $section = '1=1';
				$section1 = '1=1';
                $group = '1=1';
            }
			
            if($this->ion_auth->is_admin() || count($is_class_teacher) > 0  || $this->uri->segment(2) == 'reception'){
                $this->data['site_name'] = 'SMIS';
                $this->data['site_title'] = 'smis';
                $this->data['session'] = $this->db->select('ses_id,session_name')->get_where('session',array('status'=>1))->result_array();
                $this->data['exam_type'] = $this->db->select('et_id,et_name')->get_where('exam_type',array('status'=>1))->result_array();
                $this->data['medium'] = $this->db->select('med_id,med_name')->where($medium)->get_where('medium',array('status'=>1))->result_array();
                $this->data['class'] = $this->db->select('c_id,class_name')->where($class)->get_where('class',array('status'=>1))->result_array();
                $this->data['section'] = $this->db->select('sec_id,section_name')->where($section)->get_where('section',array('status'=>1))->result_array();
                $this->data['section1'] = $this->db->select('sec_id,section_name')->where($section1)->get_where('section',array('status'=>1))->result_array();
                $this->data['group'] = $this->db->select('sg_id,sg_name')->where($group)->get_where('sub_group',array('status'=>1))->result_array();
                $this->data['elective'] = $this->db->select('sub_id,sub_name')->join('sub_type st','st.st_id=s.st_id')->where('st.st_name','elective')->get_where('subject s',array('s.status'=>1))->result_array();
                $this->data['hostel'] = $this->db->select('hid,hostel_name')->get_where('hostel',array('sch_id'=>$school,'status'=>1))->result_array();
                $this->data['bus'] = $this->db->select('bs_id,bus_stoppage')->get_where('bus_structure',array('status'=>1,'school_id'=>$school))->result_array();
                $this->data['month'] = $this->db->select('m_id,m_name')->get_where('month',array('status'=>1))->result_array();
                $this->load->view("template/temp", $this->data);
            }else{
				print_r('Your are not a class teacher or admin.');die;
			}
        }else{
            redirect('auth/login');
        }
    }
    
    function admin_teacher_class_teacher_access(){
        if ($this->ion_auth->logged_in()){
            $user_id = $this->session->userdata('user_id');
            $session = $this->session->userdata('session_id');
            $school = $this->session->userdata('school_id');
            
            $medium = array();
            $class = array();
            $sub_group = array();
            $section = array();
            $sub_type = array();
            $subject = array();

            if($this->ion_auth->is_admin()){
                $medium = '1=1';
                $class = '1=1';
                $section = '1=1';
                $group = '1=1';
                $st = '1=1';
            }else{
                $this->db->select('t.t_id,t.email');
                $this->db->join('teacher t','t.t_id = u.t_id');
                $teacher = $this->db->get_where('users u',array('u.active'=>1,'u.status'=>1,'u.id'=>$user_id))->result_array();
                if(count($teacher) > 0 ){
                    $this->db->select('sa.med_id,sa.class_id,st.sec_id,sa.st_id,sa.sg_id,sa.sub_id');
                    $this->db->join('subject_allocation sa','sa.sa_id=st.sa_id');
                    $this->db->join('class c','c.c_id = sa.class_id');
                    $this->db->join('section sec','sec.sec_id=st.sec_id');
                    $this->db->join('sub_type sub_t','sub_t.st_id=sa.st_id');
                    $this->db->join('sub_group sg','sg.sg_id=sa.sg_id','LEFT');
                    $this->db->join('subject sub','sub.sub_id = sa.sub_id');
                    $this->db->join('teacher t1','t1.t_id=st.t_id');
                    $this->db->where('st.t_id',$teacher[0]['t_id']);
                    $subject_teacher = $this->db->get_where('sub_teacher st',array('st.status'=>1))->result_array();
                    
                    if(count($subject_teacher) > 0){
                        foreach($subject_teacher as $sub_teacher){
                            $medium[] = $sub_teacher['med_id'];
                            $class[] = $sub_teacher['class_id'];
                            if($sub_teacher['sg_id']){
                                $sub_group[] = $sub_teacher['sg_id'];
                            }
                            $section[] = $sub_teacher['sec_id'];
                            $sub_type[] = $sub_teacher['st_id'];
                            $subject[] = $sub_teacher['sub_id'];
                        }
                        $medium =  implode(',', array_unique($medium));
                        $class= implode(',', array_unique($class));
                        
                        $sub_group = implode(',', array_unique($sub_group));
                        
                        $section= implode(',', array_unique($section));
                        $sub_type= implode(',', array_unique($sub_type));
                        $subject= implode(',', array_unique($subject));
                        
                        $medium = 'med_id IN ('.$medium.')';
                        $class = 'c_id IN ('.$class.')';
                        $section = 'sec_id IN ('.$section.')';
                        
                        if($sub_group){
                            $group = 'sg_id IN ('.$sub_group.')';
                        }else{
                            $group = 'sg_id IN (0)';
                        }
                        $st = 'st_id IN ('.$sub_type.')';
                        
                    }else{
                        print_r("Your have not assign any subjects for marks entry.");die;
                    }
                }else{
                    print_r("Your are not a teacher or admin");die;
                }
            }
            $this->data['medium'] = $this->db->select('med_id,med_name')->where($medium)->get_where('medium',array('status'=>1))->result_array();
            $this->data['exam_type'] = $this->db->select('et_id,et_name')->get_where('exam_type',array('status'=>1))->result_array();
            $this->data['class'] = $this->db->select('c_id,class_name')->where($class)->get_where('class',array('status'=>1))->result_array();
            $this->data['site_name'] = 'Vivartha';
            $this->data['site_title'] = 'Multi Users';
            $this->load->view("template/temp", $this->data);
        }else{
            redirect('auth/login');
        }
    }
    
    function index(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $this->data['students'] = $this->db->select('count(*) students')->get_where('students',array('status'=>1,'ses_id'=>$session,'sch_id'=>$school))->result_array();
		$this->data['teachers'] = $this->db->select('count(*) teachers')->get_where('teacher',array('status'=>1,'school_id'=>$school))->result_array();
        $this->data['users'] = $this->db->select('count(*) users')->get_where('users',array('status'=>1,'school_id'=>$school))->result_array();
        $this->data['subjects'] = $this->db->select('count(*) subjects')->get_where('subject',array('status'=>1,'st_id'=>1))->result_array();
        $this->data['page_name'] = 'Dashbord';
        $this->data['main'] = 'dashbord/dashbord';
        $this->_load_view();
    }

    function session_master(){
        if(in_array(1, $this->permission)){
            $this->data['page_name'] = 'Session Master';
            $this->data['main'] = 'master/session_master';
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function school_master(){
        if(in_array(2, $this->permission)){
            $this->data['page_name'] = 'School Master';
            $this->data['main'] = 'master/school_master';
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function medium_master(){
        if(in_array(3, $this->permission)){
            $this->data['page_name'] = 'Medium Master';
            $this->data['main'] = 'master/medium_master';
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function class_master(){
        if(in_array(4, $this->permission)){
            $this->data['page_name'] = 'Class Master';
            $this->data['main'] = 'master/class_master';
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function subject_master(){
        if(in_array(5, $this->permission)){
            $this->data['page_name'] = 'Subject Master';
            $this->data['main'] = 'master/subject_master';
            $this->data['sub_type'] = $this->db->select('st_id,st_name')->where('status',1)->get('sub_type')->result_array();
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function subject_allocation(){
        if(in_array(6, $this->permission)){
            $this->data['page_name'] = 'Subject Allocation';
            $this->data['main'] = 'master/subject_allocation';
            
            //-----post data in page-----------------------------------------------
            $this->data['medium'] = $this->db->select('med_id,med_name')->where('status',1)->get('medium')->result_array();
            $this->data['class'] = $this->db->select('c_id,class_name')->where('status',1)->get('class')->result_array();
            $this->data['section'] = $this->db->select('sec_id,section_name')->where('status',1)->get('section')->result_array();
            $this->data['sub_type'] = $this->db->select('st_id,st_name')->where('status',1)->get('sub_type')->result_array();
            $this->data['sub_gorup'] = $this->db->select('sg_id,sg_name')->where('status',1)->get('sub_group')->result_array();
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function add_student(){
        if(in_array(7, $this->permission)){
            $this->data['page_name'] = 'Add Student';
            $this->data['main'] = 'master/add_student';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function add_teacher(){
        if(in_array(8, $this->permission)){
            $this->data['page_name'] = 'Add Teacher';
            $this->data['main'] = 'master/add_teacher';
            $this->data['teachers'] = $this->db->select('*')->order_by('teacher_name','ASC')->get_where('teacher',array('school_id'=>(int)$this->session->userdata('school_id'),'status'=>1))->result_array();
            
			$this->data['medium'] = $this->db->select('med_id,med_name')->where('status',1)->get('medium')->result_array();
            $this->data['class'] = $this->db->select('c_id,class_name')->where('status',1)->get('class')->result_array();
            $this->data['section'] = $this->db->select('sec_id,section_name')->where('status',1)->get('section')->result_array();
            $this->data['sub_type'] = $this->db->select('st_id,st_name')->where('status',1)->get('sub_type')->result_array();
            $this->data['sub_gorup'] = $this->db->select('sg_id,sg_name')->where('status',1)->get('sub_group')->result_array();
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function subject_teacher(){
        if(in_array(9, $this->permission)){
            $this->data['sub_type'] = $this->db->select('st_id,st_name')->where('status',1)->get('sub_type')->result_array();
            $this->data['teachers'] = $this->db->select('t_id,teacher_name')->get_where('teacher',array('status'=>1))->result_array();
            $this->data['page_name'] = 'Subject Teacher';
            $this->data['main'] = 'master/subject_teacher';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function define_user_role(){
        if(in_array(10, $this->permission)){
            $school = $this->session->userdata('school_id');
            $this->data['page_name'] = 'Define User Role';
            $this->data['main'] = 'master/user_role';
            $this->data['teachers'] = $this->db->select('t_id,teacher_name')->order_by('teacher_name','ASC')->get_where('teacher',array('status'=>1,'school_id'=>$school))->result_array();
            $this->data['permission'] = $this->db->select('pid,p_name,category_name')->get_where('permission',array('status'=>1))->result_array();
            $this->data['groups'] = $this->db->select('id,name')->where('id > 1')->get_where('groups')->result_array();
            $this->data['user_list'] = $this->db->select('u.id,u.username,u.email,u.pass_hint')->join('users_groups ug','ug.user_id = u.id')->order_by('u.id','DESC')->where('ug.group_id NOT IN(1,4)')->get_where('users u',array('u.active'=>1,'u.status'=>1,'u.school_id'=>$school))->result_array();
            //print_r($this->db->last_query());die;
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    
    function student_records(){
        if(in_array(19, $this->permission)){
            $this->data['page_name'] = 'Student Records';
            $this->data['main'] = 'report/student_records';
            
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function attendance_entry(){
        if(in_array(11, $this->permission)){
            $session = $this->session->userdata('session_id');
            $school = $this->session->userdata('school_id');
            $this->data['page_name'] = 'Attendance Entry';
            $this->data['main'] = 'transaction/attendance_entry';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function student_attendance(){
        if(in_array(12, $this->permission)){
            $this->data['page_name'] = 'Student Attendance';
            $this->data['main'] = 'transaction/student_attendance';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
        
    }
    
    function daily_attendance(){
        $this->data['page_name'] = 'Daily Attendance';
        $this->data['main'] = 'transaction/daily_attendance';
        $this->admin_teacher_class_teacher_access();
    }
    
    function marks_entry(){
        if(in_array(13, $this->permission)){
            $this->data['page_name'] = 'Marks Entry';
            $this->data['main'] = 'transaction/marks_entry';
            $this->admin_teacher_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function marks_entry_check(){
        if(in_array(14, $this->permission)){
            $this->data['page_name'] = 'Marks Entry Check';
            $this->data['main'] = 'production/marks_entry_check';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function furd_report(){
        if(in_array(15, $this->permission)){
            $this->data['page_name'] = 'Furd Report';
            $this->data['main'] = 'production/furd_report';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
        
    }
    
    function teacher_abstract(){
        if(in_array(16, $this->permission)){
            $this->data['page_name'] = 'Teacher Abstract';
            $this->data['main'] = 'production/teacher_abstract';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function generate_marksheet(){
        if(in_array(17, $this->permission)){
            $this->data['page_name'] = 'Generate Marksheet';
            $this->data['main'] = 'production/generate_marksheet';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function add_division(){
        if(in_array(20, $this->permission)){
            $this->data['medium'] = $this->db->select('med_id,med_name')->get_where('medium',array('status'=>1))->result_array();
            $this->data['page_name'] = 'Add Division';
            $this->data['main'] = 'utilities_and_tools/add_division';
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function add_grade(){
        if(in_array(21, $this->permission)){
            $this->data['medium'] = $this->db->select('med_id,med_name')->get_where('medium',array('status'=>1))->result_array();
            $this->data['page_name'] = 'Add Grade';
            $this->data['main'] = 'utilities_and_tools/add_grade';
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function pay_student_fees(){
        if($this->ion_auth->is_admin()){
            $this->data['session'] = $this->db->select('ses_id,session_name')->get_where('session',array('status'=>1))->result_array();
            $this->data['school'] = $this->db->select('sch_id,school_name')->get_where('school',array('status'=>1))->result_array();
            $this->data['medium'] = $this->db->select('med_id,med_name')->get_where('medium',array('status'=>1))->result_array();
            $this->data['class'] = $this->db->select('c_id,class_name')->get_where('class',array('status'=>1))->result_array();
            $this->data['section'] = $this->db->select('sec_id,section_name')->get_where('section',array('status'=>1))->result_array();
            $this->data['group'] = $this->db->select('sg_id,sg_name')->get_where('sub_group',array('status'=>1))->result_array();
            $this->data['month'] = $this->db->select('m_id,m_name')->get_where('month',array('status'=>1))->result_array();
            $this->data['fees_type'] = $this->db->select('ft_id,ft_name')->get_where('fees_type',array('status'=>1))->result_array();
            $this->data['payment_mode'] = $this->db->select('p_id,pm_name')->get_where('payment_mode',array('status'=>1))->result_array();
            
            $this->data['page_name'] = 'Pay Student Fees';
            $this->data['main'] = 'fees_payment/pay_student_fees';
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function generate_fees_csv(){
        if($this->ion_auth->is_admin()){
            $this->data['session'] = $this->db->select('ses_id,session_name')->get_where('session',array('status'=>1))->result_array();
            $this->data['school'] = $this->db->select('sch_id,school_name')->get_where('school',array('status'=>1))->result_array();
            $this->data['medium'] = $this->db->select('med_id,med_name')->get_where('medium',array('status'=>1))->result_array();
            $this->data['class'] = $this->db->select('c_id,class_name')->get_where('class',array('status'=>1))->result_array();
            $this->data['section'] = $this->db->select('sec_id,section_name')->get_where('section',array('status'=>1))->result_array();
            $this->data['group'] = $this->db->select('sg_id,sg_name')->get_where('sub_group',array('status'=>1))->result_array();
            $this->data['page_name'] = 'Generate Fees CSV';
            $this->data['main'] = 'fees_payment/generate_fees_csv';
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function export_marksheet(){
        if(in_array(18, $this->permission)){
            $this->data['page_name'] = 'Furd Report';
            $this->data['main'] = 'production/export_markssheet';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function helth_general_information(){
        if(in_array(22, $this->permission)){
            $this->data['medium'] = $this->db->select('*')->get_where('medium',array('status'=>1))->result_array();
            $this->data['sub_group'] = $this->db->select('*')->get_where('sub_group',array('status'=>1))->result_array();
            $this->data['page_name'] = 'Furd Report';
            $this->data['main'] = 'helth/general_info';
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function health_activity(){
        if(in_array(23, $this->permission)){
            $this->data['session'] = $this->db->select('*')->get_where('session',array('status'=>1))->result_array();
            $this->data['medium'] = $this->db->select('*')->get_where('medium',array('status'=>1))->result_array();
            $this->data['sub_group'] = $this->db->select('*')->get_where('sub_group',array('status'=>1))->result_array();
            $this->data['page_name'] = 'Furd Report';
            $this->data['main'] = 'helth/health_activity';
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    
    function profile(){
        $user_id = $this->session->userdata('user_id');
        $this->db->select('*');
        $this->db->join('teacher t','t.t_id = u.t_id','LEFT');
        $result = $this->db->get_where('users u',array('u.status'=>1,'u.id'=>$user_id))->result_array();
        $this->data['is_admin'] = $this->ion_auth->is_admin();
        $this->data['page_name'] = 'Profile';
        $this->data['main'] = 'report/profile';
        $this->data['user_details'] = $result;
        $this->_load_view();
    }
    
    function updateProfile(){
        $data['teacher_name'] = $this->input->post('teacher_name');
        $data['gender'] = $this->input->post('gender');
        $data['dob'] = $this->input->post('dob');
        $data['phone'] = $this->input->post('phone');
        $data['email'] = $this->input->post('email');
        $data['prmt_address'] = $this->input->post('prmt_address');
        $data['designation'] = $this->input->post('designation');
        $data['qualifications'] = $this->input->post('qualifications');
        $data['old_image'] = $this->input->post('old_image');
        
        $this->load->model('Teacher_model');
        $result = $this->Teacher_model->updateProfile($data);
        if($result){
            echo json_encode(array('msg'=>'Profile Update Successfully.','status'=>200));
        }else{
            echo json_encode(array('msg'=>'Failed, Please Try again.','status'=>500));
        }
    }
    
    function changePassword(){
        $this->load->library('ion_auth');
        $user_id = $this->session->userdata('user_id');
        $data['old_password'] = $this->input->post('old_password');
        $data['password'] = $this->ion_auth_model->hash_password($this->input->post('confirm_password'),FALSE,FALSE);
        $data['pass_hint'] = $this->input->post('confirm_password'); 
        
        $check_old_pass =  $this->db->get_where('users',array('pass_hint'=>$data['old_password'],'id'=>$user_id))->result_array();
        //print_r($this->db->last_query());die;
       if(count($check_old_pass) > 0){
           $this->db->where('id',$user_id);
           $result = $this->db->update('users',array('password'=>$data['password'],'pass_hint'=>$data['pass_hint']));
           if($result){
               echo json_encode(array('msg'=>'Password Update Successfully','status'=>200));
           }else{
               echo json_encode(array('msg'=>'something went wrong.','status'=>500));
           }
       }else{
           echo json_encode(array('msg'=>'old password not match.','status'=>201));
       }
    }
    
    
    function student_fee(){
        if(in_array(25, $this->permission)){
            $school = $this->session->userdata('school_id');
            
            $this->data['school'] = $this->db->select('*')->get_where('school',array('status'=>1,'sch_id'=>$school))->result_array();
            $this->data['page_name'] = 'Student Fee';
            $this->data['main'] = 'student_fee/student_fee';
            
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function fee_receipt($schoolname,$group_name,$receipt_no){
        if(in_array(25, $this->permission)){
            $session = $this->session->userdata('session_id');
            $school = $this->session->userdata('school_id');
            
            $this->db->select('s.sibling,s.std_id,s.adm_no,s.roll_no,s.name,s.f_name,s.contact_no,s.email_id,s.aadhar_no,s.photo,c.class_name,sec.section_name as section_name,s.sub_group as subgroup,sf.receipt_no,
                           GROUP_CONCAT(m.m_name) month,
                           IF(s.sibling="Yes",fs.sibling_rebate,0) sibling_rebate,
                           IFNULL(SUM(sf.admission_fee),0) admission_fee,
						   IFNULL(SUM(sf.amalgamated_fee),0) amalgamated_fee,
                           IFNULL(SUM(sf.lab_fee),0) lab_fee,
                           IFNULL(SUM(sf.bus_fee),0) bus_fee,
                           IFNULL(SUM(sf.tution_fee),0) tution_fee,
                           IFNULL(SUM(sf.let_fee),0) late_fee,
                           IFNULL(hfs.pay_amount,0) hostel_fee,
                           IFNULL(SUM(sf.let_fee),0) let_fee,
                           IFNULL(SUM(sf.card_charges),0) card_charges,
                           IFNULL(fw.amount,0) fee_waiver_amount,
                            
                           ((IFNULL(SUM(sf.admission_fee),0) + IFNULL(SUM(sf.amalgamated_fee),0) + IFNULL(SUM(sf.lab_fee),0) + IFNULL(SUM(sf.bus_fee),0) + IFNULL(SUM(sf.let_fee),0) + IFNULL(SUM(sf.card_charges),0) + IFNULL(hfs.pay_amount,0) + IFNULL(SUM(sf.tution_fee),0)) - IF(s.sibling="Yes",fs.sibling_rebate,0)) grand_total
                           ');
            $this->db->join('students s','s.adm_no = sf.adm_no AND s.status = 1 AND s.ses_id = '.$session.' AND s.sch_id = '.$school.'');
            $this->db->join('fees_structure fs','fs.ses_id = s.ses_id AND fs.sch_id = s.sch_id AND fs.class_id = s.class_id AND fs.med_id = s.medium AND fs.status = 1');
            $this->db->join('month m','m.m_id = sf.month_id AND m.status = 1');
            $this->db->join('class c','c.c_id = s.class_id AND c.status = 1');
            $this->db->join('section sec','sec.sec_id = s.sec_id AND sec.status = 1');
            $this->db->join('hostel_fee_status hfs','hfs.hfs_id = sf.hfs_id','LEFT');
            $this->db->join('fee_waiver fw','fw.admission_no = sf.adm_no AND fw.session = sf.ses_id AND fw.school_id = sf.sch_id AND fw.month_id = sf.month_id AND fw.approved = 1','LEFT');
            $this->data['result'] = $this->db->get_where('student_fee sf',array('sf.ses_id'=>$session,'sf.sch_id'=>$school,'sf.receipt_no'=>$receipt_no,'sf.status'=>1,'sf.pay_status'=>1))->result_array();
           // print_r($this->db->last_query());die;
            $this->data['word_amount'] = ucwords($this->my_function->number_to_word($this->data['result'][0]['grand_total']));
            
            $this->data['page_name'] = 'Fee Receipt';
            $this->data['main'] = 'student_fee/fee_receipt';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function fee_history(){
        if(in_array(25, $this->permission)){
            $school = $this->session->userdata('school_id');
            $this->data['session'] = $this->db->select('*')->get_where('session',array('status'=>1))->result_array();
            $this->data['school'] = $this->db->select('*')->get_where('school',array('status'=>1,'sch_id'=>$school))->result_array();
            $this->data['medium'] = $this->db->select('*')->get_where('medium',array('status'=>1))->result_array();
            $this->data['class'] = $this->db->select('*')->get_where('class',array('status'=>1))->result_array();
            $this->data['sub_group'] = $this->db->select('*')->get_where('sub_group',array('status'=>1))->result_array();
            $this->data['section'] = $this->db->select('*')->get_where('section',array('status'=>1))->result_array();
            $this->data['month'] = $this->db->select('*')->get_where('month',array('status'=>1))->result_array();
            
            $this->data['page_name'] = 'Fee Receipt';
            $this->data['main'] = 'student_fee/fee_history';
            $this->_load_view();
        }else{
            $this->data['page_name'] = 'Error';
            $this->_load_view('error_page');
        }
    }
    
    function new_admission(){
        if(in_array(25, $this->permission)){
            $this->data['page_name'] = 'New Admission';
            $this->data['main'] = 'student_fee/new_admission';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function admission_fee($sch_id,$adm_no){
        if(in_array(25, $this->permission)){
            $this->data['page_name'] = 'Admission Fee';
            $this->data['main'] = 'student_fee/admission_fee';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function prospectus_selling(){
        if(in_array(26, $this->permission)){
            $this->data['reg_no'] = $this->db->select('(IFNULL(MAX(reg_no),0) + 1) as reg_no')->get_where('prospectus')->result_array();
            $this->data['page_name'] = 'Prospectus Selling';
            $this->data['main'] = 'prospectus/prospectus_selling';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function prospectus_selling_list(){
        if(in_array(26, $this->permission)){
            $this->data['page_name'] = 'Prospectus Selling List';
            $this->data['main'] = 'prospectus/prospectus_selling_list';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function fee_structure(){
        if(in_array(27, $this->permission)){
            $this->data['page_name'] = 'Fee Struture';
            $this->data['main'] = 'student_fee/fee_structure';
            $this->_admin_class_teacher_access();
        }else{
            $this->data['page_name'] = 'Error';
            $this->data['main'] = 'error_page';
        }
    }
    
    function error_page(){
        $this->data['page_name'] = 'Error';
        $this->load->view("error_page", $this->data);
    }
    
}
