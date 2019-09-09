<div class="content-wrapper">
    <section class="content-header">
      <h1>Marks Entry Check<small></small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="">Production Reports</li>
        <li class="active">Marks Entry Check</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/marks_entry_check.js"></script>
    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Add School</h3>
                </div>
            	<div class="box-body">
            		<?php echo form_open("",['class'=>'form-horizontal','id'=>"marks_entry_check",'role'=>"form"]);?>
            			<input type="hidden" name="id" id="id">
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Exam Type</label>
							<div class="col-sm-8">
								<select name="exam_type" id="exam_type" class="form-control">
									<option value="">Select Exam Type</option>
									<?php foreach($exam_type as $et){?>
										<option value="<?php echo $et['et_id'];?>"><?php echo $et['et_name'];?></option>
									<?php }?>
								</select>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Medium</label>
							<div class="col-sm-8">
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
									<option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
									<?php }?>
								</select>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Class</label>
							<div class="col-sm-8">
								<select name="class" id="class" class="form-control">
									<option value="">Select Class</option>
									<?php foreach($class as $classes){?>
									<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
									<?php }?>
								</select>
							</div>
					    </div>
					    
					    <div class="form-group" id="sub_group_form" style="display:none;">
							<label class="control-label col-md-2">Subject Group</label>
							<div class="col-sm-8">
								<select name="sub_group" id="sub_group" class="form-control">
									<option value="">Select Subject Group</option>
									<?php foreach($group as $sub_group){?>
									<option value="<?php echo $sub_group['sg_id'];?>"><?php echo $sub_group['sg_name'];?></option>
									<?php }?>
								</select>
							</div>
							<div id="sub_group_err" style="display:none; color:red;"></div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Subject Section</label>
							<div class="col-sm-8">
								<select name="section" id="section" class="form-control">
									<option value="">Select Section</option>
									<?php foreach($section as $sections){?>
									<option value="<?php echo $sections['sec_id'];?>"><?php echo $sections['section_name'];?></option>
									<?php }?>
								</select>
							</div>
					    </div>
			
		  				<div class="box-footer">
                      	<div class="text-center">
                            <button type="button" id="search" class="btn btn-space btn-info btn_submit">Search</button>
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
                    				<th>S.No.</th>
                    				<th>Subject Name</th>
                    				<th>Type</th>
                    				<th>Entry</th>
            					</tr>
        					</thead>
    						<tbody id="entry_check_list"></tbody>
    					</table>
              		</div>
         		</div>
       		</div>
          </div>
	</section>	
</div>