<div class="content-wrapper">
    <section class="content-header">
      <h1>Generate<small>marksheet</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">production-report</li>
        <li class="active">generate-marksheet</li>
      </ol>
    </section>
    <script src="<?php echo base_url();?>assets/js/custom/mid_marksheet.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/js/custom/final_marksheet.js" type="text/javascript"></script>
    <!-- main section -->
        <div class="col-md-12">
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Search Records.</h3>
                </div>
            	<div class="box-body">
            	<form action="" method="POST" role="form" id="marksheet_form" class="form-horizontal">
            		<input type="hidden" name="id" id="id">
              			<div class="form-group">
							<div class="col-sm-2">
								<select name="session" id="session" class="form-control">
									<option value="">Select Session</option>
									<?php foreach($session as $ses){?>
									    <option value="<?php echo $ses['ses_id'];?>"<?php if($ses['ses_id'] == $this->session->userdata('session_id')){echo "selected"; } ?>><?php echo $ses['session_name'];?></option>
									<?php }?>
								</select>
								<div id="session_err" style="display:none; color:red;"></div>
							</div>
							
							<div class="col-sm-2">
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
										<option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
									<?php }?>
								</select>
								<div id="medium_err" style="display:none; color:red;"></div>
							</div>
							
							<div class="col-sm-2">
								<select name="class_name" id="class_name" class="form-control">
									<option value="">Select Class</option>
									<?php foreach($class as $cls){?>
										<option value="<?php echo $cls['c_id'];?>"><?php echo $cls['class_name'];?></option>
									<?php } ?>
								</select>
								<div id="class_name_err" style="display:none; color:red;"></div>
							</div>
							
							<div class="col-sm-2" id="sub_group_row" style="display:none;">
								<select name="sub_group" id="sub_group" class="form-control">
									<option value="">Select Subject Group</option>
									<?php foreach ($group as $sg){?>
										<option value="<?php echo $sg['sg_id'];?>"><?php echo $sg['sg_name'];?></option>
									<?php }?>
								</select>
								<div id="sub_group_err" style="display:none; color:red;"></div>
							</div>
							
							<div class="col-sm-2">
								<select id="section" name="section" class="form-control">
									<option value="">Select Section</option>
									<?php foreach ($section as $sec){?>
										<option value="<?php echo $sec['sec_id'];?>"><?php echo $sec['section_name'];?></option>
									<?php }?>
								</select>
								<div id="section_err" style="display:none; color:red;"></div>
							</div>
						</div>
							<div class="box-footer">
                          	<div class="col-sm-offset-9">
                          		<button type="button" name="search" id="search" class="btn btn-info">Search</button>
                          		<button type="button" data-std_id="" id="mid_marksheet" class="btn btn-info">Mid Marksheet</button>
                                <button type="button" data-std_id=""  id="final_marksheet" class="btn btn-info">Final Marksheet</button>
                            </div>
            			</div>
        			</form>
        		</div><!-- end box body -->
   			</div>
   		</div>
   		
   		<div class="col-md-12">	
          	<div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">List of Students Marksheet</h3>
                </div>
          		     <div class="box-body">
      					<table class="table table-responsive">
						<thead>
        					<tr>
                				<th>Sr No.</th>
                				<th>Student Name</th>
                				<th>Roll No</th>
                				<th>Admission No.</th>
                				<th>Mid Marksheet</th>
                				<th id="finalMS" style="display:none;">Final Marksheet</th>
        					</tr>
    					</thead>
						<tbody id="list_of_marksheet"></tbody>
					</table>
          		</div>
     		</div>
   		</div>		
</div>