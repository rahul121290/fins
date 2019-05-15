<div class="content-wrapper">
    <section class="content-header">
      <h1>Attendance<small>Entry</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
        <li>transaction-record</li>
        <li class="active">attendance-entry</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/attendance_entry.js"></script>
    <!-- Main content -->
    <section class="content">
    	<div class="row">
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Attendacne Entry</h3>
                </div>
            	<div class="box-body form-horizontal">
            		<input type="hidden" name="id" id="id">
          				
          				  <div class="form-group">
							<label class="control-label col-md-2">Medium</label>
							<div class="col-sm-8">
							<select name="medium" id="medium" class="form-control">
								<option value="">Select Medium</option>
								<?php foreach($medium as $medium1){?>
								<option value="<?php echo $medium1['med_id'];?>"><?php echo $medium1['med_name'];?></option>
								<?php }?>
							</select>
								<div id="medium_err" style="display:none; color:red;"></div>
							</div>
					    </div>

              			<div class="form-group">
							<label class="control-label col-md-2">Exam Type</label>
							<div class="col-sm-8">
							<select name="exam_type" id="exam_type" class="form-control">
								<option value="">Select Exam Type</option>
								<?php foreach($exam_type as $et){?>
								<option value="<?php echo $et['et_id'];?>"><?php echo $et['et_name'];?></option>
								<?php }?>
							</select>
								<div id="exam_type_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Class</label>
							<div class="col-sm-8">
							<select name="class_name" id="class_name" class="form-control" multiple>
								<option value="">Select Class</option>
								<?php foreach($class as $clas){?>
								<option value="<?php echo $clas['c_id'];?>"><?php echo $clas['class_name'];?></option>
								<?php }?>
							</select>
								<div id="class_name_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					       <div class="form-group">
							<label class="control-label col-md-2">Class Attendace</label>
							<div class="col-sm-8">
								<input type="text" name="class_attendace" id="class_attendace" class="form-control">
							<div id="class_attendace_err" style="display:none; color:red;"></div>
							</div>
					    </div>
            
		  			<div class="box-footer">
                      	<div class="col-sm-offset-8">
                      		<button type="button" name="submit_session" id="submit_attendace" class="btn btn-info hide btn_update">Update</button>
                            <button type="button" name="submit_session" id="submit_attendace" class="btn btn-info btn_submit">Submit</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
        			</div>
        		</div><!-- end box body -->
     			</div>
   			</div>
   			
    	<div class="col-md-6">
    		<div class="box box-primary">
            	<div class="box-header">
                      <h3 class="box-title">Class Attendance List</h3>
                </div>
    			<div class="box-body">
    				<div class="form-group">
        				<table class="table table-responsive">
            				<thead>
            					<tr>
            						<th>Sr. No.</th>
            						<th>Medium</th>
            						<th>Term</th>
            						<th>Class</th>
            						<th>Total Days</th>
            						<th>Action</th>
            					</tr>
            				</thead>
            				<tbody id="list_of_attendance"></tbody>
        				</table> 
    				</div>
    			</div>
    		</div>
		</div>	
		</div>
	</section>	
</div>