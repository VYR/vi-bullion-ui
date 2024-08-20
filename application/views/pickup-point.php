

<div class="container pt-5">
<?php	
if(!empty($records)){
foreach($records as $key => $row){ 
if(!empty($row['dealers'])){
?> 
<h1 class="text-center color1 text-uppercase"><?php echo $row['name']; ?></h1>
<?php if($row['display_type']==1){ ?>
<?php	
foreach($row['dealers'] as $key1 => $row1){ 
?> 
<div class="border nbr2 rounded px-3 pt-3 mb-3 text-white">
<div class="row">
	<div class="col-md-6 mb-3 text-center">
		<img src="<?php echo base_url(); ?>assets/images/dealers/<?php echo $row1['image']; ?>" alt="<?php echo $row1['image_alt']; ?>" style="max-width:100%;height:70px;">
		<div class="mt-2"><?php echo $row1['description']; ?></div>
		<a href="<?php echo site_url(); ?>pickup-dashboard" class="btn abt-btn mt-3">Login</a>
	</div>
	<div class="col-md-6 mb-3">
		<iframe src="<?php echo $row1['google_map']; ?>" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
	</div>
</div>
</div>
<?php }  ?>
<?php }else if($row['display_type']==2){ ?>
<div class="row">
	<?php	
	foreach($row['dealers'] as $key1 => $row1){ 
	?> 
		<div class="col-md-6">
		<div class="border nbr2 rounded px-3 pt-3 mb-3 text-white">
		<div class="row">
			<div class="col-md-6 mb-3 text-center">
				<img src="<?php echo site_url(); ?>assets/images/dealers/<?php echo $row1['image']; ?>" alt="<?php echo $row1['image_alt']; ?>" style="max-width:100%;height:70px;">
				<div class="mt-2"><?php echo $row1['description']; ?></div>
				<a href="<?php echo site_url(); ?>pickup-dashboard" class="btn abt-btn mt-3">Login</a>
			</div>
			<div class="col-md-6 mb-3">
				<iframe src="<?php echo $row1['google_map']; ?>" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div>
		</div>
		</div>
		</div>	
	<?php }  ?>
</div>
<?php }else if($row['display_type']==3){ ?>
<div class="row">
	<?php	
	foreach($row['dealers'] as $key1 => $row1){ 
	?> 
		<div class="col-md-4">
		<div class="border nbr2 rounded px-3 pt-3 mb-3 text-white">
		<div class="row">
			<div class="col-md-6 mb-3">
				<img src="<?php echo base_url(); ?>assets/images/dealers/<?php echo $row1['image']; ?>" alt="<?php echo $row1['image_alt']; ?>" style="max-width:100%;height:70px;">
				<div class="mt-2"><?php echo $row1['description']; ?></div>
				<a href="<?php echo site_url(); ?>pickup-dashboard" class="btn abt-btn mt-3">Login</a>
			</div>
			<div class="col-md-6 mb-3">
				<iframe src="<?php echo $row1['google_map']; ?>" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			</div>
		</div>
		</div>
		</div>	
	<?php }  ?>
</div>
<?php }  ?>
<?php }}}  ?>
</div>