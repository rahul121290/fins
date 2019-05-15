$(document).ready(function(){
	var base_url = $('#base_url').val();

	$(document).on('click','#submit',function(){
		$('#genetate_csv').validate({
			rules:{
				session:{required:true},
				medium:{required:true},
				class_name:{required:true},
				sub_group:{required:$('#class_name').val() > 13},
				section:{required:true}
				},
			messages:{
				},
		});

		var formvalid = $('#genetate_csv').valid();

		if(formvalid){
			var formdata = new FormData();
			formdata.append('session',$('#session').val());
			formdata.append('medium',$('#medium').val());
			formdata.append('class_name',$('#class_name').val());
			formdata.append('sub_group',$('#sub_group').val());
			formdata.append('section',$('#section').val());

			$.ajax({
				type:'POST',
				url:base_url+'Fees_payment_ctrl/generateCSV',
				data:formdata,
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');		
				},
				success:function(response){
					if(response.status == 200){
						openExcelfile(response.file_path);
						$('#loader').modal('hide');
					}else{
						alert('something went worng.');
						}
				},
				cache:false,
				contentType:false,
				processData:false
			});
		}
	});

	function openExcelfile(strFilePath){
		openExcelDocPath(base_url + strFilePath, false);
	}

	function openExcelDocPath(strLocation, boolReadOnly){
		window.location.href = strLocation;
	} 


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