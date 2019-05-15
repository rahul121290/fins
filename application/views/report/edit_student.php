<div class="content-wrapper">
    <section class="content-header">
      <h1>Update<small>students</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
        <li class="active">update student</li>
      </ol>
    </section>

    <!-- Main content -->
	<section class="content">
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">
			
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Update Student</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			
			<form id="student_form" role="form" class="form-horizontal" id="student_form" method="POST">
			<div class="box-body">
                <input type="hidden" id="std_id" name="std_id" value="<?php echo $result[0]['std_id'];?>">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Admission No.</label>
                  <div class="col-sm-6">
					<input type="text" name="admission_no" id="admission_no" class="form-control" value="<?php echo $result[0]['adm_no'];?>">
					<div id="admission_no_err" style="display:none;color:red;"></div>
				</div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Roll No.</label>
                  <div class="col-sm-6">
					<input type="text" name="roll_no" id="roll_no" class="form-control" value="<?php echo $result[0]['roll_no'];?>">
					<div id="roll_no_err"	 style="display:none;color:red;"></div>
				  </div>
                </div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Student Name</label>
						<div class="col-sm-6">
							<input type="text" name="student_name" id="student_name" class="form-control" value="<?php echo $result[0]['name'];?>">
							<div id="student_name_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Medium</label>
						<div class="col-sm-6">
							<select class="form-control" name="medium" id="medium">
								<option value="">Select Medium</option>
								<?php foreach($medium as $med){?>
								    <option value="<?php echo $med['med_id'];?>"<?php if($med['med_id'] == $result[0]['medium']){ echo "Selected"; }?>><?php echo $med['med_name'];?></option>
								<?php }?>
							</select>
							<div id="medium_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
					
				<div class="form-group">
					<label class="col-sm-3 control-label">Class</label>
					<div class="col-sm-6">
						<select class="form-control" name="class" id="class">
							<option value="">Select Class</option>
							<?php foreach($class as $classes){?>
								<option value="<?php echo $classes['c_id'];?>"<?php if($classes['c_id']==$result[0]['class_id']){echo "Selected";}?> ><?php echo $classes['class_name'];?></option>
							<?php } ?>
						</select>
						<div id="class_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Section</label>
					<div class="col-sm-6">
					<select class="form-control" name="section" id="section">
						<option value="">Select Section</option>
						<?php foreach($section as $sec){?>
						<option value="<?php echo $sec['sec_id'];?>" <?php if($sec['sec_id']==$result[0]['sec_id']){echo "Selected";}?>><?php echo $sec['section_name'];?></option>
						<?php }?>
					</select>
					<div id="section_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group" id="fit_section">
                    <label class="col-sm-3 control-label">FIT</label>
					<div class="col-sm-6">
					<select class="form-control" name="fit" id="fit">
						<option value="">Select FIT</option>
						    <option value="Yes"<?php if($result[0]['fit'] == 'Yes'){echo "Selected";}?>>Yes</option>
							<option value="No"<?php if($result[0]['fit'] == 'No'){echo "Selected";}?>>No</option>
					</select>
					<div id="fit_err" style="display:none; color:red;"></div>
					</div>
				</div>
				
				<div class="form-group" id="elective_section">
                    <label class="col-sm-3 control-label">Elective Subject</label>
					<div class="col-sm-6">
					<select class="form-control" name="elective" id="elective_subject">
						<option value="">Select Elective Subject</option>
						<?php foreach($elective as $elect){?>
						<option value="<?php echo $elect['sub_id'];?>"<?php if($elect['sub_id']==$result[0]['elective']){echo "Selected";}?>><?php echo $elect['sub_name'];?></option>
						<?php }?>
					</select>
					<div id="elective_subject_err" style="display:none; color:red;"></div>
					</div>
				</div>
				
				<div class="form-group" id="sub_group_section">
                    <label class="col-sm-3 control-label">Subject Group</label>
					<div class="col-sm-6">
					<select class="form-control" name="subject_group" id="subject_group">
						<option value="" >Select Subject Group</option>
						<?php foreach($group as $groups){?>
						<option value="<?php echo $groups['sg_id'];?>"<?php if($groups['sg_id']==$result[0]['sub_group']){echo "Selected";}?>><?php echo $groups['sg_name'];?></option>
						<?php } ?>
					</select>
					<div id="subject_group_err" style="display:none; color:red;"></div>
					</div>
				</div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Father's Name</label>
					<div class="col-sm-6">
						<input type="text" name="father_name" id="father_name" class="form-control" value="<?php echo $result[0]['f_name'];?>">
						<div id="father_name_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
					<label class="col-sm-3 control-label">Mother's Name</label>
					<div class="col-sm-6">
						<input type="text" name="mother_name" id="mother_name" class="form-control" value="<?php echo $result[0]['m_name'];?>">
						<div id="mother_name_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
					<label class="col-sm-3 control-label">Date Of Birth</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control datepicker" id="dob" name="dob" value="<?php echo $result[0]['dob'];?>"> 
					<div id="dob_err" class="text-danger" style="display:none;"></div> 
					</div>
					<!-- /.input group -->
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Gender</label>
					<div class="col-sm-6">
					<select class="form-control" id="gender" name="gender">
						<option value="">Select Gender</option>
							<option value="male"<?php if($result[0]['gender']=='male'){echo "Selected";}?>>Male</option>
							<option value="female"<?php if($result[0]['gender']=='female'){echo "Selected";}?>>Female</option>    
					</select>
					 <div id="gender_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Date of Admission</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control datepicker" id="admission_date" name="admission_date" value="<?php echo $result[0]['admission_date'];?>">
					<div id="admission_date_err" style="display:none; color:red;"></div>
					</div>
					<!-- /.input group -->
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Caste</label>
					<div class="col-sm-6">
					<select class="form-control" name="caste" id="caste">
						<option value="">Select Caste</option>
						<option value="General"<?php if($result[0]['cast'] == 'General'){echo "Selected";}?>>General</option>
						<option value="OBC" <?php if($result[0]['cast'] == 'OBC'){echo "Selected";}?>>OBC</option>
						<option value="ST" <?php if($result[0]['cast'] == 'ST'){echo "Selected";}?>>ST</option>
						<option value="SC" <?php if($result[0]['cast'] == 'SC'){echo "Selected";}?>>SC</option>
					</select>
					<div id="caste_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Blood Group</label>
					<div class="col-sm-6">
					<select class="form-control" name="blood" id="blood">
						<option value="">Select Blood Group</option>
						<option value="A+"<?php if($result[0]['blood_group']=='A+'){echo "Selected";}?>>A+</option>
						<option value="A-"<?php if($result[0]['blood_group']=='A-'){echo "Selected";}?>>A-</option>
						<option value="B+"<?php if($result[0]['blood_group']=='B+'){echo "Selected";}?>>B+</option>
						<option value="B-"<?php if($result[0]['blood_group']=='B-'){echo "Selected";}?>>B-</option>
						<option value="O+"<?php if($result[0]['blood_group']=='O+'){echo "Selected";}?>>O+</option>
						<option value="O-"<?php if($result[0]['blood_group']=='O-'){echo "Selected";}?>>O-</option>
						<option value="AB+"<?php if($result[0]['blood_group']=='AB+'){echo "Selected";}?>>AB+</option>
						<option value="AB-"<?php if($result[0]['blood_group']=='AB-'){echo "Selected";}?>>AB-</option>
						
					</select>
					<div id="blood_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label">Aadhaar Card Number</label>
					<div class="col-sm-6">
						<input type="text" name="aadhaar" id="aadhaar" class="form-control" maxlength="12" value="<?php echo $result[0]['aadhar_no'];?>">
						<div id="aadhaar_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Permanent Address</label>
					<div class="col-sm-6">
						<textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter permanent address"><?php echo$result[0]['address'];?></textarea>
						<div id="address_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Guardian Name</label>
					<div class="col-sm-6">
						<input type="text" name="guardian" id="guardian" class="form-control" value="<?php echo $result[0]['guardian'];?>">
						<div id="guardian_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Local Address </label>
					<div class="col-sm-6">
						<textarea name="local_address" id="local_address" class="form-control" rows="3"><?php echo $result[0]['local_address'];?></textarea>
						<div id="local_address_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Contact No.</label>
					<div class="col-sm-6">
						<input type="text" name="contact_no" id="contact_no" class="form-control" value="<?php echo $result[0]['contact_no'];?>">
						<div id="contact_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Email ID</label>
					<div class="col-sm-6">
						<input type="text" name="email" id="email" class="form-control" value="<?php echo $result[0]['email_id'];?>">
						<div id="email_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Medical History</label>
					<div class="col-sm-6">
						<input type="text" name="medical" id="medical" class="form-control" value="<?php echo $result[0]['medical'];?>">
						<div id="medical_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Height </label>
					<div class="col-sm-6">
						<input type="text" name="height" id="height" class="form-control" value="<?php echo $result[0]['height'];?>">
						<div id="height_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-3 control-label">Weight</label>
					<div class="col-sm-6">
						<input type="text" name="weight" id="weight" class="form-control" value="<?php echo $result[0]['weight'];?>">
						<div id="weight_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                    <label class="col-sm-3 control-label">TC Self</label>
					<div class="col-sm-6">
					<select class="form-control" name="transfer" id="transfer">
						<option value="">Select TC Self</option>
						<option value="Bonafide"<?php if($result[0]['tc']=='Bonafide'){echo "Selected";}?>>Bonafide</option>
						<option value="Fresher"<?php if($result[0]['tc']=='Fresher'){echo "Selected";}?>>Fresher</option>
					</select>
					<div id="transfer_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">hostel</label>
					<div class="col-sm-6">
					<select class="form-control" name="hostel" id="hostel">
						<option value="">Select hostel</option>
						<?php foreach($hostel as $hostels){?>
							<option value="<?php echo $hostels['hid'];?>"<?php if($result[0]['hostel_id']==$hostels['hid']){echo "Selected";}?>><?php echo $hostels['hostel_name'];?></option>
						<?php }?>
					</select>
					<div id="house_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Hostler</label>
					<div class="col-sm-6">
					<select class="form-control" name="hostler" id="hostler">
						<option value="">Select Hostler</option>
						<option value="Yes" <?php if($result[0]['hostler']=='Yes'){echo "Selected";}?>>Yes</option>
						<option value="No"<?php if($result[0]['hostler'] == 'No'){echo "Selected";}?>>No</option>
					</select>
					<div id="hostler_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
                  <label class="col-sm-3 control-label" for="exampleInputFile">Profile Image</label>
                  <input type="hidden" id="old_image" name="old_image" value="<?php echo $result[0]['photo'];?>">
                  <div>
                  <?php if(!empty($result[0]['photo'])&& file_exists("assets/images/students/temp/".$result[0]['photo'])){?>
                  <img src="<?php echo base_url();?>assets/images/students/temp/<?php echo $result[0]['photo'];?>" style="height:50px;" width="50px;">
                  <?php }else{ echo "NULL"; } ?>
                  </div><br>
                  <div class="col-sm-offset-3"><input type="file" name="std_image" id="std_image"></div>
                  <div id="std_image_err"></div>
                </div>
			
			</div>
			<div class="box-footer">
                      	<div class="col-sm-offset-8">
                            <button type="button" name="submit" id="submit" class="btn btn-info">Submit</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
        			</div>
			</form>
		</div>
        </section>
