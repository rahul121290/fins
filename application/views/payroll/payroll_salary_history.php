<div class="content-wrapper">
<section class="content-header" style="margin-bottom:10px;">
      <h1>Salary History</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/payroll/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Salary History</li>
      </ol>
    </section>

<!-- main section -->
<div class="col-md-12">	
  	<div class="box box-danger no-print">
        <div class="box-header">
          <h3 class="box-title">Select filters</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<form id="salary_history" action="javascript:void(0);" method="POST" role="form">
    	
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    	
      			<div class="form-group" style="margin-bottom:0px;">
					<div class="col-sm-2 mb-3">
						<select name="school" id="school" class="form-control">
							<option value="">Select School</option>
							<option value="1" selected>Shakuntala Vidyalaya (CBSE) Records</option>
							<option value="3">Shakuntala Vidyalaya (CG) Records</option>
							<option value="2">Sharda Vidyalaya Risali</option>
							<option value="4">Sharda Vidyalaya Vaishali Nagar</option>
						</select>
						<div id="school_err" style="display:none; color:red;"></div>
					</div>	
					
					<div class="col-sm-2 mb-3">
						<select id="month" name="month" class="form-control">
							<option value="">Select Month</option>
							<?php foreach($month as $months){?>
								<option value="<?php echo $months['m_id'];?>" <?php if($months['m_id'] == (int)date('m')){echo "selected";}?> ><?php echo $months['m_name'];?></option>
							<?php } ?>
						</select>
						<div id="month_err" style="display:none; color:red;"></div>
					</div>
									
					<div class="col-sm-2 mb-3">
						<select class="form-control" name="emp_type" id="emp_type">
							<option value="">Select Employee Type</option>
							<option value="1">Permanent</option>
							<option value="2">Adhoc</option>
						</select>
						<div id="emp_type_err" style="display:none; color:red;"></div>
					</div>
					
						<div class="col-sm-2 mb-3">
						<select class="form-control" name="emp_sub_type" id="emp_sub_type">
							<option value="">Select Sub Type</option>
						</select>
						<div id="emp_sub_type_err" style="display:none; color:red;"></div>
					</div>
									
					<div class="col-sm-2 mb-3">
						<select class="form-control" name="pay_mode" id="pay_mode">
							<option value="">Select Payment Mode</option>
							<option value="cash">Cash</option>
							<option value="cheque">Cheque</option>
							<option value="bank">Bank</option>
						</select>
						<div id="pay_mode_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-md-2 mb-3">
						<button type="button" id="search" class="btn btn-info pull-left">Search</button>&nbsp;
						<button type="button" id="print_all" class="btn btn-success">Print</button>
					</div>
			    </div>
    		</form>	
		</div><!-- end box body -->
		</div>
		<div class="box box-primary">
			<div class="box-body text-center" style="font-size:18px;color:#e24e08;border:1px solid #ddd;width:100%;background-color:#fff;margin-bottom:20px;">
			<div class="col-md-4" style="border-right:1px solid #ddd;width:33%;float:left;font-size:17px;">
				</div>
				
				<div class="col-md-4" style="border-right:1px solid #ddd;width:33%;float:left;font-size:17px;">
					<b style="color:#5d5c5c;">Total Generated Salary on <?php echo date('M')?>. Month</b><br>
					<b>Rs. <?php echo $total_generated_amount[0]['net_salary'];?></b><b id="received_fee"></b>/-
				</div>
				<div class="col-md-4" style="width:33%;float:left;font-size:17px;">
				</div>
				
			</div>
		</div>
		
		<div class="print-s-logo" style="float:left;padding:0px 0px 5px 0px;width:100%;margin-bottom:10px;">
				<div class="text-center" style="float:left;">
					<img class="pull-left" alt="" src="../images/shakuntala/shakuntala.png" height="40" />
					<div class="print-s-name" >
						<h4><b>Shakuntala Vidyalaya</b></h4>
						<p>Ram Nagar Bhilai(C.G.)</p>
					</div>
				</div>
				<div class="text-right">
					<h4 style="margin-bottom:0px;"><b>Shakuntala Employee Payment History</b></h4>
				</div>
		</div>
	
		<div class="box box-info">
            <div class="box-header no-print">
              <h3 class="box-title"><b>Shakuntala Employee Payment History</b></h3>
            </div>
      		<div class="box-body p-table-bg-head p-table-body table-responsive">
				<table class="table">
					<thead><tr>
					<th>S.No.</th>
					<th>Employee Name</th>
					<th>Employee Type</th>
					<th>POST</th>
					<th>Payment Mode</th>
					<th>Account Detail</th>
					<th>Net Salary</th>
					<th>Action</th>
					</tr>
					</thead>
					<tbody id="employee_list"><tr><td colspan="10" class="text-center">Record not found.</td></tr></tbody>
				</table>
      		</div>
 		</div>
	</div>
