<div class="content-wrapper">
    <section class="content-header">
      <h1>Students Marks<small>entry</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="">transaction-record</li>
        <li class="active">marks-entry</li>
      </ol>
    </section>
    <script src="<?php echo base_url();?>assets/js/custom/marks_entry.js"></script>
    <!-- Main content -->
    <section class="content">
    	<!-- <div class="box box-primary" style="position: relative; left: 0px; top: 0px; display: none;" id="file_import">
			<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
			  <h3 class="box-title">Csv Import</h3><input type="button" id="download_format" value="Download Sample File" class="btn btn-sm pull-right">
			  <div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
			  	<i class="fa fa-minus"></i></button>
			  </div>
			</div>
    		<div class="form-horizontal">
        		<div class="col-sm-offset-2 col-sm-3">
        			<input type="file" id="marks_csv" name="marks_csv" class="form-control">
        			<div id="marks_csv_err" style="display:none;color:red;"></div>
        		</div>
        		
            	<div class="col-sm-offset-8">
                	<button type="button" id="marks_csv_submit" class="btn btn-info">Import CSV</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                </div>
    		</div><br>
    	</div> -->
    
    	<div class="row">
        <div class="col-md-5">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Studnets Marks Entry</h3>
                </div>
            	<div class="box-body">
            	<form role="form" method="POST" class="form-horizontal" id="marks_entry_form">
            		<input type="hidden" name="id" id="id">
            			
            			<div class="form-group">
							<label class="control-label col-md-2">Exam Type</label>
							<div class="col-sm-9">
								<select name="exam_type" id="exam_type" class="form-control">
									<option value="">Select Exam Type</option>
									<?php foreach($exam_type as $et){?>
									<option value="<?php echo $et['et_id'];?>"><?php echo $et['et_name'];?></option>
									<?php }?>
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
                  			<div class="col-sm-offset-8">
                        		<button type="button" id="search" class="btn btn-info">Search Students</button>
                    		</div>
                		</div>	
        			</form>
        		</div><!-- end box body -->
     			</div>
   			</div>
       		<div class="col-md-7">	
              	<div class="box box-info">
                    <div class="box-header">
                      <h3 class="box-title">Marks Entry <span id="type_and_sub"></span></h3>
                      <div id="subject_msg"></div>
                      <div id="practical_msg"></div>
                      <div id="notebook_msg"></div>
                      <div id="enrichment_msg"></div>
                      <div id="acadmic_msg"></div>
                    </div>
              		     <div class="box-body">
          					<table class="table table-responsive">
    						<thead>
            					<tr>
                    				<th>Sr No.</th>
                    				<th>Student Name</th>
                    				<th>Class/ Section</th>
                    				<th>Admission No</th>
                    				<th>Roll No</th>
                    				<th style="width: 50px;">Subject Marks</th>
                    				<th id="notebook" style="display:none;">Notebook</th>
                    				<th id="enrichment" style="display:none;width: 50px;">Subject Enrichment</th>
                    				<th id="practical" style="display:none;">Practical</th>
                    				<th id="academic" style="display:none;">Academic</th>
            					</tr>
        					</thead>
    						<tbody id="list_of_students"></tbody>
    					</table>
              		</div>
                  	<div class="box-footer">
                  	<div class="col-sm-offset-8">
                        <button type="button" id="marks_submit" class="btn btn-info" style="display:none;" disabled>Submit</button>
                    </div>
                	</div>
         		</div>
       		</div>
		</div>
	</section>	
</div>