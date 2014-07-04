$(document).ready(function(){
	//每5分钟更新一次页面
	var timeOfUpdate = 300000;
	$('#txtFilterCampaign').live('click',function(){
		$(this).attr('value','');
	});
	$('.close').live('click',function(){
		$('.public_tip').remove();
	});
	//点击搜索获取订单列表
	$('#btnAjaxSearch').live('click',function(){
		$.ajax({
		    url: '../mediaCenter/ajaxGetCampaigns',
		    data: 'key=' + $('#txtFilterCampaign').val(),
		    type: 'GET',
		    dataType: 'html',
		    timeout: 10000,
		    error: function(){
		        alert('Error loading');
		    },
		    success: function(data){
				$('.media_center_drop_searchbox').remove();
				$('.default_corner_input').after(data);
				/*
		    	$('#filterCampaign').empty();
		    	$.each(data, function(key, value){
		    		$('#filterCampaign').append('<li phaseId="'+value['phaseID']+'" stateId="'+value['stateID']+'"><a href="../campaign/view?id='+value['ID']+'" >' + value['Name'] + '</a></li>');
				});
		    	$('#displayCanpaignList').removeClass('op');
		    	$('#displayCanpaignList').addClass('show');
		    	$('#filterCampaign').show('slow');
		    	*/
		    }
		});
	});
	
	//点击具体流程弹出订单列表
	$('.flow').live('click', function(){
		var flow = $(this);
		//tb_show('订单列表','../mediaCenter/campaignList?MediaManager_FlowControlCurrent[phaseID]='+$(this).attr('phaseId')+'&MediaManager_FlowControlCurrent[stateID]='+$(this).attr('stateId')+'&KeepThis=true&TB_iframe=true&width=800&height=450');
		tb_show('订单列表','../campaign/list?layout=thickbox&MediaManager_FlowControlCurrent[phaseID]='+$(this).attr('phaseId')+'&MediaManager_FlowControlCurrent[stateID]='+$(this).attr('stateId')+'&KeepThis=true&TB_iframe=true&width=900&height=500');
	});
	$('body').live('click',function(){
		$(".media_center_table").remove();
	});
	
	$('.flow').live('mouseover',function(){
		$(this).addClass('hover');
	});
	
	$('.flow').live('mouseout',function(){
		$(this).removeClass('hover');
	});
	
	//鼠标移上订单列表高亮显示
	$('#filterCampaign > li').live('mouseover',function(){
		$(this).addClass('hover');
		$(this).find('s').show();
		$('.media_center').find('.flow[phaseId='+$(this).attr('phaseId')+'][stateId='+$(this).attr('stateId')+']').addClass('show');
	});
	
	//鼠标移出订单列表高亮显示
	$('#filterCampaign > li').live('mouseout',function(){
		$(this).removeClass('hover');
		$(this).find('s').hide();
		$('.media_center').find('.flow[phaseId='+$(this).attr('phaseId')+'][stateId='+$(this).attr('stateId')+']').removeClass('show');
	});
	
	$('#displayCanpaignList').live('click',function(){
		if($(this).attr('class')=='show'){
			$('#filterCampaign').hide('slow');
			$(this).html('展开');
			$(this).attr('class','hide')
		}
		else if($(this).attr('class')=='hide'){
			$('#filterCampaign').show('slow');
			$(this).html('隐藏');
			$(this).attr('class','show');
		}
	});
	
	//每隔一段时间刷新流程图
    setInterval('DynamicUpdate()', timeOfUpdate);
	
});

function DynamicUpdate(){
	$.ajax({
	    url: 'ajaxGetPhaseState',
	    data: '',
	    type: 'GET',
	    dataType: 'html',
	    success: function(data){
			$('div.con_in').html(data);
	    }
	});
}
