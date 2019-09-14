<style>
.skin-blue .main-header .navbar{padding:10px;}
.mb-3{margin-bottom:15px;}
</style>
<div class="content-wrapper">
<section class="content-header no-print">
      <h1>Delinquents Report</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/reception/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">delinquents-report</li>
      </ol>
    </section>
<section class="content-header">
</section>
	<!-- main section -->
    <div class="col-md-12">	
      	<div class="box box-danger no-print">
            <div class="box-header">
              <h3 class="box-title">Student Filter</h3>
            </div>
        	<div class="box-body form-horizontal">
        	<form id="delinquents_report" action="javascript:void(0);" method="POST" role="form">
        	
        	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
        	
          			<div class="form-group" style="margin-bottom:0px;">

						<div class="col-sm-2 mb-3" >
							<select name="medium" id="medium" class="form-control">
								<option value="">Select Medium</option>
								<?php foreach($medium as $med){?>
							    <option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
							<?php }?>
							</select>
							<div id="medium_err" style="display:none; color:red;"></div>
						</div>
						
							<div class="col-sm-2 mb-3">
							<select name="warning" id="warning" class="form-control">
								<option value="">Select Warning</option>
								<?php foreach($warning as $war){?>
        							<option value="<?php echo $war['w_id'];?>"><?php echo $war['warning'];?></option>
        						<?php }?>
							</select>
							<div id="warning_err" style="display:none; color:red;"></div>
						</div>
						
						<div class="col-sm-2 mb-3">
							<select class="form-control" id="class_name" name="class_name">
								<option value="">Select Class</option>
								<?php foreach($class as $classes){?>
    								<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
    							<?php } ?>
							</select>
							<div id="class_name_err" style="display:none; color:red;"></div>
						</div>
						
						<div class="col-sm-2 mb-3">
							<select name="section" id="section" class="form-control">
								<option value="">Select Section</option>
								<?php foreach($section as $sec){?>
        							<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
        						<?php }?>
							</select>
							<div id="section_err" style="display:none; color:red;"></div>
						</div>
						
					
						
						<div class="col-md-2 mb-3" style="padding:0px 0px;">
							<button style="margin-right:10px;" type="button" id="search" class="btn btn-success pull-left">Search</button>&nbsp;&nbsp;&nbsp;
							<button type="button" id="print" class="btn btn-info pull-left"  onclick='printDiv();'>Print</button>
							
						</div>
				    </div>
					 
				   <!--  <div class="col-sm-6 mb-3" style="padding-left:0px;">
						<input type="text" id="search_box" name="search_box" class="form-control" placeholder="Enter Admission Number/ Student Name" />	
					</div>  -->
				   
        		</form>	
    		</div><!-- end box body -->
 			</div>
			<div class="print-s-logo" style="float:left;padding:0px 0px 5px 0px;width:100%;">
				<div class="text-center" style="float:left;">
    				<?php if($this->session->userdata('school_id') == 1){?>
        				<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" height="40" />
        				<div class="print-s-name"><h4><b>Shakuntala Vidyalaya</b></h4><p>Ram Nagar Bhilai(C.G.)</p></div>
      				<?php } else if($this->session->userdata('school_id') == 2){?>
                      	<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/sharda/sharda_logo.png" height="40" />
                		<div class="print-s-name"><h4><b>Sharda Vidyalaya</b></h4><p>Risali Bhilai(C.G.)</p></div>
					<?php }else{?>
						<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" height="40" />
						<div class="print-s-name"><h4><b>Shakuntala Vidyalaya No. 2</b></h4><p>Ram Nagar Bhilai(C.G.)</p></div>
					<?php }?>
				</div>
				<div class="text-right"><h4 style="margin-bottom:0px;"><b>Student Sibling Report</b></h4></div>
			</div>
			<div class="box box-info" style="float:left;">
                <div class="box-header no-print">
                  <h3 class="box-title">Search Results</h3>
                </div>
          		     <div class="box-body p-sibling-report" id="DivIdToPrint">
      					<table style="border:2px solid #ddd;" class="table table-responsive">
							<thead><tr>
							<th>S.No.</th>
                              <th>Adm. No.</th>
							   <th>Student Name</th>
                              <th>Class/Section</th>
                              <th>Father Name</th>
                              <th>Contact No</th>
                              <th>Incident Remarks</th>
                              <th>Action Taken</th>
                              <th>Date of Incident</th>
                              <th>Warning Sl.</th>
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
var userUrl = $('#user_url').val();

$('#delinquents_report').validate({
	rules:{
		medium:{required:true},
		//class_name:{required:true},
		//section:{required:true},
		warning:{required:true},
	},
});

$(document).on('click','#search',function(){
	var formvalidate = $('#delinquents_report').valid();
	var medium = $('#medium').val();
	var class_name = $('#class_name').val();
	var section = $('#section').val();
	var warning = $('#warning').val();
	var search_box = '';
	if(formvalidate){
		studentList(medium,class_name,section,warning,search_box);
	}
});

