/*
	Name	:	Show Flash.
	Author	:	jim
	Date	:	2011/3/23
*/
var __alysLib  = window.__alysLib || {
					console:function(m){
						if(!m) return;						
						var l = document.location;
						if(/[\&\?]alys_console/.test(l)){
							(new Image).src = 'http://www.allyeslib.com/debug?error=' + window.encodeURIComponent(m);
						}else
							if(window.console){
								window.console.log('*** alysLib ERROR: '+m);
							}
					}
				};

if(!__alysLib.flash)
	__alysLib.flash = function(u,w,h,p,d,b,r,a){
		var o = typeof d == 'object' ? d : document.getElementById(d),
			ad;
		p = !p ? 'transparent' : p == 1 ? 'opaque' : 'window';

		if(!r)
			r = [0,0,0,0];
		
		ad='<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://active.macromedia.com/flash2/cabs/swflash.cab#version=4,0,0,0"'+
			' WIDTH="'+w+'" HEIGHT="'+h+'" ID="f'+b+'">'+
			'<PARAM NAME="movie" VALUE="'+u+'">'+
			'<PARAM NAME="wmode" VALUE="'+p+'">'+
			'<PARAM NAME="allowscriptaccess" VALUE="always">'+
			'<EMBED src="'+u+'" WIDTH="'+w+'" HEIGHT="'+h+'" WMODE="'+p+'" TYPE="application/x-shockwave-flash" ALLOWSCRIPTACCESS="always" NAME="f'+b+'"></EMBED>'+
			'</OBJECT>';
		if(o)
			o.innerHTML = (typeof a == 'string' && a !='') ? '<div style="position:relative;z-index:1;width:' + w + 'px;height:' + h + 'px">' + 
									'<div style="position:absolute;left:0;top:0;z-index:2;width:'+w+'px;height:'+h+'px">'+ad+'</div>' + 
									'<a href="' + a + '" target="_blank"  style="background-color:#fff;position:absolute;left:'+ r[3] + 
													'px;top:'+  r[0] + 
													'px;z-index:3;width:'+ (w-r[1]-r[3] )+
													'px;height:'+(h-r[0]-r[2])+
													'px;opacity:0.00001;filter:alpha(opacity=0);">' + 
									'</a>' + 
								 '</div>' : ad;
		else
			__alysLib.console('__alysLib.flash(): \'d\' parameter missing.');
		return d;
	};

//Flash Flash广告

if(!__alysLib.sflash)
	__alysLib.sflash = function(settings){
	try{
		var p  = settings.flashwmode,
			u  = settings.src,
			w  = settings.width,
			h  = settings.height,
			d  = settings.parent,
			hf = settings.href,
			r  = settings.rect,
			ff = settings.flashparamflag,
			fp = settings.flashparam,
			n  = settings.fname;

			if(p === null || typeof p =='undefined')
				p=0;

			if( (typeof hf == 'string' && hf !='') && ff){
				u = u+"?" + fp + "=" + encodeURIComponent(hf);
				__alysLib.flash(u,w,h,p,d,n,r);
			}else{
				__alysLib.flash(u,w,h,p,d,n,r,hf);
			}
	
	}catch(e){	
		__alysLib.console(e.toString());
	}
}

//FixFlash 浮动流媒体

if(!__alysLib.fixflash)
	__alysLib.fixflash = function(initData){
	var fix_pic_width=initData.fix_pic_width;
	
	//height of Ad
	
	var fix_pic_height=initData.fix_pic_height;//Ad URL

	var fix_pic=initData.fix_pic;
	var fix_alt=initData.fix_alt;
	//1:light, 0:no light
	var fix_light = initData.fix_light;
	//name of window
	var fix_tar = initData.fix_tar;
	//horizonal align method:left,1;center,2;right:3;0,defined
	var fix_poleft=initData.fix_poleft;
	//vertical align method:top,1;middle,2;bottom:3;0,defined
	var fix_potop=initData.fix_potop;
	//customsized  offset value from left side
	var fix_defined_left_offset=initData.fix_defined_left_offset;
	
	fix_defined_left_offset =  isNaN(fix_defined_left_offset) ? 0 : parseInt(fix_defined_left_offset);

	//customsized  offset value from top side
	var fix_defined_top_offset=initData.fix_defined_top_offset;
	
	fix_defined_top_offset = isNaN(fix_defined_top_offset)?0:parseInt(fix_defined_top_offset);
	
	//define ad type:swf or pic
	var fix_ad_type=initData.fix_ad_type;
	//define v-offset:swf or pic
	var fix_v_offset= initData.fix_v_offset;
	//define h-offset:swf or pic
	var fix_h_offset= initData.fix_h_offset;
	var fix_main_t_offset=initData.fix_main_t_offset;
	var CreativeCloseStyle =initData.CreativeCloseStyle;
	var CreativeCloseBgColor =initData.CreativeCloseBgColor;
	var CreativeReplayStyle =initData.CreativeReplayStyle;
	var CreativeReplayBgColor =initData.CreativeReplayBgColor;

	var fix_roll=initData.fix_roll;
	var fix_main=initData.fix_main;
	
	var	fix_main_width=initData.fix_main_width;
	var fix_main_height=initData.fix_main_height;
	
	var autoclose=initData.autoclose;
	var btn=initData.btn;
	var flash_trasparent = initData.flash_transparent;
	var clickdiv = initData.clickdiv;
	var flashparam = initData.flashparam;

	var close = btn[0];
	var replay = btn[1];
	
	var fix_IE = document.all ? 1 : 0;

	var __clientHeight = __clientWidth = __scrollLeft = __scrollTop = 0;
	
	var fadestyle="";
	
	var __hposition, __vposition, __closetimeout;

	var standardCompat = document.compatMode.toLowerCase();
	
	var elmDoc=(standardCompat=="backcompat"||standardCompat=="quirksmode")?document.body:document.documentElement;

	__clientWidth=elmDoc.clientWidth;
	
	__clientHeight=elmDoc.clientHeight;
	
	__scrollLeft=elmDoc.scrollLeft;
	
	__scrollTop=elmDoc.scrollTop;

	var randID = (Math.random()).toString().substring(2);
	
	var flashName = "_888_" + randID;

	var $id = function(id){
		return document.getElementById(id);
	};
	var docWrite = function(s){
		document.write(s);
		return false;
	};
	var alysxcf = function(d,u,w,h,p,clickdiv,flashparam){

		docWrite("<div id='" + d + "' style='padding:0px'></div>");
		var n = flashName;
		var hf = initData.href;
		var r  = initData.rect;
		var	ff = initData.flashparamflag;
		var	fp = initData.flashparam;
		if(p === null || typeof p =='undefined')
			p=0;

		if( (typeof hf == 'string' && hf !='') && ff){
			u = u+"?" + fp + "=" + encodeURIComponent(hf);
			return __alysLib.flash(u,w,h,p,d,n,r);
		}else{
			return __alysLib.flash(u,w,h,p,d,n,r,hf);
		}
//		if(clickdiv && flashparam!='')u=u+"?"+flashparam+"="+encodeURIComponent(ADFUSER27);
//		return __alysLib.flash(u,w,h,p,d,flashName,0,ADFUSER27);
	}

	docWrite("<div id='fix_floater" + randID + "' style='position:absolute;padding:0px; visibility:hidden; width:"+fix_pic_width+"px; height:"+fix_pic_height+fadestyle+"px'>");

	if (fix_ad_type=="swf"){//flash
		alysxcf("fix_pic_swf" + randID,fix_pic, fix_pic_width, fix_pic_height,!flash_trasparent ,clickdiv,flashparam);
	}else{//pic
		docWrite("<a href='" + initData.href +"' target='"+fix_tar+"'><img src='"+fix_pic+"' border='0' alt='"+fix_alt+"' WIDTH="+fix_pic_width+" HEIGHT="+fix_pic_height+"></a>"); 
	}
	docWrite("<div id='closedivid" + randID + "' style='background-color:"+CreativeCloseBgColor+";padding:0px;margin:0px;width:"+fix_pic_width +"px;'>" +
				"<table width='"+fix_pic_width+"px' cellspacing=0 cellpadding=0><tr>"+
					"<td id='closedivid" + randID + "_td1' align='center' width='50%' style='cursor:pointer;"+CreativeCloseStyle+"' >"+close+"</td>"+
					"<td id='closedivid" + randID + "_td2' align='center' width='50%' style='cursor:pointer;background-color:"+CreativeReplayBgColor+";padding:0px;"+CreativeReplayStyle+"'>"+replay+"</td></tr></table></div>");
	docWrite("</div>");

 
	$id("closedivid" + randID + "_td1").onclick = function(){
			$id('fix_floater' + randID).style.display='none';
			$id('fix_maindiv' + randID).style.display='none';
	};

	$id("closedivid" + randID + "_td2").onclick=function(){
		ShowDivMain();

	};
 

	docWrite("<div id='fix_maindiv" + randID + "' style='position:absolute;padding:0px; display:none; width:"+fix_main_width+"; height:"+fix_main_height+"' >");
	alysxcf("fix_main_swf" + randID,fix_main, fix_main_width, fix_main_height,!flash_trasparent ,clickdiv,flashparam);
	docWrite("</div>");

//	self.onError=null;       

	function fix_effectFixFloat() {
		 __clientHeight=elmDoc.clientHeight;
		 __clientWidth=elmDoc.clientWidth;
		 __scrollLeft=elmDoc.scrollLeft;
		 __scrollTop=elmDoc.scrollTop;

		 switch (fix_poleft) {
		  case "Vleft":
		   __hposition=__scrollLeft+fix_h_offset+"px";
		   break;
		  case "Vcenter":
		   __hposition=Math.round((__clientWidth-fix_pic_width)/2)+__scrollLeft+"px";
		   break;
		  case "Vright":
		   __hposition=__clientWidth+__scrollLeft-fix_pic_width-fix_h_offset+"px";
		   break;
		  case "Vself":
		   __hposition=__scrollLeft+fix_defined_left_offset+"px";
		   break;
		  default:
		 }
		 
		if(fix_roll)
		{
		 switch (fix_potop) {
		  case "Vtop":
		   __vposition=__scrollTop+fix_v_offset+"px";
		   break;
		  case "Vmiddle":
		   __vposition=Math.round((__clientHeight-fix_pic_height)/2)+__scrollTop+"px";
		   break;
		  case "Vbottom":
		   __vposition=__clientHeight+__scrollTop-fix_pic_height-fix_v_offset-($id('closedivid' + randID)?$id('closedivid'  + randID  ).offsetHeight:0)+"px";
		   break;
		  case "Vself":
		   __vposition=__scrollTop+fix_defined_top_offset+"px";
		   break;
		  default:
		 }
		}
		else
		{
		  switch (fix_potop) {
		  case "Vtop":
		   __vposition=fix_v_offset+"px";
		   break;
		  case "Vmiddle":
		   __vposition=Math.round((__clientHeight-fix_pic_height)/2)+"px";
		   break;
		  case "Vbottom":
		   __vposition=__clientHeight-fix_pic_height-fix_v_offset-($id('closedivid' + randID )?$id('closedivid'  + randID  ).offsetHeight:0)+"px";
		   break;
		  case "Vself":
		   __vposition=fix_defined_top_offset+"px";
		   break;
		  default:
		 }
		} 

		var $floaterStyle = $id("fix_floater"+randID).style;
		$floaterStyle.top=__vposition;
		$floaterStyle.left=__hposition;
		
		__vposition=__scrollTop+fix_main_t_offset+"px";
		
		if(fix_roll) 
			__hposition=Math.round((__clientWidth-fix_main_width)/2)+__scrollLeft+"px";
		else
			__hposition=Math.round((__clientWidth-fix_main_width)/2)+"px";
		
		var $maindivSytle = $id("fix_maindiv" + randID).style;
		$maindivSytle.top=__vposition;
		$maindivSytle.left=__hposition;

	}




	function SetDivTop10091912222259(){
		$id("fix_floater"+randID).style.top=elmDoc.scrollTop+"px";
	}
	function SetDiv2Left10091912222259(){
		$id("fix_floater"+randID).style.left=elmDoc.scrollLeft+elmDoc.clientWidth - CreativeWidth - 10+"px";
	}
	function getFlashObject(movieName){
	  if (window.document[movieName]) 
	  {
		  return window.document[movieName];
	  }
	  if (navigator.appName.indexOf("Microsoft Internet")==-1)
	  {
		if (document.embeds && document.embeds[movieName])
		  return document.embeds[movieName]; 
	  }
	  else // if (navigator.appName.indexOf("Microsoft Internet")!=-1)
	  {
		return document.getElementById(movieName);
	  }
	}
	function ShowDivMain(){
		clearTimeout( __closetimeout);
		try{
			if(fix_IE ==1 ){
				getFlashObject("f"+flashName).Rewind() ;
			}
			else{
				
				getFlashObject("f"+flashName).Rewind();
				//getFlashObject("f"+flashName).childNodes[3].Rewind();
			}
		}catch(e){
		}
		
		$id("fix_maindiv" + randID).style.display="block";
		$id("fix_floater"+randID).style.visibility="hidden";
		__closetimeout=setTimeout(function(){
				CloseDivMain(true)
				},autoclose*1000);  
	}
	function CloseDivMain(flag){
		 $id("fix_maindiv" + randID).style.display="none";  
		 if(flag)
			 $id("fix_floater"+randID).style.visibility="visible";
	}
	window.setInterval(fix_effectFixFloat,200);	 
	window.setTimeout(ShowDivMain,200);

}


//staticFloat静止浮层

