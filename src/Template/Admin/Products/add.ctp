<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a href="/admin/products" class="btn btn-primary"><i class="fas fa-long-arrow-alt-left"></i> Quay lại</a>
            </div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">
                        <legend><i class="zmdi zmdi-plus-circle-o"></i> <?= __('Sản phẩm') ?></legend>
                    </h3>
                </div>
                <hr>
                <?= $this->Form->create($product, ['enctype' => 'multipart/form-data']) ?>
                <fieldset>
                    <?php
                        echo $this->Form->hidden('category_id', ['value' => $category_id]);
                        echo $this->Form->hidden('sub_category_id', ['value' => $sub_category_id]);
                        echo $this->Form->hidden('trademark_id', ['value' => $trademark_id]);
                        echo $this->Form->hidden('sku', ['id' => 'sku', 'value' => NULL]);
                        echo $this->Form->input('name',['label' => 'Sản phẩm']);
                        echo $this->Form->hidden('slug', ['value' => NULL]);
                        echo $this->Form->hidden('total_bought', ['value' => NULL]);
                        echo $this->Form->hidden('model', ['value' => 'WM']);
                        echo $this->Form->input('description', ['label' => 'Mô tả']);
                        echo $this->Form->input('shipping', ['label' => 'Số lượng', 'value' => 1]);
                        echo $this->Form->input('buy_price', ['label' => 'Giá lẻ']);
                        echo $this->Form->hidden('sell_price', ['label' => 'Giá chính xác', 'value' => NULL]);
                        echo $this->Form->hidden('calc_price', ['value' => NULL]);
                        echo $this->Form->hidden('discount_endtime', ['value' => date('Y-m-d')]);
                        echo $this->Form->hidden('discount_percent',['value' => 0]);
                        echo $this->Form->hidden('units_in_stock', ['value' => 1]);
                        echo $this->Form->hidden('size', ['label' => 'Kích thước', 'value' => NULL]);
                        echo $this->Form->hidden('color', ['label' => 'Màu sắc', 'value' => NULL]);
                        echo $this->Form->hidden('weight', ['label' => 'Trọng lượng', 'value' => NULL]);
                        echo $this->Form->hidden('rating', ['value' => 1]);
                        echo $this->Form->input('thumb', ['label' => 'Hình SP', 'type' => 'file']);
                        echo $this->Form->hidden('created', ['value' => date("Y-m-d H:i:s")]);
                        echo $this->Form->hidden('modified', ['value' => date("Y-m-d H:i:s")]);
                        echo $this->Form->input('crawl_url', ['label' => 'Link gốc']);
                        echo $this->Form->hidden('crawl_info_url', ['value' => NULL]);
                        echo $this->Form->hidden('crawl_detail_url', ['value' => NULL]);
                        echo $this->Form->hidden('crawl_status', ['value' => 'INFO']);
                        echo $this->Form->input('position', ['label' => 'Vị trí', 'options' => $positions, 'type' => 'select']);
                        echo $this->Form->input('status', ['label' => 'Tình trạng', 'options' => $statuses, 'type' => 'select']);
                    ?>
                </fieldset>
                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block" onclick="document.getElementById('form').submit()">
                    <i class="far fa-paper-plane"></i>&nbsp;
                    <span id="payment-button-amount">Tạo ngay</span>
                </button>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
