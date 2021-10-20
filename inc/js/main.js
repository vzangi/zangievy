$(function(){
	$.ztimeout;
	
	$('#family, #name, #fname').keyup(function(){
		if ($.ztimeout) clearTimeout($.ztimeout);
		var Family = $('#family').val().trim();
		var Name = $('#name').val().trim();
		var FName = $('#fname').val().trim();
		if (Family == '' && Name == '' && FName == '') {
			$('.helper').html('');
			return;
		}
		$.ztimeout = setTimeout(function(){
			$.post({
				url: '/inc/getman.php',
				data: {
					family: Family,
					name: Name,
					fname: FName
				},
				success: function(r) {
					$(".helper").html('');
					$("#manTmpl").tmpl(r).appendTo( ".helper" );
				}
			});
		}, 500);
	});
});