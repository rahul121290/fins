<div class="content-wrapper">
    <section class="content-header">
      <h1>Hostel<small>New admission</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">New Admission</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/new_admission.js"></script>
    <!-- Main content -->
	<section class="content">
		<form role="form" action="javascript:void(0);" class="form-horizontal" id="student_form" method="POST">
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 style="margin-top:8px;" class="text-center"><b>SHAKUNTALA GURUKUL 2019-20</b></h3>
			  <hr>
			 
			</div>
			
			
			<div class="box-body">
                <div class="col-md-6">
				<div class="form-group">
					<label class="col-sm-3 control-label">Allotted Hostel <span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<select class="form-control" name="school" id="">
								<option value="">Select One</option>
								<option value="1">Hostel 1</option>
								<option value="2">Hostel 2</option>
							</select>
							<div id="school_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Admission No. <span style="color:red;">*</span></label>
                  <div class="col-sm-6">
					<input type="text" name="admission_no" id="admission_no" class="form-control only_int" placeholder="Enter admission no." />
					<div id="admission_no_err" style="display:none;color:red;"></div>
				</div>
                </div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Student Name <span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<input type="text" name="student_name" id="student_name" class="form-control only_text" placeholder="Enter student name" />
							<div id="student_name_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Roll No.</label>
                  <div class="col-sm-6">
					<input type="text" name="roll_no" id="roll_no" class="form-control only_int" placeholder="Enter roll no." />
					<div id="roll_no_err"	 style="display:none;color:red;"></div>
				  </div>
                </div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Session <span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<select class="form-control" name="session" id="session">
								<option value="">Select Session</option>
								<option value="3">2019-20</option>
							</select>
							<div id="session_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Board <span style="color:red;">*</span></label>
						<div class="col-sm-6">
							<select class="form-control" name="school" id="school">
								<option value="">Select Board</option>
								<option value="1">CBSE</option>
								<option value="3">CG State Board</option>
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
					<select class="form-control" name="section" id="section">
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
				
				<div class="form-group" id="sub_group_section" style="display: none;">
                    <label class="col-sm-3 control-label">Subject Group</label>
					<div class="col-sm-6">
					<select class="form-control" name="subject_group" id="subject_group">
						<option value="" >Select Subject Group</option>
						<?php foreach($group as $groups){?>
						<option value="<?php echo $groups['sg_id'];?>"><?php echo $groups['sg_name'];?></option>
						<?php } ?>
					</select>
					<div id="subject_group_err" style="display:none; color:red;"></div>
					</div>
				</div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Father's Name <span style="color:red;">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="father_name" id="father_name" class="form-control only_text" placeholder="Enter father's name" />
						<div id="father_name_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
					<label class="col-sm-3 control-label">Mother's Name <span style="color:red;">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="mother_name" id="mother_name" class="form-control only_text" placeholder="Enter mother's name" />
						<div id="mother_name_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
					<label class="col-sm-3 control-label">Date Of Birth <span style="color:red;">*</span></label>
					<div class="col-sm-6">
					  <input type="date"max="<?php echo date('Y-m-d')?>" class="form-control" id="dob" name="dob" placeholder="dd/mm/yyyy" /> 
					<div id="dob_err" class="text-danger" style="display:none;"></div> 
					</div>
					<!-- /.input group -->
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Gender <span style="color:red;">*</span></label>
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
                  <label class="col-sm-3 control-label">Aadhaar Card Number</label>
					<div class="col-sm-6">
						<input type="text" name="aadhaar" id="aadhaar" class="form-control only_int" placeholder="Enter aadhaar card no." maxlength="12" />
						<div id="aadhaar_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Permanent Address <span style="color:red;">*</span></label>
					<div class="col-sm-6">
						<textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter permanent address"></textarea>
						<div id="address_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
               <div class="form-group">
                  <label class="col-sm-3 control-label">Contact No. <span style="color:red;">*</span></label>
					<div class="col-sm-6">
						<input type="text" name="contact_no" id="contact_no" class="form-control only_int" placeholder="Enter contact no." />
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
						<input type="text" name="f_contact_no" id="" class="form-control only_int" placeholder="Enter contact no." />
						<div id="contact_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Mother's Mobile No.</label>
					<div class="col-sm-6">
						<input type="text" name="m_contact_no" id="" class="form-control only_int" placeholder="Enter contact no." />
						<div id="contact_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Guardian Name</label>
					<div class="col-sm-6">
						<input type="text" name="guardian" id="guardian" class="form-control only_text" placeholder="Enter guardian name" />
						<div id="guardian_err" class="text-danger" style="display:none;"></div>
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
                  <label class="col-sm-3 control-label">Guardian Mobile No.</label>
					<div class="col-sm-6">
						<input type="text" name="g_contact_no" id="" class="form-control only_int" placeholder="Enter contact no." />
						<div id="contact_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Email ID</label>
					<div class="col-sm-6">
						<input type="text" name="email" id="email" class="form-control" placeholder="Enter email id" />
						<div id="email_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                    <label class="col-sm-3 control-label">TC Self <span style="color:red;">*</span></label>
					<div class="col-sm-6">
					<select class="form-control" name="transfer" id="transfer">
						<option value="">Select TC Self</option>
						<option value="Bonafide">Bonafide</option>
						<option value="Fresher">Fresher</option>
					</select>
					<div id="transfer_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				</div>
			<div class="col-md-6">
				
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Previous School</label>
					<div class="col-sm-6">
						<input type="text" name="preSchool" class="form-control" placeholder="Enter school name" />
						<div id="" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Class passed</label>
					<div class="col-sm-6">
						<input type="text" name="" class="form-control" placeholder="Enter class" />
						<div id="" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">% of Marks</label>
					<div class="col-sm-6">
						<input type="text" name="" class="form-control" placeholder="Enter marks" />
						<div id="" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Father A/C No.</label>
					<div class="col-sm-6">
						<input type="text" name="" class="form-control" placeholder="Enter A/C No." />
						<div id="" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Student A/C No.</label>
					<div class="col-sm-6">
						<input type="text" name="" class="form-control" placeholder="Enter A/C No." />
						<div id="" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-12" for="exampleInputFile">If any real cousin brother/sister(s) is /are living in the Hostel </label>
                  <div class="col-sm-12">
					<table style="border:1px solid #999;" class="table table-bordered text-center s-b-table">
					<style>.s-b-table > thead > tr > th{border:1px solid #d8c6c6 !important;}.s-b-table > tbody > tr > td{border:1px solid #d8c6c6 !important;}</style>
						<thead class="thead-dark">
							<tr>
							<th>Name</th>
							<th>Father's Name</th>
							<th>Class/Sec</th>
							<th>Since Section</th>
							</tr>
						</thead>
						<tbody>
						<tr>
							<td><input type="text" /></td>
							<td><input type="text" /></td>
							<td><input type="text" /></td>
							<td><input type="text" /></td>
						</tr>
						<tr>
							<td><input type="text" /></td>
							<td><input type="text" /></td>
							<td><input type="text" /></td>
							<td><input type="text" /></td>
						</tr>
						<tr>
							<td><input type="text" /></td>
							<td><input type="text" /></td>
							<td><input type="text" /></td>
							<td><input type="text" /></td>
						</tr>
						</tbody>
					</table>
				  </div>
				  
                </div>
			
			</div>
		</div>
		</div>
		
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Photos</h3>
			  <hr>
			</div>
			
			<div class="box-body">
				<div class="col-md-3 text-center">
					<h5><b>Student Photo</b></h5>
					<img style="border:1px solid #ddd;width:120px;height:120px;margin-bottom:20px;" src="" />
					<input class="form-control" type="file" />
				</div>
				<div class="col-md-3 text-center">
					<h5><b>Student Father's Photo</b></h5>
					<img style="border:1px solid #ddd;width:120px;height:120px;margin-bottom:20px;" src="" />
					<input class="form-control" type="file" />
				</div>
				<div class="col-md-3 text-center">
					<h5><b>Student Mother's Photo</b></h5>
					<img style="border:1px solid #ddd;width:120px;height:120px;margin-bottom:20px;" src="" />
					<input class="form-control" type="file" />
				</div>
				<div class="col-md-3 text-center">
					<h5><b>Student Gurardian's Photo</b></h5>
					<img style="border:1px solid #ddd;width:120px;height:120px;margin-bottom:20px;" src="" />
					<input class="form-control" type="file" />
				</div>
			</div>
		</div>
		
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Payment</h3>
			  <hr>
			</div>
			
			<div class="box-body">
				<div class="col-md-6">
					<div class="form-group mb-3">
						<label class="col-sm-6">Details of amount</label>
						<div class="col-sm-6">
							<select class="form-control" name="transfer">
								<option value="">Select One</option>
								<option value="">Payable in March/April 2019</option>
								<option value="">Payable in September 2019</option>
							</select>
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group mb-3">
					  <label class="col-sm-6">Details of payable amount</label>
						<div class="col-sm-6">
							<input type="text" name="" class="form-control" placeholder="Enter amount" />
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group">
					  <label class="col-sm-6">Lodging & Boarding Charges</label>
						<div class="col-sm-6">
							<input type="text" name="" class="form-control" placeholder="Enter amount" />
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group">
					  <label class="col-sm-6">Laundry Charges</label>
						<div class="col-sm-6">
							<input type="text" name="" class="form-control" placeholder="Enter amount" />
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group">
					  <label class="col-sm-6">Caution Money</label>
						<div class="col-sm-6">
							<input type="text" name="" class="form-control" placeholder="Enter amount" />
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
                      	<div class="col-md-12 text-center">
                            <button type="button" id="submit" class="btn btn-info">Submit</button>
                        </div>
        			</div>
		</div>
		
		
		</form>
        </section>



<input type="hidden" id="user_url" name="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>"/>


<!-- Modal -->
<div id="sibling_verification" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        
        <div class="row">
        	<div class="form-group">
              <div class="col-sm-3">
				<select class="form-control" id="sibling_school">
					<option value="">Select BOARD</option>
					<option value="1">CBSE</option>
					<option value="2">CG Board</option>
				</select>
				<div id="sibling_school_err" class="error" style="display: none;"></div>
			</div>
			
              <div class="col-sm-3">
    			<select class="form-control" id="sibling_medium"> 
    				<option value="">Select Medium</option>
    				<?php foreach($medium as $med){?>
    				    <option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
    				<?php }?>
    			</select>
    			<div id="sibling_medium_err" class="error" style="display: none;"></div>
    		</div>
    		
    		<div class="col-sm-3">
    			<select class="form-control" id="sibling_class">
    				<option value="">Select Class</option>
    				<?php foreach($class as $classes){?>
						<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
					<?php } ?>
    			</select>
    			<div id="sibling_class_err" class="error" style="display: none;"></div>
    		</div>
    		
    		<div class="col-sm-3">
    			<select class="form-control" id="sibling_section">
    				<option value="">Select Section</option>
    				<?php foreach($section as $sec){?>
						<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
					<?php }?>
    			</select>
    			<div id="sibling_section_err" class="error" style="display: none;"></div>
    		</div>
    		
    		<div class="col-sm-3">
    			<button id="search_record" class="btn btn-sm btn-primary">Search</button>
    		</div>
      	 </div>
      	 
      	 <div style="width:100%; height: 400px;overflow-y: scroll;float: left;">
      	 	<table class="table" >
      	 		<thead>
      	 			<tr>
      	 				<th>S No.</th>
      	 				<th>Admission No.</th>
      	 				<th>Student Name</th>
      	 				<th>Father's Name</th>
      	 				<th>Contact No.</th>
      	 			</tr>
      	 		</thead>
      	 		<tbody id="student_list"></tbody>
      	 	</table>
      	 </div>
      </div>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>