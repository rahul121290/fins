$(document).ready(function(){
	var base_url = $('#base_url').val();
	var user_url = $('#user_url').val();
	
	$(document).on('change','#class_name',function(){
		var class_id = $(this).val();
    	if(class_id == 12 || class_id == 13){
    		$('#fit_table').css('display','block');
    	}else{
    			$('#fit_table').css('display','none');
    			$('#fit_value').prop('selectedIndex','');
    		}
    
    	if(class_id == 14 || class_id == 15){
    		$('#sub_group_table').css('display','block');
    	}else{
    		$('#sub_group_table').css('display','none');
    		$('#sub_group').prop('selectedIndex','');
    		}
	});

//	$(document).on('change','#session,#school,#medium,#class_name,#section,sub_group',function(){
//		$('#search').trigger('click');
//	});

	$('#fee_form').validate({
		rules:{
			session:{required:true},
			school:{required:true},
			medium:{required:true},
			class_name:{required:true},
			section:{required:true},
			month:{required:true},
		},
	});
	
	$(document).on('click','#search',function(){
		var formvalid = $('#fee_form').valid();
		
		var medium = $('#medium').val();
	    var class_name = $('#class_name').val();
	    var sub_group = $('#sub_group').val();
	    var section = $('#section').val();
	    var month = $('#month').val();
	    
		if($('#session').val() == '0'){
			$('#session_err').html('Please select session.').css('display','block');
			formvalid = false;
		}else{
			$('#session_err').css('display','none');
		}
		
		
		if(formvalid == true){
			var formdata = new FormData();
			formdata.append('session',$('#session').val());
			formdata.append('school',$('#school').val());
			formdata.append('medium',medium);
			formdata.append('class',class_name);
			formdata.append('sub_group',sub_group);
			formdata.append('section',section);
			formdata.append('month',month);
			$.ajax({
					type:'POST',
					url:base_url+'Student_fee/getStudentData',
					data:formdata,
					dataType:'json',
					beforeSend:function(){
						$('#loader').modal('show');
					},
					success:function(response){
						$('#loader').modal('hide');
						if(response.status == 200){
    						x='';
    						i=1;
    						$.each(response.result,function(key,value){
    							if(value.sg_name == null || value.sg_name == ''){
    								var sub_group = '-';
    							}else{
    								var sub_group = value.sg_name;
    							}
    							
    							if(value.sub_name == null || value.sub_name == ''){
    								var elective = '-';
    							}else{
    								var elective = value.sub_name;
    							}
    							
    							x=x+'<tr>'+
    								'<td>'+value.adm_no+'</td>'+
    								'<td>'+value.class_name+'/'+value.section_name+'</td>'+
    								'<td>'+value.name+'</td>'+
    								'<td>'+value.f_name+'</td>'+
									'<td>'+sub_group+'</td>'+
    								'<td>'+value.contact_no+'</td>';
    							if(value.pay_status == 1){
    								x = x + '<td><b style="color:green;">Paid</b></td>';
    								x = x + '<td><button type="button" data-receipt_no="'+ value.receipt_no +'" class="btn btn-success btn-sm print_receipt"><span class="glyphicon glyphicon-print"></span> Print</button></td>';
    							}else{		
    								x = x + '<td><b style="color:red;">Pending</b></td>';
    								x = x + '<td><button type="button" data-ses_id="'+value.ses_id+'" data-sch_id="'+value.sch_id+'" data-medium="'+value.medium+'" data-class_id="'+value.class_id+'" data-sub_group="'+value.sub_group+'" data-sec_id="'+value.sec_id+'" data-adm_no="'+ value.adm_no +'" class="btn btn-primary btn-sm fee-action"><span class="glyphicon glyphicon-edit"></span> Pay</button></td>';
    							}
    							'<tr>';
    							i++;
    						});
    						$('#student_list').html(x);
						}else{
							$('#student_list').html('<tr><td colspan="15" style="text-align:center;">Record not Found.</td></tr>');
							}
					},
					contentType:false,
					processData:false
			});
		}
			
	});
	
//--------------search admission no----------------------
    $(document).on('keyup','#search_box',function(){
		var adm_no = $(this).val();
		var session = $('#session').val();
		var school = $('#school').val();
		var month = $('#month').val();
	    var formvalid = true;
	    if(session == ''){
	    	$('#session_err').html('This is Required').css('display','block');
	    	formvalid = false;
	    }else{
	    	$('#session_err').css('display','none');
	    }
	    
	    if(school == ''){
	    	$('#school_err').html('This is Required').css('display','block');
	    	formvalid = false;
	    }else{
	    	$('#session_err').css('display','none');
	    }
	    
	    if(month == ''){
	    	$('#month_err').html('This is Required').css('display','block');
	    	formvalid = false;
	    }else{
	    	$('#month_err').css('display','none');
	    }
		
	    if(formvalid){
	    	$.ajax({
				type:'POST',
				url:base_url+'Student_fee/getAdmNoRecord',
				data:{
					'session': session,
					'school': school,
					'month':month,
					'adm_no': adm_no
				},
				dataType:'json',
				beforeSend:function(){},
				success:function(response){
					if(response.status == 200){
						x='';
						i=1;
						$.each(response.result,function(key,value){
							x=x+'<tr>'+
									'<td>'+ value.adm_no +'</td>'+
									'<td>'+ value.class_name +'/'+ value.section_name +'</td>'+
									'<td>'+ value.name +'</td>'+
									'<td>'+ value.f_name +'</td>'+
									'<td>'+ value.sg_name +'</td>'+
									'<td>'+ value.contact_no +'</td>';
							
							if(value.pay_status == 1){
								x = x + '<td>Paid</td>';
								x = x + '<td><button type="button" data-receipt_no="'+ value.receipt_no +'" class="btn btn-success btn-sm print_receipt"><span class="glyphicon glyphicon-print"></span> Print</button></td>';
							}else{		
								x = x + '<td>Pending</td>';
								x = x + '<td><button type="button" data-ses_id="'+value.ses_id+'" data-sch_id="'+value.sch_id+'" data-medium="'+value.medium+'" data-class_id="'+value.class_id+'" data-sub_group="'+value.sub_group+'" data-sec_id="'+value.sec_id+'" data-adm_no="'+ value.adm_no +'" class="btn btn-primary btn-sm fee-action"><span class="glyphicon glyphicon-edit"></span> Pay</button></td>';
							}
	    					x = x +'<tr>';
							i++;
						});
						$('#student_list').html(x);
					}else{
						$('#student_list').html('<tr><td colspan="15" style="text-align:center;">Record not Found.</td></tr>');
					}
				},
				
			});
	    }
		
	});
    
    //---------------view pay section-------------------    
    $(document).on('click','.print_receipt',function(){
    	var receipt_no = $(this).data('receipt_no');
    	window.open(base_url+user_url+'/student-fee/receipt/'+receipt_no,"popupWindow", "width=960, height=960, scrollbars=yes");
    });
    
    //---------------view pay section-------------------
    $(document).on('click','.fee-action', function(){
    	var adm_no = $(this).data('adm_no');
    	var session = $(this).data('ses_id');
		var school = $(this).data('sch_id');
		var medium = $(this).data('medium');
	    var class_name = $(this).data('class_id');
	    var sub_group = $(this).data('sub_group');
	    var section = $(this).data('sec_id');
	    var month = $('#month').val();
	    console.log();
	    
    	$.ajax({
			type:'POST',
			url:base_url+'Student_fee/student_fee_detail',
			data:{
				'adm_no' : adm_no,
				'session' : session,
				'school' : school,
				'medium' : medium,
				'class_name' : class_name,
				'sub_group' : sub_group,
				'section' : section,
				'month' : month
			},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				$('#loader').modal('hide');
				if(response.status == 200){
					var x = '<table class="table table-responsive">'+
								'<tbody>'+
									'<tr style="display:none;">'+
										'<td></td>'+
										'<td>'+
											'<input type="text" id="form_fee_id" value="'+ response.data[0]['sf_id'] +'">'+
											'<input type="text" id="form_admin_no" value="'+ response.data[0]['adm_no'] +'">'+
											'<input type="text" id="form_student_id" value="'+ response.data[0]['std_id'] +'">'+
											'<input type="text" id="month_fee" value="'+ response.data[0]['tution_fee'] +'">'+
											
										'</td>'+
									'</tr>'+
									'<tr>'+
										'<td>Admission No.</td>'+
										'<td>: '+ response.data[0]['adm_no'] +'</td>'+
										'<td>Class/ Section</td>'+
										'<td>: '+ response.data[0]['class_name'] +'/'+ response.data[0]['section_name'] +'</td>'+
									'</tr>'+
							
									'<tr>'+
										'<td>Student Name</td>'+
										'<td>: '+ response.data[0]['name'] +'</td>'+
										'<td>Father\'s Name</td>'+
										'<td>: '+ response.data[0]['f_name'] +'</td>'+
									'</tr>';
									
									if(response.data[0]['subgroup'] != null){
									x = x + '<tr>'+
												'<td>Subject Group</td>'+
												'<td>: '+ response.data[0]['subgroup'] +'</td>'+
											'</tr>';
									}
									x = x + '<tr>'+
										'<td>Contact No.</td>'+
										'<td>: '+ response.data[0]['contact_no'] +'</td>'+
									'</tr>'+
									'<tr>'+
										'<td>Fee Months</td>'+
										'<td colspan="3">'+
											'<select id="form_month" class="form-control form_month" multiple>';
												$.each(response.month,function(mkey,mvalue){
													x=x+'<option value="'+mvalue.m_id+'">'+mvalue.m_name+'</option>';
												});
											x=x+'</select>'+
											'<div id="form_month_err" class="error" style="display:none;"></div>'+
										'</td>'+
									'</tr>'+ 
									'<tr>'+
										'<td><b>Tution Fee</b></td>'+
										'<td colspan="3"><input class="form-control" type="text" data-val="'+ response.data[0]['tution_fee'] +'" id="form_tution_fee" value="'+ response.data[0]['tution_fee'] +'" disabled /></td>'+
									'</tr>';
									if(response.data[0]['sibling'] == '1'){
									x = x + '<tr>'+
										'<td><b>Sibling Rebate</b></td>'+
										'<td colspan="3"><input class="form-control" type="text" data-val="'+ response.data[0]['sibling_rebate'] +'" id="" value="'+ response.data[0]['sibling_rebate'] +'" disabled /></td>'+
									'</tr>';
									}
									
									if(response.data[0]['hostel_fee'] != ''){
									x= x +'<tr>'+
										'<td><b>Hostel Fee</b></td>'+
										'<td colspan="3">'+
										'<input class="hostel-check" type="checkbox" id="hostel_check" />'+ 
										'<input disabled style="padding-left:25px;" class="form-control" type="text" data-instalment="'+response.data[0]['instalment']+'" data-hf_id ="'+response.data[0]['hf_id']+'" data-val="'+ response.data[0]['due_amount'] +'" id="form_hostel_fee" value="'+ response.data[0]['due_amount']  +'"></td>'+
									'</tr>';
									}
									if(response.data[0]['bus_fee'] > 0){
									x= x +'<tr>'+
										'<td><b>Bus Fee</b></td>'+
										'<td colspan="3"><input class="form-control" type="text" data-val="'+ response.data[0]['bus_fee'] +'" id="form_bus_fee" value="'+ response.data[0]['bus_fee']  +'" disabled></td>'+
									'</tr>';
									}
									if(response.data[0]['lab_fee'] > 0){
										x= x +'<tr>'+
											'<td><b>Lab Fee</b></td>'+
											'<td colspan="3"><input class="form-control" type="text" data-val="'+ response.data[0]['lab_fee'] +'" id="form_lab_fee" value="'+ response.data[0]['lab_fee']  +'" disabled></td>'+
										'</tr>';
									}
									if(response.data[0]['library_fee'] > 0){
										x= x +'<tr>'+
											'<td><b>Library Fee</b></td>'+
											'<td colspan="3"><input class="form-control" type="text" data-val="'+ response.data[0]['library_fee'] +'" id="form_library_fee" value="'+ response.data[0]['library_fee']  +'" disabled></td>'+
										'</tr>';
									}
									if(response.data[0]['optional_sub_fee'] > 0){
										x= x +'<tr>'+
											'<td><b>Optional Sub Fee</b></td>'+
											'<td colspan="3"><input class="form-control" type="text" data-val="'+ response.data[0]['optional_sub_fee']  +'" id="form_optional_sub_fee" value="'+ response.data[0]['optional_sub_fee']  +'" disabled></td>'+
										'</tr>';
									}
											
									if(response.data[0]['let_fee'] > 0){
										x=x+'<tr>'+
											'<td><b>Let fee</b></td>'+
											'<td colspan="3"><input class="form-control" type="text" id="let_fee" value="'+ response.data[0]['let_fee']  +'" disabled /></td>'+
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
									'</tr>'+
								'</tbody>'+
							'</table>'+
							'<div class="box-footer text-center" style="padding:10px 0px;">'+
	                            '<button type="button" name="submit" id="fee_collect" class="btn btn-info">Submit '+ response.data[0]['grand_total'] +'</button>'+
	        				'</div>';
					$('#fee-detail-box').css('display','block');
					$('#fee-detail').html(x).css('display','block');
				}else{
					alert(response.msg);
				}
			}
    	});
    });
    
    $(document).on('click','#fee_collect',function(){
		var data = {};
			data['std_id'] = $('#form_student_id').val();
			data['fs_id'] = $('#form_fee_id').val();
			data['adm_no'] = $('#form_admin_no').val();
			data['month'] = [];
			 $.each($(".form_month option:selected"), function(){          
				 data['month'].push($(this).val());
			 });
			
			data['tution_fee'] = $('#form_tution_fee').val();
			data['month_fee'] = $('#month_fee').val();
			data['hf_id'] = $('#form_hostel_fee').data('hf_id');
			data['hostel_due_amount'] = $('#form_hostel_fee').data('val');
			data['hostel_paid_amount'] = $('#form_hostel_fee').val();
			data['instalment'] = $('#form_hostel_fee').data('instalment'); 
			
			data['bus_fee'] = $('#form_bus_fee').val();
			data['lab_fee'] = $('#form_lab_fee').val();
			data['library_fee'] = $('#form_library_fee').val();
			data['optional_sub_fee'] = $('#form_optional_sub_fee').val();
			data['let_fee'] = $('#let_fee').val();
			data['total'] = $('#form_total').val();
			data['pay_method'] = $("input[name='pay_method']:checked").data('method');
			if($(this).prop("checked") == true){
				 data['hostel'] = true;
			 }else{
				data['hostel'] = false; 
			 }
			
			var formvalidate = true;
			
			if(data['pay_method'] == 'cheque'){
				var cheque_pay_method1 = $('#cheque_pay_method1').val();
				var cheque_pay_method2 = $('#cheque_pay_method2').val();
				var cheque_pay_method3 = $('#cheque_pay_method3').val();
				
				data['cheque_pay_method1'] = cheque_pay_method1;
				data['cheque_pay_method2'] = cheque_pay_method2;
				data['cheque_pay_method3'] = cheque_pay_method3;
				
				if(cheque_pay_method1 == ''){
					$('#cheque_pay_method1_err').html('This is Required.').css('display','block');
					formvalidate = false;
				}else{
					$('#cheque_pay_method1_err').css('display','none');
				}
				
				if(cheque_pay_method2 == ''){
					$('#cheque_pay_method2_err').html('This is Required.').css('display','block');
					formvalidate = false;
				}else{
					$('#cheque_pay_method2_err').css('display','none');
				}
				
				if(cheque_pay_method3 == ''){
					$('#cheque_pay_method3_err').html('This is Required.').css('display','block');
					formvalidate = false;
				}else{
					$('#cheque_pay_method3_err').css('display','none');
				}
				
			}else if(data['pay_method'] == 'dd'){
				var dd_pay_method1 = $('#dd_pay_method1').val();
				var dd_pay_method2 = $('#dd_pay_method2').val();
				var dd_pay_method3 = $('#dd_pay_method3').val();
				
				data['dd_pay_method1'] = dd_pay_method1;
				data['dd_pay_method2'] = dd_pay_method2;
				data['dd_pay_method3'] = dd_pay_method3;
				
				if(dd_pay_method1 == ''){
					$('#dd_pay_method1_err').html('This is Required.').css('display','block');
					formvalidate = false;
				}else{
					$('#dd_pay_method1_err').css('display','none');
				}
				
				if(dd_pay_method2 == ''){
					$('#dd_pay_method2_err').html('This is Required.').css('display','block');
					formvalidate = false;
				}else{
					$('#dd_pay_method2_err').css('display','none');
				}
				
				if(dd_pay_method3 == ''){
					$('#dd_pay_method3_err').html('This is Required.').css('display','block');
					formvalidate = false;
				}else{
					$('#dd_pay_method3_err').css('display','none');
				}
			}
			
			var fee_waiver_amount = $('#fee_waiver_amount').val();
			var fee_waiver_otp = $('#fee_waiver_otp').val();
			if(fee_waiver_amount != '' && fee_waiver_otp == ''){
				$('#fee_waiver_otp_err').html('This is Required.').css('display','block');
				formvalidate = false;
			}else{
				$('#fee_waiver_otp_err').css('display','none');
			}
			
			var select_month = $('#form_month').val();
			if(select_month == ''){
				$('#form_month_err').html('This is Required.').css('display','block');
				formvalidate = false;
			}else{
				$('#form_month_err').css('display','none');
			}
			
			if(formvalidate){
				$.ajax({
					type:'POST',
					url:base_url+'Student_fee/fee_submit',
					data : data,
					dataType:'json',
					beforeSend:function(){},
					success:function(response){
						if(response.status == 200){
							$('#fee-detail-box').css('display','none');
							var search_box_val = $('#search_box').val();
							if(search_box_val == ''){
								$('#search').trigger("click");
							}else{
								$('#search_box').trigger("keyup");
							}
						} else{
							alert('Something went wrong.');
						}
					},
					complete:function(complete){
						window.open(base_url+user_url+'/student-fee/receipt/'+complete.responseJSON.receipt_no,"popupWindow", "width=960, height=960, scrollbars=yes");
					},
				});
			}	
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
    $(document).on('change','#form_month',function(){
 	   var month_ids = $(this).val().length;
 	
    	tution_fee = $('#form_tution_fee').data('val');
		hostel_fee = $('#form_hostel_fee').val();
		bus_fee = $('#form_bus_fee').data('val');
		lab_fee = $('#form_lab_fee').data('val');
		library_fee =  $('#form_library_fee').data('val');
		optional_sub_fee = $('#form_optional_sub_fee').data('val');
		let_fee =  $('#let_fee').data('val');
    	
    	tution = 0;
    	lab = 0;
    	bus = 0;
    	library = 0;
    	optional = 0;
    	
    	tution = parseFloat(tution_fee * month_ids);
    	lab  = parseFloat(lab_fee * month_ids);
    	bus = parseFloat(bus_fee * month_ids);
    	library = parseFloat(library_fee * month_ids);
    	optional = parseFloat(optional_sub_fee * month_ids);
    	
    	if(isNaN(tution)){
    		lab = 0;
    	}
    	if(isNaN(lab)){
    		lab = 0;
    	}
    	if(isNaN(bus)){
    		lab = 0;
    	}
    	if(isNaN(library)){
    		library = 0;
    	}
    	if(isNaN(optional)){
    		optional = 0;
    	}
    	if(isNaN(hostel_fee)){
    		hostel_fee = 0;
    	}
    	if(isNaN(let_fee)){
    		let_fee = 0;
    	}
    	
    	$('#form_tution_fee').val(tution);
    	$('#form_bus_fee').val(bus);
    	$('#form_lab_fee').val(lab);
    	$('#form_library_fee').val(library);
    	$('#form_optional_sub_fee').val(optional);
    	
    	if($('#hostel_check').prop("checked")){
    		total = total_fee('fee');	
    	}else {
    		total = total_fee('hostel');
    	}
    	$('#form_total').val(total);
    });
    
    //----------------*********--------------------------------------
    $(document).on('click','#hostel_check',function(){
    	if($(this).prop("checked") == true){
            //alert("Checkbox is checked.");
    		$('#form_hostel_fee').removeAttr('disabled','disabled');
    		$('#form_total').val(total_fee('fee'));
        }
        else if($(this).prop("checked") == false){
        	//alert("Checkbox is unchecked.");
        	$('#form_hostel_fee').attr('disabled','disabled');
        	$('#form_total').val(total_fee('hostel'));
        }
    });
    
    //----------------*********--------------------------------------
    $(document).on('keyup','#form_hostel_fee',function(e){
    	var keycode = (event.keyCode ? event.keyCode : event.which);
    	$('#form_total').val(total_fee('fee'));
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
    
    
});//--------end of ready function-------------------

function total_fee(x){
	tution_fee = $('#form_tution_fee').val();
	hostel_fee = $('#form_hostel_fee').val();
	bus_fee = $('#form_bus_fee').val();
	lab_fee = $('#form_lab_fee').val();
	library_fee =  $('#form_library_fee').val();
	optional_sub_fee = $('#form_optional_sub_fee').val();
	let_fee = $('#let_fee').val();
	
	tution = parseFloat(tution_fee);
	hostel = parseFloat(hostel_fee);
	lab  = parseFloat(lab_fee);
	bus = parseFloat(bus_fee);
	library = parseFloat(library_fee);
	optional = parseFloat(optional_sub_fee);
	let_fee = parseFloat(let_fee);
	
	if(isNaN(tution)){
		tution = 0;
	}
	if(isNaN(hostel)){
		hostel = 0;
	}
	if(isNaN(lab)){
		lab = 0;
	}
	if(isNaN(bus)){
		bus = 0;
	}
	if(isNaN(library)){
		library = 0;
	}
	if(isNaN(optional)){
		optional = 0;
	}
	if(isNaN(let_fee)){
		let_fee = 0;
	}
	
	if( x == 'fee'){
		total = tution + hostel + lab + bus + library + optional + let_fee;
		$('#fee_collect').text('Submit '+total);
		return total;
	}else{
		total = tution + lab + bus + library + optional + let_fee;
		$('#fee_collect').text('Submit '+total);
		return total;
	}
}
