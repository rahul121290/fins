<div class="content-wrapper">
<section class="content-header" style="margin-bottom:10px;">
      <h1>Salary Generation</h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Salary Generation</li>
      </ol>
    </section>

<!-- main section -->
<div class="col-md-12">	
  	<div class="box box-danger no-print">
        <div class="box-header">
          <h3 class="box-title">Select filters</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<form id="search_employee_form" action="javascript:void(0);" method="POST" role="form">
    	
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    	
      			<div class="form-group" style="margin-bottom:0px;">
      				<div class="col-sm-2 mb-3">
						<select name="school" id="school" class="form-control">
							<option value="">Select School</option>
							<option value="1" selected>Shakuntala Vidyalaya (CBSE) Records</option>
							<option value="3">Shakuntala Vidyalaya (CG) Records</option>
							<option value="2">Sharda Vidyalaya Risali</option>
							<option value="4">Sharda Vidyalaya Vaishali Nagar</option>
						</select>
						<div id="school_err" style="display:none; color:red;"></div>
					</div>
									
					<div class="col-sm-2 mb-3">
						<select class="form-control" name="emp_type" id="emp_type">
							<option value="">Select Employee Type</option>
							<option value="1">Permanent</option>
							<option value="2">Adhoc</option>
						</select>
						<div id="emp_type_err" style="display:none; color:red;"></div>
					</div>	
					
					<div class="col-sm-2 mb-3">
						<select class="form-control" name="emp_sub_type" id="emp_sub_type">
							<option value="">Select Employee Type</option>
						</select>
						<div id="emp_sub_type_err" style="display:none; color:red;"></div>
					</div>	
					
					<div class="col-md-4 mb-3">
					<button type="button" id="search" class="btn btn-info pull-left">Search</button>	
					</div>
			    </div>
    		</form>	
		</div><!-- end box body -->
		</div>	
		<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title"><b>Generated Teacher Salary List</b></h3>
			  <hr></hr>
            </div>
      		<div class="box-body">				
				<table class="table">
					<thead><tr>
					<th>Sr. No.</th>
					<th>Employee Name</th>
					<th>Employee ID</th>
					<th>Post</th>
					<th>Action</th>
					</tr>
					</thead>
					<tbody id="employee_details"></tbody>
				</table>	
			</div>
 		</div>
	</div>
</div>
<script type="text/javascript">
var baseUrl = $('#base_url').val();
var userUrl = $('#user_url').val();

$('#search_employee_form').validate({
	rules:{
		school:{required:true},
		emp_type:{required:true},
		emp_sub_type:{required:true}
	},
});

$(document).on('click','#search',function(){
	var formvalid = $('#search_employee_form').valid();
	if(formvalid){
		var school = $('#school').val();
		var emp_type = $('#emp_type').val();
		var emp_sub_type = $('#emp_sub_type').val();

		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/salary_employee_list',
			data:{'sch_id':school,'emp_type':emp_type,'emp_sub_type':emp_sub_type},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					var x='';
					$.each(response.data,function(key,value){
						x=x+'<tr>'+
							'<td>'+parseInt(key+1)+'</td>'+
							'<td>'+value.emp_name+'</td>'+
							'<td>'+value.emp_generated_id+'</td>'+
							'<td>'+value.post_name+'</td>'+
							'<td><button data-emp_id="'+value.emp_id+'" class="btn btn-info salary_generate">Salary Generate</button></td>'+
						'</tr>';
					});	
					$('#employee_details').html(x);
				}else{
					$('#employee_details').html('<tr><td colspan="4">Record not found.</td></tr>');
				}
			},
		});
	}
});

$(document).on('click','.salary_generate',function(){
	var month_id = 1;
	var emp_id = $(this).data('emp_id');
	window.open(baseUrl+userUrl+'/salary/salary-generation/'+month_id+'/'+emp_id);
});


$(document).on('change','#emp_type',function(){
	var emp_type = $(this).val();
	$.ajax({
		type:'POST',
		url:baseUrl+'payroll/Payroll_ctrl/emp_sub_type',
		data:{'emp_type':emp_type},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var x='<option value="">Select Sub Type</option>';
				$.each(response.data,function(key,value){
					x=x+'<option value="'+value.est_id+'">'+value.sub_type_name+'</option>';
				});	
				$('#emp_sub_type').html(x);
			}else{
				alert(response.msg);
			}
		},
	});
});
</script>