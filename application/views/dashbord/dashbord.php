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
    
	<?php }else if($this->uri->segment(2) == 'reception'){
	    
	    $this->load->view('student_fee/reception_dashboard');
	    
	}else if($this->uri->segment(2) == 'payroll'){
	    
        $this->load->view('payroll/payroll_dashboard');
        
    }?>
    	 
    
    
    
    
    
    
    
    
  </div>