<div class="content-wrapper">
    <section class="content-header">
      <h1>Profile<small>Details</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
    <li class="active">profile</li>
  </ol>
</section>
<!-- main section -->
<?php if(!$is_admin){?>
			<div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Update Profile</h3>
                  <form role="form" class="form-horizontal" id="profile_form">
    					<div class="box-body">
					      	<div class="form-group">
                              <label class="col-sm-3 control-label">Name</label>
                              <div class="col-sm-6">
            					<input type="text" name="teacher_name" id="teacher_name" class="form-control" value="<?php echo $user_details[0]['teacher_name'];?>" placeholder="Name">
            						<div id="teacher_name_err" style="display:none;color:red;"></div>
            					</div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-3 control-label">Gender</label>
                              <div class="col-sm-6">
            					<select id="gender" name="gender" class="form-control">
            						<option value="">Select Gender</option>
            						<option value="Male"<?php if($user_details[0]['gender'] == 'Male'){echo "selected";}?>>Male</option>
            						<option value="Female" <?php if($user_details[0]['gender'] == 'Female'){echo "selected";}?>>Female</option>
            					</select>
            					<div id="gender_err" style="display:none;color:red;"></div>
            					</div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-3 control-label">DOB</label>
                              <div class="col-sm-6">
            					<input type="date" name="dob" id="dob" class="form-control" placeholder="Date of Birth" value="<?php echo $user_details[0]['dob'];?>">
            						<div id="dob_err" style="display:none;color:red;"></div>
            					</div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-3 control-label">Phone</label>
                              <div class="col-sm-6">
            					<input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number" value="<?php echo $user_details[0]['phone'];?>">
            						<div id="phone_err" style="display:none;color:red;"></div>
            					</div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-3 control-label">Email</label>
                              <div class="col-sm-6">
            					<input type="text" name="email" id="email" class="form-control" placeholder="Email Id" value="<?php echo $user_details[0]['email'];?>">
            						<div id="email_err" style="display:none;color:red;"></div>
            					</div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-3 control-label">Address</label>
                              <div class="col-sm-6">
                              <textarea rows="" cols="" name="prmt_address" id="prmt_address" class="form-control" placeholder="Address"><?php echo $user_details[0]['prmt_address'];?></textarea>
            						<div id="prmt_address_err" style="display:none;color:red;"></div>
            					</div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-3 control-label">Designation</label>
                              <div class="col-sm-6">
            					<input type="text" name="designation" id="designation" class="form-control" placeholder="Designation" value="<?php echo $user_details[0]['designation'];?>">
            						<div id="designation_err" style="display:none;color:red;"></div>
            					</div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-3 control-label">Qualifications</label>
                              <div class="col-sm-6">
            					<input type="text" name="qualifications" id="qualifications" class="form-control" placeholder="Qualifications" value="<?php echo $user_details[0]['qualifications'];?>">
            						<div id="qualifications_err" style="display:none;color:red;"></div>
            					</div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-3 control-label">Image</label>
                              <div class="col-sm-6">
                              <?php 
                              $path = base_url().'assets/images/sharda/teachers/'.$user_details[0]['image'];
                                if($this->session->userdata('school_id') == 1){
                                    $path = base_url().'assets/images/shakuntala/teachers/'.$user_details[0]['image'];
                                }
                              ?>
                              	<img alt="" src="<?php echo $path;?>" height="100" width="100" />
                              	
                              	<input type="hidden" id="old_image" value="<?php echo $user_details[0]['image'];?>">
            					<input type="file" name="image" id="image" class="form-control">
            						<div id="image_err" style="display:none;color:red;"></div>
            					</div>
                            </div>
                            
                            <div class="form-group">
                              <div class="col-sm-6">
                              <input type="button" class="btn btn-success pull-right" id="update_profile" value="Update Profile">
            					</div>
                            </div>
    					</div>
				  </form>
                </div>
             </div>
             </div>
             <?php }?>
             <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Change Password</h3>
                  <form role="form" class="form-horizontal" id="change_password">
    					<div class="box-body">
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Old Password</label>
                          <div class="col-sm-6">
        					<input type="password" name="old_password" id="old_password" class="form-control">
        						<div id="old_password_err" style="display:none;color:red;"></div>
        					</div>
                        </div>
                        
                         <div class="form-group">
                          <label class="col-sm-3 control-label">New Password</label>
                          <div class="col-sm-6">
        					<input type="password" name="new_password" id="new_password" class="form-control">
        						<div id="new_password_err" style="display:none;color:red;"></div>
        					</div>
                        </div>
                        
                         <div class="form-group">
                          <label class="col-sm-3 control-label">Confirm Password</label>
                          <div class="col-sm-6">
        					<input type="password" name="confirm_password" id="confirm_password" class="form-control">
        						<div id="confirm_password_err" style="display:none;color:red;"></div>
        					</div>
                        </div>
                        
                    	<div class="form-group">
                          <div class="col-sm-6">
        					 <input type="button" id="update_password" class="btn btn-success pull-right" value="Update Password">
        					</div>
                        </div>
                            
                        </div>
                   </form>
                </div>
             </div>
         </div>
