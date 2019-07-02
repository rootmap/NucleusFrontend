/**
 * Defines the StencilWebAPI namespace.  Users of the StencilWebAPI must call init() and then provide instances
 * to handle interactions with Stencil (e.g. StencilWebAPI.navigation = new NavigationBase()).
 *
 * Copyright 2014 Nucleus Retail. All rights reserved.
 * Created by kurtbergeron on 14-12-09.
 */

(function() {
    var StencilWebAPI = {
        /**
         * Initializes the StencilWebAPI.  Calling init more than once has no effect.
         */
        init: function() {
            if (!this._initialized) {
                this._initialized = true;

                this._navigation = null;
            }
        },

        /**
         * Determines if the web-app is running in Stencil
         *
         * @returns {boolean}   True if we are running in a Stencil embedded web view and false otherwise.
         */
        isStencil: function() {
            return window.webkit && window.webkit.messageHandlers && window.webkit.messageHandlers[this.Utils.MessageHandler.SET_NAVIGATION_STATE];
        }
    };

    // define properties
    Object.defineProperties(StencilWebAPI, {
        'navigation' : {
            get: function() { return this._navigation; },
            set: function(navigation) { this._navigation = navigation; },
            enumerable: true
        }
    });

    // work with both Phoenix and webPOS architectures
    if (typeof window.define === 'function' && window.define.amd) {
        define([], function() {
            return StencilWebAPI;
        });
    } else {
        window.StencilWebAPI = StencilWebAPI;
    }
}());

/**
 * Defines utility functions used by the StencilWebAPI
 *
 * Copyright 2014 Nucleus Retail. All rights reserved.
 * Created by kurtbergeron on 14-12-09.
 */

(function() {

    /**
     * Stencil message handler constants
     */
    var MessageHandler = {
        SET_NAVIGATION_STATE: 'stencilSetNavigationState',
        SET_BUSY_STATE: 'stencilSetBusyState',
        CARD_READER_HANDLER: 'stencilListenForHighPowerCardReaderEvents',
        PRINTER_HANDLER: 'stencilPrintHTMLReceipt',
        OPEN_CASH_DRAWER_HANDLER: 'stencilOpenCashDrawer',
        SCANNER_HANDLER: 'listenForBarcodeScans'
    };

    /**
     * Icon constants to map icon classes to a corresponding charater code.
     */
    var IconMap = {
        'ICON-CHEVRON-LEFT' : '\\f053'
    };

    var StencilWebAPIUtils = {
        MessageHandler: MessageHandler,
        IconMap: IconMap,

        /**
         * Posts a message to the specified message handler using the specified data.
         *
         * @param messageHandler    The Stencil message handler to post the data to
         * @param data              The data to include with the message
         */
        postMessage: function(messageHandler, data) {
            if (window.webkit && window.webkit.messageHandlers && window.webkit.messageHandlers[messageHandler]) {
                window.webkit.messageHandlers[messageHandler].postMessage(data);
            } else {
                console.error('Invalid message handler: ', messageHandler);
            }
        },

        /**
         * Constructs an object defining an action.  An action describes the object and method within the
         * StencilWebAPI context that can be invoked to perform a web action from Stencil.
         *
         * @param objectName {string}   The name of the object
         * @param methodName {string}   The method of the object to invoke to perform the desired action
         * @optional args {Array}       An array of arguments to be used when invoking the method to perform the
         *                              desired action.
         * @returns {{}}
         */
        buildAction: function(objectName, methodName) {
            var action = {};

            action.obj = objectName || '';
            action.method = methodName || '';

            if (arguments.length > 2 && arguments[2] && Array.isArray(arguments[2])) {
                action.args = arguments[2];
            }

            return action;
        }
    };

    // work with both Phoenix and webPOS architectures
    if (typeof window.define === 'function' && window.define.amd) {
        define(['./StencilWebAPI'], function(StencilWebAPI) {
            StencilWebAPI.Utils = StencilWebAPIUtils;
            return StencilWebAPIUtils;
        });
    } else {
        if (!window.StencilWebAPI) {
            throw new Error('Error defining StencilWebAPIUtils; StencilWebAPI must be defined first.');
        }
        window.StencilWebAPI.Utils = StencilWebAPIUtils;
    }
}());

config = {
	app_ui_name: 'Nucleus Retail',
	debug_on: false,
}

