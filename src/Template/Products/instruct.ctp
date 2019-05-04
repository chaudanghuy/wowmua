<!-- header -->
<?=$this->element('WM_Balo/home_header'); ?>
<!-- /header -->
<!-- banner -->
<div class="banner banner-profile rlt">
  <h5><?= __('HƯỚNG DẪN MUA HÀNG') ?></h5>
  <img class="img-responsive" src="/tpl_v2/img/img-bg-banner-profile.jpg" alt="">
</div>
<!-- /banner -->
<!-- content -->
<div class="content">
  <div class="container">
    <div class="term-privacy-content clearfix">
      <div class="nav-tabs-horizontal nav-tabs-inverse nav-tabs-animate">
        <ul class="header-banner-resource__menu term-privacy-menu nav nav-tabs" data-plugin="nav-tabs" role="tablist">
          <li class="active" role="presentation">
            <a data-toggle="tab" href="#term-privacy__tab1" aria-controls="term-privacy__tab1" role="tab" aria-expanded="true">
              <?= __('Hướng dẫn mua hàng') ?>
            </a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active animation-slide-left getting-started__tabs" id="term-privacy__tab1" role="tabpanel">
            <div class="term-privacy__tab--content">
              <div class="term-privacy__tab--item">
                <div class="term-privacy__tab--text">
                  <?= __('Bạn muốn đặt hàng từ Hàn Quốc, Nhật Bản và Úc về đến Việt Nam một cách nhanh chóng, thuận tiện với hóa đơn đầy đủ từ đội ngũ traveler quốc tế của WowMua? Chỉ cần vài nhấp chuột và bạn đã có thể yên tâm “nằm nhà, shopping thế giới” rồi nhé. Hãy cùng xem những hướng dẫn bên dưới để đặt hàng cùng WowMua!!!'); ?>
                </div>
              </div>
              <div class="term-privacy__tab--title">
                1. <?= __('Lựa chọn hành trình mà bạn muốn order hàng') ?>
              </div>
              <div class="term-privacy__tab--item">
                <div class="term-privacy__tab--text">
                  <?= __('Sau khi truy cập vào wowmua.com, bạn hoàn toàn yên tâm bởi trang web hiển thị toàn bộ bằng tiếng Việt rất dễ dàng cho việc sử dụng. Tiếp đến, bạn lựa chọn quốc gia (Hàn Quốc / Nhật Bản / Úc) mà mình muốn đặt hàng ở ô “Mua từ” cũng như tỉnh, thành phố mà bạn sinh sống ở ô “Chuyển về” để WowMua có thể gửi hàng đến tận nhà cho bạn. Sau đó nhấp vào ô “Tìm kiếm”.') ?>
                </div>
                <div class="term-privacy__tab--text">
                  <img class="img-responsive" src="/image/<?=($img_prefix) ?>1.png">
                </div>
              </div>
              <div class="term-privacy__tab--title">
                2. <?= __('Đặt hàng') ?>
              </div>
              <div class="term-privacy__tab--item">
                <div class="term-privacy__tab--text">
                  <?= __('Giờ thì bạn đang nhìn thấy trang giao diện đặt hàng của WowMua. Bạn có thể yêu cầu thời gian giao hàng tối đa mình có thể chờ để giao hàng bằng cách chọn thời gian ở ô “cần trước ngày”. WowMua luôn có nhiều traveler vận chuyển thường xuyên để giao hàng nhanh cho bạn. Tuy nhiên đối với nhiều đơn hàng mua qua web thì sẽ tốn nhiều thời gian hơn để traveler chờ người bán giao hàng ở địa chỉ nước ngoài. Nếu thời gian bạn yêu cầu khó đáp ứng, WowMua sẽ thông báo để bạn được biết.') ?>
                </div>
                <div class="term-privacy__tab--text">
                  <img class="img-responsive" src="/image/<?=$img_prefix ?>2.png">
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('Tiếp đến, bạn sẽ thấy phần “Điền THÔNG TIN cho đơn hàng của bạn như sau') ?>
                </div>
                <div class="term-privacy__tab--text">
                  <img class="img-responsive" src="/image/<?=$img_prefix ?>3.png">
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('Bạn cần hoàn tất các bước trong phần 1 như:'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('- Tải hình ảnh sản phẩm bạn muốn mua'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('- Điền tên sản phẩm'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('- Điền khối lượng sản phẩm. Trong trường hợp bạn không thấy khối lượng sản phẩm trên web thì có thể điền dung tích sản phẩm. Đội ngũ WowMua sẽ liên hệ bạn nếu cần sự điều chỉnh'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('Điền giá sản phẩm (theo đơn vị tiền tệ của quốc gia bạn muốn mua). Ví dụ: sản phẩm có giá 4,120 thì bạn điền 4120; sản phẩm có giá 15.99 (dưới 16) thì bạn điền 15.99. Bạn vui lòng không điền dấu chấm hoặc phẩy nếu không cần thiết để tránh bị sai giá.'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('- Điền số lượng sản phẩm bạn muốn mua'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('- Nếu bạn mua hàng qua website và cần phải trả phí ship nội địa ở nước sở tại thì bạn điền thông tin về link sản phẩm và phí ship nội địa (nếu có). Trong trường hợp bạn mua hàng tại cửa hàng mà có website, việc bạn điền link sản phẩm sẽ giúp traveler tìm kiếm và mua sản phẩm cho bạn chuẩn xác hơn. '); ?>
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('- Điền ghi chú khác (màu sắc, kích thước, dung tích). Đối với những bạn order quần áo và giày dép vui lòng điền màu sắc, size giày / áo / quần, chiều cao của giày là bao nhiêu cm (nếu có), đối với các loại hóa mỹ phẩm thì bạn có thể điền mua loại bao nhiêu l / ml. Càng chi tiết bao nhiêu thì traveler mua hàng cho bạn chính xác bấy nhiêu.') ?>
                </div>
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('Sau khi bạn điền xong phần 1, phần “Tóm tắt” sẽ tự động hiển thị tổng quát lại các thông tin bạn đã điền vào trước đó. Ở đây, bạn cũng thấy được tổng giá sau ship về Việt Nam là bao nhiêu với chi tiết các phí mà bạn phải trả (giá sản phẩm, phí ship của traveler, phí dịch vụ) như hình bên dưới.') ?>
                </div>
                <div class="term-privacy__tab--text">
                  <img class="img-responsive" src="/image/<?=$img_prefix ?>4.png">
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('Bạn không cần phải là một thành viên mới đặt hàng được trên WowMua, chính vì vậy bạn có thể điền thông tin ở phần số 2 về “Thông tin giao hàng” bao gồm:') ?>
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('- Điền tên người nhận hàng'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('- Điền email liên hệ để WowMua gửi mail xác nhận đơn hàng'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('- Điền địa chỉ nhận hàng'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('- Điền số điện thoại để giao hàng') ?>
                </div>
                </div>
                <div class="term-privacy__tab--text">
                  <?= __('Sau đó nhấp vào ô “Đặt hàng”.') ?>
                </div>
                <div class="term-privacy__tab--text">
                  <img class="img-responsive" src="/image/<?=$img_prefix ?>5.png">
                </div>
              </div>
              <div class="term-privacy__tab--title">
                3. <?= __('Hoàn tất đặt hàng'); ?>
              </div>
              <div class="term-privacy__tab--item">
                <div class="term-privacy__tab--text">
                  <?= __('Khi đã hoàn tất được thủ tục mua hàng, bạn sẽ thấy được hiển thị “ĐẶT HÀNG THÀNH CÔNG” cùng với những thông tin về:'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  - <?= __('Mã đơn hàng của bạn'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  - <?= __('Tổng số tiền bạn cần thanh toán. Hiện tại WowMua chỉ chấp nhận hình thức thanh toán chuyển khoản qua ngân hàng'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  - <?= __('Thời hạn thanh toán'); ?>.
                </div>
                <div class="term-privacy__tab--text">
                  - <?= __('Địa chỉ thanh toán'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  - <?= __('Đia chỉ email WowMua xác nhận đơn hàng và thông báo trạng thái đơn hàng qua email cho bạn.'); ?>
                </div>
                <div class="term-privacy__tab--text">
                  <img class="img-responsive" src="/image/<?=$img_prefix ?>6.png">
                </div>
              </div>
              <div class="term-privacy__tab--title">
                4. <?= __('Nhận hàng') ?>
              </div>
              <div class="term-privacy__tab--item">
                <div class="term-privacy__tab--text">
                  <?= __('Khi đã hoàn tất được thủ tục mua hàng và thanh toán, bạn chỉ cần ung dung ngồi nhà và chờ WowMua gửi hàng đến tận nơi cho bạn. Hóa đơn gốc mua ở nước ngoài sẽ được gửi đến bạn qua email. Quá thuận tiện phải không nào? Đặt hàng NGAY cùng WowMua!') ?>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Footer-->
<!-- footer -->
<?=$this->element('WM_Balo/home_footer'); ?>
<!-- /footer