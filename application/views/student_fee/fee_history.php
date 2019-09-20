<div class="content-wrapper">
<section class="content-header no-print">
      <h1>School Fee MIS</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/reception/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">School Fee MIS</li>
      </ol>
    </section>
    <section class="content-header">
    </section>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/custom/fee_history.js"></script>
    	<!-- main section -->
<div class="col-md-12">	
  	<div class="print-s-logo" style="float:left;padding:0px 0px 5px 0px;width:100%;margin-bottom:10px;">
				<div class="text-center" style="float:left;">
					<?php if($this->session->userdata('school_id') == 1){ $school = 'shakuntala';?>
		<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" height="40" />
		<div class="print-s-name" >
			<h4><b>Shakuntala Gurukul</b></h4>
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
					<h4 style="margin-bottom:0px;"><b>School Fee MIS</b></h4>
				</div>
		</div>
	<div class="box box-primary" >
			<div class="box-body text-center" style="font-size:18px;color:#e24e08;border:1px solid #ddd;float:left;width:100%;background-color:#fff;margin-bottom:20px;">
			<div class="col-md-4" style="border-right:1px solid #ddd;width:33%;float:left;font-size:17px;">
					<b style="color:#5d5c5c;">Total Amount</b><br>
					<b>Rs. </b><b id="total_fee"></b>/-
				</div>
				
				<div class="col-md-4" style="border-right:1px solid #ddd;width:33%;float:left;font-size:17px;">
					<b style="color:#5d5c5c;">Received Amount</b><br>
					<b>Rs. </b><b id="received_fee"></b>/-
				</div>
				<div class="col-md-4" style="width:33%;float:left;font-size:17px;">
					<b style="color:#5d5c5c;">Pending Amount</b><br>
					<b>Rs. </b><b id="pending_fee"></b>/-
				</div>
				
			</div>
		</div>
		
	<div class="box box-danger no-print" style="float:left;">
        <div class="box-header">
          <h3 class="box-title">Search Filter</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<form id="fee_form" action="javascript:void(0);" method="POST" role="form">
    	
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    	
    	<!-- <div class="col-sm-2 mb-3" style="min-height:35px;padding-top:7px;">
						<input name="dailyReport" type="radio" /><label style="margin-right:20px;margin-left:10px;">Daily</label>
						<input name="dailyReport" type="radio" /><label style="margin-right:20px;margin-left:10px;">Datewise</label>
					</div> -->
		
      			<div class="form-group col-md-12" style="margin-bottom:0px;">
      				<div class="col-sm-2 mb-3">
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
					
					<div class="col-sm-2 mb-3" >
						<select name="medium" id="medium" class="form-control">
							<option value="">Select Medium</option>
							<option value="1">English</option>
							<option value="2">Hindi</option>
						</select>
						<div id="medium_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-2 mb-3">
						<input type="date" id="from_date" min="2019-04-01" max="<?php echo date('Y-m-d');?>" value="<?php echo date('Y-m-d');?>" class="form-control" />
					</div>
					<div class="col-sm-2 mb-3">
						<input type="date" id="to_date" min="2019-04-01" max="<?php echo date('Y-m-d');?>" value="<?php echo date('Y-m-d');?>" class="form-control" />
					</div>
					
					<!-- <div class="col-sm-2 mb-3 pm-box">
						<label style="font-size:15px;margin-left:15px;">Fine Collected</label>
						<input style="left:15px;top:9px;" type="checkbox" /><span style="left:15px;" class="checkmark"></span>
					</div>
					<div class="col-sm-2 mb-3 pm-box">
						<label style="font-size:15px;margin-left:15px;">Fee Waiver</label>
						<input style="left:15px;top:9px;" type="checkbox" /><span style="left:15px;" class="checkmark"></span>
					</div> -->
			    </div>
			   
    		</form>	
		</div><!-- end box body -->
		</div>
		
		<div class="col-md-6 col-md-offset-3 p-full-w" style="float:left;padding:0px;">
		<div class="box box-danger">
            <div class="box-header fee-table-head" style="background-color: #881e1e;color: #fff;">
              <h3 class="box-title"><b>Shakuntala Vidyalaya (2019-20)</b></h3>
			  <span class="pull-right"><b>Date Range: <span id="date_range"></span></b></span>
            </div>
      		     <div class="box-body fee-table-body" id="fee_report_table"></div>
 		</div>
		<div class="text-center"><button class="btn btn-space btn-primary no-print" style="margin-bottom:50px;" onclick="printDiv()">Print this page</button></div>
 		</div>
	</div>
<script>
function printDiv() {
  window.print();
}
</script>
</div>