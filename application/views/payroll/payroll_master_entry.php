<div class="content-wrapper container">
<section class="content-header" style="margin-bottom:10px;">
  <h1>Payroll Master Entry</h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo base_url().$this->uri->segment(1);?>/payroll/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
	<li class="active">Payroll Master Entry</li>
  </ol>
</section>

<!-- main section -->
<div class="col-md-12">	
		<div class="row">
		<form action="javascript:void(0);" id="payroll_master_form" role="form">
		<input type="hidden" id="m_id" value="<?php if(isset($master_data[0]['pm_id'])){echo $master_data[0]['pm_id'];}?>">
			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header">
					  <h3 class="box-title"><b>PF(Provident Fund) Above</b></h3>
					</div>
					<div class="box-body">
						<div class="form-group row">
							<label class="col-sm-3 control-label">Above Basic Salary<span style="color:red;">*</span></label>
							<div class="col-sm-9">
								<input value="" type="number" name="" id="" class="form-control only_text" placeholder="Type Amout" />
								<div id="" class="text-danger" style="display:none;"></div>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-sm-3 control-label">Samiti PF<span style="color:red;">*</span></label>
							<div class="col-sm-9">
							
								<input value="" type="number" name="samiti_pf" id="samiti_pf" class="form-control only_text" placeholder="Type Amout in %">
								<div id="samiti_pf_err" class="text-danger" style="display:none;"></div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label">Employee PF<span style="color:red;">*</span></label>
							<div class="col-sm-9">
							
								<input value="" type="number" name="emp_pf" id="emp_pf" class="form-control only_text" placeholder="Type Amout in %">
								<div id="emp_pf_err" class="text-danger" style="display:none;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="box box-success">
					<div class="box-header">
					  <h3 class="box-title"><b>ESIC(Employees State Insurance Corporation) Above</b></h3>
					</div>
					<div class="box-body">
						<div class="form-group row">
							<label class="col-sm-3 control-label">Above Basic Salary<span style="color:red;">*</span></label>
							<div class="col-sm-9">
								<input value="" type="number" name="" id="" class="form-control only_text" placeholder="Type Amout" />
								<div id="" class="text-danger" style="display:none;"></div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label">Samiti ESIC<span style="color:red;">*</span></label>
							<div class="col-sm-9">
							
								<input type="number" value="" name="samiti_esic" id="samiti_esic" class="form-control only_text" placeholder="Type Amout in %">
								<div id="samiti_esic_err" class="text-danger" style="display:none;"></div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label">Employee ESIC<span style="color:red;">*</span></label>
							<div class="col-sm-9">
							
								<input type="number" value="" name="emp_esic" id="emp_esic" class="form-control only_text" placeholder="Type Amout in %">
								<div id="emp_esic_err" class="text-danger" style="display:none;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header">
					  <h3 class="box-title"><b>PF(Provident Fund) Below</b></h3>
					</div>
					<div class="box-body">
						<div class="form-group row">
							<label class="col-sm-3 control-label">Below Basic Salary<span style="color:red;">*</span></label>
							<div class="col-sm-9">
								<input value="" type="number" name="" id="" class="form-control only_text" placeholder="Type Amout" />
								<div id="" class="text-danger" style="display:none;"></div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label">Samiti PF<span style="color:red;">*</span></label>
							<div class="col-sm-9">
							
								<input value="" type="number" name="samiti_pf" id="samiti_pf" class="form-control only_text" placeholder="Type Amout in %">
								<div id="samiti_pf_err" class="text-danger" style="display:none;"></div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label">Employee PF<span style="color:red;">*</span></label>
							<div class="col-sm-9">
							
								<input value="" type="number" name="emp_pf" id="emp_pf" class="form-control only_text" placeholder="Type Amout in %">
								<div id="emp_pf_err" class="text-danger" style="display:none;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="box box-success">
					<div class="box-header">
					  <h3 class="box-title"><b>ESIC(Employees State Insurance Corporation) Below</b></h3>
					</div>
					<div class="box-body">
						<div class="form-group row">
							<label class="col-sm-3 control-label">Below Basic Salary<span style="color:red;">*</span></label>
							<div class="col-sm-9">
								<input value="" type="number" name="" id="" class="form-control only_text" placeholder="Type Amout" />
								<div id="" class="text-danger" style="display:none;"></div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label">Samiti ESIC<span style="color:red;">*</span></label>
							<div class="col-sm-9">
							
								<input type="number" value="" name="samiti_esic" id="samiti_esic" class="form-control only_text" placeholder="Type Amout in %">
								<div id="samiti_esic_err" class="text-danger" style="display:none;"></div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label">Employee ESIC<span style="color:red;">*</span></label>
							<div class="col-sm-9">
							
								<input type="number" value="" name="emp_esic" id="emp_esic" class="form-control only_text" placeholder="Type Amout in %">
								<div id="emp_esic_err" class="text-danger" style="display:none;"></div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="col-md-12 text-center">
				<div class="box box-succes ">
					<button class="btn btn-space btn-success no-print" id="submit_master_record" style="margin:20px;">Submit</button>
				</div>
			</div>
			</form>
		</div>
		
	</div>
</div>
<script type="text/javascript">
var baseUrl = $('#base_url').val();

$('#payroll_master_form').validate({
	rules:{
		da_percentage:{required:true},
		pa_percentage:{required:true},
		samiti_pf:{required:true},
		emp_pf:{required:true},
		samiti_esic:{required:true},
		emp_esic:{required:true},
		samiti_t_ded:{required:true},
		emp_t_ded:{required:true}
	},
});

$(document).on('click','#submit_master_record',function(){
	var formvlidate = $('#payroll_master_form').valid();
	if(formvlidate){
		var formdata = new FormData();
			formdata.append('m_id',$('#m_id').val());
			formdata.append('da_percentage',$('#da_percentage').val());
			formdata.append('pa_percentage',$('#pa_percentage').val());
			formdata.append('samiti_pf',$('#samiti_pf').val());
			formdata.append('emp_pf',$('#emp_pf').val());
			formdata.append('samiti_esic',$('#samiti_esic').val());
			formdata.append('emp_esic',$('#emp_esic').val());
			formdata.append('samiti_t_ded',$('#samiti_t_ded').val());
			formdata.append('emp_t_ded',$('#emp_t_ded').val());

		$.ajax({
			type:'POST',
			url:baseUrl+'payroll/Payroll_ctrl/master_entry',
			data:formdata,
			dataType:'json',
			beforeSend:function(){},
			success:function(response){
				if(response.status == 200){
					alert(response.msg);
					location.reload();
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