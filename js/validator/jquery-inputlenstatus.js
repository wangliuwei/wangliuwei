(function($){ 
	$.fn.extend({
		welcomeInputLenStatus:function(settings) {
		
				settings = $.extend({}, settings);		

				
				var _needStatusElements = this.find('input,textarea').not(":submit,:reset,:button").filter(function() { return $(this).attr('_maxlength'); });
				
				var isArrow = function(v){
					return v>=37&&v<=40;
				};					
				var _ctrEnter = function(event){
						var _kc = event.keyCode;
						if( _kc==8 || _kc == 46 || isArrow(_kc)){//delete backspace arrow is valid input.
							return true;
						}else{
							return false;
						}
				};
				var _substring = function(str,len){
					if(!str) return '';
					var strTemp = str;
					strTemp = String(strTemp);
					var sum = 0;
					var end = 0;
					for(var i = 0 ; i < strTemp.length; i++){
					  if((strTemp.charCodeAt(i)>=0) && (strTemp.charCodeAt(i)<=255))    
						sum=sum+1;
					  else
						sum=sum+2;
					  if(sum>=len) break;
					}
					if(sum>len)
						end = i;
					else{
						if(sum==len)
							end = i + 1;
						else
							end = strTemp.length;
					}
					return str.substring(0,end);
				};
			
				function _focus(_this){
					var pbar = _this.parent().find('.ProgressBarForInputLen');

					//pbar.__resetInputValue(_this);
					if($.trim(_this.val())!=''){ //非空时候显示长度进度
						if(!_this.parent().hasClass('error')){
							if(pbar.size()!=0)	pbar.remove();
							pbar.__buildPBarForInputLen(_this);
						}
					}				
				
				}
				function _blur(_this){
					var pbar = _this.parent().find('.ProgressBarForInputLen');
					pbar.__removePBarForInputLen(_this);
					pbar.__resetInputValue(_this);
					
					var _treatas2 = !!_this.attr('_TTWO');//TTWO = treat chinese as 2 letters.
					var _limitLen =  _this.attr('_maxlength');
					var _v = _this.val();
					if(_treatas2){
						_this.val(_substring(_v,_limitLen));
					}
				}
				function _keydown(_this,e){
						var _pbar = _this.parent().find('div.ProgressBarForInputLen');
						var _limitLen =  _this.attr('_maxlength');
						var _v = _this.val();
						var _treatas2 = !!_this.attr('_TTWO');//TTWO = treat chinese as 2 letters.
						var _nlen = _pbar.__getCharsLen(_v,_treatas2);
						//var _rLen = _nlen;
						_nlen = _pbar._getValidLen(_nlen,_limitLen);
						_pbar.setValue(_nlen);

						return true;
				}
				function _keyup(e,_this){
						var _pbar = _this.parent().find('div.ProgressBarForInputLen');

						function getPos(textBox){
							var start=0,end=0;
							if(typeof(textBox.selectionStart) == "number"){
								start = textBox.selectionStart;
								end = textBox.selectionEnd;
							}
							else if(document.selection){
											var l=window.document.selection.createRange();
											var z=textBox.createTextRange();
											if(z==null||l==null||((l.text!="")&&z.inRange(l)==false)){return -1;}
											if(l.text==""){
												if(z.boundingLeft==l.boundingLeft){
													Q=0;
												}
												else{
													if(textBox.tagName=="INPUT"){
														var I=z.text;
														var U=1;
														while(U<I.length){
															z.findText(I.substring(U));
															if(z.boundingLeft==l.boundingLeft){
																break;
															}
															U++;
														}

													}
													else{
														if(textBox.tagName=="TEXTAREA"){
															var U=textBox.value.length+1;
															var s=document.selection.createRange().duplicate();
															while(s.parentElement()==textBox&&s.move("character",1)==1){  --U; }
															if(U==textBox.value.length+1){	U=-1;	}
														}
													}
													Q=U;
												}
										 }
										 else{
											Q=z.text.indexOf(l.text);
										}
										start=end = Q;
								}
							return {start:start,end:end};
						}
						function setPos(aCtrl, aPos) {
							if (aCtrl.setSelectionRange) {
								setTimeout(function() {
									aCtrl.setSelectionRange(aPos, aPos);
									aCtrl.focus();
								}, 0);
							} else if (aCtrl.createTextRange) {
								var rng = aCtrl.createTextRange();
								rng.collapse(true);
								//rng.moveStart('character', aPos);
								//rng.moveEnd('character', aPos);
								rng.move('character', aPos);
								rng.select();
							}
						}


						var isArrowKey = (e.keyCode >=37 && e.keyCode <=40 ? true : false);
//						if(!isArrowKey) {
//							var _originalPos  = getPos(_this[0]);
//							_pbar.__resetInputValue(_this);
//							var _okPos = (_originalPos.start >= _this.val().length ? _this.val().length: _originalPos.start);
//							setPos(_this[0],_okPos);
//						}

						var _limitLen =  _this.attr('_maxlength');
						var _v = _this.val();	
						var _treatas2 = !!_this.attr('_TTWO');//TTWO = treat chinese as 2 letters.
						var _nlen = _pbar.__getCharsLen(_v,_treatas2);
						var _rLen = _nlen;
						_nlen = _pbar._getValidLen(_nlen,_limitLen);
						_pbar.setValue(_nlen);
						
						if($.trim(_this.val())!=''){ //非空时候显示长度进度
							if(_this.parent().hasClass('error')){if(_pbar.size()!=0)_pbar.__removePBarForInputLen(_this); return;}
							else if(_pbar.size()==0) _pbar.__buildPBarForInputLen(_this);
						}else{//隐藏长度进度
							_pbar.__removePBarForInputLen(_this);
						}

						//if(_treatas2){
						//	if((_rLen > _limitLen) && !_ctrEnter(e)){
						//		return false;
						//	}
						//}
						if(_treatas2){
							if(!_ctrEnter(e)&&!e.ctrlKey)
								_this.val(_substring(_v,_limitLen));
						}
						return true;
				}


				var _self = this;
				_self.listen("focus", "input", function (event) {
					var _this = $(this);
					if($(this).attr('_maxlength')){
//						event.preventDefault(); 
//						event.stopPropagation();
						_focus(_this);
						//return false;
					}
				}).listen("focus", "textarea", function (event) {
					var _this = $(this);
					if($(this).attr('_maxlength')){
//						event.preventDefault(); 
//						event.stopPropagation();
						_focus(_this);
						//return false;
					}
				}).listen("blur", "input", function (event) {
					var _this = $(this);
					if($(this).attr('_maxlength')){
//						event.preventDefault(); 
//						event.stopPropagation();
						_blur(_this);
						//return false;
					}
				}).listen("blur", "textarea", function (event) {
					var _this = $(this);
					if($(this).attr('_maxlength')){
//						event.preventDefault(); 
//						event.stopPropagation();
						_blur(_this);
						//return false;
					}
				}).listen("keydown", "input", function (event) {
					var _this = $(this);
					if($(this).attr('_maxlength')){
//						event.preventDefault(); 
//						event.stopPropagation();
						return _keydown(_this,event);
						//return false;
					}
				}).listen("keydown", "textarea", function (event) {
					var _this = $(this);
					if($(this).attr('_maxlength')){
//						event.preventDefault(); 
//						event.stopPropagation();
						return _keydown(_this,event);
						//return false;
					}
				}).listen("keyup", "input", function (event) {
					var _this = $(this);
					if($(this).attr('_maxlength')){
//						event.preventDefault(); 
//						event.stopPropagation();
						_keyup(event,_this);
						//return false;
					}
				}).listen("keyup", "textarea", function (event) {
					var _this = $(this);
					if($(this).attr('_maxlength')){
//						event.preventDefault(); 
//						event.stopPropagation();
						_keyup(event,_this);
						//return false;
					}
				});

		},
		//根据实际长度截取有效长度值！
		//
		_getValidLen : function(___nLen,___limitLen){
			return ___nLen>= ___limitLen ? ___limitLen : ___nLen;
		},
		
		//获得输入框的字符/字节长度
		//
		__getCharsLen : function (strTemp,treatcas2){    
			var i,sum;    
			sum=0;    
			for(i=0;i<strTemp.length;i++){    
			  if((strTemp.charCodeAt(i)>=0) && (strTemp.charCodeAt(i)<=255))    
				sum=sum+1;
			  else{   
				if(!treatcas2)
					sum=sum+1; 
				else
					sum=sum+2;
			  }
			} 
			return sum;    
		},
		
		//在合法的长度下，重置输入框的字符！
		//
		 __resetInputValue: function(ele){
//			var _limitLen = ele.attr('_maxlength');
//			var _nLen = this.__getCharsLen(ele.val());			
//			var _fnLen = this._getValidLen(_nLen,_limitLen);			
//			var _oVal = ele.val();
//			var _Index = 0;
//			var __len = _oVal.length;
//			for(i=0;i< __len;i++){    
//			  if((_oVal.charCodeAt(i)>=0) && (_oVal.charCodeAt(i)<=255))    
//				_Index++;
//			  else   
//				_Index+=1; //2
//			  if(_Index>=_fnLen) break;
//			} 
//			ele.val(_oVal.substring(0,i+1));	
		},

		__buildPBarForInputLen : function (ele){
				if(ele.attr('tagName').toLowerCase() != 'input' && ele.attr('tagName').toLowerCase() != 'textarea') return;

				ele.after('<div style="height:10px; width:50px;padding:0;" class="ProgressBarForInputLen"><\/div>');
				
				var pbar = ele.parent().find('.ProgressBarForInputLen');
				var _limitLen = ele.attr('_maxlength');
				//var _treatas1 = !!ele.attr('TONE');
				var _treatas2 = !!ele.attr('_TTWO');//TTWO = treat chinese as 2 letters.
				var _nLen = this.__getCharsLen(ele.val(),_treatas2);
				_nLen =  this._getValidLen(_nLen,_limitLen);
				pbar.ProgressBar({
									background : '#fff',
									foreground : '#a6d87e',
									start : 0,
									end : _limitLen,
									value : _nLen,
									textView : false,
									success:function(){}
								  });		
		
		},
		__removePBarForInputLen : function(ele){
			var pbar = ele.parent().find('.ProgressBarForInputLen');
			//alert('remove:'+pbar.attr('tagName'));
			if(pbar.size()!=0)	pbar.remove();
		//	this.__resetInputValue(ele);			
		}
	});
})(jQuery);