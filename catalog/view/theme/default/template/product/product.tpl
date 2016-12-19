<?php echo $header; ?>
<div class="vertical-margin-10 hidden-xs"></div>
<div class="container">
  <div class="row"><?php echo $column_left; ?>
    <div id="content" class="col-sm-12"><?php echo $content_top; ?>
      <div class="row">
        <div class="col-sm-8">
          <?php if ($thumb || $images) { ?>
          <ul class="thumbnails no-offset-xs">
            <?php if ($thumb) { ?>
            <li>
              <a class="thumbnail" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>">
                <img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
                <?php if ($images) { ?>
                <div class="img-info-bottom info"><i class="fa fa-clone"></i> <?php echo $text_img_gallery; ?></div>
                <?php } ?>
              </a>
            </li>
            <?php } ?>
            <?php if ($images) { ?>
            <?php foreach ($images as $image) { ?>
            <li class="image-additional hidden-xs"><a class="thumbnail" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"> <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
            <?php } ?>
            <?php } ?>
          </ul>
          <?php } ?>
        </div>
        <div class="col-sm-4 inner-bg-xs" style="padding-bottom:5px;">
          <h2 class="product-name-title"><?php echo $heading_title; ?></h2>
            <?php if ($reward) { ?>
            <span class="label label-success"><?php echo $text_reward; ?> <?php echo $reward; ?></span>
            <?php } ?>
          <ul class="list-unstyled">
            <?php if ($manufacturer) { ?>
            <li><span class="product-detail-leading"><?php echo $text_manufacturer; ?></span> <a id="manufacturer-anchor" href="javascript:"><?php echo $manufacturer; ?></a></li>
            <?php } ?>
            <li><span class="product-detail-leading"><?php echo $text_model; ?></span> <?php echo $model; ?></li>
            <li><span class="product-detail-leading"><?php echo $text_sale_status; ?></span> <span class="label <?php echo is_null($buyable) ? 'label-default' : 'label-warning' ?>"><?php echo $sale_status; ?></span></li>
          </ul>
          <?php if ($rating) { $width = round($rating / 5 * 72,0); ?>
            <li class="product-rating clearfix">
                <span class="star-rating pull-left">
                    <span class="star-score" style="width:<?php echo $width; ?>px"></span>
                </span>
                <span class="score-num pull-left"><?php echo $rating; ?></span> <?php echo $text_fen; ?>
                <span class="pull-right"><a id="review-anchor" href="javascript:"><?php echo $reviews; ?></a></span>
            </li>
          <?php } ?>
          <?php if ($price) { ?>
          <ul class="list-unstyled">
            <?php if (!$special) { ?>
            <li id="product_price" data-value="<?php echo $price; ?>">
              <h2 class="product-price-current color-orange"><span class="product-price-symbol"><?php echo $price_symbol_left; ?></span> <strong id="product_price_display"><?php echo $price; ?></strong></h2><span class="product-price-symbol"><?php echo $price_symbol_right; ?></span>
            </li>
            <?php } else { ?>
            <li id="product_price" data-value="<?php echo $special; ?>">
              <h2 class="product-price-current color-orange"><span class="product-price-symbol"><?php echo $price_symbol_left; ?></span> <strong id="product_price_display"><?php echo $special; ?></strong></h2><span class="product-price-symbol"><?php echo $price_symbol_right; ?></span>
              <span style="text-decoration: line-through;"><?php echo $price_symbol_left; ?> <?php echo $price; ?><?php echo $price_symbol_right; ?></span>
              <?php if ($points) { ?>
                <span class="label label-success"><?php echo $text_points; ?> <?php echo $points; ?></span>
              <?php } ?>
            </li>
            <?php } ?>
            <?php if ($discounts) { ?>
              <span class="praduct-label-discount"><?php echo $text_discount_title; ?></span>
            <?php foreach ($discounts as $discount) { ?>
            <li style="margin-left:30px;"><?php echo $discount['quantity']; ?><?php echo $text_unit; ?><?php echo $text_discount; ?></span> <?php echo $price_symbol_left; ?><?php echo $discount['price']; ?><?php echo $price_symbol_right; ?></li>
            <?php } ?>
            <?php } ?>
          </ul>
          <?php } ?>
          
          <div id="product">
          <?php if ($options) { ?>
            <div id="product-options" class="sys_item_spec default-border">
            <?php foreach ($options as $option) { ?>
            <?php if ($option['type'] == 'select') { ?>
            <dl class="clearfix iteminfo_parameter sys_item_specpara" data-type="select" data-name="option[<?php echo $option['product_option_id']; ?>]" data-required="<?php echo $option['required']; ?>" data-attrval="">
              <dt><?php echo $option['name']; ?></dt>
              <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                <?php if ($option_value['price']) { ?>
                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                <?php } ?>
                </option>
                <?php } ?>
              </select>
            </dl>
            <?php } ?>
  
            <?php if ($option['type'] == 'radio') { ?>
            <dl class="clearfix iteminfo_parameter sys_item_specpara" data-type="radio" data-name="option[<?php echo $option['product_option_id']; ?>]" data-required="<?php echo $option['required']; ?>" data-attrval="">
              <dt><?php echo $option['name']; ?></dt>
              <dd>
                  <ul class="sys_spec_text">
                    <?php foreach ($option['product_option_value'] as $option_value) { ?>
                    <li data-value="<?php echo $option_value['product_option_value_id']; ?>" data-price-prefix="<?php echo $option_value['price_prefix']; ?>" data-price="<?php echo $option_value['price']; ?>">
                    <a href="javascript:;" title="<?php echo $option_value['name']; ?>"> <?php echo $option_value['name']; ?>
                    </a>
                    </li>
                    <?php } ?>
                  </ul>
              </dd>
            </dl>
            <?php } ?>

            <?php if ($option['type'] == 'checkbox') { ?>
            <dl class="clearfix iteminfo_parameter sys_item_specpara" data-type="checkbox" data-name="option[<?php echo $option['product_option_id']; ?>]" data-required="<?php echo $option['required']; ?>" data-attrval="">
              <dt><?php echo $option['name']; ?></dt>
              <dd>
                <ul class="sys_spec_text">
                 <?php foreach ($option['product_option_value'] as $option_value) { ?>
                 <li data-value="<?php echo $option_value['product_option_value_id']; ?>" data-price-prefix="<?php echo $option_value['price_prefix']; ?>" data-price="<?php echo $option_value['price']; ?>">
                 <a href="javascript:;" title="<?php echo $option_value['name']; ?>"> <?php echo $option_value['name']; ?>
                 </a>
                 </li>
                <?php } ?>
               </ul>
             </dd>
            </dl>
            <?php } ?>
            
            <?php if ($option['type'] == 'image') { ?>
            <dl class="clearfix iteminfo_parameter sys_item_specpara" data-type="radio" data-name="option[<?php echo $option['product_option_id']; ?>]" data-required="<?php echo $option['required']; ?>" data-attrval="">
              <dt><?php echo $option['name']; ?></dt>
              <dd>
                <ul class="sys_spec_img">
                  <?php foreach ($option['product_option_value'] as $option_value) { ?>
                    <li data-value="<?php echo $option_value['product_option_value_id']; ?>" data-price-prefix="<?php echo $option_value['price_prefix']; ?>" data-price="<?php echo $option_value['price']; ?>">
                      <a title="<?php echo $option_value['name']; ?>" href="javascript:;" data-value="<?php echo $option_value['product_option_value_id']; ?>">
                      <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" title="<?php echo $option_value['name']; ?>" />
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </dd>
            </dl>
            <?php } ?>
            
            <?php if ($option['type'] == 'text') { ?>
             <dl class="clearfix iteminfo_parameter sys_item_specpara" date-required="<?php echo $option['required']; ?>">
              <dt><?php echo $option['name']; ?></dt>
              <ul class="sys_spec_text">
              <dd class="input-group">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
              </dd>
              </ul>
            </dl>
            <?php } ?>
            <?php if ($option['type'] == 'textarea') { ?>
            <dl class="clearfix iteminfo_parameter sys_item_specpara" date-required="<?php echo $option['required']; ?>">
              <dt><?php echo $option['name']; ?></dt>
              <ul class="sys_spec_text">
              <dd>
                <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
              </dd>
              </ul>
            </dl>
            <?php } ?>
            <?php if ($option['type'] == 'file') { ?>
            <dl class="clearfix iteminfo_parameter sys_item_specpara" date-required="<?php echo $option['required']; ?>">
              <dt><?php echo $option['name']; ?></dt>
              <ul class="sys_spec_text">
              <dd>
                <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
              </dd>
              </ul>
            </dl>
            <?php } ?>
            <?php if ($option['type'] == 'date') { ?>
            <dl class="clearfix iteminfo_parameter sys_item_specpara" date-required="<?php echo $option['required']; ?>">
              <dt><?php echo $option['name']; ?></dt>
              <ul class="sys_spec_text">
              <dd class="input-group date">
                <input type="text" class="form-control" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" />
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span>
              </dd>
              </ul>
            </dl>
            <?php } ?>
            <?php if ($option['type'] == 'datetime') { ?>
            <dl class="clearfix iteminfo_parameter sys_item_specpara" date-required="<?php echo $option['required']; ?>">
              <dt><?php echo $option['name']; ?></dt>
              <ul class="sys_spec_text">
              <dd class="input-group datetime">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span>
              </dd>
              </ul>
            </dl>
            <?php } ?>
            <?php if ($option['type'] == 'time') { ?>
            <dl class="clearfix iteminfo_parameter sys_item_specpara" date-required="<?php echo $option['required']; ?>">
              <dt><?php echo $option['name']; ?></dt>
              <ul class="sys_spec_text">
              <dd class="input-group time">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span>
              </dd>
              </ul>
            </dl>
            <?php } ?>
            <?php } ?>
            </div>
          <?php } ?>
            <div class="form-group">
              <div class="product-item clearfix iteminfo_parameter">
                <span class="control-label pull-left product-detail-leading" style="margin-top:7px;" for="input-quantity"><?php echo $entry_qty; ?></span>
                <div class="input-group sys_spec_text product-qty-btn">
                  <span class="input-group-btn">
                  <button type="button" id="quantity-minus" data-toggle="tooltip" data-minimum-quantity="<?php echo $minimum; ?>" class="btn"><i class="fa fa-minus"></i></button></span>
                  <input type="text" name="quantity" value="<?php echo $minimum; ?>" id="input-quantity" class="product-qty-input" />
                  <span class="input-group-btn pull-left">
                  <button type="button" id="quantity-plus" data-toggle="tooltip" class="btn"><i class="fa fa-plus"></i></button></span>
                </div>
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
              </div>
              <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block" <?php echo is_null($buyable) ? 'disabled="disabled"' : ''; ?>><?php echo $button_cart; ?></button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-8'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-8'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div class="<?php echo $class; ?>">
          <div class="tab-navbar-mask no-offset-xs"></div>
          <ul class="nav nav-tabs tab-navbar no-offset-xs">
            <li class="<?php echo empty($products) ? 'active':'' ?> col-xs-3"><a id="tab-description-trigger" href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?></a></li>
            <li class="col-xs-3"><a id="tab-review-trigger" href="#tab-review" data-toggle="tab"><?php echo $tab_review; ?></a></li>
            <li class="<?php echo empty($products) ? '':'active' ?> col-xs-3"><a id="tab-related-trigger" href="#tab-related-products" data-toggle="tab"><?php echo $tab_related; ?></a></li>
            <li class="col-xs-3"><a id="tab-manufacturer-trigger" href="#tab-manufacturer" data-toggle="tab"><?php echo $tab_manufacturer; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane no-offset-xs inner-bg" id="tab-description">
              <div class="col-xs-12 "><?php echo $description; ?></div>
            </div>
            <div class="tab-pane no-offset-xs inner-bg" id="tab-review">
               <div class="col-xs-12" id="review"></div>
            </div>
            <?php if ($products) { ?>
              <div class="tab-pane active row" id="tab-related-products">
                <?php foreach ($products as $product) { ?>
                <div class="product-grid col-xs-6 col-sm-6 col-md-3 col-lg-3">
                  <div class="product-thumb transition inner-bg <?php echo is_null($product['buyable']) ? 'product-off-sale' : ''; ?>">
                    <div class="image">
                      <a href="<?php echo $product['href']; ?>">
                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
                        <?php if (is_null($product['buyable'])){ ?>
                        <div class="img-info-bottom unbuyable"><?php echo $text_unbuyable; ?></div>
                        <?php } ?>
                      </a>
                    </div>
                    <div class="caption">
                      <div class="title"><?php echo $product['title']; ?></div>
                      <div class="clearfix">
                          <div class="name pull-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                          <?php if ($product['price']) { ?>
                          <div class="price pull-right">
                            <?php if (!$product['special']) { ?>
                            <?php echo $product['price']; ?>
                            <?php } else { ?>
                            <?php echo $product['special']; ?>
                            <?php } ?>
                          </div>
                          <?php } ?>
                      </div>
                      <div class="clearfix">
                        <?php if ($product['rating']) { $width = round($product['rating'] / 5 * 72,0); ?>
                          <div class="rating pull-left">
                            <span class="star-rating pull-left">
                              <span class="star-score" style="width:<?php echo $width; ?>px"></span>
                            </span>
                            <span class="score-num pull-left"><?php echo $product['rating']; ?><?php echo $text_fen; ?></span>
                          </div>
                        <?php } else { ?>
                          <div class="rating"><?php echo $text_no_review; ?></div>
                        <?php } ?>
                        <?php if ($product['special']) { ?>
                         <div class="price-old pull-right"><?php echo $product['price']; ?></div>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="button-group">
                      <button class="cart-color" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');" <?php if(is_null($product['buyable'])) echo 'disabled="disabled"'; ?> ><span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span> <i class="fa fa-shopping-cart"></i></button>
                      <button class="heart-color" type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            <?php } else { ?>
              <div class="tab-pane no-offset-xs inner-bg" id="tab-related-products">
                <div class="col-xs-12"><?php echo $text_no_related; ?></div>
              </div>
            <?php } ?>
            <div class="tab-pane no-offset-xs inner-bg" id="tab-manufacturer">
              <div class="col-xs-12"><?php echo $mf_description; ?></div>
            </div>
          </div>
        </div>
      </div>
      <?php if ($tags) { ?>
      <p><?php echo $text_tags; ?>
        <?php for ($i = 0; $i < count($tags); $i++) { ?>
        <?php if ($i < (count($tags) - 1)) { ?>
        <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
        <?php } else { ?>
        <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
        <?php } ?>
        <?php } ?>
      </p>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
//商品规格选择
$(function(){
    $(".sys_item_spec .sys_item_specpara").each(function(){
        var i = $(this);
        var p = i.find("ul>li");
        p.click(function(){
            if(i.data('type') == 'radio') {
                if (!!$(this).hasClass("selected")) {
                    $(this).removeClass("selected");
                    i.data("attrval","");
                } else {
                    $(this).addClass("selected").siblings("li").removeClass("selected");
                    i.data("attrval",$(this).data("value"));
                }
            } else if (i.data('type') == 'checkbox'){
                if (!!$(this).hasClass("selected")) {
                    $(this).removeClass("selected");
                } else {
                    $(this).addClass("selected");
                }

                var value = new Array();
                p.filter('.selected').each(function(){
                    value.push($(this).data("value"));
                });
                if(value.length == 0){
                    i.data("attrval","");
                } else {
                    i.data("attrval",value.join(","));
                }
            }
            
            updatePrice(); //更新价格
        });
    });
    
    //更新价格
    function updatePrice(){
        // 金额字符串去掉所有逗号
        var oldPrice = $('#product_price').data('value').replace(/,/g,"");
        var newPrice = oldPrice;
        $(".sys_item_spec .sys_item_specpara").each(function(){
            var i = $(this);
            var p = i.find("ul>li");
            
            p.each(function(){
                if (!!$(this).hasClass("selected") && ($(this).data('price') != '')){
                    if($(this).data('price-prefix') == '-') {
                        newPrice = Number(newPrice) - Number($(this).data('price'));
                    } else if ($(this).data('price-prefix') == '+'){
                        newPrice = Number(newPrice) + Number($(this).data('price'));
                    }
                }
            });
        });
        
        //输出价格
        if(Number(newPrice) != Number($('#product_price_display').text().replace(/,/g,""))){
             // 格式化
             $('#product_price_display').text(formatMoney(newPrice));
        }
    }
    
})
//--></script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
    
    var options = "{";
    $(".sys_item_spec .sys_item_specpara").each(function(){
        if($(this).data('attrval') != ""){
            if($(this).data('type') == "radio"){
                options = options + "\"" + $(this).data('name') + "\":" + $(this).data('attrval') + ",";    
            } else if($(this).data('type') == "checkbox"){
                options = options + "\"" + $(this).data('name') + "\":" + "[" + $(this).data('attrval') + "],";
            }
        } 
    });
    
    $('#product input[type=\'text\'], #product select, #product textarea').each(function(){
        options = options + "\"" + $(this).attr('name') + "\":\"" + $(this).val() + "\",";
    });
    
    options = options + "\"product_id\"" + ":" + $("input[name='product_id']").val();

    options += "}";

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: jQuery.parseJSON(options),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
				    $("html,body").animate({scrollTop: $("#product").offset().top}, 500);
				    // 闪烁边框
				    var counter = 0, id = false;
				    var oldClass = $('#product-options').attr("class") + " ",newClass = "";
                    id = setInterval(function(){
                        newClass = counter%2 ? oldClass : oldClass + "bling-border";
                        $('#product-options').attr("class", newClass);
                        if(counter==5){
                            clearInterval(id);
                            $('#product-options').removeClass("bling-border");
                        }
                        counter++;
                    },300);
                 }

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
			    $('.modal-dialog').addClass('modal-sm');
			    $('#common-modal-container').html(json['success']);
			    $('#common-modal-dialog').modal({backdrop:'static'});

				$('#cart > button').html('<i class="fa fa-shopping-cart"></i> ' + json['total']);

				$('#cart > ul').load('index.php?route=common/cart/info ul li');
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : ''),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#review').after('<div class="alert alert-danger no-offset-xs"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review').after('<div class="alert alert-success no-offset-xs"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});

