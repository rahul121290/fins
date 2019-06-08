<div class="content-wrapper">
    <section class="content-header">
      <h1>Student<small>Reports</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
        <li class="active">student reports</li>
      </ol>
    </section>
    	<script src="<?php echo base_url();?>assets/js/custom/student_records.js"></script>
    	<!-- main section -->
        <div class="col-md-12">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Search Records</h3>
                </div>
            	<div class="box-body form-horizontal">
            		
              			<div class="form-group">
							<div class="col-sm-3">
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
								    <option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
								<?php }?>
								</select>
								<div id="medium_err" style="display:none; color:red;"></div>
							</div>
							
							
							<div class="col-sm-3">
								<select class="form-control" id="class_name" name="class_name">
									<option value="">Select Class</option>
									<?php foreach($class as $classes){?>
        								<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
        							<?php } ?>
								</select>
								<div id="class_name_err" style="display:none; color:red;"></div>
							</div>
							
							<div class="col-sm-3" id="fit_table" style="display:none;">
								<select name="fit_value" id="fit_value" class="form-control">
									<option value="">Select Fit</option>
										<option value="yes">Yes</option>
										<option value="no">No</option>
								</select>
								<div id="fit_err" style="display:none; color:red;"></div>
							</div>
							
							<div class="col-sm-3" id="sub_group_table" style="display:none;">
								<select name="sub_group" id="sub_group" class="form-control">
									<option value="">Select Subject Group</option>
									<?php foreach($group as $groups){?>
            							<option value="<?php echo $groups['sg_id'];?>"><?php echo $groups['sg_name'];?></option>
            						<?php } ?>
								</select>
								<div id="sub_group_err" style="display:none; color:red;"></div>
							</div>
							
							<div class="col-sm-3">
								<select name="section" id="section" class="form-control">
									<option value="">Select Section</option>
									<?php foreach($section as $sec){?>
            							<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
            						<?php }?>
								</select>
								<div id="section_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="box-footer">
                      		<div class="col-sm-12">
                      			<button type="reset" class="btn btn-default pull-right">Reset</button>
                            	<button type="button" name="search" id="search" class="btn btn-info pull-right">Search</button>
                        	</div>
        				</div>
            			
            			<div class="col-sm-3">
							<input type="text" id="search_box" name="search_box" class="form-control" placeholder="Enter Admission Number">	
						</div>
        		</div><!-- end box body -->
     			</div>
   			</div>
   			
   			<div class="col-md-12">	
              	<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">Session List</h3>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    							<thead><tr>
                                  <th>S.No.</th>
                                  <th>Edit/Del.</th>
                                  <th>Image</th>
                                  <th>Admission No.</th>
                                  <th>Roll No.</th>
                                  <th>Class/ Section</th>
                                  <th>Fit</th>
                                  <th>Subject Group</th>
                                  <th>Elective Subject</th>
                                  <th>Student Name</th>
                                  <th>DOB</th>
                                  <th>Aadhar No</th>
                                  <th>Gender</th>
                                  <th>Father's Name</th>
                                  <th>Mother's Name</th>
                                  <th>Contact No.</th>
                                  <th>Admission Date</th>
                                  <th>Medium</th>
                                  <th>Tc</th>
                                </tr>
                            </thead>
    						<tbody id="student_list"></tbody>
    					</table>
              		</div>
         		</div>
   			</div>   			
		</div>

