<?php use Cake\Routing\Router;?>
<?php $this->assign('title', $product['name']); ?>
<!-- Hidden field -->
<input type="hidden" id="add-cart-url" value="<?php echo Router::url(['controller' => 'Carts', 'action' => 'add']); ?>" name="">
<div class="container">
	<ul class="breadcrumb prod">
		<li><a href="/">Trang chủ</a> <span class="divider"></span></li>
		<li>Sản phẩm <span class="divider"></span></li>
		<li class="active"><?=$product['name']; ?></li>
	</ul>
	<div class="row product-info">
		<div class="col-md-6">
			<div class="image"><a class="cloud-zoom" rel="adjustX: 0, adjustY:0" id='zoom1' href="<?=$product['thumb'];?>" title="Nano"><?=$this->Html->image($product['thumb'], ['alt' => 'Nano', 'title' => 'Nano', 'id' => 'image'])?></a></div>
			<div class="image-additional">
				<a title="Dress" rel="useZoom: 'zoom1', smallImage: '<?=$product['thumb'];?>'" class="cloud-zoom-gallery" href="<?=$product['thumb'];?>"><?=$this->Html->image($product['thumb'], ['alt' => 'Nano', 'title' => 'Nano', 'id' => 'image'])?></a>
				<!-- <a title="Dress" rel="useZoom: 'zoom1', smallImage: 'products/dress5home.jpg'" class="cloud-zoom-gallery" href="products/dress5home.jpg"><?=$this->Html->image('../products/dress5home.jpg', ['alt' => 'Dress', 'title' => 'Dress', 'id' => 'image'])?></a>
				<a title="Dress" rel="useZoom: 'zoom1', smallImage: 'products/dress6home.jpg'" class="cloud-zoom-gallery" href="products/dress6home.jpg"><?=$this->Html->image('../products/dress6home.jpg', ['alt' => 'Dress', 'title' => 'Dress', 'id' => 'image'])?></a>
				<a title="Dress" rel="useZoom: 'zoom1', smallImage: 'products/dress4home.jpg'" class="cloud-zoom-gallery" href="products/dress4home.jpg"><?=$this->Html->image('../products/dress4home.jpg', ['alt' => 'Dress', 'title' => 'Dress', 'id' => 'image'])?></a> -->
			</div>
			<div class="well" style="margin-left: 10px; border:1px solid #cecece;">
				<h3>Xem trang gốc</h3>
				<div class="media">
					<div class="media-left">
						<a href="#">
							<img class="media-object" src="/img/gmarket.jpg" width="128px" height="128px" alt="...">
						</a>
					</div>
					<div class="media-body">
						<h4 class="media-heading"><a href="<?=$product['crawl_url']; ?>" target="_blank">GMARKET</a></h4>
						<select class="rating-stars">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3" selected>3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
						Gmarket là trang web bán đấu giá trực tuyến và trang web mua sắm trực tuyến của Hàn Quốc, nơi mọi người từ khắp nơi trên thế giới mua và bán hàng hóa và dịch vụ.
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<h1><?=$product['name']?></h1>
			<div class="jumbotron">
				<div class="row">
					<!-- <div class="col-md-10" style="margin-top: -10px">  -->
					<?php
						if ($product['discount_percent']) {
							echo '<p>Giá: ';
												echo '<span class="strike" style="margin-left: 15px">' . number_format($product['buy_price']) . '<sup>đ</sup></span></p>';
												echo '<strong style="color: red; font-size: 30px; margin-left: 55px;">' . number_format($product['sell_price']) . '<sup>đ</sup></strong>&nbsp;&nbsp;&nbsp;';
											} else {
												echo '<p>Giá: ';
												echo '<strong style="color: red; font-size: 30px; margin-left: 15px">' . number_format($product['sell_price']) . '<sup>đ</sup></strong></p>';
											}
						?>
						<!-- </div> -->
					</div>
				</div>
				<div class="line"></div>
				<div class="control-group row">
					<div class="col-md-12">
						<div class="col-md-3">
							<label class="control-label">Số lượng<span class="required">*</span></label>
						</div>
						<div class="col-md-5">
							<div class="controls">
								<input id="itemQty" type="number" class="form-control" name="" value="1" placeholder="Nhập số lượng cần mua">
							</div>
						</div>
						<div class="col-md-4">
							<a id="add-to-cart" href="" class="btn btn-success btn-block"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Thêm giỏ hàng</a>
						</div>
					</div>
				</div>
				<div class="line"></div>
				<form class="form-inline" id="cartForm" method="POST">
					<input type="hidden" name="user_id" value="<?=$userId?>" />
					<input type="hidden" name="product_id" value="<?=$product['id']?>" />
					<input type="hidden" name="price" value="<?=$product['sell_price']?>" />
					<!-- <label>Qty:</label>  -->
					<input id="cartQty" type="hidden" name="quantity" value="1" placeholder="1" class="col-md-1">
				</form>
				<div class="clearfix"></div>
				&nbsp;&nbsp;&nbsp;
			</div>
		</div>
		<div class="col-md-12">
			<div class="tabs">
				<ul class="nav nav-tabs" id="myTab">
					<li class="active"><a href="#home" data-toggle="tab">Thông tin</a></li>
					<li><a href="#profile" data-toggle="tab">Đặc tính</a></li>
					<li><a href="#messages" data-toggle="tab">Bình luận</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="home"><?=$product['description']?> </div>
					<div class="tab-pane" id="profile">

					</div>
					<div class="tab-pane" id="messages">
						<div class="fb-comments" data-href="<?=Router::url(null, true); ?>" data-numposts="5"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h2 style="font-weight: bold; font-size: 20px">Sản phẩm liên quan</h2>
				<?php foreach ($products as $product): ?>
				<div class="col-sm-3">
					<article class="col-item">
						<div class="photo">
							<div class="options-cart-round">
								<button class="btn btn-default" title="Add to cart">
								<span class="fa fa-shopping-cart"></span>
								</button>
							</div>
							<div class="item">
								<a href="#">
									<?=($product['discount_percent']) ? '<span class="notify-badge">' . $product['discount_percent'] . '</span>' : ''?>
									<?=$this->Html->image($product['thumb'], ['url' => ['action' => 'view', $product['id']]])?>
								</a>
							</div>
						</div>
						<div class="info">
							<div class="row">
								<div class="price-details col-md-6">
									<div class="btn-add text-center">
										<div class="rating text-center">
											<select class="rating-stars">
												<?php $i = 1; ?>
												<?php while ($i <= 5): ?>
													<option value="<?= $i; ?>" <?= ($i == $product['rating']) ? "selected" : "" ?>><?= $i; ?></option>
													<?php $i++; ?>
												<?php endwhile; ?>
											</select>
										</div>
										<div class="text-center">
											<i class="fa fa-comments" aria-hidden="true"></i> 1,050,008
										</div>
									</div>
									<p class="btn-details">
										<div class="text-center">Kết thúc sau</div>
										<div class="text-center">
											<div class="getting-started"></div>
										</div>
									</p>
								</div>
							</div>
							<div class="separator clear-left">
								<div class="price-details col-md-6">
									<div class="row">
										<div class="col-md-5">
											<p class="details" style="text-decoration: line-through; margin-top: 12px; margin-left: 0px; color: #C0C0C0;">
												<?=number_format($product['sell_price'])?> <sup>đ</sup>
											</p>
										</div>
										<div class="col-md-6" style="margin-right: 12px">
											<p style="color: #23487b; font-size: 16px"><?=number_format($product['buy_price'])?> <sup>đ</sup></p>
										</div>
									</div>
									<span class="text-center">Mua sản phẩm tại <a href="#">Gmarket</a></span>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</article>
				</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>