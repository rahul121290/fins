<div class="content-wrapper">
<section class="content-header">
      <h1>Employee Salary <small>Generate</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url().$this->uri->segment(1);?>/payroll/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Employee Salary</li>
      </ol>
    </section>
    <input type="hidden" id="month" value="<?php echo $this->uri->segment(5);?>">
    <input type="hidden" id="emp_id" value="<?php echo $this->uri->segment(6);?>">
    <input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    <div class="col-md-6">
	<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Employee Details</h3>
			</div>
			
			<div class="box-body">
					<table class="table">
						<tbody>
						<tr>
						<td><b>Employee Name</b></td><td>: <?php echo ucfirst($emp_details[0]['emp_name']);?></td>
						<td><b>F/H Name</b></td><td>: <?php echo ucfirst($emp_details[0]['f_or_h_name']);?></td>
						</tr>
						<tr>
						<td><b>Employeee ID</b></td><td>: <?php echo $emp_details[0]['emp_generated_id'];?></td>
						<td><b>Employee Type</b></td><td>: <?php echo $emp_details[0]['emp_type'] .' / '.$emp_details[0]['sub_type_name'];?></td>
						</tr>
						<tr>
						<td><b>POST</b></td><td>: <?php echo $emp_details[0]['post_name'];?></td>
						<td><b>Contact No.</b></td><td>: <?php echo $emp_details[0]['phone_no'];?></td>
						</tr>
						</tbody>
					</table>
				
			</div>
		</div>
</div>
<div class="col-md-6">
	<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Employee Previous Detail</h3>
			</div>
			<div class="box-body">
						<table class="table">
						<tbody>
						<tr>
						<td><b>Month</b></td><td>: <?php echo date('F');?></td>
						<td><b>Month Days</b></td><td>: <?php echo date('t');?></td>
						</tr>
						<tr>
						<td><b>Entry No</b></td><td>: <?php echo $receipt_no;?></td>
						<td><b>Daily Wage</b></td><td>: <?php echo round($emp_details[0]['basic_salary'] / date('t'),2);?></td>
						</tr>
						<tr>
						<td><b>Entry Date</b></td><td>: <?php echo date('d-M-Y');?></td>
						</tr>
						</tbody>
					</table>
			</div>
		</div>
</div>
<?php 
    //---------------net basic------------------------------
    $one_day_salary = $emp_details[0]['basic_salary'] / date('t');
    $leave_salary = $emp_details[0]['absent'] * $one_day_salary;
    $net_basic = round($emp_details[0]['basic_salary'] - $leave_salary);
	 
	//--------------------gross basic------------------------
    $da_amount = (($emp_details[0]['basic_salary'] * $emp_details[0]['da_percentange']) /100);
    $da_amount = round($da_amount);
	$gross_basic = round($net_basic + $da_amount);
	$emp_pf = 0;
	$samiti_pf = 0;
	   if($gross_basic >= 15000){
	       $emp_pf = 1800;
	       $samiti_pf = 1800;
	   }else if($gross_basic < 15000){
	       $emp_pf = round(($gross_basic * 12)/100);
	       $samiti_pf = round(($gross_basic * 12)/100);
	   }
    $gross_salary = $gross_basic + $emp_details[0]['pa_amount'];
	 
	//----------------net salary-------------------------------
	$samiti_esic = 0;
	$emp_esic = 0;
	if($gross_salary >= 21000){
	   $samiti_esic = 0;
	   $emp_esic = 0;
	}else if($gross_salary < 21000){
	   $samiti_esic = round(($gross_salary * 3.25) / 100);
	   $emp_esic = round(($gross_salary * 0.75) / 100);
	} 
	$emp_t_ded = $emp_pf + $emp_esic;
	$samiti_t_ded = $samiti_pf + $samiti_esic;
	$net_salary = round($gross_salary - ($emp_t_ded + $emp_details[0]['advance_amount']));
