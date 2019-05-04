<?php use Cake\Routing\Router; ?>
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div style="font-weight: bold; font-size: 20px">Kết quả cho tìm kiếm với "<?=$q; ?>"</div>
         <div class="clearfix">&nbsp;</div>
         <div class="row">
            <?php foreach($products as $product): ?>
            <div class="col-sm-3">
               <article class="col-item">
                  <div class="photo">
                     <div class="options-cart-round">
                        <button class="btn btn-default" title="Add to cart">
                        <span class="fa fa-shopping-cart"></span>
                        </button>
                     </div>
                     <div class="item">
                        <a href="#">
                           <?= ($product['discount_percent']) ? '<span class="notify-badge">' . $product['discount_percent'] . '</span>' : '' ?>
                           <?= $this->Html->image($product['thumb'], ['url' => ['action' => 'view', $product['id']]]) ?>
                        </a>
                     </div>
                  </div>
                  <div class="info">
                     <div class="row">
                        <div class="col-md-10 text-center">
                           <small><?=substr($product['name'], 0, 25) . ".."; ?></small>
                        </div>
                     </div>
                     <div class="row">
                        <div class="price-details col-md-6">
                           <div class="btn-add text-center">
                              <div class="rating text-center">
                                 <select class="rating-stars">
                                    <?php $i = 0; ?>
                                    <?php while ($i < 5): ?>
                                    <option value="<?= $i; ?>" <?= ($i == $product['rating']) ? "selected" : "" ?>><?= $i; ?></option>
                                    <?php $i++; ?>
                                    <?php endwhile; ?>
                                 </select>
                              </div>
                              <div class="text-center">
                                 <i class="fa fa-comments" aria-hidden="true"></i> <span class="fb-comments-count" data-href="<?=Router::url(['controller' => 'Products', 'action' => 'view/'.$product['id']], true) ?>"></span>
                              </div>
                           </div>
                           <p class="btn-details">
                              <div class="text-center">Kết thúc sau</div>
                              <div class="text-center">
                                 <div class="getting-started"></div>
                              </div>
                           </p>
                        </div>
                     </div>
                     <div class="separator clear-left">
                        <div class="price-details col-md-6">
                           <div class="row">
                              <div class="col-md-5">
                                 <p class="details" style="text-decoration: line-through; margin-top: 12px; margin-left: 5px; color: #C0C0C0;">
                                    <?= number_format($product['buy_price']) ?> <sup>đ</sup>
                                 </p>
                              </div>
                              <div class="col-md-6" style="margin-right: 20px">
                                 <p style="color: #23487b; font-size: 16px"><?= number_format($product['sell_price']) ?> <sup>đ</sup></p>
                              </div>
                           </div>
                           <span class="text-center">Mua <a href="#">sản phẩm</a> tại <a href="#">Gmarket</a></span>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
               </article>
            </div>
            <?php endforeach; ?>
         </div>
         <div class="row">
            <div class="col-md-12">
               <ul class="pagination pull-right">
                  <!-- <?= $this->Paginator->prev('< ' . __('previous')) ?> -->
                  <?= $this->Paginator->numbers() ?>
                  <!-- <?= $this->Paginator->next(__('next') . ' >') ?> -->
               </ul>
               <!-- <p><?= $this->Paginator->counter() ?></p> -->
            </div>
         </div>
      </div>
   </div>
</div>