$(document).ready(function(){
	var base_url = $('#base_url').val();
	var src = base_url+'assets/images/';
	schoolList();
	function schoolList(){
		$.ajax({
				url:base_url+'School_ctrl/schoolList',
				dataType:'json',
				beforeSend:function(){},
				success:function(response){
					console.log(response);
					var x = '';
					var i = 1;
					var y = '';
					if(response.status==200){
						$('#submit_school').attr('disabled',true);
						$.each(response.result,function(key,value){

							if(value.set_school == 1){
								var checked = 'checked';
								}else{
									checked = '';
									}
							y = y +'<input type="radio" name="school_set" id="'+value.sch_id+'" class="set_school" '+checked+'>'+value.school_name+'<br>';

							x=x+'<tr>'+
						        '<td>'+i+'</td>'+
						        '<td>'+value.school_name+'</td>'+
						        '<td>'+value.address+'</td>'+
						        '<td>'+value.affiliation_no+'</td>'+
						        '<td>'+value.school_no+'</td>'+
						        '<td><img src="'+src+value.school_image+'" style="height:50px;" width="50px;"></td>'+ 
						        '<td><button type="button" id="'+value.sch_id +'" class="btn btn-primary btn-sm edit"><span class="glyphicon glyphicon-edit"></span> Edit </button> &nbsp;'+
		    					 '<button type="button" id="'+value.sch_id +'" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span> Delete </button></td>'+
					        i++;
						});	
						$('#set_school').html(y);				     
						 $('#school_list').html(x);
					}
				},
			});
	}
//-------------------------------------------------------
//	$(document).on('click','.set_school',function(){
//		var set_id = $(this).attr('id');
//		$.ajax({
//			type:'POST',
//			url:base_url+'School_ctrl/setInSession',
//			data:{set_id:set_id},
//			dataType:'json',
//			beforeSend:function(){
//				$('#loader').modal('show');
//			},
//			success:function(response){
//				if(response.status == 200){
//					location.reload();
//				}else{
//					alert(response.feedback);
//					}
//			},
//			});
//	});
//--------------------------------------------------------
	$(document).on('click','.delete',function(){
		var delete_id = $(this).attr('id');
		if(confirm('are you sure! ')){
			$.ajax({
				type:'POST',
				url:base_url+'School_ctrl/deleteRow',
				data:{delete_id:delete_id},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						location.reload();
					}else{
						alert(response.feedback);
					 }
				},
			});
		}
	});
//---------------------------------------------------
	$(document).on('click','.edit',function(){
		var edit_id = $(this).attr('id');
	    	$.ajax({
	    		type:'POST',
	    		url:base_url+'School_ctrl/editRow',
	    		data:{edit_id:edit_id},
	    		dataType:'json',
	    		beforeSend:function(){
	    			$('#loader').modal('show');
	        	},
	    		success:function(response){
	        		console.log(response);
	    			if(response.status == 200){
	    				$('#loader').modal('hide');
	    				
	    				$('#id').val(response.result[0]['sch_id']);
	    				$('#school_name').val(response.result[0]['school_name']);
	    				$('#address').val(response.result[0]['address']);
	    				$('#affiliation_no').val(response.result[0]['affiliation_no']);
	    				$('#school_no').val(response.result[0]['school_no']);
	    				
	    				$('#principal_name').val(response.result[0]['principal_name']);
	    				$('#old_principal_image').val(response.result[0]['principal_sign']);
	    				$('#sing_preview').hide();
	    				$('#sing_preview').text('');
	    				$('#sing_preview').show();
	    				$('#sing_preview').append('<img src="'+src+response.result[0]['principal_sign']+'" style="height:50px;" width="50px;">');
	    				
	    				
	    				$('#old_image').val(response.result[0]['school_image']);
	    				$('#edit_preview').hide();
	    				$('#edit_preview').text('');
	    				$('#edit_preview').show();
	    				$('#edit_preview').append('<img src="'+src+response.result[0]['school_image']+'" style="height:50px;" width="50px;">');
	    				$('.btn_submit').addClass('hide');
						$('.btn_update').removeClass('hide');
	    			}else{
	    				alert(response.feedback);
	    			 }
	    		},
	    	});
	});
