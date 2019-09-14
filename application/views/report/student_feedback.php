<div class="content-wrapper">
    <section class="content-header">
      <h1>Students Delinquents<small>Entry</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="">Reports</li>
        <li class="active">Delinquents Entry</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    	<div class="row">
        <div class="col-md-5">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Search Students</h3>
                </div>
            	<div class="box-body">
            	<form role="form" method="POST" class="form-horizontal" id="student_feedback_form">
            		<input type="hidden" name="id" id="id">
              			<div class="form-group">
							<label class="control-label col-md-2">Medium</label>
							<div class="col-sm-9">
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
										<option value="<?php echo $med['med_id'];?>" <?php if(count($medium) == 1){echo "selected";}?>><?php echo $med['med_name'];?></option>
									<?php } ?>
								</select>
								<div id="medium_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Class</label>
							<div class="col-sm-9">
								<select name="class_name" id="class_name" class="form-control">
									<option value="">Select Class</option>
									<?php foreach($class as $classes){?>
									<option value="<?php echo $classes['c_id'];?>" <?php if(count($class) == 1){echo "selected";}?>><?php echo $classes['class_name'];?></option>
									<?php } ?>
								</select>
								<div id="class_name_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Section</label>
							<div class="col-sm-9">
								<select name="section" id="section" class="form-control">
									<option value="">Select Section</option>
									<?php foreach($section1 as $sec){?>
									<option value="<?php echo $sec['sec_id'];?>" <?php if(count($section1) == 1){echo "selected";}?>><?php echo $sec['section_name'];?></option>
									<?php }?>
								</select>
								<div id="section_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					
						<div class="box-footer">
                  			<div class="text-center">
                        		<button type="button" id="search" class="btn btn-info btn-space">Search Students</button>
                    		</div>
                		</div>	
        			</form>
        		</div><!-- end box body -->
     			</div>
   			</div>
       		<div class="col-md-7">	
              	<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">Student List</h3>
                      <div id="subject_msg"></div>
                      <div id="practical_msg"></div>
                      <div id="notebook_msg"></div>
                      <div id="enrichment_msg"></div>
                      <div id="acadmic_msg"></div>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    						<thead>
            					<tr>
                    				<th>S.No.</th>
                    				<th>Student Name</th>
                    				<th>Class/Section</th>
                    				<th>Admission No.</th>
                    				<th>Roll No.</th>
                    				<th>Warning No.</th>
                    				<th>Action</th>
            					</tr>
        					</thead>
    						<tbody id="student_list"></tbody>
    					</table>
              		</div>
         		</div>
       		</div>
		</div>
	</section>	
</div>

<!-- Modal -->
<div id="feedback_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      <input type="hidden" id="modal_medium" value="">
      <input type="hidden" id="modal_adm_no" value="">
      
      <select id="warning_no" name="warning_no" class="form-control">
      	<option value="">Select Warning</option>
      </select>
      
      	<div class="box-body" id="feedback_list"></div>
      	<div class="box-body" id="action_taken"></div>
      	<div class="box-footer">
  			<div class="text-center">
        		<button type="button" id="submit_feedback" class="btn btn-info btn-space">Submit</button>
    		</div>
		</div>	
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
var baseUrl = $('#base_url').val();

$(document).on('click','#search',function(){
	var medium = $('#medium').val();
	var class_id = $('#class_name').val();
	var section = $('#section').val();
	var formvalidate = true;

	if(medium == ''){
		$('#medium_err').html('This is Required').css('display','block');
		formvalidate = false;
	}else{
		$('#medium_err').css('display','none');
	}

	if(class_id == ''){
		$('#class_name_err').html('This is Required').css('display','block');
		formvalidate = false;
	}else{
		$('#class_name_err').css('display','none');
	}

	if(section == ''){
		$('#section_err').html('This is Required').css('display','block');
		formvalidate = false;
	}else{
		$('#section_err').css('display','none');
	}
	if(formvalidate){
		$.ajax({
			type:'POST',
			url:baseUrl+'Teacher_ctrl/student_feedback',
			data:{'medium':medium,'class_id':class_id,'section':section},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				var x='';
				if(response.status == 200){
					$.each(response.data,function(key,value){
						x=x+'<tr>'+
							'<td>'+parseInt(key+1)+'</td>'+
							'<td>'+value.name+'</td>'+
							'<td>'+value.class_name+'/'+value.section_name+'</td>'+
							'<td>'+value.adm_no+'</td>'+
							'<td>'+value.roll_no+'</td>'+
							'<td>'+value.warning_no+'</td>'+
							'<td><button class="btn btn-success feedback" data-std_name="'+value.name+'" data-medium="'+value.medium+'" data-adm_no="'+value.adm_no+'">Feedback</button></td>'+
						'</tr>';
					});	
					$('#student_list').html(x);
				}
			},
		});
	}
});

