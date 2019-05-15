<div class="content-wrapper">
    <section class="content-header">
      <h1>Student Attendance<small>Entry</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
        <li>transaction-record</li>
        <li class="active">attendance-entry</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/student_attendance.js"></script>
    <!-- Main content -->
    <section class="content">
    	<div class="row">
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Student Attendacne</h3>
                </div>
            	<div class="box-body form-horizontal">
            		<input type="hidden" name="am_id" id="am_id">
          				
          				  <div class="form-group">
							<label class="control-label col-md-2">Medium</label>
							<div class="col-sm-8">
							<select name="medium" id="medium" class="form-control">
								<option value="">Select Medium</option>
								<?php foreach($medium as $sch_medium){?>
									<option value="<?php echo $sch_medium['med_id'];?>"><?php echo $sch_medium['med_name'];?></option>
								<?php }?>
							</select>
								<div id="medium_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					   	<div class="form-group">
							<label class="control-label col-md-2">Select Exam</label>
							<div class="col-sm-8">
							<select name="exam_type" id="exam_type" class="form-control">
								<option value="">Select Exam Type</option>
							</select>
								<div id="exam_type_err" style="display:none; color:red;"></div>
							</div>
					    </div>
          
          				<div class="form-group">
							<label class="control-label col-md-2">Class</label>
							<div class="col-sm-8">
							<select name="class_name" id="class_name" class="form-control">
								<option value="">Select Class</option>
								<?php foreach($class as $class_name){?>
								<option value="<?php echo $class_name['c_id'];?>"><?php echo $class_name['class_name'];?></option>
								<?php }?>
							</select>
								<div id="class_name_err" style="display:none; color:red;"></div>
							</div> 
					    </div>
					    
					    <div class="form-group" id="sg_row" style="display:none;">
							<label class="control-label col-md-2">Subject group</label>
							<div class="col-sm-8">
							<select name="sub_group" id="sub_group" class="form-control">
								<option value="">Select Subject Group</option>
								<?php foreach($group as $sg){?>
								<option value="<?php echo $sg['sg_id'];?>"><?php echo $sg['sg_name'];?></option>
								<?php }?>
							</select>
								<div id="sub_group_err" style="display:none; color:red;"></div>
							</div> 
					    </div>
					    
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Section</label>
							<div class="col-sm-8">
							<select name="section" id="section" class="form-control">
								<option value="">Select Section</option>
								<?php foreach($section as $sect){?>
								<option value="<?php echo $sect['sec_id'];?>"><?php echo $sect['section_name'];?></option>
								<?php }?>
							</select>
								<div id="section_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					      <div class="form-group">
							<label class="control-label col-md-2">Total Present Days</label>
							<div class="col-sm-8">
							<input type="text" name="total_days" id="total_days" class="form-control" disabled="disabled">
								<div id="total_days_err" style="display:none; color:red;"></div>
							</div>
					    </div>
          
              	
		  			<div class="box-footer">
                      	<div class="col-sm-offset-8">
                            <button type="button" name="search" id="search" class="btn btn-info" style="display:none;">Search Students</button>
                            <button type="reset" id="reset" class="btn btn-default" style="display:none;">Reset</button>
                        </div>
        			</div>
        		</div><!-- end box body -->
     			</div>
   			</div>
   			
    	<div class="col-md-6">
    		<div class="box box-primary">
            	<div class="box-header">
                      <h3 class="box-title">Students Attendance List</h3>
                </div>
    			<div class="box-body">
    				<div class="form-group">
        				<table class="table table-responsive">
            				<thead>
            					<tr>
            						<th>Sr. No.</th>
            						<th>Student Name</th>
            						<th>Addmition No</th>
            						<th>Roll No</th>
            						<th>Attendance</th>
            					</tr>
            				</thead>
            				<tbody id="std_list"></tbody>
        				</table> 
    			</div>
    		</div>
    		<div class="box-footer">
              	<div class="col-sm-offset-8">
                     <button type="button" name="submit" id="submit" class="btn btn-info" style="display:none;">Submit</button>
                </div>
            </div>
    	</div>
		</div>
		</div>
	</section>	
</div>