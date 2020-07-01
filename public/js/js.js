
var clientWidth = $('html').width();
var clientHeight = $('html').height();
if(clientWidth>640){
	clientWidth=640;
}

// banner
var bannerSwiper = new Swiper('.swiper-banner',{
	pagination:'.banner-pagination',
    width:clientWidth,
    loop:true,
    autoplay: 5000,//可选选项，自动滑动
});
// 今日公告
var noticeSwiper = new Swiper('.swiper-notice', {		        
	paginationClickable: true,
    direction: 'vertical',
    loop:true,
    height: 68*(clientWidth / 640) ,
    autoplay: 3000,//可选选项，自动滑动
});
// 首页的热销推荐等
var floorSwiper = new Swiper('.swiper-floor', {
	width: 236*(clientWidth / 640),
	// slidesOffsetAfter: -236*(clientWidth / 640), 
});

// 分类的侧边栏高度
setTimeout(function(){
	var Height = clientHeight-$('footer').height()-$('.header').height()-2;
	$('.rootList,.branchScroll').height(Height);
},10)

// 分类滚动到头部
$('.rootList-li').click(function(event) {
	$(this).addClass('curr').siblings('.rootList-li').removeClass('curr');
	var top =$(this).position().top- $(this).height()+5;
	var ScrollTop=$(this).parents('ul').scrollTop();
	$(this).parents('ul').animate({scrollTop: top+ScrollTop}, 100);
	console.log(top,ScrollTop)
});

// 产品列表的条件
$('.new-change-eleven').click(function(event) {
	$(this).addClass('active').siblings().removeClass('active');
	if(!$('.new-sort-price').hasClass('active')){
		$('.new-sort-price span').removeClass('arrow-up').removeClass('arrow-down');
	}
})
$('.new-sort-price span').click(function(event) {
	if(!$(this).hasClass('arrow-down')){
		$(this).addClass('arrow-down').removeClass('arrow-up');
	}else{
		$(this).addClass('arrow-up').removeClass('arrow-down');
	}
})

$('.new-change-filtrate').click(function(event) {
	$('.cover-pannel').show(0);
	setTimeout(function(){
		$('.new-filtrate').animate({left:"20%"},200);
	},30);
})
$('.cover-pannel,.filtrate-submit').click(function(event) {
	setTimeout(function(){
		$('.cover-pannel').hide();
	},250);
	$('.new-filtrate').animate({left:"100%"},200);
	// alert('000')
})

$('.filtrate-arrow').click(function(event) {
	var Parents=$(this).parents('.filtrate-chunk');
	if(Parents.hasClass('up')){
		Parents.removeClass('up');
	}else{
		Parents.addClass('up');
	}
})
// 监听价格输入框变化修改价格单选框
$(document).on('input propertychange','.price-input',function () {
	$('.price-radio').attr("checked",false);
})
$('.price-radio').click(function(){
	$('.price-input').val('')
})

//
$('.productHeader-return').click(function(event) {
	if(!$('.productHeader-li').eq(0).hasClass('header-tab-selected')){
		$('.product-content-item').eq(0).show().siblings('.product-content-item').hide();
		$('.productHeader-li').eq(0).addClass('header-tab-selected').siblings('.productHeader-li').removeClass('header-tab-selected');
	}
	// 切换页面滚动到顶部
	$(window).scrollTop(0);
	$('.tab-lst').show();
});

// 产品轮播图
var productSwiper = new Swiper('.product-container',{
    width:clientWidth,
    pagination : '.product-pagination',
	paginationType : 'fraction',
})
// 收藏
$('.product-data-collect').click(function(event) {
	if (!$(this).hasClass('collecting')) {
		$(this).addClass('collecting');
	}else{
		$(this).removeClass('collecting');
	}
});


// 产品详情
$('.tab-lst-li').click(function(event) {
	$(this).addClass('curr').siblings('.tab-lst-li').removeClass('curr');
	var Index=$(this).index();
	$('.sift-detail').eq(Index).show().siblings('.sift-detail').hide();
	// 切换页面滚动到顶部
	$(window).scrollTop(0);
	$('.tab-lst').show();
	
});

var beforeScrollTop=$(window).scrollTop();
$(window).scroll(function(event) {
	var afterScrollTop=$(window).scrollTop();
	var delta = afterScrollTop - beforeScrollTop;
	beforeScrollTop = afterScrollTop;
	var Top=90*(clientWidth / 640)
	if(beforeScrollTop<Top){
		return false
	}
	if( delta === 0 ){
		return false
	}else if( delta > 0 ){
		$('.tab-lst').hide();
	}else{
		$('.tab-lst').show();
	}
	
});

// 数量加减

function Number() {
	var NumberVal=$('.spec-menu-number-input').val();
	if(NumberVal<2){
		$('.spec-menu-number-subtract').addClass('forbid');
	}else{
		$('.spec-menu-number-subtract').removeClass('forbid');
	}
}
Number();

