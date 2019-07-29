<div class="content-wrapper">
    <section class="content-header">
      <h1>Reception<small>admission fee</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">new admission</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/new_admission.js"></script>
    <!-- Main content -->
    
            <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Fee Details</h3>
                </div>
            	<div class="box-body form-horizontal">
            	<form role="form" class="form-horizontal" id="student_form" method="POST">
        			<div class="box-body">
                        <input type="hidden" name="school_id" id="school_id" value="<?php echo $this->uri->segment(5);?>" />
                        <input type="hidden" name="admission_no" id="admission_no" value="<?php echo $this->uri->segment(6);?>" />
                   	</div>
                   		<div id="fee_details"></div>
        			</form>
        		</div><!-- end box body -->
     			</div>
    		</div>
    
</div>

<script type="text/javascript">
var base_url = $('#base_url').val();
var adm_no = $('#admission_no').val();
var sch_id = $('#school_id').val();

fee_details();
function fee_details(){
	$.ajax({
		type:'POST',
		url:base_url+'New_admission_ctrl/admission_fee_details',
		data:{'sch_id':sch_id,'adm_no':adm_no},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			console.log(response);
			if(response.status == 200){
				var x='';
				x=x+'<table class="table">'+
					'<tr>'+
    					'<td>Student Name</td>'+
    					'<td>'+response.data[0].name+'</td>'+
					'</tr>';

					x=x+'<tr>'+
    					'<td>Class</td>'+
    					'<td>'+response.data[0].class_id+'</td>'+
    				'</tr>';

    				if(response.data[0].sub_group != ''){
    					x=x+'<tr>'+
    					'<td>Subject Group</td>'+
        					'<td>'+response.data[0].sub_group+'</td>'+
        				'</tr>';
        			}

    				if(response.data[0].f_name != ''){
    					x=x+'<tr>'+
    					'<td>Father Name</td>'+
        					'<td>'+response.data[0].f_name+'</td>'+
        				'</tr>';
        			}

    				if(response.data[0].conact_no != ''){
    					x=x+'<tr>'+
    					'<td>Contact No.</td>'+
        					'<td>'+response.data[0].conact_no+'</td>'+
        				'</tr>';
        			}

    				if(response.data[0].sibling != ''){
    					x=x+'<tr>'+
    					'<td>Sibling</td>'+
        					'<td>'+response.data[0].sibling+'</td>'+
        				'</tr>';
        			}

					x=x+'<tr>'+
					'<td>Fee Month</td>'+
    					'<td><select id="month" name="month" class="form-control" multiple>'+
    						'<option value="">Select Month</option>'+
    						'<option value="1">January</option>'+
    						'<option value="2">February</option>'+
    						'<option value="3">March</option>'+
    						'<option value="4">April</option>'+
    						'<option value="5">May</option>'+
    						'<option value="6">June</option>'+
    						'<option value="7">July</option>'+
    						'<option value="8">August</option>'+
    						'<option value="9">September</option>'+
    						'<option value="10">October</option>'+
    						'<option value="11">November</option>'+
    						'<option value="12">December</option>'+
    					'</td>'+
    				'</tr>';
    			
					if(response.data[0].admission_fee > 0){
    					x=x+'<tr>'+
    					'<td>Admission Fee</td>'+
        					'<td><input type="text" id="admission_fee" name="admission_fee" data-admission_fee="'+response.data[0].admission_fee+'" value="'+response.data[0].admission_fee+'" class="form-control" disabled /></td>'+
        				'</tr>';
        			}

					if(response.data[0].amalgam_fee > 0){
    					x=x+'<tr>'+
    					'<td>amalgam_fee</td>'+
        					'<td><input type="text" id="amalgam_fee" name="amalgam_fee" data-amalgam_fee="'+response.data[0].amalgam_fee+'" value="'+response.data[0].amalgam_fee+'" class="form-control" disabled /></td>'+
        				'</tr>';
        			}

					if(response.data[0].tuition_fee > 0){
    					x=x+'<tr>'+
    					'<td>tuition_fee</td>'+
        					'<td><input type="text" id="tuition_fee" name="tuition_fee" data-tuition_fee="'+response.data[0].tuition_fee+'" value="'+response.data[0].tuition_fee+'" class="form-control" disabled /></td>'+
        				'</tr>';
        			}

					if(response.data[0].bus_fee > 0){
    					x=x+'<tr>'+
    					'<td>bus_fee</td>'+
        					'<td><input type="text" id="bus_fee" name="bus_fee" data-bus_fee="'+response.data[0].bus_fee+'" value="'+response.data[0].bus_fee+'" class="form-control" disabled /></td>'+
        				'</tr>';
        			}

					if(response.data[0].hostel_fee > 0){
    					x=x+'<tr>'+
    					'<td>hostel_fee</td>'+
        					'<td><input class="hostel-check" type="checkbox" id="hostel_check" />'+
        					'<input type="text" id="hostel_fee" name="hostel_fee" data-hostel_fee="'+response.data[0].hostel_fee+'" value="'+response.data[0].hostel_fee+'" class="form-control" disabled /></td>'+
        				'</tr>';
        			}

					if(response.data[0].lab_fee > 0){
    					x=x+'<tr>'+
    					'<td>hostel_fee</td>'+
        					'<td><input type="text" id="lab_fee" name="lab_fee" data-lab_fee="'+response.data[0].lab_fee+'" value="'+response.data[0].lab_fee+'" class="form-control" disabled /></td>'+
        				'</tr>';
        			}

					if(response.data[0].library_fee > 0){
    					x=x+'<tr>'+
    					'<td>library_fee</td>'+
        					'<td><input type="text" id="library_fee" name="library_fee" data-library_fee="'+response.data[0].library_fee+'" value="'+response.data[0].library_fee+'" class="form-control" disabled /></td>'+
        				'</tr>';
        			}

					if(response.data[0].optional_sub_fee > 0){
    					x=x+'<tr>'+
    					'<td>optional_sub_fee</td>'+
        					'<td><input type="text" id="optional_sub_fee" name="optional_sub_fee" data-optional_sub_fee="'+response.data[0].optional_sub_fee+'" value="'+response.data[0].optional_sub_fee+'" class="form-control" disabled /></td>'+
        				'</tr>';
        			}

					if(response.data[0].sibling > 'Yes'){
    					x=x+'<tr>'+
    					'<td>sibling_rebate</td>'+
        					'<td><input type="text" data-sibling="'+response.data[0].sibling+'" data-sibling_rebate="'+esponse.data[0].sibling_rebate+'" id="sibling_rebate" name="sibling_rebate" value="'+response.data[0].sibling_rebate+'" class="form-control" disabled /></td>'+
        				'</tr>';
        			}

					if(response.data[0].grand_total > 0){
    					x=x+'<tr>'+
    					'<td>grand_total</td>'+
        					'<td><input type="text" id="grand_total" name="grand_total" value="'+response.data[0].grand_total+'" class="form-control" disabled /></td>'+
        				'</tr>';
        			}

					x=x+'<tr>'+
					'<tr>'+
						'<td><b>Fee Waiver</b></td>'+
						'<td colspan="3" style="position:relative;">';
							if(response.data[0]['fee_waiver'] == '0'){
								var apply_amount =  response.data[0]['apply_amount'];
								var css_atrr = 'display:block;';
							}else{
								var apply_amount =  '';
								var css_atrr = 'display:none;';
							}
							x=x+'<input class="form-control" type="text" id="fee_waiver_amount" placeholder="fee waiver amount" value="'+apply_amount+'"/>'+
							'<div class="error" id="fee_waiver_amount_err" style="display:none;"></div>'+
								'<button type="button" id="fee_waiver_apply" class="btn btn-success btn-sm fee-waiver-apply-btn">Apply</button>'+
								'<input style="margin-top:15px; '+css_atrr+'" class="form-control fee_waiver_otp" id="fee_waiver_otp" type="text" maxlength="6" palaceholder="Type OTP" /><a style="'+css_atrr+'" class="resend-otp fee_waiver_resend" id="resend_otp" href="javascript:void(0);">Resend OTP</a>'+
								'<div class="error" id="fee_waiver_otp_err" style="display:none;"></div></td>'+
                					'</tr>'+
                				
                				'<tr>'+
                					'<td>'+
                						'<button type="button" id="otp_submit" class="btn btn-success btn-sm fee_waiver_otp" style="'+css_atrr+'">Submit OTP</button>'+
                					'</td>'+
                				'</tr>'+
                				
                				'<tr>'+
                				'<td><b>Grand Total</b></td>'+
                				'<td colspan="3"><input class="form-control" type="text" id="form_total" value="'+ response.data[0]['grand_total']  +'" disabled /></td>'+
                			'</tr>'+
                				
                			'<tr>'+
                				'<td><b>Payment Mode</b></td>'+
                				'<td  colspan="3"><input type="radio" name="pay_method" class="pay_method" data-method="cash" checked /> CASH &nbsp;&nbsp;&nbsp;&nbsp;'+
                					'<input type="radio" name="pay_method" class="pay_method" data-method="cheque" /> CHEQUE &nbsp;&nbsp;&nbsp;&nbsp;'+
                					'<input type="radio" name="pay_method" class="pay_method" data-method="dd" /> DD(Demand Draft) '+
                					
                					'<div id="cheque_box" style="display:none;">'+
                						'<input class="form-control mb-3" type="text" id="cheque_pay_method1" placeholder="Cheque No."/>'+
                						'<div class="error" id="cheque_pay_method1_err" style="display:none;"></div>'+
                						'<input type="date" class="form-control mb-3" id="cheque_pay_method2" placeholder="Cheque Date"/>'+
                						'<div class="error" id="cheque_pay_method2_err" style="display:none;"></div>'+
                						'<input class="form-control mb-3" type="text" id="cheque_pay_method3" placeholder="Bank Name" />'+
                						'<div class="error" id="cheque_pay_method3_err" style="display:none;"></div>'+
                					'</div>'+
                					'<div id="dd_box" style="display:none;">'+
                						'<input class="form-control mb-3" type="text" id="dd_pay_method1" placeholder="Demand Draft" />'+
                						'<div class="error" id="dd_pay_method1_err" style="display:none;"></div>'+
                						'<input class="form-control mb-3" type="date" id="dd_pay_method2" placeholder="Demand Draft Date" />'+
                						'<div class="error" id="dd_pay_method2_err" style="display:none;"></div>'+
                						'<input class="form-control mb-3" type="text" id="dd_pay_method3" placeholder="Bank Name" />'+
                						'<div class="error" id="dd_pay_method3_err" style="display:none;"></div>'+
                					'</div>'+
                				'</td>'+
                			'</tr>';
                				
				x=x+'</table>'+
				'<div class="box-footer text-center" style="padding:10px 0px;">'+
                    '<button type="button" id="fee_collect" class="btn btn-info">Submit</button>'+
    			'</div>';
				$('#fee_details').html(x);
			}
		},
	});
}

