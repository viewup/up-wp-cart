function WPCart() {
	this.requestLib = 'jquery';
	this.baseAjaxUrl = this.urlJoin([
		WPCartData.homeUrl, 
		'wp-json',
		WPCartData.UPWPCART_API_BASE,
		WPCartData.UPWPCART_API_ROUTE,	
	]);

	this.errorPrefix = 'UPWPCart';
}

WPCart.prototype.urlJoin = function (pathStrings) {
	this.throwTypeError(pathStrings, 'Array');

	var trimmedPaths = pathStrings.map(function (pathString) {
		var newPathString = String(pathString);

		if (newPathString.slice(0, 1) == '/') {
			newPathString = newPathString.slice(1);
		}

		if (newPathString.slice(-1) == '/') {
			newPathString = newPathString.slice(0, -1);
		}

		return newPathString;
	});

	return trimmedPaths.join('/');

};

WPCart.prototype.throwRequestLibError = function (requestLib) {
	var message;

	if (requestLib) {
		message = "Request lib: '" + requestLib + "' is not defined!";
	} else {
		message = 'No request library available!';
	}

	throw new Error(this.errorPrefix + ': ' + message);
};

WPCart.prototype.throwUndefObj = function (obj, objName) {

	if (typeof obj === 'undefined') {
		throw new Error(this.errorPrefix + ': ' + 'Object is not defined: ' + objName);
	}
};

WPCart.prototype.throwTypeError = function(obj, typeObj){
	
	var assertion;

	switch(typeObj){
		case 'Array':
			assertion = !(obj instanceof Array);
			break;
		case 'Integer':
			assertion = !Number.isInteger(obj);
			break;
		default:
			assertion = typeof obj !== typeObj;	
	}

	if (assertion) {
		throw new Error(this.errorPrefix + ': ' + "Invalid type: Parameter '" + obj + "'  is not '" + typeObj + "'.");
	}	
	
}

WPCart.prototype.jqueryAjaxHandle = function (options) {
	var jquery;

	if (typeof jQuery !== 'undefined') {
		jquery = jQuery;
	} else if (typeof $ !== 'undefined') {
		jquery = $;
	} else {
		this.throwRequestLibError(this.requestLib);
	}

	if (typeof jquery !== 'undefined') {
		jquery.ajax(options);
	}
};

WPCart.prototype.ajax = function (params) {
	this.throwUndefObj(params, 'ajaxParams');
	this.throwTypeError(params, 'object');
	this.throwUndefObj(params.url, 'ajax.params.url');
	this.throwTypeError(params.url, 'string');


	var defaults = {
		method: 'GET',
	};

	var options = Object.assign({}, defaults, params);

	switch (this.requestLib) {
		case 'jquery':
			this.jqueryAjaxHandle(options);
			break;
		default:
			this.throwRequestLibError();

	}
};

WPCart.prototype.ajaxGet = function (params) {
	this.throwUndefObj(params, 'ajaxGetParams');
	this.throwTypeError(params, 'object');
	this.throwUndefObj(params.url, 'ajaxGet.params.url');
	this.throwTypeError(params.url, 'string');
	
	params.method = 'GET';
	this.ajax(params);
};

WPCart.prototype.ajaxPost = function (params) {
	this.throwUndefObj(params, 'ajaxPostParams');
	this.throwTypeError(params, 'object');
	this.throwUndefObj(params.url, 'ajaxPost.params.url');
	this.throwTypeError(params.url, 'string');
	params.method = 'POST';
	this.ajax(params);
};

WPCart.prototype.ajaxDelete = function (params) {
	this.throwUndefObj(params, 'ajaxDeleteParams');
	this.throwTypeError(params, 'object');
	this.throwUndefObj(params.url, 'ajaxDelete.params.url');
	this.throwTypeError(params.url, 'string');
	params.method = 'DELETE';
	this.ajax(params);
};


WPCart.prototype.getItems = function (callback) {
	this.throwUndefObj(callback, 'getItemsCallback');
	this.throwTypeError(callback, 'function');

	this.ajaxGet({
		url : this.baseAjaxUrl,
		success: callback
	});
};


WPCart.prototype.getItem = function(params, callback){

	this.throwUndefObj(params, 'getItemParams');
	this.throwTypeError(params, 'object');

	this.throwUndefObj(params.id, 'getItem.params.id');
	this.throwTypeError(params.id, 'Integer');

	this.throwUndefObj(callback, 'getItemCallback');
	this.throwTypeError(callback, 'function');

	this.ajaxGet({
		url : this.urlJoin([this.baseAjaxUrl, params.id]),
		success: callback,
	});
}

WPCart.prototype.addItem = function(params, callback){
	this.throwUndefObj(params, 'addItemParams');
	this.throwTypeError(params, 'object');

	this.throwUndefObj(params.id, 'addItems.params.id');
	this.throwTypeError(params.id, 'Integer');

	this.throwUndefObj(params.amount, 'addItem.params.amount');
	this.throwTypeError(params.amount, 'Integer');

	this.throwUndefObj(callback, 'addItemCallback');
	this.throwTypeError(callback, 'function');

	this.ajaxPost({
		url : this.baseAjaxUrl,
		success: callback,
		data: params
	});
};

WPCart.prototype.removeItem = function(params, callback){
	this.throwUndefObj(params, 'removeItemParams');
	this.throwTypeError(params, 'object');

	this.throwUndefObj(params.id, 'removeItem.params.id');
	this.throwTypeError(params.id, 'Integer');

	this.throwUndefObj(callback, 'removeItemCallback');
	this.throwTypeError(callback, 'function');

	this.ajaxDelete({
		url : this.urlJoin([this.baseAjaxUrl, params.id]),
		success: callback,
	});
};

WPCart.prototype.updateItem = function(params, callback){
	this.throwUndefObj(params, 'updateItemParams');
	this.throwTypeError(params, 'object');

	this.throwUndefObj(params.id, 'updateItem.params.id');
	this.throwTypeError(params.id, 'Integer');

	this.throwUndefObj(params.amount, 'updateItem.params.amount');
	this.throwTypeError(params.amount, 'Integer');

	this.throwUndefObj(callback, 'updateItemCallback');
	this.throwTypeError(callback, 'function');

	this.ajaxPost({
		url : this.urlJoin([this.baseAjaxUrl, params.id]),
		success: callback,
		data: {amount: params.amount}
	});
};

WPCart.prototype.clearItems = function(callback){

	this.throwUndefObj(callback, 'clearItemsCallback');
	this.throwTypeError(callback, 'function');

	this.ajaxDelete({
		url : this.baseAjaxUrl,
		success: callback,
	});	
}