<div class="content-wrapper">
<section class="content-header">
      <h1>Hostel <small>Hostel Fee Report</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Hostel Fee Report</li>
      </ol>
    </section>
    <section class="content-header">
 </section>

<!-- main section -->
<div class="col-md-12">	
  	<div class="box box-danger no-print">
        <div class="box-header">
          <h3 class="box-title">Hostel Fee Filter</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<form id="hostel_mis_form" action="javascript:void(0);" method="POST" role="form">
    	
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    	
      			<div class="form-group" style="margin-bottom:0px;">
      				<div class="col-sm-2 mb-3">
						<label>Select Session</label>
						<select name="session" id="session" class="form-control">
							<option value="3" selected>2019-20</option>
						</select>
						<div id="session_err" style="display:none; color:red;"></div>
					</div>
					<div class="col-sm-2 mb-3">
						<label>Select Board</label>
						<select name="school" id="school" class="form-control">
							<option value="">Select Board</option>
							<?php if($this->session->userdata('school_id')){?>
							<option value="1" selected>Shakuntala CBSE</option>
							<option value="3">CG State Board</option>
							<?php }else{?>
							<option value="2">Sharda</option>
							<?php } ?>
						</select>
						<div id="school_err" style="display:none; color:red;"></div>
					</div>					
				
					<div class="col-sm-2 mb-3">
						<label>From Date</label>
						<input type="date" id="from_date" class="form-control" value="<?php echo date('Y-m-d');?>" min="2019-04-01" max="<?php echo date('Y-m-d');?>"/>
						<div id="from_date_err" style="display:none; color:red;"></div>
					</div>
					<div class="col-sm-2 mb-3">
						<label>To Date</label>
						<input type="date" id="to_date" class="form-control" value="<?php echo date('Y-m-d');?>" min="2019-04-01" max="<?php echo date('Y-m-d');?>"/>
						<div id="to_date_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-md-2 mb-3">
						<button type="button" id="search" class="btn btn-info pull-left">Search</button>	
					</div>
			    </div>
    		</form>	
		</div><!-- end box body -->
		</div>
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
					<h4 style="margin-bottom:0px;"><b>Shakuntala Student Fee List</b></h4>
				</div>
		</div>
		<div class="box box-primary">
			<div class="box-body text-center" style="font-size:18px;color:#e24e08;border:1px solid #ddd;float:left;width:100%;background-color:#fff;margin-bottom:20px;">
			<div class="col-md-2" style="border-right:1px solid #ddd;width:20%;float:left;font-size:17px;">
    					<b style="color:#5d5c5c;">Total Hostler</b><br>
    					<span id="total_students"><b>0.00</b></span>
    			</div>
    			<div class="col-md-2" style="border-right:1px solid #ddd;width:20%;float:left;font-size:17px;">
    					<b style="color:#5d5c5c;">Total Fee</b><br>
    					<span id="total_fee"><b>0.00</b></span>
    			</div>
				
				<div class="col-md-2"  style="border-right:1px solid #ddd;width:20%;float:left;font-size:17px;">
					<b style="color:#5d5c5c;">Received Fee</b><br>
					<span id="paid_fee"><b>0.00</b></span>
				</div>
				
				<div class="col-md-2" style="border-right:1px solid #ddd;width:20%;float:left;font-size:17px;">
					<b style="color:#5d5c5c;">Received GST</b><br>
					<span id="gst_fee"><b>0.00</b></span>
				</div>
				
				<div class="col-md-2" >
					<b style="color:#5d5c5c;">Pending Fee</b><br>
					<span id="pending_fee"><b>0.00</b></span>
				</div>
				
			</div>
		</div>
	
		<!-- <div class="box box-info">
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
		</div>-->
		
		
		<div class="col-md-6 col-md-offset-3 p-full-w" style="float:left;padding:0px;">
		<div class="box box-danger" id="DivIdToPrint">
            <div class="box-header fee-table-head" style="background-color: #881e1e;color: #fff;">
              <h3 class="box-title"><b>Shakuntala Gurukul (2019-20)</b></h3>
			  <span class="pull-right"><b>Date Range: <span id="date_range"></span></b></span>
            </div>
      		     <div class="box-body fee-table-body" id="fee_report_table"></div>
 		</div>
		<div class="text-center"><button class="btn btn-space btn-primary no-print" style="margin-bottom:50px;" onclick="printDiv()">Print this page</button></div>
 		</div>
	</div>
