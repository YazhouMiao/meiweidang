<?php echo $header; ?>
<div class="vertical-margin-10 hidden-xs"></div>
<div class="container inner-bg">
  <?php if ($success) { ?>
  <div class="alert alert-success no-offset-xs"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger no-offset-xs"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
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
      <div class="row">
        <div class="vertical-margin-50 hidden-xs"></div>
        <div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-4 col-lg-4">
          <div class="no-offset-xs well">
            <h2 class="text-center"><?php echo $text_returning_customer; ?></h2>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
                <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
                <a href="<?php echo $forgotten; ?>" class="pull-right"><?php echo $text_forgotten; ?></a></div>
              <div class="form-group"> 
                <input type="checkbox" name="remember" value="1" checked="checked" /> <?php echo $text_remember; ?></div>
              <input type="submit" value="<?php echo $button_login; ?>" class="btn btn-primary btn-block" />
              <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
              <?php } ?>
            </form>
            <br />
            <button id="button-register" class="btn btn-default btn-block"><?php echo $button_register; ?></button>
          </div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$('#button-register').click(function() {
    location = '<?php echo $register; ?>';
});
//--></script>
<?php echo $footer; ?>