$(document).ready(function() {
    var base_url = $('#base_url').val();

    //----------get current date----------------
    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var currentDate = (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + d.getFullYear();


    $('#marksheet_form').validate({
        rules: {
            session: { required: true },
            medium: { required: true },
            section: { required: true },
            class_name: { required: true }
        },
    });
    //---------------------------*************--------------------------------------------
    $(document).on('click', '#final_marksheet,.final_marksheet', function() {
        var formvalidate = $('#marksheet_form').valid();
        var class_name = $('#class_name').val();
        var sub_group = $('#sub_group').val();
        if (class_name >= 14) {
            if (sub_group == '') {
                $('#sub_group_err').html('This field is required.').css('display', 'block');
                return false
            } else {
                $('#sub_group_err').css('display', 'none');
            }
        }
        if (formvalidate) {
            var formdata = new FormData();
            formdata.append('session', $('#session').val());
            formdata.append('medium', $('#medium').val());
            formdata.append('class_name', $('#class_name').val());
            formdata.append('sub_group', $('#sub_group').val());
            formdata.append('section', $('#section').val());
            formdata.append('std_id', $(this).data('std_id'));

            $.ajax({
                type: 'POST',
                url: base_url + 'Production_ctrl/finalMarkSheetGenerate',
                data: formdata,
                dataType: 'json',
                beforeSend: function() {
                    $('#loader').modal('show');
                },
                success: function(response) {
                    if (response.status == 200) {
                        $('#loader').modal('hide');
                        if ($('#class_name').val() == 12 || $('#class_name').val() == 13) {
                            class_9th_final(response);
                            return false;
                        }

                        if ($('#class_name').val() == 14 || $('#class_name').val() == 15) {
                            final_marksheet_XI_XII(response);
                            return false;
                        }
                        var win = window.open('', "myWindowName", "scrollbars=1,width=1200, height=600");
                        var x = '<link rel="stylesheet" type="text/css" href="' + base_url + 'assets/css/bootstrap.min.css">' +
                            '<link rel="stylesheet" type="text/css" href="' + base_url + 'assets/css/marksheet-result.css">' +
                            '<link rel="stylesheet" type="text/css" media="print" href="' + base_url + 'assets/css/marksheet-result-print.css">';
                        $.each(response.result.final, function(mainkey, value) {
                            x = x + '<div class="modal-content p-head-sec-f ms-full">' +
                                '<img src="' + base_url + 'assets/images/' + response.result.org_details.school[0].school_image + '" style="position:absolute;top:40%;left:30%;margin:0 auto; background-size:cover; background-position:center;opacity: 0.5;filter: alpha(opacity=50);">' +
                                '<div class="modal-header p-header">' +
                                '<div class="col-md-3 c-logo-section"><img class="c-logo" style="width:80px;" src="' + base_url + 'assets/images/cbse-logo.png"></div>' +
                                '<div class="col-md-6 p-logo-sec text-center">' +
                                '<div class="p-school-name-sec">' +
                                '<h2>' + response.result.org_details.school[0].school_name + '</h2>' +
                                '<p>Affiliated to CBSE, New Delhi No. ' + response.result.org_details.school[0].affiliation_no + ' | School No.: ' + response.result.org_details.school[0].school_no + '<br>English &amp; Hindi Medium Senior Secondary School, <br>' + response.result.org_details.school[0].address + '</p>' +
                                '</div>' +
                                '</div>' +
                                '<div class="col-md-3 p-school-logo"><img class="p-logo pull-right" src="' + base_url + 'assets/images/' + response.result.org_details.school[0].school_image + '"></div>' +
                                '</div>' +
                                '<div class="modal-body p-student-body">' +
                                '<div class="student-Information">' +
                                '<div class="text-center">' +
                                '<h5><b>Academic Report Card: ' + response.result.org_details.session[0].session_name + '<br></b></h5>' +
                                '</div>' +
                                '<div class="col-md-10 p-student-info">' +
                                '<div class="student-info-t">' +
                                '<b>STUDENT PARTICULARS</b>' +
                                '</div>' +
                                '<div class="student-per-info">' +
                                '<div class="student-per-info1">' +
                                '<table class="table">' +
                                '<tbody>' +
                                '<tr>' +
                                '<td style="width:35%;">Student\'s Name</td>' +
                                '<td>:' +
                                '<b>' + value.term1.name + '</b>' +
                                '</td>' +
                                '</tr>' +
                                '<tr></tr>' +
                                '<tr>' +
                                '<td>Mother\'s Name</td>' +
                                '<td>: ' + value.term1.m_name + '</td>' +
                                '</tr>' +
                                '<tr></tr>' +
                                '<tr>' +
                                '<td>Father\'s Name</td>' +
                                '<td>: ' + value.term1.f_name + '</td>' +
                                '</tr>' +
                                '<tr></tr>' +
                                '<tr>' +
                                '<td>Contact No.</td>' +
                                '<td>:' + value.term1.contact_no + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Aadhar No.</td>' +
                                '<td>:' + value.term1.aadhar_no + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Address</td>' +
                                '<td class="address-sec">:' + value.term1.address + '</td>' +
                                '</tr>' +
                                '</tbody>' +
                                '</table>' +
                                '</div>' +
                                '<div class="student-per-info2">' +
                                '<table class="table">' +
                                '<tbody>' +
                                '<tr>' +
                                '<td>Date of Birth</td>' +
                                '<td>:' + value.term1.dob + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Adm. No.</td>' +
                                '<td>:' + value.term1.adm_no + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Roll No.</td>' +
                                '<td>:' + value.term1.roll_no + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Class/Section</td>' +
                                '<td>:' + value.term1.class_name + ' \'' + value.term1.section_name + '\'</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Attnd. Mid.Term</td>' +
                                '<td>:' + value.term1.total_days + '/' + value.term1.present_days + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Attnd. Session End</td>' +
                                '<td>:' + value.term2.total_days + '/' + value.term2.present_days + '</td>' +
                                '</tr>' +
                                '</tbody>' +
                                '</table>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="col-md-2 p-student-photo"><img class="student-photo" src="' + base_url + 'assets/images/students/temp/' + value.term1.photo + '?' + Math.random() + '"></div>' +
                                '</div>' +
                                '<div class="results-information p-results-information-f-a col-md-12">' +
                                '<div class="academic-result-t">' +
                                '<b>ACADEMIC PERFORMANCE (Scholastic Areas)</b>' +
                                '</div>' +
                                '<table class="table fullmark-term1">' +
                                '<thead>' +
                                '<tr>' +
                                '<th style="border-bottom:1px solid #b1afaf;" colspan="7">Term 1</th>' +
                                '</tr>' +
                                '<tr>' +
                                '<th style="width:21%;">Subjects</th>' +
                                '<th>Pre Test: 10</th>' +
                                '<th>Note Book: 05</th>' +
                                '<th>Sub Enrichment: 05</th>' +
                                '<th>Half Yearly: 80</th>' +
                                '<th>Marks Obtained: 100</th>' +
                                '<th>Grade</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody>';
                            $.each(response.result.mid_sub, function(k, mid_sub) {
                                $.each(response.result.final[mainkey].marks_obtaint, function(key, marks_obt) {
                                    if (mid_sub.sub_id == marks_obt.sub_id) {

                                        var marks_obtained = marks_obt["mid_" + mid_sub.sub_name + "_obtain"];

                                        if (marks_obtained > 90) {
                                            var grade = 'A1';
                                        } else if (marks_obtained > 80) {
                                            var grade = 'A2';
                                        } else if (marks_obtained > 70) {
                                            var grade = 'B1';
                                        } else if (marks_obtained > 60) {
                                            var grade = 'B2';
                                        } else if (marks_obtained > 50) {
                                            var grade = 'C1';
                                        } else if (marks_obtained > 40) {
                                            var grade = 'C2';
                                        } else if (marks_obtained > 32) {
                                            var grade = 'D';
                                        } else if (marks_obtained > 0) {
                                            var grade = 'E';
                                        } else {
                                            var grade = '-';
                                        }
                                        x = x + '<tr>' +
                                            '<td style="text-align:left;">' + mid_sub.sub_name + '</td>' +
                                            '<td>' + value.term1["pre_" + mid_sub.sub_name] + '</td>' +
                                            '<td>' + value.term1["mid_" + mid_sub.sub_name + '_notebook'] + '</td>' +
                                            '<td>' + value.term1["mid_" + mid_sub.sub_name + '_enrichment'] + '</td>' +
                                            '<td>' + value.term1["mid_" + mid_sub.sub_name] + '</td>' +
                                            '<td>' + marks_obtained + '</td>';
                                        x = x + '<td>' + grade + '</td>' +
                                            '</tr>';
                                    }
                                });
                            });
                            x = x + '</tbody>' +
                                '</table>' +
                                '<table class="table fullmark-term2">' +
                                '<thead>' +
                                '<tr><th style="border-bottom:1px solid #b1afaf;" colspan="6">Term 2</th></tr>' +
                                '<tr><th>Post Test: 10</th><th>Note Book: 05</th><th>Sub Enrichment: 05</th><th>Session Ending Exam: 80</th><th>Marks Obtained: 100</th><th>Grade</th></tr>' +
                                '</thead>' +
                                '<tbody>';
                            $.each(response.result.mid_sub, function(k, mid_sub) {
                                $.each(response.result.final[mainkey].marks_obtaint, function(key, marks_obt) {
                                    if (mid_sub.sub_id == marks_obt.sub_id) {

                                        var marks_obtained = marks_obt["final_" + mid_sub.sub_name + "_obtain"];

                                        if (marks_obtained > 90) {
                                            var grade = 'A1';
                                        } else if (marks_obtained > 80) {
                                            var grade = 'A2';
                                        } else if (marks_obtained > 70) {
                                            var grade = 'B1';
                                        } else if (marks_obtained > 60) {
                                            var grade = 'B2';
                                        } else if (marks_obtained > 50) {
                                            var grade = 'C1';
                                        } else if (marks_obtained > 40) {
                                            var grade = 'C2';
                                        } else if (marks_obtained > 32) {
                                            var grade = 'D';
                                        } else if (marks_obtained > 0) {
                                            var grade = 'E';
                                        } else {
                                            var grade = '-';
                                        }
                                        x = x + '<tr>' +
                                            '<td>' + value.term2["post_" + mid_sub.sub_name] + '</td>' +
                                            '<td>' + value.term2["final_" + mid_sub.sub_name + '_notebook'] + '</td>' +
                                            '<td>' + value.term2["final_" + mid_sub.sub_name + '_enrichment'] + '</td>' +
                                            '<td>' + value.term2["final_" + mid_sub.sub_name] + '</td>' +
                                            '<td>' + marks_obtained + marks_obt.star + '</td>';
                                        x = x + '<td>' + grade + '</td>' +
                                            '</tr>';
                                    }
                                });
                            });

                            x = x + '</tbody>' +
                                '</table>' +
                                '</div>' +
                                '<div class="results-information p-results-information-f-c col-md-12" style="margin-top:8px;margin-bottom:6px;">' +
                                '<div class="academic-result-t" style="background-color:rgba(241,241,241,0.0)!important;">' +
                                '<b>Co-Scholastic Areas</b>' +
                                '</div>' +
                                '<table style="width:50%;float:left;" class="table">' +
                                '<thead>' +
                                '<tr><th>Term 1 [on a 3-point (A-C) grading scale]</th><th>Grade</th></tr>' +
                                '</thead>' +
                                '<tbody>';
                            $.each(response.result.co_scholistic_sub, function(key, so_sch) {
                                x = x + '<tr>' +
                                    '<td style="text-align:left;">' + so_sch['sub_name'] + '</td>' +
                                    '<td align="center">' + value.term1[so_sch['sub_name']] + '</td>' +
                                    '</tr>';
                            });
                            x = x + '</tbody>' +
                                '</table>' +
                                '<table style="width:50%;float:left;" class="table">' +
                                '<thead><tr><th>Term 2 [on a 3-point (A-C) grading scale]</th><th>Grade</th></tr></thead>' +
                                '<tbody>';
                            $.each(response.result.co_scholistic_sub, function(key, so_sch) {
                                x = x + '<tr>' +
                                    '<td style="text-align:left;">' + so_sch['sub_name'] + '</td>' +
                                    '<td align="center">' + value.term2[so_sch['sub_name']] + '</td>' +
                                    '</tr>';
                            });
                            x = x + '</tbody>' +
                                '</table>' +
                                '</div>' +
                                '<div class="col-md-6 teacher-remark">';
                            if (value.back) {
                                var c = 1;
                                x = x + '<p><span>Result: Promoted to Class: <b>_</b></span> <span style="margin-left:50px";>Needs improvement : ';
                                $.each(value.back, function(bkey, bvalue) {
                                    x = x + '(' + c + '). <b>' + bvalue.name + '</b> ';
                                    c++;
                                });
                                x = x + '</span></p></div>';
                            } else {
                                x = x + '<p>Result: Promoted to Class: ';
                                if (value.term1.class_name == 'I') {
                                    x = x + '<b>II</b>';
                                } else if (value.term1.class_name == 'II') {
                                    x = x + '<b>III</b>';
                                } else if (value.term1.class_name == 'III') {
                                    x = x + '<b>IV</b>';
                                } else if (value.term1.class_name == 'IV') {
                                    x = x + '<b>V</b>';
                                } else if (value.term1.class_name == 'V') {
                                    x = x + '<b>VI</b>';
                                } else if (value.term1.class_name == 'VI') {
                                    x = x + '<b>VII</b>';
                                } else if (value.term1.class_name == 'VII') {
                                    x = x + '<b>VIII</b>';
                                } else if (value.term1.class_name == 'VIII') {
                                    x = x + '<b>IX</b>';
                                }
                            }
                            x = x + '</p>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer p-footer-sec-f" style="padding-left:0px;margin-top:-15px;">' +
                                '<div class="col-md-2 p-place-date" style="padding-left:5px;">Place: ' +
                                '<b>Bhilai </b>' +
                                '<br>Date: '+currentDate +
                                '</div>' +
                                '<div class="col-md-2 col-md-offset-2 p-techer-sign">&nbsp;' +
                                '<br>' +
                                '<b>Signature of Class Teacher </b>' +
                                '</div>' +
                                '<div class="col-md-2 col-md-offset-1 p-school-seal">&nbsp;' +
                                '<br>' +
                                '<b>Seal of the School</b>' +
                                '</div>' +
                                '<div class="col-md-2 col-md-offset-1 text-center p-princi-sign" style="padding-right:0px;">' +
                                '<img class="principle-sign" src="' + base_url + 'assets/images/' + response.result.org_details.school[0].principal_sign + '">' +
                                '<br>' + response.result.org_details.school[0].principal_name +
                                '<br>' +
                                '<b>Principal</b>' +
                                '</div>' +
                                '<div class="instc-sec">' +
                                '<h4>Instructions</h4>' +
                                '<p>' +
                                '<b>Grading scale for scholastic areas:</b> Grades are awarded on a 8- point grading scale as follows -' +
                                '</p>' +
                                '<div class="col-md-4 col-md-offset-4 range-table" style="margin-left:25%;width:50%;">' +
                                '<table style="font-size:11px;" class="table table-bordered">' +
                                '<thead>' +
                                '<tr>' +
                                '<th style="width:40%;">Marks Range</th>' +
                                '<th style="width:60%;">Grade</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody>' +
                                '<tr><td>91-100</td><td>A 1</td></tr>' +
                                '<tr><td>81-90</td><td>A 2</td></tr>' +
                                '<tr><td>71-80</td><td>B 1</td></tr>' +
                                '<tr><td>61-70</td><td>B 2</td></tr>' +
                                '<tr><td>51-60</td><td>C 1</td></tr>' +
                                '<tr><td>41-50</td><td>C 2</td></tr>' +
                                '<tr><td>33-40</td><td>D</td></tr>' +
                                '<tr><td>32 &amp; Below</td><td>E (Needs improvement)</td></tr>' +
                                '</tbody>' +
                                '</table>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';

                        });
                        with(win.document) {
                            open();
                            write(x);
                            close();
                        }
                    } else {
                        alert('something getting wrong!!!');
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
    //----------------****************----------------------
    function class_9th_final(response) {
        var win = window.open('', "myWindowName", "scrollbars=1,width=1200, height=600");
        var x = '<link rel="stylesheet" type="text/css" href="' + base_url + 'assets/css/bootstrap.min.css">' +
            '<link rel="stylesheet" type="text/css" href="' + base_url + 'assets/css/marksheet-result.css">' +
            '<link rel="stylesheet" type="text/css" media="print" href="' + base_url + 'assets/css/marksheet-result-print.css">';
        $.each(response.result.final, function(mainkey, value) {
            x = x + '<div class="modal-content p-head-sec-f ms-full">' +
                '<img src="' + base_url + 'assets/images/' + response.result.org_details.school[0].school_image + '" style="position:absolute;top:40%;left:30%;margin:0 auto; background-size:cover; background-position:center;opacity: 0.5;filter: alpha(opacity=50);">' +
                '<div class="modal-header p-header">' +
                '<div class="col-md-3 c-logo-section"><img class="c-logo" style="width:80px;" src="' + base_url + 'assets/images/cbse-logo.png"></div>' +
                '<div class="col-md-6 p-logo-sec text-center">' +
                '<div class="p-school-name-sec">' +
                '<h2>' + response.result.org_details.school[0].school_name + '</h2>' +
                '<p>Affiliated to CBSE, New Delhi No. ' + response.result.org_details.school[0].affiliation_no + ' | School No.: ' + response.result.org_details.school[0].school_no + '<br>English &amp; Hindi Medium Senior Secondary School, <br>' + response.result.org_details.school[0].address + '</p>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-3 p-school-logo"><img class="p-logo pull-right" src="' + base_url + 'assets/images/' + response.result.org_details.school[0].school_image + '"></div>' +
                '</div>' +
                '<div class="modal-body p-student-body">' +
                '<div class="student-Information">' +
                '<div class="text-center">' +
                '<h5><b>Academic Report Card: ' + response.result.org_details.session[0].session_name + '<br></b></h5>' +
                '</div>' +
                '<div class="col-md-10 p-student-info">' +
                '<div class="student-info-t">' +
                '<b>STUDENT PARTICULARS</b>' +
                '</div>' +
                '<div class="student-per-info">' +
                '<div class="student-per-info1">' +
                '<table class="table">' +
                '<tbody>' +
                '<tr>' +
                '<td style="width:35%;">Student\'s Name</td>' +
                '<td>:' +
                '<b>' + value.std_details[0].name + '</b>' +
                '</td>' +
                '</tr>' +
                '<tr></tr>' +
                '<tr>' +
                '<td>Mother\'s Name</td>' +
                '<td>: ' + value.std_details[0].m_name + '</td>' +
                '</tr>' +
                '<tr></tr>' +
                '<tr>' +
                '<td>Father\'s Name</td>' +
                '<td>: ' + value.std_details[0].f_name + '</td>' +
                '</tr>' +
                '<tr></tr>' +
                '<tr>' +
                '<td>Contact No.</td>' +
                '<td>:' + value.std_details[0].contact_no + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Aadhar No.</td>' +
                '<td>:' + value.std_details[0].aadhar_no + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Address</td>' +
                '<td class="address-sec">:' + value.std_details[0].address + '</td>' +
                '</tr>' +
                '</tbody>' +
                '</table>' +
                '</div>' +
                '<div class="student-per-info2">' +
                '<table class="table">' +
                '<tbody>' +
                '<tr>' +
                '<td>Date of Birth</td>' +
                '<td>:' + value.std_details[0].dob + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Adm. No.</td>' +
                '<td>:' + value.std_details[0].adm_no + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Roll No.</td>' +
                '<td>:' + value.std_details[0].roll_no + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Class/Section</td>' +
                '<td>:' + value.std_details[0].class_name + ' \'' + value.std_details[0].section_name + '\'</td>' +
                '</tr>' +
                '</tbody>' +
                '</table>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-2 p-student-photo"><img class="student-photo" src="' + base_url + 'assets/images/students/temp/' + value.std_details[0].photo + '?' + Math.random() + '"></div>' +
                '</div>' +
                '<div class="results-information p-results-information-f-a col-md-12">' +
                '<div class="academic-result-t"><b>ACADEMIC PERFORMANCE (Scholastic Areas)</b></div>' +
                '<table class="table">' +
                '<thead>' +
                '<tr>' +
                '<th style="width:18%;text-align:left;">Subjects</th>' +
                '<th>Periodic Test: 10</th>' +
                '<th>Note Book: 05</th>' +
                '<th>Sub Enrichment: 05</th>' +
                '<th>Session Ending Exam: 80</th>' +
                '<th>Marks Obtained: 100</th>' +
                '<th>Grade</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';

            $.each(response.result.mid_sub, function(k, mid_sub) {
                $.each(value.main_marks, function(m, marks) {
                    if (mid_sub.sub_id == marks.sub_id) {
                        x = x + '<tr>' +
                            '<td style="text-align:left;">' + mid_sub.sub_name + '</td>' +
                            '<td>' + marks["priodic_" + mid_sub.sub_name] + '</td>' +
                            '<td>' + marks["notebook_" + mid_sub.sub_name] + '</td>' +
                            '<td>' + marks["enrichment_" + mid_sub.sub_name] + '</td>' +
                            '<td>' + marks["session_ending_" + mid_sub.sub_name] + '</td>' +
                            '<td>' + marks["marks_obtained_" + mid_sub.sub_name] + marks["marks_obtained_" + mid_sub.sub_name + '_star'] + '</td>' +
                            '<td>' + marks["grade_" + mid_sub.sub_name] + '</td>' +
                            '</tr>';
                    }
                });
            });
            x = x + '</tbody>' +
                '</table>' +
                '</div>' +
                '<div class="results-information p-results-information-f-c col-md-6" style="margin-top:15px;padding-right:0px;">' +
                '<table class="table">' +
                '<thead>' +
                '<tr>' +
                '<th rowspan="3" style="width:18%;">Subject</th>' +
                '<th colspan="5">Session Ending Marks</th>' +
                '<th rowspan="3">Grade</th>' +
                '</tr>' +
                '<tr>' +
                '<th colspan="2">Theory</th>' +
                '<th colspan="2">Practical</th>' +
                '<th>Total</th>' +
                '</tr>' +
                '<tr>' +
                '<th>MM</th>' +
                '<th>Marks Obtained</th>' +
                '<th>MM</th>' +
                '<th>Marks Obtained</th>' +
                '<th>100</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '<tr>' +
                '<td>Computer Application</td>' +
                '<td>' + response.result.extra_sub[0].out_of + '</td>' +
                '<td>' + value.extra_sub[0].final_marks + '</td>' +
                '<td>' + response.result.extra_sub[0].practical + '</td>' +
                '<td>' + value.extra_sub[0].practical_marks + '</td>' +
                '<td>' + value.extra_sub[0].total + '</td>' +
                '<td>' + value.extra_sub[0].grade + '</td>' +
                '</tr>' +
                '</tbody>' +
                '</table>' +

                '<div class="teacher-remark">' +
                '<table class="table">' +
                '<tbody>' +
                '<tr>';
            if (value.back) {
                if (value.back.length <= 2) {
                    var c = 1;
                    x = x + '<td><b>Aggregate</b></td><td><b>' + value.aggregate + '/500</b></td><td><b>Result:</b></td>';
                    x = x + '<td><b>Compartment</b> in ';
                    $.each(value.back, function(bkey, bvalue) {
                        x = x + '(' + c + '). <b>' + bvalue.name + '</b> ';
                        c++;
                    });
                    x = x + '</td>';
                } else {
                    x = x + '<td><b>Aggregate</b></td><td><b>-</b></td><td><b>Result:</b></td>';
                    x = x + '<td><b>Detained</b></td>';
                }
            } else {
                x = x + '<td><b>Aggregate</b></td><td><b>' + value.aggregate + '/500</b></td><td><b>Result:</b></td>';
                x = x + '<td><b>Pass</b></td>';
            }
            x = x + '</tr>' +
                '</tbody>' +
                '</table>' +
                '</div>' +
                '</div>' +

                '<div class="results-information p-results-information-f-c col-md-6" style="margin-top:15px;margin-bottom:6px;">' +
                '<table class="table">' +
                '<thead>' +
                '<tr>' +
                '<th style="text-align:left;">Co-Scholastic Areas [on a 5-point (A-E) grading scale]</th>' +
                '<th>Grade</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';
            $.each(response.result.co_scholistic_sub, function(co_key, co_sub) {
                $.each(value.co_scholastic, function(ck, co_marks) {
                    if (co_sub.sub_id == co_marks.sub_id) {
                        x = x + '<tr>' +
                            '<td style="text-align:left;">' + co_sub.sub_name + '</td>' +
                            '<td>' + co_marks[co_sub.sub_name] + '</td>' +
                            '</tr>';
                    }
                });

            });
            x = x + '</tbody>' +
                '</table>' +
                '</div>' +
                '</div>' +
                '<div class="modal-footer p-footer-sec-f" style="padding-left:0px;margin-top:-15px;">' +
                '<div class="col-md-2 p-place-date" style="padding-left:5px;">Place: <b>Bhilai </b>' +
                '<br>Date: '+currentDate+'</div>' +
                '<div class="col-md-2 col-md-offset-2 p-techer-sign">&nbsp;' +
                '<br><b>Signature of Class Teacher </b></div>' +
                '<div class="col-md-2 col-md-offset-1 p-school-seal">&nbsp;' +
                '<br><b>Seal of the School</b></div>' +
                '<div class="col-md-2 col-md-offset-1 text-center p-princi-sign" style="padding-right:0px;"><img class="principle-sign" src="' + base_url + 'assets/images/' + response.result.org_details.school[0].principal_sign + '">' +
                '<br>' + response.result.org_details.school[0].principal_name +
                '<br><b>Principal</b></div>' +
                '<div class="instc-sec">' +
                '<h4>Instructions</h4>' +
                '<p><b>Grading scale for scholastic areas:</b> Grades are awarded on a 8- point grading scale as follows -</p>' +
                '<div class="col-md-4 col-md-offset-4 range-table" style="margin-left:25%;width:50%;">' +
                '<table style="font-size:11px;" class="table table-bordered">' +
                '<thead>' +
                '<tr>' +
                '<th style="width:40%;">Marks Range</th>' +
                '<th style="width:60%;">Grade</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '<tr>' +
                '<td>91-100</td>' +
                '<td>A 1</td>' +
                '</tr>' +
                '<tr>' +
                '<td>81-90</td>' +
                '<td>A 2</td>' +
                '</tr>' +
                '<tr>' +
                '<td>71-80</td>' +
                '<td>B 1</td>' +
                '</tr>' +
                '<tr>' +
                '<td>61-70</td>' +
                '<td>B 2</td>' +
                '</tr>' +
                '<tr>' +
                '<td>51-60</td>' +
                '<td>C 1</td>' +
                '</tr>' +
                '<tr>' +
                '<td>41-50</td>' +
                '<td>C 2</td>' +
                '</tr>' +
                '<tr>' +
                '<td>33-40</td>' +
                '<td>D</td>' +
                '</tr>' +
                '<tr>' +
                '<td>32 &amp; Below</td>' +
                '<td>E (Failed)</td>' +
                '</tr>' +
                '</tbody>' +
                '</table>' +
                '</div>' +
                '</div>' +
                '<div style="float:left;text-align:left;"><span style="float:left;width:40px;"><b>Note:</b></span><span style="float:left;">* Compartment<br>** Promoted</span></div>' +
                '</div>' +
                '</div>';
        });
        with(win.document) {
            open();
            write(x);
            close();
        }
    }

    function final_marksheet_XI_XII(response) {
        var win = window.open('', "myWindowName", "scrollbars=1,width=1200, height=600");
        var x = '<link rel="stylesheet" type="text/css" href="' + base_url + 'assets/css/bootstrap.min.css">' +
            '<link rel="stylesheet" type="text/css" href="' + base_url + 'assets/css/marksheet-result.css">' +
            '<link rel="stylesheet" type="text/css" media="print" href="' + base_url + 'assets/css/marksheet-result-print.css">';
        $.each(response.result.final_result, function(key, value) {
            x = x + '<div class="modal-content p-head-sec-f ms-full">' +
                '<img src="' + base_url + 'assets/images/' + response.result.org_details.school[0].school_image + '" style="position:absolute;top:40%;left:30%;margin:0 auto; background-size:cover; background-position:center;opacity: 0.5;filter: alpha(opacity=50);">' +
                '<div class="modal-header p-header">' +
                '<div class="col-md-3 c-logo-section"><img class="c-logo" style="width:80px;" src="' + base_url + 'assets/images/cbse-logo.png"></div>' +
                '<div class="col-md-6 p-logo-sec text-center">' +
                '<div class="p-school-name-sec">' +
                '<h2>' + response.result.org_details.school[0].school_name + '</h2>' +
                '<p>Affiliated to CBSE, New Delhi No. ' + response.result.org_details.school[0].affiliation_no + ' | School No.: ' + response.result.org_details.school[0].school_no + '<br>English &amp; Hindi Medium Senior Secondary School, <br>' + response.result.org_details.school[0].address + '</p>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-3 p-school-logo"><img class="p-logo pull-right" src="' + base_url + 'assets/images/' + response.result.org_details.school[0].school_image + '"></div>' +
                '</div>' +
                '<div class="modal-body p-student-body">' +
                '<div class="student-Information">' +
                '<div class="text-center">' +
                '<h5><b>Academic Report Card: ' + response.result.org_details.session[0].session_name + '<br></b></h5>' +
                '</div>' +
                '<div class="col-md-10 p-student-info">' +
                '<div class="student-info-t">' +
                '<b>STUDENT PARTICULARS</b>' +
                '</div>' +
                '<div class="student-per-info">' +
                '<div class="student-per-info1">' +
                '<table class="table">' +
                '<tbody>' +
                '<tr>' +
                '<td style="width:35%;">Student\'s Name</td>' +
                '<td>:' +
                '<b>' + value.name + '</b>' +
                '</td>' +
                '</tr>' +
                '<tr></tr>' +
                '<tr>' +
                '<td>Mother\'s Name</td>' +
                '<td>: ' + value.m_name + '</td>' +
                '</tr>' +
                '<tr></tr>' +
                '<tr>' +
                '<td>Father\'s Name</td>' +
                '<td>: ' + value.f_name + '</td>' +
                '</tr>' +
                '<tr></tr>' +
                '<tr>' +
                '<td>Contact No.</td>' +
                '<td>:' + value.contact_no + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Aadhar No.</td>' +
                '<td>:' + value.aadhar_no + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Address</td>' +
                '<td class="address-sec">:' + value.address + '</td>' +
                '</tr>' +
                '</tbody>' +
                '</table>' +
                '</div>' +
                '<div class="student-per-info2">' +
                '<table class="table">' +
                '<tbody>' +
                '<tr>' +
                '<td>Date of Birth</td>' +
                '<td>:' + value.dob + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Adm. No.</td>' +
                '<td>:' + value.adm_no + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Roll No.</td>' +
                '<td>:' + value.roll_no + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Class/Section</td>' +
                '<td>:' + value.class_name + ' \'' + value.section_name + '\'</td>' +
                '</tr>' +
                '</tbody>' +
                '</table>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-2 p-student-photo"><img class="student-photo" src="' + base_url + 'assets/images/students/temp/' + value.photo + '?' + Math.random() + '"></div>' +
                '</div>' +
                '<div class="results-information p-results-information-f-a col-md-12">' +
                '<div class="academic-result-t"><b><b>ACADEMIC PERFORMANCE (Scholastic Areas)</b></b>' +
                '</div>' +
                '<table class="table">' +
                '<thead>' +
                '<tr>' +
                '<th style="width:18%;text-align:center;" rowspan="4">Subjects</th>' +
                '<th rowspan="4">Post Mid<br>(20 Marks)</th>' +
                '<th colspan="5">Session Ending Exam</th>' +
                '<th rowspan="4">Pre<br>(Out of 5)</th>' +
                '<th rowspan="4">Mid<br>(Out of 20)</th>' +
                '<th rowspan="4">Post Mid<br>(Out of 5)</th>' +
                '<th colspan="3">Session Ending Exam<br>(Theory + Practical)<br>(Out of 60)</th>' +
                '<th rowspan="4">Academic Attention<br>(Out of 10)</th>' +
                '<th rowspan="4">Grand Total 100</th>' +
                '<th rowspan="4">Over all Grade</th>' +
                '</tr>' +
                '<tr>' +
                '<th colspan="2">Theory</th>' +
                '<th colspan="2">Practical</th>' +
                '<th>Total</th>' +
                '<th rowspan="3">Th</th>' +
                '<th rowspan="3">Pr</th>' +
                '<th rowspan="3">Total</th>' +
                '</tr>' +
                '<tr></tr>' +
                '<tr>' +
                '<th>MM</th>' +
                '<th>Marks Obt.</th>' +
                '<th>MM</th>' +
                '<th>Marks Obt.</th>' +
                '<th>&nbsp;</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';
            $.each(response.result.subjects, function(skey, subjects) {
                if ((subjects.st_id == 1) || (subjects.st_id == 3 && subjects.sub_id == value.elective)) {
                    x = x + '<tr>' +
                        '<td style="text-align:left;">' + subjects.sub_name + '</td>';
                   
                    $.each(value.post_marks, function(pk, post) {
                        if (subjects.sub_id == post.sub_id) {
                            x = x + '<td>' + post[subjects['sub_name']+'_out_of_5'] + '</td>';
                        }
                    });

                    x = x + '<td>' + subjects.out_of + '</td>';

                    $.each(value.final_marks, function(mk, final) {
                        if (subjects.sub_id == final.sub_id) {
                            x = x + '<td>' + final[subjects['sub_name']] + final.sub_star+'</td>';
                        }
                    });
                    if(subjects.practical){
                    	var practical_out_of = subjects.practical;
                    	}else{
                    		var practical_out_of = 'NA';
                    	}
                    x = x + '<td>' + practical_out_of + '</td>';

                    $.each(value.final_marks, function(mk, final_marks) {
                        if (subjects.sub_id == final_marks.sub_id) {
                            x = x + '<td>' + final_marks[subjects['sub_name'] + '_practical'] +final_marks.prac_star +'</td>';
                            x = x + '<td>' + final_marks.total + '</td>';
                        }
                    });

                    $.each(value.pre_marks, function(pk, pvalue) {
                        if (subjects.sub_id == pvalue.sub_id) {
                            x = x + '<td>' + pvalue[subjects['sub_name']] + '</td>';
                        }
                    });

                    $.each(value.mid_marks, function(pk, mvalue) {
                        if (subjects.sub_id == mvalue.sub_id) {
                            x = x + '<td>' + mvalue[subjects['sub_name'] + '_out_of_20'] + '</td>';
                        }
                    });

                    $.each(value.post_marks, function(po, povalue) {
                        if (subjects.sub_id == povalue.sub_id) {
                            x = x + '<td>' + povalue[subjects['sub_name']] + '</td>';
                        }
                    });
                    
                    $.each(value.final_marks, function(final, final_value) {
                        if (subjects.sub_id == final_value.sub_id) {
                            x = x + '<td>' + final_value[subjects['sub_name']+'_out_of_60'] + '</td>';
                        }
                    });
                    
                    $.each(value.final_marks, function(final, final_value) {
                        if (subjects.sub_id == final_value.sub_id) {
                            x = x + '<td>' + final_value[subjects['sub_name']+'_practical_out_of_60'] + '</td>';
                        }
                    });
                    
                    $.each(value.final_marks, function(final, final_value) {
                        if (subjects.sub_id == final_value.sub_id) {
                            x = x + '<td>' + final_value.total + '</td>';
                        }
                    });
                    
                    $.each(value.final_marks, function(final,acadmic) {
                        if (subjects.sub_id == acadmic.sub_id) {
                            x = x + '<td>' + acadmic[subjects['sub_name']+'_acadmic'] + '</td>';
                        }
                    });
                    
                    $.each(value.grand_total, function(final, grand_total) {
                        if (subjects.sub_id == grand_total.sub_id) {
                            x = x + '<td>' + grand_total[subjects['sub_name']] + grand_total.total_star +'</td>';
                        }
                    });
                    
                    $.each(value.grand_total, function(final, grand_total) {
                        if (subjects.sub_id == grand_total.sub_id) {
                            x = x + '<td>' + grand_total.grade +'</td>';
                        }
                    });
                    
                    x = x + '</tr>';
                }

            });
            x = x + '</tbody>' +
                '</table>' +
                '</div>' +
                '<div class="results-information p-results-information-f-c col-md-6">' +
                '<div class="academic-result-t" style="background-color:rgba(241,241,241,0.2)!important;"><b><b>Co-Scholastic Areas:[on a 5 Point (A-E) Grading Scale]</b></b></div>' +
                '<table class="table">' +
                '<thead>' +
                '<tr>' +
                '<th style="text-align:center;">Subjects</th>' +
                '<th>Grade MT</th>' +
                '<th>Grade SE</th>' +
                '<th colspan="2">Over all Grade</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';
	            $.each(response.result.co_Scholastic,function(co_key,co_sub){
					x=x+'<tr>';
					x=x+'<td style="text-align:left;">'+co_sub['sub_name']+'</td>';
					
	        		$.each(value.co_scholastic.mid_co_scholastic,function(m,mid_mark){
	        			if(co_sub.sub_id == mid_mark.sub_id){
	        				x=x+'<td>'+mid_mark[co_sub['sub_name']]+'</td>';
	        			}
	        		});
	        		
	        		$.each(value.co_scholastic.final_co_scholastic,function(f,final_mark){
	        			if(co_sub.sub_id == final_mark.sub_id){
	        				x=x+'<td>'+final_mark[co_sub['sub_name']]+'</td>';
	        			}
	        		});
	        		
	        		$.each(value.co_scholastic.calculate_co,function(t,mid_final){
	        			if(co_sub.sub_id == mid_final.sub_id){
	        				x=x+'<td>'+mid_final[co_sub['sub_name']]+'</td>';
	        			}
	        		});
	        		
	        		x=x+'</tr>';
	        	});
                x=x+'</tbody>' +
                '</table>' +
                '</div>';
                
                	x=x+'<div class="results-information p-results-information-f-c col-md-6">' +
                    '<div class="academic-result-t" style="background-color:rgba(241,241,241,0.2)!important;"><b><b>Result</b></b></div>' +
                    '<table class="table" width="50%">' +
                    '<tbody>' +
                    '<tr>' +
                    '<td>Aggregate</td>' +
                    '<td>'+value.aggregate+'</td>' +
                    '<td>Percentage</td>' +
                    '<td>'+value.percentage+'</td>' +
                    '<td>Rank</td>' +
                    '<td>'+value.rank+'</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Final Result</td>';
                	
                    if(value.result != 'Compartment'){
                    	x=x+'<td colspan="5"><b>'+value.result+'</b></td>';
                    }else{
                    	if(value.back.length > 0 && value.back.length < 3){
    						var y = ''; 
    						$.each(value.back,function(k,v){
    							y = y + ' '+v.name + ',';
    						});
    						y = y.slice(0, -1);
    						x=x+'<td><b>Compartment in</b></td><td colspan="4"><b>'+ y +'</b></td>';
    					}
                    }
                    x=x+'</tr>' +
                    '</tbody>' +
                    '</table>' +
                    '</div>'+
                    '<div class="modal-footer p-footer-sec-f" style="padding-left:0px;margin-top:-25px;">' +
                '<div class="col-md-2 p-place-date"><b>Place: <b>Bhilai </b><br>Date: '+currentDate+'</b></div>' +
                '<div class="col-md-2 col-md-offset-2 p-techer-sign"><b>&nbsp;<br><b>Signature of Class Teacher </b></b></div>' +
                '<div class="col-md-2 col-md-offset-1 p-school-seal"><b>&nbsp;<br><b>Seal of the School</b></b></div>' +
                '<div class="col-md-2 col-md-offset-1 text-center p-princi-sign" style="padding-right:0px;"><b><img class="principle-sign" src="' + base_url + 'assets/images/' + response.result.org_details.school[0].principal_sign + '">' +
                '<br>' + response.result.org_details.school[0].principal_name +'</div>' +
                '<div class="instc-sec" style="margin-bottom:0px;padding:0;">' +
                '<h4><b>Instructions</b></h4>' +
                '<p><b><b>Grading scale for scholastic areas:</b> Grades are awarded on a 8- point grading scale as follows -</b></p>' +
                '<div class="col-md-4 col-md-offset-4 range-table" style="margin-left:25%;width:50%;">' +
                '<table style="font-size:11px;" class="table table-bordered">' +
                '<thead>' +
                '<tr>' +
                '<th style="width:40%;">Marks Range</th>' +
                '<th style="width:60%;">Grade</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '<tr>' +
                '<td>91-100</td>' +
                '<td>A 1</td>' +
                '</tr>' +
                '<tr>' +
                '<td>81-90</td>' +
                '<td>A 2</td>' +
                '</tr>' +
                '<tr>' +
                '<td>71-80</td>' +
                '<td>B 1</td>' +
                '</tr>' +
                '<tr>' +
                '<td>61-70</td>' +
                '<td>B 2</td>' +
                '</tr>' +
                '<tr>' +
                '<td>51-60</td>' +
                '<td>C 1</td>' +
                '</tr>' +
                '<tr>' +
                '<td>41-50</td>' +
                '<td>C 2</td>' +
                '</tr>' +
                '<tr>' +
                '<td>33-40</td>' +
                '<td>D</td>' +
                '</tr>' +
                '<tr>' +
                '<td>32 &amp; Below</td>' +
                '<td>E (Failed)</td>' +
                '</tr>' +
                '</tbody>' +
                '</table>' +
                '</div>' +
                '</div>' +
                '<div style="float:left;text-align:left;"><b><span style="float:left;width:40px;"><b>Note:</b></span><span style="float:left;">* Compartment<br>** Promoted</span></b></div>' +
                '</div>' +
                '</div>' +
                '</div>';
        });

        with(win.document) {
            open();
            write(x);
            close();
        }
    }
});