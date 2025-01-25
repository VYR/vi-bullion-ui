
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       User Payments
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
	
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">User Details</h3>
			   <div id="dmsg"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive" id="">
				<table id="" class="table table-bordered table-striped">            
				<thead>       
					<tr>       
						<th>Category</th>  
						<th>Promoter</th>  
						<th>User Details</th>  
						<th>Joining Date</th>  
					</tr>       
				</thead>   
				<tbody>
					<tr class="text-center">
					<td>
					<?php echo $record['category_name']; ?><br>
					<?php echo $record['sub_category_name']; ?>
					</td>
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
						<td>
							<?php if($row['payment_status']==0){ ?>
							<b class="text-danger">Not Paid</b>
							<?php }else{ ?>
							<b class="text-danger">Paid</b>
							<?php } ?>
						</td>
					</tr>
					<?php }  }  ?>
					</tbody>
					</table>
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
						<a href="<?php echo base_url(); ?>admin/visave_user_bonus_add?id=<?php echo $record['id']; ?>" class="btn btn-primary">Add</a>
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
						<a href="<?php echo base_url(); ?>admin/visave_user_penalties_add?id=<?php echo $record['id']; ?>" class="btn btn-primary">Add</a>
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

 
