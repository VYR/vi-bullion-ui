
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
					url:"<?php echo base_url(); ?>admin/categories_ajax",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location.reload(); }, 1000);
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
      Home content
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
				<label for="cat_slno" class="control-label">Name <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="<?php if(!empty($record)){ echo $record['name']; } ?>" required>
				<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Logo <span class="text-danger"></span></label>
				<?php if(!empty($record)){ ?><br>
				<img src="<?php echo base_url(); ?>assets/images/categories/<?php echo $record['image']; ?>" width="100">
				<?php } ?>
				<input type="file" class="form-control" id="image" name="image">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Image Alt <span class="text-danger"></span></label>
				<input type="text" class="form-control" id="image_alt" name="image_alt" placeholder="Enter Image Alt" value="<?php if(!empty($record)){ echo $record['image_alt']; } ?>">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Link Name <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="link_name" name="link_name" placeholder="Enter link name" value="<?php if(!empty($record)){ echo $record['link_name']; } ?>" required>
				<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Scrolling text<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="scrolling_text" name="scrolling_text" placeholder="Enter scrolling text" value="<?php if(!empty($record)){ echo $record['scrolling_text']; } ?>">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Description <span class="text-danger">*</span></label>
				<textarea class="form-control" id="description" name="description" placeholder="Enter Description"><?php if(!empty($record)){ echo $record['description']; } ?></textarea>
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Banner <span class="text-danger"></span></label>
				<?php if(!empty($record)){ ?><br>
				<img src="<?php echo base_url(); ?>assets/images/categories/<?php echo $record['banner']; ?>" width="100">
				<?php } ?>
				<input type="file" class="form-control" id="banner" name="banner">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Banner Alt <span class="text-danger"></span></label>
				<input type="text" class="form-control" id="banner_alt" name="banner_alt" placeholder="Enter banner Alt" value="<?php if(!empty($record)){ echo $record['banner_alt']; } ?>">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Long  Description<span class="text-danger"></span></label>
				<textarea class="ckeditor" id="long_description" name="long_description"><?php if(!empty($record)){ echo $record['long_description']; } ?></textarea>
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Status<span class="text-danger">*</span></label>
				<select class="form-control" name="status" required>
					<option value="0" <?php if(empty($record) || $record['status']==0){ echo 'selected'; } ?>>Deactive</option>
					<option value="1" <?php if(!empty($record) && $record['status']==1){ echo 'selected'; } ?>>Active</option>
				</select>
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Url Redirect<span class="text-danger">*</span></label>
				<select class="form-control" name="url_redirect" required>
					<option value="0" <?php if(empty($record) || $record['url_redirect']==0){ echo 'selected'; } ?>>Home</option>
					<option value="1" <?php if(!empty($record) && $record['url_redirect']==1){ echo 'selected'; } ?>>Page</option>
				</select>
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

	<script type="text/javascript">
			CKEDITOR.replaceAll( function( textarea, config ){
				if ( new CKEDITOR.dom.element( textarea ).hasClass('ckeditor') ) {
				CKEDITOR.tools.extend( config, {				
				filebrowserBrowseUrl: '<?php echo base_url(); ?>assets/ckfinder/ckfinder.html',
				filebrowserImageBrowseUrl: '<?php echo base_url(); ?>assets/ckfinder/ckfinder.html?type=Images',
				filebrowserUploadUrl: '<?php echo base_url(); ?>assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				filebrowserImageUploadUrl: '<?php echo base_url(); ?>assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
				} );
				return true;
				} 
				return false;
			});
	</script>
 
