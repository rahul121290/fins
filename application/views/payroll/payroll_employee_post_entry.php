<div class="content-wrapper">
<section class="content-header" style="margin-bottom:10px;">
      <h1>Employee Post Entry</h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url();?>shakuntala/payroll/dashbord"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Employee Post Entry</li>
      </ol>
    </section>

<!-- main section -->
<div class="col-md-6">	
  	<div class="box box-danger no-print">
        <div class="box-header">
          <h3 class="box-title">Add New Post</h3>
        </div>
    	<div class="box-body form-horizontal">
    	<form id="hostel_mis_form" action="javascript:void(0);" method="POST" role="form">
    	
    	<input type="hidden" id="user_url" value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2);?>">
    	
      			<div class="form-group" style="margin-bottom:0px;">
      				<div class="form-group">
						<label class="col-sm-3 control-label">Post:</label>
						<div class="col-sm-8">
							<input type="text" name="" id="" class="form-control only_text" placeholder="Type Post">
							<div id="" class="text-danger" style="display:none;"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"></label>
						<div class="col-sm-8">
							<button type="button" id="" class="btn btn-info pull-right">Submit</button>	
						</div>
					</div>
			    </div>
    		</form>	
		</div><!-- end box body -->
		</div>
</div>
<div class="col-md-6">			
		<div class="box box-info">
            <div class="box-header no-print">
              <h3 class="box-title"><b>Employee Post List</b></h3>
            </div>
      		<div class="box-body p-table-bg-head p-table-body table-responsive">
				<table class="table">
					<thead><tr>
					<th>S.No.</th>
					<th>Post</th>
					<th>Action</th>
					</tr>
					</thead>
					<tbody id="">
					<tr>
						<td>01.</td>
						<td>PGT</td>
						<td><button class="btn btn-success edit">Edit</button> <button class="btn btn-danger delete">Delete</button></td>
					</tr>
					<tr>
						<td>01.</td>
						<td>PGT</td>
						<td><button class="btn btn-success edit">Edit</button> <button class="btn btn-danger delete">Delete</button></td>
					</tr>
					<tr>
						<td>01.</td>
						<td>PGT</td>
						<td><button class="btn btn-success edit">Edit</button> <button class="btn btn-danger delete">Delete</button></td>
					</tr>
					<tr>
						<td>01.</td>
						<td>PGT</td>
						<td><button class="btn btn-success edit">Edit</button> <button class="btn btn-danger delete">Delete</button></td>
					</tr>
					</tbody>
				</table>
      		</div>
 		</div>
		
	</div>
</div>