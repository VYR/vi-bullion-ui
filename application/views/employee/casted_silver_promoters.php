
	
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Promoters
      </h1>
     <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>-->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
          
            <!-- /.box-header -->
            <div class="box-body">
			<div class="row" >
			<div class="col-md-3 col-xs-8">
				<select class="form-control" id="employee_id" name="employee_id"  onchange="getRecords(this.value)" required>

					<option value="0">Select Corporate</option>

					<?php	

					if(count($employees) > 0){

					foreach($employees as $skey => $srow){ 

					?> 

					<option value="<?php echo $srow['id']; ?>" <?php if($employee_id==$srow['id']){ echo 'selected'; } ?>><?php echo $srow['name']; ?></option>

					<?php }}  ?>

				</select>
            </div>
			<div class="col-md-9 col-xs-4 text-right">
				<a href="<?php echo base_url(); ?>admin/casted_silver_promoters_add" class="btn btn-primary">Add</a>
            </div>
            </div>
            </div>
            <!-- /.box-body -->
          </div>          <!-- /.box -->
	
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Promoters Table</h3>
			   <div id="dmsg"></div>
            </div>
            <!-- /.box-header -->
			<?php	
			if(count($records) > 0){
			?> 
            <div class="box-body table-responsive" id="">
				<table id="example1" class="table table-bordered table-striped">            
				<thead>       
					<tr>       
						<th>SNO</th> 
						<th>Promoter Details</th>  
						<th>Promoter Code</th>  
						<th>Password</th>  
						<th>Company</th>    
						<th>Bank Details</th>  
						<th>Status</th>  
						<th>Action</th>  
					</tr>       
				</thead>   
				<tbody>
	<?php	
	foreach($records as $key => $row){ 
	?> 
	<tr class="text-center">
	<td><?php echo $key+1; ?></td>
	<td>
	<?php echo $row['name']; ?><br>
	<?php echo $row['mobile']; ?><br>
	<?php echo $row['email']; ?>
	</td>
	<td><?php echo $row['unique_code']; ?></td>
	<td><?php echo decode5t($row['password']); ?></td>
	<td>
	<?php echo $row['company_name']; ?><br>
	<?php echo $row['gst']; ?>
	</td>
	<td>
	<b>BANK : </b><?php echo $row['bank_name']; ?><br>
	<b>ACCOUNT NO : </b><?php echo $row['account_number']; ?><br>
	<b>IFSC : </b><?php echo $row['ifsc']; ?><br>
	<b>BRANCH : </b><?php echo $row['branch']; ?>
	</td>
	<td>
	<?php if($row['status']==0) { ?>
	<a href="<?php echo base_url(); ?>admin/casted_silver_promoters_status?id=<?php echo $row['id']; ?>&status=1" class="btn btn-danger text-white confirm_alert" data-title="Are You Sure Want To Change Status?">Deactive</a>
	<?php } else if($row['status']==1) { ?>		
	<a href="<?php echo base_url(); ?>admin/casted_silver_promoters_status?id=<?php echo $row['id']; ?>&status=0" class="btn btn-success text-white confirm_alert" data-title="Are You Sure Want To Change Status?">Active</a>					
	<?php } ?>							
	</td>
	<td>
	<a href="<?php echo base_url(); ?>admin/casted_silver_promoters_add?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
	<a href="<?php echo base_url(); ?>admin/casted_silver_promoters_delete?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger confirm_alert" data-title="Are you sure want to delete?" title="Delete"><i class="fa fa-trash"></i></a>
	</td>
	</tr>
	<?php }   ?>
			  </tbody></table>
			  </div>
				<?php }  ?>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		  
		  
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
	function getRecords(value){
		location.href="<?php echo base_url(); ?>admin/casted_silver_promoters?id="+value;
	}
</script>
 
