$(document).ready(function(){
	var base_url = $('#base_url').val();
	var user_url = $('#user_url').val();
//----------datepicker-------------------------------------------
	$( ".datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange:"-50:+0",
		dateFormat: 'dd-mm-yy'
	});

	$(document).on('click','#verify_sibling_related_adm_no',function(){
		$('#sibling_verification').modal('show');
	});
	
	$(document).on('click','#search_record',function(){
		var school = $('#sibling_school').val();
		var medium = $('#sibling_medium').val();
		var class_id = $('#sibling_class').val();
		var section = $('#sibling_section').val();
		var siblingValidate = true;
		
		if(school == ''){
			$('#sibling_school_err').html('This is Required.').css('display','block');
			siblingValidate = false;
		}else{
			$('#sibling_school_err').css('display','none');
		}
		
		if(medium == ''){
			$('#sibling_medium_err').html('This is Required.').css('display','block');
			siblingValidate = false;
		}else{
			$('#sibling_medium_err').css('display','none');
		}
		
		if(class_id == ''){
			$('#sibling_class_err').html('This is Required.').css('display','block');
			siblingValidate = false;
		}else{
			$('#sibling_class_err').css('display','none');
		}
		
		if(section == ''){
			$('#sibling_section_err').html('This is Required.').css('display','block');
			siblingValidate = false;
		}else{
			$('#sibling_section_err').css('display','none');
		}
		
		if(siblingValidate){
			$.ajax({
				type:'POST',
				url:base_url+'New_admission_ctrl/student_record',
				data:{'school':school,'medium':medium,'class_id':class_id,'section':section},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');
						var x='';
						$.each(response.data,function(key,value){
							x=x+'<tr>'+
									'<td>'+parseInt(key+1)+'</td>'+
									'<td>'+value.adm_no+'</td>'+
									'<td>'+value.name+'</td>'+
									'<td>'+value.f_name+'</td>'+
									'<td>'+value.contact_no+'</td>'+
								'</tr>';
						});
						$('#student_list').html(x);
					}else{
						$('#loader').modal('hide');
						$('#student_list').html('<tr><td colspan="5">Record not found.</td></tr>');
					}
				},
			});
		}		
	});
//------------------------------------------------------------------------
	$(document).on('keyup','#related_adm_no',function(){
		var related_adm_no = $('#related_adm_no').val();
		$.ajax({
			type:'POST',
			url:base_url+'New_admission_ctrl/check_related',
			data:{'adm_no':related_adm_no},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					var x='<table>'+
						'<tr><td> Student Name: '+response.data[0].name+'</td></tr>'+
						'<tr><td> Father\s Name: '+response.data[0].f_name+'</td></tr>'+
						'<tr><td> Adm No.: '+response.data[0].adm_no+'</td></tr>'+
						'<tr><td> Class/Sec: '+response.data[0].class_name+'/'+response.data[0].section_name+'</td></tr>'+
						'<tr><td> School: '+response.data[0].school_name+'</td></tr>'+
						'</table>';
					$('#related_student_details').html(x).css('display','block');
				}else{
					$('#related_student_details').html('Student Not Found.').css('display','block');
				}
			},
		});
	});
	
//--------------check existing admission no--------------------------------
	$(document).on('keyup','#admission_no',function(){
		var admission_no = $('#admission_no').val();
		$.ajax({
				type:'POST',
				url:base_url+'Student_ctrl/check_admission_no',
				data:{'admission_no':admission_no},
				dataType:'json',
				success:function(response){
					if(response.status == 200){
						$('#admission_no_err').html('<strong>'+response.result[0].adm_no+'</strong> is already exist.').css('display','block');
					}else{
						$('#admission_no_err').css('display','none');
						}
				},
			});
	});
