
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Group Lucky Draw
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
	
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Group Details</h3>
			   <div id="dmsg"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive" id="">
				<table id="" class="table table-bordered table-striped">            
				<thead>       
					<tr>       
						<th>Category</th>  
						<th>Group Name</th>   
						<th>No of Users</th>  
						<th>Joining Date</th>  
					</tr>       
				</thead>   
				<tbody>
					<tr class="text-center">
						<td>
						<?php echo $record['category_name']; ?><br>
						<?php echo $record['sub_category_name']; ?>
						</td>
						<td><?php echo $record['group_name']; ?></td>
						<td><?php echo $record['no_of_users']; ?></td>
						<td><?php echo date("Y-m-d",strtotime($record['joining_date'])); ?></td>
					</tr>
			  </tbody></table>
			  </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		  
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lucky Draw</h3>
			   <div id="dmsg"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive" id="">
				<table id="" class="table table-bordered table-striped">            
				<thead>       
					<tr>       
						<th>SNO</th>  
						<th>Month</th>  
						<th>User</th>  
					</tr>       
				</thead>   
				<tbody>
					<?php	
					if(count($records) > 0){
					foreach($records as $key => $row){ 
					?> 
					<tr class="text-center">
						<td><?php echo $key+1; ?></td>
						<td><?php echo date("M Y",strtotime($row['month'])); ?></td>
						<td class="text-left">
							<?php if(empty($row['user_id'])){ ?>
							<form role="form" method="post" action="<?php echo base_url(); ?>admin/visave_group_lucky_draw_add">
								<input type="hidden" id="id" name="id" value="<?php echo $row['id']; ?>">
								<input type="hidden" id="group_id" name="group_id" value="<?php echo $record['id']; ?>">
								<div style="width:200px;">
									<div class="row">
										<div class="col-md-8">
											<label for="name">User<span class="text-danger">*</span></label>
											<select class="form-control" id="user_id" name="user_id" required>
												<option value="">Select</option>
												<?php	
												if(!empty($users)){
												foreach($users as $skey => $srow){ 
												?> 
												<option value="<?php echo $srow['id']; ?>"><?php echo $srow['name']; ?> (<?php echo $srow['mobile']; ?>)</option>
												<?php }}  ?>
											</select>
										</div>
										<div class="col-md-4">
											<label for="upload_image">&nbsp;</label><br>
											<button type="submit" id="submit_id" class="btn btn-primary">Submit</button>
										</div>
									</div>
								</div>
							</form>
							<?php }else{ ?>
							<div class="text-success"><b><?php echo $row['user_name']; ?></b></div>
							<div class="text-success"><b><?php echo $row['user_mobile']; ?></b></div>
							<?php } ?>
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

 
