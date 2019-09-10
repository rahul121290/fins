<div class="content-wrapper">
    <section class="content-header">
      <h1>Synchronize Fee Records </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/reception/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Data Synchronize</li>
      </ol>
    </section>
    <!-- Main content -->
	<section class="content">
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Click the button below to start Synchronization</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<div class="text-left box-body" style="margin-top:25px;margin-left:20px;border: 1px solid #bdb8b8;margin-bottom: 20px;width: 530px;padding:0px;">
			<button id="sync" class="btn btn-primary btn-lg" style="float:left;">Start Synchronization</button>
			<?php
			$this->db->select('DATE_FORMAT(MAX(sync_date),"%d-%M-%Y %H:%i") sync_date');
			$sync_date = $this->db->get_where('last_sync',array('status'=>1,'table_name'=>'master_data'))->result_array();
			?>
			<p style="float:left;font-size:16px;margin-top:10px;margin-left:16px;" id="last_sync_date"><?php if(count($sync_date) > 0) {?><b>Last Synchronize on <?php echo $sync_date[0]['sync_date'];?></b><?php }?></p>
			</div>
			<br>
		</div>
        </section>
	</div>
<script type="text/javascript">
var baseUrl = $('#base_url').val();
$(document).on('click','#sync',function(){
	$.ajax({
		type:'POST',
		url:baseUrl+'Data_sync_ctrl/data_sync',
		dataType:'json',
		beforeSend:function(){
			$('#loader').modal('show');
		},
		success:function(response){
			if(response.status == 200){
				alert(response.msg);
				location.reload();
			}else{
				$('#loader').modal('hide');
				alert(response.msg);
			}
		}
	});
});

</script>