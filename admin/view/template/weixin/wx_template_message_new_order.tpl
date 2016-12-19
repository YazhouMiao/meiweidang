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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_new_order_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-weixin" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="entry_new_order_deliverer_template_id"><?php echo $entry_new_order_deliverer_template_id; ?></label>
            <div class="col-sm-9">
              <input type="text" name="weixin_new_order_deliverer_template_id" value="<?php echo $weixin_new_order_deliverer_template_id; ?>" id="entry_new_order_deliverer_template_id" class="form-control"/>
              <?php if ($error_new_order_deliverer_template_id) { ?>
              <div class="text-danger"><?php echo $error_new_order_deliverer_template_id; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="entry_new_order_deliverer_url"><?php echo $entry_new_order_deliverer_url; ?></label>
            <div class="col-sm-9">
              <input type="text" name="weixin_new_order_deliverer_url" value="<?php echo $weixin_new_order_deliverer_url; ?>" id="entry_new_order_deliverer_url" class="form-control"/>
              <?php if ($error_new_order_deliverer_url) { ?>
              <div class="text-danger"><?php echo $error_new_order_deliverer_url; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="entry_new_order_business_template_id"><?php echo $entry_new_order_business_template_id; ?></label>
            <div class="col-sm-9">
              <input type="text" name="weixin_new_order_business_template_id" value="<?php echo $weixin_new_order_business_template_id; ?>" id="entry_new_order_business_template_id" class="form-control"/>
              <?php if ($error_new_order_business_template_id) { ?>
              <div class="text-danger"><?php echo $error_new_order_business_template_id; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-3 control-label" for="entry_new_order_business_url"><?php echo $entry_new_order_business_url; ?></label>
            <div class="col-sm-9">
              <input type="text" name="weixin_new_order_business_url" value="<?php echo $weixin_new_order_business_url; ?>" id="entry_new_order_business_url" class="form-control"/>
              <?php if ($error_new_order_business_url) { ?>
              <div class="text-danger"><?php echo $error_new_order_business_url; ?></div>
              <?php } ?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>