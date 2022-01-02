<?php
	$this->permission_model->getOnceWebMain();
	$P_Name = rowArray($this->common_model->custom_query(
    	" SELECT * FROM `product` WHERE `P_ID` = '$P_ID' "
    ));
    $product = rowArray($this->common_model->custom_query(
    	" 	SELECT * FROM `product`
    		LEFT JOIN `product_stock` USING (`P_ID`)
    		WHERE `P_ID` = '$P_ID'
    		AND `PS_Allow` != '3'
    		ORDER BY `PS_DateTimeUpdate` DESC
    		LIMIT 1 "
    ));
    if (count($product) <= 0) {
    	$product['PS_Amount'] 		= 0;
    	$product['PS_FullSumPrice'] = 0;
    }
?>
<div class="various-grocery-lightbox">
	<div class="various-product-info">
		<label>ชื่อสินค้า: </label>
		<span id="P_Name"><?php if (isset($P_Name['P_Name']) && $P_Name['P_Name'] !== '' && isset($P_Name['P_IDCode']) && $P_Name['P_IDCode'] !== '') echo $P_Name['P_IDCode'].' ('.$P_Name['P_Name'].')'; ?></span>
	</div> <?php
	if ($PS_Price_amount === 'amount') { ?>
		<div class="various-input-textbox">
			<label>จำนวน: </label>
			<input type="hidden" id="PS_FullSumPrice" placeholder="ราคา" min="0" value="<?php if (isset($product['PS_FullSumPrice']) && $product['PS_FullSumPrice'] !== '') echo $product['PS_FullSumPrice']; else echo 0; ?>">
			<input type="number" id="PS_Amount" placeholder="จำนวน" min="0" value="<?php if (isset($product['PS_Amount']) && $product['PS_Amount'] !== '') echo $product['PS_Amount']; else echo 0; ?>">
		</div> <?php
	}
	else if ($PS_Price_amount === 'price') { ?>
		<div class="various-input-textbox">
			<label>ราคา: </label>
			<input type="number" id="PS_FullSumPrice" placeholder="ราคา" min="0" value="<?php if (isset($product['PS_FullSumPrice']) && $product['PS_FullSumPrice'] !== '') echo $product['PS_FullSumPrice']; else echo 0; ?>">
			<input type="hidden" id="PS_Amount" placeholder="จำนวน" min="0" value="<?php if (isset($product['PS_Amount']) && $product['PS_Amount'] !== '') echo $product['PS_Amount']; else echo 0; ?>">
		</div>
		<?php
	} ?>
	<div class="various-input-submit">
		<label></label>
		<input type="submit" id="PS_Confirm_button" value="บันทึก">
		<input type="button" id="PS_Cancel_button" 	value="ยกเลิก">
	</div>
</div>
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#PS_Confirm_button").click(function() {
			var Prie_Amot = "<?php echo $PS_Price_amount; ?>";
			var Amount_PS = parseInt("<?php echo $product['PS_Amount']; ?>");
			var Prices_PS = parseFloat("<?php echo $product['PS_FullSumPrice']; ?>");
			var Amount_LG = 0;
			var Prices_LG = 0;
			var Amount_TP = 3;
			var Prices_TP = 3;
			if ($("#PS_FullSumPrice").val() <= 0 || $("#PS_FullSumPrice").val() == '' || $("#PS_FullSumPrice").val() == null)
				$("#PS_FullSumPrice").val(0);
			if (Prie_Amot == 'amount') {
				if ($("#PS_Amount").val() < Amount_PS) {
					Amount_LG = Amount_PS - $("#PS_Amount").val();
					Amount_TP = 2;
				}
				else if ($("#PS_Amount").val() > Amount_PS) {
					Amount_LG = $("#PS_Amount").val() - Amount_PS;
					Amount_TP = 1;
				}
			}
			else if (Prie_Amot == 'price') {
				if ($("#PS_FullSumPrice").val() < Prices_PS) {
					Prices_LG = Prices_PS - $("#PS_FullSumPrice").val();
					Prices_TP = 2;
				}
				else if ($("#PS_FullSumPrice").val() > Prices_PS) {
					Prices_LG = $("#PS_FullSumPrice").val() - Prices_PS;
					Prices_TP = 1;
				}
			}
			var request = $.ajax({
	  			url: "<?php echo base_url('product/control_product/stock_changed'); ?>",
				method: "POST",
				data: {
					P_ID 			: "<?php echo $P_ID; ?>",
					PS_Price 		: $("#PS_FullSumPrice").val(),
					PS_Amount 		: $("#PS_Amount").val(),
					PS_Price_Log 	: Prices_LG,
					PS_Amount_Log 	: Amount_LG,
					PS_Price_Type	: Prices_TP,
					PS_Amount_Type	: Amount_TP,
				}
			});
			request.done(function(msg) {
				location.reload();
			});
			request.fail(function(jqXHR, textStatus) {
	  			alert("Request failed: " + textStatus);
			});
		});
		$("#PS_Cancel_button").click(function() {
			location.reload();
		});
	});
</script>