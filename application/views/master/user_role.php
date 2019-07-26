<div class="content-wrapper">
    <section class="content-header">
      <h1>Define User Role</h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="">master-record</li>
        <li class="active">define-user-role</li>
      </ol>
    </section>
    <script src="<?php echo base_url();?>assets/js/custom/user_role.js"></script>
    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Add Teacher & Class Teacher</h3>
                </div>
                
            	<div class="box-body">
            	<form method="POST" class="form-horizontal" id="user_role_form" role="form">
            			<input type="hidden" name="id" id="id">
            			<input type="hidden" name="ug_id" id="ug_id">
					   
					    <div class="form-group">
					    	<label class="control-label col-md-2">Slelect Teacher</label>
							<div class="col-sm-8">
									<select id="teacher" name="teacher" class="form-control">
										<option value="">Select Teacher</option>
										<?php foreach($teachers as $teacher){ ?>
										<option value="<?php echo $teacher['t_id'];?>"><?php echo $teacher['teacher_name'];?></option>
										<?php } ?>
									</select> 
							</div>
					    </div>
					    
					    <div class="form-group">
					    	<label class="control-label col-md-2">Select Group</label>
							<div class="col-sm-8">
									<select id="group" name="group" class="form-control">
										<option value="">Select Group</option>
										<?php foreach($groups as $group){?>
										<option value="<?php echo $group['id'];?>"><?php echo $group['name'];?></option>
										<?php } ?>
									</select> 
							</div>
					    </div>
					    
					    <div class="form-group">
					    	<label class="control-label col-md-2">Email</label>
							<div class="col-sm-8">
								<input type="text" name="email" id="email" class="form-control" placeholder="Email" disabled>
							</div>
					    </div>
					    
					     <div class="form-group">
					    	<label class="control-label col-md-2">Username</label>
							<div class="col-sm-8">
								<input type="text" name="username" id="username" class="form-control" placeholder="Username">
								<label id="username_err" class="error" style="display: none;"></label>
							</div>
					    </div>
					     
					     <div class="form-group">
					    	<label class="control-label col-md-2">Password</label>
							<div class="col-sm-8">
								<input type="password" name="password" id="password" class="form-control" placeholder="Password">
							</div>
					    </div>
					    
					    <div class="form-group">
					    	<label class="control-label col-md-2">Confirm Password</label>
							<div class="col-sm-8">
								<input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
							</div>
					    </div>
					    
					    <div class="form-group">
					    	<H4>MASTER RECORDS</H4>
					    	<?php foreach($permission as $prmis){ 
					    	    if($prmis['category_name'] == 'MASTER RECORDS'){?>
							<div class="col-sm-2">
								<input type="checkbox" name="permission[]" value="<?php echo $prmis['pid'];?>"><?php echo $prmis['p_name'];?>
							</div>
							<?php } } ?>
						</div>
						<div class="form-group">
							<H4>PRODUCTION REPORTS</H4>
					    	<?php foreach($permission as $prmis){ 
					    	    if($prmis['category_name'] == 'PRODUCTION REPORTS'){?>
							<div class="col-sm-2">
								<input type="checkbox" name="permission[]" value="<?php echo $prmis['pid'];?>"><?php echo $prmis['p_name'];?>
							</div>
							<?php } } ?>
						</div>
						
						<div class="form-group">
							<H4>TRANSACTION RECORDS</H4>
					    	<?php foreach($permission as $prmis){ 
					    	    if($prmis['category_name'] == 'TRANSACTION RECORDS'){?>
							<div class="col-sm-2">
								<input type="checkbox" name="permission[]" value="<?php echo $prmis['pid'];?>"><?php echo $prmis['p_name'];?>
							</div>
							<?php } } ?>
						</div>
						
						<div class="form-group">
							<H4>REPORTS</H4>
					    	<?php foreach($permission as $prmis){ 
					    	    if($prmis['category_name'] == 'REPORTS'){?>
							<div class="col-sm-2">
								<input type="checkbox" name="permission[]" value="<?php echo $prmis['pid'];?>"><?php echo $prmis['p_name'];?>
							</div>
							<?php } } ?>
						</div>	
						<div class="form-group">
							<H4>UTILITIES & TOOLS</H4>
					    	<?php foreach($permission as $prmis){ 
					    	    if($prmis['category_name'] == 'UTILITIES & TOOLS'){?>
							<div class="col-sm-2">
								<input type="checkbox" name="permission[]" value="<?php echo $prmis['pid'];?>"><?php echo $prmis['p_name'];?>
							</div>
							<?php } } ?>
						</div>
						<div class="form-group">	
							<H4>HEALTH</H4>
					    	<?php foreach($permission as $prmis){ 
					    	    if($prmis['category_name'] == 'HEALTH'){?>
							<div class="col-sm-2">
								<input type="checkbox" name="permission[]" value="<?php echo $prmis['pid'];?>"><?php echo $prmis['p_name'];?>
							</div>
							<?php } } ?>
					    </div>
					    
    		  			<div class="box-footer">
                          	<div class="col-sm-offset-8">
                          		<button type="button" id="submit_user_role" class="btn btn-info hide user_update">Update</button>
                                <button type="button" id="submit_user_role" class="btn btn-info user_submit">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
            			</div>
            			</form>
        			</div><!-- end box body -->
     			</div>
   			</div>
   			
          	<div class="col-md-6">	
          		<div class="box box-danger">
                	<div class="box-header">
                  		<h3 class="box-title">List of Teachers</h3>
                	</div>
                	<table id="example1" class="table table-bordered table-striped">
                		<thead>
                			<tr>
                				<th>Sr No.</th>
                				<th>User Name</th>
                				<th>Email</th>
                				<th>Password</th>
                				<th>Action</th>
                			</tr>
                			</thead>
                			<tbody>
                			<?php $i = 1; 
                			foreach($user_list as $ul){?>
                			<tr>
                				<td><?php echo $i++ ?></td>
                				<td><?php echo $ul['username'];?></td>
                				<td><?php echo $ul['email'];?></td>
                				<td><input type="password" value="<?php echo $ul['pass_hint']?>" id="<?php echo "pass_".$i;?>"> <input data-id="<?php echo "pass_".$i;?>" type="checkbox" class="show_check"></td>
                				<td><button type="button" id="<?php echo $ul['id']?>" class="btn btn-primary btn-sm edit"><span class="glyphicon glyphicon-edit"></span> Edit </button> &nbsp;
		    					    <button type="button" id="<?php echo $ul['id']?>" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span> Delete </button></td>
                			</tr>
                			<?php } ?>
                			</tbody>
                	</table>
              		</div>   
     			</div>
   			</div>
	</section>	
</div>