<div class="content-wrapper">
    <section class="content-header">
      <h1>Add Teacher</h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
        <li class="active">add teacher</li>
      </ol>
    </section>
    <script src="<?php echo base_url();?>assets/js/custom/add_teacher.js"></script>
    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Add Teacher & Assign Class Teacher</h3>
                </div>
            	<div class="box-body">
            	<form method="POST" class="form-horizontal" id="teacher_form" role="form">
            			<input type="hidden" name="t_id" id="t_id">
					    <input type="hidden" name="ct_id" id="ct_id">
					    <div class="form-group">
					    	<label class="control-label col-md-2">Class Teacher</label>
							<div class="col-sm-8">
								<input type="radio" name="is_class_teacher" id="is_class_teacher" value="yes" class="yes_check" checked>Yes
								<input type="radio" name="is_class_teacher" id="is_class_teacher" class="no_check" value="no">No	
							</div>
					    </div>
					    
					    <div class="form-group" id="medium_div">
							<label class="control-label col-md-2">Medium</label>
							<div class="col-sm-8">
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
									<option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
									<?php }?>
								</select>
								<div id="medium_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group" id="class_div">
							<label class="control-label col-md-2">Class</label>
							<div class="col-sm-8">
								<select name="class" id="class" class="form-control">
									<option value="">Select Class</option>
									<?php foreach($class as $cls){?>
										<option value="<?php echo $cls['c_id'];?>"><?php echo $cls['class_name'];?></option>
									<?php }?>
								</select>
								<div id="class_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group" id="sub_group_form" style="display:none;">
							<label class="control-label col-md-2">Subject Group</label>
							<div class="col-sm-8">
								<select name="sub_group" id="sub_group" class="form-control">
									<option value="">Select Subject Group</option>
									<?php foreach ($sub_gorup as $subject_group){?>
										<option value="<?php echo $subject_group['sg_id'];?>"><?php echo $subject_group['sg_name'];?></option>
									<?php }?>
								</select>
								<div id="sub_group_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group"id="section_div">
							<label class="control-label col-md-2">Section</label>
							<div class="col-sm-8">
								<select name="section" id="section" class="form-control">
									<option value="">Select Section</option>
									<?php foreach ($section as $sec){?>
										<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
									<?php }?>
								</select>
								<div id="section_err" style="display: none; color:red;"></div>
							</div>
					    </div>
	
	    <div class="col-sm-12" style="text-align:center; background-color:#00a65a;"><strong>Profile Section</strong></div><br/><br/>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Teacher Name</label>
							<div class="col-sm-8">
								<input type="text" name="teacher_name" id="teacher_name" class="form-control only_text" placeholder="Enter Teacher Name">
								<div id="staff_name_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Gender</label>
							<div class="col-sm-8">
								<select name="gender" id="gender" class="form-control">
									<option value="">Select Gender</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
								<div id="gender_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					      <div class="form-group">
							<label class="control-label col-md-2">DOB</label>
							<div class="col-sm-8">
								<input type="date" name="dob" id="dob" class="form-control" placeholder="date of birth">
								<div id="dob_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Phone</label>
							<div class="col-sm-8">
								<input type="text" name="phone" id="phone" class="form-control" placeholder="Contact Number">
								<div id="phone_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Email</label>
							<div class="col-sm-8">
								<input type="text" name="email" id="email" class="form-control" placeholder="Enter Email Id">
								<div id="email_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Permanent Address</label>
							<div class="col-sm-8">
								<textarea name="prmt_address" id="prmt_address" rows="" cols="" placeholder="Permanent Address" class="form-control"></textarea>
								<div id="prmt_address_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Alternet Address</label>
							<div class="col-sm-8">
								<textarea name="alter_address" id="alter_address" rows="" cols="" placeholder="Alternet Address" class="form-control"></textarea>
								<div id="alter_address_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
				 		<div class="form-group">
							<label class="control-label col-md-2">Designation</label>
							<div class="col-sm-8">
								<input type="text" name="designation" id="designation" placeholder="Enter Designation" class="form-control only_text">
								<div id="designation_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Qualifications</label>
							<div class="col-sm-8">
								<input type="text" name="qualifications" id="qualifications" placeholder="Enter Qualifications" class="form-control">
								<div id="qualifications_err" style="display: none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Image</label>
							<div class="col-sm-8">
								<input type="hidden" name="old_image" id="old_image">
								<div id="edit_preview"></div>
								<input type="file" name="image" id="image" class="form-control">
								<div id="image_err" style="color: red;"></div>
							</div>
					    </div>
				 		
    		  			<div class="box-footer">
                          	<div class="col-sm-offset-8">
                          		<button type="button" id="submit_teacher" class="btn btn-info hide teacher_update">Update</button>
                                <button type="button" id="submit_teacher" class="btn btn-info teacher_submit">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
            			</div>
            			</form>
            			
        			</div><!-- end box body -->
     			</div>
   			</div>
   			
          	<div class="col-md-6">	
          		<div class="box box-danger">
                	<div class="box-header">
                  		<h3 class="box-title">List of Teachers</h3>
                	</div>
                	<table id="example1" class="table table-bordered table-striped">
                		<thead>
                			<tr>
                				<th>Sr No.</th>
                				<th>Teacher Name</th>
                				<th>Phone</th>
                				<th>Designation</th>
                				<!-- <th>Image</th> -->
                				<th>Action</th>
                			</tr>
                			</thead>
                			<tbody>
                    				<?php $i = 1;
                    				foreach($teachers as $teacher){?>
                    				<tr>
                    				<td><?php echo $i++;?></td>
                    				<td><?php echo $teacher['teacher_name'];?></td>
                    				<td><?php echo $teacher['phone'];?></td>
                    				<td><?php echo $teacher['designation'];?></td>
                    				
                    				<?php 
                    				$path = base_url().'assets/images/sharda/teachers/';
                    				if($this->session->userdata('school_id') == 1){
                    				    $path = base_url().'assets/images/shakuntala/teachers/';
                    				}
                    				?>
                    				
                    				<!-- <td><?php if(!empty($teacher['image'])&& file_exists("$path".$teacher['image'])){?>
                                     <img src="<?php echo $path;?><?php echo $teacher['image'];?>" style="height:50px;" width="50px;">
                                	<?php }else{ echo "NULL"; } ?></td> -->
                    				<td><button type="button" id="<?php echo $teacher['t_id']?>" class="btn btn-primary btn-sm edit"><span class="glyphicon glyphicon-edit"></span> Edit </button> &nbsp;
		    					        <button type="button" id="<?php echo $teacher['t_id']?>" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span> Delete </button></td>
                    				</tr>
                    				<?php }?>
                			</tbody>
                	</table>
              		</div>   
     			</div>
   			</div>
	</section>	
</div>
<input type="hidden" id="path" value="<?php echo $path;?>">
