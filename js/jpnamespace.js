var jpNamespace  = jpNamespace || {};

jpNamespace.isDomContains = document.compareDocumentPosition ?  function(a, b){
										return a.compareDocumentPosition(b) & 16;
							} : function(a, b){
								return a !== b && (a.contains ? a.contains(b) : true);
							};

jpNamespace.jpArrowBtn = function(obj){
	obj = $.extend({
		className:'',
		title:'',
		callback: function(){
			return true;
		}
	},obj);

	var $div = $('<div class="jpbtn jparrowbtn '+ obj.className  + '"></div>');
	$div.html('<div class="c"><table><tbody><tr><td class="t">' + obj.title + '</td><td class="a"><b>&nbsp;</b></td></tr></tbody></table></div>');
	$div.click(function(){
		var c = obj.callback(); 
		if(typeof c == 'undefined')
			return true;
		else
			return !!c ;
	});
	return $div;
};

jpNamespace.jpSimpleBtn = function(obj){ 
	var $btn  = jpNamespace.jpArrowBtn(obj);
	$btn.addClass('jpsimplebtn');
	return $btn;
};

jpNamespace.jpComboBtn = function(obj){
	var $cb = $('<div class="jpcombobtn"><table class="mycombobox"><tr><td></td></tr></table></div>');
 
	
	obj = $.extend({
		className:'',
		title:'',
		reverse:true,
		selectObj:null,
		selectName:'jpcomboname_' + ++jpNamespace.jpComboBtn.count,
		callback: function(){
			return true;
		}
	},obj);


	if(obj.className){
		$cb.addClass(obj.className);
	}
	//select element.
	var $cSelect = null;
	
	if(typeof obj.selectObj == 'object' && obj.selectObj && obj.selectObj.attr && obj.selectObj.attr('tagName') == 'SELECT'){
		$cb.find('td').append(obj.selectObj);
		var name = obj.selectObj.attr('name');
		if(!name)
			obj.selectObj.attr('name',obj.selectName);
		obj.selectObj.combobox({reverse:obj.reverse});
		$cSelect = obj.selectObj;
	}else
		if(Object.prototype.toString.call(obj.selectObj) === '[object Array]'){
				var $select = $('<select id="'+obj.selectName+'" name="'+obj.selectName+'"></select>');
				var _t = [];
				$.each(obj.selectObj,function(i,itm){
					 if(itm[2])
						_t.push('<option value="' + itm[0] + '" selected>' + itm[1] + '</option>'); 
					 else
						_t.push('<option value="' + itm[0] + '">' + itm[1] + '</option>');
				});
				$select.html(_t.join(''));
				$select.appendTo($cb.find('td'));
				$select.combobox({reverse:obj.reverse,changeCallback:obj.changeCallback || function(e,ui){}});
				$cSelect = $select;
		}
//	if(obj.reverse){
//		if($cSelect){
//			
//		}
//	}else{
//		var $input = $cb.find('input.ui-autocomplete-input').val();
//		if($input.size()){
//			
//		}
//	}
	//console.log($cSelect.combobox("widget"));
	return $cb;
};

jpNamespace.jpComboBtn.count = 0;





jpNamespace.mask = function(isMask,title){
	var $bgdiv = $('<div class="jpmask_bg"></div>');
	var $div = $('<div class="jpmask"></div>');
	var $body = $(document.body);

	$bgdiv.css('opacity','0.5');

	$body.append($div);
	$body.append($bgdiv);
	jpNamespace.mask = function(isMask,title){
		isMask = !!isMask;
		if(isMask){
			var optTitle = '';
			optTitle = title || ( jpNamespace.dict && jpNamespace.dict['maskTitle']) || '';
			var _w = $(document).width();
			var _h = $(document).height();
			$bgdiv.css({
					width:_w,
					height:_h
			}).show();
			
			var w = $div.width();
			var h = $div.height();

			$div.css({
					left:Math.abs(_w - w)/2,
					top:Math.abs(_h - h)/2
			}).hide().html(optTitle).fadeIn('slow');			
		}else{
			$div.fadeOut('fast',function(){
				$(this).hide();
				$bgdiv.fadeOut('fast',function(){
								$(this).hide()
							});
			});
			
		}
		return;
	};
	jpNamespace.mask(isMask,title);

};

