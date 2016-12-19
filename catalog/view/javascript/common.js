/* jquery.hammer.js */
(function(factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery', 'hammerjs'], factory);
    } else if (typeof exports === 'object') {
        factory(require('jquery'), require('hammerjs'));
    } else {
        factory(jQuery, Hammer);
    }
}(function($, Hammer) {
    function hammerify(el, options) {
        var $el = $(el);
        if(!$el.data("hammer")) {
            $el.data("hammer", new Hammer($el[0], options));
        }
    }

    $.fn.hammer = function(options) {
        return this.each(function() {
            hammerify(this, options);
        });
    };

    // extend the emit method to also trigger jQuery events
    Hammer.Manager.prototype.emit = (function(originalEmit) {
        return function(type, data) {
            originalEmit.call(this, type, data);
            $(this.element).trigger({
                type: type,
                gesture: data
            });
        };
    })(Hammer.Manager.prototype.emit);
}));

function getURLVar(key) {
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
}

// myzhou 2015/7/7 金额格式化
function formatMoney(moneyStr){  
   moneyStr = parseFloat((moneyStr + "").replace(/[^\d\.-]/g, "")).toFixed(1) + "";//更改这里n数也可确定要保留的小数位  
   var l = moneyStr.split(".")[0].split("").reverse(); 
   var r = moneyStr.split(".")[1];  
   var t = "";
   for(i = 0; i < l.length; i++ ){  
      t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");  
   }  
   return t.split("").reverse().join("") + "." + r.substring(0,1);//保留1位小数  如果要改动 把substring 最后一位数改动即可  
}

// myzhou 2015/5/31 判断客户端是否是移动端
function isMobile() {
	var system = {
		win : false,
		mac : false,
		xll : false
	};

	//检测平台
	var p = navigator.platform;
	system.win = p.indexOf("Win") == 0;
	system.mac = p.indexOf("Mac") == 0;
	system.x11 = (p == "X11") || (p.indexOf("Linux") == 0);
	//跳转语句
	if (system.win||system.mac||system.xll) {
		return false;
	} else {
		return true;
	}
}

$(document).ready(function() {
	if(isMobile()){
		// fastclick代替click事件，消除移动端的延迟
	    $(function() {
	        FastClick.attach(document.body);
	    });
	}

    // Adding the clear Fix
    cols1 = $('#column-right, #column-left').length;
    
    if (cols1 == 2) {
        $('#content .product-layout:nth-child(2n+2)').after('<div class="clearfix visible-md visible-sm"></div>');
    } else if (cols1 == 1) {
        $('#content .product-layout:nth-child(3n+3)').after('<div class="clearfix visible-lg"></div>');
    } else {
        $('#content .product-layout:nth-child(4n+4)').after('<div class="clearfix"></div>');
    }
    
    // Highlight any found errors
    $('.text-danger').each(function() {
        var element = $(this).parent().parent();
        
        if (element.hasClass('form-group')) {
            element.addClass('has-error');
        }
    });
        
    // Currency
    $('#currency .currency-select').on('click', function(e) {
        e.preventDefault();

        $('#currency input[name=\'code\']').attr('value', $(this).attr('name'));

        $('#currency').submit();
    });

    // Language
    $('#language a').on('click', function(e) {
        e.preventDefault();

        $('#language input[name=\'code\']').attr('value', $(this).attr('href'));

        $('#language').submit();
    });

    /* Search */
    $('#search input[name=\'search\']').parent().find('button').on('click', function() {
        url = $('base').attr('href') + 'index.php?route=product/search';

        var value = $('header input[name=\'search\']').val();

        if (value) {
            url += '&search=' + encodeURIComponent(value);
        }

        location = url;
    });

    $('#search input[name=\'search\']').on('keydown', function(e) {
        if (e.keyCode == 13) {
            $('header input[name=\'search\']').parent().find('button').trigger('click');
        }
    });

    // Menu
    $('#menu .dropdown-menu').each(function() {
        var menu = $('#menu').offset();
        var dropdown = $(this).parent().offset();

        var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());

        if (i > 0) {
            $(this).css('margin-left', '-' + (i + 5) + 'px');
        }
    });

    // Product List
    $('#list-view').click(function() {
        $('#content .product-layout > .clearfix').remove();

        //$('#content .product-layout').attr('class', 'product-layout product-list col-xs-12');
        $('#content .row > .product-layout').attr('class', 'product-layout product-list col-xs-12');
        
        localStorage.setItem('display', 'list');
    });

    // Product Grid
    $('#grid-view').click(function() {
        $('#content .product-layout > .clearfix').remove();

        // What a shame bootstrap does not take into account dynamically loaded columns
        cols = $('#column-right, #column-left').length;

        if (cols == 2) {
            $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
        } else if (cols == 1) {
            $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
        } else {
            $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');
        }

         localStorage.setItem('display', 'grid');
    });
    

    if (localStorage.getItem('display') == 'list') {
        $('#list-view').trigger('click');
    } else {
        $('#list-view').trigger('click');
    }

    // tooltips on hover
    $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});

    // Makes tooltips work on ajax generated content
    $(document).ajaxStop(function() {
        $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
    });
    
    // 幻灯片切换js
    $('#head-slider').carousel({
      interval: 3000
    });

    // 导航栏按钮侧切动作
    $('#right-panel-link').click(function(){
        var active = $("#right-panel");
        var width = active.css('width');
        
        bodyAnimation = {};
        if(!active.is(':visible')){
            bodyAnimation['margin-left'] = '-=' + width;
            $('body').animate(bodyAnimation, 500);
            $("#right-panel").show(500);
        } else {
            bodyAnimation['margin-left'] = '+=' + width;
            $('body').animate(bodyAnimation, 200);
            $("#right-panel").hide(200);
        }
    });
    // 移动设备
    if(isMobile()){
        // 向右滑动，收起侧栏
        $('#right-panel').hammer().on('swiperight', function(){
            if($("#right-panel").is(':visible')){
                bodyAnimation = {};
                bodyAnimation['margin-left'] = '+=' + $("#right-panel").css('width');
                $('body').animate(bodyAnimation, 200);
                $("#right-panel").hide(200);
            }
        });
    }

    // 模式对话框垂直居中显示
    $("[role='dialog']").on("shown.bs.modal", function() {
        var $modalDialog = $(this).find(".modal-dialog"),
            dialogHeight = $modalDialog.height(),
            windowHeight = $(window).height();
     
        // When dialog height greater than window height,
        // use default margin top value to set dialog position.
        if (windowHeight < dialogHeight) {
            // do nothing
            return;
        }
     
        // When dialog height less than window height,
        // dialog position set it with vertical center.
        $modalDialog.css({
            "marginTop": (windowHeight - dialogHeight) / 2
        });
    });
});

