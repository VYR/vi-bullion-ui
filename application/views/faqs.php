
<div class="container py-5 text-white" style="min-height:500px;">
<h1 class="text-center text-uppercase">FAQ's</h1>

	<?php	
		if(!empty($records)){
		foreach($records as $key => $row){ 
	?> 
		<div class="row">
			<div class="col-md-12 nbg2 text-white">
				<h2 class="m-0 py-1"><?php echo $row['name']; ?></h2>
			</div>	
			<?php	
				if(!empty($row['faqs'])){
				foreach($row['faqs'] as $fkey => $frow){ 
			?> 
			<div class="col-md-12 mb-3">
				<div class="p-3" data-toggle="collapse" data-target="#demo_<?php echo $key; ?>_<?php echo $fkey; ?>" aria-expanded="true" style=" padding: 10px;border-bottom: 1px solid #c7a250;" ><?php echo $frow['question']; ?> <i class="fa fa-plus float-right" aria-hidden="true"></i> </div>
				<div id="demo_<?php echo $key; ?>_<?php echo $fkey; ?>" class="collapse " style="
				padding: 13px;
				">
				<div ><?php echo $frow['answer']; ?></div>
				</div>
			</div>	
			<?php }}  ?>	
		</div>
	<?php }}  ?>
</div>

