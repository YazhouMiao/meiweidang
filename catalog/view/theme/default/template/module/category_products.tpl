<?php if(!empty($category['products'])){ ?>
<div class="global-title no-offset-xs inner-bg-xs">
  <span class="title category-title" style="background-color:<?php echo $color; ?>"><?php echo $category['title']; ?></span>
  <div class="child"><a href="<?php echo $category['href']; ?>" style="color:<?php echo $color; ?>"><?php echo $text_all; ?> ></a></div>
  <?php $counter=0; ?>
  <?php foreach($category['children'] as $children) { ?>
    <?php if($counter<3) { ?>
      <div class="child"><a href="<?php echo $children['href']; ?>" style="color:<?php echo $color; ?>"><?php echo $children['name']; ?></a> | </div>
    <?php } else { ?>
      <div class="child hidden-xs"><a href="<?php echo $children['href']; ?>" style="color:<?php echo $color; ?>"><?php echo $children['name']; ?></a> | </div>
    <?php } ?>
  <?php $counter++;} ?>
</div>
<div class="row">
  <?php foreach ($category['products'] as $product) { ?>
  <div class="product-grid col-lg-3 col-md-3 col-sm-6 col-xs-6">
    <div class="product-thumb transition inner-bg-xs <?php echo is_null($product['buyable']) ? 'product-off-sale' : ''; ?>"  data-href="<?php echo $product['href']; ?>">
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
<div class="category-footer no-offset-xs"><a href="<?php echo $category['href']; ?>" style="color:<?php echo $color; ?>"><?php echo $text_more.$category['name']; ?> <i class="fa fa-hand-o-right"></i></a></div>
<?php } ?>