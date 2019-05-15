$(document).ready(function(){
	var base_url = $('#base_url').val();

	$(document).on('click','#search',function(){
		$('#pay_student_fees').validate({
			rules:{
				medium:{required:true},
				class_name:{required:true},
				section:{required:true},
				sub_group:{required:$('#class_name').val() >= '14'},
				month:{required:true},
				fees_type:{required:true},
				},
			messages:{
			},
		});
		var formvalidate = $('#pay_student_fees').valid();

		if(formvalidate){
			var formdata = new FormData();
			formdata.append('medium',$('#medium').val());
			formdata.append('class_name',$('#class_name').val());
			formdata.append('section',$('#section').val());
			formdata.append('sub_group',$('#sub_group').val());
			formdata.append('month',$('#month').val());
			formdata.append('fees_type',$('#fees_type').val());
			$.ajax({
				type:'POST',
				url:base_url+'Fees_payment_ctrl/getStudentRecord',
				data:formdata,
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');
						x='<thead><tr><th>Sr. No.</th><th>Adm No.</th><th>Roll No.</th><th>Student Name</th>';
						if($('#fees_type').val() == 1){
							x=x+'<th>Admission Fees</th>';
						}
						if($('#fees_type').val() == 2){
							x=x+'<th>Month Fees</th>';
						}
						$.each(response.category,function(k,v){
							x=x+'<th id="'+v.name+'" class="category_name">'+v.name+'</th>';
						});
						x=x+'<th>Total Fees</th>';
						x=x+'<th>Payment Mode</th>';
	        			x=x+'</tr></thead><tbody>';
						$.each(response.result,function(key,value){
							x=x+'<tr>'+
								'<td>'+parseInt(key+1)+'</td>'+
								'<td>'+value.adm_no+'</td>'+
								'<td>'+value.roll_no+'</td>'+
								'<td>'+value.name+'</td>';
	    						if($('#fees_type').val() == 1){
	        						if(value.main_fees){ var main_fees = value.main_fees;}else{var main_fees = '';}
	    							x=x+'<td><input type="text" name="admission_fees[]" value="'+main_fees+'" class="admission_fees" placeholder="admission" style="width:50px;"></td>';
	    						}
	    						if($('#fees_type').val() == 2){
	    							if(value.main_fees){ var main_fees = value.main_fees;}else{var main_fees = '';}
	    							x=x+'<td><input type="text" name="month_fees[]" value="'+main_fees+'" class="month_fees" placeholder="Month" style="width:50px;"></td>';
	    						}
								$.each(response.category,function(k,v){
									x=x+'<td><input type="text" name="'+v.name+'[]" value="'+value[v.name]+'" class="'+v.name+'"  placeholder="'+v.name+'" style="width:50px;"></td>';
								});
								x=x+'<td><input type="text" data-roll_no="'+value.roll_no+'" data-std_name="'+value.name+'" data-adm_no="'+value.adm_no+'" value="'+value.total_fees+'" name="total_fees[]" class="total_fees" placeholder="total" style="width:50px;"></td>'+
								    '<td><select name="payment_mode[]">'+
								    		'<option value="">Payment Mode</option>';
								    		$.each(response.payment_mode,function(k,v){
									    		if(value.mode == v.pm_name){
										    		var selected = 'selected';
										    		}else{
										    			var selected = '';
											    		}
									    	x=x+'<option value="'+v.pm_name+'" '+selected+'>'+v.pm_name+'</option>';	
									    	});
								    	x=x+'</select></td>'+
									'<tr>';
						});
						x=x+'</tbody>';
						$('#table_data').html(x);
						$('#submit').removeClass('hide');
					}else{
						}
				},
				cache:false,
				contentType:false,
				processData:false
			});
		}
	});
	//------------submit-data--------------------

	$(document).on('click','#submit',function(){
		var formdata = new FormData();
		formdata.append('medium',$('#medium').val());
		formdata.append('class_name',$('#class_name').val());
		formdata.append('section',$('#section').val());
		formdata.append('sub_group',$('#sub_group').val());
		formdata.append('month',$('#month').val());
		formdata.append('fees_type',$('#fees_type').val());

		var numItems = $('.total_fees').length;
	    for(var i = 0; i < numItems; i++) {
	    	var adm_no = $("input[name='total_fees[]']").map(function(){return $(this).data('adm_no');}).get()[i];
	    	var roll_no = $("input[name='total_fees[]']").map(function(){return $(this).data('roll_no');}).get()[i];
	    	var std_name = $("input[name='total_fees[]']").map(function(){return $(this).data('std_name');}).get()[i];
	    	var total_fees = $("input[name='total_fees[]']").map(function(){return $(this).val();}).get()[i];
	    	var payment_mode = $("select[name='payment_mode[]']").map(function(){return $(this).val();}).get()[i];

	    	if($('#fees_type').val() == 1){
	    		var admission_fees = $("input[name='admission_fees[]']").map(function(){return $(this).val();}).get()[i];
	    		formdata.append("admission_fees[]", admission_fees);  //Use [] to add multiple.
	        }
	    	if($('#fees_type').val() == 2){
	    		var month_fees = $("input[name='month_fees[]']").map(function(){return $(this).val();}).get()[i];
	    		formdata.append("month_fees[]", month_fees);  //Use [] to add multiple.
	        }

	    	formdata.append("adm_no[]", adm_no);  //Use [] to add multiple.
	    	formdata.append("roll_no[]", roll_no);  //Use [] to add multiple.
	    	formdata.append("std_name[]", std_name);  //Use [] to add multiple.
	    	formdata.append("total_fees[]", total_fees);  //Use [] to add multiple.
	    	formdata.append("payment_mode[]", payment_mode);  //Use [] to add multiple.
	    }	

	    $('.category_name').each(function(){
			var category_name = ($(this).attr('id')); //----------get category name--------
			var numItem = $('.'+category_name+'').length;//----------find category input lenght
		    for(var i = 0; i < numItem; i++) {
		    	var data = $("input[name='"+category_name+"[]']").map(function(){return $(this).val();}).get()[i];
		    	formdata.append(""+category_name+"[]", data);  //Use [] to add multiple.
		    }
		});
		$.ajax({
			type:'POST',
			url:base_url+'Fees_payment_ctrl/submitFeesRecords',
			data:formdata,
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
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
	});

	//--------------***************------------------//
	$(document).on('change','#fees_type',function(){
		var fees_type = $(this).val();
		if(fees_type == 2){
			$('#month_row').css('display','block');
		}else{
			$('#month_row').css('display','none');
			$('#month').prop('selectedIndex','');
			}
	});

	$(document).on('change','#class_name',function(){
		var class_id = $(this).val();
		if(class_id > 13){
			$('#sub_group_row').css('display','block');
		}else{
			$('#sub_group_row').css('display','none');
			$('#sub_group').prop('selectedIndex','');
			}
	});
});