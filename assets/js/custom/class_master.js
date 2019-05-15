$(document).ready(function(){
	var base_url = $('#base_url').val();
	//---------data list--------------------------------------
	classList();
	function classList(){
		$.ajax({
			url:base_url+'Class_ctrl/classList',
			dataType:'json',
			success:function(response){
				x = '';
				i = 1;
				if(response.status == 200){
					console.log(response);
					$.each(response.result,function(key,value){
						x=x+'<tr>'+
	    					'<td>'+i+'</td>'+
	    					'<td>'+value.class_name+'</td>'+
	    					'<td><button type="button" id="'+value.c_id +'" class="btn btn-primary btn-sm edit"><span class="glyphicon glyphicon-edit"></span> Edit </button> &nbsp;'+
	   					 	//'<button type="button" id="'+value.c_id +'" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span> Delete </button></td>'+
							'</tr>';
						i++;
					});
					$('#class_list').html(x);
				}
			},
		});
	}
	//----------delete process-------------------------------
	$(document).on('click','.delete',function(){
		var delete_id = $(this).attr('id');
		if(confirm('are you sure!')){
			$.ajax({
				type:'POST',
				url:base_url+'Class_ctrl/deleteData',
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

	//----------edit button process--------------------------
	$(document).on('click','.edit',function(){
		var edit_id = $(this).attr('id');
		$.ajax({
				type:'POST',
				url:base_url+'Class_ctrl/getEditData',
				data:{edit_id:edit_id},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');
						$('#id').val(response.result[0]['c_id']);
						$('#class_name').val(response.result[0]['class_name']);
						$('.btn_update').removeClass('hide');
						$('.btn_submit').addClass('hide');	
					}else{
						alert(response.feedback);
						}
				}
			});
	});

	//----------submit data-----------------------------------
	$(document).on('click','#submit_class',function(){
		var id = $('#id').val();
		var class_name = $('#class_name').val();
		var formvalid = true;
		if(class_name == ''){
			$('#class_name_err').html('Class Name is Required.').css('display','block');
			formvalid = false;
		}else{
			$('#class_name_err').css('display','none');
			}
			
		if(formvalid == true){
			$.ajax({
				type:'POST',
				url:base_url+'Class_ctrl/submitData',
				data:{id:id,class_name:class_name},
				async:false,
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						alert(response.feedback);
						$('#loader').modal('hide');
						location.reload();
					}else{
						alert(response.feddback);
						}
					if(response.status == 400){
						alert(response.validation_errors);
					}
				},
			});		
		}
		
	});
	//--------------------end class parts-----------------------------------------

	//---------- section list---------------------------
	SectionList();
	function SectionList(){
		$.ajax({
			url:base_url+'Class_ctrl/SectionList',
			dataType:'json',
			success:function(response){
				if(response.status == 200){
					x = '';
					i = 1;
					$.each(response.result,function(key,value){
						x=x+'<tr>'+
							'<td>'+i+'</td>'+
							'<td>'+value.section_name+'</td>'+
							'<td><button type="button" id="'+value.sec_id +'" class="btn btn-primary btn-sm sec_edit"><span class="glyphicon glyphicon-edit"></span> Edit </button> &nbsp;'+
	   					 	'<button type="button" id="'+value.sec_id +'" class="btn btn-danger btn-sm sec_delete"><span class="glyphicon glyphicon-trash"></span> Delete </button></td>'+
							'</tr>';
						i++;
					});
					$('#section_list').html(x);
				}else{
					$('#section_list').html('<tr><td colspan="3" style="text-align:center;"><b>record not found.</b></td></tr>');
					}		
			},
		});
	}
	//--------------get section data-------------------------------
	$(document).on('click','.sec_edit',function(){
		var editSecId = $(this).attr('id');
		$.ajax({
				type:'POST',
				url:base_url+'Class_ctrl/editSecId',
				data:{editSecId:editSecId},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');	
						$('#sectionid').val(response.result[0]['sec_id']);
						$('#section_name').val(response.result[0]['section_name']);
						$('.btn_update_sec').removeClass('hide');
						$('.btn_submit_sec').addClass('hide');
					}
				}
			});
	});

	//--------------delete section---------------------------------
	$(document).on('click','.sec_delete',function(){
		var sec_id = $(this).attr('id');
		if(confirm('are you sure!')){
			$.ajax({
					type:'POST',
					url:base_url+'Class_ctrl/deleteSection',
					data:{sec_id:sec_id},
					dataType:'json',
					beforeSend:function(){
						$('#loader').modal('show');
					},
					success:function(response){
						console.log(response);
						if(response.status == 200){
							location.reload();
						}else{
							alert(response.feedback);
							}
					}
				});	
		}
	});

	//-----------submit section-----------------------------
	$(document).on('click','#submit_section',function(){
		var sectionid = $('#sectionid').val();
		var section_name = $('#section_name').val();
		var formvalidate = true;
		if(section_name == ''){
			$('#section_name_err').html('Section Name is Required.').css('display','block');
			formvalidate = false;
		}else{
			$('#section_name_err').css('display','none');
			}

		if(formvalidate == true){
			$.ajax({
				type:'POST',
				url:base_url+'Class_ctrl/submitSectionData',
				data:{sectionid:sectionid,section_name:section_name},
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