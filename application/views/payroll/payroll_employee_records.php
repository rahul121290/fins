<div class="col-md-12">	
  	<div class="box box-danger no-print">
        <div class="box-header">
          <h3 class="box-title">Select filters</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<form id="hostel_mis_form" action="javascript:void(0);" method="POST" role="form">
    	
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    	
      			<div class="form-group" style="margin-bottom:0px;">
      				<div class="col-sm-2 mb-3">
						<select name="session" id="session" class="form-control">
							<option value="3" selected>2019-20</option>
						</select>
						<div id="session_err" style="display:none; color:red;"></div>
					</div>
					<div class="col-sm-2 mb-3">
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
						<div id="school_err" style="display:none; color:red;"></div>
					</div>					
					<div class="col-sm-2 mb-3">
						<select class="form-control" name="" id="">
							<option value="">Select Employee Grade</option>
							<option value="1">Teacher</option>
							<option value="3">Peon + Helper + Driver</option>
							<option value="3">Shakuntala Group</option>
						</select>
						<div id="" style="display:none; color:red;"></div>
					</div>
					<div class="col-sm-2 mb-3">
						<select class="form-control" name="" id="">
							<option value="">Select Gender</option>
							<option value="1">Female</option>
							<option value="3">Male</option>
						</select>
						<div id="" style="display:none; color:red;"></div>
					</div>
					
					
					<div class="col-md-2 mb-3">
						<button type="button" id="search" class="btn btn-info pull-left">Search</button>	
					</div>
			    </div>
    		</form>	
		</div><!-- end box body -->
		</div>
		<div class="print-s-logo" style="float:left;padding:0px 0px 5px 0px;width:100%;margin-bottom:0px;">
				<div class="text-center" style="float:left;">
					<img class="pull-left" alt="" src="../images/shakuntala/shakuntala.png" height="40" />
		<div class="print-s-name" >
			<h4><b>Shakuntala Vidyalaya</b></h4>
			<p>Ram Nagar Bhilai(C.G.)</p>
		</div>
					
				</div>
				<div class="text-right">
					<h4 style="margin-bottom:0px;"><b>Shakuntala Employee List</b></h4>
				</div>
		</div>
		
	
		<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title no-print"><b>Shakuntala Employee </b></h3>
            </div>
      		<div class="box-body table-responsive p-table-bg-head p-table-body">
				<table class="table">
					<thead><tr>
					<th>S.No.</th>
					<th>School</th>
					<th>Employee Type</th>
					<th>Employee Name</th>
					<th>Employee ID</th>
					<th>Gender</th>
					<th>Payment Mode</th>
					<th>Net Salary</th>
					<th class="no-print">Action</th>

					</tr>
					</thead>
					<tbody id="">
					<tr>
						<td>01.</td>
						<td>Shakuntala CSBE</td>
						<td>Teacher</td>
						<td>Mrs. Neerja Singh</td>
						<td>Staff05</td>
						<td>Female</td>
						<td>Cash</td>
						<td>Rs.12,500.00/-</td>
						<td class="no-print"><a href="singal-employee-detail.html" class="btn btn-sm btn-info"><i class=""></i>Info</a> | <button class="btn btn-sm btn-info">Edit</button> | <button class="btn btn-sm btn-danger">Delete</button></td>
					</tr>
					<tr>
						<td>02.</td>
						<td>Shakuntala CSBE</td>
						<td>Teacher</td>
						<td>Mrs. Sahlini</td>
						<td>Staff05</td>
						<td>Female</td>
						<td>Cash</td>
						<td>Rs.12,500.00/-</td>
						<td class="no-print"><button class="btn btn-sm btn-info"><i class=""></i>Info</button> | <button class="btn btn-sm btn-info">Edit</button> | <button class="btn btn-sm btn-danger">Delete</button></td>
					</tr>
					<tr>
						<td>03.</td>
						<td>Shakuntala CSBE</td>
						<td>Teacher</td>
						<td>Mrs. Neerja Singh</td>
						<td>Staff05</td>
						<td>Female</td>
						<td>Cash</td>
						<td>Rs.12,500.00/-</td>
						<td class="no-print"><button class="btn btn-sm btn-info"><i class=""></i>Info</button> | <button class="btn btn-sm btn-info">Edit</button> | <button class="btn btn-sm btn-danger">Delete</button></td>
					</tr>
					<tr>
						<td>04.</td>
						<td>Shakuntala CSBE</td>
						<td>Teacher</td>
						<td>Mrs. Neha Sharma</td>
						<td>Staff05</td>
						<td>Female</td>
						<td>Cash</td>
						<td>Rs.12,500.00/-</td>
						<td class="no-print"><button class="btn btn-sm btn-info"><i class=""></i>Info</button> | <button class="btn btn-sm btn-info">Edit</button> | <button class="btn btn-sm btn-danger">Delete</button></td>
					</tr>
					<tr>
						<td>04.</td>
						<td>Shakuntala CSBE</td>
						<td>Teacher</td>
						<td>Mrs. Reshma </td>
						<td>Staff05</td>
						<td>Female</td>
						<td>Cash</td>
						<td>Rs.12,500.00/-</td>
						<td class="no-print"><button class="btn btn-sm btn-info"><i class=""></i>Info</button> | <button class="btn btn-sm btn-info">Edit</button> | <button class="btn btn-sm btn-danger">Delete</button></td>
					</tr>
					<tr>
						<td>05.</td>
						<td>Shakuntala CSBE</td>
						<td>Teacher</td>
						<td>Mrs. Nitu </td>
						<td>Staff05</td>
						<td>Female</td>
						<td>Cash</td>
						<td>Rs.12,500.00/-</td>
						<td class="no-print"><button class="btn btn-sm btn-info"><i class=""></i>Info</button> | <button class="btn btn-sm btn-info">Edit</button> | <button class="btn btn-sm btn-danger">Delete</button></td>
					</tr>
					<tr>
						<td>06.</td>
						<td>Shakuntala CSBE</td>
						<td>Teacher</td>
						<td>Mrs. Ranu Singh</td>
						<td>Staff05</td>
						<td>Female</td>
						<td>Cash</td>
						<td>Rs.12,500.00/-</td>
						<td class="no-print"><button class="btn btn-sm btn-info"><i class=""></i>Info</button> | <a class="btn btn-sm btn-info" data-toggle="modal" data-target="#editEmployee">Edit</a> | <button class="btn btn-sm btn-danger">Delete</button></td>
					</tr>
					</tbody>
				</table>
      		</div>
 		</div>
		
		<div class="text-center"><button class="btn btn-space btn-primary no-print" style="margin-bottom:50px;" onclick="printDiv()">Print this page</button></div>

	</div>
</div>


<div id="editEmployee" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Edit Employee Record.</h4>
	  </div>
      <div class="modal-body">
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
					<label class="col-sm-3 control-label">Employee ID: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Employee ID">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">School: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<select class="form-control" name="school" id="school">
								<option value="">Select School</option>
								<option value="1">Shakuntala CBSE</option>
								<option value="3">Shakuntala CG</option>
								<option value="3">Vaishali </option>
								<option value="3">Sharda Risali </option>
							</select>
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
				</div>
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
					<label class="col-sm-3 control-label">Basic Sallary: <span style="color:red;">*</span></label>
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

			<div class="box-footer">
                      	<div class="col-sm-offset-8">
                            <button type="button" name="submit" id="" class="btn btn-info">Submit</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
        			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
</div>
</div>