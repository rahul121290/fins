<div class="content-wrapper">
    <section class="content-header">
      <h1>Subject<small>master</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
        <li class="active">subject master</li>
      </ol>
    </section>
<script src="<?php echo base_url();?>assets/js/custom/subject_master.js"></script>
<!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Add Subject</h3>
                </div>
            	<div class="box-body form-horizontal">
            			<input type="hidden" name="sub_id" id="sub_id">
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Subject Type</label>
							<div class="col-sm-8">
								<select name="sub_type" id="sub_type" class="form-control">
								<option value="">Select Subject Type</option>
									<?php foreach ($sub_type as $s_type){?>
										<option value="<?php echo $s_type['st_id'];?>"><?php echo $s_type['st_name'];?></option>
									<?php } ?>
								</select>
								<div id="sub_type_err" style="color: red; display:none;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Subject Name</label>
							<div class="col-sm-8">
								<?php echo form_input(['name'=>'subject_name','id'=>'subject_name','class'=>'form-control','placeholder'=>'Enter Subject Name','value'=>'']);?>
								<div id="sub_name_err" style="color: red; display:none;"></div>
							</div>
					    </div>
					    
					    	<div class="form-group">
							<label class="control-label col-md-2">Short Order</label>
							<div class="col-sm-8">
								<?php echo form_input(['name'=>'short_order','id'=>'short_order','class'=>'form-control','placeholder'=>'Enter Short Order','value'=>'']);?>
								<div id="short_order_err" style="color: red; display:none;"></div>
							</div>
					    </div>
			
    		  			<div class="box-footer">
                          	<div class="col-sm-offset-8">
                          		<button type="button" id="submit_subject" class="btn btn-info hide subject_update">Update</button>
                                <button type="button" id="submit_subject" class="btn btn-info subject_submit">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
            			</div>
            			
              		     <div class="box-body">
          					<table class="table table-responsive">
    						<thead>
            					<tr>
                    				<th>Sr No.</th>
                    				<th>Subject Type</th>
                    				<th>Subject Name</th>
                    				<th>Short Order</th>
                    				<th>Action</th>
            					</tr>
        					</thead>
    						<tbody id="subject_list"></tbody>
    					</table>
              		</div>            			
        			</div><!-- end box body -->
     			</div>
   			</div>
   		
		<div class="col-md-6">	
          	<div class="box box-warning">
                <div class="box-header">
                  <h3 class="box-title">Add Subject Type</h3>
                </div>
            	<div class="box-body form-horizontal">
            			<input type="hidden" name="st_id" id="st_id">
					    <div class="form-group">
							<label class="control-label col-md-2">Subject Type</label>
							<div class="col-sm-8">
								<?php echo form_input(['name'=>'st_name','id'=>'st_name','class'=>'form-control','placeholder'=>'Enter Subject Type','value'=>'']);?>
								<div id="st_name_err" style="color: red; display:none;"></div>
							</div>
					    </div>
			
    		  			<div class="box-footer">
                          	<div class="col-sm-offset-8">
                          		<button type="button" id="submit_sub_type" class="btn btn-info hide btn_update_sub_type">Update</button>
                                <button type="button" id="submit_sub_type" class="btn btn-info btn_submit_sub_type">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
            			</div>
            			     <div class="box-body">
          					<table class="table table-responsive">
    						<thead>
            					<tr>
                    				<th>Sr No.</th>
                    				<th>Subject Type</th>
                    				<th>Action</th>
            					</tr>
        					</thead>
    						<tbody id="st_list"></tbody>
    					</table>
              		</div>
        			</div><!-- end box body -->        			
     			</div>
   			</div>
  			
       		<div class="col-md-6">	
          	<div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Add Subject Group</h3>
                </div>
            	<div class="box-body form-horizontal">
            			<input type="hidden" name="sg_id" id="sg_id">
					    <div class="form-group">
							<label class="control-label col-md-2">Subject Group</label>
							<div class="col-sm-8">
								<?php echo form_input(['name'=>'sg_name','id'=>'sg_name','class'=>'form-control','placeholder'=>'Enter Subject Group','value'=>'']);?>
								<div id="sg_name_err" style="color: red; display:none;"></div>
							</div>
					    </div>
			
    		  			<div class="box-footer">
                          	<div class="col-sm-offset-8">
                          		<button type="button" id="submit_sub_group" class="btn btn-info hide update_sub_group">Update</button>
                                <button type="button" id="submit_sub_group" class="btn btn-info submit_sub_group">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
            			</div>
            			     <div class="box-body">
          					<table class="table table-responsive">
    						<thead>
            					<tr>
                    				<th>Sr No.</th>
                    				<th>Subject Group</th>
                    				<th>Action</th>
            					</tr>
        					</thead>
    						<tbody id="sub_group_list"></tbody>
    					</table>
              		</div>
            			
        			</div><!-- end box body -->
     			</div>
   			</div>
          </div>  
	</section>	
</div>