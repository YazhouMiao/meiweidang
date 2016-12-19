<?php echo $header; ?>
<div class="vertical-margin-10 hidden-xs"></div>
<div class="container inner-bg">
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger no-offset-xs"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
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
      <h1><?php echo $heading_title; ?></h1>
      <div class="panel-group no-offset-xs" id="accordion">
        <?php if (!$logged && $account != 'guest') { ?>
        <div class="panel panel-default" id="panel-payment-address">
          <div class="panel-heading">
            <h4 class="panel-title"><?php echo $text_checkout_account; ?></h4>
          </div>
          <!-- 配送地址 &配送方式-->
          <div class="panel-collapse collapse" id="collapse-payment-address">
            <div class="panel-body"></div>
          </div>
        </div>
        <?php } else { ?>
        <div class="panel panel-default" id="panel-payment-address">
          <div class="panel-heading">
            <h4 class="panel-title"><?php echo $text_checkout_payment_address; ?></h4>
          </div>
          <!-- 配送地址 &配送方式-->
          <div class="panel-collapse collapse" id="collapse-payment-address">
            <div class="panel-body"></div>
          </div>
        </div>
        <?php } ?>
        
        <div class="panel panel-default" id="panel-payment-method">
          <div class="panel-heading">
            <h4 class="panel-title"><?php echo $text_checkout_payment_method; ?></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-payment-method">
            <div class="panel-body"></div>
          </div>
        </div>
        <div class="panel panel-default hidden" id="panel-checkout-confirm">
          <div class="panel-heading">
            <h4 class="panel-title"><?php echo $text_checkout_confirm; ?></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-checkout-confirm">
            <div class="panel-body"></div>
          </div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
    // 购物车不能操作
    $('#cart button').attr('disabled','disabled');
    
    <?php if (!$logged) { ?>
    $.ajax({
        url: 'index.php?route=checkout/guest',
        dataType: 'html',
        beforeSend: function() {
            $('#button-account').button('loading');
        },
        complete: function() {
            $('#button-account').button('reset');
        },
        success: function(html) {
            $('.alert, .text-danger').remove();

            $('#collapse-payment-address .panel-body').html(html);

            $('#collapse-payment-address').parent().find('.panel-heading .panel-title').attr({
                "data-toggle" : "collapse",
                "data-target" : "#collapse-payment-address",
                "data-parent" : "#accordion"
            });

            $('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_account; ?> <i class="fa fa-caret-down"></i>');
            
            $('#collapse-payment-address').parent().addClass("panel-success");

            $('#collapse-payment-address').parent().find('.panel-heading .panel-title').trigger('click');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
    <?php } else { ?>
    $.ajax({
        url: 'index.php?route=checkout/payment_address',
        dataType: 'html',
        success: function(html) {
            $('#collapse-payment-address .panel-body').html(html);

            $('#collapse-payment-address').parent().find('.panel-heading .panel-title').attr({
                "data-toggle" : "collapse",
                "data-target" : "#collapse-payment-address",
                "data-parent" : "#accordion"
            });

            $('#collapse-payment-address').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_address; ?> <i class="fa fa-caret-down"></i>');
            
            $('#collapse-payment-address').parent().addClass('panel-success');

            $('#collapse-payment-address').parent().find('.panel-heading .panel-title').trigger('click');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
    <?php } ?>
});

// Payment Address
$(document).delegate('#button-payment-address', 'click', function() {
    var options = "{";
    
    $('#collapse-payment-address input[type=\'text\'], #collapse-payment-address input[type=\'date\'], #collapse-payment-address input[type=\'datetime-local\'], #collapse-payment-address input[type=\'time\'], #collapse-payment-address input[type=\'password\'], #collapse-payment-address input[type=\'checkbox\']:checked, #collapse-payment-address input[type=\'radio\']:checked, #collapse-payment-address input[type=\'hidden\'], #collapse-payment-address textarea, #collapse-payment-address select').each(function(){
        options = options + "\"" + $(this).attr('name') + "\":\"" + $(this).val() + "\",";
    });

    $("#payment-existing ul>li").each(function(){
        if (!!$(this).hasClass("selected")) {
           options = options + "\"address_id\"" + ":\"" + $(this).data('value') + "\",";
        }
    });

    options += "\"\":\"\"}";
    // end

    $.ajax({
        url: 'index.php?route=checkout/payment_address/save',
        type: 'post',
        data: jQuery.parseJSON(options),
        dataType: 'json',
        beforeSend: function() {
        	$('#button-payment-address').button('loading');
		},
        complete: function() {
			$('#button-payment-address').button('reset');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#collapse-payment-address .panel-body').prepend('<div class="alert alert-warning no-offset-xs">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

				for (i in json['error']) {
					var element = $('#input-payment-' + i.replace('_', '-'));

					if ($(element).parent().hasClass('input-group')) {
						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}

				// Highlight any found errors
				$('.text-danger').parent().parent().addClass('has-error');
            } else {
                $('#collapse-payment-method .panel-body').html(json['payment_method_html']);
                
                $('#collapse-payment-method').parent().find('.panel-heading .panel-title').attr({
                    "data-toggle" : "collapse",
                    "data-target" : "#collapse-payment-method",
                    "data-parent" : "#accordion"
                });
    
				$('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_method; ?> <i class="fa fa-caret-down"></i>');

				$('#collapse-payment-method').parent().addClass("panel-success");
				
				$('#collapse-payment-method').parent().find('.panel-heading .panel-title').trigger('click');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

// Guest
$(document).delegate('#button-guest', 'click', function() {
    $.ajax({
        url: 'index.php?route=checkout/guest/save',
        type: 'post',
        data: $('#collapse-payment-address input[type=\'text\'], #collapse-payment-address input[type=\'date\'], #collapse-payment-address input[type=\'datetime-local\'], #collapse-payment-address input[type=\'time\'], #collapse-payment-address input[type=\'checkbox\']:checked, #collapse-payment-address input[type=\'radio\']:checked, #collapse-payment-address input[type=\'hidden\'], #collapse-payment-address textarea, #collapse-payment-address select'),
        dataType: 'json',
        beforeSend: function() {
       		$('#button-guest').button('loading');
	    },
        complete: function() {
			$('#button-guest').button('reset');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#collapse-payment-address .panel-body').prepend('<div class="alert alert-warning no-offset-xs">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

				for (i in json['error']) {
					var element = $('#input-payment-' + i.replace('_', '-'));

					if ($(element).parent().hasClass('input-group')) {
						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
            } else {
                $('#collapse-payment-method .panel-body').html(json['payment_method_html']);
                
                $('#collapse-payment-method').parent().find('.panel-heading .panel-title').attr({
                    "data-toggle" : "collapse",
                    "data-target" : "#collapse-payment-method",
                    "data-parent" : "#accordion"
                });
                
				$('#collapse-payment-method').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_payment_method; ?> <i class="fa fa-caret-down"></i>');

				$('#collapse-payment-method').parent().addClass("panel-success");
				
				$('#collapse-payment-method').parent().find('.panel-heading .panel-title').trigger('click');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

$(document).delegate('#button-payment-method', 'click', function() {
    $.ajax({
        url: 'index.php?route=checkout/payment_method/save',
        type: 'post',
        data: $('#collapse-payment-method input[type=\'radio\']:checked, #collapse-payment-method input[type=\'checkbox\']:checked'),
        dataType: 'json',
        beforeSend: function() {
         	$('#button-payment-method').button('loading');
		},
		complete: function() {
            $('#button-payment-method').button('reset');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['redirect']) {
                location.href = json['redirect'];
            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#collapse-payment-method .panel-body').prepend('<div class="alert alert-warning no-offset-xs">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
            } else {
                // 分不同支付方式,进行不同处理
                var payment_method = $('#collapse-payment-method input[type=\'radio\']:checked').val();

                if(payment_method == 'wxpay_jsapi'){  // 微信公众号支付
                	$('#collapse-checkout-confirm .panel-body').html(json['payment_return']);
                } else if(payment_method == 'wxpay_native'){ // 微信扫码支付
                    $('#collapse-checkout-confirm .panel-body').html(json['payment_return']);
                    
                    $('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').attr({
                        "data-toggle" : "collapse",
                        "data-target" : "#collapse-checkout-confirm",
                        "data-parent" : "#accordion"
                    });
                    
    				$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').html('<?php echo $text_checkout_confirm; ?> <i class="fa fa-caret-down"></i>');
    
    				$('#collapse-checkout-confirm').parent().addClass("panel-success");
    				
    				$('#panel-checkout-confirm').removeClass("hidden");
    				
    				$('#collapse-checkout-confirm').parent().find('.panel-heading .panel-title').trigger('click');
                } else if(payment_method == 'cod'){ // 活动付款
                	location.href = json['payment_return'];
                }
                if((payment_method == 'alipay_direct') || (payment_method == 'alipay_wap' && json['wx_version']===false)){
                    document.forms['alipaysubmit'].submit();
                // 在微信中使用支付宝无线支付
                } else if(payment_method == 'alipay_wap' && json['wx_version']!==false && json['wx_version']!=='undefined'){
                    var queryParam = '';

                    Array.prototype.slice.call(document.querySelector("#alipaysubmit").querySelectorAll("input[type=hidden]")).forEach(function (ele) {
                        queryParam += ele.name + "=" + encodeURIComponent(ele.value) + '&';
                    });
                    var gotoUrl = document.querySelector("#alipaysubmit").getAttribute('action') + '&' + queryParam;
                    location.href = "<?php echo $alipay_in_weixin_url; ?>" + '&goto=' + gotoUrl;
                }
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
//--></script>
<?php echo $footer; ?>