$('#quantity-plus').on('click', function() {
    var quantity = Number($("input[name='quantity']").val());
    if(!isNaN(quantity)){
        quantity += 1;
        $("input[name='quantity']").val(quantity);
    }
});

$('#quantity-minus').on('click', function() {
    var minimum = $('#quantity-minus').data('minimum-quantity');
    var quantity = Number($("input[name='quantity']").val());
    
    if(!isNaN(quantity) && (quantity > minimum)){
        quantity -= 1;
        $("input[name='quantity']").val(quantity);
    }
});

$(document).ready(function() {
    $('.thumbnails').magnificPopup({
        type:'image',
        delegate: 'a',
        gallery: {
            enabled:true
        }
    });
    
    $('.tab-navbar').click(function() {
        var offsetTop = $(this).offset().top;
        $('html, body').animate({ scrollTop: offsetTop }, 'fast');
    });
    
    var target = $('.tab-navbar');
    var offsetTop = target.offset().top;
    $(window).on('scroll', function(){
        var width = target.width();
        //on desktop - fix navigation on scrolling
        if($(window).scrollTop() >= offsetTop) {
            target.addClass('fixed-to-top');
            target.css('width',width);
            $('.tab-navbar-mask').show();
        } else {
            target.removeClass('fixed-to-top');
            target.attr("style",null);
            $('.tab-navbar-mask').hide();
        }
    });
    
    $(window).resize(function(){
        $(window).unbind('scroll');

        var target = $('.tab-navbar');
        target.attr("style",null);
        target.removeClass('fixed-to-top');
        
        var offsetTop = target.offset().top;
        var width = target.width();

        $(window).on('scroll', function(){
            if($(window).scrollTop() > offsetTop) {
                target.addClass('fixed-to-top');
                target.css('width',width);
                $('.tab-navbar-mask').show();
            } else {
                target.removeClass('fixed-to-top');
                target.attr("style",null);
                $('.tab-navbar-mask').hide();
            }
        });
    });
    
    $('#review-anchor').click(function(){
        $('#tab-review-trigger').trigger('click');
    });
    $('#manufacturer-anchor').click(function(){
        $('#tab-manufacturer-trigger').trigger('click');
    });
});
//--></script>
<?php echo $footer; ?>