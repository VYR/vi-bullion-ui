
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
					url:"<?php echo base_url(); ?>admin/visave_categories_ajax",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/visave_categories"; }, 1000);
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
       VI Save Categories Add
        
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
			<label for="cat_slno" class="control-label">Category Name <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Category name" value="<?php if(!empty($record)){ echo $record['category_name']; } ?>" required>
			<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
			</div>
			<div class="col-md-4 form-group">
			<label for="cat_slno" class="control-label">Amount <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="amount" name="amount" placeholder="Enter amount" value="<?php if(!empty($record)){ echo $record['amount']; } ?>" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')" autocomplete="off" required>
			</div>
			<div class="col-md-4 form-group">
			<label for="cat_slno" class="control-label">Penalty per day <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="penalty_per_day" name="penalty_per_day" placeholder="Enter Penalty per day" value="<?php if(!empty($record)){ echo $record['penalty_per_day']; } ?>" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')" autocomplete="off" required>
			</div>
			<div class="col-md-12 form-group">
				<label for="upload_image">&nbsp;</label><br>
				<a href="<?php echo base_url(); ?>admin/visave_categories" class="btn btn-danger">Cancel</a>
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

 
