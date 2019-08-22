<div class="content-wrapper">
    <section class="content-header">
      <h1>Reception<small>Fee Structure</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">fee structure</li>
      </ol>
    </section>
    <!-- Main content -->
	<section class="content">
		<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Fee Structure Add /Update</h3>
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
				  <i class="fa fa-minus"></i></button>
			  </div>
			</div>
			<div class="box-body">
			<form action="javascript:void(0);" id="fee_structure_form">
    			<div class="col-sm-3 ">
                      <div class="form-group">
    					<select id="school" name="school" class="form-control">
    						<option value="">Select Board</option>
    						<option value="1">CBSE</option>
    						<option value="3">CG Board</option>
    					</select>
    					<div class="error" id="school_err" style="display: none;"></div>
    			  </div>
               </div>
               
               <div class="col-sm-3">
                      <div class="form-group">
    					<select id="medium" name="medium" class="form-control">
    						<option value="">Select Medium</option>
    						<?php foreach($medium as $med){?>
    						<option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
    						<?php } ?>
    					</select>
    					<div class="error" id="medium_err" style="display: none;"></div>
    			  </div>
               </div>
    			
    			<div class="col-sm-3">
                      <div class="form-group">
    					<select id="class_id" name="class_id" class="form-control">
    						<option value="">Select Class</option>
    						<?php foreach($class as $class){?>
    						<option value="<?php echo $class['c_id'];?>"><?php echo $class['class_name'];?></option>
    						<?php } ?>
    					</select>
    					<div class="error" id="class_err" style="display: none;"></div>
    			  </div>
               </div>
               
               <div class="col-sm-3">
    				<button id="search" class="btn btn-warning">Search</button>
               </div>
               
			   <div class="col-md-12">
			   <h3 class="box-title" style="font-size:19px;">Fee Structure List</h3>
			   <hr>
               <div class="table-responsive" style="min-height:300px;">
			   <table class="table" >
               		<thead>
               			<tr>
               				<th>Heads</th>
               				<th>General Student</th>
               				<th>Sibling</th>
               				<th>RTE</th>
               				<th>Staff (First Child)</th>
               				<th>Staff (Second Child)</th>
               				
               				
               			</tr>
               		</thead>
               		<tbody id="feelist"></tbody>
               </table>
			   </div>
			   <div class="col-md-6">
				   <div class="text-center">
				   <button class="btn btn-block btn-success " id="submit" style="display:none;">Submit</button>
				   </div>
			   </div>
			   </div>
               </form>
			</div>
		</div>
    </section>
</div>

<script type="text/javascript">
var baseUrl = $('#base_url').val();

$(document).on('change','#class_id',function(){
	var sch_id = $('#school').val();
	var med_id = $('#medium').val();
	var class_id =$('#class_id').val();
	var formvalid = true;
	if(sch_id == ''){
		$('#school_err').html('This is Required.').css('display','block');
		formvalid = false;
	}else{
		$('#school_err').css('display','none');
	}

	if(med_id == ''){
		$('#medium_err').html('This is Required.').css('display','block');
		formvalid = false;
	}else{
		$('#medium_err').css('display','none');
	}

	if(class_id == ''){
		$('#class_err').html('This is Required.').css('display','block');
		formvalid = false;
	}else{
		$('#class_err').css('display','none');
	}
	
	if(formvalid){
		fee_stucuture_record(sch_id,med_id,class_id);	
	}
		
});


$(document).on('click','#search',function(){
	$("#class_id").trigger("change");
});

function fee_stucuture_record(sch_id,med_id,class_id){
	$.ajax({
		type:'POST',
		url: baseUrl+'Fee_structure_ctrl/feeList',
		data:{'sch_id':sch_id,'med_id':med_id,'class_id':class_id},
		dataType:'json',
		beforeSend:function(){
			$('#loader').modal('show');
		},
		success:function(response){
			if(response.status == 200){
				$('#loader').modal('hide');
				var x = '';
				$.each(response.data,function(key,value){
					x=x+'<tr>'+
					'<td><b>'+value.name+'</b></td>'+
					'<td><input type="number" value="'+value.general+'" data-ft_id="'+value.ft_id+'" id="'+value.ft_id+'_general" class="general only_amount form-control"/></td>'+
					'<td><input type="number" value="'+value.sibling+'" data-ft_id="'+value.ft_id+'" id="'+value.ft_id+'_sibling" class="sibling only_amount form-control"/></td>'+
					'<td><input type="number" value="'+value.rte+'" data-ft_id="'+value.ft_id+'" id="'+value.ft_id+'_rte" class="rte only_amount form-control" /></td>'+
					'<td><input type="number" value="'+value.staff_first_child+'" data-ft_id="'+value.ft_id+'" id="'+value.ft_id+'_staff_first_child" class="staff_first_child only_amount form-control" /></td>'+
					'<td><input type="number" value="'+value.staff_second_child+'" data-ft_id="'+value.ft_id+'" id="'+value.ft_id+'_staff_second_child" class="staff_second_child only_amount form-control" /></td>'+
					'</tr>';
				});
				$('#submit').css('display','block');
				$('#feelist').html(x);
			}
		},
	});
}

$(document).on('keyup','.only_amount',function(){
	$(this).val($(this).val().replace(/[^0-9\.]/g,''));
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});


$(document).on('click','#submit',function(){
	var sch_id = $('#school').val();
	var med_id = $('#medium').val();
	var class_id =$('#class_id').val();
	
	var general = [];
	$( ".general" ).each(function(key,value) {
			var temp = [];
			temp.push({ ft_id : $(this).data('ft_id')});
			temp.push({ amount : $(this).val()});
			general.push(temp);  
	});

	var sibling = [];
	$( ".sibling" ).each(function(key,value) {
			var temp = [];
			temp.push({ ft_id : $(this).data('ft_id')});
			temp.push({ amount : $(this).val()});
			sibling.push(temp);  
	});

	var rte = [];
	$( ".rte" ).each(function(key,value) {
			var temp = [];
			temp.push({ ft_id : $(this).data('ft_id')});
			temp.push({ amount : $(this).val()});
			rte.push(temp);  
	});


	var staff_first_child = [];
	$( ".staff_first_child" ).each(function(key,value) {
			var temp = [];
			temp.push({ ft_id : $(this).data('ft_id')});
			temp.push({ amount : $(this).val()});
			staff_first_child.push(temp);  
	});

	var staff_second_child = [];
	$( ".staff_second_child" ).each(function(key,value) {
			var temp = [];
			temp.push({ ft_id : $(this).data('ft_id')});
			temp.push({ amount : $(this).val()});
			staff_second_child.push(temp);  
	});

	$.ajax({
		type:'POST',
		url:baseUrl+'Fee_structure_ctrl/submit_fee',
		data:{
			'sch_id':sch_id,
			'med_id':med_id,
			'class_id':class_id,
			'general':general,
			'sibling':sibling,
			'rte':rte,
			'staff_first_child':staff_first_child,
			'staff_second_child':staff_second_child
		},
		dataType:'json',
		beforeSend:function(){
			$('#loader').modal('show');
		},
		success:function(response){
			if(response.status == 200){
				//$('#loader').modal('hide');
				alert(response.msg);
				fee_stucuture_record(sch_id,med_id,class_id);
			}else{
				$('#loader').modal('hide');
				alert(response.msg);
			}
		},
	});
});


</script>