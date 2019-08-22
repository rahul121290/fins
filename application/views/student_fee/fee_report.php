<div class="content-wrapper">
<section class="content-header">
      <h1>Reception <small>Student Classwise Fee</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Student Classwise Fee</li>
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
						<select name="section" id="section" class="form-control">
							<option value="">Select Section</option>
							<?php foreach($section as $sec){?>
    							<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
    						<?php }?>
						</select>
						<div id="section_err" style="display:none; color:red;"></div>
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
					
					<div class="col-md-2 mb-3">
						<button type="button" id="search" class="btn btn-info pull-left">Search</button>	
					</div>
			    </div>
    		</form>	
		</div><!-- end box body -->
		</div>
		
		<div class="box box-primary">
			<div class="box-body text-center" style="font-size:18px;color:#e24e08;">
    				<div class="col-md-4">
    					<b style="color:#5d5c5c;">Total Fee</b><br>
    					<span id="total_fee"><b>0.00</b></span>
    				</div>
    			
				
				<div class="col-md-4" style="border-right:1px solid #ddd;">
					<b style="color:#5d5c5c;">Received Fee</b><br>
					<span id="paid_fee"><b>0.00</b></span>
				</div>
				
				<div class="col-md-4" style="border-right:1px solid #ddd;">
					<b style="color:#5d5c5c;">Pending Fee</b><br>
					<span id="pending_fee"><b>0.00</b></span>
				</div>
			</div>
		</div>
	
		<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Student List</h3>
            </div>
      		     <div class="box-body">
  					<table class="table table-responsive">
						<thead><tr>
						<th>S.No.</th>
						<th>Admission No.</th>
						<th>Class/Sec</th>
						<th>Student Name</th>
                          <th>Father's Name</th>
                          <th>Bus</th>
                          <th>Pending Month</th>
                          <th>Fee Criteria</th>
                          <th>Staff Child</th>
                          <th>Pending Fee</th>
                          <th>Received Fee</th>
                          <th>Total Fee</th>
                          <th>Action</th>
                        </tr>
                    </thead>
					<tbody id="student_list"></tbody>
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
		medium:{required:true},
		class_name:{required:true},
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
		$.ajax({
			type:'POST',
			url:baseUrl+'Student_fee_ctrl/class_wise_report',
			data:{
				'session':session,
				'school':school,
				'medium':medium,
				'class_name':class_name,
				'section':section,
				'fee_criteria':fee_criteria
			},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					$('#paid_fee').html('<b>'+parseFloat(response.paid_fee).toFixed(2)+'</b>');
					$('#pending_fee').html('<b>'+parseFloat(response.pending_fee).toFixed(2)+'</b>');
					$('#total_fee').html('<b>'+parseFloat(response.total_fee).toFixed(2)+'</b>');
					
					var x='';
					$.each(response.data,function(key,value){
						if(value.pending_fee == '' || value.pending_fee == null){
							pending_fee = '0.00';
						}else{
							pending_fee = parseFloat(value.pending_fee).toFixed(2);
						}

						if(value.paid_fee == '' || value.paid_fee == null){
							paid_fee = '0.00';
						}else{
							paid_fee = parseFloat(value.paid_fee).toFixed(2);
						}

						if(value.total == '' || value.total == null){
							total = '0.00';
						}else{
							total = parseFloat(value.total).toFixed(2);
						}
						
						x=x+'<tr>'+
							'<td>'+parseInt(key+1)+'</td>'+
							'<td>'+value.adm_no+'</td>'+
							'<td>'+value.class_name+'/'+value.section_name+'</td>'+
							'<td>'+value.name+'</td>'+
							'<td>'+value.f_name+'</td>'+
							'<td>'+value.bus+'</td>'+
							'<td>'+value.pending_month+'</td>'+
							'<td>'+value.fc_name+'</td>'+
							'<td>'+value.staff_child+'</td>'+
							'<td>'+pending_fee+'</td>'+
							'<td>'+paid_fee+'</td>'+
							'<td>'+total+'</td>'+
							'<td><button data-ses_id="'+value.ses_id+'" data-sch_id="'+value.sch_id+'" data-adm_no="'+value.adm_no+'" class="btn btn-sm btn-primary view_details">View Details</button></td>'+
							'</tr>';
					});
					$('#student_list').html(x);
				}else{
					$('#student_list').html('<tr><td colspan="13" style="text-align:center;">Record not found.</td></tr>');
				}
			},
		});
	}
	
	$(document).on('click','.view_details',function(){
		var ses_id = $(this).data('ses_id');
		var sch_id = $(this).data('sch_id');
		var adm_no = $(this).data('adm_no');
		window.open(baseUrl+userUrl+'/report/student/'+ses_id+'/'+sch_id+'/'+adm_no);
	});
});
</script>