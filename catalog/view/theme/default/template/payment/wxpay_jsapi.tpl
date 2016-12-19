<script type="text/javascript"><!--

wx.config({
  debug:false,
  appId:'<?php echo $appId; ?>',
  timestamp:<?php echo $wx_timestamp; ?>,
  nonceStr:'<?php echo $wx_nonceStr; ?>',
  signature:'<?php echo $wx_signature; ?>',
  jsApiList:['chooseWXPay']
});

//调用微信JS api 支付
wx.ready(function(){
  wx.chooseWXPay({
    timestamp: <?php echo $timestamp; ?>,
    nonceStr:  '<?php echo $nonceStr; ?>',
    package:   '<?php echo $package; ?>',
    signType:  '<?php echo $signType; ?>',
    paySign:   '<?php echo $paySign; ?>',
    success: function (res) {
        // 支付成功
        location = '<?php echo $success_url; ?>';
    }
  });
});

wx.error(function (res) {
    alert('wx.error: '+JSON.stringify(res));
});
//--></script>
