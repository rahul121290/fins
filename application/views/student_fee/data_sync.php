<div class="content-wrapper">
    <section class="content-header">
      <h1>Data Synchronization</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Data Synchronization</li>
      </ol>
    </section>
    <!-- Main content -->
	<section class="content">
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Synchronization your <b>Fee Data Online to Offline</b> and <b>Offline to Online</b></h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<div class="text-center " style="margin-top:25px;padding-bottom:25px;">
			<button id="sync" class="btn btn-primary btn-lg">Synchronization Fee Data</button>
			</div>
		</div>
        </section>
	</div>
<script type="text/javascript">
var baseUrl = $('#base_url').val();
$(document).on('click','#sync',function(){
	$.ajax({
		type:'POST',
		url:baseUrl+'Data_sync_ctrl/sync_fee_details',
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



