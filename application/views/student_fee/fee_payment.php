<style>
.skin-blue .main-header .navbar{padding:10px;}
.mb-3{margin-bottom:15px;}
</style>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/custom/fee_payment.js"></script>
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
        		<input type="hidden" id="ses_id" value="<?php echo $this->uri->segment(5);?>" />
        		<input type="hidden" id="sch_id" value="<?php echo $this->uri->segment(6);?>" />
        		<input type="hidden" id="med_id" value="<?php echo $this->uri->segment(7);?>" />
        		<input type="hidden" id="adm_no" value="<?php echo $this->uri->segment(8);?>" />
        		<input type="hidden" id="current_month" value="<?php echo date('m');?>" />
        		<input type="hidden"  id="all_late_fee" value="0.00" />
        		
        		<div id="student_details"></div>
        		
    		</div><!-- end box body -->
 		</div>	
	</div> 
	
	 <div class="col-md-6">	
      	<div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Once in a session</h3>
            </div>
        	<div class="box-body form-horizontal">
				<table class="table">
					<thead>
						<tr><th>Actions</th><th>Heads</th><th>Amount</th><th>Status</th></tr>
					</thead>
					<tbody id="one_time_fee"></tbody>
				</table>
    		</div><!-- end box body -->
 		</div>	
	</div> 
	
	<div class="col-md-12">	
      	<div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Monthly Fee</h3>
            </div>
        	<div class="box-body form-horizontal">
        		<div class="month-fee-table">
				<table class="table">
					<thead>
						<tr>
							<th><input type="checkbox" id="all_month"> All</th>
							<th>Fee Month</th>
							<th>Tution Fee</th>
							<th>Bus Fee</th>
							<th>Due Date</th>
							<th>Late Fee</th>
							<th>Total Fee</th>
						</tr>
					</thead>
				<tbody id="month_fee"></tbody>
				</table>
				</div>
        		<hr>
				<div class="col-md-6">
					<div style="padding-left:0px;" class="box-header ">
						 <h3 class="box-title">Fee Waiver</h3>
					</div>
					<div class="fee-waiver-box">
						<input class="form-control" type="number" id="fee_waiver_amount" placeholder="Enter Amount" />
						<div class="error" id="fee_waiver_amount_err" style="display: none;"></div>
						<button class="btn btn-info apply-btn" id="fee_waiver_apply">Apply</button>
						
						<div class="col-md-6" id="fee_waiver_otp_row" style="padding-left:0px;position:relative; display:none;">
						
						<input class="form-control" id="fee_waiver_otp" type="number" placeholder="Type OTP" />
						<div class="error" id="fee_waiver_otp_err" style="display: none;"></div>
						
						<a href="javascript:void(0);" id="resend_otp" class="resend-otp">Resend OTP</a>
						<button id="otp_submit" class="btn btn-success submit-otp">Submit Now</button>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="box-header">
						 <h3 class="box-title">Total Fee</h3>
					</div>
					<div class="fee-tottal-box">
						<input type="text" class="form-control" id="fee_total" value="0.00" disabled="disabled">
					</div>
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
					<thead><tr><th></th><th></th><th></th><th></th><th></th><th></thead>
					<tbody>
					<tr>
						<td><input class="form-check-input pay_method" id="cash" type="checkbox" /><td>
						<td><b>Cash</b></td>
						<td><input class="form-control max_type" id="cash_amount" type="text" placeholder="Enter Amount" disabled="disabled" /></td>
						<td></td>
						<td></td>
						<td></td>
						
					</tr>
					<tr>
						<td><input class="form-check-input pay_method" id="cheque" type="checkbox" /><td>
						<td><b>Cheque</b></td>
						<td><input class="form-control max_type" id="cheque_amount" type="text" placeholder="Cheque Amount" disabled="disabled" /></td>
						<td><input class="form-control" id="cheque_no" type="text" placeholder="Cheque No." disabled="disabled" /></td>
						<td><input class="form-control" id="cheque_date" type="date" placeholder="Date" disabled="disabled" /></td>
						<td><input class="form-control" id="cheque_bank" type="text" placeholder="Bank Name" disabled="disabled" /></td>
					</tr>
					<tr>
						<td><input class="form-check-input pay_method" id="dd" type="checkbox" /><td>
						<td><b>DD(Demand Draft)</b></td>
						<td><input class="form-control max_type" id="dd_amount" type="text" placeholder="DD Amount" disabled="disabled" /></td>
						<td><input class="form-control" id="dd_no" type="text" placeholder="DD(Demand Draft) No." disabled="disabled" /></td>
						<td><input class="form-control" id="dd_date" type="date" placeholder="Date" disabled="disabled" /></td>
						<td><input class="form-control" id="dd_bank" type="text" placeholder="Bank Name" disabled="disabled" /></td>
					</tr>
					<tr>
						<td><input class="form-check-input pay_method" id="pos" type="checkbox" /><td>
						<td><b>POS</b></td>
						<td>
							<select class="form-control" id="pos_card" disabled="disabled">
								<option value="">Select One</option>
								<option value="credit_card">Credit Card</option>
								<option value="debit_card">Debit Card</option>
							</select>
							<div class="error" id="pos_card_err" style="display: none;"></div>
						</td>
						<td><input class="form-control max_type" id="pos_amount" type="text" placeholder="POS Amount" disabled="disabled" /></td>
						<td><input class="form-control" id="trns_charge" type="text" placeholder="Transaction Charge" disabled="disabled" /></td>
						<td></td>
					</tr>
					</tbody>
				</table>
				<hr>
				<div style="margin-left:5%;" class="col-md-5 fee-tottal-box">
					<div class="pull-left">Grand Total</div>
					<div class="pull-right"><input type="text" class="form-control" id="grand_total" value="0.00" disabled="disabled"></div>
				</div>
				<button id="submit" class="btn btn-success">Submit</button>
			</div>
		</div>
	</div>
</div>