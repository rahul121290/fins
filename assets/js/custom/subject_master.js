$(document).ready(function(){
	var base_url = $('#base_url').val();
	/*---------------------------------------------------------
	 					subject group
	-----------------------------------------------------------*/
	subGroupList();
	function subGroupList(){
		$.ajax({
				url:base_url+'Subject_ctrl/subGroupList',
				dataType:'json',
				success:function(response){
					x = '';
					i = 1;
					if(response.status == 200){
						$.each(response.result,function(key,value){
							x = x+'<tr>'+
	        					   '<td>'+i+'</td>'+
	        					   '<td>'+value.sg_name+'</td>'+
	        					   '<td><button type="button" id="'+value.sg_id +'" class="btn btn-primary btn-sm edit_sub_group"><span class="glyphicon glyphicon-edit"></span> Edit </button> &nbsp;'+
	   	   					 	'<button type="button" id="'+value.sg_id +'" class="btn btn-danger btn-sm delete_sub_group"><span class="glyphicon glyphicon-trash"></span> Delete </button></td>'+
	        					   '</tr>';
	 					   		i++;	
						});
						$('#sub_group_list').html(x);
					}else{
						$('#sub_group_list').html('<tr><td colspan="3" style="text-align:center;">record not found.</td></tr>');
						}
				}
			});
	}
	//------------------edit subject group--------------------------------
	$(document).on('click','.edit_sub_group',function(){
		var sg_id = $(this).attr('id');
		$.ajax({
			type:'POST',
			url:base_url+'Subject_ctrl/getSubGroupData',
			data:{sg_id:sg_id},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					$('#sg_id').val(response.result[0]['sg_id']);
					$('#sg_name').val(response.result[0]['sg_name']);
					$('.update_sub_group').removeClass('hide');
					$('.submit_sub_group').addClass('hide');
				}else{
					}
			},
		});
	});
	//----------------delete subject gorup----------------------
	$(document).on('click','.delete_sub_group',function(){
		var delete_id = $(this).attr('id');
		if(confirm('are you sure!')){
			$.ajax({
				type:'POST',
				url:base_url+'Subject_ctrl/deleteSubGroup',
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
				}
			});
		}
	});


	$(document).on('click','#submit_sub_group',function(){
		var sg_id = $('#sg_id').val();
		var sg_name = $('#sg_name').val();
		var formvalidate = true;
		if(sg_name == ''){
			$('#sg_name_err').html('Subject Group is Required.').css('display','block');
			formvalidate = false;
			}else{
				$('#sg_name_err').css('display','none');
				}
		if(formvalidate == true){
			$.ajax({
				type:'POST',
				url:base_url+'Subject_ctrl/submitSubGroup',
				data:{sg_id:sg_id,sg_name:sg_name},
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
					if(response.status == 400){
						alert(response.validation_errors);
					}
				}
			});	
		}
	});

	/*---------------------------------------------------------
						subject type
	-----------------------------------------------------------*/
	subjectTypeList();
	function subjectTypeList(){
		$.ajax({
				url:base_url+'Subject_ctrl/subjectTypeList',
				dataType:'json',
				success:function(response){
					x='';
					i=1;
					if(response.status == 200){
						$.each(response.result,function(key,value){
							x=x+'<tr>'+
								'<td>'+i+'</td>'+
								'<td>'+value.st_name+'</td>'+
								'<td><button type="button" id="'+value.st_id +'" class="btn btn-primary btn-sm edit_sub_type"><span class="glyphicon glyphicon-edit"></span> Edit </button> &nbsp;'+
		   					 	'<button type="button" id="'+value.st_id +'" class="btn btn-danger btn-sm delete_sub_type"><span class="glyphicon glyphicon-trash"></span> Delete </button></td>'+
								'</tr>';
							i++;
						});
						$('#st_list').html(x);
					}else{
						$('#st_list').html('<tr><td colspan="3" style="text-align:center;">record not found.</td></tr>');
						}
				},
			});
	}

	//--------------get subject type data---------------------------------
	$(document).on('click','.edit_sub_type',function(){
		var st_id = $(this).attr('id');
		$.ajax({
				type:'POST',
				url:base_url+'Subject_ctrl/getSubTypeData',
				data:{st_id:st_id},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');
						$('#st_id').val(response.result[0]['st_id']);
						$('#st_name').val(response.result[0]['st_name']);
						$('.btn_update_sub_type').removeClass('hide');
						$('.btn_submit_sub_type').addClass('hide');
					}else{
						alert(response.feedback);
						}
				},
			});
	});
	//--------------delete subject type---------------------------------------------
	$(document).on('click','.delete_sub_type',function(){
		var delete_id = $(this).attr('id');
		if(confirm('are you sure!')){
			$.ajax({
				type:'POST',
				url:base_url+'Subject_ctrl/deleteSubType',
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

	//-------------subject type submit-----------------------------------------------
	$(document).on('click','#submit_sub_type',function(){
		var st_id = $('#st_id').val();
		var st_name = $('#st_name').val();
		var fromvalid = true;
		if(st_name == ''){
			$('#st_name_err').html('Subject Type is required.').css('display','block');
			fromvalid = false;
			}else{
				$('#st_name_err').css('display','none');
				}

		if(fromvalid){
			$.ajax({
				type:'POST',
				url:base_url+'Subject_ctrl/submitSubjectType',
				data:{st_id:st_id,st_name:st_name},
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
					if(response.status == 400){
						alert(response.validation_errors);	
					}
				}
			});	
		}
		
	});

	//----------subject list----------------------------------
	subjectList();
	function subjectList(){
		$.ajax({
			url:base_url+'Subject_ctrl/subjectList',
			dataType:'json',
			success:function(response){
				if(response.status == 200){
					x = '';
					i = 1;
					$.each(response.result,function(key,value){
						x=x+'<tr>'+
							'<td>'+i+'</td>'+
							'<td>'+value.st_name+'</td>'+
							'<td>'+value.sub_name+'</td>'+
							'<td>'+value.short_order+'</td>'+
							'<td><button type="button" id="'+value.sub_id +'" class="btn btn-primary btn-sm edit_subject"><span class="glyphicon glyphicon-edit"></span> Edit </button> &nbsp;'+
	   					 	'<button type="button" id="'+value.sub_id +'" class="btn btn-danger btn-sm delete_subject"><span class="glyphicon glyphicon-trash"></span> Delete </button></td>'+
							'</tr>'+
						i++;
					});
					$('#subject_list').html(x);
				}else{
					$('#subject_list').html('<tr><td colspan="5" style="text-align:center;">record not found.</td></tr>');
					}
			},
		});
	}
	//-----------------delete Subject-----------------------------
	$(document).on('click','.delete_subject',function(){
		var sub_id = $(this).attr('id');
		if(confirm('are you sure!')){
			$.ajax({
				type:'POST',
				url:base_url+'Subject_ctrl/delete_subject',
				data:{sub_id:sub_id},
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
	//----------------subject edit data----------------------
	$(document).on('click','.edit_subject',function(){
		var edit_id = $(this).attr('id');
		$.ajax({
				type:'POST',
				url:base_url+'Subject_ctrl/editSubject',
				data:{edit_id:edit_id},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					console.log(response);
					if(response.status == 200){
						$('#loader').modal('hide');
						$('#sub_id').val(response.result[0]['sub_id']);
						$('#sub_type').val(response.result[0]['st_id']);
						$('#subject_name').val(response.result[0]['sub_name']);
						$('#short_order').val(response.result[0]['short_order']);
						$('.subject_update').removeClass('hide');
						$('.subject_submit').addClass('hide');
					}else{
						alert(response.feedback);
						}
				},
			});
	});

	//------------------subject submit------------------------
	$(document).on('click','#submit_subject',function(){
		var sub_id = $('#sub_id').val();
		var sub_type = $('#sub_type').val();
		var subject_name = $('#subject_name').val();
		var short_order = $('#short_order').val();
		var formvalid = true;
		if(subject_name == ''){
			$('#sub_name_err').html('Subject Name is required.').css('display','block');
			formvalid = false;
			}else{
				$('#sub_name_err').css('display','none');
				}
		if(sub_type == ''){
			$('#sub_type_err').html('Subject Type is Required..!').css('display','block');
			}else{
				$('#sub_type_err').css('display','none');
			}
		if(short_order == ''){
			$('#short_order_err').html('Short Order is Required..!').css('display','block');
			}else{
				$('#short_order_err').css('display','none');
				}
		
		if(formvalid == true){
				$.ajax({
					type:'POST',
					url:base_url+'Subject_ctrl/subjectSubmit',
					data:{
	    					'sub_id':sub_id,
	    					'sub_type':sub_type,
	    					'subject_name':subject_name,
	    					'short_order':short_order
						},
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
						if(response.status == 400){
							alert(response.validation_errors);	
						}	
					},
				});
			}
	});
});