<main>
    <?php $this->template->load('header/breadcrumb'); ?>

    <section>
        <div class="row">
            <div class="columns">
                <h2>Checkout</h2>
            </div>
        </div>
        <div class="row">
            <div class="small-12 medium-8 columns">
                <div class="">
                    <h4>เลือกการจัดส่ง</h4>
                    <form>
                        <div class="row">
                            <div class="small-4 columns">
                                <div class="checkout-img-delivery">
                                    <img class="thumbnail" src="<?php echo base_url('assets/images/checkout/th-post.png'); ?>" alt="Thailand Post">
                                </div>
                                <div class="text-center">
                                    <!-- <h4>+ 150 บาท</h4> -->
                                    <h4>จัดส่งในวันถัดไป</h4>
                                </div>
                            </div>
                            <div class="small-4 columns">
                                <div class="checkout-img-delivery">
                                    <img class="thumbnail active" src="<?php echo base_url('assets/images/checkout/fed-ex.png'); ?>" alt="FedEx">
                                </div>
                                <div class="text-center">
                                    <!-- <h4>+ 150 บาท</h4> -->
                                    <h4>จัดส่งในวันถัดไป</h4>
                                </div>
                            </div>
                            <div class="small-4 columns">
                                <div class="checkout-img-delivery">
                                    <img class="thumbnail" src="<?php echo base_url('assets/images/checkout/nim.png'); ?>" alt="NiMExpress">
                                </div>
                                <div class="text-center">
                                    <!-- <h4>+ 150 บาท</h4> -->
                                    <h4>จัดส่งในวันถัดไป</h4>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="small-12 medium-3 large-offset-9 columns">
                                <a href="<?php echo base_url('cart/review'); ?>" class="button btn-checkout">ดำเนินการต่อไป</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary -->
            <?php $this->load->view('front-end/summary'); ?>
        </div>
    </section>
</main>
<script type="text/javascript">
    $('.checkout-img-delivery').click(function() {
        $('.checkout-img-delivery').find('img').removeClass('active');
        if ($(this).find('img').prop('class') == 'thumbnail active')
            $(this).find('img').removeClass('active');
        else if ($(this).find('img').prop('class') == 'thumbnail')
            $(this).find('img').addClass('active');
    });
</script>