lsCloud = {

	getJSONFromAPI: function(path) {
		var deferred = $.Deferred();
		$.getJSON(path, {readonly: '0'})
			.done(function(data, textStatus, jqXHR) {
				deferred.resolve(data);
			})
			.fail(function() {
				if (typeof(handleLogout) === 'function') {
					$.when(handleLogout())
					.done(function (data) {
						// for load session we don't need to re-call this
						// getJSONFromAPI because logging in gets us the same
						// info
						if (path=="/API/Session") {
							deferred.resolve(data);
							return;
						}
						$.when(getJSONFromAPI(path)) // after login try again
							.done(function(data) {
								deferred.resolve(data); // if our retry succeeds then we are good to go
							})
							.fail(function() {
								deferred.reject(); // our retry failed, so reject our deferred object
							});
						})
						.fail(function () {
							deferred.fail(); // oh uh our login didn't work, fail our deferred
						});
				} else {
					deferred.reject();
				}
			});
		return deferred.promise();
	},

	startServerJob: function(job,silent_fail) {
		var deferred = $.Deferred();
		var json = JSON.stringify(job.obj);
		var type = 'PUT';

		var obj = {
			type: type,
			url: job.url,
			data: job.data
		}

		if (job.type) {
			obj.type = job.type
		}

		// Handle json data differently than xml data
		if (json) {
			obj.data = json;
			obj.contentType = 'application/json; charset=utf-8';
			obj.dataType = 'json';
		}

		$.ajax(obj)
			.done(function(data, textStatus, jqXHR){
				deferred.resolve(data);
	            return jqXHR;
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				if (silent_fail) {
					deferred.resolve(errorThrown);
					return;
				}
	            var e = jqXHR;
				if (e.status != 401) {
					alertUser("Couldn't save (" + e.status + ")");
					return;
				}
				if (typeof(handleLogout) === 'function') {
					$.when(handleLogout())
					.done(function (data) {
						// for load session we don't need to re-call this
						// getJSONFromAPI because logging in gets us the same
						// info
						if (path=="/API/Session") {
							deferred.resolve(data);
							return;
						}
						$.when(getJSONFromAPI(path)) // after login try again
							.done(function(data) {
								deferred.resolve(data); // if our retry succeeds then we are good to go
							})
							.fail(function() {
								deferred.reject(); // our retry failed, so reject our deferred object
							});
						})
						.fail(function () {
							deferred.fail(); // oh uh our login didn't work, fail our deferred
						});
				}
			});

			return deferred;
	},

	Config: {
		__config: {},
		__loaded: false,

		__load: function () {
			var deferred = $.Deferred();
			if (this.__loaded) {
				deferred.resolve(this.__config);
			} else {
				if (merchantos.session.getSystemCustomerID()) {
					lsCloud.getJSONFromAPI('/API/Account/' + merchantos.session.getSystemCustomerID() + '/Config').done(
						function (configs) {
							lsCloud.Config.__loaded = true;

							configs.Config.forEach(function (config) {
								lsCloud.Config.__config[config.name] = config.value;
							});

							deferred.resolve(lsCloud.Config.__config);
						}
					).fail(function () {
						deferred.reject();
					});
				} else {
					deferred.reject();
				}
			}
			return deferred;
		},

		access: function(name) {
			var deferred = $.Deferred();
			this.__load().always(function () {
				if (name) {
					deferred.resolve(lsCloud.Config.__config[name]);
				} else {
					deferred.resolve(lsCloud.Config.__loaded);
				}
			});
			return deferred;
		},

		set: function(name, value) {
			this.__load().always(function () {
				lsCloud.Config.__config[name] = value;
			});
		}
	},

	Options: {
		__options: null,
		__loaded: false,

		__load: function() {
			var deferred = $.Deferred();
			if (lsCloud.Options.__options) {
				deferred.resolve(lsCloud.Options.__options);
			} else {
				lsCloud.getJSONFromAPI('/API/Account/' + merchantos.session.getSystemCustomerID() + '/Option').done(
					function (opts) {
						lsCloud.Options.__options = opts.Option;
						deferred.resolve(lsCloud.Options.__options);
					}
				)
				.fail(function() {
					deferred.reject();
				});
			}
			return deferred;
		},

		get: function(opt_name) {
			var deferred = $.Deferred();
			lsCloud.Options.__load().done(function(options) {
				var value = null;
				options.forEach(function (option) {
					if (option.name == opt_name) {
						value = option.value;
						return false;
					}
					return true;
				});
				deferred.resolve(value);
			})
			.fail(function() {
				deferred.reject();
			});
			return deferred;
		},

		save: function(opt_name,opt_value) {
			if (lsCloud.Options.__options) {
				lsCloud.Options.__options.forEach(function (option,index) {
					if (option.name == opt_name) {
						lsCloud.Options.__options[index].value = opt_value;
						return false;
					}
					return true;
				});
			}
			return $.ajax({
				type: 'PUT',
				url: '/API/Account/' + merchantos.session.getSystemCustomerID() + '/Option',
				data: '<Options><Option><name>' + opt_name + '</name><value>' + opt_value + '</value></Option></Options>'
			});
		}
	},

	UserPreferences: {
		__preferences: null,
		__loaded: false,

		__load: function() {
			var deferred = $.Deferred();
			if (this.__preferences) {
				deferred.resolve(this.__preferences);
			} else {
				var custID = merchantos.session.getSystemCustomerID(),
					employeeID = merchantos.session.getEmployee().employeeID;

				lsCloud.getJSONFromAPI('/API/Account/' + custID + '/UserPreference?employeeID=' + employeeID).done(
					function (prefs) {
						lsCloud.UserPreferences.__preferences = prefs.UserPreference;
						deferred.resolve(lsCloud.UserPreferences.__preferences);
					}
				)
				.fail(function() {
					deferred.reject();
				});
			}
			return deferred;
		},

		get: function(pref_name, component) {
			var deferred = $.Deferred();
			this.__load().done(function(preferences) {
				var value = null;

				// Check to make sure the user has any preferences
				if (preferences) {
					if(!$.isArray(preferences)) {
						preferences = [preferences];
					}
					preferences.forEach(function (pref) {
						if (pref.name == pref_name &&
							(!component || pref.component == component)) {
							value = pref.value;
							return false;
						}
						return true;
					});
				}
				deferred.resolve(value);
			})
			.fail(function() {
				deferred.reject();
			});
			return deferred;
		},

		save: function(pref_name, pref_value, type, component) {
			var deferred = $.Deferred();
			var employeeID = merchantos.session.getEmployee().employeeID;
			var prefID = null;

			if (this.__preferences) {
				this.__preferences.forEach(function (pref,index) {
					if (pref.name == pref_name) {
						llsCloud.UserPreferences.__preferences[index].value = pref_value;
						prefID = pref.userPreferenceID;
						return false;
					}
					return true;
				});
			}

			if (!component) {
				component = '';
			}

			if (!type) {
				type = '';
			}

			if (!prefID) {
				var type = 'POST'
				var id = '';
			} else {
				var type = 'PUT';
				var id = '/' + pref_id;
			}

			var data = '<UserPreference><employeeID>' + employeeID + '</employeeID>';
			data += '<type>' + type + '</type>';
			data += '<component>' + component + '</component>';
			data += '<name>' + pref_name + '</name>';
			data += '<value>' + pref_value + '</value></UserPreference>';

			$.ajax({
				type: type,
				url: '/API/Account/' + merchantos.session.getSystemCustomerID() + '/UserPreference' + id,
				data: data
			}).done(function(preference) {
				if (!prefID) {
					lsCloud.UserPreferences.__preferences.push(preference.UserPreference);
				}
				deferred.resolve(preference);
			}).fail(function () {
				deferred.reject();
			});

			return deferred;
		}
	},

	Shops: {
		__shops: null,
		__loaded: false,

		__load: function() {
			var deferred = $.Deferred();
			if (this.__loaded) {
				deferred.resolve(this.__shops);
			} else {
				lsCloud.getJSONFromAPI('/API/Account/' + merchantos.session.getSystemCustomerID() + '/Shop').done(
					function(shops) {
						if (!$.isArray(shops.Shop)) {
							shops.Shop = [shops.Shop];
						}
						this.__loaded = true;
						lsCloud.Shops.__shops = shops.Shop;
						deferred.resolve(lsCloud.Shops.__shops);
					}
				).fail(function() {
					deferred.reject();
				});
			}
			return deferred;
		},

		get: function() {
			var deferred = $.Deferred();
			this.__load().done(function () {
				deferred.resolve(lsCloud.Shops.__shops);
			}).fail(function () {
				deferredreject();
			});
			return deferred;
		}


	}
}

merchantos = {
	debug: function(msg) {
		if(config.debug_on == true) {
			console.log(msg);
		}

		var thisurl = $.url();
		if (isCordova() && (thisurl.attr('host')=='rad.localdev' || thisurl.attr('host')=='beta.merchantos.com')) {
			var debug_dom = $('#debug');
			if(debug_dom.length == 0) {
				$('body').append('<div id="debug"></div>');
				var debug_dom = $('#debug');
			}

			debug_dom.prepend(msg + "<br>");
		}
		return;
	},

	session: {
		getSystemCustomerID: function () { if (!merchantos.session.sessData) return null; return merchantos.session.sessData.systemCustomerID; },
		getEmployee: function () { if (!merchantos.session.sessData) return null; return merchantos.session.sessData.Employee; },
		getShop: function () { if (!merchantos.session.sessData) return null; return merchantos.session.sessData.Shop; },
		getRegister: function () { if (!merchantos.session.sessData) return null; return merchantos.session.sessData.Register; },
		hasRight: function (right) {
			if (!this.sessData || this.sessData.Rights[right] !== "true") {
				return false;
			}
			return true;
		},
		sessData: null,
		init: function () {
			if (merchantos.session.sessData) {
				// already loaded, just return a success
				return $.Deferred().resolveWith(this,merchantos.session.sessData);
			}

			return merchantos.session.apiRequest('/API/Session.json')
				.done(function(mSess, textStatus, jqXHR) {
					merchantos.session.sessData = mSess;
				});
		},
		apiRequest: function(url,load_relations) {
			url = url.replace("{{systemCustomerID}}",merchantos.session.getSystemCustomerID());
			load_relations = (load_relations?'&load_relations='+JSON.stringify(load_relations):'');

			var deferred = $.Deferred();

			$.getJSON(url+load_relations)
				.fail(function(jqXHR, textStatus, errorThrown) {
					merchantos.debug(errorThrown);
					deferred.rejectWith(this,[jqXHR, textStatus, errorThrown]);
				})
				.done(function(data, textStatus, jqXHR) {
					deferred.resolveWith(this,[data, textStatus, jqXHR]);
				});

			return deferred;
		},
		loadModules: function() {
			return merchantos.session.apiRequest('/API/SystemCustomerModule.json?systemCustomerID={{systemCustomerID}}&load_relations=all');
		},
		loadSale: function(saleID,relations) {
			return merchantos.session.apiRequest('/API/Account/{{systemCustomerID}}/Sale/'+saleID+'.json?',relations);
		}
	}
};

