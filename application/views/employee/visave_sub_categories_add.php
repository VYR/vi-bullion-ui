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
					url:"<?php echo base_url(); ?>admin/visave_sub_categories_ajax",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/visave_sub_categories"; }, 1000);
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
       VI Save Sub Categories Add
        
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
			<div class="col-md-4 form-group">
				<label for="name">Category<span class="text-danger">*</span></label>
				<select class="form-control" id="category_id" name="category_id" required>
					<option value="">Select</option>
					<?php	
					if(count($categories) > 0){
					foreach($categories as $skey => $srow){ 
					?> 
					<option value="<?php echo $srow['id']; ?>" <?php if(!empty($record) && $record['category_id']==$srow['id']){ echo 'selected'; } ?>><?php echo $srow['category_name']; ?></option>
					<?php }}  ?>
				</select>
			</div>
			<div class="col-md-4 form-group">
			<label for="cat_slno" class="control-label">Sub Category Name <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="sub_category_name" name="sub_category_name" placeholder="Enter Sub Category name" value="<?php if(!empty($record)){ echo $record['sub_category_name']; } ?>" required>
			<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
			</div>
			<div class="col-md-12 form-group">
				<label for="upload_image">&nbsp;</label><br>
				<a href="<?php echo base_url(); ?>admin/visave_sub_categories" class="btn btn-danger">Cancel</a>
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
 