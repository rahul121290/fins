$(document).ready(function(){
	var baseUrl = $('#base_url').val();
	var userUrl = $('#user_url').val();
	//----------------------------------------------------------
	$(document).on('change','#pay_month',function(){
		var pay_month = $(this).val();
		var ses_id = $('#ses_id').val();
		var sch_id = $('#sch_id').val();
		var adm_no = $('#adm_no').val();
		
		$.ajax({
			type:'POST',
			url:baseUrl+'hostel/Hostel_students_ctrl/getPaymentAmount',
			data:{'ses_id':ses_id,'sch_id':sch_id,'adm_no':adm_no,'pay_month':pay_month},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					if(pay_month != 1){
						$('#pay_amount').attr('disabled',true);
					}
					if(pay_month == 2){
						$('#check_box_row').css('display','block');
						$('#check_box_div').html('<input type="checkbox" id="enable_pay_amount"> Enable Pay Amount');
					}
					$('#total_fee').val(parseFloat(response.data[0].total).toFixed(2));
					$('#previous_paid').val(parseFloat(response.data[0].previous_paid).toFixed(2));
					$('#pay_amount').val(parseFloat(response.data[0].pay_amount).toFixed(2));
					
					if(parseFloat(response.data[0].pending_amount) > 0){
						$('#pending_fee_row').css('display','block');
						$('#pending_amount').val(parseFloat(response.data[0].pending_amount).toFixed(2));
					}
					
					var taxable_amount =  parseFloat(parseFloat(response.data[0].pay_amount)*parseFloat(40)/parseFloat(100));
					var sgst = parseFloat(parseFloat(taxable_amount)*parseFloat(2.5)/parseFloat(100));
					var cgst = parseFloat(parseFloat(taxable_amount)*parseFloat(2.5)/parseFloat(100));
					var total_amount = parseFloat(parseFloat(response.data[0].pay_amount)+parseFloat(sgst)+parseFloat(cgst));
					
					$('#taxable_amount').val(taxable_amount.toFixed(2));
					$('#sgst').val(sgst.toFixed(2));
					$('#cgst').val(cgst.toFixed(2));
					$('#total_amount').val(total_amount.toFixed(2));
					$('#grand_total').val(total_amount.toFixed(2));
				}else{
					alert(response.msg);
					$('#pay_month').prop('selectedIndex','');
					$('#total_fee').val('');
					$('#previous_paid').val('');
					$('#pay_amount').val('');
					$('#grand_total').val('');
					$('#pending_amount').val('');
					$('#taxable_amount').val('');
					$('#sgst').val('');
					$('#cgst').val('');
					$('#total_amount').val('');
				}
			},
		});
	});
	
	//--------------------********--------------------------
	$(document).on('click','#enable_pay_amount',function(){
		if($(this).prop('checked') == true){
			if(confirm('Are you sure!')){
				var pay_month = $('#pay_month').val();
				var ses_id = $('#ses_id').val();
				var sch_id = $('#sch_id').val();
				var adm_no = $('#adm_no').val();
				$.ajax({
					type:'POST',
					url:baseUrl+'hostel/Hostel_students_ctrl/enablePayAmount',
					data:{'ses_id':ses_id,'sch_id':sch_id,'adm_no':adm_no,'pay_month':pay_month},
					dataType:'json',
					beforeSend:function(){},
					success:function(response){
						if(response.status == 200){
							$('#otp_div').html('<input type="text" id="otp" name="otp" class="form-control" placeholder="Enter OTP"><div id="otp_err" class="error"></div><button id="submit_otp" class="btn btn-sm btn-success">Submit OTP</button>');
							alert(response.msg);
						}else{
							alert(response.msg);
						}
					},
				});
			}else{
				$(this).prop('checked',false);
			}
		}else{
			$('#otp_div').html('');
		}
	});
	
	//--------------submit otp-------------------------------------------
	$(document).on('click','#submit_otp',function(){
		var otp = $('#otp').val();
		var pay_month = $('#pay_month').val();
		var ses_id = $('#ses_id').val();
		var sch_id = $('#sch_id').val();
		var adm_no = $('#adm_no').val();
		var formvalid = true;
		if(formvalid == ''){
			$('#otp_err').html('This is Required.').css('display','block');
			formvalid = false;
		}else{
			$('#otp_err').css('display','none');
		}
		if(formvalid){
			$.ajax({
				type:'POST',
				url:baseUrl+'hostel/Hostel_students_ctrl/submit_otp',
				data:{'ses_id':ses_id,'sch_id':sch_id,'adm_no':adm_no,'pay_month':pay_month,'otp':otp},
				dataType:'json',
				beforeSend:function(){},
				success:function(response){
					if(response.status == 200){
						alert(response.msg);
						$('#check_box_row').css('display','none');
						$('#otp_div').css('display','none');
						$('#pay_amount').prop('disabled',false);
					}else{
						alert(response.msg);
					}
				},
			});
		}
	});
	
	
	
	
	//-------------------change pay amount--------------------------------
	$(document).on('keyup','#pay_amount',function(){
		var previous_paid = $('#previous_paid').val();
		var pay_amount = $(this).val();
		var total_fee = $('#total_fee').val();
		
	  		if(parseFloat(pay_amount) > parseFloat(total_fee)){
		  	  	$(this).css('box-shadow','0px 0px 10px red');
			  	$(this).focus();
			  	$('#pay_amount_err').html('Entered Wrong Amount.').css('display','block');
			  	$('#hostel_fee_submit').attr('disabled',true);
		  	}else{
		  	  	$(this).css('box-shadow','none');
		  	    $('#hostel_fee_submit').attr('disabled',false);
		  	    $('#pay_amount_err').css('display','none');
		  	    var taxable_amount =  parseFloat(parseFloat(pay_amount)*parseFloat(40)/parseFloat(100));
				var sgst = parseFloat(parseFloat(taxable_amount)*parseFloat(2.5)/parseFloat(100));
				var cgst = parseFloat(parseFloat(taxable_amount)*parseFloat(2.5)/parseFloat(100));
				var total_amount = parseFloat(parseFloat(pay_amount)+parseFloat(sgst)+parseFloat(cgst));
				
				$('#taxable_amount').val(taxable_amount.toFixed(2));
				$('#sgst').val(sgst.toFixed(2));
				$('#cgst').val(cgst.toFixed(2));
				$('#total_amount').val(total_amount.toFixed(2));
				$('#grand_total').val(total_amount.toFixed(2));
				
		  	    var pending_fee = parseFloat(parseFloat(parseFloat(total_fee) - parseFloat(parseFloat(previous_paid) + parseFloat(pay_amount) ))).toFixed(2);
		  	    if(pending_fee > 0){
		  	    	$('#pending_fee_row').css('display','block');
		  	    	$('#pending_amount').val(pending_fee);
		  	    }else{
		  	    	$('#pending_fee_row').css('display','none');
		  	    }
		  	}
	});
	
	//----------paymethod section---------------------
	$(document).on('click','#cash',function(){
		if($(this).prop('checked') == true){
			$('#cash_amount').prop('disabled',false);
		}else{
			$('#cash_amount').val('');
			$('#cash_amount').prop('disabled',true);
		}
	});
	
	$(document).on('click','#cheque',function(){
		if($(this).prop('checked') == true){
			$('#cheque_amount').prop('disabled',false);
			$('#cheque_no').prop('disabled',false);
			$('#cheque_date').prop('disabled',false);
			$('#cheque_bank').prop('disabled',false);
		}else{
			$('#cheque_amount').val('');
			$('#cheque_no').val('');
			$('#cheque_date').val('');
			$('#cheque_bank').val('');
			
			$('#cheque_amount').prop('disabled',true);
			$('#cheque_no').prop('disabled',true);
			$('#cheque_date').prop('disabled',true);
			$('#cheque_bank').prop('disabled',true);
		}
	});
	
	$(document).on('click','#dd',function(){
		if($(this).prop('checked') == true){
			$('#dd_amount').prop('disabled',false);
			$('#dd_no').prop('disabled',false);
			$('#dd_date').prop('disabled',false);
			$('#dd_bank').prop('disabled',false);
		}else{
			$('#dd_amount').val('');
			$('#dd_no').val('');
			$('#dd_date').val('');
			$('#dd_bank').val('');
			
			$('#dd_amount').prop('disabled',true);
			$('#dd_no').prop('disabled',true);
			$('#dd_date').prop('disabled',true);
			$('#dd_bank').prop('disabled',true);
		}
	});
	
	$(document).on('click','#pos',function(){
		if($(this).prop('checked') == true){
			$('#pos_card').prop('disabled',false);
			$('#pos_amount').prop('disabled',false);
		}else{
			$('#pos_card').prop('selectedIndex','');
			$('#pos_amount').val('');
			$('#trns_charge').val('');
			
			$('#pos_card').prop('disabled',true);
			$('#pos_amount').prop('disabled',true);
		}
	});
	
