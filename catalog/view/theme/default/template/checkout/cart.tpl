<?php echo $header; ?>
<div class="vertical-margin-10 hidden-xs"></div>
<div class="container inner-bg">
  <?php if ($attention) { ?>
  <div class="alert alert-info no-offset-xs"><i class="fa fa-info-circle"></i> <?php echo $attention; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="alert alert-success no-offset-xs"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger no-offset-xs"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
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
      <h2><?php echo $heading_title; ?></h2>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <!-- 手机以外的大屏显示 -->
        <div class="table-checkout hidden-xs">
          <table class="table">
            <thead>
              <tr>
                <td class="text-center" colspan="2"><?php echo $column_name; ?></td>
                <td class="text-left"><?php echo $column_price; ?></td>
                <td class="text-left"><?php echo $column_quantity; ?></td>
                <td class="text-left"><?php echo $column_total; ?></td>
                <td class="text-center"><?php echo $column_operation; ?></td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product) { ?>
              <tr>
                <td class="text-left">
                  <a style="margin-left:50px;" href="<?php echo $product['href']; ?>">
                  <?php if ($product['thumb']) { ?>
                  <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" />
                  <?php } ?>
                  <?php echo $product['name']; ?>
                  <?php if (!$product['stock']) { ?>
                  <span class="text-danger">***</span>
                  <?php } ?>
                  </a>
                </td>
                <td class="text-left">
                  <?php if ($product['option']) { ?>
                  <?php foreach ($product['option'] as $option) { ?>
                  <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                  <br />
                  <?php } ?>
                  <?php } ?>
                  <?php if ($product['reward']) { ?>
                  <small><?php echo $product['reward']; ?></small>
                  <br />
                  <?php } ?>
                  <?php if ($product['recurring']) { ?>
                  <span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
                  <br />
                  <?php } ?>
                </td>
                <td class="text-left" id="sm-price-<?php echo $product['id']; ?>"><?php echo $product['price']; ?></td>
                <td class="text-left">
                  <div class="input-group sys_spec_text product-qty-btn">
                    <span class="input-group-btn">
                      <button type="button" onclick="cartEdit('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', false);" data-minimum="<?php echo $product['minimum']; ?>" data-toggle="tooltip" class="btn"><i class="fa fa-minus"></i></button>
                    </span>
                    <input type="text" readonly="true" name="quantity[<?php echo $product['key']; ?>]" data-minimum="<?php echo $product['minimum']; ?>" value="<?php echo $product['quantity']; ?>" id="input-quantity" />
                    <span class="input-group-btn pull-left">
                      <button type="button" onclick="cartEdit('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', true);" data-toggle="tooltip" class="btn"><i class="fa fa-plus"></i></button>
                    </span>
                  </div>
                </td>
                <td class="text-left" id="sm-total-<?php echo $product['id'] ?>"><?php echo $product['total']; ?></td>
                <td class="text-center"><a href="javascript:cart.remove('<?php echo $product['key']; ?>');"> <?php echo $text_remove; ?></a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- 手机等小屏显示 -->
        <div class="checkout-xs visible-xs-block">
            <?php foreach ($products as $product) { ?>
                <div class="item-title no-offset-xs clearfix">
                  <span class="pull-left item-name">
                  <h3><?php echo $product['name']; ?></h3>
                  <?php if (!$product['stock']) { ?>
                    <span class="text-danger">***</span>
                  <?php } ?>
                  </span>
                  <span class="pull-right item-remove">
                  <h3><a href="javascript:;" onclick="cart.remove('<?php echo $product['key']; ?>');"> <i class="fa fa-trash-o"></i></a></h3>
                  </span>       
                </div>
                <?php if ($product['option']) { ?>
                <div class="item-option text-left clearfix">
                  <?php foreach ($product['option'] as $option) { ?>
                  <small><?php echo $option['name']; ?>:<?php echo $option['value']; ?>;</small>
                  <?php } ?>
                </div>
                <?php } ?>
                <div class="item-price clearfix">
                  <span class="pull-left"><?php echo $column_price; ?></span>
                  <span class="pull-right" id="xs-price-<?php echo $product['id']; ?>"><?php echo $product['price']; ?></span>
                </div>
                <div class="clearfix">
                  <span class="control-label pull-left" style="margin-top:7px;" for="input-quantity"><?php echo $column_quantity; ?></span>
                  <div class="pull-right">
                      <div class="input-group sys_spec_text product-qty-btn">
                        <span class="input-group-btn">
                          <button type="button" onclick="cartEdit('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', false);" data-minimum="<?php echo $product['minimum']; ?>" data-toggle="tooltip" class="btn"><i class="fa fa-minus"></i></button>
                        </span>
                        <input type="text" readonly="true" name="quantity[<?php echo $product['key']; ?>]" data-minimum="<?php echo $product['minimum']; ?>" value="<?php echo $product['quantity']; ?>" id="input-quantity" class="product-qty-input" />
                        <span class="input-group-btn pull-left">
                          <button type="button" onclick="cartEdit('<?php echo $product['id']; ?>', '<?php echo $product['key']; ?>', true);" data-toggle="tooltip" class="btn"><i class="fa fa-plus"></i></button>
                        </span>
                      </div>
                  </div>
                </div>
                <div class="item-total clearfix">
                  <span class="pull-left"><?php echo $column_total; ?></span>
                  <span id="xs-total-<?php echo $product['id'] ?>" class="pull-right"><?php echo $product['total']; ?></span>
                </div>
            <?php } ?>
         </div>
      </form>
      <?php if ($coupon || $voucher || $reward || $shipping) { ?>
      <div class="row">
        <div class="col-sm-4 col-sm-offset-8">
          <div class="panel-group" id="accordion"><?php echo $reward; ?><?php echo $coupon; ?><?php echo $voucher; ?></div>
        </div>
      </div>
      <?php } ?>
      <div class="row">
        <div id="checkout-totals" class="col-sm-4 pull-right text-right"><?php echo $totals; ?></div>
      </div>
      <div class="buttons checkout-btn clearfix">
        <div class="pull-right"><button id="checkout-button" class="btn btn-primary btn-lg"><?php echo $button_checkout; ?></button></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
function cartEdit(id, key, flag) {
    // 价格/总计联动
    var symbol_left = '<?php echo $symbol_left; ?>';
    var price = $("#xs-price-"+id).text().replace(symbol_left,'').replace(/,/g,'');
    var total = $("#xs-total-"+id).text().replace(symbol_left,'').replace(/,/g,'');
    var minimum = $("input[name='quantity[" + key + "]']").data('minimum');
    var quantity = $("input[name='quantity[" + key + "]']").val();
    
    if(flag){
        total = Number(total) + Number(price);
        quantity = Number(quantity) + 1;
    } else if(!flag && (quantity > minimum)){
        total = Number(total) - Number(price);
        quantity = Number(quantity) - 1;
    } else {
        return;
    }
    
    $("input[name='quantity[" + key + "]']").val(quantity);
    var totalStr = symbol_left + formatMoney(total);
    $("#xs-total-"+id).text(totalStr);
    $("#sm-total-"+id).text(totalStr);

    cart.edit(key, quantity);
}

// 如果没有登录,弹出登录对话框
$('#checkout-button').click(function() {
    <?php if (!$logged) { ?>
        $.ajax({
            url: 'index.php?route=checkout/login',
            dataType: 'html',
            success: function(html) {
                $('.modal-dialog').addClass('modal-sm');
                $('#common-modal-container').html(html);
                $('#common-modal-dialog').modal({backdrop:'static'});
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    <?php } else { ?>
        location = '<?php echo $checkout; ?>';
    <?php } ?>
});

//--></script>
<?php echo $footer; ?>