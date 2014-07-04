/**
 * 菜单动作js
 */
$(document).ready(function(){
		var $activeItem = $('#activeItemId'); 
		///imedia/trunk/index.php/userMenus/list
		//#usermenus
		var _curUrl = location.href;
		_curUrl = _curUrl.split(/index.*\.php/);
		//userMenu module
		if(_curUrl[1].indexOf('/userMenus/') == 0){
			$('#usermenus').find('>li').addClass('nav_menu_active');
		}else{

			if($activeItem.hasClass('nav_menu_li')){
					$activeItem.removeClass('active').addClass('nav_menu_active');
					$activeItem.find('>a').addClass('sf-with-ul');
			}else{
				if($activeItem.size()){
					$activeItem = $activeItem.parent().parent();
					while(!$activeItem.hasClass('nav_menu_li') && $activeItem.attr('tagName') == 'LI'){
						$activeItem.addClass('active');
						$activeItem = $activeItem.parent().parent();
					}
					if($activeItem.hasClass('nav_menu_li')){
						$activeItem.addClass('nav_menu_active');
					}

				}
			}
		}

		var $MENUUL = $("#mainmenu").find('ul.tabarlevel');


		$MENUUL.supersubs({ 
			minWidth:    10,   
			maxWidth:    30,  
			extraWidth:  1						  
		}).superfish({autoArrows : true,delay:300}).find('ul').bgIframe({opacity:false});


	/**
	 * 鼠标移上菜单的效果
	 */
//	$('#menu > li').hover(
//		function () {
//			//show its submenu
//			$(this).children().slideDown(50);
//		}, 
//		function () {
//			//hide its submenu
//			//$('ul', this).slideUp(50);
//			$('ul', this).hide();
//		}
//	);

	/**
	 * 鼠标移上二级菜单的效果
	 */
//	$('#menu > li > ul > li').hover(
//		function () {
//			//show its submenu
//			$('ul', this).slideDown(50);
//			$(this).parents('li').find('a:first').addClass('sel');
//		}, 
//		function () {
//			//hide its submenu
//			$('ul', this).hide();
//			$(this).parents('li').find('a:first').removeClass('sel');
//		}
//	);
	
	
//	$('#menu > li > ul > li > ul > li').hover(
//			function () {
//				//show its submenu
//				$('ul', this).slideDown(50);
//				$(this).parent().parent().find('a:first').addClass('thirdsel');
//			}, 
//			function () {
//				//hide its submenu
//				$('ul', this).hide();
//				$(this).parent().parent().find('a:first').removeClass('thirdsel');
//			}
//		);

	/**
	 * 鼠标移出菜单的效果
	 */
//	$('#menu > li').mouseout(function(){
//		$(this).find('ul').slideUp();
//		$(this).children().first().attr('class','');
//	});
	
	/**
	 * 收藏夹鼠标移上菜单的效果
	 */
//	$('#usermenus > li').hover(function(){
//		$(this).children().slideDown(50);
//		//$(this).children().hide();
//	},function(){
//	    //$(this).find('ul').slideUp(50);
//		$(this).find('ul').hide();
//	}
//	);
	
	/**
	 * 收藏夹鼠标移出菜单的效果
	 */
//	$('#usermenus > li').mouseout(function(){
//	    //$(this).find('ul').slideUp(50);
//		$(this).find('ul').hide();
//	});
});