<div class="content-wrapper">
<section class="content-header">
      <h1>Reception</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
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
        		<input type="hidden" id="adm_no" value="<?php echo $this->uri->segment(7);?>" />
        		
        		<div id="student_details"></div>
        		
    		</div><!-- end box body -->
 		</div>	
	</div> 
	<div class="col-md-12">
	<div class="box box-primary">
					<div class="box-body text-center" style="font-size:18px;color:#e24e08;">
						
						<div class="col-md-4">
							<b style="color:#5d5c5c;">Total Fee</b><br>
							<span id="total_fee">0.00</span>
						</div>
						
						<div class="col-md-4" style="border-right:1px solid #ddd;">
							<b style="color:#5d5c5c;">Received Fee</b><br>
							<span id="paid_fee">0.00</span>
						</div>
						
						<div class="col-md-4" style="border-right:1px solid #ddd;">
							<b style="color:#5d5c5c;">Pending Fee</b><br>
							<span id="pending_fee">0.00</span>
						</div>
						
						
					</div>
				</div>
	</div>
	
	<div class="col-md-12">	
      	<div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Paid Fee Details</h3>
            </div>
        	<div class="box-body form-horizontal">
        		<div class="month-fee-table">
				<table class="table">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Receipt No</th>
							<th>Payment Date</th>
							<th>Months</th>
							<th>Payment Amount</th>
							<th>Pay Mode</th>
							<th>Action</th>
						</tr>
					</thead>
				<tbody id="fee_details"></tbody>
				</table>
				</div>
    		</div><!-- end box body -->
 		</div>	
	</div>  
</div>
<script type="text/javascript">
var baseUrl = $('#base_url').val();
var userUrl = $('#user_url').val();
var ses_id = $('#ses_id').val();
var sch_id = $('#sch_id').val();
var adm_no = $('#adm_no').val();


student_report();
function student_report(){
	$.ajax({
		type:'POST',
		url:baseUrl+'Student_fee_ctrl/student_report',
		data:{'ses_id':ses_id,'sch_id':sch_id,'adm_no':adm_no},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var s = '<table class="table"><tbody>'+
        				'<tr><td><b>Student Name</b> : '+response.student_details[0].name+'</td><td></td>'+
        				'<td><b>Father Name</b> : '+response.student_details[0].f_name+'</td><td></td>'+
        				'<td><b>Admission No.</b> : '+response.student_details[0].adm_no+'</td><td></td>'+
        				'<td><b>Fee Criteria</b> : '+response.student_details[0].fc_name+'</td><td></td>'+
        				'<td><b>Staff Child</b> : '+response.student_details[0].staff_child+'</td><td></td>'+
        				'</tr>'+
        			'</tbody>'+
        		'</table>';
        		$('#student_details').html(s);

		
				$('#total_fee').html('<b>Rs. '+parseFloat(response.total_fee).toFixed(2)+'/-</b>');
				$('#pending_fee').html('<b>Rs. '+parseFloat(response.pending_fee).toFixed(2)+'/-</b>');
				$('#paid_fee').html('<b>Rs. '+parseFloat(response.paid_fee).toFixed(2)+'/-</b>');
				
			if(response.data.length > 0){
				var x='';
				$.each(response.data,function(key,value){
					x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'</td>'+
						'<td>'+value.receipt_no+'</td>'+
						'<td>'+value.payment_date+'</td>'+
						'<td>'+value.fee_month+'</td>'+
						'<td>'+value.paid_amount+'</td>'+
						'<td>'+value.pay_mode+'</td>'+
						'<td><button data-receipt_no="'+value.receipt_no+'" class="btn btn-primary print_receipt">Print Receipt</button></td>'+
					'</tr>';
				});
				$('#fee_details').html(x);
			}else{
				$('#fee_details').html('<tr><td colspan="7" style="text-align:center;">Not paid any fee.</td></tr>');
				}
			}else{
				alert('something went wrong.');	
			}
		},
	});
}


$(document).on('click','.print_receipt',function(){
	var receipt_no = $(this).data('receipt_no');
	window.open(baseUrl+userUrl+"/student-fee/receipt/"+receipt_no,"popupWindow", "width=960, height=960, scrollbars=yes");
});

</script>



