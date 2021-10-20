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
?><div class="page man-change-page not-first column content init" style="display: block;">
	<? if (isset($uid)) {
		echo "<input type='hidden' value='$uid' id='changemanid' />";
	} ?><div class="page-wrap">
		<div id="page-region" class="page-content">
			<div class="page-panel">
				<div class="panel-header-wrap">
					<!-- типовая стрелка возврата обратно-->
					<a class="prev js-prev" onclick='prev(this)'>
						<i class="fa ion-chevron-left"></i>
					</a>
					<div id="header-region" class="panel-header">
						<div class="header-text">Изменение</small></div>
						<div class="nav-buttons">
							<button class="btn btn-xs btn-link" onclick='prev(this);'><span class="text">Отменить</span></button>
							<button class="btn btn-xs btn-success btn-change-man"><i class="fa fa-md-save"></i><span class="text">Сохранить</span></button>
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
								<input id='manFamily' type="text" class="form-control" value='<? echo $man['family']; ?>'>
							</dd>
							<dt class="for-input">
								<label for="desc">
									<span class="name">Имя</span>
								</label>
							</dt>
							<dd class="for-input">
								<input id='manName' type="text" class="form-control" value='<? echo $man['name']; ?>'>
							</dd>
							<dt class="for-input">
								<label for="desc">
									<span class="name">Отчество</span>
								</label>
							</dt>
							<dd class="for-input">
								<input id='manFathername' type="text" class="form-control" value='<? echo $man['fathername']; ?>'>
							</dd>
							<dt class="for-input">
								<label for="desc">
									<span class="name">Пол</span>
								</label>
							</dt>
							<dd class="for-input">
								<span class='block epol man-pol-1 <? if ($man['pol'] == 1) {?>selected<? } ?>' data-id='1'>Мужской</span>
								<span class='block epol man-pol-2 <? if ($man['pol'] == 0) {?>selected<? } ?>' data-id='0'>Женский</span>
							</dd>
							<dt class="for-input">
								<label for="desc">
									<span class="name">Дата рождения</span>
								</label>
							</dt>
							<dd class="for-input">
								<input id='manBirth' type="text" class="form-control" value='<? echo $man['birthdate']; ?>'>
							</dd>
							<dt class="for-input">
								<label for="desc">
									<span class="name">Дата смерти</span>
								</label>
							</dt>
							<dd class="for-input">
								<input id='manDeath' type="text" class="form-control" value='<? echo $man['deathdate']; ?>'>
							</dd>
							<dt class="for-input">
								<label for="desc">
									<span class="name">Фото</span>
								</label>
							</dt>
							<dd class="for-input">
								<? if (count($fotos) > 0) { ?>
									<a class='change-items uploadImage hide'><span class='ion-image'></span> Загрузить картинку</a>
									<div class='uploadImageBox'><img src='<? echo $fotos[0]['foto']; ?>' alt='<? echo $man['family'].' '.$man['name'].' '.$man['fathername']; ?>' style='width:100%;' /></div>
								<? } else { ?>
									<a class='change-items uploadImage'><span class='ion-image'></span> Загрузить картинку</a>
									<div class='uploadImageBox'></div>
								<? } ?>
							</dd>
							<dt class="for-input">
								<label for="desc">
									<span class="name">Дополнительное описание</span>
								</label>
							</dt>
							<dd class="for-input">
								<textarea id='manDesc' type="text" class="form-control" style='height:100px;' rows='5'><? echo $man['description']; ?></textarea>
							</dd>
							<dt class="for-input">
								<label for="desc">
									<span class="name">Сортировка</span>
								</label>
							</dt>
							<dd class="for-input">
								<input id='manSort' type="number" class="form-control" value='<? echo $man['sort']; ?>'>
							</dd>
						</dl>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
$(".epol").click( function() {
	$(".epol").removeClass('selected');
	$(this).addClass('selected');
});
$(".man-change-page .btn-change-man").click( function() {
	var data = {};
	data.family = $("#manFamily").val().trim();
	data.name = $("#manName").val().trim();
	data.fathername = $("#manFathername").val().trim();
	data.birthdate = $("#manBirth").val().trim();
	data.deathdate = $("#manDeath").val().trim();
	data.description= $("#manDesc").val().trim();
	data.pol = $(".epol.selected").data().id;
	data.sort = $("#manSort").val();
	data.id = $("#changemanid").val();
	
	if (data.family == '') {
		$("#manFamily").focus();
		return alert('Введите фамилию!');
	}
	if (data.name == '') {
		$("#manName").focus();
		return alert('Введите имя!');
	}
	
	api.geo_man.put( data, function(r,e) {
		if (r) {
				
			var images = api.geo_foto.getSync({man: data.id});
			
			for (var i = 0; i < images.length; i++)
				api.geo_foto.delSync( images[i].id );
				
			if ($(".uploadImageBox img").length != 0) {
				var img = $(".uploadImageBox img:first").attr("src");
				
				api.geo_foto.post({
					man: data.id,
					foto: img,
					sort: 0
				});
			}
			
			$(".man-change-page .js-prev").click();
			setTimeout(function(){
				appendColumn( 'man-item', { manid: data.id } );
			}, 100);
		} else {
			alert('Не удалось сохранить. Попробуйте еще раз');
		}
	})
});


setUploadBtn( $(".man-change-page .uploadImage") );

$(".uploadImageBox").contextmenu( function() {
	if (!confirm('Удалить картинку?')) return false;
	$(".uploadImageBox img").remove();
	setUploadBtn( $(".man-change-page .uploadImage") );
	return false;
});

function setUploadBtn( btn ) {
	if ($("[name=uploadfile]").length!==0){
		$("[name=uploadfile]").remove();
	}
	if ($(".uploadImageBox img").length == 0)
		$(btn).removeClass('hide');
	guid = get_guid();
	new AjaxUpload(btn, {
		action: '/inc/upload.php',
		data: { name: guid },
		name: 'uploadfile',
		onSubmit: function(file, ext){
			if (!(ext && /^(jpg|jpeg|png)$/.test(ext))){ 
				alert('Загружать можно только файлы с расширенем PNG, JPG или JPEG');
				return false;
			} 
		},
		onComplete: function(file, response){
			if(~response.indexOf("success")) {
				
				var img = response.replace("success ", "");
				
				$("<img src='/inc/upload/"+img+"'>").appendTo(".uploadImageBox")
				
				$(".man-change-page .uploadImage").addClass('hide');
				
			} else{
				alert("При загрузке файла возникла ошибка!");
			}
		}
	});
}
</script>
</div>