<div class="content-wrapper">
<section class="content-header">
	<LINK src="">
      <h1>Student Classwise Fee</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/reception/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Student Classwise Fee</li>
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
      				<div class="col-sm-1 mb-3">
						<select name="session" id="session" class="form-control">
							<option value="">Select Session</option>
							<option value="3" selected>2019-20</option>
						</select>
						<div id="session_err" style="display:none; color:red;"></div>
					</div>
					<div class="col-sm-2 mb-3">
						<select name="school" id="school" class="form-control">
							<option value="">Select Board</option>
							<option value="1" selected>Shakuntala CBSE</option>
							<option value="3">CG State Board</option>
							<option value="2">Sharda</option>
						</select>
						<div id="school_err" style="display:none; color:red;"></div>
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
						<select name="fee_month" id="fee_month" class="form-control">
							<option value="">Select Fee Month</option>
							<?php foreach($fee_month as $feemonth){?>
    							<option value="<?php echo $feemonth['fm_id'];?>"><?php echo $feemonth['name'];?></option>
    						<?php }?>
						</select>
						<div id="fee_month_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-2 mb-3">
						<select name="fee_status" id="fee_status" class="form-control">
							<option value="">Select Fee Status</option>
							<option value="1">Paid</option>
							<option value="0">Pending</option>
						</select>
						<div id="fee_month_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-md-3 mb-3">
						<button type="button" id="search" class="btn btn-success ">Search</button>&nbsp;&nbsp;
						<button type="button" id="print" class="btn btn-info"  onclick='printDiv();'>Print</button>&nbsp;&nbsp;
					</div>
			    </div>
    		</form>	
		</div><!-- end box body -->
		
		 <div class="box-body form-horizontal row">
            <div class="col-sm-3 mb-3">
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
					<h4 style="margin-bottom:0px;"><b>Student Classwise Fee</b></h4>
				</div>
		</div>
		<div class="box box-info" id="DivIdToPrint">
            <div class="box-header no-print">
              <h3 class="box-title">Student List</h3>
            </div>
      		     <div class="box-body p-table-body p-table-bg-head">
  					<table class="table table-responsive">
						<thead><tr>
						<th>S.No.</th>
						<th>Admission No.</th>
						<th>Fee Criteria</th>
                        <!--th>Related Students</th -->
						<th>Class/Sec</th>
						<th>Student Name</th>
                          <th>Father's Name</th>
                          <th>Bus</th>
                          <th>Month Name</th>
                          <th>Fee Status</th>
                          <!-- >th>Action</th -->
                        </tr>
                    </thead>
					<tbody id="student_list"><tr><td colspan="9" style="text-align:center;">Record not found.</td></tr></tbody>
				</table>
      		</div>
 		</div>
	</div>
</div>
		
<script type="text/javascript">
var baseUrl = $('#base_url').val();
var userUrl = $('#user_url').val();

$('#class_wise_fee_details').validate({
	rules:{
		session:{required:true},
		school:{required:true},
		//medium:{required:true},
		//class_name:{required:true},
		//section:{required:true},
		//fee_criteria:{required:true},
	},
});

$(document).on('click','#search',function(){
	var formvalidate = $('#class_wise_fee_details').valid();
	if(formvalidate){	
    	var session = $('#session').val();
    	var school = $('#school').val(); 
    	var medium = $('#medium').val();
    	var class_name = $('#class_name').val();
    	var section = $('#section').val();
		var fee_criteria = $('#fee_criteria').val();
		var search_box = '';
		var fee_month = $('#fee_month').val();
		var fee_status = $('#fee_status').val();
		student_details_list(session,school,medium,class_name,section,fee_criteria,fee_month,fee_status,search_box);
	}
});


$(document).on('change','#search_box',function(){
	var search_box = $(this).val();
	var session = $('#session').val();
	var school = $('#school').val(); 
	var medium = '';
	var class_name = '';
	var section = '';
	var fee_criteria = '';
	var fee_month = $('#fee_month').val();
	var fee_status = '';
	if(search_box != ''){
		student_details_list(session,school,medium,class_name,section,fee_criteria,fee_month,fee_status,search_box);
	}
});

