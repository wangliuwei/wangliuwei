function initializeMasonry() {
	// imageLoaded!
	$('#content').imagesLoaded(function () {
		$('#content').masonry({
			columnWidth: '.item',
			// gutter: 20,
			itemSelector: '.item'
		}).masonry('reloadItems').animate({'opacity':1}, 500, function(){
			if ((current_page == 'album' || current_page == 'artist-exhibition-details' || current_page == 'artist-book-details')
			    && $(window).width() > 768){
				clickHandler('toggleGallery', 'slider', $("#toggle"));
			}
		});
		// $('#content').animate({'opacity':1}, 500);
	});
}

$(document).ready(function() {
	if (current_page == 'artist-exhibition-details' || current_page == 'artist-book-details') {
		$("footer").css("margin-top", "0px");
	}
	
	// menu hack for mobile.
	if(typeof(menu) != 'undefined' &&  menu.categories.length > 0) {
		mobileMenuInit(menu, '#subNav'); 
	}

	//var current_page = (typeof current_page == "undefined") ? "" : current_page;


	// The single image loading for the album slideshow
	if (current_page != 'artist-exhibition-details' && current_page != 'artist-book-details') {
		$("#content.album-page").on('click', '.item img', function(event) {
			event.preventDefault();
			if($(window).width() > 768){
				var cycleIndex = $(this).attr("data-cycleindex");
				
				//clickHandler('toggleGallery', 'slider', $("#toggle"));
				$("#toggle").trigger('click');
				$('#content.slider').cycle('goto', cycleIndex);
			}
		});
	}

	$("body").keyup(function(event) {

		if($(".cycle-slide").length > 0){
			if(event.keyCode == 39)
				$("#content").cycle("next");
			else if(event.keyCode == 37)
				$("#content").cycle("prev");
		}
	});
	
	/*
	$('body').on('click', '.popupInit', function (event) {
		console.log('on call');
		var popuptype = $(this).attr('data-type');
		var parameters = $(this).attr('data-params');
		clickHandler(popuptype, parameters, $(this));	
	});
	*/
	
	// Just for iOS...................
	$('.popupInit').on('click', function (event) {
		var popuptype = $(this).attr('data-type');
		var parameters = $(this).attr('data-params');
		clickHandler(popuptype, parameters, $(this));	
	});


	$(window).load(function(){
	 	// console.log($(window).width());
		
		if (current_page != 'category') {
			adjustWebpageElements(true);
			verticallyCenterText($('#content .item'));
			
			$('#main .loading').hide();
			initializeMasonry();
		}
		
		var adjustMasonryColumnWidth = false;
		if ($('#content .item').length <= 0) {
			adjustMasonryColumnWidth = true;
		}
		
		// Ajax galleries
		if (typeof(useAjaxToGetGalleries) != 'undefined' && useAjaxToGetGalleries === true
			&& typeof(galleriesArr) != 'undefined' && galleriesArr.length > 0) {
			for(i = 0; i < galleriesArr.length; i++) {
				$.ajax({
					type: 'post',
					dataType: 'json',
					async: true,
					data: {
						mediaId: galleriesArr[i]
					},
					url: siteUrl + 'getMedia'
				}).done(function (data) {
					//console.log(data);
					var mediaStr = '';
					var mediaElement = $('<div class="item"></div>');
					if (data.type == 'video') {
						mediaElement.attr('data-videoPreview', data.videoPreview);
						var previewStr = '<img src="' + data.image + '" />';
						if (typeof(data.videoPreview) != 'undefined' && data.videoPreview != null) {
							mediaElement.attr('data-thumbnail', data.image);
							var ww = Math.min($(window).width(), 1920);
							if (ww > 1024) {
								previewStr = '<video id="vid" autoplay width="100%" loop>'
									 	   + '<source src="' + data.videoPreview + '" type="video/mp4" />'
									 	   + '</video>';
							} else {
								previewStr = '<img src="' + data.image + '" />';
							}
						}
						//mediaStr = '<div class="item">'
						mediaStr = '<div class="inner">'
								 + '<a href="' + data.link + '"><div class="overlay"><p>' + data.title + '</p></div></a>'
								 + previewStr
								 + '</div>';
								 //+ '</div>';
					} else if (data.type == 'gallery') {
						//mediaStr = '<div class="item">'
						mediaStr = '<div class="inner">'
								 + '<a href="' + data.link + '"><div class="overlay"><p>' + data.title + '</p></div></a>'
								 + '<img src="' + data.image + '" />'
								 + '</div>';
								 //+ '</div>';
					}
					mediaElement.html(mediaStr);
					$('#content').append(mediaElement);
					if (adjustMasonryColumnWidth === true) {
						$('#content').masonry(
							{
								columnWidth: '.item'
							}
						);
						adjustMasonryColumnWidth = false;
					}
					$('#content').masonry('appended', mediaElement);
					$(mediaElement).imagesLoaded(function () {
						verticallyCenterText([mediaElement]);
						$('#content').masonry();
					});
				}).fail(function (data) {
					console.log(data);
				});
			}
		}
		
		// Ajax artists
		if (current_page == 'category'
			&& typeof(useAjaxToGetArtists) != 'undefined' && useAjaxToGetArtists === true
			&& typeof(categoryID) != 'undefined' && Object.prototype.toString.call(categoryID) == '[object String]' && categoryID != '') {
			//for(i = 0; i < galleriesArr.length; i++) {
				$.ajax({
					type: 'post',
					dataType: 'json',
					async: true,
					data: {
						category: categoryID
					},
					url: siteUrl + 'yj/index.php/artists/ajaxGetMediaInfo'
				}).done(function (data) {
					//console.log(data);
					if (data != null && data.length > 0) {
						for(i = 0; i < data.length; i++) {
							var mediaStr = '';
							var mediaElement = $('<div class="item"></div>');
							if (data[i].type == 'video') {
								mediaElement.attr('data-thumbnail', data[i].image);
								mediaElement.attr('data-videoPreview', data[i].videoPreview);
								var previewStr = '<img src="' + data[i].image + '" />';
								if (typeof(data[i].videoPreview) != 'undefined' && data[i].videoPreview != null) {
									mediaElement.attr('data-thumbnail', data[i].image);
									var ww = Math.min($(window).width(), 1920);
									if (ww > 1024) {
										previewStr = '<video id="vid" class="vid" autoplay width="100%" loop>'
											 	   + '<source src="' + data[i].videoPreview + '" type="video/mp4" />'
											 	   + '</video>';
									} else {
										previewStr = '<img src="' + data[i].image + '" />';
									}
								}
								var videoInfoStr = '';
								if (typeof(data[i].videoId) != 'undefined' && data[i].videoId != null
									&& typeof(data[i].vimeoId) != 'undefined' && data[i].vimeoId != null) {
									videoInfoStr = ' data-videoId="' + data[i].videoId + '" data-vimeoId="' + data[i].vimeoId + '"';
								}
								mediaStr = '<div class="inner">'
										 + '<a href="' + data[i].link + '"' + videoInfoStr + '><div class="overlay"><p>' + data[i].name + '</p></div></a>'
										 + previewStr
										 + '</div>';
							} else if (data[i].type == 'gallery') {
								mediaStr = '<div class="inner">'
										 + '<a href="' + data[i].link + '"><div class="overlay"><p>' + data[i].name + '</p></div></a>'
										 + '<img src="' + data[i].image + '" />'
							}
							mediaElement.html(mediaStr);
							$('#content').append(mediaElement);
						}
					}
					adjustWebpageElements(true);
					verticallyCenterText($('#content .item'));
					
					$('#main .loading').hide();
					initializeMasonry();
					
					var videoElements = $('#content video.vid');
					if (videoElements.length > 0) {
						var readyVideos = 0;
						var masonryReinitialized = false;
						for(i = 0; i < videoElements.length; i++) {
							var currentIndex = i;
							var vidIntFunc = setInterval(
								function () {
									clearInterval(vidIntFunc);
									if (videoElements.get(currentIndex).readyState === 4) {
										readyVideos++;
										clearInterval(vidIntFunc);
									}
									if (masonryReinitialized === false && readyVideos >= videoElements.length) {
										masonryReinitialized = true;
										$('#content').masonry();
									}
								},
								500
							);
						}
					}
				}).fail(function (data) {
					console.log(data);
				});
			//}
		}
  
    }).resize(function() {
    	adjustWebpageElements(false);
    	verticallyCenterText($('#content .item'));

    	
    	/*$('#content').masonry({
			columnWidth: '.item',
			// gutter: 20,
			itemSelector: '.item'
		}).masonry('reloadItems').animate({'opacity':1}, 500);      
    	*/
    });
    
    $('#share, #social-media-sharing').hover(
		function () { $('#social-media-sharing').removeClass('hidden');},
		function () { $('#social-media-sharing').addClass('hidden');}
	);
});


