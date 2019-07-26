<div class="content-wrapper">
    <section class="content-header">
      <h1>Subject<small>Teacher</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">subject teacher</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/subject_teacher.js"></script>
    <!-- Main content -->
    <section class="content">
    	<div class="row">
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Add Subject Teacher</h3>
                </div>
            	<div class="box-body">
            		<form method="POST" role="form" class="form-horizontal" id="subject_teacher_form">
            		
            		<input type="hidden" name="id" id="id">
              			<div class="form-group">
							<label class="control-label col-md-2">Medium</label>
							<div class="col-sm-8">
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
										<option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
									<?php } ?>
								</select>
								<div id="medium_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
						<div class="form-group">
							<label class="control-label col-md-2">Class</label>
							<div class="col-sm-8">
								<select name="class_name" id="class_name" class="form-control">
									<option value="">Select Calss</option>
									<?php foreach($class as $classes){?>
									<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
									<?php } ?>
								</select>
								<div id="class_name_err" style="display:none; color:red;"></div>
							</div>
					    </div>
						
						<div class="form-group" id="sub_group_field" style="display:none;">
							<label class="control-label col-md-2">Sub Group</label>
							<div class="col-sm-8">
								<select name="sub_group" id="sub_group" class="form-control">
									<option value="">Select Subject Group</option>
									<?php foreach($group as $sub_group){?>
										<option value="<?php echo $sub_group['sg_id'];?>"><?php echo $sub_group['sg_name'];?></option>
									<?php } ?>
								</select>
								<div id="sub_group_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Section</label>
							<div class="col-sm-8">
								<select name="section" id="section" class="form-control">
									<option value="">Select Section</option>
									<?php foreach($section as $sec){?>
									<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
									<?php } ?>
								</select>
								<div id="section_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Subject Type</label>
							<div class="col-sm-8">
								<select name="sub_type" id="sub_type" class="form-control">
									<option value="">Select Subject Type</option>
									<?php foreach($sub_type as $subtype){?>
									<option value="<?php echo $subtype['st_id'];?>"><?php echo $subtype['st_name'];?></option>
									<?php } ?>
								</select>
								<div id="sub_type_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
					    	<label class="control-label col-md-2"></label>
    					    <div class="col-sm-8">
    					    	<table class="table table-responsive">
    					    		<thead>
    					    			<tr>
    					    				<th>Sr. No.</th>
    					    				<th>Subject Name</th>
    					    				<th>Teacher Name</th>
    					    			</tr>
    					    		</thead>
    					    		<tbody id="subjects_list"></tbody>
    					    	</table>
    					    </div>
					    </div>
        			</form>
        		</div><!-- end box body -->
     			</div>
   			</div>
       		<div class="col-md-6">	
              	<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">Class wise subject and teacher list</h3>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    						<thead>
            					<tr>
                    				<th>Sr No.</th>
                    				<th>Class</th>
                    				<th id="table_sub_group" style="display:none;">Subject Group</th>
                    				<th>Section</th>
                    				<th>Subject Type</th>
                    				<th>Subject</th>
                    				<th>Teacher</th>
            					</tr>
        					</thead>
    						<tbody id="list_of_subject_teacher"></tbody>
    					</table>
              		</div>
         		</div>
       		</div>
       		
		</div>
	</section>	
</div>