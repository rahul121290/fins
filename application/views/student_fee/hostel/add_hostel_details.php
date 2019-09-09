<div class="content-wrapper">
    <section class="content-header">
      <h1>Hostel<small>Add Student Details</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Add Student Details</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/add_hostel_students.js"></script>
    <!-- Main content -->
	<section class="content">
		<form role="form" action="javascript:void(0);" class="form-horizontal" id="hostel_student_details" method="POST">
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 style="margin-top:8px;" class="text-center"><b>SHAKUNTALA GURUKUL 2019-20</b></h3>
			  <hr> 
			</div>
			
			<div class="box-body">
                <div class="col-md-6">
                <div class="form-group">
					<label class="col-sm-3 control-label">Student Hostel Status<span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<select class="form-control" name="std_status" id="std_status">
								<option value="">Select Status</option>
								<option value="New">New</option>
								<option value="Old">Old</option>
							</select>
							<div id="school_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
                <div class="form-group">
					<label class="col-sm-3 control-label">Board <span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<select class="form-control" name="school" id="school">
								<option value="">Select Board</option>
								<?php foreach($school as $sch){?>
									<option value="<?php echo $sch['sch_id'];?>"><?php echo $sch['school_name'];?></option>
								<?php }?>
							</select>
							<div id="school_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Allotted Hostel <span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<select class="form-control" name="hostel_name" id="hostel_name">
								<option value="">Select One</option>
								<?php foreach($hostel_details as $hdetails){?>
									<option value="<?php echo $hdetails['hd_id'];?>"><?php echo $hdetails['hostel_name'];?></option>
								<?php } ?>
							</select>
							<div id="hostel_name_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Admission No. <span style="color:red;">*</span></label>
                  <div class="col-sm-6">
					<input type="number" name="admission_no" id="admission_no" class="form-control" placeholder="Enter admission no." />
					<div id="admission_no_err" style="display:none;color:red;"></div>
				</div>
                </div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Student Name <span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<input type="text" name="student_name" id="student_name" class="form-control only_text" placeholder="Enter student name" disabled="disabled"/>
							<div id="student_name_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Roll No.</label>
                  <div class="col-sm-6">
					<input type="text" name="roll_no" id="roll_no" class="form-control only_int" placeholder="Enter roll no." disabled="disabled"/>
					<div id="roll_no_err"	 style="display:none;color:red;"></div>
				  </div>
                </div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Medium <span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<select class="form-control" name="medium" id="medium" disabled="disabled">
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
						<select class="form-control" name="class_id" id="class_id" disabled="disabled">
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
					<select class="form-control" name="section" id="section" disabled="disabled">
						<option value="">Select Section</option>
						<?php foreach($section as $sec){?>
						<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
						<?php }?>
					</select>
					<div id="section_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				</div>
				<div class="col-md-6">
				
				<div class="form-group" id="sub_group_row" style="display: none;">
                    <label class="col-sm-3 control-label">Subject Group</label>
					<div class="col-sm-6">
					<select class="form-control" name="subject_group" id="subject_group" disabled="disabled">
						<option value="" >Select Subject Group</option>
						<?php foreach($sub_group as $group){?>
						<option value="<?php echo $group['sg_id'];?>"><?php echo $group['sg_name'];?></option>
						<?php } ?>
					</select>
					<div id="subject_group_err" style="display:none; color:red;"></div>
					</div>
				</div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Father's Name <span style="color:red;">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="father_name" id="father_name" class="form-control only_text" placeholder="Enter father's name" disabled="disabled"/>
						<div id="father_name_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
					<label class="col-sm-3 control-label">Mother's Name <span style="color:red;">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="mother_name" id="mother_name" class="form-control only_text" placeholder="Enter mother's name" disabled="disabled"/>
						<div id="mother_name_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
					<label class="col-sm-3 control-label">Date Of Birth <span style="color:red;">*</span></label>
					<div class="col-sm-6">
					  <input type="date"max="<?php echo date('Y-m-d')?>" class="form-control" id="dob" name="dob" placeholder="dd/mm/yyyy" disabled="disabled"/> 
					<div id="dob_err" class="text-danger" style="display:none;"></div> 
					</div>
					<!-- /.input group -->
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Gender <span style="color:red;">*</span></label>
					<div class="col-sm-6">
					<select class="form-control" id="gender" name="gender" disabled="disabled">
						<option value="">Select Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
					 <div id="gender_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
								
				<div class="form-group">
                  <label class="col-sm-3 control-label">Aadhaar Card Number</label>
					<div class="col-sm-6">
						<input type="text" name="aadhar_no" id="aadhar_no" class="form-control only_int" placeholder="Enter aadhaar card no." maxlength="12" disabled="disabled"/>
						<div id="aadhar_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Permanent Address <span style="color:red;">*</span></label>
					<div class="col-sm-6">
						<textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter permanent address" disabled="disabled"></textarea>
						<div id="address_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
               <div class="form-group">
                  <label class="col-sm-3 control-label">Contact No. <span style="color:red;">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="contact_no" id="contact_no" class="form-control only_int" placeholder="Enter contact no." disabled="disabled"/>
						<div id="contact_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				</div>
		</div>
			
		</div>
		
		
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Information part-2</h3>
			  <hr>
			</div>
			
		<div class="box-body">
		<div class="col-md-6">
				<div class="form-group">
                  <label class="col-sm-3 control-label">Father's Mobile No.</label>
					<div class="col-sm-6">
						<input type="text" name="f_contact_no" id="f_contact_no" class="form-control only_int" placeholder="Enter contact no." />
						<div id="f_contact_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Mother's Mobile No.</label>
					<div class="col-sm-6">
						<input type="text" name="m_contact_no" id="m_contact_no" class="form-control only_int" placeholder="Enter contact no." />
						<div id="m_contact_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Guardian Name</label>
					<div class="col-sm-6">
						<input type="text" name="guardian_name" id="guardian_name" class="form-control only_text" placeholder="Enter guardian name" />
						<div id="guardian_name_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Local Address </label>
					<div class="col-sm-6">
						<textarea name="local_address" id="local_address" class="form-control" rows="3" placeholder="Enter local address"></textarea>
						<div id="local_address_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-3 control-label">Pin Code</label>
					<div class="col-sm-6">
						<input type="text" name="guardian_pin_code" id="guardian_pin_code" class="form-control only_text" placeholder="Pin Code" />
						<div id="guardian_pin_code_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				
				
				
                <div class="form-group">
                  <label class="col-sm-3 control-label">Guardian Mobile No.</label>
					<div class="col-sm-6">
						<input type="text" name="g_contact_no" id="g_contact_no" class="form-control" placeholder="Enter contact no." />
						<div id="g_contact_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				</div>
			<div class="col-md-6">
				<div class="form-group">
                  <label class="col-sm-3 control-label">Previous School</label>
					<div class="col-sm-6">
						<input type="text" name="preSchool" id="preSchool" class="form-control" placeholder="Enter school name" />
						<div id="preSchool_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Class passed</label>
					<div class="col-sm-6">
						<select name="preClass" id="preClass" class="form-control">
							<option value="">Select Class</option>
							<?php foreach($class_name as $class){?>
								<option value="<?php echo $class['c_id'];?>"><?php echo $class['class_name'];?></option>
							<?php } ?>
						</select>
						<div id="preClass_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">% of Marks</label>
					<div class="col-sm-6">
						<input type="text" name="per_of_marks" id="per_of_marks" class="form-control" placeholder="Enter marks" />
						<div id="per_of_marks_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Father A/C No.</label>
					<div class="col-sm-6">
						<input type="text" name="f_acc_no" id="f_acc_no" class="form-control" placeholder="Enter A/C No." />
						<div id="f_acc_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Student A/C No.</label>
					<div class="col-sm-6">
						<input type="text" name="std_acc_no" id="std_acc_no" class="form-control" placeholder="Enter A/C No." />
						<div id="std_acc_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-8" for="exampleInputFile">If any real cousin brother/sister(s) is /are living in the Hostel </label>
                  
				  <div class="col-md-8"><input type="radio" class="cousin" name="cousin" value="Yes" checked />Yes
                  <input type="radio" class="cousin" name="cousin" value="No" />No</div>
                  
                </div>
			</div>
			<div class="col-sm-12 table-responsive" id="cousin_details">
					<table style="border:1px solid #999;" class="table table-bordered text-center s-b-table">
					<style>.s-b-table > thead > tr > th{border:1px solid #d8c6c6 !important;}.s-b-table > tbody > tr > td{border:1px solid #d8c6c6 !important;}</style>
						<thead class="thead-dark">
							<tr>
							<th></th>
							<th>Name</th>
							<th>Father's Name</th>
							<th>Class</th>
							<th>Section</th>
							<th>Since Session</th>
							</tr>
						</thead>
						<tbody>
						<tr>
							<td><input type="checkbox" id="c_row_1"></td>
							<td><input type="text" id="c_name_1" name="c_name_1" disabled="disabled"/></td>
							<td><input type="text" id="cf_name_1" name="cf_name_1"  disabled="disabled"/></td>
							<td><select id="c_class_1" name="c_class_1"  disabled="disabled">
								<option value="">Select Class</option>
    							<?php foreach($class_name as $class){?>
    								<option value="<?php echo $class['c_id'];?>"><?php echo $class['class_name'];?></option>
    							<?php } ?>
							</select></td>
							<td>
							<select id="c_section_1" name="c_section_1"  disabled="disabled">
							<option value="">Select Section</option>
    							<?php foreach($section as $sec){?>
    								<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
    							<?php } ?>
							</select>
							</td>
							<td><input type="text" id="since_ses_1" name="since_ses_1"  disabled="disabled"/></td>
							
						</tr>
						<tr>
							<td><input type="checkbox" id="c_row_2"></td>
							<td><input type="text" id="c_name_2" name="c_name_2"  disabled="disabled"/></td>
							<td><input type="text" id="cf_name_2" name="cf_name_2"  disabled="disabled"/></td>
							<td><select id="c_class_2" name="c_class_2"  disabled="disabled">
								<option value="">Select Class</option>
    							<?php foreach($class_name as $class){?>
    								<option value="<?php echo $class['c_id'];?>"><?php echo $class['class_name'];?></option>
    							<?php } ?>
							</select></td>
							<td>
							<select id="c_section_2" name="c_section_2"  disabled="disabled">
							<option value="">Select Section</option>
    							<?php foreach($section as $sec){?>
    								<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
    							<?php } ?>
							</select>
							</td>
							<td><input type="text" id="since_ses_2" name="since_ses_2"  disabled="disabled"/></td>
						</tr>
						<tr>
							<td><input type="checkbox" id="c_row_3"></td>
							<td><input type="text" id="c_name_3" name="c_name_3"  disabled="disabled"/></td>
							<td><input type="text" id="cf_name_3" name="cf_name_3"  disabled="disabled"/></td>
							<td><select id="c_class_3" name="c_class_3"  disabled="disabled">
								<option value="">Select Class</option>
    							<?php foreach($class_name as $class){?>
    								<option value="<?php echo $class['c_id'];?>"><?php echo $class['class_name'];?></option>
    							<?php } ?>
							</select></td>
							<td>
							<select id="c_section_3" name="c_section_3"  disabled="disabled">
							<option value="">Select Section</option>
    							<?php foreach($section as $sec){?>
    								<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
    							<?php } ?>
							</select>
							</td>
							<td><input type="text" id="since_ses_3" name="since_ses_3"  disabled="disabled"/></td>
						</tr>
						<tr><td colspan="6" style="text-align:center;"><div class="error" style="display:none;" id="cousin_details_err">This is Required.</div></td></tr>
						</tbody>
					</table>
				  </div>
		</div>
		</div>
		
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Upload Photos</h3>
			  <hr>
			</div>
			
			<div class="box-body">
				<div class="col-md-3 text-left">
					<h5><b>Student Photo</b></h5>
					<div id="std_image_preview"></div>
					<input class="form-control" type="file" id="student_image" name="student_image" disabled="disabled"/>
				</div>
				<div class="col-md-3 text-left">
					<h5><b>Student Father's Photo</b></h5>
					<input class="form-control" type="file" id="father_image" name="father_image" />
				</div>
				<div class="col-md-3 text-left">
					<h5><b>Student Mother's Photo</b></h5>
					<input class="form-control" type="file" id="mother_image" name="mother_image"/>
				</div>
				<div class="col-md-3 text-left">
					<h5><b>Student Gurardian's Photo</b></h5>					
					<input class="form-control" type="file" id="gurardian_image" name="gurardian_image"/>
				</div>
			</div>
		</div>
    	<div class="box-footer">
          	<div class="col-md-12 text-center">
                <button type="button" id="submit_details" class="btn btn-info btn-space">Submit</button>
            </div>
    	</div>
	</form>
 </section>
<input type="text" id="user_url" name="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>"/>
