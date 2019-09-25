<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['(:any)/(:any)/dashbord'] = 'Admin_ctrl/index';
$route['(:any)/(:any)/test'] = 'Admin_ctrl/testing';


$route['(:any)/(:any)/master-record/add-assessment-feedback'] = 'Admin_ctrl/add_feedback';
$route['(:any)/(:any)/master-record/student-feedback'] = 'Admin_ctrl/student_feedback';
$route['(:any)/(:any)/master-record/delinquents-report'] = 'Admin_ctrl/delinquents_report';
$route['(:any)/(:any)/master-record/student-delinquents'] = 'Admin_ctrl/student_delinquents';
$route['(:any)/(:any)/master-record/academic-report'] = 'Admin_ctrl/academic_report';

$route['(:any)/(:any)/master-record/session-master'] = 'Admin_ctrl/session_master';
$route['(:any)/(:any)/master-record/school-master'] = 'Admin_ctrl/school_master';
$route['(:any)/(:any)/master-record/medium-master'] = 'Admin_ctrl/medium_master';
$route['(:any)/(:any)/master-record/class-master'] = 'Admin_ctrl/class_master';
$route['(:any)/(:any)/master-record/subject-master'] = 'Admin_ctrl/subject_master';
$route['(:any)/(:any)/master-record/subject-allocation'] = 'Admin_ctrl/subject_allocation';
$route['(:any)/(:any)/master-record/add-teacher'] = 'Admin_ctrl/add_teacher';
$route['(:any)/(:any)/master-record/subject-teacher'] = 'Admin_ctrl/subject_teacher';

$route['(:any)/(:any)/master-record/define-user-role'] = 'Admin_ctrl/define_user_role';
$route['(:any)/(:any)/master-record/add-student'] = 'Admin_ctrl/add_student';
$route['(:any)/(:any)/master-record/student-records'] = 'Admin_ctrl/student_records';
$route['(:any)/(:any)/master-record/csv-update'] = 'Admin_ctrl/csv_update';

$route['(:any)/(:any)/master-record/sync-master-data'] = 'Admin_ctrl/sync_master_data';
$route['(:any)/(:any)/master-record/upload-student-marks'] = 'Admin_ctrl/upload_student_marks';
$route['(:any)/(:any)/master-record/sibling-details'] = 'Admin_ctrl/sibling_details';


$route['(:any)/(:any)/transaction-record/attendance-entry'] = 'Admin_ctrl/attendance_entry';
$route['(:any)/(:any)/transaction-record/student-attendance'] = 'Admin_ctrl/student_attendance';
$route['(:any)/(:any)/transaction-record/daily-attendance'] = 'Admin_ctrl/daily_attendance';

$route['(:any)/(:any)/transaction-record/marks-entry'] = 'Admin_ctrl/marks_entry';

$route['(:any)/(:any)/production-report/marks-entry-check'] = 'Admin_ctrl/marks_entry_check';
$route['(:any)/(:any)/production-report/furd-report'] = 'Admin_ctrl/furd_report';
$route['(:any)/(:any)/production-report/export-marksheet'] = 'Admin_ctrl/export_marksheet';
$route['(:any)/(:any)/production-report/teacher-abstract'] = 'Admin_ctrl/teacher_abstract';
$route['(:any)/(:any)/production-report/generate-marksheet'] = 'Admin_ctrl/generate_marksheet';

$route['(:any)/(:any)/utilities-and-tools/add-division'] = 'Admin_ctrl/add_division';
$route['(:any)/(:any)/utilities-and-tools/add-grade'] = 'Admin_ctrl/add_grade';

$route['(:any)/(:any)/fees-payment/pay-student-fees'] = 'Admin_ctrl/pay_student_fees';
$route['(:any)/(:any)/fees-payment/generate-fees-csv'] = 'Admin_ctrl/generate_fees_csv';

$route['(:any)/(:any)/helth/general-information'] = 'Admin_ctrl/helth_general_information';
$route['(:any)/(:any)/helth/health-activity'] = 'Admin_ctrl/health_activity';

//----------------student fee-------------------------------------
$route['(:any)/(:any)/student-fee/payment'] = 'Admin_ctrl/student_fee';
$route['(:any)/(:any)/student-fee/payment/(:num)/(:num)/(:num)/(:any)'] = 'Admin_ctrl/fee_payment';

