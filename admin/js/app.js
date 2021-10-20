var api = new Api();
$.kesh = {};
var me = Api.prototype.getSync('myprofile');
var cid = 100;
var loader = {
	activate: function () {
		$(".loader").addClass("showed");
	},
	deactivate: function () {
		setTimeout( function(){ $(".loader").removeClass("showed"); }, 100 );
	},
	isActive: function() {
		return $(".loader").hasClass("showed")
	}
};

function pinger() {
	$.post("/admin/pinger.php", function(result) { });
}

(function($) {
	var app = $.sammy(function() {
		function setActive( url ) {
			$("li.active").removeClass('active');
			$("a[href='"+ url +"']").parent().addClass('active');
		}
		
		function loadPage( page, callback ) {
			loader.activate();
			$.ajax({
				url: '/admin/pages/' + page + '.php',
				data: {r: Math.random()},
				success: function(r, s) {
					$(".pages").html( r );
					$(".page:first").attr('cid', cid++);
					if (callback) callback();
					loader.deactivate();
				}, 
				error: function( r, s ){
					console.log( r, s );
					loader.deactivate();
				}
			});
		}
		
		this.get('/admin/#dashboard', function(e, r) {
			setActive( '#dashboard' );
			
			//После загрузки данных надо поменять заголовок
			$("#header-region").html("<div><h1>Поиск по имени</h1></div>");
			
			loadPage( 'dashboard', function(){
				/* if (me.role == 0) {
					appendColumn( 'statistics-fast');
				} */
			});
		});		
		
		this.get('/logout/', function(e, r) {
			location.href = "/admin/logout/";
		});
		
		this.get('/admin/', function(e, r) {
			setActive( '#dashboard' );
			
			//После загрузки данных надо поменять заголовок
			$("#header-region").html("<div><h1>Поиск по имени</h1></div>");
			
			loadPage( 'dashboard' );
		});
		
		$(function() {
			
				if (~location.href.indexOf('#')) {
					app.run(location.href.substr(location.href.indexOf('#')));				
				} else {
					app.run('/admin/#dashboard');
				}
						
			$(".user-info-name").click( function(){
				return false;
				if ($("#employeid").length > 0) return;
				appendColumn( 'employe-item', { employeid: me.id } );
			});
			
			setInterval(pinger, 30000);
		});
	});
})(jQuery)

function appendColumn( href, data ) {
	loader.activate();
	if (!data) data = {};
	data.rnd = Math.random();
	setTimeout( function() {
		$.ajax({
			url: '/admin/pages/' + href + '.php',
			data: data,
			success: function(r, s) {
				$(".pages").append( r );
				
				//Задаем ид загруженной странице
				var $p = $(".column:last").attr('cid', cid++);
				
				//Расчет ширины столбцов (нужно ли сжимать содержимое)
				var $wrapper = $(".pages");
				var $pages = $(".page:not(.remove-page)");
				var psw = 0;
				for (var i = 0; i < $pages.length; i++) {
					psw += $($pages[i]).width();
				}
				
				var raz = $wrapper.width() - psw;
				
				if ( raz < 0 ) {
					for (var i = 0; i < $pages.length; i++) {
						if (raz >= 0) break;
						if ($($pages[i]).hasClass('collapse')) continue;
						raz += $($pages[i]).width();
						$($pages[i]).data().width = $($pages[i]).width();
						$($pages[i]).addClass('collapse');
					}
				}
				
				//Отображение добавленной страницы
				setTimeout( function(){ $p.removeClass("init"); }, 50 );
				
				loader.deactivate();
			}, 
			error: function( r, s ){
				console.log( r, s );
				loader.deactivate();
			}
		});
	}, 400);
}

function getCid( elem ) {
	$page = $(elem);
	for (var i = 0; i < 10; i++) {
		if ($page.attr('cid')) return $page.attr('cid');
		$page = $page.parent();
	}
	return null;
}

function removePage( page ) {
	page.addClass('remove-page');
	page.addClass('init');
	setTimeout( function() { page.remove() }, 200 );
}

//Закрытие текущей и последующих страниц
function prev( self, nxt ) {
	if (!nxt) nxt = 0;
	var pages = $(".page");
	var pcid = getCid( self );
	for (var i = 0; i < pages.length; i++) {
		if ($(pages[i]).attr('cid') === pcid) {
			for (var j = pages.length - 1; j >= i + nxt; j--) {
				removePage( $(pages[j]) );
			}
			//Если есть свернутые страницы - открываем их
			if ( $('.page.collapse').length > 0 ) {
				
				var $wrapper = $(".pages");
				var $pages = $(".page:not(.remove-page)");
				var psw = 0;//ширина несвернутых страниц
				for (var i = 0; i < $pages.length; i++) {
					if ($($pages[i]).hasClass('collapse')) continue;
					psw += $($pages[i]).width();
				}
				
				for (var i = $pages.length - 1; i >= 0; i--) {
					if (!$($pages[i]).hasClass('collapse')) continue;
					if (psw + $($pages[i]).data().width > $wrapper.width()) break;
					psw += $($pages[i]).data().width;
					recollapse($($pages[i]));
				}
			}
			return false;
		}
	}
	return false;
	
	function recollapse( page ) { setTimeout( function() {page.removeClass('collapse');}, 500); }
}

//Свернутые не открываются
function removePagesAfter( self ) {
	var pages = $(".page");
	var pcid = getCid( self );
	for (var i = 0; i < pages.length; i++) {
		if ($(pages[i]).attr('cid') === pcid) {
			for (var j = pages.length - 1; j >= i + 1; j--) {
				removePage( $(pages[j]) );
			}
			return false;
		}
	}
	return false;
}


function _n(t) {
	if (t < 10) return '0'+t;
	return t;
}
