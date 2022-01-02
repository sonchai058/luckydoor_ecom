<main>
    <?php $this->template->load('header/breadcrumb'); ?>

    <section>
        <div class="row">
            <?php $this->load->view('front-end/category'); ?>

            <!-- Product -->
            <div class="columns">
                <div class="wrapper-product-title">
                    <h2>สินค้าของ Luckydoor</h2>
                    <p>นวัตกรรมการผลิตสินค้าในนามว่า "Lucky" ที่เน้นใช้อย่างประหยัดคุ้มค่าและมีรสนิยมสินค้าที่ผลิตออกมาจะตอบสนองตามความต้องการของผู้สร้างและผู้อยู่เป็นหลัก</p>
                    <p>ดังนี้เราจึงกล้ารับประกันผลิตภัณฑ์ที่ผลิตภายใต้แบรนด์ "Lucky" ว่ามีทั้งคุณภาพดีไซน์และราคาที่แข่งขันได้</p>
                </div> <?php
                echo form_input(array('type' => 'hidden', 'id' => 'current_page'));
                echo form_input(array('type' => 'hidden', 'id' => 'show_per_page')); ?>
                <div class="row row-product" id="row_product"> <?php
                    if ($product_empty == null) {
                        foreach ($product_query as $key => $value) {
                            $P_ID = $value['P_ID'];
                            $product_stock_query = rowArray($this->common_model->custom_query(
                                " SELECT * FROM `product_stock` WHERE `P_ID` = '$P_ID' AND `PS_Allow` = '1' ORDER BY `PS_ID` DESC LIMIT 1 "
                            ));

                            $product_promotion_query = rowArray($this->common_model->custom_query(
                                " SELECT * FROM `product_price` WHERE `P_ID` = '$P_ID' AND `PP_Special` = '1' AND `PP_Allow` = '1' AND (NOW() BETWEEN PP_StartDate AND PP_EndDate ) ORDER BY `PP_ID` DESC LIMIT 1 "
                            )); ?>
                            <div class="small-12 medium-6 large-3 columns">
                                <div class="product">
                                    <div class="product-wrapper">
                                        <div class="product-img-2"> <?php
                                            if ($value['P_Img'] !== '') { ?>
                                                <!-- <img src="<?php echo base_url('assets/images/products/outdoor/CF-0002.5.png'); ?>" alt="IMG_0354"> -->
                                                <img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$value['P_Img']); ?>" alt="<?php echo $value['P_Img']; ?>">
                                                <?php
                                            }
                                            else { ?>
                                                <!-- <img src="<?php echo base_url('assets/images/products/outdoor/CF-0002.5.png'); ?>" alt="IMG_0354"> -->
                                                <img src="<?php echo base_url('assets/images/noimage.gif'); ?>" alt="">
                                                <?php
                                            } ?>
    <!--                                         <div class="product-hvr">
                                                <a href="#" class="btn-buy-now" onclick="addToCart('<?php echo $value['P_ID']; ?>')"><i class="fa fa-cart-plus"></i> BUY NOW</a>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="product-price">
                                        <h5 class="product-title-2 text-green"><a href="<?php echo base_url('product/detail/'.$value['P_ID']); ?>"><?php echo $value['P_IDCode']; ?></a></h5>
                                        <h4> <?php
                                            if (count($product_promotion_query) > 0)
                                                echo '฿'.number_format($product_promotion_query['PP_Price'], 2, '.', ',');
                                            else if (count($product_stock_query) > 0)
                                                echo '฿'.number_format($product_stock_query['PS_Price'], 2, '.', ','); ?>
                                        </h4>
                                        <!-- <h5>
                                            <span class="price-sale"><?php if (count($product_promotion_query) > 0 && count($product_stock_query) > 0) echo '฿'.number_format($product_stock_query['PS_Price'], 2, '.', ','); ?></span><?php
                                            if (count($product_promotion_query) > 0 && count($product_stock_query) > 0) { ?>
                                                <span class="price-per-sale"><?php echo number_format(((1 - ($product_promotion_query['PP_Price'] / $product_stock_query['PS_Price'])) * 100), 0, '.', ',').'%'; ?></span> <?php
                                            } ?>
                                        </h5> -->
                                        <h5 class="text-red">
                                            <span class="out-of-stock"> <?php
                                                if (count($product_stock_query) <= 0 || (count($product_stock_query) > 0 && $product_stock_query['PS_Amount'] <= 0))
                                                    echo 'สินค้าหมด'; ?>
                                            </span>
                                        </h5>
                                    </div>
                                    <div class="field-btn"> <?php
                                        $product = rowArray($this->common_model->get_where_custom('product', 'P_ID', $P_ID));
                                        if (count($product) > 0) {
                                            $colors = explode(",", $product['P_Color']); ?>
                                            <select class="color-picker">
                                                <option value="0" disabled selected>Colors</option> <?php
                                                foreach ($colors as $key => $values) {
                                                    $product_color = rowArray($this->common_model->get_where_custom('product_color', 'PC_ID', $values));
                                                    if (count($product_color) > 0) { ?>
                                                        <option value="<?php echo $product_color['PC_ID']; ?>"><?php echo $product_color['PC_Name']; ?></option> <?php
                                                    }
                                                } ?>
                                            </select>
                                            <br><br> <?php
                                        } ?>
                                        <a href="<?php echo base_url('product/detail/'.$value['P_ID']); ?>" class="btn-view-detail"><i class="fa fa-search"></i> View Detail</a>
                                        <a href="#" class="btn-buy-now" onclick="addToCart('<?php echo $value['P_ID']; ?>')"><i class="fa fa-search"></i> Buy Now</a>
                                        <!-- <a href="<?php echo base_url('product/color/'.$value['P_ID']); ?>" class="btn-buy-now various fancybox.ajax"><i class="fa fa-cart-plus"></i></i> Buy Now</a> -->
                                    </div>
                                </div>

                            </div> <?php
                        }
                    }
                    else { ?>
                        <div class="small-12 medium-12 large-12 columns">
                            <h4><blockquote><cite><span><?php echo $product_empty; ?></span></cite></blockquote></h4>
                        </div> <?php
                    } ?>
                </div> <!-- End row -->

                <!-- <ul class="pagination text-center" role="navigation" aria-label="Pagination"></ul> -->
            </div> <!-- end-columns -->
        </div> <!-- end row -->
        <div class="row">
          <div class="columns">

              <ul class="pagination text-center" role="navigation" aria-label="Pagination"></ul>
          </div>
        </div>
    </section>
