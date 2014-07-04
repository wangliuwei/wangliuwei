jpNamespace.JpBtnMenu = function (obj){
	if(typeof obj != 'object') obj = {};
	this.metaTitle = obj.metaTitle || 'undefined';
	this.title = obj.title || this.metaTitle;
	this.className = obj.className || '';
	this.showCallback = obj.showCallback ;
	this._jpBtnMenuIndex = jpNamespace.JpBtnMenu.count++; 
};

jpNamespace.JpBtnMenu.count = 0;
jpNamespace.JpBtnMenu.prototype.init = function(){
	var _h = [];
	var className = this.className || 'jpbtnmenu_' + this._jpBtnMenuIndex;
	_h.push('<div class="jpbm_tle" >');
	_h.push('<table><tr><td class="t"><button type="button" tabIndex="0"  id="jpbtnmenu_btn' + (this._jpBtnMenuIndex) + '">' + this.metaTitle +'</button></td><td class="a"><b>&nbsp;</b></td></tr></table>');
	_h.push('</div>');
	_h.push('<div class="jpbm_lst">');
	_h.push('</div>');
	var $div = $('<div class="jpbtnmenu '+ className + '"></div>');
	$div.html(_h.join(''));

	
	this.$title = $div.find('div.jpbm_tle td.t button');
	this.$btn = $div.find('div.jpbm_tle');
	
	this.isOpen = false;

	var hideBtnMenu = function(ev){
		var jpbtnMenuObj = arguments[0].data;
		var $btn = jpbtnMenuObj.$btn;
		var $list =jpbtnMenuObj.$list;
		try{			 
			if(ev && ev.target && (jpNamespace.isDomContains($btn[0],ev.target) || $btn[0] == ev.target || jpNamespace.isDomContains($list[0],ev.target) || $list[0] == ev.target)){
				return true;
			}
		}catch(e){
		
		}
		$btn.parent().removeClass('jpbtnmenu_on');
		$list.hide();
		$(document).unbind('click',arguments.callee);	
		jpbtnMenuObj.isOpen = !jpbtnMenuObj.isOpen;
		return true;
	};
	
	this.closeHandler = function(){
		hideBtnMenu({data:this});
		this.isOpen = false;
	};


//	this.$title.focus(function(){
//				$(this).blur();
//	});

	this.$btn.bind('click',this,function(){
		var jpbtnMenuObj = arguments[0].data;
		if(jpbtnMenuObj.isOpen){ 
			jpbtnMenuObj.$list.parent().removeClass('jpbtnmenu_on');
			jpbtnMenuObj.$list.hide();
			$(document).unbind('click',hideBtnMenu);
		}else{
			jpbtnMenuObj.$list.parent().addClass('jpbtnmenu_on');
			jpbtnMenuObj.$list.show();

			var $tleBar = jpbtnMenuObj.$title.closest('div.jpbm_tle');
			var offset = $tleBar.offset();
			if(offset.left + $tleBar.width() < jpbtnMenuObj.$list.width()){
				jpbtnMenuObj.$list.css({
					left:0,
					right:'auto'
				});
			}else{
				jpbtnMenuObj.$list.css({
					left:'auto',
					right:0
				});			
			}
 
			if(typeof jpbtnMenuObj.showCallback == 'function')
					jpbtnMenuObj.showCallback();
			$(document).bind('click',jpbtnMenuObj,hideBtnMenu);	
		}
		jpbtnMenuObj.isOpen = !jpbtnMenuObj.isOpen;
		return true;
	});
	this.$list = $div.find('>div.jpbm_lst');
	this.closeHandler();
	
//	this.$list.click(function(){
//		//return false;
//	});

	try{
		return $div;
	}finally{
		_h = null;

	}
};
jpNamespace.JpBtnMenu.prototype.setTitle = function(t){
	if(typeof t == 'undefined'){
		this.$title.html(this.metaTitle);
	}else{
		this.$title.html(this.title.replace(/\{0\}/g,t));
	} 
};