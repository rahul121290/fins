<div class="content-wrapper">
<section class="content-header">
      <h1>Reception</h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Student Fee Details</li>
      </ol>
    </section>
    <section class="content-header">
    </section>
	<!-- main section -->
    <div class="col-md-12">	
      	<div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Student Details</h3>
            </div>
        	<div class="box-body form-horizontal">
        		<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
        		<input type="hidden" id="ses_id" value="<?php echo $this->uri->segment(5);?>" />
        		<input type="hidden" id="sch_id" value="<?php echo $this->uri->segment(6);?>" />
        		<input type="hidden" id="med_id" value="<?php echo $this->uri->segment(7);?>" />
        		<input type="hidden" id="adm_no" value="<?php echo $this->uri->segment(8);?>" />
        		<input type="hidden" id="current_month" value="<?php echo date('m');?>" />
        		<input type="hidden"  id="all_late_fee" value="0.00" />
        		
        		<input type="hidden"  id="student_name" value="" />
        		<input type="hidden"  id="contact_no" value="" />
        		
        		<div id="">
					<table class="table">
						<tbody>
						<tr><td><b>Student Name</b> : Nitesh kumar</td><td></td>
							<td><b>Father Name</b> : Mr. Shankar</td><td></td>
					
							<td><b>Admission No.</b> : 1213</td><td></td>
    						<td><b>Roll No.</b> : 11524</td><td></td>
							</tr>
						</tbody>
					</table>
				</div>
        		
    		</div><!-- end box body -->
 		</div>	
	</div> 
	<div class="col-md-12">
	<div class="box box-primary">
					<div class="box-body text-center" style="font-size:18px;color:#e24e08;">
						<div class="col-md-4" style="border-right:1px solid #ddd;">
							<b style="color:#5d5c5c;">Received Fee</b><br>
							<b>Rs. 4500.00/-</b>
						</div>
						<div class="col-md-4" style="border-right:1px solid #ddd;">
							<b style="color:#5d5c5c;">Pending Fee</b><br>
							<b>Rs. 5500.00/-</b>
						</div>
						<div class="col-md-4">
							<b style="color:#5d5c5c;">Total Fee</b><br>
							<b>Rs. 10000.00/-</b>
						</div>
					</div>
				</div>
	</div>
	
	<div class="col-md-12">	
      	<div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Fee History</h3>
            </div>
        	<div class="box-body form-horizontal">
        		<div class="month-fee-table">
				<table class="table">
					<thead>
						<tr>
							<th>Head</th>
							<th>Amount</th>
							<th>Late Fee</th>
							<th>Bus Fee</th>
							<th>Status</th>
						</tr>
					</thead>
				<tbody id="">
					<tr><td><b>Admission Fee</b></td><td>9000.00</td><td>00.00</td><td>-</td><td>Paid</td></tr>
					<tr><td><b>Amalgamated Fund</b></td><td>4000.00</td><td>00.00</td><td>-</td><td>Paid</td></tr>
					<tr><td><b>Lab Fee</b></td><td>00.00</td><td>00.00</td><td>-</td><td>Paid</td></tr>
					<tr><td><b>Optional Sub Fee</b></td><td>00.00</td><td>00.00</td><td>-</td><td>Paid</td></tr>
					<tr><td><b>June-July</b></td><td>1500.00</td><td>50.00</td><td>850.00</td><td>Paid</td></tr>
					<tr><td><b>Aug</b></td><td>1500.00</td><td>00.00</td><td>850.00</td><td>Pending</td></tr>
					<tr><td><b>Sep</b></td><td>1500.00</td><td>00.00</td><td>850.00</td><td>Pending</td></tr>
					<tr><td><b>Oct</b></td><td>1500.00</td><td>00.00</td><td>850.00</td><td>Pending</td></tr>
					<tr><td><b>Nov</b></td><td>1500.00</td><td>00.00</td><td>850.00</td><td>Pending</td></tr>
					<tr><td><b>Dis</b></td><td>1500.00</td><td>00.00</td><td>850.00</td><td>Pending</td></tr>
				</tbody>
				</table>
				</div>
    		</div><!-- end box body -->
 		</div>	
	</div>  
</div>