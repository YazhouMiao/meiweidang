<?php echo $header; ?>
<div class="container">
  <?php if ($success) { ?>
  <div class="alert alert-success no-offset-xs"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if (!empty($error)) { ?>
    <?php if (!empty($error['order'])) { ?>
    <div class="alert alert-danger no-offset-xs"><i class="fa fa-exclamation-circle"></i> <?php echo $error['order']; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if (!empty($error['permission'])) { ?>
    <div class="alert alert-danger no-offset-xs"><i class="fa fa-exclamation-circle"></i> <?php echo $error['permission']; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if (!empty($error['status'])) { ?>
    <div class="alert alert-danger no-offset-xs"><i class="fa fa-exclamation-circle"></i> <?php echo $error['status']; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
  <?php } ?>
    <div id="content">
      <h3><?php echo $heading_title; ?></h3>
      <div class="pull-right"><a href="<?php echo $task_list; ?>"><?php echo $button_task_list; ?></a></div>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left" colspan="2"><?php echo $text_order_detail; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left" style="width: 50%;">
              <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?><br />
              <b><?php echo $text_invoice; ?></b> <?php echo $invoice; ?><br />
              <b><?php echo $text_payment_status; ?></b> <?php echo $payment_status; ?></td>
            <td class="text-left">
              <?php if ($shipping_method) { ?>
              <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?><br />
              <?php } ?>
              <?php if ($delivery_info) { ?>
              <b><?php echo $text_delivery_status; ?></b> <?php echo $delivery_info['status']; ?>
              <?php } ?></td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <?php if ($payment_address) { ?>
            <td class="text-left" style="width: 100%;"><?php echo $text_payment_address; ?>
            </td>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left">
              <?php echo $payment_address; ?><br />
              <b><?php echo $text_telephone; ?></b> <a href="tel:<?php echo $customer_telephone; ?>" ><?php echo $customer_telephone; ?></a>
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left" colspan="2"><?php echo $text_products; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach($products as $business){ ?>
          <tr>
            <td class="text-left" style="width: 50%;">
              <b><?php echo $text_business_name; ?></b> <?php echo $business[0]['business_name']; ?><br />
              <b><?php echo $text_business_address; ?></b> <?php echo $business[0]['business_address']; ?><br />
              <b><?php echo $text_business_telephone; ?></b> <a href="tel:<?php echo $business[0]['business_telephone']; ?>" ><?php echo $business[0]['business_telephone']; ?></a></td>
            <td class="text-left">
              <?php foreach ($business as $product) { ?>
                <?php echo $product['name']; ?>
                <?php foreach ($product['option'] as $option) { ?>
                <br />
                &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                <?php } ?><br />
                <b><?php echo $text_model; ?></b><?php echo $product['model']; ?><br />
                <b><?php echo $text_quantity; ?></b><?php echo $product['quantity']; ?><?php echo $text_unit; ?><br />
                <b><?php echo $text_price; ?></b><?php echo $product['price']; ?><br />
                <b><?php echo $text_total; ?></b><?php echo $product['total']; ?><br />
                <br />
              <?php } ?>
            </td>
          </tr>
          <?php } ?>
        </tbody>
        <tfoot>
            <?php foreach ($totals as $total) { ?>
            <tr>
              <td colspan="2" class="text-right"><b><?php echo $total['title']; ?>：</b><?php echo $total['text']; ?></td>
            </tr>
            <?php } ?>
            <?php if ($comment) { ?>
            <tr>
              <td class="text-left"><b><?php echo $text_comment; ?></b><?php echo $comment; ?></td>
            </tr>
            <?php } ?>
          </tfoot>
      </table>
      <div class="buttons clearfix">
        <?php if ($delivery_status == 0) { ?>
            <div class="col-xs-4"><a href="<?php echo $got; ?>" class="btn btn-primary btn-lg"><?php echo $button_got; ?></a></div>
            <div class="col-xs-4"><a href="<?php echo $delivered; ?>" class="btn btn-primary btn-lg"><?php echo $button_delivered; ?></a></div>
            <div class="col-xs-4"><a href="<?php echo $returned; ?>" class="btn btn-primary btn-lg"><?php echo $button_returned; ?></a></div>
        <?php } else if ($delivery_status == 1) { ?>
            <div class="col-xs-6"><a href="<?php echo $delivered; ?>" class="btn btn-primary btn-lg"><?php echo $button_delivered; ?></a></div>
            <div class="col-xs-6"><a href="<?php echo $returned; ?>" class="btn btn-primary btn-lg"><?php echo $button_returned; ?></a></div>
        <?php } ?>
      </div>
   </div>
</div>
<?php echo $footer; ?>