</div>

<script type="text/javascript">
var base_url = $('#base_url').val();

//----------datepicker-------------------------------------------
$( ".datepicker" ).datepicker({
	changeMonth: true,
	changeYear: true,
	yearRange:"-50:+0",
	dateFormat: 'dd-mm-yy'
});

//--------------check existing admission no--------------------------------
$(document).on('keyup','#admission_no',function(){
	var admission_no = $('#admission_no').val();
	$.ajax({
			type:'POST',
			url:base_url+'Student_ctrl/check_admission_no',
			data:{'admission_no':admission_no},
			dataType:'json',
			success:function(response){
				if(response.status == 200){
					$('#admission_no_err').html('<strong>'+response.result[0].adm_no+'</strong> is already exist.').css('display','block');
				}else{
					$('#admission_no_err').css('display','none');
					}
			},
		});
});

//---------------check existing roll number----------------------------
$(document).on('keyup','#roll_no',function(){
	var roll_no = $('#roll_no').val();
	$.ajax({
			type:'POST',
			url:base_url+'Student_ctrl/check_roll_no',
			data:{'roll_no':roll_no},
			dataType:'json',
			success:function(response){
				if(response.status == 200){
					$('#roll_no_err').html('<strong>'+response.result[0].roll_no+'</strong> is already exist.').css('display','block');
				}else{
					$('#roll_no_err').css('display','none');
					}
			},
		});
});

