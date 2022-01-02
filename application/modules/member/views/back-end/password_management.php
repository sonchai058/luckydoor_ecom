<?php
	$query = $this->common_model->custom_query(" SELECT * FROM `$table` WHERE `$field_key` = $field_id AND `$field_allow` != '3' LIMIT 1 ");
	if (count($query) > 0) { ?>
		<div id="order_detail">
			<div class="mDiv">
				<div class="ftitle">แก้ไข <?php echo $title; ?></div>
			</div>
			<div class="main-table-box"> <?php
				echo form_open('member/control_member/password_changed'); ?>
					<div class="form-div"> <?php
						foreach ($query as $key => $value) {
							echo form_input(array('id' => 'field-M_ID', 'class' => 'form-control', 'name' => 'M_ID', 'type' => 'hidden', 'value' => $field_id)); ?>
							<div class="form-field-box odd">
								<div class="form-header-box">ชื่อผู้ใช้งาน: </div>
								<div class="form-display-box"><?php echo $value['M_Username']; ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">รหัสผ่าน (ปัจจุบัน)<span class="required">*</span>: </div>
								<div class="form-input-box"><?php echo form_input(array('id' => 'field-M_Passcurr', 'class' => 'form-control', 'name' => 'M_Passcurr', 'type' => 'password', 'maxlength' => '200', 'required' => 'required')); ?></div>
							</div>
							<div class="form-field-box odd">
								<div class="form-header-box">รหัสผ่าน (ใหม่)<span class="required">*</span>: </div>
								<div class="form-input-box"><?php echo form_input(array('id' => 'field-M_Password', 'class' => 'form-control', 'name' => 'M_Password', 'type' => 'password', 'maxlength' => '200', 'required' => 'required')); ?></div>
							</div>
							<div class="form-field-box even">
								<div class="form-header-box">ยืนยันรหัสผ่าน (ใหม่)<span class="required">*</span>: </div>
								<div class="form-input-box"><?php echo form_input(array('id' => 'field-M_Passconf', 'class' => 'form-control', 'name' => 'M_Passconf', 'type' => 'password', 'maxlength' => '200', 'required' => 'required')); ?></div>
							</div> <?php
							if (validation_errors() || (isset($validation_error) && $validation_error === 'error')) { ?>
								<div id="report-error" class="report-div error"> <?php
									if (isset($validation_error) && $validation_error === 'error') echo '<p>รหัสผ่าน (ปััจุบัน) ไม่ถูกต้อง</p>';
									echo form_error('M_Passcurr');
									echo form_error('M_Password');
									echo form_error('M_Passconf'); ?>
								</div> <?php
							}
							else if (isset($validation_success) && $validation_success === 'success') { ?>
								<div id="report-success" class="report-div success">
									<p>ข้อมูลของคุณอัพเดตเรียบร้อยแล้ว</p>
								</div> <?php
							}
						} ?>
					</div>
					<div class="iDiv">
						<div class="form-button-box">
							<input id="form-button-save" type="submit" value="อัพเดตการเปลี่ยนแปลง" class="btn btn-large">
						</div>
					</div> <?php
				echo form_close(); ?>
			</div>
		</div> <?php
	}
?>