// Main variables
var view_mode = "all";

// mobile menu - custom function
function mobileMenuInit (menuJson, selector) {
	//Check data && obj
	obj = $(selector);
	if(typeof(menuJson) == 'undefined' || obj.length == 0 ) { 
		console.log('Error: Incorrect data or Cannot find menu container'); 
		return; 
	}

	var ww = $(window).width();
	var mainMenuStr = '';

	//Create main menu string
	$.each(menuJson.categories, function(i, v){
		mainMenuStr += '<li class="next" data-type="categories" data-index="'+ i +'" data-id="'+ v.id +'" data-urlname="'+ v.url_name +'">'+ v.name +'</li>';
	});
	mainMenuStr = '<ul>'+ mainMenuStr +'</ul>';
	
	//join main menu footer
	mainMenuStr += '<ul>';
	//mainMenuStr += '<li><a href="http://syndication.artpartner.com/">Licensing</a></li>';
    mainMenuStr += '<li><a href="#">Make upartists</a></li>';
    mainMenuStr += '<li><a href="#">Production</a></li>';
	mainMenuStr += '<li><a href="#">About</a></li>';
	mainMenuStr += '<li><a href="#">News</a></li>';
	mainMenuStr += '<li><a href="">Contact</a></li>';

    mainMenuStr += '</ul>';

    //Wrap menu in full-width menu container
	mainMenuStr = '<div class="inner"><div class="menu" data-levelcount="0" data-type="main">'+ mainMenuStr +'</div></div>';

	obj.on('click', 'http://www.artpartner.com/js/li.next', function(e, animateMenu) { 
		mobileMenu.nextMenu(menuJson, e, $(this), animateMenu); 
	});
	obj.on('click', 'http://www.artpartner.com/js/li.prev', function(e, animateMenu) { 
		mobileMenu.prevMenu(menuJson, e, $(this), animateMenu); 
	});
	obj.html(mainMenuStr);
	obj.find('.menu').width(ww);
}

