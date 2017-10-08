Framework7.prototype.plugins.statistics = function (app, params) {
    
	var verification = function(){
		"use strict";
		return {
			login:function(){
			}
		}
	}();
	var strings = function(){
		"use strict";
		return {
			count:function(string){
				console.log(string[0]+string[1]+"a");
		 		return string[0]+string[1]+"a";
			}
		}
	}();

    return {
        hooks: {
            appInit: function () {
            	console.log("xxx");

            	app.loginScreen();
            	$('body').particleground({
				    dotColor: '#ccc',
				    lineColor: '#ddd',
				    density:5000,
				    parallax:false
				});

            	$$("#Button").on('click',function(){
	            	var peopleList = $$("input[data-cmd='peopleList']").val().split(',');
	            	console.log(peopleList);
	            	$.each(peopleList,function(a,b){
	            		peopleList[a] = parseInt(peopleList[a]);
	            	});
            		console.log(peopleList);
            	});
            }
        }
    };
};

var $$ = Dom7;
var app = new Framework7({
	statistics:true
});

