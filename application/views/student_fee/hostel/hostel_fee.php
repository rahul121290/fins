<div class="content-wrapper">
<section class="content-header">
      <h1>Hostel <small>Student Hostel Fee</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Student Hostel Fee</li>
      </ol>
    </section>
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/custom/hostel_fee_payment.js"></script>
    <input type="hidden" id="ses_id" value="<?php echo $this->uri->segment(5);?>">
    <input type="hidden" id="sch_id" value="<?php echo $this->uri->segment(6);?>">
    <input type="hidden" id="medium" value="<?php echo $student_details[0]['medium'];?>">
    <input type="hidden" id="adm_no" value="<?php echo $this->uri->segment(7);?>">
    
    <div class="col-md-12">
	<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Student Details</h3>
			  <hr>
			</div>
			
			<div class="box-body">
				<div class="col-md-6">
					<table>
						<thead>
							<tr>
								<th>Student Name: </th>
								<td><?php echo $student_details[0]['name'];?></td>
							</tr>
							<tr>
								<th>Student Name: </th>
								<td><?php echo $student_details[0]['name'];?></td>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
</div>
    
    <form role="form" action="javascript:void(0);" class="form-horizontal" id="hostel_fee_form" method="POST">
    <div class="col-md-12">
	<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Payment</h3>
			  <hr>
			</div>
			
			<div class="box-body">
				<div class="col-md-6">
				
					<div class="form-group mb-3">
						<label class="col-sm-6">Pay Month</label>
						<div class="col-sm-6">
							<select class="form-control" name="pay_month" id="pay_month">
								<option value="">Select Month</option>
								<option value="1">March/April <?php echo date('Y');?></option>
								<option value="2">September <?php echo date('Y');?></option>
							</select>
							<div id="pay_month_err" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					
					<div class="form-group mb-3">
						<label class="col-sm-6">Total Amount</label>
						<div class="col-sm-6">
							<input type="number" id="total_fee" name="total_fee" class="form-control" placeholder="Total Amount" disabled="disabled">
							<div id="total_fee_err" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					
					<div class="form-group mb-3">
						<label class="col-sm-6">Previus Paid</label>
						<div class="col-sm-6">
							<input type="number" id="previous_paid" name="previous_paid" value="0.00" class="form-control" placeholder="previous Paid" disabled="disabled">
							<div id="previous_paid_err" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					
					<div class="form-group mb-3">
						<label class="col-sm-6">Pay Amount</label>
						<div class="col-sm-6">
							<input type="number" id="pay_amount" name="pay_amount" class="form-control" placeholder="Pay Amount">
							<div id="pay_amount_err" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					
					<div class="form-group mb-3" id="check_box_row" style="display: none;">
						<label class="col-sm-6"></label>
    					<div class="col-sm-6" id="check_box_div"></div>
    					<div class="col-sm-6" id="otp_div"></div>
					</div>
					
					<div class="form-group mb-3">
						<label class="col-sm-6">Pending Amount</label>
						<div class="col-sm-6">
							<input type="number" id="pending_amount" name="pending_amount" class="form-control" placeholder="Pending Amount" disabled="disabled">
							<div id="pending_amount_err" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					
				</div>
			</div>
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
						<td class="pm-box"><input class="form-check-input pay_method" id="cash" type="checkbox" /><span class="checkmark"></span><td>
						<td><b>Cash</b></td>
						<td><input class="form-control max_type" id="cash_amount" type="number" placeholder="Enter Amount" disabled="disabled" /></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td class="pm-box"><input class="form-check-input pay_method" id="cheque" type="checkbox" /><span class="checkmark"></span><td>
						<td><b>Cheque</b></td>
						<td><input class="form-control max_type" id="cheque_amount" type="number" placeholder="Cheque Amount" disabled="disabled" /></td>
						<td><input class="form-control" id="cheque_no" type="text" placeholder="Cheque No." disabled="disabled" /></td>
						<td><input class="form-control" id="cheque_date" type="date" placeholder="Date" disabled="disabled" /></td>
						<td><input class="form-control" id="cheque_bank" type="text" placeholder="Bank Name" disabled="disabled" /></td>
					</tr>
					<tr>
						<td class="pm-box"><input class="form-check-input pay_method" id="dd" type="checkbox" /> <span class="checkmark"></span><td>
						<td><b>DD(Demand Draft)</b></td>
						<td><input class="form-control max_type" id="dd_amount" type="number" placeholder="DD Amount" disabled="disabled" /></td>
						<td><input class="form-control" id="dd_no" type="text" placeholder="DD(Demand Draft) No." disabled="disabled" /></td>
						<td><input class="form-control" id="dd_date" type="date" placeholder="Date" disabled="disabled" /></td>
						<td><input class="form-control" id="dd_bank" type="text" placeholder="Bank Name" disabled="disabled" /></td>
					</tr>
					<tr>
						<td class="pm-box"><input class="form-check-input pay_method" id="pos" type="checkbox" /><span class="checkmark"></span><td>
						<td><b>POS</b></td>
						<td>
							<select class="form-control" id="pos_card" disabled="disabled">
								<option value="">Select One</option>
								<option value="credit_card">Credit Card</option>
								<option value="debit_card">Debit Card</option>
							</select>
							<div class="error" id="pos_card_err" style="display: none;"></div>
						</td>
						<td><input class="form-control max_type" id="pos_amount" type="number" placeholder="POS Amount" disabled="disabled" /></td>
						<td><input class="form-control" id="trns_charge" type="number" placeholder="Transaction Charge" disabled="disabled" /></td>
						<td></td>
					</tr>
					</tbody>
				</table>
				<hr>
				<div id="pay_method_amount"></div>
				<div style="margin-left:58%;" class="col-md-5 ">
					<div class="fee-tottal-box">
					<div class="pull-left" style="padding-top:5px;"><b>GRAND TOTAL FEE</b></div>
					<div class="pull-right"><input type="text" class="form-control totalinput" id="grand_total" value="0.00" disabled="disabled" /></div>
					</div>
					<button id="hostel_fee_submit" class="btn btn-lg btn-success pull-right">Submit</button>
				</div>
				
			</div>
		</div>
	</div>
	</form>
</div>