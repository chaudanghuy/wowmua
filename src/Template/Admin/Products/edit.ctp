<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><a href="#" onClick="window.history.back();" class="btn btn-primary"><i class="fas fa-long-arrow-alt-left"></i> Quay lại</a></div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">
                        <?=$product->name; ?> <i class="fas fa-pencil-alt"></i>
                    </h3>
                </div>
                <hr>
                <?= $this->Form->create($product, ['id' => 'form', 'type' => 'file']) ?>
                <fieldset>
                    <?php
                    echo $this->Form->input('category_id', ['label' => 'Danh mục', 'options' => $categories, 'empty' => true]);
                    echo $this->Form->input('sub_category_id', ['label' => 'Danh mục con', 'options' => $subCategories, 'empty' => true]);
                    echo $this->Form->input('sku', ['label' => 'SKU']);
                    echo $this->Form->input('name', ['label' => 'Tên']);
                    echo $this->Form->input('model', ['label' => 'Model']);
                    echo $this->Form->input('description', ['label' => 'Mô tả']);
                    echo $this->Form->input('buy_price', ['label' => 'Giá bán']);
                    echo $this->Form->input('sell_price', ['label' => 'Giá khuyến mãi']);
                    echo $this->Form->input('units_in_stock', ['label' => 'Số lượng']);
                    echo $this->Form->input('size', ['label' => 'Kích thước']);
                    echo $this->Form->input('color', ['label' => 'Màu sắc']);
                    echo $this->Form->input('weight', ['label' => 'Trọng lượng']);
                    echo $this->Form->input('rating', ['label' => 'Đánh giá']);
                    echo $this->Form->control('thumb', ['type' => 'file']);
                    echo $this->Html->image($product->thumb, ['class' => 'img-thumbnail']);
                    echo $this->Form->input('status', ['label' => 'Tình trạng']);
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