<?php if (uri_seg(2) == 'control_cart' && uri_seg(4) != 'edit') { ?>
    <div class="dt-custom-head">
        <div class="dt-custom-menu">
            <ul> <?php
                if (uri_seg(3) == 'order_doing_unannounce' || uri_seg(3) == 'order_doing_announced') {
                    $unannounce = rowArray($this->common_model->custom_query(
                        " SELECT COUNT(`OD_ID`) AS `U_ODID` FROM `order` WHERE `OD_Allow` IN ('1', '4') "
                    ));
                    if (count($unannounce) > 0) $U_ODID = $unannounce['U_ODID']; else $U_ODID = 0;
                    $announced = rowArray($this->common_model->custom_query(
                        " SELECT COUNT(`OD_ID`) AS `A_ODID` FROM `order` WHERE `OD_Allow` IN ('5', '6') "
                    ));
                    if (count($announced) > 0) $A_ODID = $announced['A_ODID']; else $A_ODID = 0; ?>
                    <li <?php if (uri_seg(3) == 'order_doing_unannounce') { ?> class="active" <?php } ?>><a href="<?php echo base_url('cart/control_cart/order_doing_unannounce'); ?>"><i class="fa fa-clock-o"></i> ยังไม่ได้แจ้งชำระ&nbsp;<span class="hvr-bob"><?php echo $U_ODID; ?></span></a><div></div></li>
                    <li <?php if (uri_seg(3) == 'order_doing_announced')  { ?> class="active" <?php } ?>><a href="<?php echo base_url('cart/control_cart/order_doing_announced'); ?>"><i class="fa fa-share"></i> แจ้งชำระแล้ว&nbsp;<span class="hvr-bob"><?php echo $A_ODID; ?></span></a><div></div></li> <?php
                }
                else if (uri_seg(3) == 'order_history_success' || uri_seg(3) == 'order_history_cancel') {
                    $transport = rowArray($this->common_model->custom_query(
                        " SELECT COUNT(`OD_ID`) AS `T_ODID` FROM `order` WHERE `OD_Allow` IN ('7') "
                    ));
                    if (count($transport) > 0) $T_ODID = $transport['T_ODID']; else $T_ODID = 0;
                    $canceled = rowArray($this->common_model->custom_query(
                        " SELECT COUNT(`OD_ID`) AS `C_ODID` FROM `order` WHERE `OD_Allow` IN ('2', '3') "
                    ));
                    if (count($canceled) > 0) $C_ODID = $canceled['C_ODID']; else $C_ODID = 0; ?>
                    <li <?php if (uri_seg(3) == 'order_history_success') { ?> class="active" <?php } ?>><a href="<?php echo base_url('cart/control_cart/order_history_success'); ?>"><i class="fa fa-exchange"></i> จัดส่งแล้ว&nbsp;(<?php echo $T_ODID; ?>)</a><div></div></li>
                    <li <?php if (uri_seg(3) == 'order_history_cancel')  { ?> class="active" <?php } ?>><a href="<?php echo base_url('cart/control_cart/order_history_cancel'); ?>"><i class="fa fa-lock"></i> ยกเลิก/ระงับ&nbsp;(<?php echo $C_ODID; ?>)</a><div></div></li> <?php
                } ?>
            </ul>
        </div> <?php
        if (uri_seg(4) != 'view') { ?>
            <div class="dt-custom-search"> <?php
                        if (uri_seg(3) == 'order_doing_unannounce'  ) { ?><label>ค้นหาวันที่สั่งซื้อ: </label><?php }
                else    if (uri_seg(3) == 'order_doing_announced'   ) { ?><label>ค้นหาวันที่แจ้ง: </label><?php }
                else    if (uri_seg(3) == 'order_history_success'   ) { ?><label>ค้นหาวันที่สั่งซื้อ: </label><?php }
                else    if (uri_seg(3) == 'order_history_cancel'    ) { ?><label>ค้นหาวันที่สั่งซื้อ: </label><?php } ?>
                <input type="text" id="datepicker" placeholder="ป้อนข้อมูลวันที่">
            </div> <?php
        } ?>
    </div> <?php
}
else { ?>
    <!-- <div class="dt-normal"></div> -->
    <?php
} ?>