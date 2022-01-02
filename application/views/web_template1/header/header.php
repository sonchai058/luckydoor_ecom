<?php
	$site = $this->webinfo_model->getOnceWebMain();
	$gq = 0;
    if ($this->cart->contents()) {
        foreach ($this->cart->contents() as $value) {
            $gq += $value['qty'];
        }
    }
?>
<header>

	<div class="title-bar" data-responsive-toggle="mobile-menu">
		<div class="title-bar-left">
			<button class="menu-icon" type="button" data-open="offCanvasLeft"></button>
		</div>
		<span class="title-bar-title"><?php echo $site['WD_Name']; ?></span>
		<div class="title-bar-right">
			<style type="text/css">
				.mb_tran a{
					color: #fff;
					-moz-transition: all 500ms linear;
					-o-transition: all 500ms linear;
					-webkit-transition: all 500ms linear;
					 transition: all 500ms linear;
				}
				.mb_tran a:hover {
					color: #262626;
				}
				.mb_menu{
					text-align: left;
					right: 0 !important;
				}
			</style>
			<div id="google_translate_element" style="display: none;"></div>
			<ul class="dropdown menu mb_tran" data-dropdown-menu>
				<li>
					<a href="#"><!-- <img src="<?php echo base_url('assets/images/flag/th.png');?>" alt=""> -->
						<?php 
							if (isset($_COOKIE['googtrans'])) {
							   if ($_COOKIE['googtrans'] == '/en/en') { 
							      $icon = 'en.png';
							      $lang = 'English';
							   } elseif ($_COOKIE['googtrans'] == '/en/th') {
							      $icon = 'th.png';
							      $lang = 'Thai';
							   } elseif ($_COOKIE['googtrans'] == '/en/id') {
							      $icon = 'Indonesia.png';
							      $lang = 'indonesian';
							   } elseif ($_COOKIE['googtrans'] == '/en/zh-TW') {
							      $icon = 'China.png';
							      $lang = 'chinese';
							   } elseif ($_COOKIE['googtrans'] == '/en/vi') {
							      $icon = 'Viet Nam.png';
							      $lang = 'vietnamese';
							   } elseif ($_COOKIE['googtrans'] == '/en/my') {
							      $icon = 'Malaysia.png';
							      $lang = 'Malay';
							   } else {
							      $icon = 'th.png';
							      $lang = 'English';
							   }
							   echo '<img src="'.base_url('assets/images/flag/'.$icon).'" alt="">';
						   } else {
						      $_COOKIE['googtrans'] = '';
						      echo '<img src="'.base_url('assets/images/flag/th.png').'" alt="">';
						   }
						   echo "เปลี่ยนภาษา&nbsp";
						?>
					</a>

			   	 <ul class="translation-links menu mb_menu">
			    		<li><a id="en" href="javascript:void(0)" onclick="translator('en')"><img src="<?php echo base_url('assets/images/flag/en.png')?>" alt="" title="English"> อังกฤษ</a></li>
						<li><a id="th" href="javascript:void(0)" onclick="translator('th')"><img src="<?php echo base_url('assets/images/flag/th.png')?>" alt="" title="Thai"> ไทย</a></li>
						<li><a id="th" href="javascript:void(0)" onclick="translator('zh-TW')"><img src="<?php echo base_url('assets/images/flag/China.png')?>" alt="" title="China"> จีน</a></li>
						<li><a id="th" href="javascript:void(0)" onclick="translator('vi')"><img src="<?php echo base_url('assets/images/flag/Viet Nam.png')?>" alt="" title="Viet Nam"> เวียดนาม</a></li>
						<li><a id="th" href="javascript:void(0)" onclick="translator('my')"><img src="<?php echo base_url('assets/images/flag/Malaysia.png')?>" alt="" title="Malaysia"> มาเลเซีย</a></li>
			    	</ul>
			  	</li>
			</ul>
		</div>
	</div>

	<nav data-sticky-container>
		<div data-sticky data-anchor="exampleId" data-sticky-on="large" style="width:100%;">
			<div class="nav" id="mobile-menu">
				<div class="row">
					<div class="columns">
						<div class="top-bar-left">
							<ul class="dropdown menu">
								<li class="menu-text">
									<a href="<?php echo base_url(''); ?>" class="brand">
										<img src="<?php echo base_url('assets/images/logo/logo.png'); ?>" alt="<?php echo $site['WD_Name']; ?>"> <?php echo $site['WD_Name']; ?>
									</a>
								</li>
								<li><a href="<?php echo base_url('product'); ?>" title="สินค้า">สินค้า</a></li>
								<li><a href="<?php echo base_url('howto'); ?>" title="วิธีชำระเงิน">วิธีชำระเงิน</a></li>
								<li><a href="<?php echo base_url('aboutus'); ?>" title="เกี่ยวกับเรา">เกี่ยวกับเรา</a></li>
								<li><a href="<?php echo base_url('contactus'); ?>" title="ติดต่อเรา">ติดต่อเรา</a></li>
							</ul>
						</div>
					</div>
					<div class="columns">
						<div class="top-bar-right">
							<ul class="menu"> <?php
								if (get_session('C_ID') != '') {
									$member_data = rowArray($this->common_model->get_where_custom('member', 'M_ID', get_session('C_ID')));
									if ($member_data !== '') { ?>
										<li><a href="#" title="<?php echo $member_data['M_flName']; ?>" id="member-history"><i class="fa fa-user"></i><?php echo $member_data['M_flName']; ?></a></li> <?php
									}
									else { ?>
										<li><a href="#" title="สถานะการสั่งซื้อ" id="member-history"><i class="fa fa-truck"></i>สถานะการสั่งซื้อ</a></li> <?php
									}
								}
								else { ?>
									<li><a href="<?php echo base_url('member/transfercustom'); ?>" title="แจ้งโอนเงิน" id="member-transfer"><i class="fa fa-exchange"></i>แจ้งโอนเงิน</a></li> <?php
								} ?>
								<li> <?php
									if (get_session('C_ID') == '') { ?>
										<a href="#" title="เข้าสู่ระบบ" data-toggle="reveal-login" id="login-reveal"><i class="fa fa-sign-in"></i>เข้าสู่ระบบ</a> <?php
									}
									else {
										echo form_open('member/logout', array('id' => 'form-logout')); ?>
											<a href="#" title="ลงชื่อออก" id="btn-logout"><i class="fa fa-sign-out"></i> ออกจากระบบ</a> <?php
											echo form_hidden('current_url', current_url());
										echo form_close();
									} ?>
								</li>
								<li><a href="#" title="รถเข็น" id="shopping_cart"><i class="fa fa-shopping-cart"></i>รถเข็น <?php if ($this->cart->contents()) echo '<span class="shopping-noti hvr-bob">'.trim($gq).'</span>'; ?> </a></li>
								<!-- <li> <?php
									echo form_open('product', array('id' => 'form-productsearch')); ?>
										<input type="search" placeholder="ค้นหาสินค้า..." id="product_search_input" name="product_search_input"> <?php
										echo form_hidden('productsearch', 'productsearch');
									echo form_close(); ?>
								</li> -->
								<!-- <li><button type="button" class="button" id="product_search_btn"><i class="fa fa-search"></i></button></li> -->
								<li>
									<div id="google_translate_element" style="display: none;"></div>
									<ul class="dropdown menu" data-dropdown-menu>
										<li>
									   <a href="#"><!-- <img src="<?php echo base_url('assets/images/flag/th.png');?>" alt=""> -->
									   <?php 
										   if (isset($_COOKIE['googtrans'])) {
										      if ($_COOKIE['googtrans'] == '/en/en') { 
										         $icon = 'en.png';
										         $lang = 'English';
										      } elseif ($_COOKIE['googtrans'] == '/en/th') {
										         $icon = 'th.png';
										         $lang = 'Thai';
										      } elseif ($_COOKIE['googtrans'] == '/en/id') {
										         $icon = 'Indonesia.png';
										         $lang = 'indonesian';
										      } elseif ($_COOKIE['googtrans'] == '/en/zh-TW') {
										         $icon = 'China.png';
										         $lang = 'chinese';
										      } elseif ($_COOKIE['googtrans'] == '/en/vi') {
										         $icon = 'Viet Nam.png';
										         $lang = 'vietnamese';
										      } elseif ($_COOKIE['googtrans'] == '/en/my') {
										         $icon = 'Malaysia.png';
										         $lang = 'Malay';
										      } else {
										         $icon = 'th.png';
										         $lang = 'English';
										      }
										         echo '<img src="'.base_url('assets/images/flag/'.$icon).'" alt="">';
										      } else {
										         $_COOKIE['googtrans'] = '';
										            echo '<img src="'.base_url('assets/images/flag/th.png').'" alt="">';
										      }
										      echo "เปลี่ยนภาษา&nbsp";
										?>

										</a>
									   
									    <ul class="translation-links menu">
									    	<li><a id="en" href="javascript:void(0)" onclick="translator('en')"><img src="<?php echo base_url('assets/images/flag/en.png')?>" alt="" title="English"> อังกฤษ</a></li>
          								<li><a id="th" href="javascript:void(0)" onclick="translator('th')"><img src="<?php echo base_url('assets/images/flag/th.png')?>" alt="" title="Thai"> ไทย</a></li>
          								<li><a id="th" href="javascript:void(0)" onclick="translator('zh-TW')"><img src="<?php echo base_url('assets/images/flag/China.png')?>" alt="" title="China"> จีน</a></li>
          								<li><a id="th" href="javascript:void(0)" onclick="translator('vi')"><img src="<?php echo base_url('assets/images/flag/Viet Nam.png')?>" alt="" title="Viet Nam"> เวียดนาม</a></li>
          								<li><a id="th" href="javascript:void(0)" onclick="translator('my')"><img src="<?php echo base_url('assets/images/flag/Malaysia.png')?>" alt="" title="Malaysia"> มาเลเซีย</a></li>
									    </ul>
									  </li>
									</ul>
								</li>
								<!-- <li><div id="google_translate_element" style="visibility:hidden"></div></li>
								<li>
									<select class="translation-links">
										<option class="english" value="ภาษาอังกฤษ">English</option>
										<option class="indonesian" 	value="ภาษาอินโดนีเซีย">Indonesian</option>
  										<option class="khmer" 		value="ภาษาเขมร">Khmer</option>
  										<option class="lao" 		value="ลาว">Lao</option>
				  						<option class="malay" 		value="ภาษามาเลย์">Malay</option>
				  						<option class="burmese" 	value="พม่า">Burmese</option>
				  						<option class="tamil" 		value="ภาษาทมิฬ">Tamil</option>
				  						<option class="thai" 		value="ภาษาไทย">Thai</option>
				  						<option class="filipino" 	value="ภาษาฟิลิปปินส์">Filipino</option>
				  						<option class="vietnamese" 	value="ภาษาเวียดนาม">Vietnamese</option>
				  						<option class="chinese" 	value="ภาษาจีน (ดั้งเดิม)">Chinese</option>
									</select>
								</li> -->
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

	</nav>

	<div class="tiny reveal reveal-login" id="reveal-login" data-reveal data-close-on-click="true" data-animation-in="slide-in-down" data-animation-out="slide-out-up" data-showdelay="2" data-hidedelay="2">

		<?php $this->template->load('content/login'); ?>

		<button class="close-button" data-close aria-label="Close reveal" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<aside class="off-canvas position-left" id="offCanvasLeft" data-off-canvas>
		<button class="close-button" aria-label="Close menu" type="button" data-close>
			<span aria-hidden="true">×</span>
		</button>
		<ul class="menu vertical off-canvas-list">
			<li><h3>เมนูหลัก</h3></li>
			<li><a href="<?php echo base_url('product'); ?>">สินค้า</a></li>
			<li><a href="<?php echo base_url('cart'); ?>">รถเข็น</a></li>
			<li><a href="<?php echo base_url('member/history'); ?>">สถานะการสั่งซื้อ</a></li>
			<li><a href="<?php echo base_url('howto'); ?>">วิธีชำระเงิน</a></li>
			<li><a href="<?php echo base_url('aboutus'); ?>">เกี่ยวกับเรา</a></li>
			<li><a href="<?php echo base_url('contactus'); ?>">ติดต่อเรา</a></li>
			<li> <?php
				if (get_session('C_ID') == '') { ?>
					<a href="<?php echo base_url('member/login'); ?>">ลงชื่อเข้าใช้</a> <?php
				}
				else {
					echo form_open('member/logout', array('id' => 'form-logout-res'));
						echo form_hidden('current_url', current_url());
					echo form_close(); ?>
					<a href="#" id="btn-logout-res">ลงชื่อออก</a> <?php
				} ?>
			</li>
		</ul>
	</aside>