<!------------------------------------- Edit Section ----------------------------------------------- -->		
    <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Student Record.</h4>
              </div>
              <div class="modal-body">
    				<form id="student_form" role="form" class="form-horizontal" id="student_form" method="POST">
			<div class="box-body">
                <input type="hidden" id="std_id" name="std_id">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Admission No.</label>
                  <div class="col-sm-6">
					<input type="text" name="admission_no" id="admission_no" class="form-control">
					<div id="admission_no_err" style="display:none;color:red;"></div>
				</div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Roll No.</label>
                  <div class="col-sm-6">
					<input type="text" name="roll_no" id="roll_no" class="form-control">
					<div id="roll_no_err"	 style="display:none;color:red;"></div>
				  </div>
                </div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Student Name</label>
						<div class="col-sm-6">
							<input type="text" name="student_name" id="student_name" class="form-control">
							<div id="student_name_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Medium</label>
						<div class="col-sm-6">
							<select class="form-control" name="medium_modal" id="medium_modal">
								<option value="">Select Medium</option>
								<?php foreach($medium as $med){?>
								    <option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
								<?php }?>
							</select>
							<div id="medium_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
					
				<div class="form-group">
					<label class="col-sm-3 control-label">Class</label>
					<div class="col-sm-6">
						<select class="form-control" name="class" id="class">
							<option value="">Select Class</option>
							<?php foreach($class as $classes){?>
								<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
							<?php } ?>
						</select>
						<div id="class_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Section</label>
					<div class="col-sm-6">
					<select class="form-control" name="section_modal" id="section_modal">
						<option value="">Select Section</option>
						<?php foreach($section as $sec){?>
						<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
						<?php }?>
					</select>
					<div id="section_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group" id="fit_section">
                    <label class="col-sm-3 control-label">FIT</label>
					<div class="col-sm-6">
					<select class="form-control" name="fit" id="fit">
						<option value="">Select FIT</option>
						    <option value="Yes">Yes</option>
							<option value="No">No</option>
					</select>
					<div id="fit_err" style="display:none; color:red;"></div>
					</div>
				</div>
				
				<div class="form-group" id="elective_section">
                    <label class="col-sm-3 control-label">Elective Subject</label>
					<div class="col-sm-6">
					<select class="form-control" name="elective_subject" id="elective_subject">
						<option value="">Select Elective Subject</option>
						<?php foreach($elective as $elect){?>
						<option value="<?php echo $elect['sub_id'];?>"><?php echo $elect['sub_name'];?></option>
						<?php }?>
					</select>
					<div id="elective_subject_err" style="display:none; color:red;"></div>
					</div>
				</div>
				
				<div class="form-group" id="sub_group_section">
                    <label class="col-sm-3 control-label">Subject Group</label>
					<div class="col-sm-6">
					<select class="form-control" name="subject_group_modal" id="subject_group_modal">
						<option value="" >Select Subject Group</option>
						<?php foreach($group as $groups){?>
						<option value="<?php echo $groups['sg_id'];?>"><?php echo $groups['sg_name'];?></option>
						<?php } ?>
					</select>
					<div id="subject_group_err" style="display:none; color:red;"></div>
					</div>
				</div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Father's Name</label>
					<div class="col-sm-6">
						<input type="text" name="father_name" id="father_name" class="form-control">
						<div id="father_name_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
					<label class="col-sm-3 control-label">Mother's Name</label>
					<div class="col-sm-6">
						<input type="text" name="mother_name" id="mother_name" class="form-control">
						<div id="mother_name_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
					<label class="col-sm-3 control-label">Date Of Birth</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control datepicker" id="dob" name="dob"> 
					<div id="dob_err" class="text-danger" style="display:none;"></div> 
					</div>
					<!-- /.input group -->
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Gender</label>
					<div class="col-sm-6">
					<select class="form-control" id="gender" name="gender">
						<option value="">Select Gender</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>    
					</select>
					 <div id="gender_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Date of Admission</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control datepicker" id="admission_date" name="admission_date">
					<div id="admission_date_err" style="display:none; color:red;"></div>
					</div>
					<!-- /.input group -->
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Caste</label>
					<div class="col-sm-6">
					<select class="form-control" name="caste" id="caste">
						<option value="">Select Caste</option>
						<option value="General">General</option>
						<option value="OBC">OBC</option>
						<option value="ST">ST</option>
						<option value="SC">SC</option>
					</select>
					<div id="caste_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Blood Group</label>
					<div class="col-sm-6">
					<select class="form-control" name="blood" id="blood">
						<option value="">Select Blood Group</option>
						<option value="A+">A+</option>
						<option value="A-">A-</option>
						<option value="B+">B+</option>
						<option value="B-">B-</option>
						<option value="O+">O+</option>
						<option value="O-">O-</option>
						<option value="AB+">AB+</option>
						<option value="AB-">AB-</option>
						
					</select>
					<div id="blood_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Aadhaar Card Number</label>
					<div class="col-sm-6">
						<input type="text" name="aadhaar" id="aadhaar" class="form-control" maxlength="12">
						<div id="aadhaar_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Permanent Address</label>
					<div class="col-sm-6">
						<textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter permanent address"></textarea>
						<div id="address_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Guardian Name</label>
					<div class="col-sm-6">
						<input type="text" name="guardian" id="guardian" class="form-control">
						<div id="guardian_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Local Address </label>
					<div class="col-sm-6">
						<textarea name="local_address" id="local_address" class="form-control" rows="3"></textarea>
						<div id="local_address_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Contact No.</label>
					<div class="col-sm-6">
						<input type="text" name="contact_no" id="contact_no" class="form-control">
						<div id="contact_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Email ID</label>
					<div class="col-sm-6">
						<input type="text" name="email" id="email" class="form-control">
						<div id="email_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Medical History</label>
					<div class="col-sm-6">
						<input type="text" name="medical" id="medical" class="form-control">
						<div id="medical_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Height </label>
					<div class="col-sm-6">
						<input type="text" name="height" id="height" class="form-control">
						<div id="height_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Weight</label>
					<div class="col-sm-6">
						<input type="text" name="weight" id="weight" class="form-control">
						<div id="weight_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                    <label class="col-sm-3 control-label">TC Self</label>
					<div class="col-sm-6">
					<select class="form-control" name="transfer" id="transfer">
						<option value="">Select TC Self</option>
						<option value="Bonafide">Bonafide</option>
						<option value="Fresher">Fresher</option>
					</select>
					<div id="transfer_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">hostel</label>
					<div class="col-sm-6">
					<select class="form-control" name="hostel" id="hostel">
						<option value="">Select hostel</option>
						<?php foreach($hostel as $hostels){?>
							<option value="<?php echo $hostels['hid'];?>"><?php echo $hostels['hostel_name'];?></option>
						<?php }?>
					</select>
					<div id="house_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Hostler</label>
					<div class="col-sm-6">
					<select class="form-control" name="hostler" id="hostler">
						<option value="">Select Hostler</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
					<div id="hostler_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label" for="exampleInputFile">Profile Image</label>
                  <input type="hidden" id="old_image" name="old_image">
                  <div id="image_preview"></div><br>
                  <div class="col-sm-offset-3"><input type="file" name="std_image" id="std_image"></div>
                  <div id="std_image_err" style="color:red;"></div>
                </div>
			
			</div>
			<div class="box-footer">
                      	<div class="col-sm-offset-8">
                            <button type="button" name="submit" id="submit" class="btn btn-info">Submit</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
        			</div>
			</form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div> <!-- End of Modal -->
        <?php
        $path = base_url().'assets/images/sharda/students/';
        
        $school = $this->session->userdata('school_id');
        if($school == 1){
            $path = base_url().'assets/images/shakuntala/students/';
        }
        ?>
        <input type="hidden" id="path" value="<?php echo $path;?>">
        
        
        
        