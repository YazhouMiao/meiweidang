<?php if(!empty($products)){ $counter = 0; ?>
<div class="global-title no-offset-xs inner-bg-xs"><span class="title"><i class="fa fa-volume-up"></i> <?php echo $heading_title; ?></span></div>
<div class="row">
  <?php foreach ($products as $product) { if($counter == 0){ $class='col-xs-12'; } else { $class='col-xs-6';} if($product['latest']&&$product['rating']){$style='margin-bottom:5px;';}else{$style='';} ?>
  <div class="product-grid col-lg-3 col-md-3 col-sm-6 product-recommend <?php echo $class; ?>" style="<?php echo $style; ?>">
    <div class="product-thumb transition inner-bg-xs">
      <div class="image">
        <a href="<?php echo $product['href']; ?>">
          <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
          <div class="img-info-left">
          <?php if(in_array('latest', $product['tags'])) { ?>
            <div class="tag tag-latest"><?php echo $text_tag_latest; ?></div>
          <?php } ?>
          <?php if(in_array('best_seller', $product['tags'])) { ?>
            <div class="tag tag-best-seller"><?php echo $text_tag_best_seller; ?></div>
          <?php } ?>
          <?php if(in_array('special', $product['tags'])) { ?>
            <div class="tag tag-special"><?php echo $text_tag_special; ?></div>
          <?php } ?>
          <?php if(in_array('best_review', $product['tags'])) { ?>
            <div class="tag tag-best-review"><?php echo $text_tag_best_review; ?></div>
          <?php } ?>
          </div>
        </a>
      </div>
      <div class="caption">
        <div class="title"><?php echo $product['title']; ?></div>
        <div class="clearfix">
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
        <div class="clearfix">
          <?php if ($product['latest']) { ?>
            <div class="latest pull-left"><?php echo $product['latest']; ?></div>
          <?php } else if($product['rating']) { $width = round($product['rating'] / 5 * 72,0); ?>
            <div class="rating pull-left" style="margin-right:10px;">
            <span class="star-rating pull-left">
              <span class="star-score" style="width:<?php echo $width; ?>px"></span>
            </span>
          </div>
          <?php } ?>
          <?php if($product['special']) { ?>
          <div class="price-old pull-right"> <?php echo $text_old_price; ?><?php echo $product['price']; ?></div>
          <?php } else if($product['sales']){ ?>
              <div class="sales"><?php echo $product['sales']; ?></div>
          <?php } ?>
        </div>
        <div class="clearfix">
        <?php if ($product['latest']&&$product['rating']) { $width = round($product['rating'] / 5 * 72,0); ?>
          <div class="rating pull-left" style="margin-right:10px;">
            <span class="star-rating pull-left">
              <span class="star-score" style="width:<?php echo $width; ?>px"></span>
            </span>
          </div>
        <?php } ?>
        <?php if ($product['special']&&$product['sales']) { ?>
          <div class="sales"><?php echo $product['sales']; ?></div>
        <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <?php $counter++; if($counter == 5)$counter=0;} ?>
</div>
<?php } ?>
