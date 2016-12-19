<?php echo $header; ?>
<div id="content" style="margin-top: 50px">
  <div class="container-fluid">
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
    <?php if (!empty($error['status'])) { ?>
    <div class="alert alert-danger no-offset-xs"><i class="fa fa-exclamation-circle"></i> <?php echo $error['status']; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
  <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-xs-8">
              <div class="form-group">
                <select name="filter_status" id="input-status" class="form-control">
                  <?php if (!$filter_status && !is_null($filter_status)) { ?>
                  <option value="0" selected="selected"><?php echo $text_status_0; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_status_0; ?></option>
                  <?php } ?>
                  <?php if ($filter_status == 1) { ?>
                  <option value="1" selected="selected"><?php echo $text_status_1; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_status_1; ?></option>
                  <?php } ?>
                  <?php if ($filter_status == 2) { ?>
                  <option value="2" selected="selected"><?php echo $text_status_2; ?></option>
                  <?php } else { ?>
                  <option value="2"><?php echo $text_status_2; ?></option>
                  <?php } ?>
                  <?php if ($filter_status == 3) { ?>
                  <option value="3" selected="selected"><?php echo $text_status_3; ?></option>
                  <?php } else { ?>
                  <option value="3"><?php echo $text_status_3; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="pull-right">
              <div class="form-group">
                <button type="button" id="button-filter" class="btn btn-primary pull-left"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
              </div>
            </div>
         </div>
        </div>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-delivery-task">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <?php if(isset($button_action)){ ?>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <?php } ?>
                  <td class="text-center"><?php if ($sort == 'dh.order_id') { ?>
                    <a href="<?php echo $sort_order_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_order_id; ?>"><?php echo $column_order_id; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php if ($sort == 'ma.name') { ?>
                    <a href="<?php echo $sort_business_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_business_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_business_name; ?>"><?php echo $column_business_name; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php echo $column_product_name; ?></td>
                  <td class="text-center"><?php if ($sort == 'op.quantity') { ?>
                    <a href="<?php echo $sort_quantity; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_quantity; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_quantity; ?>"><?php echo $column_quantity; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php echo $column_status; ?></td>
                  <td class="text-center"><?php echo $column_address ?></td>
                  <td class="text-center"><?php if ($sort == 'o.date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($delivery_tasks) { ?>
                <?php foreach ($delivery_tasks as $delivery_task) { ?>
                <tr>
                  <?php if(isset($button_action)){ ?>
                  <td class="text-center"><?php if (in_array($delivery_task['order_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $delivery_task['order_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $delivery_task['order_id']; ?>" />
                    <?php } ?></td>
                  <?php } ?>
                  <td class="text-center"><a href="<?php echo $delivery_task['link']; ?>"><?php echo $delivery_task['order_id']; ?></a></td>
                  <td class="text-center"><?php echo $delivery_task['business_name']; ?></td>
                  <td class="text-center"><?php echo $delivery_task['product_name']; ?></td>
                  <td class="text-center"><?php echo $delivery_task['quantity']; ?></td>
                  <td class="text-center"><?php echo $delivery_task['status']; ?></td>
                  <td class="text-center"><?php echo $delivery_task['company']; ?><br/><?php echo $delivery_task['delivery_area']; ?>,<?php echo $delivery_task['address']; ?></td>
                  <td class="text-center"><?php echo $delivery_task['date_added']; ?></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <?php if($delivery_tasks && isset($button_action)) { ?>
            <div class="form-group">
              <button type="button" id="button-action" data-toggle="tooltip" class="btn btn-danger pull-right"> <i class="fa fa-wrench"></i> <?php echo $button_action; ?></button>
            </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
    url = 'index.php?route=delivery/task';
    
    var filter_status = $('select[name=\'filter_status\']').val();
    
    if (filter_status != '') {
        url += '&filter_status=' + encodeURIComponent(filter_status); 
    }   
    
    location = url;
});

$("input[name='selected[]']").on('change', function() {
    var inArr = new Array();
    $("input[name='selected[]']").each(function(){
        var value = $(this).prop("value");
        var result = $(this).prop("checked");
        if ($.inArray(value, inArr) == -1) {
            $("input[name='selected[]'][value='"+ value +"']").prop("checked",result);
            inArr.push(value);
        }
    });
});

$("#button-action").on('click', function() {
    var counter = 0;
    $("input[name='selected[]']").each(function(){
        if($(this).prop("checked")){
            counter++;
        }
    });
    if (counter == 0) {
        alert("<?php echo $text_no_selected; ?>");
    } else {
        if(confirm('<?php echo $text_confirm; ?>')){
            $('#form-delivery-task').submit();
        }
    }
});
//--></script>
<?php echo $footer; ?> 
