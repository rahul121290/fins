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
	//--------------------get section and subject_group----------------------------
	$(document).on('change','#class_name',function(){
		var exam_type = $('#exam_type').val();
		var medium = $('#medium').val();
		var class_id = $(this).val();
		if(class_id < 14){
			$.ajax({
				type:'post',
				url:base_url+'Marks_entry_ctrl/get_section',
				data:{'exam_type':exam_type,'medium':medium,'class_id':class_id,'sub_group':''},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');
						var x='<option value="">Select Section</option>';
						$.each(response.data,function(key,value){
							x=x+'<option value="'+value.sec_id+'">'+value.section_name+'</option>';
						});
						$('#section').html(x);
					}else{
						alert(response.msg);
					}
				},
			});
		}else{
			$.ajax({
				type:'post',
				url:base_url+'Marks_entry_ctrl/getSubGroup',
				data:{'exam_type':exam_type,'medium':medium,'class_id':class_id},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');
						var x='<option value="">Select Subject Group</option>';
						$.each(response.data,function(key,value){
							x=x+'<option value="'+value.sg_id+'">'+value.sg_name+'</option>';
						});
						$('#sub_group').html(x);
					}else{
						alert(response.msg);
					}
				},
			});
			
			$('#section').prop('selectedIndex','');
		}
		
	});
	//----------get section of class 11-12----------------------
	$(document).on('change','#sub_group',function(){
		var exam_type = $('#exam_type').val();
		var medium = $('#medium').val();
		var class_id = $('#class_name').val();
		var sub_group = $(this).val();
		$.ajax({
			type:'post',
			url:base_url+'Marks_entry_ctrl/get_section',
			data:{'exam_type':exam_type,'medium':medium,'class_id':class_id,'sub_group':sub_group},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					var x='<option value="">Select Section</option>';
					$.each(response.data,function(key,value){
						x=x+'<option value="'+value.sec_id+'">'+value.section_name+'</option>';
					});
					$('#section').html(x);
				}else{
					alert(response.msg);
				}
			},
		});
	});
	
	
	//--------------------get subject type----------------------
	
	$(document).on('change','#section',function(){
		$('#list_of_students').css('display','none');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
		
		if($('#exam_type').val() == 1 || $('#exam_type').val() == 3){
			$('#sub_type option[value="2"]').hide();
		}else{
			$('#sub_type option[value="2"]').show();
			}
		
		var exam_type = $('#exam_type').val();
		var medium = $('#medium').val();
		var class_id = $('#class_name').val();
		var section = $(this).val();
		$.ajax({
			type:'post',
			url:base_url+'Marks_entry_ctrl/getSubjectType',
			data:{'exam_type':exam_type,'medium':medium,'class_id':class_id,'section':section},
			dataType:'json',
			beforeSend:function(){$('#loader').modal('show');},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					var x='<option value="">Select Subject Type</option>';
					$.each(response.data,function(key,value){
						x=x+'<option value="'+value.st_id+'">'+value.st_name+'</option>';
					});
					$('#sub_type').html(x);
				}else{
					alert(response.msg);
				}
			},
		});
	});
	
	//-------------get student records---------------------------
	$(document).on('click','#search',function(){
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
						if(response.status == 200){
							$('#loader').modal('hide');
							$('#type_and_sub').html($('#exam_type').children('option:selected').text()+':- '+ $('#subject').children('option:selected').text());
							if(response.max_marks[0].sub_marks){
								$('#subject_msg').html('Maximum Subject Marks: '+response.max_marks[0].sub_marks).css('display','block');
							}else{
								$('#subject_msg').css('display','none');	
								}
							$.each(response.students,function(key,std){
								x = x +'<tr>'+
									   '<td>'+parseInt(key+1)+'</td>'+
									   '<td>'+std.name+'</td>'+
									   '<td>'+std.class_name+' / '+std.section_name+'</td>'+
									   '<td>'+std.adm_no+'</td>'+
									   '<td>'+std.roll_no+'</td>'+
									   '<td><input type="text" id="subject_marks_'+std.std_id+'" data-std_id="'+std.std_id+'" data-roll_no="'+std.roll_no+'" data-adm_no="'+std.adm_no+'" data-max="'+response.max_marks[0].sub_marks+'" value="'+std.sub_marks+'" name="subject_marks[]" class="subject_marks marks_entry_validation" style="width:50px;"></td>';

									 //---------------notebook marks & enrichment marks-----------------------
										if(class_name < 12){
											if(exam_type == 2 || exam_type == 4){
												if(sub_type == 1){
													//---------remove------------
													$('#portfolio').css('display','none');
													$('#multiple_assessment').css('display','none');
													$('#portfolio_msg').css('display','none');
													$('#multiple_assessment_msg').css('display','none');
													//---------------------------------------------------
													
													$('#notebook').removeAttr('style');
													   $('#enrichment').removeAttr('style');
													   $('#notebook_msg').html('Maximum Notebook Marks: 5').css('display','block');
													   $('#enrichment_msg').html('Maximum Enrichment Marks: 5').css('display','block');
													   x=x+'<td><input type="text" id="notebook_'+std.std_id+'" data-max="5" value="'+std.notebook+'" name="notebook_marks[]" class="notebook_marks marks_entry_validation" style="width:50px;"></td>';
													  x=x+'<td><input type="text" id="enrichment_'+std.std_id+'" data-max="5" value="'+std.enrichment+'" name="enrichment_marks[]" class="enrichment_marks marks_entry_validation" style="width:50px;"></td>';
												}else{
													$('#notebook').css('display','none');
													$('#enrichment').css('display','none');
													$('#notebook_msg').css('display','none');
													$('#enrichment_msg').css('display','none');
												}
											}
										}
										else if(class_name == 12 || class_name == 13){
										   if(exam_type == 2 || exam_type == 4){
											   if(sub_type == 1){
												   //-----------remove not book-------------
												   $('#notebook').css('display','none');
												   $('#notebook_msg').css('display','none');
													
												   $('#portfolio').removeAttr('style');
												   $('#multiple_assessment').removeAttr('style');
												   $('#enrichment').removeAttr('style');
												   $('#enrichment_msg').html('Maximum Enrichment Marks: 5').css('display','block');
												   
												   $('#portfolio_msg').html('Maximum Portfolio Marks: 5').css('display','block');
												   $('#multiple_assessment_msg').html('Maximum Multiple Assessment Marks: 5').css('display','block');
												   
												   x=x+'<td><input type="text" id="portfolio_'+std.std_id+'" data-max="5" value="'+std.portfolio+'" name="portfolio_marks[]" class="portfolio_marks marks_entry_validation" style="width:50px;"></td>';
												   x=x+'<td><input type="text" id="multiple_assessment_'+std.std_id+'" data-max="5" value="'+std.multiple_assessment+'" name="multiple_assessment_marks[]" class="multiple_assessment_marks marks_entry_validation" style="width:50px;"></td>';
												   x=x+'<td><input type="text" id="enrichment_'+std.std_id+'" data-max="5" value="'+std.enrichment+'" name="enrichment_marks[]" class="enrichment_marks marks_entry_validation" style="width:50px;"></td>';
											   }else{
													$('#portfolio').css('display','none');
													$('#multiple_assessment').css('display','none');
													$('#portfolio_msg').css('display','none');
													$('#multiple_assessment_msg').css('display','none');
													$('#enrichment').css('display','none');
													$('#enrichment_msg').css('display','none');
												}
										   }
										}
										//--------------------practical marks-----------------------------
									   if(response.max_marks[0].practical){
										   if((class_name >= 14 && exam_type == 2 && sub_type != 2)||(class_name >= 14 && exam_type == 4 && sub_type != 2) || (class_name >= 12 && exam_type == 2 && sub_type == 4) || (class_name >= 12 && exam_type == 4 && sub_type == 4)){
											   //---------------hide---------------------
											   $('#notebook').css('display','none');
											   $('#notebook_msg').css('display','none');
											   $('#portfolio').css('display','none');
												$('#multiple_assessment').css('display','none');
												$('#portfolio_msg').css('display','none');
												$('#multiple_assessment_msg').css('display','none');
												$('#enrichment').css('display','none');
												$('#enrichment_msg').css('display','none');
											   //----------------------------------------------
												
												$('#practical').removeAttr('style');
												$('#practical_msg').html('Maximum Practical Marks: '+response.max_marks[0].practical).css('display','block');
												x=x+'<td><input type="text" id="practical_'+std.std_id+'" data-max="'+response.max_marks[0].practical+'" value="'+std.practical+'" name="practical_marks[]" class="practical_marks marks_entry_validation" style="width:50px;"></td>';
											}else{
												$('#practical').css('display','none');
												$('#practical_msg').css('display','none');
											} 
									   }else{
											$('#practical').css('display','none');
											$('#practical_msg').css('display','none');
									   }
										
										//---------acadmic marks-----------------
										if((class_name >= 14 && exam_type == 4)){
											$('#academic').removeAttr('style');
											$('#acadmic_msg').html('Maximum Practical Marks: 10').css('display','block');
											x=x+'<td><input type="text" id="acadmic_'+std.std_id+'" data-max="10" value="'+std.acadmic+'" name="acadmic_marks[]" class="acadmic_marks marks_entry_validation" style="width:50px;"></td>';
										}else{
											$('#academic').css('display','none');
											$('#acadmic_msg').css('display','none');
										}
									   '</tr>';
							});
							$('#list_of_students').html(x);
							$('#marks_submit').css('display','block');
							$('#file_import').css('display','block');
							$('#list_of_students').removeAttr('style',true);
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
	 
	    
		 var std_marks = [];
			$('.subject_marks').each(function (index, value) {
				var temp = [];
				var std_id = $(this).data('std_id');
				
				if($('#subject_marks_'+std_id).val()){
					var sub_mark = $('#subject_marks_'+std_id).val();
				}else{
					var sub_mark = '';
				}
				
				if($('#notebook_'+std_id).val()){
					var notebook_mark = $('#notebook_'+std_id).val();
				}else{
					var notebook_mark = '';
				}
				
				if($('#multiple_assessment_'+std_id).val()){
					var multiple_assessment_mark = $('#multiple_assessment_'+std_id).val();
				}else{
					var multiple_assessment_mark = '';
				}
				
				if($('#portfolio_'+std_id).val()){
					var portfolio_marks = $('#portfolio_'+std_id).val();
				}else{
					var portfolio_marks = '';
				}
				
				if($('#enrichment_'+std_id).val()){
					var enrichment_marks = $('#enrichment_'+std_id).val();
				}else{
					var enrichment_marks = '';
				}
				
				if($('#practical_'+std_id).val()){
					var practical_marks = $('#practical_'+std_id).val();
				}else{
					var practical_marks = '';
				}
				
				if($('#acadmic_'+std_id).val()){
					var acadmic_mark = $('#acadmic_'+std_id).val();
				}else{
					var acadmic_mark = '';
				}
				
				temp.push({std_id : std_id});
				temp.push({adm_no : $(this).data('adm_no')});
				temp.push({roll_no : $(this).data('roll_no')}) ;
				temp.push({subject_marks : sub_mark});
				temp.push({notebook : notebook_mark});
				
				temp.push({multiple_assessment : multiple_assessment_mark});
				temp.push({portfolio : portfolio_marks});
				
				temp.push({enrichment : enrichment_marks});
				temp.push({practical : practical_marks});
				temp.push({acadmic : acadmic_mark});
				std_marks.push(temp);
			});
			
		var formdata = new FormData();
		formdata.append('exam_type',exam_type);
		formdata.append('medium',medium);
		formdata.append('class_name',class_name);
		formdata.append('sub_group',sub_group);
		formdata.append('section',section);
		formdata.append('sub_type',sub_type);
		formdata.append('subject',subject);
		formdata.append('std_marks',JSON.stringify(std_marks));

		$.ajax({
				type:'POST',
				url:base_url+'Marks_entry_ctrl/marksEntry',
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
		$(document).on('blur','.marks_entry_validation',function(){
			var max = $(this).data('max');
		  	var val = $(this).val();
		  	if(max != ''){
		  		if(val > max || val == ''){
			  	  	$(this).css('box-shadow','0px 0px 10px red');
				  	$(this).focus();
				  	$('#marks_submit').attr('disabled','disabled');
			  	}
			  	else{
			  		$('#marks_submit').attr('disabled',false);
			  	  	$(this).css('box-shadow','none');
			  	}
		  	}
		});	

	//-------------- focus on text box--------------------------------
	$(document).on('keyup','.marks_entry_validation',function(){
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

	//------------press only A and number-----------------------------
	$(document).on('keypress','.marks_entry_validation',function(e){
	    var keyCode = e.which ? e.which : e.keyCode;
	    var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode <= 65 || keyCode <= 8));
	    if(!ret){
	        e.preventDefault();
	    }
	});
	$(document).on('change','#exam_type',function(){
		$('#list_of_students').css('display','none');
		$('#medium').prop('selectedIndex','');
		$('#class_name').prop('selectedIndex','');
		$('#sub_group').prop('selectedIndex','');
		$('#section').prop('selectedIndex','');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
	});

	$(document).on('change','#medium',function(){
		$('#list_of_students').css('display','none');
		$('#class_name').prop('selectedIndex','');
		$('#sub_group').prop('selectedIndex','');
		$('#section').prop('selectedIndex','');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
	});
	$(document).on('change','#class_name',function(){
		$('#list_of_students').css('display','none');
		$('#sub_group').prop('selectedIndex','');
		$('#section').prop('selectedIndex','');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
	});
	$(document).on('change','#sub_group',function(){
		$('#list_of_students').css('display','none');
		$('#section').prop('selectedIndex','');
		$('#sub_type').prop('selectedIndex','');
		$('#subject').prop('selectedIndex','');
	});
	
	
	$(document).on('change','#sub_type',function(){
		$('#list_of_students').css('display','none');
	});
	$(document).on('change','#subject',function(){
		$('#list_of_students').css('display','none');
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