<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-delivery-schedule" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-city"><?php echo $entry_city; ?></label>
            <div class="col-sm-10">
              <select name="city_id" id="input-city-group" class="form-control">
                <option value=""><?php echo $text_select ?></option>
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
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-service-zone"><?php echo $entry_service_zone; ?></label>
            <div class="col-sm-10">
              <select name="service_zone_id" id="input-service-zone-group" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($service_zones as $service_zone) { ?>
                <?php if ($service_zone['service_zone_id'] == $service_zone_id) { ?>
                <option value="<?php echo $service_zone['service_zone_id']; ?>" selected="selected"><?php echo $service_zone['service_zone_name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $service_zone['service_zone_id']; ?>"><?php echo $service_zone['service_zone_name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-delivery-area"><?php echo $entry_delivery_area; ?></label>
            <div class="col-sm-10">
              <select name="delivery_area_id" id="input-delivery-area-group" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($delivery_areas as $delivery_area) { ?>
                <?php if ($delivery_area['delivery_area_id'] == $delivery_area_id) { ?>
                <option value="<?php echo $delivery_area['delivery_area_id']; ?>" selected="selected"><?php echo $delivery_area['delivery_area_name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $delivery_area['delivery_area_id']; ?>"><?php echo $delivery_area['delivery_area_name']; ?></option>
                <?php } ?>
                <?php } ?>
                <?php if ($error_delivery_area) { ?>
                  <div class="text-danger"><?php echo $error_delivery_area; ?></div>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-start-date"><?php echo $entry_start_date; ?></label>
            <div class="col-sm-10">
              <input type="text" id="input_start_date" name="start_date" value="<?php echo $start_date; ?>" data-date-format="YYYY-MM-DD" id="input-start-date" class="form-control" />
              <?php if ($error_start_date) { ?>
                <div class="text-danger"><?php echo $error_start_date; ?></div>
              <?php } ?>
              <?php if ($error_start_end_date) { ?>
                <div class="text-danger"><?php echo $error_start_end_date; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-end-date"><?php echo $entry_end_date; ?></label>
            <div class="col-sm-10">
              <input type="text" id="input_end_date" name="end_date" value="<?php echo $end_date; ?>" data-date-format="YYYY-MM-DD" id="input-end-date" class="form-control" />
              <?php if ($error_end_date) { ?>
                <div class="text-danger"><?php echo $error_end_date; ?></div>
              <?php } ?>
              <?php if ($error_start_end_date) { ?>
                <div class="text-danger"><?php echo $error_start_end_date; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-start-time"><?php echo $entry_start_time; ?></label>
            <div class="col-sm-10">
              <input type="text" id="input_start_time" name="start_time" value="<?php echo $start_time; ?>" data-time-format="HH:mm" id="input-start-time" class="form-control" />
              <?php if ($error_start_time) { ?>
                <div class="text-danger"><?php echo $error_start_time; ?></div>
              <?php } ?>
              <?php if ($error_start_end_time) { ?>
                <div class="text-danger"><?php echo $error_start_end_time; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-end-time"><?php echo $entry_end_time; ?></label>
            <div class="col-sm-10">
              <input type="text" id="input_end_time" name="end_time" value="<?php echo $end_time; ?>" data-time-format="HH:mm" id="input-end-time" class="form-control" />
              <?php if ($error_end_time) { ?>
                <div class="text-danger"><?php echo $error_end_time; ?></div>
              <?php } ?>
              <?php if ($error_start_end_time) { ?>
                <div class="text-danger"><?php echo $error_start_end_time; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-delivery-staff"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <select name="delivery_staff_id" id="input-delivery-staff-group" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($delivery_staffs as $delivery_staff) { ?>
                <?php if ($delivery_staff['delivery_staff_id'] == $delivery_staff_id) { ?>
                <option value="<?php echo $delivery_staff['delivery_staff_id']; ?>" selected="selected"><?php echo $delivery_staff['delivery_staff_name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $delivery_staff['delivery_staff_id']; ?>"><?php echo $delivery_staff['delivery_staff_name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <?php if ($error_delivery_staff) { ?>
                <div class="text-danger"><?php echo $error_delivery_staff; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <?php } ?>
                <?php if (!$status && !is_null($status)) { ?>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="0"><?php echo $text_disabled; ?></option>
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
$('#input_start_date').datetimepicker({
    pickTime: false,
    format: 'YYYY-MM-DD'
});
$('#input_end_date').datetimepicker({
    pickTime: false,
    format: 'YYYY-MM-DD'
});
$('#input_start_time').datetimepicker({
    pickDate: false,
    format: 'HH:mm',
    minuteStepping: 30
});
$('#input_end_time').datetimepicker({
    pickDate: false,
    format: 'HH:mm',
    minuteStepping: 30
});
//--></script>
<script type="text/javascript"><!--
$('select[name=\'city_id\']').on('change', function() {
    if($('select[name=\'city_id\']').val() == ""){
        $('select[name=\'service_zone_id\']').html('<option value=""></option>');
        $('select[name=\'delivery_area_id\']').html('<option value=""></option>');
        return;
    }
    $.ajax({
        url: 'index.php?route=localisation/city/serviceZone&token=<?php echo $token; ?>&city_id=' + $('select[name=\'city_id\']').val(),
        dataType: 'json',
        success: function(json) {
            html = '<option value=""><?php echo $text_select; ?></option>';

            if (json['service_zone'] && json['service_zone'] != '') {
                for (i = 0; i < json['service_zone'].length; i++) {
                    html += '<option value="' + json['service_zone'][i]['service_zone_id'] + '">' + json['service_zone'][i]['service_zone_name'] + '</option>';
                }
            } else {
                html = '<option value=""><?php echo $text_none; ?></option>';
            }

            $('select[name=\'service_zone_id\']').html(html);
            $('select[name=\'delivery_area_id\']').html('<option value=""><?php echo $text_none; ?></option>');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
//--></script>
<script type="text/javascript"><!--
$('select[name=\'service_zone_id\']').on('change', function() {
    if ($('select[name=\'service_zone_id\']').val() == "") {
        $('select[name=\'delivery_area_id\']').html('<option value=""></option>');
        return;
    }
    $.ajax({
        url: 'index.php?route=localisation/service_zone/deliveryArea&token=<?php echo $token; ?>&service_zone_id=' + $('select[name=\'service_zone_id\']').val(),
        dataType: 'json',
        success: function(json) {
            html = '<option value="" selected="selected"><?php echo $text_select; ?></option>';

            if (json['delivery_area'] && json['delivery_area'] != '') {
                for (i = 0; i < json['delivery_area'].length; i++) {
                    html += '<option value="' + json['delivery_area'][i]['delivery_area_id'] + '">' + json['delivery_area'][i]['delivery_area_name'] + '</option>';
                }
            } else {
                html = '<option value="*"><?php echo $text_none; ?></option>';
            }

            $('select[name=\'delivery_area_id\']').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
//--></script>
<script type="text/javascript"><!--
$('select[name=\'service_zone_id\']').on('change', function() {
     if ($('select[name=\'service_zone_id\']').val() == "") {
        $('select[name=\'delivery_staff_id\']').html('<option value=""></option>');
        return;
    }
    $.ajax({
        url: 'index.php?route=delivery/staff/getStaffsByServiceZone&token=<?php echo $token; ?>&service_zone_id=' + $('select[name=\'service_zone_id\']').val(),
        dataType: 'json',
        success: function(json) {
            html = '<option value="" selected="selected"><?php echo $text_select; ?></option>';

            if (json['staffs'] && json['staffs'] != '') {
                for (i = 0; i < json['staffs'].length; i++) {
                    html += '<option value="' + json['staffs'][i]['delivery_staff_id'] + '">' + json['staffs'][i]['delivery_staff_name'] + '</option>';
                }
            } else {
                html = '<option value=""><?php echo $text_none; ?></option>';
            }

            $('select[name=\'delivery_staff_id\']').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
//--></script>
<?php echo $footer; ?> 
