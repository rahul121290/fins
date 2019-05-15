$(document).ready(function(){
	var base_url = $('#base_url').val();
 //-----------------------------------------------------------
	$(document).on('change','#medium',function(){
		$('#teacher').prop('selectedIndex','');
		$('#t_name').html('Teacher Abstract');
		$('#list_of_teacher_abstract').html('<tr><td colspan="15" style="text-align:center">record not found.</td></tr>');
		
		var medium = $(this).val();
		$.ajax({
			type:'POST',
			url:base_url+'Production_ctrl/getTeachers',
			data:{medium:medium},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				$('#loader').modal('hide');
				if(response.status == 200){
					x='<option value="">Select Teachers</option>';
					$.each(response.result,function(key,value){
							x=x+'<option value="'+value.t_id+'">'+value.teacher_name+'</option>';
					});
					$('#teacher').html(x);
				}else{
					alert(response.feedback);
					}		
			},
		});
	});
	//--------------teacher abstract---------------------
	$('#teacher_abstract_form').validate({
		rules:{
			exam_type:{required:true},
			medium:{required:true},
			teacher:{required:true},
			}
	});
	$(document).on('click','#search',function(){
		var formvalidate = $('#teacher_abstract_form').valid();
		if(formvalidate){
			var formdata = new FormData();
			formdata.append('exam_type',$('#exam_type').val());
			formdata.append('medium',$('#medium').val());
			formdata.append('teacher',$('#teacher').val());

			$.ajax({
				type:'POST',
				url:base_url+'Production_ctrl/TeacherAbstract',
				data:formdata,
				dataType:'json',
				befoeSend:function(){
					$('#lader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');
						$('#t_name').html(response.result[0].teacher_name);
						x='';
						$.each(response.result,function(key,value){
							x=x+'<tr>'+
								'<td>'+parseInt(key+1)+'</td>'+
								'<td>'+value.class_name+'/'+value.section+'</td>'+
								'<td>'+value.sub_name+'</td>'+
								'<td>'+value.sg_name+'</td>'+
								'<td>'+value.total_student+'</td>'+
								'<td>'+value.total_appear+'</td>'+
								'<td>'+value.total_pass+'</td>'+
								'<td>'+value.pass_percent+'</td>'+
								'<td>'+value.first_div+'</td>'+
								'<td>'+value.first_percent+'</td>'+
								'<td>'+value.second_div+'</td>'+
								'<td>'+value.third_div+'</td>'+
								'<td>'+value.fail+'</td>'+
								'<td>'+value.max_marks+'/'+value.max_marks_std+'</td>'+
								'<td>'+value.pi+'</td>'+
								'<tr>';
						});
						$('#list_of_teacher_abstract').html(x);
					}else{
						$('#t_name').html('Teacher Abstract');
						$('#list_of_teacher_abstract').html('<tr><td colspan="15" style="text-align:center">record not found.</td></tr>');
						}
				},
				cache:false,
				contentType:false,
				processData:false
			});
		}
	});
});