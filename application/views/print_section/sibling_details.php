<style>
.skin-blue .main-header .navbar{padding:10px;}
.mb-3{margin-bottom:15px;}
</style>
<div class="content-wrapper">
<section class="content-header">
      <h1>Update Student Record</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/reception/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Update Student Record</li>
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
        	<form id="print_report_form" action="javascript:void(0);" method="POST" role="form">
        	
        	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
        	
          			<div class="form-group" style="margin-bottom:0px;">
          			
          			<div class="col-sm-2 mb-3" >
							<select name="sibling" id="sibling" class="form-control">
								<option value="2">Sibling</option>
							</select>
							<div id="medium_err" style="display:none; color:red;"></div>
						</div>
						
						<div class="col-sm-2 mb-3">
							<select name="school" id="school" class="form-control">
							<?php if($this->session->userdata('user_id') == 1){?>
								<option value="">Select Board</option>
								<option value="1" selected>CBSE</option>
								<option value="3">CG State Board</option>
								<?php }else{ ?>
								<option value="2">Sharda</option>
								<?php }?>
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
			<div class="box box-info">
                <div class="box-header no-print">
                  <h3 class="box-title">Search Results</h3>
                </div>
          		     <div class="box-body" id="DivIdToPrint">
      					<table class="table table-responsive">
							<thead><tr>
							<th>S.No.</th>
                              <th>Admission No.</th>
                              <th>Board</th>
                              <th>Class/ Section</th>
                              <th>Student Name</th>
							  <th>Father Name</th>
                              <th>Fee Criteria</th>
                             
                              <th>Rel Admission No.</th>
                              <th>Board</th>
                              <th>Class/ Section</th>
                              <th>Student Name</th>
							  <th>Father Name</th>
                              <th>Fee Criteria</th>
                             
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

$('#print_report_form').validate({
	rules:{
		school:{required:true},
// 		medium:{required:true},
// 		class_name:{required:true},
// 		section:{required:true}
	},
});

$(document).on('click','#search',function(){
	var formvalidate = $('#print_report_form').valid();
	var sibling = $('#sibling').val();
	var school = $('#school').val();
	var medium = $('#medium').val();
	var class_name = $('#class_name').val();
	var section = $('#section').val();
	var search_box = '';
	if(formvalidate){
		studentList(sibling,school,medium,class_name,section,search_box);
	}
});

function studentList(sibling,school,medium,class_name,section,search_box){
	$.ajax({
		type:'POST',
		url:baseUrl+'Student_ctrl/print_record',
		data:{'sibling':sibling,'school':school,'medium':medium,'class_name':class_name,'section':section},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			if(response.status == 200){
				var x='';
				$.each(response.data,function(key,value){
					
					x=x+'<tr>'+
						'<td>'+parseInt(key+1)+'.</td>'+
						'<td>'+value.adm_no+'</td>'+
						'<td>'+value.school_name+'</td>'+
						'<td>'+value.class_name+'/'+value.section_name+'</td>'+
						'<td>'+value.name+'</br>'+value.contact_no+'</td>'+
						'<td>'+value.f_name+'</td>'+
						'<td>'+value.fc_name+'</td>'+
						
						'<td>'+value.related_adm_no+'</td>'+
						'<td>'+value.related_school_name+'</td>'+
						'<td>'+value.related_class_name+'/'+value.related_section_name+'</td>'+
						'<td>'+value.related_name+'</br>'+value.related_contact_no+'</td>'+
						'<td>'+value.related_f_name+'</td>'+
						'<td>'+value.related_fc_name+'</td>'+
						'</tr>';
				});
				$('#student_list').html(x);
			}else{
				$('#student_list').html('<tr><td colspan="13" style="text-align:center;">Record not found.</td></tr>');
			}
		},
	});
}

function printDiv(){
  var divToPrint=document.getElementById('DivIdToPrint');
  var newWin=window.open('','Print-Window');
  newWin.document.open();
  newWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="'+ baseUrl +'assets/css/bootstrap.min.css"></head><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},10);
}

</script>