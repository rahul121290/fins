<div class="content-wrapper">
    <section class="content-header">
      <h1>Student<small>Reports</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active">Student Reports</li>
  </ol>
</section>
<!-- main section -->
<div class="col-md-12">	
  	<div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Search Records</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<form action="javascript:void(0);" id="academic_report_form" role="form">
      			<div class="form-group">
					<div class="col-sm-2">
						<select name="medium" id="medium" class="form-control">
							<option value="">Select Medium</option>
							<?php foreach($medium as $med){?>
						    <option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
						<?php }?>
						</select>
						<div id="medium_err" style="display:none; color:red;"></div>
					</div>
					
					
					<div class="col-sm-2">
						<select class="form-control" id="class_name" name="class_name">
							<option value="">Select Class</option>
							<?php foreach($class as $classes){?>
								<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
							<?php } ?>
						</select>
						<div id="class_name_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-2" id="sub_group_table" style="display:none;">
						<select name="sub_group" id="sub_group" class="form-control">
							<option value="">Select Subject Group</option>
							<?php foreach($group as $groups){?>
    							<option value="<?php echo $groups['sg_id'];?>"><?php echo $groups['sg_name'];?></option>
    						<?php } ?>
						</select>
						<div id="sub_group_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-2">
						<select name="section" id="section" class="form-control">
							<option value="">Select Section</option>
							<?php foreach($section1 as $sec){?>
    							<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
    						<?php }?>
						</select>
						<div id="section_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-2">
						<select name="performance" id="performance" class="form-control">
							<option value="">Select Performance</option>
							<option value="Excellent">Excellent</option>
							<option value="Very Good">Very Good</option>
							<option value="Good">Good</option>
							<option value="Average">Average</option>
							<option value="Needs Improvements">Needs Improvements</option>
							
						</select>
						<div id="section_err" style="display:none; color:red;"></div>
					</div>
					
					<div class="col-sm-3">
						<button type="button" id="mid_report" class="btn btn-info btn-space">Mid Report</button>
					</div>
			    </div>
			   </form> 
			    <hr>
				
				<?php //if($this->uri->segment(2) == 'admin'){?>
    			<div class="row">
				<div class="col-sm-3">
					<input type="text" id="search_box" name="search_box" class="form-control" placeholder="Enter Admission Number">	
				</div>
				</div>
				<?php //} ?>
				
		</div><!-- end box body -->
		</div>
	</div>
	
	<div class="col-md-12">	
      	<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Student Performance List</h3>
            </div>
      		     <div class="box-body table-responsive">
  					<table class="table ">
						<thead><tr>
                          <th>S.No.</th>
                          <th>Name</th>
                          <th>Class/Section</th>
                          <th>Admission No</th>
                          <th>Roll No</th>
                          <th>Percentage</th>
                          <th>Performace</th>
                        </tr>
                    </thead>
					<tbody id="student_list"><tr><td colspan="10" style="text-align:center;">Record not found.</td></tr></tbody>
				</table>
      		</div>
 		</div>
	</div>   			
</div>
<script type="text/javascript">
var baseUrl = $('#base_url').val();

$('#academic_report_form').validate({
	rules:{
		medium:{required:true},
		class_name:{required:true},
		section:{required:true}
	},
});

$(document).on('click','#mid_report',function(){
	var formvalidate = $('#academic_report_form').valid();
	if(formvalidate){
		var medium = $('#medium').val();
		var class_name = $('#class_name').val();
		var sub_group = $('#sub_group').val();
		var section = $('#section').val();
		var performance = $('#performance').val();
		academic_report(medium,class_name,sub_group,section,performance);
	}
});

function academic_report(medium,class_name,sub_group,section,performance){
	$.ajax({
		type:'POST',
		url:baseUrl+'Production_ctrl/mid_academic_report',
		data:{'medium':medium,'class_name':class_name,'sub_group':sub_group,'section':section},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status = 200){
				var x='';
				var i = 0;
				$.each(response.data,function(key,value){
					if(performance != ''){
						if(performance == value.performance){
							i++;
							x=x+'<tr>'+
							'<td>'+parseInt(key+1)+'</td>'+
							'<td>'+value.name+'</td>'+
							'<td>'+value.class+'/'+value.section+'</td>'+
							'<td>'+value.adm_no+'</td>'+
							'<td>'+value.roll_no+'</td>'+
							'<td>'+value.pre_mid_percentage+'</td>'+
							'<td>'+value.performance+'</td>'+
							'</tr>';
						}
					}else{
						i++;
						x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'</td>'+
						'<td>'+value.name+'</td>'+
						'<td>'+value.class+'/'+value.section+'</td>'+
						'<td>'+value.adm_no+'</td>'+
						'<td>'+value.roll_no+'</td>'+
						'<td>'+value.pre_mid_percentage+'</td>'+
						'<td>'+value.performance+'</td>'+
						'</tr>';
					}
				});
				
				if(i == 0){
					$('#student_list').html('<tr><td colspan="7" style="text-align:center;">Record not found.</td></tr>');
				}else{
					$('#student_list').html(x);
				}
				
			}else{
				alert(response.msg);
				$('#student_list').html('');
			}
		},
	});
}


</script>


