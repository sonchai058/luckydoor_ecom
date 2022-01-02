<?php 
	$payments 			=  array(
		'paypal' 		=> array(
			'img' 		=> 'paypal.png', 
		), 
		'ebay' 			=> array(
			'img' 		=> 'ebay.png', 
		), 
		'cirrus' 		=> array(
			'img' 		=> 'cirrus.png', 
		), 
		'mastercard' 	=> array(
			'img' 		=> 'mastercard.png', 
		), 
		'visa' 			=> array(
			'img' 		=> 'visa.png', 
		), 
		'discover' 		=> array(
			'img' 		=> 'discover.png', 
		), 
		'google-wallet' => array(
			'img' 		=> 'google-wallet.png', 
		), 
		'maestro' 		=> array(
			'img' 		=> 'maestro.png', 
		), 
	);
	$pay_attr 			=  array(
		'' 				=> '', 
	);
?>
<div class="page-header">
	<h4><p class="text-center">วิธีชำระเงิน</p></h4>
</div>
<div class="row">
	<?php
		foreach ($payments as $key => $value) { ?>
			<div class="col-xs-3 col-md-3">
				<a class="thumbnail">
					<img src="<?php echo base_url('assets/images/ecommerce-icons/'.$value['img']); ?>" alt="<?php echo ucfirst(strtolower($key)); ?>" title="<?php echo ucfirst(strtolower($key)); ?>">
				</a>
			</div> <?php
		}
	?>
</div>