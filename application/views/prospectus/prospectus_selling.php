<div class="content-wrapper">
    <section class="content-header">
      <h1>Reception<small>Prospectus Selling</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Prospectus Selling</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/prospectus.js"></script>
    <!-- Main content -->
	<section class="content">
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Prospectus</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			
			<form role="form" class="form-horizontal" id="prospectus_form" method="POST">
			<div class="box-body">
                
				<div class="form-group">
					<label class="col-sm-3 control-label">Registration No.<span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<input type="text" name="reg_no" id="reg_no" class="form-control only_text" value="<?php echo $reg_no[0]['reg_no'];?>" placeholder="Enter Registration Number" />
							<div id="reg_no_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Selling Date<span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<input type="date" name="selling_date" id="selling_date" class="form-control" value="<?php echo date('Y-m-d');?>" />
							<div id="selling_date_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Board <span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<select class="form-control" name="school" id="school">
								<option value="">Select Board</option>
								<option value="1">CBSE</option>
								<option value="3">State Board</option>
							</select>
							<div id="school_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Medium <span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<select class="form-control" name="medium" id="medium">
								<option value="">Select Medium</option>
								<?php foreach($medium as $med){?>
								    <option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
								<?php }?>
							</select>
							<div id="medium_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
					
				<div class="form-group">
					<label class="col-sm-3 control-label">Class <span style="color:red;">*</span></label>
					<div class="col-sm-6">
						<select class="form-control" name="class_id" id="class_id">
							<option value="">Select Class</option>
							<?php foreach($class as $classes){?>
								<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
							<?php } ?>
						</select>
						<div id="class_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Name <span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<input type="text" name="name" id="name" class="form-control only_text" placeholder="Enter Name" />
							<div id="name_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Contact No. <span style="color:red;">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="phone" id="phone" max="10" class="form-control only_int" placeholder="Enter Contact No." />
						<div id="phone_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-3 control-label">Alternate Mobile No. <span style="color:red;">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="alternate_no" max="10" id="alternate_no" class="form-control only_int" placeholder="Alternate Mobile Number" />
						<div id="alternate_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Address <span style="color:red;">*</span></label>
					<div class="col-sm-6">
						<textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter Address"></textarea>
						<div id="address_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
			</div>
					<div class="box-footer text-center">
                        <button type="button" id="submit" class="btn btn-info">Submit</button>
        			</div>
			</form>
		</div>
        </section>
</div>

<input type="hidden" id="user_url" name="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>"/>
