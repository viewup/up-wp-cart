
function WPCart(){
	this.requestLib = 'jquery';
	this.baseUrl = window.location.href;
}

WPCart.prototype.urlJoin = function(params){
	this.throwUndefObj(params, 'urlJoinParams');

};

WPCart.prototype.throwRequestLibError = function(requestLib){
	var message;

	if(requestLib){
		message = "Request lib: '" + requestLib + "' is not defined!";
	}
	else{
		message = 'No request library available!';
	}

	throw new Error(message);
};

WPCart.prototype.throwUndefObj = function(obj, objName){

	if(typeof obj === 'undefined'){
		throw new Error('Object is not defined: ' + objName);
	}	
};

WPCart.prototype.jqueryAjaxHandle = function(options){
	var jquery;

	if(typeof jQuery !== 'undefined'){
		jquery = jQuery;
	}
	else if(typeof $ !== 'undefined'){
		jquery = $;
	}
	else{
		this.throwRequestLibError(this.requestLib);
	}		

	if(typeof jquery !== 'undefined'){
		jquery.ajax(options);
	}				
};

WPCart.prototype.ajax = function(params){
	var defaults = {
		method: 'GET',		
	};

	var options = Object.assign({}, defaults, params);

	switch(this.requestLib){
		case 'jquery':		
			this.jqueryAjaxHandle(options);
			break;
		default: 
			this.throwRequestLibError();
			
	}
};

WPCart.prototype.ajaxGet = function(params){
	this.throwUndefObj(params, 'ajaxGetParams');
	params.method = 'GET';
	this.ajax(params);
};

WPCart.prototype.ajaxPost = function(params){
	this.throwUndefObj(params, 'ajaxPostParams');
	params.method = 'POST';
	this.ajax(params);
};

WPCart.prototype.getItems = function(){
	// this.ajaxGet();
};


(function($){
	var instance = new WPCart();
	instance.ajaxGet();
})(jQuery || $);


