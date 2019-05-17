<div class="content-wrapper">
    <section class="content-header">
      <h1>School<small>master</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
        <li class="active">school master</li>
      </ol>
    </section>
  <script src="<?php echo base_url();?>assets/js/custom/school_master.js"></script>
    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Add School</h3>
                </div>
            	<div class="box-body">
            		<?php echo form_open("",['class'=>'form-horizontal','id'=>"school_form",'role'=>"form"]);?>
            			<input type="hidden" name="id" id="id">
					    <div class="form-group">
							<label class="control-label col-md-2">School Name </label>
							<div class="col-sm-8">
								<?php echo form_input(['name'=>'school_name','id'=>'school_name','class'=>'form-control','placeholder'=>'Enter School Name','value'=>'']);?>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Address</label>
							<div class="col-sm-8">
								<?php echo form_textarea(['name'=>'address','id'=>'address','placeholder'=>'Enter Address','class'=>'form-control','rows'=>'3']);?>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Affiliation No</label>
							<div class="col-sm-8">
								<?php echo form_input(['name'=>'affiliation_no','id'=>'affiliation_no','placeholder'=>'Enter Affilation No','class'=>'form-control']);?>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">School No</label>
							<div class="col-sm-8">
								<?php echo form_input(['name'=>'school_no','id'=>'school_no','placeholder'=>'Enter School No','class'=>'form-control']);?>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Principal Name</label>
							<div class="col-sm-8">
								<?php echo form_input(['name'=>'principal_name','id'=>'principal_name','placeholder'=>'Enter Principal Name','class'=>'form-control']);?>
							</div>
					    </div>
					   
					    <div class="form-group">
							<label class="control-label col-md-2">Principal Sign</label>
							<div class="col-sm-8">
							     <input type="hidden" name="old_principal_image" id="old_principal_image">
							     <div id="sing_preview"></div>
								 <?php echo form_upload(['name'=>'principal_image','id'=>'principal_image','class'=>'form-control']);?>
								 <div id="principal_msg" style="color: red;"></div>
							</div>
					    </div>
					   
					    <div class="form-group">
							<label class="control-label col-md-2">School Logo</label>
							<div class="col-sm-8">
							     <input type="hidden" name="old_image" id="old_image">
							     <div id="edit_preview"></div>
								 <?php echo form_upload(['name'=>'school_image','id'=>'school_image','class'=>'form-control']);?>
								 <div id="msg" style="color: red;"></div>
							</div>
					    </div>
            
		  			<div class="box-footer">
                      	<div class="col-sm-offset-8">
                      		<button type="button" id="update_school" class="btn btn-info hide btn_update">Update</button>
                            <button type="button" id="submit_school" class="btn btn-info btn_submit">Submit</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
        			</div>
        			<?php echo form_close();?>
        			</div><!-- end box body -->
     			</div>
   			</div>
   			
       		<div class="col-md-6">	
              	<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">School List</h3>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    						<thead>
            					<tr>
                    				<th>Sr No.</th>
                    				<th>School Name</th>
                    				<th>Address</th>
                    				<th>Affiliation No</th>
                    				<th>School No</th>
                    				<th>Image</th>
                    				<th>Action</th>
            					</tr>
        					</thead>
    						<tbody id="school_list"></tbody>
    					</table>
              		</div>
         		</div>
       		</div>
<!--         	<div class="col-md-6"> -->
<!--         		<div class="box box-primary"> -->
<!--                 	<div class="box-header"> -->
<!--                           <h3 class="box-title">Set School</h3> -->
<!--                     </div> -->
<!--         			<div class="box-body"> -->
<!--         				<div class="form-group"> -->
<!--             					<div id="set_school"></div> -->
<!--         			</div> -->
<!--         		</div> -->
<!--         	</div> -->
<!--           </div> -->

          </div>
	</section>	
</div>