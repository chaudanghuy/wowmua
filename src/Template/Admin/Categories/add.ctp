<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a href="#" onClick="window.history.back();" class="btn btn-primary"><i class="fas fa-long-arrow-alt-left"></i> Quay lại</a>
            </div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">
                        <legend><?= __('Add Category') ?></legend>
                    </h3>
                </div>
                <hr>
                <?= $this->Form->create($category) ?>
                <fieldset>
                    <?php
                    echo $this->Form->input('name');
                    echo $this->Form->input('description');
                    echo $this->Form->input('status');
                    ?>
                </fieldset>
                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block" onclick="document.getElementById('form').submit()">
                    <i class="far fa-paper-plane"></i>&nbsp;
                    <span id="payment-button-amount">Tạo mới</span>
                </button>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>