</header>
<script type="text/javascript">
	$(document).ready(function() {
		$('#product_search_input').keypress(function(e) {
            if (e.which == 13)
                $('#form-productsearch').submit();
        });
        $('#product_search_btn').click(function() {
        	$('#form-productsearch').submit();
        });
		$('#login-reveal').click(function() {
			setTimeout(function() {
				$('#user_id').focus();
	    		$('#user_id').val('');
	    		$('#user_pass').val('');
			}, 1000);
	    });
	    $('#reveal-login').find('#btn-login').click(function() {
	    	$('.login-wrapper-2').find('#form-login #user_id').val('');
	    	$('.login-wrapper-2').find('#form-login #user_pass').val('');
	    	$('#reveal-login').find('#form-login').submit();
	    	$('#reveal-login').find('#form-login').submit();
	    });
	    $('#reveal-login').find('#form-login input').each(function(index) {
	    	$('.login-wrapper-2').find('#form-login #user_id').val('');
	    	$('.login-wrapper-2').find('#form-login #user_pass').val('');
            $(this).keypress(function(e) {
                if (e.which == 13)
                    $('#form-login').submit();
            });
        });
	    $('.login-wrapper-2').find('#btn-login').click(function() {
	    	$('#reveal-login').find('#form-login #user_id').val('');
	    	$('#reveal-login').find('#form-login #user_pass').val('');
	    	$('.login-wrapper-2').find('#form-login').submit();
	    });
        $('.login-wrapper-2').find('#form-login input').each(function(index) {
        	$('#reveal-login').find('#form-login #user_id').val('');
        	$('#reveal-login').find('#form-login #user_pass').val('');
            $(this).keypress(function(e) {
                if (e.which == 13)
                    $('#form-login').submit();
            });
        });
        $('#btn-logout').click(function() {
	    	$('#form-logout').submit();
	    });
	    $('#btn-logout-res').click(function() {
	    	$('#form-logout-res').submit();
	    });
	    $('#member-history').click(function() {
	    	var C_ID = "<?php echo get_session('C_ID'); ?>";
	    	if (C_ID != '')
	    		window.location.href = "<?php echo base_url('member/history'); ?>";
	    	else {
	    		// alert('!!! กรุณาเข้าสู่ระบบ');
	    		$('#login-reveal').click();
	    	}
	    });
	    $('#shopping_cart').click(function() {
	    	var cart = '<?php echo json_encode($this->cart->contents()); ?>';
	    	// if (jQuery.isEmptyObject(JSON.parse(cart)))
	    		// alert('ยังไม่มีสินค้าในตะกร้า');
	    	// else
	    		window.location.href = "<?php echo base_url('cart'); ?>";
	    });
	    $('.btn-signup').click(function() {
	    	$('#login-reveal').click();
	    });
	});
</script>