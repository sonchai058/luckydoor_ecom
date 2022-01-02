<main>
    <?php 
    	$this->template->load('header/breadcrumb'); 
    	$provinces  = $this->fill_dropdown_model->getOnceWebMain('provinces',   'Province_ID',  'Province_Name'		);
    	$amphures   = $this->fill_dropdown_model->getOnceCustoms('amphures',    'Amphur_ID',    'Amphur_Name',		'Province_ID', 	$member_data['Province_ID']);
    	$districts  = $this->fill_dropdown_model->getOnceCustoms('districts',   'District_ID',  'District_Name',	'Amphur_ID', 	$member_data['Amphur_ID']);
    	$M_Img 		= $member_data['M_Img'];
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
	                    'id'    		=> 'form-account', 
	                    'data-abide'    => 'data-abide',
                        'novalidate'    => 'novalidate',
	                );
	                echo form_open_multipart('member/account', $attributes); ?> 
	                    <div class="row">
	                    	<div class="small-12 columns"><h3>ข้อมูลส่วนตัว</h3></div>
	                        <div class="small-12 columns"> <?php
	                        	if (validation_errors() || get_session('M_Email_Error') || get_session('M_Password_Error') || isset($upload_error)) { ?>
	                                <div data-abide-error class="alert callout">
	                                    <p><i class="fi-alert"></i><?php echo form_error('M_flName'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('M_MTel'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('M_Email'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('M_hrNumber'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('M_VilNo'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('Amphur_ID'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('District_ID'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('Province_ID'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('Zipcode_Code'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('M_Passcurr'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('M_Password'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo form_error('M_Passconf'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo $this->session->flashdata('M_Email_Error'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo $this->session->flashdata('M_Password_Error'); ?></p>
	                                    <p><i class="fi-alert"></i><?php echo $upload_error; ?></p>
	                                </div> <?php
	                                $this->session->unset_userdata('M_Email_Error');
	                                $this->session->unset_userdata('M_Password_Error');
	                            } ?>
	                            <div class="row">
	                            	<div class="small-4 medium-3 columns">
	                                    <label for="M_Img" class="middle label-login">รูปภาพประจำตัว: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                	<div id="image-customs">
											<div id="image-preview">
											  	<label for="M_Img" id="image-label">เลือกรูปภาพ</label>
											  	<input type="file" name="M_Img" id="M_Img">
											</div>
										</div>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_TName" class="middle label-login">คำนำหน้าชื่อ: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                	<label class="middle label-account">
		                                    <input type="radio" id="mrs" 	name="M_TName" title="นาง"	value="1" checked 	<?php if ($member_data['M_TName'] === '1') { ?> checked <?php } ?>> นาง &nbsp; 
											<input type="radio" id="ms" 	name="M_TName" title="นางสาว"	value="2" 			<?php if ($member_data['M_TName'] === '2') { ?> checked <?php } ?>> นางสาว &nbsp; 
											<input type="radio" id="mr" 	name="M_TName" title="นาย"	value="3" 			<?php if ($member_data['M_TName'] === '3') { ?> checked <?php } ?>> นาย &nbsp; 
											<input type="radio" id="other" 	name="M_TName" title="อื่นๆ"	value="4" 			<?php if ($member_data['M_TName'] === '4') { ?> checked <?php } ?>> อื่นๆ &nbsp; 
	                                	</label>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_flName" class="middle label-login">ชื่อ-นามสกุล<span class="required">*</span>: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="text" id="M_flName" name="M_flName" placeholder="ชื่อ-นามสกุล" value="<?php echo $member_data['M_flName']; ?>" required>
	                                    <span class="form-error"><h5>กรุณากรอก ชื่อ-นามสกุล</h5></span>
	                                </div>
	                            </div>
								<div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_ucName" class="middle label-login">Firstname-lastname: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="text" id="M_ucName" name="M_ucName" placeholder="Firstname-lastname" value="<?php echo $member_data['M_ucName']; ?>">
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_Sex" class="middle label-login">เพศ: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                	<label class="middle label-account">
		                                    <input type="radio" id="male" 	name="M_Sex" value="M" checked 	<?php if ($member_data['M_Sex'] === 'M') { ?> checked <?php } else if ($member_data['M_Sex'] === '') { ?> checked <?php } ?>> ชาย &nbsp; 
											<input type="radio" id="female" name="M_Sex" value="F" 			<?php if ($member_data['M_Sex'] === 'F') { ?> checked <?php } ?>> หญิง &nbsp; 
										</label>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_npID" class="middle label-login">เลขประจำตัวประชาชน: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="text" id="M_npID" name="M_npID" placeholder="เลขประจำตัวประชาชน" value="<?php echo $member_data['M_npID']; ?>">
	                                </div>
	                            </div>
								<div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_HTel" class="middle label-login">โทรศัพท์บ้าน: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="text" id="M_HTel" name="M_HTel" placeholder="โทรศัพท์บ้าน" value="<?php echo $member_data['M_HTel']; ?>">
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_MTel" class="middle label-login">โทรศัพท์มือถือ<span class="required">*</span>: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="text" id="M_MTel" name="M_MTel" placeholder="โทรศัพท์มือถือ" value="<?php echo $member_data['M_MTel']; ?>" required>
	                                    <span class="form-error"><h5>กรุณากรอก โทรศัพท์มือถือ</h5></span>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_Fax" class="middle label-login">โทรสาร: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="text" id="M_Fax" name="M_Fax" placeholder="โทรสาร" value="<?php echo $member_data['M_Fax']; ?>">
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_Email" class="middle label-login">อีเมล<span class="required">*</span>: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="email" id="M_Email" name="M_Email" placeholder="อีเมล" value="<?php echo $member_data['M_Email']; ?>" required>
	                                    <span class="form-error"><h5>กรุณากรอก อีเมล</h5></span>
	                                </div>
	                            </div>
		                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_hrNumber" class="middle label-login">เลขที่/ห้อง<span class="required">*</span>: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="text" id="M_hrNumber" name="M_hrNumber" placeholder="เลขที่/ห้อง" value="<?php echo $member_data['M_hrNumber']; ?>" required>
	                                    <span class="form-error"><h5>กรุณากรอก เลขที่/ห้อง</h5></span>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_VilBuild" class="middle label-login">หมู่บ้าน/อาคาร/คอนโด: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="text" id="M_VilBuild" name="M_VilBuild" placeholder="หมู่บ้าน/อาคาร/คอนโด" value="<?php echo $member_data['M_VilBuild']; ?>">
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_VilNo" class="middle label-login">หมู่ที่: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="text" id="M_VilNo" name="M_VilNo" placeholder="หมู่ที่" value="<?php echo $member_data['M_VilNo']; ?>">
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_LaneRoad" class="middle label-login">ตรอก/ซอย: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="text" id="M_LaneRoad" name="M_LaneRoad" placeholder="ตรอก/ซอย" value="<?php echo $member_data['M_LaneRoad']; ?>">
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_Street" class="middle label-login">ถนน: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="text" id="M_Street" name="M_Street" placeholder="ถนน" value="<?php echo $member_data['M_Street']; ?>">
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="Province_ID" class="middle label-login">จังหวัด: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <select id="Province_ID" name="Province_ID" onchange="ajaxRequest('<?php echo base_url('main/locations'); ?>', 'amphures', 'Province_ID', this.value, 'Amphur_ID', 'Amphur_Name', '#Amphur_ID', 'select')" required> <?php
	                                        foreach ($provinces as $key => $value) { ?>
	                                            <option value="<?php echo $key; ?>" <?php if ($key == $member_data['Province_ID']) { ?> selected <?php } ?>><?php echo trim($value); ?></option> <?php
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
	                                            <option value="<?php echo $key; ?>" <?php if ($key == $member_data['Amphur_ID']) { ?> selected <?php } ?>><?php echo trim($value); ?></option> <?php
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
	                                            <option value="<?php echo $key; ?>" <?php if ($key == $member_data['District_ID']) { ?> selected <?php } ?>><?php echo trim($value); ?></option> <?php
	                                        } ?>
	                                    </select>
	                                    <span class="form-error"><h5>กรุณาเลือก แขวง/ตำบล</h5></span>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="Zipcode_Code" class="middle label-login">รหัสไปรษณีย์<span class="required">*</span>: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="text" id="Zipcode_Code" name="Zipcode_Code" placeholder="รหัสไปรษณีย์" class="zipcodes" value="<?php echo $member_data['Zipcode_Code']; ?>" required>
	                                    <span class="form-error"><h5>กรุณากรอก รหัสไปรษณีย์</h5></span>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="small-12 columns">
	                        	<hr>
	                        	<h3>ข้อมูลการเข้าสู่ระบบ</h3>
	                        	<h5>หากไม่ต้องการเปลี่ยนแปลงรหัสผ่าน ให้ละเว้นการกรอกข้อมูลในส่วนนี้</h5>
	                        </div>
	                        <div class="small-12 columns">
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_Username" class="middle label-login">ชื่อผู้ใช้งาน: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <label class="middle label-account"><?php echo $member_data['M_Username']; ?></label>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_Passcurr" class="middle label-login">รหัสผ่านปัจจุบัน: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="password" id="M_Passcurr" name="M_Passcurr" placeholder="รหัสผ่านปัจจุบัน">
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_Password" class="middle label-login">รหัสผ่านใหม่: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="password" id="M_Password" name="M_Password" placeholder="รหัสผ่านใหม่">
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="small-4 medium-3 columns">
	                                    <label for="M_Passconf" class="middle label-login">ยืนยันรหัสผ่านใหม่: </label>
	                                </div>
	                                <div class="small-8 medium-9 columns">
	                                    <input type="password" id="M_Passconf" name="M_Passconf" placeholder="ยืนยันรหัสผ่านใหม่">
	                                </div>
	                            </div>
	                        </div>
	                        <div class="small-12 columns">
	                        	<hr>
	                            <div class="field-submit">
	                                <a href="#" role="button" class="btn-login" id="btn-account">ยืนยัน</a>
	                            	<a href="<?php echo base_url('member'); ?>" role="button" class="btn-signup">ยกเลิก</a>
	                            </div>
	                        </div>
	                    </div> <?php
	                echo form_hidden('accounted', 'accounted');
	                echo form_close();
	            ?>
			</div>
        </div>
    </section>                      
</main>
<script type="text/javascript">
	var M_Img = "<?php echo $M_Img; ?>";

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
        $('#btn-account').click(function() { 
            $('#form-account').submit();
        });

        $('#form-account').find('input').each(function(index) {
        	$(this).keypress(function(e) {
                if (e.which == 13)
                    $('#form-account').submit();
            });
        });

        if (M_Img != '') {
	        $('#image-preview').css('background-image', 	'url(../assets/uploads/profile_img/' + M_Img + ')');
	        $('#image-preview').css('background-size', 		'cover');
	        $('#image-preview').css('background-position', 	'center center');
	    }

        $.uploadPreview({
		    input_field: 	'#M_Img', 
		    preview_box: 	'#image-preview', 
		    label_field: 	'#image-label', 
		    label_default: 	'เลือกรูปภาพ', 
		    label_selected: 'เปลี่ยนรูปภาพ', 
		    no_label: 		false 
		});
    });
</script>