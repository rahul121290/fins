<div class="content-wrapper">
<section class="content-header" style="margin-bottom:10px;">
      <h1>Employee Salary Records </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/payroll/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Employee Salary Records </li>
      </ol>
    </section>
	
<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>"/>
<div class="col-md-12">	
  	<div class="box box-danger no-print">
        <div class="box-header">
          <h3 class="box-title">Select filters</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<form id="hostel_mis_form" action="javascript:void(0);" method="POST" role="form">
    	
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
      			<div class="form-group" style="margin-bottom:0px;">
      				<div class="col-sm-2 mb-3">
						<select name="search_session" id="search_session" class="form-control">
							<option value="3" selected>2019-20</option>
						</select>
						<div id="search_session_err" style="display:none; color:red;"></div>
					</div>
					<div class="col-sm-2 mb-3">
						<select name="search_school" id="search_school" class="form-control">
							<option value="">Select School</option>
							<option value="1">Shakuntala Vidyalaya (CBSE)</option>
							<option value="3">Shakuntala Vidyalaya (CG)</option>
							<option value="2">Sharda Vidyalaya Risali</option>
							<option value="4">Sharda Vidyalaya Vaishali Nagar</option>
						</select>
						<div id="search_school_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-2 mb-3">
						<select class="form-control" name="search_emp_type" id="search_emp_type">
							<option value="">Select Employee Type</option>
							<option value="1">Permanent</option>
							<option value="2">Adhoc</option>
						</select>
						<div id="search_emp_type_err" style="display:none; color:red;"></div>
					</div>
										
					<div class="col-sm-2 mb-3">
						<select class="form-control" name="search_emp_sub_type" id="search_emp_sub_type">
							<option value="">Employee Sub Type</option>
							<option value="1">Teacher</option>
							<option value="2">Peon + Helper + Driver</option>
							<option value="3">Shakuntala Gurukul</option>
						</select>
						<div id="search_emp_sub_type_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-2 mb-3">
						<select class="form-control" name="search_gender" id="search_gender">
							<option value="">Select Gender</option>
							<option value="1">Female</option>
							<option value="3">Male</option>
						</select>
						<div id="search_gender_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-md-2 mb-3">
						<button type="button" id="search" class="btn btn-info pull-left">Search</button>	
					</div>
			    </div>
    		</form>	
		</div><!-- end box body -->
		</div>
	
		<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title no-print"><b>Shakuntala Employee </b></h3>
            </div>
      		<div class="box-body table-responsive p-table-bg-head p-table-body">
				<table class="table">
					<thead><tr>
					<th>S.No.</th>
					<th>School</th>
					<th>Employee Type</th>
					<th>Employee Name</th>
					<th>Employee ID</th>
					<th>Gender</th>
					<th>Basic Salary</th>
					<th class="no-print">Action</th>
					</tr>
					</thead>
					<tbody id="employees_list"></tbody>
				</table>
      		</div>
 		</div>
	</div>
	
	<div id="update_record_modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Employee Details</h4>
      </div>
      <div class="modal-body">
        			<form role="form" action="javascript:void(0);" id="update_employee_form" class="form-horizontal" method="POST">
			<div class="box-body">
                <div class="row">
				<div class="col-md-6">
				
				<input type="hidden" id="emp_id" value="">
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Employee Type: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
						<select class="form-control" name="emp_type" id="emp_type">
							<option value="">Select Type</option>
							<option value="1">Permanent</option>
							<option value="2">Adhoc</option>
						</select>
						<div id="emp_type_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Employee Sub Type: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
						<select class="form-control" name="emp_sub_type" id="emp_sub_type">
							<option value="">Select Sub Type</option>
							<?php foreach($emp_sub_type as $sub_type){?>
							<option value="<?php echo $sub_type['est_id'];?>"><?php echo $sub_type['sub_type_name'];?></option>
							<?php }?>
						</select>
						<div id="emp_sub_type_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Employee Name: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="emp_name" id="emp_name" class="form-control only_text" placeholder="Employee Name">
							<div id="emp_name_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Employee ID: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="emp_generated_id" id="emp_generated_id" class="form-control only_text" placeholder="Employee ID">
							<div id="emp_generated_id_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">School: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<select name="school" id="school" class="form-control">
							<option value="">Select School</option>
							<option value="1" selected>Shakuntala Vidyalaya (CBSE) Records</option>
							<option value="3">Shakuntala Vidyalaya (CG) Records</option>
							<option value="2">Sharda Vidyalaya Risali</option>
							<option value="4">Sharda Vidyalaya Vaishali Nagar</option>
						</select>
							<div id="school_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Session: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
						<select class="form-control" name="session" id="session">
							<option value="">Select Session</option>
							<option value="3" selected>2019-20</option>
						</select>
						<div id="session_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Post: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
						<select class="form-control" name="emp_post" id="emp_post">
							<option value="">Select Post</option>
							<?php foreach($post as $posts){?>
							<option value="<?php echo $posts['ep_id'];?>"><?php echo $posts['name'];?></option>
							<?php }?>
							
						</select>
						<div id="emp_post_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Date of Join: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
					  <input type="date" max="<?php echo date('Y-m-d')?>" value="<?php echo date('Y-m-d');?>" class="form-control" id="doj" name="doj" placeholder="Date of Joining">
					<div id="doj_err" style="display:none; color:red;"></div>
					</div>
					<!-- /.input group -->
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Father/Hashband Name: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="f_or_h_name" id="f_or_h_name" class="form-control only_text" placeholder="Enter name">
							<div id="f_or_h_name_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Gender: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
					<select class="form-control" id="gender" name="gender">
						<option value="">Select Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
					 <div id="gender_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				               
				<div class="form-group">
					<label class="col-sm-3 control-label">Date Of Birth: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
					  <input type="date"max="<?php echo date('Y-m-d')?>" class="form-control" id="dob" name="dob" placeholder="Date of Birth"> 
					<div id="dob_err" class="text-danger" style="display:none;"></div> 
					</div>
					<!-- /.input group -->
				</div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Aadhaar Card Number:</label>
					<div class="col-sm-8">
						<input type="text" name="aadhaar_no" id="aadhaar_no" class="form-control" placeholder="Enter aadhaar card no." maxlength="12">
						<div id="aadhaar_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Permanent Address: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
						<textarea name="prmt_add" id="prmt_add" class="form-control" rows="3" placeholder="Enter permanent address"></textarea>
						<div id="prmt_add_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Local Address: </label>
					<div class="col-sm-8">
						<textarea name="local_add" id="local_add" class="form-control" rows="3" placeholder="Enter local address"></textarea>
						<div id="local_add_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
                  <label class="col-sm-3 control-label">Contact No.: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
						<input type="text" name="phone_no" id="phone_no" class="form-control only_int" placeholder="Enter contact no.">
						<div id="phone_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Other Contact No.:</label>
					<div class="col-sm-8">
						<input type="text" name="other_no" id="other_no" class="form-control only_int" placeholder="Enter contact no.">
						<div id="other_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Email ID:</label>
					<div class="col-sm-8">
						<input type="text" name="email" id="email" class="form-control" placeholder="Enter email id">
						<div id="email_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
				  <div id="display_emp_image"></div>
				  <input type="text" id="old_emp_image">
                  <label class="col-sm-3 control-label" for="exampleInputFile">Profile Image:</label>
                  <div class="col-sm-8"><input type="file" name="emp_image" id="emp_image"></div>
                  <div id="emp_image_err"></div>
                </div>
				
				<h5 style="    background-color: #888;    padding: 10px;    color: #fff;    margin: 30px 15px;">Bank Details</h5>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Basic Salary: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="basic_salary" id="basic_salary" class="form-control only_text" placeholder="Enter Amount">
							<div id="basic_salary_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">DA Percentange: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="da_percentange" id="da_percentange" class="form-control only_text" placeholder="DA Percentange">
							<div id="da_percentange_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">PA: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="pa_amount" id="pa_amount" class="form-control only_text" placeholder="Enter Amount">
							<div id="pa_amount_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">PF No.: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="pf_no" id="pf_no" class="form-control only_text" placeholder="Enter PF No.">
							<div id="pf_no_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">ESIC No.: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="esic_no" id="esic_no" class="form-control only_text" placeholder="Enter ESIC No.">
							<div id="esic_no_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Bank Name: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="bank_name" id="bank_name" class="form-control only_text" placeholder="Bank Name">
							<div id="bank_name_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Bank A/C No: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="bank_acc_no" id="bank_acc_no" class="form-control only_text" placeholder="Bank A/C No.">
							<div id="bank_acc_no_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Bank IFSC CODE: <span style="color:red;">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="bank_ifsc_code" id="bank_ifsc_code" class="form-control only_text" placeholder="Bank IFSC CODE">
							<div id="bank_ifsc_code_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
                      	<div class="text-center">
                            <button type="button" id="submit_emp_details" class="btn btn-success btn-space">Submit</button>
                        </div>
        			</div>
				</div>
				
				</div>
			</div>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</div>
	
