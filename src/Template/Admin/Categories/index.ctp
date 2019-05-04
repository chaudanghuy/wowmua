<div class="row">
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <h3 class="title-5 m-b-35">Danh mục (Trang <?php echo $this->Paginator->counter(); ?>)</h3>
        <div class="table-data__tool">
            <div class="table-data__tool-left">
            </div>
            <div class="table-data__tool-right">
                <button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="window.location.replace('/admin/categories/add')">
                <i class="zmdi zmdi-plus"></i>Tạo mới</button>
            </div>
        </div>
        <div class="table-responsive table-responsive-data2">
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>
                            <label class="au-checkbox">
                                <input type="checkbox">
                                <span class="au-checkmark"></span>
                            </label>
                        </th>
                        <th><?= $this->Paginator->sort('name', 'Tên <i class="fas fa-sort"></i>', ['escape' => false]) ?></th>
                        <th><?= $this->Paginator->sort('created', 'Ngày tạo <i class="fas fa-sort"></i>', ['escape' => false]) ?></th>
                        <th>Nguồn cào</th>
                        <th class="actions"><i class="fas fa-users-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                    <tr class="tr-shadow">
                        <td>
                            <label class="au-checkbox">
                                <input type="checkbox">
                                <span class="au-checkmark"></span>
                            </label>
                        </td>
                        <td>
                            <span class="status--process"><?= h($category->name) ?></span>
                            <div class="clearfix"></div>
                        </td>
                        <td>
                            <?=$category->created; ?>
                        </td>
                        <td>
                            <span class="status--process"><?=substr($category->crawl_url, 0, 20)."..."; ?></span>
                        </td>
                        <td>
                            <div class="table-data-feature">
                                <?= $this->Html->link(__('<i class="zmdi zmdi-edit"></i>'), ['action' => 'edit', $category->id], ['class' => 'btn btn-xs btn-warning', 'escapeTitle' => false]) ?>
                                <?= $this->Form->postLink(__('<i class="zmdi zmdi-delete"></i>'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id), 'class' => 'btn btn-xs btn-danger', 'escapeTitle' => false]) ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <tr class="spacer"></tr>
            </tbody>
        </table>
        <div class="paginator">
        <ul class="pagination pull-right">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
    </div>
    </div>
</div>
</div>