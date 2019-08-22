$( document ).ready(function() {
	var baseUrl = $('#base_url').val();
	var session = $('#session').val();
	var school = $('#school').val();
	var medium  = $('#medium').val();
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	
	$('#date_range').html('From '+ moment(from_date).format("DD-MM-YYYY")+' To ' +moment(to_date).format("DD-MM-YYYY"));
	
	day_wise_report(session,school,medium,from_date,to_date);
	function day_wise_report(session,school,medium,from_date,to_date){
		$.ajax({
			type:'POST',
			url:baseUrl+'Student_fee_ctrl/day_wise_report',
			data:{'session':session,
				'school':school,
				'medium':medium,
				'from_date':from_date,
				'to_date':to_date
			},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					$('#date_range').html('From '+ moment(from_date).format("DD-MM-YYYY")+' To ' +moment(to_date).format("DD-MM-YYYY"));
					
					$('#received_fee').html(response.data.month_paid);
					$('#pending_fee').html(response.data.month_pending);
					$('#total_fee').html(response.data.month_total);
					
					var x='<table class="table table-responsive"><tbody style="font-size:16px;">';
					x=x+='<tr><td><b>Received Amount</b></td><td style="font-size:20px;font-weight:600;color:#1b790f;">Rs. '+response.data.student_fee[0].paid_amount+'/-</td></tr>'+
					'<tr><td><b>Admission Fee</b></td><td>'+response.data.student_fee[0].admission_fee+'</td></tr>'+
					'<tr><td><b>Amalgamated Fund</b></td><td>'+response.data.student_fee[0].amalgamated_fund+'</td></tr>'+
					'<tr><td><b>Bus Fee</b></td><td>'+response.data.student_fee[0].bus_fee+'</td></tr>'+
					'<tr><td><b>Fee Waiver</b></td><td>'+response.data.student_fee[0].fee_waiver+'</td></tr>'+
					'<tr><td><b>Lab Fee</b></td><td>'+response.data.student_fee[0].lab_fee+'</td></tr>'+
					'<tr><td><b>Late Fee</b></td><td>'+response.data.student_fee[0].late_fee+'</td></tr>'+
					'<tr><td><b>Optional Sub</b></td><td>'+response.data.student_fee[0].optional_sub+'</td></tr>'+
					
					'<tr><td colspan="2" style="text-align:center;"><b>Pay Method</b></td></tr>'+
					
					'<tr><td><b>Cash</b></td><td>'+response.data.pay_method[0].cash+'</td></tr>'+
					'<tr><td><b>Cheque</b></td><td>'+response.data.pay_method[0].cheque+'</td></tr>'+
					'<tr><td><b>DD (Demand Draft)</b></td><td>'+response.data.pay_method[0].dd+'</td></tr>'+
					'<tr><td><b>Credit Card</b></td><td>'+response.data.pay_method[0].credit_card+'</td></tr>'+
					'<tr><td><b>Debit Card</b></td><td>'+response.data.pay_method[0].debit_card+'</td></tr>'+
					
					'</tbody></table>';
					$('#fee_report_table').html(x);
				}
			},
			complete:function(){},
		});
	}
	
	$(document).on('change','#school',function(){
		var school = $(this).val();
		var session = $('#session').val();
		var medium  = $('#medium').val();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		if(session == ''){
			$('#session_err').html('This is Required.').css('display','block');
			return false;
		}else{
			$('#session_err').css('display','none');
		}
		
		if(school == ''){
			$('#school_err').html('This is Required.').css('display','block');
			return false;
		}else{
			day_wise_report(session,school,medium,from_date,to_date);
		}
	});
	
	$(document).on('change','#medium',function(){
		var session = $('#session').val();
		var school = $('#school').val();
		var medium  = $(this).val();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		if(session == ''){
			$('#session_err').html('This is Required.').css('display','block');
			return false;
		}else{
			$('#session_err').css('display','none');
		}
		
		if(school == ''){
			$('#school_err').html('This is Required.').css('display','block');
			return false;
		}else{
			$('#school_err').css('display','none');
		}
		
		if(medium == ''){
			$('#medium_err').html('This is Required.').css('display','block');
			return false;
		}else{
			day_wise_report(session,school,medium,from_date,to_date);
		}
		
	});
	
	
	$(document).on('change','#from_date',function(){
		var session = $('#session').val();
		var school = $('#school').val();
		var medium  = $('#medium').val();
		var from_date = $(this).val();
		var to_date = $('#to_date').val();
		if(session == ''){
			$('#session_err').html('This is Required.').css('display','block');
			return false;
		}else{
			$('#session_err').css('display','none');
		}
		if(school == ''){
			$('#school_err').html('This is Required.').css('display','block');
			return false;
		}else{
			$('#school_err').css('display','none');
		}
		day_wise_report(session,school,medium,from_date,to_date);
		
	});
	
	$(document).on('change','#to_date',function(){
		var session = $('#session').val();
		var school = $('#school').val();
		var medium  = $('#medium').val();
		var from_date = $('#from_date').val();
		var to_date = $(this).val();
		if(session == ''){
			$('#session_err').html('This is Required.').css('display','block');
			return false;
		}else{
			$('#session_err').css('display','none');
		}
		if(school == ''){
			$('#school_err').html('This is Required.').css('display','block');
			return false;
		}else{
			$('#school_err').css('display','none');
		}
		day_wise_report(session,school,medium,from_date,to_date);
	});
	
	
});