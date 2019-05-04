<div class="row">
    <div class="col-md-12">
        <div class="table-responsive table-responsive-data2">
            <div class="pull-right">
                <?= $this->Html->link(__('<i class="far fa-edit"></i> Chỉnh sửa'), ['action' => 'edit', $order->id], ['class' => 'btn btn-primary', 'escape' => false]) ?>
                <?= $this->Form->postLink(__('<i class="far fa-trash-alt"></i> Xoá'), ['action' => 'delete', $order->id], ['class' => 'btn btn-danger', 'escape' => false], ['confirm' => __('Are you sure you want to delete # {0}?', $order->id)]) ?>
            </div>
            <div class="related">
                <h4><?= __('Chi tiết đơn hàng') ?></h4>
                <?php if (!empty($order->purchases)): ?>
                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th><?= __('Product') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order->purchases as $purchases): ?>
                        <?php $product = $this->Common->getProductInfoByProductId($purchases->product_id); ?>
                        <tr>
                            <td><?= h($product['name']) ?></td>
                            <td><?= number_format($purchases->price) ?><sup>đ</sup> <span class="block-email"><?= h($purchases->quantity) ?></span></td>
                            <td><?= date("d-m-Y H:i:s", strtotime($purchases->created)) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('<i class="fas fa-eye"></i>'), ['controller' => 'Purchases', 'action' => 'view', $purchases->id], ['class' => 'btn btn-xs btn-primary', 'escapeTitle' => false]) ?>
                                <?= $this->Html->link(__('<i class="zmdi zmdi-edit"></i>'), ['controller' => 'Purchases', 'action' => 'edit', $purchases->id], ['class' => 'btn btn-xs btn-warning', 'escapeTitle' => false]) ?>
                                <?= $this->Form->postLink(__('<i class="zmdi zmdi-delete"></i>'), ['controller' => 'Purchases', 'action' => 'delete', $purchases->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchases->id), 'class' => 'btn btn-xs btn-danger', 'escapeTitle' => false]) ?>
                            </td>
                        </tr>
                    </tbody>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>