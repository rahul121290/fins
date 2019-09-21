<div class="content-wrapper container">
    <section class="content-header">
      <h1>New Employee Payroll</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/reception/dashbord"></i>Home</a></li>
        <li class="active">New Employee Payroll</li>
      </ol>
    </section>

    <!-- Main content -->
	<section class="content">
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Enroll New Employee Details</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			
			<form role="form" action="javascript:void(0);" class="form-horizontal" method="POST">
			<div class="box-body">
                <div class="row">
				<div class="col-md-6">
				<div class="form-group">
					<label class="col-sm-3 control-label">Employee Type: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
						<select class="form-control" name="" id="">
							<option value="">Select Type</option>
							<option value="1">Teacher</option>
							<option value="3">Peon + Helper + Driver</option>
							<option value="3">Shakuntala Group</option>
						</select>
						<div id="" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Employee Name: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<select class="form-control" name="school" id="school">
								<option value="">Select Employee</option>
								<option value="">Rakesh</option>
								<option value="">Ravi</option>
								<option value="">Rahul </option>
								<option value="">Somesh </option>
							</select>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Employee Name: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Employee ID">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Employee ID: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Employee ID">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">School: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<select name="school" id="school" class="form-control">
							<option value="">Select School</option>
							<?php if($this->session->userdata('school_id')){?>
							<option value="1" selected>Shakuntala Vidyalaya (CBSE) Records</option>
							<option value="3">Shakuntala Vidyalaya (CG) Records</option>
							<option value="4">Sharda Vidyalaya Vaishali Nagar</option>
							<?php }else{?>
							<option value="2">Sharda Vidyalaya Risali</option>
							<?php } ?>
						</select>
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Session: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
						<select class="form-control" name="" id="">
							<option value="">Select Session</option>
							<option value="1">2019-20</option>
							<option value="3">2018-19</option>
							<option value="3">2017-18</option>
						</select>
						<div id="" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Post: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
						<select class="form-control" name="" id="">
							<option value="">Select Post</option>
							<option value="">PGT</option>
							<option value="">TGT</option>
							<option value="">PRT</option>
							<option value="">PRT</option>
							<option value="">PTI</option>
							<option value="">SUPW</option>
							<option value="">A/C</option>
							<option value="">Ass. Opt</option>
						</select>
						<div id="" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Date of Join: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
					  <input type="date" max="<?php echo date('Y-m-d')?>" value="<?php echo date('Y-m-d');?>" class="form-control" id="admission_date" name="admission_date" placeholder="dd/mm/yyyy">
					<div id="admission_date_err" style="display:none; color:red;"></div>
					</div>
					<!-- /.input group -->
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Father/Hashband Name: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Enter name">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Gender: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
					<select class="form-control" id="gender" name="gender">
						<option value="">Select Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
					 <div id="gender_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				               
				<div class="form-group">
					<label class="col-sm-3 control-label">Date Of Birth: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
					  <input type="date"max="<?php echo date('Y-m-d')?>" class="form-control" id="dob" name="dob" placeholder="dd/mm/yyyy"> 
					<div id="dob_err" class="text-danger" style="display:none;"></div> 
					</div>
					<!-- /.input group -->
				</div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Aadhaar Card Number:</label>
					<div class="col-sm-8">
						<input type="text" name="aadhaar" id="aadhaar" class="form-control only_int" placeholder="Enter aadhaar card no." maxlength="12">
						<div id="aadhaar_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Permanent Address: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
						<textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter permanent address"></textarea>
						<div id="address_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Local Address: </label>
					<div class="col-sm-8">
						<textarea name="local_address" id="local_address" class="form-control" rows="3" placeholder="Enter local address"></textarea>
						<div id="local_address_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				
				</div>
				<div class="col-md-6">
				<div class="form-group">
                  <label class="col-sm-3 control-label">Mobile No./Contact No.: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
						<input type="text" name="contact_no" id="contact_no" class="form-control only_int" placeholder="Enter contact no.">
						<div id="contact_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Other Contact No.:</label>
					<div class="col-sm-8">
						<input type="text" name="" id="" class="form-control only_int" placeholder="Enter contact no.">
						<div id="" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Email ID:</label>
					<div class="col-sm-8">
						<input type="text" name="email" id="email" class="form-control" placeholder="Enter email id">
						<div id="email_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label" for="exampleInputFile">Profile Image:</label>
                  <div class="col-sm-8"><input type="file" name="std_image" id="std_image"></div>
                  <div id="std_image_err"></div>
                </div>
				
				<h5 style="    background-color: #888;    padding: 10px;    color: #fff;    margin: 30px 15px;">Bank Details</h5>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Basic Salary: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Enter Amount">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">DA: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Enter Amount">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">PF No.: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Enter PF No.">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">ESIC No.: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Enter ESIC No.">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Bank Name: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Bank Name">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Bank A/C No: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Bank A/C No.">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Bank IFSC CODE: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Bank IFSC CODE">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				</div>
				<div class="col-md-12">
					<div class="form-group">
                      	<div class="text-center">
                            <button type="button" id="submit" class="btn btn-success btn-space">Submit</button>
                        </div>
        			</div>
				</div>
				
				</div>
			</div>
					
			</form>
		</div>
        </section>
</div>