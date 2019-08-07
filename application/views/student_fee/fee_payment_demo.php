<style>
.skin-blue .main-header .navbar{padding:10px;}
.mb-3{margin-bottom:15px;}
</style>
<div class="content-wrapper">
<section class="content-header">
      <h1>Reception</h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Student Fee Payment</li>
      </ol>
    </section>
    <section class="content-header">
    </section>
	<!-- main section -->
    <div class="col-md-6">	
      	<div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Student Details</h3>
            </div>
        	<div class="box-body form-horizontal">
        		<input type="hidden" id="ses_id" value="<?php echo $this->uri->segment(5);?>">
        		<input type="hidden" id="sch_id" value="<?php echo $this->uri->segment(6);?>">
        		<input type="hidden" id="med_id" value="<?php echo $this->uri->segment(7);?>">
        		<input type="hidden" id="adm_no" value="<?php echo $this->uri->segment(8);?>">
        		
        		<div id="student_details">
					<table class="table">
						<tbody>
						<tr><td><b>Student Name</b></td><td>: Nitesh kumar</td>
							<td><b>Father Name</b></td><td>: Mr. Shankar</td>
						</tr><tr>
							<td><b>Admission No.</b></td><td>: 1213</td>
    						<td><b>Roll No.</b></td><td>: 11524</td>
							</tr><tr>
    						<td><b>Class/Section</b></td><td>: VI/A</td>
    						<td><b>Student Fee Category</b></td><td>: General</td>
							</tr><tr>
							<td><b>Medium</b></td><td>: English</td>
    						<td><b></b></td><td></td>
    					</tr>
						</tbody>
					</table>
				</div>
        		
    		</div><!-- end box body -->
 		</div>	
	</div> 
	
	 <div class="col-md-6">	
      	<div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Once in a session</h3>
            </div>
        	<div class="box-body form-horizontal">
        		<div id="one_time_fee">
					<table class="table">
						<thead>
							<tr><th>Heads</th><th>Amount</th><th>Actions</th><th>Status</th></tr>
						</thead>
						<tbody>
							<tr><td><b>Admission Fee</b></td><td>9000</td><td><input type="checkbox" /></td><td>Paid</td></tr>
							<tr><td><b>Amalgamated Fund</b></td><td>4000</td><td><input type="checkbox" /></td><td>Paid</td></tr>
							<tr><td><b>Lab Fee</b></td><td>00.00</td><td><input type="checkbox" /></td><td>Paid</td></tr>
							<tr><td><b>Optional Sub Fee</b></td><td>00.00</td><td><input type="checkbox" /></td><td>Paid</td></tr>
						</tbody>
					</table>
				</div>
        		
    		</div><!-- end box body -->
 		</div>	
	</div> 
	
	<div class="col-md-12">	
      	<div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Monthly Fee</h3>
            </div>
        	<div class="box-body form-horizontal">
        		<div class="month-fee-table" id="month_fee">
				<table class="table">
				<thead><tr><th>Select All</th><th>Fee Month</th><th>Tution Fee</th><th>Bus Fee</th><th>Late Fee</th><th>Due Date</th><th>Total Fee</th></tr></thead>
				<tbody>
				<tr><td><input type="checkbox"></td><td>April + May</td><td> 4240.00</td><td>1880.00</td><td>200.00</td><td>15-04-2019</td><td>6300.00</td></tr>
				<tr><td><input type="checkbox"></td><td>June</td><td>4240.00</td><td>1880.00</td><td>200.00</td><td>15-04-2019</td><td>6300.00</td></tr>
				<tr><td><input type="checkbox"></td><td>July</td><td>4240.00</td><td>1880.00</td><td>200.00</td><td>15-04-2019</td><td>6300.00</td></tr>
				<tr><td><input type="checkbox"></td><td>August</td><td>4240.00</td><td>1880.00</td><td>200.00</td><td>15-04-2019</td><td>6300.00</td></tr>	
				
				<tr><td><input type="checkbox"></td><td>September</td><td>4240.00</td><td>1880.00</td><td>200.00</td><td>15-04-2019</td><td>6300.00</td></tr>
				<tr><td><input type="checkbox"></td><td>October</td><td>4240.00</td><td>1880.00</td><td>200.00</td><td>15-04-2019</td><td>6300.00</td></tr>
				
				
				</tbody>
				</table>
				</div>
        		<hr>
				<div class="col-md-6">
					<div style="padding-left:0px;" class="box-header ">
						 <h3 class="box-title">Fee Waiver</h3>
					</div>
					<div class="fee-waiver-box">
						<input class="form-control" type="text" />
						<a href="" class="btn btn-info apply-btn">Apply</a>
						
						<!--<input disabled class="form-control" type="text" />
						<a href="" class="btn btn-success apply-btn">Approved</a>-->
						<br>
						
						<div class="col-md-6" style="padding-left:0px;position:relative;">
						<input class="form-control" type="text" placeholder="Type OTP" />
						<a href="" class="resend-otp">Resend OTP</a>
						<a href="" class="btn btn-success submit-otp">Submit Now</a>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="box-header">
						 <h3 class="box-title">Total Fee</h3>
					</div>
					<div class="fee-tottal-box">
						4000.00/-
					</div>
					<a href="" class="btn btn-success btn-lg pull-right" style="margin-right:10px;">Submit</a>
				</div>
    		</div><!-- end box body -->
 		</div>	
	</div>  
	<div class="col-md-12">	
      	<div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Payment Method</h3>
            </div>
        	<div class="box-body form-horizontal payment-method-box">
				<table class="table">
					<thead><tr><th></th><th></th><th></th><th></th><th></th></tr></thead>
					<tbody>
					<tr>
						<td><input class="form-check-input" type="checkbox" /><td>
						<td><b>Cash</b></td>
						<td><input class="form-control" type="text" placeholder="Amount type" /></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><input class="form-check-input" type="checkbox" /><td>
						<td><b>Cheque</b></td>
						<td><input class="form-control" type="text" placeholder="Amount type" /></td>
						<td><input class="form-control" type="text" placeholder="Bank name" /></td>
						<td><input class="form-control" type="text" placeholder="Cheque no." /></td>
						<td></td>
					</tr>
					<tr>
						<td><input class="form-check-input" type="checkbox" /><td>
						<td><b>DD(Demand Draft)</b></td>
						<td><input class="form-control" type="text" placeholder="Amount type" /></td>
						<td><input class="form-control" type="text" placeholder="Bank name" /></td>
						<td><input class="form-control" type="text" placeholder="DD(Demand Draft) no." /></td>
						<td></td>
					</tr>
					<tr>
						<td><input class="form-check-input" type="checkbox" /><td>
						<td><b>POS Machine</b></td>
						<td>
							<select class="form-control">
								<option>Select One</option>
								<option>Credit Card</option>
								<option>Debit Card</option>
							</select>
						</td>
						<td><input class="form-control" type="text" placeholder="Amount" /></td>
						<td><input class="form-control" type="text" placeholder="GST" /></td>
						<td></td>
					</tr>
					</tbody>
				</table>
				<hr>
				<div style="margin-left:5%;" class="col-md-5 fee-tottal-box">
					<div class="pull-left">Grand Total</div>
					<div class="pull-right ">
						4000.00/-
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

