<div class="content-wrapper">
<section class="content-header">
      <h1>Reception <small>Student Classwise Fee</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Student Classwise Fee</li>
      </ol>
    </section>
    <section class="content-header">
    </section>

    	<!-- main section -->
        <div class="col-md-12">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Student Filter</h3>
                </div>
            	<div class="box-body form-horizontal">
            	<form id="fee_form" action="javascript:void(0);" method="POST" role="form">
            	
            	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
            	
              			<div class="form-group" style="margin-bottom:0px;">
              				<div class="col-sm-2 mb-3">
								<select name="session" id="session" class="form-control">
									<option value="0">Select Session</option>
									<option value="3" selected>2019-20</option>
								</select>
								<div id="session_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-2 mb-3">
								<select name="school" id="school" class="form-control">
									<option value="">Select Board</option>
    								<option value="1" selected>CBSE</option>
    								<option value="3">CG State Board</option>
								</select>
								<div id="school_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-2 mb-3">
								<select name="school" id="" class="form-control">
									<option value="">Select School Name</option>
    								<option value="1" selected>Shakuntala Vidyalaya</option>
    								<option value="2">Shakuntala Vidyalaya No.2</option>
    								<option value="3">Sharda Vidyalaya</option>
								</select>
								<div id="school_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-2 mb-3" >
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
								    <option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
								<?php }?>
								</select>
								<div id="medium_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-2 mb-3">
								<select class="form-control" id="class_name" name="class_name">
									<option value="">Select Class</option>
									<?php foreach($class as $classes){?>
        								<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
        							<?php } ?>
								</select>
								<div id="class_name_err" style="display:none; color:red;"></div>
							</div>
							
							<div class="col-sm-2 mb-3">
								<select name="section" id="section" class="form-control">
									<option value="">Select Section</option>
									<?php foreach($section as $sec){?>
            							<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
            						<?php }?>
								</select>
								<div id="section_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-md-2 mb-3">
								<button type="button" name="search" id="search" class="btn btn-info pull-left">Search</button>	
							</div>
					    </div>
					   
            		</form>	
        		</div><!-- end box body -->
     			</div>
				
				<div class="box box-primary">
					<div class="box-body text-center" style="font-size:18px;color:#e24e08;">
						<div class="col-md-4" style="border-right:1px solid #ddd;">
							<b style="color:#5d5c5c;">Received Fee</b><br>
							<b>Rs. 4500.00/-</b>
						</div>
						<div class="col-md-4" style="border-right:1px solid #ddd;">
							<b style="color:#5d5c5c;">Pending Fee</b><br>
							<b>Rs. 5500.00/-</b>
						</div>
						<div class="col-md-4">
							<b style="color:#5d5c5c;">Total Fee</b><br>
							<b>Rs. 10000.00/-</b>
						</div>
					</div>
				</div>
			
				
				
				
				<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title"><b>Shakuntala Vidyalaya XI/B (Math) Fee List</b></h3>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    							<thead><tr>
    							<th>S.No.</th>
								<th>Admission No.</th>
								<th>Student Name</th>
                                  <th>Father's Name</th>
                                  <th>Pending Fee</th>
                                  <th>Received Fee</th>
                                  <th>Total Fee</th>
                                  <th>Action</th>
                                </tr>
                            </thead>
    						<tbody id="">
								<tr>
									<td>1.</td>
									<td>1515</td>
									<td>Nitesh kumar</td>
									<td>Mr. Sankar</td>
									<td>2502.00</td>
									<td>3502.00</td>
									<td>6002.00</td>
									<th><a href="<?php echo base_url();?>shakuntala/reception/report/student/123" class="btn btn-sm btn-info" target="_blank">View Details</a></th>
								</tr>
							</tbody>
    					</table>
              		</div>
         		</div>
   			</div>
   			   			
		</div>