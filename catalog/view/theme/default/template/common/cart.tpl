<div id="cart" class="btn-group btn-block">
  <button type="button" data-toggle="dropdown" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-inverse btn-block btn-lg dropdown-toggle"><i class="fa fa-shopping-cart"></i> <span id="cart-total"><?php echo $text_items; ?></span></button>
  <ul class="dropdown-menu pull-right">
    <?php if ($products || $vouchers) { ?>
    <li>
      <table class="table table-hover table-condensed">
        <?php foreach ($products as $product) { ?>
        <tr>
          <td class="text-center" style="width:15%;"><?php if ($product['thumb']) { ?>
            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
            <?php } ?></td>
          <td class="text-left" style="width:50%;"><?php echo $product['name']; ?>
            <?php if ($product['option']) { ?>
            <br />
            (<?php foreach ($product['option'] as $option) { ?>
            <small><?php echo $option['value']; ?></small> 
            <?php } ?>)
            <?php } ?>
            <?php if ($product['recurring']) { ?>
            <br />
            <?php } ?></td>
          <td class="text-center" style="width:10%;"><b><?php echo $product['quantity']; ?></b><?php echo $text_unit; ?></td>
          <td class="text-center color-orange" style="width:15%;"><b><?php echo $product['total']; ?></b></td>
          <td class="text-center" style="width:10%;"><a class="text-danger" href="javascript:cart.remove('<?php echo $product['key']; ?>');" title="<?php echo $button_remove; ?>">删除</a></td>
        </tr>
        <?php } ?>
        <?php foreach ($vouchers as $voucher) { ?>
        <tr class="info">
          <td class="text-center"></td>
          <td class="text-left"><?php echo $voucher['description']; ?></td>
          <td class="text-right">x&nbsp;1</td>
          <td class="text-right"><?php echo $voucher['amount']; ?></td>
          <td class="text-center text-danger"><button type="button" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>
        </tr>
        <?php } ?>
      </table>
    </li>
    <li>
      <div>
        <button class="pull-right"><a href="<?php echo $cart; ?>"><strong><i class="fa fa-shopping-cart"></i> <?php echo $text_cart; ?></strong></a></button>
      </div>
    </li>
    <?php } else { ?>
    <li>
      <p class="text-center"><?php echo $text_empty; ?></p>
    </li>
    <?php } ?>
  </ul>
</div>
