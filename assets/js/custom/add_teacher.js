$(document).ready(function(){
	var base_url = $('#base_url').val();
	var src = $('#path').val();

	//------------check unique email id------------------------
	$(document).on('change','#email',function(){
		var emailId = $(this).val();
		$.ajax({
			type:'POST',
			url:base_url+'Teacher_ctrl/checkUniqueEmail',
			data:{emailId:emailId},
			dataType:'json',
			success:function(response){
				if(response.status == 200){
					$('#email_err').html(response.result[0].email+' are already exist.').css('display','block');
					$('.teacher_submit').attr("disabled","disabled");
				}else{
	    				$('#email_err').css('display','none');
	    				$('.teacher_submit').removeAttr("disabled");
					}
			}
		});
	});
//----------------------------------------------------------------------------
	$( ".only_text" ).keypress(function(e) {
        var key = e.keyCode;
        if (key >= 48 && key <= 57) {
            e.preventDefault();
        }
    });
	//----------------teacher insert and update-----------------
	var class_teacher = $('input[name="is_class_teacher"]:checked').val();
	$('#teacher_form').validate({
		rules:{
			medium:{required:class_teacher == 'yes'},
			class:{required:class_teacher == 'yes'},
			sub_group:{required:$('#class').val() >= '14'},
			section:{required:class_teacher == 'yes'},
			teacher_name:{required:true},
			gender:{required:true},
			dob:{required:true},
			//email:{required:true,email:true},
			phone:{required:true},
			prmt_address:{required:true},
			//alter_address:{required:true},
			designation:{required:true},
			qualifications:{required:true}
			},
		messages:{
//				teacher_name:"",
//				gender:"",
//				dob:"",
//				email:"",
//				prmt_address:"",
//				alter_address:"",
//				designation:"",
//				qualifications:""
			}
	});
//-----------------------------------------------------------
	$(document).on('click','#submit_teacher',function(){
		var formvalid = $('#teacher_form').valid();

		if(formvalid == true){
			var img = $('#image').val();
			
			if(img){
				var img_ext=img.split('.').pop().toUpperCase();
				var img_size=$('#image')[0].files[0].size;

				if(img_ext!='JPG' && img_ext!='JPEG' && img_ext!='PNG' && img_ext!='GIF'){
					$('#image_err').hide();
					$('#image_err').text('');
					$('#image_err').show();
					$('#image_err').append("wrong file formate.");
					return false;
	    		}
	    		if(img_size>='1000024'){
	    			$('#image_err').hide();
	    			$('#image_err').text('');
	    			$('#image_err').show();
	    			$('#image_err').append("file size is to large.");
	    			return false;
	    		}		
			}

			var class_teacher = $('input[name="is_class_teacher"]:checked').val();
			
			var formdata = new FormData();
			formdata.append('ct_id',$('#ct_id').val());
			formdata.append('class_teacher',class_teacher);
			formdata.append('medium',$('#medium').val());
			formdata.append('class',$('#class').val());
			formdata.append('sub_group',$('#sub_group').val());
			formdata.append('section',$('#section').val());
			//----------------------------------------------------
			formdata.append('t_id',$('#t_id').val());
			formdata.append('teacher_name',$('#teacher_name').val());
			formdata.append('gender',$('#gender').val());
			formdata.append('dob',$('#dob').val());
			formdata.append('phone',$('#phone').val());
			formdata.append('email',$('#email').val());
			formdata.append('prmt_address',$('#prmt_address').val());
			formdata.append('alter_address',$('#alter_address').val());
			formdata.append('designation',$('#designation').val());
			formdata.append('qualifications',$('#qualifications').val());
			formdata.append('old_image',$('#old_image').val());
			formdata.append('image',$('#image')[0].files[0]);
			$.ajax({
				type:'POST',
				url:base_url+'Teacher_ctrl/submitTeacherData',
				data:formdata,
				aysc:false,
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');
						alert(response.feedback);
						location.reload();
						}else{
							alert(response.feedback);
						}
					if(response.status==400){
						alert(response.validation_errors);
					}
				},
				cache:false,
				contentType:false,
				processData:false
			});
			
		}
	});

	//------------------------------------
	$(document).on('click','.edit',function(){
		var id = $(this).attr('id');
		$.ajax({
			type:'POST',
			url:base_url+'Teacher_ctrl/eidtData',
			data:{id:id},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				console.log(response);
				if(response.status == 200){
					$('#loader').modal('hide');

					if(response.ct_data[0]){
						$('.no_check').removeAttr('checked');
						$('.yes_check').attr("checked", "checked");
						
						$('#medium_div').css('display','block');
						$('#class_div').css('display','block');
						$('#sub_group_form').css('display','block');
						$('#section_div').css('display','block');
						
						$('#ct_id').val(response.ct_data[0].ct_id);
						$('#medium').val(response.ct_data[0].med_id);
						$('#class').val(response.ct_data[0].class_id);
						$('#section').val(response.ct_data[0].sec_id);
						$('#sub_group').val(response.ct_data[0].sg_id);
						if(response.ct_data[0].class_id >= 14){
							$('#sub_group_form').css('display','block');
						}else{
							$('#sub_group_form').css('display','none');
							}
					}else{
						$('.yes_check').removeAttr('checked');
						$('.no_check').attr("checked", "checked");
						
						$('#medium_div').css('display','none');
						$('#class_div').css('display','none');
						$('#sub_group_form').css('display','none');
						$('#section_div').css('display','none');
						}
					
					$('#t_id').val(response.result[0].t_id);
					$('#teacher_name').val(response.result[0].teacher_name);
					$('#gender').val(response.result[0].gender);
					$('#dob').val(response.result[0].dob);
					$('#email').val(response.result[0].email);
					$('#prmt_address').val(response.result[0].prmt_address);
					$('#alter_address').val(response.result[0].alter_address);
					$('#designation').val(response.result[0].designation);
					$('#qualifications').val(response.result[0].qualifications);
					$('#old_image').val(response.result[0].image);
					$('#edit_preview').hide();
					$('#edit_preview').text('');
					$('#edit_preview').show();
					$('#edit_preview').append('<img src="'+src+response.result[0].image+'" style="height:50px;" width="50px;">');
					$('.teacher_submit').addClass('hide');
					$('.teacher_update').removeClass('hide');
				}
			},
		});
	});

	//--------delete record-------------------------
	$(document).on('click','.delete',function(){
		var delete_id = $(this).attr('id');
		if(confirm('are you sure!')){
		$.ajax({
				type:'POST',
				url:base_url+'Teacher_ctrl/deleteRecord',
				data:{delete_id:delete_id},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						location.reload();
					}else{
						alert(response.feedback);
						}
				},
			});
		}
	});


	$(document).on('change','#class',function(){
		var class_id = $(this).val();
		if(class_id >= 14){
			$('#sub_group_form').css('display','block');
		}else{
			$('#sub_group_form').css('display','none');
			}
		
	});

	$(document).on('click','#is_class_teacher',function(){
		var class_teacher = $(this).val();
		if(class_teacher == 'no'){
			$('#medium_div').css('display','none');
			$('#class_div').css('display','none');
			$('#sub_group_form').css('display','none');
			$('#section_div').css('display','none');
		}else{
			$('#medium_div').css('display','block');
			$('#class_div').css('display','block');
			$('#sub_group_form').css('display','block');
			$('#section_div').css('display','block');
			}
	});
});