// We have jQuery.pURL for this same functionality
// but with login we ship the smallest possible JS so
// we have this simplistic URL parser for prep.
function getQueryParams(qs) {
    qs = qs.split("+").join(" ");

    var params = {}, tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while ((tokens = re.exec(qs))) {
        params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
    }

    return params;
}

function isCordova() {
	// Check for cordova cookie
	if(docCookies.hasItem('cordova')) {
		return true;
	}

	// Alternatively, check for URL parameter
	var params = getQueryParams(document.location.search);
	if(params['cordova']) {
		// set new cordova cookie
		var CookieDate = new Date;
		CookieDate.setFullYear(CookieDate.getFullYear() +10);
		docCookies.setItem('cordova','true',CookieDate);
		return true;
	}

	// Otherwise assume we're not running within Cordova
	return false;
}

function isGriffin() {
	if(StencilWebAPI.isStencil()) {
		// set new cookie
		docCookies.setItem('griffin','true', 0);
		return true;
	} else {
		docCookies.removeItem('griffin');
	}

	return docCookies.hasItem('griffin');
}

function initGriffin() {
	if(isGriffin()) {
		StencilWebAPI.init();
		StencilWebAPI.navigation = new Navigation();
		StencilWebAPI.printer = new Printer();
		StencilWebAPI.scanner = new Scanner();

		if (window.location.pathname === '/register.php' ||
			window.location.pathname === '/webstore.php') {
			StencilWebAPI.navigation.updateNavState();
		}
	}
}