</div>

<script type="text/javascript">
var baseUrl = $('#base_url').val();


$('#salary_history').validate({
	rules:{
		school:{required:true},
		month:{required:true},
		//emp_type:{required:true},
		//emp_sub_type:{required:true},
		//pay_mode:{required:true}
	},
});

$(document).on('click','#search',function(){
	var formvalid = $('#salary_history').valid();
	if(formvalid){
		var school = $('#school').val();
		var month = $('#month').val();
		var emp_type = $('#emp_type').val();
		var emp_sub_type = $('#emp_sub_type').val();
		var pay_mode = $('#pay_mode').val();

		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/salary_history',
			data:{'sch_id':school,'month':month,'emp_type':emp_type,'emp_sub_type':emp_sub_type,'pay_mode':pay_mode,'receipt_no':''},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					var x='';
					$.each(response.data,function(key,value){
						if(value.pay_status == 1){
							var pay_status = '<b><span style="color:green;">Paid</span></b>';
						}else{
							var pay_status = '<b><span style="color:red;">Pending</span></b>';
						}
						x=x+'<tr>'+
							'<td>'+parseInt(key+1)+'</td>'+
							'<td>'+value.emp_name+'</td>'+
							'<td>'+value.emp_type+'/'+value.emp_sub_type+'</td>'+
							'<td>'+value.post+'</td>'+
							'<td>'+value.pay_mode+'</td>'+
							'<td>'+value.bank_acc_no+'</td>'+
							'<td>'+value.net_salary+'</td>'+
							'<td><button class="btn btn-info print_receipt" data-receipt_no="'+value.receipt_no+'">Print</button></td>'+
						'<tr>';
					});
					$('#employee_list').html(x);
				}else{
					$('#employee_list').html('<tr><td colspan="10" class="text-center">Record not found.</td></tr>');
				}
			},
		});
	}
});

$(document).on('click','.print_receipt',function(){
	var receipt_no = $(this).data('receipt_no');
	var school = '';
	var month = '';
	var emp_type = '';
	var emp_sub_type = '';
	var pay_mode = '';
	salary_receipt(school,month,emp_type,emp_sub_type,pay_mode,receipt_no);
});


//-----------------****-----------------------
$(document).on('click','#print_all',function(){
	var formvalid = $('#salary_history').valid();
	if(formvalid){
		var school = $('#school').val();
		var month = $('#month').val();
		var emp_type = $('#emp_type').val();
		var emp_sub_type = $('#emp_sub_type').val();
		var pay_mode = $('#pay_mode').val();
		var receipt_no = '';
		salary_receipt(school,month,emp_type,emp_sub_type,pay_mode,receipt_no);
	}
});

