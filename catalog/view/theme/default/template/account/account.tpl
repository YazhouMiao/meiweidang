<?php echo $header; ?>
<div class="vertical-margin-10 hidden-xs"></div>
<div class="container inner-bg">
  <?php if ($success) { ?>
  <div class="alert alert-success no-offset-xs"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <!-- 手机以外屏幕可见 TODO: -->
      
      <!-- 仅手机屏幕可见 -->
      <div class="list-group visible-xs-block account-xs no-offset-xs">
        <a class="list-group-item" href="<?php echo $edit; ?>"><i class="fa fa-user"></i> <?php echo $name; ?> <span class="reward"><?php if ($points) { ?><?php echo $text_reward; ?>:<?php echo $points; ?><?php } ?></span><i class="fa fa-angle-right pull-right"></i></a>
        <a class="list-group-item" href="<?php echo $address; ?>"><i class="fa fa-list-alt"></i> <?php echo $text_address; ?><i class="fa fa-angle-right pull-right"></i></a>
        <a class="list-group-item" href="<?php echo $order; ?>"><i class="fa fa-clock-o"></i> <?php echo $text_order; ?><i class="fa fa-angle-right pull-right"></i></a>
        <a class="list-group-item" href="<?php echo $wishlist; ?>"><i class="fa fa-star"></i> <?php echo $text_wishlist; ?><i class="fa fa-angle-right pull-right"></i></a>
        <a class="list-group-item" href="<?php echo $return; ?>"><i class="fa fa-reply"></i> <?php echo $text_return; ?><i class="fa fa-angle-right pull-right"></i></a>
        <a class="list-group-item" href="<?php echo $transaction; ?>"><i class="fa fa-money"></i> <?php echo $text_transaction; ?><i class="fa fa-angle-right pull-right"></i></a>
        <a class="list-group-item" href="<?php echo $logout; ?>"><i class="fa fa-unlock-alt"></i> <?php echo $text_logout; ?><i class="fa fa-angle-right pull-right"></i></a>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>