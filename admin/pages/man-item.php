<?
	$uid = $_GET['manid'];
	include $_SERVER['DOCUMENT_ROOT'].'/inc/connection.php';
	$res = mysql_query("SELECT * FROM `geo_man` WHERE id = $uid", $db);
	if ( mysql_num_rows( $res ) == 0) exit;
	
	$man = mysql_fetch_array( $res );
	
	$fotos = array();
	$res = mysql_query("SELECT * FROM geo_foto WHERE man = $uid", $db);
	if ( mysql_num_rows( $res ) != 0) {
		while( ($foto = mysql_fetch_array($res, MYSQL_ASSOC)) !== false ) {
			$fotos[] = $foto;
		}
	}
	
?><div class="page man-item-page not-first column init man<? echo $uid; ?>" style="display: block;">
	<? if (isset($uid)) {
		echo "<input type='hidden' value='$uid' id='manid' />";
	} ?>
	<div class="page-wrap">
		<div id="page-region" class="page-content">
			<div class="page-panel">
				<div class="panel-header-wrap">
					<!-- типовая стрелка возврата обратно-->
					<a class="prev js-prev" onclick='prev(this)'>
						<i class="fa ion-chevron-left"></i>
					</a>
					<div id="header-region" class="panel-header">
						<div class="header-text">Информация #<? echo $uid; ?></div>
						<div class="nav-buttons">
							<button class="btn btn-xs btn-link edit-man-btn hide"><span class="text ion-edit" title='Править'></span></button>
							<button class="btn btn-xs btn-danger btn-remove-man hide" title='Удалить'><span class="ion-trash-b"></span></button>
						</div>
					</div>
				</div>
				<div class="scroll-wrap">
					<div class="plus-as-tab md-form">
						<dl class="dl-horizontal md-dl">
							<dt class="for-input">
								<label for="desc">
									<span class="name">Фамилия</span>
								</label>
							</dt>
							<dd class="for-input">
								<span class='dd-value'><? echo $man['family']; ?></span>
							</dd>
							<dt class="for-input">
								<label for="desc">
									<span class="name">Имя</span>
								</label>
							</dt>
							<dd class="for-input">
								<span class='dd-value'><? echo $man['name']; ?></span>
							</dd>
							<dt class="for-input">
								<label for="desc">
									<span class="name">Отчество</span>
								</label>
							</dt>
							<dd class="for-input">
								<span class='dd-value'><? echo $man['fathername']; ?></span>
							</dd>
							<? if ($man['birthdate'] != '') { ?>
							<dt class="for-input">
								<label for="desc">
									<span class="name">Дата рождения</span>
								</label>
							</dt>
							<dd class="for-input">
								<span class='dd-value'><? echo $man['birthdate']; ?></span>
							</dd>
							<? } ?>
							<? if ($man['deathdate'] != '') { ?>
							<dt class="for-input">
								<label for="desc">
									<span class="name">Дата смерти</span>
								</label>
							</dt>
							<dd class="for-input">
								<span class='dd-value'><? echo $man['deathdate']; ?></span>
							</dd>
							<? } ?>
							<dt class="for-input">
								<label for="desc">
									<span class="name">Фото</span>
								</label>
							</dt>
							<dd class="for-input">
								<? if (count($fotos) > 0) { ?>
								<img src='<? echo $fotos[0]['foto']; ?>' alt='<? echo $man['family'].' '.$man['name'].' '.$man['fathername']; ?>' style='width:100%;' />
								<? } else { ?>
								нет фото
								<? } ?>
							</dd>
							<? if ($man['description'] != '') { ?>
							<h4>Дополнительное описание</h4>
							<p><?php echo str_replace(array("\r\n", "\r", "\n"), '<br>', $man['description']); ?></p>
							<? } ?>
							<h4>Отец</h4>
							<? if ($man['father'] == 0) {?>
								<p>Нет инормации. <a class='add-father' href='#'>Добавить</a></p>
							<? } else { 
									$res = mysql_query("SELECT * FROM geo_man WHERE id = {$man[father]}");
									if ($res && mysql_num_rows($res) == 1) {
										$father = mysql_fetch_array($res, MYSQL_ASSOC);
										?>
										<ul class="nav nav-pills nav-stacked">
											<li id="man-<? echo $father['id']; ?>" class='man-pol-<? echo $father['pol']; ?>'>
												<a href='#' onclick='return showManFromDashboard(this, <? echo $father['id']; ?>)'
													oncontextmenu='return removeFather(this, <? echo $uid; ?>)'>
													<div class="pill-icon">
														<span class='ion ion-man'></span>
													</div>
													<div class="pill-content">
														<div class="pill-header"><? echo $father['family'].' '.$father['name'].' '.$father['fathername']; ?></div>
														<div class="pill-comment">
															Дата рождения: <? echo $father['birthdate']; ?>
														</div>
													</div>
												</a>
											</li>
										</ul>
										<?
									} else { ?>
										<p>Ошибка базы. <a class='remove-father' href='#'>Удалить</a></p><?
									}
								} ?>
							
							<h4>Мать</h4>
							<? if ($man['mother'] == 0) {?>
								<p>Нет инормации. <a class='add-mother' href='#'>Добавить</a></p>
							<? } else { 
									$res = mysql_query("SELECT * FROM geo_man WHERE id = {$man[mother]}");
									if ($res && mysql_num_rows($res) == 1) {
										$mother = mysql_fetch_array($res, MYSQL_ASSOC);
										?>
										<ul class="nav nav-pills nav-stacked">
											<li id="man-<? echo $mother['id']; ?>" class='man-pol-<? echo $mother['pol']; ?>'>
												<a href='#' onclick='return showManFromDashboard(this, <? echo $mother['id']; ?>)'
													oncontextmenu='return removeMother(this, <? echo $uid; ?>)'>
													<div class="pill-icon">
														<span class='ion ion-man'></span>
													</div>
													<div class="pill-content">
														<div class="pill-header"><? echo $mother['family'].' '.$mother['name'].' '.$mother['fathername']; ?></div>
														<div class="pill-comment">
															Дата рождения: <? echo $mother['birthdate']; ?>
														</div>
													</div>
												</a>
											</li>
										</ul>
										<?
									} else { ?>
										<p>Ошибка базы. <a class='remove-mother' href='#'>Удалить</a></p><?
									}
								} ?>
								
							<h4>Семья</h4>
							<div class='family-box'>
							<?
								$res = mysql_query("SELECT * FROM geo_marrieds WHERE man = $uid OR woman = $uid ORDER BY sort");
								if ($res && mysql_num_rows($res)>0) {
									$find = 'man';
									if ($man['pol'] == 1) $find = 'woman';
									while( ($row = mysql_fetch_array($res, MYSQL_ASSOC)) !== false ) {
										$m = mysql_query("SELECT * FROM geo_man WHERE id = ".$row["$find"]);
										if ($m && mysql_num_rows($m) == 1) {
											if ($man['pol'] == 1) { ?><h5>Жена <? if ($row['weddingdate'] != '') { echo '('.$row['weddingdate'].')'; } ?></h5><? }
											if ($man['pol'] == 0) { ?><h5>Муж</h5><? }
											$mother = mysql_fetch_array($m, MYSQL_ASSOC);
											?>
											<ul class="nav nav-pills nav-stacked">
												<li id="man-<? echo $mother['id']; ?>" class='man-pol-<? echo $mother['pol']; ?>'>
													<a href='#' onclick='return showManFromDashboard(this, <? echo $mother['id']; ?>)'
														oncontextmenu='return removePartner(this, <? echo $uid; ?>, <? echo $mother['id']; ?>)'>
														<div class="pill-icon">
															<span class='ion ion-<? if ($mother['pol'] == 0) echo 'wo'; ?>man'></span>
														</div>
														<div class="pill-content">
															<div class="pill-header"><? echo $mother['family'].' '.$mother['name'].' '.$mother['fathername']; ?>
																<div class='ph-icons'>
																	<span class='ion ion-arrow-up-c sortUp' title='Поставить раньше' data-id='<? echo $row['id']; ?>' data-sort='<? echo $row['sort']; ?>'></span>
																	<span class='ion ion-arrow-down-c sortDown' title='Поставить позже' data-id='<? echo $row['id']; ?>' data-sort='<? echo $row['sort']; ?>'></span>
																</div>
															</div>
															<div class="pill-comment">
																<input type='hidden' class='partnerSort' value='<? echo $row['sort']; ?>'/>
																Дата рождения: <? echo $mother['birthdate']; ?>
															</div>
														</div>
													</a>
												</li>
												<h5>Дети</h5>
												<? 
													$query = "SELECT * FROM geo_man WHERE father = $row[man] && mother = $row[woman] ORDER BY sort"; 
													$childs_res = mysql_query($query);
													if ($childs_res && mysql_num_rows($childs_res) > 0) {
														while( ($child = mysql_fetch_array($childs_res, MYSQL_ASSOC)) !== false ) {
															?>
															<li id="man-<? echo $child['id']; ?>" class='man-pol-<? echo $child['pol']; ?>'>
																<a href='#' onclick='return showManFromDashboard(this, <? echo $child['id']; ?>)'
																oncontextmenu='return removeCurChild(this, <? echo $uid; ?>, <? echo $child['id']; ?>)'>
																	<div class="pill-icon">
																		<span class='ion ion-<? if ($child['pol'] == 0) echo 'wo'; ?>man'></span>
																	</div>
																	<div class="pill-content">
																		<div class="pill-header"><? echo $child['family'].' '.$child['name'].' '.$child['fathername']; ?></div>
																		<div class="pill-comment">
																			Дата рождения: <? echo $child['birthdate']; ?>
																		</div>
																	</div>
																</a>
															</li>	
															<?
														}
														?>
															<p><a class='add-child' data-motherid='<? echo $mother['id']; ?>' href='#'>Добавить ребенка</a></p>
														<?
													} else {?>
														<p>Нет инормации. <a class='add-child' data-motherid='<? echo $mother['id']; ?>' href='#'>Добавить ребенка</a></p><?														
													}
												?>
											</ul>
											<hr>
											<?
										} else { ?>
											<p>Ошибка базы. <a class='remove-partner' href='#'>Удалить</a></p><?
										}
									}
								}
								?>
								
								<p><a class='add-family' href='#'>Добавить <? if ($man['pol'] == 0) {?>супруга<? } else { ?>супругу<?}?></a></p>
							</div>
						</dl>
						
						<br>
						<br>
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
$(".sortDown").click(function(e){
	var next = $(this).parent().parent().parent().parent().parent().parent().next().next().next().find(".sortDown");
	replacePartners(this, next);
	e.stopPropagation();
	return false;
});
$(".sortUp").click(function(e){
	var prev = $(this).parent().parent().parent().parent().parent().parent().prev().prev().prev().find(".sortUp");
	replacePartners(this, prev);
	e.stopPropagation();
	return false;
});

