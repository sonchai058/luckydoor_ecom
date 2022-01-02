<?php $site = $this->webinfo_model->getOnceWebMain(); ?>
<main>
    <?php $this->template->load('header/breadcrumb'); ?>

    <section>
        <div class="login-wrapper-2">
            <div class="login-logo">
                <img src="<?php echo base_url('assets/images/logo/logo-2.png'); ?>" alt="<?php echo $site['WD_Name']; ?>">
            </div>

            <?php 
                $attributes = array(
                    'class' => 'form-login', 
                    'id'    => 'form-register', 
                );
                echo form_open('member/register', $attributes); ?> 
                    <h2><?php echo $title; ?></h2>
                    <div class="row">
                        <div class="small-12 columns"> 
                            <label>ชื่อ-นามสกุล <?php
                                $data = array(
                                    'type'          => 'text',
                                    'id'            => 'fullname',
                                    'name'          => 'fullname',
                                    'placeholder'   => 'ชื่อ-นามสกุล...',
                                    'required'      => 'required',
                                    'title'         => 'ชื่อ-นามสกุล',
                                );
                                echo form_input($data); ?>
                            </label>
                            <label>อีเมล <?php
                                $data = array(
                                    'type'          => 'email',
                                    'id'            => 'email',
                                    'name'          => 'email',
                                    'placeholder'   => 'อีเมล...',
                                    'required'      => 'required',
                                    'title'         => 'อีเมล',
                                );
                                echo form_input($data); ?>
                            </label>
                            <label>ชื่อผู้ใช้งาน (Username) <?php
                                $data = array(
                                    'type'          => 'text',
                                    'id'            => 'username',
                                    'name'          => 'username',
                                    'placeholder'   => 'ชื่อผู้ใช้งาน (Username)...',
                                    'required'      => 'required',
                                    'title'         => 'ชื่อผู้ใช้งาน (Username)',
                                );
                                echo form_input($data); ?>
                            </label>
                            <label>รหัสผ่าน (Password) <?php
                                $data = array(
                                    'type'          => 'password',
                                    'id'            => 'password',
                                    'name'          => 'password',
                                    'placeholder'   => 'รหัสผ่าน (Password)...',
                                    'required'      => 'required',
                                    'title'         => 'รหัสผ่าน (Password)',
                                );
                                echo form_input($data); ?>
                            </label>
                            <label>ยืนยันรหัสผ่าน (Password Confirm) <?php
                                $data = array(
                                    'type'          => 'password',
                                    'id'            => 'passconf',
                                    'name'          => 'passconf',
                                    'placeholder'   => 'ยืนยันรหัสผ่าน (Password confirm)...',
                                    'required'      => 'required',
                                    'title'         => 'ยืนยันรหัสผ่าน (Password confirm)',
                                );
                                echo form_input($data); ?>
                            </label>
                            <label> <?php
                                if (validation_errors()) { ?>
                                    <font color="red"> <?php
                                        echo form_error('fullname');
                                        echo form_error('email');
                                        echo form_error('username');
                                        echo form_error('password');
                                        echo form_error('passconf'); ?>
                                    </font> <?php
                                } ?>
                            </label>
                            <div class="field-submit">
                                <a href="#" role="button" class="btn-login" id="btn-register"><?php echo $title; ?></a>
                                <!-- <a href="<?php echo base_url('member/login'); ?>" role="button" class="btn-signup">เข้าสู่ระบบ</a> -->
                                <a href="#" role="button" class="btn-signup" data-toggle="reveal-login">เข้าสู่ระบบ</a>
                            </div>
                        </div>
                    </div> <?php
                echo form_hidden('registered', 'registered');
                echo form_close();
            ?>

        </div>
        <hr>
        <div class="footer-copyright-2">
            <h5>ต้องการความช่วยเหลือ? แผนกบริการลูกค้า โทร 02-018-0000</h5>
        </div>
    </section>  
</main>
<script type="text/javascript">
    $(document).ready(function() {
        $('#fullname').focus();
        $('#btn-register').click(function() {
            $('#form-register').submit();
        });
        $('#form-register').find('input').each(function(index) {
            $(this).keypress(function(e) {
                if (e.which == 13)
                    $('#form-register').submit();
            });
        });
    });
</script>