$(document).on('click','.feedback',function(){
	$('#feedback_list').html('');
	$('#action_taken').html('');
	var medium = $(this).data('medium');
	var adm_no = $(this).data('adm_no');
	var name = $(this).data('std_name');
	$.ajax({
		type:'POST',
		url:baseUrl+'Teacher_ctrl/warning_list',
		data:{'medium':medium,'adm_no':adm_no},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				$('.modal-title').html(name+' Important assessment feedback');
				$('#modal_medium').val(medium);
				$('#modal_adm_no').val(adm_no);
				var x = '<option value="">Select Warning No</option>';
				$.each(response.data,function(key,value){
					x=x+'<option value="'+value.w_id+'">'+value.warning+'</option>';
				});
				$('#warning_no').html(x);
				$('#feedback_modal').modal('show');
			}else{
				alert(response.msg);
			}
		},
	});
});

$(document).on('change','#warning_no',function(){
	var warning_no = $(this).val();
	var medium = $('#modal_medium').val();
	var adm_no = $('#modal_adm_no').val();
	$.ajax({
		type:'POST',
		url:baseUrl+'Teacher_ctrl/feedback_list',
		data:{'medium':medium,'adm_no':adm_no,'warning_no':warning_no},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var x='<b>Feedback</b> <br/>';
				if(response.data.student_feedback != ''){
					var str = response.data.student_feedback;
					var student_feedback = str.split(",");
				}else{
					var student_feedback = [];
				}
				//---------------feedback list----------------------------
				$.each(response.data.feedback_list,function(key,value){
					var flag = 1;
					$.each(student_feedback,function(k,v){
						if(v == value.af_id){
							flag = 0;
							x=x+'<div class="form-group">'+
							'<div class="col-sm-9">'+
								'<input type="checkbox" id="'+value.af_id+'" name="assesment_feedback" checked>'+value.feedback+
						'</div></div>';
						}
					});
					if(flag){
						x=x+'<div class="form-group">'+
						'<div class="col-sm-9">'+
							'<input type="checkbox" id="'+value.af_id+'" name="assesment_feedback">'+value.feedback+
					'</div></div>';
					}
				});
				$('#feedback_list').html(x);

				var y='<b>Action Taken</b> <br/>';
				if(response.data.teacher_action_taken != ''){
					var str = response.data.teacher_action_taken;
					var teacher_action_taken = str.split(",");
				}else{
					var teacher_action_taken = [];
				}
				$.each(response.data.action_taken,function(key,value){
					var flag = 1;
					$.each(teacher_action_taken,function(k,v){
						if(v == value.at_id){
							flag = 0;
							y=y+'<div class="form-group">'+
							'<div class="col-sm-9">'+
								'<input type="checkbox" id="'+value.at_id+'" name="action_taken" checked>'+value.description+
						'</div></div>';
						}
					});
					if(flag){
						y=y+'<div class="form-group">'+
						'<div class="col-sm-9">'+
							'<input type="checkbox" id="'+value.at_id+'" name="action_taken">'+value.description+
					'</div></div>';
					}
				});
				$('#action_taken').html(y);
				$('#feedback_modal').modal('show');	
			}else{
				alert(response.msg);
			}
		},
	});
});



$(document).on('click','#submit_feedback',function(){
	var adm_no = $('#modal_adm_no').val();
	var medium = $('#modal_medium').val();
    var assesment_feedback = [];
    $.each($("input[name='assesment_feedback']:checked"), function(){            
		assesment_feedback.push($(this).attr('id'));
    });

    
	if(assesment_feedback.length == 0){
		alert('Please Select feedback');
		return false;
	}
	
    var action_taken = [];
    $.each($("input[name='action_taken']:checked"), function(){            
    	action_taken.push($(this).attr('id'));
    });

   
	if(action_taken.length == 0){
		alert('Please Select Action Taken');
		return false;
	}

	var formdata = new FormData();
		formdata.append('medium',medium);
		formdata.append('adm_no',adm_no);
		formdata.append('warning_no',$('#warning_no').val());
		formdata.append('assesment_feedback',assesment_feedback);
		formdata.append('action_taken',action_taken);
	$.ajax({
		type:'POST',
		url:baseUrl+'Teacher_ctrl/submit_feedback',
		data:formdata,
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				alert(response.msg);
				$('#search').trigger('click');
				$('#feedback_modal').modal('hide');	
			}else{
				alert(response.msg);
			}
		},
		cache:false,
		processData:false,
		contentType:false
	});
    	
});


</script>

