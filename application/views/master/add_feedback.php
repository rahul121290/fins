<div class="content-wrapper">
    <section class="content-header">
      <h1>Student<small>Delinquents</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Add Delinquents</li>
      </ol>
    </section>
    <!-- Main content -->
    
    <section class="content">
    <div class="row">
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Add New Delinquents</h3>
                </div>
            	<div class="box-body">
            		<form role="form" class="form-horizontal" id="feedback_form" method="POST">
            		
            		<input type="hidden" id="af_id" value="">
            		
            			<div class="box-body">
                           <div class="form-group">
                        	<label class="col-sm-3 control-label">Medium</label>
                        	<div class="col-sm-6">
                        		<select class="form-control" name="medium" id="medium">
                        			<option value="">Select Medium</option>
                        			<option value="1">English</option>
                        			<option value="2">Hindi</option>
                        		</select>
                        		<div id="medium_err" class="text-danger" style="display:none;"></div>
                        		</div>
                        	</div>
                        	
                        	<div class="form-group">
                        	<label class="col-sm-3 control-label">Feedback</label>
                        	<div class="col-sm-6">
                        		<textarea rows="" cols="" id="feedback" name="feedback" placeholder="Write Delinquents" class="form-control"></textarea>
                        		<div id="feedback_err" class="text-danger" style="display:none;"></div>
                        	</div>
                        	</div>
                        </div>
                        
            			<div class="box-footer">
                          	<div class="text-center ">
                                <button type="button" id="submit" class="btn btn-info btn-space">Submit</button>
                            </div>
            			</div>
        			</form>
        			</div><!-- end box body -->
     			</div>
   			</div>
   			
          	<div class="col-md-6">	
          		<div class="box box-info">
                	<div class="box-header">
                  		<h3 class="box-title">List of Feedback</h3>
                	</div>
					<div class="box-body">
                	
                	<table id="example1" class="table table-bordered table-striped">
                		<thead>
                			<tr>
                				<th>Sr No.</th>
                				<th>Medium</th>
                				<th>Delinquents</th>
                				<th>Action</th>
                			</tr>
                			</thead>
                			<tbody>
                    				<?php $i = 1;
                    				foreach($feedback_list as $f_list){?>
                    				<tr>
                    				<td><?php echo $i++;?></td>
                    				<td><?php echo $f_list['med_name'];?></td>
                    				<td><?php echo $f_list['feedback'];?></td>
                    				<td><button type="button" data-feedback="<?php echo $f_list['feedback'];?>" data-med_id="<?php echo $f_list['med_id'];?>"  id="<?php echo $f_list['af_id']?>" class="btn btn-primary btn-sm edit"><span class="glyphicon glyphicon-edit"></span> Edit </button> &nbsp;
		    					        <button type="button" id="<?php echo $f_list['af_id']?>" class="btn btn-danger btn-sm delete"><span class="glyphicon glyphicon-trash"></span> Delete </button></td>
                    				</tr>
                    				<?php }?>
                			</tbody>
                	</table>
					</div>
              		</div>   
     			</div>
   			</div>
	</section>	
</div>
<script type="text/javascript">
var baseUrl = $('#base_url').val();

$('#feedback_form').validate({
	rules:{
		medium:{required:true},
		feedback:{required:true}
	},
});

$(document).on('click','#submit',function(){
	var formvalidate = $('#feedback_form').valid();
	var medium = $('#medium').val();
	var feedback = $('#feedback').val();
	var af_id = $('#af_id').val();
	if(formvalidate){
		$.ajax({
			type:'POST',
			url:baseUrl+'Student_ctrl/add_feedback',
			data:{'medium':medium,'feedback':feedback,'af_id':af_id},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					alert(response.msg);
					location.reload();
				}else{
					alert(response.msg);
				}
			},
		});
	}
});

$(document).on('click','.edit',function(){
	$('#loader').modal('show');
	$('#af_id').val($(this).attr('id'));
	$('#medium').val($(this).data('med_id'));
	$('#feedback').val($(this).data('feedback'));
	$("#submit").html('Update');
	$('#loader').modal('hide');
});


</script>


