<div class="content-wrapper">
<section class="content-header">
      <h1>Reception <small>Student List</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Student Discontinue List</li>
      </ol>
    </section>
    <section class="content-header">
 </section>

<!-- main section -->
<div class="col-md-12">	
<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Student Filter</h3>
                </div>
            	<div class="box-body form-horizontal">
            	<form id="fee_form" action="javascript:void(0);" method="POST" role="form">
            	
            	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
            	
              			<div class="form-group" style="margin-bottom:0px;">
              				<div class="col-sm-2 mb-3">
								<select name="session" id="session" class="form-control">
									<option value="0">Select Session</option>
									<option value="3" selected>2019-20</option>
								</select>
								<div id="session_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-2 mb-3">
								<select name="school" id="school" class="form-control">
									<option value="">Select Board</option>
    								<option value="1" selected>CBSE</option>
    								<option value="3">CG State Board</option>
								</select>
								<div id="school_err" style="display:none; color:red;"></div>
							</div>
							<div class="col-sm-2 mb-3" >
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
								    <option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
								<?php }?>
								</select>
								<div id="medium_err" style="display:none; color:red;"></div>
							</div>
							
							<div class="col-sm-3 mb-3" style="padding-left:0px;">
								<input type="text" id="search_box" name="search_box" class="form-control" placeholder="Enter Admission Number / Student Name">	
							</div>
						
							<div class="col-md-2 mb-3" style="padding:0px 0px;">
								<button type="button" name="search" id="search" class="btn btn-warning pull-left">Search</button>
							</div>
					    </div>
						 
					    
					   
            		</form>	
        		</div><!-- end box body -->
     			</div>
     			
    		<div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Discontinue Student List</h3>
                </div>
          		     <div class="box-body">
      					<table class="table table-responsive">
    						<thead><tr>
    						<th>S.No.</th>
    						<th>Admission No.</th>
    						<th>Class/Sec</th>
    						<th>Student Name</th>
                              <th>Father's Name</th>
                              <th>Fee Criteria</th>
                              <th>Staff Child</th>
                              <th>Action</th>
                            </tr>
                        </thead>
    					<tbody id="student_list"></tbody>
    				</table>
          		</div>
     		</div>
	</div>
</div>

<script type="text/javascript">
var baseUrl = $('#base_url').val();
var session = $('#session').val();
var school = $('#school').val();
var medium = $('#medium').val();
var search_box = $('#search_box').val();
	
$(document).on('click','#search',function(){
	var session = $('#session').val();
	var school = $('#school').val();
	var medium = $('#medium').val();
	var search_box = $('#search_box').val();
	discontinue_student_list(session,school,medium,search_box);	
});

$(document).on('keyup','#search_box',function(){
	var session = $('#session').val();
	var school = $('#school').val();
	var medium = $('#medium').val();
	var search_box = $(this).val();
	discontinue_student_list(session,school,medium,search_box);	
});

discontinue_student_list(session,school,medium,search_box);
function discontinue_student_list(session,school,medium,search_box){
	$.ajax({
		type:'POST',
		url:baseUrl+'Student_ctrl/discontinue_student_list',
		data:{'session':session,'school':school,'medium':medium,'search_box':search_box},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var x='';
				$.each(response.data,function(key,value){
					x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'</td>'+
						'<td>'+value.adm_no+'</td>'+
						'<td>'+value.class_name+'/'+value.section_name+'</td>'+
						'<td>'+value.name+'</td>'+
						'<td>'+value.f_name+'</td>'+
						'<td>'+value.fc_name+'</td>'+
						'<td>'+value.staff_child+'</td>'+
						'<td><button data-std_id="'+value.std_id+'" class="btn btn-success restore">Restore</button>&nbsp;'+
						'<button data-std_id="'+value.std_id+'" class="btn btn-danger delete">Delete</button></td>'+
					'</tr>';
				});
			$('#student_list').html(x);
			}else{
				$('#student_list').html('<tr><td colspan="8" style="text-align:center;">Record not found.</td></tr>');
			}
		},
	});
}

$(document).on('click','.restore',function(){
	var std_id = $(this).data('std_id');
	var session = $('#session').val();
	var school = $('#school').val();
	var medium = $('#medium').val();
	var search_box = $('#search_box').val();
	if(confirm('Are you sure! you want to restore this student')){
		$.ajax({
			type:'POST',
			url:baseUrl+'Student_ctrl/std_restore',
			data:{'std_id':std_id},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					alert(response.msg);
					discontinue_student_list(session,school,medium,search_box);
				}else{
					alert(response.msg);
				}
			},
		});
	}
});

$(document).on('click','.delete',function(){
	var std_id = $(this).data('std_id');
	var session = $('#session').val();
	var school = $('#school').val();
	var medium = $('#medium').val();
	var search_box = $('#search_box').val();
	if(confirm('Are you sure! you want to permanet delete this student')){
		$.ajax({
			type:'POST',
			url:baseUrl+'Student_ctrl/std_delete',
			data:{'std_id':std_id},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					alert(response.msg);
					discontinue_student_list(session,school,medium,search_box);
				}else{
					alert(response.msg);
				}
			},
		});
	}
});

</script>