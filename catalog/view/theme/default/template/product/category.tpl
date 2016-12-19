<?php echo $header; ?>
<div class="vertical-margin-10 hidden-xs"></div>
<div class="container inner-bg">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <?php if ($categories) { ?>
      <div class="row">
        <div class="col-xs-12 select-item-bar">
          <div class="select-inner">
            <ul id="sub-category" class="filters">
                <li class="select-title"><?php echo $text_sub_category; ?>：</li>
                <?php foreach ($categories as $category) { ?>
                <li><a class="select" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                <?php } ?>
            </ul>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php if ($products) { ?>
        <?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-lg-6 col-md-6 col-sm-12 col-xs-12'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-lg-4 col-md-4 col-sm-6 col-xs-12'; ?>
        <?php } else { ?>
        <?php $class = 'col-lg-3 col-md-3 col-sm-6 col-xs-12'; ?>
        <?php } ?>
      <div class="row">
        <div class="col-sm-12">
          <ul id="input-sort" class="sorts no-offset-xs">
            <?php foreach ($sorts as $s) { ?>
            <?php if(strpos($s['value'],'p.date_available')===false){$xs_class='col-xs-2';}else{$xs_class='col-xs-4';} ?>
            <?php if ($s['value'] == $sort . '-' . $order) { ?>
            <li class="active col-sm-1 <?php echo $xs_class ?>"><a class="<?php echo strtolower($order); ?>" href="<?php echo $s['href']; ?>"><?php echo $s['text']; ?></a></li>
            <?php } else { ?>
            <li class="col-sm-1 <?php echo $xs_class ?>"><a href="<?php echo $s['href']; ?>"><?php echo $s['text']; ?></a></li>
            <?php } ?>
            <?php } ?>
            <li class="page-info pull-right hidden-xs"><?php echo $results; ?></li>
          </ul>
        </div>
      </div>
      <div class="row">
        <?php foreach ($products as $product) { ?>
        <div class="product-grid-list <?php echo $class; ?>">
          <div class="product-thumb <?php echo is_null($product['buyable']) ? 'product-off-sale' : ''; ?>" data-href="<?php echo $product['href']; ?>">
            <div class="image">
              <a href="<?php echo $product['href']; ?>">
                <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
                <?php if (is_null($product['buyable'])){ ?>
                  <div class="img-info-bottom unbuyable"><?php echo $text_unbuyable; ?></div>
                <?php } ?>
              </a>
            </div>
            <div class="caption">
              <div class="title"><?php echo $product['title']; ?></div>
              <div class="item clearfix">
                  <div class="name pull-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                  <?php if ($product['price']) { ?>
                  <div class="price pull-right">
                    <?php if (!$product['special']) { ?>
                    <?php echo $product['price']; ?>
                    <?php } else { ?>
                    <?php echo $product['special']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
              </div>
              <div class="item clearfix">
                <?php if ($product['rating']) { $width = round($product['rating'] / 5 * 72,0); ?>
                  <div class="rating pull-left">
                    <span class="star-rating pull-left">
                      <span class="star-score" style="width:<?php echo $width; ?>px"></span>
                    </span>
                    <span class="score-num pull-left"><?php echo $product['rating']; ?><?php echo $text_fen; ?></span>
                  </div>
                <?php } else { ?>
                  <div class="rating"><?php echo $text_no_review; ?></div>
                <?php } ?>
                <?php if ($product['special']) { ?>
                 <div class="price-old pull-right"><?php echo $product['price']; ?></div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } else { ?>
      <div class="vertical-margin-50"><h3><?php echo $text_empty; ?></h3></div>
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary btn-lg"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
// 点击进入产品详细页
$('.product-thumb').on('click',function(){
    if($(window).width() < 768) {
        location = $(this).data('href');
    }
});

$('.slide-menu').each(function(){
    var first = $(this).find("ul>li:first").offset();
    var last = $(this).find("ul>li .active:last").offset();
    var scrollX = last.left - first.left;
    var screen = $(window).width() - 50;
    if(scrollX >= screen){
        $(this).scrollLeft(scrollX);
    }
});

$('.slide-menu').hammer().on("panleft", function(ev){
    var scrollX = parseInt($(this).scrollLeft()) + 5;
    $(this).scrollLeft(scrollX);
});

$('.slide-menu').hammer().on("panright", function(ev){
    var scrollX = parseInt($(this).scrollLeft()) - 5;
    $(this).scrollLeft(scrollX);
});
//--></script>
<?php echo $footer; ?>
