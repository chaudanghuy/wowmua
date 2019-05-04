<div class="page-content--bge5">
    <div class="container">
        <div class="login-wrap">
            <?php echo $this->Flash->render() ?>
            <div class="login-content">
                <div class="login-logo">
                    <a href="#">
                        <img src="/image/wowmua.png" alt="WowMua System" style="height: 100px">
                    </a>
                </div>
                <div class="login-form">
                    <?= $this->Flash->render('auth') ?>
                    <?= $this->Form->create() ?>
                        <div class="form-group">
                            <!-- <label>Email</label> -->
                            <?= $this->Form->input('email',['label'=>false,'placeholder'=>'Email','class'=>'au-input au-input--full','required'=>'true']) ?>
                        </div>
                        <div class="form-group">
                            <!-- <label>Password</label> -->
                            <?= $this->Form->input('password',['label'=>false,'placeholder'=>'Mật khẩu','class'=>'au-input au-input--full','required'=>'true']) ?>
                        </div>
                        <!-- <div class="login-checkbox">
                            <label>
                                <input type="checkbox" name="remember">Ghi nhớ đăng nhập
                            </label>
                            <label>
                                <a href="#">Quên mật khẩu?</a>
                            </label>
                        </div> -->
                        <?= $this->Form->button(__('Đăng nhập'),['class'=>'au-btn au-btn--block au-btn--green m-b-20']); ?>
                        <!-- <div class="social-login-content">
                            <div class="social-button">
                                <button class="au-btn au-btn--block au-btn--blue m-b-20">sign in with facebook</button>
                                <button class="au-btn au-btn--block au-btn--blue2">sign in with twitter</button>
                            </div>
                        </div> -->
                    <?= $this->Form->end() ?>
                    <div class="register-link">
                        <p>
                            Gặp vấn đề với đăng nhập?
                            <a href="#">Liên hệ WowMua</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>