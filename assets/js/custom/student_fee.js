$(document).ready(function(){
	var baseUrl = $('#base_url').val();
	var userUrl = $('#user_url').val();
	
	$(document).on('click','#search',function(){
		var session = $('#session').val();
		var school = $('#school').val();
		var medium = $('#medium').val();
		var class_name = $('#class_name').val();
		var section = $('#section').val();
		var search_data = '';
		var formvalidate = true;
		
		if(session == ''){
			$('#session_err').html('This is Required.').css('display','block');
			formvalidate = false;
		}else{
			$('#session_err').css('display','none');
		}
		
		if(school == ''){
			$('#school_err').html('This is Required.').css('display','block');
			formvalidate = false;
		}else{
			$('#school_err').css('display','none');
		}
		
		if(medium == ''){
			$('#medium_err').html('This is Required.').css('display','block');
			formvalidate = false;
		}else{
			$('#medium_err').css('display','none');
		}
		if(class_name == ''){
			$('#class_name_err').html('This is Required.').css('display','block');
			formvalidate = false;
		}else{
			$('#class_name_err').css('display','none');
		}
		
		
		studentList(session,school,medium,class_name,section,search_data);
	});
	
	//-----------------------search admission number----------------
	
	$(document).on('keyup','#search_box',function(){
		var session = $('#session').val();
		var school = $('#school').val();
		var medium = '';
		var class_name = '';
		var section = '';
		var search_data = $(this).val();
		var formvalidate = true;
		
		if(session == ''){
			$('#session_err').html('This is Required.').css('display','block');
			formvalidate = false;
		}else{
			$('#session_err').css('display','none');
		}
		
		if(school == ''){
			$('#school_err').html('This is Required.').css('display','block');
			formvalidate = false;
		}else{
			$('#school_err').css('display','none');
		}
	
		
		if(formvalidate){
			studentList(session,school,medium,class_name,section,search_data);
		}
	});
	
	
	function studentList(session,school,medium,class_name,section,search_data){
		$.ajax({
			type:'POST',
			url:baseUrl+'Student_fee_ctrl/studentList',
			data:{
				'session':session,
				'school':school,
				'medium':medium,
				'class_name':class_name,
				'section':section,
				'search_data':search_data
			},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					var x='';
					$.each(response.data,function(key,value){
						x=x+'<tr>'+
							'<td>'+parseInt(key+1)+'</td>'+
							'<td>'+value.adm_no+'</td>'+
							'<td>'+value.class_name+'/'+value.section_name+'</td>'+
							'<td>'+value.name+'</td>'+
							'<td>'+value.f_name+'</td>';
							if(value.sg_name){
								x=x+'<td>'+value.sg_name+'</td>';
							}else{
								x=x+'<td>-</td>';
							}
							x=x+'<td>'+value.contact_no+'</td>'+
							'<td>'+value.fc_name+'</td>';
							if(value.fc_name == 'RTE'){
								x=x+'<td><button class="btn btn-success btn-sm">RTE (No fee)</button></td>';
							}else{
								x=x+'<td><button data-ses_id="'+value.ses_id+'" data-sch_id="'+value.sch_id+'" data-med_id="'+value.medium+'" data-adm_no="'+value.adm_no+'" class="btn btn-sm btn-primary payment">Pay Now</button></td>';
							}
							
							x=x+'</tr>';
					});
					$('#student_list').html(x);
				}else{
					$('#student_list').html('<tr><td colspan="8" style="text-align:center;"></td></tr>');
				}
			},
		});
	}
	
	$(document).on('click','.payment',function(){
		var ses_id = $(this).data('ses_id');
		var sch_id = $(this).data('sch_id');
		var med_id = $(this).data('med_id');
		var adm_no = $(this).data('adm_no');
		window.open(baseUrl+userUrl+'/student-fee/payment/'+ses_id+'/'+sch_id+'/'+med_id+'/'+adm_no);
	});
	
});