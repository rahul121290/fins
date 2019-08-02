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
							<div class="col-sm-12 mb-3 fee-print">
								<table class="table r-table-print" style="float:left;width:48%;">
									<tbody>
									<tr><td style="border:0px;">Receipt Date</td><td style="border:0px;">: <?php echo date('d-m-Y'); ?></td></tr>
									<tr>
										<td>Student's Name</td>
										<td>: <?php echo $result[0]['name'];?></td>
									</tr>
									<tr>
										<td>Father's Name</td>
										<td>: <?php echo $result[0]['f_name'];?></td></tr>
									</tbody>
								</table>
								<table class="table r-table-print" style="width:48%;">
									<tbody>
									<tr><td style="border:0px;">Receipt No.</td><td style="border:0px;">: <?php echo $result[0]['receipt_no']; ?></td></tr>
									<tr>
										<td>Admission No.</td>
										<td>: <?php echo $result[0]['adm_no']; ?></td>
									</tr>
									<tr>
										<td>Class/Sec</td>
										<td>: <?php echo $result[0]['class_name']; ?>/<?php echo $result[0]['section_name']; ?></td>
									</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-12 mb-3 receipt-amount-box">
								<table class="table r-table-print-dis">
									<thead class="thead-light" >
										<tr>
											<td>Description</td>
											<td align="center">Due Date</td>
											<td align="right">Amount</td>
										</tr>
									</thead>
									<tbody>
									
										<tr>
											<td>Tuition Fee <?php echo $result[0]['month']; ?></td>
											<td align="center"><?php echo date('d-m-Y'); ?></td>
											<td align="right"><?php echo $result[0]['total_fee']; ?></td>
										</tr>
										
										<?php if($result[0]['admission_fee'] > 0){?>
										<tr>
											<td>Admission Fee</td>
											<td align="center"><?php echo date('d-m-Y'); ?></td>
											<td align="right"><?php echo $result[0]['admission_fee']; ?></td>
										</tr>
									<?php } ?>
									
									<?php if($result[0]['amalgamated_fee'] > 0){?>
										<tr>
											<td>Amalgamated Fee</td>
											<td align="center"><?php echo date('d-m-Y'); ?></td>
											<td align="right"><?php echo $result[0]['amalgamated_fee']; ?></td>
										</tr>
									<?php } ?>
									
										<?php if($result[0]['bus_fee'] > 0){?>
										<tr>
											<td>Bus Fee</td>
											<td align="center"><?php echo date('d-m-Y'); ?></td>
											<td align="right"><?php echo $result[0]['bus_fee']; ?></td>
										</tr>
										<?php } ?>
										
										<?php if($result[0]['hostel_fee'] > 0){?>
										<tr>
											<td>Hostel Fee</td>
											<td align="center"><?php echo date('d-m-Y'); ?></td>
											<td align="right"><?php echo $result[0]['hostel_fee']; ?></td>
										</tr>
										<?php } ?>
										
										<?php if($result[0]['let_fee'] > 0){?>
										<tr>
											<td>Late Fee</td>
											<td align="center"><?php echo date('d-m-Y'); ?></td>
											<td align="right"><?php echo $result[0]['let_fee']; ?></td>
										</tr>
										<?php } ?>
										
										<?php if($result[0]['fee_waiver_amount'] > 0){?>
										<tr>
											<td>Fee Waiver</td>
											<td align="center"><?php echo date('d-m-Y'); ?></td>
											<td align="right"><?php echo $result[0]['fee_waiver_amount']; ?></td>
										</tr>
										<?php } ?>
										
										<tr class="grand-t">
											<td><b>Grand Total</b></td>
											<td colspan="2" align="right"><b><?php echo $result[0]['grand_total']; ?></b></td>
										</tr>
										<tr>
											<td class="b-space" colspan="3" align="right"><b><?php echo $word_amount;?></b></td>
										</tr>
										<tr>
											<td colspan="2" align="left">Date: <?php echo date('d-M-Y h:i');?> / Ranjeet </td>
											<td align="right">Counter I/C</td>
										</tr>
									</tbody>
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
$('#print').on('click',function(){
	window.print();
});
</script>