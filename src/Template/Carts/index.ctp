<?php use Cake\Routing\Router;?>
<input type="hidden" id="modify-cart-url" value="<?php echo Router::url(['controller' => 'Carts', 'action' => 'modify']); ?>" name="">
<input type="hidden" name="user_id" value="<?=$userId?>" />
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="breadcrumbs">
				<ul class="breadcrumb">
					<li><a href="/">Trang chủ</a> <span class="divider"></span></li>
					<li class="active">Giỏ hàng</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h2>Giỏ hàng</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="cart-info">
				<table class="table">
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
								<input type="image" class="update-cart" data-price="<?=$cart['product']['sell_price'] ?>" data-id="<?=$cart['product']['id'] ?>" title="Update" alt="Update" src="img/update.png">
								<input type="image" class="remove-cart" data-id="<?=$cart['product']['id'] ?>" title="Remove" alt="Remove" src="img/remove.png">
							</td>
							<td class="total"><?=number_format(round($cart['price'])) ?><sup>đ</sup></td>
						</tr>
						<?php $total += round($cart['price']); ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-8">
			<div class="cart-totals">
				<table class="table">
					<tr>
						<th><span>Tổng đơn hàng</span></th>
						<td><?php echo number_format($total) ?><sup>đ</sup></td>
					</tr>
				</table>
				<p>
					<a class="btn btn-danger" href="/carts/checkout">
						TIẾN HÀNH THANH TOÁN <i class="fa fa-money" aria-hidden="true"></i>
					</a>
				</p>
			</div>
		</div>
	</div>
</div>