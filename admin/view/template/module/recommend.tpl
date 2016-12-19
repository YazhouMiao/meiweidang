<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-nav-bar" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-nav-bar" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-latest-limit"><?php echo $entry_latest_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="latest_limit" value="<?php echo $latest_limit; ?>" placeholder="<?php echo $holder_limit; ?>" id="input-latest-limit" class="form-control" />
              <?php if ($error_latest_limit) { ?>
              <div class="text-danger"><?php echo $error_latest_limit; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-latest-interval-day"><?php echo $entry_latest_interval_day; ?></label>
            <div class="col-sm-10">
              <select name="latest_interval_day" id="input-latest-interval-day" class="form-control">
                <?php if ($latest_interval_day == '7') { ?>
                <option value="7" selected="selected"><?php echo $text_one_week; ?></option>
                <option value="14"><?php echo $text_two_week; ?></option>
                <option value="30"><?php echo $text_one_month; ?></option>
                <?php } else if ($latest_interval_day == '14') { ?>
                <option value="7"><?php echo $text_one_week; ?></option>
                <option value="14" selected="selected"><?php echo $text_two_week; ?></option>
                <option value="30"><?php echo $text_one_month; ?></option>
                <?php } else if ($latest_interval_day == '30') { ?>
                <option value="7"><?php echo $text_one_week; ?></option>
                <option value="14"><?php echo $text_two_week; ?></option>
                <option value="30" selected="selected"><?php echo $text_one_month; ?></option>
                <?php } else { ?>
                <option value="7"><?php echo $text_one_week; ?></option>
                <option value="14"><?php echo $text_two_week; ?></option>
                <option value="30"><?php echo $text_one_month; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-special-limit"><?php echo $entry_special_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="special_limit" value="<?php echo $special_limit; ?>" placeholder="<?php echo $holder_limit; ?>" id="input-special-limit" class="form-control" />
              <?php if ($error_special_limit) { ?>
              <div class="text-danger"><?php echo $error_special_limit; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-best-seller-limit"><?php echo $entry_best_seller_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="best_seller_limit" value="<?php echo $best_seller_limit; ?>" placeholder="<?php echo $holder_limit; ?>" id="input-best-seller-limit" class="form-control" />
              <?php if ($error_best_seller_limit) { ?>
              <div class="text-danger"><?php echo $error_best_seller_limit; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-best-seller-interval-day"><?php echo $entry_best_seller_interval_day; ?></label>
            <div class="col-sm-10">
              <select name="best_seller_interval_day" id="input-best-seller-interval-day" class="form-control">
                <?php if ($best_seller_interval_day == '7') { ?>
                <option value="7" selected="selected"><?php echo $text_one_week; ?></option>
                <option value="14"><?php echo $text_two_week; ?></option>
                <option value="30"><?php echo $text_one_month; ?></option>
                <?php } else if ($best_seller_interval_day == '14') { ?>
                <option value="7"><?php echo $text_one_week; ?></option>
                <option value="14" selected="selected"><?php echo $text_two_week; ?></option>
                <option value="30"><?php echo $text_one_month; ?></option>
                <?php } else if ($best_seller_interval_day == '30') { ?>
                <option value="7"><?php echo $text_one_week; ?></option>
                <option value="14"><?php echo $text_two_week; ?></option>
                <option value="30" selected="selected"><?php echo $text_one_month; ?></option>
                <?php } else { ?>
                <option value="7"><?php echo $text_one_week; ?></option>
                <option value="14"><?php echo $text_two_week; ?></option>
                <option value="30"><?php echo $text_one_month; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-best-review-limit"><?php echo $entry_best_review_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="best_review_limit" value="<?php echo $best_review_limit; ?>" placeholder="<?php echo $holder_limit; ?>" id="input-best-review-limit" class="form-control" />
              <?php if ($error_best_review_limit) { ?>
              <div class="text-danger"><?php echo $error_best_review_limit; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-review-limit-score"><?php echo $entry_review_score_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="review_score_limit" value="<?php echo $review_score_limit; ?>" placeholder="<?php echo $holder_review_score_limit; ?>" id="input-review-limit-score" class="form-control" />
              <?php if ($error_review_score_limit) { ?>
              <div class="text-danger"><?php echo $error_review_score_limit; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
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