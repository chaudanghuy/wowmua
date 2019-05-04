<?php use Cake\Routing\Router;?>
<input type="hidden" id="modify-cart-url" value="<?php echo Router::url(['controller' => 'Carts', 'action' => 'modify']); ?>" name="">
<input type="hidden" name="user_id" value="<?=$userId?>" />
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="breadcrumbs">
            <ul class="breadcrumb">
               <li><a href="index.html">Trang chủ</a> <span class="divider"></span></li>
               <li class="active">Thanh toán</li>
            </ul>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <h2>Thanh toán</h2>
         <p class="well">Đã đăng ký tài khoản ? <a href="/users/login">Bấm vào đây để đăng nhập</a></p>
      </div>
   </div>
   <div class="row box">
      <div class="col-md-6">
         <h3>Địa chỉ giao hàng</h3>
         <form id="checkoutForm" class="form-horizontal" role="form" method="POST" action="/carts/process">
            <div class="form-group">
               <label class="col-md-3 control-label" for="inputfirstname">Họ<span class="required">*</span></label>
               <div class="col-md-9">
                  <input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?=!empty($user['first_name']) ? $user['first_name'] : '' ?>">
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label" for="inputfirstname">Tên<span class="required">*</span></label>
               <div class="col-md-9">
                  <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?=!empty($user['last_name']) ? $user['last_name'] : '' ?>">
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label" for="inputfirstname">Địa chỉ<span class="required">*</span></label>
               <div class="col-md-9">
                  <input type="text" name="address" class="form-control" placeholder="Address" value="<?=!empty($user['address']) ? $user['address'] : '' ?>">
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label" for="inputfirstname">Email<span class="required">*</span></label>
               <div class="col-md-9">
                  <input type="text" name="email" class="form-control" placeholder="Email Address" value="<?=!empty($user['email']) ? $user['email'] : '' ?>">
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label" for="inputfirstname">Điện thoại<span class="required">*</span></label>
               <div class="col-md-9">
                  <input type="text" name="phone" class="form-control" placeholder="Phone" value="<?=!empty($user['phone']) ? $user['phone'] : '' ?>">
               </div>
            </div>
            <div class="form-group">
               <div class="col-md-9" style="padding-left: 33px;">
                  <label class="checkbox">
                  <input type="checkbox" checked="checked"> Tạo tài khoản mới ? </label>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="your_order">
            <h3>Đơn hàng</h3>
            <table class="table table-bordered table-responsive">
               <tbody>
                  <?php $carts = $this->Common->getCartInfoByUserId($userId); ?>
                  <?php $total = 0; ?>
                  <?php foreach($carts as $cart): ?>
                  <tr>
                      <td class="image"><?= $this->Html->image($cart['product']['thumb'], ['alt' => $cart['product']['name']]) ?></td>
                     <td class="name"><?= $this->Html->link($cart['product']['name'], '/products/view/'.$cart['product']['id']) ?></td>
                     <td><?=number_format(round($cart['product']['sell_price'])) ?><sup>đ</sup></td>
                     <td class="quantity">
                        <input type="text" class="qty-<?=$cart['product']['id'] ?>" size="1" value="<?= $cart['quantity'] ?>" name="quantity">
                        <input type="image" class="update-cart" data-price="<?=$cart['product']['sell_price'] ?>" data-id="<?=$cart['product']['id'] ?>" title="Update" alt="Update" src="/img/update.png">
                        <input type="image" class="remove-cart" data-id="<?=$cart['product']['id'] ?>" title="Remove" alt="Remove" src="/img/remove.png">
                     </td>
                     <td class="total"><?=number_format(round($cart['price'])) ?><sup>đ</sup></td>
                  </tr>
                  <?php $total += round($cart['price']); ?>
                  <?php endforeach; ?>
               </tbody>
            </table>
            <h3>Phương thức thanh toán</h3>
            <div class="form-group" style="padding-left: 23px;">
               <label class="radio" onclick="jQuery('.transfer').toggle()">
               <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
               Chuyển khoản ngân hàng
               </label>
               <div class="col-md-6">
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
               </p>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <button id="placeOrderBtn" class="btn btn-danger btn-block" type="button">ĐẶT MUA</button>
      </div>
   </div>
</div>