<script type="text/javascript">
var baseUrl = $('#base_url').val();
var ses_id = $('#search_session').val();
var sch_id = $('#search_school').val();
var emp_type = $('#search_emp_type').val();
var emp_sub_type = $('#search_emp_sub_type').val();
var gender = $('#search_gender').val();
emp_list(ses_id,sch_id,emp_type,emp_sub_type,gender);


$(document).on('click','#search_school',function(){
	var ses_id = $('#search_session').val();
	var sch_id = $(this).val();
	var emp_type = $('#search_emp_type').val();
	var emp_sub_type = $('#search_emp_sub_type').val();
	var gender = $('#search_gender').val();
	emp_list(ses_id,sch_id,emp_type,emp_sub_type,gender);	
});
$(document).on('click','#search_emp_type',function(){
	var ses_id = $('#search_session').val();
	var sch_id = $('#search_school').val();
	var emp_type = $(this).val();
	var emp_sub_type = $('#search_emp_sub_type').val();
	var gender = $('#search_gender').val();
	emp_list(ses_id,sch_id,emp_type,emp_sub_type,gender);	
});

$(document).on('click','#search_emp_sub_type',function(){
	var ses_id = $('#search_session').val();
	var sch_id = $('#search_school').val();
	var emp_type = $('#search_emp_type').val();
	var emp_sub_type = $(this).val();
	var gender = $('#search_gender').val();
	emp_list(ses_id,sch_id,emp_type,emp_sub_type,gender);	
});