if(!__alysLib.staticfloat)
	__alysLib.staticfloat = function(initdata){

			var href 	=	 initdata.href;

			var fix_pic_width	=	initdata.fix_pic_width;

			var fix_pic_height	=	initdata.fix_pic_height;

			var fix_pic	=	initdata.fix_pic;
			var fix_alt	=	initdata.fix_alt;

			var fix_light	=	initdata.fix_light;

			var fix_tar	=	initdata.fix_tar;

			var fix_poleft	=	initdata.fix_poleft;

			var fix_potop	=	initdata.fix_potop;

			var fix_defined_left_offset	=	initdata.fix_defined_left_offset;


			var fix_defined_top_offset	=	initdata.fix_defined_top_offset;

			var fix_ad_type	=	initdata.fix_ad_type;

			var fix_v_offset	=	initdata.fix_v_offset;

			var fix_h_offset	=	initdata.fix_h_offset;
			var CreativeMargin	=	initdata.CreativeMargin;
			var CreativeCloseStyle	=	initdata.CreativeCloseStyle;
			var CreativeCloseBtnPos	=	initdata.CreativeCloseBtnPos;
			var CreativeCloseBtnFlag	=	initdata.CreativeCloseBtnFlag;
			var close	=	initdata.close;
			var closeBgColor	=	initdata.closeBgColor;
			var scrollFlag	=	initdata.scrollFlag;
			var flash_trasparent	=	initdata.flash_trasparent;
			var clickdiv	=	initdata.clickdiv;
			var flashparam	=	initdata.flashparam;
			var fix_bFade	=	initdata.fix_bFade;
			var ff 	=	 initdata.flashparamflag;

			fix_defined_left_offset = isNaN(fix_defined_left_offset)?0:parseInt(fix_defined_left_offset);
			fix_defined_top_offset = isNaN(fix_defined_top_offset)?0:parseInt(fix_defined_top_offset);

			
			var fix_IE = (document.all) ? 1 : 0;
			var _cHeight = _cWidth = _sLeft = _sTop =0;
			
			var fadestyle="";
			
			var _hPosition, _vPosition;


			var standardCompat = document.compatMode.toLowerCase();

			var elmDoc= (standardCompat=="backcompat" || standardCompat=="quirksmode") ? document.body : document.documentElement;

			_cWidth=elmDoc.clientWidth;
			_cHeight=elmDoc.clientHeight;
			_sLeft=elmDoc.scrollLeft;
			_sTop=elmDoc.scrollTop;

			var $id = function(id){
				return document.getElementById(id);
			};

			var dWrite = function(s){
				document.write(s);
			};	
			var flashName = "_888_" + randID;
			
			var showFlash = function (u,w,h,p){
				if(!p)
					p=0;
				var n = flashName;
				
				var d="xc" +  randID;
				
				dWrite("<div id="+d+" style='padding:0px'></div>");

				p=(flash_trasparent)?0:1;

	
				if( (typeof href == 'string' && href !='') && ff){
					u = u+"?" + flashparam + "=" + encodeURIComponent(href);
					return __alysLib.flash(u,w,h,p,d,n,CreativeMargin);
				}else{
					return __alysLib.flash(u,w,h,p,d,n,CreativeMargin,href);
				}
				 
			};

			var randID = (Math.random()).toString().substring(2);

			var fixFloaterId = 'fix_floater' + randID;


			if (fix_light==1)
				fadestyle=";filter:alpha(opacity=50);opacity:0.5";

			dWrite("<div id='" + fixFloaterId + "' style='z-index:99999;position:absolute;padding:0px; visibility:hidden; width:"+fix_pic_width
								+"; height:"+fix_pic_height+fadestyle+"'>");

			var closeDivId = 'closedivid' + randID;

			if(CreativeCloseBtnFlag == "outside"&&CreativeCloseBtnPos <= 2){
				dWrite("<div id='" + closeDivId +  "' style='background-color:"+closeBgColor+";padding:0px;text-align:"+((CreativeCloseBtnPos%2==1)?"left":"right")+";'><span style='cursor:pointer;"+CreativeCloseStyle+"' onclick=\"document.getElementById('" + fixFloaterId + "').style.display='none';\">"+close+"</span></div>");
			}
			if (fix_ad_type=="swf"){//flash
				showFlash(fix_pic, fix_pic_width, fix_pic_height);
			}else{//pic
				dWrite("<a href='"+href+"' target='"+fix_tar+"'><img src='"+fix_pic+
								"' border='0' alt='"+fix_alt+"' WIDTH="+fix_pic_width+" HEIGHT="+fix_pic_height+
								"></a>"); 
			}
			if(CreativeCloseBtnFlag == "outside" && CreativeCloseBtnPos > 2){
				dWrite("<div id='" + closeDivId +  "' style='background-color:" + closeBgColor +
									";padding:0px;text-align:"+((CreativeCloseBtnPos%2==1)?"left":"right")+
									";'><span style='cursor:pointer;"+CreativeCloseStyle+
									"' >"+close+
									"</span></div>");
			}
			dWrite("</div>");

			setTimeout(function(){
				$id(closeDivId) && ($id(closeDivId).getElementsByTagName('span')[0].onclick=function(){
					$id(fixFloaterId).style.display = 'none';
				});		
			},10);

			//position of horizon
			switch (fix_poleft) {
				case "Vleft":
					_hPosition=_sLeft+fix_h_offset+"px";
					break;
				case "Vcenter":
					_hPosition=Math.round((_cWidth-fix_pic_width)/2)+_sLeft+"px";
					break;
				case "Vright":
					_hPosition=_cWidth+_sLeft-fix_pic_width-fix_h_offset+"px";
					break;
				case "Vself":
					_hPosition=_sLeft+fix_defined_left_offset+"px";
					break;
				default:
			}

			//position of vertical
			switch (fix_potop){
				case "Vtop":
					_vPosition=_sTop+fix_v_offset+"px";
					break;
				case "Vmiddle":
					_vPosition=Math.round((_cHeight-fix_pic_height)/2)+_sTop+"px";
					break;
				case "Vbottom":
					_vPosition=_cHeight+_sTop-fix_pic_height-fix_v_offset-($id(closeDivId )?$id(closeDivId ).offsetHeight:0)+"px";
					break;
				case "Vself":
					_vPosition=_sTop+fix_defined_top_offset+"px";
					break;
				default:
			}

			var fix_effectFixFloat= function() {
	
				_cHeight=elmDoc.clientHeight;
				_cWidth=elmDoc.clientWidth;
				_sLeft=elmDoc.scrollLeft;
				_sTop=elmDoc.scrollTop;

				switch (fix_poleft) {
					case "Vleft":
						_hPosition=_sLeft+fix_h_offset+"px";
						break;
					case "Vcenter":
						_hPosition=Math.round((_cWidth-fix_pic_width)/2)+_sLeft+"px";
						break;
					case "Vright":
						_hPosition=_cWidth+_sLeft-fix_pic_width-fix_h_offset+"px";
						break;
					case "Vself":
						_hPosition=_sLeft+fix_defined_left_offset+"px";
						break;
					default:
				}

				switch (fix_potop) {
					case "Vtop":
						_vPosition=_sTop+fix_v_offset+"px";
						break;
					case "Vmiddle":
						_vPosition=Math.round((_cHeight-fix_pic_height)/2)+_sTop+"px";
						break;
					case "Vbottom":
						_vPosition=_cHeight+_sTop-fix_pic_height-fix_v_offset-($id(closeDivId )?$id(closeDivId ).offsetHeight:0)+"px";
						break;
					case "Vself":
						_vPosition=_sTop+fix_defined_top_offset+"px";
						break;
					default:
				}
				var $ffloater = $id(fixFloaterId);
				$ffloater.style.top=_vPosition;
				$ffloater.style.left=_hPosition;
				$ffloater.style.visibility='visible';
				
				if (fix_IE){
					if (fix_light==1){ 
						var nOpacity=$ffloater.filters.alpha.opacity;
						if (nOpacity>=100)
							fix_bFade=true;
						if (nOpacity<=0) 
							fix_bFade=false;
						if (fix_bFade)
							$ffloater.filters.alpha.opacity--;
						else
							$ffloater.filters.alpha.opacity++;
					}
				}
				else{
					if (fix_light==1){ 
						
						var nOpacity=$ffloater.style.opacity;
						
						if (nOpacity>=0.99)
							fix_bFade=true;
						if (nOpacity<=0)
							fix_bFade=false;

						if (fix_bFade)
							$ffloater.style.opacity	=	parseFloat(nOpacity)-0.01;
						else
							$ffloater.style.opacity	=	parseFloat(nOpacity)+0.01;
					}	
				}
			};

			if(scrollFlag)
				window.setInterval(fix_effectFixFloat,200);
			else
				window.setTimeout(fix_effectFixFloat,200);

	}

//moveFloat移动浮层

if(!__alysLib.movefloat)
	__alysLib.movefloat = function(initdata){

	var hf = initdata.href;

	var flow_pic=		initdata.flow_pic;
	var flow_alt=	initdata.flow_alt;
	var flow_speed=	initdata.flow_speed;
	var flow_light=	initdata.flow_light;
	var flow_tar=	initdata.flow_tar;	
	var flow_shakebut=	initdata.flow_shakebut;		
	var flow_shakewin=	initdata.flow_shakewin;		
	var flash_flag=		initdata.flash_flag;	
	var flash_wid=		initdata.flash_wid;	
	var flash_hei=		initdata.flash_hei;	
	var flow_horizon=	initdata.flow_horizon;
	var flow_vertical=	initdata.flow_vertical;
	var CreativeMargin=	initdata.CreativeMargin;
	var CreativeCloseStyle=	initdata.CreativeCloseStyle;
	var CreativeCloseBtnPos=	initdata.CreativeCloseBtnPos;
	var CreativeCloseBtnFlag=	initdata.CreativeCloseBtnFlag;
	var close=	initdata.close;
	var closeBgColor=	initdata.closeBgColor;
	var flash_trasparent=	initdata.flash_trasparent;
	var clickdiv=	initdata.clickdiv;
	var flashparam=	initdata.flashparam;
	var hposition=	initdata.hposition;
	var vposition=	initdata.vposition;
	var flow_stop=	initdata.flow_stop;
	var flow_num=	initdata.flow_num;
	var flow_mie=	initdata.flow_mie;
	var flow_aname=	initdata.flow_aname;
	var flow_vr=	initdata.flow_vr;
	var flow_bFade=	initdata.flow_bFade;

	var flow_timer1;
	var flow_allyes;

	

	var $id = function(id){
		return document.getElementById(id);
	};

	var dWrite = function(s){
		document.write(s);
	};	
	
	var randID = (Math.random()).toString().substring(2);

	/*
		将为浮动对象变量名！
	*/
	var mvId = "AYFlyingAD_" + randID + randID;

	var closeID = 'closedivid' + randID;

	var flow_Chip = function(chipname,width,height){
		this.named=chipname;
		this.vx=flow_speed;
		this.vy=flow_speed;
		this.w=width;
		this.h=height;
		this.xx=0;
		this.yy=0;
		this.flow_timer1=null;
	};




	var pageMode = document.compatMode.toLowerCase();

	var elmDoc=(pageMode=="backcompat"||pageMode=="quirksmode")?document.body:document.documentElement;
	switch (flow_vertical){
	case "right":
		flow_vertical = elmDoc.clientWidth - flash_wid -8;
		hposition = "Math.round(elmDoc.clientWidth - flash_wid -8)";
		break;
	case "mid":
		flow_vertical = elmDoc.clientWidth/2 - flash_wid/2;
		hposition = "Math.round(elmDoc.clientWidth/2 - flash_wid/2)";
		break;
	case "left":
		flow_vertical = 10;
		hposition = 10;
		break;
	case "free":
		hposition = 0;
		break;
	default:
		hposition = flow_vertical;
		break;
	}
	switch ( flow_horizon){
	case "bottom":
		flow_horizon = elmDoc.clientHeight - flash_hei - 5;
		vposition = "Math.round(elmDoc.clientHeight - flash_hei - 5)";
		break;
	case "mid":
		flow_horizon = (elmDoc.clientHeight - flash_hei)/2;
		vposition = "Math.round((elmDoc.clientHeight - flash_hei)/2)";
		break;
	case "top":
		flow_horizon = 10;
		vposition = 10;
		break;
	case "free":
		vposition = 0;
		break;
	default:
		vposition = flow_horizon;
		break;
	}

	if ((flow_horizon!="free") || (flow_vertical!="free")){
		flow_vr=0;
	}



	function flow_movechip(chipname){
		var flowchip=eval('('+chipname+')');

		if (flow_stop!=1){
			pageX=elmDoc.scrollLeft;
			pageW=elmDoc.clientWidth-8;
			pageY=elmDoc.scrollTop;
			pageH=elmDoc.clientHeight;	   
			if ((flow_horizon!="free") && (flow_vertical=="free")){		
				flowchip.yy=eval(vposition); 
			}
			else if ((flow_horizon=="free") && (flow_vertical!="free")){		
				flowchip.xx=eval(hposition);
			}
			flowchip.xx=flowchip.xx+flowchip.vx;
			flowchip.yy=flowchip.yy+flowchip.vy;
			flowchip.vx+=flow_vr*(Math.random()-0.5);
			flowchip.vy+=flow_vr*(Math.random()-0.5);
			if(flowchip.vx>(flow_speed*1.5))  flowchip.vx=(flow_speed)*2-flowchip.vx;
			if(flowchip.vx<(-flow_speed*1.5)) flowchip.vx=(-flow_speed)*2-flowchip.vx;
			if(flowchip.vy>(flow_speed*1.5))  flowchip.vy=(flow_speed)*2-flowchip.vy;
			if(flowchip.vy<(-flow_speed)) flowchip.vy=(-flow_speed)*2-flowchip.vy;
			if(flowchip.xx<=pageX){
			if ((flow_horizon=="free") && (flow_vertical!="free"))
				flowchip.xx=pageX+eval(hposition);
			else	
				flowchip.xx=pageX;
			flowchip.vx=flow_speed;
			}
			if(flowchip.xx>=pageX+pageW-flowchip.w){
			flowchip.xx=pageX+pageW-flowchip.w;
			flowchip.vx=-flow_speed;
			}
			if(flowchip.yy<=pageY){
			if ((flow_horizon!="free") && (flow_vertical=="free"))
				flowchip.yy=pageY+eval(vposition);
			else
				flowchip.yy=pageY;
			flowchip.vy=flow_speed;
			}
			if(flowchip.yy>=pageY+pageH-flowchip.h){	
				flowchip.yy=pageY+pageH-flowchip.h;
				flowchip.vy=-flow_speed;
			}

			$id(flowchip.named).style.left = flowchip.xx + "px";
			$id(flowchip.named).style.top = flowchip.yy + "px";   
			flowchip.flow_timer1=setTimeout(function(){
				flow_movechip(flowchip.named)
			},50);
		}
		else {
 
			flowchip.flow_timer1=setTimeout(function(){
				flow_movechip(flowchip.named)
			},50);
		}
		if (flow_aname.indexOf("MSIE")!=-1){
			if (flow_light==1 && $id(mvId)){
				var _filter = $id(mvId).filters;
				var nOpacity = _filter.alpha.opacity;
				if (nOpacity>=100)
					flow_bFade=true;
				if (nOpacity<=0) 
					flow_bFade=false;
				if (flow_bFade) 
					_filter.alpha.opacity--;
				if (!flow_bFade) 
					_filter.alpha.opacity++;
			}
		}
		else{
			if (flow_light==1 && $id(mvId)){
				var mObjStyle = $id(mvId).style;
				var nOpacity= mObjStyle.opacity;
				
				if (nOpacity>=0.99) 
					flow_bFade=true;
				
				if (nOpacity<=0) 
					flow_bFade=false;
				
				if (flow_bFade) 
					mObjStyle.opacity=parseFloat(nOpacity)-0.01;
				
				if (!flow_bFade) 
					mObjStyle.opacity=parseFloat(nOpacity)+0.01;
			}	
		}
	}
	function flow_stopme(chipname){
		var flowchip=eval('('+chipname+')');
		if(flowchip.flow_timer1 != null ){
			clearTimeout(flowchip.flow_timer1)
		}
	}
	function flow_allyes1(){
		if (flow_num==0){
			window[mvId] = new flow_Chip(mvId,flash_wid,flash_hei+($id(closeID)?$id(closeID).offsetHeight:0));
			$id(mvId)?$id(mvId).style.visibility="visible":"";
			 
			flow_movechip(mvId);	
		}
		flow_num++;
	}


	var flow_a=1;
	var flow_rector=3;

	var getCloseDiv = function (obj){

		if(CreativeCloseBtnFlag != "outside") return;
		
		var pos=( CreativeCloseBtnPos % 2 ==1) ? "left":"right";
		
		var divhtm="<div id='" + closeID +"' style='background-color:"+closeBgColor+";text-align:"+pos+";'><span style='cursor:pointer;"+CreativeCloseStyle+"'  >"+close+"</span></div>";
		
		var o=document.createElement('div');
		
		o.innerHTML = divhtm;

		
		if(CreativeCloseBtnPos > 2)	
			obj.appendChild(o);
		else
			obj.insertBefore(o,obj.firstChild);


		setTimeout(function(){
			$id(closeID).onclick = function(){
				$id(mvId).style.display="none";
			};
		},10);
	
	}

	function flow_rattleimage(){
		if ((!document.all&&!document.getElementById)||(flow_stop==0))
			return;
		if (flow_stop==1){
			var faStyle =  $id(mvId).style;
			switch(flow_a){
				case 1:
					faStyle.top=parseInt(faStyle.top,10) + flow_rector + "px";
					break;
				case 2:
					faStyle.left=parseInt(faStyle.left,10) + flow_rector + "px";
					break;
				case 3:
					faStyle.top=parseInt(faStyle.top,10) - flow_rector + "px";
					break;
				default:
					faStyle.left=parseInt(faStyle.left,10) - flow_rector + "px";
					break;
			}
			
			if (flow_a<4)
				flow_a++;
			else
				flow_a=1;
			setTimeout(flow_rattleimage,50);
		}

	}
	var flow_rectorwin=10;
	
	function flow_boom(n) {
		var winTop =window.top;
 
		if (winTop.moveBy){
			for (i = flow_rectorwin; i > 0; i--){
				for (j = n; j > 0; j--){
					winTop.moveBy(0,i);
					winTop.moveBy(i,0);
					winTop.moveBy(0,-i);
					winTop.moveBy(-i,0);
				}
			}
		
		}
 
		shakewinallyes = setTimeout(function(){
			flow_boom(1)		
		},500);
	}


	var flashName = "_888_" + randID;


	function showFlash(u,w,h,p){
		if(!p)
			p=0;
		
		var d = mvId;
		dWrite("<div id=" + d + " style='position:absolute;visibility:hidden;'></div>");
		
		setTimeout(function(){
			var $mObj = $id(mvId);
			if($mObj){
				$mObj.onmouseover = function(){
					flow_stop=1; 
				};
				$mObj.onmouseout = function(){
					flow_stop=0; 
				};
			}		
		},20);

		p= (flash_trasparent) ? 0 : 1;
		
		var n = flashName; 	

		if( (typeof hf == 'string' && hf !='') && flash_flag){
			u = u + "?" + flashparam + "=" + encodeURIComponent(hf);
			return __alysLib.flash(u,w,h,p,d,n,CreativeMargin);
		}else{
			return __alysLib.flash(u,w,h,p,d,n,CreativeMargin,hf);
		}		

		getCloseDiv($id(d));
	}

	var foImgId =  'flow_oImg' + randID;

	if (flash_flag==0){	 
		var streamArr = [];

		streamArr.push("<div id='" + mvId + "' style='position:absolute;visibility:hidden; ");
		if (flow_light==1){
			streamArr.push(" filter:alpha(opacity=50); opacity:0.5;");
		}
		streamArr.push("'>");

			if(CreativeCloseBtnFlag == "outside" && CreativeCloseBtnPos <= 2){
				streamArr.push("<div id='" + closeID + "' style='background-color:"+closeBgColor+";padding:0px;text-align:"+((CreativeCloseBtnPos%2==1)?"left":"right")+";'><span style='cursor:pointer;"+CreativeCloseStyle+"'>"+close+"</span></div>");
			}
			var aId =  'flow_oA' + randID;
			streamArr.push("<a HREF='" + hf + "' target='" + flow_tar + "' id='" + aId + "'>");
//			streamArr.push("<img width="+ flash_wid +" height="+ flash_hei +" SRC=");
//
//			streamArr.push("'" + flow_pic + "' onload='flow_allyes1()' id='" + foImgId + "' border='0' alt='" + flow_alt + "' >");

			streamArr.push("</a>");

			if(CreativeCloseBtnFlag == "outside"&&CreativeCloseBtnPos > 2){
				streamArr.push("<div id='" + closeID + "' style='background-color:"+closeBgColor+";padding:0px;text-align:"+((CreativeCloseBtnPos%2==1)?"left":"right")+";'><span style='cursor:pointer;"+CreativeCloseStyle+"' >"+close+"</span></div>");
			}
		streamArr.push("</div>");

		dWrite(streamArr.join(''));

		streamArr  = null;

		setTimeout(function(){ 
			var $mObj = $id(mvId);
			if($mObj){
				$mObj.onmouseover = function(){
					flow_stop=1;
					if (flow_shakebut==1){
						flow_rattleimage();
					}
					if (flow_shakewin==1){
						flow_boom(1);
					}
				};
				$mObj.onmouseout = function(){
					flow_stop=0;
					if (flow_shakewin==1){
						clearTimeout(shakewinallyes);
					}
				};
			}
			if($id(closeID))
				$id(closeID).onclick = function(){
					$id(mvId).style.display='none';
				};

			var $aObj = $id(aId);
			if($aObj){
				var img = document.createElement('img');
				img.id = foImgId;
				img.border = 0;
				img.alt = '';
				img.width = flash_wid;
				img.height = flash_hei;
				img.onload = flow_allyes1;
				img.src = flow_pic;		
				$aObj.appendChild(img);
			}

		},20);
	}
	else {	         
		showFlash(flow_pic,flash_wid,flash_hei);
		setTimeout(flow_allyes1,200);
	}

}
//whole_screen全屏广告

