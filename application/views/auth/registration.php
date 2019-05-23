<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/login.css">
</head>
<body>
<input type="hidden" name="baseUrl" id="baseUrl" value="<?php echo base_url(); ?>">
<input type="hidden" name="apiUrl" id="apiUrl" value="<?php echo $this->config->item('api_url'); ?>">

<div class="container" style="center">
	<div class="login-form">
    	<div class="text-center">
    	<?php if($this->uri->segment(1) == 'sharda'){?>
    		<img alt="" src="<?php echo base_url();?>assets/images/sharda/sharda_logo.png" width="150">
    	<?php }else{?>
    		<img alt="" src="<?php echo base_url();?>assets/images/shakuntala/shakuntala.png" width="150">
    	<?php } ?>
    	</div>
    	
    	
    	<div id="infoMessage" style="text-align: center;"><?php echo $message;?></div>
    	<form class="form" name="f1" method="POST" action="<?php echo base_url();?>" autocomplete="off">
    		<div class="row">
    			Admin User-Name*:<input type="text" name="uname" id="uname">
    			<div id="error_uname" style="display:none;"></div>
    		</div>
    		<div class="row">
    			First-Name*:<input type="text" name="f_name" id="f_name">
    			<div id="error_f_name" style="display:none;"></div>
    		</div>
    		<div class="row">
    			Last-Name*:<input type="text" name="l_name" id="l_name">
    			<div id="error_l_name" style="display:none;"></div>
    		</div>
    		<div class="row">
    			Contact No.*:<input type="text" name="u_contact" id="u_contact">
    			<div id="error_u_contact" style="display:none;"></div>
    		</div>
    		<div class="row">
    			email_id*:<input type="email" name="email" id="email">
    			<div id="error_email" style="display:none;"></div>
    		</div>
    		<div class="row">
    			password*:<input type="password" name="password" id="password">
    			<div id="error_password" style="display:none;"></div>
    		</div>
    		<hr></hr>
    		<div class="row">
    		school name*: <input name="school_name" id="school_name" type="textbox" required>
    		<div id="error_school_name" style="display:none;"></div>
    		</div>
    		<div class="row">
    		Affilation No*: <input name="school_affilation" id="school_affilation" type="textbox" required>
    		<div id="error_school_affilation" style="display:none;"></div>
    		</div>
    		<div class="row">
    		Medium*: <select name="medium" id="medium">
    					<option value="0">Select medium</option>
    					<?php foreach($mediums['data'] as $medium){ ?>
    						<option value="<?php echo $medium['mid']; ?>"><?php echo $medium['name']; ?></option>
    					<?php } ?>
    				</select>
    		<div id="error_school_affiliation" style="display:none;"></div>
    		</div>
    		<div class="row">
    		school Logo*: <input id="school_logo" name="school_logo" type="file" required>
    		<div id="error_school_logo" style="display:none;"></div>
    		</div>
    		<div class="row">
    		website Url: <input id="school_url" name="school_url" type="text">
    		<div id="error_school_url" style="display:none;"></div>
    		</div>
    		<div class="row">
    		Contact no*: <input id="school_contact_no" name="school_contact_no" type="text">
    		<div id="error_school_contact_no" style="display:none;"></div>
    		</div>
    		<div class="row">
    		selcect state*:<select name="state" id="state">
    					<option value="0">Select state</option>
    				<?php foreach($states['data'] as $state) { ?>
    					<option value="<?php echo $state['id']; ?>"><?php echo $state['name']; ?></option>
    				<?php }?>
    			</select> 
    		</div>
    		<div class="row">
    		selcect city*:<select name="city" id="city">
    						<option value="0">select City</option>
    					</select> 
    		</div>
    		<div class="row">
    		Address*:<textarea row="5" id="address" name="address"></textarea> 
    		<input type="button" name="submit" id="submit" value="Submit">
    		</div>
    		
    	</form>
	</div>
	</div>
	
	<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
	<script>
    	$(document).on('keyup','#uname',function(){
        	var apiUrl = $('#apiUrl').val();
        	$.ajax({
                type: 'POST',
                url: apiUrl + 'auth/check_username',
                dataType: "json",
                data: {
                   'uname' : $('#uname').val()
                },
                beforeSend: function(){},
                complete: function(){},
                success:function (response) {
                	$('#uname').removeClass('error').addClass('success');
                },
                error: function() {
                    $('#uname').removeClass('success').addClass('error');
                 }
                
        	});
    	});

    	$(document).on('keyup','#email',function(){
        	var apiUrl = $('#apiUrl').val();
        	$.ajax({
                type: 'POST',
                url: apiUrl + 'auth/check_email',
                dataType: "json",
                data: {
                   'email' : $('#email').val()
                },
                beforeSend: function(){},
                complete: function(){},
                success:function (response) {
                	$('#email').removeClass('error').addClass('success');
                },
                error: function() {
                    $('#email').removeClass('success').addClass('error');
                 }
        	});
    	});


    	$(document).on('click','#submit',function(){
    		var apiUrl = $('#apiUrl').val();
    		var fd = new FormData();    
    		fd.append( 'school_name', $('#school_name').val());
    		fd.append( 'school_logo', school_logo.files[0]);
    		fd.append( 'school_url', $('#school_url').val());
    		fd.append( 'school_contact_no', $('#school_contact_no').val());
    		fd.append( 'state', $('#state').val());
    		fd.append( 'city', $('#city').val());
    		fd.append( 'address', $('#address').val());
    		fd.append( 'uname',$('#uname').val());
    		fd.append( 'email',$('#email').val());
    		fd.append( 'password',$('#password').val());
    		fd.append( 'school_affiliation',$('#school_affiliation').val());
    		fd.append( 'medium',$('#medium').val());
    		fd.append( 'f_name',$('#f_name').val());
    		fd.append( 'l_name',$('#l_name').val());
    		fd.append( 'u_contact',$('#u_contact').val());
    		
    		
    		promise1 = new Promise((resolve, reject) => {
    			$.ajax({
                    type: 'POST',
                    url: apiUrl + 'auth/registration',
                    dataType: "json",
                    data:fd,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){},
                    complete: function(){},
                    success:function (response) {
						console.log(response);
                    	resolve(response.output.school_id);
                    },
                    error: function() {
                    	reject('Vivartaa server NOT updated.');
                    }
            	});
    		})



    		promise1.then((message) => {
        		school(message);
    		}).catch((message) => {
        		console.log('catch:'+ message);
        	});
        });


    	function school(id){
    		var baseUrl = $('#baseUrl').val();
    		var fd = new FormData();    
    		fd.append( 'school_name', $('#school_name').val());
    		fd.append( 'school_logo', school_logo.files[0]);
    		fd.append( 'school_url', $('#school_url').val());
    		fd.append( 'school_contact_no', $('#school_contact_no').val());
    		fd.append( 'state', $('#state').val());
    		fd.append( 'city', $('#city').val());
    		fd.append( 'address', $('#address').val());
    		fd.append( 'uname',$('#uname').val());
    		fd.append( 'email',$('#email').val());
    		fd.append( 'password',$('#password').val());
    		fd.append( 'school_affiliation',$('#school_affiliation').val());
    		fd.append( 'medium',$('#medium').val());
    		fd.append( 'sch_id',id);
    		fd.append( 'f_name',$('#f_name').val());
    		fd.append( 'l_name',$('#l_name').val());
    		fd.append( 'u_contact',$('#u_contact').val());
    		
        	promise1 = new Promise((resolve, reject) => {
    			$.ajax({
                    type: 'POST',
                    url: baseUrl + 'School_ctrl/school_create',
                    dataType: "json",
                    data:fd,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){},
                    complete: function(){},
                    success:function (response) {
                    	resolve('School created successfully.');
                    },
                    error: function() {
                    	reject('Something went wrong.');
                    }
            	});
    		})

        	promise1.then((message) => {
        		alert(message);
        		window.location.replace(baseUrl+'auth/login');
    		}).catch((message) => {
        		alert(message);
        		console.log('catch:'+ message);
        	});
        }

    	$(document).on('change','#state',function(){
    		var apiUrl = $('#apiUrl').val();
    		var state = $(this).val();
        	$.ajax({
                type: 'GET',
                url: apiUrl + 'auth/get_cities/'+ state,
                dataType: "json",
                data: {},
                beforeSend: function(){},
                complete: function(){},
                success:function (response) {
                	var x = '<option value="0">select city</option>';
                	$.each(response.data,function(key,value){
                    	x = x + '<option value="'+ value.id +'">'+ value.name +'</option>';
                   	});	
                   	$('#city').html(x);
                },
                error: function() {
                    
                }
        	});
        });	
	</script>
</body>
</html>                            