<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/foundation/js/foundation.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/favico.js/favico.min.js'); ?>"></script>

<?php
	if ($content_view === 'content/main' || (uri_seg(1) === 'product' && $content_view === 'front-end/detail')) { ?>
		<script src="<?php echo base_url('assets/plugin/bxslider/jquery.bxslider.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/plugin/fancybox/source/jquery.fancybox.js'); ?>"></script> <?php
	}
	if (uri_seg(1) === 'product') { ?>
		<script src="<?php echo base_url('assets/plugin/fancybox/source/jquery.fancybox.js'); ?>"></script> <?php
	}
	else if ($content_view === 'front-end/account') { ?>
		<script src="<?php echo base_url('assets/js/jquery.uploadPreview.min.js'); ?>"></script> <?php
	}
	else if ($content_view === 'front-end/transfer' || $content_view === 'front-end/transfercustom') { ?>
		<script src="<?php echo base_url('assets/plugin/timepicker/dist/jquery-ui-sliderAccess.js'); ?>"></script>
		<script src="<?php echo base_url('assets/plugin/timepicker/dist/jquery-ui-timepicker-addon.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/plugin/timepicker/dist/i18n/jquery-ui-timepicker-th.js'); ?>"></script> <?php
	}
?>