$(document).on('click','#search_gender',function(){
	var ses_id = $('#search_session').val();
	var sch_id = $('#search_school').val();
	var emp_type = $('#search_emp_type').val();
	var emp_sub_type = $('#search_emp_sub_type').val();
	var gender = $(this).val();
	emp_list(ses_id,sch_id,emp_type,emp_sub_type,gender);	
});

function emp_list(ses_id,sch_id,emp_type,emp_sub_type,gender){
	$.ajax({
		type:'POST',
		url:baseUrl+'payroll/Payroll_ctrl/employee_list',
		data:{'ses_id':ses_id,'sch_id':sch_id,'emp_type':emp_type,'emp_sub_type':emp_sub_type,'gender':gender},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var x='';
				$.each(response.data,function(key,value){
					if(value.sch_id == 1){
						var school_name = 'Shakuntala Vidyalaya (CBSE)';
					}else if(value.sch_id == 2){
						var school_name = 'Sharda Vidyalaya Risali';
					}else if(value.sch_id == 3){
						var school_name = 'Shakuntala Vidyalaya (CG)';
					}else if(value.sch_id == 4){
						var school_name = 'Sharda Vidyalaya Vaishali Nagar';
					}
					x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'</td>'+
						'<td>'+school_name+'</td>'+
						'<td>'+value.et_name+' / '+value.sub_type_name+'</td>'+
						'<td>'+value.emp_name+'</td>'+
						'<td>'+value.emp_generated_id+'</td>'+
						'<td>'+value.gender+'</td>'+
						'<td>'+value.basic_salary+'</td>'+
						'<td><button id="'+value.emp_id+'" class="btn btn-success edit">Edit</button> '+
						'<button id="'+value.emp_id+'" class="btn btn-danger delete">Delete</button></td>'+
					'</tr>';
				});
				$('#employees_list').html(x);
			}else{
				$('#employees_list').html('<tr><td colspan="8" class="text-center">Record not found</td></tr>');
			}
		},
	});
}
//-----------------**------------------------
$(document).on('click','.delete',function(){
	var delete_id = $(this).attr('id');
	if(confirm('Are you sure!')){
		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/delete_employee',
			data:{'delete_id':delete_id},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					alert(response.msg);
					location.reload();
				}else{
					alert(response.msg);
				}
			},
		});
	}
});
//-----------------**------------------------------
$(document).on('click','.edit',function(){
	var edit_id = $(this).attr('id');
	$.ajax({
		type:'POST',
		url:baseUrl+'payroll/Payroll_ctrl/employee_edit_details',
		data:{"edit_id":edit_id},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				$('#emp_id').val(response.data[0]['emp_id']);
				$('#emp_type').val(response.data[0]['emp_type']);

				$('#emp_sub_type').val(response.data[0]['emp_sub_type']);
				var x='<option value="">Select Sub Type</option>';
				$.each(response.emp_sub_type,function(k,v){
						if(response.data[0]['emp_sub_type'] == v.est_id){
						var selected = 'selected';	
						}else{
							var selected = '';
						}
						x=x+'<option value="'+v.est_id+'" '+selected+'>'+v.sub_type_name+'</option>';
				});
				$('#emp_sub_type').html(x);
				
				$('#emp_name').val(response.data[0]['emp_name']);
				$('#emp_generated_id').val(response.data[0]['emp_generated_id']);
				$('#school').val(response.data[0]['sch_id']);
				$('#session').val(response.data[0]['ses_id']);
				$('#emp_post').val(response.data[0]['post_id']);
				$('#doj').val(response.data[0]['doj']);
				$('#f_or_h_name').val(response.data[0]['f_or_h_name']);
				$('#gender').val(response.data[0]['gender']);
				$('#dob').val(response.data[0]['dob']);
				$('#aadhaar_no').val(response.data[0]['aadhaar_no']);
				$('#prmt_add').val(response.data[0]['prmt_add']);
				$('#local_add').val(response.data[0]['local_add']);
				$('#phone_no').val(response.data[0]['phone_no']);
				$('#other_no').val(response.data[0]['other_no']);
				$('#email').val(response.data[0]['email']);
				if(response.data[0]['emp_image'] != ''){
					$('#display_emp_image').html('<img src="'+baseUrl+'assets/images/payroll/employees/'+response.data[0]['emp_image']+'"  width="150" height="80">').css('display','block');
					$('#old_emp_image').val(response.data[0]['emp_image']);
				}
				$('#basic_salary').val(response.data[0]['basic_salary']);

				$('#da_percentange').val(response.data[0]['da_percentange']);
				$('#pa_amount').val(response.data[0]['pa_amount']);
				
				$('#pf_no').val(response.data[0]['pf_no']);
				$('#esic_no').val(response.data[0]['esic_no']);
				$('#bank_name').val(response.data[0]['bank_name']);
				$('#bank_acc_no').val(response.data[0]['bank_acc_no']);
				$('#bank_ifsc_code').val(response.data[0]['bank_ifsc_code']);
				
				$('#update_record_modal').modal('show');
			}
		},
	});
});



