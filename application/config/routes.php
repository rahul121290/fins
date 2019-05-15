<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['login'] = 'Auth/login';
$route['admin/logout'] = 'Auth/logout';

$route['(:any)/(:any)/dashbord'] = 'Admin_ctrl/index';

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

$route['(:any)/(:any)/transaction-record/attendance-entry'] = 'Admin_ctrl/attendance_entry';
$route['(:any)/(:any)/transaction-record/student-attendance'] = 'Admin_ctrl/student_attendance';
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

$route['(:any)/(:any)/profile'] = 'Admin_ctrl/profile';

$route['(:any)/login'] = 'Auth/login';

$route['default_controller'] = 'Auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
