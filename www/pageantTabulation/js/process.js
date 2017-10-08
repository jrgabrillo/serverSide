Framework7.prototype.plugins.tabulation = function (app, params) {
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
			pageHandler:function(main){
				var href = (localStorage.getItem('page')==null)?main:localStorage.getItem('page');
				system.pageLoad('../pages/'+href,href,function(){system.pageLoadProcess(href)});
				$$("a.item-link").on('click',function(){
					var page = localStorage.getItem('page');
					href = this.href.split('/');
					href = href[href.length - 1];
					if(href != page){
						system.pageLoad('../pages/'+href,href,function(){system.pageLoadProcess(href)});
						localStorage.setItem('page',href);
					}
				});
			},
			pageLoad:function(url,page,_function){
				var view = app.addView('.view-main');
				view.router.loadPage(url);
				app.onPageInit(page, function(){
					if(_function != false){
						_function();					
					}
				})
			},
			pageLoadProcess:function(url){
				console.log(url);
				if(url == "contestant.html"){
	            	contestant.ini();
				}
				else if(url == "criteria.html"){
	            	criteria.ini();
				}
				else if(url == "judges.html"){
	            	judge.ini();
				}
				else if(url == "signOut.html"){
	            	signOut.ini();
				}
				else if(url == "account-judges.html"){
	            	judge.ini();
				}
				else if(url == "home.html"){
	            	tabulation.ini();
				}
			},
			printDocx:function(ID){
			    var content = "<link rel='stylesheet' href='../lib/framework7/css/framework7.material.min.css'>"+
							"<link rel='stylesheet' href='../lib/framework7/css/framework7.material.colors.min.css'>"+
							"<link rel='stylesheet' href='../lib/framework7/css/my-app.css'>"+
							"<link rel='stylesheet' href='../css/md-icons.css'>"+
							"<link rel='stylesheet' href='../css/cropper.min.css'>"+
							"<link rel='stylesheet' href='../css/index.css'>"+
							"<link rel='stylesheet' href='../css/plugins/dataTables/dataTables.bootstrap.css'>"+
							"<style class='text/css'>body{padding:20px;}</style>";
			    var WinPrint = window.open('', '', 'letf=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
			    WinPrint.document.write(content+$(ID).html());
			    WinPrint.document.close();
			    WinPrint.focus();
			    WinPrint.print();
			    WinPrint.close();
			}
		};
	}();

	var calculator = function(){
		"use Strict";
		return {
			precentile:function(percentage,number){
				percentage = Number(percentage)/100;
				number = Number(number);

				return parseFloat((percentage*number)).toFixed(2);
			}
		}
	}();
    
	var init = function(){
		'use strict';
		return {
			particleground:function(element){
            	$(element).particleground({
				    dotColor: '#ccc',
				    lineColor: '#ddd',
				    density:5000,
				    parallax:false
				});				
			}
		}
	}();

	var criteria = function(){
		"use strict";
		return {
			ini:function(){
            	this.getCriteria();
            	this.setCriteria();
			},
			getCriteria:function(){
        		var data = system.ajax('../'+php+'getCriteria',data);
        		data = JSON.parse(data.responseText);
        		data = JSON.parse(data[0][1]);
        		$$.each(data,function(a,b){
        			$$("input[name='"+a+"']").val(Number(b));
        			$$("#"+a).html(Number(b)+"%");
        		})
			},
			setCriteria:function(){
				$$("input[type='range']").on("input",function(){
					$$("#"+this.name).html(this.value+"%")
				});

				$$('a[data-cmd="setCriteria"]').on('click',function(){
					var data = app.formToJSON('#criteriaData');
	        		data = system.ajax('../'+php+'setCriteria',JSON.stringify([data,'update']));
	        		if(data.responseText == 1){
            			system.notification("Saved.",false,3000,false);
	        		}
	        		else{
            			system.notification("Failed to save the new criteria.",false,3000,false);
	        		}
				});
			},
			removeCriteria:function(){

			}
		}
	}();

	var contestant = function(){
		"use strict";
		return {
			ini:function(){
            	this.getCandidate();
            	this.setCandidate();
			},
			getCandidate:function(){
				var img = "";
        		var data = system.ajax('../'+php+'getCandidate',""), name, content = "", subcontent = "";
        		data = JSON.parse(data.responseText);
        		// console.log(data.responseText);
        		$$.each(data,function(a,b){
        			subcontent = "";
        			$$.each(b[1],function(a2,b2){
	        			name = JSON.parse(b2[2]);
	        			if(b2[4] == 'avatar.jpg'){
			        		img = '../img/avatar.jpg';
	        			}
	        			else{
			        		img = system.ajax('../img/'+b2[4],"");
			        		img = img.responseText;
	        			}

	        			subcontent += "<div class='col-33'>"+
									"	<div class='card facebook-card'>"+
									"		<div class='card-content'><img src='"+img+"' width='100%'></div>"+
									"		<div class='card-header no-border'>"+
									"			Name: "+name[0]+" "+name[1]+", "+name[2]+"<br/>"+
									"			Age: "+b2[3]+
									"		</div>"+
									"		<div class='card-content-inner no-border'>"+
									"			"+b2[5]+
									"		</div>"+
									"		<div class='card-footer no-border'>"+
									"			<a href='#' class='link' data-cmd='delete' data-key='"+b2[0]+"' title='Delete'><i class='zmdi zmdi-delete'></i></a>"+
									"		</div>"+ 
									"	</div>"+
									"</div>";
        			});
        			content += "<div class='col-50'>"+
								"    <div class='card'>"+
								"        <div class='card-header'>"+b[0]+"</div>"+
								"        <div class='row'>"+subcontent+"</div>"+
								"    </div>"+
								"</div>";

        		});
        		$$("#contestantList").html(content);

        		$$("a[data-cmd='delete']").on('click',function(){
        			var _this = this;
        			contestant.removeCandidate(_this.dataset.key,function(){
        				contestant.getCandidate(1);
        				contestant.getCandidate(2);
        			});
        		});
			},
			setCandidate:function(){
        		var content = system.ajax('../pages/formContestant.html',"");
        		content = content.responseText;

				app.onPageInit('contestant.html',function(){
					$$("a[data-cmd='addCandidate']").on("click",function(){
						app.popup(content);
			            var $inputImage = $("#inputImage");
			            var status = true;
			            if(window.FileReader){
			                $inputImage.change(function() {
			                    var fileReader = new FileReader(),
			                            files = this.files,
			                            file;

			                    file = files[0];

			                    if (/^image\/\w+$/.test(file.type)) {
			                        fileReader.readAsDataURL(file);
			                        fileReader.onload = function () {
			                            $inputImage.val("");

							            var $image = $(".image-crop > img")
							            $($image).cropper({
							            	aspectRatio: 1/1,
										    autoCropArea: 0.80,
										    preview: ".avatar-preview",
										    built: function () {
						    		    		$(".cropper-container").css({'left':'0px !important;'});
										    	$("button[data-cmd='cancel']").removeClass('hidden');
										    	$("button[data-cmd='save']").removeClass('hidden');
										    	$("button[data-cmd='rotate']").removeClass('hidden');

									            $("button[data-cmd='save']").click(function(){			
									            	$$("textarea[name='contestantPicture']").html($image.cropper("getDataURL"));
									            	$$(".image-crop img").removeClass('cropper-hidden');
									            	$$(".image-crop .cropper-container").html('');
									            	$$(".image-crop .cropper-container").attr({style:''});
									            	$$(".image-crop img").attr({src:$image.cropper("getDataURL")});
									            	$$("button[data-cmd='rotate'],button[data-cmd='save']").addClass('hidden');
									            });
										    }
										});

			                            $image.cropper("reset", true).cropper("replace", this.result);

							            $("button[data-cmd='rotate']").click(function(){
							            	var data = $(this).data('option');
								        	$image.cropper('rotate', data);
							            });
							            $("button[data-cmd='cancel']").click(function(){
							            	$$("textarea[name='contestantPicture']").html('no-image');
							            	$$(".image-crop img").removeClass('cropper-hidden');
							            	$$(".image-crop .cropper-container").html('');
							            	$$(".image-crop .cropper-container").attr({style:''});
							            	$$(".image-crop img").attr({src:'../img/avatar.jpg'});
							            	$$("button[type='button']").addClass('hidden');
							            });

			                        };
			                    }
			                    else{
			                        showMessage("Please choose an image file.");
			                    }
			                });
			            }
			            else{
			                $inputImage.addClass("hide");
			            }	            

						$$("a[data-cmd='saveContestant']").click(function(){
							app.popup('close-popup');
							var data = app.formToJSON("#candidateForm");
			        		data = system.ajax('../'+php+'setCandidate',data);
			        		if(data.responseText == 1){
			        			system.notification("Success.",false,10000,false);
			        			contestant.getCandidate();
			        		}
			        		else{
			        			system.notification("Failed to save contestant.",false,3000,false);
			        		}
						});
					});
				});
			},
			removeCandidate:function(id,_function){
				app.confirm("Are you sure you want to delete this candidate?", 'Delete', 
					function () {
		        		var data = system.ajax('../'+php+'deleteContestant',id);			
		        		// console.log(data.responseText);        		
	            		if(data.responseText == 0){
	            			system.notification("Failed. There was an error removing "+name+".",false,3000,false);
	            		}
	            		else{
	            			system.notification("Success. "+name+" has been removed.",false,3000,false);
							if(_function != false){
								_function();
							}
	            		}
					}
				);
			},
		}
	}();

	var judge = function(){
		"use strict";
		return {
			ini:function(){
				var category = (localStorage.getItem('category')==null)?'faculty':localStorage.getItem('category');
            	this.handleCategory(category);

				if(category == 'faculty'){
	            	this.getJudges();
	            	this.setJudge();
				}
				else{
	            	this.listContestants(category); 
				}
			},
			getJudges:function(){
				var img = "";
        		var data = system.ajax('../'+php+'getJudeges',""), name, content = "", subcontent = "";
        		data = JSON.parse(data.responseText);
        		$$.each(data,function(a,b){
        			img = b[3];
        			content += "<div class='col-20'>"+
								"	<div class='card facebook-card'>"+
								"		<div class='card-content'><img src='../img/"+img+"' width='100%'></div>"+
								"		<div class='card-header no-border'>"+
								"			Name: "+b[1]+"<br/>"+
								"		</div>"+
								"		<div class='card-content-inner no-border'>"+
								"			"+b[4]+
								"		</div>"+
								"		<div class='card-footer no-border'>"+
								"			<a href='#' class='link' data-cmd='delete' data-key='"+b[0]+"' title='Delete'><i class='zmdi zmdi-delete'></i></a>"+
								"			<a href='#' class='link' data-cmd='show-access-code' data-key='"+b[0]+"' title='Show access code'><i class='zmdi zmdi-code'></i></a>"+
								"		</div>"+ 
								"	</div>"+
								"</div>";

        		});
        		$$("#judgeList").html(content);

        		$$("a[data-cmd='delete']").on('click',function(){
        			var _this = this;
        			judge.removeJudge(_this.dataset.key,function(){
        				judge.getJudges();
        			});
        		});

        		$$("a[data-cmd='show-access-code']").on('click',function(){
        			var _this = this;
        			$$(".modal .input-field").html("cc");
        			app.prompt("Please enter the Administrator's Password to get the access code.",function(value){
		        		var data = system.ajax('../'+php+'getJudegeAccess',[value,_this.dataset.key]);
		        		console.log(data.responseText);
		        		if(data.responseText != '0'){
			        		data = JSON.parse(data.responseText);
		        			app.alert("Judge's access code is: "+data[0][2]);
		        		}
		        		else{
		        			app.alert("You entered a wrong administrator's password.");
		        		}
        			});
        		});
			},
			getJudgeInfo:function(){
				var status = 1;
            	var data = signOut.isSignIn();
        		data = system.ajax('../'+php+'getJudgeInfo',data[1][1]);
        		data = JSON.parse(data.responseText);
        		return data[0];
			},
			setJudge:function(){
        		var content = system.ajax('../pages/formJudge.html',"");
        		content = content.responseText;

				app.onPageInit('judges.html',function(){
					$$("a[data-cmd='addJudge']").on("click",function(){
						app.popup(content);            

						$$("a[data-cmd='saveJudge']").click(function(){
							var data = app.formToJSON("#judgeForm");
			        		data = system.ajax('../'+php+'setJudge',data);

			        		if(data.responseText == 1){
			        			system.notification("Success.",false,10000,false);
			        			judge.getJudges();
			        		}
			        		else{
			        			system.notification("Failed to save contestant.",false,3000,false);
			        		}
						});
					});
				});
			},
			removeJudge:function(id,_function){
				app.confirm("Are you sure you want to delete this judge?", 'Delete', 
					function () {
		        		var data = system.ajax('../'+php+'deleteJudge',id);			        		
	            		if(data.responseText == 0){
	            			system.notification("Failed. There was an error removing "+name+".",false,3000,false);
	            		}
	            		else{
	            			system.notification("Success. "+name+" has been removed.",false,3000,false);
							if(_function != false){
								_function();
							}
	            		}
					}
				);
			},
			handleCategory:function(category){
				$$("#category span").html(category);
				$$("#category a").on('click',function(){
					$$("a[data-cmd='category']").on('click',function(){
						$$("#category span").html(this.dataset.key);
						localStorage.setItem('category',this.dataset.key);
		            	judge.listContestants(this.dataset.key);
					});
				});
			},
			hanldeGrading:function(){
				$$("input[type='range']").on("input",function(){
					$$("."+this.name+"_"+this.dataset.key).html(this.value+"%")
				});

				$$('a[data-cmd="saveGrade"]').on('click',function(){
					var judge = this.dataset.judge, key = this.dataset.key;
					var data = app.formToJSON('#'+key);
	        		data = system.ajax('../'+php+'saveGrade',JSON.stringify([key,judge,data]));
	        		console.log(data.responseText);
	        		if(data.responseText == 1){
            			system.notification("Saved.",false,3000,false);
	        		}
	        		else{
            			system.notification("Failed to save.",false,3000,false);
	        		}
				});
			},
			listContestants:function(category){
				var judgeInfo = judge.getJudgeInfo();
				var data = (judgeInfo == undefined)?system.ajax('../'+php+'getCandidate',""):system.ajax('../'+php+'getCandidateWithScores',judgeInfo[0]);
        		var name, content = "",img,form,scores;
        		data = JSON.parse(data.responseText);
				$$.each(data,function(a,b){
					if(category == b[0]){
						$$.each(b[1],function(a1,b1){
							scores = "";
		        			if(b1[0][4] == 'avatar.jpg'){
				        		img = '../img/avatar.jpg';
		        			}
		        			else{
				        		img = system.ajax('../img/'+b1[0][4],"");
				        		img = img.responseText;
		        			}
		        			name = JSON.parse(b1[0][2]);
		        			name = name[2]+" "+name[0]+", "+name[1];

		        			if(b1[1].length>0){
		        				scores = JSON.parse(b1[1][4]);
		        			}
		        			else{
		        				scores = {"sliderAudienceResponce":"0","sliderStageAppearance":"0","sliderCreativity":"0","sliderCoordination":"0"};
		        			}

			        		form = "<div class='list-block inputs-list swiper-no-swiping' style='margin-top: 0px !important;'>"+
									"    <ul>"+
									"        <li class='item-content'>"+
									"            <div class='item-inner'>"+
									"                <div class='item-title label'>Audience Response / Entertainment Value<div class='sliderAudienceResponce_"+a1+"' class='color-black right'>"+scores['sliderAudienceResponce']+"%</div></div>"+
									"                <div class='item-input'>"+
									"                    <div class='range-slider'>"+
									"                        <input type='range' min='0' max='100' value='"+scores['sliderAudienceResponce']+"' step='1' name='sliderAudienceResponce' data-key='"+a1+"'>"+
									"                    </div>"+
									"                </div>"+
									"            </div>"+
									"        </li>"+
									"        <li class='item-content'>"+
									"            <div class='item-inner'>"+
									"                <div class='item-title label'>Stage Appearance and Presence<div class='sliderStageAppearance_"+a1+"' class='color-black right'>"+scores['sliderStageAppearance']+"%</div></div>"+
									"                <div class='item-input'>"+
									"                    <div class='range-slider'>"+
									"                        <input type='range' min='0' max='100' value='"+scores['sliderStageAppearance']+"' step='1' name='sliderStageAppearance' data-key='"+a1+"'>"+
									"                    </div>"+
									"                </div>"+
									"            </div>"+
									"        </li>"+
									"        <li class='item-content'>"+
									"            <div class='item-inner'>"+
									"                <div class='item-title label'>Creativity / Originality<div class='sliderCreativity_"+a1+"' class='color-black right'>"+scores['sliderCreativity']+"%</div></div>"+
									"                <div class='item-input'>"+
									"                    <div class='range-slider'>"+
									"                        <input type='range' min='0' max='100' value='"+scores['sliderCreativity']+"' step='1' name='sliderCreativity' data-key='"+a1+"'>"+
									"                    </div>"+
									"                </div>"+
									"            </div>"+
									"        </li>"+
									"        <li class='item-content'>"+
									"            <div class='item-inner'>"+
									"                <div class='item-title label'>Organization / Coordination<div class='sliderCoordination_"+a1+"' class='color-black right'>"+scores['sliderCoordination']+"%</div></div>"+
									"                <div class='item-input'>"+
									"                    <div class='range-slider'>"+
									"                        <input type='range' min='0' max='100' value='"+scores['sliderCoordination']+"' step='1' name='sliderCoordination' data-key='"+a1+"'>"+
									"                    </div>"+
									"                </div>"+
									"            </div>"+
									"        </li>"+
									"    </ul>"+
									"</div>";

							content += "<div class='swiper-slide' data-swiper-autoplay='1000'>"+
										"	<div class='content-block' style='margin-left:100px;margin-right:100px;'>"+
										"		<div class='row'>"+
										"			<div class='col-40'>"+
										"				<div class='card facebook-card'>"+
										"					<div class='card-content'><img src='"+img+"' width='100%'></div>"+
										"					<div class='card-header no-border'>"+
										"						Name: "+name+"<br/>"+ 
										"					</div>"+
										"					<div class='card-content-inner no-border'>"+
										"						"+b1[0][5]+
										"					</div>"+
										"				</div>"+
										"			</div>"+
										"			<div class='col-60'><form id='"+b1[0][0]+"'>"+form+"<a href='#' data-judge='"+judgeInfo[0]+"' data-cmd='saveGrade' data-key='"+b1[0][0]+"' class='button'>Save</a></form></div>"+
										"		</div>"+
										"	</div>"+
										"</div>";
						})
					}
				});
				content = "<div class='swiper-pagination'></div>"+
							"<div class='swiper-wrapper'>"+content+"</div>"+
							"<div class='swiper-button-prev'></div>"+
							"<div class='swiper-button-next'></div>";

				$$(".swiper-container").html(content);
				var swiper = app.swiper(".swiper-container",{
					// loop:true,
					speed: 400,
				    spaceBetween: 100,
				    effect:'cube',
				    cube:{
				    	slideShadows: true,
						shadow: false,
				    },
				    grabCursor:true,
				    shortSwipes:true,
				    keyboardControl:true,
				    pagination:'.swiper-container .swiper-pagination',
				    paginationClickable:true,
				    nextButton:'.swiper-container .swiper-button-next',
				    prevButton:'.swiper-container .swiper-button-prev',
				    simulateTouch:false
				    noSwiping:true,
				    noSwipingClass:'swiper-no-swiping'
				});
				$$.each(data,function(a,b){
					if(category == b[0]){
						$$.each(b[1],function(a1,b1){
		        			if(b1[0][4] == 'avatar.jpg'){
				        		img = '../img/avatar.jpg';
		        			}
		        			else{
				        		img = system.ajax('../img/'+b1[0][4],"");
				        		img = img.responseText;
		        			}		        			
		        			name = JSON.parse(b1[0][2]);
							$$(".swiper-container .swiper-pagination .swiper-pagination-bullet:nth-child("+(a1+1)+")").html("<img src='"+img+"' width='100%'>");
							$$(".swiper-container .swiper-pagination .swiper-pagination-bullet:nth-child("+(a1+1)+")").attr({title:name[2]+" "+name[0]});
						})
					}
				});

				this.hanldeGrading();
			}
		}
	}();

	var tabulation = function(){
		"use strict";
		return {
			ini:function(){
				this.check();
				this.retrieve();
			},
			retrieve:function(){
        		var content = "", subContent = "", judgesContents = "", print_judgesContents = "", judgesSubContents = "",tabulationContent ="", tabulationSubContent = "", print_tabulationSubContent = "";
        		var contestantRows = "", print_contestantRows = "", subheaderCriteria = "";
        		var total = 0, subTotal = 0;
        		var data = system.ajax('../'+php+'getJudegesScores',"");
        		data = JSON.parse(data.responseText);
        		var criteria = JSON.parse(data[0]);
        		var judges = data[1];

        		$$.each(data[2],function(a,b){
	       			subContent = "";
	       			contestantRows = "";
	       			print_contestantRows = "";
        			$$.each(b[1],function(a2,b2){
						print_judgesContents = "";
						judgesContents = "";
						subheaderCriteria = "";
						tabulationSubContent = "";
						print_tabulationSubContent = "";
		       			total = 0;
	   					$$.each(judges,function(i1,v1){
	   						judgesContents += "<th rowspan='1' colspan='5'>"+v1[0]+"</th>";
	   						print_judgesContents += "<th rowspan='1' colspan='1'>"+v1[0]+"</th>";

							subheaderCriteria += "<th>"+criteria['sliderAudienceResponce']+"%</th>";
							subheaderCriteria += "<th>"+criteria['sliderStageAppearance']+"%</th>";
							subheaderCriteria += "<th>"+criteria['sliderCreativity']+"%</th>";
							subheaderCriteria += "<th>"+criteria['sliderCoordination']+"%</th>";
							subheaderCriteria += "<th>Total</th>";

		        			$$.each(b2[1],function(a3,b3){
		        				if(b3.length>2){
			        				if(v1[0] == b3[4]){
		       							var tabulation = JSON.parse(b3[0]);
		       							var audience = calculator.precentile(criteria['sliderAudienceResponce'],tabulation['sliderAudienceResponce']);
		       							var appearance = calculator.precentile(criteria['sliderStageAppearance'],tabulation['sliderStageAppearance']);
		       							var creativity = calculator.precentile(criteria['sliderCoordination'],tabulation['sliderCoordination']);
		       							var coordination = calculator.precentile(criteria['sliderCreativity'],tabulation['sliderCreativity']);
	       								subTotal = Number(audience)+Number(appearance)+Number(creativity)+Number(coordination);

	       								tabulationSubContent += "<td align='center'>"+audience+"</td>";
	       								tabulationSubContent += "<td align='center'>"+appearance+"</td>";
	       								tabulationSubContent += "<td align='center'>"+creativity+"</td>";
	       								tabulationSubContent += "<td align='center'>"+coordination+"</td>";
	       								tabulationSubContent += "<td align='center'>"+parseFloat(subTotal).toFixed(2)+"</td>";
	       								print_tabulationSubContent += "<td align='center'>"+parseFloat(subTotal).toFixed(2)+"</td>";
					        			total = total + subTotal;
			        				}
		        				}
		        				else{
		        					$$.each(b3,function(_a3,_b3){
				        				if(v1[0] == _b3[1]){
		       								tabulationSubContent += "<td></td>";
		       								tabulationSubContent += "<td></td>";
		       								tabulationSubContent += "<td></td>";
		       								tabulationSubContent += "<td></td>";
		       								tabulationSubContent += "<td></td>";
		       								print_tabulationSubContent += "<td align='center'></td>";
				        				}
		        					})
		        				}
		        			});
	        			});

	    				var names = JSON.parse(b2[0][1]);
						contestantRows += "<tr>"+
											"	<td align='center'>"+parseFloat(total/judges.length).toFixed(2)+"</td>"+
											"	<td>"+(a2+1)+"</td>"+
											"	<td>"+names[0]+" "+names[2]+"</td>"+tabulationSubContent+
											"	<td align='center'>"+parseFloat(total/judges.length).toFixed(2)+"</td>"+
											"</tr>";

						print_contestantRows += "<tr>"+
											"	<td align='center'>"+parseFloat(total/judges.length).toFixed(2)+"</td>"+
											"	<td>"+(a2+1)+"</td>"+
											"	<td>"+names[0]+" "+names[2]+"</td>"+print_tabulationSubContent+
											"	<td align='center'>"+parseFloat(total/judges.length).toFixed(2)+"</td>"+
											"</tr>";
        			});

        			content += "<div class='col-100 students'>"+
        						"	<div class='card facebook-card'>"+
        						"		<div class='card-content-inner row'>"+b[0]+
        						"			<div class='col-10'>"+
        						"				<a href='#' class='button right item-link button-fill color-blue' data-cmd='print-result' data-key='"+b[0]+"'>Print</a>"+
        						"			</div>"+
        						"		</div>"+
        						"		<div class='card-footer'>"+
								"			<table class='dataTable display striped bordered' border='1'>"+
								"				<thead>"+
								"					<tr>"+
								"						<th rowspan='2'>Rank</th>"+
								"						<th rowspan='2'>#</th>"+
								"						<th rowspan='2'>Contestant</th>"+
														judgesContents+
								"						<th rowspan='2'>Total</th>"+
								"					</tr>"+
								"					<tr>"+
														subheaderCriteria+
								"					</tr>"+
								"				</thead>"+
								"				<tbody>"+
													contestantRows+
								"				</tbody>"+
								"			</table>"+
        						"		</div>"+
        						"		<div class='card-footer row center hidden' id='print_"+b[0]+"'>"+
        						"			<div class='col-100'><h1>OFFICIAL RESULT<br/><h3>"+b[0]+" CATEGORY</h2></h1></div>"+
        						"			<div class='col-100'>"+
								"				<table class='print_dataTable display striped bordered center' border='1' style='width:500px !important'	>"+
								"					<thead>"+
								"						<tr>"+
								"							<th>Rank</th>"+
								"							<th>#</th>"+
								"							<th>Contestant</th>"+
															print_judgesContents+
								"							<th>Total</th>"+
								"						</tr>"+
								"					</thead>"+
								"					<tbody>"+
														print_contestantRows+
								"					</tbody>"+
								"				</table>"+
								"				<table class='display striped bordered center' style='width:800px !important; margin: 0 auto; padding-top:100px;'>"+								
								"					<tr>"+											
								"						<td colspan='5'>Judges:</td>"+
								"					</tr>"+											
													print_judgesContents+											
								"				</table>"+
								"				<table class='display striped bordered center' style='width:200px !important; margin: 0 auto; padding-top:100px;'>"+
								"					<tr>"+											
								"						<td align='center'><u>RUFO N. GABRILLO JR</u><br/>TABULATOR</td>"+
								"					</tr>"+											
								"				</table>"+
        						"			</div>"+	
        						"		</div>"+
        						"	</div>"+
        						"</div>";
        		});

        		$$("#tabulationContent .row").html(content);

				var table = $('.dataTable').DataTable({
			        "columnDefs": [
			            { "visible": false, "targets": 0 }
			        ],
			        "order": [[ 0, 'desc' ]],
			        bLengthChange: false,
			        paging: false,
			        iDisplayLength: -1,
			    });

				var table = $('.print_dataTable').DataTable({
			        "columnDefs": [
			            { "visible": false, "targets": 0 }
			        ],
			        "order": [[ 0, 'desc' ]],
			        bLengthChange: false,
			        paging: false,
			        filter:false,
			        info:false,
			        iDisplayLength: -1,
			    });	

			   tabulation.handlePrint();
        		//JSON is ready, show the scores in table
        		// must handle printing
			},
			handlePrint:function(){
				$$("a[data-cmd='print-result']").on('click',function(){
					var key = this.dataset.key;
					system.printDocx("#print_"+key);
					// $("#print_"+key).printArea();
				})
			},
			check:function(){
				tabulation.retrieve();
				setTimeout(function(){
					tabulation.check();
				},5000);
			}
		}
	}();

	var signOut = function(){
		"use strict";
		return {
			ini:function(){
        		var data = system.ajax('../'+php+'signout',"");
        		if(data.responseText==1){
        			localStorage.removeItem('page');
        			window.location.href='../';
        		}
        		else{
        			app.alert('Unable sign out.','Notice');
        		}
			},
			isSignIn:function(_function){
				var status = 1;
        		var data = system.ajax('../'+php+'isSignIn',"");
        		data = JSON.parse(data.responseText);
        		if(data.length<=0){
        			status = 0;
        		}
        		return [status,data['data']];
			},
		}
	}();

    return {
        hooks: {
            appInit: function () {
            	console.log("xx");
            	var data = signOut.isSignIn();
            	if(data[0] == 1){
            		if(data[1][0] == 'judge'){
		            	system.pageHandler('account-judges.html');
            		}
            		else{
		            	system.pageHandler('home.html');
            		}
					// var swiper = app.swiper('.swiper-container', {
					//   pagination: '.swiper-pagination',
					//   paginationHide: false,
					//   paginationClickable: true,
					//   nextButton: '.swiper-button-next',
					//   prevButton: '.swiper-button-prev',
					// });            		
            	}
            	else{
            		window.location.href = '../';
            	}
            }
        }
    };
};

var $$ = Dom7;
var app = new Framework7({
	tabulation:true,
	material:true
});
 
(function () {
    var ID = "tooltip", CLS_ON = "tooltip_ON", FOLLOW = true,
    DATA = "_tooltip", OFFSET_X = -60, OFFSET_Y = -40,
    showAt = function (e) {
        var ntop = e.pageY + (e.currentTarget.clientHeight/2), nleft = e.pageX - (e.currentTarget.clientWidth/2);
        $("." + ID).html($(e.target).data(DATA)).css({'top': ntop, 'left': nleft
        }).show();
    };
    $(document).on("mouseenter", "*[title]", function (e) {
        $(this).data(DATA, $(this).attr("title"));
        $(this).removeAttr("title").addClass(CLS_ON);
        $("<div class='" + ID + "' />").appendTo("body");
        showAt(e);
    });
    $(document).on("mouseleave", "." + CLS_ON, function (e) {
        $(this).attr("title", $(this).data(DATA)).removeClass(CLS_ON);
        $("." + ID).remove();
    });
    if (FOLLOW) { $(document).on("mousemove", "." + CLS_ON, showAt); }
}());