var docCookies = {
  getItem: function (sKey) {
    return unescape(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null;
  },
  setItem: function (sKey, sValue, vEnd, sPath, sDomain, bSecure) {
    if (!sKey || /^(?:expires|max\-age|path|domain|secure)$/i.test(sKey)) { return false; }
    var sExpires = "";
    if (vEnd) {
      switch (vEnd.constructor) {
        case Number:
          sExpires = vEnd === Infinity ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT" : "; max-age=" + vEnd;
          break;
        case String:
          sExpires = "; expires=" + vEnd;
          break;
        case Date:
          sExpires = "; expires=" + vEnd.toGMTString();
          break;
      }
    }
    document.cookie = escape(sKey) + "=" + escape(sValue) + sExpires + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "") + (bSecure ? "; secure" : "");
    return true;
  },
  removeItem: function (sKey, sPath) {
    if (!sKey || !this.hasItem(sKey)) { return false; }
    document.cookie = escape(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" + (sPath ? "; path=" + sPath : "");
    return true;
  },
  hasItem: function (sKey) {
    return (new RegExp("(?:^|;\\s*)" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
  },
  keys: /* optional method: you can safely remove it! */ function () {
    var aKeys = document.cookie.replace(/((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g, "").split(/\s*(?:\=[^;]*)?;\s*/);
    for (var nIdx = 0; nIdx < aKeys.length; nIdx++) { aKeys[nIdx] = unescape(aKeys[nIdx]); }
    return aKeys;
  }
};

function hex2bin(hex)
{
    var bytes = [], str;

    for(var i=0; i< hex.length-1; i+=2)
        bytes.push(parseInt(hex.substr(i, 2), 16));

    return String.fromCharCode.apply(String, bytes);
}

// Listener to prevent mouseWheel scroll from affecting numbers when target is a
// number input.  Always unbinds/rebinds to prevent multiple listeners from
// persisting through a series of ajax requests.
function numberScrollInputFix() {
	$('body').off('mousewheel');
	$('body').on("mousewheel", function(event) {
		if($(event.target).is(':input[type=number]')) {
			event.preventDefault();
		}
	});
}

$(function() {
	if(isCordova()) {
		$('body').addClass('is_cordova');
	}
	initGriffin();
	numberScrollInputFix();
});

/*
 * JQuery URL Parser plugin, v2.2.1
 * Developed and maintanined by Mark Perkins, mark@allmarkedup.com
 * Source repository: https://github.com/allmarkedup/jQuery-URL-Parser
 * Licensed under an MIT-style license. See https://github.com/allmarkedup/jQuery-URL-Parser/blob/master/LICENSE for details.
 */ 

;(function(factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD available; use anonymous module
		if ( typeof jQuery !== 'undefined' ) {
			define(['jquery'], factory);	
		} else {
			define([], factory);
		}
	} else {
		// No AMD available; mutate global vars
		if ( typeof jQuery !== 'undefined' ) {
			factory(jQuery);
		} else {
			factory();
		}
	}
})(function($, undefined) {
	
	var tag2attr = {
			a       : 'href',
			img     : 'src',
			form    : 'action',
			base    : 'href',
			script  : 'src',
			iframe  : 'src',
			link    : 'href'
		},
		
		key = ['source', 'protocol', 'authority', 'userInfo', 'user', 'password', 'host', 'port', 'relative', 'path', 'directory', 'file', 'query', 'fragment'], // keys available to query
		
		aliases = { 'anchor' : 'fragment' }, // aliases for backwards compatability
		
		parser = {
			strict : /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,  //less intuitive, more accurate to the specs
			loose :  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/ // more intuitive, fails on relative paths and deviates from specs
		},
		
		toString = Object.prototype.toString,
		
		isint = /^[0-9]+$/;
	
	function parseUri( url, strictMode ) {
		var str = decodeURI( url ),
		res   = parser[ strictMode || false ? 'strict' : 'loose' ].exec( str ),
		uri = { attr : {}, param : {}, seg : {} },
		i   = 14;
		
		while ( i-- ) {
			uri.attr[ key[i] ] = res[i] || '';
		}
		
		// build query and fragment parameters		
		uri.param['query'] = parseString(uri.attr['query']);
		uri.param['fragment'] = parseString(uri.attr['fragment']);
		
		// split path and fragement into segments		
		uri.seg['path'] = uri.attr.path.replace(/^\/+|\/+$/g,'').split('/');     
		uri.seg['fragment'] = uri.attr.fragment.replace(/^\/+|\/+$/g,'').split('/');
		
		// compile a 'base' domain attribute        
		uri.attr['base'] = uri.attr.host ? (uri.attr.protocol ?  uri.attr.protocol+'://'+uri.attr.host : uri.attr.host) + (uri.attr.port ? ':'+uri.attr.port : '') : '';      
		  
		return uri;
	};
	
	function getAttrName( elm ) {
		var tn = elm.tagName;
		if ( typeof tn !== 'undefined' ) return tag2attr[tn.toLowerCase()];
		return tn;
	}
	
	function promote(parent, key) {
		if (parent[key].length == 0) return parent[key] = {};
		var t = {};
		for (var i in parent[key]) t[i] = parent[key][i];
		parent[key] = t;
		return t;
	}

	function parse(parts, parent, key, val) {
		var part = parts.shift();
		if (!part) {
			if (isArray(parent[key])) {
				parent[key].push(val);
			} else if ('object' == typeof parent[key]) {
				parent[key] = val;
			} else if ('undefined' == typeof parent[key]) {
				parent[key] = val;
			} else {
				parent[key] = [parent[key], val];
			}
		} else {
			var obj = parent[key] = parent[key] || [];
			if (']' == part) {
				if (isArray(obj)) {
					if ('' != val) obj.push(val);
				} else if ('object' == typeof obj) {
					obj[keys(obj).length] = val;
				} else {
					obj = parent[key] = [parent[key], val];
				}
			} else if (~part.indexOf(']')) {
				part = part.substr(0, part.length - 1);
				if (!isint.test(part) && isArray(obj)) obj = promote(parent, key);
				parse(parts, obj, part, val);
				// key
			} else {
				if (!isint.test(part) && isArray(obj)) obj = promote(parent, key);
				parse(parts, obj, part, val);
			}
		}
	}

	function merge(parent, key, val) {
		if (~key.indexOf(']')) {
			var parts = key.split('['),
			len = parts.length,
			last = len - 1;
			parse(parts, parent, 'base', val);
		} else {
			if (!isint.test(key) && isArray(parent.base)) {
				var t = {};
				for (var k in parent.base) t[k] = parent.base[k];
				parent.base = t;
			}
			set(parent.base, key, val);
		}
		return parent;
	}

	function parseString(str) {
		return reduce(String(str).split(/&|;/), function(ret, pair) {
			try {
				pair = decodeURIComponent(pair.replace(/\+/g, ' '));
			} catch(e) {
				// ignore
			}
			var eql = pair.indexOf('='),
				brace = lastBraceInKey(pair),
				key = pair.substr(0, brace || eql),
				val = pair.substr(brace || eql, pair.length),
				val = val.substr(val.indexOf('=') + 1, val.length);

			if ('' == key) key = pair, val = '';

			return merge(ret, key, val);
		}, { base: {} }).base;
	}
	
	function set(obj, key, val) {
		var v = obj[key];
		if (undefined === v) {
			obj[key] = val;
		} else if (isArray(v)) {
			v.push(val);
		} else {
			obj[key] = [v, val];
		}
	}
	
	function lastBraceInKey(str) {
		var len = str.length,
			 brace, c;
		for (var i = 0; i < len; ++i) {
			c = str[i];
			if (']' == c) brace = false;
			if ('[' == c) brace = true;
			if ('=' == c && !brace) return i;
		}
	}
	
	function reduce(obj, accumulator){
		var i = 0,
			l = obj.length >> 0,
			curr = arguments[2];
		while (i < l) {
			if (i in obj) curr = accumulator.call(undefined, curr, obj[i], i, obj);
			++i;
		}
		return curr;
	}
	
	function isArray(vArg) {
		return Object.prototype.toString.call(vArg) === "[object Array]";
	}
	
	function keys(obj) {
		var keys = [];
		for ( prop in obj ) {
			if ( obj.hasOwnProperty(prop) ) keys.push(prop);
		}
		return keys;
	}
		
	function purl( url, strictMode ) {
		if ( arguments.length === 1 && url === true ) {
			strictMode = true;
			url = undefined;
		}
		strictMode = strictMode || false;
		url = url || window.location.toString();
	
		return {
			
			data : parseUri(url, strictMode),
			
			// get various attributes from the URI
			attr : function( attr ) {
				attr = aliases[attr] || attr;
				return typeof attr !== 'undefined' ? this.data.attr[attr] : this.data.attr;
			},
			
			// return query string parameters
			param : function( param ) {
				return typeof param !== 'undefined' ? this.data.param.query[param] : this.data.param.query;
			},
			
			// return fragment parameters
			fparam : function( param ) {
				return typeof param !== 'undefined' ? this.data.param.fragment[param] : this.data.param.fragment;
			},
			
			// return path segments
			segment : function( seg ) {
				if ( typeof seg === 'undefined' ) {
					return this.data.seg.path;
				} else {
					seg = seg < 0 ? this.data.seg.path.length + seg : seg - 1; // negative segments count from the end
					return this.data.seg.path[seg];                    
				}
			},
			
			// return fragment segments
			fsegment : function( seg ) {
				if ( typeof seg === 'undefined' ) {
					return this.data.seg.fragment;                    
				} else {
					seg = seg < 0 ? this.data.seg.fragment.length + seg : seg - 1; // negative segments count from the end
					return this.data.seg.fragment[seg];                    
				}
			}
	    	
		};
	
	};
	
	if ( typeof $ !== 'undefined' ) {
		
		$.fn.url = function( strictMode ) {
			var url = '';
			if ( this.length ) {
				url = $(this).attr( getAttrName(this[0]) ) || '';
			}    
			return purl( url, strictMode );
		};
		
		$.url = purl;
		
	} else {
		window.purl = purl;
	}

});

config.hosts = {};

switch (window.location.hostname) {
	default:
	case "east0.merchantos.com":
	case "east0.Nucleusapp.com":
	case "east1.merchantos.com":
	case "east1.Nucleusapp.com":
	case "east2.merchantos.com":
	case "east2.Nucleusapp.com":
	case "east3.merchantos.com":
	case "east3.Nucleusapp.com":
	case "east4.merchantos.com":
	case "east4.Nucleusapp.com":
	case "east5.merchantos.com":
	case "east5.Nucleusapp.com":
	case "east6.merchantos.com":
	case "east6.Nucleusapp.com":
	case "east7.merchantos.com":
	case "east7Nucleusapp.com":
	case "east8.merchantos.com":
	case "east8.Nucleusapp.com":
	case "east9.merchantos.com":
	case "east9.Nucleusapp.com":
	case "east10.merchantos.com":
	case "east10.Nucleusapp.com":
	case "cloud0e.merchantos.com":
	case "cloud0e.Nucleusapp.com":
	case "cloud1e.merchantos.com":
	case "cloud1e.Nucleusapp.com":
	case "cloud2e.merchantos.com":
	case "cloud2e.Nucleusapp.com":
	case "cloud3e.merchantos.com":
	case "cloud3e.Nucleusapp.com":
	case "cloud4e.merchantos.com":
	case "cloud4e.Nucleusapp.com":
	case "cloud5e.merchantos.com":
	case "cloud5e.Nucleusapp.com":
	case "cloud6e.merchantos.com":
	case "cloud6e.Nucleusapp.com":
	case "cloud7e.merchantos.com":
	case "cloud7e.Nucleusapp.com":
	case "cloud8e.merchantos.com":
	case "cloud8e.Nucleusapp.com":
	case "cloud9e.merchantos.com":
	case "cloud9e.Nucleusapp.com":
	case "cloud10e.merchantos.com":
	case "cloud10e.Nucleusapp.com":
	case "west0.merchantos.com":
	case "west0.Nucleusapp.com":
	case "west1.merchantos.com":
	case "west1.Nucleusapp.com":
	case "west2.merchantos.com":
	case "west2.Nucleusapp.com":
	case "west3.merchantos.com":
	case "west3.Nucleusapp.com":
	case "west4.merchantos.com":
	case "west4.Nucleusapp.com":
	case "west5.merchantos.com":
	case "west5.Nucleusapp.com":
	case "west6.merchantos.com":
	case "west6.Nucleusapp.com":
	case "west7.merchantos.com":
	case "west7.Nucleusapp.com":
	case "west8.merchantos.com":
	case "west8.Nucleusapp.com":
	case "west9.merchantos.com":
	case "west9.Nucleusapp.com":
	case "west10.merchantos.com":
	case "west10.Nucleusapp.com":
	case "cloud0w.merchantos.com":
	case "cloud0w.Nucleusapp.com":
	case "cloud1w.merchantos.com":
	case "cloud1w.Nucleusapp.com":
	case "cloud2w.merchantos.com":
	case "cloud2w.Nucleusapp.com":
	case "cloud3w.merchantos.com":
	case "cloud3w.Nucleusapp.com":
	case "cloud4w.merchantos.com":
	case "cloud4w.Nucleusapp.com":
	case "cloud5w.merchantos.com":
	case "cloud5w.Nucleusapp.com":
	case "cloud6w.merchantos.com":
	case "cloud6w.Nucleusapp.com":
	case "cloud7w.merchantos.com":
	case "cloud7w.Nucleusapp.com":
	case "cloud8w.merchantos.com":
	case "cloud8w.Nucleusapp.com":
	case "cloud9w.merchantos.com":
	case "cloud9w.Nucleusapp.com":
	case "cloud10w.merchantos.com":
	case "cloud10w.Nucleusapp.com":
	case "proxyeast0.merchantos.com":
	case "proxyeast0.Nucleusapp.com":
	case "proxyeast1.merchantos.com":
	case "proxyeast1.Nucleusapp.com":
	case "proxyeast2.merchantos.com":
	case "proxyeast2.Nucleusapp.com":
	case "proxyeast3.merchantos.com":
	case "proxyeast3.Nucleusapp.com":
	case "proxyeast4.merchantos.com":
	case "proxyeast4.Nucleusapp.com":
	case "proxyeast5.merchantos.com":
	case "proxyeast5.Nucleusapp.com":
	case "proxyeast6.merchantos.com":
	case "proxyeast6.Nucleusapp.com":
	case "proxyeast7.merchantos.com":
	case "proxyeast7.Nucleusapp.com":
	case "proxyeast8.merchantos.com":
	case "proxyeast8.Nucleusapp.com":
	case "proxyeast9.merchantos.com":
	case "proxyeast9.Nucleusapp.com":
	case "proxyeast10.merchantos.com":
	case "proxyeast10.Nucleusapp.com":
	case "cloud0ep.merchantos.com":
	case "cloud0ep.Nucleusapp.com":
	case "cloud1ep.merchantos.com":
	case "cloud1ep.Nucleusapp.com":
	case "cloud2ep.merchantos.com":
	case "cloud2ep.Nucleusapp.com":
	case "cloud3ep.merchantos.com":
	case "cloud3ep.Nucleusapp.com":
	case "cloud4ep.merchantos.com":
	case "cloud4ep.Nucleusapp.com":
	case "cloud5ep.merchantos.com":
	case "cloud5ep.Nucleusapp.com":
	case "cloud6ep.merchantos.com":
	case "cloud6ep.Nucleusapp.com":
	case "cloud7ep.merchantos.com":
	case "cloud7ep.Nucleusapp.com":
	case "cloud8ep.merchantos.com":
	case "cloud8ep.Nucleusapp.com":
	case "cloud9ep.merchantos.com":
	case "cloud9ep.Nucleusapp.com":
	case "cloud10ep.merchantos.com":
	case "cloud10ep.Nucleusapp.com":
	case "proxywest0.merchantos.com":
	case "proxywest0.Nucleusapp.com":
	case "proxywest1.merchantos.com":
	case "proxywest1.Nucleusapp.com":
	case "proxywest2.merchantos.com":
	case "proxywest2.Nucleusapp.com":
	case "proxywest3.merchantos.com":
	case "proxywest3.Nucleusapp.com":
	case "proxywest4.merchantos.com":
	case "proxywest4.Nucleusapp.com":
	case "proxywest5.merchantos.com":
	case "proxywest5.Nucleusapp.com":
	case "proxywest6.merchantos.com":
	case "proxywest6.Nucleusapp.com":
	case "proxywest7.merchantos.com":
	case "proxywest7.Nucleusapp.com":
	case "proxywest8.merchantos.com":
	case "proxywest8.Nucleusapp.com":
	case "proxywest9.merchantos.com":
	case "proxywest9.Nucleusapp.com":
	case "proxywest10.merchantos.com":
	case "proxywest10.merchantos.com":
	case "cloud0wp.merchantos.com":
	case "cloud0wp.Nucleusapp.com":
	case "cloud1wp.merchantos.com":
	case "cloud1wp.Nucleusapp.com":
	case "cloud2wp.merchantos.com":
	case "cloud2wp.Nucleusapp.com":
	case "cloud3wp.merchantos.com":
	case "cloud3wp.Nucleusapp.com":
	case "cloud4wp.merchantos.com":
	case "cloud4wp.Nucleusapp.com":
	case "cloud5wp.merchantos.com":
	case "cloud5wp.Nucleusapp.com":
	case "cloud6wp.merchantos.com":
	case "cloud6wp.Nucleusapp.com":
	case "cloud7wp.merchantos.com":
	case "cloud7wp.Nucleusapp.com":
	case "cloud8wp.merchantos.com":
	case "cloud8wp.Nucleusapp.com":
	case "cloud9wp.merchantos.com":
	case "cloud9wp.Nucleusapp.com":
	case "cloud10wp.merchantos.com":
	case "cloud10wp.Nucleusapp.com":
	case "shop.merchantos.com":
	case "shop.Nucleusapp.com":
	case "cloud.merchantos.com":
	case "cloud.Nucleusapp.com":
		config.regions =
		{
			east: "cloud1e.merchantos.com",
			west: "cloud1w.merchantos.com",
		};
		config.hosts =
		{
			"east0.merchantos.com":
			{
				region: "east",
				proxy: "proxyeast0.merchantos.com",
				proxy_region: "west",
			},
			"east0.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxyeast0.Nucleusapp.com",
				proxy_region: "west",
			},
			"east1.merchantos.com":
			{
				region: "east",
				proxy: "proxyeast1.merchantos.com",
				proxy_region: "west",
			},
			"east1.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxyeast1.Nucleusapp.com",
				proxy_region: "west",
			},
			"east2.merchantos.com":
			{
				region: "east",
				proxy: "proxyeast2.merchantos.com",
				proxy_region: "west",
			},
			"east2.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxyeast2.Nucleusapp.com",
				proxy_region: "west",
			},
			"east3.merchantos.com":
			{
				region: "east",
				proxy: "proxyeast3.merchantos.com",
				proxy_region: "west",
			},
			"east3.merchantos.com":
			{
				region: "east",
				proxy: "proxyeast3.Nucleusapp.com",
				proxy_region: "west",
			},
			"east4.merchantos.com":
			{
				region: "east",
				proxy: "proxyeast4.merchantos.com",
				proxy_region: "west",
			},
			"east4.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxyeast4.Nucleusapp.com",
				proxy_region: "west",
			},
			"east5.merchantos.com":
			{
				region: "east",
				proxy: "proxyeast5.merchantos.com",
				proxy_region: "west",
			},
			"east5.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxyeast5.Nucleusapp.com",
				proxy_region: "west",
			},
			"east6.merchantos.com":
			{
				region: "east",
				proxy: "proxyeast6.merchantos.com",
				proxy_region: "west",
			},
			"east6.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxyeast6.Nucleusapp.com",
				proxy_region: "west",
			},
			"east7.merchantos.com":
			{
				region: "east",
				proxy: "proxyeast7.merchantos.com",
				proxy_region: "west",
			},
			"east7.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxyeast7.Nucleusapp.com",
				proxy_region: "west",
			},
			"east8.merchantos.com":
			{
				region: "east",
				proxy: "proxyeast8.merchantos.com",
				proxy_region: "west",
			},
			"east8.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxyeast.Nucleusapp.com",
				proxy_region: "west",
			},
			"east9.merchantos.com":
			{
				region: "east",
				proxy: "proxyeast9.merchantos.com",
				proxy_region: "west",
			},
			"east9.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxyeast9.Nucleusapp.com",
				proxy_region: "west",
			},
			"east10.merchantos.com":
			{
				region: "east",
				proxy: "proxyeast10.merchantos.com",
				proxy_region: "west",
			},
			"east10.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxyeast.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud0e.merchantos.com":
			{
				region: "east",
				proxy: "cloud0ep.merchantos.com",
				proxy_region: "west",
			},
			"cloud0e.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud0ep.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud1e.merchantos.com":
			{
				region: "east",
				proxy: "cloud1ep.merchantos.com",
				proxy_region: "west",
			},
			"cloud1e.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud1ep.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud2e.merchantos.com":
			{
				region: "east",
				proxy: "cloud2ep.merchantos.com",
				proxy_region: "west",
			},
			"cloud2e.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud2ep.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud3e.merchantos.com":
			{
				region: "east",
				proxy: "cloud3ep.merchantos.com",
				proxy_region: "west",
			},
			"cloud3e.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud3ep.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud4e.merchantos.com":
			{
				region: "east",
				proxy: "cloud4ep.merchantos.com",
				proxy_region: "west",
			},
			"cloud4e.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud4ep.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud5e.merchantos.com":
			{
				region: "east",
				proxy: "cloud5ep.merchantos.com",
				proxy_region: "west",
			},
			"cloud5e.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud5ep.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud6e.merchantos.com":
			{
				region: "east",
				proxy: "cloud6ep.merchantos.com",
				proxy_region: "west",
			},
			"cloud6e.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud6ep.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud7e.merchantos.com":
			{
				region: "east",
				proxy: "cloud7ep.merchantos.com",
				proxy_region: "west",
			},
			"cloud7e.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud7ep.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud8e.merchantos.com":
			{
				region: "east",
				proxy: "cloud8ep.merchantos.com",
				proxy_region: "west",
			},
			"cloud8e.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud8ep.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud9e.merchantos.com":
			{
				region: "east",
				proxy: "cloud9ep.merchantos.com",
				proxy_region: "west",
			},
			"cloud9e.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud9ep.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud10e.merchantos.com":
			{
				region: "east",
				proxy: "cloud10ep.merchantos.com",
				proxy_region: "west",
			},
			"cloud10e.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud10ep.Nucleusapp.com",
				proxy_region: "west",
			},
			"west0.merchantos.com":
			{
				region: "east",
				proxy: "proxywest0.merchantos.com",
				proxy_region: "west",
			},
			"west0.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxywest0.Nucleusapp.com",
				proxy_region: "west",
			},
			"west1.merchantos.com":
			{
				region: "east",
				proxy: "proxywest1.merchantos.com",
				proxy_region: "west",
			},
			"west1.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxywest1.Nucleusapp.com",
				proxy_region: "west",
			},
			"west2.merchantos.com":
			{
				region: "east",
				proxy: "proxywest2.merchantos.com",
				proxy_region: "west",
			},
			"west2.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxywest2.Nucleusapp.com",
				proxy_region: "west",
			},
			"west3.merchantos.com":
			{
				region: "east",
				proxy: "proxywest3.merchantos.com",
				proxy_region: "west",
			},
			"west3.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxywest3.Nucleusapp.com",
				proxy_region: "west",
			},
			"west4.merchantos.com":
			{
				region: "east",
				proxy: "proxywest4.merchantos.com",
				proxy_region: "west",
			},
			"west4.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxywest4.Nucleusapp.com",
				proxy_region: "west",
			},
			"west5.merchantos.com":
			{
				region: "east",
				proxy: "proxywest5.merchantos.com",
				proxy_region: "west",
			},
			"west5.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxywest5.Nucleusapp.com",
				proxy_region: "west",
			},
			"west6.merchantos.com":
			{
				region: "east",
				proxy: "proxywest6.merchantos.com",
				proxy_region: "west",
			},
			"west6.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxywest6.Nucleusapp.com",
				proxy_region: "west",
			},
			"west7.merchantos.com":
			{
				region: "east",
				proxy: "proxywest7.merchantos.com",
				proxy_region: "west",
			},
			"west7.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxywest7.Nucleusapp.com",
				proxy_region: "west",
			},
			"west8.merchantos.com":
			{
				region: "east",
				proxy: "proxywest8.merchantos.com",
				proxy_region: "west",
			},
			"west8.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxywest8.Nucleusapp.com",
				proxy_region: "west",
			},
			"west9.merchantos.com":
			{
				region: "east",
				proxy: "proxywest9.merchantos.com",
				proxy_region: "west",
			},
			"west9.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxywest9.Nucleusapp.com",
				proxy_region: "west",
			},
			"west10.merchantos.com":
			{
				region: "east",
				proxy: "proxywest10.merchantos.com",
				proxy_region: "west",
			},
			"west10.Nucleusapp.com":
			{
				region: "east",
				proxy: "proxywest10.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud0w.merchantos.com":
			{
				region: "east",
				proxy: "cloud0wp.merchantos.com",
				proxy_region: "west",
			},
			"cloud0w.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud0wp.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud1w.merchantos.com":
			{
				region: "east",
				proxy: "cloud1wp.merchantos.com",
				proxy_region: "west",
			},
			"cloud1w.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud1wp.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud2w.merchantos.com":
			{
				region: "east",
				proxy: "cloud2wp.merchantos.com",
				proxy_region: "west",
			},
			"cloud2w.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud2wp.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud3w.merchantos.com":
			{
				region: "east",
				proxy: "cloud3wp.merchantos.com",
				proxy_region: "west",
			},
			"cloud3w.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud3wp.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud4w.merchantos.com":
			{
				region: "east",
				proxy: "cloud4wp.merchantos.com",
				proxy_region: "west",
			},
			"cloud4w.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud4wp.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud5w.merchantos.com":
			{
				region: "east",
				proxy: "cloud5wp.merchantos.com",
				proxy_region: "west",
			},
			"cloud5w.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud5wp.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud6w.merchantos.com":
			{
				region: "east",
				proxy: "cloud6wp.merchantos.com",
				proxy_region: "west",
			},
			"cloud6w.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud6wp.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud7w.merchantos.com":
			{
				region: "east",
				proxy: "cloud7wp.merchantos.com",
				proxy_region: "west",
			},
			"cloud7w.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud7wp.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud8w.merchantos.com":
			{
				region: "east",
				proxy: "cloud8wp.merchantos.com",
				proxy_region: "west",
			},
			"cloud8w.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud8wp.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud9w.merchantos.com":
			{
				region: "east",
				proxy: "cloud9wp.merchantos.com",
				proxy_region: "west",
			},
			"cloud9w.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud9wp.Nucleusapp.com",
				proxy_region: "west",
			},
			"cloud10w.merchantos.com":
			{
				region: "east",
				proxy: "cloud10wp.merchantos.com",
				proxy_region: "west",
			},
			"cloud10w.Nucleusapp.com":
			{
				region: "east",
				proxy: "cloud10wp.Nucleusapp.com",
				proxy_region: "west",
			},
		};
		break;
	case "rad.localdev":
	case "rad1.localdev":
	case "rad2.localdev":
	case "rad3.localdev":
	case "rad4.localdev":
	case "proxyrad.localdev":
	case "proxyrad1.localdev":
	case "proxyrad2.localdev":
	case "proxyrad3.localdev":
	case "proxyrad4.localdev":
		config.debug_on = true;
		config.regions = {
			east: "rad1.localdev",
			west: "rad2.localdev",
		};
		config.hosts =
		{
			"rad.localdev":
			{
				region: "east",
				proxy: "proxyrad.localdev",
				proxy_region: "west",
			},
			"rad1.localdev":
			{
				region: "east",
				proxy: "proxyrad1.localdev",
				proxy_region: "west",
			},
			"rad2.localdev":
			{
				region: "east",
				proxy: "proxyrad2.localdev",
				proxy_region: "west",
			},
			"rad3.localdev":
			{
				region: "east",
				proxy: "proxyrad3.localdev",
				proxy_region: "west",
			},
			"rad4.localdev":
			{
				region: "east",
				proxy: "proxyrad4.localdev",
				proxy_region: "west",
			},
		};
		break;
	case "radproxyeast.merchantos.com":
	case "radproxyeast.Nucleusapp.com":
	case "radproxywest.merchantos.com":
	case "radproxywest.Nucleusapp.com":
	case "radeast.merchantos.com":
	case "radeast.Nucleusapp.com":
	case "radwest.merchantos.com":
	case "radwest.Nucleusapp.com":
	case "rad.merchantos.com":
	case "rad.Nucleusapp.com":
	case "radcloud.merchantos.com":
	case "radcloud.Nucleusapp.com":
		config.regions = {
			east: "radeast.merchantos.com",
			west: "radwest.merchantos.com",
		};
		config.hosts = {
			"radeast.merchantos.com":
			{
				region: "east",
				proxy: "radproxyeast.merchantos.com",
				proxy_region: "west",
			},
			"radeast.Nucleusapp.com":
			{
				region: "east",
				proxy: "radproxyeast.Nucleusapp.com",
				proxy_region: "west",
			},
			"radwest.merchantos.com":
			{
				region: "west",
				proxy: "radproxywest.merchantos.com",
				proxy_region: "east",
			},
			"radwest.Nucleusapp.com":
			{
				region: "west",
				proxy: "radproxywest.Nucleusapp.com",
				proxy_region: "east",
			},
		};
		break;
	case "staging.merchantos.com":
	case "Nucleusappstaging.com":
	case "east1.Nucleusappstaging.com":
	case "east2.Nucleusappstaging.com":
	case "east3.Nucleusappstaging.com":
	case "east4.Nucleusappstaging.com":
	case "east5.Nucleusappstaging.com":
	case "east6.Nucleusappstaging.com":
	case "east7.Nucleusappstaging.com":
	case "east8.Nucleusappstaging.com":
	case "east9.Nucleusappstaging.com":
	case "west1.Nucleusappstaging.com":
	case "west2.Nucleusappstaging.com":
	case "west3.Nucleusappstaging.com":
	case "west4.Nucleusappstaging.com":
	case "west5.Nucleusappstaging.com":
	case "west6.Nucleusappstaging.com":
	case "west7.Nucleusappstaging.com":
	case "west8.Nucleusappstaging.com":
	case "west9.Nucleusappstaging.com":
		config.regions = {
			east: "staging.merchantos.com",
		};
		config.hosts = {
			"staging.merchantos.com":
			{
				region: "east",
				proxy: "staging.merchantos.com",
				proxy_region: "west",
			},
			"east1.Nucleusappstaging.com":
			{
				region: "east",
				proxy: "east1.Nucleusappstaging.com",
				proxy_region: "west",
			},
			"east2.Nucleusappstaging.com":
			{
				region: "east",
				proxy: "east2.Nucleusappstaging.com",
				proxy_region: "west",
			},
		};
		break;
}

