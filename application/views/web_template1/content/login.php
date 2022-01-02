<?php 
	$attributes = array(
		'class' => 'form-login', 
		'id'    => 'form-login', 
	);
	echo form_open('member/login', $attributes); ?> 
		<h2>เข้าสู่ระบบ</h2>
		<div class="row">
			<div class="small-12 columns"> 
				<label>ชื่อผู้ใช้งาน (Username) <?php
					$data = array(
						'type'			=> 'text',
						'id' 			=> 'user_id',
						'name' 			=> 'user_id',
						'placeholder' 	=> 'ชื่อผู้ใช้งาน (Username)...',
						'required' 		=> 'required',
						'title' 		=> 'ชื่อผู้ใช้งาน (Username)',
					);
					echo form_input($data); ?>
				</label> 
				<label>รหัสผ่าน (Password) <?php
					$data = array(
						'type'			=> 'password',
						'id' 			=> 'user_pass',
						'name' 			=> 'user_pass',
						'placeholder' 	=> 'รหัสผ่าน (Password)...',
						'required' 		=> 'required',
						'title' 		=> 'รหัสผ่าน (Password)',
					);
					echo form_input($data); ?>
				</label> <?php
				// $data = array(
				// 	'id' 			=> 'checkbox12',
				// 	'name' 			=> 'checkbox12',
				// 	'checked' 		=> false,
				// 	'title' 		=> 'ให้ฉันอยู่ในระบบต่อไป',
				// );
				// echo form_checkbox($data);
				// echo form_label('ให้ฉันอยู่ในระบบต่อไป', 'checkbox12'); 
				if (validation_errors()) { ?>
                    <font color="red"> <?php
                        echo form_error('user_id');
                        echo form_error('user_pass'); ?>
                    </font> <?php
                } ?>
				<a href="<?php echo base_url('member/forgotpassword'); ?>" class="btn-forgot">ลืมรหัสผ่านใช่หรือไม่</a>
				<div class="field-submit">
					<a href="#" role="button" class="btn-login" id="btn-login">เข้าสู่ระบบ</a>
					<a href="<?php echo base_url('member/register'); ?>" role="button" class="btn-signup">สมัครใช้งาน</a>
				</div>
			</div>
		</div> <?php
	echo form_hidden('loggedin', 'loggedin');
	echo form_hidden('current_url', current_url());
	echo form_close();
?>