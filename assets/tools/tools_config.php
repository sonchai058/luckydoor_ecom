<link rel="stylesheet" href="<?php echo base_url('assets/plugin/foundation/css/foundation.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/reset.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/fontsset.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/admin/css/hover.css'); ?>">


<?php
	if ($content_view === 'content/main' || (uri_seg(1) === 'product' && $content_view === 'front-end/detail')) { ?>
		<link rel="stylesheet" href="<?php echo base_url('assets/plugin/bxslider/jquery.bxslider.css'); ?>"> <?php
	}
	if ($content_view === 'front-end/product' ||
		(uri_seg(1) === 'product' 	&& $content_view === 'front-end/detail') ||
		(uri_seg(1) === 'member' 	&& $content_view === 'front-end/wishlist')) { ?>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/product.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/plugin/fancybox/source/jquery.fancybox.css'); ?>"> <?php
	}
	if ($content_view === 'front-end/account') { ?>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/image-preview.css'); ?>"> <?php
	}
	if ($content_view === 'front-end/transfer' || $content_view === 'front-end/transfercustom') { ?>
		<link rel="stylesheet" href="<?php echo base_url('assets/plugin/timepicker/dist/jquery-ui-timepicker-addon.min.css'); ?>"> <?php
	}
	if ($content_view !== 'content/main' || $content_view !== 'front-end/product') { ?>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style-1.css'); ?>"> <?php
	}
?>