</div>

<script type="text/javascript">
var baseUrl = $('#base_url').val();

$('#profile_form').validate({
	rules:{
		teacher_name:{required:true},
		gender:{required:true},
		dob:{required:true},
		phone:{required:true},
		email:{required:true},
		prmt_address:{required:true},
		designation:{required:true},
		qualifications:{required:true},
// 		image:{required:true},
	},
});

$(document).on('click','#update_profile',function(){
	var formvalidate = $('#profile_form').valid();
	if(formvalidate){
		var formdata = new FormData();
		formdata.append('teacher_name',$('#teacher_name').val());
		formdata.append('gender',$('#gender').val());
		formdata.append('dob',$('#dob').val());
		formdata.append('phone',$('#phone').val());
		formdata.append('email',$('#email').val());
		formdata.append('prmt_address',$('#prmt_address').val());
		formdata.append('designation',$('#designation').val());
		formdata.append('qualifications',$('#qualifications').val());
		formdata.append('old_image',$('#old_image').val());
		formdata.append('image',$('#image')[0].files[0]);
		$.ajax({
			type:'POST',
			url:baseUrl+'Admin_ctrl/updateProfile',
			data:formdata,
			dataType:'json',
			beforeSend:function(){
				$('#loader').modal('show');
			},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					alert(response.msg);
					location.reload();
				}else{
					alert(response.msg);
					}
			},	
		cache:false,
		contentType:false,
		processData:false
		});
		
	}
});

$(document).on('click','#update_password',function(){
	
	var old_password = $.trim($('#old_password').val());
	var new_password = $.trim($('#new_password').val());
	var confirm_password = $.trim($('#confirm_password').val());

	var formvalidate = true;
	
	if(old_password == ''){
		$('#old_password_err').html('This is Required.').css('display','block');
		formvalidate = false;
	}else{
		$('#old_password_err').css('display','none');
	}

	if(new_password == ''){
		$('#new_password_err').html('This is Required.').css('display','block');
		formvalidate = false;
	}else{
		$('#new_password_err').css('display','none');
	}

	if(confirm_password == ''){
		$('#confirm_password_err').html('This is Required.').css('display','block');
		formvalidate = false;
	}else if(confirm_password != new_password){
		$('#confirm_password_err').html('Password not match.').css('display','block');
		formvalidate = false;
	}else{
		$('#confirm_password_err').css('display','none');
	}

	if(formvalidate){
		$.ajax({
			type:'POST',
			url:baseUrl+'Admin_ctrl/changePassword',
			data:{'old_password':old_password,'new_password':new_password,'confirm_password':confirm_password},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					alert('Password change successfully');
				}else if(response.status == 201){
					alert('Old Password not Match.');
					}else{
						alert('Something went wrong,Please Try again.');
						}
			},
		});
	}

	
});
</script>



