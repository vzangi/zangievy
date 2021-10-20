$(function(){
	$('.man-foto').click(function(){
		var man = $(this).data().man;
		var foto = $(this).data().foto;
		$(".modal-title").text(man.family + ' ' + man.name + ' ' + man.fathername);
		if (foto.length != 0) {
			$(".info-foto").attr('src', foto[0].foto);
		} else {
			$(".info-foto").attr('src', '/inc/images/nofoto.png');
		}
		$("#info").modal();
		var dates = '';
		if (man.birthdate != '') {
			dates += man.birthdate;
		}
		if (man.deathdate != '') {
			dates += ' - ' + man.deathdate;
		}
		$(".man-dates").text(dates);
		$(".man-desc").html(man.description.replace(/\n/g, "<br />"));
	});
	$(".gerb-image").click(function(){
		location.href = '/';
	});
});