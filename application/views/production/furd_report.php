<div class="content-wrapper">
    <section class="content-header">
      <h1>Furd Report<small></small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
        <li class="">production-reports</li>
        <li class="active">furd-report</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/furd_report.js"></script>
    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Generate Furd Report</h3>
                </div>
            	<div class="box-body">
            		<?php echo form_open("",['class'=>'form-horizontal','id'=>"marks_entry_check",'role'=>"form"]);?>
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
								<select name="class" id="class" class="form-control">
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
                            <button type="button" id="generate_report" class="btn btn-info btn_submit">Generate Report</button>
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