$(document).ready(function(){
	var baseUrl = $('#base_url').val();
	var userUrl = $('#user_url').val();
	$(document).on('change','#admission_no',function(){
		var admission_no = $(this).val();
		var school = $('#school').val();
		var hostel_name = $('#hostel_name').val();
		if(school == ''){
			$('#school_err').html('This is Required.').css('display','block');
			return false;
		}else{
			$('#school_err').css('display','none');
		}
		
		if(hostel_name = ''){
			$('#hostel_name_err').html('This is Required.').css('display','block');
			return false;
		}else{
			$('#hostel_name_err').css('display','none');
		}
		
		$.ajax({
			type:'POST',
			url:baseUrl+'hostel/Hostel_students_ctrl/getStudentDetails',
			data:{'school':school,'admission_no':admission_no},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					$('#student_name').val(response.data[0].name);
					$('#roll_no').val(response.data[0].roll_no);
					$('#medium').val(response.data[0].medium);
					$('#class_id').val(response.data[0].class_id);
					$('#section').val(response.data[0].sec_id);
					if((response.data[0].sub_group == "") || (response.data[0].sub_group == null)){
						$('#sub_group_row').css('display','none');
						$('#subject_group').prop('selectedIndex','');
					}else{
						$('#subject_group').val(response.data[0].sub_group);
						$('#sub_group_row').css('display','block');
					}
					
					$('#father_name').val(response.data[0].f_name);
					$('#mother_name').val(response.data[0].f_name);
					$('#dob').val(response.data[0].dob);
					$('#gender').val(response.data[0].gender);
					$('#aadhaar').val(response.data[0].aadhar_no);
					$('#address').val(response.data[0].address);
					$('#contact_no').val(response.data[0].contact_no);
					
					$('#std_image_preview').html('<img style="border:1px solid #ddd;width:120px;height:120px;margin-bottom:20px;" src="'+response.img_path+response.data[0].photo+'" />');
					
				}else{
					$('#student_name').val('');
					$('#roll_no').val('');
					$('#medium').prop('selectedIndex','');
					$('#class_id').prop('selectedIndex','');
					$('#section').prop('selectedIndex','');
					
					$('#sub_group_row').css('display','none');
					$('#subject_group').prop('selectedIndex','');
					
					$('#father_name').val('');
					$('#mother_name').val('');
					$('#dob').val('');
					$('#gender').val('');
					$('#aadhaar').val('');
					$('#address').val('');
					$('#contact_no').val('');
				}
			},
		});
	});
	
	/////////////////////////////////////////////////////////////
	
	$('#hostel_student_details').validate({
		rules:{
			std_status:{required:true},
			school:{required:true},
			hostel_name:{required:true},
			admission_no:{required:true},
			cousin:{required:true},
			f_contact_no:{minlength:10,maxlength:10},
			m_contact_no:{minlength:10,maxlength:10},
			guardian_pin_code:{minlength:6,maxlength:6},
			g_contact_no:{minlength:10,maxlength:10},
			student_image:{required:true,extension: "jpg|png|jpeg"},
			father_image:{required:true,extension: "jpg|png|jpeg"},
			mother_image:{required:true,extension: "jpg|png|jpeg"},
			//gurardian_image:{required:true,accept: "jpg,png,jpeg"},
		}
	});
	
	$(document).on('click','#submit_details',function(){
		var formlvaidate = $('#hostel_student_details').valid();
		
		var std_status = $('#std_status').val();
		var school = $('#school').val();
		var medium = $('#medium').val();
		var hostel_name = $('#hostel_name').val();
		
		var adm_no = $('#admission_no').val();
		var f_contact_no = $('#f_contact_no').val();
		var m_contact_no = $('#m_contact_no').val();
		var guardian_name = $('#guardian_name').val();
		var local_address = $('#local_address').val();
		var guardian_pin_code = $('#guardian_pin_code').val();
		var g_contact_no = $('#g_contact_no').val();
		
		var preSchool = $('#preSchool').val();
		var preClass = $('#preClass').val();
		var per_of_marks = $('#per_of_marks').val();
		var f_acc_no = $('#f_acc_no').val();
		var std_acc_no = $('#std_acc_no').val();
		var cousin = $("input[name='cousin']:checked").val();
		
		var cousin_details = [];
		if($('#c_row_1').prop('checked') == true){
			var temp = [];
			temp.push({name : $('#c_name_1').val()});
			temp.push({fname : $('#cf_name_1').val()});
			temp.push({class_name : $('#c_class_1').val()});
			temp.push({section : $('#c_section_1').val()});
			temp.push({since_ses : $('#since_ses_1').val()});
			cousin_details.push(temp);
		}
		if($('#c_row_2').prop('checked') == true){
			var temp = [];
			temp.push({name : $('#c_name_2').val()});
			temp.push({fname : $('#cf_name_2').val()});
			temp.push({class_name : $('#c_class_2').val()});
			temp.push({section : $('#c_section_2').val()});
			temp.push({since_ses : $('#since_ses_2').val()});
			cousin_details.push(temp);
		}
		if($('#c_row_3').prop('checked') == true){
			var temp = [];
			temp.push({name : $('#c_name_3').val()});
			temp.push({fname : $('#cf_name_3').val()});
			temp.push({class_name : $('#c_class_3').val()});
			temp.push({section : $('#c_section_3').val()});
			temp.push({since_ses : $('#since_ses_3').val()});
			cousin_details.push(temp);
		}
		
		if(cousin == 'Yes' && cousin_details == ''){
			$('#cousin_details_err').html('This is Required.').css('display','block');
			return false;		
		}else{
			$('#cousin_details_err').css('display','none');
		}

		if(formlvaidate){
			var formdata = new FormData();
			formdata.append('std_status',std_status);
			formdata.append('school',school);
			formdata.append('medium',medium);
			formdata.append('hostel_name',hostel_name);
			formdata.append('adm_no',adm_no);
			formdata.append('f_contact_no',f_contact_no);
			formdata.append('m_contact_no',m_contact_no);
			formdata.append('guardian_name',guardian_name);
			formdata.append('local_address',local_address);
			formdata.append('guardian_pin_code',guardian_pin_code);
			formdata.append('g_contact_no',g_contact_no);
			formdata.append('preSchool',preSchool);
			formdata.append('preClass',preClass);
			formdata.append('per_of_marks',per_of_marks);
			formdata.append('f_acc_no',f_acc_no);
			formdata.append('std_acc_no',std_acc_no);
			formdata.append('cousin',cousin);
			formdata.append('cousin_details',JSON.stringify(cousin_details));
			
			formdata.append('student_image',$('#student_image')[0].files[0]);
			formdata.append('father_image',$('#father_image')[0].files[0]);
			formdata.append('mother_image',$('#mother_image')[0].files[0]);
			formdata.append('gurardian_image',$('#gurardian_image')[0].files[0]);
		
			$.ajax({
				type:'POST',
				url:baseUrl+'hostel/Hostel_students_ctrl/addStudentDetails',
				data:formdata,
				dataType:'json',
				beforeSend:function(){},
				success:function(response){
					if(response.status == 200){
						alert(response.msg);
						window.location.href = baseUrl+userUrl+'/hostel/fee-payment/'+response.ses_id+'/'+response.sch_id+'/'+response.adm_no;
					}else{
						alert(response.msg);
					}
				},
				cache:false,
				processData:false,
				contentType:false
			});
		}			
	});
	
	////////////////////////////////////////////////////////////
	$(document).on('click','.cousin',function(){
		var cousin = $(this).val();
		if(cousin == 'Yes'){
			$('#cousin_details').css('display','block');
		}else{
			$('#cousin_details').css('display','none');
		}
		
	});
	
	$(document).on('click','#c_row_1',function(){
		if($(this).prop("checked") == true){
            $('#c_name_1').attr('disabled',false);
            $('#cf_name_1').attr('disabled',false);
            $('#c_class_1').attr('disabled',false);
            $('#c_section_1').attr('disabled',false);
            $('#since_ses_1').attr('disabled',false);
        }else{
        	$('#c_name_1').val('');
            $('#cf_name_1').val('');
            $('#c_class_1').val('');
            $('#c_section_1').val('');
            $('#since_ses_1').val('');
            
        	$('#c_name_1').attr('disabled',true);
            $('#cf_name_1').attr('disabled',true);
            $('#c_class_1').attr('disabled',true);
            $('#c_section_1').attr('disabled',true);
            $('#since_ses_1').attr('disabled',true);
        }
	});
	
	$(document).on('click','#c_row_2',function(){
		if($(this).prop("checked") == true){
            $('#c_name_2').attr('disabled',false);
            $('#cf_name_2').attr('disabled',false);
            $('#c_class_2').attr('disabled',false);
            $('#c_section_2').attr('disabled',false);
            $('#since_ses_2').attr('disabled',false);
        }else{
        	$('#c_name_2').val('');
            $('#cf_name_2').val('');
            $('#c_class_2').val('');
            $('#c_section_2').val('');
            $('#since_ses_2').val('');
            
        	$('#c_name_2').attr('disabled',true);
            $('#cf_name_2').attr('disabled',true);
            $('#c_class_2').attr('disabled',true);
            $('#c_section_2').attr('disabled',true);
            $('#since_ses_2').attr('disabled',true);
        }
	});
	
	$(document).on('click','#c_row_3',function(){
		if($(this).prop("checked") == true){
            $('#c_name_3').attr('disabled',false);
            $('#cf_name_3').attr('disabled',false);
            $('#c_class_3').attr('disabled',false);
            $('#c_section_3').attr('disabled',false);
            $('#since_ses_3').attr('disabled',false);
        }else{
        	$('#c_name_3').val('');
            $('#cf_name_3').val('');
            $('#c_class_3').val('');
            $('#c_section_3').val('');
            $('#since_ses_3').val('');
            
        	$('#c_name_3').attr('disabled',true);
            $('#cf_name_3').attr('disabled',true);
            $('#c_class_3').attr('disabled',true);
            $('#c_section_3').attr('disabled',true);
            $('#since_ses_3').attr('disabled',true);
        }
	});
	
});