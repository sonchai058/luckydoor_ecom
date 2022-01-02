<?php
    $provinces  = $this->fill_dropdown_model->getOnceWebMain('provinces',   'Province_ID',  'Province_Name');
    $amphures   = $this->fill_dropdown_model->getOnceWebMain('amphures',    'Amphur_ID',    'Amphur_Name');
    $districts  = $this->fill_dropdown_model->getOnceWebMain('districts',   'District_ID',  'District_Name');
?>
<main>
    <?php $this->template->load('header/breadcrumb'); ?>
    <section> <?php
        if ($this->cart->contents()) { ?>
            <div class="row">
                <div class="small-12 medium-8 columns">
                    <div class="login-wrapper"> <?php
                        $attributes = array(
                            'id'            => 'cart_order_address',
                            // 'data-abide'    => 'data-abide',
                            'novalidate'    => 'novalidate',
                        );
                        echo form_open('cart/cartOrderAddress', $attributes); ?>
                            <h4>เลือกการจัดส่ง</h4>
                            <div class="row">
                                <!-- <div class="small-4 columns">
                                    <div class="checkout-img-delivery">
                                        <img class="thumbnail active" src="<?php echo base_url('assets/images/checkout/th-post.png'); ?>" alt="Thailand Post">
                                    </div>
                                    <div class="text-center checkout-price-delivery">
                                        <h4></h4>
                                    </div>
                                </div>
                                <div class="small-4 columns">
                                    <div class="checkout-img-delivery">
                                        <img class="thumbnail" src="<?php echo base_url('assets/images/checkout/fed-ex.png'); ?>" alt="FedEx">
                                    </div>
                                    <div class="text-center checkout-price-delivery">
                                        <h4></h4>
                                    </div>
                                </div> -->
                                <div class="small-4 columns">
                                    <div class="checkout-img-delivery">
                                        <img class="thumbnail" src="<?php echo base_url('assets/images/checkout/nim.png'); ?>" alt="NiMExpress">
                                    </div>
                                    <div class="text-center checkout-price-delivery">
                                        <h4></h4>
                                    </div>
                                </div> <?php
                                echo form_input(array('type' => 'hidden', 'id' => 'delivery_index', 'name' => 'delivery_index'));
                                // echo form_input(array('type' => 'hidden', 'id' => 'delivery_price', 'name' => 'delivery_price'));
                                echo form_input(array('type' => 'hidden', 'id' => 'delivery_types', 'name' => 'delivery_types')); ?>
                            </div>
                            <hr>
                            <!-- <h4>เลือกการบรรจุสินค้า</h4> <?php
                            echo form_input(array('type' => 'radio', 'id' => 'packing_fee_typical', 'name' => 'packing_fee', 'value' => '0',    'class' => 'packing_fee'));
                            echo 'ธรรมดา';
                            echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                            echo form_input(array('type' => 'radio', 'id' => 'packing_fee_special', 'name' => 'packing_fee', 'value' => '100',  'class' => 'packing_fee'));
                            echo 'พิเศษ (+100฿)'; ?>
                            <hr> -->
                            <h4>ข้อมูลลูกค้า</h4> <?php
                            if (get_session('C_ID') != '') {
                                echo form_input(array('type' => 'radio', 'id' => 'account_address', 'name' => 'account_address', 'value' => 'checked'));
                                echo 'ใช้ที่อยู่เดียวกับข้อมูลบัญชีผู้ใช้';
                                echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                                echo form_input(array('type' => 'radio', 'id' => 'deliver_address', 'name' => 'account_address', 'value' => 'uncheck'));
                                echo 'ระบุข้อมูลที่อยู่ในการจัดส่งใหม่';
                            }
                            else { ?>
                                <p>มีบัญชีผู้ใช้แล้วใช่หรือไม่? <a href="#" class="checkout-login" data-toggle="reveal-login">คลิกที่นี่</a> เพื่อเข้าสู่ระบบ</p><br> <?php
                            }
                            if (validation_errors()) { ?>
                                <div data-abide-error class="alert callout">
                                    <p><i class="fi-alert"></i><?php echo form_error('OD_Name'); ?></p>
                                    <p><i class="fi-alert"></i><?php echo form_error('OD_Tel'); ?></p>
                                    <p><i class="fi-alert"></i><?php echo form_error('OD_Email'); ?></p>
                                    <p><i class="fi-alert"></i><?php echo form_error('OD_hrNumber'); ?></p>
                                    <p><i class="fi-alert"></i><?php echo form_error('OD_VilNo'); ?></p>
                                    <p><i class="fi-alert"></i><?php echo form_error('Province_ID'); ?></p>
                                    <p><i class="fi-alert"></i><?php echo form_error('Amphur_ID'); ?></p>
                                    <p><i class="fi-alert"></i><?php echo form_error('District_ID'); ?></p>
                                    <p><i class="fi-alert"></i><?php echo form_error('Zipcode_Code'); ?></p>
                                </div> <?php
                            } ?>
                            <div class="row">
                                <div class="small-4 medium-3 columns">
                                    <label for="OD_Name" class="middle label-login">ชื่อ-นามสกุล: </label>
                                </div>
                                <div class="small-8 medium-9 columns">
                                    <input type="text" id="OD_Name" name="OD_Name" placeholder="ชื่อ-นามสกุล" required value="<?php echo get_session('OD_Name'); ?>">
                                    <span class="form-error"><h5>กรุณากรอก ชื่อ-นามสกุล</h5></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-4 medium-3 columns">
                                    <label for="OD_Tel" class="middle label-login">โทรศัพท์: </label>
                                </div>
                                <div class="small-8 medium-9 columns">
                                    <input type="text" id="OD_Tel" name="OD_Tel" placeholder="โทรศัพท์" required value="<?php echo get_session('OD_Tel'); ?>">
                                    <span class="form-error"><h5>กรุณากรอก โทรศัพท์</h5></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-4 medium-3 columns">
                                    <label for="OD_Email" class="middle label-login">อีเมล: </label>
                                </div>
                                <div class="small-8 medium-9 columns">
                                    <input type="text" id="OD_Email" name="OD_Email" placeholder="อีเมล" required value="<?php echo get_session('OD_Email'); ?>">
                                    <span class="form-error"><h5>กรุณากรอก อีเมล</h5></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-4 medium-3 columns">
                                    <label for="OD_hrNumber" class="middle label-login">เลขที่/ห้อง: </label>
                                </div>
                                <div class="small-8 medium-9 columns">
                                    <input type="text" id="OD_hrNumber" name="OD_hrNumber" placeholder="เลขที่/ห้อง" required value="<?php echo get_session('OD_hrNumber'); ?>">
                                    <span class="form-error"><h5>กรุณากรอก เลขที่/ห้อง</h5></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-4 medium-3 columns">
                                    <label for="OD_VilBuild" class="middle label-login">หมู่บ้าน/อาคาร/คอนโด: </label>
                                </div>
                                <div class="small-8 medium-9 columns">
                                    <input type="text" id="OD_VilBuild" name="OD_VilBuild" placeholder="หมู่บ้าน/อาคาร/คอนโด" value="<?php echo get_session('OD_VilBuild'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-4 medium-3 columns">
                                    <label for="OD_VilNo" class="middle label-login">หมู่ที่: </label>
                                </div>
                                <div class="small-8 medium-9 columns">
                                    <input type="text" id="OD_VilNo" name="OD_VilNo" placeholder="หมู่ที่" value="<?php echo get_session('OD_VilNo'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-4 medium-3 columns">
                                    <label for="OD_LaneRoad" class="middle label-login">ตรอก/ซอย: </label>
                                </div>
                                <div class="small-8 medium-9 columns">
                                    <input type="text" id="OD_LaneRoad" name="OD_LaneRoad" placeholder="ตรอก/ซอย" value="<?php echo get_session('OD_LaneRoad'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-4 medium-3 columns">
                                    <label for="OD_Street" class="middle label-login">ถนน: </label>
                                </div>
                                <div class="small-8 medium-9 columns">
                                    <input type="text" id="OD_Street" name="OD_Street" placeholder="ถนน" value="<?php echo get_session('OD_Street'); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-4 medium-3 columns">
                                    <label for="Province_ID" class="middle label-login">จังหวัด: </label>
                                </div>
                                <div class="small-8 medium-9 columns">
                                    <select id="Province_ID" name="Province_ID" onchange="ajaxRequest('<?php echo base_url('main/locations'); ?>', 'amphures', 'Province_ID', this.value, 'Amphur_ID', 'Amphur_Name', '#Amphur_ID', 'select')" required> <?php
                                        foreach ($provinces as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>" <?php if (get_session('Province_ID') != '' && get_session('Province_ID') == $key) { ?> selected <?php } ?>><?php echo trim($value); ?></option> <?php
                                        } ?>
                                    </select>
                                    <span class="form-error"><h5>กรุณาเลือก จังหวัด</h5></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-4 medium-3 columns">
                                    <label for="Amphur_ID" class="middle label-login">เขต/อำเภอ: </label>
                                </div>
                                <div class="small-8 medium-9 columns">
                                    <select id="Amphur_ID" name="Amphur_ID" onchange="ajaxRequest('<?php echo base_url('main/locations'); ?>', 'districts', 'Amphur_ID', this.value, 'District_ID', 'District_Name', '#District_ID', 'select')" required> <?php
                                        foreach ($amphures as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>"><?php echo trim($value); ?></option> <?php
                                        } ?>
                                    </select>
                                    <span class="form-error"><h5>กรุณาเลือก เขต/อำเภอ</h5></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-4 medium-3 columns">
                                    <label for="District_ID" class="middle label-login">แขวง/ตำบล: </label>
                                </div>
                                <div class="small-8 medium-9 columns">
                                    <select id="District_ID" name="District_ID" onchange="ajaxRequest('<?php echo base_url('main/locations'); ?>', 'zipcodes', 'District_ID', this.value, 'Zipcode_ID', 'Zipcode_Code', '.zipcodes', 'input')" required> <?php
                                        foreach ($districts as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>"><?php echo trim($value); ?></option> <?php
                                        } ?>
                                    </select>
                                    <span class="form-error"><h5>กรุณาเลือก แขวง/ตำบล</h5></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-4 medium-3 columns">
                                    <label for="Zipcode_Code" class="middle label-login">รหัสไปรษณีย์: </label>
                                </div>
                                <div class="small-8 medium-9 columns">
                                    <input type="text" id="Zipcode_Code" name="Zipcode_Code" placeholder="รหัสไปรษณีย์" class="zipcodes" required value="<?php echo get_session('Zipcode_Code'); ?>">
                                    <span class="form-error"><h5>กรุณากรอก รหัสไปรษณีย์</h5></span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="small-12 medium-3 large-offset-9 columns">
                                    <a href="#" class="button btn-checkout" id="btn_cart_address">ดำเนินการต่อไป</a>
                                </div>
                            </div> <?php
                        echo form_close(); ?>
                    </div>
                </div>
                <!-- Summary -->
                <?php $this->load->view('front-end/summary'); ?>
            </div>
            <a href="#"></a> <?php
        } ?>
    </section>
