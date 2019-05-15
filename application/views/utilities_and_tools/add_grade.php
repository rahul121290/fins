<div class="content-wrapper">
    <section class="content-header">
      <h1>Add Grade<small></small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashbord</a></li>
        <li class="">utilities & tools</li>
        <li class="active">add grade</li>
      </ol>
    </section>
	<script src="<?php echo base_url();?>assets/js/custom/add_grade.js"></script>
    <section class="content">
    	<div class="row">    	
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Perceintage Wise Add Grade</h3>
                </div>
            	<div class="box-body">
            		<form action="" role="form" method="POST" id="grade_form" class="form-horizontal">
            			<input type="hidden" name="id" id="id">	
              			<div class="form-group">
							<label class="control-label col-md-2">Medium</label>
							<div class="col-sm-8">
								<select name="medium" id="medium" class="form-control">
									<option value="">Select Medium</option>
									<?php foreach($medium as $med){?>
									<option value="<?php echo $med['med_id'];?>"><?php echo $med['med_name'];?></option>
									<?php }?>
								</select>
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Min & Max</label>
							<div class="col-sm-4">
								<input type="text" name="min_no" id="min_no" class="form-control" placeholder="min number">
							</div>
							<div class="col-sm-4">
								<input type="text" name="max_no" id="max_no" class="form-control" placeholder="max number">
							</div>
					    </div>
					    
					    <div class="form-group">
							<label class="control-label col-md-2">Grade</label>
							<div class="col-sm-8">
								<select name="grade" id="grade" class="form-control">
									<option value="">Select Grade</option>
									<option value="A1">A1</option>
									<option value="A2">A2</option>
									<option value="B1">B1</option>
									<option value="B2">B2</option>
									<option value="C1">C1</option>
									<option value="C2">C2</option>
									<option value="D">D</option>
									<option value="E (Need Improvement)">E (Need Improvement)</option>
								</select>
					    	</div>
					    </div>
					    
					        <div class="form-group">
							<label class="control-label col-md-2">Grade Point</label>
							<div class="col-sm-8">
								<select name="grade_point" id="grade_point" class="form-control">
									<option value="">Select Grade Point</option>
									<option value="10">10</option>
									<option value="9">9</option>
									<option value="8">8</option>
									<option value="7">7</option>
									<option value="6">6</option>
									<option value="5">5</option>
									<option value="4">4</option>
									<option value="-">-</option>
								</select>
					    	</div>
					    </div>
            
		  				<div class="box-footer">
                          	<div class="col-sm-offset-8">
                          		<button type="button" id="submit" class="btn btn-info hide update">Update</button>
                                <button type="button" id="submit" class="btn btn-info insert" disabled="disabled">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
        			   </div>
        			  </form>
        			</div><!-- end box body -->
     			</div>
   			</div>
   			
   			<div class="col-md-6">	
          		<div class="box box-info">
                	<div class="box-header">
                  		<h3 class="box-title">Grade List</h3>
                	</div>
          		    <div class="box-body">
      					<table class="table table-responsive">
						<thead>
        					<tr>
                				<th>Sr No.</th>
                				<th>Min Number</th>
                				<th>Max Number</th>
                				<th>Grade</th>
                				<th>Grade Point</th>
                				<th>Action</th>
        					</tr>
    					</thead>
						<tbody id="grade_list"></tbody>
					</table>
          		</div>
     		</div>
   		</div>		
	</div>
</section>	
</div>