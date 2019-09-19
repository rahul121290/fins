<div class="content-wrapper">
    <section class="content-header">
      <h1>Students Compartment Marks<small>Entry</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="">Transaction Record</li>
        <li class="active">Marks Entry</li>
      </ol>
    </section>
    <script src="<?php echo base_url();?>assets/js/custom/compartment_marks_entry.js"></script>
    <!-- Main content -->
    <section class="content">
    	<div class="row">
        <div class="col-md-5">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Studnets Compartment Marks Entry</h3>
                </div>
            	<div class="box-body">
            	<form role="form" method="POST" class="form-horizontal" id="compartment_marks_entry_form">
            		<input type="hidden" name="id" id="id">
            			
            			<div class="form-group">
							<label class="control-label col-md-2">Exam Type</label>
							<div class="col-sm-9">
								<select name="exam_type" id="exam_type" class="form-control">
									<option value="">Select Exam Type</option>
									<option value="<?php echo $exam_type[3]['et_id'];?>"><?php echo $exam_type[3]['et_name'];?></option>
								</select>
								<div id="exam_type_err" style="display:none; color:red;"></div>
							</div>
					    </div>
            		
              			<div class="form-group">
							<label class="control-label col-md-2">Medium</label>
							<div class="col-sm-9">
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
										<option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
									<?php } ?>
								</select>
								<div id="medium_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Class</label>
							<div class="col-sm-9">
								<select name="class_name" id="class_name" class="form-control">
									<option value="">Select Class</option>
									<?php foreach($class as $classes){?>
									<option value="<?php echo $classes['c_id'];?>"><?php echo $classes['class_name'];?></option>
									<?php } ?>
								</select>
								<div id="class_name_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group" id="sub_group_row" style="display:none;">
							<label class="control-label col-md-2">Sub Group</label>
							<div class="col-sm-9">
								<select name="sub_group" id="sub_group" class="form-control">
									<option value="">Select Subject Group</option>
								</select>
								<div id="sub_group_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Section</label>
							<div class="col-sm-9">
								<select name="section" id="section" class="form-control">
									<option value="">Select Section</option>
								</select>
								<div id="section_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Sub Type</label>
							<div class="col-sm-9">
								<select name="sub_type" id="sub_type" class="form-control">
									<option value="">Select Subject Type</option>
								</select>
								<div id="sub_type_err" style="display:none; color:red;"></div>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Subject</label>
							<div class="col-sm-9">
								<select name="subject" id="subject" class="form-control">
								<option value="">Select Subject</option>	
								</select>
								<div id="subject_err" style="display:none; color:red;"></div>
							</div>
					    </div>
						<div class="box-footer">
                  			<div class="text-center">
                        		<button type="button" id="search" class="btn btn-info btn-space">Search Students</button>
                    		</div>
                		</div>	
        			</form>
        		</div><!-- end box body -->
     			</div>
   			</div>
       		<div class="col-md-7">	
              	<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">Compartment Marks Entry <span id="type_and_sub"></span></h3>
                      <div id="subject_msg"></div>
                      <div id="practical_msg"></div>
                      <div id="notebook_msg"></div>
                      
                      <div id="portfolio_msg"></div>
                      <div id="multiple_assessment_msg"></div>
                      
                      <div id="enrichment_msg"></div>
                      <div id="acadmic_msg"></div>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    						<thead>
            					<tr>
                    				<th>S.No.</th>
                    				<th>Student Name</th>
                    				<th>Class/Section</th>
                    				<th>Admission No.</th>
                    				<th>Roll No.</th>
                    				<th style="width: 50px;">Subject Marks</th>
                    				<th id="practical" style="display:none;">Practical</th>
            					</tr>
        					</thead>
    						<tbody id="student_list"></tbody>
    					</table>
              		</div>
                  	<div class="box-footer">
                      	<div class="text-center">
                            <button type="button" id="marks_submit" class="btn btn-info btn-space" style="display:none;" disabled>Submit</button>
                        </div>
                	</div>
         		</div>
       		</div>
		</div>
	</section>	
</div>