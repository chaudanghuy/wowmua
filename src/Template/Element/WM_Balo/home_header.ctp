<header class="header">
    <div class="container">
        <div class="top-bar clearfix">
            <a class="top-bar__logo--home pull-left" href="/" title=""><img src="/tpl_v2/img/logo_WOWMUA.png" alt=""></a>
            <div id="navigation">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </div>
            <ul class="top-bar__menu list-unstyled pull-right">
                <!-- <li>
                    <a href="/courier" aria-expanded="false" data-animation="scale-up" role="button">
                        <img class="icon-main-menu" src="/tpl_v2/img/icon-menu.png" alt="">
                <?= __('Become a courier') ?>
                    </a>
                </li> -->
                <li>
                    <a href="/instruction" aria-expanded="false" data-animation="scale-up" role="button">
                        <?= __('Hướng dẫn mua hàng') ?>
                        <span class="icon-circle" style="color: transparent">
                            <i class="fa fa-circle" aria-hidden="true"></i>
                        </span>
                    </a>
                </li>
                <!-- <li>
                    <a type="button" data-toggle="modal" data-target="#myModal-signup" href="#" title="">
                <?= __('Đăng ký') ?>
                        <span class="icon-circle" style="color: transparent;">
                            <i class="fa fa-circle" aria-hidden="true"></i>
                        </span>
                    </a>
                </li> -->
                <!-- <li>
                    <a type="button" data-toggle="modal" data-target="#myModal-login" class="loginbutton" href="#" title="">
                <?= __('Đăng nhập') ?>
                        <span class="icon-circle" style="color: transparent;">
                            <i class="fa fa-circle" aria-hidden="true"></i>
                        </span>
                    </a>
                </li> -->
                <li>
                    <div class="btn-group menu-dropdown" role="group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="flag-header" src="/tpl_v2/img/<?= $lang_flag ?>.png">
                            <?= __($lang_text); ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-locale="en" onclick="reloadUrl('en')">
                                    <img src="/tpl_v2/img/us.png">
                                    English
                                </a></li>
                            <li><a href="#" onclick="reloadUrl('vi')">
                                    <img src="/tpl_v2/img/vietnam.png">
                                    Tiếng Việt
                                </a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <?php if ($actionName == 'index'): ?>
            <div class="header-title">
                <div class="header-title__item">
                    <?= __('CHỈ VIỆC NẰM NHÀ SHOPPING THẾ GIỚI') ?>
                    <br> <?= __('CÙNG CÁNH CỬA GIAO NHẬN VẬN CHUYỂN HÀNG HOÁ QUỐC TẾ WOWMUA') ?>
                    <span>
                        <?= __('Đặt hàng NGAY!') ?>
                    </span>
                </div>
            </div>
            <?= $this->element('WM_Balo/home_form_request'); ?>
        <?php endif; ?>
    </div>
</header>