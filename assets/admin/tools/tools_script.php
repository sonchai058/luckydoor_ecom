<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>

<?php
	if (isset($content_view)) {
		if (gettype($content_view) == 'object') { ?>
			<script src="<?php echo base_url('assets/admin/js/grocery_flexigrid_custom.js'); ?>"></script>
			<script src="<?php echo base_url('assets/admin/js/grocery_datatable_custom.js'); ?>"></script> <?php
		}
	}
	if ($content_view === 'back-end/order_transfer_detail' || $content_view === 'back-end/order_detail') { ?>
		<script src="<?php echo base_url('assets/plugin/fancybox/source/jquery.fancybox.js'); ?>"></script> <?php
	}
?>