//--------form update----------------------------------
	$(document).on('click','#update_school',function(){
		
		$('#school_form').validate({
			rules:{
				school_name:{required:true},
				address:{required:true},
				affiliation_no:{required:true},
				school_no:{required:true},
				principal_name:{required:true}
				},
			messages:{
				 school_name:"School Name is Required.",
				 address:"Address is Required.",
				 affiliation_no:"Affiliation No is Required.",
				 school_no:"School No is Required."
				}
		});
		var formvalid = $('#school_form').valid();
		if(formvalid == true){
			var img = $('#school_image').val();
			if(img){
				var img_ext=img.split('.').pop().toUpperCase();
				var img_size=$('#school_image')[0].files[0].size;
				
	    		if(img_ext!='JPG' && img_ext!='PNG' && img_ext!='GIF'){
	    				$('#msg').hide();
	    				$('#msg').text('');
	    				$('#msg').show();
	    				$('#msg').append("wrong file formate.");
	    				return false	
	    		}
	    		if(img_size>='1000024'){
	    			$('#msg').hide();
	    			$('#msg').text('');
	    			$('#msg').show();
	    			$('#msg').append("file size is to large.");
	    			return false
	    		}
			}
			
			var principal_img = $('#principal_image').val();
			if(principal_img){
				var p_img_ext=principal_img.split('.').pop().toUpperCase();
				var p_img_size=$('#principal_image')[0].files[0].size;
				
	    		if(p_img_ext!='JPG' && p_img_ext!='PNG' && p_img_ext!='GIF'){
	    				$('#principal_msg').hide();
	    				$('#principal_msg').text('');
	    				$('#principal_msg').show();
	    				$('#principal_msg').append("wrong file formate.");
	    				return false	
	    		}
	    		if(p_img_size>='1000024'){
	    			$('#principal_msg').hide();
	    			$('#principal_msg').text('');
	    			$('#principal_msg').show();
	    			$('#principal_msg').append("file size is to large.");
	    			return false
	    		}
			}
				var formdata = new FormData();
				formdata.append('id',$('#id').val());
				formdata.append('school_name',$('#school_name').val());
				formdata.append('address',$('#address').val());
				formdata.append('affiliation_no',$('#affiliation_no').val());
				formdata.append('school_no',$('#school_no').val());
				formdata.append('principal_name',$('#principal_name').val());
				formdata.append('old_principal_image',$('#old_principal_image').val());
				formdata.append('old_image',$('#old_image').val());
				if(img){
					formdata.append('school_image',$('#school_image')[0].files[0]);
					}
				if(principal_img){
					formdata.append('principal_image',$('#principal_image')[0].files[0]);
					}
				$.ajax({
						type:'POST',
						url:base_url+'School_ctrl/submit_data',
						data:formdata,
						aysc:false,
						dataType:'json',
						beforeSend:function(){
							$('#loader').modal('show');
						},
						success:function(response){
							if(response.status == 200){
								$('#loader').modal('hide');
								alert(response.feedback);
								location.reload();
								}else{
									alert(response.feedback);
									}
							if(response.status == 400){
								alert(response.validation_errors);
							}
						},
						cache:false,
						contentType:false,
						processData:false,
					});
			}
	});

//--------form insert---------------------------------------
	$(document).on('click','#submit_school',function(){
		$('#school_form').validate({
			rules:{
				school_name:{required:true},
				address:{required:true},
				affiliation_no:{required:true},
				school_no:{required:true},
				school_image:{required:true}
				},
			messages:{
				 school_name:"School Name is Required.",
				 address:"Address is Required.",
				 affiliation_no:"Affiliation No is Required.",
				 school_no:"School No is Required.",
				 school_image:"School Image is Required.",	
				}
		});
		
		var formvalid = $('#school_form').valid();
		if(formvalid == true){

			var img = $('#school_image').val();
			
			if(img){
				var img_ext=img.split('.').pop().toUpperCase();
				var img_size=$('#school_image')[0].files[0].size;
				if(img_ext!='JPG' && img_ext!='PNG' && img_ext!='GIF'){
					$('#msg').hide();
					$('#msg').text('');
					$('#msg').show();
					$('#msg').append("wrong file formate.");
					return false	
	    		}
	    		if(img_size>='1000024'){
	    			$('#msg').hide();
	    			$('#msg').text('');
	    			$('#msg').show();
	    			$('#msg').append("file size is to large.");
	    			return false
	    		}		
			}
				var formdata = new FormData();
				formdata.append('school_name',$('#school_name').val());
				formdata.append('address',$('#address').val());
				formdata.append('affiliation_no',$('#affiliation_no').val());
				formdata.append('school_no',$('#school_no').val());
				formdata.append('school_image',$('#school_image')[0].files[0]);

				$.ajax({
						type:'POST',
						url:base_url+'School_ctrl/submit_data',
						data:formdata,
						async:false,
						dataType:'json',
						beforeSend:function(){
							$('#loader').modal('show');
						},
						success:function(response){
							if(response.status == 200){
								$('#loader').modal('hide');
								alert(response.feedback);
								location.reload();
								}else{
									alert(response.feedback);
								}
							if(response.status==400){
								alert(response.validation_errors);
							}
						},
						cache:false,
						contentType:false,
						processData:false
					});
			}
	});
});