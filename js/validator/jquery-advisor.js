/*
Copyright (c) 2009 Pawe?Miko³ajewski (http://gamma.mini.pw.edu.pl/~mikolajewskip)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/

(function($) {
$.fn.formAdvisor = function(settings) {
 
	settings = jQuery.extend({
			inputClass: 'show_advice',			//class for inputs that should be changed
			inputBgChange: true,				//set false if you don't want to change input background
			clearFieldBackground: '#fff', 		//set input background when not focused
			currentFieldBackground: '#fffadd', 	//set focused input background
			side : 'right', 					//where advisor occurs
			offset : 0 ,						//sometimes you may want to set offset (X)
			fadeTime : 800,						//time of fading in ms
			staticMessage : false,				//if static set to true
			staticId : 'advice_field'
		}, settings);
		
	var formWidth = $(this).width();
	
	var inputElements = this.find('.'+settings.inputClass);

	//this.find('.'+settings.inputClass)
	this.find('input[_title],textarea[_title],select[_title]').focus(function () {
		var title = $(this).attr('_title');
		$('.form_advisor').remove();
		if(settings.inputBgChange){
			inputElements.css('background-color',settings.clearFieldBackground);
			$(this).css('background-color',settings.currentFieldBackground);
		}
		if(settings.staticMessage){
			$('#'+settings.staticId).html(title);
			return;
		}
		var position = $(this).offset(); 
		var advisorElem = $("<div class='form_advisor'>"+title+"</div>");
		var left = position.left + $(this).width() + settings.offset;
		var advisorCss = {
			
			'position' : 'absolute',
			'left' : left + 'px',
			'top' : position.top + 'px',
			'display' : 'none'
		}
		advisorElem.css(advisorCss);
		advisorElem.appendTo('body');
		if(settings.side =='left') 
			advisorElem.css(
				{'left': left - formWidth - advisorElem.width() +'px'
				});
		
		advisorElem.fadeIn(settings.fadeTime);
		 
    });
  };
})(jQuery);