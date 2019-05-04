<?php echo $this->Form->hidden('admin-order-index', ['id' => 'admin-order-index', 'value' => 1]); ?>
<div class="row">
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <h3 class="title-5 m-b-35">ĐƠN HÀNG</h3>
        <div class="table-data__tool">
            <div class="table-data__tool-left">
                <div class="rs-select2--light rs-select2--md">
                    <select class="js-select2" name="property" id="admin-product-filter">
                        <option selected="selected">--Tình trạng--</option>
                        <option value="direction=desc&sort=id">Chờ thanh toán</option>
                        <option value="direction=desc&sort=created">Đang xử lý</option>
                        <option value="direction=desc&sort=id">đã mua hàng</option>
                    </select>
                    <div class="dropDownSelect2"></div>
                </div>
            </div>
            <div class="table-data__tool-right">
                <button class="au-btn au-btn-icon au-btn--blue au-btn--small" onclick="window.location.replace('/admin/orders/add')">
                <i class="zmdi zmdi-plus"></i>Đơn hàng mới</button>
                <button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="window.location.replace('/admin/orders/export')">
                <i class="zmdi zmdi-download"></i>Tải Excel</button>
            </div>
        </div>
        <div class="table-responsive table-responsive-data2">
            <table class="table table-data2">
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <?php if (empty($order->purchases[0])) continue; ?>
                    <!-- Không xuất order có sản phẩm ở vị trí HOME -->
                    <?php $product = $this->Common->getProductInfoByProductId($order->purchases[0]->product_id); ?>
                    <?php if ($product->position == 'HOME') continue; ?>
                    <?php $total = 0; ?>
                    <tr>
                        <td>
                            <i class="zmdi zmdi-time"></i> <small><?=$order->created->format('d/m/Y H:i:s'); ?></small>
                            <pre><?php echo $this->Common->getDiffTime($order->created->format('Y-m-d')); ?></pre>
                            <h2><span class="badge badge-success"><?=$order->order_code?></span></h2>
                        </td>
                        <td>
                            <i class="zmdi zmdi-account"></i> <?= $order->has('user') ? $this->Html->link($order->user->first_name, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?> | <i class="zmdi zmdi-phone"></i> <?= h($order->user->phone) ?>
                            <br>
                            <span class="block-email">
                                <i class="zmdi zmdi-email"></i> <?= h($order->user->email) ?>
                            </span><br>
                            <i class="zmdi zmdi-home"></i> <?= h($order->user->address) ?><br>
                        </td>
                        <td>
                            <span><i class="zmdi zmdi-flight-takeoff"></i> <?php echo $order->from_location; ?></span>
                            &nbsp;&nbsp;&nbsp;
                            <span><i class="zmdi zmdi-flight-land"></i> <?php echo $order->to_location; ?></span>
                            <?php foreach ($order->purchases as $purchase) {
                            $product = $this->Common->getProductInfoByProductId($purchase->product_id);
                            $thumb = @getimagesize($product['thumb']) ? $product['thumb'] : 'https://via.placeholder.com/200x200?text=wowmua.com';
                            echo "<div class='media'>
                                <img id='myImg' class='align-self-start mr-3 img-thumbnail' src='{$thumb}' width='200px' alt=''>
                                <div class='media-body'>
                                    <span class='badge badge-primary'>". $product['name'] . "</span>
                                    <span class='pull-right'><a href=" . $order->request_url . " target='blank'>Link sản phẩm</a></span>
                                    <p>Giá SP : <span class='status--process'>".number_format($purchase->price)." " . $this->Common->getCurrency($order->from_location)."</span>
                                        <span class='status--process'> (<i class='zmdi zmdi-plus'></i>". number_format($purchase->quantity) .")</span>
                                        <br>
                                        Phí ship nội địa: <span class='status--process'>".$product['local_ship']." </span>
                                        <br>
                                        Trọng lượng: <span class='status--process'>".$product['weight']." </span>
                                        <br>
                                        Ghi chú: <span class='status--process'>".$product['note']." </span>
                                        <br>
                                        Giá (<sup>vnđ</sup>): <span class='status--process'>".number_format(round($product['calc_price']))." <sup>đ</sup> </span>
                                    </p>
                                    <p>
                                        Tình trạng: <strong>".$statuses[($order->status == 'REQUEST') ? 'UNPAID' : $order->status]."
                                    </p>
                                    <p class='input-group'>
                                        <input type='text' class='traveller form-control' data-order='{$order->id}' name='' value='{$order->traveller}' class='form-control' placeholder='Thông tin traveller'/>
                                    </p>
                                    <p class='input-group'>
                                        <input type='text' class='datepicker form-control' data-order='{$order->id}' name='' placeholder='Ngày giao hàng dự kiến'
                                            value='{$order->delivery_date}'/>
                                    </p>
                                </div>
                            </div>";
                            $total += $purchase->price;
                            } ?>
                        </td>
                        <td>
                            <?php echo $this->Form->input('status', ['label' => false, 'options' => $statuses, 'type' => 'select', 'default' => $order->status, 'class' => 'status', 'data-id' => $order->id]); ?>
                            <div class="table-data-feature">
                                <?= $this->Html->link(__('<i class="zmdi zmdi-edit"></i>'), ['action' => 'edit', $order->id], ['class' => 'btn btn-xs btn-warning', 'escapeTitle' => false]) ?>
                                &nbsp;&nbsp;
                                <?php echo $this->Form->postLink(__('<i class="zmdi zmdi-delete"></i>'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete # {0}?', $order->id), 'class' => 'btn btn-xs btn-danger', 'escapeTitle' => false]) ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
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
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- The Close Button -->
  <span class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>