<?php
    $site = $this->webinfo_model->getOnceWebMain();
    $doing = rowArray($this->common_model->custom_query(
        " SELECT COUNT(`OD_ID`) AS `D_ODID` FROM `order` WHERE `OD_Allow` IN ('1', '4', '5', '6') "
    ));
    if (count($doing) > 0) $D_ODID = $doing['D_ODID']; else $D_ODID = 0;
    $history = rowArray($this->common_model->custom_query(
        " SELECT COUNT(`OD_ID`) AS `H_ODID` FROM `order` WHERE `OD_Allow` IN ('2', '3', '7') "
    ));
    if (count($history) > 0) $H_ODID = $history['H_ODID']; else $H_ODID = 0;
    $M_TflNameAndImg = rowArray($this->common_model->get_where_custom('admin', 'M_ID', get_session('M_ID')));
    if (count($M_TflNameAndImg) > 0) {
        $M_TName_Array = array('1' => 'นาง', '2' => 'นางสาว', '3' => 'นาย', '4' => 'ไม่ระบุ');
        if ($M_TflNameAndImg['M_TName'] !== '' && $M_TflNameAndImg['M_flName'] !== '') {
            if ($M_TflNameAndImg['M_TName'] !== '4')
                $M_Fullname = $M_TName_Array[$M_TflNameAndImg['M_TName']].$M_TflNameAndImg['M_flName'];
            else
                $M_Fullname = $M_TflNameAndImg['M_flName'];
        }
        else if ($M_TflNameAndImg['M_TName'] !== '' && $M_TflNameAndImg['M_flName'] === '')
            $M_Fullname = get_session('M_flName');
        else if ($M_TflNameAndImg['M_TName'] === '' && $M_TflNameAndImg['M_flName'] !== '')
            $M_Fullname = $M_TflNameAndImg['M_flName'];
        else if ($M_TflNameAndImg['M_TName'] === '' && $M_TflNameAndImg['M_flName'] === '')
            $M_Fullname = get_session('M_flName');
        if ($M_TflNameAndImg['M_Img'] !== '')
            $M_ProfImgs = $M_TflNameAndImg['M_Img'];
        else
            $M_ProfImgs = get_session('M_Img');
    }
    else {
        $M_Fullname = get_session('M_flName');
        $M_ProfImgs = get_session('M_Img');
    }
