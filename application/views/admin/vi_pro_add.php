
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
					url:"<?php echo base_url(); ?>admin/vi_pro_ajax",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/vi_pro"; }, 1000);
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
       Vi Pro Add
        
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
			<label for="cat_slno" class="control-label">Unique Code <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="unique_code" name="unique_code" placeholder="Enter Corporate Code" value="<?php if(!empty($record)){ echo $record['unique_code']; } ?>" required>
			<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
			</div>
			<div class="col-md-12 form-group">
			<label for="cat_slno" class="control-label">Password <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="password" name="password" placeholder="Enter password" value="<?php if(!empty($record)){ echo decode5t($record['password']); } ?>" required>
			</div>
			<div class="col-md-12 form-group">
			<label for="cat_slno" class="control-label">Name <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="<?php if(!empty($record)){ echo $record['name']; } ?>" required>
			</div>
			<div class="col-md-12 form-group">
			<label for="cat_slno" class="control-label">Mobile <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php if(!empty($record)){ echo $record['mobile']; } ?>" required>
			</div>
			<div class="col-md-12 form-group">
			<label for="cat_slno" class="control-label">Email <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php if(!empty($record)){ echo $record['email']; } ?>" required>
			</div>
			<div class="col-md-12 form-group">
			<label for="cat_slno" class="control-label">Aadhaar number <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="aadhaar_number" name="aadhaar_number" placeholder="Enter Aadhaar number" value="<?php if(!empty($record)){ echo $record['aadhaar_number']; } ?>" required>
			</div>
			<div class="col-md-12 form-group">
			<label for="cat_slno" class="control-label">Pan Number <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="pan_number" name="pan_number" placeholder="Enter Pan Number" value="<?php if(!empty($record)){ echo $record['pan_number']; } ?>" required>
			</div>
			<div class="col-md-12 form-group">
			<label for="cat_slno" class="control-label">Date <span class="text-danger">*</span></label>
			<input type="text" class="form-control datepicker" id="date" name="date" placeholder="Enter Pan Number" value="<?php if(!empty($record) && $record['date']!='0000-00-00'){ echo date("Y-m-d",strtotime($record['date'])); }else{ echo date("Y-m-d"); } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="upload_image">&nbsp;</label><br>
				<a href="<?php echo base_url(); ?>admin/vi_pro" class="btn btn-danger">Cancel</a>
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

 