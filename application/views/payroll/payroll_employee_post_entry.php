<div class="content-wrapper">
<section class="content-header" style="margin-bottom:10px;">
      <h1>Employee Post Entry</h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/payroll/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Employee Post Entry</li>
      </ol>
    </section>

<!-- main section -->
<div class="col-md-6">	
  	<div class="box box-danger no-print">
        <div class="box-header">
          <h3 class="box-title">Add New Post</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<form id="hostel_mis_form" action="javascript:void(0);" method="POST" role="form">
    	
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    		<input type="hidden" id="p_id" value="">
    	
      			<div class="form-group" style="margin-bottom:0px;">
      				<div class="form-group">
						<label class="col-sm-3 control-label">Post:</label>
						<div class="col-sm-8">
							<input type="text" name="post" id="post" class="form-control only_text" placeholder="Type Post">
							<div id="post_err" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"></label>
						<div class="col-sm-8">
							<button type="button" id="submit" class="btn btn-info pull-right submit">Submit</button>
							<button type="button" id="submit" class="btn btn-info pull-right update" style="display:none;">Update</button>	
						</div>
					</div>
			    </div>
    		</form>	
		</div><!-- end box body -->
		</div>
</div>
<div class="col-md-6">			
		<div class="box box-info">
            <div class="box-header no-print">
              <h3 class="box-title"><b>Employee Post List</b></h3>
            </div>
      		<div class="box-body p-table-bg-head p-table-body table-responsive">
				<table class="table">
					<thead><tr>
					<th>S.No.</th>
					<th>Post</th>
					<th>Action</th>
					</tr>
					</thead>
					<tbody id="post_lists"></tbody>
				</table>
      		</div>
 		</div>
		
	</div>
</div>
<script type="text/javascript">
var baseUrl = $('#base_url').val();

post_list();
function post_list(){
	$.ajax({
		type:'GET',
		url:baseUrl+'payroll/Payroll_ctrl/post_list',
		data:{},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var x='';
				$.each(response.data,function(key,value){
					x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'</td>'+
						'<td>'+value.name+'</td>'+
						'<td><button data-post_name="'+value.name+'" data-post_id="'+value.ep_id+'" class="btn btn-success edit">Edit</button> '+
						'<button data-post_id="'+value.ep_id+'" class="btn btn-danger delete">Delete</button></td>'+
					'</tr>';
				});
				$('#post_lists').html(x);
			}else{
				$('#post_lists').html('<tr><td colspan="3" class="text-center">Record not found.</td></tr>');
			}
		},
	});
}

$(document).on('click','.edit',function(){
	var post_id = $(this).data('post_id');
	var post_name = $(this).data('post_name');
	$('#p_id').val(post_id);
	$('#post').val(post_name);

	$('.submit').css('display','none');
	$('.update').css('display','block');
});


$(document).on('click','.delete',function(){
	var p_id = $(this).data('post_id');
	if(confirm('Are you sure!')){
		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/post_delete',
			data:{'p_id':p_id},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					location.reload();	
				}else{
					alert(response.msg);
				}
			},
		});
	}
});


$(document).on('click','#submit',function(){
	var post = $('#post').val();
	var p_id = $('#p_id').val();
	var formvalid = true;
	if(post == ''){
		$('#post_err').html('This is Required.').css('display','block');
		formvalid = false;
	}else{
		$('#post_err').css('display','none');
	}
	if(formvalid){
		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/post_submit',
			data:{'p_id':p_id,'post':post},
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
</script>