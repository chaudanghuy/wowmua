<?php echo $this->Form->hidden('currency', ['id' => 'currency', 'value' => $currency]); ?>
<?php echo $this->Form->hidden('priceTxt', ['id' => 'priceTxt', 'value' => __('Giá sản phẩm')]); ?>
<?php echo $this->Form->hidden('localShipTxt', ['id' => 'localShipTxt', 'value' => __('Phí ship nội địa (nếu có)')]); ?>
<!-- header -->
<?=$this->element('WM_Balo/home_header'); ?>
<!-- banner -->
<div class="banner mobile-height-size">
    <img class="img-responsive" src="/tpl_v2/img/globe-map-suitcase-travel-1176x445.jpg" alt="">
</div>
<!-- /banner -->
<!-- content -->
<div class="content">
    <form class="container" id="finalize-form" enctype="multipart/form-data" action="/process" method="POST">
        <input type="hidden" name="buyer_name" value="">
        <input type="hidden" name="buyer_mail">
        <input type="hidden" name="buyer_address">
        <input type="hidden" name="buyer_phone">
        <input type="hidden" name="request_url">
        <!-- Other fields -->
        <input type="hidden" name="manual_local_ship">
        <input type="hidden" name="manual_weight">
        <input type="hidden" name="manual_properties">
        <input type="hidden" name="manual_qty">
        <input type="hidden" name="edit_price">
        <input type="hidden" name="edit_quantity">
        <input type="hidden" name="total_amount">
        <textarea style="display: none" name="product_description">...</textarea>
        <div class="form-filter form-request">
            <div class="clearfix" style="border-bottom: 1px solid #ccc; padding-bottom: 35px;">
                <div class="form-filter__group pull-left">
                    <label><?= __('Mua từ'); ?></label>
                    <?php echo $this->Form->input('edit-from-location', [
                        'label' => false,
                        'id' => 'edit-from-location',
                        'options' => ($lang_flag == 'us') ? $from_en_location : $from_location,
                        'default' => $from,
                        'onchange' => 'reloadForm()'
                    ]) ?>
                </div>
                <div class="form-filter__group pull-left">
                    <label><?= __('Chuyển về') ?></label>
                    <?php echo $this->Form->input('edit-to-location', [
                        'label' => false,
                        'id' => 'edit-to-location',
                        'options' => $to_location,
                        'default' => $to,
                        'onchange' => 'reloadForm()'
                    ]) ?>
                </div>
                <div class="form-filter__group pull-left date">
                    <label>
                        <?= __('Cần trước ngày') ?>:
                    </label>
                    <input class="input-datepicker" type="text" id="edit-needed-by" name="needed_by" value="<?=$date; ?>" autocomplete="edit-needed-by">
                    <div class="input-group-addon"></div>
                </div>
            </div>
        </div>
        <div class="request-product-content--first nav-tabs-vertical row">
            <div class="col-md-12">
                <div class="sort-by clearfix">
                    <div class="pull-left sort-by__left">
                        <span><?= __('Điền') ?> <span><?= __('thông tin') ?></span> <?= __('cho đơn hàng của bạn') ?> :
                    </span>
                </div>
                <div class="pull-right sort-by__right">
                    <a href="#" title="">
                        <i></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="request-content clearfix">
        <div class="request-tabs request-product-content pull-left">
            <div class="request-product-content__inner">
                <div class="request-product-content__form" data-step="1" data-intro="More features, more fun." data-position="right">
                    <div class="request-product-content__title">
                        <?= __('Tải hình sản phẩm bạn muốn mua') ?>
                    </div>
                    <ul id="results" class="request-product-content__upload--list list-unstyled clearfix">
                        <li>
                            <a class="product-scroll__link img-upload__link" href="javascript:void(0)" onclick="$('#my_file').click();">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                <?= __('Bấm vào đây để tải hình') ?>
                            </a>
                        </li>
                    </ul>
                    <div class="request-product-content__upload--form">
                        <div class="row">
                            <div class="pull-left manual-content">
                                <input type="text" name="manual_title" id="manual-title" placeholder="<?= __('Tên sản phẩm') ?>" value="" required onchange="loadDataManual()">
                            </div>
                            <div class="pull-right manual-content">
                                <input type="text" name="manual_price" placeholder="<?= __('Giá sản phẩm') ?>" id="manual-price" value="" required onchange="loadDataManual()">
                            </div>
                        </div>
                        <div class="row">
                            <div class="pull-left manual-content">
                                <input type="text" name="manual_link" placeholder="<?= __('Link sản phẩm (nếu có)') ?>" id="manual-link" value="" onchange="loadDataManual()">
                            </div>
                            <div class="pull-right manual-content">
                                <input type="text" name="manual_weight" placeholder="<?= __('Khối lượng 1 sản phẩm') ?> (kg)" id="manual-weight" value="" required onchange="loadDataManual()">
                            </div>
                        </div>
                        <div class="row">
                            <div class="pull-left manual-content">
                                <input type="text" name="manual_local_ship" id="manual-local-ship" placeholder="<?= __('Phí ship nội địa (nếu có)') ?>" value="" required onchange="loadDataManual()">
                            </div>
                            <div class="pull-right manual-content">
                                <input type="text" name="manual_qty" placeholder="<?= __('Số lượng') ?>" id="manual-qty" value="" required onchange="loadDataManual()">
                            </div>
                        </div>
                        <div class="row">
                            <input type="text" name="manual_properties" id="manual-properties" placeholder="<?= __('Ghi chú khác (màu sắc, kích thước, dung tích)') ?>" value="" required onchange="loadDataManual()">
                        </div>
                    </div>
                </div>
                <div class="request-product-content__scroll" data-step="2" data-intro="Ok, wasn't that fun?" data-position="right">
                    <div class="request-product-content__title">
                        <?= __('Thông tin giao hàng') ?>
                    </div>
                    <div class="request-product-content__upload--form">
                        <div class="row">
                            <div class="pull-left manual-content">
                                <input type="text" id="buyer_name" placeholder="<?= __('Tên người nhận') ?>" value="" required onchange="loadDataManual()">
                            </div>
                        </div>
                        <div class="row">
                            <div class="manual-content">
                                <input type="email" id="buyer_mail" placeholder="<?= __('Email') ?>"  value="" required onchange="loadDataManual()">
                            </div>
                        </div>
                        <div class="row">
                            <div class="manual-content">
                                <input type="address" id="buyer_address" placeholder="<?= __('Địa chỉ') ?>" value="" required onchange="loadDataManual()">
                            </div>
                        </div>
                        <div class="row">
                            <div class="manual-content">
                                <input type="number" id="buyer_phone" placeholder="<?= __('SĐT') ?>" value="" required onchange="loadDataManual()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="finalize-product request-product pull-right">
            <!-- Form -->
            <input type="file" name="my_file" id="my_file" style="display: none;" />
            <input type="hidden" name="from" value="<?=$from; ?>">
            <input type="hidden" name="to" value="<?=$to; ?>">
            <input type="hidden" name="needed_date" value="<?=$date; ?>">
            <input type="hidden" name="subject" id="product-subject">
            <!-- Form -->
            <div class="finalize-product__inner">
                <div class="finalize-product__header clearfix">
                    <div class="inline-block finalize-product-title">
                        <?= __('Tóm tắt') ?>:
                        <br><span id="product-title"></span>
                        <input type="hidden" name="product_title" value="">
                    </div>
                    <div class="img-avatar pull-right">
                        <img src="/tpl_v2/img/avatar-default.png" alt="">
                    </div>
                </div>
                <div class="finalize-product__img">
                    <img style="max-height: 300px" id="product-image" src="https://via.placeholder.com/500x333?text=PRODUCT+IMAGE">
                </div>
                <ul class="list-unstyled list-support clearfix rlt" style="width: 80%; margin: 0 auto;">
                    <!-- <li>
                        <a href="javascript:void(0)" data-toggle="modal" type="button" data-target="#mybalo-popup-code--slide-show" title=""><img src="/tpl_v2/img/icon-bottom-1.png" alt=""></a>
                    </li>
                    <li class="abs">
                        <img src="/tpl_v2/img/icon-bottom-2.png" alt="">
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-toggle="modal" type="button" data-target="#mybalo-popup-code--description" title="">More</a>
                    </li> -->
                </ul>
                <ul class="finalize-product__list list-unstyled">
                    <li class="finalize-product__list__item">
                        <div class="finalize-product__list__title clearfix">
                            <img src="/tpl_v2/img/icon-list-finalize-product-1.png" alt="">
                            <div style="display: inline"><?= __('Chuyển về') ?></div>
                            <span class="pull-right ui-autocomplete-input" id="to-location" autocomplete="off"><?=$to; ?></span>
                        </div>
                    </li>
                    <li class="finalize-product__list__item">
                        <div class="finalize-product__list__title clearfix">
                            <img src="/tpl_v2/img/icon-list-finalize-product-2.png" alt="">
                            <div style="display: inline"><?= __('Mua từ') ?></div>
                            <span class="pull-right ui-autocomplete-input" id="from-location" autocomplete="off"><?=$from; ?></span>
                        </div>
                    </li>
                    <li class="finalize-product__list__item">
                        <div class="finalize-product__list__title clearfix">
                            <img src="/tpl_v2/img/icon-list-finalize-product-3.png" alt=""> <?= __('Cần trước ngày') ?>
                            <span class="pull-right" id="needed-by"><?=$date; ?></span>
                        </div>
                    </li>
                    <li class="finalize-product__list__item" style="margin-bottom: 0px;">
                        <div class="finalize-product__list__title clearfix">
                            <?= __('Giá') ?> (VND)
                            <p class="text-muted" style="margin: 10px auto;"><i><?= __('Trong đó') ?></i></p>
                            <span class="text-muted pull-right" id="amount-span"></span>
                        </div>
                        <ul class="finalize-product__list__sup list-unstyled">
                            <li>
                                <?= __('Giá sản phẩm') ?> <span class="edit-quantity"></span>:
                                <span class="pull-right" id="edit-price"></span>
                            </li>
                            <li>
                                <span class="pull-right" id="edit-ship-traveler">1</span> <?= __('Phí ship traveler') ?> <span class="edit-quantity"></span>:
                            </li>
                            <li>
                                <span class="pull-right" id="edit-service-fee"></span><?= __('Phí dịch vụ') ?> <span class="edit-quantity"></span>:
                            </li>
                            <li>
                                <span class="pull-right" id="edit-ship"></span><?= __('Phí ship') ?>:
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="request-item__button">
                    <a class="request-item__link" href="javascript:void(0)" type="button" onclick="requestProduct()">
                        <?= __('Đặt hàng') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
<!-- /content -->
<!--Footer-->
<!-- footer -->
<?=$this->element('WM_Balo/home_footer'); ?>
<!-- /footer -->
<!--/Footer