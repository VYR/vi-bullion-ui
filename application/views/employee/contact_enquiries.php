
		
	
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Contact Enquiries
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
         
          <!-- /.box -->
	
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Contact Enquiries Table</h3>
			   <div id="dmsg"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="">
				<table id="example1" class="table table-bordered table-striped">            
				<thead>       
					<tr>       
						<th>SNO</th>  
						<th>Name</th>  
						<th>Email</th>  
						<th>Mobile</th>  
						<th>Message</th>  
						<th>Contacted Date/Time</th>  
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
	<td><?php echo $row['name']; ?></td>
	<td><?php echo $row['email']; ?></td>
	<td><?php echo $row['mobile']; ?></td>
	<td><?php echo $row['subject']; ?></td>
	<td><?php echo date("d M Y h:i A", strtotime($row['contacted_date_time'])); ?></td>
	<td>
	<a href="<?php echo base_url(); ?>admin/contact_enquiries_delete?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger confirm_alert" data-title="Are you sure want to delete?" title="Delete"><i class="fa fa-trash"></i></a>
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

 
