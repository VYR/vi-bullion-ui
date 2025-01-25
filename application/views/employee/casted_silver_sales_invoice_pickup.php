<html>
<head>
<title>Invoice</title>
</head>
<body style="padding:20px;font-size:12px !important;">
<div style="text-align:right;">
	<div><b>ORIGINAL FOR RECIPIENT</b></div>
</div>
<table style="width:100%;font-size:12px !important;">
  <tr>
    <td style="width:30%;">
	<img src="<?php echo base_url(); ?>assets/images/logo/<?php echo $home_content['logo']; ?>" style="max-width:100%;max-height:80px;">
	</td>
    <td style="width:60%;text-align:center;">
		<h3 style="margin-top:0;margin-bottom:20px;font-size:20px;">PICKUP INVOICE</h3>
		<h3 style="margin-top:0;margin-bottom:20px;font-size:18px;">VIINDHYA BULLION PRIVATE LIMITED</h3>
		<h3 style="margin-top:0;margin-bottom:20px;font-size:16px;">Corporate Office Address</h3>
		<div>8-3-167/D/204, Flat No. G3, Sai Sadan, Beside ICICI ATM, Kalyan Nagar, Phase 1, Hyderabad, Telangana - 500038, INDIA.</div>
	</td> 
    <td style="width:30%;">
		<img src="<?php echo base_url(); ?>assets/images/casted/<?php echo $record['qr_code']; ?>" style="width:200px;height:200px;">
	</td>
  </tr>
</table>
<div style="width:100%;float:left;font-size:12px !important;">
    <div style="width:25%;float:left;">
		<div><b>IRN No :</b> <?php echo $record['irn_no']; ?></div>
		<div><b>GSTIN No :</b> 36AAICV0602Q1Z1</div>
		<div><b>CIN :</b> U51398TG2021PTC151354</div>
	</div>
    <div style="width:25%;float:left;">
		<div><b>State Code :</b> 36</div>
		<div><b>PAN No :</b> AAICV0602Q</div>
	</div>
    <div style="width:25%;float:left;">
		<?php 		
			$invoice_id=$record['invoice_id'];
			$invoice_id_final=$invoice_id;
			if(strlen($invoice_id)==1){
				$invoice_id_final='000'.$invoice_id;
			}else if(strlen($invoice_id)==2){
				$invoice_id_final='00'.$invoice_id;
			}else if(strlen($invoice_id)==3){
				$invoice_id_final='0'.$invoice_id;
			}
		?>
		<div><b>Bill No :</b> VBTI<?php echo date('my'); ?><?php echo $invoice_id_final; ?></div>
	</div>
    <div style="width:25%;float:left;text-align:center;">
		<div><b>Date :</b> <?php echo date("d-M-Y", strtotime($record['order_date_time'])); ?></div>
	</div>
</div>
<table style="width:100%;float:left;border-collapse:collapse;">
	<tr>
		<td style="width:50%;float:left;border:1px solid #000;padding:5px;">
			<div>Applicability of reverse charge :</div>
			<div><b>Bill to</b></div>
			<div>Name : <?php echo $record['buyer_name']; ?></div>
			<div>Address : <?php echo $record['buyer_address']; ?></div>
			<div>State : <?php echo $record['buyer_state']; ?></div>
			<div>State Code : <?php echo $record['buyer_state_code']; ?></div>
			<div>GSTIN No : <?php echo $record['buyer_gst_no']; ?></div>
			<div>PAN No : <?php echo $record['buyer_pan_number']; ?></div>
		</td>
		<td style="width:50%;float:left;border:1px solid #000;padding:5px;">
			<div>Place of Supply : <?php echo $record['pickup_state_code']=='36'?'Intra':'Inter'; ?> State Supply - <?php echo $record['pickup_state']; ?></div>
			<div><b>Delivery / Vaulting At :</b></div>
			<div>Name : <?php echo $record['buyer_name']; ?></div>
			<div>Address : <?php echo $record['pickup_dealer_address']; ?></div>
			<div>State : <?php echo $record['pickup_state']; ?></div>
			<div>State Code : <?php echo $record['pickup_state_code']; ?></div>
			<div>Aadhar No : <?php echo $record['buyer_aadhar_number']; ?></div>
			<div>Mobile No : <?php echo $record['buyer_mobile']; ?></div>
		</td>
	</tr>
	<tr>
		<td style="width:50%;float:left;border:1px solid #000;padding:5px;">
			<div>Transporter : </div>
			<div>Mode of Dispatch : BY HAND</div>
		</td>
		<td style="width:50%;float:left;border:1px solid #000;padding:5px;">
			<div>Truck No : NA</div>
			<div>Delivery Type : DDL-DOOR DELIVERY LOCAL</div>
		</td>
	</tr>