//-------------card transaction amount---------------
	$(document).on('keyup','#pos_amount',function(){
		var pos_amount = $(this).val();
		if(pos_amount == ''){
			pos_amount = 0;
		}
		var pos_card = $('#pos_card').val();
		var fieldvalidate = true;
		if(pos_card == ''){
			$('#pos_card_err').html('This is Required.').css('display','block');
			fieldvalidate = false;
			$('#submit').prop('disabled',true);
		}else{
			$('#pos_card_err').css('display','none');
			$('#submit').prop('disabled',false);
		}
		
		if(pos_card == 'credit_card'){
			var card_charge = 2;
		}else if(parseFloat(pos_amount) >= parseFloat(2000)){
			var card_charge = 0.75;
		}else{
			card_charge = 0;
		}
		
		if(fieldvalidate){
			var trns_charge = parseFloat((parseFloat(pos_amount) * parseFloat(card_charge)) / parseFloat(100));
			$('#trns_charge').val(trns_charge.toFixed(2));
			$('#grand_total').val(parseFloat(parseFloat(trns_charge) + parseFloat($('#pay_amount').val())).toFixed(2) );
		}
	});
	
	
	$(document).on('change','#pos_card',function(){
		var pos_amount = $('#pos_amount').val();
		var pos_card = $(this).val();
		
		if(pos_amount != '' && pos_card != ''){
			
			if(pos_card == 'credit_card'){
				var card_charge = 2;
			}else if(parseFloat(pos_amount) >= parseFloat(2000)){
				var card_charge = 0.75;
			}else{
				card_charge = 0;
			}
			
			var trns_charge = parseFloat((parseFloat(pos_amount) * parseFloat(card_charge)) / parseFloat(100));
			$('#trns_charge').val(trns_charge.toFixed(2));
			$('#grand_total').val(parseFloat(parseFloat(trns_charge) + parseFloat($('#pay_amount').val())).toFixed(2) );
			
			$('#pos_card_err').css('diplay','none');
			$('#submit').prop('disabled',false);
		}else{
			$('#pos_amount').val('');
			$('#trns_charge').val('');
		}
	});
	
	//-------------- focus on text box--------------------------------
	$(document).on('keyup','.max_type',function(){
		var max = $('#total_amount').val();
		
		var val = parseFloat(0);
		$('.max_type').each(function(){
			val += +$(this).val();
		});
	  	
		$('#pay_method_amount').html(val);
	  	if (parseFloat(val) < parseFloat(0)){
	  	  	$(this).val(0.00);
	  	  	$('#pay_method_amount').html($(this).val(0.00));
	  	 }
	  	if(parseFloat(val) < parseFloat(max)){
	  		$('#pay_method_amount').html('Outstanding <b>' + parseFloat(parseFloat(max) - parseFloat(val))+'</b>');
	  	}
	  	if(parseFloat(val) > parseFloat(max)){
	  	  	$(this).css('box-shadow','0px 0px 10px red');
		  	$(this).focus();
		  	$('#pay_method_amount').html('Worng amount <b>'+ parseFloat(parseFloat(val) - parseFloat(max))+'</b> Rs. extra.');
	  	}	
	  	else{
	  	  	$(this).css('box-shadow','none');
	  	}
	  	
	  	if(parseFloat(val) == parseFloat(max)){
	  		$('#pay_method_amount').html('Currect amount <b>' +parseFloat(val)+'</b>');
	  	}
	});
	//-----------------hostel fee submit-----------------
	
	$('#hostel_fee_form').validate({
		rules:{
			pay_month:{required:true},
			total_fee:{required:true},
			pay_amount:{required:true},
			pending_amount:{required:true},
			taxable_amount:{required:true},
			cgst:{required:true},
			sgst:{required:true},
			total_amount:{required:true}
		},
	});
	$(document).on('click','#hostel_fee_submit',function(){
		var formvalidate = $('#hostel_fee_form').valid();
		var ses_id = $('#ses_id').val();
		var sch_id = $('#sch_id').val();
		var medium = $('#medium').val();
		var adm_no = $('#adm_no').val();
		var pay_month = $('#pay_month').val();
		var total_fee = $('#total_fee').val();
		var pay_amount = $('#pay_amount').val();
		var taxable_amount = $('#taxable_amount').val();
		var cgst = $('#cgst').val();
		var sgst = $('#sgst').val();
		var total_amount = $('#total_amount').val();
		var pending_amount = $('#pending_amount').val();
		
		var cal_pay_method_amount = 0;
		var pay_option = [];
		$('.pay_method').each(function(){
			var temp = [];
			if($(this).prop('checked') == true){
				if($(this).attr('id') == 'cash'){
					cal_pay_method_amount  = parseFloat(parseFloat(cal_pay_method_amount) + parseFloat($('#cash_amount').val()) );
					var pay_method = 'cash';
					var amount = $('#cash_amount').val();
					var method_no = '';
					var date = '';
					var bank_name = '';
					var card = '';
					var trns_amount = '';
				}
				if($(this).attr('id') == 'cheque'){
					cal_pay_method_amount  = parseFloat(parseFloat(cal_pay_method_amount) + parseFloat($('#cheque_amount').val()) );
					var pay_method = 'cheque';
					var amount = $('#cheque_amount').val();
					var method_no = $('#cheque_no').val();
					var date = $('#cheque_date').val();
					var bank_name = $('#cheque_bank').val();
					var card = '';
					var trns_amount = '';
				}
				if($(this).attr('id') == 'dd'){
					cal_pay_method_amount  = parseFloat(parseFloat(cal_pay_method_amount) + parseFloat($('#dd_amount').val()) );
					var pay_method = 'dd';
					var amount = $('#dd_amount').val();
					var method_no = $('#dd_no').val();
					var date = $('#dd_date').val();
					var bank_name = $('#dd_bank').val();
					var card = '';
					var trns_amount = '';
				}
				if($(this).attr('id') == 'pos'){
					cal_pay_method_amount  = parseFloat(parseFloat(cal_pay_method_amount) + parseFloat($('#pos_amount').val()) );
					var pay_method = 'pos';
					var amount = $('#pos_amount').val();
					var card = $('#pos_card').val();
					var trns_amount = $('#trns_charge').val();
					var method_no = '';
					var date = '';
					var bank_name = '';
				}
				temp.push({pay_method : pay_method});
				temp.push({amount : amount});
				temp.push({card : card});
				temp.push({trns_amount : trns_amount});
				temp.push({method_no : method_no});
				temp.push({date : date});
				temp.push({bank_name : bank_name});
				pay_option.push(temp);
			}
		});
		
		if(parseFloat(cal_pay_method_amount) != parseFloat(total_amount)){
			alert('Pay amount missmatch.');
			formvalidate = false;
		}
		
		if(formvalidate == true){
			$.ajax({
				type:'POST',
				url:baseUrl+'hostel/Hostel_students_ctrl/paymentHostelFee',
				data:{
					'ses_id':ses_id,
					'sch_id':sch_id,
					'medium':medium,
					'adm_no':adm_no,
					'pay_month':pay_month,
					'total_fee':total_fee,
					'pay_amount':pay_amount,
					'taxable_amount':taxable_amount,
					'cgst':cgst,
					'sgst':sgst,
					'total_amount':total_amount,
					'pending_amount':pending_amount,
					'pay_option':pay_option
				},
				dataType:'json',
				beforeSend:function(){},
				success:function(response){
					if(response.status == 200){
						alert(response.msg);
						window.location.href = baseUrl+userUrl+'/hostel/receipt/'+response.receipt_no;
					}else{
						alert(response.msg);
					}
				},
			});
		}
	});
});