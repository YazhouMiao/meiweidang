<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4>登录</h4>
</div>
<div class="modal-body" id="cart-login">
 <div class="container-fluid">
    <div class="form-group">
      <input type="text" name="email" value="" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
    </div>
    <div class="form-group">
      <input type="password" name="password" value="" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
      <span class="pull-left"><?php echo $text_no_account; ?><a href="<?php echo $register; ?>"><?php echo $text_register_account; ?></a></span>
      <span class="pull-right"><a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></span>
    </div>
  <div class="row">
    <div class="col-sm-6 col-xs-6 pull-left" style="margin-top: 10px;">
      <button id="button-login" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-block"><?php echo $button_login; ?></button>
    </div>
    <div class="col-sm-6 col-xs-6 pull-right" style="margin-top: 10px;">
      <button id="button-no-login" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger btn-block"><?php echo $button_no_login; ?></button>
    </div>
  </div>
 </div>
</div>

<script type="text/javascript"><!--
// Login
$('#button-login').click(function() {
    $.ajax({
        url: 'index.php?route=checkout/login/save',
        type: 'post',
        data: $('#cart-login :input'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-login').button('loading');
        },
        complete: function() {
            $('#button-login').button('reset');
        },
        success: function(json) {
            $('.alert').remove();
            $('.form-group').removeClass('has-error');

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                $('.modal-body').prepend('<div class="alert alert-danger no-offset-xs"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                // Highlight any found errors
                $('input[name=\'email\']').parent().addClass('has-error');
                $('input[name=\'password\']').parent().addClass('has-error');
           }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
// no-login
$('#button-no-login').click(function() {
    location = '<?php echo $checkout; ?>';
});
//--></script>