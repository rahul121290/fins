<div class="content-wrapper">
    <section class="content-header">
      <h1>Upload Students Marks<small></small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="">Master-record</li>
        <li class="active">Upload Student Marks In Server</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    	<div class="box box-primary" style="position: relative; left: 0px; top: 0px;" id="marks_import">
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
			  	<i class="fa fa-minus"></i></button>
			  </div>
			</div>
    		<div class="box-body">
			<div class="form-horizontal">
        		<div class="col-sm-3">
        			<input type="file" id="student_marks" name="student_marks" class="form-control">
        			<div id="student_marks_err" style="display:none;color:red;"></div>
        		</div>
        		
            	<div class="col-sm-3">
                	<button type="button" id="submit_marks" class="btn btn-info">Import CSV</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                </div>
    		</div>
			</div>
			<br>
    	</div>
	</section>	
</div>

<script type="text/javascript">
var baseUrl = $('#base_url').val();

$(document).on('click','#submit_marks',function(){
	var student_marks = $('#student_marks').val();
	var formvalidate = true;
	if(student_marks == ''){
		$('#student_marks_err').html('This is Required.').css('display','block');
		formvalidate = false;
	}else{
		$('#student_marks_err').css('display','none');
	}

	if(formvalidate){
		var formdata = new FormData();
		formdata.append('student_marks',$('#student_marks')[0].files[0]);
		$.ajax({
			type:'POST',
			url:baseUrl+'Upload_student_marks_ctrl/upload_student_marks',
			data:formdata,
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					alert('Import successfully');
					$('#loader').modal('hide');
					location.reload();
				}else{
					alert('failed, Please try again.');
					$('#loader').modal('hide');
				}
				
			},
			cache:false,
			processData:false,
			contentType:false
		});
	}
	
		
	
});

</script>