$route['(:any)/(:any)/report/students-report'] = 'Admin_ctrl/fee_report';
$route['(:any)/(:any)/report/student/(:num)/(:num)/(:any)'] = 'Admin_ctrl/student_report';
$route['(:any)/(:any)/report/fee-mis'] = 'Admin_ctrl/fee_histroy';

$route['(:any)/(:any)/student-fee/new-admission'] = 'Admin_ctrl/new_admission';
$route['(:any)/(:any)/student-fee/update-records'] = 'Admin_ctrl/update_records';

$route['(:any)/(:any)/student-fee/admission/(:num)/(:any)'] = 'Admin_ctrl/admission_fee/$1/$2';
$route['(:any)/(:any)/student-fee/receipt/(:any)'] = 'Admin_ctrl/fee_receipt/$1/$2/$3';
$route['(:any)/(:any)/prospectus/selling'] = 'Admin_ctrl/prospectus_selling';
$route['(:any)/(:any)/prospectus/selling-list'] = 'Admin_ctrl/prospectus_selling_list';
$route['(:any)/(:any)/fee-structure/add-new'] = 'Admin_ctrl/fee_structure';
$route['(:any)/(:any)/fee-structure/online-fee'] = 'Admin_ctrl/online_fee';
$route['(:any)/(:any)/fee-structure/data-sync'] = 'Admin_ctrl/data_sync';
$route['(:any)/(:any)/students/recycle-bin'] = 'Admin_ctrl/recycle_bin';

//----------hostel fee--------------------------------
$route['(:any)/(:any)/hostel/add-hostel-details'] = 'Admin_ctrl/add_hostel_details';
$route['(:any)/(:any)/hostel/add-hostel-details/(:num)/(:num)/(:num)'] = 'Admin_ctrl/add_hostel_details/$3/$4/$5';
$route['(:any)/(:any)/hostel/fee-payment/(:num)/(:num)/(:num)'] = 'Admin_ctrl/hostel_fee/$3/$4/$5';
$route['(:any)/(:any)/hostel/fee-payment'] = 'Admin_ctrl/hostel_student_list';
$route['(:any)/(:any)/hostel/receipt/(:num)'] = 'Admin_ctrl/hostel_receipt/$3';
$route['(:any)/(:any)/hostel/hostel-mis'] = 'Admin_ctrl/hostel_report';
$route['(:any)/(:any)/hostel/student-report'] = 'Admin_ctrl/hostel_student_report';

//------------payroll------------------------------
$route['(:any)/(:any)/payroll-master/payroll-master-entry'] = 'Admin_ctrl/payroll_master_entry';
$route['(:any)/(:any)/payroll-master/employee-post-entry'] = 'Admin_ctrl/employee_post_entry';
$route['(:any)/(:any)/payroll-master/new-employee-payroll'] = 'Admin_ctrl/new_employee_payroll';
$route['(:any)/(:any)/payroll-master/employee-salary-records'] = 'Admin_ctrl/employee_salary_records';
$route['(:any)/(:any)/salary/employee-attendance'] = 'Admin_ctrl/payroll_attendance';
$route['(:any)/(:any)/salary/employee-advance'] = 'Admin_ctrl/payroll_advance';
$route['(:any)/(:any)/salary/employee-list'] = 'Admin_ctrl/salary_emp_list';
$route['(:any)/(:any)/salary/salary-generation/(:num)/(:num)'] = 'Admin_ctrl/salary_generation/$3/$4';
$route['(:any)/(:any)/salary/salary-history'] = 'Admin_ctrl/salary_history';
$route['(:any)/(:any)/salary/salary-generation-slip'] = 'Admin_ctrl/salary_generation_slip';
$route['(:any)/(:any)/report/salary-data-sheet'] = 'Admin_ctrl/salary_data_sheet';





$route['(:any)/(:any)/profile'] = 'Admin_ctrl/profile';

$route['(:any)/login'] = 'Auth/login';
$route['admin/logout'] = 'Auth/logout';

$route['default_controller'] = 'Auth/home_page';
$route['404_override'] = 'Admin_ctrl/error_page';
$route['translate_uri_dashes'] = FALSE;
