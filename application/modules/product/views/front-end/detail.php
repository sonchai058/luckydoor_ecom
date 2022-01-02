<main>
	<?php

		$this->template->load('header/breadcrumb');

		$qty_session = 0;
		if ($this->cart->contents()) {
			foreach ($this->cart->contents() as $value) {
				if ($value['id'] === $product_detail['P_ID'])
					$qty_session = $value['qty'];
			}
		}
	?>

	<section>
		<div class="row row-product-view">
			<div class="small-12 medium-5 columns">
				<div class="wrap-product-view"> <?php
					$product_images 	= $this->common_model->get_where_custom('product', 'P_ID', $product_detail['P_ID']);
					// $product_gallery 	= $this->common_model->get_where_custom('product_gallery', 'P_ID', $product_detail['P_ID']);
					$product_gallery 	= $this->common_model->custom_query(" SELECT * FROM `product_gallery` WHERE `P_ID` = {$product_detail['P_ID']} AND `PG_Allow` != '3' ");
					if (count($product_images) > 0) $P_Img = rowArray($product_images); ?>
					<div class="product-view">
						<ul class="product-show"> <?php
							if (count($product_images) > 0) {
								if ($P_Img['P_Img'] != '') { ?>
									<li><img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$P_Img['P_Img']); ?>" alt="<?php echo $P_Img['P_IDCode']; ?>"></li> <?php
								}
								else { ?>
									<li><img src="<?php echo base_url('assets/images/noimage.gif'); ?>" alt="<?php echo $P_Img['P_IDCode']; ?>"></li> <?php
								}
								if (count($product_gallery) > 0) {
									foreach ($product_gallery as $key => $value) {
										if ($value['PG_Img'] != '') { ?>
											<li><img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$value['PG_Img']); ?>" alt="<?php if ($value['PG_Name'] !== '') echo $value['PG_Name']; ?>"></li> <?php
										}
									}
								}
							} ?>
						</ul>
					</div>
					<div class="product-thumbnail">
						<div id="product-pager" class="product-pager"> <?php
							if (count($product_images) > 0 && count($product_gallery) > 0) {
								if ($P_Img['P_Img'] != '') { ?>
									<a data-slide-index="0" href=""><img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$P_Img['P_Img']); ?>"></a> <?php
								}
								$data_slide_index = 1;
								foreach ($product_gallery as $key => $value) {
									if ($value['PG_Img'] != '') { ?>
										<a data-slide-index="<?php echo $data_slide_index; ?>" href=""><img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$value['PG_Img']); ?>"></a> <?php
										$data_slide_index += 1;
									}
								}
							} ?>
						</div>
					</div>

				</div>
			</div>

			<div class="samll-12 medium-7 columns"> <?php 
				$attributes = array(
					'id' => 'cart_order_added'
				);
				echo form_open('cart/cartOrderAdded', $attributes);
				echo form_input(array('type' => 'hidden', 'id' => 'id', 	'name' => 'id', 	'value' => $product_detail['P_ID']));
				echo form_input(array('type' => 'hidden', 'id' => 'name', 	'name' => 'name', 	'value' => $product_detail['P_Name']));
				echo form_input(array('type' => 'hidden', 'id' => 'code', 	'name' => 'code', 	'value' => $product_detail['P_IDCode']));
				echo form_input(array('type' => 'hidden', 'id' => 'weight', 'name' => 'weight', 'value' => $product_detail['P_Weight']));
				echo form_input(array('type' => 'hidden', 'id' => 'imgs', 	'name' => 'imgs', 	'value' => $product_detail['P_Img'])); ?>
				<div class="product-name">
					<h2><?php echo $product_detail['P_IDCode']; ?></h2>
					<h4><?php echo $product_detail['P_Name']; ?></h4>
					<ul class="menu product-name-desc">
						<li><?php echo $product_detail['C_Name']; ?></li>
						<!-- <li><?php echo $product_detail['C_Name']; ?></li> -->
					</ul>
				</div>
				<p><?php echo $product_detail['P_Title']; ?></p>
				<br> <?php
				if ($product_detail['P_Color'] != '') {
					$colors = explode(",", $product_detail['P_Color']); ?>
					<ul>
						<li><bold><h5>เลือกสี</h5></bold>
							<select name="color"> <?php
								foreach ($colors as $key => $value) {
									$product_color = rowArray($this->common_model->get_where_custom('product_color', 'PC_ID', $value));
									if (count($product_color) > 0) { ?>
										<option value="<?php echo $product_color['PC_ID']; ?>"><?php echo $product_color['PC_Name']; ?></option> <?php
									}
								} ?>
							</select>
						</li>
					</ul> <?php
				} ?>
				<br>
				<div class="price-product">
					<h2 class="product-price-view"> <?php
						if ($product_stock['PS_Price'] != 0 && !empty($product_price['PP_Price']) && $product_price['PP_Price'] != 0) {
							if ($product_price['PP_Price'] != '' || $product_price['PP_Price'] != 0)
								echo '฿'.number_format($product_price['PP_Price'], 2, '.', ',');
						}
						else if ($product_stock['PS_Price'] != 0 && (empty($product_price['PP_Price']) || $product_price['PP_Price'] == 0)) {
							if ($product_stock['PS_Price'] != '' || $product_price['PP_Price'] != 0)
								echo '฿'.number_format($product_stock['PS_Price'], 2, '.', ',');
						}
						else
							echo '฿'.number_format(0, 2, '.', ','); ?>
					</h2> <?php
					if ($product_stock['PS_Price'] != 0 && !empty($product_price['PP_Price']) && $product_price['PP_Price'] != 0) { ?>
						<h4 class="price-sale">ราคาปกติ <?php echo '฿'.number_format($product_stock['PS_Price'], 2, '.', ','); ?></h4> <?php
					} ?>
				</div> <?php
				if (!empty($product_stock['PS_Amount']) && $product_stock['PS_Amount'] > 0) { ?>
					<h5><i class="fa fa-check"></i> มีสินค้า <?php echo ' ('.$product_stock['PS_Amount'].')'; ?></h5> <?php
				}
				else { ?>
					<h5 class="text-red"><i class="fa fa-times"></i> สินค้าหมด</h5> <?php
				} ?>
				<input class="product-prp" id="prp" name="prp" type="hidden" value="<?php if (!empty($product_price['PP_Price']) && $product_price['PP_Price'] != 0) echo number_format($product_price['PP_Price'], 2, '.', ''); else echo number_format(0, 2, '.', ''); ?>">
				<input class="product-prs" id="prs" name="prs" type="hidden" value="<?php if (!empty($product_price['PS_Price']) && $product_stock['PS_Price'] != 0) echo number_format($product_stock['PS_Price'], 2, '.', ''); else echo number_format(0, 2, '.', ''); ?>">
				<input class="product-qty" id="qty" name="qty" type="number" value="1" min="1">
				<a href="#" class="button btn-product" id="btn_cart_add">เพิ่มสินค้าในตะกร้า</a>
				<!-- <div class="wishlist"> -->
				<?php
					if (get_session('C_ID')) {
						if ($product_wlist === false) { ?>
							<a href="<?php echo base_url('product/wishlist/add/'.$product_detail['P_ID']); ?>" class="btn-wishlist"><i class="fa fa-star-o"></i> เพิ่มในรายการสินค้าที่ชอบ</a> <?php
						}
						else if ($product_wlist === true) { ?>
							<br><a href="<?php echo base_url('product/wishlist/del/'.$product_detail['P_ID']); ?>" class="btn-wishlist-active"><i class="fa fa-check-square-o"></i> อยู่ในรายการสินค้าที่ชอบ</a> <?php
						}
					}
				?>
				<!-- </div> -->
				<hr>
				<div class="_dotranslate">
					
				
					<h5><bold>รายละเอียดสินค้า</bold></h5>
					<p><?php echo $product_detail['P_Detail']; ?></p>

					<h5><bold>ขนาด</bold></h5>
					<!-- <p><?php if ($product_detail['PSI_Name'] != '') echo $product_detail['PSI_Name']; else echo '-'; ?></p> -->
					<p><?php if ($product_detail['P_Size'] != '') echo $product_detail['P_Size']; else echo '-'; ?></p>

					<h5><bold>น้ำหนัก</bold></h5>
					<p><?php echo $product_detail['P_Weight']; ?> (กก.)</p>

					<h5><bold>ข้อมูลจำเพาะของสินค้า</bold></h5>
					<ol> <?php
						if ($product_detail['PT_ID'] != '') {
							$PT_ID = explode(',', $product_detail['PT_ID']);
							$PT_String = '';
							for ($PT_Index = 0; $PT_Index < sizeof($PT_ID); ++$PT_Index) {
								$PT_Value = $PT_ID[$PT_Index];
								$product_types = $this->common_model->custom_query(" SELECT `PT_Name` FROM `product_type` WHERE `PT_ID` = '$PT_Value' ");
								if (count($product_types) > 0) {
									$product_type = rowArray($product_types);
									$PT_String .= $product_type['PT_Name'].', ';
								}
							}
							$PT_String = rtrim($PT_String, ', '); ?>
							<li>สถานะสินค้า: <?php echo trim($PT_String); ?></li> <?php
						}
						if ($product_detail['PSI_Name'] != '') { ?>
							<li>ขนาด / รูปร่าง: <?php echo $product_detail['PU_Name']; ?></li> <?php
						}
						if ($product_detail['PU_Name'] != '') { ?>
							<li>หน่วยสินค้า: <?php echo $product_detail['PU_Name']; ?></li> <?php
						} ?>
					</ol>
				</div>
				
				<?php if($product_detail['C_ID'] == 1){?>
				<div class="_notranslate notranslate">
					<h5><bold>Outdoors:</bold></h5>
					<p>Is exeternal door made from fiber cement material which cause high humidity resistance. Coloring can be done both painting or spraying.</p>

					<h5><bold>Assembly information:</bold></h5>
					<ul>
						<li>- Standard door hinges supports.</li>
						<li>- Normal doorknob and Lever doorknob can be fitted.</li>
						<li>- Eagle eye can be fitted.</li>
						<li>- Door bumper guard point available.</li>
					</ul>
					<h5><bold>Size:</bold></h5>
					
					<p>Bedroom: 80x200 cm, 90x200 cm.<br>Bathroom: 70x200 cm, 80x200 cm.</p>

					<h5><bold>Wight: </bold></h5>
					<p>25 kgs.</p>

					<h5><bold>Specifically of Product</bold></h5>
				</div>
				<?php }if($product_detail['C_ID'] == 2){ ?>
				<div class="_notranslate notranslate">
					<h5><bold>Indoors:</bold></h5>
					<p>Is internal door made from laminate material with wooden frame. Lamin material ensire the indoors to be scratch resistance and beautiful surface.</p>

					<h5><bold>Assembly information:</bold></h5>
					<ul>
						<li>- Standard door hinges supports.</li>
						<li>- Normal doorknob and Lever doorknob can be fitted.</li>
						<li>- Eagle eye can be fitted.</li>
						<li>- Door bumper guard point available.</li>
					</ul>
					<h5><bold>Size:</bold></h5>
					
					<p>Bedroom: 80x200 cm</p>

					<h5><bold>Wight: </bold></h5>
					<p>20 kgs.</p>

					<h5><bold>Specifically of Product</bold></h5>


				</div>
				<?php } ?>

				
				<hr>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56a59d09bac37383" async="async"></script>
				<div class="addthis_sharing_toolbox"></div> <?php
				echo form_close(); ?>
			</div>
		</div>
	</section>
