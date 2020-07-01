/*$(document).ready(function(){
	//单个图片点击浏览
	$('img.view').on('click',function(){
		$.colorbox({href:$(this).attr('src'),maxHeight:'98%',opacity:'0.3',title:'图片浏览',maxWidth:'98%'});
		return false;
	});
	//图片列表放大浏览
	$("a.view").colorbox({rel:"show", transition:"slide", opacity:'0.3',current:'', maxHeight:'97%', maxWidth:'87%', fixed:true});
	//iframe
	$('.iframe').on('click',function(){
		$.colorbox({
			iframe:true,
			href:$(this).attr('href'),
			title:$(this).attr('title')?$(this).attr('title'):$(this).text(),
			opacity:'0.3',
			overlayClose: false,
			width:$(this).attr('width')?$(this).attr('width'):'1000px',
			height:$(this).attr('height')?$(this).attr('height'):'700px',
			maxHeight:'95%',
			maxWidth:'95%',
			fixed:true
		});
		return false;
	});
});*/

//2016.4.27修改 iframe事件以为绑定事件，以方便动态插入数据
$(function(){
	//图片列表放大浏览
	//$("a.view").colorbox({rel:"show", transition:"slide", opacity:'0.3',current:'', maxHeight:'97%', maxWidth:'87%', fixed:true});

	//单个图片点击浏览(color绑定事件)
	$("body").on('click','img.view',function(){
		$.colorbox({href:$(this).attr('src'),maxHeight:'98%',opacity:'0.3',title:'图片浏览',maxWidth:'98%'});
		return false;
	});

	//图片列表放大浏览
	$("body").on('click','a.view',function(){
		$.colorbox({rel:"show", transition:"slide", opacity:'0.3',current:'', maxHeight:'97%', maxWidth:'87%', fixed:true});
		return false;
	});

	//iframe(color绑定事件)
	$("body").on('click','.iframe',function(){
		$.colorbox({
			iframe:true,
			href:$(this).attr('href'),
			title:$(this).attr('title')?$(this).attr('title'):$(this).text(),
			opacity:'0.3',
			overlayClose: false,
			width:$(this).attr('width')?$(this).attr('width'):'75%',
			height:$(this).attr('height')?$(this).attr('height'):'85%',
			maxHeight:'95%',
			maxWidth:'95%',
			fixed:true
		});
		return false;
	});
});