?>
<div class="wrap_top">
    <div class="wrap_profile">
        <a title="<?php echo $M_Fullname; ?>"><img src="<?php echo base_url('assets/uploads/profile_img/'.$M_ProfImgs); ?>"></a>
        <a><span><?php echo $M_Fullname; ?></span></a>
        <a class="wrap_profile_show_hide" title="แสดงเมนูผู้ใช้งาน"><div></div></a>
        <a class="wrap_profile_hide_show" title="ซ่อนเมนูผู้ใช้งาน"><div></div></a>
    </div>
    <div class="wrap_profile_edit">
        <a href="<?php echo base_url('member/control_member/profile_management/edit'); ?>" title="แก้ไขข้อมูลส่วนตัว">
            <div class="profile-menu">
                <div class="profile-menu-icon pm-icon1"></div><div class="profile-menu-text"><span>แก้ไขข้อมูลส่วนตัว</span></div>
            </div>
        </a>
        <a href="<?php echo base_url('control/logout'); ?>" title="ออกจากระบบ">
            <div class="profile-menu">
                <div class="profile-menu-icon pm-icon2"></div><div class="profile-menu-text"><span>ออกจากระบบ</span></div>
            </div>
        </a>
    </div>
    <div class="wrap_head">
        <div class="wrap_head_menu">
            <ul> <?php
                if (uri_seg(1) == 'control') { ?>
                    <li class="active">
                        <a href="<?php echo base_url('control'); ?>" title="ยอดการขาย">
                            <div class="head-menu-icon head-menu-icon-statistic2"></div>ยอดการขาย
                        </a>
                        <div></div>
                    </li> <?php
                }
                else if (uri_seg(1) == 'product') { ?>
                    <li <?php if (uri_seg(2) == 'control_product'   && uri_seg(3) == 'product_management')          { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('product/control_product/product_management'); ?>"         title="สินค้า">
                            <div class="head-menu-icon head-menu-icon-product1"></div>สินค้า
                        </a>
                        <div></div>
                    </li>
                    <!-- <li <?php if (uri_seg(2) == 'control_product'   && uri_seg(3) == 'category_management')         { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('product/control_product/category_management'); ?>"        title="หมวดหมู่สินค้า">
                            <div class="head-menu-icon head-menu-icon-product2"></div>หมวดหมู่สินค้า
                        </a>
                        <div></div>
                    </li> -->
                    <li <?php if (uri_seg(2) == 'control_product'   && uri_seg(3) == 'product_size_manage')         { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('product/control_product/product_size_manage'); ?>"        title="ขนาด / รูปทรงสินค้า">
                            <div class="head-menu-icon head-menu-icon-product3"></div>ขนาด / รูปทรงสินค้า
                        </a>
                        <div></div>
                    </li>
                    <!-- <li <?php if (uri_seg(2) == 'control_product'   && uri_seg(3) == 'product_type_manage')         { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('product/control_product/product_type_manage'); ?>"        title="ชนิดสินค้า">
                            <div class="head-menu-icon head-menu-icon-product4"></div>ชนิดสินค้า
                        </a>
                        <div></div>
                    </li>  -->
                    <!-- <li <?php if (uri_seg(2) == 'control_product'   && uri_seg(3) == 'product_unit_manage')         { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('product/control_product/product_unit_manage'); ?>"        title="หน่วยนับสินค้า">
                            <div class="head-menu-icon head-menu-icon-product5"></div>หน่วยนับสินค้า
                        </a>
                        <div></div>
                    </li>  -->
                    <li <?php if (uri_seg(2) == 'control_product'   && uri_seg(3) == 'product_color_manage')        { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('product/control_product/product_color_manage'); ?>"       title="สีของสินค้า">
                            <div class="head-menu-icon head-menu-icon-product6"></div>สีของสินค้า
                        </a>
                        <div></div>
                    </li>
                    <li <?php if (uri_seg(2) == 'control_product'   && uri_seg(3) == 'product_weight_manage')       { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('product/control_product/product_weight_manage'); ?>"      title="น้ำหนักสินค้า">
                            <div class="head-menu-icon head-menu-icon-product7"></div>น้ำหนักสินค้า
                        </a>
                        <div></div>
                    </li>
                    <li <?php if (uri_seg(2) == 'control_product'   && uri_seg(3) == 'product_gallery_manage')      { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('product/control_product/product_gallery_manage'); ?>"     title="แกลเลอรี่รูปสินค้า">
                            <div class="head-menu-icon head-menu-icon-product8"></div>แกลเลอรี่รูปสินค้า
                        </a>
                        <div></div>
                    </li>
                    <li <?php if (uri_seg(2) == 'control_product'   && uri_seg(3) == 'product_promotion_manage')    { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('product/control_product/product_promotion_manage'); ?>"   title="โปรโมชั่นสินค้า">
                            <div class="head-menu-icon head-menu-icon-product9"></div>โปรโมชั่นสินค้า
                        </a>
                        <div></div>
                    </li> <?php
                }
                else if (uri_seg(1) == 'cart') { ?>
                    <li <?php if (uri_seg(2) == 'control_cart'      && uri_seg(3) == 'order_doing_unannounce')      { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('cart/control_cart/order_doing_unannounce'); ?>"           title="การสั่งซื้อ">
                            <div class="head-menu-icon head-menu-icon-cart1"></div>รายการที่ดำเนินการอยู่&nbsp;<span class="hvr-bob"><?php echo $D_ODID; ?></span>
                        </a>
                        <div></div>
                    </li> <?php
                    if (get_session('M_Type') == '1') { ?>
                        <li <?php if (uri_seg(2) == 'control_cart'  && uri_seg(3) == 'order_history_success')       { ?> class="active" <?php } ?>>
                            <a href="<?php echo base_url('cart/control_cart/order_history_success'); ?>"        title="ประวัติการซื้อ / ขาย">
                                <div class="head-menu-icon head-menu-icon-cart2"></div>ประวัติการซื้อ / ขาย&nbsp;(<?php echo $H_ODID; ?>)
                            </a>
                            <div></div>
                        </li> <?php
                    }
                }
                else if (uri_seg(1) == 'bank') { ?>
                    <li <?php if (uri_seg(2) == 'control_bank'      && uri_seg(3) == 'bank_management')             { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('bank/control_bank/bank_management'); ?>"                  title="รายชื่อธนาคาร">
                            <div class="head-menu-icon head-menu-icon-bank1"></div>รายชื่อธนาคาร
                        </a>
                        <div></div>
                    </li> <?php
                }
                else if (uri_seg(1) == 'member' && uri_seg(2) == 'control_member' &&  uri_seg(3) != 'profile_management' && uri_seg(3) != 'password_management' && uri_seg(3) != 'password_changed') { ?>
                    <li <?php if (uri_seg(2) == 'control_member'    && uri_seg(3) == 'member_management')           { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('member/control_member/member_management'); ?>"            title="สมาชิก">
                            <div class="head-menu-icon head-menu-icon-member1"></div>สมาชิก
                        </a>
                        <div></div>
                    </li>
                    <li <?php if (uri_seg(2) == 'control_member'    && uri_seg(3) == 'admin_management')            { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('member/control_member/admin_management'); ?>"             title="ผู้ดูแลระบบ">
                            <div class="head-menu-icon head-menu-icon-member2"></div>ผู้ดูแลระบบ
                        </a>
                        <div></div>
                    </li> <?php
                }
                else if (uri_seg(1) == 'member' && uri_seg(2) == 'control_member' && (uri_seg(3) == 'profile_management' || uri_seg(3) == 'password_management' || uri_seg(3) == 'password_changed')) { ?>
                    <li <?php if (uri_seg(2) == 'control_member'    && uri_seg(3) == 'profile_management')          { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('member/control_member/profile_management/edit'); ?>"      title="ข้อมูลส่วนตัว">
                            <div class="head-menu-icon head-menu-icon-member3"></div>ข้อมูลส่วนตัว
                        </a>
                        <div></div>
                    </li>
                    <li <?php if (uri_seg(2) == 'control_member'    &&(uri_seg(3) == 'password_management' || uri_seg(3) == 'password_changed')) { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('member/control_member/password_management/edit'); ?>"     title="ข้อมูลการเข้าสู่ระบบ">
                            <div class="head-menu-icon head-menu-icon-member4"></div>ข้อมูลการเข้าสู่ระบบ
                        </a>
                        <div></div>
                    </li> <?php
                }
                else if (uri_seg(1) == 'statistic') { ?>
                    <li <?php if (uri_seg(2) == 'control_statistic' && uri_seg(3) == 'total_sales')                 { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('statistic/control_statistic/total_sales'); ?>"            title="ยอดการขาย">
                            <div class="head-menu-icon head-menu-icon-statistic2"></div>ยอดการขาย
                        </a>
                        <div></div>
                    </li>
                    <li <?php if (uri_seg(2) == 'control_statistic' && (uri_seg(3) == 'stock_report' || uri_seg(3) == 'stock_detail')) { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('statistic/control_statistic/stock_report'); ?>"           title="รายงานสต็อกสินค้า">
                            <div class="head-menu-icon head-menu-icon-statistic3"></div>รายงานสต็อกสินค้า
                        </a>
                        <div></div>
                    </li>
                    <li <?php if (uri_seg(2) == 'control_statistic' && uri_seg(3) == 'user_history')                { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('statistic/control_statistic/user_history'); ?>"           title="ประวัติการใช้งาน">
                            <div class="head-menu-icon head-menu-icon-statistic4"></div>ประวัติการใช้งาน
                        </a>
                        <div></div>
                    </li>
                    <li <?php if (uri_seg(2) == 'control_statistic' && uri_seg(3) == 'view_history')                { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('statistic/control_statistic/view_history'); ?>"           title="ประวัติการเข้าชม">
                            <div class="head-menu-icon head-menu-icon-statistic1"></div>ประวัติการเข้าชม
                        </a>
                        <div></div>
                    </li> <?php
                }
                else if (uri_seg(1) == 'webconfig') { ?>
                    <li <?php if (uri_seg(2) == 'index' && uri_seg(3) == 'edit')                                    { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('webconfig/index/edit'); ?>" title="ตั้งค่าระบบ">
                            <div class="head-menu-icon head-menu-icon-setting1"></div>ตั้งค่าระบบ
                        </a>
                        <div></div>
                    </li>
                    <li <?php if (uri_seg(2) == 'image_slider_manage')                                              { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('webconfig/image_slider_manage'); ?>" title="ตั้งค่าภาพสไลด์">
                            <div class="head-menu-icon head-menu-icon-setting2"></div>ตั้งค่าภาพสไลด์
                        </a>
                        <div></div>
                    </li> <?php
                } ?>
            </ul>
        </div>
        <div class="wrap_head_name_logo">
            <!-- <a href="<?php echo base_url('control'); ?>" title="<?php echo $site["WD_Name"].' ('.$site["WD_EnName"].')'; ?>"> <?php
                if (isset($site["WD_Logo"]) && $site["WD_Logo"] !== '') { ?>
                    <img src="<?php echo base_url('assets/images/webconfig/'.$site["WD_Logo"]); ?>"> <?php
                } ?>
            </a> -->
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".wrap_profile_show_hide").click(function() {
            $(".wrap_profile_show_hide").css("display", "none");
            $(".wrap_profile_hide_show").css("display", "block");
            $(".wrap_profile_edit").fadeToggle("fast", "linear");
        });
        $(".wrap_profile_hide_show").click(function() {
            $(".wrap_profile_show_hide").css("display", "block");
            $(".wrap_profile_hide_show").css("display", "none");
            $(".wrap_profile_edit").fadeToggle("fast", "linear");
        });
    });
</script>