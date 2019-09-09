<div class="content-wrapper">
    <section class="content-header">
      <h1>Result Export Excel<small></small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="">Production Reports</li>
        <li class="active">Export Excel</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/furd_report.js"></script>
    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Export Result Excel Sheet</h3>
                </div>
            	<div class="box-body">
            		<?php echo form_open("",['class'=>'form-horizontal','id'=>"export_form",'role'=>"form"]);?>
            			<input type="hidden" name="id" id="id">
					    
					    <div class="form-group">
							<div class="col-sm-2">
								<select name="exam_type" id="exam_type" class="form-control">
									<option value="">Select Exam Type</option>
									<?php foreach($exam_type as $et){?>
										<option value="<?php echo $et['et_id'];?>"><?php echo $et['et_name'];?></option>
									<?php }?>
								</select>
							</div>
					    
							<div class="col-sm-2">
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
									<option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
									<?php }?>
								</select>
							</div>
					    
							<div class="col-sm-2">
								<select name="class_name" id="class_name" class="form-control">
									<option value="">Select Class</option>
									<?php foreach($class as $classes){?>
									<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
									<?php }?>
								</select>
							</div>
					    
							<div class="col-sm-2" id="sub_group_form" style="display:none;">
								<select name="sub_group" id="sub_group" class="form-control">
									<option value="">Select Subject Group</option>
									<?php foreach($group as $sub_group){?>
									<option value="<?php echo $sub_group['sg_id'];?>"><?php echo $sub_group['sg_name'];?></option>
									<?php }?>
								</select>
								<div id="sub_group_err" style="display:none; color:red;"></div>
							</div>
							
					    
							<div class="col-sm-2">
								<select name="section" id="section" class="form-control">
									<option value="">Select Section</option>
									<?php foreach($section as $sections){?>
									<option value="<?php echo $sections['sec_id'];?>"><?php echo $sections['section_name'];?></option>
									<?php }?>
								</select>
							</div>
			
                      	<div class="col-sm-2">
                            <button type="button" id="export_excel" class="btn btn-info btn_submit">Export Excel</button>&nbsp;&nbsp;&nbsp;
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
        			</div>
        			<?php echo form_close();?>
        			</div><!-- end box body -->
     			</div>
   			</div>
          </div>
	</section>	
</div>
<script type="text/javascript">
var base_url = $('#base_url').val();

$(document).on('click','#export_excel',function(){
	$('#export_form').validate({
		rules:{
			exam_type:{required:true},
			medium:{required:true},
			class_name:{required:true},
			sub_group:{required:$('#class_name').val() > 13},
			section:{required:true}		
			},
	});
	
	var formvalidation = $('#export_form').valid();
	if(formvalidation){
		var formdata = new FormData();
		formdata.append('exam_type',$('#exam_type').val());
		formdata.append('medium',$('#medium').val());
		formdata.append('class_name',$('#class_name').val());
		formdata.append('sub_group',$('#sub_group').val());
		formdata.append('section',$('#section').val());
			$.ajax({
					type:'POST',
					url:base_url+'Production_ctrl/export_excel',
					data:formdata,
					dataType:'json',
					beforeSend:function(){
						$('#loader').modal('show');
					},
					success:function(response){
						if(response.status == 200){
							$('#loader').modal('hide');
							openExcelfile(response.file_path);
						}else{
							alert(response.feedback);
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
	var class_name = $('#class_name').val();
	if(class_name > 13){
		$('#sub_group_form').css('display','block');
	}else{
    		$('#sub_group_form').css('display','none');
    		$('#sub_group').prop('selectedIndex','');
		}
});
</script>