//---------------check existing roll number--------------
	$(document).on('keyup','#roll_no',function(){
		var roll_no = $('#roll_no').val();
		$.ajax({
				type:'POST',
				url:base_url+'Student_ctrl/check_roll_no',
				data:{'roll_no':roll_no},
				dataType:'json',
				success:function(response){
					if(response.status == 200){
						$('#roll_no_err').html('<strong>'+response.result[0].roll_no+'</strong> is already exist.').css('display','block');
					}else{
						$('#roll_no_err').css('display','none');
						}
				},
			});
	});
//-----------------------------------------------------
	$(document).on('change','#class',function(){
		  var c_id = $(this).val();
		  if(c_id == 12 || c_id == 13){
			  $('#fit_section').css('display','block');
		  }
		  else{
			 $('#fit_section').css('display','none'); 
		  }
		  
		  if(c_id == 14 || c_id == 15){
			$('#sub_group_section').css('display','block');  
			$('#elective_section').css('display','block');
		  }else{
			$('#sub_group_section').css('display','none');
			$('#elective_section').css('display','none');		
		  }
	});
	
	$(document).on('change','#fee_criteria',function(){
		var fee_criteria = $(this).val();
		
		if(fee_criteria == 2){
			$('#sibling_details').css('display','block');
		}else{
			$('#related_adm_no').val('');
			$('#sibling_details').css('display','none');
		}
		
		if(fee_criteria == 4 || fee_criteria == 5){
			$('#staff_child_row').css('display','block');			
		}else{
			$('#staff_child').prop('selectedIndex','');
			$('#staff_child_row').css('display','none');
			
		}
	});
	
	
	$(".only_int").on("keypress keyup blur", function(event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
	$( ".only_text" ).keypress(function(e) {
        var key = e.keyCode;
        if (key >= 48 && key <= 57) {
            e.preventDefault();
        }
    });
	
	$(document).on('click','#submit',function(){
		
		//--------------------add student---------------------------------
		$('#student_form').validate({
			rules:{
				fee_criteria:{required:true},
				staff_child:{
				    required: function(element) {
				        if ($("#fee_criteria").val() == 4 || $("#fee_criteria").val() == 5) {
				        	return true;
				        } else {
				        	return false;
				        }
				    },
				},
				
				related_adm_no:{
					required:function(element) {
				        if ($("#fee_criteria").val() == 2) {
				        	return true;
				        } else {
				        	return false;
				        }
				    },
			    },
				admission_no:{required:true,number:true},
				//roll_no:{required:true},
				student_name:{required:true},
				session:{required:true},
				school:{required:true},
				medium:{required:true},
				class:{required:true},
				//section:{required:true},
				father_name:{required:true},
				mother_name:{required:true},
				dob:{required:true},
				gender:{required:true},
				admission_date:{required:true},
				caste:{required:true},
//					blood:{required:true},
				//aadhaar:{required:true},
				address:{required:true},
//					guardian:{required:true},
//					local_address:{required:true},
				contact_no:{required:true},
				//email:{email:true},
//					medical:{required:true},
//					height:{required:true},
//					weight:{required:true},
				transfer:{required:true},
				hostler:{required:true},
				bus:{required:true},
				bus_stoppage: {
				    required: function(element) {
				        if ($("#bus").val() == "Yes") {
				        	return true;
				        } else {
				        	return false;
				        }
				    },
				},
			},
			messages:{
				},
		});
		
		
	    var formvalidate = $('#student_form').valid();//----- formvalidate = true-------------------
	    if(formvalidate == true){
	    	//----------------validation for fit,elective and subject groups---------------------------
	    	var class_id = $('#class').val();
	    	if(class_id == 12 || class_id == 13){
	    		if($('#fit').val() == ''){
	    			$('#fit_err').html('This field is required.').css('display','block');
	    			return false;
	    			}else{
	    				$('#fit_err').css('display','none');
	    			}		
	    	}
	    	if(class_id == 14 || class_id == 15){
	    		if($('#elective_subject').val() == ''){
	    			$('#elective_subject_err').html('Elective subject is required.').css('display','block');
	    			return false;
	    			}else{
	    				$('#elective_subject_err').css('display','none');
	    				}
	    		if($('#subject_group').val() == ''){
	    			$('#subject_group_err').html('Subject Group is required.').css('display','block');
	    			return false;
	    			}else{
	    				$('#subject_group_err').css('display','none');
	    				}	
	    	}
	    	
	    //--------------validation for image-------------------------------------------------		
	    	var img = $('#std_image').val();
	    	if(img){
	    		var img_ext=img.split('.').pop().toUpperCase();
	    		var img_size=$('#std_image')[0].files[0].size;
	    		if(img_ext!='JPG' && img_ext!='JPEG' && img_ext!='PNG' && img_ext!='GIF'){
	    			$('#std_image_err').hide();
	    			$('#std_image_err').text('');
	    			$('#std_image_err').show();
	    			$('#std_image_err').append("wrong file formate.");
	    			return false;	
	    		}
	    		if(img_size>='1000024'){
	    			$('#std_image_err').hide();
	    			$('#std_image_err').text('');
	    			$('#std_image_err').show();
	    			$('#std_image_err').append("file size is to large.");
	    			return false;
	    		}		
	    	}
//----------------------------------------------------------------------------------------
	    		formdata = new FormData();
	    		formdata.append('fee_criteria',$('#fee_criteria').val());
	    		formdata.append('staff_child',$('#staff_child').val());
	    		formdata.append('related_adm_no',$('#related_adm_no').val());
	    		
	    		
				formdata.append('adm_no',$('#admission_no').val());
				formdata.append('roll_no',$('#roll_no').val());
				formdata.append('name',$('#student_name').val());
				
				formdata.append('session',$('#session').val());
				formdata.append('school',$('#school').val());
				
				formdata.append('medium',$('#medium').val());
				formdata.append('class_id',$('#class').val());
				formdata.append('sec_id',$('#section').val());
				formdata.append('fit',$('#fit').val());
				formdata.append('elective',$('#elective_subject').val());
				formdata.append('sub_group',$('#subject_group').val());
				formdata.append('f_name',$('#father_name').val());
				formdata.append('m_name',$('#mother_name').val());
				formdata.append('dob',$('#dob').val());
				formdata.append('gender',$('#gender').val());
				formdata.append('admission_date',$('#admission_date').val());
				formdata.append('cast',$('#caste').val());
				formdata.append('blood_group',$('#blood').val());
				formdata.append('aadhar_no',$('#aadhaar').val());
				formdata.append('address',$('#address').val());
				formdata.append('guardian',$('#guardian').val());
				formdata.append('local_address',$('#local_address').val());
				formdata.append('contact_no',$('#contact_no').val());
				formdata.append('email_id',$('#email').val());
				formdata.append('medical',$('#medical').val());
				formdata.append('height',$('#height').val());
				formdata.append('weight',$('#weight').val());
				formdata.append('tc',$('#transfer').val());
				formdata.append('hostel',$('#hostel').val());
				formdata.append('hostler',$('#hostler').val());
				
				formdata.append('bus_stoppage',$('#bus_stoppage').val());
				formdata.append('bus',$('#bus').val());
				
				formdata.append('std_image',$('#std_image')[0].files[0]);
				$.ajax({
					type:'POST',
					url:base_url+'New_admission_ctrl/add_student',
					data:formdata,
					dataType:'json',
					beforeSend:function(){
						$('#loader').modal('show');	
					},
					success:function(response){
						console.log();
						if(response.status == 200){
							alert(response.msg);
							window.location.href = base_url+user_url+'/student-fee/payment/'+response.ses_id+'/'+response.sch_id+'/'+response.med_id+'/'+response.adm_no;
						}else{
							alert(response.feedback);
						}
					},
					cache:false,
					contentType:false,
					processData:false
				});
			}
	});

});