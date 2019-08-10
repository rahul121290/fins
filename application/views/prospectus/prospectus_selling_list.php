<div class="content-wrapper">
    <section class="content-header">
      <h1>Reception<small>Prospectus Selling</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Prospectus Selling</li>
      </ol>
    </section>
    <!-- Main content -->
	<section class="content">
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Prospectus</h3>
			</div>
			<div class="box-body">
			
			<div class="col-sm-2">
						<div class="form-group">
							<select class="form-control" name="seach_school" id="seach_school">
								<option value="">Select Board</option>
								<option value="1" selected>CBSE</option>
								<option value="3">State Board</option>
							</select>
							<div id="seach_school_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="col-sm-2">
						<div class=" form-group">
							<select class="form-control" name="seach_medium" id="seach_medium">
								<option value="">Select Medium</option>
								<?php foreach($medium as $med){?>
								    <option value="<?php echo $med['med_id'];?>" <?php if($med['med_id'] == 1){echo "selected";}?>><?php echo $med['med_name'];?></option>
								<?php }?>
							</select>
							<div id="seach_medium_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
					
				<div class="col-sm-2">
					<div class="form-group">
						<select class="form-control" name="seach_class" id="seach_class">
							<option value="">Select Class</option>
							<?php foreach($class as $classes){?>
								<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
							<?php } ?>
						</select>
						<div id="seach_class_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="col-sm-2">
					<div class="form-group">
						<input type="date" max="1979-12-31" id="from_date" name="from_date" class="form-control">
						<div id="from_date_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>

				<div class="col-sm-2">
					<div class="form-group">
						<input type="date" max="1979-12-31" id="to_date" name="to_date" class="form-control">
						<div id="to_date_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="col-sm-2">
					<div class="form-group">
						<button id="search" class="btn btn-primary btn-sm">Search</button> &nbsp; <button id="print" class="btn btn-info btn-sm">Print</button>
					</div>
				</div>
					<div class="col-md-12 table-responsive">
                      	<table class="table table-bordered table-striped text-center">
                		<thead>
                			<tr>
                				<th>S.No.</th>
                				<th>Registration No.</th>
                				<th>Selling Date</th>
                				<th>Session</th>
                				<th>Board</th>
                				<th>Class</th>
                				<th>Medium</th>
                				<th>Name</th>
                				<th>Contact No.</th>
                				<th>Alternate No.</th>
                				<th>Address</th>
                				<th>Action</th>
                			</tr>
                			</thead>
                			<tbody id="prospectus_list"></tbody>
                	</table>
					</div>
    			</div>
		</div>
    </section>
</div>


<!-- Modal -->
<div id="editProspectus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Prospectus</h4>
      </div>
      
      <div class="modal-body">
        <form role="form" class="form-horizontal" id="update_prospectus_form" method="POST">
			<div class="">
                
                <input type="hidden" id="p_id" name="p_id" value="">
                
				<div class="form-group">
					<label class="col-sm-4 control-label">Registration No.<span style="color:red;">*</span></label>
						<div class="col-sm-7">
							<input type="text" name="reg_no" id="reg_no" class="form-control only_text" value="" placeholder="Enter Registration Number" disabled="disabled" />
							<div id="reg_no_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Selling Date<span style="color:red;">*</span></label>
						<div class="col-sm-7">
							<input type="date" name="selling_date" id="selling_date" class="form-control" value="" />
							<div id="selling_date_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Board <span style="color:red;">*</span></label>
						<div class="col-sm-7">
							<select class="form-control" name="school" id="school">
								<option value="">Select Board</option>
								<option value="1">CBSE</option>
								<option value="3">State Board</option>
							</select>
							<div id="school_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Medium <span style="color:red;">*</span></label>
						<div class="col-sm-7">
							<select class="form-control" name="medium" id="medium">
								<option value="">Select Medium</option>
								<?php foreach($medium as $med){?>
								    <option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
								<?php }?>
							</select>
							<div id="medium_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
					
				<div class="form-group">
					<label class="col-sm-4 control-label">Class <span style="color:red;">*</span></label>
					<div class="col-sm-7">
						<select class="form-control" name="class_id" id="class_id">
							<option value="">Select Class</option>
							<?php foreach($class as $classes){?>
								<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
							<?php } ?>
						</select>
						<div id="class_err" class="text-danger" style="display:none;"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Name <span style="color:red;">*</span></label>
						<div class="col-sm-7">
							<input type="text" name="name" id="name" class="form-control only_text" placeholder="Enter Name" />
							<div id="name_err" class="text-danger" style="display:none;"></div>
						</div>
				</div>
				
				<div class="form-group">
                  <label class="col-sm-4 control-label">Contact No. <span style="color:red;">*</span></label>
					<div class="col-sm-7">
						<input type="text" name="phone" id="phone" class="form-control only_int" placeholder="Enter Contact No." />
						<div id="phone_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-4 control-label">Alternate Mobile No. <span style="color:red;">*</span></label>
					<div class="col-sm-7">
						<input type="text" name="alternate_no" id="alternate_no" class="form-control only_int" placeholder="Alternate Number" />
						<div id="alternate_no_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
                
				<div class="form-group">
                  <label class="col-sm-4 control-label">Address <span style="color:red;">*</span></label>
					<div class="col-sm-7">
						<textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter local address"></textarea>
						<div id="address_err" class="text-danger" style="display:none;"></div>
					</div>
                </div>
			</div>
					<div class="box-footer text-center">
                        <button type="button" id="update" class="btn btn-info">Update</button>
        			</div>
			</form>
      </div>
      
    </div>

  </div>