</main>
<script>
	var PS_Amount = parseInt("<?php echo $product_stock['PS_Amount']; ?>");
	var SS_Amount = parseInt("<?php echo $qty_session; ?>");
	$('.product-show').bxSlider({
	  	mode: 'fade',
	  	pagerCustom: '#product-pager',
	  	controls: false
	});
	$('#qty').keyup(function() {
		if ($('#prp').val() > 0)
			$('.product-price-view').text('฿' + (($(this).val() * $('#prp').val()).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
		if ($('#prs').val() > 0)
			$('.price-sale').text('ราคาปกติ ฿' + (($(this).val() * $('#prs').val()).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
	});
	$('#qty').change(function() {
		if ($('#prp').val() > 0)
			$('.product-price-view').text('฿' + (($(this).val() * $('#prp').val()).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
		if ($('#prs').val() > 0)
			$('.price-sale').text('ราคาปกติ ฿' + (($(this).val() * $('#prs').val()).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
	});
	$('#qty').focus(function() {
		$(this).keypress(function(e) {
            if (e.which == 13) $('#cart_order_added').submit();
        });
	});
	$('#qty').focusout(function() {
		if ($(this).val() < 1) {
			$(this).val(1);
			$('#qty').trigger('keyup');
		}
	});
	$('#btn_cart_add').click(function() {
		// if (confirm('ยืนยันการเพิ่มสินค้าในตะกร้า') === true)
			$('#cart_order_added').submit();
	});
	$('#cart_order_added').submit(function(event) {
		if ($('#qty').val() < 1) {
			alert('กรุณาระบุจำนวนสินค้า');
  			event.preventDefault();
		}
  		else if (PS_Amount < 1) {
  			alert('สินค้าหมด');
  			event.preventDefault();
  		}
  		else if ($('#qty').val() > (PS_Amount - SS_Amount)) {
	  		alert('สินค้ามีจำนวนไม่พอ กรุณาทำรายการใหม่');
	  		event.preventDefault();
  		}
	});
</script>