<!-- header -->
<?=$this->element('WM_Balo/home_header'); ?>
<!-- /header -->
<!-- banner -->
<div class="banner banner-pending">
  <h5><?= __('ĐẶT HÀNG THÀNH CÔNG') ?></h5>
  <img class="img-responsive" src="/tpl_v2/img/img-banner-finalize.jpg" alt="">
</div>
<!-- /banner -->
<!-- content -->
<div class="content">
  <div class="container">
    <div class="bidpending-content">
      <div class="bidpending-content__inner">
        <!-- <img class="bidpending-content__img" src="/tpl_v2/img/img-bidpending.png" alt=""> -->
        <div class="bidpending-content__title">
          <span class="pull-left" style="margin-left: 50px">
            <?= __('Mã đơn hàng của bạn') ?>: <code><?php echo $order->order_code ?></code>
          </span>
          <div class="clearfix" style="margin-top: 10px"></div>
          <div class="clearfix" style="margin-top: 10px"></div>
          <?php $total = 0; ?>
          <?php foreach($order->purchases as $purchase): ?>
          <?php $product = $this->Common->getProductInfoByProductId($purchase->product_id); ?>
          <?php if (!empty($product['calc_price'])) $total += $product['calc_price']; ?>
          <?php endforeach; ?>
          <span class="pull-left" style="margin-left: 50px">
            <?= __('Để thanh toán, bạn vui lòng chuyển khoản {0} VND cho WowMua trước 17:00 ngày {1} theo thông tin', [number_format($total), date("d/m/Y", strtotime("+1 day"))]) ?>
          </span>
          <div class="jumbotron pull-left"  style="margin-left: 50px; margin-top: 20px; margin-bottom: 15px; padding-left: 0px; padding-bottom: 5px">
            <p class="text-center">Techcombank chi nhánh thành phố Hồ Chí Minh</p>
            <div class="row">
              <span class="col-xs-5">
                <div class="pull-left">
                  <?= __('Chủ tài khoản') ?>
                </div>
              </span>
              <span class="col-xs-7">
                <div class="pull-left">
                  Nguyen Thi Nhu Ngoc
                </div>
              </span>
            </div>
            <div class="row">
              <span class="col-xs-5">
                <div class="pull-left">
                  <?= __('Số tài khoản') ?>
                </div>
              </span>
              <span class="col-xs-7">
                <div class="pull-left">
                  19031354371018
                </div>
              </span>
            </div>
            <div class="row">
              <span class="col-xs-5">
              	<div class="pull-left">
              		<?= __('Nội dung chuyển khoản') ?>
              	</div>
              </span>
              <span class="col-xs-7">
                <div class="pull-left">
                <?php echo $order->order_code ?>
              </div>
              </span>
            </div>
            <div class="clearfix"></div>
          </div>
          <span class="pull-left" style="margin-left: 50px; text-align: left;">
            <?= __('WowMua sẽ xác nhận và chuyển đơn hàng đến traveler ngay sau khi nhận được thanh toán của bạn. Thời gian giao hàng dự kiến trong vòng 14 ngày làm việc không kể thứ 7 và chủ nhật') ?>
          </span>
          <div class="clearfix" style="margin-top: 10px"></div>
          <div class="clearfix" style="margin-top: 10px"></div>
          <span class="pull-left" style="margin-left: 50px;  text-align: left;">
            <?= __('Thông tin chi tiết đơn hàng sẽ được gửi đến địa chỉ email {0}. Nếu không tìm thấy vui lòng kiểm tra hộp thư Spam và Junk Folder', [$order->user->email]) ?>
          </span>
        </div>
        <!-- <a class="bidpending-content__link" href="/" title="" style="margin-top: 20px">Tiếp tục đặt hàng</a> -->
      </div>
    </div>
  </div>
</div>
<!--Footer-->
<!-- footer -->
<?=$this->element('WM_Balo/home_footer'); ?>
<!-- /footer -->