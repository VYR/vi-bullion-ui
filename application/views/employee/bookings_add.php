
		<script>
$(document).ready(function(){	
	
	$("#submit_form").on("submit", function(e){
				e.preventDefault();		
				for ( instance in CKEDITOR.instances ) 	
				{        
					CKEDITOR.instances[instance].updateElement();    
				}	
				$("#submit_form #submit_id").attr('disabled',true);
				$("#submit_form #submit_id").text('Please Wait...');
				let data = new FormData($("#submit_form")[0]);
				$.post({
					type: "post",
					url:"<?php echo base_url(); ?>admin/bookings_ajax",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/bookings"; }, 1000);
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
       Bookings Add
        
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
			<div class="col-md-12 form-group">
				<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
				<label for="name">Commission<span class="text-danger">*</span></label>
				<input type="number" class="form-control" id="commission_percentage" name="commission_percentage" placeholder="Enter Commission" value="<?php if(!empty($record)){ echo $record['commission_percentage']; } ?>" required>
			</div>
			<div class="col-md-12 form-group">
				<label for="remarks" class="control-label">Remarks<span class="text-danger"></span></label>
				<textarea class="form-control" id="remarks" name="remarks"><?php if(!empty($record)){ echo $record['remarks']; } ?></textarea>
			</div>
			<div class="col-md-12 form-group">
				<label for="remarks" class="control-label">Status<span class="text-danger"></span></label>				<select class="form-control" id="status" name="status">				<option value="0" <?php if($record['status']=='0'){ echo 'selected'; } ?>>Pending</option>				<option value="1" <?php if($record['status']=='1'){ echo 'selected'; } ?>>Confirmed</option>				<option value="2" <?php if($record['status']=='2'){ echo 'selected'; } ?>>Closed</option>				<option value="3" <?php if($record['status']=='3'){ echo 'selected'; } ?>>Declined</option>				</select>
			</div>
			<div class="col-md-4 form-group">
				<label for="upload_image">&nbsp;</label><br>
				<button type="submit" id="submit_id" class="btn btn-primary">Submit</button>
				<a href="<?php echo base_url(); ?>admin/bookings" class="btn btn-danger">Cancel</a>
			</div>
		</div>
	</form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
	
          
          <!-- /.box -->
		  
			
	
		  
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