if(!__alysLib.wholescreen)
	__alysLib.wholescreen = function(initdata){
				var hf = initdata.href;
				var allyes_picbig=initdata.allyes_picbig;
				var allyes_picsmall=initdata.allyes_picsmall;
				var allyes_goupspeed=initdata.allyes_goupspeed; 
				var allyes_tar=initdata.allyes_tar;

				var $id = function(id){
					return window.document.getElementById(id);
				};

				var dWrite = function(s){
					window.document.write(s);
				};	
				
				var randID = (window.Math.random()).toString().substring(2);

				var imgId = 'wscreen_Img' + randID;
				var srollId = 'wscreen_sroll' + randID;
				
				var stream  = [];

				if (allyes_picsmall!=""){
					stream.push("<a href='"+hf+"' target='"+allyes_tar+"'>");
					stream.push("<img border='0' src='"+allyes_picsmall+"'></a>");
				}

				
				stream.push("<div id='" + srollId + "' style='display: none; overflow: hidden; position: absolute; top:0; left:0'>");
				stream.push("	<a href='"+hf+"' target='"+allyes_tar+"'>");
				stream.push("</a></div>");

				dWrite(stream.join(''));
				stream = null;



				var heightt=0;
				var widthzyp=0;

				var topp=0;
				var leftt=0;

				var jump=30;

				function zyp(){
					var sroll = $id(srollId);
					var sstyle = sroll.style;
					if (heightt >= 0){
						
						sstyle.height = heightt;
						sstyle.top = topp;
						sstyle.width = widthzyp;
						sstyle.left = leftt;

						widthzyp -= 6;
						leftt += 3;
						heightt -= 7;
						topp += 3;
						setTimeout(zyp,allyes_goupspeed);
					}else{
						sstyle.display='none';
					}
				}

				function start(){
					var sroll = $id(srollId);
					var ImgBig = sroll.getElementsByTagName('img')[0];

					heightt= ImgBig.height;
					widthzyp= ImgBig.width;
					if (jump!=0){
						sroll.style.display = 'block';
						jump -= 10;
						setTimeout(start,1000);
					}else{
						zyp();
					}
				}

				setTimeout(function(){			
					var $img = document.createElement('img');
					$img.border = 0;
					$img.id = imgId;
					$img.onload = start;
					$img.src = allyes_picbig + '?' + window.Math.random();
					$id(srollId).getElementsByTagName('a')[0].appendChild($img);
				},10);


			}
			
//background背景广告
			
if(!__alysLib.background)
	__alysLib.background = function(initdata){
	var hf = initdata.href;
	var fix_tar = initdata.fix_tar;
	var fix_alt = initdata.fix_alt;
	var adrimg1 = initdata.adrimg1;
	var adrbackground = initdata.adrbackground;
	var adwidth = initdata.adwidth;
	var adheight = initdata.adheight;
	var fix_ad_type = initdata.fix_ad_type;
	var waitingtime = initdata.waitingtime;
	var optspeed = initdata.optspeed;
	var optlast = initdata.optlast;
	var playtype = initdata.playtype;
	var startback = initdata.startback;
	var flash_trasparent = initdata.flash_trasparent;
	var clickdiv = initdata.clickdiv;
	var flashparam = initdata.flashparam;
	var startflag = initdata.startflag;
	var fix_bFade = initdata.fix_bFade;

	var doc = window.document;


	var $id = function(id){
		return doc.getElementById(id);
	};

	var dWrite = function(s){
		doc.write(s);
	};	
	
	var randID = (window.Math.random()).toString().substring(2);
	var bodyfilterId = "bodyfilter_" + randID;

	var fix_IE=(window.ActiveXObject)?1:0;

	var fix_FireFox=(navigator.userAgent.indexOf("Firefox")!=-1)?1:0;

	var pageMode=doc.compatMode.toLowerCase();

	var elmDoc=(pageMode=="backcompat"||pageMode=="quirksmode")?doc.body:doc.documentElement;
	
	var oldbodyback;
	var allyesbackgroundfinish;

	var showFlash = function (u,w,h,p){
		if(!p)p=0;
		
		var d = "xc83" + randID;

		dWrite("<div id="+d+" style='padding:0px'></div>");

		if(playtype=='1'){
			setTimeout(function(){
				$id(d).onmouseover = changebackground;
			},10);
		}

		p=(flash_trasparent)?0:1;


		var flashName = 'BackgroundAD_flash_' + randID;
		var n = flashName ; 	
		
		if( (typeof hf == 'string' && hf !='') && flashparam){
			u = u + "?" + flashparam + "=" + encodeURIComponent(hf);
			return __alysLib.flash(u,w,h,p,d,n,0);
		}else{
			return __alysLib.flash(u,w,h,p,d,n,0,hf);
		}	
	};
	var changebackground = function (){	
		if(allyesbackgroundfinish != null && allyesbackgroundfinish != finishfunc){
			allyesbackgroundfinish();	
		}

		allyesbackgroundfinish=finishfunc;

		if(startflag)
			return false;
		else
			startflag=true;
		
		oldbodyback = elmDoc.style.background;
		
		elmDoc.style.background="transparent";
		
		var ofilter = $id(bodyfilterId);
		var ofStyle = ofilter.style;
		
		if(fix_IE==1){
			ofilter.filters.alpha.opacity=4;
		}else{
			ofStyle.opacity=0.04;
		}
		ofStyle.width=elmDoc.scrollLeft+elmDoc.clientWidth+"px";
		ofStyle.height=elmDoc.scrollTop+elmDoc.clientHeight+"px";
				
		ofStyle.zIndex=-1;
		ofStyle.display="block";

		ofStyle = null;

		fix_bFade = false;
		
		setTimeout(stepopacity,50);
	};
	var stepopacity = function (){
		var ofilter=$id(bodyfilterId);
		ofilter.style.width=elmDoc.scrollLeft+elmDoc.clientWidth+"px";
		ofilter.style.height=elmDoc.scrollTop+elmDoc.clientHeight+"px";
		if (fix_IE){
			var nOpacity=ofilter.filters.alpha.opacity;
			if (nOpacity>=optlast){
				if(waitingtime){
					fixsize(waitingtime*1000);
					setTimeout(function(){
						ofilter.filters.alpha.opacity=optlast-optspeed;
						fix_bFade=true;
						stepopacity();
					},waitingtime*1000);
				}	
				return;
			}
			if (nOpacity<=0){ 
				finishfunc();
				return;
			}
			
			if (fix_bFade)
				ofilter.filters.alpha.opacity-=optspeed;
			else
				ofilter.filters.alpha.opacity+=optspeed;
		}else{
			var nOpacity=ofilter.style.opacity;
			if (nOpacity>=optlast*0.01){
				fixsize(waitingtime*1000);
				setTimeout(function(){ofilter.style.opacity=optlast*0.01-optspeed*0.01;fix_bFade=true;stepopacity();},waitingtime*1000);
				return;
			}
			if (nOpacity<=0.01){
				finishfunc();
				return;
			}
			
			if (fix_bFade)
				ofilter.style.opacity=parseFloat(nOpacity)-optspeed*0.01;
			else
				ofilter.style.opacity=parseFloat(nOpacity)+optspeed*0.01;
		}
		setTimeout(stepopacity,50);
	};
	var fixsize = function (leftvalue){
		 if(leftvalue>200){
			var ofilter=$id(bodyfilterId);
			ofilter.style.width=elmDoc.scrollLeft+elmDoc.clientWidth+"px";
			ofilter.style.height=elmDoc.scrollTop+elmDoc.clientHeight+"px";
			setTimeout(function(){fixsize(leftvalue-200);},200)	
		 }
	};
	var finishfunc = function (){
			var ofilter=$id(bodyfilterId);
				elmDoc.style.background = oldbodyback;

				ofilter.style.display="none";
				ofilter.style.width="0px";
				ofilter.style.height="0px";

				startflag=false;	
				fix_bFade=false;		
				
				if(allyesbackgroundfinish!=this)
					allyesbackgroundfinish=null;	
	};

	if (fix_ad_type=="swf"){//flash
		showFlash(adrimg1, adwidth, adheight);
	}else{
		var bgImgId = 'BackgroundImg_' + randID ;
		dWrite("<a href='"+hf+"' target='"+fix_tar+"'><img alt='"+fix_alt+"' border='0' src='"+adrimg1+"' style='cursor:pointer;width:"+adwidth+";height:"+adheight+"' id='" + bgImgId + "' /></a>");
		setTimeout(function(){
			if(playtype=='1'){
				$id(bgImgId).onmouseover = changebackground;
			}
		},10);
	}

	dWrite("<div id='"+bodyfilterId + "' style='filter:alpha(opacity=100);position:absolute;z-index:-5;top:0;left:0;width:0;height:0;display:none;background:url("+adrbackground+") repeat;'></div>");

	if(startback=="1"){
		var tmp_old_onoadfunc = window.onload;		
		window.onload=function(){
			if(tmp_old_onoadfunc)	
				tmp_old_onoadfunc();		
			changebackground();
		};	
	}

}



