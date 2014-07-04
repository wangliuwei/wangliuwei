/**
 * 投放列表js文件
 */
$(document).ready(function(){
	/**
	 * 点击创意数显示该投放下的创意
	 */
	$('.bannermore').click(function(){
		obj = $(this);
		if(obj.hasClass('closed_red') && !obj.hasClass('loaded')){
			$.ajax({
			    url: '../Solution/AjaxGetBannersBySolutionID',
			    data: 'id=' + obj.attr('_id'),
			    type: 'GET',
			    dataType: 'html',
			    timeout: 10000,
			    error: function(){
			        alert('Error loading');
			    },
			    success: function(data){
					obj.addClass('loaded');
					obj.addClass('open_red');
					obj.removeClass('closed_red');
					obj.parent().parent().after(data);
			    }
			});
		} else if (obj.hasClass('closed_red') && obj.hasClass('loaded')){
			obj.addClass('open_red');
			obj.removeClass('closed_red');
			obj.parent().parent().next().show();
		} else if(obj.hasClass('open_red') && obj.hasClass('loaded')){
			obj.removeClass('open_red');
			obj.addClass('closed_red');
			obj.parent().parent().next().hide();
		}
		return false;
	});
});