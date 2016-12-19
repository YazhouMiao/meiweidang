<?php if ($error_warning) { ?>
<div class="alert alert-warning no-offset-xs"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>
<p><?php echo $text_payment_method; ?></p>
<div class="clearfix">
  <ul class="list-inline">
    <?php foreach ($payment_methods as $payment_method) { ?>
    <li class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <label>
        <?php if ($payment_method['code'] == $code || !$code) { ?>
        <?php $code = $payment_method['code']; ?>
        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" />
        <?php } else { ?>
        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" />
        <?php } ?>
        <?php if (isset($payment_method['logo'])) { ?>
           <img src="<?php echo $payment_method['logo']; ?>" alt="<?php echo $payment_method['title']; ?>" title="<?php echo $payment_method['title']; ?>" class="img-thumbnail" />
           <span class="visible-xs-inline"><?php echo $payment_method['title']; ?></span>
        <?php } else { ?>
           <?php echo $payment_method['title']; ?>
        <?php } ?>
        <?php if ($payment_method['terms']) { ?>
        (<?php echo $payment_method['terms']; ?>)
        <?php } ?>
      </label>
    </li>
    <?php } ?>
  </ul>
</div>
<?php } ?>

<?php if ($text_agree) { ?>
<div class="buttons">
  <?php echo $text_agree; ?>
    <?php if ($agree) { ?>
    <input type="checkbox" name="agree" value="1" checked="checked" />
    <?php } else { ?>
    <input type="checkbox" name="agree" value="1" />
    <?php } ?>
    &nbsp;
    <div class="pull-right" style="margin-top:10px;">
      <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg" />
    </div>
</div>
<?php } else { ?>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg" />
  </div>
</div>
<?php } ?>
<script type="text/javascript"><!--
$(document).ready(function(){
  $('input').iCheck({
    radioClass: 'iradio_square-green',
    increaseArea: '5%' // optional
  });
});
//--></script>