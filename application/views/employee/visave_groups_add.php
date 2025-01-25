
		<script>
$(document).ready(function(){	
	
	$("#submit_form").on("submit", function(e){
				e.preventDefault();		
				$("#submit_form #submit_id").attr('disabled',true);
				$("#submit_form #submit_id").text('Please Wait...');
				let data = new FormData($("#submit_form")[0]);
				$.post({
					type: "post",
					url:"<?php echo base_url(); ?>admin/visave_groups_ajax",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/visave_groups"; }, 1000);
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
	function getSubcategories(){
		var category_id=$("#category_id").val();
		$.ajax({    
			type: "POST",    
			dataType: "html",    
			url: "<?php echo base_url(); ?>admin/get_visave_sub_categories",    
			data: { category_id: category_id }})
		.done(function(data) { 
			$('#sub_category_id').html(data);	
		});
	}
		 
		</script>
		
	
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Groups Add
        
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
			<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
			<div class="col-md-4 form-group">
				<label for="name">Category<span class="text-danger">*</span></label>
				<select class="form-control" id="category_id" name="category_id" onchange="getSubcategories()" required>
					<option value="">Select</option>
					<?php	
					if(!empty($categories)){
					foreach($categories as $skey => $srow){ 
					?> 
					<option value="<?php echo $srow['id']; ?>" <?php if(!empty($record) && $record['category_id']==$srow['id']){ echo 'selected'; } ?>><?php echo $srow['category_name']; ?></option>
					<?php }}  ?>
				</select>
			</div>
			<div class="col-md-4 form-group">
				<label for="name">Sub Category<span class="text-danger">*</span></label>
				<select class="form-control" id="sub_category_id" name="sub_category_id" required>
					<option value="">Select</option>
					<?php	
					if(!empty($sub_categories)){
					foreach($sub_categories as $skey => $srow){ 
					?> 
					<option value="<?php echo $srow['id']; ?>" <?php if(!empty($record) && $record['sub_category_id']==$srow['id']){ echo 'selected'; } ?>><?php echo $srow['sub_category_name']; ?></option>
					<?php }}  ?>
				</select>
			</div>
			<div class="col-md-4 form-group">
				<label for="name">Group Name<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter Group Name" value="<?php if(!empty($record)){ echo $record['group_name']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="name">No of users<span class="text-danger">*</span></label>
				<select class="form-control" id="no_of_users" name="no_of_users" required>
					<option value="">Select</option>
					<option value="27" <?php if(!empty($record) && $record['no_of_users']==27){ echo 'selected'; } ?>>27</option>
					<option value="54" <?php if(!empty($record) && $record['no_of_users']==54){ echo 'selected'; } ?>>54</option>
				</select>
			</div>
			<div class="col-md-4 form-group">
				<label for="name">Joining Date<span class="text-danger">*</span></label>
				<input type="text" class="form-control datepicker" id="joining_date" name="joining_date" placeholder="Enter Name" value="<?php if(!empty($record)){ echo date("Y-m-d",strtotime($record['joining_date'])); }else{ echo date("Y-m-d"); } ?>" required>
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

 