var mobileMenu = {
	nextMenu: function(menuJson, e, obj, animateMenu) {
		var ww = $(window).width();
		var inner = obj.parents('.inner');
		var currMenu = obj.parents('.menu');
		var currlvlCount = parseInt( obj.parents('.menu').attr('data-levelcount') );
		var currlvlType = obj.attr('data-type');
		var menuCount = inner.find('.menu').length;
		var queryObj = null;

		// console.log('Current Level:', currlvl);
		// console.log('Menu Count:', menuCount);
		// console.log('next level', obj);
		
		//caching functions
		//check to see if requested menu at the next level exists, if it exists, show it.
		//if it doesn't exists, destroy the menu placeholder at the next level, and load a new menu 
		var menus = inner.find('.menu[data-levelcount="'+ (currlvlCount+1) +'"]');
		if(menus.length > 0 && menus.attr('data-id') == obj.attr('data-id') ) {
		} else {
			if(menus.length > 0) { 
				menus.remove(); 
				inner.find('.menu[data-levelcount="'+ (currlvlCount+2) +'"]').remove();
				inner.find('.menu[data-levelcount="'+ (currlvlCount+3) +'"]').remove();
			}
			//create new menu
			mobileMenu.generateMenu(menuJson, obj, currlvlType, currlvlCount) ;
		}
		
		if (typeof(animateMenu) == 'undefined') {
			animateMenu = true;
		}
		if (animateMenu === true) {
			// adjust container and shift to the indicated position
			inner.css({ 'width': ww*(menuCount+1) }).animate({'margin-left':-ww*(currlvlCount+1) }, 500);
		} else {
			inner.css({ 'width': ww*(menuCount+1), 'margin-left': -ww*(currlvlCount+1) });
		}
	},
	prevMenu: function(menuJson, e, obj, animateMenu) {
		var ww = $(window).width();
		var inner = obj.parents('.inner');
		var currlvlCount = obj.parents('.menu').attr('data-levelcount');

		inner.animate({'margin-left':-ww*(currlvlCount-1) }, 500);	
	}, 
	generateMenu: function(menuJson, obj, type, currentMenuCounter) {
		var ww = $(window).width();
		var inner = obj.parents('.inner');
		var dataId = obj.attr('data-id');
		if(typeof(menuJson) == 'undefined') { console.log('Error: No menu data available.'); return false; } 
		
		var prevMenuStr = '';
		var mainMenuStr = '';
		var index = obj.attr('data-index');
		var index1 = obj.attr('data-index1');
		switch(type) {
			case 'categories':
				var mainMenuSocialMediaStr = '';
				// Generate the social media links (this should be there only for Giovanni Testino Inc. menu)
				if (typeof(menuJson.categories[index].socialmedia) != 'undefined' && menuJson.categories[index].socialmedia != null) {
					$.each(menuJson.categories[index].socialmedia, function (i, v) {
						//console.log(i, v);
						mainMenuSocialMediaStr += '<li class=""><a href="' + v.link + '" target="_blank">' + v.title + '</a></li>';
					});
				}
				
				//next level is to get all artist by category	
				menuJson = menuJson.categories[index].artists;
				prevMenuStr = 'Main menu';

				//Generate menu template
				mainMenuStr = '<li class="prev" data-type="'+ type +'">'+ prevMenuStr +'</li>';
				$.each(menuJson, function(i, v){
					if (typeof(v.subcategories) == 'undefined' || v.subcategories.length == 0) {
						mainMenuStr += '<li class=""><a href="' + v.link + '">' + v.artist + '</a></li>';
					} else {
						mainMenuStr += '<li class="next" data-type="artists" data-index="'+ index +'" data-index1="'+ i +'" data-id="'+ v.id +'" data-urlname="'+ v.url_name +'">'+ v.artist +'</li>';
					}
				});
				
				mainMenuStr += mainMenuSocialMediaStr;
			break;

			case 'artists':
				//next level is to get artist details
				menuJson = menuJson.categories[index].artists[index1];
				//console.log(menuJson);
				prevMenuStr = 'Back';

				//Generate menu template
				mainMenuStr = '<li class="prev" data-type="'+ type +'">'+ prevMenuStr +'</li>';
				mainMenuStr += '<li class="" data-id="'+ menuJson.id +'" data-urlname="'+ menuJson.url_name +'"><a href="' + menuJson.link + '">'+ menuJson.artist +'</a></li>';
				
				//Generate sub category string
				if(menuJson.subcategories_count > 0) {
					$.each(menuJson.subcategories, function(i, v){
						//mainMenuStr += '<li class=""><a href="main.js-type='+ v.name +'"/*tpa=http://www.artpartner.com/js/main.js?type='+ v.name +'*/>'+ v.name +'</a></li>';
						mainMenuStr += '<li class=""><a href="'+ v.link +'">'+ v.name +'</a></li>';
					});
				}
				//Generate the social media links
				if (typeof(menuJson.socialmedia) != 'undefined' && menuJson.socialmedia != null) {
					$.each(menuJson.socialmedia, function(i, v){
						mainMenuStr += '<li class=""><a href="'+ v.link +'" target="_blank">'+ v.title +'</a></li>';
					});
				}

				//Generate the social media links
				if (typeof(menuJson.shareLinks) != 'undefined' && menuJson.shareLinks != null) {
					var social_menu = "<ul class='lower-menu'>";
					$.each(menuJson.shareLinks, function (i, v) {
						social_menu += '<li class=""><a href="' + v.link + '" target="_blank">' + v.title + '</a></li>';
					});
					social_menu += "</ul>";
					mainMenuStr += "<li class='has-subclass'>" + social_menu + "</li>";
				}
			break;

			default:
				console.log('no case defined');
			break;
		}

		
		// outut all content and fix widths of each menu
		mainMenuStr = '<div class="menu" data-levelcount="'+ (parseInt(currentMenuCounter)+1) +'" data-type="'+ type +'" data-id="'+ dataId +'"><ul>'+ mainMenuStr +'</ul></div>';
		inner.append(mainMenuStr);
		inner.find('.menu').width(ww);

	}

};



