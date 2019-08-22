<div class="content-wrapper">
    <section class="content-header">
      <h1>Fee Details<small>Sync</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">data sync</li>
      </ol>
    </section>
    <!-- Main content -->
	<section class="content">
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Sync your fee data online to offline and offline to online</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<button id="sync" class="btn btn-primary">Sync</button>
			
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



