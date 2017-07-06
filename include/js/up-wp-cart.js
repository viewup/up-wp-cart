function WPCart() {
	this.requestLib = 'jquery';
	this.baseAjaxUrl = this.urlJoin([
		WPCartData.homeUrl, 
		'wp_json',
		WPCartData.UPWPCART_API_BASE,
		UPWPCART_API_ROUTE,	
	]);
}

WPCart.prototype.urlJoin = function (pathStrings) {
	this.throwTypeError(pathStrings, 'Array');

	var trimmedPaths = pathStrings.map(function (pathString) {
		var newPathString = pathString;

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

	throw new Error(message);
};

WPCart.prototype.throwUndefObj = function (obj, objName) {

	if (typeof obj === 'undefined') {
		throw new Error('Object is not defined: ' + objName);
	}
};

WPCart.prototype.throwTypeError = function(obj, typeObj){
	
	var assertion;

	if(typeObj == 'Array'){
		assertion = !(obj instanceof Array);
	}
	else{
		assertion = typeof obj !== typeObj;		
	}

	if (assertion) {
		throw new Error("Invalid type: Parameter '" + obj + "'  is not '" + typeObj + "'.");
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
	this.throwUndefObj(params);
	this.throwTypeError(params, 'object');

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
	
	params.method = 'GET';
	this.ajax(params);
};

WPCart.prototype.ajaxPost = function (params) {
	this.throwUndefObj(params, 'ajaxPostParams');
	this.throwTypeError(params, 'object');
	this.throwUndefObj(params.url, 'ajaxPost.params.url');
	params.method = 'POST';
	this.ajax(params);
};

WPCart.prototype.getItems = function () {
	// this.ajaxGet();
};


(function ($) {
	var instance = new WPCart();
	instance.urlJoin(['string passed']);
})(jQuery || $);