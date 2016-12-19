<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
<div class="product-review">
    <?php $width = round($review['rating'] / 5 * 72,0); ?>
    <div class="rating clearfix">
    <span class="star-rating pull-left">
        <span class="star-score" style="width:<?php echo $width; ?>px"></span>
    </span>
    <span class="score-num pull-left"><?php echo $review['rating']; ?><?php echo $text_fen; ?></span>
    </div>
    <div class="content"><?php echo $review['text']; ?></div>
    <div class="title clearfix">
      <div class="pull-left"><?php echo $review['author']; ?></div>
      <div class="pull-right"><?php echo $review['date_added']; ?></div>
    </div>
</div>
<?php } ?>
<div class="text-right"><?php echo $pagination; ?></div>
<?php } else { ?>
<p><?php echo $text_no_reviews; ?></p>
<?php } ?>
