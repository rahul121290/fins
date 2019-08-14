<div class="content-wrapper">
<section class="content-header">
      <h1>Hostel <small>Student Hostel Fee</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Student Hostel Fee</li>
      </ol>
    </section>
    <section class="content-header">
 </section>

<!-- main section -->
<div class="col-md-12">	
  	<div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Student Filter</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<form id="class_wise_fee_details" action="javascript:void(0);" method="POST" role="form">
    	
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    	
      			<div class="form-group" style="margin-bottom:0px;">
      				<div class="col-sm-2 mb-3">
						<select name="session" id="session" class="form-control">
							<option value="">Select Session</option>
							<option value="3" selected>2019-20</option>
						</select>
						<div id="session_err" style="display:none; color:red;"></div>
					</div>
					<div class="col-sm-2 mb-3">
						<select name="school" id="school" class="form-control">
							<option value="">Select Board</option>
							<option value="1" selected>Shakuntala CBSE</option>
							<option value="3">CG State Board</option>
							<option value="2">Sharda</option>
						</select>
						<div id="school_err" style="display:none; color:red;"></div>
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
					<div class="col-sm-2 mb-3">
						<select class="form-control" id="class_name" name="class_name">
							<option value="">Select Class</option>
							<?php foreach($class as $classes){?>
								<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
							<?php } ?>
						</select>
						<div id="class_name_err" style="display:none; color:red;"></div>
					</div>
					
					
					<div class="col-sm-2 mb-3">
						<select name="section" id="" class="form-control">
							<option value="">Select Allotted Hostel</option>
								<option value="1">Hostel 1</option>
								<option value="2">Hostel 2</option>
						</select>
						<div id="section_err" style="display:none; color:red;"></div>
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
              <h3 class="box-title"><b>Shakuntala Gurukul XI Fee List</b></h3>
            </div>
      		     <div class="box-body">
  					<table class="table table-responsive">
						<thead><tr>
						<th>S.No.</th>
						<th>Admission No.</th>
						<th>Student Name</th>
                          <th>Father's Name</th>
                          <th>Pending Month</th>
                          <th>Pending Fee</th>
                          <th>Received Fee</th>
                          <th>Total Fee</th>
                          <th>Action</th>
                        </tr>
                    </thead>
					<tbody id="student_list">
						<tr>
							<td>01.</td>
							<td>145</td>
							<td>Naresh kumar</td>
							<td>Ramesh</td>
							<td>Rs. 1452.00/-</td>
							<td>Rs. 1452.00/-</td>
							<td>Rs. 1487.00/-</td>
							<td>Rs. 8487.00/-</td>
							<td><button class="btn btn-info btn-sm">Pay Now</button></td>
						</tr>
					</tbody>
				</table>
      		</div>
 		</div>
	</div>
</div>
		
