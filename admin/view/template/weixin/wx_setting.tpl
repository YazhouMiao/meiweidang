<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-weixin" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if (isset($error['error_warning'])) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['error_warning']; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-weixin" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry_app_id"><?php echo $entry_app_id; ?></label>
            <div class="col-sm-10">
              <input type="text" name="weixin_app_id" value="<?php echo $weixin_app_id; ?>" placeholder="<?php echo $entry_placeholder; ?>" id="entry_app_id" class="form-control"/>
              <?php if ($error_app_id) { ?>
              <div class="text-danger"><?php echo $error_app_id; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry_app_secret"><?php echo $entry_app_secret; ?></label>
            <div class="col-sm-10">
              <input type="text" name="weixin_app_secret" value="<?php echo $weixin_app_secret; ?>" placeholder="<?php echo $entry_placeholder; ?>" id="entry_app_secret" class="form-control"/>
              <?php if ($error_app_secret) { ?>
              <div class="text-danger"><?php echo $error_app_secret; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry_token"><?php echo $entry_token; ?></label>
            <div class="col-sm-10">
              <input type="text" name="weixin_token" value="<?php echo $weixin_token; ?>" placeholder="<?php echo $entry_placeholder; ?>" id="entry_placeholder" class="form-control"/>
              <?php if ($error_token) { ?>
              <div class="text-danger"><?php echo $error_token; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry_EncodingAESKey"><?php echo $entry_EncodingAESKey; ?></label>
            <div class="col-sm-10">
              <input type="text" name="weixin_EncodingAESKey" value="<?php echo $weixin_EncodingAESKey; ?>" placeholder="<?php echo $entry_placeholder; ?>" id="entry_placeholder" class="form-control"/>
              <?php if ($error_EncodingAESKey) { ?>
              <div class="text-danger"><?php echo $error_EncodingAESKey; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-customer-group"><span data-toggle="tooltip" title="<?php echo $help_customer_group; ?>"><?php echo $entry_customer_group; ?></span></label>
            <div class="col-sm-10">
              <select name="weixin_customer_group_id" id="input-customer-group" class="form-control">
                <?php foreach ($customer_groups as $customer_group) { ?>
                <?php if ($customer_group['customer_group_id'] == $weixin_customer_group_id) { ?>
                <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-logging"><span data-toggle="tooltip" title="<?php echo $help_debug_logging; ?>"><?php echo $entry_debug; ?></span></label>
            <div class="col-sm-10">
              <select name="weixin_debug" id="input-logging" class="form-control">
                <?php if ($weixin_debug) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="weixin_status" id="input-status" class="form-control">
                <?php if ($weixin_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>