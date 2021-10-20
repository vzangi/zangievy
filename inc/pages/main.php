<link rel='stylesheet' href='/inc/css/mainstyle.css?v=1' /> 
<form>
	<h3>Поиск по базе</h3>
	<input id='family' type='text' name='family' placeholder='Фамилия' autocomplete="off">
	<input id='name' type='text' name='name' placeholder='Имя' autocomplete="off">
	<input id='fname' type='text' name='fname' placeholder='Отчество' autocomplete="off">
</form>
<ul class='helper'></ul>
<script id="manTmpl" type="text/x-jquery-tmpl">
<li class='man'> 
	<a href='/man/${id}'>{{if $data.foto != null}}<img src='${foto}' alt='' />{{else}}<img src='/inc/images/nofoto.png' alt='' />{{/if}}</a>
	<a href='/man/${id}'>${family} ${name} ${fathername}{{if $data.birthdate != ''}},{{if $data.birthdate.length < 5}} ${birthdate}{{else}} ${birthdate.substr(6)}{{/if}}{{/if}}</a>
</li>
</script>
<script src='/inc/js/main.js'></script>