//Name	: Flow TV
if(!__alysLib.flowtv)
	__alysLib.flowtv = function(initdata){
		var hf = initdata.href;
		var fix_tar = initdata.fix_tar;
		var fix_alt = initdata.fix_alt;
		var adcreativeurl = initdata.adcreativeurl;
		var adcreativewidth = initdata.adcreativewidth;
		var adcreativeheight = initdata.adcreativeheight;
		var fix_ad_type = initdata.fix_ad_type;
		var scrollwidth = initdata.scrollwidth;
		var adtvurl = initdata.adtvurl;
		var showtype = initdata.showtype;
		var autocancel = initdata.autocancel;
		var Tvtype = initdata.Tvtype;
		var clickdiv1 = initdata.clickdiv1;
		var clickparam1 = initdata.clickparam1;
		var scrollheight = initdata.scrollheight;
		var flash_trasparent1 = initdata.flash_trasparent1;
		var flash_trasparent2 = initdata.flash_trasparent2;
		var clickdiv2 = initdata.clickdiv2;
		var clickparam2 = initdata.clickparam2;
		var TvWidth = initdata.TvWidth;
		var TvHeight = initdata.TvHeight;
		var scrolllength = initdata.scrolllength;

		if(clickdiv1==1 && clickparam1 !="")
			adcreativeurl=adcreativeurl+"?"+clickparam1+"="+encodeURIComponent(hf);
		if(clickdiv2==1 && clickparam2 !="")
			adtvurl=adtvurl+"?"+clickparam2+"="+encodeURIComponent(hf);
		switch(showtype)
		{
			case 1:
			case 3:
			TvWidth=scrollwidth;
			TvHeight=scrollheight;
			scrolllength=scrollwidth;
			break;
			case 2:
			case 4:
			TvWidth=scrollwidth;
			TvHeight=scrollheight;
			scrolllength=TvHeight;
			break;
		}
		var steptimeout=null;
		var steptimeoutI=null;
		var doc = window.document;

		var pageMode=doc.compatMode.toLowerCase();
		var elmDoc=(pageMode=="backcompat"||pageMode=="quirksmode")?doc.body:doc.documentElement;

		 


		var $id = function(id){
			return doc.getElementById(id);
		};


		var dWrite = function(s){
			doc.write(s);
		};	

		var randID = (window.Math.random()).toString().substring(2); 
		
		var TVdivId = 'TVdiv_' + randID;
		var sourceimgId = 'sourceimg_' + randID;
		 
		function showTV()
		{
				var oImg=$id(sourceimgId);
				var startX=allyes_findPosX(oImg);
				var startY=allyes_findPosY(oImg);
				var startW=oImg.offsetWidth;
				var startH=oImg.offsetHeight;
				var oTv=$id(TVdivId);
				switch(showtype)
				{
					case 1:
					oTv.style.top=startY;
					oTv.style.left=startX;
					oTv.style.height=startH;
					oTv.style.width=0+"px";
					break;
					case 2:
					oTv.style.top=startY;
					oTv.style.left=startX;
					oTv.style.height=1+"px";
					oTv.style.width=startW;
					break;
					case 3:
					oTv.style.top=startY;
					oTv.style.left=startX+startW;
					oTv.style.height=startH;
					oTv.style.width=0+"px";
					break;
					case 4:
					oTv.style.top=startY+startH;
					oTv.style.left=startX;
					oTv.style.height=1+"px";
					oTv.style.width=startW;
					break;	
				}
				oTv.style.display="block";
				steptimeout=setTimeout(function(){
				scrollTVdiv();},100);		
		}
		 
		function scrollTVdiv(){
				var oTv=$id(TVdivId);
				var oImg=$id(sourceimgId);
				var startX=allyes_findPosX(oImg);
				var startY=allyes_findPosY(oImg);
				
				var otvSyl = oTv.style;
				switch(showtype)
				{
					case 1:
						if(oTv.offsetWidth<=(scrolllength-20))
						{
							otvSyl.top=startY;
							otvSyl.left=startX;
							otvSyl.width=parseInt(oTv.offsetWidth,10)+20+"px";
						}
						else
						{
							otvSyl.width=scrolllength+"px";
							var finishflag=true;	
						}
						break;
					case 2:
						if(oTv.offsetHeight<=(scrolllength-20))
						{
							otvSyl.top=startY;
							otvSyl.left=startX;
							otvSyl.height=parseInt(oTv.offsetHeight,10)+20+"px";
						}
						else
						{
							otvSyl.height=scrolllength+"px";	
							var finishflag=true;	
						}
						break;
					case 3:
						var tmpwidth=oTv.offsetWidth;
						var tmpleft=startX+oImg.offsetWidth-tmpwidth;
						if(tmpwidth<=(scrolllength-20))
						{
							otvSyl.top=startY;
							otvSyl.left=parseInt(tmpleft,10)-20+"px";
							otvSyl.width=parseInt(tmpwidth,10)+20+"px";
						}
						else
						{				
							otvSyl.width=scrolllength+"px";
							otvSyl.left=startX+oImg.offsetWidth-scrolllength+"px";
							var finishflag=true;	
						}
						break;
					case 4:
						var tmpheight=oTv.offsetHeight;
						var tmptop=startY+oImg.offsetHeight-tmpheight;
						if(tmpheight<=(scrolllength-20))
						{
							otvSyl.left=startX;
							otvSyl.top=parseInt(tmptop,10)-20+"px";
							otvSyl.height=parseInt(tmpheight,10)+20+"px";
						}
						else
						{
							otvSyl.height=scrolllength+"px";
							otvSyl.top=startY+oImg.offsetHeight-scrolllength+"px";
							var finishflag=true;	
						}
						break;
				}
				if(!finishflag)
				{
					steptimeout=setTimeout(function(){
					scrollTVdiv();},50);	
				}
				else
				{
					fixsize(autocancel*1000);
					steptimeout=setTimeout(function(){clearTv();},autocancel*1000);
				}	
		}
		 
		function fixsize(leftvalue)
		{
			 if(leftvalue>100)
			 {
					var oTv=$id(TVdivId);
					var otvSyl = oTv.style;
					var oImg=$id(sourceimgId);
					var startX=allyes_findPosX(oImg);
					var startY=allyes_findPosY(oImg);
					switch(showtype)
					{
						case 1:
						case 2:
							otvSyl.top=startY;
							otvSyl.left=startX;
							break;
						case 3:
							otvSyl.top=startY;
							otvSyl.left=startX+oImg.offsetWidth-scrolllength+"px";
							break;
						case 4:
							otvSyl.top=startY+oImg.offsetHeight-scrolllength+"px";
							otvSyl.left=startX;
							break;
					}
					steptimeoutI=setTimeout(function(){fixsize(leftvalue-100);},100)	
			 }
		}
		 
		function clearTv(){
			clearInterval(steptimeout);
			clearInterval(steptimeoutI);
			var objTv=$id(TVdivId);
			objTv.style.width=0;
			objTv.style.height=0;
			objTv.style.display="none";
		}
		function allyes_findPosX(obj){
			var curleft = 0;
			if (obj.offsetParent){
				while (obj.offsetParent){
					curleft += obj.offsetLeft
					obj = obj.offsetParent;
				}
			}
			else if(obj.x)
				curleft += obj.x;
			return curleft;
		}
		function allyes_findPosY(obj){
			var curtop = 0;			
			if (obj.offsetParent){
				while (obj.offsetParent){
					curtop += obj.offsetTop
					obj = obj.offsetParent;
				}
			}
			else if (obj.y)
					curtop += obj.y;
			return curtop;
		}
		function showFlash(u,w,h,d,p,clickdiv){
			if(!p)
				p=0; 
			if(!d)
				d="xc222" + randID; 
			dWrite("<div id='"+d+"' style='padding:0px'></div>");
			//return alysxc(u,w,h,p,d,"http://10.0.3.129/1x1.gif","222",clickdiv,[0,0,0,0],hf);
			var i = 'fTv_flash' + randID;
			return __alysLib.flash(u,w,h,p,d,i,0,hf); 
		}
		 
		dWrite("<div id='" + sourceimgId + "' style='overflow:hidden;width:"+adcreativewidth+";height:"+adcreativeheight+";cursor:pointer;' >");

		setTimeout(function(){
			$id(sourceimgId).onmouseover=showTV;
		},10);

		if (fix_ad_type=="swf"){	//flash
			showFlash(adcreativeurl, adcreativewidth, adcreativeheight,sourceimgId,!flash_trasparent1,clickdiv1);
		}else{	//pic
			dWrite("<a href='"+hf+"' target='"+fix_tar+"'><img border='0' alt='"+fix_alt+"' src='"+adcreativeurl+"' style='width:"+adcreativewidth+";height:"+adcreativeheight+";cursor:pointer;'></img></a>");
		}
		dWrite("</div>");
		dWrite("<div id='" + TVdivId + "' style='display:inline;overflow:hidden;display:none;position:absolute;z-index:5;'");

		if (Tvtype=="swf"){	//flash
			showFlash(adtvurl,TvWidth,TvHeight,TVdivId,!flash_trasparent2,clickdiv2);
		}else{	//pic
			dWrite("<a href='"+hf+"' target='"+fix_tar+"'><img border='0' alt='"+fix_alt+"' src='"+adtvurl+"' style='width:"+TvWidth+";height:"+TvHeight+";cursor:pointer;'></img></a>");
		}
		dWrite("</div>");
		setTimeout(function(){
			$id(TVdivId).onmouseout=clearTv;
		},10);

	}
	
	//Name:	Img description图文配
	if(!__alysLib.imgbackground)
	__alysLib.imgbackground = function(initdata){
	var hf = initdata.href; 

	var outTbWidth = initdata.outTbWidth;
	var tbBgImgSrc = initdata.tbBgImgSrc;
	var imgSrc = initdata.imgSrc;
	var imgWidth = initdata.imgWidth;
	var imgHeight = initdata.imgHeight;
	var imgTop = initdata.imgTop;
	var txtTdHeight = initdata.txtTdHeight;
	var txtHeight = initdata.txtHeight;
	var txtColor = initdata.txtColor;
	var txtOverColor = initdata.txtOverColor;
	var txt = initdata.txt;
	var txtUnderline = initdata.txtUnderline;
	var txtAlign = initdata.txtAlign;
	var swfFlag = initdata.swfFlag;
	var flash_trasparent = initdata.flash_trasparent;
	var clickdiv = initdata.clickdiv;
	var flashparam = initdata.flashparam;


	var innerTbHeight = imgHeight + imgTop;



	var doc = window.document;


	var $id = function(id){
		return doc.getElementById(id);
	};

	var dWrite = function(s){
		doc.write(s);
	};	
	
	var randID = (window.Math.random()).toString().substring(2); 


	var showFlash = function (u,w,h,p){
 		
		if(!p) p=0;
		
		var d = "txtOverColor_" + randID;

		document.write("<div id="+d+"></div>");

 
		p=(flash_trasparent)?0:1;


		var flashName = 'ImgDesAD_flash_' + randID;
		var n = flashName ; 	
		
		if( (typeof hf == 'string' && hf !='') && flashparam){
			u = u + "?" + flashparam + "=" + encodeURIComponent(hf);
			return __alysLib.flash(u,w,h,p,d,n,0);
		}else{
			return __alysLib.flash(u,w,h,p,d,n,0,hf);
		}	
 
	};

	var aCls = 'a_' + randID;

	var stream = [];
	stream.push("<style type=text/css>A." + aCls + "{font-size: " + txtHeight +
					"pt; COLOR: " + txtColor + "; TEXT-DECORATION:"+txtUnderline + 
					"}A." + aCls + ":hover {COLOR: "+txtOverColor+"; text-decoration:"+txtUnderline+"}</style>");
	stream.push("<table width="+outTbWidth+" border=0 cellpadding=0 cellspacing=0><tr valign=top align=center><td background="+tbBgImgSrc+"><table width="+imgWidth+" border='0' cellpadding='0' cellspacing='0'><tr><td id='imgTdid' height='"+innerTbHeight+"' valign='bottom'>");

	if (!swfFlag)
		stream.push("<a href='" + hf + "' target='_blank'><img src="+imgSrc+" border=0  width="+imgWidth+" height="+imgHeight+" alt="+txt+"></a>");
	if (swfFlag)
		showFlash(imgSrc,imgWidth,imgHeight);
	stream.push("</td></tr><tr><td height="+txtTdHeight+" align="+txtAlign+"><a href='" + hf + "' class='" + aCls + "' title="+txt+" target=_blank>"+txt+"</a></td></tr></table></td></tr></table>");

	document.write(stream.join(''));
	stream = null;

 
}
//orient//定位浮层
if(!__alysLib.orient)
	__alysLib.orient = function(initdata){
	var hf = initdata.href; 

	var flow_pic = initdata.flow_pic;
	var flow_time = initdata.flow_time;
	var flow_end_position = initdata.flow_end_position;
	var flow_close = initdata.flow_close;
	var flow_close_pos = initdata.flow_close_pos;
	var clos_word = initdata.clos_word;
	var closeBgColor = initdata.closeBgColor;
	var CreativeCloseStyle = initdata.CreativeCloseStyle;
	var flow_speed = initdata.flow_speed;
	var flash_flag = initdata.flash_flag;
	var CreativeMargin = initdata.CreativeMargin;

	var pic_wid = initdata.pic_wid;
	var pic_hei = initdata.pic_hei;
	var flash_trasparent = initdata.flash_trasparent;
	var clickdiv = initdata.clickdiv;
	var flashparam = initdata.flashparam;
	var close_hei = initdata.close_hei;
	var lastTime = initdata.lastTime;

	var pageMode=document.compatMode.toLowerCase();
	var elmDoc=(pageMode=="backcompat"||pageMode=="quirksmode")?document.body:document.documentElement;
	var endhandle;

	var doc = window.document;


	var $id = function(id){
		return doc.getElementById(id);
	};


	var dWrite = function(s){
		doc.write(s);
	};	
	
	var randID = (window.Math.random()).toString().substring(2); 

	var flow_allyes = 'flow_allyes' + randID + randID;
	var closeDiv = 'close_div' + randID;


	var showFlash = function (u,w,h,p){ 		
		if(!p)
			p=0;		
		var d = flow_allyes;
		p=(flash_trasparent)?0:1;
		var flashName = 'flow_flash_' + randID;
		var n = flashName;		
		if( (typeof hf == 'string' && hf !='') && flashparam){
			u = u + "?" + flashparam + "=" + encodeURIComponent(hf);
			return __alysLib.flash(u,w,h,p,d,n,CreativeMargin);
		}else{
			return __alysLib.flash(u,w,h,p,d,n,CreativeMargin,hf);
		}	
 
	}; 

	function endFlow(fays)
	{
		var _obj = $id(fays);    
		pageX=elmDoc.scrollLeft;
		pageW=elmDoc.clientWidth-8;
		pageY=elmDoc.scrollTop;
		pageH=elmDoc.clientHeight;	
		switch(flow_end_position){
			case 0:
				_obj.style.left=pageX+"px";
				_obj.style.top=pageY+"px";
				break;
			case 1:
				_obj.style.left=pageW+pageX-pic_wid+"px";
				_obj.style.top=pageY+"px";
				break;
			case 2:
				_obj.style.left=pageX+"px";
				_obj.style.top=pageY+pageH-pic_hei-close_hei+"px";
				break;
			case 3:
				_obj.style.left=pageW+pageX-pic_wid+"px";
				_obj.style.top=pageY+pageH-pic_hei-close_hei+"px";
				break;
		}
		setTimeout(function(){ChageOpcity(fays)},50);
	}
	var _opacity = 0;
	function ChageOpcity(fays){
		var _obj=$id(fays);
		if(IEBrowser){
			if(_obj.filters.opacity >= 100)
				return;
			_obj.filters.alpha.opacity = _obj.filters.alpha.opacity + 5;        
		}
		else{
			if(_opacity >= 0.9)
			{
				_obj.style.opacity = 0.99;
				return;
			}
			_opacity = _opacity + 0.05;
			_obj.style.opacity = _opacity;
		}
		setTimeout(function(){ChageOpcity(fays)},50);
	}

	var IEBrowser=false;
	
	if(navigator.appVersion.indexOf("MSIE")!=-1)
		IEBrowser=true;
	
	var hposition=0;
	var vposition=0;
	var flow_stop=0;
	var flow_stop2=0;
	var flow_num=0;
	var flow_vr=1;
	var flow_allyes;

	function flow_Chip(chipname,width,height){
		this.named=chipname;
		this.vx=flow_speed;
		this.vy=flow_speed;
		this.w=width;
		this.h=height;
		this.xx=0;
		this.yy=0;
		this.flow_timer1=null;
	}
	function flow_movechip(chipname){
		var flow_Chip=eval('('+chipname+')');

		if(flow_stop2 == 1)
			return;
		if (flow_stop!=1){
		if(flow_close) close_hei=$id(closeDiv).offsetHeight+2;

			pageX=elmDoc.scrollLeft;
			pageW=elmDoc.clientWidth-8;
			pageY=elmDoc.scrollTop;
			pageH=elmDoc.clientHeight;	   
			flow_Chip.xx=flow_Chip.xx+flow_Chip.vx;
			flow_Chip.yy=flow_Chip.yy+flow_Chip.vy;
			flow_Chip.vx+=flow_vr*(Math.random()-0.5);
			flow_Chip.vy+=flow_vr*(Math.random()-0.5);
			if(flow_Chip.vx>(flow_speed*1.5))  flow_Chip.vx=(flow_speed)*2-flow_Chip.vx;
			if(flow_Chip.vx<(-flow_speed*1.5)) flow_Chip.vx=(-flow_speed)*2-flow_Chip.vx;
			if(flow_Chip.vy>(flow_speed*1.5))  flow_Chip.vy=(flow_speed)*2-flow_Chip.vy;
			if(flow_Chip.vy<(-flow_speed)) flow_Chip.vy=(-flow_speed)*2-flow_Chip.vy;
			if(flow_Chip.xx<=pageX){	
				flow_Chip.xx=pageX;
				flow_Chip.vx=flow_speed;
			}
			if(flow_Chip.xx>=pageX+pageW-flow_Chip.w){
				flow_Chip.xx=pageX+pageW-flow_Chip.w;
				flow_Chip.vx=-flow_speed;
			}
			if(flow_Chip.yy<=pageY){
				flow_Chip.yy=pageY;
				flow_Chip.vy=flow_speed;
			}
			if(flow_Chip.yy>=pageY+pageH-flow_Chip.h-close_hei){	
				flow_Chip.yy=pageY+pageH-flow_Chip.h-close_hei;
				flow_Chip.vy=-flow_speed;
			}
			$id(flow_Chip.named).style.left=flow_Chip.xx + "px";
			$id(flow_Chip.named).style.top=flow_Chip.yy + "px";   
			flow_Chip.flow_timer1=setTimeout(function(){flow_movechip(flow_Chip.named)},50);
		}
		else {
			flow_Chip.flow_timer1=setTimeout(function(){flow_movechip(flow_Chip.named)},50);
		}
		if(flow_stop==1)
			return;
		lastTime += 50;
		if(lastTime > flow_time*1000){
			var _obj = $id(flow_allyes);
			if(_obj){           
				if(IEBrowser){
					if(_obj.filters.alpha.opacity > 0)
						_obj.filters.alpha.opacity = _obj.filters.alpha.opacity-5;
					else{
						flow_stop2=1;                   
						endFlow(flow_allyes);
						if(flow_Chip.flow_timer1!=null)
							clearTimeout(flow_Chip.flow_timer1)
					}
				}else{
					if(_obj.style.opacity > 0.05){
						 _obj.style.opacity = _obj.style.opacity - 0.05;
						}
					else{
						flow_stop2=1;                   
						endFlow(flow_allyes);
						if(flow_Chip.flow_timer1!=null)
							clearTimeout(flow_Chip.flow_timer1)
					}
				}
			}
			
		}
	}
	function flow_stopme(chipname){
		var flow_Chip=eval('('+chipname+')');
		if(flow_Chip.flow_timer1!=null)
			clearTimeout(flow_Chip.flow_timer1)
	}
	function flow_allyes1(){
		if (flow_num==0){
			window[flow_allyes] = new flow_Chip(flow_allyes,pic_wid,pic_hei);
			flow_movechip(flow_allyes);	
		}
		flow_num++;
	}
	var flow_a=1;
	var flow_rector=3;
	var flow_rectorwin=10;

	var stream = [];
	stream.push("<div id='" + flow_allyes + "' STYLE='position:absolute;left:0px;top:0px;filter:alpha(opacity=100);opacity:0.99'>");
	if (flash_flag==0){	 
		stream.push("<a HREF='"+ADFUSER30+"' target='_blank'></a>");
	}
	stream.push("</div>");
	document.write(stream.join(''));
	stream = null;
	
	setTimeout(function(){
		if (flash_flag!=0){//set flash to flow_allyes.
			showFlash(flow_pic,pic_wid,pic_hei);
			return;
		}
		var $fs = $id(flow_allyes);
		
		$fs.onmouseover = function(){ flow_stop=1};

		$fs.onmouseout = function() { flow_stop=0 };
		
		var $img = document.createElement('img');
	
		$img.width = pic_wid;
		$img.height = pic_hei;
		$img.style.width = pic_wid + 'px';
		$img.style.height = pic_hei + 'px';
		$img.id = 'flow_oImg' + randID;
		$img.border = 0;
		$img.onload = flow_allyes1;
		$img.src = flow_pic;
		$img.onmouseover = function(){flow_stop=1;};
		$img.onmouseout = function(){flow_stop=0;};
		$id(flow_allyes).getElementsByTagName('a')[0].appendChild($img);

		

	},10);


	function getCloseDiv(obj){
		if(!flow_close) 
			return;
		var pos = (flow_close_pos%2==1) ? "right":"left";
		var divhtm="<div id='" + closeDiv + "' style='background-color:"+closeBgColor+";text-align:"+pos+";'><span style='cursor:hand;"+CreativeCloseStyle+"' >"+clos_word+"</span></div>";
		
		var o=document.createElement('div');
		o.innerHTML=divhtm;
		
		setTimeout(function(){
			var $cdiv = $id(closeDiv);
			$cdiv.getElementsByTagName('span')[0].onclick= function(){
				$id(flow_allyes).style.display="none";
			};
		},10);
		
		
		if(flow_close_pos > 1)
			obj.appendChild(o);
		else
			obj.insertBefore(o,obj.firstChild);
	}
	getCloseDiv($id(flow_allyes));
	flow_allyes1();

	var hdl_oldScroll = window.onscroll;
	var hdl_oldresize = window.onresize;
	window.onscroll = function()
	{
		if(hdl_oldScroll)
			hdl_oldScroll();
		if(flow_stop2 == 1)
			endFlow(flow_allyes);
	}
	window.onresize = function()
	{
		if(hdl_oldresize)
			hdl_oldresize();
		if(flow_stop2 == 1)
			endFlow(flow_allyes);
	}
 
}
//rippage撕页广告
if(!__alysLib.rippage)
	__alysLib.rippage = function(initdata){
	var hf = initdata.href;
	//width of Ad
	var fix_pic_width = initdata.fix_pic_width;
	//height of Ad
	var fix_pic_height = initdata.fix_pic_height;
	var clkParam = initdata.clkParam;
	//Ad URL
	var fix_pic = initdata.fix_pic;

	var fix_alt = initdata.fix_alt;
	//name of window
	var fix_tar = initdata.fix_tar;
	//horizonal align method:left,1;center,2;right:3;0,defined
	var fix_po = initdata.fix_po;

	if(clkParam!="") {
		fix_pic +="?"+clkParam+"="+encodeURIComponent(hf);
	}

	var fix_poleft = 'Vright';
	if(fix_po=='1'||fix_po=='2')
		fix_poleft="Vleft";

	var fix_potop="Vbottom"; 
	if(fix_po=='1'||fix_po=='3') 
		fix_potop="Vtop";

	var doc = window.document;
	

	//customsized  offset value from left side;
	var flash_trasparent = 1;
	var fix_IE = (doc.all) ? 1 : 0;
	var clientHeight=clientWidth=scrollLeft=scrollTop=0;
	var fadestyle="";
	var hposition, vposition;
	 
	var standardCompat = doc.compatMode.toLowerCase();
	var elmDoc=(standardCompat=="backcompat"||standardCompat=="quirksmode")?document.body:document.documentElement;
	 
	clientWidth=elmDoc.clientWidth;
	clientHeight=elmDoc.clientHeight;
	scrollLeft=elmDoc.scrollLeft;
	scrollTop=elmDoc.scrollTop;
	 



	var $id = function(id){
		return doc.getElementById(id);
	};

	var dWrite = function(s){
		doc.write(s);
	};	

	var showFlash = function (d,u,w,h,p){ 		
		if(!p)
			p=0;		
		doc.write("<div id="+d+" style='padding:0px'></div>");

		var flashName = 'flow_flash_' + randID;
		var n = flashName;		

		return __alysLib.flash(u,w,h,p,d,n);

	}; 
	
	var randID = (window.Math.random()).toString().substring(2); 
	
	var fix_floaterId = 'fix_floater' + randID;


	doc.writeln("<div id='" + fix_floaterId + "' style='position:absolute;padding:0px; display:none; width:"+fix_pic_width+"; height:"+fix_pic_height+fadestyle+"'>");
	showFlash("fixmain",fix_pic, fix_pic_width, fix_pic_height,!flash_trasparent );
	
	doc.writeln("</div>");
	 
	function fix_effectFixFloat() {
		clientHeight=elmDoc.clientHeight;
		clientWidth=elmDoc.clientWidth;
		scrollLeft=elmDoc.scrollLeft;
		scrollTop=elmDoc.scrollTop;

		switch (fix_poleft) {
			case "Vleft":
				hposition=scrollLeft+"px";
				break;
			case "Vcenter":
				hposition=Math.round((clientWidth-fix_pic_width)/2)+scrollLeft+"px";
				break;
			case "Vright":
				hposition=clientWidth+scrollLeft-fix_pic_width+"px";
				break;
			default:
		}

		switch (fix_potop) {
			case "Vtop":
				//vposition=scrollTop+fix_v_offset+"px";
				vposition=0;
				break;
			case "Vmiddle":
				vposition=Math.round((clientHeight-fix_pic_height)/2)+scrollTop+"px";
				break;
			case "Vbottom":
				vposition=clientHeight+scrollTop-fix_pic_height+"px";
				break;
			default:
		}

		var ffstyle = $id(fix_floaterId).style;
		ffstyle.top=vposition;
		ffstyle.left=hposition;
		ffstyle.display='block';
	}
 
	 
	window.setInterval(fix_effectFixFloat,200);

}
//riseAd浮现广告
if(!__alysLib.riseAd)
	__alysLib.riseAd = function(initdata){
		var hf = initdata.href;
		var fix_tar = initdata.fix_tar;
		var fix_alt = initdata.fix_alt;
		var adtvurl = initdata.adtvurl;
		var adcreativewidth = initdata.adcreativewidth;
		var adcreativeheight = initdata.adcreativeheight;
		var fix_ad_type = initdata.fix_ad_type;
		var showposition = initdata.showposition;
		var margin = initdata.margin;
		var scrollp = initdata.scrollp;
		var autocancel = initdata.autocancel;
		var clickdiv = initdata.clickdiv;
		var flashparam = initdata.flashparam;
		var closestyle = initdata.closestyle;
		var closename = initdata.closename;
		var closebgcolor = initdata.closebgcolor;
		var closewidth = initdata.closewidth;
		var closeheight = initdata.closeheight;
		var flash_trasparent = initdata.flash_trasparent;

		var index = initdata.index;
		var vindex = initdata.vindex;


		var closemaginleft=adcreativewidth-closewidth;
		var closemagintop=-closeheight;

		var allyes_tv_close_flag=false;//global close
		if(scrollp==1)
		{
			vindex=margin;
		}
		else
		{
			index=margin;
		}	
		var steptimeout=null;
		var scrollflag=true;
		var waittime=0;
		var pageMode=document.compatMode.toLowerCase();
		var elmDoc=(pageMode=="backcompat"||pageMode=="quirksmode")?document.body:document.documentElement;
		var doc = window.document;


		var $id = function(id){
			return doc.getElementById(id);
		};


		var dWrite = function(s){
			doc.write(s);
		};	
		
		var randID = (window.Math.random()).toString().substring(2); 
		
		var tvDiv  = 'TVdiv' + randID;
		var closeDiv = 'closediv' + randID;

		function scrollin()
		{   
			  var tmpStepX=0;
			  var tmpStepY=0;
			  var oTv=$id(tvDiv);
			  var oTvStyle = oTv.style;
			if(oTv.offsetHeight>adcreativeheight-20&&oTv.offsetWidth>adcreativewidth-20&&scrollflag&&!allyes_tv_close_flag)
			  {
				  tmpStepX=adcreativewidth-parseInt(oTv.offsetWidth,10);
				  tmpStepY=adcreativeheight-parseInt(oTv.offsetHeight,10);
						waittime-=50;
						if(waittime<=0&&autocancel)
							scrollflag=false;
			  }
			  else if(!scrollflag&&(oTv.offsetHeight<20||oTv.offsetWidth<20)||allyes_tv_close_flag)
			  {
				 waittime=0;
				 scrollflag=true;
				 oTvStyle.display="none";
				 oTvStyle.width=0;
				 oTvStyle.height=1+"px";
				 return;
			  }
			  else
			  {
				if(scrollflag)
				{
					 if(scrollp==1)
					 {
						  tmpStepX=20;
					 }
					 else
					 {
							tmpStepY=20;
					 }
				}
				else
				{
					if(scrollp==1)
					{
						oTvStyle.width=parseInt(oTv.offsetWidth,10)-20+"px";
					} 
					 else
					 {
						oTvStyle.height=parseInt(oTv.offsetHeight,10)-20+"px";
					 }
				} 	
			  }	
				switch(showposition)
				{
						case 1:
							oTvStyle.top	=	elmDoc.scrollTop+vindex+"px";
							oTvStyle.left = elmDoc.scrollLeft+index+"px";							
						break;	
						case 2:
							oTvStyle.top	=	elmDoc.scrollTop+vindex+"px";
							oTvStyle.left = elmDoc.scrollLeft+elmDoc.clientWidth-oTv.offsetWidth-tmpStepX-index+"px";
						break;
						case 3:
							oTvStyle.top	=	elmDoc.scrollTop+elmDoc.clientHeight-oTv.offsetHeight-tmpStepY-vindex+"px";
							oTvStyle.left = elmDoc.scrollLeft+index+"px";
						break;
						case 4:
							oTvStyle.top	=	elmDoc.scrollTop+elmDoc.clientHeight-oTv.offsetHeight-tmpStepY-vindex+"px";
							oTvStyle.left = elmDoc.scrollLeft+elmDoc.clientWidth-oTv.offsetWidth-tmpStepX-index+"px";
						break;
				}
						oTvStyle.width=parseInt(oTv.offsetWidth,10)+tmpStepX+"px";
						oTvStyle.height=parseInt(oTv.offsetHeight,10)+tmpStepY+"px";
			 steptimeout=setTimeout(function(){scrollin();},50);	
		}
		function showFlash(u,w,h,p){
//			if(!p)p=0;var d="xc29";
//			p=(flash_trasparent)?0:1;
//			if(clickdiv && flashparam!="")u=u+"?"+flashparam+"="+encodeURIComponent(hf);
//			
//			return alysxc(u,w,h,p,d,"http://10.0.3.129/1x1.gif","29",clickdiv,0,hf);
// 		
			if(!p) p=0;
			
			var d = "xc29_" + randID;

			document.write("<div id="+d+" style='position:relative;padding:0px;top:"+closemagintop+"px;z-index:4;'></div>");

	 
			p=(flash_trasparent)?0:1;


			var flashName = 'RiseAD_flash_' + randID;
			var n = flashName ; 	
			
			if( (typeof hf == 'string' && hf !='') && flashparam){
				u = u + "?" + flashparam + "=" + encodeURIComponent(hf);
				return __alysLib.flash(u,w,h,p,d,n,0);
			}else{
				return __alysLib.flash(u,w,h,p,d,n,0,hf);
			}

		}

		document.write("<div id='" + tvDiv + "' style='overflow:hidden;display:none;position:absolute;z-index:10;'>");
		document.write("<div id='" + closeDiv + "' align=center style='position:relative;width:"+closewidth+"px;height:"+closeheight+"px;line-height:"+closeheight+"px;background:"+closebgcolor+";"+closestyle+";margin-left:"+closemaginleft+"px;overflow:hidden;z-index:5;cursor:pointer'>"+closename+"</div>");
		if (fix_ad_type=="swf"){//flash
			showFlash(adtvurl, adcreativewidth, adcreativeheight);
		}
		else{//pic
			document.write("<a href='"+hf+"' target='"+fix_tar+"'><img alt='"+fix_alt+"' src='"+adtvurl+"' style='width:"+adcreativewidth+";height:"+adcreativeheight+";cursor:pointer;border:0;' style='position:relative;padding:0px;top:"+closemagintop+"px;z-index:4;'></img></a>");
		}
		document.write("</div>");

		//if(!disdiv)
		var disdiv=function(){allyes_tv_close_flag=true;}

		$id(closeDiv).onclick=disdiv;

		setTimeout(function(){
			allyes_tv_close_flag=false;
			var otv = $id(tvDiv);
			var otvStyle = otv.style;
			
			if(scrollp==1){
				otvStyle.height = adcreativeheight;
				otvStyle.width = "0";
			}
			else
			{
				otvStyle.width=adcreativewidth;	
				otvStyle.height = "1px";
			}
			$id(closeDiv).style.lineHeight=closeheight+"px";
			otvStyle.display="block";
			waittime=autocancel*1000;
			scrollin();	
		},2000);

	}
	//whirl轮循广告
