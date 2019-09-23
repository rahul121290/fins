<div class="content-wrapper">
    <section class="content-header">
      <h1>Employee Advance<small>Entry</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="">Salary</li>
        <li class="active">Advance Entry</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    	<div class="row">
        <div class="col-md-5">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Employee Advance Entry</h3>
                </div>
            	<div class="box-body">
            	<form role="form" method="POST" class="form-horizontal" id="advance_form">
            		<input type="hidden" id="e_ad_id" value="">
            			<div class="form-group">
							<label class="control-label col-md-2">School</label>
							<div class="col-sm-9">
								<select name="month" id="month" class="form-control">
									<option value="">Select Month</option>
									<?php foreach($month as $months){?>
        								<option value="<?php echo $months['m_id'];?>" <?php if($months['m_id'] == (int)date('m')){echo "selected";}?>><?php echo $months['m_name'];?></option>	
        							<?php }?>
								</select>
								<div id="session_err" style="display:none; color:red;"></div>
							</div>
					    </div>
            			
            			<div class="form-group">
							<label class="control-label col-md-2">School</label>
							<div class="col-sm-9">
								<select name="school" id="school" class="form-control">
									<option value="">Select School</option>
        							<option value="1">Shakuntala Vidyalaya (CBSE)</option>
        							<option value="3">Shakuntala Vidyalaya (CG)</option>
        							<option value="2">Sharda Vidyalaya Risali</option>
        							<option value="4">Sharda Vidyalaya Vaishali Nagar</option>
								</select>
								<div id="session_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Employee</label>
							<div class="col-sm-9">
								<select name="employee" id="employee" class="form-control">
									<option value="">Select Employee</option>
								</select>
								<div id="employee_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Advance</label>
							<div class="col-sm-9">
								<input type="number" class="form-control" id="advance" placeholder="Advance Amount">
								<div id="teacher_err" style="display:none; color:red;"></div>
							</div>
					    </div>
            		
						<div class="box-footer">
                  			<div class="text-center">
                        		<button type="button" id="advance_submit" class="btn btn-info btn-space">Submit</button>
                    		</div>
                		</div>	
        			</form>
        		</div><!-- end box body -->
     			</div>
   			</div>
       		<div class="col-md-7">	
              	<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">Advance List</h3>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    						<thead>
            					<tr>
                    				<th>S.No.</th>
                    				<th>Employe Name</th>
                    				<th>Advance Date</th>
                    				<th>Advance Amount</th>
            					</tr>
        					</thead>
    						<tbody id="advance_list"></tbody>
    					</table>
              		</div>
                  	<div class="box-footer">
                	</div>
         		</div>
       		</div>
		</div>
	</section>	
</div>

<script type="text/javascript">
var baseUrl = $('#base_url').val();

advance_list();
function advance_list(){
	$.ajax({
		type:'POST',
		url:baseUrl+'payroll/Payroll_ctrl/advance_list',
		data:{},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var x='';
				$.each(response.data,function(key,value){
					x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'</td>'+
						'<td>'+value.emp_name+'</td>'+
						'<td>'+value.advance_date+'</td>'+
						'<td>'+value.advance_amount+'</td>'+
						'<td><button data-e_ad_id="'+value.e_ad_id+'" class="btn btn-success edit">Edit</button> '+
						'<button data-e_ad_id="'+value.e_ad_id+'" class="btn btn-danger delete">Delete</button></td>'+
					'</tr>';
					$('#advance_list').html(x);
				});
			}
		},
	});
}

$(document).on('click','.delete',function(){
	var delete_id = $(this).data('e_ad_id');
	if(confirm('Are you sure!')){
		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/delete_advance',
			data:{'delete_id':delete_id},
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
	var edit_id = $(this).data('e_ad_id');
	$.ajax({
		type:'POST',
		url:baseUrl+'payroll/Payroll_ctrl/advance_id_list',
		data:{'edit_id':edit_id},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				$('#e_ad_id').val(response.data[0]['e_ad_id']);
				$('#school').val(response.data[0]['sch_id']);
				$('#month').val(response.data[0]['month']);
				var x='<option value="">Select Employee</option>';
				$.each(response.employee,function(k,v){	
					if(parseInt(response.data[0]['emp_id']) == parseInt(v.emp_id)){
						var selected = 'selected';
					}else{
						var selected = '';
					}
					x=x+'<option value="'+v.emp_id+'" '+selected+'>'+v.emp_name+'('+v.emp_generated_id+') </option>';
				});
				$('#employee').html(x);
				$('#advance').val(response.data[0]['advance_amount']);
			}
		},
	});
});


//---------------****-----------------------
$('#advance_form').validate({
	rules:{
		school:{required:true},
		teacher:{required:true},
		advance:{required:true}
	},
});

$(document).on('click','#advance_submit',function(){
	var formvalidate = $('#advance_form').valid();
	if(formvalidate){
		var e_ad_id = $('#e_ad_id').val();
		var month = $('#month').val();
		var school = $('#school').val();
		var employee = $('#employee').val();
		var advance = $('#advance').val();

		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/advance_submit',
			data:{'e_ad_id':e_ad_id,'month':month,'school':school,'employee':employee,'advance':advance},
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

$(document).on('change','#school',function(){
	var sch_id = $(this).val();
	if(sch_id == ''){
		$('#school_err').html('This is Required.').css('display','block');
	}else{
		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/school_employee_list',
			data:{'sch_id':sch_id},
			dataType:'json',
			beforeSend:function(){$('#loader').modal('show');},
			success:function(response){
				if(response.status == 200){
					$('#loader').modal('hide');
					var x='<option value="">Select Employee</option>';
					$.each(response.data,function(key,value){
						x=x+'<option value="'+value.emp_id+'">'+value.emp_name+' ('+value.emp_generated_id+')</option>';
					});
					$('#employee').html(x);
				}else{
					alert(response.msg);
				}
			},
		});
	}
});
</script>