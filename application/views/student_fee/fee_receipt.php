<style>
.skin-blue .main-header .navbar{padding:10px;}
.mb-3{margin-bottom:10px;}

.receipt-amount-box thead{background-color:#f2f2f2;font-weight:600;}
.receipt-amount-box table{border:1px solid #ddd;}
.receipt-amount-box tr.grand-t{background-color:#ccc9c9;font-size:18px;}
.box-title-r{   background-color: #969393;font-size:14px;font-weight:600;
    margin-right: 15px;
    color: #fff;
    padding: 9px;
    width: 100px;
    float: right;
    text-align: center;
    border-radius: 4px;}
.table>tbody>tr>td{padding:6px;}
	
   hr{margin:10px 0;}
.main-footer{border-top:0px solid #fff;}

 @media print {
          .r-table-print{width:50%;}
		 .thead-light{background-color:#f2f2f2 !important;}

		.no-print{ display:none !important;}
		.box.box-danger {
    border-top-color: #fff !important;
}
 }
</style>
<link src="<?php echo base_url();?>assets/css/printcss.css" />
<input type="hidden" id="receipt_no" value="<?php echo $this->uri->segment(5)?>" />
<div class="content-wrapper" style="background-color:#fff;">
    <section class="content-header"></section>
    	<!-- main section -->
        <div class="col-md-7 col-md-offset-3">	
          	<div class="box box-danger" style="border-top:0px solid #fff;background-color:#fff;">

            	<div class="box-body form-horizontal">
              			<div class="form-group" id="print_div" style="margin-bottom:0px;">
              				<div class="row">
							<div class="col-md-7" style="width:60%;float:left;">
							<div style="float:left;width:100px;margin-left:25px;" class="">
								<img style="width:80px;" src="<?php echo base_url();?>assets/images/shakuntala/shakuntala.png" />
							</div>
							<div class="">
								<b style="font-size:18px;">Shakuntala Vidyalaya</b><br>
								Affiliated to CBSE, New Delhi No. 3330091<br>
								Ram Nagar Bhilai CG - 490023<br>
								Receipt(EM)
							</div>
							</div>
							<div class="col-md-5 text-right" style="width:40%;float:left;">
								<p class="box-title-r" >Fee Receipt</p>
							</div>
							</div>
							<hr>
							<div class="col-sm-12 mb-3 fee-print" id="general_details"></div>
							
							<div class="col-sm-12 mb-3 receipt-amount-box">
								<table class="table r-table-print-dis">
									<thead class="thead-light" >
										<tr>
											<td>Description</td>
											<td align="center">Due Date</td>
											<td align="right">Amount</td>
										</tr>
									</thead>
									<tbody id="fee_details"></tbody>
								</table>
							</div>
					    </div>
					    <div class="box-footer pull-right no-print" style="padding:0px 0px;">
                        	<button type="button" id="print" class="btn btn-info pull-right">Print</button>
        				</div>
        		</div><!-- end box body -->
     			</div>
   			</div>   			
		</div>

<script type="text/javascript">
var baseUrl = $('#base_url').val();
var receipt_no = $('#receipt_no').val();

fee_details();
function fee_details(){
	$.ajax({
		type:'GET',
		url:baseUrl+'Student_fee_ctrl/fee_receipt',
		data:{'receipt_no':receipt_no},
		dataType:'json',
		beforeSend:function(){
			//$('#loader').modal('show');
		},
		success:function(response){
			if(response.status == 200){
				if(response.data.student){
					var std = '<table class="table r-table-print" style="float:left;width:48%;">'+
					'<tbody>'+
					'<tr><td style="border:0px;">Receipt Date</td><td style="border:0px;">: '+response.data.student[0].receipt_date+'</td></tr>'+
					'<tr>'+
						'<td>Student\'s Name</td>'+
						'<td>: '+response.data.student[0].name+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td>Father\'s Name</td>'+
						'<td>: '+response.data.student[0].f_name+'</td></tr>'+
					'</tbody>'+
				'</table>'+
				'<table class="table r-table-print" style="width:48%;">'+
					'<tbody>'+
					'<tr><td style="border:0px;">Receipt No.</td><td style="border:0px;">: '+response.data.student[0].receipt_no+'</td></tr>'+
					'<tr>'+
						'<td>Admission No.</td>'+
						'<td>: '+response.data.student[0].adm_no+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td>Class/Sec</td>'+
						'<td>: '+response.data.student[0].class_name+'/'+response.data.student[0].section_name+'</td>'+
					'</tr>'+
					'</tbody>'+
				'</table>';
					$('#general_details').html(std);
				}

				var x='';
				if(response.data.session_fee.length > 0){
					x=x+'<tr><td><b>Session Fee</b></td><td align="center"></td><td align="right"></td></tr>'; 
					$.each(response.data.session_fee,function(key,value){
						x=x+'<tr>'+
						'<td>'+value.name+'</td>'+
						'<td align="center"><?php echo date('d-m-Y');?></td>'+
						'<td align="right">'+value.amount+'</td>'+
					'</tr>';
					});
				}

				if(response.data.month_fee.length > 0){
					x=x+'<tr><td><b>Month Fee</b></td><td align="center"></td><td align="right"></td></tr>';
					$.each(response.data.month_fee,function(key,value){
						var fee = parseFloat(parseFloat(value.fee) + parseFloat(value.bus_fee));
						x=x+'<tr>'+
						'<td>'+value.name+'</td>'+
						'<td align="center"><?php echo date('d-m-Y');?></td>'+
						'<td align="right">'+fee.toFixed(2)+'</td>'+
					'</tr>'; 
					});
					
				}

				if(response.data.student[0].late_fee > 0){
					x=x+'<tr>'+
    					'<td>Late Fee</td>'+
    					'<td align="center"><?php echo date('d-m-Y'); ?></td>'+
    					'<td align="right">'+response.data.student[0].late_fee+'</td>'+
    				'</tr>';
				}

				
				if(response.data.student[0].fee_waiver > 0){
					x=x+'<tr>'+
					'<td>Fee Waiver</td>'+
					'<td align="center"><?php echo date('d-m-Y'); ?></td>'+
					'<td align="right">'+response.data.student[0].fee_waiver+'</td>'+
				'</tr>';
				}
				
				x=x+'<tr class="grand-t">'+
    				'<td><b>Grand Total</b></td>'+
    				'<td colspan="2" align="right"><b>'+response.data.student[0].paid_amount+'</b></td>'+
    			'</tr>'+
    			'<tr>'+
    				'<td class="b-space" colspan="3" align="right"><b>'+response.data.word_amount+'</b></td>'+
    			'</tr>'+
    			'<tr>'+
    				'<td colspan="2" align="left">Date: <?php echo date('d-M-Y h:i');?> / Ranjeet </td>'+
    				'<td align="right">Counter I/C</td>'+
    			'</tr>';
				$('#fee_details').html(x);
			}
		},
	});
}



$('#print').on('click',function(){
	window.print();
});
</script>