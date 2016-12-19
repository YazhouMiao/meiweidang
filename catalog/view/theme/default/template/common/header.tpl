<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<!-- 页面在移动设备上不支持缩放 -->
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no" name="viewport" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src='catalog/view/javascript/mobile/tools.min.js'></script>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php echo $google_analytics; ?>
</head>
<body class="<?php echo $class; ?>">
<!-- 模式对话框 -->
<div class="modal" id="common-modal-dialog" tabindex="-1" role="dialog" aria-labelledby="commonModalContent">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="common-modal-container"></div>
  </div>
</div>
<nav id="top" >
  <div class="container">
    <div id="logo" class="nav pull-left">
      <?php if ($logo) { ?>
      <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" class="logo-img" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a>
      <?php } else { ?>
      <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
      <?php } ?>
    </div>
    <!-- 手机屏幕显示服务区 -->
    <?php if(isset($service_zone)) { ?>
    <div id="nav-service-zone-xs" class="nav nav-xs visible-xs-block">
      <a href="<?php echo $localisation_change_url; ?>">[<?php echo $service_zone['name']; ?>]</a>
    </div>
    <?php } ?>
    
    <!-- 手机以外显示 -->
    <div id="top-links" class="nav pull-right hidden-xs">
      <ul class="list-inline">
        <!-- 城市/服务区 -->
        <?php if(isset($service_zone)) { ?>
        <li id="nav-service-zone"><?php echo $text_localisation; ?><?php echo $service_zone['name']; ?> <span id="localisation-change">[<a href="<?php echo $localisation_change_url; ?>"><?php echo $text_localisation_change; ?></a>]</span></li>
        <?php } ?>
        <!-- 账户相关 -->
        <?php if ($logged) { ?>
        <li><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>"><?php echo $text_customer; ?></a> <a href="<?php echo $logout; ?>">[<?php echo $text_logout; ?>]</a>
        <?php } else { ?>
        <li>
          <a href="<?php echo $login; ?>"><?php echo $text_login; ?></a><span class="gap">|</span><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a>
        <?php } ?>
        </li>
        <!-- 二维码 -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-mobile-phone"></i> <span class="hidden-xs hidden-sm"><?php echo $text_phone; ?></span> <span class="caret"></span></a>
            <div class="dropdown-menu dropdown-menu-right qrcode text-center">
              <img src="<?php echo $wx_qrcode ?>" />
              <span class=""><?php echo $text_weixin; ?></span>
            </div>
        <li><a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"><i class="fa fa-heart"></i> <span class="hidden-xs hidden-sm"><?php echo $text_wishlist; ?></span></a></li>
        <!-- 购物车  -->
        <li class="nav-cart"><?php echo $cart; ?></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container"><?php echo $header_bottom ?></div>