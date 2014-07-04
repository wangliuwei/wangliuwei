/**
 * @author Nivanka
 */
(function($) {
	
	$.progressbar = {
		defaults: {
			background : '#CCC',
			foreground : '#000099',
			textColor : '#FFF',
			start : '0',
			end :  '100',
			value : 5,
			textView : true,
			success : function(){},
			onProgressing:function(){},
			sbackground:'#ccc',
			sforeground:'red'
		}
	};
	
	$.fn.extend({
			
  		ProgressBar : function (settings){		
			$defaults = $.extend({},  $.progressbar.defaults, settings);
			
			$height = $(this).height();
			$width = $(this).width();
			$(this).attr('start', $defaults.start);
			$(this).attr('end', $defaults.end);
			$(this).css('background', $defaults.background);
			//$(this).css('border', '1px solid '+$defaults.foreground);
			$(this).css('padding', '0');
			$(this).css('padding', '0px');
			$bar = $('<div></div>');
			$(this).append($bar);
			$bar.css('background', $defaults.foreground);
			$bar.css('width', parseInt(($width / ($defaults.end - $defaults.start)) * $defaults.value) + 'px');
			$bar.css('height', $height + 'px');
			if ($defaults.textView) {
				$viewer = $('<p></p>');
				$viewer.css('text-align', 'center');
				$viewer.css('padding', '0px');
				$viewer.css('margin', '-' + $height + 'px 0px 0px 0px');
				$viewer.css('font-size', '11px');
				$viewer.css('width', $width + 'px');
				$viewer.css('line-height', $height + 'px');
				$viewer.css('color', $defaults.textColor);
				$viewer.html($defaults.value + '%');
				$(this).append($viewer);
			}
			if($(this).getValue() == $end){
				$defaults.success();
				$(this).css('background', $defaults.sbackground);
				$bar =  $(this).find('div');
				$bar.css('background', $defaults.sforeground);
			}else{
				$defaults.onProgressing();
				$(this).css('background', $defaults.background);
				$bar =  $(this).find('div');
				$bar.css('background', $defaults.foreground);				
			}
			$(this).data('$defaults',$defaults);
		},
		
		getValue : function(){
			$width = $(this).find('div').width();
			$start = $(this).attr('start');
			$end = $(this).attr('end');
			$parentWidth = $(this).width();
			return parseInt(($width / $parentWidth) * ($end - $start));
		},
		
		setValue : function($val){
			var $defaults = $(this).data('$defaults');
			$val = parseInt($val);
			$start = $(this).attr('start');
			$end = $(this).attr('end');
			if($val > $end){
				throw "UnsupportedBoundsException";
			}
			$parentWidth = $(this).width();
			$(this).find('div').css('width', parseInt( ($parentWidth / ($end - $start)) * $val ) + 'px');
			if($viewer = $(this).find('p')){
				$viewer.html(parseInt($(this).getValue()) + '%');
			}
			if($defaults){
				if($(this).getValue() == $end){
					$defaults.success();
					$(this).css('background', $defaults.sbackground);
					$bar =  $(this).find('div');
					$bar.css('background', $defaults.sforeground);
				}else{
					$defaults.onProgressing();
					$(this).css('background', $defaults.background);
					$bar =  $(this).find('div');
					$bar.css('background', $defaults.foreground);				
				}
			}
		},
		
		resetValue : function(){
			try{
				$(this).setValue(0);
			}
			catch(err){
			}
		},
		
		increase : function(val){
			val = parseInt(val);
			try{
				$(this).setValue($(this).getValue() + val);
			}
			catch(err){
			}
		},
		
		decrease : function(val){
			val = parseInt(val);
			try{
				$(this).setValue($(this).getValue() - val);
			}
			catch(err){
			}
		}		
		
	});
})(jQuery);