merchantos.hosts = config.hosts;
merchantos.regions = config.regions;

merchantos.login = {
	waiting_for_num: Object.keys(config.regions).length,
	live: {},

	Submit: function(login,password,formid) {
		merchantos.login.lockSubmit();

		var done = false;
		$.each(merchantos.regions, function(region, host) {
			if (merchantos.login.live[region]) {
				done = true;
				merchantos.login.getRedirect(login,password,formid,host);
				return false; // break the .each
			}
		});
		if (done) {
			return;
		}
		if (merchantos.login.waiting_for_num <= 0) {
			displayError('Your internet connection appears to be having trouble. Try restarting your modem and router. <a href="/help/request>Contact Support for help</a>."',true,config.app_ui_name + ' servers unreachable');
			merchantos.debug("Can't login. All servers unreachable.");
			// try the first host to see if we can get through
			for (var host in merchantos.hosts) {
				merchantos.login.getRedirect(login,password,formid,host);
				return;
			}
		}
		setTimeout(function() { merchantos.login.Submit(login,password,formid); },500);
	},

	getRedirect: function(login,password,formid,host) {
		return $.ajax("https://" + host + "/ajax_forms.php",{
			dataType: "jsonp",
			timeout: 20000,
			data: {
					'form_name':'login_redirect',
					'name':login,
					'password':password,
					'form_id':formid
			},
			type: 'POST',
			error: function(jqXHR, textStatus, errorThrown) {
				merchantos.login.unlockSubmit();
			},
			success: function(data, textStatus, jqXHR) {
				if (data.message) {
					if (data.result && formid == "emailpasswordreset")
					{
						$('form fieldset').hide();
					}
					displayMessage(data.message);
					return;
				}
				if (data.error) {
					displayError(data.error,true);
					return;
				}
				if (data.openid) {
					merchantos.login.openIDRedirect(data.redirect);
					return;
				}
				if (data.host) {
					// even if the user has no redirect, we always get something back from the script
					merchantos.login.doLogin(login,password,data.host);
					return;
				}
				merchantos.login.loginIncorrect();
				return;
			}
		});
	},

	doLogin: function(login,password,redirect) {
		merchantos.debug("redirect received: " + redirect);
		redirect_props = merchantos.hosts[redirect];
		if (redirect_props) {
			if (merchantos.login.live[redirect_props.region]) {
				// do the actual login to our primary redirect host
				merchantos.debug("do login: " + redirect);
				merchantos.login.submitLogin(login,password,redirect);
				return;
			}
			if (merchantos.login.live[redirect_props.proxy_region]) {
				// login on our host but at it's proxy
				merchantos.debug("do proxy login: " + redirect_props.proxy);
				merchantos.login.submitLogin(login,password,redirect_props.proxy);
				return;
			}
		}
		// normal & proxy aren't up, we are screwed
		merchantos.debug("do login: " + redirect);
		merchantos.login.submitLogin(login,password,redirect);
	},

	submitLogin: function(login,password,host) {
		var form = $("<form method='post' class='hidden' />");
		var login_field = $("<input type='hidden' name='login_name' value='"+login+"' />");
		var password_field = $("<input type='hidden' name='login_password' value='"+password+"' />");
		var formname_field = $("<input type='hidden' name='form_name' value='login' />");
		var cordova_field = $("<input type='hidden' name='cordova' value='"+(isCordova()?'1':'0')+"' />");
		form.append(login_field);
		form.append(password_field);
		form.append(formname_field);
		form.append(cordova_field);

		var redirect_to = $("#login").find('input[name="redirect_after_login"]').val();
		if (redirect_to) {
			form.append($('<input type="hidden" name="redirect_after_login" value="' + redirect_to + '" />'));
		}

		form[0].action = "https://" + host + "/register.php";
		merchantos.debug(form);
		$("body").append(form);
		form.submit();
	},
	setLive: function(host) {
		merchantos.debug(host + " is live");
		merchantos.login.live[host] = true;
		merchantos.login.waiting_for_num--;
	},
	setDead: function(host) {
		merchantos.debug(host + " is dead");
		merchantos.login.live[host] = false;
		merchantos.login.waiting_for_num--;

		if (merchantos.login.waiting_for_num<=0)
		{
			var all_dead = true;
			$.each(merchantos.regions, function(region, host) {
				if (merchantos.login.live[region])
				{
					all_dead = false;
					return false;
				}
			});
			if (all_dead)
			{
				merchantos.login.allDead();
			}
		}
	},
	openIDRedirect: function(redirect)
	{
		merchantos.debug("Open ID Redirect: " + redirect);
		window.location = redirect;
	},
	loginIncorrect: function() {
		displayError("Login or password incorrect.");
		merchantos.login.unlockSubmit();
	},
	allDead: function() {
		// tell the user what to do.
		displayError('Your internet connection appears to be having trouble. <a href="https://www.Nucleusretail.com/cloud/help/general/merchantos-not-loading">Tips to resolve connection problems</a> or <a href="/help#request">contact Support for assistance</a>.',true,config.app_ui_name + ' servers unreachable');
		merchantos.login.unlockSubmit();
	},
	lockSubmit: function() {
		   $('#login').find('input[type="submit"]').attr('disabled','disabled').attr('value','Working...');
	},
	unlockSubmit: function() {
		$('#login').find('input[type="submit"]').removeAttr('disabled').attr('value','Sign In');
	}
};