function student_details_list(session,school,medium,class_name,section,fee_criteria,fee_month,fee_status,search_box){
	$.ajax({
		type:'POST',
		url:baseUrl+'Student_fee_ctrl/fee_report',
		data:{
			'session':session,
			'school':school,
			'medium':medium,
			'class_name':class_name,
			'section':section,
			'fee_criteria':fee_criteria,
			'search_box':search_box,
			'fee_month':fee_month,
			'fee_status':fee_status
		},
		dataType:'json',
		beforeSend:function(){
			$('#loader').modal('show');
		},
		success:function(response){
			if(response.status == 200){
// 				$('#paid_fee').html('<b>'+parseFloat(response.paid_fee).toFixed(2)+'</b>');
// 				$('#pending_fee').html('<b>'+parseFloat(response.pending_fee).toFixed(2)+'</b>');
// 				$('#total_fee').html('<b>'+parseFloat(response.total_fee).toFixed(2)+'</b>');
				
				var x='';
				$.each(response.data,function(key,value){
					x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'</td>'+
						'<td>'+value.adm_no+'</td>'+
						'<td>'+value.fc_name+' '+value.staff_child+'</td>'+
						//'<td>'+value.related_std+'</td>'+
						'<td>'+value.class_name+'/'+value.section_name+'</td>'+
						'<td>'+value.name+'</td>'+
						'<td>'+value.f_name+'</td>'+
						'<td>'+value.bus+'</td>'+
						'<td>'+value.pending_month+'</td>'+
						'<td>'+value.fee_status+'</td>'+
						//'<td><button data-ses_id="'+value.ses_id+'" data-sch_id="'+value.sch_id+'" data-adm_no="'+value.adm_no+'" class="btn btn-primary view_details">View Details</button>&nbsp;'+
						//'<button data-ses_id="'+value.ses_id+'" data-sch_id="'+value.sch_id+'" data-adm_no="'+value.adm_no+'" class="btn btn-danger discontinue">Discontinue</button></td>'+
						'</tr>';
				});
				$('#student_list').html(x);
				$('#loader').modal('hide');
			}else{
// 				$('#paid_fee').html('<b>0.00</b>');
// 				$('#pending_fee').html('<b>0.00</b>');
// 				$('#total_fee').html('<b>0.00</b>');
				$('#student_list').html('<tr><td colspan="13" style="text-align:center;">Record not found.</td></tr>');
				$('#loader').modal('hide');
			}
		},
	});
}

$(document).on('click','.discontinue',function(){
	var ses_id = $(this).data('ses_id');
	var sch_id = $(this).data('sch_id');
	var adm_no = $(this).data('adm_no');

	var session = $('#session').val();
	var school = $('#school').val(); 
	var medium = $('#medium').val();
	var class_name = $('#class_name').val();
	var section = $('#section').val();
	var fee_criteria = $('#fee_criteria').val();
	if(confirm('Are you sure!')){
		$.ajax({
			type:'POST',
			url:baseUrl+'Student_fee_ctrl/student_discontinue',
			data:{'ses_id':ses_id,'sch_id':sch_id,'adm_no':adm_no},
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');	
			},
			success:function(response){
				if(response.status == 200){
					alert(response.msg);
					student_details_list(session,school,medium,class_name,section,fee_criteria);
					$('#loader').modal('hide');
				}else{
					alert(response.msg);
					$('#loader').modal('hide');
				}
			},
		});
	}
});

/*function printDiv(){
	  var divToPrint=document.getElementById('DivIdToPrint');
	  var newWin=window.open('','Print-Window');
	  newWin.document.open();
	  newWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="'+ baseUrl +'assets/css/bootstrap.min.css"></head><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
	  newWin.document.close();
	  setTimeout(function(){newWin.close();},10);
	}*/
	function printDiv() {
  window.print();
}
</script>