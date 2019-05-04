<div class="modal-login modal fade scroll-able" id="myModal-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?= $this->Flash->render('auth') ?>
                <?= $this->Form->create() ?>
                    <div class="login-form__group">
                        <?= $this->Form->input('email',['label'=>false,'placeholder'=>'Email','class'=>'username form-control','required'=>'true']) ?>
                    </div>
                    <div class="login-form__group">
                        <?= $this->Form->input('password',['label'=>false,'placeholder'=>'Password','class'=>'username form-control','required'=>'true']) ?>
                    </div>
                    <?= $this->Form->button(__('Login'),['class'=>'login-form__button']); ?>
                </form>
            </div>
            <div class="modal-footer clearfix">
                <label class="pull-left">Don't have an account</label>
                <a href="#" title="Sign up" data-toggle="modal" data-target="#myModal-signup" data-dismiss="modal">Sign up</a>
            </div>
        </div>
    </div>
</div>