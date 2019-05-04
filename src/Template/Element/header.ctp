<div class="header">
    <nav class="navbar container">
        <div class="row">
            <div class="col-md-2">
                <a href="/"><img src="/image/wowmua.png" class="img-circle" width="100px" height="100px" alt="WowMua.com" style="margin-top: 0px"></a>
            </div>
            <div class="col-md-7" style="margin-top: 30px">
                <div class="input-group">
                    <div class="input-group-btn search-panel">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span id="search_concept">Tất cả</span> <span class="caret"></span>
                        </button>
                        <ul id="select-opts" class="dropdown-menu" role="menu">
                            <li data-value="all"><a href="#all">Tất cả</a></li>
                            <li data-value="300-500"><a href="#contains">300,000 - 500,000</a></li>
                            <li data-value="500-1000"><a href="#its_equal">500,000 - 1,000,000</a></li>
                            <li data-value="1000-3000"><a href="#greather_than">1000,000 - 3,000,000</a></li>
                            <li data-value="3000"><a href="#less_than">3,000,000</a></li>
                            <li class="divider"></li>
                        </ul>
                    </div>
                    <input type="hidden" name="search_param" value="all" id="search_param">
                    <input type="text" class="form-control" id="search-text" name="search-text" placeholder="Nhập thương hiệu và tên sản phẩm bạn cần mua..">
                    <span class="input-group-btn">
                        <button id="search-wm-home" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span> Tìm ngay</button>
                    </span>
                </div>
                <div class="clearfix">&nbsp;</div>
                <div class="row" style="margin-left: 1px;">
                    <?php foreach ($categories as $category): ?>
                    <a href="/danh-muc/<?=$category['slug'] ?>" class="btn btn-success btn-xs"><?= $category['name']; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-3"  style="margin-top: 30px">
                <div class="navbar-collapse collapse navbar-right">
                    <?php if (isset($authUser['id']) && !empty($authUser['id'])): ?>
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                            class="glyphicon glyphicon-user"></span> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><?php echo $this->Html->link(__('<i class="glyphicon glyphicon-user"></i> Profile'), array('controller' => 'users', 'action' => 'profile', $authUser['id']), array('escapeTitle' => false)); ?></li>
                                <li><?php echo $this->Html->link(__('<i class="glyphicon glyphicon-cog"></i> Change Password'), array('controller' => 'users', 'action' => 'change_password', $authUser['id']), array('escapeTitle' => false)); ?></li>
                                <li class="divider"></li>
                                <li><?php echo $this->Html->link(__('<i class="glyphicon glyphicon-off"></i> Logout'), array('controller' => 'users', 'action' => 'logout'), array('escapeTitle' => false)) ?></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-right cart">
                        <li class="dropdown">
                            <?php $carts = $this->Common->getCartInfoByUserId($userId); ?>
                            <?php if ((isset($carts)) && (!empty($carts))): ?>
                            <a href="/carts" class="dropdown-toggle">Giỏ hàng <span><?= $carts->count() ?></span></a>
                            <?php endif; ?>
                        </li>
                    </ul>
                    <?php else: ?>
                    <ul class="nav navbar-right cart">
                        <li class="dropdown">
                            <?php $carts = $this->Common->getCartInfoByUserId($userId); ?>
                            <?php if ((isset($carts)) && (!empty($carts))): ?>
                            <a href="/carts" class="dropdown-toggle">Giỏ hàng <span> <?= $carts->count() ?></span></a>
                            <?php endif; ?>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="/" class="dropdown-toggle" data-toggle="dropdown">Tài khoản <b class="caret"></b></a>
                            <ul class="dropdown-menu" style="padding: 15px;min-width: 250px;">
                                <li>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php
                                            echo $this->Form->create('User', ['url' => ['controller' => 'Users', 'action' => 'login']]);
                                            echo $this->Form->input('email', ['label' => false, 'placeholder' => 'Email address']);
                                            echo $this->Form->input('password', ['label' => false, 'placeholder' => 'Password']);
                                            echo $this->Form->input('remember_me', ['type' => 'checkbox']);
                                            echo $this->Form->submit('Đăng nhập', ['class' => 'btn btn-success btn-block']);
                                            echo $this->Form->end();
                                            ?>
                                        </div>
                                    </div>
                                </li>
                                <!-- <li class="text-center">or</li>
                                <br />
                                <li>
                                    <input class="btn btn-primary btn-block" type="button" id="sign-in-google" value="Sign In with Google">
                                    <input class="btn btn-primary btn-block" type="button" id="sign-in-twitter" value="Sign In with Twitter">
                                </li> -->
                            </ul>
                        </li>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</div>
<?php $carts = $this->Common->getCartInfoByUserId($userId); ?>
<?php if ((isset($carts)) && (!empty($carts))): ?>
<?php if (count($carts) <= 0): ?>
<div class="col-md-12 text-center">
<div class="alert alert-info">
  <i class="fa fa-shopping-cart" aria-hidden="true"></i> Bạn có <strong><?= $carts->count() ?> sản phẩm</strong> trong giỏ hàng. <a href="/carts" class="dropdown-toggle">Xem ngay</a>.
</div>
</div>
<?php endif; ?>
<?php endif; ?>