// 关闭
$('.spec-menu-close,.flick-menu-mask').click(function(event) {
	setTimeout(function(){
		$('.flick-menu-mask').hide();
	},250);
	$('.spec-menu').animate({bottom:"-100%"},200);
});

$('.add_cart,.directorder').click(function(event) {
	$('.flick-menu-mask').show();
	setTimeout(function(){
		$('.spec-menu').animate({bottom:"0"},200);
	},30);
	if($(this).hasClass('add_cart')){
		$('.add-cart-box').css({
			display: 'flex'
		});
		$('.Buy-Now-box').hide();
	}else if($(this).hasClass('directorder')){
		$('.add-cart-box').hide();
		$('.Buy-Now-box').show();
	}
})

// 滑动显示删除
var couldRun = true;
$('.cart-scroll').scroll(function(event) {
	var ScrollLeft=$(this).scrollLeft();
    if(ScrollLeft>30){
		$(this).scrollLeft(6000);
	}else{
		$(this).scrollLeft(0);
	}
});

// 全选
$('#cartAll').click(function(event) {
	if($(this).is(':checked')){  
        $('.cart-input[name="cartIds[]"]').each(function(){
            //此处如果用attr，会出现第三次失效的情况  
            $(this).prop("checked",true);  
        });  
    }else{  
        $('.cart-input[name="cartIds[]"]').each(function(){
            $(this).removeAttr("checked",false);  
        });  
        //$(this).removeAttr("checked");  
    }
});

$('.cart-input[name="cartIds[]"]').click(function(event) {
	$('.cart-input[name="cartIds[]"]').each(function(){
		if(!$(this).is(':checked')){
			$('#cartAll').removeAttr("checked",false);
			return false
		}else{
			$('#cartAll').prop("checked",true);
		}
	})
});

$('.compile-btn').click(function(event) {
	if (!$(this).hasClass('finish')) {
		$('.cart-input[name="cart"]').each(function(){  
          	$(this).removeAttr("checked",false);
        });
        $('#cartAll').removeAttr("checked",false);
        $(this).addClass('finish').html('完成');
        $('.compile-btn-box').show();
        $('.closing-btn-box').hide();
	}else{
		$('.cart-input[name="cart"]').each(function(){   
            $(this).prop("checked",true);  
        });
		$('#cartAll').prop("checked",true);
		$(this).removeClass('finish').html('编辑');
		$('.compile-btn-box').hide();
        $('.closing-btn-box').show();
	}
});


$('.cart-ul').on('click', '.cart-li-btn', function(event) {
	$(this).parents('.cart-li').remove();
});

$('.delete-btn').click(function(event) {
	$('.cart-input[name="cart"]').each(function(){
		if($(this).is(':checked')){
			$(this).parents('.cart-li').remove();
		}
	})
});


// 客服
// 分类的侧边栏高度
setTimeout(function(){
	var Height = clientHeight-$('.dialogue-bottom').height()-$('.header').height()-2;
	$('.dialogue-box').height(Height);
	// 滚动到底部
	$('.dialogue-box').scrollTop( $('.dialogue-box')[0].scrollHeight );
},10)

// 搜索
$('.search-span').click(function(event) {
	$('.box').hide();
	$('.search-Box').show();
	$('.search').focus();
});

$('.search-return').click(function(event) {
	$('.box').show();
	$('.search-Box').hide();
});

$('.search').on('input propertychange',function(){
    var result = $(this).val();
    if(result==''){
    	$('.searc-content').show();
    	$('.searc-ul').hide();
    }else{
    	$('.searc-content').hide();
    	$('.searc-ul').show();
    }
});

$('.search').on('keypress',function(e) {
    var keycode = e.keyCode;
    if(keycode=='13') {
        $("#search_keywords_form").submit();
    }
});


// 地址
// $('.siteHeader-btn').click(function(event) {
// 	$('.site-btn-box,.site-bottom').show();
// 	$('.site-text span').hide();
// 	$(this).hide().siblings('.icon-header').attr('href','javascript:void(0)').addClass('icon-header-site');

// });

$('.delivery-input[name="site"]').click(function(event) {
	$('.delivery-input[name="site"]').each(function(){
		if(!$(this).is(':checked')){
			$(this).siblings('.delivery-label').children('.site-checkbox-text').html('设为默认');
			// $(this).parents('.site-btn-box').siblings('.site-box').find('.site-text span').remove();
		}else{
			$(this).siblings('.delivery-label').children('.site-checkbox-text').html('默认地址');
			// $(this).parents('.site-btn-box').siblings('.site-box').find('.site-text').prepend('<span>[默认地址]</span>').children('span').hide()
		}
	})
});

$('.icon-like').click(function(event) {
	$(this).parents('.comment-msg').find('.icon-like').addClass('icon-liked').find('use').attr('xlink:href','#icon-liked');
	$(this).nextAll().removeClass('icon-liked').find('use').attr('xlink:href','#icon-like');
});
