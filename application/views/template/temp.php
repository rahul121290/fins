<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $page_name ;?> | <?php echo $site_title ;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/all.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/AdminLTE.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/marksheet-result.css">
  
  <!-- Google Font -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/google_font.css">
  
  <!-- jQuery -->
  <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
  <script src="<?=base_url();?>assets/js/jquery-ui.js"></script>  
  <script src="<?=base_url();?>assets/js/jquery.validate.js"></script>  	
  <script src="<?=base_url();?>assets/js/additional-methods.js"></script> 
  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php $this->load->view('template/header');?>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
<?php $this->load->view($main);?> 
<?php $this->load->view('template/footer');?>
