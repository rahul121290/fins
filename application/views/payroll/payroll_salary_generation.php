<div class="content-wrapper">
<section class="content-header" style="margin-bottom:10px;">
      <h1>Salary Generation</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/payroll/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Salary Generation</li>
      </ol>
    </section>

<!-- main section -->
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
						<select name="school" id="school" class="form-control">
							<option value="">Select Month</option>
							<option>January</option>
							<option>February</option>
							<option>March</option>
							<option>April</option>
							<option>May</option>
							<option>June</option>
							<option>July</option>
							<option>August</option>
							<option>September</option>
							<option>October</option>
							<option>November</option>
							<option>December</option>
						</select>
						<div id="school_err" style="display:none; color:red;"></div>
					</div>
									
					<div class="col-sm-2 mb-3">
						<select class="form-control" name="" id="">
							<option value="">Select Employee Type</option>
							<option value="1">Teacher</option>
							<option value="3">Peon + Helper + Driver</option>
							<option value="3">Shakuntala Group</option>
						</select>
						<div id="" style="display:none; color:red;"></div>
					</div>	
					
					
					<div class="col-md-4 mb-3">
						
					<button type="button" id="" class="btn btn-info pull-left">Generate Payment</button>	
<button type="button" id="" class="btn btn-success pull-left" style="margin-left:10px;">Print All</button>						
					</div>
			    </div>
    		</form>	
		</div><!-- end box body -->
		</div>
		<div class="print-s-logo" style="float:left;padding:0px 0px 5px 0px;width:100%;margin-bottom:10px;">
				<div class="text-center" style="float:left;">
					<?php if($this->session->userdata('school_id') == 1){ $school = 'shakuntala';?>
		<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" height="40" />
		<div class="print-s-name" >
			<h4><b>Shakuntala Vidyalaya</b></h4>
			<p>Ram Nagar Bhilai(C.G.)</p>
		</div>
      	<?php } else if($this->session->userdata('school_id') == 2){ $school = 'sharda';?>
      	<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/sharda/sharda_logo.png" height="40" />
		<div class="print-s-name" >
			<h4><b>Sharda Vidyalaya</b></h4>
			<p>Risali Bhilai(C.G.)</p>
		</div>
		<?php }else{ $school = 'cg-board';?>
		<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" height="40" />
		<div class="print-s-name" >
			<h4><b>Shakuntala Vidyalaya No. 2</b></h4>
			<p>Ram Nagar Bhilai(C.G.)</p>
		</div>
		<?php }?>
				</div>
				<div class="text-right">
					<h4 style="margin-bottom:0px;"><b>Teacher Salary Generated!</b></h4>
				</div>
		</div>
		
	
		<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title"><b>Generated Teacher Salary List</b></h3>
			  <hr></hr>
            </div>
      		<div class="box-body">
				<!--<div class="col-md-12">
					<div class="form-group col-md-4">
					<label class="col-sm-3 control-label">Total Absent: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Type absent day">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group col-md-4">
					<label class="col-sm-3 control-label">Advance Salary: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Type advance amount">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group col-md-4">
					<label class="col-sm-3 control-label">Payment Mode: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<select class="form-control" id="gender" name="gender">
								<option value="">Select Payment mode</option>
								<option value="">Case</option>
								<option value="">Bank</option>
							</select>
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
					</div>
				</div>-->
				
				<table class="table">
					<thead><tr>
					<th>Employee Name</th>
					<th>Entry Slip No.</th>
					<th>Employee ID</th>
					<th>Post</th>
					<th>Basic</th>
					<th>Absent</th>
					<th>DA</th>
					<th>Gross Basic</th>
					<th>PF(S)</th>
					<th>PF(E)</th>
					<th>PA</th>
					<th>Gross Salary</th>
					<th>ESIC(S)</th>
					<th>ESIC(E)</th>
					<th>Advance</th>
					<th>TDS</th>
					<th>T.Ded(S)</th>
					<th>T.Ded(E)</th>
					<th>TDS</th>
					<th>Net Salary</th>
					<th>Print</th>
					</tr>
					</thead>
					<tbody id="">
					<tr>
						<td>Ramesh Singh</td>
						<td>1444</td>
						<td>T124</td>
						<td>PGT</td>
						<td>12000</td>
						<td>0</td>

						<td>10800</td>
						<td>22800</td>
						<td>1800</td>
						<td>1800</td>
						<td>400</td>
						<td>23200</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>1800</td>
						<td><b>21400</b></td>
						<td><button class="btn btn-sm btn-success">Print</button></td>						
					</tr>
				</tbody>
				</table>	
			</div>
 		</div>

		
	</div>
</div>