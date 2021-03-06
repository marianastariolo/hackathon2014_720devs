var fancybox={
	init:function() {
		$(".fancyvideo").fancybox({
			fitToView	: false,
			width		: '100%',
			height		: '100%',
			autoSize	: false,
			closeClick	: false,
			openEffect	: 'none',
			padding     : '0',
			closeEffect	: 'none'
		});
	}
};

var slider={
	init:function() {
		$('#slider-top').superslides({
			hashchange: true,
			play: 5000
		});
	}
};

var scrollMenu={
	init:function() {
		$('a[href*=#]:not([href=#])').click(function() {
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
				if (target.length) {
					$('html,body').animate({
						scrollTop: target.offset().top
					}, 1000);
				return false;
				}
			}
		});

		$(window).bind('scroll', function() {
			if ($(window).scrollTop() > 50) {
				$('.navbar').addClass('navbar-white');
			}
			else {
				$('.navbar').removeClass('navbar-white');
			}
		});
	}
};

var fancybox2={
	init:function() {
		$('.fancybox-media').fancybox({
			type:'iframe'
		});
		
	}
};

var ListView = {
	init: function(){
		//masonry layout
		var container = document.querySelector('#grid');
		$(".item").each(function(){
			$(this).css('width',$(this).outerWidth()+'px');
		});
		imagesLoaded( container, function() {
			var msnry = new Masonry( container, {
				itemSelector: '.item'
			});	
		});

		//add to my boards
		$('.board-add').fancybox({
			type: 'iframe'
		});
	}
};

var Layout = {
	setSidebarSize: function(){
		Layout._setSidebarSize();
		$(window).resize(function(){
			Layout._setSidebarSize();
		});
	},

	_setSidebarSize: function(){
		var margins = $('.user').outerHeight(true) - $('.user').height();
		console.log(margins);
		$('.user').height( $(window).height() +  margins );
	}	
};

var Topics = {
	add: function(){
		$('#home-component .add-button').on('click',function(e){
			e.preventDefault();
			$(this).hide(1);
			$('#home-component .search').show(1);
		});

		$('.user .add-button').on('click',function(e){
			e.preventDefault();
			$(this).hide(1);
			$('.user .search').show(1);
		});
	},

	remove: function(id){
		var c = window.confirm("Are you sure you want delete this interest?");
		if(c){
			$.post(domain+'/topics/delete/'+id,{},function(res){
				LoadComponents.topics();
			});
		}
	}

};

var LoadComponents = {
	boards: function(callback){
		$.getJSON( domain + '/boards',{},function(res){
			html = "";
			for(var i=0; i<res.length; i++){
				html += '<li><a href="'+ res[i].permalink +'">'+ res[i].name +'</a></li>'
			}
			$('#component-boards .dropdown-menu').html( html );
		});

		if(typeof callback != "undefined"){
			callback();
		}
	},

	topics: function(callback){
		$.getJSON( domain + '/topics',{},function(res){
			html = "";
			for(var i=0; i<res.length; i++){
				html += '<span class="tag">\
					<a href="'+ res[i].permalink +'">'+ res[i].name +'</a>\
					<a class="glyphicon glyphicon-remove" href="javascript://" onclick="javascript:Topics.remove('+ res[i].id +');"></a>\
				</span>';
			}
			$('#component-topics').html( html );
		});

		if(typeof callback != "undefined"){
			callback();
		}
	},

	profilePic: function(){
		var access_token =   FB.getAuthResponse()['accessToken'];

		FB.api(
			"/me/picture",
		    {
		        "redirect": false,
		        "height": "120",
		        "type": "normal",
		        "width": "120"
		    },
		    function (response) {
				if (response && !response.error) {
					$('.profile .img-circle').attr('src',response.data.url);
					$('.profile .img-circle').fadeIn(200);
				}
		    }
		);
	},
}