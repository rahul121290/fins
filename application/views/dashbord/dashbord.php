<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Dashbord </h1>
    </section>
    
     <?php if($this->ion_auth->is_admin()){?>
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
    <?php }else{ ?>
    <div class="text-center" style="opacity: 0.5;margin-top: 110px;">
    <?php if($this->session->userdata('school_id') == 1){?>
    	<img alt="shakuntala" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" width="200">
    <?php }else{?>
    <img alt="shakuntala" src="<?php echo base_url()?>assets/images/sharda/sharda_logo.png" width="200">
    <?php }?>
    </div>
    <?php }?>
  </div>