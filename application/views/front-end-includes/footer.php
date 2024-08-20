<?php
	$this->load->model(array('Common_model','Admin_model'));
	$home_content = $this->Common_model->get_record('tbl_home_content', '*', array('id'=>1),2);
?>
<div class="container-fluid px-0 border-top nbr2">
	<div class="container pt-5" >
	<div class="row" >
	   <div class="col-md-4 mb-3 text-white">
			<h6><b>QUICK LINKS</b></h6>
			<a class="qlinks text-white text-uppercase" href="<?php echo site_url(); ?>management">Management</a><br/>
			<a class="qlinks text-white text-uppercase" href="<?php echo site_url(); ?>selling-authority">Selling Authority</a><br/>
			<a href="<?php echo base_url(); ?>terms-and-conditions" class="qlinks text-white text-uppercase">TERMS &amp; CONDITIONS</a><br/>
			<a href="<?php echo base_url(); ?>privacy-policy" class="qlinks text-white text-uppercase">PRIVACY POLICY</a><br/>
			<a href="<?php echo base_url(); ?>pickup-point" class="qlinks text-white text-uppercase">Pickup Point</a><br/>
			<!--<a href="<?php echo base_url(); ?>pickup-dashboard" class="qlinks text-white text-uppercase">Pickup Dashboard</a><br/>-->
			<a href="<?php echo base_url(); ?>casted-gold-dashboard" class="qlinks text-white text-uppercase">Employee Dashboard</a><br/>
			<?php if (!empty($this->session->userdata('casted_gold_user'))){ ?>
			<a href="<?php echo base_url(); ?>casted-gold-user-dashboard" class="qlinks text-white text-uppercase">User Dashboard</a><br/>
			<a href="<?php echo base_url(); ?>casted-gold-logout" class="qlinks text-white text-uppercase">Logout</a>
			<?php }else if (!empty($this->session->userdata('casted_silver_user'))){ ?>
			<a href="<?php echo base_url(); ?>casted-silver-user-dashboard" class="qlinks text-white text-uppercase">User Dashboard</a><br/>
			<a href="<?php echo base_url(); ?>casted-silver-logout" class="qlinks text-white text-uppercase">Logout</a>
			<?php } ?>
	   </div>
	   <div class="col-md-4 mb-3 text-center text-md-left pt-md-5">
			<a href="<?php echo site_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/logo/<?php echo $home_content['footer_logo']; ?>" alt="<?php echo $home_content['footer_logo_alt']; ?>" height="70"></a>
	   </div>
	   <div class="col-md-4 mb-3 text-white">
			<h6><b>CORPORATE ADDRESS</b></h6>
			<p><i class="fa fa-map-marker"></i>  <?php echo $home_content['address']; ?></p>
			<p><i class="fa fa-phone"></i>  <?php echo $home_content['mobile']; ?></p>
			<p><i class="fa fa-envelope"></i>  <?php echo $home_content['email']; ?></p>
	   </div>  
	</div>
	</div>
</div>
<div class="container-fluid py-3 text-white text-center">
	<?php echo $home_content['rights_reserved']; ?>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/common/js/jquery.toast.js"></script>
<?php
echo $this->session->flashdata('success');
if($this->session->flashdata('success') != '')
{
$msg = $this->session->flashdata('success');
$heading = 'Success';
$icon = 'success';
}else
if ($this->session->flashdata('error') != '')
	{
	$msg = $this->session->flashdata('error');
	$heading = 'Error';
	$icon = 'error';
	}
  else
if (isset($error) && $error != '')
	{
	$msg = $error;
	$heading = 'Error';
	$icon = 'error';
	}
  else
if (isset($success) && $success != '')
	{
	$msg = $success;
	$icon = 'success';
	$heading = 'Success';
	}else{
		$msg = '';
$icon = '';
$icon = '';

	}
?>
<script>
	<?php
	if ($msg != '')
	{ ?>
		$.toast({heading: '<?php echo $heading; ?>',text: '<?php echo $msg; ?>',showHideTransition: 'fade',position: 'top-right',icon: '<?php echo $icon; ?>'});
	<?php
	} ?>
</script>
</body>
</html>
