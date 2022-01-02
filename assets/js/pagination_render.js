var show_per_page 	= 9;
var step_value 		= 10;

var number_of_items = 0;
var number_of_pages = 0;
var wrap_content 	= null;
var tab_menu 		= ['recommend', 'popular', 'bestseller'];

function render_pagination() {
	$('#current_page').val(0);
	$('#show_per_page').val(show_per_page);

	var navigation_html = '';

	navigation_html += '<li><a class="first" href="javascript:first();"><i class="fa fa-step-backward"></i></a></li>';
	navigation_html += '<li><a class="step_backward" href="javascript:step_backward();"><i class="fa fa-angle-double-left"></i></a></li>';
	navigation_html += '<li><a class="previous" href="javascript:previous();"><i class="fa fa-angle-left"></i></a></li>';
	for (current_link = 0; current_link < number_of_pages; ++current_link) 
		navigation_html += '<li><a class="page" href="javascript:page(' + current_link + ')" longdesc="' + current_link + '">' + (current_link + 1) + '</a></li>';
	navigation_html += '<li><a class="next" href="javascript:next();"><i class="fa fa-angle-right"></i></a></li>';
	navigation_html += '<li><a class="step_forward" href="javascript:step_forward();"><i class="fa fa-angle-double-right"></i></a></li>';
	navigation_html += '<li><a class="last" href="javascript:last();"><i class="fa fa-step-forward"></i></a></li>';

	$('.pagination ul').html(navigation_html);

	for (pl = 1; pl < 4; ++pl) 
		$('.pagination ul li:nth-child(' + pl + ')').addClass('disabled');

	$('.pagination ul li:nth-child(4)').addClass('active');

	for (pl = $('.pagination ul li').length; pl > (pl - 3); --pl) 
		$('.pagination ul li:nth-child(' + pl + ')').addClass('disabled');
}

function first() {
	if ($('.first').closest('li').prop('class') != 'disabled') 
		page(0);
}

function step_backward() {
	new_page = parseInt($('#current_page').val()) - step_value;
	if (new_page >= 0)
		page(new_page);
	else if (new_page < 0) {
		if ($('.step_backward').closest('li').prop('class') != 'disabled')
			page(0);
	}
}

function previous() {
	new_page = parseInt($('#current_page').val()) - 1;
	if (new_page >= 0)
		page(new_page);
}

function page(page_num) {
	if ($('.pagination ul li:nth-child(' + (page_num + 4) + ')').prop('class') != 'active') {
		var show_per_page = parseInt($('#show_per_page').val());
		start_from 	= page_num 		* show_per_page;
		end_on 		= start_from 	+ show_per_page;
		$('#' + wrap_content).children().css('display', 'none').slice(start_from, end_on).fadeIn('fast').css('display', 'inline-block');
		$('.pagination ul li').removeClass('active');
		$('.pagination ul li:nth-child(' + (page_num + 4) + ')').addClass('active');
		if (page_num <= 0) {
			$('.pagination ul li:first').addClass('disabled');
			$('.pagination ul li:nth-child(2)').addClass('disabled');
			$('.pagination ul li:nth-child(3)').addClass('disabled');
		}
		else if (page_num >= 0) {
			$('.pagination ul li:first').removeClass('disabled');
			$('.pagination ul li:nth-child(2)').removeClass('disabled');
			$('.pagination ul li:nth-child(3)').removeClass('disabled');
		}
		if ((page_num + 1) >= number_of_pages) {
			$('.pagination ul li:nth-child(' + (number_of_pages + 4) + ')').addClass('disabled');
			$('.pagination ul li:nth-child(' + (number_of_pages + 5) + ')').addClass('disabled');
			$('.pagination ul li:last').addClass('disabled');
		}
		else if ((page_num + 1) <= number_of_pages) {
			$('.pagination ul li:nth-child(' + (number_of_pages + 4) + ')').removeClass('disabled');
			$('.pagination ul li:nth-child(' + (number_of_pages + 5) + ')').removeClass('disabled');
			$('.pagination ul li:last').removeClass('disabled');
		}
		$('#current_page').val(page_num);
	}
}

function next() {
	new_page = parseInt($('#current_page').val()) + 1;
	if (new_page < number_of_pages)
		page(new_page);
}

function step_forward() {
	new_page = parseInt($('#current_page').val()) + step_value;
	if (new_page < number_of_pages)
		page(new_page);
	else if (new_page >= number_of_pages) {
		if ($('.step_forward').closest('li').prop('class') != 'disabled')
			page(number_of_pages - 1);
	}
}

function last() {
	if ($('.last').closest('li').prop('class') != 'disabled')
		page(number_of_pages - 1);
}

$(document).ready(function() {
	// Tab pption
	$('.wrap_content_tab_menu').each(function(i) {
		$('#' + tab_menu[i]).click(function() {
			setTimeout(function() {
				wrap_content = $('#wrap_content_' + tab_menu[i]).prop('id');

				var tab_index = 0;
				while (tab_index < tab_menu.length) {
					if (tab_index !== i) {
						$('#' + tab_menu[tab_index]).removeClass('active');
						$('#wrap_content_' + tab_menu[tab_index]).css('display', 'none');
					}
					tab_index += 1;
				}

				$('#' + tab_menu[i]).addClass('active');
				$('#wrap_content_' + tab_menu[i]).fadeIn("fast", function() {
					$('#wrap_content_' + tab_menu[i]).css('display', 'inline-block');
				});
				
				number_of_items = $('#wrap_content_' + tab_menu[i]).children().size(); 
				number_of_pages = Math.ceil(number_of_items/show_per_page);

				render_pagination();

				$('#wrap_content_' + tab_menu[i]).children().css('display', 'none');
				$('#wrap_content_' + tab_menu[i]).children().slice(0, show_per_page).css('display', 'inline-block');
			}, 100);
		});
	});
	$('.wrap_content_tab').find($('#' + tab_menu[0] + ' a')).trigger('click');

	// Without tab option
	$('.wrap_content_grid').find($('.wrap_content_pagination')).load(function() {
		wrap_content = $('#wrap_content_pagination').prop('id');
		
		number_of_items = $('#wrap_content_pagination').children().size(); 
		number_of_pages = Math.ceil(number_of_items/show_per_page);

		render_pagination();

		$('#wrap_content_pagination').children().css('display', 'none');
		$('#wrap_content_pagination').children().slice(0, show_per_page).css('display', 'inline-block');
	});

	$('.wrap_content_grid').find($('.wrap_content_pagination')).trigger('load');
});