$('#update_employee_form').validate({
	rules:{
		emp_type:{required:true},
		emp_sub_type:{required:true},
		emp_name:{required:true},
		emp_generated_id:{required:true},
		school:{required:true},
		session:{required:true},
		emp_post:{required:true},
		doj:{required:true},
		f_or_h_name:{required:true},
		gender:{required:true},
		dob:{required:true},
		//aadhaar_no:{required:true},
		prmt_add:{required:true},
		//local_add:{required:true},
		phone_no:{required:true},
		//other_no:{required:true},
		email:{email:true},
		emp_image:{extension:"jpg|png|jpeg"},
		basic_salary:{required:true},
		da_amount:{required:true},
		pf_no:{required:true},
		esic_no:{required:true},
		bank_name:{required:true},
		bank_acc_no:{required:true},
		bank_ifsc_code:{required:true}
		
	},
});

$(document).on('click','#submit_emp_details',function(){
	var formvalidate = $('#update_employee_form').valid();
	if(formvalidate){
		var formdata = new FormData();
		formdata.append('emp_id',$('#emp_id').val());
		formdata.append('emp_type',$('#emp_type').val());
		formdata.append('emp_sub_type',$('#emp_sub_type').val());
		formdata.append('emp_name',$('#emp_name').val());
		formdata.append('emp_generated_id',$('#emp_generated_id').val());
		formdata.append('sch_id',$('#school').val());
		formdata.append('ses_id',$('#session').val());
		formdata.append('post_id',$('#emp_post').val());
		formdata.append('doj',$('#doj').val());
		formdata.append('f_or_h_name',$('#f_or_h_name').val());
		formdata.append('gender',$('#gender').val());
		formdata.append('dob',$('#dob').val());
		formdata.append('aadhaar_no',$('#aadhaar_no').val());
		formdata.append('prmt_add',$('#prmt_add').val());
		formdata.append('local_add',$('#local_add').val());
		formdata.append('phone_no',$('#phone_no').val());
		formdata.append('other_no',$('#other_no').val());
		formdata.append('email',$('#email').val());

		formdata.append('old_emp_image',$('#old_emp_image').val());
		formdata.append('emp_image',$('#emp_image')[0].files[0]);
		
		formdata.append('basic_salary',$('#basic_salary').val());

		formdata.append('da_percentange',$('#da_percentange').val());
		formdata.append('pa_amount',$('#pa_amount').val());
		
		formdata.append('pf_no',$('#pf_no').val());
		formdata.append('esic_no',$('#esic_no').val());
		formdata.append('bank_name',$('#bank_name').val());
		formdata.append('bank_acc_no',$('#bank_acc_no').val());
		formdata.append('bank_ifsc_code',$('#bank_ifsc_code').val());

		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/submit_new_employee',
			data:formdata,
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					alert(response.msg);
					location.reload();
				}else{
					alert(response.msg);
				}
			},
			cache:false,
			processData:false,
			contentType:false
		});
	}
});


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