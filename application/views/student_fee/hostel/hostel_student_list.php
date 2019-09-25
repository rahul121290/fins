
<div class="content-wrapper">
<section class="content-header">
      <h1>Hostel <small>Student Hostel Fee List</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Student Hostel Fee</li>
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
							<?php if($this->session->userdata('school_id') == 1){?>
							<option value="1" selected>CBSE</option>
							<option value="3">CG Board</option>
							<?php }else if($this->session->userdata('school_id') == 2){?>
							<option value="2" selected>CBSE</option>
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
						<select name="section" id="student_status" class="form-control">
							<option value="">Student Status</option>
								<option value="new">New</option>
								<option value="old">Old</option>
						</select>
						<div id="student_status_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-2 mb-3">
						<input type="text" class="form-control" id="search_box" name="search_box" placeholder="Search Name / Adm No.">
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
				<div class="col-md-3" style="border-right:1px solid #ddd;float:left;font-size:17px;">
					<b style="color:#5d5c5c;">Total Fee</b><br>
					<b>Rs. </b><span id="total_fee"><b>0.00</b></span>/-
				</div>
				
				<div class="col-md-3" style="border-right:1px solid #ddd;float:left;font-size:17px;">
					<b style="color:#5d5c5c;">Received Fee</b><br>
					<b>Rs. </b><span id="paid_fee"><b>0.00</b></span>/-
				</div>
				
				<div class="col-md-3" style="border-right:1px solid #ddd;float:left;font-size:17px;">
					<b style="color:#5d5c5c;">Received GST</b><br>
					<b>Rs. </b><span id="paid_gst"><b>0.00</b></span>/-
				</div>
				
				<div class="col-md-3" style="float:left;font-size:17px;">
					<b style="color:#5d5c5c;">Pending Fee</b><br>
					<b>Rs. </b><span id="pending_fee"><b>0.00</b></span>/-
				</div>
				
			</div>
		</div>
	
		<div class="box box-info" style="float:left;">
            <div class="box-header no-print">
              <h3 class="box-title"><b>Student List</b></h3>
            </div>
      		     <div class="box-body p-table-body p-table-bg-head">
  					<table class="table table-responsive ">
						<thead><tr>
						<th>S.No.</th>
						<th>Admission No.</th>
						<th>Hostel Status</th>
						<th>Student Name</th>
                          <th>Father's Name</th>
                          <th>Total Fee</th>
                          <th>Received Fee</th>
                          <th>Received GST</th>
                          <th>Pending Fee</th>
                          <th>Hostel Details</th>
                          <th class="no-print">Action</th>
                        </tr>
                    </thead>
					<tbody id="student_list"><tr><td colspan="9" style="text-align: center;">Record not found.</td></tr></tbody>
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
<script type="text/javascript">
var baseUrl = $('#base_url').val();
var userUrl = $('#user_url').val();
var session = $('#session').val();
var school = $('#school').val();
var search_box = '';

$(document).on('change','#search_box',function(){
	var session = $('#session').val();
	var school = $('#school').val();
	var medium = $('#medium').val();
	var class_id = $('#class_name').val();
	var student_status = $('#student_status').val();
	var search_box = $(this).val();

	studentList(session,school,medium,class_id,student_status,search_box);
});



$(document).on('click','#search',function(){
	var session = $('#session').val();
	var school = $('#school').val();
	var medium = $('#medium').val();
	var class_id = $('#class_name').val();
	var student_status = $('#student_status').val();
	var search_box = '';
	studentList(session,school,medium,class_id,student_status,search_box);	
});

function studentList(session,school,medium,class_id,student_status,search_box){
	$.ajax({
		type:'POST',
		url:baseUrl+'hostel/Hostel_students_ctrl/studentList',
		data:{'session':session,'school':school,'medium':medium,'class_id':class_id,'student_status':student_status,'search_box':search_box},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var x='';
				$.each(response.data,function(key,value){
					if(value.details_status == 'pending'){
						var details_status = '<b style="color:red;">Pending</b>';
					}else{
						var details_status = '<b style="color:green;">Updated</b>';
					}
					x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'</td>'+
						'<td>'+value.adm_no+'</td>'+
						'<td>'+value.std_status+'</td>'+
						'<td>'+value.name+'<br/>'+value.contact_no+'</td>'+
						'<td>'+value.f_name+'<br/>'+value.f_contact_no+'</td>'+
						'<td>'+value.hostel_fee+'</td>'+
						'<td>'+value.paid_fee+'</td>'+
						'<td>'+value.paid_gst+'</td>'+
						'<td>'+parseFloat(parseFloat(value.hostel_fee) - parseFloat(value.paid_fee)).toFixed(2)+'</td>'+
						'<td>'+details_status+'</td>'+
						'<td class="no-print"><button data-ses_id="'+value.ses_id+'" data-sch_id="'+value.sch_id+'" data-adm_no="'+value.adm_no+'" class="btn btn-success pay_now">Pay Now</button>  '+
						'<button data-ses_id="'+value.ses_id+'" data-sch_id="'+value.sch_id+'" data-adm_no="'+value.adm_no+'" class="btn btn-info update_std">Update</button></td>'+
					  '</tr>';
				});
				$('#student_list').html(x);
				$('#total_fee').html('<b>'+response.all_total_fee+'</b>');
				$('#paid_fee').html('<b>'+response.all_paid_fee+'</b>');
				$('#paid_gst').html('<b>'+response.all_paid_gst+'</b>');
				$('#pending_fee').html('<b>'+response.all_pending_fee+'</b>');
			}else{
				$('#student_list').html('<tr><td colspan="9" style="text-align:center">Record not found.</td></tr>');
				$('#total_fee').html('<b>0.00</b>');
				$('#paid_fee').html('<b>0.00</b>');
				$('#pending_fee').html('<b>0.00</b>');
			}
		},
	});
}

$(document).on('click','.update_std',function(){
	var ses_id = $(this).data('ses_id');
	var sch_id = $(this).data('sch_id');
	var adm_no = $(this).data('adm_no');
	window.open(baseUrl+userUrl+'/hostel/add-hostel-details/'+ses_id+'/'+sch_id+'/'+adm_no);
});

$(document).on('click','.pay_now',function(){
	var ses_id = $(this).data('ses_id');
	var sch_id = $(this).data('sch_id');
	var adm_no = $(this).data('adm_no');

	window.open(baseUrl+userUrl+'/hostel/fee-payment/'+ses_id+'/'+sch_id+'/'+adm_no);
	
});
</script>