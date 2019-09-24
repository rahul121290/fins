<div class="content-wrapper">
<section class="content-header" style="margin-bottom:10px;">
      <h1>Salary History</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/payroll/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Salary History</li>
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
						<select class="form-control" name="" id="">
							<option value="">Select Employee Type</option>
							<option value="1">Teacher</option>
							<option value="3">Peon + Helper + Driver</option>
							<option value="3">Shakuntala Group</option>
						</select>
						<div id="" style="display:none; color:red;"></div>
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
							<option value="">Select Payment Mode</option>
							<option value="1">Cash</option>
							<option value="3">Bank</option>
							<option value="3">Cheque</option>
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
		<div class="box box-primary">
			<div class="box-body text-center" style="font-size:18px;color:#e24e08;border:1px solid #ddd;width:100%;background-color:#fff;margin-bottom:20px;">
			<div class="col-md-4" style="border-right:1px solid #ddd;width:33%;float:left;font-size:17px;">
					<b style="color:#5d5c5c;">Paid Pay Amount</b><br>
					<b>Rs. 14254</b><b id="total_fee"></b>/-
				</div>
				
				<div class="col-md-4" style="border-right:1px solid #ddd;width:33%;float:left;font-size:17px;">
					<b style="color:#5d5c5c;">Pending Pay Amount</b><br>
					<b>Rs. 254874</b><b id="received_fee"></b>/-
				</div>
				<div class="col-md-4" style="width:33%;float:left;font-size:17px;">
					<b style="color:#5d5c5c;">Total Pay Amount</b><br>
					<b>Rs. 582455</b><b id="pending_fee"></b>/-
				</div>
				
			</div>
		</div>
		
		
		
		
		<div class="print-s-logo" style="float:left;padding:0px 0px 5px 0px;width:100%;margin-bottom:10px;">
				<div class="text-center" style="float:left;">
					<img class="pull-left" alt="" src="../images/shakuntala/shakuntala.png" height="40" />
					<div class="print-s-name" >
						<h4><b>Shakuntala Vidyalaya</b></h4>
						<p>Ram Nagar Bhilai(C.G.)</p>
					</div>
					
				</div>
				<div class="text-right">
					<h4 style="margin-bottom:0px;"><b>Shakuntala Employee Payment History</b></h4>
				</div>
		</div>
		
	
		<div class="box box-info">
            <div class="box-header no-print">
              <h3 class="box-title"><b>Shakuntala Employee Payment History</b></h3>
            </div>
      		<div class="box-body p-table-bg-head p-table-body table-responsive">
				<table class="table">
					<thead><tr>
					<th>S.No.</th>
					<th>School Name</th>
					<th>Employee Type</th>
					<th>Employee Name</th>
					<th>Payment Mode</th>
					<th>Account Detail</th>
					<th>Payment Month</th>
					<th>Net Salary</th>
					<th>Status</th>
					<th>Action</th>
					</tr>
					</thead>
					<tbody id="">
					<tr>
						<td>01.</td>
						<td>Shakuntala Vidyalaya</td>
						<td>Teacher</td>
						<td>Sunita Sharma</td>
						<td>Bank</td>
						<td>1524-1254-14528</td>
						<td>July</td>
						<td>22800</td>
						<td><a class="btn btn-sm btn-info" data-toggle="modal" data-target="#editEmployee">Piad</a> <button class="btn btn-sm btn-danger">Pending</button></td>
						<td><button class="btn btn-sm btn-success">Reprint</button> </td>
					</tr>
					<tr>
						<td>02.</td>
						<td>Shakuntala Vidyalaya</td>
						<td>Teacher</td>
						<td>Anita</td>
						<td>Bank</td>
						<td>1524-1254-14528</td>
						<td>July</td>
						<td>22800</td>
						<td><a class="btn btn-sm btn-info" data-toggle="modal" data-target="#editEmployee">Piad</a> <button class="btn btn-sm btn-danger">Pending</button></td>
						<td><button class="btn btn-sm btn-success">Reprint</button> </td>
					</tr>
					<tr>
						<td>02.</td>
						<td>Shakuntala Vidyalaya</td>
						<td>Teacher</td>
						<td>Smita</td>
						<td>Bank</td>
						<td>1524-1254-14528</td>
						<td>July</td>
						<td>22800</td>
						<td><a class="btn btn-sm btn-info" data-toggle="modal" data-target="#editEmployee">Piad</a> <button class="btn btn-sm btn-danger">Pending</button></td>
						<td><button class="btn btn-sm btn-success">Reprint</button> </td>
					</tr>
					<tr>
						<td>02.</td>
						<td>Shakuntala Vidyalaya</td>
						<td>Teacher</td>
						<td>Sweta Sharma</td>
						<td>Bank</td>
						<td>1524-1254-14528</td>
						<td>July</td>
						<td>22800</td>
						<td><a class="btn btn-sm btn-info" data-toggle="modal" data-target="#editEmployee">Piad</a>  <button class="btn btn-sm btn-danger">Pending</button></td>
						<td><button class="btn btn-sm btn-success">Reprint</button> </td>
					</tr>
					</tbody>
				</table>
      		</div>
 		</div>
		<div class="">
			<div class="text-center"><button class="btn btn-space btn-primary no-print" style="margin-bottom:50px;" onclick="printDiv()">Print this page</button></div>
		</div>
	</div>
</div>