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
                    'id'    => 'form-forgot', 
                );
                echo form_open('member/forgotpassword', $attributes); ?> 
                    <h2><?php echo $title; ?></h2>
                    <div class="row">
                        <div class="small-12 columns"> 
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
                            <label> <?php
                                if (validation_errors()) { ?>
                                    <font color="red"> <?php
                                        echo form_error('username'); 
                                        echo form_error('email'); ?>
                                    </font> <?php
                                } ?>
                            </label>
                            <div class="field-submit">
                                <a href="#" role="button" class="btn-login" id="btn-forgot">ยืนยัน</a>
                                <!-- <a href="<?php echo base_url('member/login'); ?>" role="button" class="btn-signup">เข้าสู่ระบบ</a> -->
                                <a href="#" role="button" class="btn-signup" data-toggle="reveal-login">เข้าสู่ระบบ</a>
                            </div>
                        </div>
                    </div> <?php
                echo form_hidden('forgotten', 'forgotten');
                echo form_close();
            ?>

        </div>
        <hr>
        <div class="footer-copyright-2">
            <h5>ต้องการความช่วยเหลือ? แผนกบริการลูกค้า โทร (029) 776-3224 หรือ (053) 433-224</h5>
        </div>
    </section>  
</main>
<script type="text/javascript">
    $(document).ready(function() {
        $('#username').focus();
        $('#btn-forgot').click(function() {
            $('#form-forgot').submit();
        });
        $('#form-forgot').find('input').each(function(index) {
            $(this).keypress(function(e) {
                if (e.which == 13)
                    $('#form-forgot').submit();
            });
        });
    });
</script>