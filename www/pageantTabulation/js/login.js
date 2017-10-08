Framework7.prototype.plugins.statistics = function (app, params) {
	var php = "harmony/Process.php?";

	var system = function(){
		"use strict";
		return {
	        searchJSON: function(obj, key, val) {
			    var objects = [];
			    for (var i in obj) {
			        if (!obj.hasOwnProperty(i)) continue;
			        if (typeof obj[i] == 'object') {
			            objects = objects.concat(this.searchJSON(obj[i], key, val));
			        } else if (i == key && obj[key] == val) {
			            objects.push(obj);
			        }
			    }
			    return objects;
			},
	        sortResults : function (data,prop, asc) {
	            data = data.sort(function(a, b) {
	                if (asc) return (a[prop] > b[prop]) ? 1 : ((a[prop] < b[prop]) ? -1 : 0);
	                else return (b[prop] > a[prop]) ? 1 : ((b[prop] < a[prop]) ? -1 : 0);
	            });
	            return data;
	        },
			ajax: function(url,data){
		        return $.ajax({
			        type: "POST",
			        url: url,
			        data: {data: data},
			        async: !1,
			        cache:false,
			        error: function() {
			            console.log("Error occured")
			        }
			    });
			},
			send_mail:function(email,message){
				var ajax = this.do_ajax('../assets/harmony/Process.php?send-mail',[email,message]);
				ajax.success(function(data){
				});
			},
			do_upload:function(url,fallback_success,fallback_error){
	            var f = document.getElementById('file'),
	                pb = document.getElementById('pb'),
	                pt = document.getElementById('pt');
	            app.uploader({
	                files: f,
	                progressBar: pb,
	                progressText: pt,
	                processor: url,
	                finished: function(data){
	                    var uploads = document.getElementById('uploads'),
	                        succeeded = document.createElement('div'),
	                        failed = document.createElement('div'),
	                        anchor,
	                        span,
	                        x,string;
	                        uploads.innerText = '';
	                        
	                        if(data.succeeded.length > 0){
	                            fallback_success(data.succeeded);                        	
	                        }
	                        if(data.failed.length > 0){
	                            fallback_error(data.failed);
	                        }
	                },
	            });
			},
			truncate: function(string, length, delimiter) {
			   delimiter = delimiter || "&hellip;";
			   return string.length > length ? string.substr(0, length) + delimiter : string;
			},
			notification:function(message,button,timeout,_functionClose){
				var timeout = (timeout == "")?false:timeout;
			    app.addNotification({
			        title: "rufongabrillojr",
			        message: message,
			        button:button,
			        onClose:function(){
					    if(_functionClose != false){
				        	_functionClose();
					    }
			        }
			    });

			    if(timeout != false){
				    setTimeout(function(){
				    	app.closeNotification(".notification-item");
				    },timeout);
			    }
			},
			pageHandler:function(){
				var href = (localStorage.getItem('page')==null)?'home.html':localStorage.getItem('page');
				system.pageLoad('../pages/'+href, function(){system.pageLoadProcess(href)});
				$$("a.item-link").on('click',function(){
					href = this.href.split('/');
					href = href[href.length - 1];
					console.log(href);
					system.pageLoad('../pages/'+href,  function(){system.pageLoadProcess(href)});
					localStorage.setItem('page',href);
				})
			},
			pageLoad:function(url,_function){
				var view = app.addView('.view-main');
				view.router.loadPage(url);

				app.onPageInit('schedulePlotter', function(){
					if(_function != false){
						_function();					
					}
				})
			},
			pageLoadProcess:function(url){
				if(url == "schedulePlotter.html"){
					sched.init();
				}
			}
		};
	}();
    
	var verification = function(){
		"use strict";
		return {
			login:function(){
            	app.loginScreen();
            	init.particleground('body');

            	$("a[data-cmd='getLogin']").on('click',function(){
            		var level = "";
            		var data = app.formToJSON("#loginData");
            		level = data['username'];
            		data = system.ajax(php+'authenticate',data);
            		if(data.responseText == 0){
            			system.notification("Sign in failed.",false,3000,false);
	            		}
            		else{
            			system.notification("Success.",false,3000,false);
            			if(level == 'administrator'){
							window.location.href='admin/';
            			}
            			else{
							window.location.href='judge/';
            			}
            		}
            	});
			}
		}
	}();

	var init = function(){
		'use strict';
		return {
			particleground:function(element){
				console.log('x');
            	$(element).particleground({
				    dotColor: '#f00',
				    lineColor: '#ddd',
				    density:5000,
				    parallax:true
				});				
			}
		}
	}();

    return {
        hooks: {
            appInit: function () {
            	verification.login();
            }
        }
    };
};

var $$ = Dom7;
var app = new Framework7({
	statistics:true,
	material:true
});


				// app.pickerModal(
				// '<div class="picker-modal">' +
				// 	'<div class="toolbar bg-red color-red theme-red">' +
				// 		'<div class="toolbar-inner">' +
				// 			'<div class="left"></div>' +
				// 			'<div class="right"><a href="#" class="close-picker">Close</a></div>' +
				// 		'</div>' +
				// 	'</div>' +
				// 	'<div class="picker-modal-inner">' +
				// 		'<div class="content-block">' +
				// 			'<p>Lorem ipsum dolor ...</p>' +
				// 		'</div>' +
				// 	'</div>' +
				// '</div>'
				// )
