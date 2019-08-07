<style>
.skin-blue .main-header .navbar{padding:10px;}
.mb-3{margin-bottom:15px;}
</style>
<div class="content-wrapper">
<section class="content-header">
      <h1>Reception</h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/reception/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Student Fee Payment</li>
      </ol>
    </section>
    <section class="content-header">
    </section>
	<!-- main section -->
    <div class="col-md-12">	
      	<div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Student Details</h3>
            </div>
        	<div class="box-body form-horizontal">
        		<input type="hidden" id="ses_id" value="<?php echo $this->uri->segment(5);?>">
        		<input type="hidden" id="sch_id" value="<?php echo $this->uri->segment(6);?>">
        		<input type="hidden" id="med_id" value="<?php echo $this->uri->segment(7);?>">
        		<input type="hidden" id="adm_no" value="<?php echo $this->uri->segment(8);?>">
        		
        		<div id="student_details"></div>
        		
    		</div><!-- end box body -->
 		</div>	
	</div> 
	
	 <div class="col-md-12">	
      	<div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Once in a session</h3>
            </div>
        	<div class="box-body form-horizontal">
        		<div id="one_time_fee"></div>
        		
    		</div><!-- end box body -->
 		</div>	
	</div> 
	
	<div class="col-md-12">	
      	<div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Month Fee</h3>
            </div>
        	<div class="box-body form-horizontal">
        		<div id="month_fee"></div>
        		
    		</div><!-- end box body -->
 		</div>	
	</div>   			  			
</div>

<script type="text/javascript">
var baseUrl = $('#base_url').val();

var ses_id = $('#ses_id').val();
var sch_id = $('#sch_id').val();
var med_id = $('#med_id').val();
var adm_no = $('#adm_no').val();

feeDetailList();
function feeDetailList(){
	$.ajax({
		type:'POST',
		url:baseUrl+'Student_fee_ctrl/feeDetailList',
		data:{
			'ses_id':ses_id,
			'sch_id':sch_id,
			'med_id':med_id,
			'adm_no':adm_no
			},
		dataType:'json',
		beforeSend:function(){},
		success:function(response){
			var x='';
			if(response.status == 200){

//-----------------------------------student details----------------------
				x=x+'<table class="table">'+
						'<thead>'+
							'<tr>'+
								'<th>Admission No.</th>'+
								'<th>Name</th>'+
								'<th>Class</th>'+
								'<th>Student Status</th>'+
							'</tr>'+
						'</thead>'+
						'<tbody>'+
						'<tr>'+
    						'<td>'+response.data.student[0].adm_no+'</td>'+
    						'<td>'+response.data.student[0].name+'</td>'+
    						'<td>'+response.data.student[0].class_name+'</td>'+
    						'<td>'+response.data.student[0].std_status+'/'+response.data.student[0].fc_name+'</td>'+
    					'</tr>'+
						'</tbody>'+
				'</table>';
				$('#student_details').html(x);
				
//------------------------ones in session fee--------------------------------
				var f = '';
				var flag = 1;
				$.each(response.data.fee_structure,function(key,value){
					if(value.ft_id != 5){ // tution fee not show ones in session fee-------------
						if((response.data.student[0].std_status == 'old_student')){ // if old student then not show in admission fee
							if(value.ft_id != 1){
								f=f+'<input type="checkbox" id="">'+ value.name;
							}
						}else{
							//-------new student show admission fee------------
							f=f+'<input type="checkbox" id="">'+ value.name;
							}
					}
					
				});
				$('#one_time_fee').html(f);

//--------------month fee-----------------------------------
				var m ='<table class="table">'+
    					'<thead>'+
        					'<th>Fee Month</th>'+
        					'<th>Tution Fee</th>'
        					if(response.data.student[0].bus == "Yes"){
        						m=m+'<th>Bus Fee</th>';
            				}
        					m=m+'<th>Due Date</th>'+
        						'<th>Late Fee</th>'+
        						'<th>Total Fee</th>'+
        					'</thead>'+
    					'<tbody>';
				$.each(response.data.fee_month,function(key,value){
					m=m+'<tr>'+
						'<td>'+value.name+'</td>'+
						'<td><input type="checkbox"> '+value.fee.toFixed(2)+'</td>';
						if(response.data.student[0].bus == "Yes"){
							m=m+'<td><input type="checkbox"> '+value.bus_fee.toFixed(2)+'</td>';
						}
						m=m+'<td>'+value.due_date+'</td>'+
							'<td>'+value.late_fee.toFixed(2)+'</td>'+
							'<td></td>'+
						'</tr>';
				});
				m=m+'</tbody>'+
					'</table>';
				$('#month_fee').html(m);				
			}else{
					alert(response.msg);
			    }
		},
	});
}


</script>