$(document).ready(function() {
	$('.ajax_list').on('click', '.del-row', function() {
		if (confirm(message_alert_delete))
			return true;
		else
			return false;
	});
});