jpNamespace.jpNormalWin = function(option){
	
	var buttons = {};

	buttons[jpNamespace.dict['alertWin']['Ok']] = function(e) {
 
		$( this ).dialog( "close" );
	};
	option = $.extend({
		width:500,
		height:310,
		modal: true,
		buttons: buttons,
		closeOnEscape: false
	},option);

	var $win = jpNamespace.jpRichWin(option.title || '' , '' , null,option);
	$win.dialog( "option", "dialogClass", 'jprichwin' );
	$win.html('');
	return $win;
};

jpNamespace.jpRichWin = function(title,msg,callback,option){
 
		var count = ++jpNamespace.jpRichWin.count;
		
		var jpWinId =  'jpWin-box-' + count;
		
		//console.log(jpWinId);

		var $win = $( "#" +jpWinId );

		if(!$win.size() || !$win.hasClass('ui-dialog-content')){
			if($win.size()) $win.remove();
			$win = $('<div id="' + jpWinId + '"></div>');
			$win.appendTo('body').dialog(option); 

			$win.bind('showDialog',function(){
				$win = $(this);
				
				var title = arguments[1];
				var msg = arguments[2];
				var callback = arguments[3];
				var isBubble = arguments[4];

				if(typeof isBubble != 'undefined'){
					$win.data('isBubble',isBubble);
					//for stop event-bubble
					//alert win.
				}


				$win.dialog( "option", "title", title );
				if(callback)
					$win.dialog( "option", "beforeClose", callback);
				$win.html('<span class="win_icon">&nbsp;</span>'+msg);	
				$win.dialog("open");		
			});
			$win.trigger('showDialog',[title,msg, callback]);
		
		}
		return $win;
};
jpNamespace.jpRichWin.count = 0;

jpNamespace.jpAlertWin = function(msg,callback,isBubble){
	
	if(typeof isBubble == 'undefined')
		isBubble = true;
	else
		isBubble = !!isBubble;

	var title = (jpNamespace.dict && jpNamespace.dict['alertWin']  && jpNamespace.dict['alertWin'].title) || 'Alert Window' ;
	
	var buttons = {};
	
	buttons[jpNamespace.dict['alertWin']['Ok']] = function(e) {
		if(!$win.data('isBubble')){
			e.stopPropagation();
		}
		$( this ).dialog( "close" );
	};
 
	if(typeof callback != 'function')
		callback  = function(){return true};
	var option = { 
		modal: true,
		closeOnEscape: false,
		buttons: buttons 
	};
	

	var $win = jpNamespace.jpRichWin(title,msg,callback,option);
	$win.dialog( "option", "dialogClass", 'jprichwin alertwin' );

	$win.data('isBubble',isBubble);
	
	jpNamespace.jpAlertWin = function(msg,callback,isBubble){ 
		$win.trigger('showDialog',[title,msg,callback,isBubble]);
	};

 
};
jpNamespace.jpConfirmWin = function(msg,yesCallback,noCallback){
	var title = (jpNamespace.dict && jpNamespace.dict['confirmWin'] && jpNamespace.dict['confirmWin'].title) || 'Confirm Window' ;

	if(typeof callback != 'function')
		callback  = function(){return true};
	var buttons = {};
	
	buttons[jpNamespace.dict['confirmWin']['Yes']] = function() {
		var cb = $( this ).data('YNCallbck');
		var r = false;
		if(typeof callback == 'function')
			r = cb.yes();
		if(r === false) return;
		$( this ).dialog( "close" );
	};
	buttons[jpNamespace.dict['confirmWin']['No']] = function() {
		var cb = $( this ).data('YNCallbck');
		var r = false;
		if(typeof callback == 'function')
			r = cb.no();
		if(r === false) return;

		$( this ).dialog( "close" );
	};
 
	

	var option = { 
		modal: true,		
		closeOnEscape: false,
		buttons: buttons 
	};
	var $win = jpNamespace.jpRichWin(title,msg,callback,option);
 	$win.dialog( "option", "dialogClass", 'jprichwin confirmwin' );

	$win.data('YNCallbck',{yes:yesCallback || function(){return true},no:noCallback|| function(){return true}});
	
	jpNamespace.jpConfirmWin = function(msg,yesCallback,noCallback){
		$win.data('YNCallbck',{yes:yesCallback || function(){return true},no:noCallback|| function(){return true}});
		$win.trigger('showDialog',[title,msg,callback]);
 
	};

};