if(!__alysLib.whirl)
	__alysLib.whirl = function(initdata){
	var hf = initdata.href;
	var iCount = initdata.iCount;
	var iInter = initdata.iInter;
	var sPlayType = initdata.sPlayType;
	var sSource = initdata.sSource;
	var sSourceType = initdata.sSourceType;
	var sClkUrl = initdata.sClkUrl;
	var sClkDiv = initdata.sClkDiv;
	var sWeight = initdata.sWeight;
	var sTagFlag = initdata.sTagFlag;
	var sTagColor = initdata.sTagColor;
	var WhirlTar = initdata.WhirlTar;
	var Width = initdata.Width;
	var Height = initdata.Height;
	var flash_trasparent = initdata.flash_trasparent;

	if(hf.search(/&i=z/)===-1){
		hf = hf.split("&url=")[0]+"&url="
	}else{
		hf = hf.split("&u=")[0]+"&u="
	} 
	var aS = sSource.split("`~`");
	var aST = sSourceType.split("`~`");
	var aC = sClkUrl.split("`~`");
	var aCD = sClkDiv.split("`~`");
	var aW = sWeight.split("`~`");
	var aColor = sTagColor.split("`");
	var aflash_trasparent = flash_trasparent.split("`~`");
	var aPlayList = [];
	var iAllWeight = 0;
	var iPlayIndex = -1;
	var iPlaySort = 0;
	var bIsIE = (navigator.userAgent.toLowerCase().indexOf("msie") != -1);


	var doc = window.document;


	var $id = function(id){
		return doc.getElementById(id);
	};


	var dWrite = function(s){
		doc.write(s);
	};	

	var randID = (window.Math.random()).toString().substring(2); 

	function addImage(id,s,w,h,c){
		var _s = "<a href='"+c+"' target='"+WhirlTar+"'><img src="+s+" border=0  WIDTH="+w+" HEIGHT="+h+"></a>";
		document.getElementById(id).innerHTML = _s;
	}
	function showFlash(u,w,h,p,d,i,c){
   		 return __alysLib.flash(u,w,h,p,d,i,0,c); 
		 //alysxc(u,w,h,p,d,"http://10.0.3.129/1x1.gif","17",i,0,c);
	}

	var ContainId = 'Contain' + randID;
	var iDivPreID = 'DivPre' + randID;
	var iSpanPreID = 'SPAN' + randID;

	document.write("<DIV id='" + ContainId + "' style='position:relative;width:"+Width+"px;height:"+Height+"px;'>");
	for(var _i=0; _i<iCount; _i++){
		document.write("<DIV ID='"+ iDivPreID + _i + "' STYLE='left:0px;top:0px;position:absolute;visibility:hidden;filter:revealTrans(DURATION=1, TRANSITION=23);z-index:10;'></DIV>");
	}
	document.write("</DIV>");
	if(sTagFlag){
		//s = "<DIV style='position:absolute;right:1px;bottom:1px;z-index:100;'>";
		var s = '';
		for(var _i=0; _i<iCount; _i++){
			s += "<span id='"+iSpanPreID+_i+"'  style='cursor:pointer;padding:3px;margin-left:2px;"+aColor[0]+"'>"+(_i+1)+"</span>";
		}	
		//s += "</DIV>";
		
		var $div = document.createElement('div');
		$div.style.position = 'absolute';
		$div.style.right = '1px';
		$div.style.bottom = '1px';
		$div.style.zIndex = '100';
		$div.innerHTML = s;
		$id(ContainId).appendChild($div);
		var nspanCLick = function(_i){
			return function() { Change(_i);}
		};
		var $spans = $div.getElementsByTagName('span');
		for(var i = 0 , len = $spans.length ; i < len ; i++){
			$spans[i].onclick= nspanCLick(i);
		}
		

	}
	for(var _i=0; _i<iCount; _i++){
		if(aST[_i]==1){
			if(aCD[_i] != 1 && aCD[_i] != 0) {
				showFlash(aS[_i]+"?"+aCD[_i]+"="+encodeURIComponent(aC[_i]),Width,Height,!parseInt(aflash_trasparent[_i]),iDivPreID+_i+"",1);
			} else if (aCD[_i] == 1) {
				showFlash(aS[_i],Width,Height,!parseInt(aflash_trasparent[_i]),iDivPreID+_i+"",1,aC[_i]);
			} else {
				showFlash(aS[_i],Width,Height,!parseInt(aflash_trasparent[_i]),iDivPreID+_i+"",0,aC[_i]);
			}
		}else{
			addImage(iDivPreID+_i+"", aS[_i],Width,Height,aC[_i]);
		}
	}
	switch(sPlayType){
		case "weight":
			for(var _i=0; _i<aW.length; _i++){
				iAllWeight += parseInt(aW[_i],10);			
			}		
			break;
		case "order":
			for(var _i=0; _i<aW.length; _i++){
				aPlayList.push(aW[_i]);			
			}
			aPlayList.sort();
			break;
	}
	 
	function FDoPlay(oC, oN){
		if(bIsIE){
			oC.filters[0].Apply();
			oC.style.zIndex = 10;
			oN.style.zIndex = 9;	
		}
		oN.style.visibility = "visible";
		oC.style.visibility = "hidden";	
		if(bIsIE){
			oC.filters.revealTrans.transition=23;
			oC.filters[0].Play();	
		}
	}
	function Change(i){
 
		fitTag(iPlaySort,'h');
		iPlaySort = ((i-1)<0)?(iCount-1):(i-1);
		clearInterval(Hdl);
		FPlay();
		Hdl = setInterval(FPlay, iInter*1000);
	}
	function fitTag(i,f){
		var _ID = iSpanPreID+i+"";
		var _o = $id(_ID);
		if(f=="h"){
			var _a = aColor[0].split(';');
		}else{
			var _a = aColor[1].split(';');
		}
		_o.style.fontFamily = (_a[0].split(':'))[1];
		_o.style.fontSize = (_a[1].split(':'))[1];
		_o.style.lineHeight = (_a[2].split(':'))[1];
		_o.style.backgroundColor = (_a[3].split(':'))[1];
		_o.style.color = (_a[4].split(':'))[1]; 		
	}
	function FPlay(){
		var i = iPlayIndex;
		var _oDiv = null;
		var _oNextDiv = null;	
		if(iCount <=1 ){
			$id(iDivPreID +"0").style.visibility = "visible";
			return;
		}	
		switch(sPlayType){
			case "average":
				if(i == -1){
					$id(iDivPreID +"0").style.visibility = "visible";
					iPlayIndex = 0;
					return;
				}else{
					var _i = i + 1;
					if(_i >= iCount) _i = 0;
				}
				break;
			case "weight":
				while(true){
					var _iRWeight = Math.floor(Math.random()*iAllWeight) + 1;
					var _iNWeight = 0;
					for(var _i = 0; _i<aW.length; _i++){
						_iNWeight += parseInt(aW[_i],10);
						if(_iRWeight <= _iNWeight) break;
					}
					if(_i != i) break;
				}
				if(i == -1){
					$id(iDivPreID+_i+"").style.visibility = "visible";
					iPlayIndex = _i;
					return;
				}
				break;
			case "order":
				var _order = 0;
				if(i == -1){
					_order = aPlayList[0];
					var _pre = iCount-1;
				}else{
					var _pre = iPlaySort;
					iPlaySort++;
					if(iPlaySort >= iCount){
						_order = aPlayList[0];
						iPlaySort = 0;
					}else{
						_order = aPlayList[iPlaySort];				
					}
				}
				for(var _i = 0; _i<aW.length; _i++){
					if(_order == aW[_i])
						break;
				}
				if(sTagFlag){
					fitTag(iPlaySort,'s');
					fitTag(_pre,'h');		
				}
				if(i == -1){
					$id(iDivPreID+_i+"").style.visibility = "visible";
					iPlayIndex = _i;
					return;
				}
				break;
		}	
		_oDiv = $id(iDivPreID+i+"");
		_oNextDiv = $id(iDivPreID+_i+"");	
		FDoPlay(_oDiv, _oNextDiv);
		iPlayIndex = _i;
	}
	FPlay();
	var Hdl = setInterval(FPlay, iInter*1000);
}

