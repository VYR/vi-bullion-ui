
	
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Casted Silver  Products
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

				<a href="<?php echo base_url(); ?>admin/casted_silver_products_add" class="btn btn-primary">Add</a>

            </div>

            <!-- /.box-body -->

          </div> 
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Products Table</h3>
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
						<th>Category</th>  
						<th>Product Name</th>  
						<th>Image</th>  
						<th>Weight</th>  
						<!--<th>Mrp</th>  -->
						<th>Purity</th>  
						<th>Purity percentage</th>  
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
	<td><?php echo $row['category_name']; ?></td>
	<td><?php echo $row['name']; ?></td>
	<td><img src="<?php echo base_url(); ?>assets/images/casted_silver/<?php echo $row['image']; ?>" width="100"></td>
	<td><?php echo $row['weight']; ?></td>
	<!--<td><?php echo $row['mrp']; ?></td>-->
	<td><?php echo $row['purity']; ?></td>
	<td><?php echo $row['purity_percentage']; ?>%</td>
	<td>
	<?php if($row['status']==0) { ?>
	<a href="<?php echo base_url(); ?>admin/casted_silver_products_status?id=<?php echo $row['id']; ?>&status=1" class="btn btn-danger text-white confirm_alert" data-title="Are You Sure Want To Change Status?">Deactive</a>
	<?php } else if($row['status']==1) { ?>		
	<a href="<?php echo base_url(); ?>admin/casted_silver_products_status?id=<?php echo $row['id']; ?>&status=0" class="btn btn-success text-white mb-1 confirm_alert" data-title="Are You Sure Want To Change Status?">Active</a>								
	<?php } ?>							
	</td>
	<td>
	<a href="<?php echo base_url(); ?>admin/casted_silver_products_add?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
	<a href="<?php echo base_url(); ?>admin/casted_silver_products_delete?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger confirm_alert" data-title="Are you sure want to delete?" title="Delete"><i class="fa fa-trash"></i></a>
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
		location.href="<?php echo base_url(); ?>admin/casted_silver_products?id="+value;
	}
</script>
 
