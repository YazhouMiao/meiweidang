<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-wxpay-native" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-wxpay-native" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-qrcode-size"><?php echo $entry_qrcode_size; ?></label>
            <div class="col-sm-10">
              <input type="text" name="wxpay_native_qrcode_size" value="<?php echo $wxpay_native_qrcode_size; ?>" id="input-qrcode-size" class="form-control" />
              <?php if ($error_qrcode_size) { ?>
                <div class="text-danger"><?php echo $error_qrcode_size; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-qrcode-margin"><?php echo $entry_qrcode_margin; ?></label>
            <div class="col-sm-10">
              <input type="text" name="wxpay_native_qrcode_margin" value="<?php echo $wxpay_native_qrcode_margin; ?>" id="input-qrcode-margin" class="form-control" />
              <?php if ($error_qrcode_margin) { ?>
                <div class="text-danger"><?php echo $error_qrcode_margin; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-qrcode-level"><?php echo $entry_qrcode_level; ?></label>
            <div class="col-sm-10">
              <select name="wxpay_native_qrcode_level" id="input-qrcode-level" class="form-control">
                <?php foreach($levels as $key => $value) { ?>
                <?php if ($value == $wxpay_native_qrcode_level) { ?>
                <option value="<?php echo $value; ?>" selected="selected"><?php echo $key; ?></option>
                <?php } else { ?>
                <option value="<?php echo $value; ?>"><?php echo $key; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_logo_image; ?></label>
            <div class="col-sm-10"><a href="" id="logo-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $logo_image; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="wxpay_native_logo" value="<?php echo $wxpay_native_logo; ?>" id="input-logo-image" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_qrcode_logo; ?></label>
            <div class="col-sm-10"><a href="" id="qrcode-logo-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $qrcode_logo_image; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="wxpay_native_qrcode_logo" value="<?php echo $wxpay_native_qrcode_logo; ?>" id="input-qrcode-logo-image" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
            <div class="col-sm-10">
              <select name="wxpay_native_order_status_id" id="input-order-status" class="form-control">
                <?php foreach($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $wxpay_native_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="wxpay_native_status" id="input-status" class="form-control">
                <?php if ($wxpay_native_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="wxpay_native_sort_order" value="<?php echo $wxpay_native_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
<?php echo $footer; ?>