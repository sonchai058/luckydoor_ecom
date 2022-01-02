<?php
	$frst_val = 0;
	$prev_val = 0;
	$next_val = 0;
	$last_val = 0;
	$where = " `$field_allow` != '3' ";
	if (uri_seg(3) == 'order_doing_unannounce'	) $where = " `$field_allow` IN ('1','4'	) ";
	if (uri_seg(3) == 'order_doing_announced'	) $where = " `$field_allow` IN ('5','6'	) ";
	if (uri_seg(3) == 'order_history_success'	) $where = " `$field_allow` IN ('7'		) ";
	if (uri_seg(3) == 'order_history_cancel'	) $where = " `$field_allow` IN ('2','3'	) ";
	$frsts = $this->common_model->custom_query(" SELECT `$field_key` FROM `$table` WHERE `$field_key` = (SELECT MIN(`$field_key`) FROM `$table` WHERE {$where}) ");
	$prevs = $this->common_model->custom_query(" SELECT `$field_key` FROM `$table` WHERE `$field_key` = (SELECT MAX(`$field_key`) FROM `$table` WHERE `$field_key` < $field_id AND {$where}) ");
	$nexts = $this->common_model->custom_query(" SELECT `$field_key` FROM `$table` WHERE `$field_key` = (SELECT MIN(`$field_key`) FROM `$table` WHERE `$field_key` > $field_id AND {$where}) ");
	$lasts = $this->common_model->custom_query(" SELECT `$field_key` FROM `$table` WHERE `$field_key` = (SELECT MAX(`$field_key`) FROM `$table` WHERE {$where}) ");
	if (count($frsts) > 0) { $frst_row = rowArray($frsts); $frst_val = $frst_row[$field_key]; }
	if (count($prevs) > 0) { $prev_row = rowArray($prevs); $prev_val = $prev_row[$field_key]; }
	if (count($nexts) > 0) { $next_row = rowArray($nexts); $next_val = $next_row[$field_key]; }
	if (count($lasts) > 0) { $last_row = rowArray($lasts); $last_val = $last_row[$field_key]; }
	$cancel_button 		= base_url(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3));
	$first_button 		= base_url(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3).'/'.uri_seg(4).'/'.$frst_val);
	$previous_button 	= base_url(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3).'/'.uri_seg(4).'/'.$prev_val);
	$next_button 		= base_url(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3).'/'.uri_seg(4).'/'.$next_val);
	$last_button 		= base_url(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3).'/'.uri_seg(4).'/'.$last_val);
	$print_button 		= base_url(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3).'/print/'.uri_seg(5));
?>
<div class="pDiv">
	<div class="form-button-box">
		<input type="button" value="กลับไปยังรายการ" class="cancel-button">
	</div>
	<div class="form-button-box"> <?php
		if (count($frsts) > 0 && $field_id !== $frst_val) { ?>
			<input type="button" value="<< First" class="first-button"> <?php
		}
		if (count($prevs) > 0) { ?>
			<input type="button" value=" < Prev " class="previous-button"> <?php
		}
		if (count($nexts) > 0) { ?>
			<input type="button" value=" Next > " class="next-button"> <?php
		}
		if (count($lasts) > 0 && $field_id !== $last_val) { ?>
			<input type="button" value="Last  >>" class="last-button"> <?php
		} ?>
	</div>
	<div class="form-button-box">
		<button class="print-button"><i class="fa fa-print"></i> PDF</button>
	</div>
</div>
<script>
	$(document).ready(function() {
  		$(".cancel-button").click(function() {
  			$(location).prop("href", "<?php echo $cancel_button; ?>");
  		});
  		$(".first-button").click(function() {
  			$(location).prop("href", "<?php echo $first_button; ?>");
  		});
  		$(".previous-button").click(function() {
  			$(location).prop("href", "<?php echo $previous_button; ?>");
  		});
  		$(".next-button").click(function() {
  			$(location).prop("href", "<?php echo $next_button; ?>");
  		});
  		$(".last-button").click(function() {
  			$(location).prop("href", "<?php echo $last_button; ?>");
  		});
  		$(".print-button").click(function() {
  			window.open("<?php echo $print_button; ?>", "_blank");
  			exit();
  		});
	});
</script>