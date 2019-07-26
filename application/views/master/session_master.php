<div class="content-wrapper">
    <section class="content-header">
      <h1>Session<small>master</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>admin/dashbord"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Session master</li>
      </ol>
    </section>
<script src="<?php echo base_url();?>assets/js/custom/session_master.js"></script>
    <!-- Main content -->
    <section class="content">
    	<div class="row">
    	<!-- <div class="row">
       		<div class="col-lg-6 col-lg-offset-3">
          		<div class="alert alert-dismissible" id="msgbox" style="display: none;">
        			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        			<p id="msg" style="text-align: center;"></p>
        		</div>
        	</div>
        </div> -->
        <div class="col-md-6">	
          	<div class="box box-danger">
                <div class="box-header">
                  <h3 class="box-title">Add Session</h3>
                </div>
            	<div class="box-body form-horizontal">
            		<input type="hidden" name="id" id="id">
              			<div class="form-group">
							<label class="control-label col-md-2">Session </label>
							<div class="col-sm-8">
								<input type="text" name="session_name" id="session_name" class="form-control" placeholder="Enter session">
								<div id="session_name_err" style="display:none; color:red;"></div>
							</div>
					    </div>
            
		  			<div class="box-footer">
                      	<div class="col-sm-offset-8">
                      		<button type="button" name="submit_session" id="submit_session" class="btn btn-info hide btn_update">Update</button>
                            <button type="button" name="submit_session" id="submit_session" class="btn btn-info btn_submit">Submit</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
        			</div>
        		</div><!-- end box body -->
     			</div>
   			</div>
   			
   		<div class="col-md-6">	
          	<div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Session List</h3>
                </div>
          		     <div class="box-body">
      					<table class="table table-responsive">
						<thead>
        					<tr>
                				<td>Sr No.</td>
                				<td>Session Name</td>
                				<td>Action</td>
        					</tr>
    					</thead>
						<tbody id="ses_list"></tbody>
					</table>
          		</div>
     		</div>
   		</div>
   			
    	<div class="col-md-6">
    		<div class="box box-primary">
            	<div class="box-header">
                      <h3 class="box-title">Set Session</h3>
                </div>
    			<div class="box-body">
    				<div class="form-group">
        				<div class="box-footer col-sm-offset-2">
        					<label id="set_ses"></label>
    					</div> 
    					       <!-- radio -->
              <div class="form-group">
        			</div>
    			</div>
    		</div>
    	</div>
		</div>
		
		</div>
	</section>	
</div>