</main>
<script type="text/javascript">
    var show_per_page   = 8;

    var number_of_items = 0;
    var number_of_pages = 0;

    var color_value     = '';

    function addToCart(this_id) {
        window.location.href = "<?php echo base_url('cart/addToCart'); ?>/" + this_id + "/" + color_value;
    }

    function render_pagination() {
        if (number_of_pages > 1) {
            $('#current_page').val(0);
            $('#show_per_page').val(show_per_page);

            var navigation_html = '';

            navigation_html += '<li><a class="first" href="javascript:first();"><i class="fa fa-angle-double-left"></i></a></li>';
            navigation_html += '<li><a class="previous" href="javascript:previous();"><i class="fa fa-angle-left"></i></a></li>';
            for (current_link = 0; current_link < number_of_pages; ++current_link)
                navigation_html += '<li><a class="page" href="javascript:page(' + current_link + ')" longdesc="' + current_link + '">' + (current_link + 1) + '</a></li>';
            navigation_html += '<li><a class="next" href="javascript:next();"><i class="fa fa-angle-right"></i></a></li>';
            navigation_html += '<li><a class="last" href="javascript:last();"><i class="fa fa-angle-double-right"></i></a></li>';

            $('.pagination').html(navigation_html);

            for (pl = 1; pl < 3; ++pl)
                $('.pagination li:nth-child(' + pl + ') a').css('pointer-events', 'none');

            $('.pagination li:nth-child(3)').empty();
            $('.pagination li:nth-child(3)').html('<span class="show-for-sr">You&#39;re on page</span> 1');
            $('.pagination li:nth-child(3)').addClass('current');

            if (number_of_pages <= 1) {
                for (pl = $('.pagination li').length; pl > ($('.pagination li').length - 2); --pl)
                    $('.pagination li:nth-child(' + pl + ') a').css('pointer-events', 'none');
            }
        }
    }

    function first() {
        if ($('.first').css('pointer-events') != 'none') page(0);
    }

    function previous() {
        new_page = parseInt($('#current_page').val()) - 1;
        if (new_page >= 0) page(new_page);
    }

    function page(page_num) {
        if ($('.pagination li:nth-child(' + (page_num + 3) + ') a').css('pointer-events') != 'none') {
            start_from  = page_num      * parseInt($('#show_per_page').val());
            end_on      = start_from    + parseInt($('#show_per_page').val());
            $('.row-product').children().css('display', 'none');
            $('.row-product').children().slice(start_from, end_on).fadeIn('fast').css('display', 'block');
            $('.pagination li').empty();
            $('.pagination li').removeClass('current');
            $('.pagination li:nth-child(1)').html('<a class="first" href="javascript:first();"><i class="fa fa-angle-double-left"></i></a>');
            $('.pagination li:nth-child(2)').html('<a class="previous" href="javascript:previous();"><i class="fa fa-angle-left"></i></a>');
            for (link_current = 3; link_current < (number_of_pages + 4); ++link_current) {
                $('.pagination li:nth-child(' + link_current + ')').html('<a class="page" href="javascript:page(' + (link_current - 3) + ')" longdesc="' + (link_current - 3) + '">' + (link_current - 2) + '</a>');
            }
            $('.pagination li:nth-child(' + (number_of_pages + 3) + ')').html('<a class="next" href="javascript:next();"><i class="fa fa-angle-right"></i></a>');
            $('.pagination li:nth-child(' + (number_of_pages + 4) + ')').html('<a class="last" href="javascript:last();"><i class="fa fa-angle-double-right"></i></a>');
            $('.pagination li:nth-child(' + (page_num + 3) + ')').empty();
            $('.pagination li:nth-child(' + (page_num + 3) + ')').html('<span class="show-for-sr">You&#39;re on page</span> ' + (page_num + 1));
            $('.pagination li:nth-child(' + (page_num + 3) + ')').addClass('current');
            if (page_num <= 0) {
                $('.pagination li:first a').css('pointer-events', 'none');
                $('.pagination li:nth-child(2) a').css('pointer-events', 'none');
            }
            else if (page_num >= 0) {
                $('.pagination li:first a').css('pointer-events', 'inherit');
                $('.pagination li:nth-child(2) a').css('pointer-events', 'inherit');
            }
            if ((page_num + 1) >= number_of_pages) {
                $('.pagination li:nth-child(' + (number_of_pages + 3) + ') a').css('pointer-events', 'none');
                $('.pagination li:last a').css('pointer-events', 'none');
            }
            else if ((page_num + 1) <= number_of_pages) {
                $('.pagination li:nth-child(' + (number_of_pages + 3) + ') a').css('pointer-events', 'inherit');
                $('.pagination li:last').css('pointer-events', 'inherit');
            }
            $('#current_page').val(page_num);
        }
    }

    function next() {
        new_page = parseInt($('#current_page').val()) + 1;
        if (new_page < number_of_pages) page(new_page);
    }

    function last() {
        if ($('.last').css('pointer-events') != 'none') page(number_of_pages - 1);
    }

    $(document).ready(function() {
        $('.row-product').load(function() {
            number_of_items = $('.row-product').children().size();
            number_of_pages = Math.ceil(number_of_items / show_per_page);
            navigation_html = '';
            render_pagination();
            $('.row-product').children().css('display', 'none');
            $('.row-product').children().slice(0, show_per_page).css('display', 'block');
        });
        $('.row-product').trigger('load');
        // $(".various").fancybox();
        $('.color-picker').change(function() {
            color_value = $(this).val();
        });
    });
</script>
