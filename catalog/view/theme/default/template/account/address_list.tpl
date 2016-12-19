<?php echo $header; ?>
<div class="vertical-margin-10 hidden-xs"></div>
<div class="container inner-bg">
  <?php if ($success) { ?>
  <div class="alert alert-success no-offset-xs"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-warning no-offset-xs"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2><?php echo $text_address_book; ?></h2>
      <?php if ($addresses) { ?>
      <!-- 手机以外的大屏显示 -->
      <div class="table-address hidden-xs">
      <table class="table table-hover">
        <?php foreach ($addresses as $address) { ?>
          <?php if ($address['address_id'] == $default_address_id) { ?>
          <tr class="success">
            <td class="text-left"><?php echo $address['address']; ?></td>
            <td class="text-right"><a href="<?php echo $address['update']; ?>" class="btn btn-primary"><?php echo $button_edit; ?></a> &nbsp; <a href="<?php echo $address['delete']; ?>" class="btn btn-danger"><?php echo $button_delete; ?></a></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td class="text-left"><?php echo $address['address']; ?></td>
            <td class="text-right"><a href="<?php echo $address['update']; ?>" class="btn btn-primary"><?php echo $button_edit; ?></a> &nbsp; <a href="<?php echo $address['delete']; ?>" class="btn btn-danger"><?php echo $button_delete; ?></a></td>
          </tr>
          <?php } ?>
        <?php } ?>
      </table>
      </div>
      
      <!-- 手机等小屏显示 -->
      <div class="address-xs no-offset-xs visible-xs-block">
        <?php foreach ($addresses as $address) { ?>
        <?php if ($address['address_id'] == $default_address_id) { ?>
        <div class="bg-success" data-link="<?php echo $address['update'] ?>">
          <?php echo $address['address']; ?>
        </div>
        <?php } else { ?>
        <div data-link="<?php echo $address['update'] ?>">
          <?php echo $address['address']; ?>
        </div>
        <?php } ?>
        <?php } ?>
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default"><?php echo $button_back; ?></a></div>
        <div class="pull-right"><a href="<?php echo $add; ?>" class="btn btn-primary"><?php echo $button_new_address; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$('.address-xs div').click(function() {
    location = $(this).data('link');
});
//--></script>
<?php echo $footer; ?>