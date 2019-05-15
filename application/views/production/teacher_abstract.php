<div class="content-wrapper">
    <section class="content-header">
      <h1>Teacher<small>Abstract</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
        <li class="">production-reports</li>
        <li class="active">teacher-abstract</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/teacher_abstract.js"></script>
    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Search Teacher Abstract</h3>
                </div>
            	<div class="box-body">
            		<?php echo form_open("",['class'=>'form-horizontal','id'=>"teacher_abstract_form",'role'=>"form"]);?>
					    <div class="form-group">
							<div class="col-sm-2">
								<select name="exam_type" id="exam_type" class="form-control">
									<option value="">Select Exam Type</option>
									<?php foreach($exam_type as $et){?>
										<option value="<?php echo $et['et_id'];?>"><?php echo $et['et_name'];?></option>
									<?php }?>
								</select>
							</div>
					    
							<div class="col-sm-2">
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
									<option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
									<?php }?>
								</select>
							</div>
							
							<div class="col-sm-2">
								<select name="teacher" id="teacher" class="form-control">
									<option value="">Select Teacher</option>
								</select>
							</div>
					    
                      	<div class="col-sm-2">
                            <button type="button" id="search" class="btn btn-info submit">Search</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
        			</div>
        			<?php echo form_close();?>
        			</div><!-- end box body -->
     			</div>
   			</div>
			
			<div class="col-md-12">	
              	<div class="box box-danger">
                    <div class="box-header">
                      <h3 class="box-title" id="t_name">Teacher Abstract</h3>
                    </div>
                    	<div class="box-body">
        					<table class="table table-striped table-bordered" style="text-align:center;">
        						<thead>
        							<tr>
        								<th>Sr. No</th>
        								<th>Class/ Section</th>
        								<th>Subject Name</th>
        								<th>Sub_group</th>
        								<th>Total Students</th>
        								<th>Total App.</th>
        								<th>Pass</th>
        								<th>Pass%</th>
        								<th>Ist Div.</th>
        								<th>Per(%)</th>
        								<th>IInd Div.</th>
        								<th>III rd Div.</th>
        								<th>Fail</th>
        								<th style="width:130px;">Highest Marks/ No. of Student</th>
        								<th>P.I.</th>
        							</tr>
        						</thead>
        						<tbody id="list_of_teacher_abstract"></tbody>
        					</table>					    
                		</div>
                	</div><!-- end box body -->
         		</div>
   			</div>
	</section>	
</div>