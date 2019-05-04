<div class="row">
    <div class="content__title content__title--last" style="cursor: pointer" onclick="window.location = '/'">
        <?= __('SẢN PHẨM NỔI BẬT') ?>
        <br>
        <span class="content__title--botton"></span>
    </div>
    <div class="ajax-loader-featured" style="display: none;"></div>
    <?php if(!empty($purchases)): ?>
    <?php $limit = 0; ?>
    <?php foreach($purchases as $purchase): ?>
    <?php if ($limit == 4) { break; } ?>
    <?php if ($purchase->product->position == 'HOME'): ?>
    <form action="/request?from={$purchase->from_location}&to={$purchase->to_location}" method="get">
        <input type="hidden" name="asin" value="">
        <input type="hidden" name="from_location_id" value="ChIJLxl_1w9OZzQRRFJmfNR1QvU">
        <input type="hidden" name="from_location" value="Japan">
        <input type="hidden" name="store" value="BigBalo">
        <input type="hidden" name="featured_id" value="109">
        <div class="col-md-3" style="height: 450px">
            <div class="product-item">
                <div class="product-item__top clearfix">
                    <!-- <div class="stars pull-left">
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star</span>
                        <span class="material-icons">star_border</span>
                    </div> -->
                    <div class="product-item__top--right pull-left" style="text-align: left">
                        <h5><?= __('Mua từ') ?> :</h5>
                        <p class="home-buy-btn"><?= __($purchase->order->from_location); ?></p>
                    </div>
                </div>
                <div class="product-item__content">
                    <a class="product-item__content--link" href="javascript:void(0)" onclick="homepage.mixpanel_from_homepage('109, BigBalo');"><img height="150" style="max-width: 220px" src="<?php echo $purchase->product->thumb; ?>"></a>
                    <h6 class="title-featured"><?php echo $purchase->product->name; ?></h6>
                    <p>Wowmua</p>
                    <a class="product-item__link" href="<?php echo $purchase->order->request_url; ?>" target="_blank"><?= __('Xem ngay') ?></a>
                </div>
                <div class="product-item__bottom clearfix">
                    <div class="margin-top-10 pull-left home-buy-btn"><?= __('Giá') ?></div>
                    <a class="pull-right" href="javascript:void(0)"><?php echo number_format($purchase->product->buy_price) ?> <sup>vnđ</sup></a>
                </div>
            </div>
        </div>
    </form>
    <?php $limit++; ?>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php else: ?>
    <h2>Chưa có sản phẩm nào</h2>
    <?php endif; ?>
</div>
<!-- <div class="view-more_featured view-more-buyer" style="display: block;"><a href="https://www.bigbalo.com/featured-product">View More</a></div> -->