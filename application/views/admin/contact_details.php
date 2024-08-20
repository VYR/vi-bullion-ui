
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
					url:"<?php echo base_url(); ?>admin/contact_details_ajax",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/contact_details"; }, 1000);
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
      Contact Details
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
				<label for="cat_slno" class="control-label">H1 tag <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="h1_tag" name="h1_tag" placeholder="Enter H1 tag" value="<?php if(!empty($record)){ echo $record['h1_tag']; } ?>" required>
				<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
			</div>
			<div class="col-md-12 form-group" style="display:none;">
				<label for="cat_slno" class="control-label">Address <span class="text-danger"></span></label>
				<input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="<?php if(!empty($record)){ echo $record['address']; } ?>">
			</div>
			<div class="col-md-12 form-group" style="display:none;">
				<label for="cat_slno" class="control-label">Google Map Url <span class="text-danger"></span></label>
				<input type="text" class="form-control" id="google_map" name="google_map" placeholder="Enter Google Map Url" value="<?php if(!empty($record)){ echo $record['google_map']; } ?>">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">H2 tag <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="h2_tag" name="h2_tag" placeholder="Enter H2 tag" value="<?php if(!empty($record)){ echo $record['h2_tag']; } ?>" required>
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Title <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="<?php if(!empty($record)){ echo $record['title']; } ?>" required>
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Meta Description <span class="text-danger">*</span></label>
				<textarea class="form-control" id="meta_description" name="meta_description" placeholder="Enter Meta Description"><?php if(!empty($record)){ echo $record['meta_description']; } ?></textarea>
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Meta Tags<span class="text-danger"></span></label>
				<textarea class="form-control" rows="10" id="meta_tags" name="meta_tags"><?php if(!empty($record)){ echo $record['meta_tags']; } ?></textarea>
			</div>
			<div class="col-md-12 form-group">
				<label for="upload_image">&nbsp;</label><br>
				<button type="submit" id="submit_id" class="btn btn-primary">Submit</button>
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

 
