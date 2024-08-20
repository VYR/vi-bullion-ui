<?php
	$this->load->model(array('Common_model','Admin_model'));
	$home_content = $this->Common_model->get_record('tbl_home_content', '*', array('id'=>1),2);
	$url=$this->uri->segment(1);	
	$cid=0;
	if($url=='casted-gold'){
		$cid=1;
	}else if($url=='minted-gold'){
		$cid=2;
	}else if($url=='casted-silver'){
		$cid=4;
	}else if($url=='minted-silver'){
		$cid=5;
	}
	$category_content = $this->Common_model->get_record('tbl_categories', '*', array('id'=>$cid),2);
?><!DOCTYPE html>
<html lang="en">
<head>
	<?php if(!empty($seo_tags)){ ?>
	<title><?php echo $seo_tags['title']; ?></title>
	<meta name="description" content="<?php echo $seo_tags['meta_description']; ?>">
	<?php echo $seo_tags['meta_tags']; ?>
	<?php } ?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/admin/error.js"></script>
	<style>
		body {
			font-family: "open sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
			font-size: 15px !important;
		}

		a:hover {
			text-decoration: none !important;
		}

		a:active {
			background: none !important;
		}

		*:focus,
		.form-control:focus,
		.btn:focus {
			outline: none !important;
			-webkit-box-shadow: none !important;
			box-shadow: none !important;
			border-color: #ced4da !important;
		}
		.f16{
			font-size:16px !important;
		}
		.f18{
			font-size:18px !important;
		}
		.bg1{
			background-color:#524528 !important
		}
		.color1{
			color:#c7a250 !important
		}
		.hnav .nav-link{
			font-weight:600 !important;
			color:#fff !important;
			text-transform: uppercase!important;
		}
		@media (max-width: 500px){
		.vidht {
		height: 200px !important;
		}
		}

		.vidht {
		height: 600px;
		}
		table{
			width:100% !important;
		}
		.hpage img{
			width:100% !important;
		}
		.err-msg
		{
			color:red;
			font-weight:bold;
		}
		.success-msg
		{
			color:green;
			font-weight:bold;
		}
		label{
			font-weight:600;
			margin-bottom:0px;
		}
		.login-text img{
			width:100% !important;
			height:auto !important;
		}
		.scroll-text p{
			margin:0px !important;
		}
		
	.social_icon-fixed {
    position: fixed;
    right: 0px;
    top: 35%;
    width: 35px;
    float: right;
    z-index: 20px;
    z-index: 888;
	}
	.social_icon-fixed .arrow {
		background: url(<?php echo base_url(); ?>assets/images/social-icon-arrow.png) right top no-repeat;
		width: 35px;
		height: 35px;
		cursor: pointer;
		float: right;
		border: 1px solid #efefef;
	}
	.social-box ul {
		width: 35px;
	}
	.social-box ul li {
		width: 35px;
		float: left;
		list-style-type: none;
	}
	.social-box a:hover {
		width: 155px;
	}
	.social-box a.facebook {
		background: url(<?php echo base_url(); ?>assets/images/social-icon1.png) right top no-repeat;
	}
	.social-box a.twitter {
		background: url(<?php echo base_url(); ?>assets/images/social-icon2.png) right top no-repeat;
	}
	.social-box a.instatram {
		background: url(<?php echo base_url(); ?>assets/images/social-icon5.png) right top no-repeat;
	}
	.social-box a.youtube {
		background: url(<?php echo base_url(); ?>assets/images/social-icon11.png) right top no-repeat;
	}
	.social-box a.printrest {
		background: url(<?php echo base_url(); ?>assets/images/social-icon7.png) right top no-repeat;
	}
	.social-box a.linkedin {
		background: url(<?php echo base_url(); ?>assets/images/social-icon4.png) right top no-repeat;
	}
	.social-box a.google-plus {
		background: url(<?php echo base_url(); ?>assets/images/social-icon3.png) right top no-repeat;
	}
	.social-box a {
		float: right;
		width: 35px;
		height: 35px;
		-webkit-transition: all 0.2s;
		-moz-transition: all 0.2s;
		-o-transition: all 0.2s;
		transition: all 0.2s;
	}
	.social-box a {
		/*color: #554d2f;*/
		text-decoration: none;
	}
	.social-box a, button {
		-ms-touch-action: manipulation;
		touch-action: manipulation;
	}
	.social_icon-fixed *, *:before, *:after {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
		margin: 0;
		padding: 0;
	}
	.social_icon-fixed * {
		outline: none;
	}
	.social_icon-fixed * {
		outline: 0px !important;
	}
	.btm-divs{
		position:absolute;
		left:0;
		bottom:0px;
		width:100%;
	}
	.btm-div{
		opacity: 0.7;
		background-color: #080808 !important;
		border: solid 2px #cfa04f !important;
		border: solid 2px var(--sand-brown);
		border-radius: 0px;
		padding: 5% 5% !important;
		min-height: 252px;
		color: white;
	}
	@media (max-width:500px){
	.btm-divs{
		margin-top:15px;
		position:relative;
	}
	.fm12{
		font-size:12px !important;
	}
	}
	@media (min-width:500px){
	.hnav .nav-link.active{
		background-color:#fff;
		color:#524528 !important;
	}
	}
	.qlinks{		
		transition: all ease-in 0.3s;
	}
	.qlinks:hover{		
		padding-left:8px;
		color:#b67f0c !important;
	}
	.pdiv:hover{		
		border:1px solid #524528 !important;
	}
	.f14{
		font-size:14px;
	}
	.f12{
		font-size:12px !important;
	}
	.bg2{
		background-color:#c6ab1e;
	}
		.nbg1{
			background-color:#3a2709 !important;
		}
		.nbr1{
			border-color:#3a2709 !important;
		}
		.ncolor1{
			color:#3a2709 !important;
		}
		.nbg2{
			background-color:#c7a250 !important;
		}
		.nbr2{
			border-color:#c7a250 !important;
		}
		.ncolor2{
			color:#c7a250 !important;
		}
		.nbg3{
			background-color:#c5c5c5 !important;
		}
		.nbr3{
			border-color:#c5c5c5 !important;
		}
		.ncolor3{
			color:#c5c5c5 !important;
		}
		.nbg4 {
			background-color:#281b08 !important;
		}
		.blinkclr1{
			color:#ff0000;
		}
		.blinkclr2{
			color:#00ff00 !important;
		}
		.buy-btn{
			font-size:14px;
			color:#fff;
			background-color: #c7a250 !important;
			border:1px solid #c7a250 !important;
		}
		.buy-btn:hover{
			background-color: #3a2709 !important;
			color:#fff;
		}
		.silver-btn{
			font-size:14px;
			color:#fff;
			background-color: #c5c5c5 !important;
			border:1px solid #c5c5c5 !important;
		}
		.silver-btn:hover{
			background-color: #3a2709 !important;
			color:#fff;
		}
		.abt-btn{
			font-size:14px;
			color:#fff;
			background-color: #c7a250 !important;
			border:1px solid #c7a250 !important;
		}
		.abt-btn:hover{
			background-color: #3a2709 !important;
			color:#fff;
		}
		.lh1{
			line-height:1;
		}
		.table-condensed>tbody>tr>td, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>td, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>thead>tr>th {
			padding: 5px;
		}
		.datepicker td, .datepicker th {
			text-align: center;
			width: 20px;
			height: 20px;
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
			border: none;
			cursor:pointer;
			font-size:14px;
		}
		.datepicker table tr td.day.focused, .datepicker table tr td.day:hover {
			background: #eee;
		}
		.datepicker td.active {
			background-color: #04c;
			color: #fff;
		}
		#order_btn, #search_form .abt-btn, #search_form .silver-btn{
			margin-bottom:15px;
		}
		.live_rates{
			display:none;
		}
	</style>
