<?php echo $this->Form->hidden("admin-product-index", ['id' => 'admin-product-index', 'value' => 1]); ?>
<div class="row">
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <h3 class="title-5 m-b-35">SẢN PHẨM</h3>
        <div class="table-data__tool">
            <div class="table-data__tool-left">
                <div class="rs-select2--light rs-select2--md">
                    <select class="js-select2" name="property" id="admin-product-filter">
                        <option selected="selected">--Lọc--</option>
                        <option value="direction=desc&sort=buy_price">Giá giảm dần</option>
                        <option value="direction=asc&sort=buy_price">Giá tăng dần</option>
                        <option value="direction=desc&sort=id">Mới tạo</option>
                    </select>
                    <div class="dropDownSelect2"></div>
                </div>
                <div class="rs-select2--light rs-select2--sm">
                    <select class="js-select2" name="time">
                        <option selected="selected">--Vị trí--</option>
                        <option value="">Trang chủ</option>
                        <option value="">Request</option>
                    </select>
                    <div class="dropDownSelect2"></div>
                </div>
                <button class="au-btn-filter">
                <i class="zmdi zmdi-filter-list"></i>Lọc nâng cao</button>
            </div>
            <div class="table-data__tool-right">
                <button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="window.location.replace('/admin/products/add')">
                <i class="zmdi zmdi-plus"></i>New item</button>
                <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                    <select class="js-select2" name="type">
                        <option selected="selected">Export</option>
                        <option value=""><i class="far fa-file-excel"></i> Excel</option>
                        <option value=""><i class="fas fa-file-pdf"></i> PDF</option>
                    </select>
                    <div class="dropDownSelect2"></div>
                </div>
            </div>
        </div>
        <div class="table-responsive table-responsive-data2">
            <table class="table table-data2">
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr class="tr-shadow" style="white-space: nowrap;">
                        <td>
                            <div class="image">
                                <img class="img-thumbnail img-responsive" src="<?=$product->thumb; ?>" alt="#" width="100px" height="100px">
                            </div>
                            <span class="status--process"><?= h($product->name) ?></span>
                            <div class="clearfix"></div>
                            <?php
                            // Get url host
                            $host = parse_url($product->crawl_url, PHP_URL_HOST);
                            if (!empty($host)) {
                            ?>
                            <span class="block-email">Nguồn cào: <a href="<?php echo $product->crawl_url; ?>"><?php echo $host; ?></a></span>
                            <?php } ?>
                        </td>
                        <td>
                            <i class="zmdi zmdi-time"></i> <?php echo $this->Common->getDiffTime($product->created); ?>
                        </td>
                        <td>
                            <?php
                            if (!empty($product->sell_price) && ($product->sell_price != $product->buy_price)):
                            ?>
                            <span class="status--process"><?= $this->Number->format($product->sell_price) ?><sup>đ</sup></span>
                            <span class="status--denied" style="text-decoration: line-through;"><?= $this->Number->format($product->buy_price) ?><sup>đ</sup></span>
                            <span class="block-email"><?=$product->discount_percent ?></span>
                            <?php
                            else:
                            ?>
                            <span class="status--process"><?= $this->Number->format($product->buy_price) ?><sup>đ</sup></span>
                            <?php
                            endif;
                            ?>
                        </td>
                        <td>
                            <?=$this->Form->select('position', $positions, ['default' => $product->position, 'class' => 'item-update-pos']); ?>
                        </td>
                        <td>
                            <div class="table-data-feature">
                                <?= $this->Html->link(__('<i class="zmdi zmdi-edit"></i>'), ['action' => 'edit', $product->id], ['class' => 'btn btn-xs btn-warning', 'escapeTitle' => false]) ?>
                                &nbsp;
                                <?= $this->Form->postLink(__('<i class="zmdi zmdi-delete"></i>'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id), 'class' => 'btn btn-xs btn-danger', 'escapeTitle' => false]) ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <tr class="spacer"></tr>
            </tbody>
        </table>
        <div class="card-body" style="display: flex; justify-content: center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?= $this->Paginator->prev('<< ') ?>
                    <?php echo $this->Paginator->numbers(); ?>
                    <?= $this->Paginator->next(' >>') ?>
                </ul>
            </nav>
        </div>        
    </div>
</div>
</div>