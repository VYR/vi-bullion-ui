
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Group User Payments
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
						<th>Group</th>  
						<th>Promoter</th>  
						<th>User Details</th>  
						<th>Joining Date</th>  
					</tr>       
				</thead>   
				<tbody>
					<tr class="text-center">
					<td><?php echo $record['group_name']; ?></td>
					<td><?php echo $record['promoter_name']; ?></td>
					<td>
					<?php echo $record['name']; ?><br>
					<?php echo $record['mobile']; ?><br>
					<?php echo $record['email']; ?>
					</td>
					<td><?php echo date("Y-m-d",strtotime($record['joining_date'])); ?></td>
					</tr>
			  </tbody></table>
			  </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		  
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">User Payments</h3>
			   <div id="dmsg"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive" id="">
				<table id="" class="table table-bordered table-striped">            
				<thead>       
					<tr>       
						<th>SNO</th>  
						<th>Date</th>  
						<th>Amount</th>  
						<th>Payment Details</th>  
					</tr>       
				</thead>   
				<tbody>
					<?php	
					$total_payments=array();
					if(count($payments) > 0){
					foreach($payments as $key => $row){ 
					if($row['payment_status']==1){
						$total_payments[]=$row['amount'];
					}
					?> 
					<tr class="text-center">
						<td><?php echo $key+1; ?></td>
						<td><?php echo date("Y-m-d",strtotime($row['payment_date'])); ?></td>
						<td><?php echo $row['amount']; ?></td>
						<td class="text-left">
							<?php if($row['payment_status']==0){ ?>
							<form role="form" method="post" action="<?php echo base_url(); ?>admin/visave_group_payments_add">
								<input type="hidden" id="id" name="id" value="<?php echo $row['id']; ?>">
								<input type="hidden" id="user_id" name="user_id" value="<?php echo $record['id']; ?>">
								<div style="width:200px;">
									<div class="row">
										<div class="col-md-8">
											<label for="name">Date<span class="text-danger">*</span></label>
											<input type="text" class="form-control datepicker" id="payment_date_time" name="payment_date_time" value="<?php echo date("Y-m-d"); ?>" required>
										</div>
										<div class="col-md-4">
											<label for="upload_image">&nbsp;</label><br>
											<button type="submit" id="submit_id" class="btn btn-primary">Submit</button>
										</div>
									</div>
								</div>
							</form>
							<b class="text-danger">Not Paid</b>
							<?php }else{ ?>
							<b class="text-success">Paid</b>
							<div><?php echo date("Y-m-d",strtotime($row['payment_date_time'])); ?></div>
							<?php } ?>
						</td>
					</tr>
					<?php }  }  ?>
			  </tbody></table>
			  </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		<div class="box">
            <div class="box-header">
				<div class="row">
					<div class="col-md-6">
						<h3 class="box-title">User Bonus</h3>						
					</div>
					<div class="col-md-6 text-right">
						<a href="<?php echo base_url(); ?>admin/visave_group_user_bonus_add?id=<?php echo $record['id']; ?>" class="btn btn-primary">Add</a>
					</div>
				</div>
            </div>
            <div class="box-body table-responsive" id="">
				<table id="" class="table table-bordered table-striped">            
					<thead>       
						<tr>       
							<th>SNO</th>  
							<th>Date</th>  
							<th>Amount</th>  
						</tr>       
					</thead>   
					<tbody>
						<?php	
						$total_bonus=array();
						if(count($bonus) > 0){
						foreach($bonus as $key => $row){ 
						$total_bonus[]=$row['amount'];
						?> 
						<tr class="text-center">
							<td><?php echo $key+1; ?></td>
							<td><?php echo date("Y-m-d",strtotime($row['payment_date'])); ?></td>
							<td><?php echo $row['amount']; ?></td>
						</tr>
						<?php }  }  ?>
				  </tbody>
			  </table>
			</div>
		</div>
		<div class="box">
            <div class="box-header">
				<div class="row">
					<div class="col-md-6">
						<h3 class="box-title">User Penalties</h3>						
					</div>
					<div class="col-md-6 text-right">
						<a href="<?php echo base_url(); ?>admin/visave_group_user_penalties_add?id=<?php echo $record['id']; ?>" class="btn btn-primary">Add</a>
					</div>
				</div>
				<div id="dmsg"></div>
            </div>
            <div class="box-body table-responsive" id="">
				<table id="" class="table table-bordered table-striped">            
					<thead>       
						<tr>       
							<th>SNO</th>  
							<th>Date</th>  
							<th>Amount</th>  
						</tr>       
					</thead>   
					<tbody>
						<?php	
						$total_penalties=array();
						if(count($penalties) > 0){
						foreach($penalties as $key => $row){ 
						$total_penalties[]=$row['amount'];
						?> 
						<tr class="text-center">
							<td><?php echo $key+1; ?></td>
							<td><?php echo date("Y-m-d",strtotime($row['payment_date'])); ?></td>
							<td><?php echo $row['amount']; ?></td>
						</tr>
						<?php }  }  ?>
				  </tbody>
			  </table>
			</div>
		</div>
		  
		<div class="box">
            <div class="box-header">
				<h3 class="box-title">User Total payment</h3>		
            </div>
            <div class="box-body table-responsive" id="">
				<table id="" class="table table-bordered table-striped">            
					<tbody>       
						<tr>       
							<th>Payments (A)</th>  
							<th><?php echo round(array_sum($total_payments)); ?></th>  
						</tr>         
						<tr>       
							<th>Bonus (B)</th>  
							<th><?php echo round(array_sum($total_bonus)); ?></th>  
						</tr>         
						<tr>       
							<th>Penalties (C)</th>  
							<th><?php echo round(array_sum($total_penalties)); ?></th>  
						</tr>            
						<tr>       
							<th>Total (A+B)-C</th>  
							<th><?php echo (round(array_sum($total_payments))+round(array_sum($total_bonus)))-round(array_sum($total_penalties)); ?></th>  
						</tr>       
					</tbody>  
			  </table>
			</div>
		</div>
		  
		  
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
