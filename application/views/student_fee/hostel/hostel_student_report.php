<div class="content-wrapper">
<section class="content-header">
      <h1>Hostel <small>Student Hostel Fee</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Student Hostel Fee</li>
      </ol>
    </section>
    <section class="content-header">
 </section>

<!-- main section -->
<div class="col-md-12">	
  	<div class="box box-danger">
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
					
					<div class="col-md-2 mb-3">
						<button type="button" id="search" class="btn btn-success pull-left">Search</button>&nbsp;&nbsp;
						<button type="button" id="print" class="btn btn-info pull-left"  onclick='printDiv();'>Print</button>	
					</div>
			    </div>
    		</form>	
		</div><!-- end box body -->
		</div>
		
		<div class="box box-info" id="DivIdToPrint">
            <div class="box-header">
              <h3 class="box-title" id="title"></h3>
            </div>
      		     <div class="box-body">
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
                        <th>Pending Fee</th>
                        <th>Pay Status</th>
                        <th>Received By</th>
                        </tr>
                    </thead>
					<tbody id="student_list"><tr><td colspan="10" style="text-align: center;">Record not found.</td></tr></tbody>
				</table>
      		</div>
 		</div>
 		
	</div>
</div>

<script type="text/javascript">
var baseUrl = $('#base_url').val();
var userUrl = $('#user_url').val();
var session = $('#session').val();
var school = $('#school').val();
var installment = $('#installment').val();


$(document).on('click','#search',function(){
	var session = $('#session').val();
	var school = $('#school').val();
	var medium = $('#medium').val();
	var class_id = $('#class_name').val();
	var installment = $('#installment').val();
	var pay_status = $('#pay_status').val();

	studentList(session,school,medium,class_id,installment,pay_status);		
});

function studentList(session,school,medium,class_id,installment,pay_status){
	$.ajax({
		type:'POST',
		url:baseUrl+'hostel/Hostel_students_ctrl/studentPrintList',
		data:{'session':session,'school':school,'medium':medium,'class_id':class_id,'installment':installment,'pay_status':pay_status},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var x='';
				 var school_name = $("#school option:selected").text();
				 if($('#medium').val() != ''){
					 var medium_name = $("#medium option:selected").text();
				 }else{
					var medium_name = '';
				 }
				 
				 var installment_name = $("#installment option:selected").text();

			     var titleMsg = 'Student List of '+school_name+'/'+medium_name+' '+installment_name+'<br/>'+'Generated By: '+response.username;
			     $('#title').html(titleMsg); 
				
				$.each(response.data,function(key,value){
					if(value.pay_status == 'Pending'){
						var pay_status = '<b style="color:red;">Pending</b>';
					}else{
						var pay_status = '<b style="color:green;">Paid</b>';
					}
					x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'</td>'+
						'<td>'+value.adm_no+'</td>'+
						'<td>'+value.class_name+'/'+value.section_name+'</td>'+
						'<td>'+value.name+'<br/>'+value.contact_no+'</td>'+
						'<td>'+value.f_name+'<br/>'+value.f_contact_no+'</td>'+
						'<td>'+value.std_status+'</td>'+
						'<td>'+value.total_fee+'</td>'+
						'<td>'+value.paid_fee+'</td>'+
						'<td>'+parseFloat(parseFloat(value.total_fee) - parseFloat(value.paid_fee)).toFixed(2)+'</td>'+
						'<td>'+pay_status+'</td>'+
						'<td>'+value.username+'</td>'+
					  '</tr>';
				});
				$('#student_list').html(x);
			}else{
				$('#student_list').html('<tr><td colspan="6" style="text-align:center">Record not found.</td></tr>');
			}
		},
	});
}

function printDiv(){
	  var divToPrint=document.getElementById('DivIdToPrint');
	  var newWin=window.open('','Print-Window');
	  newWin.document.open();
	  newWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="'+ baseUrl +'assets/css/bootstrap.min.css"></head><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
	  newWin.document.close();
	  setTimeout(function(){newWin.close();},10);
}
</script>