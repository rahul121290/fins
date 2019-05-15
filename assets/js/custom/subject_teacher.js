$(document).ready(function(){
	var base_url = $('#base_url').val();
	$('#subject_teacher_form').validate({
		rules:{
			medium:{required:true},
			class_name:{required:true},
			section:{required:true},
//	 		sub_type:{required:true}
		},
		messages:{
			}
	});

	$(document).on('change','#section',function(){
		//----select index in subject type--------------
		
		var form_validate = $('#subject_teacher_form').valid();
		var medium = $('#medium').val();
		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		var section = $(this).val();
		
		if(class_name == 14 || class_name == 15){
			if(sub_group == ''){
				$('#sub_group_err').html('sub group field is required.').css('display','block');
				form_validate = false;
			}else{
				$('#sub_group_err').css('display','none');
				}
		}

		if(form_validate == true){
			$.ajax({
				type:'POST',
				url:base_url+'Teacher_ctrl/ListOfSubjectTeacher',
				data:{
	    				'medium':medium,
	    				'class_name':class_name,
	    				'sub_group':sub_group,
	    				'section':section
					},
				dataType:'json',
				beforeSend:function(){
				},
				success:function(response){
					x='';
					i=1;
					if(response.status == 200){
						$('#loader').modal('hide');
						$.each(response.result,function(key,value){
							x=x+'<tr>'+
								'<td>'+i+'</td>'+
	    						'<td>'+value.class_name+'</td>';
	    						if($('#class_name').val() >= 14){
	        						$('#table_sub_group').css('display','block');
	        						x=x+'<td>'+value.sg_name+'</td>';
	        					}else{
	        						$('#table_sub_group').css('display','none');
	            					}
	    						x=x+'<td>'+value.section_name+'</td>'+
	    						'<td>'+value.st_name+'</td>'+
	    						'<td>'+value.sub_name+'</td>'+
	    						'<td>'+value.teacher_name+'</td>'+
	    						'</tr>';
							i++;
						});
						$('#list_of_subject_teacher').html(x);
					}else{
						$('#list_of_subject_teacher').html('<tr><td colspan="7" style="text-align:center"> record not found.</td></tr>');
						}
				},
			});	
		}
		
	});		
//-----------get subject lists and teacher list-----------------------
	$(document).on('change','#sub_type',function(){	
		var form_validate = $('#subject_teacher_form').valid();
		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		if(class_name == 14 || class_name == 15){
			if(sub_group == ''){
				$('#sub_group_err').html('sub group field is required.').css('display','block');
				form_validate = false;
			}else{
				$('#sub_group_err').css('display','none');
				}
		}
		if(form_validate == true){
			var formdata = new FormData();
			//formdata.append('teacher',$('#teacher').val());
			formdata.append('medium',$('#medium').val());
			formdata.append('class_name',$('#class_name').val());
			formdata.append('sub_group',$('#sub_group').val());
			formdata.append('section',$('#section').val());
			formdata.append('sub_type',$(this).val());
			$.ajax({
				type:'POST',
				url:base_url+'Teacher_ctrl/getSubjects',
				data:formdata,
				async:false,
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					$('#loader').modal('hide');
					x = '';
					i=1;
					if(response.status == 200){
						$.each(response.result,function(key,value){
							
							x=x+'<tr>'+
								'<td>'+i+'</td>'+
								'<td>'+value.sub_name+'</td>'+
								'<td><select class="form-control teacher" data-sa_id="'+value.sa_id+'"><option value="">Select Teacher</option>';
									$.each(response.teachers,function(k,v){
	    								if(v.t_id == value.t_id && value.status == 1){
	        								var selected = 'selected';
	    								}else{
	    									var selected = '';
	        								}
	    								x=x+'<option value="'+v.t_id+'" '+selected+'>'+v.teacher_name+'</option>';
									});	
								x=x+'</select></td></tr>';
							i++;
						});
						$('#subjects_list').html(x);
						$('#section').trigger('change');
					}else{
	 						alert('First you can allocate class subjects, then assign subject teacher');
							$('#subjects_list').html('<tr><td colspan="3" style="text-align:center;">Record not found.</td></tr>');
							$('#list_of_subject_teacher').html('<tr><td colspan="7" style="text-align:center"> record not found.</td></tr>');
						}
				},
				cache:false,
				contentType:false,
				processData:false
			});	
		}	
	});

	//---------------assign subject teacher---------------------------
	$(document).on('change','.teacher',function(){
		var form_validate = $('#subject_teacher_form').valid();

		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		var section = $('#section').val();
		
		var t_id = $(this).val();
		var sa_id = $(this).data('sa_id');
		if(class_name == 14 || class_name == 15){
			if(sub_group == ''){
				$('#sub_group_err').html('sub group field is required.').css('display','block');
				form_validate = false;
			}else{
				$('#sub_group_err').css('display','none');
				}
		}
		if(form_validate == true){
			$.ajax({
				type:'POST',
				url:base_url+'Teacher_ctrl/allocateSubjectTeacher',
				data:{
					't_id':t_id,
					'sa_id':sa_id,
					'section':section
					},
				async:false,
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					console.log(response);
					if(response.status == 200){
						$('#section').trigger('change');
						$('#sub_type').trigger('change');
					}else{
						alert(response.feedback);
						}
				}
			});
		}
	});
//--------------------------------------------------------
	$(document).on('change','#medium',function(){
		$('#class_name').prop('selectedIndex', '');
		$('#sub_group').prop('selectedIndex', '');
		$('#section').prop('selectedIndex', '');
		$('#sub_type').prop('selectedIndex', '');
		$('#list_of_subject_teacher').html('<tr><td colspan="7" style="text-align:center"> record not found.</td></tr>');
		$('#subjects_list').html('<tr><td colspan="3" style="text-align:center;">Record not found.</td></tr>');
	});

	$(document).on('change','#class_name',function(){
		var class_name = $(this).val();
		if(class_name == 14 || class_name == 15){
			$('#sub_group_field').css('display','block');
		}else{
			$('#sub_group_field').css('display','none');
			}
		$('#sub_group').prop('selectedIndex', '');
		$('#section').prop('selectedIndex', '');
		$('#sub_type').prop('selectedIndex', '');
		$('#list_of_subject_teacher').html('<tr><td colspan="7" style="text-align:center"> record not found.</td></tr>');
		$('#subjects_list').html('<tr><td colspan="3" style="text-align:center;">Record not found.</td></tr>');
	});

	$(document).on('change','#sub_group',function(){
		$('#section').prop('selectedIndex', '');
		$('#sub_type').prop('selectedIndex', '');
		$('#list_of_subject_teacher').html('<tr><td colspan="7" style="text-align:center"> record not found.</td></tr>');
		$('#subjects_list').html('<tr><td colspan="3" style="text-align:center;">Record not found.</td></tr>');
	});
});