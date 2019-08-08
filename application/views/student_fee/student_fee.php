<style>
.skin-blue .main-header .navbar{padding:10px;}
.mb-3{margin-bottom:15px;}
</style>
<div class="content-wrapper">
<section class="content-header">
      <h1>Reception</h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Student Fee</li>
      </ol>
    </section>
    <section class="content-header">
    </section>
    	<script src="<?php echo base_url();?>assets/js/custom/student_fee.js"></script>
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
							<div class="col-md-2 mb-3" style="padding:0px 0px;">
								<button type="button" name="search" id="search" class="btn btn-info pull-left">Search</button>
								<button style="margin-left:10px;" type="reset" class="btn btn-default pull-left">Reset</button>
								
							</div>
					    </div>
						 
					    <div class="col-sm-6 mb-3" style="padding-left:0px;">
							<input type="text" id="search_box" name="search_box" class="form-control" placeholder="Enter Admission Number">	
						</div>
					   
            		</form>	
        		</div><!-- end box body -->
     			</div>
				
				<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">Search Results</h3>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    							<thead><tr>
    							<th>S No.</th>
                                  <th>Admission No.</th>
                                  <th>Class/ Section</th>
                                  <th>Student Name</th>
                                  <th>Father's Name</th>
								  <th>Subject Group</th>
                                  <th>Contact No.</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                            </thead>
    						<tbody id="student_list"></tbody>
    					</table>
              		</div>
         		</div>
   			</div>
   			<div class="col-md-12" id="fee-detail-box" style="display: none;">	
              	<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">Fee Detail</h3>
                    </div>
              		    <div class="box-body" id="fee-detail">					
              		</div>
         		</div>
   			</div>   			
		</div>