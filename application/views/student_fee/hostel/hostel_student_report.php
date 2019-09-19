<div class="content-wrapper">
<section class="content-header">
      <h1>Hostel <small>Student Hostel Fee List</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Student Hostel Fee List</li>
      </ol>
    </section>
    <section class="content-header">
 </section>

<!-- main section -->
<div class="col-md-12">	
  	<div class="box box-danger no-print">
        <div class="box-header">
          <h3 class="box-title">Student Filter</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<form id="class_wise_fee_details" action="javascript:void(0);" method="POST" role="form">
    	
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    	
      			<div class="form-group" style="margin-bottom:0px;">
      				<div class="col-sm-2 mb-3">
						<select name="session" id="session" class="form-control">
							<option value="">Select Session</option>
							<option value="3" selected>2019-20</option>
						</select>
						<div id="session_err" style="display:none; color:red;"></div>
					</div>
					<div class="col-sm-2 mb-3">
						<select name="school" id="school" class="form-control">
							<option value="">Select Board</option>
							<?php if($this->session->userdata('school_id') == 1){?>
							<option value="1" selected>Shakuntala CBSE</option>
							<option value="3">CG State Board</option>
							<?php }else{?>
							<option value="2" selected>Sharda</option>
							<?php } ?>
						</select>
						<div id="school_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-2 mb-3" >
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
						<select name="installment" id="installment" class="form-control">
							<option value="">Select Installment</option>
								<option value="1" selected>March / April</option>
								<option value="2">September</option>
								<option value="3">Outstanding</option>
						</select>
						<div id="installment_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-2 mb-3">
						<select name="pay_status" id="pay_status" class="form-control">
							<option value="">Pay Status</option>
								<option value="1">Paid</option>
								<option value="0">Pending</option>
						</select>
						<div id="pay_status_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-2 mb-3">
						<input type="text" id="search_box" name="search_box" class="form-control" placeholder="Seach Student Name / Adm No.">
					</div>
					
					<div class="col-md-2 mb-3">
						<button style="margin-right:10px;" type="button" id="search" class="btn btn-success pull-left">Search</button>&nbsp;&nbsp;
						<button type="button" id="print" class="btn btn-info pull-left"  onclick='printDiv();'>Print</button>	
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
		<div class="box box-info" >
            <div class="box-header no-print">
              <h3 class="box-title" id="title">Student Hostel Fee List</h3>
            </div>
      		    <div id="DivIdToPrint">
				<div class="box-body p-sibling-report" >
  					<table class="table table-responsive">
						<thead><tr>
						<th>S.No.</th>
						<th>Admission No.</th>
						<th>Class/Section</th>
						<th>Student Name</th>
                        <th>Father's Name</th>
                        <th>Hostel Status</th>
                        <th>Total Fee</th>
                        <th>Paid Fee</th>
                        <th>Paid GST</th>
                        <th>Pending Fee</th>
                        <th>Due Date</th>                        
                        <th>Received By</th>
                        </tr>
                    </thead>
					<tbody id="student_list"><tr><td colspan="12" style="text-align: center;">Record not found.</td></tr></tbody>
					</table>
				</div>
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
<script type="text/javascript">
var baseUrl = $('#base_url').val();
var userUrl = $('#user_url').val();
var session = $('#session').val();
var school = $('#school').val();
var installment = $('#installment').val();

$('#class_wise_fee_details').validate({
	rules:{
		session:{required:true},
		school:{required:true},
		//medium:{required:true},
		installment:{required:true},
	},
});


$(document).on('change','#search_box',function(){
	var formvalid = $('#class_wise_fee_details').valid();
	var session = $('#session').val();
	var school = $('#school').val();
	var medium = $('#medium').val();
	var class_id = $('#class_name').val();
	var installment = $('#installment').val();
	var pay_status = $('#pay_status').val();
	var search_box = $('#search_box').val();
	if(formvalid){
		studentList(session,school,medium,class_id,installment,pay_status,search_box);
	}
});