</main>
<script type="text/javascript">
    // var delivery_price  = [150.00, 150.00, 150.00];
    // var delivery_types  = ['Thailand Post', 'FedEx', 'NIM Express'];
    // var delivery_ships  = ['จัดส่งในวันถัดไป', 'จัดส่งในวันถัดไป', 'จัดส่งในวันถัดไป'];
    var delivery_types  = ['NIM Express', ''];
    var delivery_ships  = ['จัดส่งในวันถัดไป', ''];

    function ajaxRequest(module, field_table, field_key, field_id, field_value, field_name, element_id, element_name) {
        var request = $.ajax({
            url:    module,
            method: 'POST',
            data:   {
                fieldTable: field_table,
                fieldKey:   field_key,
                fieldID:    field_id,
                fieldValue: field_value,
                fieldName:  field_name,
                fieldEle:   element_name,
            }
        });
        request.done(function(msg) {
            if (element_name === 'select') {
                $(element_id).find('option').remove().end();
                $.each(JSON.parse(msg), function(i, value) {
                    $(element_id).append($('<option>').text(value).attr('value', i));
                });
                $(element_id).trigger('change');
            }
            else if (element_name === 'input') {
                $(element_id).val();
                $(element_id).val(JSON.parse(msg));
            }
        });
        request.fail(function(jqXHR, textStatus) {
            alert('Request failed: ' + textStatus);
        });
    }

    $(document).ready(function() {
        var checkout_index_delivery = "<?php echo get_session('delivery_index'); ?>";
        $('.checkout-price-delivery').each(function(index) {
            // $(this).find('h4:nth-child(1)').text('+ ฿' + (parseFloat(delivery_price[index]).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            // $(this).find('h4:nth-child(2)').text(delivery_ships[index]);
            $(this).find('h4').text(delivery_ships[index]);
        })
        $('.checkout-img-delivery').click(function() {
            $('.checkout-img-delivery').find('img').removeClass('active');
            if ($(this).find('img').prop('class') == 'thumbnail active')
                $(this).find('img').removeClass('active');
            else if ($(this).find('img').prop('class') == 'thumbnail')
                $(this).find('img').addClass('active');
            $('#delivery_index').val($('.checkout-img-delivery').index(this));
            // $('#delivery_price').val(delivery_price[$('.checkout-img-delivery').index(this)]);
            $('#delivery_types').val(delivery_types[$('.checkout-img-delivery').index(this)]);
            // $('#price_delivery').text('฿' + (parseFloat(delivery_price[$('.checkout-img-delivery').index(this)]).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });
        if (checkout_index_delivery != '')
            $('.checkout-img-delivery').eq(parseInt(checkout_index_delivery)).trigger('click');
        else
            $('.checkout-img-delivery').eq(0).trigger('click');
        $('#Province_ID').trigger('change');
        $('#account_address').change(function() {
            var request = $.ajax({
                url:    "<?php echo base_url('cart/getAddress'); ?>",
                method: "POST",
            });
            request.done(function(msg) {
                var address = JSON.parse(msg);
                $('#OD_Name').val(address.M_flName);
                if (address.M_MTel != '') $('#OD_Tel').val(address.M_MTel); else $('#OD_Tel').val(address.M_HTel);
                $('#OD_Email').val(address.M_Email);
                $('#OD_hrNumber').val(address.M_hrNumber);
                $('#OD_VilBuild').val(address.M_VilBuild);
                $('#OD_VilNo').val(address.M_VilNo);
                $('#OD_LaneRoad').val(address.M_LaneRoad);
                $('#OD_Street').val(address.M_Street);
                setTimeout(function() {
                    $('#Province_ID').val(address.Province_ID);
                    $('#Province_ID').trigger('change');
                }, 0);
                setTimeout(function() {
                    $('#Amphur_ID').val(address.Amphur_ID);
                    $('#Amphur_ID').trigger('change');
                }, 500);
                setTimeout(function() {
                    $('#District_ID').val(address.District_ID);
                    $('#District_ID').trigger('change');
                }, 1000);
                $('#Zipcode_Code').val(address.Zipcode_Code);
            });
            request.fail(function(jqXHR, textStatus) {
                alert('Request failed: ' + textStatus);
            });
        });
        $('#deliver_address').change(function(){
            $('#OD_Name').val('');
            $('#OD_Tel').val('');
            $('#OD_Email').val('');
            $('#OD_hrNumber').val('');
            $('#OD_VilBuild').val('');
            $('#OD_VilNo').val('');
            $('#OD_LaneRoad').val('');
            $('#OD_Street').val('');
            setTimeout(function() {
                $('#Province_ID option:eq(0)').prop('selected', true);
                $('#Province_ID').trigger('change');
            }, 0);
            setTimeout(function() {
                $('#Amphur_ID option:eq(0)').prop('selected', true);
                $('#Amphur_ID').trigger('change');
            }, 500);
            setTimeout(function() {
                $('#District_ID option:eq(0)').prop('selected', true);
                $('#District_ID').trigger('change');
            }, 1000);
            $('#Zipcode_Code').val('');
        });
        $('#account_address').prop('checked', true).trigger('change');
        // $('.packing_fee').change(function() {
        //     $('#fee_packing').text('฿'      + ( parseFloat($(this).val()).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        //     $('#summary_price').text('฿'    + ((parseFloat($(this).val()) + parseFloat("<?php echo $grand_subtotal; ?>")).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        // });
        // $('#packing_fee_typical').prop('checked', true).trigger('change');
        $('#btn_cart_address').click(function() {
            // if (confirm('ยืนยันข้อมูลที่อยู่/การจัดส่ง') === true)
                $('#cart_order_address').submit();
        });
    });
</script>