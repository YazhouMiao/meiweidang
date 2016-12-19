<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-delivery-staff" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-service-zone" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-city"><?php echo $entry_city; ?></label>
            <div class="col-sm-10">
              <select name="city_id" id="input-city" class="form-control">
                <option value="" selected="selected"><?php echo $text_select; ?></option>
                <?php foreach ($cities as $city) { ?>
                  <?php if ($city['city_id'] == $city_id) { ?>
                  <option value="<?php echo $city['city_id']; ?>" selected="selected"><?php echo $city['city_name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $city['city_id']; ?>"><?php echo $city['city_name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-service-zone"><?php echo $entry_service_zone; ?></label>
            <div class="col-sm-10">
              <select name="service_zone_id" id="input-service-zone" class="form-control">
                <?php if(!empty($service_zones)){ ?>
                  <?php foreach ($service_zones as $service_zone) { ?>
                    <?php if ($service_zone['service_zone_id'] == $service_zone_id) { ?>
                    <option value="<?php echo $service_zone['service_zone_id']; ?>" selected="selected"><?php echo $service_zone['service_zone_name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $service_zone['service_zone_id']; ?>"><?php echo $service_zone['service_zone_name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                <?php  } else { ?>
                    <option value="" selected="selected"><?php echo $text_none; ?></option>
                <?php } ?>
              </select>
              <?php if ($error_service_zone) { ?>
              <div class="text-danger"><?php echo $error_service_zone; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
            <div class="col-sm-10">
              <input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
              <?php if ($error_telephone) { ?>
              <div class="text-danger"><?php echo $error_telephone; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-openid"><?php echo $entry_openid; ?></label>
            <div class="col-sm-10">
              <input type="text" name="openid" value="<?php echo $openid; ?>" placeholder="<?php echo $entry_openid; ?>" id="input-openid" class="form-control" />
              <?php if ($error_openid) { ?>
              <div class="text-danger"><?php echo $error_openid; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-amount"><?php echo $entry_amount; ?></label>
            <div class="col-sm-10">
              <input type="text" name="amount" value="<?php echo $amount; ?>" placeholder="<?php echo $entry_amount; ?>" id="input-amount" class="form-control" />
              <?php if ($error_amount) { ?>
              <div class="text-danger"><?php echo $error_amount; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-description"><span data-toggle="tooltip" data-container="#tab-general" title="<?php echo $help_description; ?>"><?php echo $entry_description; ?></span></label>
            <div class="col-sm-10">
              <textarea name="description" rows="5" placeholder="<?php echo $entry_description; ?>" id="input-description" class="form-control"><?php echo $description; ?></textarea>
              <?php if ($error_description) { ?>
              <div class="text-danger"><?php echo $error_description; ?></div>
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
<script type="text/javascript"><!--
$('select[name=\'city_id\']').on('change', function() {
    $.ajax({
        url: 'index.php?route=localisation/city/serviceZone&token=<?php echo $token; ?>&city_id=' + $('select[name=\'city_id\']').val(),
        dataType: 'json',
        beforeSend: function() {
            $('select[name=\'city_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
        },
        complete: function() {
            $('.fa-spin').remove();
        },
        success: function(json) {
            html = '';

            if (json['service_zone'] && json['service_zone'] != '') {
                for (i = 0; i < json['service_zone'].length; i++) {
                    html += '<option value="' + json['service_zone'][i]['service_zone_id'] + '">' + json['service_zone'][i]['service_zone_name'] + '</option>';
                }
            } else {
                html = '<option value="" selected="selected"><?php echo $text_none; ?></option>';
            }

            $('select[name=\'service_zone_id\']').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

//--></script>
<?php echo $footer; ?>