function clickHandler(type, params, obj) {
	if(typeof(params) == 'undefined') { params = null; }
	if(typeof(obj) == 'undefined') { obj = null; }

	switch(type) {
		case 'toggleNav':
			// console.log('Y');
			if (params== 'show') {
				var ww = $(window).width();
				var inner = $('#subNav').find('.inner');

				//show the menu
				$('#overlayBackground').fadeIn(300);
				$('#subNav').fadeIn(500);
				$('header').css('z-index','9001');
				$('#content').hide();

				//menu reset widths just incase you're on a browser and you're resizing the window.
				inner.find('.menu').width(ww);
				inner.css('width', (inner.find('.menu').length * ww));
				
				// Always open menu at first level
				inner.css('margin-left', 0);
				
				obj.attr('data-params','hide');
			} else {
				//hide the menu
				$('#overlayBackground').fadeOut(300);
				$('#subNav').fadeOut(500);
				$('header').css('z-index','100');
				$('#content').show();
				obj.attr('data-params','show');
			}
			break;
		case 'toggleGallery':
			var parent = $('#content');
			//var cw = $('#main .fluid').width()-245;
			var bw = $("body").width();
			var cw = parent.width();
			var img = parent.find('img.album-image');

			if(params == 'slider') {
					obj.removeClass('slider').attr('data-params', 'grid').find('span').html('<img src="' + siteUrl + 'images/grid-icon.png"> View <br>All');
					//Destroy pinterest layout

					//if(parent.find(".item").first().css("position") == "absolute")
					parent.masonry('destroy').removeClass('grid').addClass('slider');

					if(bw < 769)
						parent.width(bw);
					else
						parent.width(cw);
					img.unwrap();


					// On the album page, to put the footer always to the bottom
					if(current_page == "album"){
						var min_height = $(window).height() - 150;
            			$("#main").css("min-height", min_height);
            		}

					var counter = 0;
					var imgCount = 0;
					var cycleIndex = -1;
					img.each(function(index) {
							var w = parseInt($(this).attr('data-img-width'));
							var h = parseInt($(this).attr('data-img-height'));
							var ratio = w/h;
							var newImage = true;
							
							if(ratio >= 1) {
								//for wide images
								newImage = true;
								imgCount = 0;
								counter++;

								// console.log('wide', newImage, imgCount, counter);
							} else {
								//for tall images
								imgCount++;
								if(imgCount <= 1) {
									counter++;
									newImage = true;
									// console.log('tall-1', newImage, imgCount, counter);
								} else if(imgCount == 2){
									newImage = false;
									imgCount = 0;
									// console.log('tall-2', newImage, imgCount, counter);
								}

							}

							//var class_name = (counter > 1) ? "multiple" : "single";
							if(newImage == true) {
								cycleIndex++;
								$(this).wrap(function() { return '<div class="slide" data-counter="'+ counter +'"></div>'; });
								// parent.prepend(newImage);
							} else {
								$(this).appendTo( $('.slide[data-counter="'+ counter +'"]') );
								$('.slide[data-counter="'+ counter +'"]').addClass('multiple');
							}

							$(this).attr('data-cycleIndex', cycleIndex);
					});
				
					$('#content.slider').prepend('<div class="cycle-prev"></div> <div class="cycle-next"></div>');
					$('#content.slider').cycle({
						slides: '>.slide',
						pauseOnHover: true,
						log: false
					});

					view_mode = "layout"; // Updating the view mode

			} else {
					obj.addClass('slider').attr('data-params', 'slider').find('span').html('<img src="' + siteUrl + 'images/layout-icon.png"> Layout View');
					$('#content.slider').cycle('destroy').removeClass('slider').addClass('grid');
					$('.cycle-prev, .cycle-next').remove();
					//parent.width($(window).width() * 0.785);
					if(bw < 769)
						parent.width(bw);
					else
						parent.width(cw);

					img.each(function(index) {
						// console.log($(this).parent(), $(this).parent().is('.slide'));
						if($(this).parent().is('.slide') ) {
							$(this).unwrap();
							$(this).wrap('<div class="item"></div>');
						} else {
							$(this).wrap('<div class="item"></div>');
						}
					});

					$('#main #content').masonry({
						columnWidth: '.item',
						//gutter: 20,
						itemSelector: '.item'
					}).masonry('reloadItems').animate({'opacity':1}, 500);

					view_mode = "all"; // Updating the view mode
					adjustWebpageElements();
			}
			break;
		
		case 'mobileContentDivBackBtn':

			var levelOneId = $(obj).attr('data-levelOneId');
			var levelTwoId = $(obj).attr('data-levelTwoId');
			$('#subNavTrigger').trigger('click');
			//setTimeout(function () {}, 3000);
			if (typeof(levelOneId) != 'undefined' && typeof(menu) != 'undefined' && typeof(menu.categories) != 'undefined' && menu.categories.length > 0) {
				$.each(menu.categories, function (i, v) {
					if (v.url_name == levelOneId) {
						$('li[data-type="categories"][data-urlname="' + levelOneId + '"]').trigger('click', [false]);
						if (typeof(levelTwoId) != 'undefined' && typeof(v.artists) != 'undefined' && v.artists.length > 0) {
							$.each(v.artists, function (index, value) {
								if (value.url_name == levelTwoId) {
									$('li[data-type="artists"][data-urlname="' + levelTwoId + '"]').trigger('click', [false]);
									return false;
								}
							});
						}
						return false;
					}
				});
			}
			break;
		
		case 'scrollToTop':
			if (!params) {
                params = 0;
            }
			$('html, body').animate({ scrollTop: params }, 600);
			break;
		default:
			//console.log('Click type: None assisgned');
			break;
	}
}


