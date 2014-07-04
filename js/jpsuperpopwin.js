/*
    Author:jim
*/
 

var popwin = function popwin(){
	this.popwin  = null;
	this.popwinForm = null;
	this.defaultDataItem = null;
	this.item = null; 
	this.init();
	
};

popwin.prototype.init = function(){
	if(this.popwin)
		return;
	this.popwin  = $('<div class="jp_superpopwin"></div>');	
	this.popwin.hide();
	$(document.body).append(this.popwin);
	//Stopping event bubble.(click popwin area.)
	this.popwin.bind('click',function(e){
		return false;
	});
	
	//Reset this func when running.
	
	this.popwinHideFunc = null;

	var self = this;
	
	this.documentCallback = function(e){
		self.popwinHideFunc && self.popwinHideFunc(e);
	};
	$(document).bind('click',this.documentCallback);
};
popwin.prototype.getWH = function(){
	return [this.popwin.width(),this.popwin.height()];
};
popwin.prototype.create = function(dDataItemObj,item,x,y,$tg,enterCb){
	if(!this.popwin) return ;

	/*
		reset pop-win content.
	*/
	

	this.popwin.html('');

	this.defaultDataItem = null;
	this.defaultDataItem = dDataItemObj || {};
	this.item = item; 


/*
{
	showType:,
	title:,
	memo:,
	name:,
	format:,
	length:,
	property:,
	isNeed:,
	definedRule:
}
*/


	var showtype = [
		['custom','预设置'],
		['text','文本'],
		['textarea','文本域'],
		['radio','单选'],
		['checkbox','复选'],
		['select','下拉列表']
	];

	var initList = function(_itm){
		_itm = !_itm ? '' : _itm;
		var s = '<div class="navlist"><ul>';
		for(var i=0,len = showtype.length; i<len;i++){				
			s+= '<li class="' + (_itm == showtype[i][0] ? 'selected' : '') + (i==0 ? ' first' : i==len -1 ? ' last':'') + '" _type="' + showtype[i][0] + '">' + showtype[i][1] + '</li>';
		}
		s += '</ul></div>';
		return s;
	};

	var initBtnbar = function(){
		return '<div class="btnbar"><input type="submit" value="确认" class="singleBtn enterBtn" /><input type="button" value="关闭" class="singleBtn closeBtn" /></div>';
	};

	


	var datatype = this.defaultDataItem.showType || 'custom';

 

	//init nav-list.
	var $navlist = $(initList(datatype));
	var self = this;		
	$navlist.click(function(e){
		var $tg = $(e.target);
		if($tg.hasClass('selected') || $tg.attr('tagName')!='LI') return;
		var _type = $tg.attr('_type');
		$tg.parent().find('li').removeClass('selected');
		$tg.addClass('selected');
		
		var $form = self.__popwinForm;
		var _title = $form.find('input.datatitle').val();
		var _property = $form.find('select.dataproperty').val();
		var	_memo = $form.find('textarea.datamemo').val();
		self.defaultDataItem = self.defaultDataItem ? self.defaultDataItem : {};
		self.defaultDataItem.title = _title;
		self.defaultDataItem.memo = _memo;
		self.defaultDataItem.property = _property;

		self.refreshContent(_type);
		return false;
	});
	this.popwin.append($navlist);


	
	this.__popwinForm = $('<form class="popwinform"></form>');

	this.popwinForm = $('<div class="formeles"></div>');
	this.__popwinForm.append(this.popwinForm);
	this.popwin.append(this.__popwinForm);

	//----------------
	//validator
	
	var validatorSettings = {
			rules: {
				title:  {
					required:true,
					maxlength: 50
				},
				memo:{
					maxlength:200
				}
			},
			messages: {
				title:{
					required:'请输入标题',
					maxlength: '标题不能超过50个字符'
				},
				memo:{
					maxlength:'不能超过200个字符!'
				}

			},
			submitHandler: function(){

	try{
					var serializeArry = self.__popwinForm.serializeArray(); 
					var showType= self.__popwinForm[0]['showType'].value;
					var title= self.__popwinForm[0]['title'].value;
					if(showType == 'radio' || showType == 'checkbox' || showType == 'select'){
						var tmp = {
							name:'defaultValues',
							value:[]
						};
						self.__popwinForm.find('div.formlist.select tr.data').each(function(){
							var _v = $(this).find('input.value').val();
							var _k = $(this).find('input.key').val();
							tmp.value.push([_k,_v]);
						});
						serializeArry.push(tmp);
					}
	}catch(e){
		console&&console.log(e);
	}
					enterCb($tg,showType,title,serializeArry);
					self.__popwinForm.find('input.closeBtn').trigger('click');
					return false;
			}
		};
//		if(datatype == 'text'){
//			validatorSettings.rules.length_value = {
//						required:'[name=length][value=0]:checked',
//						digits: true
//					};
//			validatorSettings.messages.length_value = {
//						required:'请输入一个非负整数',
//						digits: '非负整数'
//			};
//
//		}


	$.validator.addMethod("lengthneed", function(value, element) { 		  
	   var radio = $(element).parent().prev().find('input[name=length_value]').is(":checked");
	   if(radio)
			return $.trim(value) != '' && /^\d+$/.test(value);
	   else
			return true ;   	
	 }, "请输入一个非负整数！");   

	
	var $btnbar = $(initBtnbar());
	

	this.popwinHideFunc = function(e){
		if($tg)
			self.popwin.fadeOut('fast',function(e){
				$tg.parent().removeClass('focus');
				self.popwinHideFunc = null;
			});
		else
			self.popwin.fadeOut('fast',function(e){
				self.popwinHideFunc = null;
			});	
	};


	$btnbar.find('input.enterBtn').click(function(){
		//enterCb($tg,,'',serializestr);
		//$btnbar.closest('form').submit();
		self.__popwinForm.trigger('submit');
		return true;
	});
	$btnbar.find('input.closeBtn').click(this.popwinHideFunc);

	this.__popwinForm.append($btnbar);


	this.refreshContent(datatype);





	this.popwin.fadeIn('fast',function(){
		setTimeout(function(){self.__popwinForm.validate(validatorSettings)},10);	
	});
	
	this.popwin.css({
		left: x + 'px',
		top: y + 'px'
	});
	if($tg)
		$tg.parent().addClass('focus');


};