function studentList(medium,class_name,section,warning,search_box){
	$.ajax({
		type:'POST',
		url:baseUrl+'Student_ctrl/delinquents_report',
		data:{'medium':medium,'class_name':class_name,'section':section,'warning':warning},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var x='';
				$.each(response.data,function(key,value){
					x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'</td>'+
						'<td>'+value.adm_no+'</td>'+
						'<td>'+value.name+'</td>'+
						'<td>'+value.class_name+'/'+value.section_name+'</td>'+
						'<td>'+value.f_name+'</td>'+
						'<td>'+value.contact_no+'</td>'+
						'<td>';
						$.each(value.delinquents,function(dkay,dval){
							x=x+'<p><b>'+parseInt(dkay+1)+')</b> '+dval.feedback+'</p>';
						});
						x=x+'</td>'+
						'<td>';
						$.each(value.action_taken,function(atKey,atVal){
							x=x+'<p><b>'+parseInt(atKey+1)+')</b> '+atVal.description+'</p>';
						});
						x=x+'</td>'+
						'<td>'+value.submit_date+'</td>'+
						'<td>'+value.warning_no+'</td>'+
						'<td><button data-adm_no="'+value.adm_no+'" class="btn btn-success view_details">View Details</button></td>'+
						'</tr>';
				});
				$('#student_list').html(x);
			}else{
				$('#student_list').html('<tr><td colspan="13" style="text-align:center;">Record not found.</td></tr>');
			}
		},
	});
}


$(document).on('click','.view_details',function(){
	var adm_no = $(this).data('adm_no');
	$.ajax({
		type:'POST',
		url:baseUrl+'Student_ctrl/student_delinquents_details',
		data:{'adm_no':adm_no},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var win = window.open(baseUrl+userUrl+'/master-record/student-delinquents', "myWindowName", "scrollbars=1,width=1200, height=600");
				var x = '<link rel="stylesheet" type="text/css" href="'+ baseUrl +'assets/css/bootstrap.min.css">'+
				'<div class="modal-content p-head-sec" style="height:640px;">';
				x=x+'<table class="table">'+
					'<tbody>'+
						'<tr><td>Name: </td>'+
						'<td>'+response.student[0].name+'</td></tr>'+
						'<tr><td>Father\'s Name: </td>'+
						'<td>'+response.student[0].f_name+'</td></tr>'+
						'<tr><td>Contact Number: </td>'+
						'<td>'+response.student[0].contact_no+'</td></tr>'+
					'<tbody>'+
					'<table>';	

					x=x+'<div>Delinquents Details</div>'+
					'<table class="table"><thead><tr><th>Sr No.</th><th>Incident Remarks</th><th>Action Taken</th><th>Date of Incident</th><th>Warning Sl.</th></tr></thead><tbody>';
					$.each(response.data,function(key,value){
						x=x+'<tr>'+
							'<td>'+parseInt(key+1)+'</td>'+
							'<td>';
						$.each(value.delinquents,function(dkey,dval){
							x=x+'<p><b>'+parseInt(dkey+1)+')</b> '+dval.feedback+'</p>';
						});
						x=x+'</td><td>';
						$.each(value.action_taken,function(atKey,atVal){
							x=x+'<p><b>'+parseInt(atKey+1)+')</b> '+atVal.description+'</p>';
						});
						
						x=x+'</td>'+
							'<td>'+value.created_at+'</td>'+
							'<td>'+value.warning_no+'</td>'+
						'</tr>';
					});
					x=x+'</tbody></table>';
				with(win.document){open(); write(x);close();}
			}else{
				alert(response.msg);
			}
			
		},
	});
});


// function studentList(medium,class_name,section,search_box){
// 	$.ajax({
// 		type:'POST',
// 		url:baseUrl+'Student_ctrl/delinquents_report',
// 		data:{'medium':medium,'class_name':class_name,'section':section},
// 		dataType:'json',
// 		beforeSend:function(){},
// 		success:function(response){
// 			if(response.status == 200){
// 				var x='';
// 				$.each(response.data,function(key,value){
// 					x=x+'<tr>'+
// 						'<td>'+parseInt(key+1)+'</td>'+
// 						'<td>'+value.adm_no+'</td>'+
// 						'<td>'+value.name+'</td>'+
// 						'<td>'+value.class_name+'/'+value.section_name+'</td>'+
// 						'<td>'+value.f_name+'</td>'+
// 						'<td>'+value.contact_no+'</td>';
// 						var d = '';
// 						$.each(value.delinquents,function(k,delinqList){
// 							d=d+'<b> Warning: '+parseInt(k+1)+'</b><br/><b>Date of Incident:</b> '+delinqList.date+'<br/>';
// 							$.each(delinqList.data,function(f,fd){
// 								d=d+'<p><b>'+parseInt(f+1)+') </b>'+fd.feedback+'</p>';
// 							});
// 						});
// 						x=x+'<td>'+d+'</td>';
// 						'<td></td>'+
// 						'<td></td>'+
// 						'</tr>';
// 				});
// 				$('#student_list').html(x);
// 			}else{
// 				$('#student_list').html('<tr><td colspan="13" style="text-align:center;">Record not found.</td></tr>');
// 			}
// 		},
// 	});
// }

function printDiv(){
  var divToPrint=document.getElementById('DivIdToPrint');
  var newWin=window.open('','Print-Window');
  newWin.document.open();
  newWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="'+ baseUrl +'assets/css/custom-style.css"><link rel="stylesheet" type="text/css" href="'+ baseUrl +'assets/css/bootstrap.min.css"><style>.p-sibling-report table thead tr th{padding:3px !important;font-size:11px !important;background-color:#f3f3f3 !important;}'+
'.p-sibling-report table tbody tr td{padding:3px !important;font-size:11px !important;}</style></head><body onload="window.print()">'+
  '<div class="print-s-logo" style="float:left;padding:0px 0px 5px 0;width:100%;">'+
				'<div class="text-center" style="float:left;">'+
		'<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" height="40" />'+
		'<div class="print-s-name" >'+
			'<h4><b>Shakuntala Vidyalaya</b></h4>'+
			'<p>Ram Nagar Bhilai(C.G.)</p>'+
		'</div></div><div class="text-right">'+
					'<h4><b>Student Delinquents Report</b></h4>'+
				'</div></div>'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},10);
}

/*function printDiv() {
  window.print();
}*/

</script>