$(document).on('click','#fee_collect',function(){
	var month = $('#')
});

//----------------*********--------------------------------------
$(document).on('click','.pay_method',function(){
	var pay_method = $(this).data('method');
	if(pay_method == 'cash'){
		$('#cheque_box').css('display','none');
		$('#dd_box').css('display','none');
	} else if(pay_method == 'cheque'){
		$('#cheque_box').css('display','block');
		$('#dd_box').css('display','none');
	} else{
		$('#cheque_box').css('display','none');
		$('#dd_box').css('display','block');
	}
});

//----------------*********--------------------------------------
$(document).on('click','#fee_waiver_apply',function(){
	var fee_waiver_amount = $('#fee_waiver_amount').val();
	var formvalidate = true;
	
	if(fee_waiver_amount == ''){
		$('#fee_waiver_amount_err').html('This is Required.').css('display','block');
		formvalidate = false;
	}else{
		$('#fee_waiver_amount_err').css('display','none');
	}
	
	if(formvalidate){
		var that = this;
	   $.ajax({
			type:'POST',
			url:base_url+'Student_fee/fee_waiver_apply',
			data:{
				'adm_no' : $('#form_admin_no').val(),
				'session' : $('#session').val(),
				'school' : $('#school').val(),
				'amount' : $('#fee_waiver_amount').val(),
				'month' : $('#month').val()
			},
			dataType:'json',
			beforeSend:function(){
				$(that).attr("disabled", true);
			},
			success:function(response){
				if(response.status == 200){
					$('.fee_waiver_otp').css('display','block');
					$('.fee_waiver_resend').css('display','block');
				} else {
					$(that).attr("disabled", false);
				}
			}
		});
	}
});

