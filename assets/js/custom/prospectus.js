$(document).ready(function(){
	var baseUrl = $('#base_url').val();
	
	$(document).on('click','#enable_amount',function(){
		if($(this).prop('checked') == 1){
			$('#amount').prop('disabled',false);
		}else{
			$('#amount').prop('disabled',true);
		}
	});
	
	
	$('#prospectus_form').validate({
		rules:{
			reg_no:{required:true},
			selling_date:{required:true},
			school:{required:true},
			medium:{required:true},
			class_id:{required:true},
			name:{required:true},
			phone:{required:true,number:true,maxlength: 10,minlength: 10},
			alternate_no:{number:true,maxlength: 10,minlength: 10},
			address:{required:true},
			amount:{required:true}
		},
	});
	
	$(document).on('click','#submit',function(){
		var formvalidate = $('#prospectus_form').valid();
		if(formvalidate){
			$.ajax({
				type:'POST',
				url:baseUrl+'Prospectus_ctrl/sellingProspectus',
				data:{
					reg_no:$('#reg_no').val(),
					selling_date:$('#selling_date').val(),
					school:$('#school').val(),
					medium:$('#medium').val(),
					class_id:$('#class_id').val(),
					name:$('#name').val(),
					phone:$('#phone').val(),
					alternate_no:$('#alternate_no').val(),
					address:$('#address').val(),
					amount:$('#amount').val(),
				},
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					if(response.status == 200){
						$('#loader').modal('hide');
						alert('Insert Successfully.');
						location.reload();
					}else{
						alert('Insert Faild, Please try again.');
					}
				},
			});
		}
	});
});