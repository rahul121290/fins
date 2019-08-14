<div class="content-wrapper">
<section class="content-header">
      <h1>Hostel <small>Student Hostel Fee</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Student Hostel Fee</li>
      </ol>
    </section>
<form role="form" action="javascript:void(0);" class="form-horizontal" id="" method="POST">
<div class="col-md-12">
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
					<button id="submit" class="btn btn-lg btn-success pull-right">Submit</button>
				</div>
				
			</div>
		</div>
	</div>
	</form>
</div>