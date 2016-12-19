<div id="nav-bar" class="row visible-xs-block fixed-to-bottom">
  <ul class="col-xs-12">
    <li class="col-xs-3 text-center <?php echo $home['status'] ? 'active' : ''; ?>"><a href="<?php echo $home['link']; ?>" title="<?php echo $category['title']; ?>"><i class="fa fa-home"></i></a></li>
    <li class="col-xs-3 text-center <?php echo $category['status'] ? 'active' : ''; ?>"><a href="<?php echo $category['link']; ?>" title="<?php echo $category['title']; ?>"><i class="fa fa-th-list"></i></a></li>
    <li class="col-xs-3 text-center <?php echo $cart['status'] ? 'active' : ''; ?>">
      <a href="<?php echo $cart['link']; ?>" title="<?php echo $cart['title']; ?>">
        <i class="fa fa-shopping-cart"></i>
        <?php if(!empty($cart_count)) { ?>
        <span class="label-cart badge"><?php echo $cart_count; ?></span>
        <?php } ?>
      </a>
    </li>
    <li class="col-xs-3 text-center <?php echo $account['status'] ? 'active' : ''; ?>"><a href="<?php echo $account['link']; ?>" title="<?php echo $account['title']; ?>"><i class="fa fa-user"></i></a></li>
  </ul>
</div>
<div id="nav-mask" class="hidden-sm hidden-md hidden-lg"></div>
