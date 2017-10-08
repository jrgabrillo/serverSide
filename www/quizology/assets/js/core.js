var kaboom = function(){
	"use strict";

	return {
		ini:function(){
			$("body").append("<script>console.log('%cDeveloped By: RNR Digital Consultancy (2017) http://rnrdigitalconsultancy.com ,,|,_', 'background:#f74356;color:#64c2ec;font-size:20px;')</script>");
			$(document).ready(function(){
			    $('.tooltipped').tooltip({delay: 50});
				system.ini();
				// App.init();
			});
		}
	}
}();

var system = function(){
	"use strict";

	return {
		ini:function(){
			setTimeout(function(){
				system.loading(true);
				$('#content-login').addClass('animated slideInUp');
			},1000);
			login.ini();
		},
		ajax:function(url,data){
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
		html:function(url){
	        return $.ajax({
		        type: "POST",
		        url: url,
                dataType: 'html',
		        async: !1,
		        cache:false,
		        error: function() {
		            console.log("Error occured")
		        }
		    });
		},
		xml:function(url){
	        return $.ajax({
		        type: "POST",
		        url: url,
                dataType: 'xml',
		        async: !1,
		        cache:false
		    });
		},
		send_mail:function(email,message){
			var data = system.ajax('../assets/harmony/Process.php?send-mail',[email,message]);
			data.success(function(data){
				console.log(data);
			});
		},
		loading: function(_switch){
			if(_switch){ // show loader
				$('#loader-wrapper').addClass('animated zoomOut');
				setTimeout(function(){
					$("#loader-wrapper").addClass("hide-on-med-and-up hide-on-med-and-down");
				},1000);
			}
			else{
				setTimeout(function(){
					$("#loader-wrapper").removeClass("hide-on-med-and-up hide-on-med-and-down");
				},1000);
				$("#loader-wrapper").removeClass("zoomOut");
				$('#loader-wrapper').addClass('animated zoomIn');
			}
		},
		loader: function(_switch){
			if(_switch){ // show loader
				$(".progress").removeClass("hide-on-med-and-up hide-on-med-and-down");
				console.log('x');
			}
			else{
				$(".progress").addClass("hide-on-med-and-up hide-on-med-and-down");
				console.log('x');
			}
		},
		preloader:function(div){
			var data = system.xml("pages.xml");
			$(data.responseText).find("loader").each(function(i,content){
				// return content;
				console.log("xxx");
				$(div).html(content);
			});
		},
		block:function(status){
			if(status){
				$("#block-control").addClass('block-content')
			}
			else{
				$("#block-control").removeClass('block-content')
			}
		},
		clearForm:function(){
			$("form").find('input:text, input:password, input:file, select, textarea').val('');
			$("form").find('error').html('');
			$("form").find('input:text, input:password, input:file, select, textarea').removeClass("valid");
		    $("form").find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
		}
	}
}();

login = {
	ini:function(){
		login.page();
		login.validate();
	},
	validate:function(){
	    $("#form_login").validate({
	        rules: {
	            field_empID: {required: true,maxlength: 100},
	            field_password: {required: true,maxlength: 50},
	        },
	        errorElement : 'div',
	        errorPlacement: function(error, element) {
				var placement = $(element).data('error');
				if(placement){
					$(placement).append(error)
				} 
				else{
					error.insertAfter(element);
				}
			},
			submitHandler: function (form) {
				var _form = $(form).serializeArray();
				var data = system.ajax('assets/harmony/Process.php?login',_form);
				data.done(function(data){
					console.log(data);
					if(data !== 0){
						localStorage.setItem("hash",data);
						Materialize.toast('Success.',4000);
				    	$(location).attr('href','account/');
					}
					else{
						Materialize.toast('Cannot process request.',4000);
					}
				});
	        }
		}); 
	},
	page:function(){
		var documentHeight = $(window).height();
		$(".wrapper.overlap-gradient").attr({"style":"height:"+documentHeight+"px;margin-top: 5%;"});

		$(window).resize(function(){
			documentHeight = $(document).height();
			$(".wrapper.overlap-gradient").attr({"style":"height:"+documentHeight+"px;margin-top: 5%;"});
			console.log(documentHeight);
		});
	}
};

admin = {
	management:function(){
		var data = system.xml("pages.xml");
		$(data.responseText).find("addAccount").each(function(i,content){
			$("#modal .modal-content").html(content);
			$('#modal').openModal('show');			
		});
	},
	list:function(){
		var content = "";
		var data = system.html('../assets/harmony/Process.php?get-admin');
		data.done(function(data){
			data = JSON.parse(data);
			console.log(data[0]);
			$("#display_adminName").html(data[0][1]);
			$("#display_email").html(data[0][5]);
			$("#display_username").html(data[0][2]);
			$("#display_password").html('Active');
			$("#display_status").html('Active');
			$("#display_date").html(data[0][7]);
		});

		var data = system.html('../assets/harmony/Process.php?get-listAdmin');
		data.done(function(data){
			data = JSON.parse(data);
			$.each(data,function(i,v){
				content += "<tr>"+
							"	<td>"+v[1]+"</td>"+
							"	<td>Active</td>"+
							"	<td>Admin</td>"+
							"	<td>"+
							"		<a class='tooltipped btn-floating waves-effect black-text no-shadow grey lighten-5 right' data-position='bottom' data-delay='50' data-tooltip='Update' data-cmd='update'>"+
							"			<i class='mdi-editor-mode-edit right black-text'></i>"+
							"		</a>"+
							"	</td>"+
							"</tr>";
			})	

			content = "<table class='table bordered'>"+
						"	<tr>"+
						"		<th>Name</th><th>Status</th><th>Role</th><th></th>"+
						"	</tr>"+
							content+
						"</table>";
			$("#display_adminList").html(content);
		});
	},
	add:function(){
		var data = system.xml("pages.xml");
		$(data.responseText).find("addAccount").each(function(i,content){
			$("#display_newAdmin").html(content);
			$("#form_registerAdmin").validate({
			    rules: {
			        field_name: {required: true,maxlength: 50},
			        field_email: {required: true,maxlength: 50,checkEmail:true},
			        field_username: {required: true,maxlength: 50},
			        field_password: {required: true,maxlength: 50},
			        field_capabilities: {required: true,maxlength: 500},
			    },
			    errorElement : 'div',
			    errorPlacement: function(error, element) {
					var placement = $(element).data('error');
					if(placement){
						$(placement).append(error)
					} 
					else{
						error.insertAfter(element);
					}
				},
				submitHandler: function (form) {
					var _form = $(form).serializeArray();
					var data = system.ajax('../assets/harmony/Process.php?set-newAdmin',_form);
					data.done(function(data){
						if(data == 1){
							Materialize.toast('Saved.',4000);
							App.handleLoadPage("#cmd=index;content=account");
						}
						else{
							Materialize.toast('Cannot process request.',4000);
						}
					});
			    }
			}); 
		});
	},
}

product = {
	get:function(){
		var data = system.html('../assets/harmony/Process.php?get-products');
		return data;
	},
	list:function(){
		var content = "";
		var data = product.get();
		data = JSON.parse(data.responseText);
		$.each(data,function(i,v){
			console.log(v);
			content += "<tr>"+
						"	<td>"+(i+1)+". </td>"+
						"	<td><img src='../assets/images/img3.jpg' alt='Thumbnail' class='responsive-img valign profile-image'></td>"+
						"	<td><p style='width:200px;'>"+v[1]+"</p></td>"+
						"	<td>"+v[5]+"</td>"+
						"	<td>"+v[4]+"</td>"+
						"	<td>"+v[2]+"</td>"+
						"	<td>"+v[3]+"</td>"+
						"	<td>published</td>"+
						"	<td>"+
						"		<a class='tooltipped btn-floating waves-effect black-text no-shadow grey lighten-5 right' data-position='bottom' data-delay='50' data-tooltip='Update' data-cmd='update'>"+
						"			<i class='mdi-editor-mode-edit right black-text'></i>"+
						"		</a>"+
						"	</td>"+
						"</tr>";
		})	

		content = "<table class='table bordered' id='products'>"+
					"<thead>"+
					"	<tr>"+
					"		<th>#</th><th>Thumbnail</th><th>Product</th><th>Description</th><th>Category</th><th>Qty</th><th>Price</th><th>Status</th><th></th>"+
					"	</tr>"+
					"</thead>"+
					"</tbody>"+
						content+
					"</tbody>"+
					"</table>";
		$("#display_productList").html(content);

		var table = $('#products').DataTable({
	        "order": [[ 0, 'asc' ]],
	        // bLengthChange: false,
	        // paging: false,
	        // iDisplayLength: -1,
	        "drawCallback": function ( settings ) {
	            var api = this.api();
	            var rows = api.rows( {page:'current'} ).nodes();
	            var last=null;
	        }
	    });
	},
	listGrid:function(){
		var data = system.xml("pages.xml");
		var _content = "";
		$(data.responseText).find("product").each(function(i,content){
			console.log();
			for(x=0;x<=100;x++){
				_content += content.innerHTML;

			}
			$("#products").html(_content);
		});
	},
	add:function(){
		$("#add_product").on('click',function(){
			var data = system.xml("pages.xml");
			$(data.responseText).find("addProduct").each(function(i,content){
				$("#modal .modal-content").html(content);
				$('#modal').openModal('show');

				$("#form_addProduct").validate({
				    rules: {
				        field_productName: {required: true,maxlength: 50},
				        field_qty: {required: true,maxlength: 50,checkPositiveNumber:true},
				        field_price: {required: true,maxlength: 50,checkCurrency:true},
				        field_description: {required: true,maxlength: 900},
				        field_category: {required: true,maxlength: 500},
				    },
				    errorElement : 'div',
				    errorPlacement: function(error, element) {
						var placement = $(element).data('error');
						if(placement){
							$(placement).append(error)
						} 
						else{
							error.insertAfter(element);
						}
					},
					submitHandler: function (form) {
						var _form = $(form).serializeArray();
						var data = system.ajax('../assets/harmony/Process.php?set-newProduct',_form);
						data.done(function(data){
							if(data == 1){
								Materialize.toast('Saved.',4000);
								system.clearForm();
								App.handleLoadPage("#cmd=index;content=list_products");
							}
							else{
								Materialize.toast('Cannot process request.',4000);
							}
						});
				    }
				});
			});
		})
	},
}

client = {
	ini:function(){
		this.add();
		this.list();
	},
	get:function(){
		var data = system.html('../assets/harmony/Process.php?get-clients');
		return data;
	},
	list:function(){
		var content = "";
		var data = client.get();
		data = JSON.parse(data.responseText);
		$.each(data,function(i,v){
			console.log(v);
			content += "<tr>"+
						"	<td>"+(i+1)+". </td>"+
						"	<td><img src='../assets/images/img3.jpg' alt='Thumbnail' class='responsive-img valign profile-image'></td>"+
						"	<td><p style='width:200px;'>"+v[1]+"</p></td>"+
						"	<td>"+(Math.round((i*143/2.1)))+"</td>"+
						"	<td>Active</td>"+
						"	<td>"+
						"		<a class='tooltipped btn-floating waves-effect black-text no-shadow grey lighten-5 right' data-position='bottom' data-delay='50' data-tooltip='Update' data-cmd='update'>"+
						"			<i class='mdi-editor-mode-edit right black-text'></i>"+
						"		</a>"+
						"	</td>"+
						"</tr>";
		})	

		content = "<table class='table bordered' id='products'>"+
					"<thead>"+
					"	<tr>"+
					"		<th>#</th><th>Logo</th><th>Client</th><th># of Employees</th><th>Status</th><th></th>"+
					"	</tr>"+
					"</thead>"+
					"</tbody>"+
						content+
					"</tbody>"+
					"</table>";
		$("#display_clientList").html(content);

		var table = $('#products').DataTable({
	        "order": [[ 0, 'asc' ]],
	        // bLengthChange: false,
	        // paging: false,
	        // iDisplayLength: -1,
	        "drawCallback": function ( settings ) {
	            var api = this.api();
	            var rows = api.rows( {page:'current'} ).nodes();
	            var last=null;
	        }
	    });
	},
	listGrid:function(){
		var data = system.xml("pages.xml");
		var _content = "";
		$(data.responseText).find("product").each(function(i,content){
			console.log();
			for(x=0;x<=100;x++){
				_content += content.innerHTML;

			}
			$("#products").html(_content);
		});
	},
	add:function(){
		$("#add_client").on('click',function(){
			var data = system.xml("pages.xml");
			$(data.responseText).find("addClient").each(function(i,content){
				$("#modal .modal-content").html(content);
				$('#modal').openModal('show');		

				$("#form_addClient").validate({
				    rules: {
				        field_name: {required: true,maxlength: 50},
				        field_phone: {required: true,maxlength: 50},
				        field_email: {required: true,maxlength: 50,checkEmail:true},
				        field_address: {required: true,maxlength: 50},
				        field_description: {required: true,maxlength: 500},
				    },
				    errorElement : 'div',
				    errorPlacement: function(error, element) {
						var placement = $(element).data('error');
						if(placement){
							$(placement).append(error)
						} 
						else{
							error.insertAfter(element);
						}
					},
					submitHandler: function (form) {
						var _form = $(form).serializeArray();
						var data = system.ajax('../assets/harmony/Process.php?set-newClient',_form);
						data.done(function(data){
							if(data == 1){
								Materialize.toast('Saved.',4000);
								system.clearForm();
								App.handleLoadPage("#cmd=index;content=clients");
							}
							else{
								Materialize.toast('Cannot process request.',4000);
							}
						});
				    }
				});
			});
		})
	},
	update:function(){
		var data = system.xml("pages.xml");
		$(data.responseText).find("addClient").each(function(i,content){
			$("#modal .modal-content").html(content);
			$('#modal').openModal('show');			
		});
	}
}

points = {
	ini:function(){

	},
	upload:function(){
		var data = system.xml("pages.xml");
		$(data.responseText).find("addPoint").each(function(i,content){
			$("#modal .modal-content").html(content);
			$('#modal').openModal('show');			
		});
	},
	importFromFile_student: function(){
        var $inputImage = $("#form_addPoints");
        status = true;
        if(window.FileReader){
            $inputImage.change(function() {
				var _data = account.getStudent();
				_data = JSON.parse(_data);
                var files = this.files, file = files[0].name.split('.');
                if((file[1] == "csv") || (file[1] == "xlsx")){ // 
                	$("#displayImport").removeClass('hidden');
					$("#form_addPoints").parse({
						config: {
							complete: function(results, file) {
								var data = [],count = 0;
								for(var x=1;x<(results['data'].length-1);x++){
									data.push(results['data'][x]);
								}
				                $('#importPreview').DataTable({
				                    data: data,
				                    sort: true,
							        "order": [[ 2, 'asc' ]],
							        bLengthChange: true,
							        paging: false,
							        iDisplayLength: -1,
									sScrollY:        "300px",
									sScrollX:        "100%",
									bScrollCollapse: true,
									fixedColumns:   {
									    leftColumns: 2,
									},								        
				                    columns: [
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	count++;
				                                return count+".";
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var result = system.searchJSON(_data,'student_id',full[0]), _class='red-text';
				                   				if(result.length<=0)
				                   					_class = '';
				                            	var details = "<span class='"+_class+"'>"+full[1]+", "+full[2]+" "+full[3]+"</span>";
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = full[0];
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = full[4];
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = full[5];
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = full[9];
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = full[10];
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = full[8];
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = full[13];
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = full[14];
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = full[11];
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = full[12];
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = "Year: "+full[6]+",<br/>Section: "+full[7];
				                                return details;
				                            }
				                        }
				                    ],
				                });

				                $("#save_import").on("click",function(){
									Materialize.toast('Importing...',4000);
				                	$(this).addClass('disabled');
				                	setTimeout(function(){
										var ajax = system.get_ajax('../assets/harmony/Process.php?set-importStudent',data);
										ajax.success(function(data){
											if(data == 1){
												App.handleLoadPage(window.location.hash);
											}
											else{
												var data = JSON.parse(data);
												Materialize.toast('There was an error. '+data.length+' student(s) are not added.',4000);
											}
										});
				                	},1000);
				                });
							}
						},
						before: function(file, inputElem){
							$("#display_excelFile").html(file.name);
						},
						error: function(err, file, inputElem, reason){
							Materialize.toast("MS Excel file is corrupted.",4000);
						},
					});
                }
                else{
                	$("#displayImport").addClass('hidden');
					$("#display_excelFile").html("");
					Materialize.toast("MS Excel file is not valid. Try a CSV file.",4000);
                }
            });
        }
        else{
            $inputImage.addClass("hide");
        }	 			
	},
}

