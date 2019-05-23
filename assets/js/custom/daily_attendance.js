$(document).ready(function() {
    var base_url = $('#base_url').val();

    $('#daily_attendance_form').validate({
        rules: {
            attendance_date: { required: true },
            period: { required: true },
            medium: { required: true },
            class_name: { required: true },
            section: { required: true },
            sub_type: { required: true },
        },
        messages: {}
    });

    $(document).on('change', '#sub_type', function() {
        var form_validate = $('#daily_attendance_form').valid();
        var class_name = $('#class_name').val();
        var sub_group = $('#sub_group').val();
        if (class_name == 14 || class_name == 15) {
            if (sub_group == '') {
                $('#sub_group_err').html('This field is required.').css('display', 'block');
                return false;
            } else {
                $('#sub_group_err').css('display', 'none');
            }
        }

        if (form_validate == true) {
            var formdata = new FormData();
            formdata.append('exam_type', $('#exam_type').val());
            formdata.append('medium', $('#medium').val());
            formdata.append('class_name', $('#class_name').val());
            formdata.append('sub_group', $('#sub_group').val());
            formdata.append('section', $('#section').val());
            formdata.append('sub_type', $(this).val());

            $.ajax({
                type: 'POST',
                url: base_url + 'Daily_attend_ctrl/getSubjects',
                data: formdata,
                dataType: 'json',
                beforeSend: function() {
                    $('#loader').modal('show');
                },
                success: function(response) {
                    //	 				console.log(response);
                    $('#loader').modal('hide');
                    x = '<option value="">Select Subject</option>';
                    if (response.status == 200) {
                        $.each(response.result, function(key, value) {
                            x = x + '<option value="' + value.sub_id + '">' + value.sub_name + ' (' + value.st_name + ')</option>';
                        });
                        $('#subject').html(x);
                    } else {
                        alert(response.feedback);
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });


    //-------------get student records---------------------------
    $(document).on('click', '#search', function() {
        var form_validate = $('#daily_attendance_form').valid();
        var attendance_date = $('#attendance_date').val();
        var period = $('#period').val();
        var medium = $('#medium').val();
        var class_name = $('#class_name').val();
        var sub_group = $('#sub_group').val();
        var section = $('#section').val();
        var sub_type = $('#sub_type').val();
        var subject = $('#subject').val();

        if (subject == '') {
            $('#subject_err').html('field is required.').css('display', 'block');
            return false;
        } else {
            $('#subject_err').css('display', 'block');
        }

        if (form_validate == true) {
            formdata = new FormData();
            formdata.append('attendance_date', attendance_date);
            formdata.append('period', period);
            formdata.append('medium', medium);
            formdata.append('class_name', class_name);
            formdata.append('sub_group', sub_group);
            formdata.append('section', section);
            formdata.append('sub_type', sub_type);
            formdata.append('subject', subject);

            $.ajax({
                type: 'POST',
                url: base_url + 'Daily_attend_ctrl/getStudentsRecords',
                data: formdata,
                dataType: 'json',
                beforeSend: function() {
                    $('#loader').modal('show');
                },
                success: function(response) {
                    var x = '';
                    var i = 1;
                    if (response.status == 200) {
                        $('#loader').modal('hide');
                        $('#type_and_sub').html($('#exam_type').children('option:selected').text() + ':- ' + $('#subject').children('option:selected').text());

                        $.each(response.students, function(key, std) {
                            if (std.attendance == "A") {
                                var class_is = "btn-danger";
                                var name = 'Absent';
                                var disabled = '';
                            } else if (std.attendance == "L") {
                                var class_is = "btn-info";
                                var name = 'Leave';
                                var disabled = 'disabled';
                            } else {
                                var class_is = "btn-success";
                                var name = 'Presnet';
                                var disabled = '';
                            }

                            x = x + '<tr>' +
                                '<td>' + i + '</td>' +
                                '<td>' + std.name + '</td>' +
                                '<td>' + std.class_name + ' / ' + std.section_name + '</td>' +
                                '<td>' + std.adm_no + '</td>' +
                                '<td>' + std.roll_no + '</td>' +
                                '<td><button data-std_id="' + std.std_id + '" data-roll_no="' + std.roll_no + '" data-adm_no="' + std.adm_no + '" class="attendance ' + class_is + '" id="' + std.std_id + '" ' + disabled + '>' + name + '</button></td>' +
                                '</tr>';
                            i++;
                        });
                        $('#list_of_students').html(x);
                        $('#attendance_submit').css('display', 'block');
                    } else {
                        $('#loader').modal('hide');
                        alert(response.feedback);
                        $('#list_of_students').html('<tr><td colspan="6">Record not found.</td></tr>');
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });


    $(document).on('click', '.attendance', function() {
        var btn_id = $(this).attr('id');
        if ($('#' + btn_id).hasClass('btn-success')) {
            $('#' + btn_id).removeClass('btn-success');
            $('#' + btn_id).addClass('btn-danger');
            $('#' + btn_id).html('Absent');
        } else {
            $('#' + btn_id).removeClass('btn-danger');
            $('#' + btn_id).addClass('btn-success');
            $('#' + btn_id).html('Presnet');
        }
    });
    //------------------students marks entry----------------------------
    $(document).on('click', '#attendance_submit', function() {
    	var attendance_date = $('#attendance_date').val();
        var period = $('#period').val();
        var medium = $('#medium').val();
        var class_name = $('#class_name').val();
        var sub_group = $('#sub_group').val();
        var section = $('#section').val();
        var sub_type = $('#sub_type').val();
        var subject = $('#subject').val();

        var attendance = [];
        $('.btn-success').each(function(index, value) {
            var temp = [];
            var adm_no = $(this).data('adm_no');
            temp.push({ adm_no: adm_no });
            temp.push({ std_id: $(this).data('std_id') });
            temp.push({ roll_no: $(this).data('roll_no') });
            temp.push({ attendance: 'P' });
            attendance.push(temp);
        });

        $('.btn-danger').each(function(index, value) {
            var temp = [];
            var adm_no = $(this).data('adm_no');
            temp.push({ adm_no: adm_no });
            temp.push({ std_id: $(this).data('std_id') });
            temp.push({ roll_no: $(this).data('roll_no') });
            temp.push({ attendance: 'A' });
            attendance.push(temp);
        });

        var formdata = new FormData();
        formdata.append('attendance_date', attendance_date);
        formdata.append('period', period);
        formdata.append('medium', medium);
        formdata.append('class_name', class_name);
        formdata.append('sub_group', sub_group);
        formdata.append('section', section);
        formdata.append('sub_type', sub_type);
        formdata.append('subject', subject);
        formdata.append('attendance', JSON.stringify(attendance));
        
        $.ajax({
            type: 'POST',
            url: base_url + 'Daily_attend_ctrl/attendanceEntry',
            data: formdata,
            //async: false,
            dataType: 'json',
            beforeSend: function() {
                $('#loader').modal('show');
            },
            success: function(response) {
                if (response.status == 200) {
                    alert(response.feedback);
                    location.reload();
                } else {
                    alert(response.feedback);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


});