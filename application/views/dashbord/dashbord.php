<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
     <?php if($this->ion_auth->is_admin()){?>
	 <section class="content-header">
      <h1> Dashboard </h1>
    </section>
    <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php print_r($students[0]['students']);?></h3>
              <p>Students</p>
            </div>
            <div class="icon">
              <i class="icon icon ion-happy-outline"></i>
            </div>
          </div>
        </div>
        
         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php print_r($teachers[0]['teachers']);?></h3>
              <p>Teachers</p>
            </div>
            <div class="icon">
              <i class="icon ion-person-stalker"></i>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php print_r($users[0]['users']);?></h3>
              <p>Users</p>
            </div>
            <div class="icon">
              <i class="icon ion-person-add"></i>
            </div>
          </div>
        </div>
    
    	<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php print_r($subjects[0]['subjects']);?></h3>
              <p>Scholistic Subjects</p>
            </div>
            <div class="icon">
              <i class="icon ion-ios-book"></i>
            </div>
          </div>
        </div>
		
    <?php }else if(($this->uri->segment(2) == 'class-teacher') || ($this->uri->segment(2) == 'teacher')){ ?>
	
	<div class="text-center" style="opacity: 0.5;margin-top: 110px;display:none;">
    <?php if($this->session->userdata('school_id') == 1){?>
    	<img alt="shakuntala" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" width="200">
    <?php }else{?>
    <img alt="shakuntala" src="<?php echo base_url()?>assets/images/sharda/sharda_logo.png" width="200">
    <?php }?>
    </div>
	
	<?php }else if($this->uri->segment(2) == 'reception'){?>
	
	<div class="container">
		<div class="col-md-12" style="background-color:#fff;padding:20px 0px;margin-top:30px;">
		<section class="content-header">
      <h1> Dashboard </h1>
    </section>
	<hr>
		
		<div class="col-md-2 text-center"><a title="Add Students" href="<?php echo base_url().$this->uri->segment(1);?>/reception/student-fee/new-admission"><img style="width:70px;" src="<?php echo base_url()?>assets/images/reception/student-add.png"><br> <h4 style="font-weight:600;color:#524d4d;font-size:16px;">New Admission</h4></a></div>
		
		<div class="col-md-2 text-center"><a title="Student Fee" href="<?php echo base_url().$this->uri->segment(1);?>/reception/student-fee/payment"><img style="width:70px;" src="<?php echo base_url()?>assets/images/reception/student-fee.png"><br><h4 style="font-weight:600;color:#524d4d;font-size:16px;">Student Fee</h4></a></div>
		
		<div class="col-md-2 text-center"><a title="Fee History" href="<?php echo base_url().$this->uri->segment(1);?>/reception/report/fee-mis"><img style="width:70px;" src="<?php echo base_url()?>assets/images/reception/fee-history.png"><br><h4 style="font-weight:600;color:#524d4d;font-size:16px;">Fee MIS</h4></a></div>
		
		<div class="col-md-2 text-center"><a title="Fee History" href="<?php echo base_url().$this->uri->segment(1);?>/reception/fee-structure/online-fee"><img style="width:70px;" src="<?php echo base_url()?>assets/images/reception/fee-history.png"><br><h4 style="font-weight:600;color:#524d4d;font-size:16px;">Generate Online Month fee</h4></a></div>
		
		<div class="col-md-2 text-center"><a title="Fee History" href="<?php echo base_url().$this->uri->segment(1);?>/reception/fee-structure/data-sync"><img style="width:70px;" src="<?php echo base_url()?>assets/images/reception/fee-history.png"><br><h4 style="font-weight:600;color:#524d4d;font-size:16px;">	Data Synchronization</h4></a></div>
		
		<div class="col-md-2 text-center"><a title="Fee History" href="<?php echo base_url().$this->uri->segment(1);?>/reception/students/recycle-bin"><img style="width:70px;" src="<?php echo base_url()?>assets/images/reception/fee-history.png"><br><h4 style="font-weight:600;color:#524d4d;font-size:16px;">	Recycle Bin</h4></a></div>
		<div class="col-md-2"></div>
		</div>
	</div>
    <?php } ?>
  </div>