$(document).ready(function(){
	var base_url = $('#base_url').val();
	var path = $('#path').val();
  //----------datepicker-------------------------------------------
    $( ".datepicker" ).datepicker({
    	changeMonth: true,
    	changeYear: true,
    	yearRange:"-50:+0",
    	dateFormat: 'dd-mm-yy'
    });

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

	$(document).on('click','#search',function(){
		var medium = $('#medium').val();
	    var class_name = $('#class_name').val();
	    var fit = $('#fit_value').val();
	    var sub_group = $('#sub_group').val();
	    var section = $('#section').val();
	    
	    var formvalid = true;
		if(medium == ''){
			$('#medium_err').html('This field is required..!').css('display','block');
			formvalid = false;
		}else{
			$('#medium_err').css('display','none');
			}
	    if(class_name == ''){
	    	$('#class_name_err').html('This field is required..!').css('display','block');
	    	formvalid = false;
	    }else{
	    	$('#class_name_err').css('display','none');
	        }
        //---------------for fit subjects-----------------------------
 	    if(class_name == 12 || class_name == 13){
 	    	sub_group = '';
// 	        if(sub_group == ''){
// 	            $('#fit_err').html('This field is required..!').css('display','block');
// 	            formvalid = false;
// 	        }else{
// 	        	$('#fit_err').css('display','none');
// 	            }
 	    }

        //------------for subject groups-------------------------
	    if(class_name == 14 || class_name == 15){
		    fit = '';
	        if(sub_group == ''){
	            $('#sub_group_err').html('This field is required..!').css('display','block');
	            formvalid = false;
	        }else{
	        	$('#sub_group_err').css('display','none');
	            }
	    }

		if(section == ''){
			$('#section_err').html('This field is required..!').css('display','block');
			formvalid = false;
		}else{
			$('#section_err').css('display','none');
			}


		if(formvalid == true){
			var formdata = new FormData();
			formdata.append('medium',medium);
			formdata.append('class',class_name);
			formdata.append('fit',fit);
			formdata.append('sub_group',sub_group);
			formdata.append('section',section);
			$.ajax({
					type:'POST',
					url:base_url+'Student_ctrl/getStudentData',
					data:formdata,
					async:false,
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
    							x=x+'<tr>'+
    								'<td>'+i+'</td>'+
    								'<td><button type="button" id="'+value.std_id+'" class="btn btn-info btn-sm edit"><span class="glyphicon glyphicon-edit"></span></button>'+
    								'<button type="button" id="'+value.std_id+'" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button></td>'+
    								'<td><img src="'+path+value.photo+'?'+Math.random()+'" style="height:50px;" width="50px;"></td>'+
    								'<td>'+value.adm_no+'</td>'+
    								'<td>'+value.roll_no+'</td>'+
    								'<td>'+value.class_name+'/'+value.section_name+'</td>'+
    								'<td>'+value.fit+'</td>'+
    								'<td>'+value.sg_name+'</td>'+
    								'<td>'+value.sub_name+'</td>'+
    								'<td>'+value.name+'</td>'+
    								'<td>'+value.dob+'</td>'+
    								'<td>'+value.aadhar_no+'</td>'+
    								'<td>'+value.gender+'</td>'+
    								'<td>'+value.f_name+'</td>'+
    								'<td>'+value.m_name+'</td>'+
    								'<td>'+value.contact_no+'</td>'+
    								'<td>'+value.admission_date+'</td>'+
    								'<td>'+value.med_name+'</td>'+
    								'<td>'+value.tc+'</td>'+
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
	
//--------------search admission n0----------------------
    $(document).on('keyup','#search_box',function(){
		var adm_no = $(this).val();
		$.ajax({
			type:'POST',
			url:base_url+'Student_ctrl/getAdmNoRecord',
			data:{'adm_no':adm_no},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				console.log(response.status);
				if(response.status == 200){
					x='';
					i=1;
					$.each(response.result,function(key,value){
						x=x+'<tr>'+
							'<td>'+i+'</td>'+
							'<td><button type="button" id="'+value.std_id+'" class="btn btn-info btn-sm edit"><span class="glyphicon glyphicon-edit"></span></button>'+
							'<button type="button" id="'+value.std_id+'" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span></button></td>'+
							'<td><img src="'+path+value.photo+'?'+Math.random()+'" style="height:50px;" width="50px;"></td>'+
							'<td>'+value.adm_no+'</td>'+
							'<td>'+value.roll_no+'</td>'+
							'<td>'+value.class_name+'/'+value.section_name+'</td>'+
							'<td>'+value.fit+'</td>'+
							'<td>'+value.sg_name+'</td>'+
							'<td>'+value.sub_name+'</td>'+
							'<td>'+value.name+'</td>'+
							'<td>'+value.dob+'</td>'+
							'<td>'+value.aadhar_no+'</td>'+
							'<td>'+value.gender+'</td>'+
							'<td>'+value.f_name+'</td>'+
							'<td>'+value.m_name+'</td>'+
							'<td>'+value.contact_no+'</td>'+
							'<td>'+value.admission_date+'</td>'+
							'<td>'+value.med_name+'</td>'+
							'<td>'+value.tc+'</td>'+
							'<tr>';
						i++;
					});
					$('#student_list').html(x);
				}else{
					$('#student_list').html('<tr><td colspan="15" style="text-align:center;">Record not Found.</td></tr>');
					}
			},
			
		});
	});
	
//-------------delete----------------------------------------
    $(document).on('click','.delete',function(){
        var delete_id = $(this).attr('id');
		if(confirm('are you sure!')){
			$.ajax({
				type:'POST',
				url:base_url+'Student_ctrl/deleteRecord',
				data:{delete_id:delete_id},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#search').trigger("click");
					}else{
						alert(response.feedback);
						}	
				}
			});
		}
    });
  //----------------retrive edit id and fill the modal form------------------------------
    $(document).on('click', '.edit', function(){
        $('#std_image_err').css('display','none');
    	var id = $(this).attr('id');
    	$('#myModal').find('.modal-title').text('Update Student Record.');
    	$('#myModal').modal({'show':true, backdrop: false, keyboard: false});
    	$.ajax({
    		   type:'POST',
    		   url:base_url+'Student_ctrl/getEditData',
    		   dataType:'json',
    		   data:{id: id},
    		   beforeSend: function(){},
    		   success: function (response){
        		   console.log(response);
        		   if(response.status == 200){
            		   $('#std_id').val(response.result[0].std_id);
            		   $('#admission_no').val(response.result[0].adm_no);
            		   $('#roll_no').val(response.result[0].roll_no);
            		   $('#student_name').val(response.result[0].name);
            		   $('#medium_modal').val(response.result[0].medium);
            		   $('#class').val(response.result[0].class_id);
            		   $('#section_modal').val(response.result[0].sec_id);
            		   $('#fit').val(response.result[0].fit);
            		   
            		   if(response.result[0].class_id >= 14){
                		   $('#elective_section').css('display','block');
                		   $('#sub_group_section').css('display','block');
            			   $('#subject_group_modal').val(response.result[0].sub_group);
            			   $('#elective_subject').val(response.result[0].elective);
                		}else{
                			$('#elective_section').css('display','none');
                			$('#sub_group_section').css('display','none');
                    		}
            		   $('#father_name').val(response.result[0].f_name);
            		   $('#mother_name').val(response.result[0].m_name);
            		   $('#dob').val(response.result[0].dob);
            		   $('#gender').val(response.result[0].gender);
            		   $('#admission_date').val(response.result[0].admission_date);
            		   $('#caste').val(response.result[0].cast);
            		   $('#blood').val(response.result[0].blood_group);
            		   $('#aadhaar').val(response.result[0].aadhar_no);
            		   $('#address').val(response.result[0].address);
            		   $('#guardian').val(response.result[0].guardian);
            		   $('#local_address').val(response.result[0].local_address);
            		   $('#contact_no').val(response.result[0].contact_no);
            		   $('#email').val(response.result[0].email_id);
            		   $('#medical').val(response.result[0].medical);
            		   $('#height').val(response.result[0].height);
            		   $('#weight').val(response.result[0].weight);
            		   $('#transfer').val(response.result[0].tc);
            		   $('#hostel').val(response.result[0].hostel_id);
            		   $('#hostler').val(response.result[0].hostler);
            		   $('#old_image').val(response.result[0].photo);
            		   $('#image_preview').hide();
       				   $('#image_preview').text('');
       				   $('#image_preview').show();
       				   $('#image_preview').append('<img src="'+path+response.result[0].photo+'?'+Math.random()+'" style="height:50px;" width="50px;">');
            		   
            		}else{
                		alert(response.feedback);
                		}
    		   
    						
    			},
    	});

    });
    
//----------------update student records-----------------------------
$('#student_form').validate({
	rules:{
		admission_no:{required:true},
		roll_no:{required:true},
		student_name:{required:true},
		medium:{required:true},
		class:{required:true},
		section_modal:{required:true},
		father_name:{required:true},
		mother_name:{required:true},
		dob:{required:true},
		gender:{required:true},
		admission_date:{required:true},
		caste:{required:true},
//			blood:{required:true},
		aadhaar:{required:true},
		address:{required:true},
//			guardian:{required:true},
//			local_address:{required:true},
		contact_no:{required:true},
		email:{email:true},
//			medical:{required:true},
//			height:{required:true},
//			weight:{required:true},
		transfer:{required:true},
//			house:{required:true},
//			hostler:{required:true},
//			std_image:{required:true},
		},
	messages:{
		},
});
$(document).on('click','#submit',function(){
	$("body.modal-open").removeAttr("style");
    var formvalidate = $('#student_form').valid();//----- formvalidate = true-------------------
    if(formvalidate == true){
    	//----------------validation for fit,elective and subject groups---------------------------
    	var class_id = $('#class').val();
    	if(class_id == 12 || class_id == 13){
    		if($('#fit').val() == ''){
    			$('#fit_err').html('This field is required.').css('display','block');
    			return false;
    			}else{
    				$('#fit_err').css('display','none');
    			}		
    	}
    	if(class_id == 14 || class_id == 15){
    		if($('#elective_subject').val() == ''){
    			$('#elective_subject_err').html('Elective subject is required.').css('display','block');
    			return false;
    			}else{
    				$('#elective_subject_err').css('display','none');
    				}
    		if($('#subject_group_modal').val() == ''){
    			$('#subject_group_err').html('Subject Group is required.').css('display','block');
    			return false;
    			}else{
    				$('#subject_group_err').css('display','none');
    				}	
    	}
    //--------------validation for image-------------------------------------------------		
    	var img = $('#std_image').val();
    	if(img){
    		var img_ext=img.split('.').pop().toUpperCase();
    		var img_size=$('#std_image')[0].files[0].size;
    		if(img_ext!='JPG' && img_ext!='PNG' && img_ext!='GIF'){
    			$('#std_image_err').hide();
    			$('#std_image_err').text('');
    			$('#std_image_err').show();
    			$('#std_image_err').append("wrong file formate.");
    			return false;	
    		}
    		if(img_size>='1000024'){
    			$('#std_image_err').hide();
    			$('#std_image_err').text('');
    			$('#std_image_err').show();
    			$('#std_image_err').append("file size is to large.");
    			return false;
    		}		
    	}
		formdata = new FormData();
		formdata.append('std_id',$('#std_id').val());
		formdata.append('adm_no',$('#admission_no').val());
		formdata.append('roll_no',$('#roll_no').val());
		formdata.append('name',$('#student_name').val());
		formdata.append('medium',$('#medium_modal').val());
		formdata.append('class_id',$('#class').val());
		formdata.append('sec_id',$('#section_modal').val());
		formdata.append('fit',$('#fit').val());
		formdata.append('elective',$('#elective_subject').val());
		formdata.append('sub_group',$('#subject_group_modal').val());
		formdata.append('f_name',$('#father_name').val());
		formdata.append('m_name',$('#mother_name').val());
		formdata.append('dob',$('#dob').val());
		formdata.append('gender',$('#gender').val());
		formdata.append('admission_date',$('#admission_date').val());
		formdata.append('cast',$('#caste').val());
		formdata.append('blood_group',$('#blood').val());
		formdata.append('aadhar_no',$('#aadhaar').val());
		formdata.append('address',$('#address').val());
		formdata.append('guardian',$('#guardian').val());
		formdata.append('local_address',$('#local_address').val());
		formdata.append('contact_no',$('#contact_no').val());
		formdata.append('email_id',$('#email').val());
		formdata.append('medical',$('#medical').val());
		formdata.append('height',$('#height').val());
		formdata.append('weight',$('#weight').val());
		formdata.append('tc',$('#transfer').val());
		formdata.append('hostel',$('#hostel').val());
		formdata.append('hostler',$('#hostler').val());
		formdata.append('old_image',$('#old_image').val());
		formdata.append('std_image',$('#std_image')[0].files[0]);
		$.ajax({
			type:'POST',
			url:base_url+'Student_ctrl/add_student',
			data:formdata,
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');	
			},
			success:function(response){
				if(response.status == 200){
					alert(response.feedback);
					$('#myModal').modal('hide');
					$('#search').trigger("click");
				}else{
					alert(response.feedback);
					}
			},
			contentType:false,
			processData:false
			});
		}
	});
});