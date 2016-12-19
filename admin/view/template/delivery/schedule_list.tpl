<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-delivery-schedule').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-start-date"><?php echo $entry_start_date; ?></label>
                <input type="text" id="input_start_date" name="filter_start_date" value="<?php echo $filter_start_date; ?>" data-date-format="YYYY-MM-DD" id="input-start-date" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" id="input-name" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-end-date"><?php echo $entry_end_date; ?></label>
                <input type="text" id="input_end_date" name="filter_end_date" value="<?php echo $filter_end_date; ?>" data-date-format="YYYY-MM-DD" id="input-end-date" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-city"><?php echo $entry_city; ?></label>
                <select name="filter_city_id" id="input-city-group" class="form-control">
                  <option value="*"></option>
                  <?php foreach ($cities as $city) { ?>
                  <?php if ($city['city_id'] == $filter_city_id) { ?>
                  <option value="<?php echo $city['city_id']; ?>" selected="selected"><?php echo $city['city_name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $city['city_id']; ?>"><?php echo $city['city_name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-start-time"><?php echo $entry_start_time; ?></label>
                <input type="text" id="input_start_time" name="filter_start_time" value="<?php echo $filter_start_time; ?>" data-time-format="HH:mm" id="input-start-time" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-service-zone"><?php echo $entry_service_zone; ?></label>
                <select name="filter_service_zone_id" id="input-service-zone-group" class="form-control">
                  <option value="*" selected="selected"></option>
                  <?php if(!empty($service_zones))  { ?>
                    <?php foreach ($service_zones as $service_zone) { ?>
                      <?php if ($service_zone['service_zone_id'] == $filter_service_zone_id) { ?>
                      <option value="<?php echo $service_zone['service_zone_id']; ?>" selected="selected"><?php echo $service_zone['service_zone_name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $service_zone['service_zone_id']; ?>"><?php echo $service_zone['service_zone_name']; ?></option>
                      <?php } ?>
                    <?php } ?>
                  <?php } else { ?>
                    <option value="*" ><?php echo $text_none; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-end-time"><?php echo $entry_end_time; ?></label>
                <input type="text" id="input_end_time" name="filter_end_time" value="<?php echo $filter_end_time; ?>" data-time-format="HH:mm" id="input-end-time" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-delivery-area"><?php echo $entry_delivery_area; ?></label>
                <select name="filter_delivery_area_id" id="input-delivery-area-group" class="form-control">
                  <option value="*" selected="selected"></option>
                  <?php if(!empty($delivery_areas))  { ?>
                    <?php foreach ($delivery_areas as $delivery_area) { ?>
                      <?php if ($delivery_area['delivery_area_id'] == $filter_delivery_area_id) { ?>
                      <option value="<?php echo $delivery_area['delivery_area_id']; ?>" selected="selected"><?php echo $delivery_area['delivery_area_name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $delivery_area['delivery_area_id']; ?>"><?php echo $delivery_area['delivery_area_name']; ?></option>
                      <?php } ?>
                    <?php } ?>
                  <?php } else { ?>
                    <option value="*" ><?php echo $text_none; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
                <select name="filter_status" id="input-status" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!$filter_status && !is_null($filter_status)) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-offset-6 col-sm-3">
              <div class="form-group">
                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
              </div>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-delivery-schedule">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-center"><?php if ($sort == 'dsc.start_date') { ?>
                    <a href="<?php echo $sort_start_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_start_date; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_start_date; ?>"><?php echo $column_start_date; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php if ($sort == 'dsc.end_date') { ?>
                    <a href="<?php echo $sort_end_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_end_date; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_end_date; ?>"><?php echo $column_end_date; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php if ($sort == 'dsc.start_time') { ?>
                    <a href="<?php echo $sort_start_time; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_start_time; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_start_time; ?>"><?php echo $column_start_time; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php if ($sort == 'dsc.end_time') { ?>
                    <a href="<?php echo $sort_end_time; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_end_time; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_end_time; ?>"><?php echo $column_end_time; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php echo $column_service_zone; ?></td>
                  <td class="text-center"><?php if ($sort == 'da.delivery_area_name') { ?>
                    <a href="<?php echo $sort_delivery_area; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_delivery_area; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_delivery_area; ?>"><?php echo $column_delivery_area; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php if ($sort == 'ds.delivery_staff_name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php echo $column_telephone; ?></td>
                  <td class="text-center"><?php echo $column_city; ?></td>
                  <td class="text-center"><?php echo $column_status; ?></td>
                  <td class="text-center"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($delivery_schedules) { ?>
                <?php foreach ($delivery_schedules as $delivery_schdule) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($delivery_schdule['delivery_schedule_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $delivery_schdule['delivery_schedule_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $delivery_schdule['delivery_schedule_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-center"><?php echo $delivery_schdule['start_date']; ?></td>
                  <td class="text-center"><?php echo $delivery_schdule['end_date']; ?></td>
                  <td class="text-center"><?php echo $delivery_schdule['start_time']; ?></td>
                  <td class="text-center"><?php echo $delivery_schdule['end_time']; ?></td>
                  <td class="text-center"><?php echo $delivery_schdule['service_zone']; ?></td>
                  <td class="text-center"><?php echo $delivery_schdule['delivery_area']; ?></td>
                  <td class="text-center"><?php echo $delivery_schdule['name']; ?></td>
                  <td class="text-center"><?php echo $delivery_schdule['telephone']; ?></td>
                  <td class="text-center"><?php echo $delivery_schdule['city']; ?></td>
                  <td class="text-center"><?php echo $delivery_schdule['status']; ?></td>
                  <td class="text-center"><a href="<?php echo $delivery_schdule['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="10"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
    url = 'index.php?route=delivery/schedule&token=<?php echo $token; ?>';
    
    var filter_start_date = $('input[name=\'filter_start_date\']').val();
    
    if (filter_start_date) {
        url += '&filter_start_date=' + encodeURIComponent(filter_start_date);
    }

    var filter_end_date = $('input[name=\'filter_end_date\']').val();
    
    if (filter_end_date) {
        url += '&filter_end_date=' + encodeURIComponent(filter_end_date);
    }
    
    var filter_start_time = $('input[name=\'filter_start_time\']').val();
    
    if (filter_start_time) {
        url += '&filter_start_time=' + encodeURIComponent(filter_start_time);
    }
    
    var filter_end_time = $('input[name=\'filter_end_time\']').val();
    
    if (filter_end_time) {
        url += '&filter_end_time=' + encodeURIComponent(filter_end_time);
    }

    var filter_name = $('input[name=\'filter_name\']').val();
    
    if (filter_name) {
        url += '&filter_name=' + encodeURIComponent(filter_name);
    }
    
    var filter_city_id = $('select[name=\'filter_city_id\']').val();
    
    if (filter_city_id !='*') {
        url += '&filter_city_id=' + encodeURIComponent(filter_city_id);
    }
    
    var filter_service_zone_id = $('select[name=\'filter_service_zone_id\']').val();
    
    if (filter_service_zone_id != '*') {
        url += '&filter_service_zone_id=' + encodeURIComponent(filter_service_zone_id);
    }
    
    var filter_delivery_area_id = $('select[name=\'filter_delivery_area_id\']').val();
    
    if (filter_delivery_area_id != '*') {
        url += '&filter_delivery_area_id=' + encodeURIComponent(filter_delivery_area_id);
    }
    
    var filter_status = $('select[name=\'filter_status\']').val();
    
    if (filter_status != '*') {
        url += '&filter_status=' + encodeURIComponent(filter_status); 
    }   
    
    location = url;
});
//--></script> 
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
$('select[name=\'filter_city_id\']').on('change', function() {
    if($('select[name=\'filter_city_id\']').val() == "*"){
        $('select[name=\'filter_service_zone_id\']').html('<option value="*"></option>');
        $('select[name=\'filter_delivery_area_id\']').html('<option value="*"></option>');
        return;
    }
    $.ajax({
        url: 'index.php?route=localisation/city/serviceZone&token=<?php echo $token; ?>&city_id=' + $('select[name=\'filter_city_id\']').val(),
        dataType: 'json',
        beforeSend: function() { 
            $("#button-filter").attr("disabled","true");
        },
        complete: function() {
            $("#button-filter").removeAttr("disabled");
        },
        success: function(json) {
            html = '<option value="*"></option>';

            if (json['service_zone'] && json['service_zone'] != '') {
                for (i = 0; i < json['service_zone'].length; i++) {
                    html += '<option value="' + json['service_zone'][i]['service_zone_id'] + '">' + json['service_zone'][i]['service_zone_name'] + '</option>';
                }
            } else {
                html += '<option value="*"><?php echo $text_none; ?></option>';
            }

            $('select[name=\'filter_service_zone_id\']').html(html);
            $('select[name=\'filter_delivery_area_id\']').html('<option value="*" selected="selected"></option><option value="*"><?php echo $text_none; ?></option>');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
//--></script>
<script type="text/javascript"><!--
$('select[name=\'filter_service_zone_id\']').on('change', function() {
    if ($('select[name=\'filter_service_zone_id\']').val() == "*") {
        $('select[name=\'filter_delivery_area_id\']').html('<option value="*"></option>');
        return;
    }
    $.ajax({
        url: 'index.php?route=localisation/service_zone/deliveryArea&token=<?php echo $token; ?>&service_zone_id=' + $('select[name=\'filter_service_zone_id\']').val(),
        dataType: 'json',
        beforeSend: function() { 
            $("#button-filter").attr("disabled","true");
        },
        complete: function() {
            $("#button-filter").removeAttr("disabled");
        },
        success: function(json) {
            html = '<option value="*" selected="selected"></option>';

            if (json['delivery_area'] && json['delivery_area'] != '') {
                for (i = 0; i < json['delivery_area'].length; i++) {
                    html += '<option value="' + json['delivery_area'][i]['delivery_area_id'] + '">' + json['delivery_area'][i]['delivery_area_name'] + '</option>';
                }
            } else {
                html += '<option value="*"><?php echo $text_none; ?></option>';
            }

            $('select[name=\'filter_delivery_area_id\']').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
//--></script>
<?php echo $footer; ?> 
