$(document).ready(function(){

	var base_url = $('#base_url').val();

	$(document).on('change','#medium',function(){
	var medium = $(this).val();
		$.ajax({
			type:'POST',
			url:base_url+'Attendance_ctrl/getExamType',
			data:{medium:medium},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				$('#loader').modal('hide');
				x='<option value"">Select Exam Type</option>';
				if(response.status == 200){
					$.each(response.result,function(key,value){
						if(value.et_id == 2 || value.et_id == 4){
							x=x+'<option value="'+value.et_id+'">'+value.et_name+'</option>';
						}
					});		
					$('#exam_type').html(x);
				}	
						
			},
		});
	});

	$(document).on('change','#class_name',function(){
		var class_id = $(this).val();
		if(class_id == 14 || class_id == 15){
			$('#sg_row').css('display','block');
		}else{
			$('#sg_row').css('display','none');
			}
	});

	$(document).on('change','#medium',function(){
		var medium = $(this).val();
			$("#exam_type").prop('selectedIndex', '');
			$("#class_name").prop('selectedIndex', '');
			$("#sub_group").prop('selectedIndex', '');
			$("#section").prop('selectedIndex', '');
			$("#total_days").val('');
	});

	$(document).on('change','#exam_type',function(){
			$("#class_name").prop('selectedIndex', '');
			$("#sub_group").prop('selectedIndex', '');
			$("#section").prop('selectedIndex', '');
			$("#total_days").val('');
		
	});

	$(document).on('change','#class_name',function(){
			$("#sub_group").prop('selectedIndex', '');
			$("#section").prop('selectedIndex', '');
			$("#total_days").val('');
		
	});

	$(document).on('change','#sub_group',function(){
			$("#section").prop('selectedIndex', '');
			$("#total_days").val('');
	});


	$(document).on('change','#section',function(){
		var medium = $('#medium').val();
		var exam_type = $('#exam_type').val();
		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		var section = $(this).val();
		$.ajax({
			type:'POST',
			url:base_url+'Attendance_ctrl/getPresentDays',
			data:{
				'medium':medium,
				'exam_type':exam_type,
				'class_name':class_name,
				'section':section,
				'sub_group':sub_group
				},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					$('#am_id').val(response.result[0]['am_id']);
					$('#total_days').val(response.result[0]['total_days']);
					$('#search').css('display','block');
					$('#reset').css('display','block');
				}else{
					alert('This exam type/class not define total days of attendacne');
					$('#loader').modal('hide');
					$('#am_id').val('');
					$('#total_days').val('');
					$('#search').css('display','none');
					$('#reset').css('display','none');
					$('#section').prop('selectedIndex','');
					}
			}
		});
	});

	//--------------search button and get the records------------------------------
	$(document).on('click','#search',function(){
		var medium = $('#medium').val();
		var exam_type = $('#exam_type').val();
		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		var section = $('#section').val();
		var total_days = $('#total_days').val();
		var formvalid = true;
		
		if(medium === ''){
			$('#medium_err').html('medium is required.').css('display','block');
			formvalid = false;
		}else{
			$('#medium_err').css('dispaly','none');
			}

		if(exam_type === ''){
			$('#exam_type_err').html('exam_type is required.').css('display','block');
			formvalid = false;
			}else{
				$('#exam_type_err').css('display','none');
				}
		if(class_name === ''){
			$('#class_name_err').html('class is required.').css('display','block');
			formvalid = false;
			}else{
				$('#class_name_err').css('dispaly','none');
				}
		if(class_name == 14 || class_name == 15){
			if(sub_group == ''){
				$('#sub_group_err').html('subject group is required.').css('display','block');
				formvalid = false;
			}else{
				$('#sub_group_err').css('display','none');
				}
		}
		
		if(section === ''){
			$('#section_err').html('Section is required.').css('display','block');
			formvalid = false;
		}else{
			$('#section_err').css('dispaly','none');
			}
		if(total_days === ''){
			$('#total_days_err').html('total days is required.').css('display','block');
			}else{
				$('#total_days_err').css('display','none');
				}
		if(formvalid){
			$.ajax({
				type:'POST',
				url:base_url+'Attendance_ctrl/StudentRecords',
				data:{
					'medium':medium,
					'exam_type':exam_type,
					'class_name':class_name,
					'section':section,
					'sub_group':sub_group
					},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					$('#loader').modal('hide');
					x='';
					i=1;
					if(response.status == 200){
						$.each(response.result,function(key,value){
							x=x+'<tr>'+
								'<td>'+i+'</td>'+
								'<td>'+value.name+'</td>'+
								'<td>'+value.adm_no+'</td>'+
								'<td>'+value.roll_no+'</td>'+
								'<td><input type="text" name="attendance_entry" data-max="'+response.class_attendance[0]['total_days']+'" data-id="'+value.std_id+'" data-adm_no="'+value.adm_no+'" data-roll_no="'+value.roll_no+'" class="attendance" value="'+value.present_days+'"></td>'+
							i++;
						});
						$('#std_list').html(x);
						$('#submit').css('display','block');
					}else{
						$('#std_list').html('<tr><td colspan="5" style="text-align:center;">record not found.</td></tr>');
						$('#submit').css('display','none');
						}
						
				},
				
			});	
		}
	});

	// //-------------- blur on text box--------------------------------
	 $(document).on('blur','.attendance',function(){
	 		var max = $(this).data('max');
	 	  	var val = $(this).val();
	 	  		if(val > max || val === ''){
	 	  	  	$(this).css('box-shadow','0px 0px 10px red');
	 		  	$(this).focus();
	 		  	$('#submit').attr('disabled',true);
	 	  	}	
	 	  	else{
	 	  		$('#submit').attr('disabled',false);
	 	  	  	$(this).css('box-shadow','none');
	 	  	  	
	 			var attendance = $(this).val();
	 			var id = $(this).data('id');
	 			var adm_no = $(this).data('adm_no');
	 			var roll_no = $(this).data('roll_no');
	 			var total_days = $('#total_days').val();
	 			var am_id = $('#am_id').val();
	 			
	 			$.ajax({
	 				type:'POST',
	 				url:base_url+'Attendance_ctrl/submitAttendance',
	 				data:{
	 					'am_id':am_id,
	 					'attendance':attendance,
	 					'id':id,
	 					'adm_no':adm_no,
	 					'roll_no':roll_no,
	 					'total_days':total_days
	 					},
	 				dataType:'json',
//	 				beforeSend:function(){
//	 					$('#loader').modal('show');
//	 				},
	 				success:function(response){
	 					if(response.status == 200){
	 						//$('loader').modal('hide');
		 					//$('#search').trigger('click');
	 					}else{
	 						alert('someting went wrong, please check.');
	 					}
	 					
	 				},	
	 			});
	 	  	  	
	 	  	}
	 	});
	//-------------- focus on text box--------------------------------
	$(document).on('keyup','.attendance',function(){
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

	//------------press only A and number-------------------------
	$(document).on('keypress','.attendance',function(e){
	    var keyCode = e.which ? e.which : e.keyCode;
	    var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode <= 65 || keyCode <= 8));
	    if(!ret){
	        e.preventDefault();
	    }
	});

	//---------attendance entry section-------------------------
//	$(document).on('change','.attendance',function(){
//		var attendance = $(this).val();
//		var id = $(this).data('id');
//		var adm_no = $(this).data('adm_no');
//		var roll_no = $(this).data('roll_no');
//		var total_days = $('#total_days').val();
//		var am_id = $('#am_id').val();
//		
//		$.ajax({
//			type:'POST',
//			url:base_url+'Attendance_ctrl/submitAttendance',
//			data:{
//				'am_id':am_id,
//				'attendance':attendance,
//				'id':id,
//				'adm_no':adm_no,
//				'roll_no':roll_no,
//				'total_days':total_days
//				},
//			dataType:'json',
//			beforeSend:function(){
//				$('#loader').modal('show');
//			},
//			success:function(response){
//				$('loader').modal('hide');
//				$('#search').trigger('click');
//			},	
//		});
//		
//	});
	//-----------------------------------------------------------
	$(document).on('click','#submit',function(){
		alert('Attendance submited successfully');
		location.reload();
	});
});