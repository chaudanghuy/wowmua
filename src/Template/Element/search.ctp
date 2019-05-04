<div class="row">
  <form method="POST" action="/products/search">
   <div class="col-md-12">
      <div class="form-group has-success has-feedback">
        <div class="input-group">
          <span class="input-group-addon">Tìm sản phẩm</span>
          <input type="text" class="form-control" id="inputGroupSuccess1" aria-describedby="inputGroupSuccess1Status" name="q">
        </div>
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
        <span id="inputGroupSuccess1Status" class="sr-only">(success)</span>
      </div>
   </div>
 </form>
</div>
<div class="row">
   <div class="col-md-12">
      <?php foreach($categories as $category): ?>
         <span class="label"><a href="/products/index/<?=$category['id'] ?>"><?=$category['name']; ?></a></span>
      <?php endforeach; ?>
   </div>
</div>