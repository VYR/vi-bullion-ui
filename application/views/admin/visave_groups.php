
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Groups
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
				<a href="<?php echo base_url(); ?>admin/visave_groups_add" class="btn btn-primary">Add</a>
            </div>
            <!-- /.box-body -->
          </div>          <!-- /.box -->
	
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Groups Table</h3>
			   <div id="dmsg"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive" id="">
				<table id="example1" class="table table-bordered table-striped">            
				<thead>       
					<tr>       
						<th>SNO</th>  
						<th>Category</th>  
						<th>Group Name</th>   
						<th>No of Users</th>  
						<th>Joining Date</th>  
						<th>Status</th>  
						<th>Action</th>  
					</tr>       
				</thead>   
				<tbody>
	<?php	
	if(count($records) > 0){
	foreach($records as $key => $row){ 
	?> 
	<tr class="text-center">
	<td><?php echo $key+1; ?></td>
	<td>
	<?php echo $row['category_name']; ?><br>
	<?php echo $row['sub_category_name']; ?>
	</td>
	<td><?php echo $row['group_name']; ?></td>
	<td><?php echo $row['no_of_users']; ?></td>
	<td><?php echo date("Y-m-d",strtotime($row['joining_date'])); ?></td>
	<td>
	<?php if($row['status']==0) { ?>
	<a href="<?php echo base_url(); ?>admin/visave_groups_status?id=<?php echo $row['id']; ?>&status=1" class="btn btn-danger btn-sm text-white confirm_alert" data-title="Are You Sure Want To Change Status?">Deactive</a>
	<?php } else if($row['status']==1) { ?>		
	<a href="<?php echo base_url(); ?>admin/visave_groups_status?id=<?php echo $row['id']; ?>&status=0" class="btn btn-success btn-sm text-white confirm_alert" data-title="Are You Sure Want To Change Status?">Active</a>					
	<?php } ?>	
	<br><br>	
	<a href="<?php echo base_url(); ?>admin/visave_group_lucky_draw?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm text-white">Lucky Draw</a>								
	</td>
	<td>
	<a href="<?php echo base_url(); ?>admin/visave_groups_add?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
	<a href="<?php echo base_url(); ?>admin/visave_groups_delete?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger confirm_alert" data-title="Are you sure want to delete?" title="Delete"><i class="fa fa-trash"></i></a>
	</td>
	</tr>
	<?php }  }  ?>
			  </tbody></table>
			  </div>
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

 