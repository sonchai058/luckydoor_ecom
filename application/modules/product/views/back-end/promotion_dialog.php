<?php 
	$this->permission_model->getOnceWebMain();
    $product = rowArray($this->common_model->custom_query(
    	" 	SELECT * FROM `product` 
    		LEFT JOIN `product_price` USING (`P_ID`) 
    		WHERE `P_ID` = '$P_ID' 
    		ORDER BY `PP_DateTimeUpdate` DESC 
    		LIMIT 1 "
    )); 
    $stock = rowArray($this->common_model->custom_query(
    	" 	SELECT * FROM `product_stock` 
    		WHERE `P_ID` = '$P_ID' 
    		ORDER BY `PS_DateTimeUpdate` DESC 
    		LIMIT 1 "
    )); 
?>
<div class="various-grocery-lightbox-large">
	<div class="various-product-info">
		<label></label>
		<span id="P_Name"><?php if (isset($product['P_Name']) && $product['P_Name'] !== '' && isset($product['P_IDCode']) && $product['P_IDCode'] !== '') echo $product['P_Name'].' ('.$product['P_IDCode'].')'; ?></span>
	</div>
	<div class="various-input-textbox">
		<label>ราคา (ตั้งต้น): </label>
		<input type="number" id="PS_FullSumPrice" value="<?php if (isset($stock['PS_FullSumPrice']) && $stock['PS_FullSumPrice'] !== 0) echo $stock['PS_FullSumPrice']; else echo number_format(0, 2, '.', ','); ?>" disabled>
	</div>
	<div class="various-input-textbox">
		<label>ราคา (โปรโมชั่น): </label>
		<input type="number" id="PP_Price" min="0" placeholder="ราคา (โปรโมชั่น)" value="<?php if (isset($product['PP_FullSumPrice']) && $product['PP_FullSumPrice'] !== 0) echo $product['PP_FullSumPrice']; ?>">
	</div>
	<div class="various-input-textbox">
		<label>วันเวลาที่เริ่ม: </label>
		<input type="text" id="PP_StartDate" placeholder="วันเวลาที่เริ่ม" value="<?php if (isset($product['PP_StartDate']) && $product['PP_StartDate'] !== '0000-00-00 00:00:00') echo $product['PP_StartDate']; ?>">
	</div> 
	<div class="various-input-textbox">
		<label>วันเวลาที่สิ้นสุด: </label>
		<input type="text" id="PP_EndDate" placeholder="วันเวลาที่สิ้นสุด" value="<?php if (isset($product['PP_EndDate']) && $product['PP_EndDate'] !== '0000-00-00 00:00:00') echo $product['PP_EndDate']; ?>">
	</div>
	<div class="various-input-detail">
		<label>ชื่อโปรโมชั่น: </label>
		<input type="text" id="PP_Name" placeholder="ชื่อโปรโมชั่น" value="<?php if (isset($product['PP_Name']) && $product['PP_Name'] !== '') echo $product['PP_Name']; ?>">
	</div>
	<div class="various-input-detail">
		<label>คำอธิบาย: </label>
		<textarea id="PP_Title" rows="3" placeholder="คำอธิบาย"><?php if (isset($product['PP_Title']) && $product['PP_Title'] !== '') echo $product['PP_Title']; ?></textarea>
	</div>
	<div class="various-input-detail">
		<label>รายละเอียด: </label>
		<textarea id="PP_Descript" rows="3" placeholder="รายละเอียด"><?php if (isset($product['PP_Descript']) && $product['PP_Descript'] !== '') echo $product['PP_Descript']; ?></textarea>
	</div>
	<div class="various-input-detail">
		<label>หมายเหตุ: </label>
		<textarea id="PP_Remark" rows="3" placeholder="หมายเหตุ"><?php if (isset($product['PP_Remark']) && $product['PP_Remark'] !== '') echo $product['PP_Remark']; ?></textarea>
	</div>
	<div class="various-input-detail">
		<label></label>
		<input type="checkbox" id="PP_Special" value="1" <?php if (isset($product['PP_Special']) && $product['PP_Special'] === '1') { ?> checked <?php } ?>>&nbsp;แสดงโปรโมชั่น
	</div>
	<div class="various-input-submit">
		<label></label>
		<input type="submit" id="PP_Confirm_button" value="บันทึก">
		<input type="button" id="PP_Cancel_button" 	value="ยกเลิก">
	</div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugin/timepicker/dist/jquery-ui-timepicker-addon.min.css'); ?>">
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/timepicker/dist/jquery-ui-timepicker-addon.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/timepicker/dist/jquery-ui-sliderAccess.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugin/timepicker/dist/i18n/jquery-ui-timepicker-addon-i18n.min.js'); ?>"></script>
<script type="text/javascript">
	var startDateTextBox 	= $('#PP_StartDate');
	var endDateTextBox 		= $('#PP_EndDate');
	var PP_Special 			= '2';
	$(document).ready(function() { 
		$.timepicker.datetimeRange(
			startDateTextBox,
			endDateTextBox, {
				minInterval: (1000 * 60 * 60),
				dateFormat: 'yy-mm-dd', 
				timeFormat: 'HH:mm:ss',
				start: {
					changeMonth: true,
      				changeYear: true,
					timeText: 'เวลา',
					hourText: 'ชั่วโมง',
					minuteText: 'นาที',
					secondText: 'วินาที',
					currentText: "วันนี้", 
					monthNames: ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"], // Names of months for drop-down and formatting
					monthNamesShort: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."], // For formatting
					dayNames: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"],
					dayNamesShort: ["อา.","จ.","อ.","พ.","พฤ.","ศ.","ส."],
					dayNamesMin: ["อ","จ","อ","พ","พ","ศ","ส"],
				},
				end: {
					changeMonth: true,
      				changeYear: true,
					timeText: 'เวลา',
					hourText: 'ชั่วโมง',
					minuteText: 'นาที',
					secondText: 'วินาที',
					currentText: "วันนี้", 
					monthNames: ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"], // Names of months for drop-down and formatting
					monthNamesShort: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."], // For formatting
					dayNames: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"],
					dayNamesShort: ["อา.","จ.","อ.","พ.","พฤ.","ศ.","ส."],
					dayNamesMin: ["อ","จ","อ","พ","พ","ศ","ส"],
				}					
			}
		);
		$("#PP_Confirm_button").click(function() {
			if ($("#PP_Special").prop('checked') === true) PP_Special = $("#PP_Special").val(); else PP_Special = '2';
			if ($("#PP_Price").val() <= 0 || $("#PP_Price").val() == '' || $("#PP_Price").val() == null) alert('โปรดระบุราคาโปรโมชั่น');
			else if ($("#PP_StartDate").val() 	== '' || $("#PP_StartDate").val() 	== null) alert('โปรดระบุวันเวลาที่เริ่ม');
			else if ($("#PP_EndDate").val() 	== '' || $("#PP_EndDate").val() 	== null) alert('โปรดระบุวันเวลาที่สิ้นสุด');
			else {
				var request = $.ajax({
		  			url: "<?php echo base_url('product/control_product/promotion_changed'); ?>",
					method: "POST",
					data: { 
						P_ID 			: "<?php echo $P_ID; ?>",
						PP_StartDate 	: $("#PP_StartDate").val(),
						PP_EndDate 		: $("#PP_EndDate").val(),
						PP_Special 		: PP_Special,
						PP_Name 		: $("#PP_Name").val(),
						PP_Title 		: $("#PP_Title").val(),
						PP_Descript 	: $("#PP_Descript").val(),
						PP_Remark 		: $("#PP_Remark").val(),
						PP_Price 		: $("#PP_Price").val(),
					}
				});
				request.done(function(msg) {
					location.reload();
				});
				request.fail(function(jqXHR, textStatus) {
		  			alert("Request failed: " + textStatus);
				});
			}
		});
		$("#PP_Cancel_button").click(function() {
			location.reload();
		});
	});
</script>