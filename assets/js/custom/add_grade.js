$(document).ready(function(){
	var base_url = $('#base_url').val();

	listOfGrade();
	function listOfGrade(){
		$.ajax({
				url:base_url+'Utilities_and_tool_ctrl/listOfGrade',
				dataType:'json',
				success:function(response){
					console.log(response);
					x='';
					$.each(response.result,function(key,value){
						x=x+'<tr>'+
							'<td>'+parseInt(key+1)+'</td>'+
							'<td>'+value.min_no+'</td>'+
							'<td>'+value.max_no+'</td>'+
							'<td>'+value.grade+'</td>'+
							'<td>'+value.grade_point+'</td>'+
							'<td><button type="button" id="'+value.g_id +'" class="btn btn-primary btn-sm edit"><span class="glyphicon glyphicon-edit"></span> Edit </button>&nbsp;'+
	   					 	//'<button type="button" id="'+value.g_id +'" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span> Delete </button></td>'+
							'</tr>';
					});
					
					$('#grade_list').html(x);
				}
			});
	}
	//-----------------------------------------------------------
	$(document).on('click','.edit',function(){
		var edit_id = $(this).attr('id');
		$.ajax({
			type:'POST',
			url:base_url+'Utilities_and_tool_ctrl/GetGradeEditData',
			data:{edit_id:edit_id},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					$('#id').val(response.result[0].g_id);
					$('#medium').val(response.result[0].med_id);
					$('#min_no').val(response.result[0].min_no);
					$('#max_no').val(response.result[0].max_no);
					$('#grade').val(response.result[0].grade);
					$('#grade_point').val(response.result[0].grade_point);
					$('.update').removeClass('hide');
					$('.insert').addClass('hide');
				}else{
						alert(response.feedback);
					}
			}
		});
	});
	//--------------------delete section ----------------------
	$(document).on('click','.delete',function(){
		var delete_id = $(this).attr('id');
		if(confirm('are you sure!')){
			$.ajax({
				type:'POST',
				url:base_url+'Utilities_and_tool_ctrl/deleteGrade',
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

	//------------insert and update------------------------------
	$('#grade_form').validate({
		rules:{
			medium:{required:true},
			min_no:{required:true},
			max_no:{required:true},
			grade:{required:true},
			grade_point:{required:true},
		},
	});

	$(document).on('click','#submit',function(){
		var formvalidate = $('#grade_form').valid();

		var formdata = new FormData();
		formdata.append('id',$('#id').val());
		formdata.append('medium',$('#medium').val());
		formdata.append('min_no',$('#min_no').val());
		formdata.append('max_no',$('#max_no').val());
		formdata.append('grade',$('#grade').val());
		formdata.append('grade_point',$('#grade_point').val());
		if(formvalidate){
			$.ajax({
				type:'POST',
				url:base_url+'Utilities_and_tool_ctrl/GradeSubmit',
				data:formdata,
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
				},
				cache:false,
				contentType:false,
				processData:false	
			});
		}
	});
});