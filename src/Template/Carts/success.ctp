<div class="container">
   <div class="row">
      <h1 class="text-center" style="color:#0fad00">ĐẶT HÀNG THÀNH CÔNG</h1>
      <div class="col-md-12">
         <h3>Xin chào, <?=$user['first_name'] . " " . $user['last_name'] ?></h3>
      </div>
      <div class="col-md-12">
         <h3>Thông tin đơn hàng của bạn:</h3>
         <div class="panel panel-default">
            <div class="panel-body">MÃ ĐƠN HÀNG: <strong style="color: red; font-size: 30px; margin-left: 55px;"><?=$orderCode ?></strong></div>
         </div>
      </div>
      <div class="col-md-12">
         <h3>Đơn hàng</h3>
         <div class="your_order">
            <table class="table table-bordered table-responsive">
               <tbody>
                  <?php $total = 0; ?>
                  <?php foreach($purchases as $purchase): ?>
                  <tr>
                     <td class="image"><?= $this->Html->image($purchase['product']['thumb'], ['alt' => $purchase['product']['name']]) ?></td>
                     <td class="name"><?= $this->Html->link($purchase['product']['name'], '/products/view/'.$purchase['product']['id']) ?></td>
                     <td><?=number_format(round($purchase['product']['sell_price'])) ?><sup>đ</sup></td>
                     <td class="quantity">
                        x<?= $purchase['quantity'] ?>
                     </td>
                     <td class="total"><?=number_format(round($purchase['price'])) ?><sup>đ</sup></td>
                  </tr>
                  <?php $total += round($purchase['price']); ?>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
      </div>
      <div class="col-md-12">
         <div class="col-sm-4 col-sm-offset-8">
            <div class="cart-totals">
               <table class="table">
                  <tr>
                     <th><span>Tổng đơn hàng</span></th>
                     <th><?php echo number_format($total) ?><sup>đ</sup></th>
                  </tr>
               </table>
            </div>
         </div>
      </div>
      <div class="col-md-12">
         <h2>Báo giá này sẽ hết hiệu lực sau 17:00 ngày <?=date("d-m-Y", strtotime("+1 day")); ?> . Để thanh toán, bạn vui lòng chuyển khoản 100% số tiền cho WowMua trước khi hết hiệu lực báo giá theo thông tin:</h2>
         <table class="table table-hover">
            <tbody>
               <tr>
                  <td><img src="/img/Techcombank_logo.png" class="img-thumbnail" height="50px" width="50px"> TECHCOMBANK - CHI NHÁNH TP HỒ CHÍ MINH</td>
               </tr>
               <tr>
                  <td>CHỦ TÀI KHOẢN : NGUYEN THI NHU NGOC</td>
               </tr>
               <tr>
                  <td>SỐ TÀI KHOẢN : 19031354371018</td>
               </tr>
               <tr>
                  <td>NỘI DUNG CHUYỂN KHOẢN: Họ tên-Mã đơn hàng</td>
               </tr>
            </tbody>
         </table>
      </div>
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-body">WowMua sẽ xác nhận và chuyển đơn hàng đến traveler ngay sau khi nhận được thanh toán của bạn. Thời gian hàng về đến Việt Nam là 14 ngày (hoặc có thể sớm hơn).</div>
         </div>
      </div>
      <div class="col-md-12">
         <div class="alert alert-danger">
            <strong>Lưu ý:</strong> Báo giá trên chưa bao gồm phí ship nội địa Việt Nam (20,000-60,000) từ các đối tác vận chuyển của WowMua. Quý khách vui lòng liên hệ WowMua để biết thêm chi tiết
         </div>
      </div>
   </div>
</div>