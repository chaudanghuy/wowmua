<div class="modal-login modal fade scroll-able" id="myModal-register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert alert-danger" id="register_failed_alert" style="display:none;"></div>
                <form class="login-form" method="post" action="https://www.bigbalo.com/user/signup" id="form-register">
                    <div class="login-form__group register-form">
                        <input name="authenticity_token" value="cOED83TA3pybjBIMgH/5u7Q9fzdjrm+BHHbky26vZngCAkTXYlxKlB+HLxbPR8LlAr7HHGMfyr0PRHdhOHW9eQ==" type="hidden">
                        <input type="text" placeholder="First Name" name="first_name" required="" value="">
                    </div>
                    <div class="login-form__group register-form">
                        <input type="text" placeholder="Last Name" name="last_name" required="" value="">
                    </div>
                    <div class="login-form__group register-form">
                        <input type="email" placeholder="Email" name="email" required="" value="">
                    </div>
                    <div class="login-form__group register-form">
                        <input type="password" placeholder="Password" name="password" required="">
                    </div>
                    <button class="login-form__button" type="button" onclick="global.signup(jQuery('#form-register').val());">
                    Sign up
                    </button>
                </form>
            </div>
            <div class="modal-footer clearfix">
                <label class="pull-left">
                    Already have a BigBalo account
                </label>
                <a href="#" title="Log in" data-toggle="modal" data-target="#myModal-login" data-dismiss="modal">
                    Log in
                </a>
            </div>
        </div>
    </div>
</div>