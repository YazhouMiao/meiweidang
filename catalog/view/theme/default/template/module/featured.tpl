<h3><?php echo $heading_title; ?></h3>
<div class="row">
  <?php foreach ($products as $product) { ?>
  <div class="product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="product-thumb transition">
      <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
      <div class="caption">
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <div class="title"><?php echo $product['title']; ?></div>
        <?php if ($product['rating']) { $width = round($product['rating'] / 5 * 72,0); ?>
          <div class="rating clearfix">
          <span class="star-rating pull-left">
              <span class="star-score" style="width:<?php echo $width; ?>px"></span>
          </span>
          <span class="score-num pull-left"><?php echo $product['rating']; ?><?php echo $text_fen; ?></span>
          </div>
        <?php } else { ?>
          <div class="rating clearfix hidden-xs"></div>
        <?php } ?>
        <?php if ($product['price']) { ?>
        <p class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
          <?php } ?>
        </p>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
