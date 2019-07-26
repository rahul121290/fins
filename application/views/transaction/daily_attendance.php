<div class="content-wrapper">
    <section class="content-header">
      <h1>Daily Attendance<small>entry</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="">transaction-record</li>
        <li class="active">daily-attendance</li>
      </ol>
    </section>
    <script src="<?php echo base_url();?>assets/js/custom/daily_attendance.js"></script>
    <!-- Main content -->
    <section class="content">
    	<div class="row">
        <div class="col-md-5">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Daily Attendance Entry</h3>
                </div>
            	<div class="box-body">
            	<form role="form" method="POST" class="form-horizontal" id="daily_attendance_form">
            		<input type="hidden" name="id" id="id">
            		
            		    <div class="form-group">
							<label class="control-label col-md-2">Date</label>
							<div class="col-sm-9">
								<input type="date" name="attendance_date" id="attendance_date" value="<?php echo date('Y-m-d');?>" class="form-control">
								<div id="attendance_date_err" style="display:none; color:red;"></div>
							</div>
					    </div>
            		
            		 	<div class="form-group">
							<label class="control-label col-md-2">Period</label>
							<div class="col-sm-9">
								<select name="period" id="period" class="form-control">
									<option value="">Select Period</option>
									<?php $total_period = 10;
									for($i=1; $i<$total_period; $i++){ ?>
									    <option value="<?php echo $i;?>"><?php echo 'period '.$i;?></option>
									<?php } ?>
								</select>
								<div id="period_err" style="display:none; color:red;"></div>
							</div>
					    </div>
            		
              			<div class="form-group">
							<label class="control-label col-md-2">Medium</label>
							<div class="col-sm-9">
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
							<div class="col-sm-9">
								<select name="class_name" id="class_name" class="form-control">
									<option value="">Select Class</option>
									<?php foreach($class as $classes){?>
									<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
									<?php } ?>
								</select>
								<div id="class_name_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group" id="sub_group_row" style="display: none;">
							<label class="control-label col-md-2">Sub Group</label>
							<div class="col-sm-9">
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
							<div class="col-sm-9">
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
							<label class="control-label col-md-2">Sub Type</label>
							<div class="col-sm-9">
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
							<label class="control-label col-md-2">Subject</label>
							<div class="col-sm-9">
								<select name="subject" id="subject" class="form-control">
								<option value="">Select Subject</option>	
								</select>
								<div id="subject_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
						<div class="box-footer">
                  			<div class="col-sm-offset-8">
                        		<button type="button" id="search" class="btn btn-info">Search Students</button>
                    		</div>
                		</div>	
        			</form>
        		</div><!-- end box body -->
     			</div>
   			</div>
       		<div class="col-md-7">	
              	<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">Attendance Entry <span id="type_and_sub"></span></h3>
                      <div id="subject_msg"></div>
                      <div id="practical_msg"></div>
                      <div id="notebook_msg"></div>
                      <div id="enrichment_msg"></div>
                      <div id="acadmic_msg"></div>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    						<thead>
            					<tr>
                    				<th>Sr No.</th>
                    				<th>Student Name</th>
                    				<th>Class/ Section</th>
                    				<th>Admission No</th>
                    				<th>Roll No</th>
                    				<th style="width: 50px;">Attendance</th>
            					</tr>
        					</thead>
    						<tbody id="list_of_attendance"></tbody>
    					</table>
              		</div>
                  	<div class="box-footer">
                  	<div class="col-sm-offset-8">
                        <button type="button" id="attendance_submit" class="btn btn-info" style="display:none;">Submit</button>
                    </div>
                	</div>
         		</div>
       		</div>
		</div>
	</section>	
</div>