$(document).ready(function(){
	var base_url = $('#base_url').val();

	$('#compartment_marks_entry_form').validate({
		rules:{
			medium:{required:true},
			exam_type:{required:true},
			class_name:{required:true},
			section:{required:true},
			sub_type:{required:true},
		},
		messages:{
		}
	});

	$(document).on('change','#sub_type',function(){
		var form_validate = $('#compartment_marks_entry_form').valid();

		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		if(class_name == 14 || class_name == 15){
			if(sub_group == ''){
				$('#sub_group_err').html('This field is required.').css('display','block');
				return false;
			}else{
				$('#sub_group_err').css('display','none');
				}
		}
		
		if(form_validate == true){
			var formdata = new FormData();
			formdata.append('exam_type',$('#exam_type').val());
			formdata.append('medium',$('#medium').val());
			formdata.append('class_name',$('#class_name').val());
			formdata.append('sub_group',$('#sub_group').val());
			formdata.append('section',$('#section').val());
			formdata.append('sub_type',$(this).val());

			$.ajax({
				type:'POST',
				url:base_url+'Marks_entry_ctrl/getSubjects',
				data:formdata,
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
//	 				console.log(response);
					$('#loader').modal('hide');
					x='<option value="">Select Subject</option>';
					if(response.status == 200){
						$.each(response.result,function(key,value){
							x=x+'<option value="'+value.sub_id+'">'+value.sub_name+' ('+value.st_name+')</option>';
						});
						$('#subject').html(x);
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
	//--------------------get section and subject_group----------------------------
	$(document).on('change','#class_name',function(){
		var exam_type = $('#exam_type').val();
		var medium = $('#medium').val();
		var class_id = $(this).val();
		if(class_id < 14){
			$.ajax({
				type:'post',
				url:base_url+'Marks_entry_ctrl/get_section',
				data:{'exam_type':exam_type,'medium':medium,'class_id':class_id,'sub_group':''},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');
						var x='<option value="">Select Section</option>';
						$.each(response.data,function(key,value){
							x=x+'<option value="'+value.sec_id+'">'+value.section_name+'</option>';
						});
						$('#section').html(x);
					}else{
						alert(response.msg);
					}
				},
			});
		}else{
			$.ajax({
				type:'post',
				url:base_url+'Marks_entry_ctrl/getSubGroup',
				data:{'exam_type':exam_type,'medium':medium,'class_id':class_id},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');
						var x='<option value="">Select Subject Group</option>';
						$.each(response.data,function(key,value){
							x=x+'<option value="'+value.sg_id+'">'+value.sg_name+'</option>';
						});
						$('#sub_group').html(x);
					}else{
						alert(response.msg);
					}
				},
			});
			
			$('#section').prop('selectedIndex','');
		}
		
	});
	//----------get section of class 11-12----------------------
	$(document).on('change','#sub_group',function(){
		var exam_type = $('#exam_type').val();
		var medium = $('#medium').val();
		var class_id = $('#class_name').val();
		var sub_group = $(this).val();
		$.ajax({
			type:'post',
			url:base_url+'Marks_entry_ctrl/get_section',
			data:{'exam_type':exam_type,'medium':medium,'class_id':class_id,'sub_group':sub_group},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					var x='<option value="">Select Section</option>';
					$.each(response.data,function(key,value){
						x=x+'<option value="'+value.sec_id+'">'+value.section_name+'</option>';
					});
					$('#section').html(x);
				}else{
					alert(response.msg);
				}
			},
		});
	});
	
	
	//--------------------get subject type----------------------
	
	$(document).on('change','#section',function(){
		$('#list_of_students').css('display','none');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
		
		if($('#exam_type').val() == 1 || $('#exam_type').val() == 3){
			$('#sub_type option[value="2"]').hide();
		}else{
			$('#sub_type option[value="2"]').show();
			}
		
		var exam_type = $('#exam_type').val();
		var medium = $('#medium').val();
		var class_id = $('#class_name').val();
		var section = $(this).val();
		$.ajax({
			type:'post',
			url:base_url+'Marks_entry_ctrl/getSubjectType',
			data:{'exam_type':exam_type,'medium':medium,'class_id':class_id,'section':section},
			dataType:'json',
			beforeSend:function(){$('#loader').modal('show');},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					var x='<option value="">Select Subject Type</option>';
					$.each(response.data,function(key,value){
						x=x+'<option value="'+value.st_id+'">'+value.st_name+'</option>';
					});
					$('#sub_type').html(x);
				}else{
					alert(response.msg);
				}
			},
		});
	});
	
	//-------------get student records---------------------------
	$(document).on('click','#search',function(){
		var form_validate = $('#compartment_marks_entry_form').valid();
		var exam_type = $('#exam_type').val();
		var medium = $('#medium').val();
		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		var section = $('#section').val();
		var sub_type = $('#sub_type').val();
		var subject = $('#subject').val();
		
		if(subject == ''){
			$('#subject_err').html('field is required.').css('display','block');
			return false;
		}else{
				$('#subject_err').css('display','block');
			}
		
		if(form_validate == true){
			formdata = new FormData();
			formdata.append('exam_type',exam_type);
			formdata.append('medium',medium);
			formdata.append('class_name',class_name);
			formdata.append('sub_group',sub_group);
			formdata.append('section',section);
			formdata.append('sub_type',sub_type);
			formdata.append('subject',subject);

			$.ajax({
					type:'POST',
					url:base_url+'Marks_entry_ctrl/compartment_student_records',
					data:formdata,
					dataType:'json',
					beforeSend:function(){
						$('#loader').modal('show');
					},
					success:function(response){
						if(response.status == 200){
							var x='';
							$.each(response.data,function(key,value){
								x=x+'<tr>'+
									'<td>'+parseInt(key+1)+'</td>'+
									'<td>'+value.name+'</td>'+
									'<td>'+value.class_name+'/'+value.section_name+'</td>'+
									'<td>'+value.adm_no+'</td>'+
									'<td>'+value.roll_no+'</td>'+
									'<td><input type="text" id="subject_marks_'+value.std_id+'" data-std_id="'+value.std_id+'" data-roll_no="'+value.roll_no+'" data-adm_no="'+value.adm_no+'" data-max="'+response.max_marks[0].sub_marks+'" value="'+value.sub_marks+'" name="subject_marks[]" class="subject_marks marks_entry_validation" style="width:50px;"></td>'+
									'</tr>';
							});
							$('#student_list').html(x);
							$('#marks_submit').css('display','block');
						}else{
							$('#student_list').html('<tr><td data-adm_no="'+value.adm_no+'" colspan="6" style="text-align:center;">'+response.msg+'</td></tr>');
						}
					},
					complete:function(){
						$('#loader').modal('hide');
					},
					cache:false,
			        contentType:false,
			        processData:false
			});
		}
	});
	
	//------------------students marks entry----------------------------
	$(document).on('click','#marks_submit',function(){
		var exam_type = $('#exam_type').val();
		var medium = $('#medium').val();
		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		var section = $('#section').val();
		var sub_type = $('#sub_type').val();
		var subject = $('#subject').val();
	 
	    
		 var std_marks = [];
			$('.subject_marks').each(function (index, value) {
				var temp = [];
				var std_id = $(this).data('std_id');
				
				if($('#subject_marks_'+std_id).val()){
					var sub_mark = $('#subject_marks_'+std_id).val();
				}else{
					var sub_mark = '';
				}
				
				if($('#practical_'+std_id).val()){
					var practical_marks = $('#practical_'+std_id).val();
				}else{
					var practical_marks = '';
				}
				temp.push({std_id : std_id});
				temp.push({adm_no : $(this).data('adm_no')});
				temp.push({subject_marks : sub_mark});
				temp.push({practical : practical_marks});
				std_marks.push(temp);
			});
			
			var formdata = new FormData();
			formdata.append('exam_type',exam_type);
			formdata.append('medium',medium);
			formdata.append('class_name',class_name);
			formdata.append('sub_group',sub_group);
			formdata.append('section',section);
			formdata.append('sub_type',sub_type);
			formdata.append('subject',subject);
			formdata.append('std_marks',JSON.stringify(std_marks));
	
			$.ajax({
					type:'POST',
					url:base_url+'Marks_entry_ctrl/CompartmentMarksEntry',
					data:formdata,
					dataType:'json',
					beforeSend:function(){
						$('#loader').modal('show');
					},	
					success:function(response){
						if(response.status == 200){
							alert(response.msg);
							location.reload();
						}else{
							alert(response.msg);
						}
					},
					cache:false,
			        contentType:false,
			        processData:false
			});
	});

	//----------------only 11-12th show gruoup section--------------------------
	$(document).on('change','#class_name',function(){
		var class_name = $(this).val();
		if(class_name == 14 || class_name == 15){
			$('#sub_group_row').css('display','block');		
		}else{
			$('#sub_group_row').css('display','none');
			}
	});

	//----------------min max validation----------------
		$(document).on('blur','.marks_entry_validation',function(){
			var max = $(this).data('max');
		  	var val = $(this).val();
		  	if(max != ''){
		  		if(val > max || val == ''){
			  	  	$(this).css('box-shadow','0px 0px 10px red');
				  	$(this).focus();
				  	$('#marks_submit').attr('disabled','disabled');
			  	}
			  	else{
			  		$('#marks_submit').attr('disabled',false);
			  	  	$(this).css('box-shadow','none');
			  	}
		  	}
		});	

	//-------------- focus on text box--------------------------------
	$(document).on('keyup','.marks_entry_validation',function(){
		var max = $(this).data('max');
	  	var val = $(this).val();
	  	if (val < 0){
	  	  	$(this).val(0);
	  	 }
	  	if(val > max){
	  	  	$(this).css('box-shadow','0px 0px 10px red');
		  	$(this).focus();
		    //$(this).val(max);
	  	}	
	  	else{
	  	  	$(this).css('box-shadow','none');
	  	}
	});

	//------------press only A and number-----------------------------
	$(document).on('keypress','.marks_entry_validation',function(e){
	    var keyCode = e.which ? e.which : e.keyCode;
	    var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode <= 65 || keyCode <= 8));
	    if(!ret){
	        e.preventDefault();
	    }
	});
	
	$(document).on('change','#exam_type',function(){
		$('#list_of_students').css('display','none');
		$('#medium').prop('selectedIndex','');
		$('#class_name').prop('selectedIndex','');
		$('#sub_group').prop('selectedIndex','');
		$('#section').prop('selectedIndex','');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
	});

	$(document).on('change','#medium',function(){
		$('#list_of_students').css('display','none');
		$('#class_name').prop('selectedIndex','');
		$('#sub_group').prop('selectedIndex','');
		$('#section').prop('selectedIndex','');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
	});
	
	$(document).on('change','#class_name',function(){
		$('#list_of_students').css('display','none');
		$('#sub_group').prop('selectedIndex','');
		$('#section').prop('selectedIndex','');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
	});
	$(document).on('change','#sub_group',function(){
		$('#list_of_students').css('display','none');
		$('#section').prop('selectedIndex','');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
	});
	
	$(document).on('change','#sub_type',function(){
		$('#list_of_students').css('display','none');
	});
	
	$(document).on('change','#subject',function(){
		$('#list_of_students').css('display','none');
	});
});