$( document ).ready(function() {
	var baseUrl = $('#base_url').val();


	$('#fee_history_form').validate({
		rules:{
			session:{required:true},
			school:{required:true},
			medium:{required:true},
			//class_name:{required:true},
		},
	});
	$(document).on('click','#search_fee_history',function(){
		var formvalidate = $('#fee_history_form').valid();
		if(formvalidate){
			var formdata = new FormData();
			formdata.append('session',$('#session').val());
			formdata.append('school',$('#school').val());
			formdata.append('medium',$('#medium').val());
			formdata.append('class',$('#class_name').val());
			formdata.append('from_date',$('#from_date').val());
			formdata.append('to_date',$('#to_date').val());
			formdata.append('fee_status',$('#fee_status').val());
			formdata.append('fee_waiver',$('#fee_waiver').val());
			
			$.ajax({
				type:'POST',
				url:baseUrl+'Fee_history_ctrl/getFeeHistory',
				data:formdata,
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');
						$('#total_amount').html(response.data.generated_fee);
						$('#collected_amount').html(parseInt(response.data.collected_amount).toFixed(2));
						$('#fee_waiver_show').html(response.data.fee_waiver);
						
						if(parseInt(response.data.pending_amount) > 0 ){
							var pending_amount = parseInt(response.data.pending_amount).toFixed(2);
						}else{
							var pending_amount = '-';
						}
						$('#pending_amount').html(pending_amount);

						var x='';
						$.each(response.data.student_history,function(key,value){
							if(value.pay_status == 0){
								var pay_status = 'Pending';
							}else{
								var pay_status = 'Paid';
								}
							x=x+'<tr>'+
	    							'<td>'+parseInt(key+1)+'</td>'+
	    							'<td>'+value.adm_no+'</td>'+
	    							'<td>'+value.name+'</td>'+
	    							'<td>'+value.class_name+'/'+value.section_name+'</td>'+
	    							'<td>'+value.contact_no+'</td>'+
	    							'<td>'+value.total+'</td>'+
	    							'<td>'+pay_status+'</td>'+
								'</tr>';
						});
						$('#student_list').html(x);
						
					}else{
						$('#student_list').html('<tr><td colspan="7" style="text-align:center;">Record not found</td></tr>');
					}
				},
				cache:false,
				contentType:false,
				processData:false
			});
		}
	});
	//----------------***********-----------------

	$(document).on('keyup','#search_box',function(){
		var session = $('#session').val();
		var school = $('#school').val();
		var adm_no = $(this).val();
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

		if(adm_no == ''){
			$('#search_box_err').html('This is Required.').css('display','block');
			formvalidate = false;
		}else{
			$('#search_box_err').css('display','none');
		}

		if(formvalidate){
			var formdata = new FormData();
			formdata.append('session',$('#session').val());
			formdata.append('school',$('#school').val());
			formdata.append('adm_no',adm_no);
			
			$.ajax({
				type:'POST',
				url:baseUrl+'Fee_history_ctrl/getFeeHistory',
				data:formdata,
				dataType:'json',
				beforeSend:function(){},
				success:function(response){
					if(response.status == 200){
						$('#total_amount').html(response.data.generated_fee);
						$('#collected_amount').html(parseInt(response.data.collected_amount).toFixed(2));
						$('#fee_waiver_show').html(response.data.fee_waiver);
						if(parseInt(response.data.pending_amount) > 0 ){
							var pending_amount = parseInt(response.data.pending_amount).toFixed(2);
						}else{
							var pending_amount = '-';
						}
						$('#pending_amount').html(pending_amount);

						var x='';
						$.each(response.data.student_history,function(key,value){
							if(value.pay_status == 0){
								var pay_status = 'Pending';
							}else{
								var pay_status = 'Paid';
								}
							x=x+'<tr>'+
									'<td>'+parseInt(key+1)+'</td>'+
									'<td>'+value.adm_no+'</td>'+
									'<td>'+value.name+'</td>'+
									'<td>'+value.class_name+'/'+value.section_name+'</td>'+
									'<td>'+value.contact_no+'</td>'+
									'<td>'+value.total+'</td>'+
									'<td>'+pay_status+'</td>'+
								'</tr>';
						});
						$('#student_list').html(x);
						
					}else{
						$('#student_list').html('<tr><td colspan="7" style="text-align:center;">Record not found</td></tr>');
					}
				},
				cache:false,
				contentType:false,
				processData:false
			});
		}
	});

	//------------------****************------------------------
	getAllRecords();
	function getAllRecords(){
		$.ajax({
			type:'GET',
			url:baseUrl+'Fee_history_ctrl/getAllRecords',
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					$('#total_amount').html(response.data.generated_fee);
					$('#collected_amount').html(parseInt(response.data.collected_amount).toFixed(2));
					$('#fee_waiver_show').html(response.data.fee_waiver);
					$('#pending_amount').html(parseInt(response.data.pending_amount).toFixed(2));
				}else{
					
				}
			},
		});
	}
});