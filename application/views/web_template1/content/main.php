<main>
    <section>
        <ul class="bxslider"> <?php
            // $image_slider = $this->common_model->getTableOrder('image_slider', 'IS_Order', 'ASC');
            $image_slider = $this->common_model->get_where_custom_order('image_slider', 'IS_Allow', '1', 'IS_Order', 'ASC');
            if (count($image_slider) > 0) {
                foreach ($image_slider as $key => $value) { ?>
                    <li><a href="#"><img src="<?php echo base_url('assets/images/slide/'.$value['IS_Img']); ?>"></a></li>
                    <?php
                }
            }
            else { ?>
                <li><a href="#"><img src="<?php echo base_url('assets/images/slide/slide-1.jpg'); ?>"></a></li>
                <?php
            } ?>
            <!-- <li><a href="#"><img src="<?php echo base_url('assets/images/slide/slide-2.jpg'); ?>" height="450"></a></li>
            <li><a href="#"><img src="<?php echo base_url('assets/images/slide/slide-3.jpg'); ?>"></a></li>
            <li><a href="#"><img src="<?php echo base_url('assets/images/slide/slide-1.jpg'); ?>"></a></li> -->
        </ul>
    </section>

    <section class="wrap-vision">
        <div class="row row-vision">
               <div class="small-12 medium-5 columns">
                   <div class="animation-element slide-left">
                       <img class="image-center vision-image" src="<?php echo base_url('assets/images/vision/img-vision.png'); ?>">
                   </div>
               </div>
               <div class="small-12 medium-7 columns">
                   <div class="animation-element slide-right">
                       <div class="vision-text _dotranslate">
                            <h2>ทำไมต้องเป็น <span class="green">Lucky door</span></h2>
                            <p>ถ้าจะพูดถึงประตูในอดีตพวกเราจะคิดถึงประตูทำจากไม้มีฝัก 4, ฝัก 5, ฝัก 8 หรือบานไม้สักแกะลายเป็นต้นแต่ในปัจจุบัน มีการณรงค์ให้ดูแลสิ่งแวดล้อมกันมากขึ้น จึงทำให้โลกเรามีการพัฒนาวัสดุที่ทดแทนไม้ขึ้นมาแต่ยังให้ความรู้สึกเหมือนไม้แถมยังปรับปรุงจุดอ่อนต่างๆของไม้ได้อักด้วย ด้วยเหตุนี้ “<bold>Lucky door</bold>” จึงนำวัสดุเหล่านี้มาผสมผสานกับไม้ และพัฒนาออกมาในรูปแบบของประตูแบบต่างๆ ที่สามารถใช้ได้ทั้งภายนอกและภายใน เพื่อตอบสนองความต้องการทั้งรูปแบบและสีสันที่สวยงาม ทั้งยังคงให้ความรู้สึกที่ยังคงเป็นธรรมชาติและอนุรักษ์สิ่งแวดล้อมให้กับโลกต่อไป</p>
                        </div>
                        <div class="vision-text _notranslate notranslate">
                            <h2>Why <span class="green">Lucky door?</span></h2>
                            <p>In the past, when the term “door” was mentioned, people would think about wooden doors with 4, 5, 8 panels or carved teak wood doors. However, to answer the calls from various environmental care campaigns nowadays, we develop wood replacement materials. The materials give the exact feel of wood, but provide no flaws the wood posses. Lucky door uses these materials to mix up with the wood and produces doors that can be used for both interior and exterior area. The doors perfectly fit the requirements in terms of the beautiful pattern and color, while they also provide the natural feel. They’re also environmentally friendly and good for the earth.</p>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <section>
        <div class="collection-wrapper-head">
            <div class="title-home">
                <h1 class="text-title-home">New Collecttion</h1>
                <hr class="hr-title-1 hr-width-1">
                <h4><blockquote><cite><span>Know more about our latest collection.</span></cite></blockquote></h4>
            </div>
        </div>
        <div class="row row-feature"> <?php
            foreach ($feature_items as $key => $value) {
                $feature_stocks = rowArray($this->common_model->custom_query(
                    "   SELECT * FROM `product_stock`
                        WHERE `P_ID` = '{$value['P_ID']}'
                        AND `PS_Allow` = '1'
                        ORDER BY `PS_ID` DESC LIMIT 1   "
                ));
                $feature_promotions = rowArray($this->common_model->custom_query(
                    "   SELECT * FROM `product_price`
                        WHERE `P_ID` = '{$value['P_ID']}'
                        AND `PP_Special` = '1'
                        AND `PP_Allow` = '1'
                        ORDER BY `PP_ID` DESC LIMIT 1   "
                )); ?>
                <div class="small-12 medium-6 large-3 columns">
                    <div class="product">
                        <div class="product-img"> <?php
                            if ($value['P_Img'] !== '') { ?>
                                <img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$value['P_Img']); ?>" alt="<?php echo $value['P_Name']; ?>"> <?php
                            }
                            else { ?>
                                <img src="<?php echo base_url('assets/images/noimage.gif'); ?>" alt="<?php echo $value['P_Name']; ?>"> <?php
                            } ?>
                        </div>
                        <h3 class="product-title"><?php echo $value['P_IDCode']; ?></h3>
                        <p> <?php
                                 if ($value['P_Title']   !== '') mb_substr(strip_tags($value['P_Title']), 0, 37,'UTF-8').'...';
                            else if ($value['P_Detail']  !== '') mb_substr(strip_tags($value['P_Detail']), 0, 37,'UTF-8').'...'; ?>
                        </p>
                        <h3 class="home-product-price"> <?php
                                 if (count($feature_promotions) > 0) echo '฿'.number_format($feature_promotions['PP_Price'],    2, '.', ',');
                            else if (count($feature_stocks)     > 0) echo '฿'.number_format($feature_stocks['PS_Price'],        2, '.', ','); ?>
                        </h3>
                        <!-- <div class="wrap-price-sale">
                            <h5>
                                <span class="price-sale"><?php if (count($feature_promotions) > 0 && count($feature_stocks) > 0) echo '฿'.number_format($feature_stocks['PS_Price'], 2, '.', ','); ?></span><?php
                                if (count($feature_promotions) > 0 && count($feature_stocks) > 0) { ?>
                                    <span class="price-per-sale"><?php echo number_format(((1 - ($feature_promotions['PP_Price'] / $feature_stocks['PS_Price'])) * 100), 0, '.', ',').'%'; ?></span> <?php
                                } ?>
                            </h5>
                        </div> -->
                        <div class="field-btn"> <?php
                            $product = rowArray($this->common_model->get_where_custom('product', 'P_ID', $value['P_ID']));
                            if (count($product) > 0) {
                                $colors = explode(",", $product['P_Color']); ?>
                                <select class="color-picker">
                                    <option value="0" disabled selected>Colors</option> <?php
                                    foreach ($colors as $key => $values) {
                                        $product_color = rowArray($this->common_model->get_where_custom('product_color', 'PC_ID', $values));
                                        if (count($product_color) > 0) { ?>
                                            <option value="<?php echo $product_color['PC_ID']; ?>"><?php echo $product_color['PC_Name']; ?></option> <?php
                                        }
                                    } ?>
                                </select>
                                <br><br> <?php
                            } ?>
                            <a href="<?php echo base_url('product/detail/'.$value['P_ID']); ?>" class="btn-view-detail"><i class="fa fa-search"></i> View Detail</a>
                            <a href="#" class="btn-buy-now" onclick="addToCart('<?php echo $value['P_ID']; ?>')"><i class="fa fa-cart-plus"></i> Buy Now</a>
                        </div>
                    </div>
                </div> <?php
            } ?>


            <!-- <div class="small-6 medium-3 columns">
                <div class="product">
                    <div class="product-img">
                        <img src="<?php echo base_url('assets/images/products/showcase/IMG_0354.png'); ?>" alt="IMG_0354">
                        <div class="product-hvr">
                            <a href="<?php echo base_url('product'); ?>" class="btn-buy-now"><i class="fa fa-search"></i> ดูเพิ่มเติม</a>
                        </div>
                    </div>
                    <h3 class="product-title">Modern Outdoor</h3>
                    <p>ประตูสไตล์ modern มีความแข็งแรง ทนทานสูง</p>
                    <h3 class="home-product-price">5,206 THB</h3>

                    <div class="wrap-price-sale">
                        <h5>
                            <span class="price-sale">5,206 THB</span>
                            <span class="price-per-sale">SALE 11%</span>
                        </h5>
                    </div>

                    <div class="field-btn">
                        <a href="#!" class="btn-view-detail"><i class="fa fa-search"></i> View Detail</a>
                        <a href="#!" class="btn-buy-now"><i class="fa fa-search"></i> Buy Now</a>
                    </div>

                </div>
            </div>
            <div class="small-6 medium-3 columns">
                <div class="product">
                    <div class="product-img">
                        <img src="<?php echo base_url('assets/images/products/showcase/IMG_0541.png'); ?>" alt="IMG_0354">
                        <div class="product-hvr">
                            <a href="<?php echo base_url('product'); ?>" class="btn-buy-now"><i class="fa fa-search"></i> ดูเพิ่มเติม</a>
                        </div>
                    </div>
                    <h3 class="product-title">Modern Outdoor</h3>
                    <p>ประตูสไตล์ modern มีความแข็งแรง ทนทานสูง</p>
                    <h3 class="home-product-price">5,206 THB</h3>

                    <div class="wrap-price-sale">
                        <h5>
                            <span class="price-sale">5,206 THB</span>
                            <span class="price-per-sale">SALE 11%</span>
                        </h5>
                    </div>

                    <div class="field-btn">
                        <a href="#!" class="btn-view-detail"><i class="fa fa-search"></i> View Detail</a>
                        <a href="#!" class="btn-buy-now"><i class="fa fa-search"></i> Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="small-6 medium-3 columns">
                <div class="product">
                    <div class="product-img">
                        <img src="<?php echo base_url('assets/images/products/showcase/IMG_0103.png'); ?>" alt="IMG_0354">
                        <div class="product-hvr">
                            <a href="<?php echo base_url('product'); ?>" class="btn-buy-now"><i class="fa fa-search"></i> ดูเพิ่มเติม</a>
                        </div>
                    </div>
                    <h3 class="product-title">Modern Outdoor</h3>
                    <p>ประตูสไตล์ modern มีความแข็งแรง ทนทานสูง</p>
                    <h3 class="home-product-price">5,206 THB</h3>

                    <div class="wrap-price-sale">
                        <h5>
                            <span class="price-sale">5,206 THB</span>
                            <span class="price-per-sale">SALE 11%</span>
                        </h5>
                    </div>

                    <div class="field-btn">
                        <a href="#!" class="btn-view-detail"><i class="fa fa-search"></i> View Detail</a>
                        <a href="#!" class="btn-buy-now"><i class="fa fa-search"></i> Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="small-6 medium-3 columns">
                <div class="product">
                    <a href="#!">
                        <div class="product-img">
                            <img src="<?php echo base_url('assets/images/products/showcase/IMG_0427.png'); ?>" alt="IMG_0354">
                            <div class="product-hvr">
                                <a href="<?php echo base_url('product'); ?>" class="btn-buy-now"><i class="fa fa-search"></i> ดูเพิ่มเติม</a>
                            </div>
                        </div>
                        <h3 class="product-title">Modern Outdoor</h3>
                        <p>ประตูสไตล์ modern มีความแข็งแรง ทนทานสูง</p>
                        <h3 class="home-product-price">5,206 THB</h3>

                        <div class="wrap-price-sale">
                            <h5>
                                <span class="price-sale">5,206 THB</span>
                                <span class="price-per-sale">SALE 11%</span>
                            </h5>
                        </div>

                        <div class="field-btn">
                            <a href="#!" class="btn-view-detail"><i class="fa fa-search"></i> View Detail</a>
                            <a href="#!" class="btn-buy-now"><i class="fa fa-search"></i> Buy Now</a>
                        </div>
                    </a>
                </div>
            </div> -->
        </div>
    </section>

    <section>
        <div class="row row-promotion">
            <div class="columns">
                <div class="wrapper-promotion">
                    <article class="text-promotion">
                        <h1 class="text-title-home">Hot Sale</h1>
                        <hr class="hr-title-2 hr-width-1">
                        <h2 class="sup-title-promotion">Now in Stores</h2>
                        <a href="<?php echo base_url('product/type/3'); ?>" class="btn-view-store">ดูเพิ่มเติม</a>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="collection-wrapper-head">
            <div class="title-home">
                <h1 class="text-title-home">Lucky Door Collection</h1>
                <hr class="hr-title-1 hr-width-2">
                <!-- <h4>KNOW MORE ABOUT OUR LATEST COLLECTION</h4> -->
                <h4><blockquote><cite><span>Know more about our latest collection.</span></cite></blockquote></h4>
            </div>
        </div>
        <div class="collection-wrapper-content">

            <!-- Collection 1 -->
            <div class="row row-collection">
                <div class="small-12 medium-expand columns">
                    <div class="collection-list">
                        <div class="collection-item-1">
                            <div class="collection-item-img">
                                <img src="<?php echo base_url('assets/images/products/showcase/CF-0002.7.png'); ?>" alt="CF-0002.7">
                            </div>
                            <div class="item-model"><small>( CF-0002.7 )</small></div>
                        </div>
                        <div class="collection-item-1">
                            <div class="collection-item-img">
                                <img src="<?php echo base_url('assets/images/products/showcase/CF-0008.9.png'); ?>" alt="CF-0008.9">
                            </div>
                            <div class="item-model"><small>( CF-0008.9 )</small></div>
                        </div>
                        <div class="collection-item-1">
                            <div class="collection-item-img">
                               <img src="<?php echo base_url('assets/images/products/showcase/CPB-0012.1.png'); ?>" alt="CPB-0012.1">
                            </div>
                            <div class="item-model"><small>( CFB-0012.1 )</small></div>
                        </div>
                    </div>
                </div>
                <div class="small-12 medium-expand columns">
                    <div class="collection-intro">
                        <div class="collection-title">
                            <h2 class="text-green">Modern <span class="sub-title-1">Outdoors</span></h2>
                            <div class="divider"></div>
                            <!-- <p>ถ้าจะพูดถึงประตูในอดีตพวกเราจะคิดถึงประตูทำจากไม้มีฝัก 4, ฝัก 5, ฝัก 8 หรือบานไม้สักแกะลายเป็นต้นแต่ในปัจจุบัน มีการณรงค์ให้ดูแลสิ่งแวดล้อมกันมากขึ้นมา แต่ยังให้ความรู้สึกเหมือนไม้แถมยังปรับปรุงจุดอ่อนต่างๆของไม้ได้อักด้วย ด้วยเหตุนี้ “<bold>Lucky door</bold>” จึงนำวัสดุเหล่านี้มาผสมผสานกับไม้ และพัฒนาออกมาในรูปแบบของประตูแบบต่างๆ ที่สามารถใช้ได้ทั้งภายนอกและภายใน เพื่อตอบสนองความต้องการทั้งรูปแบบและสีสันที่สวยงาม ทั้งยังคงให้ความรู้สึกที่ยังคงเป็นธรรมชาติและอนุรักษ์สิ่งแวดล้อมให้กับโลกต่อไป</p> -->
                            <div class="_dotranslate">
                               <p>เป็นประตูที่ใช้ในพื้นที่ที่มีความชื้นและมีโอกาศโดนฝนและโดนแดด</p>
                            </div>
                            <div class="_notranslate notranslate">
                                <p>The door is for external use. Primary moisture resistent for high numidity or sunlight area use.</p>
                            </div>
                            

                        </div>
                        <div class="collection-more">
                            <a href="<?php echo base_url('product/category/1'); ?>" class="btn-view-store">ดูเพิ่มเติม</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Collection 2 -->
            <div class="row row-collection">
                <div class="column order-1 medium-order-2 small-12 medium-expand">
                        <div class="collection-list">
                            <div class="collection-item-1">
                                <div class="collection-item-img">
                                    <img src="<?php echo base_url('assets/images/products/showcase/MDP-W-0003.3.png'); ?>" alt="MDP-W-0003.3">
                                </div>
                                <div class="item-model"><small>( MDP-W-0003.3 )</small></div>
                            </div>
                            <div class="collection-item-1">
                                <div class="collection-item-img">
                                    <img src="<?php echo base_url('assets/images/products/showcase/MDP-G-0011.3.png'); ?>" alt="MDP-G-0011.3">
                                </div>
                                <div class="item-model"><small>( MDP-B-0011.3 )</small></div>
                            </div>
                            <div class="collection-item-1">
                                <div class="collection-item-img">
                                    <img src="<?php echo base_url('assets/images/products/showcase/MDP-G-0003.4.png'); ?>" alt="MDP-G-0003.4">
                                </div>
                                <div class="item-model"><small>( MDP-G-0003.4 )</small></div>
                            </div>
                        </div>
                </div>
                <div class="column order-2 medium-order-1 small-12 medium-expand">
                    <div class="collection-intro collection-reverse">
                        <div class="collection-title">
                            <h2 class="notranslate text-green">Modern<span class="sub-title-1">Indoors</span></h2>
                            <div class="divider-reverse"></div>
                             <!--<p>ถ้าจะพูดถึงประตูในอดีตพวกเราจะคิดถึงประตูทำจากไม้มีฝัก 4, ฝัก 5, ฝัก 8 หรือบานไม้สักแกะลายเป็นต้นแต่ในปัจจุบัน มีการณรงค์ให้ดูแลสิ่งแวดล้อมกันมากขึ้นมา แต่ยังให้ความรู้สึกเหมือนไม้แถมยังปรับปรุงจุดอ่อนต่างๆของไม้ได้อักด้วย ด้วยเหตุนี้ “<bold>Lucky door</bold>” จึงนำวัสดุเหล่านี้มาผสมผสานกับไม้ และพัฒนาออกมาในรูปแบบของประตูแบบต่างๆ ที่สามารถใช้ได้ทั้งภายนอกและภายใน เพื่อตอบสนองความต้องการทั้งรูปแบบและสีสันที่สวยงาม ทั้งยังคงให้ความรู้สึกที่ยังคงเป็นธรรมชาติและอนุรักษ์สิ่งแวดล้อมให้กับโลกต่อไป</p> -->
                            <div class="_dotranslate">
                                <p>เป็นประตูที่ใช้สำหรับภายใน ทนความชื้นได้ในระดับหนึ่งไม่เหมาะกับสภาพที่ชื้นตลอดเวลาหรือมีแดด</p>
                            </div>
                            
                            <div class="_notranslate notranslate">
                                <p>The door is for internal use. Primary moisture resistent not for high numidity or sunlight area use.</p>
                            </div>
                        </div>
                        <div class="collection-more">
                            <a href="<?php echo base_url('product/category/2'); ?>" class="btn-view-store">ดูเพิ่มเติม</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Collection 3 -->
            <div class="row row-collection">
                <div class="small-12 medium-expand columns">
                    <div class="collection-list">
                        <div class="collection-item-2"><img src="<?php echo base_url('assets/images/products/stair/IMG_0054.jpg'); ?>" alt="Lucky Stair" width="450"></div>
                    </div>
                </div>
                <div class="small-12 medium-expand columns">
                    <div class="collection-intro">
                        <div class="collection-title">
                            <h2 class="text-green">Lucky<span class="sub-title-2"> Stairs</span></h2>
                            <div class="divider-2"></div>
                            <div class="_dotranslate">
                                <p>ในอดีตที่ผ่านมา ประเทศไทยได้ชื่อว่าเป็นประเทศที่ร่ำรวยไม้ก็ว่าได้ เราคุ้นเคยกับการใช้ทรัพยากรไม้ แบบฟุ่มเฟื่อยเพราะเราหามาง่าย แต่ในปัจจุบัน "ไม้" เป็นสิ่งที่มีค่าและหายาก ยิ่งถ้าเป็นไม้ที่มีราคาแพง เช่น ไม้สัก, ไม้มะค่า, ไม้พยุง, ไม้ชิงชัน เป็นต้น ด้วยเหตุผลเหล่านี้ <bold>"Lucky Stair"</bold> จึงได้สร้างผลิตภัณฑ์สำหรับทำบันได โดยผ่านขบวนการผลิตต่างๆ ให้ได้มาซึ่งความสวยงาม คงทน และได้อารมณ์ของคำว่าไม้ ในชั้นบันไดที่มีชื่อว่า <bold>"Lucky Stair"</bold> ไม่บิด ไม่งอ ทนต่อความชื้นและแมลงต่างๆ</p>
                                <br>
                                <img src="<?php echo base_url('assets/images/products/stair/sw-core.png'); ?>" alt="" width="200">
                                <br>
                                <div class="text-green ico-mid"><bold><i class="fa fa-caret-right"></i> Sandwich Core</bold></div>
                                <p>เป็นการนำไม้แผ่นบางๆหนาประมาณ 8 mm. มาเรียงซ้อนกันโดยใช้กาวชนิดพิเศษทนต่อความร้อนและความชื้นมาเป็นตัวยึดให้ไม้แต่ละชั้นติดอยู่ด้วยกันในการวางไม้แต่ละชิ้นจะถูกเรียงสลับขวางซ้อนกันเพื่อไม่ให้ไม้นั้นบิดงอได้ มีความแข็งแรง คงสภาพได้ยาวนาน</p>
                                <br>
                                <img src="<?php echo base_url('assets/images/products/stair/sw-core2.png'); ?>" alt="" width="200">
                                <br>
                                <div class="text-green ico-mid"><bold><i class="fa fa-caret-right"></i> Finger-Joint Core</bold></div>
                                <p>เป็นการนำไม้ที่มีความหนาขนาด 30 mm. มาต่อและเรียงเป็นแนวให้ได้ขนาดความกว้างที่ต้องการโดยใช้กาวเป็นตัวยึดด้านข้างระหว่างชิ้นต่อชิ้นละเสริมด้วยแกนกระดูกด้านหลังเพื่อป้องกันการบิดงอของชิ้นไม้</p>
                            </div>
                            <div class="_notranslate notranslate">
                                <p>In the past, Thailand is said to be rich in natural resources, especially trees. We were used to using up tree resources extravagantly due to the fact that trees were so easy to find. However, trees become scarce and valuable nowadays. Teakwood, black rose wood, Siamese rosewood and rosewood are expensive. This is the reason why “Lucky Stair” produces stair products. We use various manufacturing procedures to provide the beauty, durability and the sensation of wood. The “Lucky Stairs” are resistant against insects and moist. The products do not bend nor twist.</p>
                                <br>
                                <img src="<?php echo base_url('assets/images/products/stair/sw-core.png'); ?>" alt="" width="200">
                                <br>
                                <div class="text-green ico-mid"><bold><i class="fa fa-caret-right"></i> Sandwich Core</bold></div>
                                <p>Sandwich – Core is made with thin layers of wood. The 8 mm. thick wood layers are stacked, using the special glue that’s resistance to heat and moist. Each layer of wood is stacked in opposite direction, in order to prevent the wood from bending. The product is therefore durable and stable for a long period of time.</p>
                                <br>
                                <img src="<?php echo base_url('assets/images/products/stair/sw-core2.png'); ?>" alt="" width="200">
                                <br>
                                <div class="text-green ico-mid"><bold><i class="fa fa-caret-right"></i> Finger-Joint Core</bold></div>
                                <p>Finger –Joint core is made with 30 mm. wood. Pieces of wood are laid in lines to the desired width. Then, the glue is used to fix the pieces together one by one on the side. The product is supported by the wooden core at the back, in order to prevent from bending.</p>
                            </div>
                        </div>
                        <br><br>
                        <div class="collection-more">
                            <a href="<?php echo base_url('product/category/3'); ?>" class="btn-view-store">ดูเพิ่มเติม</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script type="text/javascript">
    var color_value = '';

    function addToCart(this_id) {
        window.location.href = "<?php echo base_url('cart/addToCart'); ?>/" + this_id + "/" + color_value;
    }

    $(document).ready(function() {
        $('.color-picker').change(function() {
            color_value = $(this).val();
        });
    });
</script>