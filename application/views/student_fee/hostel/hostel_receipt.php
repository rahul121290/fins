<div class="content-wrapper">
	<section class="content-header">
      <h1>Hostel <small>Student Fee Receipt</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Student Fee Receipt</li>
      </ol>
    </section>
	
	<div class="col-md-8 col-md-offset-2 mt-3">
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle text-center" style="cursor: move;">
			  <h2 class="box-title "><b>SHAKUNTALA GURUKUL</b></h2>
			  <p>Bhilai(C.G.) 490023</p>
			</div>
			<div class="box-body" style="padding-top:0px;" id="fee_receipt"></div>
			
		</div>
	</div>
</div>
<input type="hidden" id="receipt_no" value="<?php echo $this->uri->segment(5);?>" />

<script type="text/javascript" src="<?php echo base_url();?>assets/js/custom/number_to_word.js"></script>
<script type="text/javascript">
var baseUrl = $('#base_url').val();

getReceiptData();
function getReceiptData(){
	var receipt_no = $('#receipt_no').val();
	$.ajax({
		type:'POST',
		url:baseUrl+'hostel/Hostel_students_ctrl/fee_receipt',
		data:{'receipt_no':receipt_no},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var hostel_fee = parseFloat(parseFloat(response.data[0].paid_amount)-parseFloat(parseFloat(response.data[0].paid_amount)/parseFloat(2.5))).toFixed(2);
				var mess_fee = parseFloat(parseFloat(response.data[0].paid_amount)/parseFloat(2.5)).toFixed(2);
				var gst_charge = parseFloat(parseFloat(parseFloat(mess_fee)*parseFloat(2.5))/parseFloat(100)).toFixed(2);
				var sub_total = parseFloat(parseFloat(hostel_fee)+parseFloat(mess_fee)+parseFloat(gst_charge)+parseFloat(gst_charge)).toFixed(2);
				var mess_with_gst = parseFloat(parseFloat(mess_fee)+parseFloat(gst_charge)+parseFloat(gst_charge)).toFixed(2);
				var x='<table class="table h-hostel-bil-table">'+
					'<tbody>'+
				'<tr><td><b>Bill No.</b></td><td>: SG/19-20/ 073</td><td><b>Bill Date</b></td><td>: '+response.data[0].receipt_no+'</td></tr>'+
				'<tr><td><b>Student Name</b></td><td>: '+response.data[0].name+'</td><td><b>Class</b></td><td>: '+response.data[0].class_name+'/'+response.data[0].section_name+'</td></tr>'+
				'<tr><td><b>Board</b></td><td>: '+response.data[0].school_name+'</td><td><b>GST No.</b></td><td>: 22ADWFS8751K1Z9</td></tr>'+
			'</tbody>'+
		'</table>'+
		
		'<table class="table hostel-bil-table" style="border:2px solid #000;">'+
			'<thead>'+
				'<tr><th>S.NO.</th><th>PARTICULARS</th><th>SAC CODE</th><th>QTY</th><th>RATE</th><th>AMOUNT</th></tr>'+
			'</thead>'+
			'<tbody>'+
				'<tr><td>1.</td><td>Hostel Fees(During the Year- 12M)</td><td>996322</td><td>1</td><td>'+hostel_fee+'</td><td>'+hostel_fee+'</td></tr>'+
				'<tr><td>2.</td><td>Mess/Canteen Charges</td><td>996333</td><td>1</td><td>'+mess_fee+'</td><td>'+mess_fee+'</td></tr>'+
				'<tr><td colspan="2"></td><td><b>SUB TOTAL</b></td><td colspan="2"></td><td><b>'+response.data[0].paid_amount+'</b></td></tr>'+
				'<tr><td colspan="3"></td><td>CGST @2.5%</td><td></td><td>'+gst_charge+'</td></tr>'+
				'<tr><td colspan="3"></td><td>CGST @2.5%</td><td></td><td>'+gst_charge+'</td></tr>'+
				'<tr><td colspan="2"></td><td><b>TOTAL</b></td><td colspan="2"></td><td><b>'+sub_total+'</b></td></tr>'+
				'<tr><td colspan="6" style="text-align:right;"><b>'+toWords(parseFloat(sub_total))+'</b></td></tr>'+
				
				'<tr><td colspan="2"></td><td><b>GST RATE</b></td><td><b>CGST @2.5%</b></td><td><b>SGST@2.5%</b></td><td><b>TOTAL GST</b></td></tr>'+
				'<tr><td></td><td>Hostel Fees - 996322</td><td>Exempt</td><td>-</td><td>-</td><td>-</td></tr>'+
				'<tr><td></td><td>Mess/Canteen - 996333</td><td>'+mess_fee+'</td><td>'+gst_charge+'</td><td>'+gst_charge+'</td><td>'+mess_with_gst+'</td></tr>'+
				'<tr><td colspan="2"></td><td><b>TOTAL</b></td><td><b>'+gst_charge+'</b></td><td><b>'+gst_charge+'</b></td><td><b>'+mess_with_gst+'</b></td></tr>'+
			'</tbody>'+
		'</table>'+
		'<table class="table">'+
			'<tbody>'+
				'<tr><td></td></tr>'+
				'<tr><td colspan="" style="text-align:right;"><b>Authorised Sign</b></td></tr>'+
			'</tbody></table>';
			$('#fee_receipt').html(x);
			}else{
				alert(response.msg);
			}
		},
	
	});
}

</script>

