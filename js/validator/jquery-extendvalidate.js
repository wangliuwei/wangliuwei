(function($){
	$.fn.extendvalidate = function(setting){
		$.extend($.validator.prototype,{
				element: function( element ) {
					element = this.clean( element );
					this.lastElement = element;
					this.prepareElement( element );
					this.currentElements = $(element);
					var result = this.check( element );
					if ( result ) {
						delete this.invalid[element.name];
					} else {
						this.invalid[element.name] = true;
					}
					if ( !this.numberOfInvalids() ) {
						// Hide error containers on last error
						this.toHide = this.toHide.add( this.containers );
					}
					this.showErrors();

					/////////////////jim
					if(document.activeElement!=element) return;

					var _pEle = $(element).parent();
					var _needStatusElements = _pEle.find('input,textarea').not(":submit,:reset,:button").filter(function() {
						var ele = $(this);
						return ele.attr('_maxlength'); 
					});	
					try{
						if( (typeof result) == 'undefined' || result){
							_pEle.removeClass('error');
							if($.trim($(element).val())!='')
								if(_needStatusElements.size()>0){
									_pEle.find('div.ProgressBarForInputLen').__removePBarForInputLen($(element));
									_pEle.find('div.ProgressBarForInputLen').__buildPBarForInputLen($(element));

								}
						}else{
							_pEle.addClass('error');
							if(_needStatusElements.size()>0)
								_pEle.find('div.ProgressBarForInputLen').__removePBarForInputLen($(element));

						}
					}catch(e){
						alert(e);
					}
					////////////////
					return result;
				}
		});
	};
	$.extend($.fn,{
		insertInputValidte:function(){
				return this.filter(function(){return $(this).attr('_verify');}).each(function(){
							var _ele = $(this);
							if(_ele.attr('tagName').toLowerCase() != 'input' && _ele.attr('tagName').toLowerCase() != 'textarea') return;
							var _vAttr = _ele.attr('_verify');
							var mArr = _vAttr.split(/\s+/);
							for(var i = 0 ; i < mArr.length; i++){
								var _t = mArr[i];
								var _tArr = _t.split(':');
								if($.trim(_tArr[0])=='') continue;
								if($.trim(_tArr[0])=='required'){
									_ele.addClass('required');
									continue;
								}
								if($.trim(_tArr[0])=='maxlength'){
									_ele.attr('_maxlength',$.trim(_tArr[1]));
								}
								if($.trim(_tArr[1])==''){
									_ele.attr(_tArr[0],'true');
								}else{
									_ele.attr(_tArr[0],$.trim(_tArr[1]));
								}
							}
				});
			}
	});
})(jQuery);
(function($){

if(!window._t){
	window._t = function(str){
		if(!window.imediaDict) return str;
		else
			if(window.imediaDict[str]) return window.imediaDict[str];
			else
				return str;};
}

 jQuery.validator.addMethod("validaccount", function(value, element){ 
   return this.optional(element) || /^[a-zA-Z]+[A-Za-z0-9_]*(\({1}[A-Za-z0-9_]+\))?$/.test(value);  
 }, _t('_verifyAccount'));   


 jQuery.validator.addMethod("validPName", function(value, element){ 
   return this.optional(element) || /^[A-Za-z0-9\u4e00-\u9fa5_]+$/.test(value);  
 }, _t('_verifyPName'));   


 jQuery.validator.addMethod("allyesRuleA", function(value, element){ 
   return this.optional(element) || /^[a-zA-Z_0-9]+$/.test(value);  
 }, _t('_allyesRuleA'));   


 jQuery.validator.addMethod("allyesRuleB", function(value, element){ 
   return this.optional(element) || /^[a-zA-Z_0-9\u4e00-\u9fa5]+$/.test(value);  
 }, _t('_allyesRuleB'));   


 jQuery.validator.addMethod("minItems", function(value, element, param){ 
   return this.optional(element) || this.findByName(element.name).length >= param ;  
 }, $.validator.format(_t('_verifyMinItems')));   

 jQuery.validator.addMethod("maxItems", function(value, element, param){ 
   return this.optional(element) || this.findByName(element.name).length <= param ;  
 }, $.validator.format(_t('_verifyMaxItems')));   



jQuery.validator.addMethod("treeMinItems", function(value, element, param){ 
   return this.optional(element) || this.findByName(element.name).filter(':not(:disabled)').length >= param ;  
 }, $.validator.format(_t('_verifyMinItems')));   

jQuery.validator.addMethod("treeMaxItems", function(value, element, param){ 
   return this.optional(element) || this.findByName(element.name).filter(':not(:disabled)').length <= param ;  
 }, $.validator.format(_t('_verifyMaxItems')));   

 jQuery.validator.addMethod("floatnumber", function(value, element){ 
   return this.optional(element) || /^(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(value);  
 }, _t('_verifyFloat'));   

 jQuery.validator.addMethod("floatlimit", function(value, element, param){ 
   var reg1  = new RegExp("^(?:[0-9]+|[0-9]{1,3}(?:,[0-9]{3})+)(?:\.[0-9]{" + param  + "," + param + "})?$","ig");
   return this.optional(element) || reg1.test(value);  
 }, $.validator.format(_t('_verifyFloatLimit')));  


 
  jQuery.validator.addMethod("allyesRuleD", function(value, element){ 
   return this.optional(element) || /^[a-zA-Z_0-9*\u4e00-\u9fa5]+$/.test(value);  
 }, _t('_allyesRuleD'));   

  jQuery.validator.addMethod("allyesRuleE", function(value, element){ 
   return this.optional(element) || /^[a-zA-Z_0-9,\u4e00-\u9fa5]+$/.test(value);  
 }, _t('_allyesRuleE'));     


	$.extend($.validator.messages,{
		_t: window._t,
		required: _t('_verifyRequired'),
		ip: _t('_verifyIP'),
		email: _t('_verifyEmail'),
		url: _t('_verifyUrl'),
		domain:_t('_verifyDomain'),
		date: _t('_verifyDate'),
		number: _t('_verifyNumber'),
		_number:_t('_verifyEmptyOrNumber'),
		password:_t('_verifyPassword'),
		positiveNumber :_t('_verifyPNumber'),
		phone: _t('_verifyPhone'),
		fax: _t('_verifyFax'),
		zipcode:_t('_verifyZip'),
		equalTo: _t('_verifySameValue'),
                digits: _t('_verifyDigits'),
/*
		remote: "Please fix this field.",
		dateISO: "Please enter a valid date (ISO).",
		dateDE: "Bitte geben Sie ein gültiges Datum ein.",
		numberDE: "Bitte geben Sie eine Nummer ein.",
		digits: "Please enter only digits",
		creditcard: "Please enter a valid credit card number.",
		equalTo: "Please enter the same value again.",
		accept: "Please enter a value with a valid extension.",
*/
		maxlength: $.validator.format(_t('_verifyMaxlength')),
		minlength: $.validator.format(_t('_verifyMinlength')),
		rangelength: $.validator.format(_t('_verifyRangelength')),
		range: $.validator.format(_t('_verifyRange')),
		max: $.validator.format(_t('_verifyMax')),
		min: $.validator.format(_t('_verifyMin'))
	});
})(jQuery);