popwin.prototype.refreshContent = function(datatype){
	if(!this.popwinForm) return;

	var datatype = datatype;

	// about tmpl.
	// speed
	var __tmpl = function(s){
		return $.template(s);
	};

	var _selectHtml = function(hash,checkeditem,cls,name){
		var _arr =['<select class="' + cls + '" name="' + name + '">'];
			//console.log(hash);
			for(var p in hash){ 
				_arr.push('<option value="' + p + '"');
				if(checkeditem && checkeditem == p){
					_arr.push(' selected="selected"');
				}
				_arr.push('>' + hash[p] + '</option>');
			}
			_arr.push('</select>');
		try{
			 
			return _arr.join('');
		}finally{
			_arr = null;
		}
	};


	var __evalHtml = {
		datacustom:function(hash,checkeditem){return _selectHtml(hash,checkeditem,'datacustom','definedRule')},
		dataformat:function(hash,checkeditem){return _selectHtml(hash,checkeditem,'dataformat','format')},
		datalen:function(len){
				len = parseInt(len,10);
				var _arr =[''];
				_arr.push('<label><input name="length_value" type="radio" class="radio" value="-1"');
				if(len<0)
					_arr.push(' checked="checked"');
				_arr.push(' />任意长度</label>');

				_arr.push('<label><input name="length_value" type="radio" class="radio" value="0"');
				if(len>=0){
					_arr.push(' checked="checked" />');
					_arr.push('自定义</label><span>（至少）：<input class="fnumber datalen lengthneed" name="__length" maxlength="5"    type="text"');
				}else{
					_arr.push(' />');
					_arr.push('自定义</label><span style="display:none;">（至少）：<input class="fnumber datalen lengthneed" maxlength="5"    name="__length" type="text"');
				}
				
				(len>=0) && _arr.push(' value="' + len + '"');
				
				_arr.push(' /></span>');

													
			try{
				 
				return _arr.join('');
			}finally{
				_arr = null;
			}
		},
		dataRequired:function(_v,count){
			var _arr =[''];			
			_v = parseInt(_v,10);
			if(isNaN(_v) || _v<1){
				_arr.push('<label><input name="isNeed" type="radio" class="radio datareq" value="-1" ' + (_v==-1 ? 'checked="checked"' : '') +' />是</label><label><input name="isNeed" type="radio" class="radio datareq" value="-2" ' + (_v!=-1 ? 'checked="checked"' : '') +' />否</label>');	
			}else{
 
				_arr.push('<input class="fnumber datareqv required" digits="true" max="' + (count || 0)  + '" value="' + _v + '" type="text" name="isNeed" />');
			}
			try{
				 
				return _arr.join('');
			}finally{
				_arr = null;
			}
		},
		datatitle:function(_v){
			_v = !_v ? '' : _v;
			return '<input class="datatitle" value="' + _v + '" type="text" name="title"  />' ;
		},
		datamemo:function(_v){
			_v = !_v ? '' : _v;
			return '<textarea class="datamemo" name="memo">' + _v + '</textarea>';
		},
		dataproperty:function(hash,checkeditem){return _selectHtml(hash,checkeditem,'dataproperty','property')}

	};


	var commonRule = __tmpl('<div class="formlist common">\
							<table width="100%" border="0" cellspacing="0" cellpadding="0">\
									<tr>\
											<td class="t">标题：</td>\
											<td>\
												${datatitle}\
											</td>\
									</tr>\
									<tr>\
											<td class="t">属性：</td>\
											<td>\
												${dataproperty}\
											</td>\
									</tr>\
									<tr>\
											<td class="t">说明：</td>\
											<td>\
												${datamemo}\
											</td>\
									</tr>\
							</table>\
						</div>');		 
	var ruleList = {
		text: __tmpl('<div class="formlist text">\
								<table   border="0" cellspacing="0" cellpadding="0">\
										<tr>\
												<td class="t">数据格式：</td>\
												<td>\
													${dataformat}\
												</td>\
										</tr>\
										<tr>\
												<td class="t">长度限制：</td>\
												<td>\
													${datalen}\
												</td>\
										</tr>\
										<tr>\
												<td class="t">${datareqtitle}：</td>\
												<td>\
													${datareq}\
												</td>\
										</tr>\
								</table>\
							</div>'),
		textarea:__tmpl('<div class="formlist textarea">\
								<table   border="0" cellspacing="0" cellpadding="0">\
										<tr>\
												<td class="t">长度限制：</td>\
												<td>\
													${datalen}\
												</td>\
										</tr>\
										<tr>\
												<td class="t">${datareqtitle}：</td>\
												<td>\
													${datareq}\
												</td>\
										</tr>\
								</table>\
							</div>'),
		'select':__tmpl('<tr class="data">\
										<td class="c c1"><input maxlength="100" type="text" name="value-${index}" value="${value}" class="value required" /></td>\
										<td class="c c2"><input maxlength="100" type="text" name="key-${index}" value="${key}" class="key required" /></td>\
										<td class="c c3"><a class="singleBtn ${cls}" href="#">&nbsp;</a></td>\
						 </tr>'),
		'custom':__tmpl('<div class="formlist custom">\
								<table   border="0" cellspacing="0" cellpadding="0">\
										<tr>\
												<td class="t">预设值：</td>\
												<td>\
													${datacustom}\
												</td>\
										</tr>\
								</table>\
							</div>')
	};	 
//	alert(__evalHtml.dataformat({'mail':'mail','url':'url'}));


	this.popwinForm.html('');
	
	//Hidden: showtype attribute.
	this.popwinForm.append('<input class="showType" name="showType" type="hidden" value="' + datatype + '" />');
	
	//Hidden: name attribute.	
	this.popwinForm.append('<input class="dataname" name="__name" type="hidden" value="' + (this.defaultDataItem.name||'noname') + '" />');

	//Hidden: itemCount attribute.	
	if(this.defaultDataItem.itemCount)
		this.popwinForm.append('<input class="datareqicount" name="itemCount" type="hidden" value="' + this.defaultDataItem.itemCount + '" />');
	else
		this.popwinForm.append('<input class="datareqicount" name="itemCount" type="hidden" value="1" />');



	var datatitle = '';
	var datamemo  = '';
	var dataproperty = 'image';
//common property!!!
//init same value.

//	if(datatype == this.defaultDataItem.showType){
		datatitle = this.defaultDataItem.title;
		datamemo  = this.defaultDataItem.memo;
		dataproperty = this.defaultDataItem.property;
//	}
/*
{
	showType:,
	title:,
	memo:,
	name:,
	format:,
	length:,
	property:,
	isNeed:,
	definedRule:
}
*/



	//init common interface.
	this.popwinForm.append( commonRule , {
		datatitle:__evalHtml.datatitle(datatitle),
		datamemo:__evalHtml.datamemo(datamemo),
		dataproperty:__evalHtml.dataproperty(_dataproperty_ ,dataproperty)
	});

	//预设置		
	if(datatype=='custom'){
		var drule = this.defaultDataItem.definedRule ||  'image' ;
		this.popwinForm.append( ruleList[datatype] , {
			datacustom: __evalHtml.datacustom(_definedRule_ ,drule)
		});
		return;		
	}

	//init diff part.
	
	var dataObj = {};

	if(datatype == 'text'){
		var dataFormat = 'url';
		
		var dataLen = -1;
		
		var datareq = -2 ;

		if(this.defaultDataItem && this.defaultDataItem.itemCount>1 && this.defaultDataItem.isNeed < 0 ){
			if(this.defaultDataItem.isNeed == -1)
				datareq = this.defaultDataItem.itemCount ;
			else
				datareq = 0 ;
		}else
			datareq = this.defaultDataItem.isNeed  ;

		var datareqtitle =  '是否必须 ';
		if(this.defaultDataItem && this.defaultDataItem.itemCount>1)
			datareqtitle = datareq <0 ? '是否必须 '  : '组元素' + this.defaultDataItem.itemCount + '个必填限制';

		//var datareqtitle = datareq <0 ? '是否必须 '  : '组元素（' + datareq + '个）必填限制';

		if(datatype == this.defaultDataItem.showType){
			 dataFormat = this.defaultDataItem.format;			
			 dataLen = this.defaultDataItem.length;	
			 if(this.defaultDataItem.itemCount>1  && this.defaultDataItem.isNeed < 0 ){
				if(this.defaultDataItem.isNeed == -1)
					datareq = this.defaultDataItem.itemCount ;
				else
					datareq = 0 ;
			 }else 
				datareq = this.defaultDataItem.isNeed;
			 datareqtitle = datareq <0 ? '是否必须 '  : '组元素' + this.defaultDataItem.itemCount + '个必填限制';
		}
/*
	{
		showType:,
		title:,
		memo:,
		name:,
		format:,
		length:,
		property:,
		isNeed:,
		definedRule:
	}
*/


		dataObj = {
			 dataformat:__evalHtml.dataformat(_dataformat_ ,dataFormat),
			 datalen:__evalHtml.datalen(dataLen),
			 datareq:__evalHtml.dataRequired(datareq,this.defaultDataItem.itemCount),
			 datareqtitle: datareqtitle
		};
		this.popwinForm.append( ruleList[datatype] , dataObj);

		this.popwinForm.find('input[name=length_value]').click(function(){
			//console.log($(this).parent());
			if($(this).val() == '0'){
				$(this).parent().next().show();
			}else{
				$(this).parent().next().next().hide();
			
			}
		});
	}else
		if(datatype == 'textarea'){ 
				
				var dataLen = -1;
				
				var datareq = -2 ;
				if(this.defaultDataItem && this.defaultDataItem.itemCount>1  && this.defaultDataItem.isNeed < 0 ){
					if(this.defaultDataItem.isNeed == -1)
						datareq = this.defaultDataItem.itemCount ;
					else
						datareq = 0 ;
				}else
					datareq = this.defaultDataItem.isNeed;
				var datareqtitle =  '是否必须 ';
				if(this.defaultDataItem && this.defaultDataItem.itemCount>1)
				datareqtitle = datareq <0 ? '是否必须 '  : '组元素' + this.defaultDataItem.itemCount + '个必填限制';
				
				//var datareqtitle = datareq <0 ? '是否必须 '  : '组元素（' + datareq + '个）必填限制';

				if(datatype == this.defaultDataItem.showType){ 	
					 dataLen = this.defaultDataItem.length;			
					 if(this.defaultDataItem.itemCount>1  && this.defaultDataItem.isNeed < 0 ){
						if(this.defaultDataItem.isNeed == -1)
							datareq = this.defaultDataItem.itemCount ;
						else
							datareq = 0 ;
					}else 
						datareq = this.defaultDataItem.isNeed;
					 datareqtitle = datareq <0 ? '是否必须 '  : '组元素' + this.defaultDataItem.itemCount + '个必填限制';
				}
		/*
			{
				showType:,
				title:,
				memo:,
				name:,
				format:,
				length:,
				property:,
				isNeed:,
				definedRule:,
				defaultValues:
			}
		*/


				dataObj = {
					 datalen:__evalHtml.datalen(dataLen),
					 datareq:__evalHtml.dataRequired(datareq,this.defaultDataItem.itemCount),
					 datareqtitle: datareqtitle
				};		
				this.popwinForm.append( ruleList[datatype] , dataObj);
				this.popwinForm.find('input[name=length_value]').click(function(){
 
					if($(this).val() == '0'){
						$(this).parent().next().show();
					}else{
						$(this).parent().next().next().hide();
					
					}
				});

		}else{
			var $lst = $('<div class="formlist select">\
								<table  border="0" cellspacing="0" cellpadding="0">\
									<tbody>\
										<tr>\
												<td class="t t1">标题</td>\
												<td class="t t2">键值</td>\
												<td class="t t3"><a class="singleBtn add" href="#">&nbsp;</a></td>\
										</tr>\
									</tbody>\
								</table>\
							</div>');
			var list = null;
			var _index = 0;

			if(datatype == this.defaultDataItem.showType){ 	
				 list = this.defaultDataItem.defaultValues;
				 
			}
	/*
		{
			showType:,
			title:,
			memo:,
			name:,
			format:,
			length:,
			property:,
			isNeed:,
			definedRule:,
			defaultValues:
		}
	*/
			if(!list){
				$lst.find('tbody').append( ruleList['select'] , {
					index:_index++,
					key:'',
					value:'',
					cls:'hidden'
				});				
				$lst.find('tbody').append( ruleList['select'] , {
					index:_index++,
					key:'',
					value:'',
					cls:'del'
				});	
			}else{
				if(list.constructor == Array){
					var _cls = '';
					for(var i = 0 ,len = list.length; i<len; i++){
						if(i==0)
							_cls = 'hidden';
						else
							_cls = 'del';
						$lst.find('tbody').append( ruleList['select'] , {
							index:_index++,
							key:list[i][0],
							value:list[i][1],
							cls:_cls
						});								
					}
				}
				
			}
			$lst.click(function(e){
				var $tg = $(e.target);
				if($tg.attr('tagName') != 'A') return;
				if($tg.hasClass('add')){
					$tg.closest('tbody').append( ruleList['select'] , {
						index:_index++,
						key:'',
						value:'',
						cls:'del'
					});	
					return false;
				}else if($tg.hasClass('del')){
					$tg.closest('tr').remove();
					return false;
				}
			});
			this.popwinForm.append($lst);
		}



};