// Cart add remove functions
var cart = {
    'add': function(product_id, quantity) {
        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
            dataType: 'json',
            beforeSend: function() {
                $('#cart > button').button('loading');
            },
            complete: function() {
                $('#cart > button').button('reset');
            },            
            success: function(json) {
                $('.alert, .text-danger').remove();

                if (json['redirect']) {
                    location = json['redirect'];
                }

                if (json['success']) {
                	$('.modal-dialog').addClass('modal-sm');
    			    $('#common-modal-container').html(json['success']);
    			    $('#common-modal-dialog').modal({backdrop:'static'});

                    // Need to set timeout otherwise it wont update the total
                    setTimeout(function () {
                        $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
                        $('.label-cart').text(json['count']);
                    }, 100);
                
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                }
            }
        });
    },
    'remove': function(key) {
        $.ajax({
            url: 'index.php?route=checkout/cart/remove',
            type: 'post',
            data: 'key=' + key,
            dataType: 'json',
            beforeSend: function() {
                $('#cart > button').button('loading');
            },
            complete: function() {
                $('#cart > button').button('reset');
            },            
            success: function(json) {
                // Need to set timeout otherwise it wont update the total
                setTimeout(function () {
                    $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
                    $('.label-cart').text(json['count']);
                }, 100);
                    
                if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
                    location = 'index.php?route=checkout/cart';
                } else {
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                }
            }
        });
    },
    // 修改商品数量
    'edit': function(key, quantity) {
        var params = {};
        params[key] = quantity;
        $.ajax({
            url: 'index.php?route=checkout/cart/edit',
            type: 'post',
            data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
            dataType: 'json',
            complete: function() {
                $('#cart > button').button('reset');
            },            
            success: function(json) {
                // Need to set timeout otherwise it wont update the total
                setTimeout(function () {
                    $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
                    $('.label-cart').text(json['count']);
                }, 100);

                $('#cart > ul').load('index.php?route=common/cart/info ul li');
                
                $('#checkout-totals').html(json['totals']);
            }
        });
    }
}

