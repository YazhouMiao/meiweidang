<?php echo $header; ?>
<div class="vertical-margin-10 hidden-xs"></div>
<div class="container inner-bg">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"> <?php echo $content_top; ?>
      <div class="panel panel-success no-offset-xs" id="panel-address">
        <div class="panel-heading">
          <h4 class="panel-title"><i class="fa fa-list-alt"></i> <?php echo $text_edit_address; ?> <?php if ($default) { ?>-- <?php echo $text_default; } ?> <?php if(isset($delete)){ ?><a class="pull-right visible-xs-block" href="<?php echo $delete; ?>"><i class="fa fa-trash-o"></i></a><?php } ?></h4>
        </div>
        <div class="panel-collapse collapse in" id="collapse-address">
          <div class="panel-body">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <fieldset>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_firstname; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
                  <?php if ($error_firstname) { ?>
                  <div class="text-danger"><?php echo $error_firstname; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group  required">
                <label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-company"><?php echo $entry_company; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="company" value="<?php echo $company; ?>" placeholder="<?php echo $entry_company; ?>" id="input-company" class="form-control" />
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-city"><?php echo $entry_city; ?></label>
                <div class="col-sm-10">
                  <select name="city_id" id="input-city" class="form-control">
                    <?php foreach ($cities as $city) { ?>
                      <?php if ($city['city_id'] == $city_id) { ?>
                      <option value="<?php echo $city['city_id']; ?>" selected="selected"><?php echo $city['city_name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $city['city_id']; ?>"><?php echo $city['city_name']; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if ($error_city) { ?>
                  <div class="text-danger"><?php echo $error_city; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-service-zone"><?php echo $entry_service_zone; ?></label>
                <div class="col-sm-10">
                  <select name="service_zone_id" id="input-service-zone" class="form-control">
                    <option value="" selected="selected"><?php echo $text_select; ?></option>
                    <?php foreach ($service_zones as $service_zone) { ?>
                      <?php if ($service_zone['service_zone_id'] == $service_zone_id) { ?>
                      <option value="<?php echo $service_zone['service_zone_id']; ?>" selected="selected"><?php echo $service_zone['service_zone_name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $service_zone['service_zone_id']; ?>"><?php echo $service_zone['service_zone_name']; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if ($error_service_zone) { ?>
                  <div class="text-danger"><?php echo $error_service_zone; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-delivery-area"><?php echo $entry_delivery_area; ?></label>
                <div class="col-sm-10">
                  <select name="delivery_area_id" id="input-delivery-area" class="form-control">
                    <option value="" selected="selected"><?php echo $text_select; ?></option>
                    <?php foreach ($delivery_areas as $delivery_area) { ?>
                      <?php if ($delivery_area['delivery_area_id'] == $delivery_area_id) { ?>
                      <option value="<?php echo $delivery_area['delivery_area_id']; ?>" selected="selected"><?php echo $delivery_area['delivery_area_name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $delivery_area['delivery_area_id']; ?>"><?php echo $delivery_area['delivery_area_name']; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if ($error_delivery_area) { ?>
                  <div class="text-danger"><?php echo $error_delivery_area; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-address-1"><?php echo $entry_address_1; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="address_1" value="<?php echo $address_1; ?>" placeholder="<?php echo $text_address_holder; ?>" id="input-address-1" class="form-control" />
                  <?php if ($error_address_1) { ?>
                  <div class="text-danger"><?php echo $error_address_1; ?></div>
                  <?php } ?>
                </div>
              </div>
              <?php foreach ($custom_fields as $custom_field) { ?>
              <?php if ($custom_field['location'] == 'address') { ?>
              <?php if ($custom_field['type'] == 'select') { ?>
              <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
                <div class="col-sm-10">
                  <select name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control">
                    <option value=""><?php echo $text_select; ?></option>
                    <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                    <?php if (isset($address_custom_field[$custom_field['custom_field_id']]) && $custom_field_value['custom_field_value_id'] == $address_custom_field[$custom_field['custom_field_id']]) { ?>
                    <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>" selected="selected"><?php echo $custom_field_value['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                  <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <?php if ($custom_field['type'] == 'radio') { ?>
              <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
                <div class="col-sm-10">
                  <div>
                    <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                    <div class="radio">
                      <?php if (isset($address_custom_field[$custom_field['custom_field_id']]) && $custom_field_value['custom_field_value_id'] == $address_custom_field[$custom_field['custom_field_id']]) { ?>
                      <label>
                        <input type="radio" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
                        <?php echo $custom_field_value['name']; ?></label>
                      <?php } else { ?>
                      <label>
                        <input type="radio" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
                        <?php echo $custom_field_value['name']; ?></label>
                      <?php } ?>
                    </div>
                    <?php } ?>
                  </div>
                  <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                  <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <?php if ($custom_field['type'] == 'checkbox') { ?>
              <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
                <div class="col-sm-10">
                  <div>
                    <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                    <div class="checkbox">
                      <?php if (isset($address_custom_field[$custom_field['custom_field_id']]) && in_array($custom_field_value['custom_field_value_id'], $address_custom_field[$custom_field['custom_field_id']])) { ?>
                      <label>
                        <input type="checkbox" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" checked="checked" />
                        <?php echo $custom_field_value['name']; ?></label>
                      <?php } else { ?>
                      <label>
                        <input type="checkbox" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
                        <?php echo $custom_field_value['name']; ?></label>
                      <?php } ?>
                    </div>
                    <?php } ?>
                  </div>
                  <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                  <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <?php if ($custom_field['type'] == 'text') { ?>
              <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($address_custom_field[$custom_field['custom_field_id']]) ? $address_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                  <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                  <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <?php if ($custom_field['type'] == 'textarea') { ?>
              <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
                <div class="col-sm-10">
                  <textarea name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" rows="5" placeholder="<?php echo $custom_field['name']; ?>" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control"><?php echo (isset($address_custom_field[$custom_field['custom_field_id']]) ? $address_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?></textarea>
                  <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                  <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <?php if ($custom_field['type'] == 'file') { ?>
              <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
                <div class="col-sm-10">
                  <button type="button" id="button-custom-field<?php echo $custom_field['custom_field_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                  <input type="hidden" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($address_custom_field[$custom_field['custom_field_id']]) ? $address_custom_field[$custom_field['custom_field_id']] : ''); ?>" />
                  <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                  <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <?php if ($custom_field['type'] == 'date') { ?>
              <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
                <div class="col-sm-10">
                  <div class="input-group date">
                    <input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($address_custom_field[$custom_field['custom_field_id']]) ? $address_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                    <span class="input-group-btn">
                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                    </span></div>
                  <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                  <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <?php if ($custom_field['type'] == 'time') { ?>
              <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
                <div class="col-sm-10">
                  <div class="input-group time">
                    <input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($address_custom_field[$custom_field['custom_field_id']]) ? $address_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                    <span class="input-group-btn">
                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                    </span></div>
                  <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                  <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <?php if ($custom_field['type'] == 'datetime') { ?>
              <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                <label class="col-sm-2 control-label" for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
                <div class="col-sm-10">
                  <div class="input-group datetime">
                    <input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo (isset($address_custom_field[$custom_field['custom_field_id']]) ? $address_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
                    <span class="input-group-btn">
                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                    </span></div>
                  <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                  <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <?php } ?>
              <?php } ?>
              <div class="col-sm-12">
              <div class="pull-right">
                <?php if ($default) { ?>
                  <input type="checkbox" name="default" value="1" checked="checked" />
                  <?php echo $text_default; ?>
                <?php } else { ?>
                  <input type="checkbox" name="default" value="1" />
                  <?php echo $text_default; ?>
                <?php } ?>
              </div>
              </div>
            </fieldset>
            <div class="buttons clearfix">
              <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default"><?php echo $button_back; ?></a></div>
              <div class="pull-right">
                <input type="submit" value="<?php echo $button_save; ?>" class="btn btn-primary" />
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
// Sort the custom fields
$('.form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('.form-group').length) {
		$('.form-group').eq($(this).attr('data-sort')).before(this);
	} 
	
	if ($(this).attr('data-sort') > $('.form-group').length) {
		$('.form-group:last').after(this);
	}
		
	if ($(this).attr('data-sort') < -$('.form-group').length) {
		$('.form-group:first').before(this);
	}
});
//--></script>
<script type="text/javascript"><!--
$('button[id^=\'button-custom-field\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$(node).parent().find('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});
//--></script>
<script type="text/javascript"><!--
$('select[name=\'city_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=account/account/city&city_id=' + $('select[name=\'city_id\']').val(),
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'city_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			html = '<option value="" selected="selected"><?php echo $text_select; ?></option>';

			if (json['service_zone'] && json['service_zone'] != '') {
				for (i = 0; i < json['service_zone'].length; i++) {
					html += '<option value="' + json['service_zone'][i]['service_zone_id'] + '">' + json['service_zone'][i]['service_zone_name'] + '</option>';
				}
			} else {
				html = '<option value="" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('select[name=\'service_zone_id\']').html(html);
			$('select[name=\'delivery_area_id\']').html('<option value="" selected="selected"><?php echo $text_none; ?></option>');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

//--></script>
<script type="text/javascript"><!--
$('select[name=\'service_zone_id\']').on('change', function() {
    $.ajax({
        url: 'index.php?route=account/account/serviceZone&service_zone_id=' + $('select[name=\'service_zone_id\']').val(),
        dataType: 'json',
        beforeSend: function() {
            $('select[name=\'service_zone_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
        },
        complete: function() {
            $('.fa-spin').remove();
        },
        success: function(json) {
            html = '<option value="" selected="selected"><?php echo $text_select; ?></option>';

            if (json['delivery_area'] && json['delivery_area'] != '') {
                for (i = 0; i < json['delivery_area'].length; i++) {
                    html += '<option value="' + json['delivery_area'][i]['delivery_area_id'] + '">' + json['delivery_area'][i]['delivery_area_name'] + '</option>';
                }
            } else {
                html = '<option value="" selected="selected"><?php echo $text_none; ?></option>';
            }

            $('select[name=\'delivery_area_id\']').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
//--></script>
<?php echo $footer; ?>
