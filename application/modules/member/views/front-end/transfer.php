<main>
    <?php 
    	$this->template->load('header/breadcrumb'); 
    	$bank = $this->fill_dropdown_model->getOnceWebMain('bank', 'B_ID', 'B_Name');
    ?>
    <section>
        <div class="row account-wrapper">
            <?php $this->load->view('front-end/section'); ?>
            <div class="small-12 medium-expand columns">
				<div class="wrapper-orderstatus-title">
					<h1><?php echo $title; ?></h1>
					<?php echo $title; ?>
				</div>
				<?php 
	                $attributes = array(
	                    'class' 		=> 'form-login', 
	                    'id'    		=> 'form-transfer', 
	                    'data-abide'    => 'data-abide',
                        'novalidate'    => 'novalidate',
	                );
	                echo form_open_multipart('member/transfer/'.$order_data['OD_ID'], $attributes); ?> 
	                    <div class="row">
	                        <div class="small-12 columns"> <?php
	                        	if (validation_errors() || isset($upload_error)) { ?>
	                                <div data-abide-error class="alert callout">
	                                    <p><i class="fi-alert"></i><?php echo form_error('B_ID'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('OT_DateTimeAdd'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('OT_Price'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('OT_ImgAttach'); ?></p>
	                                    <p><i class="fi-alert"></i><?php if (isset($upload_error)) echo $upload_error; ?></p>
	                                </div> <?php
	                            } ?>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="OD_Code" class="middle label-login">เลขที่ใบสั่งซื้อ: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <label class="middle label-account"><?php echo $order_data['OD_Code']; ?></label>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="Province_ID" class="middle label-login">ธนาคาร: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <select id="B_ID" name="B_ID" required> <?php
	                                        foreach ($bank as $key => $value) { ?>
	                                            <option value="<?php echo $key; ?>"><?php echo trim($value); ?></option> <?php
	                                        } ?>
	                                    </select>
	                                    <span class="form-error"><h5>กรุณาเลือก ธนาคาร</h5></span>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="OT_Payment" class="middle label-login">ช่องทางชำระเงิน: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                	<label class="middle label-account">
		                                    <input type="radio" name="OT_Payment" value="1" title="โอนผ่านธนาคาร" checked> โอนผ่านธนาคาร &nbsp; 
											<input type="radio" name="OT_Payment" value="2" title="ชำระผ่านบัตร"> ชำระผ่านบัตร &nbsp; 
											<input type="radio" name="OT_Payment" value="3" title="ชำระผ่านเคาเตอร์เซอร์วิส"> ชำระผ่านเคาเตอร์เซอร์วิส &nbsp; 
											<input type="radio" name="OT_Payment" value="4" title="อื่นๆ"> อื่นๆ &nbsp; 
	                                	</label>
	                                </div>
	                            </div>
								<div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="OT_DateTimeAdd" class="middle label-login">วันเวลาที่ทำรายการ: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                	<input type="text" id="datetimepicker" name="OT_DateTimeAdd" placeholder="วันเวลาที่ทำรายการ" required readonly>
	                                	<span class="form-error"><h5>กรุณาเลือก วันเวลาที่ทำรายการ</h5></span>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="OT_Price" class="middle label-login">จำนวนเงิน: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="text" id="OT_Price" name="OT_Price" placeholder="จำนวนเงิน" required>
	                                    <span class="form-error"><h5>กรุณากรอก จำนวนเงิน</h5></span>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="OT_Descript" class="middle label-login">หมายเหตุ/รายละเอียด: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <textarea id="OT_Descript" name="OT_Descript" placeholder="หมายเหตุ/รายละเอียด" rows="3"></textarea>
	                                </div>
	                            </div>
	                            <div class="row">
	                            	<div class="small-4 medium-3 columns">
	                                    <label for="OT_ImgAttach" class="middle label-login">หลักฐานการโอนเงิน: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                	<label for="OT_ImgAttach" class="btn-upload">
	                                		<i class="fa fa-cloud-upload"></i> เลือกไฟล์
	                                	</label>
										<input type="file" class="input-file-custom" id="OT_ImgAttach" name="OT_ImgAttach">
	                                	<span class="val-upload">ยังไม่ได้เลือกไฟล์</span>
	                                	<span class="form-error"><h5>กรุณาเลือกไฟล์</h5></span>
	                                </div>
	                            </div>
	                            <div class="row">
	                            	<div class="small-4 medium-3 columns"></div>
	                                <div class="small-8 medium-9 columns">
										<div class="pre-upload">
	                                		<img class="img-upload" src="" alt="" title="">
	                                	</div>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="small-12 columns">
	                        	<hr>
	                            <div class="field-submit">
	                                <a href="#" role="button" class="btn-login" id="btn-transfer">ยืนยัน</a>
	                            	<a href="<?php echo base_url('member'); ?>" role="button" class="btn-signup">ยกเลิก</a>
	                            </div>
	                        </div>
	                    </div> <?php
	                echo form_hidden('transfered', 'transfered');
	                echo form_close();
	            ?>
			</div>
        </div>
    </section>                      
</main>
<script type="text/javascript">
    function readURL(input) {
    	if (input.files && input.files[0]) {
        	var reader = new FileReader();
        	reader.onload = function (e) {
            	$('.img-upload').prop('src', e.target.result);
        	}
        	reader.readAsDataURL(input.files[0]);
    	}
    	else
    		$('.img-upload').prop('src', '');
	}

    $(document).ready(function() {
        $('#btn-transfer').click(function() { 
            $('#form-transfer').submit();
        });

        $('#form-transfer').find('input').each(function(index) {
        	$(this).keypress(function(e) {
                if (e.which == 13)
                    $('#form-transfer').submit();
            });
        });

		$('#datetimepicker').datetimepicker({
			timeFormat: 'HH:mm',
			dateFormat: 'yy-mm-dd',
		});

		$('.input-file-custom').change(function() {
			$('.val-upload').text($(this).val().split('\\').pop());
			readURL(this);
		});
    });
</script>