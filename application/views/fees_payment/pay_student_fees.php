<div class="content-wrapper">
    <section class="content-header">
      <h1>Session<small>master</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
        <li class="active">Session master</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/pay_fees.js"></script>
    <!-- Main content -->
    <section class="content">
    	<div class="row">
        <div class="col-md-4">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Search Students</h3>
                </div>
            	<div class="box-body">
            	<form action="" method="POST" role="form" class="form-horizontal" id="pay_student_fees">
                		<input type="hidden" name="id" id="id">
           
    					    <div class="form-group">
    							<div class="col-sm-12">
    								<select name="medium" id="medium" class="form-control">
    									<option value="">Select Medium</option>
    									<?php foreach($medium as $med){?>
    									<option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
    									<?php }?>
    								</select>
    								<div id="medium_err" style="display:none; color:red;"></div>
    							</div>
    					    </div>
    					    
    					    <div class="form-group">
    							<div class="col-sm-12">
    								<select name="class_name" id="class_name" class="form-control">
    									<option value="">Select Class</option>
    									<?php foreach($class as $cls){?>
    										<option value="<?php echo $cls['c_id'];?>"><?php echo $cls['class_name'];?></option>
    									<?php }?>
    								</select>
    								<div id="class_name_err" style="display:none; color:red;"></div>
    							</div>
    					    </div>
    					    
    					        <div class="form-group" id="sub_group_row" style="display:none;">
    							<div class="col-sm-12">
    								<select name="sub_group" id="sub_group" class="form-control">
    									<option value="">Select Subject Group</option>
    									<?php foreach($group as $sub_group){?>
    									<option value="<?php echo $sub_group['sg_id'];?>"><?php echo $sub_group['sg_name'];?></option>
    									<?php }?>
    								</select>
    								<div id="sub_group_err" style="display:none; color:red;"></div>
    							</div>
    					    </div>
    					    
    					    <div class="form-group">    							
    							<div class="col-sm-12">
    								<select name="section" id="section" class="form-control">
    									<option value="">Select Section</option>
    									<?php foreach($section as $sec){?>
    										<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
    									<?php }?>
    								</select>
    								<div id="section_err" style="display:none; color:red;"></div>
    							</div>
    					    </div>
    					   
    					   <div class="form-group">
    							<div class="col-sm-12">
    								<select id="fees_type" name="fees_type" class="form-control">
    									<option value="">Select Fees Type</option>
    									<?php foreach ($fees_type as $ft){?>
    									<option value="<?php echo $ft['ft_id'];?>"><?php echo $ft['ft_name'];?></option>
    									<?php }?>
    								</select>
    								<div id="fees_type_err" style="display:none; color:red;"></div>
    							</div>
    					    </div>
    					    
    					     <div class="form-group" id="month_row" style="display: none;">
    							<div class="col-sm-12">
    								<select name="month" id="month" class="form-control">
    								<option value="">Select Month</option>
    								<?php foreach($month as $months){?>
    									<option value="<?php echo $months['m_id'];?>"><?php echo $months['m_name'];?></option>
    								<?php }?>
    								</select>
    								<div id="month_err" style="display:none; color:red;"></div>
    							</div>
    					    </div>
    			
    		  			<div class="box-footer">
                          	<div class="col-sm-offset-7">
                          		<button type="button" id="search" class="btn btn-info">Search</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
            			</div>
        			</form>
        		</div><!-- end box body -->
     			</div>
   			</div>
   			
   			<div class="col-md-8">
   				<div class="box box-info">
                	<div class="box-header">
                  		<h3 class="box-title">List of Students</h3>
                	</div>
                    	<table class="table table-responsive" id="table_data">
                        </table>
                        
                    <div class="box-footer">
                          	<div class="col-sm-offset-7">
                          		<button type="button" id="submit" class="btn btn-info hide">submit</button>
                            </div>
            			</div>  
                </div>
   			</div>
   			
		</div>
	</section>	
</div>