?>   
 <form role="form" action="javascript:void(0);" class="form-horizontal" id="hostel_fee_form" method="POST">
    <div class="col-md-12">
	<div class="box box-primary" style="position: relative; left: 0px; top: 0px;">		
			<div class="box-header ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Salary Generate</h3><hr></div>
			<div class="box-body">
				<table class="table">
					<thead>
						<tr>
    						<th>Basic</th>
    						<th>Absent</th>
    						<th>Net Basic</th>
    						<th>DA (%)</th>
    						<th>DA</th>
    						<th>Gross Basic</th>
    						<th>PF (S)</th>
    						<th>PF (E)</th>
    						<th>PA</th>
    						<th>Gross Salary</th>
    						<th>ESIC (S)</th>
    						<th>ESIC (E)</th>
    						<th>Advance</th>
    						<th>T. Ded (S)</th>
    						<th>T. Ded (E)</th>
    						<th>TDS</th>
    						<th>Net Salary</th>
						</tr>
					</thead>
					<tbody id="">
						<tr>
							<td><?php echo round($emp_details[0]['basic_salary']);?></td>
							<td><?php echo $emp_details[0]['absent'];?></td>
							<td><?php echo $net_basic;?></td>
							<td><?php echo $emp_details[0]['da_percentange'];?>%</td>
							<td><?php echo $da_amount;?></td>
							<td><?php echo $gross_basic;?></td>
							<td><?php echo $samiti_pf;?></td>
							<td><?php echo $emp_pf;?></td>
							<td><?php echo $emp_details[0]['pa_amount'];?></td>
							<td><?php echo $gross_salary;?></td>
							<td><?php echo $samiti_esic;?></td>
							<td><?php echo $emp_esic;?></td>
							<td><?php echo $emp_details[0]['advance_amount'];?></td>
							<td><?php echo $samiti_t_ded;?></td>
							<td><?php echo $emp_t_ded;?></td>
							<td><input type="text" id="tds" name="tds"></td>
							<td><span id="show_net_salary"><?php echo $net_salary;?></span></td>
						</tr>
					</tbody>
				</table>
				<hr>
				
				<div class="form-group">
						<div class="col-sm-6">
							<textarea rows="" cols="" id="remark" name="remark" class="form-control" placeholder="Remark"></textarea>
						</div>
				</div>
				
				<div class="form-group">
						<div class="col-sm-3">
							<select id="pay_mode" name="pay_mode" class="form-control">
								<option value="">Select Payment Mode</option>
								<option value="cash">Cash</option>
								<option value="cheque">Cheque</option>
								<option value="bank">Bank</option>
							</select>
							<div id="pay_mode_err" class="error" style="display: none;"></div>
						</div>
				</div>
				
				<div class="box-footer">
                  	<div class="col-md-12 text-center">
                        <button type="button" id="generate_salary" class="btn btn-info btn-space">Submit</button>
                    </div>
            	</div>
			</div>
		</div>
	</div>
	
	<input type="hidden" id="receipt_no" name="receipt_no" value="<?php echo $receipt_no;?>"/>
	<input type="hidden" id="ses_id" name="ses_id" value="<?php echo $emp_details[0]['ses_id'];?>"/>
	<input type="hidden" id="sch_id" name="sch_id" value="<?php echo $emp_details[0]['sch_id'];?>"/>
	<input type="hidden" id="emp_type" name="emp_type" value="<?php echo $emp_details[0]['emp_type'];?>"/>
	<input type="hidden" id="emp_sub_type" name="emp_sub_type" value="<?php echo $emp_details[0]['sub_type_name'];?>"/>
	
	<input type="hidden" id="month_id" name="month_id" value="<?php echo $this->uri->segment(5);?>"/>
	
	<input type="hidden" id="emp_id" name="emp_id" value="<?php echo $emp_details[0]['emp_id'];?>"/>
	<input type="hidden" id="emp_name" name="emp_name" value="<?php echo $emp_details[0]['emp_name'];?>"/>
	<input type="hidden" id="post_name" name="post_name" value="<?php echo $emp_details[0]['post_name'];?>"/>
	
	<input type="hidden" id="basic_salary" name="basic_salary" value="<?php echo round($emp_details[0]['basic_salary']);?>"/>
	<input type="hidden" id="absent" name="absent" value="<?php echo round($emp_details[0]['absent']);?>"/>
	<input type="hidden" id="net_basic" name="net_basic" value="<?php echo $net_basic;?>"/>
	<input type="hidden" id="da_percentange" name="da_percentange" value="<?php echo $emp_details[0]['da_percentange'];?>"/>
	<input type="hidden" id="da_amount" name="da_amount" value="<?php echo $da_amount;?>"/>
	<input type="hidden" id="gross_basic" name="gross_basic" value="<?php echo $gross_basic;?>"/>
	<input type="hidden" id="samiti_pf" name="samiti_pf" value="<?php echo $samiti_pf;?>"/>
	<input type="hidden" id="emp_pf" name="emp_pf" value="<?php echo $emp_pf;?>"/>
	
	<input type="hidden" id="pa_amount" name="pa_amount" value="<?php echo $emp_details[0]['pa_amount'];?>"/>
	
	<input type="hidden" id="gross_salary" name="gross_salary" value="<?php echo $gross_salary;?>"/>
	<input type="hidden" id="samiti_esic" name="samiti_esic" value="<?php echo $samiti_esic;?>"/>
	<input type="hidden" id="emp_esic" name="emp_esic" value="<?php echo $emp_esic;?>"/>
	<input type="hidden" id="advance_amount" name="advance_amount" value="<?php echo round($emp_details[0]['advance_amount']);?>"/>
	<input type="hidden" id="samiti_t_ded" name="samiti_t_ded" value="<?php echo $samiti_t_ded;?>"/>
	<input type="hidden" id="emp_t_ded" name="emp_t_ded" value="<?php echo $emp_t_ded;?>"/>
	<input type="hidden" id="net_salary" name="net_salary" value="<?php echo $net_salary;?>"/>
  </form>