function renderNotice(message,title,type,insertion_point) {
	if(!title)
		title = ''

	var id = ("error" === type ? "loginFailedMessage" : "");
	var notice = $('<div id="'+id+'" class="notice '+type+'"><h3>'+title+'</h3><p>'+message+'</p></div>');

	// Default insertion point
	if(!insertion_point)
		insertion_point = $('section:visible').find('.block');

	// Let's work on the DOM
	$('.error, .notice').remove();
	insertion_point.before(notice);
	notice.hide().fadeIn();

	return notice;
}

function displayMessage(message) {
	renderNotice(message)
}

function displayError(message,no_fadeout,title) {

	if (!title)
		title = "Error";

	notice = renderNotice(message, title, 'error')

	if (no_fadeout)
		return;

	setTimeout(function() { notice.fadeOut(); },10000);
	setTimeout(function() { notice.remove(); },11000);
}


$(document).ready(function() {
	var reset_hashkey = false;

	// On iPad w/ landscape orientation focus will jump when keyboard pop event causes
	// field movement. By resetting scroll location when initial field gets focus we're
	// able to prevent field jump. See ticket #1698.

	// If this causes weird behavior on other platforms a iOS detection could be attempted
	// before running this event but in limited testing it didn't seem to cause issues
	// elsewhere.
	$('body').one('focus','input[name="login"]', function() {
		window.scrollTo(0, 0);
	});

	// Intercept Google login event
	$('.google').click(function(event) {
		event.preventDefault();
		merchantos.login.Submit('@gmail.com','','openid_form');
		return false;
	});

	if(urlParams["error_message"]) {
		displayError(urlParams["error_message"]);
	}

	if(urlParams["redirect_after_login"])
		$('input[name="redirect_after_login"]').val(urlParams["redirect_after_login"]);

	if(urlParams["prefill_user"])
		$('input[name="login"]').val(urlParams["prefill_user"]);

	if(urlParams["prefill_pwd"])
		$('input[name="password"]').val(urlParams["prefill_pwd"]);

	if ($('#login, #resetpassword, #emailpasswordreset').length > 0) {
		if (location.hash) {
			$.each(location.hash.replace("#","").split(";"), function(index, str) {
				var param = str.split(":");
				if (param[0] == "email") {
					$("#login").find('input[name="login"]')[0].value = param[1];
					$("#login").find('input[name="password"]').focus();
				}
				if (param[0] == "hashkey") {
					reset_hashkey = param[1];
				}
			});
		}
		$.each(merchantos.regions, function(region, host) {
			$.ajax("https://" + host + "/responder.js.php",{
				dataType: "jsonp",
				timeout: 4000,
				success: function(data, textStatus, jqXHR) {
					if (data) {
						var redirect_to = "/register.php";

						var redirect_after_login = $("#login").find('input[name="redirect_after_login"]').val();
						if (redirect_after_login) {
							redirect_to = decodeURIComponent(redirect_after_login);
						}

						// user is already logged in here, so just redirect them
						window.location = "https://" + host + redirect_to;
						return;
					}
					merchantos.login.setLive(region);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					merchantos.login.setDead(host);
				}
			});
		});
	}

	$("#login").find('form').submit(function(event) {
		event.preventDefault();

		var login = $(this).find('input[name="login"]').val();
		var password = $(this).find('input[name="password"]').val()
		merchantos.login.Submit(login,password,'login_form');
		return false;
	});

	$("#resetpassword").find('form').submit(function(event) {
		event.preventDefault();
		var password1 = $(this).find('input[name="password1"]').val();
		var password2 = $(this).find('input[name="password2"]').val();

		if (!reset_hashkey) {
			displayError("Something happened to the link we sent you. Please try openning the link from your email again.");
			return false;
		}
		if (password1 != password2) {
			displayError("Please re-enter your password. Password did not match against your verification of it.");
			return false;
		}

		merchantos.login.Submit("hashkey=" + reset_hashkey,password1,'resetpassword');
		return false;
	});

	$("#emailpasswordreset").find('form').submit(function(event) {
		event.preventDefault();
		var email = $(this).find('input[name="email"]').val();

		merchantos.login.Submit("emailpasswordreset",email,'emailpasswordreset');
		return false;
	});
});

