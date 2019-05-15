$(document).ready(function(){
	var base_url  = $('#base_url').val();
//------------------------*********--------------------------------
	$('#marks_entry_check').validate({
		rules:{
			exam_type:{required:true},
			medium:{required:true},
			class:{required:true},
			section:{required:true},
			},
		messages:{
			},
	});
	$(document).on('click','#search',function(){
		var form_valdate = $('#marks_entry_check').valid();

		if($('#class').val() >= 14){
			if($('#sub_group').val() == ''){
				$('#sub_group_err').html('This field is required.').css('display','block');
				return false;
				}else{
					$('#sub_group_err').css('display','block');
					}
		}
		var formdata = new FormData();
		formdata.append('exam_type',$('#exam_type').val());
		formdata.append('medium',$('#medium').val());
		formdata.append('class',$('#class').val());
		formdata.append('sub_group',$('#sub_group').val());
		formdata.append('section',$('#section').val());
		if(form_valdate == true){
			$.ajax({
					type:'POST',
					url:base_url+'Production_ctrl/marks_entry_check',
					data:formdata,
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
									'<td>'+value.sub_name+'</td>'+
									'<td>'+value.st_name+'</td>';
									if(value.entry == 'yes'){
										x=x+'<td><img src="'+base_url+'/assets/images/right.png"></td>';
									}else{
										x=x+'<td><img src="'+base_url+'/assets/images/wrong.png"></td>';
										}
									'<tr>';
								i++;	
							});
							$('#entry_check_list').html(x);
						}else{
							$('#entry_check_list').html('<tr><td colspan="4" style="text-align:center;">Subjects not allocated in this class/section.</td></tr>');
							}
					},
					cache:false,
					contentType:false,
					processData:false
				});
		}
	});
 //--------------------------------------------------------
	$(document).on('change','#class',function(){
		var class_id = $(this).val();
		if(class_id >= 14){
			$('#sub_group_form').css('display','block');
		}else{
			$('#sub_group_form').css('display','none');
			}
	});
});