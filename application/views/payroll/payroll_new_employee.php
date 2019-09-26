<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>"/>
<div class="content-wrapper container">
    <section class="content-header">
      <h1>New Employee Payroll</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/payroll/dashbord"></i>Home</a></li>
        <li class="active">New Employee Payroll</li>
      </ol>
    </section>

    <!-- Main content -->
	<section class="content">
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Enroll New Employee Details</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			
			<form role="form" action="javascript:void(0);" id="new_employee_form" class="form-horizontal" method="POST">
			<div class="box-body">
                <div class="row">
				<div class="col-md-6">
				<div class="form-group">
					<label class="col-sm-3 control-label">Employee Grade: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
						<select class="form-control" name="emp_type" id="emp_type">
							<option value="">Select Grade</option>
							<option value="1">Permanent</option>
							<option value="2">Adhoc</option>
						</select>
						<div id="emp_type_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Employee Sub Grade: <span style="color:red;">*</span></label>
					<div class="col-sm-8">
						<select class="form-control" name="emp_sub_type" id="emp_sub_type">
							<option value="">Select Sub Grade</option>
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
						<input type="text" name="aadhaar_no" id="aadhaar_no" class="form-control only_int" placeholder="Enter aadhaar card no." maxlength="12">
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
					<label class="col-sm-3 control-label">DA (%): <span style="color:red;">*</span></label>
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
					<label class="col-sm-3 control-label">Bank A/C No.: <span style="color:red;">*</span></label>
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
        </section>
</div>
<script type="text/javascript">
var baseUrl = $('#base_url').val();
var userUrl = $('#user_url').val();

$('#new_employee_form').validate({
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
		da_percentange:{required:true},
		pa_amount:{required:true},
		pf_no:{required:true},
		esic_no:{required:true},
		bank_name:{required:true},
		bank_acc_no:{required:true},
		bank_ifsc_code:{required:true}
		
	},
});

$(document).on('click','#submit_emp_details',function(){
	var formvalidate = $('#new_employee_form').valid();
	if(formvalidate){
		var formdata = new FormData();
		formdata.append('emp_id','');
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

		formdata.append('old_emp_image','');
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
					window.location.href = baseUrl+userUrl+'/payroll-master/employee-salary-records';
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


