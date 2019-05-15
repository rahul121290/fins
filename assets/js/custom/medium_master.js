$(document).ready(function(){
	var base_url = $('#base_url').val();
	ShowList();
	function ShowList(){
		$.ajax({
				url:base_url+'Medium_ctrl/showList',
				dataType:'json',
				success:function(response){
					x='';
					i=1;
					$.each(response.result,function(key,value){
						x=x+'<tr>'+
							'<td>'+i+'</td>'+
						    '<td>'+value.med_name+'</td>'+
						    '<td><button type="button" id="'+value.med_id +'" class="btn btn-primary btn-sm edit"><span class="glyphicon glyphicon-edit"></span> Edit </button> &nbsp;'+
	   					    '<button type="button" id="'+value.med_id +'" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span> Delete </button></td>'+
						    '</tr>';
					    i++;
					});
					$('#medium_list').html(x);
				},
			});
	}//end of function--------
//-----------record delete--------------------------
	$(document).on('click','.delete',function(){
		var delete_id = $(this).attr('id');
		if(confirm('are you sure!')){
		$.ajax({
				type:'POST',
				url:base_url+'Medium_ctrl/delete_record',
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
//--------click edit button and fetch record----------------------------
	$(document).on('click','.edit',function(){
		var edit_id = $(this).attr('id');
		
		$.ajax({
			type:'POST',
			url:base_url+'Medium_ctrl/editrecord',
			data:{edit_id:edit_id},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					$('#id').val(response.result[0]['med_id']);
					$('#medium_name').val(response.result[0]['med_name']);
					$('.btn_update').removeClass('hide');
					$('.btn_submit').addClass('hide');
				}else{
					alert(response.feedback);
					}
			},
			
			});
	});
//-----------record submit-------------------------
	$(document).on('click','#submit_medium',function(){
		var medium_name =  $('#medium_name').val();
		var formvalidate = true;
		if(medium_name == ''){
			$('#medium_name_err').html('Medium is Required..!').css('display','block');	
			formvalidate = false;
		}else{
			$('#medium_name_err').css('display','none');
			}

		if(formvalidate == true){
				$.ajax({
						type:'POST',
						url:base_url+'Medium_ctrl/submitData',
						data:{
							'id':$('#id').val(),
							'medium_name':$('#medium_name').val()
							},
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
					});
			}
	});
});