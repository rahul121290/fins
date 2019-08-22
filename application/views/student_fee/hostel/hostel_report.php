<div class="content-wrapper">
<section class="content-header">
      <h1>Hostel <small>Hostel Fee Report</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Hostel Fee Report</li>
      </ol>
    </section>
    <section class="content-header">
 </section>

<!-- main section -->
<div class="col-md-12">	
  	<div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Hostel Fee Filter</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<form id="class_wise_fee_details" action="javascript:void(0);" method="POST" role="form">
    	
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    	
      			<div class="form-group" style="margin-bottom:0px;">
      				<div class="col-sm-2 mb-3">
						<label>Select Session</label>
						<select name="session" id="session" class="form-control">
							<option value="">Select Session</option>
							<option value="3" selected>2019-20</option>
						</select>
						<div id="session_err" style="display:none; color:red;"></div>
					</div>
					<div class="col-sm-2 mb-3">
						<label>Select Board</label>
						<select name="school" id="school" class="form-control">
							<option value="">Select Board</option>
							<option value="1" selected>Shakuntala CBSE</option>
							<option value="3">CG State Board</option>
							<option value="2">Sharda</option>
						</select>
						<div id="school_err" style="display:none; color:red;"></div>
					</div>					
					
					<div class="col-sm-2 mb-3">
						<label>Select Allotted Hostel</label>
						<select name="section" id="" class="form-control">
							<option value="">Select Allotted Hostel</option>
								<option value="1">Hostel 1</option>
								<option value="2">Hostel 2</option>
						</select>
						<div id="" style="display:none; color:red;"></div>
					</div>
					<div class="col-sm-2 mb-3">
						<label>To Date</label>
						<input type="date" class="form-control" />
						<div id="" style="display:none; color:red;"></div>
					</div>
					<div class="col-sm-2 mb-3">
						<label>From Date</label>
						<input type="date" class="form-control" />
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
			<div class="box-body text-center" style="font-size:18px;color:#e24e08;">
				<div class="col-md-4" style="border-right:1px solid #ddd;">
					<b style="color:#5d5c5c;">Received Fee</b><br>
					<span id="paid_fee"><b>0.00</b></span>
				</div>
				<div class="col-md-4" style="border-right:1px solid #ddd;">
					<b style="color:#5d5c5c;">Pending Fee</b><br>
					<span id="pending_fee"><b>0.00</b></span>
				</div>
				<div class="col-md-4">
					<b style="color:#5d5c5c;">Total Fee</b><br>
					<span id="total_fee"><b>0.00</b></span>
				</div>
			</div>
		</div>
	
		<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title"><b>Shakuntala Gurukul Fee</b></h3>
            </div>
      		<div class="box-body">
				<table class="table table-responsive">
					<thead><tr>
					<th>S.No.</th>
					<th>Board</th>
					<th>Hostel</th>
					<th>Month/Day</th>
					<th>All Hostel Fee</th>

					</tr>
					</thead>
					<tbody id="student_list">
					<tr>
						<td>01.</td>
						<td>Shakuntala CSBE</td>
						<td>Hostel 1</td>
						<td>Rs.145000.00/-</td>
						<td>Rs.2,45000.00/-</td>
					</tr>
					</tbody>
				</table>
      		</div>
 		</div>
		
		<div class="box box-info">
			 <div class="box-header text-center">
              <h3><b>SHAKUNTALA GURUKUL</b></h3>
			  <p>Bhilai C.G 490023</p>
            </div>
      		<div class="box-body">
			
				<table class="table table-responsive">
					<thead><tr>
					<th>S.No.</th>
					<th>Particulars</th>
					<th>Sac Code</th>
					<th>Qty.</th>
					<th>All Hostel Fee</th>

					</tr>
					</thead>
					<tbody id="student_list">
					<tr>
						<td>01.</td>
						<td>Shakuntala CSBE</td>
						<td>Hostel 1</td>
						<td>Rs.145000.00/-</td>
						<td>Rs.2,45000.00/-</td>
					</tr>
					</tbody>
				</table>
      		</div>
		</div>
		
	</div>
</div>
		
