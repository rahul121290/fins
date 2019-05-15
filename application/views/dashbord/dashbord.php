<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Dashbord </h1>
    </section>
    
    <div class="text-center" style="opacity: 0.5;margin-top: 110px;">
    <?php if($this->session->userdata('school_id') == 1){?>
    	<img alt="shakuntala" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" width="200">
    <?php }else{?>
    <img alt="shakuntala" src="<?php echo base_url()?>assets/images/sharda/sharda_logo.png" width="200">
    <?php }?>
    </div>
    
  </div>