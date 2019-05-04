<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a href="#" onClick="window.history.back();" class="btn btn-primary"><i class="fas fa-long-arrow-alt-left"></i> Quay lại</a>
            </div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">
                        <?=$category->name ?> <i class="fas fa-pencil-alt"></i>
                    </h3>
                </div>
                <hr>
                <?= $this->Form->create($category, ['id' => 'form']) ?>
                <fieldset>
                    <?php
                    echo $this->Form->input('name', ['label' => 'Tên']);
                    echo $this->Form->input('description', ['label' => 'Mô tả']);
                    echo $this->Form->input('status', ['label' => 'Tình trạng']);
                    echo $this->Form->input('crawl_url', ['label' => 'Nguồn cào']);
                    ?>
                </fieldset>
                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block" onclick="document.getElementById('form').submit()">
                    <i class="far fa-paper-plane"></i>&nbsp;
                    <span id="payment-button-amount">Cập nhật</span>
                </button>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>