employee = {
	get:function(company){
		var data = system.html('../assets/harmony/Process.php?get-employee');
		return data;
	}
}

employer = {
	account:function(){
	},
	employees:function(){
		$("#field_addEmployee").on("change",function(data){
			var data = $(this).val();
			console.log(data);
			if(data == "Bulk upload"){
		    	$(location).attr('href','#cmd=index;content=employeeUpload');			
			}
		})
	},
	addEmployee:function(){
	},
	uploadEmployee:function(){
        var $inputImage = $("#field_file");
        status = true;
        if(window.FileReader){
            $inputImage.change(function() {
            	$("#field_file").addClass("disabled");
		    	system.preloader("#display_importLoading");
                var files = this.files, file = files[0].name.split('.');
                if((file[1] == "csv") || (file[1] == "xlsx")){ // 
					$("#field_file").parse({
						config: {
							complete: function(results, file) {
								system.loading(true);

								var data = [],count = 0;
								var employeeList = employee.get();
								employeeList = JSON.parse(employeeList.responseText);
								console.log(employeeList);

								for(var x=1;x<(results['data'].length-1);x++){
									data.push(results['data'][x]);
								}

								console.log(data);
				                $('#importPreview').DataTable({
				                    data: data,
							        "order": [[ 0, 'asc' ]],
							        deferRender:    true,
							        iDisplayLength: 100,
									sScrollY:        "300px",
									sScrollX:        "100%",
									bScrollCollapse: true,
				                    columns: [
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	count++;
				                                return count+".";
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	// var result = system.searchJSON(_data,'student_id',full[0]), _class='red-text';
				                   				// if(result.length<=0)
				                   				// 	_class = '';

				                            	// var details = "<span class='"+_class+"'>"+full[1]+", "+full[2]+" "+full[3]+"</span>";
				                            	var details = "<span>"+full[0]+"</span>";
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = "<span>"+full[2]+"</span>";
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = "<span>"+full[1]+"</span>";
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = "<span>"+full[3]+"</span>";
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = "<span>"+full[4]+"</span>";
				                                return details;
				                            }
				                        },
				                        {data: "",
				                            render: function ( data, type, full ){
				                            	var details = "<span>"+full[5]+"</span>";
				                                return details;
				                            }
				                        },
				                    ],
				                });

			                	$("#display_import").removeClass('hidden');
								$("#display_importLoading").addClass('animated zoomOut').html("");
								employer.saveUpload(data);
							}
						},
						before: function(file, inputElem){
							$("#display_excelFile").html(file.name);
						},
						error: function(err, file, inputElem, reason){
							Materialize.toast("MS Excel file is corrupted.",4000);
							$("#display_importLoading").html("");
						},
					});
                }
                else{
                	$("#display_import").addClass('hidden');
					$("#display_excelFile").html("");
					Materialize.toast("MS Excel file is not valid. Try a CSV file.",4000);
                }
            });
        }
        else{
            $inputImage.addClass("hide");
        }	 			
	},
	saveUpload:function(_data){
        $("#save_import").on("click",function(){
			Materialize.toast('Importing...',4000);
        	// $(this).addClass('disabled');
        	setTimeout(function(){
        		_data = JSON.stringify(_data);
				var data = system.ajax('../assets/harmony/Process.php?set-newBulkEmployee',_data);
				data.done(function(data){
					console.log(data);
					// if(data == 1){
					// 	Materialize.toast('Saved.',4000);
					// 	App.handleLoadPage("#cmd=index;content=account");
					// }
					// else{
					// 	Materialize.toast('Cannot process request.',4000);
					// }
				});
        	},1000);
        });
	}
}

trial = {
	hashCatcher:function(){
		var hash = window.location.hash;
		console.log(hash);
		if((hash == "#admin") || (hash == "#employer") || (hash == "#employee")){
            hash = hash.split("#"); hash = hash[1];
			localStorage.setItem("hash",hash);
	    	$(location).attr('href','account/');			
		}
		else{
			Materialize.toast('URL is not valid.',4000);
		}
	}
}

test = {
	timer:function(){
		var count = 1;
		setInterval(function(){
			test.go(count);
			count++;
			console.log("xx");
		},1000); //1200000
	},
	go:function(page_count){
		var data = system.xml("account/pages.xml");
		$(data.responseText).find("quiz_"+page_count).each(function(i,content){
			console.log(content);
			$("#display_test .test").html(content);
		});
	}	
}