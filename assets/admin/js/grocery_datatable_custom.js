var allow_keys = ['1'	, 	'2'		, '3'			, '4'		, '5'			, '6'			, '7'			];
var allow_text = ['ปกติ'	, 	'ระงับ'	, 'ลบ / บล็อค'	, 'รอโอนเงิน'	, 'โอนเงินแล้ว'	, 'รอส่งสินค้า'	, 'ส่งสินค้าแล้ว'	];

function inputGenerate(_this, this_value, this_id) {
	var td = $(_this).parent();
	var value = this_value;
	td.empty();
	td.append('<span style="font-size:18px;font-style:italic">กด Enter เพื่อบันทึก</span><br><input class="editable-input" type="text" value="' + value + '" maxlength="50" onfocusout="inputUnsave(this, ' + '`' + this_value + '`' + ', ' + this_id + ');" onkeypress="inputSaved(this, event, ' + this_id + ');" style="width:6em">');
	$('.editable-input').focus();
}

function inputUnsave(_this, this_value, this_id) {
	var td = $(_this).parent();
	td.empty();
	if (this_value != '')
		td.append('<a href="#" class="" onclick="inputGenerate(this, ' + '`' + this_value + '`' + ', ' + this_id + ');"><img src="../../assets/admin/images/tools/edit-icon.png"></a>&#160;' + this_value);
	else
		td.append('<a href="#" class="" onclick="inputGenerate(this, ' + '`' + this_value + '`' + ', ' + this_id + ');"><img src="../../assets/admin/images/tools/edit-icon.png"></a>&#160;<a href="#" class="" onclick="inputGenerate(this, ' + '`' + this_value + '`' + ', ' + this_id + ');" style="color:red;font-weight:bold;font-size:17px">ป้อนข้อมูล</a>');
}

function inputSaved(_this, _event, this_id) {
	if (_event.keyCode == 13) {
		var this_value = $(_this).val();
        var request = $.ajax({
		  	url: 	'ems_code_changed',
		  	method: 'POST',
		  	data: 	{
		  		OD_ID: 		this_id,
		  		OD_EmsCode: this_value,
		  	},
		});
		request.done(function(msg) {
			if (confirm("ต้องการเปลี่ยนสถานะเป็นแจ้งชำระหรือไม่?")) {
				var form_id = '#orderStateChange' + this_id;
				$(form_id).submit();
			}
			else location.reload();
		});
		request.fail(function(jqXHR, textStatus) {
		  	alert('Request failed: ' + textStatus);
		  	location.reload();
		});
    }
}

function dropdownGenerate(_this, this_value, this_id) {
	var td = $(_this).parent();
	var select = '<select class="editable-dropdown" onfocusout="dropdownUnsave(this, ' + this_value + ', ' + this_id + ')" onchange="dropdownSaved(this, ' + this_id + ')">';
	for (var i = 0; i < allow_keys.length; i++) {
		if (this_value == allow_keys[i])
			select += '<option value="' + allow_keys[i] + '" selected>' + allow_text[i] + '</option>';
		else
			select += '<option value="' + allow_keys[i] + '">' + allow_text[i] + '</option>';
	};
	select += '</select>';
	td.empty();
	td.append(select);
	$('.editable-dropdown').focus();
}

function dropdownUnsave(_this, this_value, this_id) {
	var td = $(_this).parent();
	td.empty();
	td.append('<a href="#" class="" onclick="dropdownGenerate(this, ' + this_value + ', ' + this_id + ');"><img src="../../assets/admin/images/tools/edit-icon.png"></a>&#160;' + allow_text[this_value - 1]);
}

function dropdownSaved(_this, this_id) {
	var this_value = $(_this).val();
    var request = $.ajax({
	  	url: 	'order_status_changed',
	  	method: 'POST',
	  	data: 	{
	  		OD_ID: 		this_id,
	  		OD_Allow: 	this_value,
	  	},
	});
	request.done(function(msg) {
		location.reload();
	});
	request.fail(function(jqXHR, textStatus) {
	  	alert('Request failed: ' + textStatus);
	  	location.reload();
	});
}

$(document).ready(function() {
	$('.del-row').parent('a').click(function() {
		if (confirm(message_alert_delete))
			return true;
		else
			return false;
	});
});