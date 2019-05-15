<div class="content-wrapper">
    <section class="content-header">
      <h1>Subject<small>Allocation</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
        <li class="active">subject allocation</li>
      </ol>
    </section>
<script src="<?php echo base_url();?>assets/js/custom/subject_allocation.js"></script>
<!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Class Wise Allocate Subject's</h3>
                </div>
            	<div class="box-body form-horizontal">
            			<input type="hidden" name="sub_id" id="sub_id">
					    <div class="form-group">
							<label class="control-label col-md-2">Medium</label>
							<div class="col-sm-8">
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
									<option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
									<?php }?>
								</select>
								<div id="medium_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Class</label>
							<div class="col-sm-8">
								<select name="class" id="class" class="form-control">
									<option value="">Select Class</option>
									<?php foreach($class as $cls){?>
										<option value="<?php echo $cls['c_id'];?>"><?php echo $cls['class_name'];?></option>
									<?php }?>
								</select>
								<div id="class_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group" id="sub_group_form" style="display:none;">
							<label class="control-label col-md-2">Subject Group</label>
							<div class="col-sm-8">
								<select name="sub_group" id="sub_group" class="form-control">
									<option value="">Select Subject Group</option>
									<?php foreach ($sub_gorup as $subject_group){?>
										<option value="<?php echo $subject_group['sg_id'];?>"><?php echo $subject_group['sg_name'];?></option>
									<?php }?>
								</select>
								<div id="sub_group_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Subject Type</label>
							<div class="col-sm-8">
								<select name="sub_type" id="sub_type" class="form-control">
									<option value="">Select Subject Type</option>
									<?php foreach ($sub_type as $subject_type){?>
										<option value="<?php echo $subject_type['st_id'];?>"><?php echo $subject_type['st_name'];?></option>
									<?php } ?>
								</select>
								<div id="sub_type_err" style="display: none; color:red;"></div>
							</div>
					    </div>
			
					    <div class="form-group" id="subjets"></div>
					    
        			</div><!-- end box body -->
     			</div>
   			</div>
   			
          	<div class="col-md-6">	
          		<div class="box box-danger">
                	<div class="box-header">
                  		<h3 class="box-title">Out of Marks</h3>
                	</div>
                	<table class="table table-responsive">
                		<thead>
                			<tr>
                				<th>Sr No.</th>
                				<th>Subject Name</th>
                				<th id="_pre_mid">Pre Mid</th>
                				<th>Mid</th>
                				<th id="mid_pra" style="display:none;">M Practical</th>
                				<th id="_post_mid">Post Mid</th>
                				<th>Final</th>
                				<th id="final_pra" style="display:none;">F Practical</th>
                			</tr>
                			</thead>
                			<tbody id="out_of_marks"></tbody>
                	</table>
              		</div>   
     			</div>
   			</div> 
	</section>	
</div>