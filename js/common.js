$(document).ready(function(){
	//根据窗口可视化面积初始化窗口高度
	resizeScrollbar();

	/**
	 * 搜索框 切换高级搜索功能
	 */
	if($.cookie('isAdvSearchOpen') == 1){
		$('.normal_search').hide();
		$('.senior_search').show();
		$.cookie('isAdvSearchOpen', 1);
		//resizeScrollbar();
	}
	else{
		$('.normal_search').show();
		$('.senior_search').hide();
		$.cookie('isAdvSearchOpen', null);
		//resizeScrollbar();
	}
	
	$('#switch_adv_search').click(function(){
		$('.senior_search').show();
		$('.normal_search').hide();
		$.cookie('isAdvSearchOpen', 1, {expires:365});
		//resizeScrollbar();
	});
	$('#switch_base_search').click(function(){;
		$('.senior_search').hide();
		$('.normal_search').show();
		$.cookie('isAdvSearchOpen', null);
		//resizeScrollbar();
	});
	
	$('.switch_adv_search').click(function(){
		$(this).parent().parent().next().show();
		$(this).parent().parent().hide();
		$.cookie('isAdvSearchOpen', 1, {expires:365});
		//resizeScrollbar();
	});
	$('.switch_base_search').click(function(){
		$(this).parent().parent().prev().show();
		$(this).parent().parent().hide();
		$.cookie('isAdvSearchOpen', null);
		//resizeScrollbar();
	});
	
	//搜索框鼠标hover高亮效果
	$('.switch_adv_search').hover(function(){
		$(this).css('background','url(../../images/bot_down.gif) no-repeat');
	},function(){
		$(this).css('background','url(../../images/bot.gif) no-repeat');
	});
	$('.search_button_back').hover(function(){
		$(this).css('background','url(../../images/s-back_04.gif) no-repeat');
	},function(){
		$(this).css('background','url(../../images/s-back_03.gif) no-repeat');
	});
	
	//用户快捷菜单收缩 cookie控制
	if($.cookie('isUserMenusOpen') == 1){
		$('td.ECbar').prev().show();
		$('td.ECbar').children().removeClass('close');
	}
	else{
		$('td.ECbar').prev().hide();
	}
	$('td.ECbar').click(function(){
		if($(this).children().hasClass('close')){
			$(this).prev().show();
			$(this).children().removeClass('close');
			$.cookie('isUserMenusOpen', 1, {expires:365, path: '/', domain: 'localhost'});
		}else{
			$(this).prev().hide();
			$(this).children().addClass('close');
			$.cookie('isUserMenusOpen', null);
		}
	});
	
	//焦点框背景变为黄色
//	$('input:text,input:password,textarea').focus(function(){
////		$(this).attr('class', 'focus');
//		$(this).css("background","lightyellow");
//	});
//	$('input:text,input:password,textarea').blur(function(){
////		$(this).removeAttr('class');
//		$(this).css("background","");
//	});
	
	$(".items > tbody > tr").each(function(){
		$(this).live('mouseover',function(){
			$(this).addClass('selected');
		});
		$(this).live('mouseout',function(){
			$(this).removeClass('selected');
		});	
	});
	
//	$('.form_post_in').jqf1();.
	
	//form表单 提示信息默认隐藏，当input框焦点时显示，失去焦点时隐藏
	$('.enter_tips').hide();
	$('input,select,textarea').each(function(){
		$(this).focus(function(){
			$(this).next('.enter_tips').show();
		});
		$(this).blur(function(){
			$(this).next('.enter_tips').hide();
		})
	});
	
	$('#reset').click(function(){
		$('input[type=text]').val('');
//		$('input[type=hidden]').val('');
		$('input[type=radio][value=0]').attr("checked",true);
		$('input[type=checkbox]').attr("checked",false);
		$('select option:nth-child(1)').attr("selected" , "selected");
		return false;
	});
	
	$('button.reset').click(function(){
		$('input[type=text]').val('');
		$('input[type=radio]').attr("checked",false);
		$('input[type=checkbox]').attr("checked",false);
		$('select option:nth-child(1)').attr("selected" , "selected");
		return false;
	});
});

/**
 * 根据窗口大小变化，动态调整列表大小
 */
$(window).resize(function(){
	resizeScrollbar();
});

/**
 * 根据窗口大小变化，调整列表区域大小
 */
function resizeScrollbar(){
	/*
	var height = $(window).height()-185-$('.formSubmit').height()-$('.content_top').height()-$('#footer').height()-$('.breadcrumbs').height()-$('h1.title').height()-$('.errorSummary').height();
	$('div.scrollbar').height(height);
	var userheight = $(window).height()-105-$('#footer').height();
	$('div.menu_user').height(userheight);*/
}