$(document).on('click','#search',function(){
	var formvalid = $('#class_wise_fee_details').valid();
	var session = $('#session').val();
	var school = $('#school').val();
	var medium = $('#medium').val();
	var installment = $('#installment').val();
	var class_id = '';
	var pay_status = '';
	var search_box = '';
	if(formvalid){
		studentList(session,school,medium,class_id,installment,pay_status,search_box);
	}
});

function studentList(session,school,medium,class_id,installment,pay_status,search_box){
	$.ajax({
		type:'POST',
		url:baseUrl+'hostel/Hostel_students_ctrl/studentPrintList',
		data:{'session':session,'school':school,'medium':medium,'class_id':class_id,'installment':installment,'pay_status':pay_status,search_box},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var x='';
				 var installment_name = $("#installment option:selected").text();
			     var titleMsg = 'Student List of Shakuntala Gurukul '+installment_name;

			     $('#title').html(titleMsg); 
				 var grand_total = 0;
				 var paid_total = 0;
				 var gst_total = 0;
				 $.each(response.data,function(key,value){
					grand_total += parseFloat(value.total_fee);
					paid_total += parseFloat(value.paid_fee);
					gst_total +=parseFloat(value.paid_gst);
					x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'</td>'+
						'<td>'+value.adm_no+'</td>'+
						'<td>'+value.class_name+'/'+value.section_name+'</td>'+
						'<td>'+value.name+'<br/>'+value.contact_no+'</td>'+
						'<td>'+value.f_name+'<br/>'+value.f_contact_no+'</td>'+
						'<td>'+value.std_status+'</td>'+
						'<td>'+value.total_fee+'</td>'+
						'<td>'+value.paid_fee+'</td>'+
						'<td>'+value.paid_gst+'</td>'+
						//'<td>'+value.paid_date+'</td>'+
						'<td>'+parseFloat(parseFloat(value.total_fee) - parseFloat(value.paid_fee)).toFixed(2)+'</td>';
						if($('#installment').val() == 1){
							if(value.pay_status == 'Paid'){
								x=x+'<td>September</td>';	
							}else{
								x=x+'<td>March / April</td>';
							}
						}
						if($('#installment').val() == 2){
							if(value.pay_status == 'Paid'){
								x=x+'<td>-</td>';
							}else{
								x=x+'<td>September</td>';	
							}
						}
						x=x+'<td>'+value.username+'</td>'+
					  '</tr>';
				});

				x=x+'<tr>'+
				'<td colspan="5"></td>'+
				'<td><b>Over All</b></td>'+
				'<td><b>'+grand_total.toFixed(2)+'</b></td>'+
				'<td><b>'+paid_total.toFixed(2)+'</b></td>'+
				'<td><b>'+gst_total.toFixed(2)+'</b></td>'+
				'<td><b>'+parseFloat(parseFloat(grand_total) - parseFloat(paid_total)).toFixed(2)+'</b></td>'+
			  '</tr>';

				$('#student_list').html(x);
			}else{
				$('#student_list').html('<tr><td colspan="11" style="text-align:center">Record not found.</td></tr>');
			}
		},
	});
}

function printDiv(){
	  var divToPrint=document.getElementById('DivIdToPrint');
	  var newWin=window.open('','Print-Window');
	  newWin.document.open();
	  newWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="'+ baseUrl +'assets/css/custom-style.css"><link rel="stylesheet" type="text/css" href="'+ baseUrl +'assets/css/bootstrap.min.css"><style>.p-sibling-report table thead tr th{padding:3px !important;font-size:11px !important;background-color:#f3f3f3 !important;}'+
'.p-sibling-report table tbody tr td{padding:3px !important;font-size:11px !important;}</style></head><body onload="window.print()">'+
  '<div class="print-s-logo" style="float:left;padding:0px 0px 5px 0;width:100%;">'+
				'<div class="text-center" style="float:left;">'+
		'<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" height="40" />'+
		'<div class="print-s-name" >'+
			'<h4><b>Shakuntala Gurukul</b></h4>'+
			'<p>Ram Nagar Bhilai(C.G.)</p>'+
		'</div></div><div class="text-right">'+
					'<h4><b>Student Hostel Fee List</b></h4>'+
				'</div></div>'+divToPrint.innerHTML+'</body></html>');
	  newWin.document.close();
	  setTimeout(function(){newWin.close();},10);
}
</script>