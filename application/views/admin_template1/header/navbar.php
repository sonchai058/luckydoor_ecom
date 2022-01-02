<div class="wrap_nav">
    <ul> <?php


        // Root Menu
        if (get_session('M_Type') == '1') { ?>
            <li <?php if (uri_seg(1) == 'control') { ?>     class="active" <?php } ?>>
                <a href="<?php echo base_url('control'); ?>" title="หน้าหลัก"><div class="nav-menu-icon1"></div></a>
            	<a href="<?php echo base_url('control'); ?>" title="หน้าหลัก">หน้าหลัก</a>
            </li>
            <li <?php if (uri_seg(1) == 'product') { ?>     class="active" <?php } ?>>
                <a href="<?php echo base_url('product/control_product/product_management'); ?>" title="สินค้า"><div class="nav-menu-icon2"></div></a>
            	<a href="<?php echo base_url('product/control_product/product_management'); ?>" title="สินค้า">สินค้า</a>
            </li>
            <li <?php if (uri_seg(1) == 'cart') { ?>        class="active" <?php } ?>>
                <a href="<?php echo base_url('cart/control_cart/order_doing_unannounce'); ?>"   title="การซื้อ / ขาย"><div class="nav-menu-icon3"></div></a>
            	<a href="<?php echo base_url('cart/control_cart/order_doing_unannounce'); ?>"   title="การซื้อ / ขาย">การซื้อ / ขาย</a>
            </li>
            <li <?php if (uri_seg(1) == 'bank') { ?>        class="active" <?php } ?>>
                <a href="<?php echo base_url('bank/control_bank/bank_management'); ?>"          title="รายชื่อธนาคาร"><div class="nav-menu-icon4"></div></a>
                <a href="<?php echo base_url('bank/control_bank/bank_management'); ?>"          title="รายชื่อธนาคาร">รายชื่อธนาคาร</a>
            </li>
            <li <?php if (uri_seg(1) == 'member') { ?>      class="active" <?php } ?>>
                <a href="<?php echo base_url('member/control_member/member_management'); ?>"    title="สมาชิก"><div class="nav-menu-icon5"></div></a>
            	<a href="<?php echo base_url('member/control_member/member_management'); ?>"    title="สมาชิก">สมาชิก</a>
            </li>
            <li <?php if (uri_seg(1) == 'statistic') { ?>   class="active" <?php } ?>>
                <a href="<?php echo base_url('statistic/control_statistic/total_sales'); ?>"    title="รายงาน / สถิติ"><div class="nav-menu-icon6"></div></a>
            	<a href="<?php echo base_url('statistic/control_statistic/total_sales'); ?>"    title="รายงาน / สถิติ">รายงาน / สถิติ</a>
            </li>
            <li <?php if (uri_seg(1) == 'webconfig') { ?>   class="active" <?php } ?>>
                <a href="<?php echo base_url('webconfig/index/edit'); ?>" title="ตั้งค่าระบบ"><div class="nav-menu-icon7"></div></a>
            	<a href="<?php echo base_url('webconfig/index/edit'); ?>" title="ตั้งค่าระบบ">ตั้งค่าระบบ</a>
            </li> <?php
        }



        // Accountant Menu
        else if (get_session('M_Type') == '2') { ?>
            <li <?php if (uri_seg(1) == 'control') { ?>     class="active" <?php } ?>>
                <a href="<?php echo base_url('control'); ?>" title="หน้าหลัก"><div class="nav-menu-icon1"></div></a>
                <a href="<?php echo base_url('control'); ?>" title="หน้าหลัก">หน้าหลัก</a>
            </li>
            <li <?php if (uri_seg(1) == 'product') { ?>     class="active" <?php } ?>>
                <a href="<?php echo base_url('product/control_product/product_management'); ?>" title="สินค้า"><div class="nav-menu-icon2"></div></a>
                <a href="<?php echo base_url('product/control_product/product_management'); ?>" title="สินค้า">สินค้า</a>
            </li>
            <li <?php if (uri_seg(1) == 'cart') { ?>        class="active" <?php } ?>>
                <a href="<?php echo base_url('cart/control_cart/order_doing_unannounce'); ?>"   title="การซื้อ / ขาย"><div class="nav-menu-icon3"></div></a>
                <a href="<?php echo base_url('cart/control_cart/order_doing_unannounce'); ?>"   title="การซื้อ / ขาย">การซื้อ / ขาย</a>
            </li>
            <li <?php if (uri_seg(1) == 'statistic') { ?>   class="active" <?php } ?>>
                <a href="<?php echo base_url('statistic/control_statistic/view_history'); ?>"   title="รายงาน / สถิติ"><div class="nav-menu-icon6"></div></a>
                <a href="<?php echo base_url('statistic/control_statistic/view_history'); ?>"   title="รายงาน / สถิติ">รายงาน / สถิติ</a>
            </li> <?php
        }



        // Stock Menu
        else if (get_session('M_Type') == '3') { ?>
            <li <?php if (uri_seg(1) == 'control') { ?>     class="active" <?php } ?>>
                <a href="<?php echo base_url('control'); ?>" title="หน้าหลัก"><div class="nav-menu-icon1"></div></a>
                <a href="<?php echo base_url('control'); ?>" title="หน้าหลัก">หน้าหลัก</a>
            </li>
            <li <?php if (uri_seg(1) == 'product') { ?>     class="active" <?php } ?>>
                <a href="<?php echo base_url('product/control_product/product_management'); ?>" title="สินค้า"><div class="nav-menu-icon2"></div></a>
                <a href="<?php echo base_url('product/control_product/product_management'); ?>" title="สินค้า">สินค้า</a>
            </li> <?php
        }



        // Messenger Menu
        else if (get_session('M_Type') == '4') { ?>
            <li <?php if (uri_seg(1) == 'control') { ?>     class="active" <?php } ?>>
                <a href="<?php echo base_url('control'); ?>" title="หน้าหลัก"><div class="nav-menu-icon1"></div></a>
                <a href="<?php echo base_url('control'); ?>" title="หน้าหลัก">หน้าหลัก</a>
            </li>
            <li <?php if (uri_seg(1) == 'cart') { ?>        class="active" <?php } ?>>
                <a href="<?php echo base_url('cart/control_cart/order_doing_unannounce'); ?>"   title="การซื้อ / ขาย"><div class="nav-menu-icon3"></div></a>
                <a href="<?php echo base_url('cart/control_cart/order_doing_unannounce'); ?>"   title="การซื้อ / ขาย">การซื้อ / ขาย</a>
            </li> <?php
        }



        // Other Menu
        else { ?>
            <li <?php if (uri_seg(1) == 'control') { ?>     class="active" <?php } ?>>
                <a href="<?php echo base_url('control'); ?>" title="หน้าหลัก"><div class="nav-menu-icon1"></div></a>
                <a href="<?php echo base_url('control'); ?>" title="หน้าหลัก">หน้าหลัก</a>
            </li> <?php
        } ?>


    </ul>
</div>