//----------------**************--------------------------------
$(document).on('click','#resend_otp',function(){
	var fee_waiver_amount = $('#fee_waiver_amount').val();
	var formvalidate = true;
	
	if(fee_waiver_amount == ''){
		$('#fee_waiver_amount_err').html('This is Required.').css('display','block');
		formvalidate = false;
	}else{
		$('#fee_waiver_amount_err').css('display','none');
	}
	
	if(formvalidate){
		var that = this;
	   $.ajax({
			type:'POST',
			url:base_url+'Admin_ctrl/fee_waiver_apply',
			data:{
				'adm_no' : $('#form_admin_no').val(),
				'session' : $('#session').val(),
				'school' : $('#school').val(),
				'amount' : $('#fee_waiver_amount').val(),
				'month' : $('#month').val()
			},
			dataType:'json',
			beforeSend:function(){
				$(that).attr("disabled", true);
			},
			success:function(response){
				if(response.status == 200){
					$('.fee_waiver_otp').css('display','block');
					$('.fee_waiver_resend').css('display','block');
				} else {
					$(that).attr("disabled", false);
				}
			}
		});
	}
});

//-------------------------------Submit OTP----------------------------------------
$(document).on('click','#otp_submit',function(){
	var fee_waiver_otp = $('#fee_waiver_otp').val();
	var fee_waiver_amount = $('#fee_waiver_amount').val();
	var formvalid = true;
	
	if(fee_waiver_amount == ''){
		$('#fee_waiver_amount_err').html('This is Required.').css('display','block');
		formvalid = false;
	}else{
		$('#fee_waiver_amount_err').css('display','none');
	}
	
	if(fee_waiver_otp == ''){
		$('#fee_waiver_otp_err').html('This is Required.').css('display','block');
		formvalid = false;
	}else{
		$('#fee_waiver_otp_err').css('display','none');
	}
	
	if(formvalid){
		$.ajax({
    		type:'POST',
    		url:base_url+'Student_fee/check_otp',
    		data:{
    			'adm_no' : $('#form_admin_no').val(),
    			'session' : $('#session').val(),
    			'school' : $('#school').val(),
    			'amount' : $('#fee_waiver_amount').val(),
    			'month' : $('#month').val(),
    			'otp' : $('#fee_waiver_otp').val()
    		},
    		dataType:'json',
    		beforeSend:function(){
    			$('#loader').modal('show');
    		},
    		success:function(response){
    			if(response.status == 200){
    				$('#loader').modal('hide');
    				$('#fee_waiver_otp_err').html(response.msg).css('display','block');
    				$('#otp_submit').css('display','none');
    				var actual_amount = $('#form_total').val() - fee_waiver_amount;
    				$('#form_total').val(actual_amount);
    				$('#fee_collect').text('Submit '+actual_amount);
    			}else{
    				$('#loader').modal('hide');
    				$('#fee_waiver_otp_err').html(response.msg).css('display','block');
    			}
    			
    		}
    	});
	}
});