function replacePartners(self, replacedItem) {
	var id1 = $(self).data().id;
	var sort1 = $(self).data().sort;
	var id2 = $(replacedItem).data().id;
	var sort2 = $(replacedItem).data().sort;
		
	api.geo_marrieds.put({
		id: id1,
		sort: sort2
	});
	api.geo_marrieds.put({
		id: id2,
		sort: sort1
	});
	
	removePagesAfter( $('.mans-search-page') );
	appendColumn( 'man-item', { manid: $("#manid").val() } );
}

//Удаление доступно только администратору
if (me.role == 0) {
	$(".man-item-page .btn-remove-man").removeClass('hide');
	$(".man-item-page .edit-man-btn").removeClass('hide');
	$(".man-item-page .btn-remove-man").click( function() {
		if (!confirm("Удалить?")) return;
		
		if ($("#manrole").val() == 0) return;
		
		var cid = $(".man-item-page #manid").val();
		
		loader.activate();
		api.geo_man.del( cid );
		
		loader.deactivate();
		
		$("#man-" + cid).remove();
		$(".man-item-page .js-prev").click();
	});
	
	$(".man-item-page .edit-man-btn").click( function() {
		prev( $('.man-item-page') );
		appendColumn( 'man-change', { manid: $("#manid").val() } );
	});
	
} else {
	$(".man-item-page .btn-remove-man").remove();	
	$(".man-item-page .edit-man-btn").remove();	
	$(".autorize").remove();
}

