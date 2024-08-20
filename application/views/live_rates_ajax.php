<div class="row">
			<div class="col-md-8 mx-auto text-white">
				<h3 class="text-center mb-3 color1 live_rates">Live Rates</h3>
				<div class="row text-center">
					<div class="col-4 mb-3">
						<div class="nbg4 border nbr2 px-1 py-2 mb-1">
							<h6 class="mb-0 font-weight-bold">SPOT GOLD</h6>
						</div>
						<div class="nbg4 border nbr2 px-1 py-2 f12 font-weight-bold">
							<h5 class="mb-0 blinkclr2 blinkclr1 sprice">$<?php echo round($api_details[2]['Ask'],2); ?></h5>
							<div class="">H: <?php echo round($api_details[2]['High'],2); ?> / L: <?php echo round($api_details[2]['Low'],2); ?></div>
						</div>
					</div>
					<div class="col-4 mb-3 px-0">
						<div class="nbg4 border nbr2 px-1 py-2 mb-1">
							<h6 class="mb-0 font-weight-bold">SPOT SILVER</h6>
						</div>
						<div class="nbg4 border nbr2 px-1 py-2 f12 font-weight-bold">
							<h5 class="mb-0 blinkclr2 blinkclr1 sprice">$<?php echo round($api_details[3]['Ask'],2); ?></h5>
							<div class="">H: <?php echo round($api_details[3]['High'],2); ?> / L: <?php echo round($api_details[3]['Low'],2); ?></div>
						</div>
					</div>
					<div class="col-4 mb-3">
						<div class="nbg4 border nbr2 px-1 py-2 mb-1">
							<h6 class="mb-0 font-weight-bold">SPOT INR</h6>
						</div>
						<div class="nbg4 border nbr2 px-1 py-2 f12 font-weight-bold">
							<h5 class="mb-0 blinkclr2 blinkclr1 sprice"><i class="fa fa-inr"></i><?php echo round($api_details[4]['Ask'],2); ?></h5>
							<div class="">H: <?php echo round($api_details[4]['High'],2); ?> / L: <?php echo round($api_details[4]['Low'],2); ?></div>
						</div>
					</div>
				</div>
				<?php
					$ask=$api_details[0]['Ask']/10;
					$ask1=$ask+$gold_mcx['mcxa_value'];
					$ask_gst=($ask1*$gold_mcx['mcxb_value'])/100;
					$gask2=$ask1+$ask_gst+$gold_mcx['mcxc_value'];
					$gask2=$gask2;
					
					$ask=$api_details[5]['Ask'];
					$ask1=$ask+$silver_mcx['mcxa_value'];
					$ask_gst=($ask1*$silver_mcx['mcxb_value'])/100;
					$sask2=$ask1+$ask_gst+$silver_mcx['mcxc_value'];
				?>
				<div class="mb-3 text-white">
					<div class="border nbr2 p-2 mb-1">
						<h6 class="mb-0 font-weight-bold">GOLD (99.9%) PER 1GM</h6>
					</div>
					<div class="row">
						<div class="col-8">
							<div class="border nbr2 p-2">
								<h5 class="mb-0">ALL OVER INDIA</h5>
							</div>
						</div>
						<div class="col-4 pl-0">
							<div class="border nbr2 p-2">
								<?php if($gold_mcx['all_india_display']=='0'){ ?>
								<h5 class="mb-0"><i class="fa fa-inr"></i><?php echo round($gold_value,2); ?></h5>
								<?php }else{ ?>
								<h5 class="mb-0"><i class="fa fa-inr"></i><?php echo round($gask2,2); ?></h5>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="mb-3 text-white">
					<div class="border nbr2 p-2 mb-1">
						<h6 class="mb-0 font-weight-bold">SILVER (99.9%) PER 1KG</h6>
					</div>
					<div class="row">
						<div class="col-8">
							<div class="border nbr2 p-2">
								<h5 class="mb-0">ALL OVER INDIA</h5>
							</div>
						</div>
						<div class="col-4 pl-0">
							<div class="border nbr2 p-2">
								<?php if($silver_mcx['all_india_display']=='0'){ ?>
								<h5 class="mb-0"><i class="fa fa-inr"></i><?php echo round($silver_value,2)*1000; ?></h5>
								<?php }else{ ?>
								<h5 class="mb-0"><i class="fa fa-inr"></i><?php echo round($sask2,2); ?></h5>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row text-center">
					<div class="col-6 mb-3">
						<div class="nbg4 border nbr2 px-1 py-2 mb-1">
							<h6 class="mb-0 font-weight-bold">GOLD COSTING</h6>
						</div>
						<div class="nbg4 border nbr2 px-1 py-2 f12 font-weight-bold">
							<h5 class="mb-0 blinkclr2 blinkclr1 sprice"><?php echo round(($api_details[0]['Ask']),2); ?></h5>
							<div class="">H: <?php echo round($api_details[0]['High'],2); ?> / L: <?php echo round($api_details[0]['Low'],2); ?></div>
						</div>
					</div>
					<div class="col-6 mb-3">
						<div class="nbg4 border nbr2 px-1 py-2 mb-1">
							<h6 class="mb-0 font-weight-bold">SILVER COSTING</h6>
						</div>
						<div class="nbg4 border nbr2 px-1 py-2 f12 font-weight-bold">
							<h5 class="mb-0 blinkclr2 blinkclr1 sprice"><?php echo round($api_details[5]['Ask'],2); ?></h5>
							<div class="">H: <?php echo round($api_details[5]['High'],2); ?> / L: <?php echo round($api_details[5]['Low'],2); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>