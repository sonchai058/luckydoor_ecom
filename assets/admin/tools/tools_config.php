<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/admin/css/images_sprites.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/admin/css/reset.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/admin/css/main.css'); ?>">

<?php
	if (uri_seg(1) == 'cart') { ?>
		<link rel="stylesheet" href="<?php echo base_url('assets/admin/css/hover.css'); ?>"> <?php
	}
	if ($content_view === 'back-end/order_transfer_detail' || $content_view === 'back-end/order_detail') { ?>
		<link rel="stylesheet" href="<?php echo base_url('assets/plugin/fancybox/source/jquery.fancybox.css'); ?>"> <?php
	}
?>