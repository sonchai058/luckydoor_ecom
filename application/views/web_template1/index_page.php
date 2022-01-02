<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $site = $this->webinfo_model->getOnceWebMain(); ?>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php echo @$site['WD_Descrip']; ?>">
        <meta name="keywords" content="<?php echo @$site['WD_Keyword']; ?>">
        <meta name="author" content="<?php echo @$site['WD_Name']; ?>">

		<link rel="shortcut icon" href="<?php echo base_url('assets/images/webconfig/'.@$site['WD_Icon']); ?>" type="image/x-icon">
        <link rel="icon" href="<?php echo base_url('assets/images/webconfig/'.@$site['WD_Icon']); ?>" type="image/x-icon">

		<?php $this->load->file('assets/tools/tools_config.php'); ?>
		<?php $this->load->file('assets/tools/tools_script.php'); ?>

		<title><?php echo $site['WD_Name'].' ('.$title.')'; ?></title>
	</head>
	<body>

		<div class="off-canvas-wrapper">
			<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
				<div class="off-canvas-content" data-off-canvas-content>
					<?php
						$this->template->load('header/header');
						if ($content_view === 'content/main')
							$this->template->load($content_view);
						else
							$this->load->view($content_view);
						$this->template->load('footer/footer');
					?>
				</div>
			</div>
		</div>

		<script>
			$(document).foundation();
		</script>

		<?php
			if ($content_view === 'content/main' || (uri_seg(1) === 'product' && $content_view === 'front-end/detail')) { ?>
				<script>
					$('.bxslider').bxSlider({
						pager: false,
						auto: true,
						speed: 500
					});
				</script> <?php
			}
		?>
  		<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.cookie.min.js');?>"></script>
	    <script>
			var $animation_elements = $('.animation-element');
			var $window 			= $(window);

			// $('.translation-links a').click(function() {
   //    			var lang = $(this).data('lang');
   //    			// if (!$('.goog-te-menu-frame:first').size()) {
   //      			// alert('Error: Could not find Google translate frame.');
   //      			// return false;
   //    			// }
   //    			$('.goog-te-menu-frame:first').contents().find('.goog-te-menu2-item span.text').each(function() {
   //    				if ($(this).html() == lang)
   //    					$(this).click();
   //    				$('#goog-gt-tt').css('display', 'none !important');
   //    			});
   //    			// return false;
   //  		});

			// $('.translation-links').change(function() {
   //    			var lang = $(this).val();
   //    			// if (!$('.goog-te-menu-frame:first').size()) {
   //      			// alert('Error: Could not find Google translate frame.');
   //      			// return false;
   //    			// }
   //    			$('.goog-te-menu-frame:first').contents().find('.goog-te-menu2-item span.text').each(function() {
   //    				if ($(this).html() == lang)
   //    					$(this).click();
   //    				$('#goog-gt-tt').css('display', 'none !important');
   //    			});
   //    			// return false;
   //  		});

			// function googleTranslateElementInit() {
  	// 			new google.translate.TranslateElement({
  	// 				pageLanguage: 		'th',
  	// 				includedLanguages: 	'en,id,km,lo,ms,my,ta,th,tl,vi,zh-TW',
  	// 				layout: 			google.translate.TranslateElement.InlineLayout.SIMPLE,
  	// 				autoDisplay: 		false
  	// 			}, 'google_translate_element');
			// }

			// $('.translation-links a').click(function() {
	  //     var lang = $(this).data('lang');
	  //     var $frame = $('.goog-te-menu-frame:first');
	  //     if (!$frame.size()) {
	  //       alert("Error: Could not find Google translate frame.");
	  //       return false;
	  //     }
	  //     $frame.contents().find('.goog-te-menu2-item span.text:contains('+lang+')').get(0).click();
	  //     return false;
	  //   });

      		function googleTranslateElementInit() {
        		new google.translate.TranslateElement({pageLanguage: 'th', includedLanguages: 'en,th,id,zh-TW,vi,my', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
      		}
		</script>

      	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>  

      	<script>      
      		
      		$(document).ready(function() {
      			$('div._notranslate').hide();

    			if ($.cookie('googtrans') == '/en/th' || $.cookie('googtrans') == undefined) {
    				$('div._notranslate').hide();
    				$('div._dotranslate').show();
    			}
    			else {
    				$('div._dotranslate').hide();
    				$('div._notranslate').show();
    			}
			});

			function extractDomain(url) {
				var suffix = url.split('.');
	    		return suffix.slice(-(suffix.length-1)).join('.');
			}

        	function translator(lang){
          		console.log(lang);
          		// if (location.hostname == 'localhost' || location.hostname == '192.168.0.8')
	          		$.removeCookie("googtrans");
	          	// else
	          		// $.removeCookie('googtrans',{ path: '/' });
          		var date = new Date();
          		var minutes = 30;
          		date.setTime(date.getTime() + (minutes * 60 * 1000));
          		// if (location.hostname == 'localhost' || location.hostname == '192.168.0.8')
	          		$.cookie('googtrans', '/en/' + lang, { expires: date });
	          	// else
	          		// $.cookie('googtrans', '/en/' + lang, { expires: date, path:'/', domain:extractDomain(location.hostname) });
          		window.location.replace("");          
        	}

			function check_if_in_view() {
			  	var window_height 			= $window.height();
			  	var window_top_position 	= $window.scrollTop();
			  	var window_bottom_position 	= (window_top_position + window_height);

			  	$.each($animation_elements, function() {
			    	var $element 				= $(this);
			    	var element_height 			= $element.outerHeight();
			    	var element_top_position 	= $element.offset().top;
			    	var element_bottom_position = (element_top_position + element_height);

			    	if ((element_bottom_position 	>= window_top_position) &&
			        	(element_top_position 		<= window_bottom_position))
			      		$element.addClass('in-view');
			    	else
			      		$element.removeClass('in-view');
			  	});
			}

			$window.on('scroll resize', check_if_in_view);
			$window.trigger('scroll');
		</script>
    </body>
</html>