$(document).on('change','#class',function(){
	  var c_id = $(this).val();
	  if(c_id == 12 || c_id == 13){
		  $('#fit_section').css('display','block');
	  }
	  else{
		 $('#fit_section').css('display','none'); 
	  }
	  
	  if(c_id == 14 || c_id == 15){
		$('#sub_group_section').css('display','block');  
		$('#elective_section').css('display','block');
	  }else{
		$('#sub_group_section').css('display','none');
		$('#elective_section').css('display','none');		
	  }
});


//--------------------add student-------------------------------------------------
$('#student_form').validate({
	rules:{
		admission_no:{required:true},
		roll_no:{required:true},
		student_name:{required:true},
		medium:{required:true},
		class:{required:true},
		section:{required:true},
		father_name:{required:true},
		mother_name:{required:true},
		dob:{required:true},
		gender:{required:true},
		admission_date:{required:true},
		caste:{required:true},
//			blood:{required:true},
		aadhaar:{required:true},
		address:{required:true},
//			guardian:{required:true},
//			local_address:{required:true},
		contact_no:{required:true},
		email:{email:true},
//			medical:{required:true},
//			height:{required:true},
//			weight:{required:true},
		transfer:{required:true},
//			house:{required:true},
//			hostler:{required:true},
//			std_image:{required:true},
		},
	messages:{
		},
});
$(document).on('click','#submit',function(){
    	
    var formvalidate = $('#student_form').valid();//----- formvalidate = true-------------------

    if(formvalidate == true){
    	//----------------validation for fit,elective and subject groups---------------------------
    	var class_id = $('#class').val();
    	if(class_id == 12 || class_id == 13){
    		if($('#fit').val() == ''){
    			$('#fit_err').html('This field is required.').css('display','block');
    			return false;
    			}else{
    				$('#fit_err').css('display','none');
    			}		
    	}
    
    	if(class_id == 14 || class_id == 15){
    		if($('#elective_subject').val() == ''){
    			$('#elective_subject_err').html('Elective subject is required.').css('display','block');
    			return false;
    			}else{
    				$('#elective_subject_err').css('display','none');
    				}
    		if($('#subject_group').val() == ''){
    			$('#subject_group_err').html('Subject Group is required.').css('display','block');
    			return false;
    			}else{
    				$('#subject_group_err').css('display','none');
    				}	
    	}
    //------------------------------------------------------------------------------------
    
    //--------------validation for image-------------------------------------------------		
    	var img = $('#std_image').val();
    	if(img){
    		var img_ext=img.split('.').pop().toUpperCase();
    		var img_size=$('#std_image')[0].files[0].size;
    		if(img_ext!='JPG' && img_ext!='PNG' && img_ext!='GIF'){
    			$('#std_image_err').hide();
    			$('#std_image_err').text('');
    			$('#std_image_err').show();
    			$('#std_image_err').append("wrong file formate.");
    			return false;	
    		}
    		if(img_size>='1000024'){
    			$('#std_image_err').hide();
    			$('#std_image_err').text('');
    			$('#std_image_err').show();
    			$('#std_image_err').append("file size is to large.");
    			return false;
    		}		
    	}
//----------------------------------------------------------------------------------------

    		formdata = new FormData();
    		formdata.append('std_id',$('#std_id').val());
    		formdata.append('adm_no',$('#admission_no').val());
			formdata.append('adm_no',$('#admission_no').val());
			formdata.append('roll_no',$('#roll_no').val());
			formdata.append('name',$('#student_name').val());
			formdata.append('medium',$('#medium').val());
			formdata.append('class_id',$('#class').val());
			formdata.append('sec_id',$('#section').val());

			formdata.append('fit',$('#fit').val());
			formdata.append('elective',$('#elective_subject').val());
			formdata.append('sub_group',$('#subject_group').val());

			formdata.append('f_name',$('#father_name').val());
			formdata.append('m_name',$('#mother_name').val());
			formdata.append('dob',$('#dob').val());
			formdata.append('gender',$('#gender').val());
			formdata.append('admission_date',$('#admission_date').val());
			formdata.append('cast',$('#caste').val());
			formdata.append('blood_group',$('#blood').val());
			formdata.append('aadhar_no',$('#aadhaar').val());
			formdata.append('address',$('#address').val());
			formdata.append('guardian',$('#guardian').val());
			formdata.append('local_address',$('#local_address').val());
			formdata.append('contact_no',$('#contact_no').val());
			formdata.append('email_id',$('#email').val());
			formdata.append('medical',$('#medical').val());
			formdata.append('height',$('#height').val());
			formdata.append('weight',$('#weight').val());
			formdata.append('tc',$('#transfer').val());
			formdata.append('hostel',$('#hostel').val());
			formdata.append('hostler',$('#hostler').val());
			formdata.append('old_image',$('#old_image').val());
			formdata.append('std_image',$('#std_image')[0].files[0]);

			$.ajax({
				type:'POST',
				url:base_url+'Student_ctrl/add_student',
				data:formdata,
				async:false,
				dataType:'json',
				beforeSend:function(){
					$('#loader').modal('show');	
				},
				success:function(response){
					if(response.status == 200){
						alert(response.feedback);
						window.location.replace('<?php echo base_url();?>admin/student_records');
					}else{
						alert(response.feedback);
						}
				},
				cache:false,
				contentType:false,
				processData:false
			});
		}

});
</script>
