
<div class="container py-5" style="min-height:500px;">
<h1 class="text-center color1 text-uppercase"><?php echo $record['h1_tag']; ?></h1>
<div class="row">
	<div class="col-md-6">
		<h2><?php echo $record['h2_tag']; ?></h2>
	</div>
	<div class="col-md-6 text-right">
		<a href="" class="text-dark"><h2><?php echo $record['h2_tag2']; ?></h2></a>
	</div>
</div>
<iframe src="<?php echo base_url(); ?>assets/images/booking/<?php echo $record['pdf']; ?>" frameborder="0" width="100%" height="500"></iframe>
</div>