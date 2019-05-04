<!-- header -->
<?=$this->element('WM_Balo/home_header'); ?>
<!-- /header -->
<!-- content -->
<div class="content">
	<div class="product">
		<div class="container">
			<?=$this->element('WM_Balo/home_featured_ajax'); ?>
		</div>
	</div>
	<div class="container">
		<div class="content__title">
			<?= __('NHỮNG LÝ DO ĐỂ BẠN CHỌN WOWMUA') ?>
			<br>
			<span class="content__title--botton"></span>
		</div>
		<div class="row content-top" style="display: flex;flex-wrap: wrap;">
			<div class="col-md-4" style="margin-bottom: 30px;">
				<div class="content-top__item" href="javascript:void(0)" title="" style="height: 100%;padding: 20px 20px 10px;color: #fff;">
					<img src="/tpl_v2/img/img-content-1.png" alt="">
					<h5><?= __('Mua hàng xách tay mọi lúc mọi nơi') ?></h5>
					<p>
						<?= __('Mặc cho sản phẩm bạn muốn mua đựơc sản xuất ở quốc gia nào, nếu sản phẩm hợp pháp, WOWMUA sẽ điều phối người vận chuyển mang hàng xách tay về cho bạn. Những người vận chuyển là đội ngũ tiếp viên và traveler thường xuyên đi lại giữa Việt Nam và nước sở tại. Vì vậy, luôn có hàng bạn cần.') ?>
					</p>
				</div>
			</div>
			<div class="col-md-4" style="margin-bottom: 30px;">
				<div class="content-top__item" href="javascript:void(0)" title="" style="height: 100%;padding: 20px 20px 10px;color: #fff;">
					<img src="/tpl_v2/img/img-content-2.png" alt="">
					<h5><?= __('Phí dịch vụ cố định') ?></h5>
					<p><?= __('WOWMUA cam kết cố định phí dịch vụ giao hàng. Chúng tôi cung cấp bảng tính và minh bạch tất cả chi phí dịch vụ. Chúng tôi chỉ nhận phí dịch vụ cố định về tư vấn và điều phối, phí rẻ bằng 1 ly trà sữa mà thôi.') ?>
					</p>
				</div>
			</div>
			<div class="col-md-4" style="margin-bottom: 30px;">
				<div class="content-top__item" href="javascript:void(0)" title="" style="height: 100%;padding: 20px 20px 10px;color: #fff;">
					<img src="/tpl_v2/img/img-content-3.png" alt="">
					<h5><?= __('Hệ thống đáng tin cậy') ?></h5>
					<p><?= __('Đội ngũ traveler là tiếp viên và khách du lịch cố định thường xuyên đi lại giữa các tuyến, có độ tin cậy cao. Chúng tôi có giới thiệu, hướng dẫn và khuyến khích các bạn mua hàng online trên các trang web uy tín cung cấp hàng hoá chính hãng. WOWMUA chỉ trả chi phí cho người vận chuyển khi bạn nhận được món hàng bạn yêu cầu.') ?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="activity">
		<div class="container">
			<div class="row">
				<div class="content__title content__title--white">
					<?= __('WOWMUA hoạt động ra sao ?') ?>
					<br>
					<span class="content__title--botton-1"></span>
				</div>
				<div class="col-md-4">
					<div class="activity__item clearfix">
						<div class="activity__number pull-left">1</div>
						<div class="activity__text">
							<?= __('Tìm kiếm sản phẩm bạn yêu thích, tìm kiếm các đợt khuyến mãi trong thời gian thực cho bạn.') ?>
						</div>
					</div>
					<div class="activity__item clearfix padding-left">
						<div class="activity__number pull-left">2</div>
						<div class="activity__text ">
							<?= __('Chúng tôi liên hệ những người vận chuyển đi du lịch đến nước có hàng bạn đặt sẽ được nhận đơn hàng của bạn với giá tốt nhất và thời gian giao hàng sớm nhất và thông báo cho bạn.') ?>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-md-push-4">
					<div class="activity__item clearfix">
						<div class="activity__number pull-right">3</div>
						<div class="activity__text">
							<?= __('Bạn xác nhận vận chuyển và thanh toán đơn hàng, chúng tôi sẽ gửi xác nhận để người mua hộ tiến hành mua và chuyển về Việt Nam') ?>
						</div>
					</div>
					<div class="activity__item clearfix padding-right">
						<div class="activity__number pull-right">4</div>
						<div class="activity__text ">
							<?= __('Chúng tôi liên hệ với bạn để giao hàng tại Việt Nam') ?>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-md-pull-4">
					<div class="activity-download">
						<img class="img-responsive" src="/tpl_v2/img/activity-en.png" alt="">
						<!--<div class="activity-download__link">-->
						<!--<a href="#" title="">Download the App Now</a>-->
						<!--</div>-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Button trigger modal -->
	<button type="button" style="display: none" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#mybalo-popup-cencel--z">
	Launch demo modal
	</button>
