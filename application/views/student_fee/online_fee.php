<div class="content-wrapper">
    <section class="content-header">
      <h1>Generate Online Month Fee</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Online Month Fee</li>
      </ol>
    </section>
    <!-- Main content -->
	<section class="content">
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Generate the fee on 1st of every month.</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<form role="form" class="form-horizontal" id="fee_generate" method="POST">
			<div class="box-body">
                <div class="form-group">
                  <div class="col-sm-6">
					<select id="school" name="school" class="form-control">
						<option value="">Select School</option>
						<option value="1">Shakuntala CBSE</option>
						<option value="3">Shakuntala CG Board</option>
						<option value="2">Sharda CBSE</option>
					</select>
					<div id="school_err" class="error" style="display:none;"></div>
				</div>
				
				<div class="col-sm-6" style="display: none;" id="class_row">
					<select id="class_id" name="class_id" class="form-control">
						<option value="">Select Class</option>
						<?php foreach($class as $cls){?>
						<option value="<?php echo $cls['c_id'];?>"><?php echo $cls['class_name'];?></option>
						<?php } ?>
					</select>
					<div id="class_err" class="error" style="display:none;"></div>
				</div>
				
				<div class="col-md-6">
					<button type="button" id="submit" class="btn btn-info">Submit</button>
                    <button type="button" id="send_sms" style="display: none;" class="btn btn-info">Send SMS</button>
				</div>
                </div>
			</div>
			
			<div class="box-footer"></div>
			</form>
		</div>
     </section>
</div>

<script type="text/javascript">
var baseUrl = $('#base_url').val();


$('#fee_generate').validate({
	rules:{
		school:{required:true},
	},
});

$(document).on('click','#submit',function(){
	var formvalidate = $('#fee_generate').valid();
	if(formvalidate){
		$.ajax({
			type:'POST',
			url:baseUrl+'Generate_fee_ctrl/generate_fee',
			data:{'sch_id':$('#school').val()},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					alert(response.msg);
					$('#school').prop('disabled',true);
					$('#submit').css('display','none');
					$('#class_row').css('display','block');
					$('#send_sms').css('display','block');
				}else{
					$('#loader').modal('hide');	
					alert(response.msg);
					$('#school').prop('disabled',true);
					$('#submit').css('display','none');
					$('#class_row').css('display','block');
					$('#send_sms').css('display','block');
				}
			},
		});
	}
});

$(document).on('click','#send_sms',function(){
	var school = $('#school').val();
	var class_id = $('#class_id').val();

	$.ajax({
		type:'POST',
		url:baseUrl+'Generate_fee_ctrl/send_fee_sms',
		data:{'school':school,'class_id':class_id},
		dataType:'json',
		beforeSend:function(){
			$('#loader').modal('show');
		},
		success:function(response){
			if(response.status == 200){
				alert(response.msg);
				$('#loader').modal('hide');
			}else{
				alert(response.msg);
				$('#loader').modal('hide');
			}
		},
	});
	
});



</script>