//couplet_ad对联广告
if(!__alysLib.coupletad)
	__alysLib.coupletad = function(initdata){
	var hf = initdata.href;
	var LeftCreativeUrl=initdata.LeftCreativeUrl;
	var RightCreativeUrl=initdata.RightCreativeUrl;
	var CreativeWidth=initdata.CreativeWidth;
	var CreativeHeight=initdata.CreativeHeight;
	var TopOffset=initdata.TopOffset;
	var SWSFlag=initdata.SWSFlag;
	var LeftCreativeFlashFlag=initdata.LeftCreativeFlashFlag;
	var RightCreativeFlashFlag=initdata.RightCreativeFlashFlag;
	var CreativeMargin=initdata.CreativeMargin;
	var CreativeCloseStyle=initdata.CreativeCloseStyle;
	var CreativeCloseBtnPos=initdata.CreativeCloseBtnPos;
	var CreativeCloseBtnFlag=initdata.CreativeCloseBtnFlag;
	var close=initdata.close;
	var closeBgColor=initdata.closeBgColor;
	var leftClickUrl=initdata.leftClickUrl;
	var rightClickUrl=initdata.rightClickUrl;
	var flash_trasparent1=initdata.flash_trasparent1;
	var clickdiv1=initdata.clickdiv1;
	var flashparam1=initdata.flashparam1;
	var flash_trasparent2=initdata.flash_trasparent2;
	var clickdiv2=initdata.clickdiv2;
	var flashparam2=initdata.flashparam2;

	var pageMode = document.compatMode.toLowerCase();
	var elmDoc=(pageMode=="backcompat"||pageMode=="quirksmode")?document.body:document.documentElement;
	var Left2 = elmDoc.clientWidth - CreativeWidth - 10;

	var WriteHtml = "";

	if(hf.search(/&i=z/)===-1){
		 hf = hf.split("&url=")[0] + "&url=" ;
	}else{
		 hf = hf.split("&u=")[0] + "&u=" ;
	}

	var doc = window.document;


	var $id = function(id){
		return doc.getElementById(id);
	};

	var dWrite = function(s){
		doc.write(s);
	};	
	
	var randID = (window.Math.random()).toString().substring(2);

	var cpAd1ID = 'CPAD_l_' + randID;
	var cpAd2ID = 'CPAD_r_' + randID;

	var commonStyle = "position: absolute;visibility:visible;z-index:999;";


	function setCloseBtn(obj,flag){
		if(CreativeCloseBtnFlag != "outside")
			return; 
		var pos=(CreativeCloseBtnPos % 2 ==1) ?"left":"right";
		
		if(flag==2)
			pos=(CreativeCloseBtnPos % 2 ==1)?"right":"left";  
		
		var divhtm="<div style='background-color:"+closeBgColor+";text-align:"+pos+";'><span style='cursor:pointer;word-wrap: normal;word-break:keep-all;white-space:nowrap;"+CreativeCloseStyle+"' >"+close+"</span></div>";
		
		var o=doc.createElement('div');
		o.innerHTML = divhtm;
		
		if(CreativeCloseBtnPos > 2)
			obj.appendChild(o);
		else
			obj.insertBefore(o,obj.firstChild);
		
		setTimeout(function(){
			o.getElementsByTagName('span')[0].onclick = function(){
				$id(cpAd1ID).style.display="none";
				$id(cpAd2ID).style.display="none";
			};
		},0);
	}
	function showFlash(divname,button,top,left,u,w,h,p,url,trasparent,clickdiv,flashparam){
		if(!p)
			p=0;
	
		p = (trasparent) ? 0 : 1;

		doc.write("<div id="+divname+" style='" + commonStyle + "top:"+top+"px;left:"+left+"px'></div>");

//		if(clickdiv && flashparam!='')
//			u=u+"?"+flashparam+"="+encodeURIComponent(url);
//		alysxc(u,w,h,p,divname,"http://10.0.3.129/1x1.gif",button,clickdiv,CreativeMargin,url);
		
		var flashName = 'CPAD_flash_' + randID;
		var n = flashName + "_" + button; 	

		if( (typeof url == 'string' && url !='') && flashparam){
			u = u + "?" + flashparam + "=" + encodeURIComponent(url);
			return __alysLib.flash(u,w,h,p,divname,n,CreativeMargin);
		}else{
			return __alysLib.flash(u,w,h,p,divname,n,CreativeMargin,url);
		}	
	}

	function SetDivTop(){
		var cpad1Style = $id(cpAd1ID).style;
		cpad1Style.top=elmDoc.scrollTop+parseInt(TopOffset)+"px";
		cpad1Style.left=elmDoc.scrollLeft+10+"px";
		$id(cpAd2ID).style.top=elmDoc.scrollTop+parseInt(TopOffset)+"px";
	}

	function SetDiv2Left(){
		$id(cpAd2ID).style.left=elmDoc.scrollLeft+elmDoc.clientWidth - CreativeWidth - 10+"px";
	}


	if (LeftCreativeFlashFlag)
		showFlash(cpAd1ID,"left",TopOffset,10,LeftCreativeUrl,CreativeWidth,CreativeHeight,null,hf+leftClickUrl,flash_trasparent1,clickdiv1,flashparam1);
	else
		doc.write("<div id=" + cpAd1ID + " style='" + commonStyle + "top:"+TopOffset+"px;left:5px'><a href="+hf+leftClickUrl+" target='_blank'><img src="+LeftCreativeUrl+" border='0'  width="+CreativeWidth+" height="+CreativeHeight+"></a></div>");
	if (RightCreativeFlashFlag)
		showFlash(cpAd2ID,"right",TopOffset,Left2,RightCreativeUrl,CreativeWidth,CreativeHeight,null,hf+rightClickUrl,flash_trasparent2,clickdiv2,flashparam2);
	else
		doc.write("<div id=" + cpAd2ID +" style='" + commonStyle + "top: "+TopOffset+"px;left:" + Left2 +"px'><a href='"+hf + rightClickUrl+"' target='_blank'><img src="+RightCreativeUrl+" border='0'  width="+CreativeWidth+" height="+CreativeHeight+"></a></div>");

	
	setCloseBtn($id(cpAd1ID),1);
	setCloseBtn($id(cpAd2ID),2);
	
	// init couplet ads.

	if (SWSFlag)
		window.setInterval(SetDivTop,200);
	window.setInterval(SetDiv2Left,200);
}
//mobile_converter移动转换
if(!__alysLib.mobile_converter)
	__alysLib.mobile_converter = function(initdata){

	var hf = initdata.href;

	var flowchange_pic = initdata.flowchange_pic;
	var flowchange_pic2 = initdata.flowchange_pic2;
	var flowchange_alt = initdata.flowchange_alt;
	var flowchange_speed = initdata.flowchange_speed;	
	var flowchange_tar = initdata.flowchange_tar;	
	var flowchange_downflag = initdata.flowchange_downflag;
	var flowchange_horizon = initdata.flowchange_horizon;	
	var flowchange_vertical = initdata.flowchange_vertical;
	var flowchange_pic1_wid = initdata.flowchange_pic1_wid;
	var flowchange_pic1_hei = initdata.flowchange_pic1_hei;
	var flowchange_pic2_wid = initdata.flowchange_pic2_wid;
	var flowchange_pic2_hei = initdata.flowchange_pic2_hei;
	var flowchange_pic1_type = initdata.flowchange_pic1_type;
	var flowchange_pic2_type = initdata.flowchange_pic2_type;
	var flash_trasparent1 = initdata.flash_trasparent1;
	var clickdiv1 = initdata.clickdiv1;
	var flashparam1 = initdata.flashparam1;
	var flash_trasparent2 = initdata.flash_trasparent2;
	var clickdiv2 = initdata.clickdiv2;
	var flashparam2 = initdata.flashparam2;	
	var flowchange_stop = initdata.flowchange_stop;
	var flowchange_num = initdata.flowchange_num;
	var flowchange_vr = initdata.flowchange_vr;

	var flowchange_timer1;
	var flowchange_allyes;

	var pageMode = document.compatMode.toLowerCase();

	var elmDoc = (pageMode=="backcompat"||pageMode=="quirksmode") ? document.body : document.documentElement;
	
	if ((flowchange_horizon != "free") || (flowchange_vertical != "free")){
		flowchange_vr = 0;
	}


	var $id = function(id){
		return document.getElementById(id);
	};

	var dWrite = function(s){
		document.write(s);
	};	
	
	var randID = (Math.random()).toString().substring(2);


	var fcID = "flowchange_allyes" + randID + randID;
	var lfID = "leftDown_" + randID;
	var picID = "pic_" + randID;

	var flashName = "flash_" + randID;
 
	function flowchange_Chip(chipname,width,height){
		this.named = chipname;
		this.vx = flowchange_speed;
		this.vy = flowchange_speed;
		this.w = width;
		this.h = height;
		this.xx = 0;
		this.yy = 0;
		this.flowchange_timer1 = null;
	}

	function flowchange_fitMode(){
		switch (flowchange_vertical){
			case "right":
				flowchange_vertical = elmDoc.clientWidth - flowchange_pic1_wid -8;
				break;
			case "mid":
				flowchange_vertical = elmDoc.clientWidth/2 - flowchange_pic1_wid/2;
				break;
			case "left":
				flowchange_vertical = 10;
				break;
		}
		switch ( flowchange_horizon){
			case "bottom":
				flowchange_horizon = elmDoc.clientHeight - flowchange_pic1_hei - 5;break;
			case "mid":
				flowchange_horizon = (elmDoc.clientHeight - flowchange_pic1_hei)/2;break;
			case "top":
				flowchange_horizon = 10;break;
		}
		flowchange_allyes1();
	}

	function flowchange_movechip(chipname){
		var fcChip = eval('('+chipname+')');

		if (flowchange_stop!=1){
			pageX = elmDoc.scrollLeft;
			pageW = elmDoc.clientWidth-8;
			pageY = elmDoc.scrollTop;
			pageH = elmDoc.clientHeight;
			if ((flowchange_horizon!="free") && (flowchange_vertical=="free")){
				fcChip.yy = flowchange_horizon; 
			}else if ((flowchange_horizon=="free") && (flowchange_vertical!="free")){
				fcChip.xx = flowchange_vertical;
			}
			fcChip.xx = fcChip.xx+fcChip.vx;
			fcChip.yy = fcChip.yy+fcChip.vy;
			fcChip.vx += flowchange_vr*(Math.random()-0.5);
			fcChip.vy += flowchange_vr*(Math.random()-0.5);
			
			if(fcChip.vx>(flowchange_speed*1.5))
				fcChip.vx = (flowchange_speed)*2-fcChip.vx;			
			if(fcChip.vx<(-flowchange_speed*1.5))
				fcChip.vx = (-flowchange_speed)*2-fcChip.vx;
			if(fcChip.vy>(flowchange_speed*1.5))
				fcChip.vy = (flowchange_speed)*2-fcChip.vy;
			if(fcChip.vy<(-flowchange_speed*1.5))
				fcChip.vy = (-flowchange_speed)*2-fcChip.vy;
			if(fcChip.xx<=pageX){
				if ((flowchange_horizon=="free") && (flowchange_vertical!="free"))
					fcChip.xx = pageX+flowchange_vertical;
				else	
					fcChip.xx = pageX;
				fcChip.vx = flowchange_speed;
			}
			if(fcChip.xx>=pageX+pageW-fcChip.w){
				fcChip.xx = pageX+pageW-fcChip.w;
				fcChip.vx = -flowchange_speed;
			}
			if(fcChip.yy<=pageY){
				if ((flowchange_horizon!="free") && (flowchange_vertical=="free"))
					fcChip.yy = pageY+flowchange_horizon;
				else
					fcChip.yy = pageY;
				fcChip.vy = flowchange_speed;
			}
			if(fcChip.yy>=pageY+pageH-fcChip.h){
				fcChip.yy = pageY+pageH-fcChip.h;
				fcChip.vy = -flowchange_speed;
			}

			$id(fcChip.named).style.left = fcChip.xx + "px";
			$id(fcChip.named).style.top = fcChip.yy + "px";
			
			fcChip.flowchange_timer1 = setTimeout(function(){
				flowchange_movechip(fcChip.named)
			},50);
		}else{
			fcChip.flowchange_timer1 = setTimeout(function(){
				flowchange_movechip(fcChip.named)
			},50);
		}
	}
	function flowchange_stopme(chipname){
		var fcChip = eval('('+chipname+')');
		if(fcChip.flowchange_timer1!=null){
			clearTimeout(fcChip.flowchange_timer1)
		}
	}
	function flowchange_allyes1(){
		if (flowchange_num==0){
			window[fcID] = new flowchange_Chip(fcID,flowchange_pic1_wid,flowchange_pic1_hei);
			flowchange_movechip(fcID);	
		}
		flowchange_num++;
	}
	function change_over(){
		var $ldObjStyle = $id(lfID).style; 
		switch(flowchange_downflag){
			case 0:
				$id(picID).getElementsByTagName('img')[0].style.visibility = "hidden";
				break;
			case 1:
				$ldObjStyle.top = flowchange_pic1_hei+"px";
				break;
			case 2:
				$ldObjStyle.left = flowchange_pic1_wid+"px";
				break;
			case 3:
				$ldObjStyle.left = -flowchange_pic2_wid+"px";
				break;
			case 4:
				$ldObjStyle.top = -flowchange_pic2_hei+"px";
				break;
		}
		$ldObjStyle.visibility = "visible"; 
	}

	function change_out(){
		$id(lfID).style.visibility = "hidden";
		$id(picID).getElementsByTagName('img')[0].style.visibility = "visible";
	}

	var mouseTimer = null;
	
	function _mouserOver(){
		var fcChip = eval('('+fcID+')');
		if(fcChip.flowchange_timer1){
			clearTimeout(fcChip.flowchange_timer1);
			fcChip.flowchange_timer1 = null;
		}
		if(mouseTimer){
			clearTimeout(mouseTimer);
			mouseTimer = null;
		}
		change_over();
		flowchange_stop=1;
	}

	function _mouserOut(){ 
		if(mouseTimer){
			clearTimeout(mouseTimer);
			mouseTimer = null;
		}
		mouseTimer = setTimeout(function(){
				change_out();
				flowchange_stop=0;

				var fcChip = eval('('+fcID+')');

				if(fcChip.flowchange_timer1){
					clearTimeout(fcChip.flowchange_timer1);
					fcChip.flowchange_timer1 = null;
				}
				fcChip.flowchange_timer1 = setTimeout(function(){
					flowchange_movechip(fcChip.named)
				},50);
		},200);	
	}

	function showFlash(divname,visable,button,u,w,h,p,trasparent,clickdiv,flashparam){
		if(!p)
			p = 0;
		p = (trasparent) ? 0 : 1;
		
		dWrite("<div id='" + divname + "' style='position:absolute;visibility:" + visable + "' ></div>");
		setTimeout(function(){
			var $div = $id(divname);
			$div.onmouseover=_mouserOver; 
			$div.onmouseout = _mouserOut;
		},10);

		var n = flashName + "_" + button; 	

		if( (typeof hf == 'string' && hf !='') && flashparam){
			u = u + "?" + flashparam + "=" + encodeURIComponent(hf);
			return __alysLib.flash(u,w,h,p,divname,n,0);
		}else{
			return __alysLib.flash(u,w,h,p,divname,n,0,hf);
		}		

	}
	function PicDiv(divname,picurl,visable,width,height){
		dWrite("<div id='"+divname+"' style='position:absolute; z-index:1;visibility:"+visable+"'><a href='"+ADFUSER32+"' target='" +
		flowchange_tar + "' ><img src='"+ picurl + "'  border='0' alt='" + flowchange_alt + 
		"' width="+width+" height="+height+"></a></div>");

		setTimeout(function(){
			var $div = $id(divname);
			$div.onmouseover= _mouserOver; 
			$div.onmouseout = _mouserOut;
			var $img = $div.getElementsByTagName('img')[0];
			$img.onmouseover = _mouserOver;
			$img.onmouseout = _mouserOut;
		},10);
	}

	dWrite("<div ID='" + fcID + "' STYLE='position:absolute;'>");

	if(flowchange_pic1_type == 1)
		showFlash(picID,"visible","1",flowchange_pic,flowchange_pic1_wid,flowchange_pic1_hei,0,flash_trasparent1,clickdiv1,flashparam1);
	else
		PicDiv(picID,flowchange_pic,"visible",flowchange_pic1_wid,flowchange_pic1_hei);
	if(flowchange_pic2_type == 1)
		showFlash(lfID,"hidden","2",flowchange_pic2,flowchange_pic2_wid,flowchange_pic2_hei,0,flash_trasparent2,clickdiv2,flashparam2);
	else
		PicDiv(lfID,flowchange_pic2,"hidden",flowchange_pic2_wid,flowchange_pic2_hei);
	dWrite("</div>");

	flowchange_fitMode();

}