</div>
<!--/content-->
<!--Footer-->
<!-- footer -->
<?=$this->element('WM_Balo/home_footer'); ?>
<!-- /footer -->
<!--/Footer-->
<div id="loading-screen"></div>
<div class="modal-login modal fade scroll-able" id="myModal-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="alert alert-danger" id="register_failed_alert" style="display:none;"></div>
				<form class="login-form" id="form-password">
					<div class="login-form__group register-form">
						<input type="text" placeholder="Email" name="email" required="" value="">
					</div>
					<button class="login-form__button" type="button" onclick="global.resetPassword(jQuery('#form-password'));">
					Reset password
					</button>
				</form>
			</div>
			<div class="modal-footer clearfix">
				<label class="pull-left">
					Already have a <?=$brand; ?> account
				</label>
				<a href="#" title="Log in" data-toggle="modal" data-target="#myModal-login" data-dismiss="modal">Log in</a>
			</div>
		</div>
	</div>
</div>
<div class="modal-login modal fade scroll-able" id="myModal-addition-email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="alert alert-danger" style="display:none;"></div>
				<form class="login-form" id="addition-email-form">
					<div class="login-form__group register-form">
						<input type="text" placeholder="Email" name="email" required="" value="">
					</div>
					<input type="hidden" id="fb-access-token-addition" name="access_token" value="">
					<button class="login-form__button" type="button" onclick="global.additionEmailFacebook($('#addition-email-form'))">
					Sign up
					</button>
				</form>
			</div>
			<div class="modal-footer clearfix">
				<label class="pull-left">
					Already have a <?=$brand; ?> account
				</label>
				<a href="#" title="Log in" data-toggle="modal" data-target="#myModal-login" data-dismiss="modal">Log in</a>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="mybalo-popup-cencel--z" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body" style="text-align: center;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
				</button>
				<div class="mybalo-popup__img">
					<!--<i class="fa fa-frown-o" aria-hidden="true"></i>-->
					<img src="/tpl_v2/img/aboutus-tab-img.png" alt="">
				</div>
				<div class="mybalo-popup-cencel__text">
					Currently, we are only facilitating deliveries to Vietnam and the US. We'll let you know once we expand to other countries.
				</div>
				<form class="mybalo-popup__form" id="facilitating-form" novalidate="novalidate">
					<input type="text" class="form-control mybalo-popup__input" name="name" placeholder="Name" required="" value="">
					<input type="email" class="form-control mybalo-popup__input" name="email" placeholder="Email" required="" value="">
					<input type="text" class="form-control mybalo-popup__input" name="delivery_location" placeholder="Country" required="" value="">
					<button class="mybalo-popup__button" type="submit"> Ok! </button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end intercome -->
<!-- deploy -->
<div>
	<div class="sweet-overlay" tabindex="-1"></div>
	<div class="sweet-alert" tabindex="-1">
		<div class="icon error"><span class="x-mark"><span class="line left"></span><span class="line right"></span></span>
	</div>
	<div class="icon warning"> <span class="body"></span> <span class="dot"></span> </div>
	<div class="icon info"></div>
	<div class="icon success"> <span class="line tip"></span> <span class="line long"></span>
	<div class="placeholder"></div>
	<div class="fix"></div>
</div>
<div class="icon custom"></div>
<h2>Title</h2>
<p class="lead text-muted">Text</p>
<p>
	<button class="cancel btn btn-lg" tabindex="2">Cancel</button>
	<button class="confirm btn btn-lg" tabindex="1">OK</button>
</p>
</div>
</div>
<div id="fb-root" class=" fb_reset">
<div style="position: absolute; top: -10000px; height: 0px; width: 0px;">
<div></div>
</div>
<div style="position: absolute; top: -10000px; height: 0px; width: 0px;">
<div></div>
</div>
</div>
<div id="intercom-container" style="position: fixed; width: 0px; height: 0px; bottom: 0px; right: 0px; z-index: 2147483647;">
<div data-reactroot="" class="intercom-app intercom-app-launcher-enabled">
<div></div>
<div></div>
<!-- react-empty: 6 -->
<div></div>
<!-- react-empty: 7 -->
</div>
</div>