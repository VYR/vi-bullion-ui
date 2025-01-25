
<div class="box">

<!-- /.box-header -->
<div class="box-header">
<h4>Pricing</h4>
</div>
<div class="box-body">
<div class="row" >
<div class="col-md-3 form-group">
<label>A</label>
<input type="text" class="form-control" id="org_price" value="<?php echo $org_price; ?>" readonly>
</div>
<div class="col-md-3 form-group">
<label>B</label>
<input type="text" class="form-control" id="dollar_price" value="<?php echo $dollar_price; ?>" readonly>
</div>
</div>
<div class="row" >
<div class="col-md-3 form-group">
<label>A1 (add)</label>
<input type="text" class="form-control" value="<?php echo $record['a1_value']; ?>" readonly>
</div>
<div class="col-md-3 form-group">
<label>B1 (add)</label>
<input type="text" class="form-control" value="<?php echo $record['b1_value']; ?>" readonly>
</div>
</div>
<div class="row" >
<div class="col-md-3 form-group">
<?php $a2_value=$org_price+$record['a1_value']; ?>
<label>A2 (equal)</label>
<input type="text" class="form-control" value="<?php echo round($a2_value,2); ?>" readonly>
</div>
<div class="col-md-3 form-group">
<?php $b2_value=$dollar_price+$record['b1_value']; ?>
<label>B2 (equal)</label>
<input type="text" class="form-control" value="<?php echo round($b2_value,2); ?>" readonly>
</div>
</div>
<div class="row" >
<div class="col-md-3 form-group">
<label>A3 (add)</label>
<input type="text" class="form-control" value="<?php echo $record['a3_value']; ?>" readonly>
</div>
</div>
<div class="row">
<div class="col-md-3 form-group">
<?php $a4_value=$a2_value+$record['a3_value']; ?>
<label>A4 (equal)</label>
<input type="text" class="form-control" value="<?php echo round($a4_value,2); ?>" readonly>
</div>
<div class="col-md-3 form-group">
<label>B2 (x)</label>
<input type="text" class="form-control" value="<?php echo round($b2_value,2); ?>" readonly>
</div>
<div class="col-md-3 form-group">
<label>A5 (equal)</label>
<?php $a5_value=$a4_value*$b2_value; ?>
<input type="text" class="form-control" value="<?php echo round($a5_value,2); ?>" readonly>
</div>
</div>
<div class="row">
<div class="col-md-2 form-group">
<label>A5</label>
<input type="text" class="form-control" value="<?php echo round($a5_value,2); ?>" readonly>
</div>
<div class="col-md-2 form-group">
<label>C (add)</label>
<input type="text" class="form-control" value="<?php echo $record['c_value']; ?>" readonly>
</div>
<div class="col-md-2 form-group">
<label>D (equal)</label>
<?php $d_value=$a5_value+$record['c_value']; ?>
<input type="text" class="form-control" value="<?php echo round($d_value,2); ?>" readonly>
</div>
<div class="col-md-2 form-group">
<label>E (Multiply by)</label>
<input type="text" class="form-control" value="<?php echo $record['e_value']; ?>" readonly>
</div>
<div class="col-md-2 form-group">
<?php $m_value=$d_value*$record['e_value']; ?>
<label>M (equal)</label>
<input type="text" class="form-control" value="<?php echo round($m_value,2); ?>" readonly>
</div>
<div class="col-md-2 form-group">
<label>N (Divided By)</label>
<input type="text" class="form-control" value="<?php echo '1000'; ?>" readonly>
</div>
<div class="col-md-2 form-group">
<?php $f_value=$m_value/1000; ?>
<label>F (equal)</label>
<input type="text" class="form-control" value="<?php echo round($f_value,2); ?>" readonly>
</div>
</div>
<div class="row">
<div class="col-md-2 form-group">
<label>F</label>
<input type="text" class="form-control" value="<?php echo round($f_value,2); ?>" readonly>
</div>
<div class="col-md-2 form-group">
<?php $i_value=($record['gst']*$f_value)/100; ?>					
<label>I (GST)(add)</label>
<input type="text" class="form-control" value="<?php echo round($i_value,2); ?>" readonly>
</div>
<div class="col-md-2 form-group">
<label>H (equal)</label>
<?php $h_value=$f_value+$i_value; ?>
<input type="text" class="form-control" value="<?php echo round($h_value,2); ?>" readonly>
</div>
<div class="col-md-2 form-group">
<label>G (add)</label>
<input type="text" class="form-control" value="<?php echo $record['g_value']; ?>" readonly>
</div>
<div class="col-md-2 form-group">
<?php $j_value=$h_value+$record['g_value']; ?>
<label>J (equal)</label>
<input type="text" class="form-control" value="<?php echo round($j_value,2); ?>" readonly>
</div>
<div class="col-md-2 form-group">
	<?php $l_value=$record['l_value']; ?>					
	<label>L (Minus)</label>
	<input type="text" class="form-control" value="<?php echo round($l_value,2); ?>" readonly>
</div>
<div class="col-md-2 form-group">
	<?php $n_value=$j_value-$l_value; ?>
	<label>N (equal)</label>
	<input type="text" class="form-control" value="<?php echo round($n_value,2); ?>" readonly>
</div>
</div>
</div>
<!-- /.box-body -->
</div>
<div class="box">
<div class="box-header">
<h3 class="box-title">Products Table</h3>
<div id="dmsg"></div>
</div>
<!-- /.box-header -->
<?php	
if(count($records) > 0){
?> 
<div class="box-body table-responsive">
<table id="" class="table table-bordered table-striped">            
<thead>       
<tr>       
<th>SNO</th>  
<th>Purity</th>  
<th>Weight</th>  
<th>Price1/gm</th>   
<th>Purity percentage</th>  
<th>Purity amount</th>  
<th>Price2/gm</th>     
<th>Final Price</th>  
</tr>       
</thead>   
<tbody>
<?php	
foreach($records as $key => $row){ 
$purity_amount=($row['purity_percentage']*$n_value)/100;

$price2=$n_value-$purity_amount;
$final_price=$price2*$row['weight'];
?> 
<tr class="text-center">
<td><?php echo $key+1; ?></td>
<td><?php echo $row['purity']; ?></td>
<td><?php echo $row['weight']; ?></td>
<td><?php echo round($n_value,2); ?></td>
<td><?php echo $row['purity_percentage']; ?>%</td>
<td><?php echo round($purity_amount,2); ?></td>
<td><?php echo round($price2,2); ?></td>
<td><?php echo round($final_price,2); ?></td>
</tr>
<?php }   ?>
</tbody>
</table>
</div>
<?php }  ?>
<!-- /.box-body -->
</div>