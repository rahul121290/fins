<div class="content-wrapper">
<section class="content-header" style="margin-bottom:10px;">
      <h1>Salary Data Entry</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/payroll/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Salary Data Entry</li>
      </ol>
    </section>

<!-- main section -->
<div class="col-md-12">	
  	<div class="box box-danger no-print">
        <div class="box-header">
          <h3 class="box-title">Select filters</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    	<form id="attendance_form" action="javascript:void(0);" role="form" method="post">
      			<div class="form-group" style="margin-bottom:0px;">
      				<div class="col-sm-2 mb-3">
						<select name="month" id="month" class="form-control">
							<option value="">Select Month</option>
							<?php foreach($month as $months){?>
								<option value="<?php echo $months['m_id'];?>" <?php if($months['m_id'] == (int)date('m')){echo "selected";}?>><?php echo $months['m_name'];?></option>	
							<?php }?>
						</select>
						<div id="month_err" style="display:none; color:red;"></div>
					</div>	
					
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
							<option value="">Select Type</option>
							<option value="1">Permanent</option>
							<option value="2">Adhoc</option>
						</select>
						<div id="emp_type_err" class="text-danger" style="display:none;"></div>
					</div>
										
					<div class="col-sm-2 mb-3">
						<select class="form-control" name="emp_sub_type" id="emp_sub_type">
							<option value="">Employee Sub Type</option>
						</select>
						<div id="emp_sub_type_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-md-2 mb-3">
						<button type="button" id="search" class="btn btn-info pull-left">Search</button>	
					</div>
			    </div>
			    </form>
		</div><!-- end box body -->
		</div>
		<div class="print-s-logo" style="float:left;padding:0px 0px 5px 0px;width:100%;margin-bottom:10px;">
				<div class="text-center" style="float:left;">
					<img class="pull-left" alt="" src="../images/shakuntala/shakuntala.png" height="40" />
					<div class="print-s-name" >
						<h4><b>Shakuntala Vidyalaya</b></h4>
						<p>Ram Nagar Bhilai(C.G.)</p>
					</div>
					
				</div>
				<div class="text-right">
					<h4 style="margin-bottom:0px;"><b>Enter salary data employee wise</b></h4>
				</div>
		</div>
		
	
		<div class="box box-info">
            <div class="box-header no-print">
              <h3 class="box-title"><b>Enter salary data employee wise</b></h3>
            </div>
      		<div class="box-body p-table-bg-head p-table-body table-responsive">
				<table class="table">
					<thead><tr>
					<th>S.No.</th>
					<th>School Name</th>
					<th>Employee Type</th>
					<th>Employee Name</th>
					<th>Month</th>
					<th>Absent Day</th>
					</tr>
					</thead>
					<tbody id="employee_list"></tbody>
				</table>
      		</div>
 		</div>
		<div class="">
			<div class="text-center">
    			<button class="btn btn-space btn-success no-print" id="attendance_submit" style="margin-bottom:50px;">Submit</button> 
    			<button class="btn btn-space btn-primary no-print" style="margin-bottom:50px;" onclick="printDiv()">Print this page</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var baseUrl = $('#base_url').val();


$('#attendance_form').validate({
	rules:{
		school:{required:true},
		emp_type:{required:true},
		emp_sub_type:{required:true},
		month:{required:true},
		
	},
});

$(document).on('click','#search',function(){
	var formvalidate = $('#attendance_form').valid();
	if(formvalidate){
		var school = $('#school').val();
		var emp_type = $('#emp_type').val();
		var emp_sub_type = $('#emp_sub_type').val();
		var month = $('#month').val();

		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/employee_attendance_list',
			data:{'emp_type':emp_type,'emp_sub_type':emp_sub_type,'month':month},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					var x='';
					$.each(response.data,function(key,value){
						if(value.sch_id == 1){
							var school_name = 'Shakuntala Vidyalaya (CBSE)';
						}else if(value.sch_id == 2){
							var school_name = 'Sharda Vidyalaya Risali';
						}else if(value.sch_id == 3){
							var school_name = 'Shakuntala Vidyalaya (CG)';
						}else if(value.sch_id == 4){
							var school_name = 'Sharda Vidyalaya Vaishali Nagar';
						}
						x=x+'<tr>'+
							'<td>'+parseInt(key+1)+'</td>'+
							'<td>'+school_name+'</td>'+
							'<td>'+value.et_name+' / '+value.sub_type_name+'</td>'+
							'<td>'+value.emp_name+'</td>'+
							'<td>'+month+'</td>'+
							'<td><input type="text" data-max="30" data-emp_id="'+value.emp_id+'" value="'+value.present+'" class="emp_attendance max_validation"></td>'+
							'</tr>';
					});
					$('#employee_list').html(x);
				}else{
					$('#employee_list').html('<tr><td colspan="7">Record not found.</td></tr>');
				}
			},
		});
	}
});


//----------------min max validation----------------
$(document).on('blur','.max_validation',function(){
	var max = $(this).data('max');
  	var val = $(this).val();
  	if(max != ''){
  		if(val > max || val == ''){
	  	  	$(this).css('box-shadow','0px 0px 10px red');
		  	$(this).focus();
		  	$('#attendance_submit').attr('disabled','disabled');
	  	}
	  	else{
	  		$('#attendance_submit').attr('disabled',false);
	  	  	$(this).css('box-shadow','none');
	  	}
  	}
});	

//-------------- focus on text box--------------------------------
$(document).on('keyup','.max_validation',function(){
var max = $(this).data('max');
	var val = $(this).val();
	if (val < 0){
	  	$(this).val(0);
	 }
	if(val > max){
	  	$(this).css('box-shadow','0px 0px 10px red');
  	$(this).focus();
    //$(this).val(max);
	}	
	else{
	  	$(this).css('box-shadow','none');
	}
});

$(document).on('click','#attendance_submit',function(){
	var formvalidate = $('#attendance_form').valid();
	if(formvalidate){

		var school = $('#school').val();
		var emp_type = $('#emp_type').val();
		var emp_sub_type = $('#emp_sub_type').val();
		var month = $('#month').val();

		
		var emp_attendance = [];
		var month = $('#month').val();
		$('.emp_attendance').each(function(){
			var temp = [];
			temp.push({emp_id : $(this).data('emp_id')});
			temp.push({attendance : $(this).val()});
			emp_attendance.push(temp);
		});

		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/emp_attendance',
			data:{'emp_attendance':emp_attendance,
				'sch_id':school,
				'emp_type':emp_type,
				'emp_sub_type':emp_sub_type,
				'month':month
			},
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