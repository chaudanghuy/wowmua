<form class="header-form clearfix" id="home_page_form" action="/request" method="get">
    <input type="hidden" id="lang_flag_code" value="<?= $lang_flag; ?>">
    <input type="hidden" id="from-location-id" name="from_location_id" value="">
    <input type="hidden" id="to-location-id" name="to_location_id" value="">
    <div class="col-md-3"></div>
    <div class="header-form__group pull-left" style="margin-bottom: 30px;font-size: 19px;">
        <label><?= __('Đặt hàng từ') ?></label>
    </div>
    <div class="form-group">
        <div class="col-md-3"></div>
        <div class="header-form__group pull-left" style="background: rgba(0, 0, 0, 0.3);border-radius: 10px;display: inline-block;">
            <div class="col-sm-2 text-center">
                <a href="/request?from_location=<?= __('HÀN QUỐC') ?>&to_location=H%E1%BB%93+Ch%C3%AD+Minh+(SGN)">
                    <img style="margin-bottom: 10px" src="/image/korea-flag.png" class="img-circle" width="50px" height="50px"/>
                    <br>
                    <span style="color: whitesmoke; font-weight: bold"><?= __('HÀN QUỐC') ?></span>
                </a>
            </div>
            <div class="col-sm-2 text-center">
                <a href="/request?from_location=<?= __('NHẬT BẢN') ?>&to_location=H%E1%BB%93+Ch%C3%AD+Minh+(SGN)">
                    <img style="margin-bottom: 10px" src="/image/japan-flag.png" class="img-circle" width="50px" height="50px"/>
                    <br>
                    <span style="color: whitesmoke; font-weight: bold"><?= __('NHẬT BẢN') ?></span>
                </a>
            </div>
            <div class="col-sm-2 text-center">
                <a href="/request?from_location=<?= __('ÚC') ?>&to_location=H%E1%BB%93+Ch%C3%AD+Minh+(SGN)">
                    <img style="margin-bottom: 10px" src="/image/australia-flag.png" class="img-circle" width="50px" height="50px"/>
                    <br>
                    <span style="color: whitesmoke; font-weight: bold"><?= __('ÚC') ?></span>
                </a>
            </div>
            <div class="col-sm-2 text-center">
                <a href="/request?from_location=<?= __('ANH') ?>&to_location=H%E1%BB%93+Ch%C3%AD+Minh+(SGN)">
                    <img style="margin-bottom: 10px" src="/image/uk-flag.png" class="img-circle" width="50px" height="50px"/>
                    <br>
                    <span style="color: whitesmoke; font-weight: bold"><?= __('ANH') ?></span>
                </a>
            </div>
            <div class="col-sm-2 text-center">
                <a href="/request?from_location=<?= __('PHÁP') ?>&to_location=H%E1%BB%93+Ch%C3%AD+Minh+(SGN)">
                    <img style="margin-bottom: 10px" src="/image/france-flag.png" class="img-circle" width="50px" height="50px"/>
                    <br>
                    <span style="color: whitesmoke; font-weight: bold"><?= __('PHÁP') ?></span>
            </div>
            <div class="col-sm-2 text-center">
                <a href="/request?from_location=<?= __('ĐỨC') ?>&to_location=H%E1%BB%93+Ch%C3%AD+Minh+(SGN)">
                    <img style="margin-bottom: 10px" src="/image/germany-flag.png" class="img-circle" width="50px" height="50px"/>
                    <br>
                    <span style="color: whitesmoke; font-weight: bold"><?= __('ĐỨC') ?></span>
                </a>
            </div>
        </div>
    </div>
</form>