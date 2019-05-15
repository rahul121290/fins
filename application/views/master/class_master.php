<div class="content-wrapper">
    <section class="content-header">
      <h1>Class<small>master</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
        <li class="active">class master</li>
      </ol>
    </section>
<script src="<?php echo base_url();?>assets/js/custom/class_master.js"></script>    
<!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Add Class</h3>
                </div>
            	<div class="box-body form-horizontal">
            			<input type="hidden" name="id" id="id">
					    <div class="form-group">
							<label class="control-label col-md-2">Class Name</label>
							<div class="col-sm-8">
								<?php echo form_input(['name'=>'class_name','id'=>'class_name','class'=>'form-control','placeholder'=>'Enter Class Name','value'=>'']);?>
								<div id="class_name_err" style="color: red; display:none;"></div>
							</div>
					    </div>
			
    		  			<div class="box-footer">
                          	<div class="col-sm-offset-8">
                          		<button type="button" id="submit_class" class="btn btn-info hide btn_update">Update</button>
                                <button type="button" id="submit_class" class="btn btn-info btn_submit">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
            			</div>
        			</div><!-- end box body -->
     			</div>
   			</div>
   			
   			<div class="col-md-6">	
          	<div class="box box-warning">
                <div class="box-header">
                  <h3 class="box-title">Add Section</h3>
                </div>
            	<div class="box-body form-horizontal">
            			<input type="hidden" name="sectionid" id="sectionid">
					    <div class="form-group">
							<label class="control-label col-md-2">Section Name</label>
							<div class="col-sm-8">
								<?php echo form_input(['name'=>'section_name','id'=>'section_name','class'=>'form-control','placeholder'=>'Enter Section Name','value'=>'']);?>
								<div id="section_name_err" style="color: red; display:none;"></div>
							</div>
					    </div>
			
    		  			<div class="box-footer">
                          	<div class="col-sm-offset-8">
                          		<button type="button" id="submit_section" class="btn btn-info hide btn_update_sec">Update</button>
                                <button type="button" id="submit_section" class="btn btn-info btn_submit_sec">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
            			</div>
        			</div><!-- end box body -->
     			</div>
   			</div>
   			
       		<div class="col-md-6">	
              	<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">Class List</h3>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    						<thead>
            					<tr>
                    				<th>Sr No.</th>
                    				<th>Class Name</th>
                    				<th>Action</th>
            					</tr>
        					</thead>
    						<tbody id="class_list"></tbody>
    					</table>
              		</div>
         		</div>
       		</div>
       		  			 
  				<div class="col-md-6">	
              	<div class="box box-success">
                    <div class="box-header">
                      <h3 class="box-title">Section List</h3>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    						<thead>
            					<tr>
                    				<th>Sr No.</th>
                    				<th>Section Name</th>
                    				<th>Action</th>
            					</tr>
        					</thead>
    						<tbody id="section_list"></tbody>
    					</table>
              		</div>
         		</div>
       		</div>	
       		
          </div>  
	</section>	
</div>