//点击小图时，切换大图片
toggleImg = function(){
	var toggleId = $active.attr("rel") -1;
	var divWidth = $("#nav_div1").width();
	var toggleWidth = toggleId * divWidth;
	$active.activeClass();
	$("#nav_div2").animate({left: -toggleWidth}, 500);
}

//启动一个定时器，每隔30秒切换图片
autoPlay = function(){
	play = setInterval(function(){
		$active = $(".mininal_btn_hl").next();
		if($active.length === 0){
			$active = $(".mininal_btn:first");
		}
		toggleImg();
	},20000);
}


$(function(){
	
	$(".mininal_btn").mouseover(function(){
		$active = $(this);
		clearInterval(play);
		toggleImg();
		autoPlay();
	});

	
	$(".mininal_btn:first").activeClass();
	autoPlay();
});


$.fn.extend({"activeClass":function(){
	$(".mininal_btn_hl").removeClass().addClass("mininal_btn");
	$(this).removeClass().addClass("mininal_btn_hl");
}});


$(function(){
	$(".nav_box").click(function(){
		window.location.href = $(this).attr("href");
	}).hover(
		function(){
			$(this).removeClass().addClass("sub");
		},
		function(){
			$(this).removeClass().addClass("nav_box");
		}
	);


	//右上角相关站点图片鼠标获得焦点时触发的事件
	$("#top_site").hover(
		function(){
			$("~ table",this).show();
		},
		function(){
			var $obj = $("~ table",this);
			setTimeout(function() {
				if(!$obj.hasClass("hover"))
					$obj.hide();
	          }, 150);
		}
	);
	
	$("#top_site ~ table").hover(
		function(){
			$(this).addClass("hover");
		},
		function(){
			$(this).removeClass("hover");
			$(this).hide();
			
		}
	);
	//右上角相关站点图片鼠标获得焦点时切换Class
	$(".nav_td").hover(
		function(){
			$(this).removeClass().addClass("top_sub");
		},
		function(){
			$(this).removeClass().addClass("nav_td");
		}
	);
	
})