$(document).ready(function(){
	var base_url = $('#base_url').val();
	$(document).on('change','#teacher',function(){
		var tid = $('#teacher').val();
		$.ajax({
			type:'POST',
			url:base_url+'User_role_ctrl/getemail',
			data:{tid:tid},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					$('#email').val(response.result[0].email);
				}
			},
		});
	});
	//------------get edit data-------------------------------------------
	$(document).on('click','.edit',function(){
		var editId = $(this).attr('id');
		$.ajax({
				type:'POST',
				url:base_url+'User_role_ctrl/getEditData',
				data:{editId:editId},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');				
				},
				success:function(response){
					console.log(response);
					if(response.status == 200){
						$('#loader').modal('hide');
						var values = response.data.permission;
						$.each(values.split(","), function(key,value){
							$(":checkbox[value="+ value +"]").prop("checked",true);
							});				
						$('#id').val(response.data.id);
						$('#ug_id').val(response.data.ug_id);
						$('#teacher').val(response.data.teacher);
						$('#group').val(response.data.group);
						$('#email').val(response.data.email);
						$('#username').val(response.data.username);
						$('#password').val(response.data.pass_hint);
						$('#confirm_password').val(response.data.pass_hint);
						$('.user_submit').addClass('hide');
						$('.user_update').removeClass('hide');
					}
				},
			});
	});
//--------------------delete--------------------------------------
	$(document).on('click','.delete',function(){
		var delete_id = $(this).attr('id');
		if(confirm('are you sure!')){
			$.ajax({
					type:'POST',
					url:base_url+'User_role_ctrl/deleteRecord',
					data:{'delete_id':delete_id},
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

//---------------------formdata submit----------------------------------
	$('#user_role_form').validate({
		rules:{
				teacher:{required:true},
				username:{required:true},
				password:{required:true, minlength:6, maxlength:12},
				confirm_password:{required:true,equalTo: "#password"},
				permission:{required:true},
				group:{required:true}
			},
		messages:{
			}	
	});
	$(document).on('click','#submit_user_role',function(){
		var formvalid = $('#user_role_form').valid();
		var permission = new Array();
		$('input[name="permission[]"]:checked').each(function() {
		   permission.push($(this).val());
		});
		if(formvalid == true){
			var formdata = new FormData();
			formdata.append('id',$('#id').val());
			formdata.append('ug_id',$('#ug_id').val());
			formdata.append('teacher',$('#teacher').val());
			formdata.append('username',$('#username').val());
			formdata.append('email',$('#email').val());
			formdata.append('confirm_password',$('#confirm_password').val());
			formdata.append('permission',permission);
			formdata.append('group',$('#group').val());
			$.ajax({
				type:'POST',
				url:base_url+'User_role_ctrl/userRollSubmit',
				data:formdata,
				async: false,
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
				},
				cache: false,
		        contentType: false,
		        processData: false
			});
		}
	});
	
	//---------check username------------------------------
	$(document).on('keyup','#username',function(){
		var username = $(this).val();
		$.ajax({
			type:'POST',
			url:base_url+'User_role_ctrl/checkUsername',
			data:{'username':username},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					$('#username_err').html(response.data[0].username+ ' is Already exist.').css('display','block');
					$('.user_submit').prop('disabled',true);
				}else{
					$('#username_err').css('display','none');
					$('.user_submit').prop('disabled',false);
				}
			},
		});
	});
	
	$('input[class="show_check"]').click(function(){
		var pass_row = $(this).data('id');
        if($(this).prop("checked") == true){
            $('#'+pass_row).prop('type','text');
        }
        else if($(this).prop("checked") == false){
        	$('#'+pass_row).prop('type','password');
        }
    });
	
});