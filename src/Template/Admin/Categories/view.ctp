<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?= $this->Html->link(__('<i class="far fa-edit"></i> Chỉnh sửa'), ['action' => 'edit', $category->id], ['class' => 'btn btn-primary', 'escape' => false]) ?>
            <?= $this->Form->postLink(__('<i class="far fa-trash-alt"></i> Xoá'), ['action' => 'delete', $category->id], ['class' => 'btn btn-danger', 'escape' => false], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?>
        </div>
        <h3><?= h($category->name) ?></h3>
        <div class="table-responsive table-responsive-data2">
            <?php if (!empty($category->products)): ?>
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($category->products as $products): ?>
                    <tr>
                        <td><div class="image">
                            <img src="<?=$products->thumb; ?>" alt="<?= h($products->name) ?>">
                        </div></td>
                        <td>
                            <span class="status--process"><?= h($products->name) ?></span>
                            <div class="clearfix"></div>
                            <span class="block-email">Gmarket </span>
                        </td>
                        <td>
                            <?php
                                if (!empty($products->sell_price) && ($products->sell_price != $products->buy_price)):
                            ?>
                            <span class="status--process"><?= $this->Number->format($products->sell_price) ?><sup>đ</sup></span>
                            <span class="status--denied" style="text-decoration: line-through;"><?= $this->Number->format($products->buy_price) ?><sup>đ</sup></span>
                            <span class="block-email"><?=$products->discount_percent ?></span>
                            <?php
                                else:
                            ?>
                            <span class="status--process"><?= $this->Number->format($products->buy_price) ?><sup>đ</sup></span>
                            <?php
                                endif;
                            ?>
                        </td>
                        <td>
                            <div class="table-data-feature">
                                <?= $this->Html->link(__('<i class="zmdi zmdi-edit"></i>'), ['action' => 'edit', $products->id], ['class' => 'btn btn-xs btn-warning', 'escapeTitle' => false]) ?>
                                <?= $this->Form->postLink(__('<i class="zmdi zmdi-delete"></i>'), ['action' => 'delete', $products->id], ['confirm' => __('Are you sure you want to delete # {0}?', $products->id), 'class' => 'btn btn-xs btn-danger', 'escapeTitle' => false]) ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>