var voucher = {
    'add': function() {

    },
    'remove': function(key) {
        $.ajax({
            url: 'index.php?route=checkout/cart/remove',
            type: 'post',
            data: 'key=' + key,
            dataType: 'json',
            beforeSend: function() {
                $('#cart > button').button('loading');
            },
            complete: function() {
                $('#cart > button').button('reset');
            },
            success: function(json) {
                // Need to set timeout otherwise it wont update the total
                setTimeout(function () {
                    $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
                }, 100);

                if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
                    location = 'index.php?route=checkout/cart';
                } else {
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                }
            }
        });
    }
}

var wishlist = {
    'add': function(product_id) {
        $.ajax({
            url: 'index.php?route=account/wishlist/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function(json) {
                $('.alert').remove();

                if (json['success']) {
                    $('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                if (json['info']) {
                    $('#content').parent().before('<div class="alert alert-info"><i class="fa fa-info-circle"></i> ' + json['info'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                $('#wishlist-total span').html(json['total']);
                $('#wishlist-total').attr('title', json['total']);

                $('html, body').animate({ scrollTop: 0 }, 'slow');
            }
        });
    },
    'remove': function() {

    }
}

/* Agree to Terms */
$(document).delegate('.agree', 'click', function(e) {
    e.preventDefault();

    $('#modal-agree').remove();

    var element = this;

    $.ajax({
        url: $(element).attr('href'),
        type: 'get',
        dataType: 'html',
        success: function(data) {
            html  = '<div id="modal-agree" class="modal">';
            html += '  <div class="modal-dialog">';
            html += '    <div class="modal-content">';
            html += '      <div class="modal-header">';
            html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
            html += '        <h4 class="modal-title">' + $(element).text() + '</h4>';
            html += '      </div>';
            html += '      <div class="modal-body">' + data + '</div>';
            html += '    </div';
            html += '  </div>';
            html += '</div>';

            $('body').append(html);

            $('#modal-agree').modal('show');
        }
    });
});

// Autocomplete */
(function($) {
    $.fn.autocomplete = function(option) {
        return this.each(function() {
            this.timer = null;
            this.items = new Array();
    
            $.extend(this, option);
    
            $(this).attr('autocomplete', 'off');
            
            // Focus
            $(this).on('focus', function() {
                this.request();
            });
            
            // Blur
            $(this).on('blur', function() {
                setTimeout(function(object) {
                    object.hide();
                }, 200, this);                
            });
            
            // Keydown
            $(this).on('keydown', function(event) {
                switch(event.keyCode) {
                    case 27: // escape
                        this.hide();
                        break;
                    default:
                        this.request();
                        break;
                }                
            });
            
            // Click
            this.click = function(event) {
                event.preventDefault();
    
                value = $(event.target).parent().attr('data-value');
    
                if (value && this.items[value]) {
                    this.select(this.items[value]);
                }
            }
            
            // Show
            this.show = function() {
                var pos = $(this).position();
    
                $(this).siblings('ul.dropdown-menu').css({
                    top: pos.top + $(this).outerHeight(),
                    left: pos.left
                });
    
                $(this).siblings('ul.dropdown-menu').show();
            }
            
            // Hide
            this.hide = function() {
                $(this).siblings('ul.dropdown-menu').hide();
            }        
            
            // Request
            this.request = function() {
                clearTimeout(this.timer);
        
                this.timer = setTimeout(function(object) {
                    object.source($(object).val(), $.proxy(object.response, object));
                }, 200, this);
            }
            
            // Response
            this.response = function(json) {
                html = '';
    
                if (json.length) {
                    for (i = 0; i < json.length; i++) {
                        this.items[json[i]['value']] = json[i];
                    }
    
                    for (i = 0; i < json.length; i++) {
                        if (!json[i]['category']) {
                            html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
                        }
                    }
    
                    // Get all the ones with a categories
                    var category = new Array();
    
                    for (i = 0; i < json.length; i++) {
                        if (json[i]['category']) {
                            if (!category[json[i]['category']]) {
                                category[json[i]['category']] = new Array();
                                category[json[i]['category']]['name'] = json[i]['category'];
                                category[json[i]['category']]['item'] = new Array();
                            }
    
                            category[json[i]['category']]['item'].push(json[i]);
                        }
                    }
    
                    for (i in category) {
                        html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';
    
                        for (j = 0; j < category[i]['item'].length; j++) {
                            html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
                        }
                    }
                }
    
                if (html) {
                    this.show();
                } else {
                    this.hide();
                }
    
                $(this).siblings('ul.dropdown-menu').html(html);
            }
            
            $(this).after('<ul class="dropdown-menu"></ul>');
            $(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));    
            
        });
    }
})(window.jQuery);