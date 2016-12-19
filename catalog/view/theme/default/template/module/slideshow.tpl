<div class="no-offset-xs">
  <div id="slideshow" class="owl-carousel owl-theme owl-loaded">
    <?php foreach($banners as $banner){ ?>
    <div class="item">
      <?php if ($banner['link']) { ?>
        <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="slide-img-height"/></a>
        <?php } else { ?>
        <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
      <?php } ?>
    </div>
    <?php } ?>
  </div>
</div>

<script type="text/javascript"><!--
  var flag = <?php echo count($banners); ?>;
  $("#slideshow").owlCarousel({
      items: 1,
      loop: flag == 1 ? false : true,
      margin: 0,
      nav: false,
      autoplay: true,
      autoplayTimeout: 3000,
      autoplayHoverPause: true,
      center: true,
      autoplaySpeed: 750,
      smartSpeed: 10
  });
//--></script>