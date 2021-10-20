<div class="page mans-search-page column active" style="display: block;">
<style>
.order-filter input {
	border: 1px solid #d0d0d0;
	width: 100%;
}
</style>
	<div class="page-wrap">
		<div id="page-region" class="page-content">
			<div class="page-panel">
				<div class="panel-header-wrap">
					<!-- типовая стрелка возврата обратно-->
					<a href="#prev" class="prev js-prev">
						<i class="fa ion-chevron-left"></i>
					</a>
					<div id="header-region" class="panel-header">
						<div class="header-text">Список имен <small class='order-count'></small></div>
						<div class="nav-buttons">
							<button class="btn btn-xs btn-link btn-filter" title="Фильтр">
								<i class="fa ion-funnel"></i>
							</button>
							<button class="btn btn-xs btn-link btn-refresh" title="Обновить">
								<i class="fa ion-loop"></i>
							</button>
							<button class="btn btn-xs btn-link btn-add-man" title="Добавить человека">
								<i class="fa ion-plus"></i>
							</button>
						</div>
					</div>
				</div>
				<div class="scroll-wrap">
					<div class='order-filter'>
						<div class="plus-as-tab md-form">
							<dl class="dl-horizontal md-dl">
								<dt class="for-input">
									<label for="name">
										<i class="error-sign"></i>
										<span class="name">Фамилия</span>
									</label>
								</dt>
								<dd class="for-input">
									<input id='search_family' />
								</dd>
							</dl>
							<dl class="dl-horizontal md-dl">
								<dt class="for-input">
									<label for="name">
										<i class="error-sign"></i>
										<span class="name">Имя</span>
									</label>
								</dt>
								<dd class="for-input">
									<input id='search_name' />
								</dd>
							</dl>
						</div>
					</div>
					<div id="content-region" class="panel-content">
						<ul class="nav nav-pills nav-stacked mans-list">
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
	var serchTimeOut;
	
	$("#search_family, #search_name").keyup(function(){
		refreshSearch();
	});
	
	$(".btn-refresh").click(function(){
		refreshSearch();
	})
	
	function refreshSearch(){
		clearTimeout(serchTimeOut);
		var fam = $("#search_family").val().trim();
		var name = $("#search_name").val().trim();
		var data = {};
		if (fam == '' && name == '') {
			$(".mans-list").empty();
			return false;
		}
		if (fam != '') {
			data.family = { likebegin: fam }
		}
		if (name != '') {
			data.name = { likebegin: name }
		}
		serchTimeOut = setTimeout(function(){
			var mans = api.geo_man.getSync( data );
			
			mans.sort(function(a,b){
				if (a.family < b.family) return -1;
				if (a.family > b.family) return 1;
				if (a.name < b.name) return -1;
				if (a.name > b.name) return 1;
				if (a.fathername < b.fathername) return -1;
				if (a.fathername > b.fathername) return 1;
				return 0;
			});
		
			$("#search_tmpl").tmpl( mans ).appendTo( $(".mans-list").empty() );
		}, 500);
	}
	
	$(".mans-search-page .btn-filter").click( function() {
		$(".new-orders-page .order-filter").slideToggle();
	});
	
	function showManFromDashboard(self, id) {
		removePagesAfter( $('.mans-search-page') );
		appendColumn( 'man-item', { manid: id } );
		return false;
	}
	
	$(".mans-search-page .btn-add-man").click( function() {
		removePagesAfter( $('.mans-search-page') );
		appendColumn( 'man-add' );
	});
	
</script>
<!-- ШАБЛОН ЭЛЕМЕНТА СПИСКА -->
<script type="text/x-jquery-tmpl" id="search_tmpl">
<li id="man-${id}" class='man-pol-${pol}'>
	<a href='#' onclick='return showManFromDashboard(this, ${id})'>
		<div class="pill-icon">
			<span class='ion ion-{{if $data.pol == 0 }}wo{{/if}}man'></span>
		</div>
		<div class="pill-content">
			<div class="pill-header">${family} ${name} ${fathername}</div>
			<div class="pill-comment">
				Дата рождения: ${birthdate}
			</div>
		</div>
	</a>
</li>
</script>
<script type="text/x-jquery-tmpl" id="order_makedate_tmpl">
<li style='background: #f0f0f0;'>
	<span style='display: inline-block; padding: 5px; color: #444;'>${makedate}</span>
</li>
</script>
</div>