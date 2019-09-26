<div class="content-wrapper">
<section class="content-header" style="margin-bottom:10px;">
      <h1>Salary Data Sheet</h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/payroll/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Salary Data Sheet</li>
      </ol>
    </section>

<!-- main section -->
<div class="col-md-12">	
  	<div class="box box-danger no-print">
        <div class="box-header">
          <h3 class="box-title">Employee List Filter</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<form id="salary_data_sheet" action="javascript:void(0);" method="POST" role="form">
    	
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    	
      			<div class="form-group" style="margin-bottom:0px;">
      				<div class="col-sm-2 mb-3">
						<select name="session" id="session" class="form-control">
							<option value="3" selected>2019-20</option>
						</select>
						<div id="session_err" style="display:none; color:red;"></div>
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
						<select name="month" id="month" class="form-control">
							<option value="">Select Month</option>
							<?php foreach($month as $months){?>
								<option value="<?php echo $months['m_id'];?>" <?php if($months['m_id'] == (int)date('m')){echo "selected";}?> ><?php echo $months['m_name'];?></option>
							<?php } ?>
						</select>
						<div id="month_err" style="display:none; color:red;"></div>
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
						<select name="emp_sub_type" id="emp_sub_type" class="form-control">
							<option value="">Select Sub Type</option>
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
					<?php if($this->session->userdata('school_id') == 1){ $school = 'shakuntala';?>
		<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" height="40" />
		<div class="print-s-name" >
			<h4><b>Shakuntala Vidyalaya</b></h4>
			<p>Ram Nagar Bhilai(C.G.)</p>
		</div>
      	<?php } else if($this->session->userdata('school_id') == 2){ $school = 'sharda';?>
      	<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/sharda/sharda_logo.png" height="40" />
		<div class="print-s-name" >
			<h4><b>Sharda Vidyalaya</b></h4>
			<p>Risali Bhilai(C.G.)</p>
		</div>
		<?php }else{ $school = 'cg-board';?>
		<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" height="40" />
		<div class="print-s-name" >
			<h4><b>Shakuntala Vidyalaya No. 2</b></h4>
			<p>Ram Nagar Bhilai(C.G.)</p>
		</div>
		<?php }?>
				</div>
				<div class="text-right">
					<h4 style="margin-bottom:0px;"><b>Shakuntala Vidyalaya (CBSE) Teacher Salary Data Sheet - September Month</b></h4>
				</div>
		</div>
		
	
		<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title"><b>Shakuntala Vidyalaya (CBSE) Salary Data Sheet - September 2019-20</b></h3>
            </div>
      		<div class="box-body table-responsive p-sibling-report" id="DivIdToPrint">
				<table class="table">
					<thead><tr>
					<th>S.No.</th>
					<th>Employee Name</th>
					<th>Employee ID</th>
					<th>Post</th>
					<th>Basic</th>
					<th>Abs</th>
					<th>DA%</th>
					<th>DA</th>
					<th>Gross Basic</th>
					<th>PF(S)</th>
					<th>PF(E)</th>
					<th>PA</th>
					<th>Gross Salary</th>
					<th>ESIC(S)</th>
					<th>ESIC(E)</th>
					<th>Adva</th>
					<th>T.Ded(E)</th>
					<th>T.Ded(S)</th>
					<th>TDS</th>
					<th>Net Salary</th>
					<th></th>
					</tr>
					</thead>
					<tbody id="salary_date_list"></tbody>
				</table>
      		</div>
 		</div>
 		</div>
		<div class="">
			<div class="text-center"><button class="btn btn-space btn-primary no-print" style="margin-bottom:50px;" onclick="printDiv()">Print this page</button></div>
		</div>
		
	</div>
</div>
<script type="text/javascript">
var baseUrl = $('#base_url').val();

$('#salary_data_sheet').validate({
	rules:{
		session:{required:true},
		school:{required:true},
		month:{required:true},
		//emp_type:{required:true},
		//emp_sub_type:{required:true}
	},
});

$(document).on('click','#search',function(){
	var formvalid = $('#salary_data_sheet').valid();
	var session = $('#session').val();
	var school = $('#school').val();
	var month = $('#month').val();
	var emp_type = $('#emp_type').val();
	var emp_sub_type = $('#emp_sub_type').val();

	if(formvalid){
		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/salary_data_sheet',
			data:{
				'session':session,
				'school':school,
				'month':month,
				'emp_type':emp_type,
				'emp_sub_type':emp_sub_type
			},
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
						'<td>'+value.post+'</td>'+
						'<td>'+value.basic_salary+'</td>'+
						'<td>'+value.absent+'</td>'+
						'<td>'+value.da_percentage+'</td>'+
						'<td>'+value.da_amount+'</td>'+
						'<td>'+value.gross_basic+'</td>'+
						'<td>'+value.emp_pf+'</td>'+
						'<td>'+value.samiti_pf+'</td>'+
						'<td>'+value.pa_amount+'</td>'+
						'<td>'+value.gross_salary+'</td>'+
						'<td>'+value.samiti_esic+'</td>'+
						'<td>'+value.emp_esic+'</td>'+
						'<td>'+value.advance_amount+'</td>'+
						'<td>'+value.emp_t_ded+'</td>'+
						'<td>'+value.samiti_t_ded+'</td>'+
						'<td>'+value.tds+'</td>'+
						'<td>'+value.net_salary+'</td>'+
						
					'<tr>';
					});
					$('#salary_date_list').html(x);
				}else{
					$('#salary_date_list').html('<tr><td colspan="" class="text-center;">Record not found.</td></tr>');
				}
			},
		});
	}
});

//----------------*****----------------------------
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


function printDiv(){
	  var divToPrint=document.getElementById('DivIdToPrint');
	  var newWin=window.open('','Print-Window');
	  newWin.document.open();
	  newWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="'+ baseUrl +'assets/css/bootstrap.min.css"><link rel="stylesheet" type="text/css" href="'+ baseUrl +'assets/css/custom-style.css"><style>#in {display:none} .p-sibling-report table thead tr th{padding:3px !important;font-size:11px !important;background-color:#f3f3f3 !important;}'+
'.p-sibling-report table tbody tr td{padding:3px !important;font-size:11px !important;}</style><body   onload="window.print()"><div class="print-s-logo" style="float:left;padding:0px 0px 5px 0;width:100%;">'+
				'<div class="text-center" style="float:left;">'+
		'<img class="pull-left" alt="" src="<?php echo base_url()?>assets/images/shakuntala/shakuntala.png" height="40" />'+
		'<div class="print-s-name" >'+
			'<h4><b>Shakuntala Vidyalaya</b></h4>'+
			'<p>Ram Nagar Bhilai(C.G.)</p>'+
		'</div></div><div class="text-right">'+
					'<h4><b>Shakuntala Vidyalaya (CBSE) Salary Data Sheet - September 2019-20</b></h4>'+
				'</div></div>'+divToPrint.innerHTML+'</body></html>');
	  newWin.document.close();
	  setTimeout(function(){newWin.close();},10);
	}
</script>