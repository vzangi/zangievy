<?
	if (!isset($_GET['field'])) exit;
	if (!isset($_GET['manid'])) exit;
?><div class="page find-mans-search-page not-first column active" style="display: block;">
<style>
.order-filter input {
	border: 1px solid #d0d0d0;
	width: 100%;
}
</style>
	<? 
	if (isset($_GET['field'])) {
		echo "<input type='hidden' value='".$_GET['field']."' id='field' />";
	} 
	if (isset($_GET['motherid'])) {
		echo "<input type='hidden' value='".$_GET['motherid']."' id='motherid' />";
	}  
	if (isset($_GET['manid'])) {
		echo "<input type='hidden' value='".$_GET['manid']."' id='fmanid' />";
	} 
	?>
	<div class="page-wrap">
		<div id="page-region" class="page-content">
			<div class="page-panel">
				<div class="panel-header-wrap">
					<!-- типовая стрелка возврата обратно-->
					<a class="prev js-prev" onclick='prev(this)'>
						<i class="fa ion-chevron-left"></i>
					</a>
					<div id="header-region" class="panel-header">
						<div class="header-text">Список имен <small class='order-count'></small></div>
						<div class="nav-buttons">
							
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
									<input id='find_search_family' />
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
									<input id='find_search_name' />
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
	var serchTimeOut2;
	
	$("#find_search_family, #find_search_name").keyup(function(){
		refreshFindSearch();
	});
	
	$(".find-mans-search-page .btn-refresh").click(function(){
		refreshFindSearch();
	})
	
	function refreshFindSearch(){
		clearTimeout(serchTimeOut2);
		var fam = $("#find_search_family").val().trim();
		var name = $("#find_search_name").val().trim();
		var data = {};
		if (fam == '' && name == '') {
			$(".find-mans-search-page .mans-list").empty();
			return false;
		}
		if (fam != '') {
			data.family = { likebegin: fam }
		}
		if (name != '') {
			data.name = { likebegin: name }
		}
		serchTimeOut2 = setTimeout(function(){
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
		
			$("#search_tmpl2").tmpl( mans ).appendTo( $(".find-mans-search-page .mans-list").empty() );
		}, 500);
	}
	
	$(".find-mans-search-page .btn-filter").click( function() {
		$(".new-orders-page .order-filter").slideToggle();
	});
	
	function selectMan(self, id) {
		
		var field = $("#field").val();
		var curmanid = $("#fmanid").val();
		
		if (field == 'mother' || field == 'father') {
			var data = {id: curmanid };
			data[field] = id;
			api.geo_man.put( data );
		}
		
		if (field == 'partner') {
			var sort = 0;
			if ($(".partnerSort:last").length != 0) {
				sort = $(".partnerSort:last").val()*1 + 10;
			}
			var curMan = api.geo_man.getSync({id: curmanid});
			if (curMan[0].pol == 1) {
				api.geo_marrieds.post({
					sort: sort,
					man: curmanid,
					woman: id
				});
			} else {
				api.geo_marrieds.post({
					sort: sort,
					woman: curmanid,
					man: id
				});
			}
		}
		
		if (field == 'child') {
			var curMan = api.geo_man.getSync({id: curmanid});
			if (curMan[0].pol == 1) {
				api.geo_man.put({
					id: id, 
					father: curmanid,
					mother: $("#motherid").val()
				});
			} else {
				api.geo_man.put({
					id: id, 
					mother: curmanid,
					father: $("#motherid").val()
				});
			}
		}
		
		removePagesAfter( $('.mans-search-page') );
		appendColumn( 'man-item', { manid: curmanid } );
		return false;
	}
	
</script>
<!-- ШАБЛОН ЭЛЕМЕНТА СПИСКА -->
<script type="text/x-jquery-tmpl" id="search_tmpl2">
<li id="man-${id}" class='man-pol-${pol}'>
	<a href='#' onclick='return selectMan(this, ${id})'>
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