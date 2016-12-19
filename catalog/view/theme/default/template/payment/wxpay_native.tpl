<div class="wxpay-native">
  <div class="qrcode-container pull-left col-sm-6">
      <div class="title"><?php echo $text_title; ?></div>
      <div class="qrcode">
         <img alt="<?php echo $text_title; ?>" title="<?php echo $text_title; ?>" src="<?php echo $qr_image; ?>" />
      </div>
      <div class="tip center-block">
        <?php echo $text_tip; ?><br />
        <span id="wxpay-native-error" class="text-danger"></span>
        <div class="buttons">
          <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-success" />
        </div>
      </div>
  </div>
  <div class="mobile-container pull-left col-sm-6">
     <div class="mobile-img"></div> 
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
    $.ajax({
        url: 'index.php?route=payment/wxpay_native/confirm',
        type: 'post',
        dataType: 'json',
        beforeSend: function() {
            $('#button-confirm').button('loading');
            $('#wxpay-native-error').text('');
        },
        complete: function() {
            $('#button-confirm').button('reset');
        },
        success: function(json) {
            if(json['return_code'] == 'SUCCESS'){
                location = '<?php echo $continue; ?>';
            } else {
                $('#wxpay-native-error').text('<?php echo $text_error_info; ?>');
            }
        }
    });
});
//--></script>
