$(document).ready(function(){
	var baseUrl = $('#base_url').val();
	var userUrl = $('#user_url').val();

	$('#class_wise_fee_details').validate({
		rules:{
			session:{required:true},
			school:{required:true},
			medium:{required:true},
			class_name:{required:true},
			//section:{required:true},
			//fee_criteria:{required:true},
		},
	});

	$(document).on('click','#search',function(){
		var formvalidate = $('#class_wise_fee_details').valid();
		if(formvalidate){	
	    	var session = $('#session').val();
	    	var school = $('#school').val(); 
	    	var medium = $('#medium').val();
	    	var class_name = $('#class_name').val();
	    	var section = $('#section').val();
			var fee_criteria = $('#fee_criteria').val();
			var search_box = '';
			student_details_list(session,school,medium,class_name,section,fee_criteria,search_box);
		}
	});


	$(document).on('change','#search_box',function(){
		var search_box = $(this).val();
		var session = $('#session').val();
		var school = $('#school').val(); 
		var medium = '';
		var class_name = '';
		var section = '';
		var fee_criteria = '';

		if(search_box != ''){
			student_details_list(session,school,medium,class_name,section,fee_criteria,search_box);
		}
	});

	function student_details_list(session,school,medium,class_name,section,fee_criteria,search_box){
		$.ajax({
			type:'POST',
			url:baseUrl+'Student_fee_ctrl/student_fee_details',
			data:{
				'session':session,
				'school':school,
				'medium':medium,
				'class_name':class_name,
				'section':section,
				'fee_criteria':fee_criteria,
				'search_box':search_box
			},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					$('#paid_fee').html('<b>'+parseFloat(response.paid_fee).toFixed(2)+'</b>');
					$('#pending_fee').html('<b>'+parseFloat(response.pending_fee).toFixed(2)+'</b>');
					$('#total_fee').html('<b>'+parseFloat(response.total_fee).toFixed(2)+'</b>');
					
					var x='';
					$.each(response.data,function(key,value){
						if(value.pending_fee == '' || value.pending_fee == null || parseFloat(value.total) == parseFloat(0)){
							pending_fee = '-';
						}else{
							pending_fee = parseFloat(value.pending_fee).toFixed(2);
						}

						if(value.paid_fee == '' || value.paid_fee == null || parseFloat(value.total) == parseFloat(0)){
							paid_fee = '-';
						}else{
							paid_fee = parseFloat(value.paid_fee).toFixed(2);
						}

						if(value.total == '' || value.total == null || parseFloat(value.total) == parseFloat(0) ){
							total = '-';
						}else{
							total = parseFloat(value.total).toFixed(2);
						}
						
						x=x+'<tr>'+
							'<td>'+parseInt(key+1)+'</td>'+
							'<td>'+value.adm_no+'</td>'+
							'<td>'+value.class_name+'/'+value.section_name+'</td>'+
							'<td>'+value.name+'</td>'+
							'<td>'+value.f_name+'</td>'+
							'<td>'+value.bus+'</td>'+
							'<td style="width:25%;">'+value.pending_month+'</td>'+
							'<td>'+value.fc_name+'</td>'+
							'<td>'+value.staff_child+'</td>'+
							'<td>'+total+'</td>'+
							'<td>'+paid_fee+'</td>'+
							'<td>'+pending_fee+'</td>';
							if(value.fc_name == 'RTE'){
								x=x+'<td colspan="2"><button class="btn btn-warning">RTE</button>&nbsp;';
							}else{
								x=x+'<td class="no-print"><button data-ses_id="'+value.ses_id+'" data-sch_id="'+value.sch_id+'" data-med_id="'+value.medium+'" data-adm_no="'+value.adm_no+'" class="btn btn-success payment"><span class="glyphicon glyphicon-check"></span></button>&nbsp;'+
								'<button data-ses_id="'+value.ses_id+'" data-sch_id="'+value.sch_id+'" data-adm_no="'+value.adm_no+'" class="btn btn-primary view_details"><span class="glyphicon glyphicon-eye-open"></span></button>&nbsp;';
							}
							x=x+'<button data-ses_id="'+value.ses_id+'" data-sch_id="'+value.sch_id+'" data-adm_no="'+value.adm_no+'" class="btn btn-danger discontinue"><span class="glyphicon glyphicon-trash"></span></button></td>';
							'</tr>';
					});
					$('#student_list').html(x);
					$('#loader').modal('hide');
				}else{
					$('#paid_fee').html('<b>0.00</b>');
					$('#pending_fee').html('<b>0.00</b>');
					$('#total_fee').html('<b>0.00</b>');
					$('#student_list').html('<tr><td colspan="13" style="text-align:center;">Record not found.</td></tr>');
					$('#loader').modal('hide');
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

	$(document).on('click','.discontinue',function(){
		var ses_id = $(this).data('ses_id');
		var sch_id = $(this).data('sch_id');
		var adm_no = $(this).data('adm_no');

		var session = $('#session').val();
		var school = $('#school').val(); 
		var medium = $('#medium').val();
		var class_name = $('#class_name').val();
		var section = $('#section').val();
		var fee_criteria = $('#fee_criteria').val();
		if(confirm('Are you sure!')){
			$.ajax({
				type:'POST',
				url:baseUrl+'Student_fee_ctrl/student_discontinue',
				data:{'ses_id':ses_id,'sch_id':sch_id,'adm_no':adm_no},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');	
				},
				success:function(response){
					if(response.status == 200){
						alert(response.msg);
						student_details_list(session,school,medium,class_name,section,fee_criteria);
						$('#loader').modal('hide');
					}else{
						alert(response.msg);
						$('#loader').modal('hide');
					}
				},
			});
		}
	});

	$(document).on('click','.view_details',function(){
		var ses_id = $(this).data('ses_id');
		var sch_id = $(this).data('sch_id');
		var adm_no = $(this).data('adm_no');
		window.open(baseUrl+userUrl+'/report/student/'+ses_id+'/'+sch_id+'/'+adm_no);
	});
});