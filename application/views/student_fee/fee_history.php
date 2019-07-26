<script type="text/javascript" src="<?php echo base_url();?>assets/js/custom/fee_history.js"></script>
<div class="content-wrapper fee-print">
	<section class="content-header">
      <h1>Reception</h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">fee history</li>
      </ol>
    </section>
    <section class="content-header "></section>
    	<!-- main section -->
        <div class="col-md-3 no-print">	
          	<div class="box box-danger">
                <div class="box-header">
                	<h3 class="box-title">Student Fee Filter</h3>
                </div>
                <form action="javascript:void(0);" id="fee_history_form" role="form">
            	<div class="box-body form-horizontal">
              			
						<div class="form-group" style="margin-bottom:0px;">
							<div class="col-sm-12 mb-3" >
							<input type="text" id="search_box" name="search_box" class="form-control" placeholder="Enter Admission Number">	
						</div>
              				<div class="col-sm-12 mb-3">
								<select name="session" id="session" class="form-control">
									<option value="">Select Session</option>
									<?php foreach($session as $ses){?>
										<option value="<?php echo $ses['ses_id'];?>" <?php if($ses['ses_id'] == $this->session->userdata('session_id')){echo "selected";}?>><?php echo $ses['session_name'];?></option>
									<?php } ?>
								</select>
								<div id="session_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-12 mb-3">
								<select name="school" id="school" class="form-control">
									<option value="">Select School</option>
									<?php foreach($school as $school){?>
										<option value="<?php echo $school['sch_id'];?>" selected><?php echo $school['school_name'];?></option>
									<?php } ?>
									<option value="3">CG</option>
								</select>
								<div id="school_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-12 mb-3">
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
								    <option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
								<?php }?>
								</select>
								<div id="medium_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-12 mb-3">
								<select class="form-control" id="class_name" name="class_name">
									<option value="">Select Class</option>
									<?php foreach($class as $classes){?>
        								<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
        							<?php } ?>
								</select>
								<div id="class_name_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-12 mb-3" id="sub_group_table" style="display:none;">
								<select name="sub_group" id="sub_group" class="form-control">
									<option value="">Select Subject Group</option>
									<?php foreach($sub_group as $groups){?>
            							<option value="<?php echo $groups['sg_id'];?>"><?php echo $groups['sg_name'];?></option>
            						<?php } ?>
								</select>
								<div id="sub_group_err" style="display:none; color:red;"></div>
							</div>
							
							<div class="col-sm-12 mb-3">
								<select class="form-control" id="fee_status" name="fee_status">
									<option value="">Select Fee Status</option>
									<option value="1">Paid</option>
									<option value="0">Pending</option>
								</select>
							</div>
							
							<div class="col-sm-12 mb-3">
								<select class="form-control" id="fee_waiver" name="fee_waiver">
									<option value="">Select Fee Waiver</option>
									<option value="yes">Yes</option>
								</select>
							</div>
							
							<div class="col-sm-12 mb-3">
								<input type="date" name="form_date" id="from_date" class="form-control">
							</div>
							
							<div class="col-sm-12 mb-3">
								<input type="date" name="to_date" id="to_date" class="form-control">
							</div>
							
					    </div>
					    
						<div id="search_box_err"></div>
					    <div class="box-footer col-md-12" style="padding:0px 0px;">
                  			<button type="button" id="search_fee_history" class="btn btn-info pull-left">Search</button>
							<button style="margin-left:10px;" type="reset" class="btn btn-default pull-left">Reset</button>
                        	
        				</div>
        		</div><!-- end box body -->
        		</form>
     			</div>
			</div>
			
			<div class="col-md-9 student-fee-record">
				<h3 style="margin-top:0px;" class="text-center desk-hide">Shakuntala Vidyalaya Session 2019-20</h3>
				<!-- <div class="box box-info desk-hide">
                 		     <div class="box-body">
					<table class="table">
						<tbody>
							<tr><td>Class</td><td>: V</td><td>Medium</td><td>: English</td></tr>
							<tr><td>From Date</td><td>: 12-02-19</td><td>To Date</td><td>: 12-05-19</td></tr>
							<tr><td>Print Date</td><td>: 12-07-19</td><td>Session</td><td>: 2019-20</td></tr>
						</tbody>
					</table>
					</div>
				</div> -->
				<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">Fee Details</h3>
                      
                    </div>
              		     <div class="box-body">
              		     	<table class="table">
              		     		<tbody>
              		     			<tr>
              		     				<td><b>Total Amount</b></td>
              		     				<td>: <span id="total_amount"></span></td>
										<td><b>Collected Amount</b></td>
              		     				<td>: <span id="collected_amount"></span></td>
              		     			</tr>

              		     			
              		     			<tr>
              		     				<td><b>Fee Waiver</b></td>
              		     				<td>: <span id="fee_waiver_show"></span></td>
										<td><b>Pending Amount</b></td>
              		     				<td>: <span id="pending_amount"></span></td>
              		     			</tr>
              		     			
              		     		</tbody>
              		     	</table>
              			</div>
         		</div>
				
				<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">Student Fee List</h3>
                    </div>
              		     <div class="box-body  table-responsive">
          					<table class="table student-fee-list">
    							<thead><tr>
    							  <th>S No.</th>
                                  <th>Admission No.</th>
                                  <th>Student Name</th>
                                  <th>Class/ Section</th>
                                  <th>Contact No.</th>
                                  <th>Amount</th>
                                  <th>Status</th>
                                </tr>
                            </thead>
    						<tbody id="student_list">
    							<tr><td colspan="8" class="text-center">No Record Found.</td></tr>
    						</tbody>
    					</table>
              		</div>
         		</div>
   			</div>   			
		</div>
		