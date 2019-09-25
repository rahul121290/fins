<div class="content-wrapper">
    <section class="content-header">
      <h1>Student<small>Master</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Add CSV</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/add_student.js"></script>
    <!-- Main content -->
	<section class="content">
	<?php if($this->ion_auth->is_admin() == 1){?>
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
			  	<i class="fa fa-minus"></i></button>
			  </div>
		</div>
    		<div class="box-body">
			<div class="form-horizontal">
        		<div class="col-sm-3">
        			<input type="file" id="csv_file" name="csv_file" class="form-control">
        			<div id="csv_file_err" style="display:none;color:red;"></div>
        		</div>
    			
            	<div class="col-sm-3">
                	<button type="button" id="csv_submit" class="btn btn-info">Import CSV</button>&nbsp;&nbsp;&nbsp;
                    <button type="reset" class="btn btn-default">Reset</button>
                </div>
    		</div>
			</div><br>
    	</div>
	<?php } ?>
    </section>
</div>

<script type="text/javascript">
var baseUrl = $('#base_url').val();

$(document).on('click','#csv_submit',function(){
	var csv_file = $('#csv_file').val();

	var file_ext = csv_file.split('.').pop().toUpperCase();
	var file_size = $('#csv_file')[0].files[0].size;
	
	var formvalidate = true;

	if(csv_file == ''){
		$('#csv_file_err').html('This is Required.').css('display','block');
		formvalidate = false;
	}else{
		if(file_ext!='JPG' && file_ext!='CSV' && file_ext!='XLSX'){
			$('#csv_file_err').html("wrong file formate.").css('display','block');
			formvalidate = false;	
		}else if(file_size >= '1000024'){
			$('#csv_file_err').html("file size is to large.").css('display','block');
			formvalidate = false;
		}else{
			$('#csv_file_err').css('display','none');
		}	
	}
	
	if(formvalidate){
		var formdata = new FormData();
		formdata.append('csv_file',$('#csv_file')[0].files[0]);

		$.ajax({
			type:'POST',
			url:baseUrl+'Student_ctrl/csv_update',
			data:formdata,
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					alert(response.msg);
					location.reload();		
				}else{
					alert(response.msg);
				}
			},
			cache:false,
			processData:false,
			contentType:false
		});	
	}
});


</script>