</div>


<script type="text/javascript">
var baseUrl = $('#base_url').val();

var sch_id = $('#seach_school').val();
var med_id = $('#seach_medium').val();
var class_id = $('#seach_class').val();
var from_date = $('#from_date').val();
var to_date = $('#to_date').val();

alllist(sch_id,med_id,class_id,from_date,to_date);
function alllist(sch_id,med_id,class_id,from_date,to_date){
	$.ajax({
		type:'GET',
		url:baseUrl+'Prospectus_ctrl/allList',
		data:{
			'sch_id':sch_id,
			'med_id':med_id,
			'class_id':class_id,
			'from_date':from_date,
			'to_date':to_date
			},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var x = '';
				$.each(response.data,function(key,value){
					if(value.sch_id == 1){
						var school = 'CBSE';
					}else if(value.sch_id == 2){
						var school = 'Sharda';
					}else if(value.sch_id == 3){
						var school = 'CG Board';
					}
					x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'.</td>'+
						'<td>'+value.reg_no+'</td>'+
						'<td>'+value.selling_date+'</td>'+
						'<td>'+value.session_name+'</td>'+
						'<td>'+school+'</td>'+
						'<td>'+value.class_name+'</td>'+
						'<td>'+value.med_name+'</td>'+
						'<td>'+value.name+'</td>'+
						'<td>'+value.phone+'</td>'+
						'<td>'+value.alternate_no+'</td>'+
						'<td>'+value.address+'</td>'+
						'<td><button class="btn btn-primary btn-sm edit" id="'+value.p_id+'"><i class="fa fa-edit"></i></button>&nbsp;&nbsp;'+
							'<button class="btn btn-danger btn-sm delete" id="'+value.p_id+'"><i class="fa fa-trash"></i></button></td>'+
						'</tr>';
				});
				$('#prospectus_list').html(x);
			}else{
			$('#prospectus_list').html('<tr><td colspan="12" style="text-align: center;">Record not found.</td></tr>');	
			}
		},
	});
}

//-------------search-----------------------------

$(document).on('click','#search',function(){
	var sch_id = $('#seach_school').val();
	var med_id = $('#seach_medium').val();
	var class_id = $('#seach_class').val();
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	alllist(sch_id,med_id,class_id,from_date,to_date);
});


