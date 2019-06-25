$(document).ready(function() {
    var base_url = $('#base_url').val();
    $(document).on('change', '#sub_type', function() {
        var medium = $('#medium').val();
        var class_id = $('#class').val();
        var sub_group = $('#sub_group').val();
        var sub_type = $(this).val();
        $.ajax({
            type: 'POST',
            url: base_url + 'Subject_allocation_ctrl/getSubjectData',
            data: {
                'medium': medium,
                'class': class_id,
                'sub_group': sub_group,
                'sub_type': sub_type
            },
            dataType: 'json',
            beforeSend: function() {
                $('#loader').modal('show');
            },
            success: function(response) {
                console.log(response);
                x = '<label class="control-label col-md-2">Subjects</label>';
                if (response.status == 200) {
                    $('#loader').modal('hide');
                    $.each(response.result, function(key, value) {
                        x = x + '<div class="col-sm-3">' +
                            '<input type="checkbox" class="subjects_entry" name="subjects[]" id="' + value.sub_id + '"  value="' + value.sub_id + '" ' + value.active + '>' + value.sub_name +
                            '</div>';
                    });
                    $('#subjets').html(x);
                } else {
                    $('#subjets').html('<div class="col-sm-12" style="text-align:center;">record not found.</div>');
                }
            },
        }); // end of ajax..

    });
    //----------------------------------------------------------------
    $(document).on('click', '.subjects_entry', function() {
        var medium = $('#medium').val();
        var class_id = $('#class').val();
        var sub_group = $('#sub_group').val();
        var sub_type = $('#sub_type').val();
        var subject = $(this).attr('id');
        var formvalid = true;
        if (medium == '') {
            $('#medium_err').html('Medium is required..!').css('display', 'block');
            formvalid = false;
        } else {
            $('#medium_err').css('display', 'none');
        }

        if (class_id == '') {
            $('#class_err').html('Class is required..!').css('display', 'block');
            formvalid = false;
        } else {
            $('#class_err').css('display', 'none');
        }

        if (sub_group == '' && class_id >= 14) {
            $('#sub_group_err').html('Subject Group is required..!').css('display', 'block');
            formvalid = false;
        } else {
            $('#sub_group_err').css('display', 'none');
        }

        if (sub_type == '') {
            $('#sub_type_err').html('Subject Type is required..!').css('display', 'block');
            formvalid = false;
        } else {
            $('#sub_type_err').css('display', 'none');
        }
        var formdata = new FormData();
        formdata.append('medium', medium);
        formdata.append('class', class_id);
        formdata.append('sub_group', sub_group);
        formdata.append('sub_type', sub_type);
        formdata.append('subject', subject);
        if (formvalid) {

            $.ajax({
                type: 'POST',
                url: base_url + 'Subject_allocation_ctrl/subject_allocate',
                data: formdata,
                dataType: 'json',
                beforeSend: function() {
                    $('#loader').modal('show');
                },
                success: function(response) {
                    if (response.status == 200) {
                        //alert(response.feedback);
                        $('#loader').modal('hide');
                        listOfExamMarksEntry();
                    } else {
                        alert(response.feedback);
                    }
                    if (response.status == 400) {
                        alert(response.validation_errors);
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

    });
    //-----------------------------------------------------
    $(document).on('change', '#sub_type', function() {
        listOfExamMarksEntry();
    });
    //--------------------------------------------------	
    function listOfExamMarksEntry() {
        var medium = $('#medium').val();
        var class_id = $('#class').val();
        var sub_group = $('#sub_group').val();
        var sub_type = $('#sub_type').val();

        $.ajax({
            type: 'POST',
            url: base_url + 'Subject_allocation_ctrl/list_of_exam_marks_entry',
            data: {
                'medium': medium,
                'class': class_id,
                'sub_group': sub_group,
                'sub_type': sub_type
            },
            dataType: 'json',
            beforeSend: function() {},
            success: function(response) {
                console.log(response);
                var x = '';
                var i = 1;
                if (response.status == 200) {
                    $.each(response.result, function(key, value) {
                        x = x + '<tr>' +
                            '<td>' + i + '</td>' +
                            '<td>' + value.sub_name + '</td>' +
                            '<td><input  type="text" data-sa_id="' + value.sa_id + '" data-et_id="1" value="' + value.pre + '" name="pre" id="pre" class="master only_int" style="width:50px;"></td>' +
                            '<td><input type="text" data-sa_id="' + value.sa_id + '" data-et_id="2" value="' + value.mid + '" name="mid" id="mid" class="master only_int" style="width:50px;"></td>';

                        if (($('#class').val() >= 14) || ($('#class').val() == 12 && sub_type == 4)) {
                            $('#mid_pra').css('display', 'block');
                            x = x + '<td><input type="text" data-sa_id="' + value.sa_id + '" data-et_id="2" value="' + value.mid_practical + '" name="mid" id="mid_practical" class="practical only_int" style="width:50px;"></td>';
                        } else {
                            $('#mid_pra').css('display', 'none');
                        }

                        x = x + '<td><input type="text" data-sa_id="' + value.sa_id + '" data-et_id="3" value="' + value.post + '" name="post" id="post" class="master only_int" style="width:50px;"></td>' +
                            '<td><input type="text" data-sa_id="' + value.sa_id + '" data-et_id="4" value="' + value.final + '" name="final" id="final" class="master only_int" style="width:50px;"></td>';

                        if (($('#class').val() >= 14) || ($('#class').val() == 12 && sub_type == 4)) {
                            $('#final_pra').css('display', 'block');
                            x = x + '<td><input type="text" data-sa_id="' + value.sa_id + '" data-et_id="4" value="' + value.final_practical + '" name="final" id="final_practical" class="practical only_int" style="width:50px;"></td>';
                        } else {
                            $('#final_pra').css('display', 'none');
                        }
                        x = x + '</tr>';
                        i++;
                    });
                    $('#out_of_marks').html(x);
                } else {
                    $('#out_of_marks').html('<tr><td colspan="6" style="text-align:center">this class not allocated any subjects.</td></tr>');
                }
            },
            complete: function() {
                $(".only_int").on("keypress keyup blur", function(event) {
                    $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
                    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                        event.preventDefault();
                    }
                });
            }

        });
    }
    //----------------------------------------------------------
    $(document).on('change', '.practical', function() {
        var sa_id = $(this).data('sa_id');
        var exam_type = $(this).data('et_id');
        var practical = $(this).val();
        $.ajax({
            type: 'POST',
            url: base_url + 'Subject_allocation_ctrl/outOfPracticalMarks',
            data: {
                'sa_id': sa_id,
                'exam_type': exam_type,
                'practical': practical
            },
            dataType: 'json',
            beforeSend: function() {
                $('#loader').modal('show');
            },
            success: function(response) {
                if (response.status == 200) {
                    $('#loader').modal('hide');
                } else {
                    alert(response.feedback);
                }
                if (response.status == 400) {
                    alert(response.validation_errors);
                }
            },
        });

    });
    //---------------------------------------------------------
    $(document).on('change', '.master', function() {
        var sa_id = $(this).data('sa_id');
        var exam_type = $(this).data('et_id');
        var out_of = $(this).val();
        $.ajax({
            type: 'POST',
            url: base_url + 'Subject_allocation_ctrl/entryOutOfMarks',
            data: {
                'sa_id': sa_id,
                'exam_type': exam_type,
                'out_of': out_of
            },
            dataType: 'json',
            beforeSend: function() {
                $('#loader').modal('show');
            },
            success: function(response) {
                if (response.status == 200) {
                    $('#loader').modal('hide');
                } else {
                    alert(response.feedback);
                }
                if (response.status == 400) {
                    alert(response.validation_errors);
                }
            },
        });

    });
    //--------------------------------------------------------
    $(document).on('change', '#medium', function() {
        $('#class').prop('selectedIndex', '');
        $('#sub_group').prop('selectedIndex', '');
        $('#sub_type').prop('selectedIndex', '');
        $('#subjets').html('<div class="col-sm-12" style="text-align:center;">record not found.</div>');
        $('#out_of_marks').html('<tr><td colspan="6" style="text-align:center">this class not allocated any subjects.</td></tr>');
    });
    //--------------------------------------------------------
    $(document).on('change', '#class', function() {
        var class_id = $(this).val();
        if (class_id >= 14) {
            $('#sub_group_form').css('display', 'block');
            $('#mid_pra').css('display', 'none');
            $('#final_pra').css('display', 'none');
        } else {
            $('#sub_group_form').css('display', 'none');
            $('#mid_pra').css('display', 'none');
            $('#final_pra').css('display', 'none');
        }
        $('#sub_group').prop('selectedIndex', '');
        $('#sub_type').prop('selectedIndex', '');
        $('#subjets').html('<div class="col-sm-12" style="text-align:center;">record not found.</div>');
        $('#out_of_marks').html('<tr><td colspan="6" style="text-align:center">this class not allocated any subjects.</td></tr>');
    });
    //--------------------------------------------------------
    $(document).on('change', '#sub_group', function() {
        $('#sub_type').prop('selectedIndex', '');
        $('#subjets').html('<div class="col-sm-12" style="text-align:center;">record not found.</div>');
        $('#out_of_marks').html('<tr><td colspan="6" style="text-align:center">this class not allocated any subjects.</td></tr>');
    });

});