/**
 * 省市联动
 */
$(document).ready(function(){
	var province = $("#province_info").val();
	var city = $("#city_info").val();
	if(province != ''){
		$.ajax({
			type: "POST",
			url: "AjaxGetCity",
			data: "province="+province,
			dataType: 'json',
		    timeout: 3000,
		    error: function(){
		        alert('Error loading');
		    },
			success: function(data){
				$("#city_info").empty();
				var str = '';
				$.each(data,function(key,value){
					if(key == city){
						str += '<option value="' + key + '" selected= "selected">' + value + '</option>'
					}else{
						str = '<option value="' + key + '">' + value + '</option>'
					}
					$("#city_info").append(str);
				});
		   	}
		});
	}
	$("#province_info").change(function(){
		$.ajax({
			type: "POST",
			url: "AjaxGetCity",
			data: "province="+$(this).val(),
			dataType: 'json',
		    timeout: 3000,
		    error: function(){
		        alert('Error loading');
		    },
			success: function(data){
				$("#city_info").empty();
				$.each(data,function(key,value){
					$("#city_info").append('<option value="' + key + '">' + value + '</option>');
				});
		   	}
		});
	});
});