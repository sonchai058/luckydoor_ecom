<?php
    if ($this->cart->contents()) { ?>
        <div class="columns">
            <div class="row row-summary">
                <div class="small-12 medium-expanded columns">
                    <div class="summary-head">
                        <h3>สรุปการสั่งซื้อ <?php if ($grand_quantity !== 0) echo '('.number_format($grand_quantity).')' ?></h3>
                    </div>
                </div> <?php
                foreach ($this->cart->contents() as $value) { ?>
                    <div class="small-7 columns">
                        <div class="summary-detail-1">
                            <h5><?php if ($value['name'] != '') echo $value['name']; if ($value['options']['code'] != '') echo ' '.$value['options']['code']; ?>: </h5>
                        </div>
                    </div>
                    <div class="small-1 columns">
                        <h5 class="text-right"><?php echo number_format($value['qty']); ?></h5>
                    </div>
                    <div class="small-4 columns">
                        <h4 class="text-right">฿<?php echo number_format($value['price'], 2, '.', ','); ?></h4>
                    </div> <?php
                } ?>
                <div class="small-12 columns"><hr></div>
                <div class="small-6 columns">
                    <div class="summary-detail-1">
                        <h5>น้ำหนักสินค้าทั้งหมด: </h5>
                    </div>
                </div>
                <div class="small-6 columns">
                    <h4 class="text-right"><?php if ($grand_weight !== 0) echo number_format($grand_weight, 2, '.', ','); else echo number_format(0, 2, '.', ','); ?> (กก.)</h4>
                </div>
                <div class="small-12 columns"><hr></div>
                <div class="small-6 columns">
                    <div class="summary-detail-1">
                        <h5>ค่าบริการจัดส่ง: </h5>
                    </div>
                </div>
                <div class="small-6 columns">
                    <h4 class="text-right">฿<?php if ($grand_wprice !== 0) echo number_format($grand_wprice, 2, '.', ','); else echo number_format(0, 2, '.', ','); ?></h4>
                </div>
                <!-- <div class="small-6 columns">
                    <div class="summary-detail-1">
                        <h5>ค่าจัดส่ง: </h5>
                    </div>
                </div>
                <div class="small-6 columns">
                    <h4 class="text-right" id="price_delivery">฿<?php if (get_session('delivery_price') != '') echo number_format(get_session('delivery_price'), 2, '.', ','); ?></h4>
                </div> -->
                <!-- <div class="small-6 columns">
                    <div class="summary-detail-1">
                        <h5>ค่าธรรมเนียมบรรจุสินค้า: </h5>
                    </div>
                </div>
                <div class="small-6 columns">
                    <h4 class="text-right" id="fee_packing">฿<?php if (get_session('packing_fee') != '') echo number_format(get_session('packing_fee'), 2, '.', ','); else echo number_format(0, 2, '.', ','); ?></h4>
                </div> -->
                <div class="small-12 columns"><hr></div>
                <div class="small-6 columns">
                    <div class="summary-detail-1">
                        <h5>ยอดสุทธิ: </h5>
                    </div>
                </div>
                <div class="small-6 columns">
                    <h4 class="text-right" id="summary_price">
                        ฿<?php
                        // if ($grand_subtotal !== 0 && get_session('delivery_price') != '')
                        //     echo number_format($grand_subtotal + get_session('delivery_price'), 2, '.', ',');
                        // if ($grand_subtotal !== 0 && get_session('packing_fee') != '')
                        //     echo number_format($grand_subtotal + get_session('packing_fee'), 2, '.', ',');
                        if ($grand_subtotal !== 0 && $grand_wprice !== 0)
                            echo number_format($grand_subtotal + $grand_wprice, 2, '.', ',');
                        else if ($grand_subtotal !== 0)
                            echo number_format($grand_subtotal, 2, '.', ','); ?>
                    </h4>
                </div>
                <!-- <div class="small-6 columns">
                    <h5>ยอดสุทธิ (รวมภาษีมูลค่าเพิ่ม): </h5>
                </div>
                <div class="small-6 columns">
                    <h3 class="text-right">฿446.00</h3>
                </div> -->
            </div>
        </div> <?php
    }
?>