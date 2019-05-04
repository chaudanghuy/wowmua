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
                        <legend><i class="zmdi zmdi-plus-circle-o"></i> <?= __('Đơn hàng') ?></legend>
                    </h3>
                </div>
                <hr>
                <?= $this->Form->create($order, ['enctype' => 'multipart/form-data']) ?>
                <fieldset>
                    <?php
                        echo $this->Form->input('from', ['label' => 'Mua từ', 'id' => 'from-location', 'autocomplete' => 'from']);
                        echo $this->Form->input('to', ['label' => 'Chuyển về', 'id' => 'to-location', 'autocomplete' => 'to']);
                        echo $this->Form->input('needed_date', ['label' => 'Cần trước ngày', 'type' => 'date']);
                        echo $this->Form->input('photo', ['label' => 'Hình SP', 'type' => 'file']);
                        echo $this->Form->input('name', ['label' => 'Tên SP']);
                        echo $this->Form->input('buy_price', ['label' => 'Giá SP']);
                        echo $this->Form->input('qty', ['label' => 'Số lượng']);
                        echo $this->Form->input('crawl_url', ['label' => 'Link gốc']);
                        echo $this->Form->input('customer', ['label' => 'Tên người nhận']);
                        echo $this->Form->input('email', ['label' => 'Email']);
                        echo $this->Form->input('address', ['label' => 'Địa chỉ']);
                        echo $this->Form->input('phone', ['label' => 'SĐT']);
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
