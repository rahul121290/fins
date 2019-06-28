$(document).ready(function(){
	var base_url = $('#base_url').val();
	//-----------session------------------------------------------------
	$(document).on('click','#submit_session',function(){
		var session_name = $('#session_name').val();
		var formvalid = true;
		if(session_name == ''){
			$('#session_name_err').html('Session Name is Required..!').css('display','block');
			formvalid = false;
			}else{
				$('#session_name_err').css('display','none');
				}

		if(formvalid == true){
			var formdata= new FormData();
			formdata.append('id',$('#id').val());
			formdata.append('session_name',$('#session_name').val());
			
			$.ajax({
				type:"POST",
				url:base_url+'Session_ctrl/session_insert',
				dataType:'json',
				data:formdata,
				async:false,
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success: function(response){
					if(response.status==200){
						alert(response.feedback);
						location.reload();
					}else{
						alert(response.feedback);
	    				}
					if(response.status==400){
							alert(response.validation_errors);
						}
					},
				 cache: false,
				 contentType: false,
				 processData: false	
			});
		}
	});

	get_session();
	function get_session(){
		$.ajax({
				url:base_url+'Session_ctrl/get_session',
				dataType:'json',
				beforeSend:function(){},
				success:function(response){
					console.log(response);
					var x = '';
					var y = '';
					var i = 1;
					if(response.status == 200){
						$.each(response.result,function(key,value){
							if(value.set_ses == 1){
								var checked = 'checked';
								}else{
									checked = '';
									}
							x = x +'<input type="radio" name="session_set" data-id="'+value.ses_id+'" value="'+value.set_ses+'" class="session_set"'+checked+'> '+value.session_name+'<br>';
							y = y + '<tr>'+
									'<td>'+ i +'</td>'+
									'<td>'+value.session_name+'</td>'+
									 '<td><button type="button" id="'+value.ses_id +'" class="btn btn-primary btn-sm editbtn"><span class="glyphicon glyphicon-edit"></span> Edit </button> &nbsp;'+
			    					 //'<button type="button" id="'+value.ses_id +'" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span> Delete </button></td>'+
									'</tr>';
								i++;
						});
						$('#set_ses').html(x);
						$('#ses_list').html(y);
					}
				},
			});
	}

	$(document).on('click','.delete',function(){
		var delete_id = $(this).attr('id');
		if(confirm('are you sure!')){
				$.ajax({
						type:'POST',
						url:base_url+'Session_ctrl/delete_session',
						data:{delete_id:delete_id},
						dataType:'json',
						beforeSend:function(){
							$('#loader').modal('show');
						},
						success:function(response){
							$('#loader').modal('hide');
							if(response.status == 200){
								location.reload();
							}else{
								alert(response.feedback);
			    				}
						}
					});
			}
	});

	$(document).on('click','.editbtn',function(){
		var edit_id = $(this).attr('id');
		$.ajax({
				type:'POST',
				url:base_url+'Session_ctrl/edit_data',
				data:{edit_id:edit_id},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');
						$('#id').val(response.result[0]['ses_id']);
						$('#session_name').val(response.result[0]['session_name']);
						$('.btn_submit').addClass('hide');
						$('.btn_update').removeClass('hide');
					}
				},
			});
	});

	$(document).on('click','.session_set',function(){
		var session_set = $('input[name="session_set"]:checked').val();
		var id = $(this).data('id');
		$.ajax({
				type:'POST',
				url:base_url+'Session_ctrl/session_set',
				data:{id:id,session_set:session_set},
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
					}
			});
	});
});