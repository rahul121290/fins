<?php
$permission_link = $this->my_function->permission_link();
$permission = $this->my_function->user_permission();
?>

<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container-fluid">
      	<ul class="nav navbar-nav">
      	<?php if($this->session->userdata('school_id') == 1){ $school = 'shakuntala';?>
      	
      	<li><img alt="" src="<?php echo base_url()?>assets/images/shakuntala/header-logo.png" height="50"></li>
      	<?php } else{ $school = 'sharda';?>
      	<li><img alt="" src="<?php echo base_url()?>assets/images/sharda/header-logo.png" height="50"></li>
      	<?php } ?>
			<li class="active"><a href="<?=base_url().$school.'/'.$permission_link;?>/dashbord">DASHBORD</a></li>
				<li class="dropdown">
				<?php if($permission_link == 'admin' || $permission_link == 'class-teacher'){ ?>
				<a class="dropdown-toggle" data-toggle="dropdown"  href="#">MASTER RECORDS<span class="caret"></span></a>
				<?php } ?>
						<ul class="dropdown-menu">
						<?php if($permission_link == 'admin'){ ?>
						<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/session-master"><i class="fa fa-calendar text-blue" aria-hidden="true"></i> Session Create</a></li>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/school-master"><i class="fa fa-building-o text-blue" aria-hidden="true"></i> Add School</a></li>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/medium-master"><i class="fa fa-medium text-blue" aria-hidden="true"></i> Add Medium</a></li>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/class-master"><i class="fa fa-building text-blue" aria-hidden="true"></i> Add Class</a></li>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/subject-master"><i class="fa fa-address-book-o text-blue" aria-hidden="true"></i> Add Subject</a></li>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/subject-allocation"><i class="fa fa-circle-o text-blue" aria-hidden="true"></i> Subject Allocation</a></li>
						<?php }?>
							
						<?php if(in_array("2", $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/add-student"><i class="fa fa-user-circle-o text-blue" aria-hidden="true"></i> Add Student</a></li>
						<?php }?>
						
						<?php if($permission_link == 'admin'){ ?>	
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/add-teacher"><i class="fa fa-users text-blue" aria-hidden="true"></i> Add Teacher</a></li>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/subject-teacher"><i class="fa fa-user-plus text-blue" aria-hidden="true"></i>Assign Subject Teacher</a></li>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/define-user-role"><i class="fa fa-user text-blue" aria-hidden="true"></i> Define user Role</a></li>
						<?php }?>
						</ul>
					</li>
					
					<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">TRANSACTION RECORDS<span class="caret"></span></a>
						<ul class="dropdown-menu">
						<?php if($permission_link == 'admin' || $permission_link == 'class-teacher'){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/transaction-record/attendance-entry"><i class="fa fa-address-book text-blue" aria-hidden="true"></i>Attendance Entey</a></li>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/transaction-record/student-attendance"><i class="fa fa-address-book-o text-blue" aria-hidden="true"></i>Student Attendance</a></li>
						<?php } ?>
							
						<?php if($permission_link == 'admin' || $permission_link == 'class-teacher' || $permission_link == 'teacher'){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/transaction-record/daily-attendance"><i class="fa fa-calculator text-blue" aria-hidden="true"></i>Daily Attendance</a></li>
						
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/transaction-record/marks-entry"><i class="fa fa-calculator text-blue" aria-hidden="true"></i>Marks Entry</a></li>
						<?php } ?>
						</ul>
					</li>
					<?php if($permission_link == 'admin' || $permission_link == 'class-teacher'){ ?>
					<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">PRODUCTION REPORTS<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/production-report/marks-entry-check"><i class="fa fa-check-square text-blue" aria-hidden="true"></i>Marks Entey Check</a></li>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/production-report/furd-report"><i class="fa fa-check-circle-o text-blue" aria-hidden="true"></i>Furd Report</a></li>	
						
						<?php if($permission_link == 'admin'){ ?>							
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/production-report/teacher-abstract"><i class="fa fa-check-square-o text-blue" aria-hidden="true"></i>Teacher Abstract</a></li>
						<?php } ?>
						
						<?php if($permission_link == 'admin' || $permission_link == 'class-teacher'){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/production-report/generate-marksheet"><i class="fa fa-area-chart text-blue" aria-hidden="true"></i>Generate Marksheet</a></li>
						<?php } ?>
						
						<?php if($permission_link == 'admin' || $permission_link == 'class-teacher' || $permission_link == 'teacher'){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/production-report/export-marksheet"><i class="fa fa-check-circle-o text-blue" aria-hidden="true"></i>Export Results Excel</a></li>
						<?php } ?>
						</ul>
					</li>
					<?php } ?>
					
					<?php if($permission_link == 'admin'){ ?>
					<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">REPORTS (Records)<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/student-records"><i class="fa fa-user-circle-o text-blue" aria-hidden="true"></i>Student Reocrds</a></li>
						</ul>
					</li>
					<?php } ?>
					
					<?php if(in_array("3", $permission)){ ?>
					<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">Health<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/helth/general-information"><i class="fa fa-genderless text-blue" aria-hidden="true"></i>General Information</a></li>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/helth/health-activity"><i class="fa fa-eye-slash text-blue" aria-hidden="true"></i>Health Activitiy</a></li>
						</ul>
					</li>
					<?php } ?>
					
					<?php if($permission_link == 'admin'){ ?>
					<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">UTILITIES & TOOLS<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/utilities-and-tools/add-division"><i class="fa fa-percent text-blue" aria-hidden="true"></i>Division</a></li>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/utilities-and-tools/add-grade"><i class="fa fa-buysellads text-blue" aria-hidden="true"></i>Grade</a></li>
						</ul>
					</li>
					<li class="dropdown"><a href="<?php echo base_url();?>Backup_ctrl">BackUp</a></li>
					<?php } ?>
					
					<?php /*?>
					<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">FEES PAYMENT<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?=base_url();?>admin/fees-payment/pay-student-fees"><i class="fa fa-telegram text-blue" aria-hidden="true"></i>Pay Students Fees</a></li>
							<li><a href="<?=base_url();?>admin/fees-payment/generate-fees-csv"><i class="fa fa-snowflake-o text-blue" aria-hidden="true"></i>Generate Fees CSV</a></li>
						</ul>
					</li> <?php */?>
				</ul>
      
      	<?php $user = $this->ion_auth->user()->row();?>
        <ul class="nav navbar-nav navbar-right"> 
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url();?>assets/images/user.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $user->username; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url();?>assets/images/user.png" class="img-circle" alt="User Image">
                <p>
                  <?php echo $user->username; ?>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url().$school.'/'.$permission_link;?>/profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url();?>Auth/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>