</table>
<table style="width:100%;border-collapse:collapse;font-size:12px !important;vertical-align:top;">
  <tr>
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">S.NO</th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">DESCRIPTION OF<br>GOODS/SERVICES</th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">Total<br>Wt<br>(gms)</th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">QTY<br>(Pcs)</th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">Rate/Pc<br>(INR)</th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">Total<br>(INR)</th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">Taxable<br>Value<br>(INR)</th>
	<?php if($record['pickup_state_code']=='36'){ ?>	 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">CGST (1.5 %)<br>Amount</th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">SGST (1.5 %)<br>Amount</th> 
	<?php }else{ ?>		
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">IGST (3 %)<br>Amount</th> 
	<?php } ?>		
  </tr>
  <?php
	$prices=array();
	$gsts=array();
	if(!empty($order_products)){
	foreach($order_products as $key=>$row){
	$price=$row['price'];
	$price1=$price/1.03;
	$gst=$price-$price1;
	$tgst=$gst*$row['qty'];
	$cgst=$tgst/2;
	$total_price=$price1*$row['qty'];
	$prices[]=$total_price;
	$gsts[]=$tgst;
  ?>
  <tr>
    <td style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;"><?php echo $key+1; ?></td> 
    <td style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">
		<div>HSN : <?php echo $record['hsn_code']; ?></div>
		<div>Commodity Name :</div>
		<div><?php echo $row['name']; ?></div>
		<div><?php echo $row['purity']; ?></div>
		<div><?php echo $row['purity_percentage']; ?></div>
	</td>
    <td style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;"><?php echo $row['weight']; ?></td> 
    <td style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;"><?php echo $row['qty']; ?></td> 
    <td style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;"><?php echo round($price1,2); ?></td> 
    <td style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">
		<?php echo round($total_price,2); ?>
	</td> 
    <td style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">
		<?php echo round($total_price,2); ?>
	</td> 
	<?php if($record['pickup_state_code']=='36'){ ?>	
    <td style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">
		<?php 
			if($record['pickup_state_code']=='36'){
				echo round($cgst,2);
			}
		?>
	</td> 
    <td style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">
		<?php 
			if($record['pickup_state_code']=='36'){
				echo round($cgst,2);
			}
		?>
	</td> 
	<?php }else{ ?>		
    <td style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">
		<?php 
			if($record['pickup_state_code']=='36'){
				echo round($tgst,2);
			}
		?>
	</td> 
	<?php } ?>		
  </tr>
	<?php }} ?>
  <tr>
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;"></th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;"></th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;"></th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;"></th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;"></th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">
		<?php 
		$tprices=array_sum($prices);
		echo round($tprices,2); 
		?>
	</th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">
		<?php 
		$tprices=array_sum($prices);
		echo round($tprices,2); 
		?>
	</th> 
	<?php if($record['pickup_state_code']=='36'){ ?>	
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;"></th> 
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">
		<?php 
		$tgsts=array_sum($gsts);
		echo round($tgsts,2); 
		?>
	</th>  
	<?php }else{ ?>		
    <th style="border: 1px solid black;border-collapse:collapse;padding:5px;text-align:center;">
		<?php 
		$tgsts=array_sum($gsts);
		echo round($tgsts,2); 
		?>
	</th> 
	<?php } ?>	 
  </tr>
</table> 
<table style="width:100%;">
	<tr>
		<th style="padding-top:5px;text-align:left;">Total TCS Value (0.1 %)</th>
		<td style="padding-top:5px;text-align:left;">: <?php echo $record['tcs_value']; ?>@</td>
	</tr>
	<tr>
		<th style="padding-top:5px;text-align:left;">Total Value</th>
		<td style="padding-top:5px;text-align:left;">: <?php echo $record['total_amount']; ?></td>
	</tr>
	<tr>
		<th style="padding-top:5px;text-align:left;">Discount Value</th>
		<td style="padding-top:5px;text-align:left;">: <?php echo $record['coupon_amount']; ?></td>
	</tr>
	<tr>
		<th style="padding-top:5px;text-align:left;">Invoice Value (In Figure)</th>
		<td style="padding-top:5px;text-align:left;">: <?php echo $record['final_amount']; ?></td>
	</tr>
	<tr>
		<th style="padding-top:5px;text-align:left;">Invoice Value (In Words)</th>
		<td style="padding-top:5px;text-align:left;">: 
		<?php
			$number=$record['final_amount'];
			$decimal = round($number - ($no = floor($number)), 2) * 100;
			$hundred = null;
			$digits_length = strlen($no);
			$i = 0;
			$str = array();
			$words = array(0 => '', 1 => 'one', 2 => 'two',
			3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
			7 => 'seven', 8 => 'eight', 9 => 'nine',
			10 => 'ten', 11 => 'eleven', 12 => 'twelve',
			13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
			16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
			19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
			40 => 'forty', 50 => 'fifty', 60 => 'sixty',
			70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
			$digits = array('', 'hundred','thousand','lakh', 'crore');
			while( $i < $digits_length ) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += $divider == 10 ? 1 : 2;
			if ($number) {
			$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
			$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
			$str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
			} else $str[] = null;
			}
			$Rupees = implode('', array_reverse($str));
			$paise = ($decimal > 0) ? " and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
			echo ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
		?>
		</td>
	</tr>
	<tr>
		<th style="padding-top:5px;text-align:left;">Total Receivable</th>
		<td style="padding-top:5px;text-align:left;">: <?php echo $record['final_amount']; ?></td>
	</tr>
</table>
<div style="width:100%;float:left;font-size:12px !important;margin-top:30px;">
    <div style="width:50%;float:left;">
		<div style="margin-bottom:30px;font-weight:600;">Remarks 1:</div>
		<div style="margin-bottom:30px;font-weight:600;">Remarks 2:</div>
		<div style="margin-bottom:30px;font-weight:600;">Remarks 3:</div>
	</div>
    <div style="width:50%;float:left;text-align:center;">
		<div style="font-size:16px;margin-bottom:50px;">For VIINDHYA BULLION PRIVATE LIMITED</div>
		<div style="font-size:14px;">Authorised Signatory</div>
	</div>
</div>
</body>
</html>
