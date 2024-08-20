<style>
	.cat-navs {
		white-space: nowrap !important;
		overflow-x: auto !important;
		display: block;
		font-size: 0 !important;
		padding-bottom: 15px;
		overflow-y: hidden;
		text-align: center;
	}
	.cat-navs .nav-item {
		display: inline-block;
	}
	.cat-navs .nav-link{
		position: relative;
		display: inline-block;
		min-width: 115px;
		text-align: center;
		background: #3a2709;
		font-size: 14px;
		font-weight: 600;
		color: #fff !important;
		padding: 10px 20px !important;
		border-radius: 25px;
		border: 1px solid #c7a250;
		margin-left:10px;
	}
	.cat-navs .nav-link.active, .cat-navs .nav-link:hover{
		background-color:#c7a250;
	}
</style>
<img src="<?php echo base_url(); ?>assets/images/management/<?php echo $record['image']; ?>" alt="<?php echo $record['image_alt']; ?>" style="width:100%;max-height:400px">
<div class="container py-3 text-white" style="min-height:500px;">
	<h1 class="text-center color1 text-uppercase mb-3"><?php echo $record['h1_tag']; ?></h1>
	<ul class="nav nav-pills mb-3 justify-content-center cat-navs">
		<?php	
			if(!empty($categories)){
			foreach($categories as $key => $row){ 
		?>
		<li class="nav-item">
			<a class="nav-link mcat" id="mcat_<?php echo $row['id']; ?>" href="javascript:void(0)" onclick="showEmployees(<?php echo $row['id']; ?>)"><?php echo $row['name']; ?></a>
		</li>
		<?php }} ?>
	</ul>
	<div id="desc_div">
	<?php echo $record['description']; ?>
	</div>
	<div class="pt-3">
		<?php	
			if(!empty($categories)){
			foreach($categories as $key => $row){ 
			$pcol='col-md-12';
			if($row['display_count']=='2'){
				$pcol='col-md-6';
			}else if($row['display_count']=='3'){
				$pcol='col-md-4';
			}else if($row['display_count']=='4'){
				$pcol='col-md-3';
			}
		?>
		<div class="mdiv" id="mdiv_<?php echo $row['id']; ?>" style="display:none;">
			<div class="row">
			<?php	
				if(!empty($row['employees'])){
				foreach($row['employees'] as $key1 => $row1){
			?> 			
			<div class="<?php echo $pcol; ?> col-sm-6 mb-3 text-center">
				<img src="<?php echo base_url(); ?>assets/images/management/<?php echo $row1['image']; ?>" alt="<?php echo $row1['image_alt']; ?>" style="width:200px;height:200px;border-radius:50%;">
				<h5 class="my-2"><?php echo $row1['name']; ?></h5>
				<div><?php echo $row1['designation']; ?></div>
			</div>
			<?php }} ?>
			</div>
			<?php echo $row['description']; ?>
		</div>
		<?php }} ?>
	</div>
</div>
<script>
	function showEmployees(id){
		if($("#mdiv_"+id).is(":visible")){
			$(".mdiv").hide();
			$(".mcat").removeClass("active");
			$("#desc_div").show();
		}else{		
			$(".mdiv").hide();
			$(".mcat").removeClass("active");
			$("#desc_div").hide();	
			$("#mdiv_"+id).show();
			$("#mcat_"+id).addClass("active");
		}
	}
</script>