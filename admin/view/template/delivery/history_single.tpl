<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $back; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_order_list; ?></h3>
      </div>
      <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-center"><?php echo $column_add_time; ?></td>
                  <td class="text-center"><?php echo $column_status; ?></td>
                  <td class="text-center"><?php echo $column_delivery_name; ?></td>
                  <td class="text-center"><?php echo $column_delivery_telephone; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($delivery_histories) { ?>
                <?php foreach ($delivery_histories as $delivery_history) { ?>
                <tr>
                  <td class="text-center"><?php echo $delivery_history['add_time']; ?></td>
                  <td class="text-center"><?php echo $delivery_history['status']; ?></td>
                  <td class="text-center"><?php echo $delivery_history['delivery_name']; ?></td>
                  <td class="text-center"><?php echo $delivery_history['delivery_telephone']; ?></td>
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
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 
