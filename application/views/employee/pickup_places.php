
		<script>
$(document).ready(function(){	
	
	$("#submit_form").on("submit", function(e){
				e.preventDefault();	
				$("#submit_form #submit_id").attr('disabled',true);
				$("#submit_form #submit_id").text('Please Wait...');
				let data = new FormData($("#submit_form")[0]);
				$.post({
					type: "post",
					url:"<?php echo base_url(); ?>admin/ajax_pickup_places",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/pickup_places"; }, 1000);
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
       Pickup Places
        
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
	<form role="form" id="submit_form" method="post" enctype="multipart/form-data">
		<div class="row" >
			<div class="col-md-3 form-group">
				<label for="name">Name<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="name" name="name" value="<?php if(!empty($record)){echo $record['name'];} ?>" autocomplete="off" placeholder="Name" required>
				<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
			</div>
			<div class="col-md-3 form-group">
				<label for="name">state code<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="state_code" name="state_code" value="<?php if(!empty($record)){echo $record['state_code'];} ?>" autocomplete="off" placeholder="state code" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="name">Position<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="position" name="position" value="<?php if(!empty($record)){echo $record['position'];} ?>" autocomplete="off" placeholder="Position" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="name">Display Type<span class="text-danger">*</span></label>
				<select class="form-control" id="display_type" name="display_type"  onchange="getSub()" required>
					<option value="1" <?php if(!empty($record) && $record['display_type']==1){ echo 'selected'; } ?>>1</option>
					<option value="2" <?php if(!empty($record) && $record['display_type']==2){ echo 'selected'; } ?>>2</option>
					<option value="3" <?php if(!empty($record) && $record['display_type']==3){ echo 'selected'; } ?>>3</option>
				</select>
			</div>
			<div class="col-md-12 form-group">
				<button type="submit" id="submit_id" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
	
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Pickup Places Table</h3>
			   <div id="dmsg"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="">
				<table id="example1" class="table table-bordered table-striped">            
				<thead>       
					<tr>       
						<th>SNO</th>  
						<th>Name</th>  
						<th>State code</th>  
						<th>Position</th>  
						<th>Display Type</th>  
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
	<td><?php echo $row['state_code']; ?></td>
	<td><?php echo $row['position']; ?></td>
	<td><?php echo $row['display_type']; ?></td>
	<td>
	<?php if($row['status']==0) { ?>
	<a href="<?php echo base_url(); ?>admin/pickup_places_status?id=<?php echo $row['id']; ?>&status=1" class="btn btn-danger text-white confirm_alert" data-title="Are You Sure Want To Change Status?">Deactive</a>
	<?php } else if($row['status']==1) { ?>		
	<a href="<?php echo base_url(); ?>admin/pickup_places_status?id=<?php echo $row['id']; ?>&status=0" class="btn btn-success text-white confirm_alert" data-title="Are You Sure Want To Change Status?">Active</a>					
	<?php } ?>							
	</td>
	<td>
	<a href="<?php echo base_url(); ?>admin/pickup_places?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
	<a href="<?php echo base_url(); ?>admin/pickup_places_delete?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger confirm_alert" data-title="Are you sure want to delete?" title="Delete"><i class="fa fa-trash"></i></a>
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

 
