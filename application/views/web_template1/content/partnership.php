<?php
	$partnerships 		=  array(
		'homeworks' 	=> array(
			'url' 		=> 'http://www.homeworks.co.th/index.html',
			'img' 		=> 'homeworks.png',
		),
		'globalhouse' 	=> array(
			'url' 		=> 'http://www.globalhouse.co.th/',
			'img' 		=> 'globalhouse.png',
		),
		'thaiwatsadu' 	=> array(
			'url' 		=> 'http://www.thaiwatsadu.com/index.html',
			'img' 		=> 'thaiwatsadu.png',
		),
		'homepro' 		=> array(
			'url' 		=> 'http://www.homepro.co.th/',
			'img' 		=> 'homepro.png',
		),
	);
	$partner_attr 		=  array(
		'target'		=> '_blank',
	);
?>
<div class="row">
	<?php
		foreach ($partnerships as $key => $value) { ?>
			<div class="col-xs-3 col-md-3">
				<a href="<?php echo $value['url']; ?>" class="thumbnail" target="<?php echo $partner_attr['target']; ?>">
					<img src="<?php echo base_url('assets/images/partnership-logos/'.$value['img']); ?>" alt="<?php echo ucfirst(strtolower($key)); ?>" title="<?php echo ucfirst(strtolower($key)); ?>">
				</a>
			</div> <?php
		}
	?>
</div>