</div>

<script type="text/javascript">
var baseUrl = $('#base_url').val();
var session = $('#session').val();
var school = $('#school').val();
var from_date = $('#from_date').val();
var to_date = $('#to_date').val();

$('#hostel_mis_form').validate({
	rules:{
		session:{required:true},
		school:{required:true}
	},
});

$(document).on('click','#search',function(){
	var formvaldate = $('#hostel_mis_form').valid();
	var session = $('#session').val();
	var school = $('#school').val();
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	 
	if(formvaldate){
		getMisDetails(session,school,from_date,to_date);	
	}
	
});

getMisDetails(session,school,from_date,to_date);
function getMisDetails(session,school,from_date,to_date){
	$.ajax({
		type:'POST',
		url:baseUrl+'hostel/Hostel_students_ctrl/hostel_mis_details',
		data:{'session':session,'school':school,'from_date':from_date,'to_date':to_date},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				$('#date_range').html('From '+ moment(from_date).format("DD-MM-YYYY")+' To ' +moment(to_date).format("DD-MM-YYYY"));
				$('#total_students').html('<b>'+response.data.total_students+'</b>');
				$('#total_fee').html('<b>'+response.data.total_fee+'</b>');
				$('#paid_fee').html('<b>'+response.data.total_paid_fee+'</b>');
				$('#gst_fee').html('<b>'+response.data.total_paid_gst+'</b>');
				var pending_fee = parseFloat(parseFloat(response.data.total_fee) - parseFloat(response.data.total_paid_fee)).toFixed(2);
				$('#pending_fee').html('<b>'+pending_fee+'</b>');

				var x='<table class="table table-responsive"><tbody style="font-size:16px;">';
				x=x+='<tr><td><b>Total Hostler</b></td><td style="font-size:20px;font-weight:600;color:#1b790f;">'+response.data.total_students+'</td></tr>'+
				'<tr><td><b>Total Fee</b></td><td style="font-size:20px;font-weight:600;color:#1b790f;">Rs. '+response.data.total_fee+'/-</td></tr>'+
				'<tr><td><b>Received Fee</b></td><td style="font-size:20px;font-weight:600;color:#1b790f;">Rs. '+response.data.paid_fee+'/-</td></tr>'+
				'<tr><td><b>Received GST</b></td><td style="font-size:20px;font-weight:600;color:#1b790f;">Rs. '+response.data.paid_gst+'/-</td></tr>'+
				//'<tr><td><b>Total Received Fee</b></td><td style="font-size:20px;font-weight:600;color:#1b790f;">Rs. '+response.data.total_paid_fee+'/-</td></tr>'+
				'<tr><td><b>Pending Fee</b></td><td style="font-size:20px;font-weight:600;color:#1b790f;">Rs. '+pending_fee+'/-</td></tr>'+
				'<tr><td colspan="2" style="text-align:center;background-color:#ddd !important;"><b>Pay Method</b></td></tr>'+
				'<tr><td><b>Cash</b></td><td>'+response.data.pay_method[0].cash+'</td></tr>'+
				'<tr><td><b>Cheque</b></td><td>'+response.data.pay_method[0].cheque+'</td></tr>'+
				'<tr><td><b>DD (Demand Draft)</b></td><td>'+response.data.pay_method[0].dd+'</td></tr>'+
				'<tr><td><b>Credit Card</b></td><td>'+response.data.pay_method[0].credit_card+'</td></tr>'+
				'<tr><td><b>Debit Card</b></td><td>'+response.data.pay_method[0].debit_card+'</td></tr>'+
				
				'</tbody></table>';
				$('#fee_report_table').html(x);
			}
		},
	});
}

$(document).on('change','#from_date,#to_date',function(){
	$('#search').trigger('click');
});


function printDiv() {
  window.print();
}
</script>