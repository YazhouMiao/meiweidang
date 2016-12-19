<?php echo $header; ?>
<div class="vertical-margin-10 hidden-xs"></div>
<div class="container inner-bg">
 <div id="select-localisation">
  <h2 style="margin-bottom:20px;"><?php echo $heading_title; ?></h2>
  <div id="city" class="clearfix" style="clear: both;display: block;overflow: hidden;">
    <div class="title"><?php echo $text_on_service_city; ?></div>
    <div class="selection row">
       <?php foreach ($cities as $c) { ?>
         <?php if($c['id'] == $city['id']){ ?>
         <li data-value="<?php echo $c['id']; ?>" class="selected col-lg-2 col-md-3 col-sm-4 col-xs-6">
           <a href="javascript:;"> <?php echo $c['name']; ?></a>
         </li>
         <?php } else { ?>
         <li data-value="<?php echo $c['id']; ?>" class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
           <a href="javascript:;"> <?php echo $c['name']; ?></a>
         </li>
         <?php } ?>
       <?php } ?>
    </div>
  </div>
  <hr>
  <div id="service-zone" class="clearfix">
    <div id="tip" class="alert alert-success alert-dismissible fade in col-xs-12 visible-xs-block"><i class="fa fa-info-circle"></i> <?php echo $text_tip; ?></div>
    <div class="title"><?php echo $text_service_zone; ?></div>
    <div class="selection row">
       <?php foreach ($service_zones as $sz) { ?>
         <?php if($sz['id'] == $service_zone['id']){ ?>
         <li data-value="<?php echo $sz['id']; ?>" class="selected col-lg-2 col-md-3 col-sm-4 col-xs-6">
           <a href="javascript:;" data-placement="top" data-toggle="popover" data-trigger="hover click" data-content="<?php echo $sz['description']; ?>"><?php echo $sz['name']; ?></a>
         </li>
         <?php } else { ?>
         <li data-value="<?php echo $sz['id']; ?>" class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
           <a href="javascript:;" data-placement="top" data-toggle="popover" data-trigger="hover click" data-content="<?php echo $sz['description']; ?>"><?php echo $sz['name']; ?></a>
         </li>
         <?php } ?>
       <?php } ?>
    </div>
  </div>
  <div class="col-md-2 col-sm-4 col-xs-12" style="margin-top: 30px;">
    <button type="button" id="button-select" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block"><?php echo $button_select; ?></button>
  </div>
 </div>
</div>
<script type="text/javascript"><!--
$(function () {
  $('[data-toggle="popover"]').popover();
});

$("#city").delegate("li","click",function(){
    if (!$(this).hasClass("selected")) {
        $(this).addClass("selected").siblings("li").removeClass("selected");
        
        var city_id = $(this).data('value');
        $.ajax({
            url: 'index.php?route=common/localisation/getServiceZones',
            type: 'post',
            data: 'city_id=' + city_id,
            dataType: 'json',
            success: function(json) {
                var html = '';
                if (json['service_zones'] && json['service_zones'] != '') {
                    for (i = 0; i < json['service_zones'].length; i++) {
                        if(json['service_zones'][i]['id'] === json['default_service_zone_id']){
                            html += '<li data-value="' + json['service_zones'][i]['id'] + '" class="selected col-lg-2 col-md-3 col-sm-4 col-xs-6"><a href="javascript:;" data-placement="top" data-toggle="popover" data-trigger="hover click" data-content="' + json['service_zones'][i]['description'] +'">' + json['service_zones'][i]['name'] + '</a></li>';
                        } else {
                            html += '<li data-value="' + json['service_zones'][i]['id'] + '" class="col-lg-2 col-md-3 col-sm-4 col-xs-6"><a href="javascript:;" data-placement="top" data-toggle="popover" data-trigger="hover click" data-content="' + json['service_zones'][i]['description'] +'">' + json['service_zones'][i]['name'] + '</a></li>';
                        }
                    }
                } else {
                    html += '<li class="alert alert-danger col-sm-6 col-xs-12" role="alert"><?php echo $text_no_service_zone; ?></li>';
                }
                
                $('#service-zone .selection').html(html);
                $('[data-toggle="popover"]').popover();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
});

$("#service-zone").delegate("li","click",function(){
    if (!$(this).hasClass("selected")) {
        $(this).addClass("selected").siblings("li").removeClass("selected");
    }
});

// 设置定位的城市
function setCity(cityName) {
    $.ajax({
        url: 'index.php?route=common/localisation/setCity',
        type: 'post',
        data: 'city_name=' + cityName,
        dataType: 'json',
        success: function(json) {
            if(json['city_status']){
                $('#city').before('<div id="located-city" class="alert alert-success col-md-4 col-sm-6 col-xs-12">'+json['text_located_city'] + '<span class="city">' + json['located_city']+ '</span> (' + json['text_on_service'] +')</div>');
            } else {
                $('#city').before('<div id="located-city" class="alert alert-danger col-md-4 col-sm-6 col-xs-12">'+json['text_located_city'] + '<span class="city">' + json['located_city']+'</span> ('+ json['text_off_service'] +')</div>');
            }
            
            if(json['city']['id'] && json['city']['id']!=''){
                $('#city [data-value="' + json['city']['id'] + '"]').trigger('click');
            }
        }
    });
}

// 百度地图获取用户所在城市
if(typeof BMap !== 'undefined'){
    if(isMobile()){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;
                var point = new BMap.Point(lon, lat); // 创建点坐标
                var gc = new BMap.Geocoder();
                gc.getLocation(point, function (rs) {
                    var addComp = rs.addressComponents;
                    //当前定位城市
                    setCity(addComp.city);
                });
            });
        }
    } else {
        // 通过IP获得
        function myFun(result){
            var cityName = result.name;
            //当前定位城市
            setCity(cityName);
        }
        var myCity = new BMap.LocalCity();
        myCity.get(myFun);
    }
}

$('#button-select').on('click', function() {
    var cityId = '';
    var serviceZoneId = '';
    $('#city li').each(function(){
        if($(this).hasClass("selected")){
            cityId = $(this).data("value");
        }
    });
    $('#service-zone li').each(function(){
        if($(this).hasClass("selected")){
            serviceZoneId = $(this).data("value");
        }
    });
    
    $.ajax({
        url: 'index.php?route=common/localisation/set',
        type: 'post',
        data: 'city_id=' + cityId + '&service_zone_id=' + serviceZoneId,
        dataType: 'json',
        beforeSend: function() {
            $('#button-select').button('loading');
            $('#alert').remove();
        },
        complete: function() {
            $('#button-select').button('reset');
        },
        success: function(json) {
            if(json['error'] && json['error']!=''){
                $('#select-localisation').before('<div id="alert" class="alert alert-danger col-xs-12"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
            } else if (json['redirect'] && json['redirect']!=''){
                location = json['redirect'];
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

});
//--></script>
<?php echo $footer; ?>
