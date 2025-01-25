
	
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Vi Payments
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
            </div>
			<div class="col-md-9 col-xs-4 text-right">
				<a href="<?php echo base_url(); ?>admin/vi_payments_add" class="btn btn-primary">Add</a>
            </div>
            </div>
            </div>
            <!-- /.box-body -->
          </div>          <!-- /.box -->
	
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Vi Payments</h3>
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
						<th>Heading</th>  
						<th>Pro Amount</th>  
						<th>Super Amount</th>  
						<th>Action</th>  
					</tr>       
				</thead>   
				<tbody>
					<?php	
					foreach($records as $key => $row){ 
					?> 
					<tr class="text-center">
					<td><?php echo $key+1; ?></td>
					<td><?php echo date("M Y",strtotime($row['heading'])); ?></td>
					<td><?php echo $row['pro_amount']['total_pro_amount']; ?></td>
					<td><?php echo $row['super_amount']['total_super_amount']; ?></td>
					<td>
						<a href="<?php echo base_url(); ?>admin/vi_payments_add?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
					</td>
					</tr>
					<?php } ?>
				</tbody>
				</table>
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
		location.href="<?php echo base_url(); ?>admin/vi_super?id="+value;
	}
</script>
 
