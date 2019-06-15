$(document).ready(function(){
	var base_url = $('#base_url').val();
	
	AllAttendanceList();
		function AllAttendanceList(){
			$.ajax({
				url:base_url+'Attendance_ctrl/listData',
				dataType:'json',
				success:function(response){
					if(response.status == 200){
						x='';
						i=1;
						$.each(response.result,function(key,value){
							x=x+'<tr>'+
								'<td>'+i+'</td>'+
								'<td>'+value.med_name+'</td>'+
								'<td>'+value.et_name+'</td>'+
								'<td>'+value.class_name+'</td>'+
								'<td>'+value.total_days+'</td>'+
								'<td><button type="button" id="'+value.am_id +'" class="btn btn-primary btn-sm edit"><span class="glyphicon glyphicon-edit"></span> Edit </button> &nbsp;'+
		    					 '<button type="button" id="'+value.am_id +'" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span> Delete </button></td>'+
								'</tr>';
							i++;
						});
						$('#list_of_attendance').html(x);
					}else{
						}
				},
			});
		}
	//-------------------edit process-------------------------------------
	$(document).on('click','.edit',function(){
		var edit_id = $(this).attr('id');
		$.ajax({
			type:'POST',
			url:base_url+'Attendance_ctrl/editData',
			data:{edit_id:edit_id},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					
					$('#id').val(response.result[0].am_id);
					$('#medium').val(response.result[0].med_id);
					$('#exam_type').val(response.result[0].et_id);
					$('#class_name').val(response.result[0].class_id);
					$('#class_attendace').val(response.result[0].total_days);

					$('#class_name').removeAttr('multiple');
					$('.btn_update').removeClass('hide');
					$('.btn_submit').addClass('hide');
					
					
				}else{
					alert(response.feedback);
					}
			},
		});
	});

//-------------------delete process----------------------------------
	$(document).on('click','.delete',function(){
		var deleteId = $(this).attr('id');
		if(confirm('are you sure!')){
			$.ajax({
				type:'POST',
				url:base_url+'Attendance_ctrl/deleteRecord',
				data:{'deleteId':deleteId},
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
//---------------------****************--------------------------------------
	$(document).on('click','#submit_attendace',function(){
		var id = $('#id').val();
		var medium = $('#medium').val(); 
		var exam_type = $('#exam_type').val();
		var class_name = $('#class_name').val();
		var class_attendace = $('#class_attendace').val();
		var formvalid = true;
		if(medium == ''){
			$('#medium_err').html('Exam Type is Required..').css('display','block');
			formvalid = false;
		}else{
			$('#medium_err').css('display','none');
			}
		if(exam_type == ''){
			$('#exam_type_err').html('Exam Type is Required..').css('display','block');
			formvalid = false;
		}else{
			$('#exam_type_err').css('display','none');
			}
		if(class_name == ''){
			$('#class_name_err').html('Class is Required..').css('display','block');
			formvalid = false;
		}else{
			$('#class_name_err').css('display','none');
			}

		if(class_attendace == ''){
			$('#class_attendace_err').html('This Field is Required..').css('display','block');
			formvalid = false;
		}else{
			$('#class_attendace_err').css('display','none');
			}
		if(formvalid == true){
			$.ajax({
				type:'POST',
				url:base_url+'attendance_ctrl/class_attendance',
				data:{
						'id':id,
    					'medium':medium,
    					'exam_type':exam_type,
    					'class_name':class_name,
    					'class_attendace':class_attendace
					},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						alert(response.feedback);
						location.reload();
					}else{
						alert(response.feedback);
						}
				},
			});
		}
	});
//------------------------------------------------------------
	$(document).on('change','#medium',function(){
		$('#exam_type').prop('selectedIndex','');
		$('#class_name').prop('selectedIndex','');
		$('#class_attendace').val('');
	});
//------------------------------------------------------------
	$(document).on('change','#exam_type',function(){
		$('#class_name').prop('selectedIndex','');
		$('#class_attendace').val('');
	});
	
	
	$("#class_attendace").on("keypress keyup blur",function (event) {
		$(this).val($(this).val().replace(/[^0-9\.]/g,''));
		    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
		        event.preventDefault();
		    }
		});
	
});