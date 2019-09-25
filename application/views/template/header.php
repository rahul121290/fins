<?php
$permission_link = $this->my_function->permission_link();
$permission = $this->my_function->user_permission();
?>
<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container-fluid">
      	<ul class="nav navbar-nav">
      	<?php if($this->session->userdata('school_id') == 1){ $school = 'shakuntala';?>
      	
      	<li style="margin-right:20px;"><img alt="" src="<?php echo base_url()?>assets/images/shakuntala/header-logo.png" height="50"></li>
      	<?php } else if($this->session->userdata('school_id') == 2){ $school = 'sharda';?>
      	<li style="margin-right:20px;"><img alt="" src="<?php echo base_url()?>assets/images/sharda/header-logo.png" height="50"></li>
		<?php }else{ $school = 'cg-board';?>
		<li style="margin-right:20px;"><img alt="" src="<?php echo base_url()?>assets/images/shakuntala/header-logo.png" height="50"></li>
		<?php }?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="active"><a href="<?=base_url().$school.'/'.$permission_link;?>/dashbord">HOME</a></li>
			<?php if(in_array(1, $permission) || in_array(2, $permission) || in_array(3, $permission) || in_array(4, $permission) || in_array("5", $permission) || in_array(6, $permission) || in_array(7, $permission) || in_array(8, $permission) || in_array(9, $permission) || in_array(10, $permission)){ ?>
				<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown"  href="#">MASTER RECORDS<span class="caret"></span></a>
						<ul class="dropdown-menu">
						<?php if(in_array(32, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/add-assessment-feedback"><i class="fa fa-calendar text-blue" aria-hidden="true"></i> Add Delinquents</a></li>
						<?php }?>
						
						<?php if(in_array(1, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/session-master"><i class="fa fa-calendar text-blue" aria-hidden="true"></i> Session Create</a></li>
						<?php }?>
						
						<?php if(in_array(2, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/school-master"><i class="fa fa-building-o text-blue" aria-hidden="true"></i> Add School</a></li>
						<?php } ?>
						
						<?php if(in_array(3, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/medium-master"><i class="fa fa-medium text-blue" aria-hidden="true"></i> Add Medium</a></li>
						<?php } ?>
						
						<?php if(in_array(4, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/class-master"><i class="fa fa-building text-blue" aria-hidden="true"></i> Add Class</a></li>
						<?php } ?>
						
						<?php if(in_array(5, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/subject-master"><i class="fa fa-address-book-o text-blue" aria-hidden="true"></i> Add Subject</a></li>
						<?php } ?>
						
						<?php if(in_array(6, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/subject-allocation"><i class="fa fa-circle-o text-blue" aria-hidden="true"></i> Subject Allocation</a></li>
						<?php }?>
							
						<?php if(in_array(7, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/add-student"><i class="fa fa-user-circle-o text-blue" aria-hidden="true"></i> Add Student</a></li>
						<?php }?>
						
						<?php if(in_array(8, $permission)){ ?>	
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/add-teacher"><i class="fa fa-users text-blue" aria-hidden="true"></i> Add Teacher</a></li>
						<?php } ?>
						
						<?php if(in_array(9, $permission)){ ?>	
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/subject-teacher"><i class="fa fa-user-plus text-blue" aria-hidden="true"></i>Assign Subject Teacher</a></li>
						<?php }?>
						
						<?php if(in_array(10, $permission)){ ?>	
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/define-user-role"><i class="fa fa-user text-blue" aria-hidden="true"></i> Define user Role</a></li>
						<?php } ?>
						</ul>
					</li>
					<?php } ?>
					
					<?php if(in_array(11, $permission) || in_array(12, $permission) || in_array(13, $permission)){ ?>
					<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">TRANSACTION RECORDS<span class="caret"></span></a>
						<ul class="dropdown-menu">
						<?php if(in_array(11, $permission)){ ?>	
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/transaction-record/attendance-entry"><i class="fa fa-address-book text-blue" aria-hidden="true"></i>Attendance Entry</a></li>
						<?php } ?>
						
						<?php if(in_array(12, $permission)){ ?>	
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/transaction-record/student-attendance"><i class="fa fa-address-book-o text-blue" aria-hidden="true"></i>Student Attendance</a></li>
						<?php } ?>
						
						<?php if(in_array(13, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/transaction-record/marks-entry"><i class="fa fa-calculator text-blue" aria-hidden="true"></i>Marks Entry</a></li>
						<?php } ?>
						</ul>
					</li>
					<?php } ?>
					
					<?php if(in_array(14, $permission) || in_array(15, $permission) || in_array(16, $permission) || in_array(17, $permission) || in_array(18, $permission)){ ?>
					<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">PRODUCTION REPORTS<span class="caret"></span></a>
						<ul class="dropdown-menu">
						<?php if(in_array(14, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/production-report/marks-entry-check"><i class="fa fa-check-square text-blue" aria-hidden="true"></i>Marks Entry Check</a></li>
						<?php } ?>
						<?php if(in_array(15, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/production-report/furd-report"><i class="fa fa-check-circle-o text-blue" aria-hidden="true"></i>Furd Report</a></li>	
						<?php } ?>
						<?php if(in_array(16, $permission)){ ?>						
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/production-report/teacher-abstract"><i class="fa fa-check-square-o text-blue" aria-hidden="true"></i>Teacher Abstract</a></li>
						<?php } ?>
						
						<?php if(in_array(17, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/production-report/generate-marksheet"><i class="fa fa-area-chart text-blue" aria-hidden="true"></i>Generate Marksheet</a></li>
						<?php } ?>
						
						<?php if(in_array(18, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/production-report/export-marksheet"><i class="fa fa-check-circle-o text-blue" aria-hidden="true"></i>Export Results Excel</a></li>
						<?php } ?>
						</ul>
					</li>
					<?php } ?>
					
					
					<?php if(in_array(19, $permission)){ ?>
					<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">REPORTS (Records)<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/student-records"><i class="fa fa-user-circle-o text-blue" aria-hidden="true"></i>Student Records</a></li>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/csv-update"><i class="fa fa-user-circle-o text-blue" aria-hidden="true"></i>CSV Update</a></li>
							<?php if(in_array(29, $permission)){ ?>
    								<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/sibling-details"><i class="fa fa-user text-blue" aria-hidden="true"></i>Sibling Details</a></li>
    							<?php }?>
    						<?php if(in_array(33, $permission)){ ?>
    								<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/student-feedback"><i class="fa fa-user text-blue" aria-hidden="true"></i>Add Student Delinquents</a></li>
    							<?php }?>	
    							<?php if(in_array(34, $permission)){ ?>
    								<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/delinquents-report"><i class="fa fa-user text-blue" aria-hidden="true"></i>Delinquents Report</a></li>
    							<?php }?>
    							<?php if(in_array(35, $permission)){ ?>
    								<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/academic-report"><i class="fa fa-user text-blue" aria-hidden="true"></i>Academic Report</a></li>
    							<?php }?>	
						</ul>
					</li>
					<?php } ?>
					
					<?php if(in_array(22, $permission) || in_array(23, $permission)){ ?>
					<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">HEALTH<span class="caret"></span></a>
						<ul class="dropdown-menu">
						<?php if(in_array(22, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/helth/general-information"><i class="fa fa-genderless text-blue" aria-hidden="true"></i>General Information</a></li>
						<?php } ?>
						<?php if(in_array(23, $permission)){ ?>
							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/helth/health-activity"><i class="fa fa-eye-slash text-blue" aria-hidden="true"></i>Health Activitiy</a></li>
						<?php } ?>
						</ul>
					</li>
					<?php } ?>
					
					<?php if(in_array(20, $permission) || in_array(21, $permission)){ ?>
    					<li class="dropdown">
    					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">UTILITIES & TOOLS<span class="caret"></span></a>
    						<ul class="dropdown-menu">
    						<?php if(in_array(20, $permission)){ ?>
    							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/utilities-and-tools/add-division"><i class="fa fa-percent text-blue" aria-hidden="true"></i>Division</a></li>
    						<?php } ?>
    						<?php if(in_array(21, $permission)){ ?>
    							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/utilities-and-tools/add-grade"><i class="fa fa-buysellads text-blue" aria-hidden="true"></i>Grade</a></li>
    						<?php } ?>
    						</ul>
    					</li>
					<?php } ?>
					<?php if(in_array(27, $permission)){ ?>
						<li class="dropdown">
    					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">FEE STRUCTURE<span class="caret"></span></a>
    						<ul class="dropdown-menu">
    							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/fee-structure/add-new"><i class="fa fa-inbox text-blue" aria-hidden="true"></i>Add/Update Fee Structure</a></li>
    						</ul>
    					</li>
					<?php } ?>
					<?php if(in_array(26, $permission)){ ?>
						<li class="dropdown">
    					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">PROSPECTUS<span class="caret"></span></a>
    						<ul class="dropdown-menu">
    							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/prospectus/selling"><i class="fa fa-book text-blue" aria-hidden="true"></i>Prospectus Selling</a></li>
    							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/prospectus/selling-list"><i class="fa fa-address-book-o text-blue" aria-hidden="true"></i>Selling List</a></li>
    						</ul>
    					</li>
					<?php } ?>
							
					<!-- ---------------------------------hostel fee -------------------- -->			
					<?php if(in_array(28, $permission)){ ?>
						<li class="dropdown">
    					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">HOSTEL FEE<span class="caret"></span></a>
    						<ul class="dropdown-menu">
    							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/hostel/add-hostel-details"><i class="fa fa-user text-blue" aria-hidden="true"></i>Add Hostel Student</a></li>
								<li><a href="<?=base_url().$school.'/'.$permission_link;?>/hostel/fee-payment"><i class="fa fa-user text-blue" aria-hidden="true"></i>Fee Payment</a></li>
								<li><a href="<?=base_url().$school.'/'.$permission_link;?>/hostel/student-report"><i class="fa fa-user text-blue" aria-hidden="true"></i>Student Report</a></li>
    							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/hostel/hostel-mis"><i class="fa fa-id-badge text-blue" aria-hidden="true"></i>Hostel MIS</a></li>
    						</ul>
    					</li>
					<?php } ?>		
					
					<?php if(in_array(25, $permission)){ ?>
						<li class="dropdown">
    					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">FEE<span class="caret"></span></a>
    						<ul class="dropdown-menu">
    							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/student-fee/new-admission"><i class="fa fa-user text-blue" aria-hidden="true"></i>New Admission</a></li>
								<li><a href="<?=base_url().$school.'/'.$permission_link;?>/student-fee/payment"><i class="fa fa-id-badge text-blue" aria-hidden="true"></i>Student Fee</a></li>
    							
    						</ul>
    					</li>
    					
    					<li class="dropdown">
    					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">REPORT<span class="caret"></span></a>
    						<ul class="dropdown-menu">
    							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/report/fee-mis"><i class="fa fa-id-badge text-blue" aria-hidden="true"></i>Fee MIS</a></li>
    							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/report/students-report"><i class="fa fa-id-badge text-blue" aria-hidden="true"></i>Students Report</a></li>
								<li><a href="<?=base_url().$school.'/'.$permission_link;?>/student-fee/update-records"><i class="fa fa-user text-blue" aria-hidden="true"></i>Update Students</a></li>
    							
    						</ul>
    					</li>
					<?php } ?>
					
					<?php if(in_array(31, $permission)){ ?>
						<li class="dropdown">
    					<a class="dropdown-toggle" data-toggle="dropdown"  href="#">Synchronization<span class="caret"></span></a>
    						<ul class="dropdown-menu">
    							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/sync-master-data"><i class="fa fa-user text-blue" aria-hidden="true"></i>Sync Master Data</a></li>
    							<li><a href="<?=base_url().$school.'/'.$permission_link;?>/master-record/upload-student-marks"><i class="fa fa-user text-blue" aria-hidden="true"></i>Upload Student Marks</a></li>
    						</ul>
    					</li>
					<?php } ?>
					<!-----------------------Salary-------------------------->
					<?php if(in_array(36, $permission)){ ?>
    					<li class="dropdown">
        				<a class="dropdown-toggle" data-toggle="dropdown"  href="#">PAYROLL MASTER<span class="caret"></span></a>
        				<ul class="dropdown-menu">
        					<!-- >li><a href="<?=base_url().$school.'/'.$permission_link;?>/payroll-master/payroll-master-entry"><i class="fa fa-id-badge text-blue" aria-hidden="true"></i>Payroll Master Entry</a></li -->
        					<li><a href="<?=base_url().$school.'/'.$permission_link;?>/payroll-master/employee-post-entry"><i class="fa fa-id-badge text-blue" aria-hidden="true"></i>Employee Post Entry</a></li>
        					<li><a href="<?=base_url().$school.'/'.$permission_link;?>/payroll-master/new-employee-payroll"><i class="fa fa-user text-blue" aria-hidden="true"></i>New Employee Payroll</a></li>
        					<li><a href="<?=base_url().$school.'/'.$permission_link;?>/payroll-master/employee-salary-records"><i class="fa fa-id-badge text-blue" aria-hidden="true"></i>Employee Salary Records </a></li>
        				</ul>
        			</li>
        			<li class="dropdown">
        				<a class="dropdown-toggle" data-toggle="dropdown"  href="#">SALARY<span class="caret"></span></a>
        				<ul class="dropdown-menu">
        					
        					<li><a href="<?=base_url().$school.'/'.$permission_link;?>/salary/employee-attendance"><i class="fa fa-id-badge text-blue" aria-hidden="true"></i>Employee Attendance</a></li>
        					<li><a href="<?=base_url().$school.'/'.$permission_link;?>/salary/employee-advance"><i class="fa fa-id-badge text-blue" aria-hidden="true"></i>Employee Advance</a></li>
        					<li><a href="<?=base_url().$school.'/'.$permission_link;?>/salary/employee-list"><i class="fa fa-id-badge text-blue" aria-hidden="true"></i>Salary Generation</a></li>
        					<li><a href="<?=base_url().$school.'/'.$permission_link;?>/salary/salary-history"><i class="fa fa-id-badge text-blue" aria-hidden="true"></i>Salary History</a></li>
        				</ul>
        			</li>
        			<li class="dropdown">
        				<a class="dropdown-toggle" data-toggle="dropdown"  href="#">REPORT<span class="caret"></span></a>
        				<ul class="dropdown-menu">
        					<li><a href="<?=base_url().$school.'/'.$permission_link;?>/report/salary-data-sheet"> <i class="fa fa-id-badge text-blue" aria-hidden="true"></i>Salary Data Sheet</a></li>
        				</ul>
        			</li>
					<?php } ?>
					<!------------------------salary------------------------>
					<?php if(in_array(24, $permission)){ ?>
						<li class="dropdown"><a href="<?php echo base_url();?>Backup_ctrl">BackUp</a></li>
					<?php } ?>
									
      	<?php $user = $this->ion_auth->user()->row();?>
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