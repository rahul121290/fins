<div class="content-wrapper">
<section class="content-header">
      <h1>Student Classwise Fee</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/reception/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Student Classwise Fee</li>
      </ol>
    </section>
    <section class="content-header">
 </section>
<script type="text/javascript" src="<?php echo base_url();?>/assets/js/custom/student_fee.js"></script>
<!-- main section -->
<div class="col-md-12">	
  	<div class="box box-danger no-print">
        <div class="box-header">
          <h3 class="box-title">Student Filter</h3>
        </div>
    	<div class="box-body form-horizontal no-print">
    	<form id="class_wise_fee_details" action="javascript:void(0);" method="POST" role="form">
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
      			<div class="form-group" style="margin-bottom:0px;">
      				<div class="col-sm-1 mb-3">
						<select name="session" id="session" class="form-control">
							<option value="">Select Session</option>
							<option value="3" selected>2019-20</option>
						</select>
						<div id="session_err" style="display:none; color:red;"></div>
					</div>
					<div class="col-sm-2 mb-3">
						<select name="school" id="school" class="form-control">
							<?php if($this->session->userdata('school_id') == 1){?>
							<option value="">Select Board</option>
							<option value="1" selected>Shakuntala CBSE</option>
							<option value="3">CG State Board</option>
							<?php }else if($this->session->userdata('school_id') == 2){?>
							<option value="2" selected>CBSE</option>
							<?php }?>
						</select>
						<div id="school_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-1 mb-3" >
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
						<select name="section" id="section" class="form-control">
							<option value="">Select Section</option>
							<?php foreach($section as $sec){?>
    							<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
    						<?php }?>
						</select>
						<div id="section_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-2 mb-3">
						<select name="fee_criteria" id="fee_criteria" class="form-control">
							<option value="">Select Criteria</option>
							<?php foreach($fee_criteria as $feecriteria){?>
    							<option value="<?php echo $feecriteria['fc_id'];?>"><?php echo $feecriteria['fc_name'];?></option>
    						<?php }?>
						</select>
						<div id="fee_criteria_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-md-2 mb-3">
						<button type="button" id="search" class="btn btn-success pull-left">Search</button>	
					</div>
			    </div>
    		</form>	
		</div><!-- end box body -->
		
		 <div class="box-body form-horizontal no-print">
            <div class="col-sm-3 mb-3 row">
    			<input type="text" id="search_box" name="search_box" class="form-control" placeholder="Enter Adm No / Student Name" />
    			<div id="seach_box_err" style="display:none; color:red;"></div>
    		</div>
		</div>
		
		</div>
		
		<!-- <div class="box box-primary">
			<div class="box-body text-center" style="font-size:18px;color:#e24e08;">
    				<div class="col-md-4" style="border-right:1px solid #ddd;">
    					<b style="color:#5d5c5c;">Total Fee</b><br>
    					<span id="total_fee"><b>0.00</b></span>
    				</div>
    			
				
				<div class="col-md-4" style="border-right:1px solid #ddd;">
					<b style="color:#5d5c5c;">Received Fee</b><br>
					<span id="paid_fee"><b>0.00</b></span>
				</div>
				
				<div class="col-md-4">
					<b style="color:#5d5c5c;">Pending Fee</b><br>
					<span id="pending_fee"><b>0.00</b></span>
				</div>
			</div>
		</div> -->
		<div class="print-s-logo" style="float:left;padding:0px 0px 5px 0px;width:100%;margin-bottom:10px;">
				<div class="text-center" style="float:left;">
					<?php if($this->session->userdata('school_id') == 1){ $school = 'shakuntala';?>
		<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" height="40" />
		<div class="print-s-name" >
			<h4><b>Shakuntala Vidyalaya</b></h4>
			<p>Ram Nagar Bhilai(C.G.)</p>
		</div>
      	<?php } else if($this->session->userdata('school_id') == 2){ $school = 'sharda';?>
      	<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/sharda/sharda_logo.png" height="40" />
		<div class="print-s-name" >
			<h4><b>Sharda Vidyalaya</b></h4>
			<p>Risali Bhilai(C.G.)</p>
		</div>
		<?php }else{ $school = 'cg-board';?>
		<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" height="40" />
		<div class="print-s-name" >
			<h4><b>Shakuntala Vidyalaya No. 2</b></h4>
			<p>Ram Nagar Bhilai(C.G.)</p>
		</div>
		<?php }?>
				</div>
				<div class="text-right">
					<h4 style="margin-bottom:0px;"><b>Student Classwise Fee List</b></h4>
				</div>
		</div>
		<div class="box box-info">
            <div class="box-header no-print">
              <h3 class="box-title">Student List</h3>
            </div>
      		     <div class="box-body p-table-body p-table-bg-head">
  					<table class="table table-responsive">
						<thead><tr>
						<th>S.No.</th>
						<th>Admission No.</th>
						<th>Class/Sec</th>
						<th>Student Name</th>
                          <th>Father's Name</th>
                          <th>Bus</th>
                          <th>Pending Month</th>
                          <th>Fee Criteria</th>
                          <th>Staff Child</th>
                          <th>Total Fee</th>
                          <th>Received Fee</th>
                          <th>Pending Fee</th>
                          <th>Action</th>
                        </tr>
                    </thead>
					<tbody id="student_list"><tr><td colspan="13" style="text-align:center;">Record not found.</td></tr></tbody>
				</table>
      		</div>
 		</div>
		<div class="col-md-12">
			<div class="text-center"><button class="btn btn-space btn-primary no-print" style="margin-bottom:50px;" onclick="printDiv()">Print this page</button></div>
		</div>
	</div>
</div>

<script>
function printDiv() {
  window.print();
}
</script>