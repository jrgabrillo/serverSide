function TimeBackup(Hours,Minutes,Seconds){
	var DBTimer = setInterval(function(){
		Seconds++;
		if(Seconds>59){
			Seconds=0; Minutes++;
			if(Minutes>59){
				Minutes=0; Hours++;
				if(Hours>23){
					Hours=0;
				}
			}
		}
		if(Hours===15&&Minutes===59&&Seconds===0){
			 Modal_Alert("Database","Database is about to back up in just a minute.");
		}
		if(Hours===16&&Minutes===0&&Seconds===0){
			 Modal_Alert("Database","Database back up is on process.");
		}
		$("#Timely").html(Hours+':'+Minutes+':'+Seconds);
	},1000);
	return false;
}

function ModalConfirmations(Message){
    $("#ModalConfirmation").modal("show");
    $("#Text_ModalConfirmation").html(Message);
}

function ModalAlert(Message){
    $("#ModalAlert").modal("show");
    $("#Text_ModalAlert").html(Message);
}

$(document).ready(function(e) {

	$.post("../Cashier/Cashier.php?Time",function(Clock){
		var Clock = Clock.split(" "), Time = Clock[1].split(":");
		Hours = Number(Time[0]), Minutes = Number(Time[1]), Seconds = Number(Time[2]);
		TimeBackup(Hours,Minutes,Hours);
	});

	var URL = window.location;
	$.post("Admin.php?FacultyList",{},function(Data){
		$("#FacultyList").html(Data);
	});	 	

	$.post("Admin.php?FeeList",{},function(Data){
		$("#FeeList").html(Data);
	});	 	

	$.post("Admin.php?CutOffForm",{},function(Data){
		$("#CutoffForm").html(Data);
	    $("#LockDate").pickadate({
	        disable:[1,7,{from: [1900,12,31], to: true }],
	        max:365,
	        format: 'yyyy-mm-dd',
	        clear:false
	    });
		$("#LockDate").change(function(){
			$.post("Admin.php?SetCutOff",{Data:$("#LockDate").val()},function(Data){
				$("#LockDate").val("Cut off is being set...");
				if(Data == 1)
					window.location = URL.pathname;
				else
					ModalAlert("An error occured while setting the cut off date. Please refer to the developer.");

			})
		})
	});	 	

	$.post("Admin.php?EnrolmentCutOffForm",{},function(Data){
		$("#EnrolmentCutoffForm").html(Data);
	    $("#EnrolmentLockDate").pickadate({
	        disable:[1,7,{from: [1900,12,31], to: true }],
	        max:365,
	        format: 'yyyy-mm-dd',
	        clear:false
	    });
		$("#EnrolmentLockDate").change(function(){
			$.post("Admin.php?SetEnrolmentCutOff",{Data:$("#EnrolmentLockDate").val()},function(Data){
				$("#EnrolmentLockDate").val("Cut off is being set...");
				if(Data == 1)
					window.location = URL.pathname;
				else
					ModalAlert("An error occured while setting the cut off date. Please refer to the developer.");

			})
		})
	});	 	


	$("#ButtonFacultyAdd").click(function(){
		$("#ButtonFacultyAdd").addClass("hidden");
		$("#FacultyForm").removeClass("hidden");
	})

	$("#CancelAddFaculty").click(function(){
		$("#ButtonFacultyAdd").removeClass("hidden");
		$("#FacultyForm").addClass("hidden");
		$("#ErrorFaculty").addClass("hidden");
	})

	$("body").click(function(event){
		var Hash = event.target.hash, URL = window.location;
        if(typeof Hash !== "undefined" && Hash !== ""){
        	var Hashes = Hash.split("#")
			if(Hashes[1] === "UKey"){
				if(Hashes[3] === "1")
					User = "Administrator";
				else if(Hashes[3] === "2")
					User = "Registrar";
				else if(Hashes[3] === "3")
					User = "Assessment";
				else if(Hashes[3] === "4")
					User = "Cashier";
				else
					User = "Faculty";
				$("#UserIdentity").html("Updating "+User);
				$("#PasswordField").val("");
				$("#UpdatePassword").addClass('disabled');
				$("#PasswordManagementForm").removeClass('hidden');
				$("#PasswordNotification").addClass('hidden');

				var Key = Hashes[2];
				$("#Modal_PasswordManager").modal('show');

				$("#UpdatePassword").click(function(){
					var Data = Array(Hashes[2],$("#PasswordField").val());
					$.post("Admin.php?Update",{Data:Data},function(Data){
						$("#PasswordManagementForm").addClass('hidden');
						$("#PasswordNotification").removeClass('hidden');
						if(Data == 1){
							$("#PasswordNotification").html("<div class='alert alert-success'>Password has been changed.</div>");
						}
						else{
							$("#PasswordNotification").html("<div class='alert alert-danger'>An error occured during the alteration of password.</div>");
						}
						console.log(Data)
					});
				})
			}
			else if(Hashes[1] === "UFee"){
				$("#Modal_FeeManager").modal('show');
				$("#FeeIdentity").html("Updating "+Hashes[2]+" fee");

				$.post("Admin.php?FeeForm",{},function(Data){
					$("#FeeForm").html(Data);
					var a2=0,b2=0;
	
					$("#RegularField").val(Hashes[3]);
					$("#InternationalField").val(Hashes[4]);
	
				    $("#RegularField").keyup(function(){
				        var SentData = $("#RegularField").val();
				        if(SentData === ""){
				            $("#ErrorRegular").html("<i class='glyphicon glyphicon-remove'></i>");
							a2=1;
				            var Fields = Array(a2,b2);
				            Validate(Fields,$("#FeeUpdateButton"));
				        }
				        else{
							$.post("../Registrar/Validation.php?ValidateFee",{DataInput:SentData},function(Data){
								if(Data == 0){
									a2 = 0;
									$("#ErrorRegular").html("<i class='glyphicon glyphicon-ok'></i>");
								}
								else{
									a2 = 1;
									$("#ErrorRegular").html("<i class='glyphicon glyphicon-remove'></i>");
								} 
					            var Fields = Array(a2,b2);
					            Validate(Fields,$("#FeeUpdateButton"));
							});
				        }
				    })

				    $("#InternationalField").keyup(function(){
				        var SentData = $("#InternationalField").val();
				        if(SentData === ""){
				            $("#ErrorInternational").html("<i class='glyphicon glyphicon-remove'></i>");
							b2=1;
				            var Fields = Array(a2,b2);
				            Validate(Fields,$("#FeeUpdateButton"));
				        }
				        else{
							$.post("../Registrar/Validation.php?ValidateFee",{DataInput:SentData},function(Data){
								if(Data == 0){
									b2 = 0;
									$("#ErrorInternational").html("<i class='glyphicon glyphicon-ok'></i>");
								}
								else{
									b2 = 1;
									$("#ErrorInternational").html("<i class='glyphicon glyphicon-remove'></i>");
								} 
					            var Fields = Array(a2,b2);
					            Validate(Fields,$("#FeeUpdateButton"));
							});
				        }
				    })

					$("#FeeUpdateButton").click(function(){
						var UpdateKey = Array(Hashes[2],$("#RegularField").val(),$("#InternationalField").val());
						$.post("Admin.php?UpdateFee",{Data:UpdateKey},function(Data){
							$("#FeeManagementForm").addClass('hidden');
							$("#FeeNotification").removeClass('hidden');
							if(Data == 1){
								$.post("Admin.php?FeeList",{},function(Data){
									$("#FeeList").html(Data);
									$("#FeeNotification").html("<div class='alert alert-success'>Fee has been changed.</div>");
								});	 	
							}
							else{
								$("#FeeNotification").html("<div class='alert alert-danger'>Fee has not been changed.</div>");
							}
						});	 	
					})
				})
			}
			else if(Hashes[1] === "DFee"){
			    ModalConfirmations("You are about to delete the "+Hashes[2]+". Do you want to proceed?");
			    $("#Button_Execute").click(function(){
					$.post("Admin.php?DeleteFee",{Data:Hashes[2]},function(Data){
						if(Data == 1){
							$.post("Admin.php?FeeList",{},function(Data){
								$("#ModalConfirmation").modal('hide');				
								$("#FeeList").html(Data);
								ModalAlert("Fee Deleted.")	
							});	 	
						}
					})
			    });
			}
			else if(Hashes[1] === "AddFee"){
				$("#Modal_FeeManager").modal('show');

				$.post("Admin.php?FeeForm",{},function(Data){
					$("#FeeForm").html(Data);
					$("#FeeFormField").removeClass("hidden");
					$("#FeeManagementForm").removeClass('hidden');
					$("#FeeNotification").addClass('hidden');					
					$("#FeeUpdateButton").val('Add');

					var a2=1,b2=1,c2=1;
				    $("#RegularField").keyup(function(){
				        var SentData = $("#RegularField").val();
				        if(SentData === ""){
				            $("#ErrorRegular").html("<i class='glyphicon glyphicon-remove'></i>");
							a2=1;
				            var Fields = Array(a2,b2,c2);
				            Validate(Fields,$("#FeeUpdateButton"));
				        }
				        else{
							$.post("../Registrar/Validation.php?ValidateFee",{DataInput:SentData},function(Data){
								if(Data == 0){
									a2 = 0;
									$("#ErrorRegular").html("<i class='glyphicon glyphicon-ok'></i>");
								}
								else{
									a2 = 1;
									$("#ErrorRegular").html("<i class='glyphicon glyphicon-remove'></i>");
								} 
					            var Fields = Array(a2,b2,c2);
					            Validate(Fields,$("#FeeUpdateButton"));
							});
				        }
				    })

				    $("#InternationalField").keyup(function(){
				        var SentData = $("#InternationalField").val();
				        if(SentData === ""){
				            $("#ErrorInternational").html("<i class='glyphicon glyphicon-remove'></i>");
							b2=1;
				            var Fields = Array(a2,b2,c2);
				            Validate(Fields,$("#FeeUpdateButton"));
				        }
				        else{
							$.post("../Registrar/Validation.php?ValidateFee",{DataInput:SentData},function(Data){
								if(Data == 0){
									b2 = 0;
									$("#ErrorInternational").html("<i class='glyphicon glyphicon-ok'></i>");
								}
								else{
									b2 = 1;
									$("#ErrorInternational").html("<i class='glyphicon glyphicon-remove'></i>");
								} 
					            var Fields = Array(a2,b2,c2);
					            Validate(Fields,$("#FeeUpdateButton"));
							});
				        }
				    })

				    $("#FeeField").keyup(function(){
				        var SentData = $("#FeeField").val();
				        if(SentData === ""){
				            $("#ErrorFee").html("<i class='glyphicon glyphicon-remove'></i>");
							c2=1;
				            var Fields = Array(a2,b2,c2);
				            Validate(Fields,$("#FeeUpdateButton"));
				        }
				        else{
							$.post("Admin.php?CheckFee",{Data:SentData},function(Data){
								console.log(Data);
								if(Data == 0){
									c2 = 0;
									$("#ErrorFee").html("<i class='glyphicon glyphicon-ok'></i>");
								}
								else{
									c2 = 1;
									$("#ErrorFee").html("<i class='glyphicon glyphicon-remove'></i>");
								} 
					            var Fields = Array(a2,b2,c2);
					            Validate(Fields,$("#FeeUpdateButton"));
							});
				        }
				    })

					$("#FeeUpdateButton").click(function(){
						var AddFee = Array($("#FeeField").val(),$("#RegularField").val(),$("#InternationalField").val());
						$.post("Admin.php?AddFee",{Data:AddFee},function(Data){
							$("#FeeManagementForm").addClass('hidden');
							$("#FeeNotification").removeClass('hidden');
							if(Data == 1){
								$.post("Admin.php?FeeList",{},function(Data){
									$("#FeeList").html(Data);
									$("#FeeNotification").html("<div class='alert alert-success'>Fee has been added.</div>");
								});	 	
							}
							else{
								$("#FeeNotification").html("<div class='alert alert-danger'>Fee has not been added.</div>");
							}
						});	 	
					})

				})
			}
		}
        history.pushState('', "page 2", URL.pathname+URL.search);
	})

	$("#ShowAsText").click(function(){
		if($("#ShowAsText").prop('checked') === true)
			$("#PasswordField").attr("type","text");
		else
			$("#PasswordField").attr("type","password");
	})

	/*Add Faculty*/
    $("#FacultyName").keyup(function(){
        var SentData = $("#FacultyName").val();
        if(SentData === ""){
            $("#ErrorFacultyName").html("<i class='glyphicon glyphicon-remove'></i>");
			a1=1;
            var Fields = Array(a1,b1);
            Validate(Fields,$("#SubmitFaculty"));
        }
        else{
			$.post("../Registrar/Validation.php?FacultyName",{DataInput:SentData},function(Data){
				$("#ErrorFacultyName").html(Data);
				if(Data == 0)
					a1 = 0;
				else 
					a1 = 1;
	            var Fields = Array(a1,b1);
	            Validate(Fields,$("#SubmitFaculty"));
			});
        }
    })

    $("#FacultyPassword").keyup(function(){
        var SentData = $("#FacultyPassword").val();
        if(SentData === "" || SentData.length <= 5){
            $("#ErrorFacultyPassword").html("<i class='glyphicon glyphicon-remove'></i>");
			b1=1;
            var Fields = Array(a1,b1);
            Validate(Fields,$("#SubmitFaculty"));
        }
        else{
			$.post("../Registrar/Validation.php?AlphaNumeric",{DataInput:SentData},function(Data){
                if(Data==0){
                    $("#ErrorFacultyPassword").html("<i class='glyphicon glyphicon-ok'></i>");
					b1=0;
                }
                else{
                    $("#ErrorFacultyPassword").html("<i class='glyphicon glyphicon-remove'></i>");
                    b1 = 1;
                }
	            var Fields = Array(a1,b1);
	            console.log(Fields);
	            Validate(Fields,$("#SubmitFaculty"));
            });
        }
    })

	$("#SubmitFaculty").click(function(){
		$.post("Admin.php?AddFaculty",{Name:$("#FacultyName").val(), Password:$("#FacultyPassword").val(), Node:$("#FacultyNode").val()},function(Data){
			$("#ErrorFaculty").html(Data);
			console.log(Data)
			if(Data == ""){
				$.post("Admin.php?FacultyList",{},function(Data){
					$("#FacultyList").html(Data);
					$("#SubmitFaculty").addClass('disabled');
				});
				$("#FacultyName").val(""); 
			}
			$("#FacultyPassword").val("");

			b1 = 1;
            var Fields = Array(a1,b1);
            Validate(Fields,$("#SubmitFaculty"));
		});
	})	

    $("#PasswordField").keyup(function(){
        var SentData = $("#PasswordField").val();
        if(SentData === "" || SentData.length <= 5){
            $("#ErrorPassword").html("<i class='glyphicon glyphicon-remove'></i>");
			a=1;
            var Fields = Array(a);
            Validate(Fields,$("#UpdatePassword"));
        }
        else{
			$.post("../Registrar/Validation.php?AlphaNumeric",{DataInput:SentData},function(Data){
                if(Data==0){
                    $("#ErrorPassword").html("<i class='glyphicon glyphicon-ok'></i>");
                    a = 0;
                }
                else{
                    $("#ErrorPassword").html("<i class='glyphicon glyphicon-remove'></i>");
                    a = 1;
                }
                var Fields = Array(a);
                Validate(Fields,$("#UpdatePassword"));
            });
        }
    })
	/*End Add Faculty*/
});	
