<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-alipay" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-alipay" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-seller_email"><?php echo $entry_seller_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="alipay_seller_email" value="<?php echo $alipay_seller_email; ?>" placeholder="<?php echo $entry_seller_email_holder; ?>" id="input-seller_email" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-partner"><?php echo $entry_partner; ?></label>
            <div class="col-sm-10">
              <input type="text" name="alipay_partner" value="<?php echo $alipay_partner; ?>" placeholder="<?php echo $entry_partner_holder; ?>" id="input-partner_holder" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-security_code"><?php echo $entry_security_code; ?></label>
            <div class="col-sm-10">
              <input type="text" name="alipay_security_code" value="<?php echo $alipay_security_code; ?>" placeholder="<?php echo $entry_security_code_holder; ?>" id="input-security_code" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_logo_image; ?></label>
            <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="alipay_logo" value="<?php echo $alipay_logo; ?>" id="input-image" />
            </div>
          </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
<?php echo $footer; ?>