//motion_picture震动图片
if(!__alysLib.motion_picture)
	__alysLib.motion_picture = function(initdata){

	var hf = initdata.href;
	var shakebut_pic=initdata.shakebut_pic;
	var shakebut_alt=initdata.shakebut_alt;
	var shakebut_rectop=initdata.shakebut_rectop;	//1:small, 3:middle, 5:big
	var shakebut_speed=initdata.shakebut_speed;	//20:fast, 50:middle, 80:slow
	var shakebut_tar=initdata.shakebut_tar;

	var shakebut_stop=initdata.shakebut_stop;
	var shakebut_a_stop=initdata.shakebut_a_stop;

	var $id = function(id){
		return document.getElementById(id);
	};

	var dWrite = function(s){
		document.write(s);
	};	
	
	var randID = (Math.random()).toString().substring(2);
	
	var shakeId = 'shake' + randID;
	var imgId = 'shakeImg_' + randID;

	function rattleimage(){
		if (!document.getElementById || (shakebut_stop==0))	return;
		var $shakeObj  = $id(shakeId);
	 
		if (shakebut_a_stop==1){
			if(!isNaN(parseInt($id(shakeId).style.top))) {
				$id(shakeId).style.top=parseInt($id(shakeId).style.top,10)+shakebut_rectop + 'px';
			}else {
				$id(shakeId).style.top=shakebut_rectop + 'px';
			}
		}
		else if (shakebut_a_stop==2){
			if(!isNaN(parseInt($id(shakeId).style.left))) {
				$id(shakeId).style.left=parseInt($id(shakeId).style.left,10)+shakebut_rectop + 'px';
			} else {
				$id(shakeId).style.left=shakebut_rectop + 'px';
			}
		}
		else if (shakebut_a_stop==3){
			if(!isNaN(parseInt($id(shakeId).style.top))) {
				$id(shakeId).style.top=parseInt($id(shakeId).style.top,10)-shakebut_rectop + 'px';
			}else {
				$id(shakeId).style.top=-shakebut_rectop + 'px';
			}
		}
		else{
			if(!isNaN(parseInt($id(shakeId).style.left))) {
				$id(shakeId).style.left=parseInt($id(shakeId).style.left,10)-shakebut_rectop + 'px';
			}else {
				$id(shakeId).style.left=-shakebut_rectop + 'px';
			}
		}
		if (shakebut_a_stop<4)
			shakebut_a_stop++;
		else
			shakebut_a_stop=1;
		setTimeout(rattleimage,shakebut_speed);
	}

	var stream = [];
	stream.push("<div id='" + shakeId + "' style='position:relative'>");
	stream.push("<a href='"+hf+"' target='" + shakebut_tar + "'><img border='0'  src='" + shakebut_pic + "' alt='" + shakebut_alt + "'  id='" + imgId + "' ></a>");
	stream.push("</div>");

	document.write(stream.join(''));
	stream = null;

	setTimeout(function(){
		var $img = $id(imgId);
		$img.onmouseover=function(){
			shakebut_stop=1;
			rattleimage()
		};
		$img.onmouseout=function(){
			shakebut_stop=0
		};
	},10);
}
//mouse_move鼠标拖动
if(!__alysLib.mouse_move)
	__alysLib.mouse_move = function(initdata){
	var hf = initdata.href;
	var mousemove_pic=initdata.mousemove_pic;
	var mousemove_poleft=initdata.mousemove_poleft;	//10:left, 300:middle, 570:right
	var mousemove_potop=initdata.mousemove_potop;	//10:top,  180:middle, 380:down
	var mousemove_hreflag=initdata.mousemove_hreflag;	//0:not link, 1:link
	var mousemove_tar=initdata.mousemove_tar;
	var mousemove_alt=initdata.mousemove_alt;

	var doc = window.document;


	var $id = function(id){
		return window.document.getElementById(id);
	};

	var dWrite = function(s){
		window.document.write(s);
	};	
	
	var randID = (window.Math.random()).toString().substring(2);

	var mmId = 'mousemove_floater_' + randID;

	var imgId = 'mm_oImg_' + randID;

	function setPos(){
		var standardCompat = doc.compatMode.toLowerCase();
		var elmDoc=(standardCompat=="backcompat"||standardCompat=="quirksmode")?doc.body:doc.documentElement;
		var cW =  elmDoc.clientWidth;
		var cH = elmDoc.clientHeight;
		var sL = elmDoc.scrollLeft;
		var sT = elmDoc.scrollTop;
		var oImg = $id(imgId);
 
		var imgW = oImg.width || oImg.offsetWidth;
		var imgH = oImg.height || oImg.offsetHeight;
		var imgL,imgT;
		switch (mousemove_poleft) {
			case 10:
				imgL = sL + 10 + "px";
				break;
			case 300:
				imgL = (cW-imgW)/2 + sL +"px";
				break;
			case 570:
				imgL = (cW-imgW) + (sL-10) + "px";
				break;
			default:
				imgL = sL + mousemove_poleft + "px";
				break;
		}
		switch (mousemove_potop) {
			case 10:
				imgT = sT + "px";
				break;
			case 180:
				imgT = (cH-imgH)/2 + sT +"px";
				break;
			case 380:
				imgT = (cH-imgH) + (sT-10) + "px";
				break;
			default:
				imgT = sT + mousemove_potop + "px";
				break;
		}
		var oDiv = $id(mmId);
		var oDStyle = oDiv.style;
		oDStyle.left = imgL;
		oDStyle.top = imgT;
		oDStyle.visibility = "visible";
	}

	var mousemove_light=0;
	var mousemove_bFade=false;

	var stream = [];

	stream.push("<div align=\'center\' id=\'" + mmId + "\'");
	stream.push("style=\'position:absolute; left:0px; top:0px; z-index:1;visibility:hidden;\'>");
	
	if (mousemove_hreflag==1){
		stream.push("<a href=\'"+hf+"\' target=\'" + mousemove_tar + "\'>");
	}
	else if (mousemove_hreflag==0){
		stream.push("<a href=\'#\'>");
	}
	stream.push("</a></div>");	
	dWrite(stream.join(''));
	stream = null;

 

	setTimeout(function(){
		var $img = doc.createElement('img');

		$id(mmId).getElementsByTagName('a')[0].appendChild($img);

		$img.border = 0;
		$img.alt = mousemove_alt;

		$img.onload = function(){
			setPos();
		};

		$img.src = mousemove_pic + '?' + Math.random();
		$img.id = imgId;


		if (mousemove_light==1)
			$img.style = 'position:absolute;opacity:0.5;filter:alpha(opacity=50);';
				
	},10);

	var mousemove_currentX = mousemove_currentY = 0;       
	var mousemove_whichIt = null;        
	var mousemove_lastScrollX = 0; 
	var mousemove_lastScrollY = 0;       
	var mousemove_NS = (doc.layers) ? 1 : 0;       
	var mousemove_IE = (doc.all) ? 1: 0;    
	
	function mousemove_light(){
		var oImg = $id(imgId);
		var nOpacity=oImg.filters.alpha.opacity;
		if (nOpacity>=100) mousemove_bFade=true;
		if (nOpacity<=0) mousemove_bFade=false;
		if (mousemove_bFade) oImg.filters.alpha.opacity--;
		if (!mousemove_bFade) oImg.filters.alpha.opacity++;
	}
      
	function mousemove_heartBeat() { 
		var oImg = $id(imgId);
	
		if(mousemove_IE) { 
			diffY = doc.body.scrollTop;
			diffX = doc.body.scrollLeft;
		}      
		if(mousemove_NS) { diffY = self.pageYOffset; diffX = self.pageXOffset; }
		if(diffY != mousemove_lastScrollY) {       
			percent = .1 * (diffY - mousemove_lastScrollY);       
			if(percent > 0) percent = Math.ceil(percent);       
			else percent = Math.floor(percent);       
			if(mousemove_IE) doc.all[mmId].style.pixelTop += percent;       
			if(mousemove_NS) doc[mmId].top += percent;        
			mousemove_lastScrollY = mousemove_lastScrollY + percent;       
		}       
		if(diffX != mousemove_lastScrollX) {       
			percent = .1 * (diffX - mousemove_lastScrollX);       
			if(percent > 0) percent = Math.ceil(percent);       
			else percent = Math.floor(percent);       
			if(mousemove_IE) doc.all[mmId].style.pixelLeft += percent;       
			if(mousemove_NS) doc[mmId].left += percent;       
			mousemove_lastScrollX = mousemove_lastScrollX + percent;       
		}	
		if (mousemove_IE){
			if (mousemove_light==1){
				var nOpacity=oImg.filters.alpha.opacity;
				if (nOpacity>=100) mousemove_bFade=true;
				if (nOpacity<=0) mousemove_bFade=false;
				if (mousemove_bFade) oImg.filters.alpha.opacity--;
				if (!mousemove_bFade) oImg.filters.alpha.opacity++;
			}
		}
	}       
     
	function startmove(a){
		var b=$id(mmId);
		
		a=fixE(a);

		b.lastMouseX=a.clientX;
		b.lastMouseY=a.clientY;

		doc.onmousemove=function(a){
				var _body = doc.body;
				a = fixE(a);
				var c = a.clientY;
				var d = a.clientX;
				var e = parseInt(b.style.top);
				var f = parseInt(b.style.left);
				var h,g;
				
				h = f+d-b.lastMouseX;
				g = e+c-b.lastMouseY;
				
				b.style.left = h+"px";
				b.style.top  = g+"px";
				
				if(parseInt(b.style.top) < _body.scrollTop)
					b.style.top = _body.scrollTop;  			
				if(parseInt(b.style.left) < _body.scrollLeft) 
					b.style.left = _body.scrollLeft; 

				b.lastMouseX = d;
				b.lastMouseY = c;
				return false;
		};
		doc.onmouseup=function(){
			doc.onmousemove=null;
			doc.onmouseup=null;
		};
		return false;
	} 
	function fixE(a){
		if(typeof a=="undefined")
			a=window.event;
		if(typeof a.layerX=="undefined")
			a.layerX=a.offsetX;
		if(typeof a.layerY=="undefined")
			a.layerY=a.offsetY;
		return a;
	}

    
	$id(mmId).onmousedown=function(a){
		startmove(a);
		return false;
	};
		  
	if(mousemove_NS || mousemove_IE)
		action = window.setInterval(mousemove_heartBeat,50);     

}
//pop_win弹出窗口
if(!__alysLib.pop_win)
	__alysLib.pop_win = function(initdata){
	var hf = initdata.href;
	var flag=initdata.flag;
	var pic=initdata.pic;
	var htm=initdata.htm;
	var wid=initdata.wid;
	var hei=initdata.hei;
	var scrollbars=initdata.scrollbars;
	var tar=initdata.tar;
	var flash_adr=initdata.flash_adr;
	var flash_trasparent=initdata.flash_trasparent;
	var clickdiv=initdata.clickdiv;
	var flashparam=initdata.flashparam;
	var poptop_left=initdata.poptop_left;
	var poptop_hei=initdata.poptop_hei;
	var template=initdata.template;

	var hposition, vposition;
	var aname = navigator.appVersion;
	switch (poptop_left){
		case "Vleft":
			hposition = 5;
			break;
		case "Vcenter":
			hposition = Math.round((screen.availWidth - wid)/2);
			break;
		case "Vright":
			hposition = screen.availWidth - wid - 5;
			break;
	}
	switch (poptop_hei){
		case "Vtop":
			vposition = 5;
			break;
		case "Vmiddle":
			vposition = Math.round((screen.availHeight - hei)/2);
			break;
		case "Vbottom":
			vposition = screen.availHeight - hei - 30;
			break;
	}
	var strwin="toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars="+scrollbars+
		",resizable=1,copyhistory=0,width="+wid+
		",height="+hei+",left=" + hposition  + 
		",top=" + vposition;

	if (flag==0){
		
		var win = window.open("","abc",strwin);
 
		var doc = win.document;
		doc.open("text/html");
		doc.write("<html><body topmargin=0 leftmargin=0><a href='"+hf+"' target='"+tar+"'><img src='"+pic+"' border='0'></a></body></html>");
		doc.close();
		
		win.focus();
	}else if(flag==1){
		var windowfou = window.open(htm,"abc",strwin);
		windowfou.focus();
	}else if(flag==2){
		var win=open("","abc",strwin);
		var doc = win.document;
		var stream = [];
		doc.open();

		stream.push("<HTML><body topmargin='0' leftmargin='0'>");
		stream.push("<script language='JavaScript'>");
		stream.push("function alysxc(u,w,h,p,d,c,b,i,r,a){");
		stream.push("var o=document.getElementById(d),ad;");
		stream.push("p=(!p)?'Transparent':'Opaque';");
		stream.push("ad='<OBJECT classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://active.macromedia.com/flash2/cabs/swflash.cab#version=4,0,0,0\" WIDTH=\"'+w+'\" HEIGHT=\"'+h+'\"><PARAM NAME=\"movie\" VALUE=\"'+u+'\"><PARAM NAME=\"wmode\" VALUE=\"'+p+'\"><EMBED src=\"'+u+'\" WIDTH=\"'+w+'\" HEIGHT=\"'+h+'\" WMODE=\"'+p+'\" TYPE=\"application/x-shockwave-flash\"></EMBED></OBJECT>';");
		stream.push("o.innerHTML=(!i)?'<div style=\"POSITION:relative;Z-INDEX:1;width:'+w+'px;height:'+h+'px\"><DIV style=\"POSITION:absolute;left:0;top:0;Z-INDEX:2;width:'+w+'px;height:'+h+'px\">'+ad+'</div><a href=\"'+a+'\" target=\"_blank\"><IMG SRC=\"'+c+'?local=1x1.gif\" style=\"POSITION:absolute;left:0;top:0;Z-INDEX:3;width:'+w+'px;height:'+h+'px\" border=0></a></div>':ad;");
		stream.push("return d;}");
		stream.push("</scr"+"ipt>");
		stream.push("<script language='JavaScript'>");
		stream.push("function alysxcf(u,w,h,p){");
		stream.push("if(!p)p=0;var d='leftup';");
		stream.push("document.write(\"<div id=\"+d+\"></div>\");");
		stream.push("p=("+flash_trasparent+")?0:1;");
		stream.push("if("+clickdiv+" && '"+flashparam+"'!='')u=u+'?'+'"+flashparam+"="+encodeURIComponent(hf)+"';");
		stream.push("alysxc(u,w,h,p,d,'http://10.0.3.129/1x1.gif','197',"+clickdiv+",0,'"+hf+"');}");
		stream.push("alysxcf('"+flash_adr+"',"+wid+","+hei+");");
		stream.push("</scr"+"ipt>");
		stream.push("</body></HTML>");
		
		doc.write(stream.join(''));
		stream  = null;
		
		doc.close();
	 
		win.focus();
		//win.location.reload();
	}else if(flag==3){ 
		var win=open("","abc",strwin);
		var rowtemplate=template.split("<allyesbr>");
		with(win.document){
			open("text/html");
			for (key in rowtemplate){writeln (rowtemplate[key]);}
			close();
		}
		win.focus();
	}

}

  //