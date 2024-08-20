
		<script>
$(document).ready(function(){	
	
	$("#submit_form").on("submit", function(e){
				e.preventDefault();	
				$("#submit_form #submit_id").attr('disabled',true);
				$("#submit_form #submit_id").text('Please Wait...');
				let data = new FormData($("#submit_form")[0]);
				$.post({
					type: "post",
					url:"<?php echo base_url(); ?>admin/ajax_faq_categories",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/faq_categories"; }, 1000);
						}
						else
						{
							$.toast({heading: 'Error',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'error'});		
						}
						$("#submit_form #submit_id").attr('disabled',false);
						$("#submit_form #submit_id").text('Submit');
					}
				});	
			});	
	
});
		 
		 
		</script>
		
	
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Casted Silver Categories
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
				<a href="<?php echo base_url(); ?>admin/casted_silver_categories_add" class="btn btn-primary">Add</a>
            </div>
            <!-- /.box-body -->
          </div>          <!-- /.box -->
	
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Casted Silver Categories Table</h3>
			   <div id="dmsg"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive" id="">
				<table id="example1" class="table table-bordered table-striped">            
				<thead>       
					<tr>       
						<th>SNO</th>  
						<th>Name</th>  
						<th>Display order</th>  
						<th>Products Display count</th>  
						<th>Ads Display count</th>  
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
	<td><?php echo $row['name']; ?></td>
	<td><?php echo $row['display_order']; ?></td>
	<td><?php echo $row['products_display_count']; ?></td>
	<td><?php echo $row['ads_display_count']; ?></td>
	<td>
	<?php if($row['status']==0) { ?>
	<a href="<?php echo base_url(); ?>admin/casted_silver_categories_status?id=<?php echo $row['id']; ?>&status=1" class="btn btn-danger text-white confirm_alert" data-title="Are You Sure Want To Change Status?">Deactive</a>
	<?php } else if($row['status']==1) { ?>		
	<a href="<?php echo base_url(); ?>admin/casted_silver_categories_status?id=<?php echo $row['id']; ?>&status=0" class="btn btn-success text-white confirm_alert" data-title="Are You Sure Want To Change Status?">Active</a>					
	<?php } ?>							
	</td>
	<td>
	<a href="<?php echo base_url(); ?>admin/casted_silver_categories_add?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
	<a href="<?php echo base_url(); ?>admin/casted_silver_categories_delete?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger confirm_alert" data-title="Are you sure want to delete?" title="Delete"><i class="fa fa-trash"></i></a>
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

 
