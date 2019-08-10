<div class="content-wrapper">
<section class="content-header">
      <h1>Reception <small>School Fee</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">School Fee</li>
      </ol>
    </section>
    <section class="content-header">
    </section>

    	<!-- main section -->
        <div class="col-md-12">	
          	<div class="box box-primary">
					<div class="box-body text-center" style="font-size:18px;color:#e24e08;">
						<div class="col-md-4" style="border-right:1px solid #ddd;">
							<b style="color:#5d5c5c;">Received Amount</b><br>
							<b>Rs. 100500.00/-</b>
						</div>
						<div class="col-md-4" style="border-right:1px solid #ddd;">
							<b style="color:#5d5c5c;">Pending Amount</b><br>
							<b>Rs. 55500.00/-</b>
						</div>
						<div class="col-md-4">
							<b style="color:#5d5c5c;">Total Amount</b><br>
							<b>Rs. 200000.00/-</b>
						</div>
					</div>
				</div>
				
			<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Search Filter</h3>
                </div>
            	<div class="box-body form-horizontal">
            	<form id="fee_form" action="javascript:void(0);" method="POST" role="form">
            	
            	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
            	
              			<div class="form-group col-md-12" style="margin-bottom:0px;">
              				<div class="col-sm-2 mb-3">
								<select name="session" id="session" class="form-control">
									<option value="0">Select Session</option>
									<option value="3" selected>2019-20</option>
								</select>
								<div id="session_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-2 mb-3">
								<select name="school" id="school" class="form-control">
									<option value="">Select Board</option>
    								<option value="1" selected>CBSE</option>
    								<option value="3">CG State Board</option>
								</select>
								<div id="school_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-2 mb-3">
								<select name="school" id="" class="form-control">
									<option value="">Select School Name</option>
    								<option value="1" selected>Shakuntala Vidyalaya</option>
    								<option value="2">Shakuntala Vidyalaya No.2</option>
    								<option value="3">Sharda Vidyalaya</option>
								</select>
								<div id="school_name" style="display:none; color:red;"></div>
							</div>
							
							<div class="col-sm-2 mb-3">
								<select name="school" id="" class="form-control">
									<option value="">Select Payment Mode</option>
    								<option value="1">Credit Card</option>
    								<option value="2">Debit Card</option>
    								<option value="3">Cheque</option>
    								<option value="3">DD(Demand Draft)</option>
    								<option value="3">POS</option>
								</select>
								<div id="school_name" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-2 mb-3" >
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
								    <option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
								<?php }?>
								</select>
								<div id="medium_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-2 mb-3" style="min-height:35px;padding-top:7px;">
								<input name="dailyReport" type="radio" /><label style="margin-right:20px;margin-left:10px;">Daily</label>
								<input name="dailyReport" type="radio" /><label style="margin-right:20px;margin-left:10px;">Datewise</label>
							</div>
							<div class="col-sm-2 mb-3">
								<label>From Date</label>
								<input type="date" class="form-control" />
							</div>
							<div class="col-sm-2 mb-3">
								<label>To Date</label>
								<input type="date" class="form-control" />
							</div>
							<div class="col-sm-2 mb-3 pm-box">
								<label style="font-size:15px;margin-left:15px;">Fine Collected</label>
								<input style="left:15px;top:9px;" type="checkbox" /><span style="left:15px;" class="checkmark"></span>
							</div>
							<div class="col-sm-2 mb-3 pm-box">
								<label style="font-size:15px;margin-left:15px;">Fee Waiver</label>
								<input style="left:15px;top:9px;" type="checkbox" /><span style="left:15px;" class="checkmark"></span>
							</div>

							<div class="col-md-2 mb-3">
								<button type="button" name="search" id="search" class="btn btn-info pull-left">Search</button>	
							</div>
					    </div>
					   
            		</form>	
        		</div><!-- end box body -->
     			</div>
				
				
			
				
				
				<div class="col-md-6 col-md-offset-3">
				<div class="box box-danger">
                    <div class="box-header" style="background-color: #881e1e;color: #fff;">
                      <h3 class="box-title"><b>Shakuntala Vidyalaya (2019-20)</b></h3>
					  <span class="pull-right"><b>Date: 10-Aug-2019</b></span>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    							
    						<tbody id="" style="font-size:16px;">
								<tr><td><b>Total Amount</b></td><td style="font-size:20px;font-weight:600;color:#e05411;">Rs. 1,50,000.00/-</td></tr>
								<tr><td><b>Received Amount</b></td><td style="font-size:20px;font-weight:600;color:#1b790f;">Rs. 1,20,00.00/-</td></tr>
								<tr><td><b>Pending Amount</b></td><td style="font-size:20px;font-weight:600;color:#a01010;">Rs. 30002.00/-</td></tr>
								<tr><td><b>Medium</b></td><td>English</td></tr>
								<tr><td><b>Payment Mode</b></td><td>Credit Card</td></tr>
								<tr><td><b>Fine Collected</b></td><td>Rs. 2560.00/-</td></tr>
								<tr><td><b>Fee Waiver</b></td><td>Rs. 6560.00/-</td></tr>
							</tbody>
    					</table>
              		</div>
         		</div>
         		</div>
   			</div>
   			   			
		</div>