function salary_receipt(school,month,emp_type,emp_sub_type,pay_mode,receipt_no){	
	$.ajax({
		type:'POST',
		url:baseUrl+'payroll/Payroll_ctrl/salary_history',
		data:{'sch_id':school,'month':month,'emp_type':emp_type,'emp_sub_type':emp_sub_type,'pay_mode':pay_mode,'receipt_no':receipt_no},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var win = window.open('', "myWindowName", "scrollbars=1,width=1200, height=600");
				var x = '<link rel="stylesheet" type="text/css" href="'+ base_url +'assets/css/bootstrap.min.css">'+
						'<link rel="stylesheet" type="text/css" href="'+ base_url +'assets/css/marksheet-result.css">'+
						'<div class="modal-content p-head-sec" style="height:640px;"><style>@media print {.table tr td{padding:3px !important;font-size:13px !important;}.payroll-box-sec{border:2px solid #ddd !important;}}</style>';
			$.each(response.data,function(key,value){
				x=x+'<div class="payroll-box" style="float:left;width:100%;padding:0px 30px 25px 30px;">'+
				'<div class="payroll-header" style="float:left;width:100%;">';
				if(value.sch_id == 1){
					x=x+'<div class="float-left" style="float:left;width:50%;"><img style="width:50px;margin-right:10px;float:left;" src="<?php echo base_url();?>assets/images/shakuntala/shakuntala.png" /><div style="float:left;font-size:15px;"><h4 style="margin-top:0px;margin-bottom:0px;"><b>Shakuntala Vidyalaya CBSE</b></h4><span>Ram Nagar Bhilai</span></div></div>';
				}else if(value.sch_id == 2){
					x=x+'<div class="float-left" style="float:left;width:50%;"><img style="width:50px;margin-right:10px;float:left;" src="<?php echo base_url();?>assets/images/shrada/sharda_logo.png" /><div style="float:left;font-size:15px;"><h4 style="margin-top:0px;margin-bottom:0px;"><b>Sharda Vidyalaya CBSE</b></h4><span>Risali Bhilai</span></div></div>';
				}else if(value.sch_id == 3){
					x=x+'<div class="float-left" style="float:left;width:50%;"><img style="width:50px;margin-right:10px;float:left;" src="<?php echo base_url();?>assets/images/shakuntala/shakuntala.png" /><div style="float:left;font-size:15px;"><h4 style="margin-top:0px;margin-bottom:0px;"><b>Shakuntala Vidyalaya CG</b></h4><span>Ram Nagar Bhilai</span></div></div>';
				}else{
					x=x+'<div class="float-left" style="float:left;width:50%;"><img style="width:50px;margin-right:10px;float:left;" src="<?php echo base_url();?>assets/images/shakuntala/sharda_logo.png" /><div style="float:left;font-size:15px;"><h4 style="margin-top:0px;margin-bottom:0px;"><b>Sharda Vidyalaya CBSE</b></h4><span>Vaisali Nagar Bhilai</span></div></div>';
				}
				
				x=x+'<div class="float-right" style="float:right;width:50%;text-align:right;">'+
						'<b>ISO 9001:2015 Certified</b>'+
					'</div>'+
				'</div>'+
				'<div class="payroll-box-sec" style="float:left;width:100%;border-top:1px solid #ddd;margin-top:5px;">'+
					'<div style="float:left;width:100%;background-color:#f3f3f3;padding:5px;">'+
						'<div style="float:left;width:50%;"><b>Employee Name: '+value.emp_name+'</b></div>'+
						'<div style="float:left;width:50%;text-align:right;"><b>Entry No.:</b> '+value.receipt_no+' </div>'+
					'</div>'+
					'<div style="float:left;width:100%;">'+
						'<table class="table" style="width:33%;float:left;">'+
							'<tbody>'+
								'<tr><td style="width:50%;"><b>Month:</b></td><td>'+value.m_name+'</td></tr>'+
								'<tr><td><b>Basic  Salary:</b></td><td>'+value.basic_salary+'</td></tr>'+
								'<tr><td><b>Absent:</b></td><td>'+value.absent+'</td></tr>'+
								'<tr><td><b>Net Basic:</b></td><td>'+value.net_salary+'</td></tr>'+
								'<tr><td><b>DA:</b></td><td>'+value.da_amount+'</td></tr>'+
								'<tr><td><b>Gross Basic:</b></td><td>'+value.gross_basic+'</td></tr>'+
							'</tbody>'+
						'</table>'+
						'<table class="table" style="width:33%;float:left;">'+
							'<tbody>'+
								'<tr><td style="width:50%;"><b>PF No.:</b></td><td>'+value.pf_no+'</td></tr>'+
								'<tr><td><b>PF Samiti:</b></td><td>'+value.samiti_pf+'</td></tr>'+
								'<tr><td><b>PF Employee:</b></td><td>'+value.emp_pf+'</td></tr>'+
								'<tr><td><b>PA:</b></td><td>'+value.pa_amount+'</td></tr>'+
								'<tr><td><b>Gross Salary:</b></td><td>'+value.gross_salary+'</td></tr>'+
								'<tr><td><b>ESIC Samiti:</b></td><td>'+value.samiti_esic+'</td></tr>'+
								'<tr><td><b>ESIC Employee:</b></td><td>'+value.emp_esic+'</td></tr>'+
							'</tbody>'+
						'</table>'+
						'<table class="table" style="width:33%;float:left;">'+
							'<tbody>'+
								'<tr><td style="width:60%;"><b>ESIC No.:</b></td><td>'+value.esic_no+'</td></tr>'+
								'<tr><td><b>Advance:</b></td><td>'+value.advance_amount+'</td></tr>'+
								'<tr><td><b>Total Ded Emp:</b></td><td>'+value.emp_t_ded+'</td></tr>'+
								'<tr><td><b>Total Ded Samiti:</b></td><td>'+value.samiti_t_ded+'</td></tr>'+
								'<tr><td><b>TDS:</b></td><td>'+value.tds+'</td></tr>'+
							'</tbody>'+
						'</table>'+
						'<table class="table">'+
							'<tbody>'+
								'<tr><td style="text-align:right;background-color: #f2f2f2;font-size: 17px;padding-right:30px;"><b>Net Salary: '+value.net_salary+'/-</b></td></tr>'+
							'</tbody>'+
						'</table>'+
						'<div style="float-right;text-align:right;">';
						if(value.sch_id == 1){
							x=x+'<img style="width:80px;margin-right:20px;" src="<?php echo base_url();?>assets/images/shakuntala/principle_image.png" />';
						}else if(value.sch_id == 2){
							x=x+'<img style="width:80px;margin-right:20px;" src="<?php echo base_url();?>assets/images/sharda/principle_image.png" />';
						}else if(value.sch_id == 3){
							x=x+'<img style="width:80px;margin-right:20px;" src="<?php echo base_url();?>assets/images/shakuntala/principle_image.png" />';
						}else if(value.sch_id == 4){
							x=x+'<img style="width:80px;margin-right:20px;" src="<?php echo base_url();?>assets/images/sharda/principle_image.png" />';
						}
						x=x+'</div>'+
					'</div>'+
				'</div>'+
			'</div>';
			});
			with(win.document){open(); write(x);close();}
			}else{
				alert(response.msg);
			}
		},
	});
}

//---------------***------------------------------
$(document).on('change','#emp_type',function(){
	var emp_type = $(this).val();
	$.ajax({
		type:'POST',
		url:baseUrl+'payroll/Payroll_ctrl/emp_sub_type',
		data:{'emp_type':emp_type},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var x='<option value="">Select Sub Type</option>';
				$.each(response.data,function(key,value){
					x=x+'<option value="'+value.est_id+'">'+value.sub_type_name+'</option>';
				});	
				$('#emp_sub_type').html(x);
			}else{
				alert(response.msg);
			}
		},
	});
});
</script>