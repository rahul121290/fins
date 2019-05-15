$(document).ready(function(){
	var base_url = $('#base_url').val();
	//-----------------get final result---------------------
	$(document).on('click','.final_marksheet',function(){
		var formvalidate = $('#marksheet_form').valid();
		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		if(class_name >= 14){
			if(sub_group == ''){
				$('#sub_group_err').html('This field is required.').css('display','block');
				return false
			}else{
				$('#sub_group_err').css('display','none');
				}
		}
		if(formvalidate){
			var formdata = new FormData();
			formdata.append('session',$('#session').val());
			formdata.append('medium',$('#medium').val());
			formdata.append('class_name',$('#class_name').val());
			formdata.append('sub_group',$('#sub_group').val());
			formdata.append('section',$('#section').val());
			formdata.append('std_id',$(this).data('std_id'));
			$.ajax({
				type:'POST',
				url:base_url+'Production_ctrl/finalMarkSheetGenerate',
				data:formdata,
				dataType:'json',
				beforeSned:function(){
					$('#loader').modal('show');
				},
				success:function(response){
					console.log(response);
				},
				cache:false,
				processData:false,
				contentType:false
			});
		}
	});
	
	//----------------****************----------------------
	$(document).on('change','#class_name',function(){
		var class_name = $(this).val();
		if(class_name >= 14){
			$('#sub_group_row').css('display','block');
		}else{
			$('#sub_group_row').css('display','none');
			$('#sub_group').prop('selectedIndex','');
			}	
	});
});