</div>

<script type="text/javascript">
var baseUrl = $('#base_url').val();

$(document).on('keyup','#tds',function(){
	var tds_amount = $(this).val();
	if(tds_amount == ''){
		tds_amount = 0;
	}
	var advance_amount = $('#advance_amount').val();
	var emp_t_ded = $('#emp_t_ded').val();

	var total_ded = parseFloat(parseFloat(tds_amount) + parseFloat(advance_amount) + parseFloat(emp_t_ded));
	var net_salary =  parseFloat(parseFloat($('#gross_salary').val()) - parseFloat(total_ded));

	$('#show_net_salary').html(net_salary);
	$('#net_salary').val(net_salary);
	
});


$(document).on('click','#generate_salary',function(){
	var receipt_no = $('#receipt_no').val();

	var ses_id = $('#ses_id').val();
	var sch_id = $('#sch_id').val();
	var emp_type = $('#emp_type').val();
	var emp_sub_type = $('#emp_sub_type').val();
	
	var month_id = $('#month_id').val();
	var emp_id = $('#emp_id').val();
	var emp_name = $('#emp_name').val();
	var post_name = $('#post_name').val();
	
	var basic_salary = $('#basic_salary').val();
	var absent = $('#absent').val();
	var net_basic = $('#net_basic').val();
	var da_percentange = $('#da_percentange').val();
	var da_amount = $('#da_amount').val();
	var gross_basic = $('#gross_basic').val();
	var samiti_pf = $('#samiti_pf').val();
	var emp_pf = $('#emp_pf').val();
	var pa_amount = $('#pa_amount').val();
	var gross_salary = $('#gross_salary').val();
	var samiti_esic = $('#samiti_esic').val();
	var emp_esic = $('#emp_esic').val();
	var advance_amount = $('#advance_amount').val();
	var samiti_t_ded = $('#samiti_t_ded').val();
	var emp_t_ded = $('#emp_t_ded').val();
	var net_salary = $('#net_salary').val();
	var tds = $('#tds').val();
	var remark = $('#remark').val();
	var pay_mode = $('#pay_mode').val();
	var formvalid = true;

	if(pay_mode == ''){
		$('#pay_mode_err').html('This is Required.').css('display','block');
		formvalid = false;
	}else{
		$('#pay_mode_err').css('display','none');
	}

	if(formvalid == true){
		var formdata = new FormData();
		formdata.append('receipt_no',receipt_no);

		formdata.append('ses_id',ses_id);
		formdata.append('sch_id',sch_id);
		formdata.append('emp_type',emp_type);
		formdata.append('emp_sub_type',emp_sub_type);
		
		formdata.append('month_id',month_id);
		formdata.append('emp_id',emp_id);
		formdata.append('emp_name',emp_name);
		formdata.append('post',post_name);
		formdata.append('basic_salary',basic_salary);
		formdata.append('absent',absent);
		formdata.append('net_basic',net_basic);
		formdata.append('da_percentage',da_percentange);
		formdata.append('da_amount',da_amount);
		formdata.append('gross_basic',gross_basic);
		formdata.append('samiti_pf',samiti_pf);
		formdata.append('emp_pf',emp_pf);
		formdata.append('pa_amount',pa_amount);
		formdata.append('gross_salary',gross_salary);
		formdata.append('samiti_esic',samiti_esic);
		formdata.append('emp_esic',emp_esic);
		formdata.append('advance_amount',advance_amount);
		formdata.append('samiti_t_ded',samiti_t_ded);
		formdata.append('emp_t_ded',emp_t_ded);
		formdata.append('net_salary',net_salary);
		formdata.append('tds',tds);
		formdata.append('remark',remark);
		formdata.append('pay_mode',pay_mode);
		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/generate_salary',
			data:formdata,
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					alert(response.msg);
					window.close();
				}else{
					alert(response.msg);
				}
			},
			cache:false,
			processData:false,
			contentType:false
		});
		
	}
	
	
	
});

</script>

