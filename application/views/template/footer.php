  <!-- <footer class="main-footer">
   <div class="pull-right hidden-xs">
      <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; 2019-20 <a href="http://krimtel.com"> Krimtel Gensease Technologies Pvt. Ltd.</a>.</strong> All rights
    reserved.
  </footer>  -->
  <div class="control-sidebar-bg"></div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/dataTables.bootstrap.min.js"></script>

<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
    <div class="modal fade" id="loader" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document" style="width:70px;top:40%">
        <div class="modal-content" style="border-radius:10px;">
          <div class="modal-body">
    		<img style="width:40px;" alt="" src="<?php echo base_url(); ?>assets/images/loader.gif" />
          </div>
          
        </div>
      </div>
    </div>
</div>
</body>
</html>