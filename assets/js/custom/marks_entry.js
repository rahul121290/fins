$(document).ready(function(){
	var base_url = $('#base_url').val();

	$('#marks_entry_form').validate({
		rules:{
			medium:{required:true},
			exam_type:{required:true},
			class_name:{required:true},
			section:{required:true},
			sub_type:{required:true},
		},
		messages:{
		}
	});

	$(document).on('change','#sub_type',function(){
		var form_validate = $('#marks_entry_form').valid();

		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		if(class_name == 14 || class_name == 15){
			if(sub_group == ''){
				$('#sub_group_err').html('This field is required.').css('display','block');
				return false;
			}else{
				$('#sub_group_err').css('display','none');
				}
		}
		
		if(form_validate == true){
			var formdata = new FormData();
			formdata.append('exam_type',$('#exam_type').val());
			formdata.append('medium',$('#medium').val());
			formdata.append('class_name',$('#class_name').val());
			formdata.append('sub_group',$('#sub_group').val());
			formdata.append('section',$('#section').val());
			formdata.append('sub_type',$(this).val());

			$.ajax({
				type:'POST',
				url:base_url+'Marks_entry_ctrl/getSubjects',
				data:formdata,
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
//	 				console.log(response);
					$('#loader').modal('hide');
					x='<option value="">Select Subject</option>';
					if(response.status == 200){
						$.each(response.result,function(key,value){
							x=x+'<option value="'+value.sub_id+'">'+value.sub_name+' ('+value.st_name+')</option>';
						});
						$('#subject').html(x);
					}else{
							alert(response.feedback);
						}
				},
				cache:false,
		        contentType:false,
		        processData:false
			});
		}	
	});


	//-------------get student records---------------------------
	$(document).on('change','#subject',function(){
		var form_validate = $('#marks_entry_form').valid();
		var exam_type = $('#exam_type').val();
		var medium = $('#medium').val();
		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		var section = $('#section').val();
		var sub_type = $('#sub_type').val();
		var subject = $('#subject').val();
		
		if(subject == ''){
			$('#subject_err').html('field is required.').css('display','block');
			return false;
		}else{
				$('#subject_err').css('display','block');
			}
		
		if(form_validate == true){
			formdata = new FormData();
			formdata.append('exam_type',exam_type);
			formdata.append('medium',medium);
			formdata.append('class_name',class_name);
			formdata.append('sub_group',sub_group);
			formdata.append('section',section);
			formdata.append('sub_type',sub_type);
			formdata.append('subject',subject);

			$.ajax({
					type:'POST',
					url:base_url+'Marks_entry_ctrl/getStudentsRecords',
					data:formdata,
					dataType:'json',
					beforeSend:function(){
						$('#loader').modal('show');
					},
					success:function(response){
//	 					console.log(response);
						x='';
						i=1;
						if(response.status == 200){
							$('#loader').modal('hide');

							if(response.max_marks[0].sub_marks){
								$('#subject_msg').html('Maximum Subject Marks: '+response.max_marks[0].sub_marks).css('display','block');
							}else{
								$('#subject_msg').css('display','none');	
								}
							$.each(response.students,function(key,std){
								x = x +'<tr>'+
									   '<td>'+i+'</td>'+
									   '<td>'+std.name+'</td>'+
									   '<td>'+std.class_name+' / '+std.section_name+'</td>'+
									   '<td>'+std.adm_no+'</td>'+
									   '<td>'+std.roll_no+'</td>'+
									   '<td><input type="text" data-std_id="'+std.std_id+'" data-roll_no="'+std.roll_no+'" data-adm_no="'+std.adm_no+'" data-max="'+response.max_marks[0].sub_marks+'" value="'+std.sub_marks+'" name="subject_marks[]" class="subject_marks" style="width:50px;"></td>';

									 //---------------notebook marks & enrichment marks-----------------------
									   if((class_name < 14 && exam_type == 2 && sub_type == 1) ||(class_name < 14 && exam_type == 2 && sub_type == 3) || (class_name < 14 && exam_type == 4 && sub_type == 1)|| (class_name < 14 && exam_type == 4 && sub_type == 3)){ 
										   $('#notebook').css('display','block');
										   $('#enrichment').css('display','block');
										   $('#notebook_msg').html('Maximum Notebook Marks: 5').css('display','block');
										   $('#enrichment_msg').html('Maximum Enrichment Marks: 5').css('display','block');
										   x=x+'<td><input type="text" id="'+std.std_id+'" data-max="5" value="'+std.notebook+'" name="notebook_marks[]" class="notebook_marks" style="width:50px;"></td>';
											x=x+'<td><input type="text" id="'+std.std_id+'" data-max="5" value="'+std.enrichment+'" name="enrichment_marks[]" class="enrichment_marks" style="width:50px;"></td>';
										}else{
											$('#notebook').css('display','none');
											$('#enrichment').css('display','none');
											$('#notebook_msg').css('display','none');
											$('#enrichment_msg').css('display','none');
											}
										//--------------------practical marks-----------------------------
										if((class_name >= 14 && exam_type == 2 && sub_type != 2)||(class_name >= 14 && exam_type == 4 && sub_type != 2) || (class_name >= 12 && exam_type == 2) || (class_name >= 12 &&sub_type == 4)){
											$('#practical').css('display','block');
											$('#practical_msg').html('Maximum Practical Marks: '+response.max_marks[0].practical).css('display','block');
											x=x+'<td><input type="text" id="'+std.std_id+'" data-max="'+response.max_marks[0].practical+'" value="'+std.practical+'" name="practical_marks[]" class="practical_marks" style="width:50px;"></td>';
										}else{
											$('#practical').css('display','none');
											$('#practical_msg').css('display','none');
											}
										
										//---------acadmic marks-----------------
										if((class_name >= 14 && exam_type == 4)){ 
											$('#academic').css('display','block');
											$('#acadmic_msg').html('Maximum Practical Marks: 10').css('display','block');
											x=x+'<td><input type="text" id="'+std.std_id+'" data-max="10" value="'+std.acadmic+'" name="acadmic_marks[]" class="acadmic_marks" style="width:50px;"></td>';
										}else{
											$('#academic').css('display','none');
											$('#acadmic_msg').css('display','none');
											}
									   '</tr>';
								   i++;
							});
							$('#list_of_students').html(x);
							$('#marks_submit').css('display','block');
							$('#file_import').css('display','block');
						}else{
							$('#loader').modal('hide');
							alert(response.feedback);
							$('#list_of_students').html('<tr><td colspan="6">Record not found.</td></tr>');
						}
					},
					cache:false,
			        contentType:false,
			        processData:false
			});
		}
	});

	//------------------students marks entry----------------------------
	$(document).on('click','#marks_submit',function(){
		var exam_type = $('#exam_type').val();
		var medium = $('#medium').val();
		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		var section = $('#section').val();
		var sub_type = $('#sub_type').val();
		var subject = $('#subject').val();
	 
	    
		var formdata = new FormData();
		formdata.append('exam_type',exam_type);
		formdata.append('medium',medium);
		formdata.append('class_name',class_name);
		formdata.append('sub_group',sub_group);
		formdata.append('section',section);
		formdata.append('sub_type',sub_type);
		formdata.append('subject',subject);
		
		var numItems = $('.subject_marks').length;
	    for(var i = 0; i < numItems; i++) {
	    	var std_id = $("input[name='subject_marks[]']").map(function(){return $(this).data('std_id');}).get()[i];
	    	var roll_no = $("input[name='subject_marks[]']").map(function(){return $(this).data('roll_no');}).get()[i];
	    	var adm_no = $("input[name='subject_marks[]']").map(function(){return $(this).data('adm_no');}).get()[i];
	    	var subject_marks = $("input[name='subject_marks[]']").map(function(){return $(this).val();}).get()[i];
	    	
	    	if((class_name < 14 && exam_type == 2 && sub_type == 1) || (class_name < 14 && exam_type == 4 && sub_type==1)){
	    		var notebook_marks = $("input[name='notebook_marks[]']").map(function(){return $(this).val();}).get()[i];	
	    		var enrichment_marks = $("input[name='enrichment_marks[]']").map(function(){return $(this).val();}).get()[i];	
	        }else{
	        	var notebook_marks = '';
	        	var enrichment_marks = '';
	            }
	    	if((class_name >= 14 && exam_type == 2 && sub_type != 2)||(class_name >= 14 && exam_type == 4 && sub_type != 2) || (class_name >= 12 && exam_type == 2) || (class_name >= 12 &&sub_type == 4)){
	    		var practical_marks = $("input[name='practical_marks[]']").map(function(){return $(this).val();}).get()[i];	 
	        }else{
	        	var practical_marks = '';
	            }

	    	if((class_name >= 14 && exam_type == 4)){
	    		var acadmic_marks = $("input[name='acadmic_marks[]']").map(function(){return $(this).val();}).get()[i];
	     	}else{
	     		var acadmic_marks='';
	         	}
	    
	    	formdata.append("std_id[]", std_id);  //Use [] to add multiple.
	    	formdata.append("roll_no[]", roll_no);  //Use [] to add multiple.
	    	formdata.append("adm_no[]", adm_no);  //Use [] to add multiple.
	    
	    	formdata.append("subject_marks[]", subject_marks);  //Use [] to add multiple.
	    	formdata.append("notebook_marks[]", notebook_marks);  //Use [] to add multiple.
	    	formdata.append("enrichment_marks[]", enrichment_marks);  //Use [] to add multiple.
	    	formdata.append("practical_marks[]", practical_marks);  //Use [] to add multiple.
	    	formdata.append("acadmic_marks[]", acadmic_marks);  //Use [] to add multiple.
	    }
	    
		$.ajax({
				type:'POST',
				url:base_url+'Marks_entry_ctrl/marksEntry',
				data:formdata,
				async: false,
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


	//----------------only 11-12th show gruoup section--------------------------
	$(document).on('change','#class_name',function(){
		var class_name = $(this).val();
		if(class_name == 14 || class_name == 15){
			$('#sub_group_row').css('display','block');		
		}else{
			$('#sub_group_row').css('display','none');
			}
	});

	//----------------min max validation----------------
		$(document).on('blur','.subject_marks,.notebook_marks,.enrichment_marks,.practical_marks,.acadmic_marks',function(){
			var max = $(this).data('max');
		  	var val = $(this).val();
		  		if(val > max || val == ''){
		  	  	$(this).css('box-shadow','0px 0px 10px red');
			  	$(this).focus();
			  	$('#marks_submit').attr('disabled','disabled');
		  	}	
		  	else{
		  		$('#marks_submit').attr('disabled',false);
		  	  	$(this).css('box-shadow','none');
		  	}
		});	

	//-------------- focus on text box--------------------------------
	$(document).on('keyup','.subject_marks,.notebook_marks,.enrichment_marks,.practical_marks,.acadmic_marks',function(){
		var max = $(this).data('max');
	  	var val = $(this).val();
	  	if (val < 0){
	  	  	$(this).val(0);
	  	 }
	  	if(val > max){
	  	  	$(this).css('box-shadow','0px 0px 10px red');
		  	$(this).focus();
		    //$(this).val(max);
	  	}	
	  	else{
	  	  	$(this).css('box-shadow','none');
	  	}
	});

	//------------press only A and number-------------------------
	$(document).on('keypress','.subject_marks,.notebook_marks,.enrichment_marks,.practical_marks,.acadmic_marks',function(e){
	    var keyCode = e.which ? e.which : e.keyCode;
	    var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode <= 65 || keyCode <= 8));
	    if(!ret){
	        e.preventDefault();
	    }
	});
	$(document).on('change','#exam_type',function(){
		$('#medium').prop('selectedIndex','');
		$('#class_name').prop('selectedIndex','');
		$('#sub_group').prop('selectedIndex','');
		$('#section').prop('selectedIndex','');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
	});

	$(document).on('change','#medium',function(){
		$('#class_name').prop('selectedIndex','');
		$('#sub_group').prop('selectedIndex','');
		$('#section').prop('selectedIndex','');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
	});
	$(document).on('change','#class_name',function(){
		$('#sub_group').prop('selectedIndex','');
		$('#section').prop('selectedIndex','');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
	});
	$(document).on('change','#sub_group',function(){
		$('#section').prop('selectedIndex','');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
	});
	$(document).on('change','#section',function(){
		$('#loader').modal('show');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
		
		if($('#exam_type').val() == 1 || $('#exam_type').val() == 3){
			$('#sub_type option[value="2"]').hide();
		}else{
			$('#sub_type option[value="2"]').show();
			}
		$('#loader').modal('hide');
	});
	
	//-------------csv import------------------------
	$(document).on('click','#marks_csv_submit',function(){
		
		var marks_csv = $('#marks_csv').val();
		var file_validation = true;
		
		if(marks_csv == ''){
			$('#marks_csv_err').html('File is required.').css('display','block');
			file_validation = false;
		}else{
			$('#marks_csv_err').css('display','none');
		}
		
	 	if(marks_csv){
    		var csv_ext=marks_csv.split('.').pop().toUpperCase();
    		if(csv_ext!='CSV' && csv_ext!='XLSX'){
    			$('#marks_csv_err').html('wrong file formate.').css('display','block');
    			file_validation = false;	
    		}else{
    			$('#marks_csv_err').css('display','none');
    		}
    	}
	 	
	 	if(file_validation){
	 		var formdata = new FormData();
	 		formdata.append('exam_type',$('#exam_type').val());
	 		formdata.append('medium',$('#medium').val());
	 		formdata.append('class_name',$('#class_name').val());
	 		formdata.append('sub_group',$('#sub_group').val());
	 		formdata.append('section',$('#section').val());
	 		formdata.append('sub_type',$('#sub_type').val());
	 		formdata.append('subject',$('#subject').val());
	 		formdata.append('marks_csv',$('#marks_csv')[0].files[0]);
	 		$.ajax({
	 			type:'POST',
	 			url:base_url+'Marks_entry_ctrl/marks_csv_import',
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
	 					$('#loader').modal('hide');
	 					alert(response.feedback);
	 				}
	 			},
	 			error: function (error){
	 				$('#loader').modal('hide');
	 			    alert('Somthing Error..');
	 			},
	 			cache:false,
	 			contentType:false,
	 			processData:false
	 		});
	 	}
	});
	//-----------download sample file-------------------------
	$(document).on('click','#download_format',function(){
		var formdata = new FormData();
 		formdata.append('medium',$('#medium').val());
 		formdata.append('class_name',$('#class_name').val());
 		formdata.append('sub_group',$('#sub_group').val());
 		formdata.append('section',$('#section').val());
 		$.ajax({
 			type:'POST',
 			url:base_url+'Marks_entry_ctrl/download_sample',
 			data:formdata,
 			dataType:'json',
 			beforeSned:function(){
 				$('#loader').modal('show');
 			},
 			success:function(response){
 				if(response.status == 200){
 					openExcelfile(response.file_path);
 				}else{
 					alert(response.feedback);
 				}
 			},
 			cache:false,
 			contentType:false,
 			processData:false
 		});
	});

	function openExcelfile(strFilePath){
		openExcelDocPath(base_url + strFilePath, false);
	}
	function openExcelDocPath(strLocation, boolReadOnly){
		window.location.href = strLocation;
	} 
});