function verticallyCenterText(obj) {
	//obj.each(function(index) {
	$.each(obj, function(index, value) {
		var h = $(this).height();
		
		if (h <= 0) {
			var that = this;
			var hIntFunc = setInterval(
				function () {
					if ($(that).height() > 0) {
						verticallyCenterText([that]);
						clearInterval(hIntFunc);
					}
				},
				50
			);
		}
		
		var th = $(this).find('.overlay p').height();
		
		if(th < h) {
			$(this).find('.overlay p').css('margin-top', ((h-th)/2));
		}
	});
}

function adjustWebpageElements(firstLoad) {
    var wh = $(window).height();
    var ww = Math.min($(window).width(), 1920);
    var cw = $('header .container').width();
    var mTop = 0;
    
    if (ww > 1024) {
    	// Remove thumbnails for videos ad re-add video elements
    	if (current_page == 'index') {
    		$('.vertical-slideshow-container .video-slide[data-videoPreview]').each(function () {
    			var videoPreviewFile = $(this).attr('data-videoPreview');
    			if (typeof(videoPreviewFile) != 'undefined' && videoPreviewFile != '') {
    				var imageElements = $(this).find('img.videoThumbnail');
    				if (imageElements.length > 0) {
		    			imageElements.remove();
			    		$(this).prepend(
			    			'<video id="vid" class="vid" autoplay width="100%" loop>'
			    			+ '<source src="' + videoPreviewFile + '" type="video/mp4" />'
			    			+ '</video>'
			    		);
		    		}
    			}
    		});
    	} else {
	        $('#content .item[data-videoPreview]').each(function () {
	        	var videoPreviewFile = $(this).attr('data-videoPreview');
	        	if (typeof(videoPreviewFile) != 'undefined' && videoPreviewFile != '') {
		    		var imageElements = $(this).find('.inner img');
		    		if (imageElements.length > 0) {
		    			imageElements.remove();
			    		$(this).find('.inner').append(
			    			'<video id="vid" class="vid" autoplay width="100%" loop>'
			    			+ '<source src="' + videoPreviewFile + '" type="video/mp4" />'
			    			+ '</video>'
			    		);
		    		}
	    		}
	    	});
    	}
        // -----------------------------------------------------
    } else {
    	// Remove video elements and add thumbnails
    	if (current_page == 'index') {
    		$('.vertical-slideshow-container .video-slide[data-videoPreview]').each(function () {
    			var videoElements = $(this).find('video');
	    		if (videoElements.length > 0) {
	    			videoElements.remove();
		    		$(this).prepend(
		    			'<img class="videoThumbnail" src="' + $(this).attr('data-thumbnail') + '" />'
		    		);
	    		}
    		});
    	} else {
	    	$('#content .item[data-videoPreview]').each(function () {
	    		var videoElements = $(this).find('video');
	    		if (videoElements.length > 0) {
	    			videoElements.remove();
		    		$(this).find('.inner').append(
		    			'<img src="' + $(this).attr('data-thumbnail') + '" />'
		    		);
	    		}
	    	});
	    }
    	// ----------------------------------------
    }
    
    //Y-axis adjust to vertically center gallery on homepage
    if(ww >= 960) {
        if((wh-90-60-525-47) > 0){
            mTop = (wh-90-60-525-47)/2;
        }
        $('#subNav').hide();
    } else {
    	
    }
    $('#bannerContainer').css('margin-top', mTop).animate({opacity:1}, 500);


    //HACKS FOR LAYOUT - make sure this is run BEFORE masonry runs. Masonry uses the margins to do absolute left positioning.
    //Normally masonry will allow you a fixed gutter width using the "gutter" parameter
    //Because the masonry layouot doesn't allow for gutter widths to be % based we need to do a position based hack
    //Margins will be set on the object directly
    //We will expand the width of the #content div by the width of the "gutter", and offset it by the same amount.
    //Look for #content div where the pinterest layout will reside
    if($('#content').length > 0) {
  //   	var contentWidth = $('#content').width();
  //   	var contentMargin = parseInt( $('#content').css('margin-right') );
		// var itemWidth = Math.floor((contentWidth-(itemMargin*(columns-1)))/columns);
		// var itemMargin = 20;
		// // itemMargin = Math.ceil(itemMargin);
		// // var columns = 4;
		// // if(ww <= 1024) {
		// // 	columns = 3;
		// // }

		// // //calculate the layout
		// // $('#content .item').css({
		// // 	'width': itemWidth,
		// // 	'margin-right': itemMargin
		// // });
		// $('#content').css({
		// 	'width': Math.ceil(contentWidth+itemMargin), 
		// 	'margin-right': contentMargin-itemMargin
		// });
    }

	// //X-axis adjust
	// if(ww > 959) {
	// 	$('nav, #main #content').width(cw-242);
	// } else {
	// 	$('nav').removeAttr('style');
	// 	$('#main #content').width(cw-242);
	// }

 //    if (wh < 800) {
 //        $('.index footer').css({'position':'relative', 'margin-top':'20px', 'float':'left'});
 //    }
 //    if($('body.index').length == 0 && $('header .subpageBar').length == 0) {
	// 	$('header .container').append('<div class="subpageBar" style="width: '+ (cw-250) +'px"></div>');
	// 	$('#main #content').width(cw-250);
	// } else {
	// 	$('header .subpageBar, #main #content').width(cw-250);
	// }


	var $container = $("#content");
	//$container.width(parseInt($(window).width() * 0.785));
	if(ww < 769){
		$container.width(ww);
		$("#leftNav").hide();
		//console.log("100%");
	}else{
		
		$("#leftNav").show();
		if(current_page == "album"){
			//console.log("ALBUM");
			$container.width(parseInt(ww*0.775) - 45);
			$container.css('right', 45);
			$("#toggle").css('right', -45);
		}
		else
			$container.width(parseInt(ww*0.775));
	}
	//if(view_mode == "all")
		//$container.width(parseInt($(window).width() * 0.785));

	if (current_page == 'artist-exhibition-details' || current_page == 'artist-book-details') {
		if($(".exhibitionTitle").length > 0)
    		$(".exhibitionTitle").width($("#content").width());
    	if($(".book-description").length > 0)
    		$(".book-description").width($("#content").width());
	}
	
	if (ww > 768) {
    	//$('#mobileContentDiv').hide();
    	if ((typeof (firstLoad) == 'undefined' || firstLoad === false)
    		&& (current_page == 'artist-exhibition-details' || current_page == 'artist-book-details')
    		&& $('#content .item').length > 0) {
    		clickHandler('toggleGallery', 'slider', $("#toggle"));
    	}
    } else {
    	//$('#mobileContentDiv').show();
    	if((current_page == "album" || current_page == "artist-exhibition-details" || current_page == "artist-book-details") && $(".cycle-slide").length > 0){
    		clickHandler('toggleGallery', 'layout', $("#toggle"));
    	}
    }
}


// function adjustLayout() {
// 	//console.log('run this function');
// 	if($('#leftColumn').length > 0 && $('#rightColumn').length > 0) {
// 		var lH = $('#leftColumn').height();
// 		var rH = $('#rightColumn').height();
// 		var h = Math.max(lH, rH); 
// 		$('#leftColumn, #rightColumn').height(h);
// 	}
// }