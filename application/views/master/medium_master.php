<div class="content-wrapper">
    <section class="content-header">
      <h1>Medium<small>master</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">medium master</li>
      </ol>
    </section>
<script src="<?php echo base_url();?>assets/js/custom/medium_master.js"></script>
<!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Add Medium</h3>
                </div>
            	<div class="box-body form-horizontal">
            			<input type="hidden" name="id" id="id">
					    <div class="form-group">
							<label class="control-label col-md-2">Medium Name </label>
							<div class="col-sm-8">
								<?php echo form_input(['name'=>'medium_name','id'=>'medium_name','class'=>'form-control','placeholder'=>'Enter Medium Name','value'=>'']);?>
								<div id="medium_name_err" style="color: red; display: none;"></div>
							</div>
					    </div>
			
    		  			<div class="box-footer">
                          	<div class="col-sm-offset-8">
                          		<button type="button" id="submit_medium" class="btn btn-info hide btn_update">Update</button>
                                <button type="button" id="submit_medium" class="btn btn-info btn_submit">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
            			</div>
        			</div><!-- end box body -->
     			</div>
   			</div>
   			
       		<div class="col-md-6">	
              	<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">Medium List</h3>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    						<thead>
            					<tr>
                    				<th>Sr No.</th>
                    				<th>Medium Name</th>
                    				<th>Action</th>
            					</tr>
        					</thead>
    						<tbody id="medium_list"></tbody>
    					</table>
              		</div>
         		</div>
       		</div>
          
          </div>
	</section>	
</div>