function removeFather(self, uid) {
	if (!confirm("Удалить запись об отце?")) return false;
	api.geo_man.put({id: uid, father: 0});
	removePagesAfter( $('.mans-search-page') );
	appendColumn( 'man-item', { manid: uid } );
	return false;
}

function removeMother(self, uid) {
	if (!confirm("Удалить запись о матери?")) return false;
	api.geo_man.put({id: uid, mother: 0});
	removePagesAfter( $('.mans-search-page') );
	appendColumn( 'man-item', { manid: uid } );
	return false;
}

function removePartner(self, uid, pid) {
	if (!confirm("Удалить запись о партнере?")) return false;
	var curMan = api.geo_man.getSync({id:uid});
	if (curMan[0].pol == 1) {
		var married = api.geo_marrieds.getSync({man:uid, woman:pid});
	} else {
		var married = api.geo_marrieds.getSync({woman:uid, man:pid});
	}
	api.geo_marrieds.del(married[0].id);
	
	removePagesAfter( $('.mans-search-page') );
	appendColumn( 'man-item', { manid: uid } );
	return false;
}

function removeCurChild(self, uid, cid) {
	if (!confirm("Удалить запись о ребенке?")) return false;
	api.geo_man.put({id: cid, mother: 0, father: 0});
	removePagesAfter( $('.mans-search-page') );
	appendColumn( 'man-item', { manid: uid } );
	return false;
}
$(function(){
	$('.add-father').click(function(){
		removePagesAfter( $('.man-item-page') );
		appendColumn( 'findname', { 
			manid: $("#manid").val(), 
			field: 'father'
		} );
		return false;
	});
	$('.add-mother').click(function(){
		removePagesAfter( $('.man-item-page') );
		appendColumn( 'findname', { 
			manid: $("#manid").val(), 
			field: 'mother'
		} );
		return false;
	});
	$('.add-family').click(function(){
		removePagesAfter( $('.man-item-page') );
		appendColumn( 'findname', { 
			manid: $("#manid").val(), 
			field: 'partner'
		} );
		return false;
	});
	$('.add-child').click(function(){
		removePagesAfter( $('.man-item-page') );
		appendColumn( 'findname', { 
			manid: $("#manid").val(), 
			motherid: $(this).data().motherid,
			field: 'child'
		} );
		return false;
	});
});
</script>
</div>