//--------------------------------------------------------------------------------
$(document).on('keypress keyup blur','#fee_waiver_amount',function (event) {
	if(event.which == 13){
		$( "#fee_waiver_apply" ).trigger( "click" );
	}else{
    	$(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
	}
});

$(document).on('keyup','#fee_waiver_otp',function (event) {
	if(event.which == 13){
		if($(this).val().length == 4){
			otp_check();
		}
	}else{
    	$(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
	}
});


$(document).on('change','#month',function(){
	var count_month = $(this).val().length;
	console.log(count_month);
	var admission_fee = parseInt($('#admission_fee').data('admission_fee'));
	var amalgam_fee =  parseInt($('#amalgam_fee').data('amalgam_fee'));
	//var tuition_fee =  (parseInt($('#tuition_fee').data('tuition_fee')) * count_month);
	var bus_fee =  parseInt($('#bus_fee').data('bus_fee')) * count_month;
	var hostel_fee =  parseInt($('#hostel_fee').data('hostel_fee'));
	var lab_fee =  parseInt($('#lab_fee').data('lab_fee'));
	var library_fee =  parseInt($('#library_fee').data('library_fee'));
	var optional_sub_fee =  parseInt($('#optional_sub_fee').data('optional_sub_fee'));
	var sibling = $('#sibling_rebate').data('sibling');
	if(sibling == 'Yes'){
		var sibling_rebate =  parseInt($('#sibling_rebate').data('sibling_rebate')) * count_month;
	}else{
		sibling_rebate = 0 ;
		}
	if(isNaN(admission_fee)){
		admission_fee = 0;
	}
	if(isNaN(amalgam_fee)){
		amalgam_fee = 0;
	}
	if(isNaN(tuition_fee)){
		tuition_fee = 0;
	}
	if(isNaN(bus_fee)){
		bus_fee = 0;
	}
	if(isNaN(hostel_fee)){
		hostel_fee = 0;
	}
	if(isNaN(lab_fee)){
		lab_fee = 0;
	}
	if(isNaN(library_fee)){
		library_fee = 0;
	}
	if(isNaN(optional_sub_fee)){
		optional_sub_fee = 0;
	}
	if(isNaN(sibling_rebate)){
		sibling_rebate = 0;
	}

	if($('#hostel_check').prop("checked")){
		hostel_fee = parseInt($('#hostel_fee').val());
	}else {
		hostel_fee = 0;
	}

	if(isNaN(hostel_fee)){
		hostel_fee = 0;
	}

	var total = ((admission_fee + amalgam_fee + tuition_fee + bus_fee + hostel_fee + lab_fee + library_fee + optional_sub_fee) - sibling_rebate);
	$('#tuition_fee').val(tuition_fee);
	$('#sibling_rebate').val(sibling_rebate);
	$('#bus_fee').val(bus_fee);
	$('#grand_total').val(total);
});

$(document).on('click','#hostel_check',function(){
	if($(this).prop("checked") == true){
		$('#hostel_fee').removeAttr('disabled','disabled');
		fee_total();
    }
    else if($(this).prop("checked") == false){
    	//alert("Checkbox is unchecked.");
    	$('#hostel_fee').attr('disabled','disabled');
    	fee_total();
    }
});

$(document).on('keyup','#hostel_fee',function(){
	fee_total();
});


function fee_total(){
	var admission_fee = parseInt($('#admission_fee').val());
	var amalgam_fee =  parseInt($('#amalgam_fee').val());
	var tuition_fee =  parseInt($('#tuition_fee').val());
	var bus_fee =  parseInt($('#bus_fee').val());
	var lab_fee =  parseInt($('#lab_fee').val());
	var library_fee =  parseInt($('#library_fee').val());
	var optional_sub_fee =  parseInt($('#optional_sub_fee').val());
	var sibling = $('#sibling_rebate').data('sibling');
	if(sibling == 'Yes'){
		var sibling_rebate =  parseInt($('#sibling_rebate').val());
	}else{
		sibling_rebate = 0 ;
		}
	if(isNaN(admission_fee)){
		admission_fee = 0;
	}
	if(isNaN(amalgam_fee)){
		amalgam_fee = 0;
	}
	if(isNaN(tuition_fee)){
		tuition_fee = 0;
	}
	if(isNaN(bus_fee)){
		bus_fee = 0;
	}

	if(isNaN(lab_fee)){
		lab_fee = 0;
	}
	if(isNaN(library_fee)){
		library_fee = 0;
	}
	if(isNaN(optional_sub_fee)){
		optional_sub_fee = 0;
	}
	if(isNaN(sibling_rebate)){
		sibling_rebate = 0;
	}

	if($('#hostel_check').prop("checked")){
		hostel_fee = parseInt($('#hostel_fee').val());
	}else {
		hostel_fee = 0;
	}

	if(isNaN(hostel_fee)){
		hostel_fee = 0;
	}
	
	var total = ((admission_fee + amalgam_fee + tuition_fee + bus_fee + hostel_fee + lab_fee + library_fee + optional_sub_fee) - sibling_rebate);
	$('#tuition_fee').val(tuition_fee);
	$('#sibling_rebate').val(sibling_rebate);
	$('#bus_fee').val(bus_fee);
	$('#grand_total').val(total);
}

</script>