var urlParams = {};
(function () {
	var e,
		a = /\+/g,  // Regex for replacing addition symbol with a space
		r = /([^&=]+)=?([^&]*)/g,
		d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
		q = window.location.search.substring(1);

	while (e = r.exec(q))
	   urlParams[d(e[1])] = d(e[2]);
})();



lsCloud.analytics = {
	// Record takes a config object containing the attibute 
	// google_analytics_account. This is easily found in the 
	// merchantos.config global.
	record: function(config) {
		// Use jquery.pURL library to get manipuable URL object
		var url = $.url(window.location.href);
		var params = lsCloud.analytics.removeBadParams(url.param());

		// Google Analytics

		ga('send', 'pageview');

		// Tag session as Cordova if user identifies as a Cordova user.
		if(isCordova()) { ga('send', 'pageview', {'Browser Type': 'Cordova'}); }
	},

	removeBadParams: function(params) {
		delete params.id;
		delete params.redirect_after_login;
		return params;
	},

	buildUrl: function(urlObj, params) {
		return urlObj.attr('protocol') + "://" + urlObj.attr('host') + lsCloud.analytics.buildUri(urlObj,params);
	},

	buildUri: function(urlObj, params) {
		return urlObj.attr('path') + '?' + jQuery.param(params);

	}
};

jQuery.browser={};
(function(){
	jQuery.browser.msie=false;
	jQuery.browser.version=0;
	if(navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
		jQuery.browser.msie=true;jQuery.browser.version=RegExp.$1;
	}
})();

$(document).ready(function() {
	if($.browser.msie) {
	    $('body').append($('<div class="ie">').append('<iframe src="/unsupported-browser.html"></iframe>'));		
	}
})
