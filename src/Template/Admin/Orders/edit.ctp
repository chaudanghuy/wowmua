<?php echo $this->Form->hidden('admin-order-index', ['id' => 'admin-order-index', 'value' => 1]); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a href="/admin/orders" class="btn btn-primary"><i class="fas fa-long-arrow-alt-left"></i> Quay lại</a>
            </div>
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">
                        <legend><i class="zmdi zmdi-plus-circle-o"></i> <?= __('Edit Order') ?></legend>
                    </h3>
                </div>
                <hr>
                <?= $this->Form->create($order, ['enctype' => 'multipart/form-data']) ?>
                <fieldset>
                    <?php
                        echo $this->Form->input('from_location', ['label' => 'Mua từ', 'id' => 'from-location', 'autocomplete' => 'from']);
                    echo $this->Form->input('to_location', ['label' => 'Chuyển về', 'id' => 'to-location', 'autocomplete' => 'to']);
                    echo $this->Form->input('needed_date', ['label' => 'Cần trước ngày', 'type' => 'date']);
                    echo $this->Form->input('photo', ['label' => 'Hình SP', 'type' => 'file']);
                    ?>
                    <label class="control-label" for="product_name">Tên SP: </label>
                    <input type="text" name="product_name" class="form-control" id="product_name" value="<?php echo $product_name?>">
                    <label class="control-label" for="buy_price">Giá SP: </label>
                    <input type="text" name="buy_price" class="form-control" id="buy_price" value="<?php echo $buy_price?>">
                    <label class="control-label" for="quantity">Số lượng: </label>
                    <input type="text" name="quantity" class="form-control" id="quantity" value="<?php echo $quantity?>">
                    <label class="control-label" for="crawl_url">Link gốc: </label>
                    <input type="text" name="crawl_url" class="form-control" id="crawl_url" value="<?php echo $crawl_url?>">
                    <label class="control-label" for="first_name">Name: </label>
                    <input type="text" name="first_name" class="form-control" id="first_name" value="<?php echo $first_name?>">
                    <label class="control-label" for="email">Email: </label>
                    <input type="text" name="email" class="form-control" id="email" value="<?php echo $email?>">
                    <label class="control-label" for="address">Địa chỉ: </label>
                    <input type="text" name="address" class="form-control" id="address" value="<?php echo $address?>">
                    <label class="control-label" for="phone">SĐT: </label>
                    <input type="text" name="phone" class="form-control" id="phone" value="<?php echo $phone?>">
                    <br>
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