$(document).on('click','#print',function(){
	var sch_id = $('#seach_school').val();
	var med_id = $('#seach_medium').val();
	var class_id = $('#seach_class').val();
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	$.ajax({
		type:'GET',
		url:baseUrl+'Prospectus_ctrl/allList',
		data:{
			'sch_id':sch_id,
			'med_id':med_id,
			'class_id':class_id,
			'from_date':from_date,
			'to_date':to_date
			},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var win = window.open('Prospectus Report', "myWindowName", "scrollbars=1,width=1200, height=600");
				var x = '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assets/css/bootstrap.min.css">'+
        				'<table class="table table-bordered table-striped">'+
                		'<thead>'+
                			'<tr>'+
                				'<th>Sr No.</th>'+
                				'<th>Reg. No.</th>'+
                				'<th>Selling Date</th>'+
                				'<th>Session</th>'+
                				'<th>Board</th>'+
                				'<th>Class</th>'+
                				'<th>Medium</th>'+
                				'<th>Name</th>'+
                				'<th>Contact No.</th>'+
                				'<th>Alternate No.</th>'+
                				'<th>Address</th>'+
                			'</tr>'+
                			'</thead>'+
                			'<tbody>';
				$.each(response.data,function(key,value){
					if(value.sch_id == 1){
						var school = 'CBSE';
					}else if(value.sch_id == 2){
						var school = 'Sharda';
					}else if(value.sch_id == 3){
						var school = 'CG Board';
					}
					x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'</td>'+
						'<td>'+value.reg_no+'</td>'+
						'<td>'+value.selling_date+'</td>'+
						'<td>'+value.session_name+'</td>'+
						'<td>'+school+'</td>'+
						'<td>'+value.class_name+'</td>'+
						'<td>'+value.med_name+'</td>'+
						'<td>'+value.name+'</td>'+
						'<td>'+value.phone+'</td>'+
						'<td>'+value.alternate_no+'</td>'+
						'<td>'+value.address+'</td>'+
						'</tr>';
				});
            		x=x+'</tbody></table>';
            		with(win.document){open(); write(x);close();}
			}else{
			
			}
		},
	});
});

//------------record delete----------------------
$(document).on('click','.delete',function(){
	var delete_id = $(this).attr('id');
	if(confirm('Are you sure!')){
		$.ajax({
			type:'POST',
			url:baseUrl+'Prospectus_ctrl/deleteRecord',
			data:{'delete_id':delete_id},
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

//-----------------record edit---------------------
$(document).on('click','.edit',function(){
	var edit_id = $(this).attr('id');

	$.ajax({
		type:'POST',
		url:baseUrl+'Prospectus_ctrl/editRecord',
		data:{'edit_id':edit_id},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				$('#p_id').val(response.data[0].p_id);
				$('#reg_no').val(response.data[0].reg_no);
				$('#selling_date').val(response.data[0].selling_date);
				$('#school').val(response.data[0].sch_id);
				$('#medium').val(response.data[0].med_id);
				$('#class_id').val(response.data[0].class_id);
				$('#name').val(response.data[0].name);
				$('#phone').val(response.data[0].phone);
				$('#alternate_no').val(response.data[0].alternate_no);
				$('#address').val(response.data[0].address);
				$('#editProspectus').modal('show');
			}else{
				alert('something went wrong.');
			}
		},
	});	
});


$('#update_prospectus_form').validate({
	rules:{
		reg_no:{required:true},
		selling_date:{required:true},
		school:{required:true},
		medium:{required:true},
		class_id:{required:true},
		name:{required:true},
		phone:{required:true,number:true},
		alternate_no:{number:true},
		address:{required:true},
	},
});

$(document).on('click','#update',function(){
	var formvalidate = $('#update_prospectus_form').valid();
	if(formvalidate){
		$.ajax({
			type:'POST',
			url:baseUrl+'Prospectus_ctrl/sellingProspectus',
			data:{
				p_id:$('#p_id').val(),
				reg_no:$('#reg_no').val(),
				selling_date:$('#selling_date').val(),
				school:$('#school').val(),
				medium:$('#medium').val(),
				class_id:$('#class_id').val(),
				name:$('#name').val(),
				phone:$('#phone').val(),
				alternate_no:$('#alternate_no').val(),
				address:$('#address').val()
			},
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					alert('Update Successfully');
					location.reload();
				}else{
					alert('Update Failed, Please try again.');
				}
			},
		});
	}
});

</script>

