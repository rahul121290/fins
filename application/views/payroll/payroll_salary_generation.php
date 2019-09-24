<div class="content-wrapper">
<section class="content-header">
      <h1>Employee Salary <small>Generate</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/payroll/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Employee Salary</li>
      </ol>
    </section>
    <input type="hidden" id="month" value="<?php echo $this->uri->segment(5);?>">
    <input type="hidden" id="emp_id" value="<?php echo $this->uri->segment(6);?>">
    <input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    <div class="col-md-6">
	<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Student Details</h3>
			</div>
			
			<div class="box-body">
					<table class="table">
						<tbody>
						<tr>
						<td><b>Student Name</b></td><td>:</td>
						<td><b>Father Name</b></td><td>:</td>
						</tr>
						<tr>
						<td><b>Admission No.</b></td><td>:</td>
						<td><b>Roll No.</b></td><td>:</td>
						</tr>
						<tr>
						<td><b>Class</b></td><td>:</td>
						<td><b>Student Fee Category</b></td><td>:</td>
						</tr>
						<tr>
						<td><b>Medium</b></td><td>:</td>
						<td><b>Contact No.</b></td><td>:</td>
						</tr>
						<tr>
						<td><b>Allotted Hostel</b></td><td>:</td>
						<td><b>School</b></td><td>:</td>
						</tr>
						</tbody>
					</table>
				
			</div>
		</div>
</div>
<div class="col-md-6">
	<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Student Paid Fee Detail</h3>
			</div>
			
			<div class="box-body">
					<table class="table">
						<thead>
							<tr>
								<th>Receipt No</th>
								<th>Pay Date</th>
								<th>Installment</th>
								<th>Paid Amount</th>
								<th>Paid GST</th>
								<th>Pending Amount</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
			</div>
		</div>
</div>
    
    <form role="form" action="javascript:void(0);" class="form-horizontal" id="hostel_fee_form" method="POST">
    <div class="col-md-12">
	<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Salary Generate</h3><hr></div>
			<div class="box-body">
				<table class="table">
					<thead>
						<tr>
    						<th>Basic</th>
    						<th>Advance</th>
    						<th>Net Basic</th>
    						<th>DA</th>
    						<th>Gross Basic</th>
    						<th>PF Samiti</th>
    						<th>PF Emp</th>
    						<th>PA</th>
    						<th>Gross Salary</th>
    						<th>ESIC Samiti</th>
    						<th>ESIC Emp</th>
    						<th>Advance</th>
    						<th>TDS</th>
    						<th>Net Salary</th>
						</tr>
					</thead>
					<tbody id=""></tbody>
				</table>
			</div>
		</div>
</div>
	</form>
</div>

<script type="text/javascript">

</script>