</head>
<body class="nbg1">  
<div class="social_icon-fixed">	
<!--<div class="arrow"></div>	-->
<div class="social-box">		
<ul>		
<li><a href="https://www.facebook.com/" target="_blank" class="facebook"></a></li>	
<li><a href="https://twitter.com/" target="_blank" class="twitter"></a></li>

<li><a href="https://www.instagram.com/" target="_blank" class="instatram"></a></li>		
<li><a href="https://m.youtube.com/" target="_blank" class="youtube"></a></li>	
<li><a href="https://www.pinterest.ca/" target="_blank" class="printrest"></a></li>	
</ul>		
</div>	
</div>
<div class="shadow sticky-top">
<div class="container-fluid bg-white px-0">
	<div class="container py-2">
		<div class="row">
			<div class="col-md-4 col-4 pr-0 text-left text-md-left">
				<a href="<?php echo site_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/logo/<?php echo $home_content['logo']; ?>" alt="<?php echo $home_content['logo_alt']; ?>" style="max-width:100%;max-height:70px;"></a>
			</div>
			<div class="col-md-4 col-6 pl-2 pr-0 text-right text-md-center">
				<div class="d-flex pt-md-2">
					<div class="d-none d-md-inline-block mr-1 font-weight-bold ncolor1 pt-3">
						Authorized Outright Dealer for MMTC - PAMP
					</div>
					<div class="d-inline-block d-md-none mr-1 font-weight-bold ncolor1">
						<div>Authorised</div>
						<div>Outright dealer</div>
						<div>MMTC - PAMP</div>
					</div>
					<div>
						<img src="<?php echo base_url(); ?>assets/images/mmtc.jpg" style="max-height:50px;">
					</div>
				</div>
			</div>
			<div class="col-md-4 col-2 text-right d-block d-md-none">
				<button class="btn pb-0 color1 border-0" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" style="font-size: 24px;"><i class="fa fa-bars"></i></button>
			</div>
			<div class="col-md-4 d-none d-md-block ncolor1 pt-md-2">
				<span class="float-right">
				<div class="mb-1">
					<i class="fa fa-phone"></i> <?php echo $home_content['mobile']; ?>
				</div>
				<div>
					<i class="fa fa-envelope-o"></i> <?php echo $home_content['email']; ?>
				</div>
				</span>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid nbg1 px-0">
	<div class="container">
		<nav class="navbar navbar-expand-md p-0 navbar-dark">
		<!--<a class="navbar-brand d-inline-block d-md-none" href="<?php echo site_url(); ?>">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
		<span class="navbar-toggler-icon"></span>
		</button>-->
		<div class="collapse navbar-collapse" id="collapsibleNavbar">
		<ul class="navbar-nav hnav mx-auto lh1">
			<li class="nav-item">
			<a class="nav-link d-none d-md-inline-block <?php if($this->uri->segment(1)==''){ echo 'active'; } ?>" href="<?php echo site_url(); ?>">Home</a>
			</li>   
			<li class="nav-item">
			<a class="nav-link <?php if($this->uri->segment(1)=='about'){ echo 'active'; } ?>" href="<?php echo site_url(); ?>about">About Us</a>
			</li>   
			<li class="nav-item">
			<a class="nav-link <?php if($this->uri->segment(1)=='management'){ echo 'active'; } ?>" href="<?php echo site_url(); ?>management">Management</a>
			</li>  
			<li class="nav-item">
			<a class="nav-link <?php if($this->uri->segment(1)=='our-supporters'){ echo 'active'; } ?>" href="<?php echo site_url(); ?>our-supporters">Our Supporters</a>
			</li>    
			<li class="nav-item">
			<a class="nav-link <?php if($this->uri->segment(1)=='vi-grants'){ echo 'active'; } ?>" href="<?php echo site_url(); ?>vi-grants">VI Grants</a>
			</li>       
			<li class="nav-item">
			<a class="nav-link <?php if($this->uri->segment(1)=='vi-save'){ echo 'active'; } ?>" href="<?php echo site_url(); ?>vi-save">VI Save</a>
			</li>   
			<li class="nav-item">
			<a class="nav-link <?php if($this->uri->segment(1)=='contact'){ echo 'active'; } ?>" href="<?php echo site_url(); ?>contact">Contact us</a>
			</li>    
			<li class="nav-item">
			<a class="nav-link <?php if($this->uri->segment(1)=='faqs'){ echo 'active'; } ?>" href="<?php echo site_url(); ?>faqs">FAQS</a>
			</li>    
			<!--<li class="nav-item">
			<a class="nav-link <?php if($this->uri->segment(1)=='casted-register'){ echo 'active'; } ?>" href="<?php echo site_url(); ?>casted-register">Casted</a>
			</li>     
			<li class="nav-item">
			<a class="nav-link <?php if($this->uri->segment(1)=='minted-register'){ echo 'active'; } ?>" href="<?php echo site_url(); ?>minted-register">Minted</a>
			</li>  -->
		</ul>
		</div>  
		</nav>
	</div>
</div>
<div class="container-fluid nbg2 p-1 lh1">
	<?php if(!empty($category_content)){ ?>
	<a href="<?php echo site_url().$url; ?>" class="text-white f14 font-weight-bold"><marquee onmouseover="this.stop();" onmouseout="this.start();"><?php echo $category_content['scrolling_text']; ?></marquee></a>
	<?php }else{ ?>
	<a href="<?php echo site_url(); ?>casted-gold" class="text-white f14 font-weight-bold"><marquee onmouseover="this.stop();" onmouseout="this.start();"><?php echo $home_content['scrolling_text']; ?></marquee></a>
	<?php } ?>
</div>
</div>
