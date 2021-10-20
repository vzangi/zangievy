function Api ( _settings ) {
	var self = this;
	var defaultTables = ['geo_admin', 'geo_man', 'geo_foto', 'geo_marrieds'];
	var obj = _settings || defaultTables;
	
	// получение данных (синхронно)
	// data - параметры запроса (не обязательный параметр)
	var getSync = function( data ) {
		var req = { url: this.name, async: false };
		if ( data ) req.data = data;
		return sendAjax( req );
	}
	
	var postSync = function( data ) {
		return Api.prototype.postSync( this.name, data );
	}
	
	// получение данных (асинхронно)
	// query - параметры запроса (не обязательный параметр)
	// callback - функция в которую передается результат
	var get = function( query, callback ) {
		if ( typeof query === "function" && callback === undefined ) {
			callback = query;
			query = undefined;
		}
		var resp = { url: this.name, async: true, callback: callback };
		if (query) resp.data = query;
		sendAjax( resp );
	}
	
	var del = function( id, callback ) {
		Api.prototype.del( this.name, id, callback );
	}
	
	var delSync = function( id ) {
		return Api.prototype.delSync( this.name, id );
	}
	
	var post = function( data, callback ) {
		Api.prototype.post( this.name, data, callback );
	}

	var put = function( data, callback ) {
		Api.prototype.put( this.name, data, callback );
	}

	var putSync = function( data ) {
		return Api.prototype.putSync( this.name, data );
	}

	// Установка функций
	for ( i in obj ) {
		this[ obj[i] ] = {
			name: 	obj[i],		//Имя сущности
			getSync: getSync,	//получение данных (синхронно)
			delSync: delSync,	//удаление элемента (синхронно)
			putSync: putSync,	//изменение элемента (синхронно)
			postSync: postSync,	//добавление элемента (синхронно)
			get: 	get,		//получение данных (асинхронно)
			del: 	del,		//удаление элемента
			put: 	put,		//изменение элемента
			post: 	post		//добавление элемента
		}
	}
	
	return this;
}

// Запрос на получение данных (синхронный)
// url - адрес сущности
Api.prototype.getSync = function ( url, query ) {
	var req = { url: url, async: false };
	if ( query ) req.data = query;
	return sendAjax( req );
}

// Запрос на получение данных (асинхронный)
// url - адрес сущности
// callback - функция в которую передается результат
Api.prototype.get = function(url, query, callback){
	sendAjax({ url: url, data: query, async: true, callback: callback });
}

// Запрос на удаление элемента (асинхронный)
// url - адрес сущности
// id  - id элемента
// callback - функция в которую передается результат
Api.prototype.del = function(url, id, callback){
	sendAjax( {
		url: url + "/" + id,
		type: "DELETE",
		async: true,
		callback: callback
	});
}

Api.prototype.delSync = function(url, id ){
	return sendAjax( {
		url: url + "/" + id,
		type: "DELETE"
	});
}

Api.prototype.post = function(url, data, callback) {
	sendAjax( {
		url: url,
		type: "POST",
		data: data,
		async: true,
		callback: callback
	});
}

Api.prototype.postSync = function(url, data ) {
	return sendAjax( {
		url: url,
		type: "POST",
		data: data
	});
}

Api.prototype.put = function(url, data, callback) {
	sendAjax( {
		url: url,
		type: "PUT",
		data: data,
		async: true,
		callback: callback
	});
}

Api.prototype.putSync = function(url, data ) {
	return sendAjax( {
		url: url,
		type: "PUT",
		data: data
	});
}
	
function sendAjax(options) {
	
	options = options || {};

	var data = null;
	
	var address = "/admin/json/";
	
	if ( options.url ) {
		options.url = address + options.url.replace(address, "");
	} else {
		options.url = address;
	}
	
	var request = {
		type: options.type || "GET",
		url: options.url,
		dataType: "json",
		//contentType:"application/json",
		global: false,
		async: options.async==undefined ? false : options.async,
		success: function ( result, status, xhr ) {

			data = result;
			if (options.callback){
				options.callback( result );
			}
		},
		error: function(result) {
			
			//Возвращаем ошибку во втором параметре
			if (options.callback){
				options.callback( null, result );
			}
		}
	};
	
	if (options.data)
		if (request.type == "GET") {
			request.url += "?query=" + JSON.stringify( options.data );
		} else {
			request.data = options.data;
		}
	
	$.ajax( request );

	//Если запорс синхронный, то возвращаем результат
	return data;
}