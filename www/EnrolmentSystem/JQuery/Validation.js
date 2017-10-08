function ShowBTN(a,b,c,d,e,f,g,h,i,j,k){
	return a+b+c+d+e+f+g+h+i+j+k;
}

function Validate(Fields,Button){
    var RetSendData = 0;
    for(loop=0;loop<Fields.length;loop++){
        RetSendData += Fields[loop];
    }
    if(RetSendData === 0)
    	Button.removeClass("disabled");
    else
    	Button.addClass("disabled");
}

function ModalConfirmations(Message){
    $("#ModalConfirmation").modal("show");
    $("#Text_ModalConfirmation").html(Message);
}

function ModalConfirmations2(Message){
    $("#ModalConfirmation2").modal("show");
    $("#Text_ModalConfirmation2").html(Message);
}

function ModalAlert(Message){
    $("#ModalAlert").modal("show");
    $("#Text_ModalAlert").html(Message);
}

function Modal_lg(Header,Content){
    $("#Modal_Universal").modal("show");
    $("#myModalLabel").html(Header);
    $("#Modal_BodyUniversal").html(Content);
}

function PrintDocx(ID){
    var prtContent = document.getElementById(ID);
    var WinPrint = window.open('', '', 'letf=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint .print();
    WinPrint.close();
}

$(document).ready(function(e){
	var a=1,b=1,c=1,d=1,e=1,f1=1,g=1,h=1,i=1,j=1,k=1,l=1,m=1,n=1,o=1,p=1,q=1,r=1,s=1,t=1,u=1,v=1,w=1,x=1,y=1,z=1;
	/*Students*/
	$("#BackupDBX").click(function(){
	    ModalConfirmations("Are you sure you want to back up the database?");
	    $("#Button_Execute").click(function(){
	        $("#ModalConfirmation").modal("hide");
			$("#BackupDBX").html("Backup on progress...")
			$.post("Registrar.php?BackUp",{},function(Data){
				if(Data == 1){
					$("#BackupDBX").html("Backup Database")
					ModalAlert("Finished back up process.")					
				}
			});		
	    });
	})

	$("#StudentType").change(function(){
		var StudentType = $("#StudentType").val();
		if(StudentType == "Old" || StudentType == "Shifter"){
			if(StudentType == "Old")
				$("#StudentTitle").html("Continuing student");
			else
				$("#StudentTitle").html("Shifting student");

			$("#StudentIDInput").val(null);
			$("#GeneratedID").addClass("hidden");
			$("#NewCrossEnrolleeTransfereeStudent").addClass("hidden")
			$("#StudentIDInput").removeClass("hidden");
			$("#OldStudentData").addClass("hidden");
			$("#ShifterData").addClass("hidden");
			$("#StudentCategoryForm").addClass("hidden");
		}
		else{
			$("#OldStudentData").addClass("hidden");
			$("#ShifterData").addClass("hidden");
			$("#NewStudentData").removeClass('hidden');
			$("#StudentCategoryForm").removeClass("hidden");

	        $.ajax({
	            url: '../Registrar/Registrar.php?GenerateRandomStudentID',
	            type: 'POST',
	            data:{Data:"Doctoral"},
	            success: function(Data) {
	            	$("#GeneratedID").html(Data);
	            	$("#IDNumberSettings").click(function(){
		            	if($("#IDNumberSettings").prop("checked") === true){
		            		$("#IDNumber").val("");
		            		$("#IDNumber").removeClass("disabled")
		            		$("#IDNumber").removeClass("hidden");
		            	}
		            	else{
					        $.ajax({
					            url: '../Registrar/Registrar.php?GetGenerateRandomStudentID',
					            type: 'POST',
					            success: function(Data) {
					            	$("#IDNumber").val(Data);
					            }
					        })
		            		$("#IDNumber").addClass("disabled");
		            		$("#IDNumber").addClass("hidden");
		            	}
	            	})
	            }
	        })				

	        $.ajax({
	            url: '../PhpFiles/Process.php?NewStudent',
	            type: 'POST',
	            success: function(Data) {
					var a=1,b=1,c=1,d=1,e=1,f=1,g=1,h=1,i=1,j=0;
					$("#NewStudentData").html(Data)

		            $("#RemovePicture").click(function(){
		            	$("#uploads").html("");
		            })

				    $("#StudentFamilyName").keyup(function(){
				        var SentData = $("#StudentFamilyName").val();
				        if(SentData === ""){
				            $("#ErrorStudentFamilyName").html("<span class='label label-danger'><span class='glyphicon glyphicon-remove'></span> This field is required.</span>");
							a=1;
			                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
			                Validate(Fields,$("#AddMe"));
				        }
				        else{
							$.post("../Registrar/Validation.php?StudentFamilyName",{DataInput:SentData},function(Data){
				                if(Data==0){
				                    $("#ErrorStudentFamilyName").html("");
				                    a = 0;
				                }
				                else{
				                    $("#ErrorStudentFamilyName").html(Data);
				                    a = 1;
				                }
				                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
				                Validate(Fields,$("#AddMe"));
				            });
				        }
				    })

				    $("#StudentGivenName").keyup(function(){
				        var SentData = $("#StudentGivenName").val();
				        if(SentData === ""){
				            $("#ErrorStudentGivenName").html("<span class='label label-danger'><span class='glyphicon glyphicon-remove'></span> This field is required.</span>");
							b=1;
			                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
			                Validate(Fields,$("#AddMe"));
				        }
				        else{
							$.post("../Registrar/Validation.php?StudentGivenName",{DataInput:SentData},function(Data){
				                if(Data==0){
				                    $("#ErrorStudentGivenName").html("");
				                    b = 0;
				                }
				                else{
				                    $("#ErrorStudentGivenName").html(Data);
				                    b = 1;
				                }
				                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
				                Validate(Fields,$("#AddMe"));
				            });
				        }
				    })

				    $("#StudentMiddleName").keyup(function(){
				        var SentData = $("#StudentMiddleName").val();
				        if(SentData === ""){
				            $("#ErrorStudentMiddleName").html("<span class='label label-danger'><span class='glyphicon glyphicon-remove'></span> This field is required.</span>");
							c=1;
			                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
			                Validate(Fields,$("#AddMe"));
				        }
				        else{
							$.post("../Registrar/Validation.php?StudentMiddleName",{DataInput:SentData},function(Data){
				                if(Data==0){
				                    $("#ErrorStudentMiddleName").html("");
				                    c = 0;
				                }
				                else{
				                    $("#ErrorStudentMiddleName").html(Data);
				                    c = 1;
				                }
				                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
				                Validate(Fields,$("#AddMe"));
				            });
				        }
				    })

				    $("#StudentMobileNumber").keyup(function(){
				        var SentData = $("#StudentMobileNumber").val();
				        if(SentData === ""){
				            $("#ErrorStudentMobileNumber").html("<span class='label label-danger'><span class='glyphicon glyphicon-remove'></span> This field is required.</span>");
							d=1;
			                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
			                Validate(Fields,$("#AddMe"));
				        }
				        else{
							$.post("../Registrar/Validation.php?StudentMobileNumber",{DataInput:SentData},function(Data){
				                if(Data==0){
				                    $("#ErrorStudentMobileNumber").html("");
				                    d = 0;
				                }
				                else{
				                    $("#ErrorStudentMobileNumber").html(Data);
				                    d = 1;
				                }
				                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
				                Validate(Fields,$("#AddMe"));
				            });
				        }
				    })

				    $("#StudentAddress").keyup(function(){
				        var SentData = $("#StudentAddress").val();
				        if(SentData === ""){
				            $("#ErrorStudentAddress").html("<span class='label label-danger'><span class='glyphicon glyphicon-remove'></span> This field is required.</span>");
							e=1;
			                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
			                Validate(Fields,$("#AddMe"));
				        }
				        else{
							$.post("../Registrar/Validation.php?StudentAddress",{DataInput:SentData},function(Data){
				                if(Data==0){
				                    $("#ErrorStudentAddress").html("");
				                    e = 0;
				                }
				                else{
				                    $("#ErrorStudentAddress").html(Data);
				                    e = 1;
				                }
				                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
				                Validate(Fields,$("#AddMe"));
				            });
				        }
				    })

				    $("#StudentEmailAddress").keyup(function(){
				        var SentData = $("#StudentEmailAddress").val();
				        if(SentData === ""){
				            $("#ErrorStudentEmailAddress").html("<span class='label label-danger'><span class='glyphicon glyphicon-remove'></span> This field is required.</span>");
							f1=1;
			                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
			                Validate(Fields,$("#AddMe"));
				        }
				        else{
							$.post("../Registrar/Validation.php?StudentEmailAddress",{DataInput:SentData},function(Data){
				                if(Data==0){
				                    $("#ErrorStudentEmailAddress").html("");
				                    f1 = 0;
				                }
				                else{
				                    $("#ErrorStudentEmailAddress").html(Data);
				                    f1 = 1;
				                }
				                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
				                Validate(Fields,$("#AddMe"));
				            });
				        }
				    })

				    $("#StudentGuardian").keyup(function(){
				        var SentData = $("#StudentGuardian").val();
				        if(SentData === ""){
				            $("#ErrorStudentGuardian").html("<span class='label label-danger'><span class='glyphicon glyphicon-remove'></span> This field is required.</span>");
							g=1;
			                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
			                Validate(Fields,$("#AddMe"));
				        }
				        else{
							$.post("../Registrar/Validation.php?StudentGuardian",{DataInput:SentData},function(Data){
				                if(Data==0){
				                    $("#ErrorStudentGuardian").html("");
				                    g = 0;
				                }
				                else{
				                    $("#ErrorStudentGuardian").html(Data);
				                    g = 1;
				                }
				                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
				                Validate(Fields,$("#AddMe"));
				            });
				        }
				    })

				    $("#StudentGuardianContactNumber").keyup(function(){
				        var SentData = $("#StudentGuardianContactNumber").val();
				        if(SentData === ""){
				            $("#ErrorStudentGuardianContactNumber").html("<span class='label label-danger'><span class='glyphicon glyphicon-remove'></span> This field is required.</span>");
							h=1;
			                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
			                Validate(Fields,$("#AddMe"));
				        }
				        else{
							$.post("../Registrar/Validation.php?StudentGuardianContactNumber",{DataInput:SentData},function(Data){
				                if(Data==0){
				                    $("#ErrorStudentGuardianContactNumber").html("");
				                    h = 0;
				                }
				                else{
				                    $("#ErrorStudentGuardianContactNumber").html(Data);
				                    h = 1;
				                }
				                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
				                Validate(Fields,$("#AddMe"));
				            });
				        }
				    })

				    $("#StudentCourseGraduated").keyup(function(){
				        var SentData = $("#StudentCourseGraduated").val();
				        if(SentData === ""){
				            $("#ErrorStudentCourseGraduated").html("<span class='label label-danger'><span class='glyphicon glyphicon-remove'></span> This field is required.</span>");
							i=1;
			                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
			                Validate(Fields,$("#AddMe"));
				        }
				        else{
							$.post("../Registrar/Validation.php?StudentCourseGraduated",{DataInput:SentData},function(Data){
				                if(Data==0){
				                    $("#ErrorStudentCourseGraduated").html("");
				                    i = 0;
				                }
				                else{
				                    $("#ErrorStudentCourseGraduated").html(Data);
				                    i = 1;
				                }
				                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
				                Validate(Fields,$("#AddMe"));
				            });
				        }
				    })

		            $("#file").change(function(){
		            	var File = $("#file").val().split('.');
		                if(($("#file").val().length > 0) && ((File[File.length - 1] == "gif") || (File[File.length - 1] == "jpg") || (File[File.length - 1] == "jpeg") || (File[File.length - 1] == "png"))){
		                    console.log("OK");
		                    var f = document.getElementById('file'),
		                        pb = document.getElementById('pb'),
		                        pt = document.getElementById('pt');
		                    app.uploader({
		                        files: f,
		                        progressBar: pb,
		                        progressText: pt,
		                        processor: '../PhpFiles/Process.php?TestFile',
		                        finished: function(data){
		                            var uploads = document.getElementById('uploads'),
		                                succeeded = document.createElement('div'),
		                                failed = document.createElement('div'),
		                                anchor, span, x,string;
		                                uploads.innerText = '';
		                                for(x=0;x<data.succeeded.length;x++){
		                                    anchor = document.createElement("span");
		                                    anchor.href = '../files/'+data.succeeded[x].file;
		                                    anchor.target = '_blank';
		                                    succeeded.appendChild(anchor);
		                                }
		                                for(x=0;x<data.failed.length;x++){
		                                    span = document.createElement('span');
		                                    failed.appendChild(span);
		                                }
		                                uploads.appendChild(succeeded);
		                                uploads.appendChild(failed);

		                                if (data.failed.length) {
		                                    string = '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> You cannot upload this file.</span>';
		                                    failed.innerHTML = string;
		                                    j = 1;
							                //var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
							                var Fields = Array(j);
							                Validate(Fields,$("#AddMe"));
		                                }
		                                if (data.succeeded.length) {
		                                    string = '<span class="label label-success"><span class="glyphicon glyphicon-ok"></span> File ok for upload.</span> '; 
		                                    succeeded.innerHTML = string;
		                                    j = 0;
							                //var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
							                var Fields = Array(j);
							                Validate(Fields,$("#AddMe"));
		                                }
		                        }
		                    });
		                    var FileName = $(".fileinput-filename").text("");
		                }
		                else{
		                    j = 0;
			                var Fields = Array(a,b,c,d,e,f1,g,h,i,j);
			                console.log(Fields);
			                Validate(Fields,$("#AddMe"));
		                }
		            })

					$("#AddMe").click(function(){
	                    var f = document.getElementById('file'),
	                        pb = document.getElementById('pb'),
	                        pt  = document.getElementById('pt');
	                    app.uploader({
	                        files: f,
	                        progressBar: pb,
	                        progressText: pt,
	                        processor: '../PhpFiles/Upload.php',
	                        finished: function(data){
	                            var uploads = document.getElementById('uploads'),
	                                succeeded = document.createElement('div'),
	                                failed = document.createElement('div'),
	                                anchor, span, x,string,ProfilePicture
	                                uploads.innerText = '';

	                                if(typeof data.succeeded[0] == "undefined")
	                                	ProfilePicture = "";
	                                else
	                                	ProfilePicture = data.succeeded[0].file;


                                    var Data = Array({
                                    	0:$("#IDNumber").val(),
                                    	1:$("#StudentBirthMonth").val()+" "+$("#StudentBirthDay").val()+", "+$("#StudentBirthYear").val(),
                                    	2:$("#StudentFamilyName").val(),
                                    	3:$("#StudentGivenName").val(),
                                    	4:$("#StudentMiddleName").val(),
                                    	5:$("#StudentMobileNumber").val(),
                                    	6:$("#StudentAddress").val(),
                                    	7:$("#StudentEmailAddress").val(),
                                    	8:$("#StudentGuardian").val(),
                                    	9:$("#StudentGuardianContactNumber").val(),
                                    	10:$("#StudentCourseGraduated").val(),
                                    	11:$("#StudentCivilStatus").val(),
                                    	12:$("#StudentGender").val(),
                                    	13:$("#StudentYearGraduated").val(),
			                        	14:$("#StudentType").val(),
                                    	15:ProfilePicture,
			                        	16:$("#StudentProgram").val(),
			                        	17:$("#StudentCategory").val(),
                                    })		
									$.post("../PhpFiles/Process.php?AddMe",{Data:Data},function(ReturnData){
										ReturnData = ReturnData.split("<x>");
										console.log(ReturnData);
										if(Number(ReturnData[0]) == 1){
										    ModalAlert("Successful");
										    $("#NewStudentData").addClass("hidden");
										    $("#GeneratedID").addClass("hidden");
										    $("#StudentIDInput").removeClass("hidden");
										    $("#StudentIDInput").val(ReturnData[1]);
											var StudentNumber = $("#StudentIDInput").val();

											$("#OldStudentData").removeClass('hidden');
											$.post("Registrar.php?OldStudent",{StudentNumber:StudentNumber},function(Data){
												$("#StudentInformation").html(Data);

												$("#ShifterSelectedCourse").change(function(){
													if($("#ShifterSelectedCourse").val() == 'New Course')
														$("#Button_Shift").addClass('disabled');
													else
														$("#Button_Shift").removeClass('disabled');

													$("#Button_Shift").click(function(){
														var DataSent = Array($("#ShifterSelectedCourse").val(),$("#StudentIDInput").val());
													    ModalConfirmations("Are you sure you want to shift the course to "+DataSent[0]);
													    $("#Button_Execute").click(function(){
													        $("#ModalConfirmation").modal("hide");
															$.post("Registrar.php?Shift",{Data:DataSent},function(Data){
																if(Data == 1){
																    ModalAlert("Successfully updated");

																	$.post("Registrar.php?OldStudent",{StudentNumber:StudentNumber},function(Data){
																		$("#StudentInformation").html(Data);

																		$(".AddEnrolSubject").click(function(){
																			var index = $(".AddEnrolSubject").index(this), indexPlusOne = index+1;
																			$("#SubjectsList tr:nth-child("+indexPlusOne+")").addClass('hidden');
																			$("#SuggestedSubjectsList tr:nth-child("+indexPlusOne+")").removeClass('hidden');
																			$("#AddSubjectToEnrol_"+index).addClass("AddSubjectToEnrol");
																		})

																		$(".RemoveEnrolSubject").click(function(){
																			var index = $(".RemoveEnrolSubject").index(this), indexPlusOne = index+1;
																			$("#SubjectsList tr:nth-child("+indexPlusOne+")").removeClass('hidden');
																			$("#SuggestedSubjectsList tr:nth-child("+indexPlusOne+")").addClass('hidden');
																			$("#AddSubjectToEnrol_"+index).removeClass("AddSubjectToEnrol");
																		})

																		$("#ButtonEnrol").click(function(){
																			var CollectSubjects = $(".AddSubjectToEnrol"), Subjects = Array(), Notification = "", Counter = 0;
																			for(x=0;x<CollectSubjects.length;x++){
																				Counter++;
																				Subjects[x] = CollectSubjects[x].value;
																				Notification += Counter+". "+CollectSubjects[x].value+"<br/> ";
																			}

																			if((Subjects.length>0)&&Subjects.length<=5){
																				var Data = Array(StudentNumber,RegistrationCode,Subjects);
																		        $.ajax({
																		            url: 'RegistrarPrinting.php?PrintRegistrar',
																		            type: 'POST',
																		            data:{Data:Data},
																		            success: function(Data) {
																		            	$("#Printable").html(Data);
																		            }
																		        })
																			    ModalConfirmations2("Are you sure you want to enrol the following subjects?</br>"+Notification);
																			    $("#Button_Execute2").click(function(){
																			        $("#ModalConfirmation").modal("hide");
																			        $.ajax({
																			            url: 'Registrar.php?EnrolSubjects',
																			            type: 'POST',
																			            data:{Data:Data},
																			            success: function(Data) {
																			            	if(Data == 0){
																								$.post("Registrar.php?GeneratedCode",{},function(Data){
																									$("#RegistrationCode").val(Data);
																								})
																			            		$("#StudentInformation").html("");
																			            		$("#ShifterInformation").html("");
																			            		$("#StudentIDInput").val("");
																				                PrintDocx('Printable');
																			            	}
																			            	else
																			            		ModalAlert("There was an error during the saving process. Refer the problem to the developer.");
																			            }
																			        })
																			    })
																			}
																			else
															            		ModalAlert("The subject(s) you are about to enrol is out of range.");
																		})
																	})

																}
																else{
																    ModalAlert("There was an error updating the course to "+DataSent[0]);
																}
																return false;
															})
													    });
													})										
												});
											})
										}
										else
										    ModalAlert("There was an error processing your request. Seek developer help.");
									});

	                                uploads.appendChild(succeeded);
	                                uploads.appendChild(failed);

	                                if (data.failed.length) {
	                                    string = '<span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> You cannot upload this file.</span>';
	                                    failed.innerHTML = string;
	                                }
	                                if (data.succeeded.length) {
	                                    string = '<span class="label label-success"><span class="glyphicon glyphicon-ok"></span> File ok for upload.</span> '; 
	                                    succeeded.innerHTML = string;
	                                }
	                        }
	                    });
	                    var FileName = $(".fileinput-filename").text("");
					})
	            }
	        });

			$("#StudentTitle").text("New student");
			$("#GeneratedID").removeClass("hidden");
			$("#NewCrossEnrolleeTransfereeStudent").removeClass("hidden")
			$("#StudentIDInput").addClass("hidden");
		}
	});

	$("#StudentIDInput").keyup(function(){
		var StudentType = $("#StudentType").val(), RegistrationCode = $("#RegistrationCode").val(), StudentNumber = $("#StudentIDInput").val(), Subjects = Array();
		$.post("../Registrar/Validation.php?StudentIDValidation",{DataInput:StudentNumber},function(Data){
			if(Data == 0){
				$("#ErrorStudentIDInput").html("");				
				if($("#StudentType").val() == 'Old'){
					$("#ShifterInformation").html("");
					$("#OldStudentData").removeClass('hidden');
					$.post("Registrar.php?OldStudent",{StudentNumber:StudentNumber},function(Data){
						$("#StudentInformation").html(Data);

						$("body").click(function(event){
							var Hash = event.target.hash, URL = window.location;
					        if(typeof Hash !== "undefined" && Hash !== ""){
					        	var Hashes = Hash.split("#")

								if(Hashes[1] === "CreditedSubject "){
									var Data = Array(Hashes[2],Hashes[3],$("#StudentIDInput").val());
									$("#Modal_Credit").modal("show");
									$("#CreditedSubject").html(Hashes[3]);

									$("#Button_CreditedSubject").click(function(){
										var Data2 = Array($("#CreditedSubjectRating").val(),$("#SchoolLastAttended").val());
										var DataX = Array(Data,Data2);
										console.log(DataX);

								        $.ajax({
								            url: 'Registrar.php?CreditedSubject',
								            type: 'POST',
								            data:{Data:DataX},
								            success: function(Data) {
								            	console.log(Data);
								            	if(Data == 1){
										        	$("#EventCreditedSubject_"+Number(Hashes[4])).addClass('hidden');
													$("#SubjectsList tr:nth-child("+Number(Hashes[4])+")").addClass('hidden');
								            	}
								            	else{
												    //ModalAlert("There was an error processing your request. Seek developer help.");
								            	}
												$("#Modal_Credit").modal("hide");
								            }
								        })

									})
								}
							}
					        history.pushState('', "page 2", URL.pathname+URL.search);
						})

						$("#ShifterSelectedCourse").change(function(){
							if($("#ShifterSelectedCourse").val() == 'New Course')
								$("#Button_Shift").addClass('disabled');
							else
								$("#Button_Shift").removeClass('disabled');

							$("#Button_Shift").click(function(){
								var DataSent = Array($("#ShifterSelectedCourse").val(),$("#StudentIDInput").val());
							    ModalConfirmations("Are you sure you want to shift the course to "+DataSent[0]);
							    $("#Button_Execute").click(function(){
							        $("#ModalConfirmation").modal("hide");
									$.post("Registrar.php?Shift",{Data:DataSent},function(Data){
										if(Data == 1){
										    ModalAlert("Successfully updated");

											$.post("Registrar.php?OldStudent",{StudentNumber:StudentNumber},function(Data){
												$("#StudentInformation").html(Data);

												$(".AddEnrolSubject").click(function(){
													var index = $(".AddEnrolSubject").index(this), indexPlusOne = index+1;
													$("#SubjectsList tr:nth-child("+indexPlusOne+")").addClass('hidden');
													$("#SuggestedSubjectsList tr:nth-child("+indexPlusOne+")").removeClass('hidden');
													$("#AddSubjectToEnrol_"+index).addClass("AddSubjectToEnrol");
												})

												$(".RemoveEnrolSubject").click(function(){
													var index = $(".RemoveEnrolSubject").index(this), indexPlusOne = index+1;
													$("#SubjectsList tr:nth-child("+indexPlusOne+")").removeClass('hidden');
													$("#SuggestedSubjectsList tr:nth-child("+indexPlusOne+")").addClass('hidden');
													$("#AddSubjectToEnrol_"+index).removeClass("AddSubjectToEnrol");
												})

												$("#ButtonEnrol").click(function(){
													var CollectSubjects = $(".AddSubjectToEnrol"), Subjects = Array(), Notification = "", Counter = 0;
													for(x=0;x<CollectSubjects.length;x++){
														Counter++;
														Subjects[x] = CollectSubjects[x].value;
														Notification += Counter+". "+CollectSubjects[x].value+"<br/> ";
													}

													if((Subjects.length>0)&&Subjects.length<=5){
														var Data = Array(StudentNumber,RegistrationCode,Subjects);
												        $.ajax({
												            url: 'RegistrarPrinting.php?PrintRegistrar',
												            type: 'POST',
												            data:{Data:Data},
												            success: function(Data) {
												            	$("#Printable").html(Data);
												            }
												        })
													    ModalConfirmations2("Are you sure you want to enrol the following subjects?</br>"+Notification);
													    $("#Button_Execute2").click(function(){
													        $("#ModalConfirmation").modal("hide");
													        $.ajax({
													            url: 'Registrar.php?EnrolSubjects',
													            type: 'POST',
													            data:{Data:Data},
													            success: function(Data) {
													            	if(Data == 0){
																		$.post("Registrar.php?GeneratedCode",{},function(Data){
																			$("#RegistrationCode").val(Data);
																		})
													            		$("#StudentInformation").html("");
													            		$("#ShifterInformation").html("");
													            		$("#StudentIDInput").val("");
														                PrintDocx('Printable');
													            	}
													            	else
													            		ModalAlert("There was an error during the saving process. Refer the problem to the developer.");
													            }
													        })
													    })
													}
													else
									            		ModalAlert("The subject(s) you are about to enrol is out of range.");
												})
											})

										}
										else{
										    ModalAlert("There was an error updating the course to "+DataSent[0]);
										}
										return false;
									})
							    });
							})										
						});

						$(".AddEnrolSubject").click(function(){
							var index = $(".AddEnrolSubject").index(this), indexPlusOne = index+1;
							console.log(index);
							console.log($(".AddEnrolSubject:nth-child(9)"));
							$(".AddEnrolSubject:nth-child("+index+")").addClass('hidden');
							//$("#SubjectsList tr:nth-child("+indexPlusOne+")").addClass('hidden');
							//$("#SuggestedSubjectsList tr:nth-child("+indexPlusOne+")").removeClass('hidden');
							//$("#AddSubjectToEnrol_"+index).addClass("AddSubjectToEnrol");
						})

						$(".RemoveEnrolSubject").click(function(){
							var index = $(".RemoveEnrolSubject").index(this), indexPlusOne = index+1;
							$("#SubjectsList tr:nth-child("+indexPlusOne+")").removeClass('hidden');
							$("#SuggestedSubjectsList tr:nth-child("+indexPlusOne+")").addClass('hidden');
							$("#AddSubjectToEnrol_"+index).removeClass("AddSubjectToEnrol");
						})

						$("#ButtonEnrol").click(function(){
							var CollectSubjects = $(".AddSubjectToEnrol"), Subjects = Array(), Notification = "", Counter = 0;
							for(x=0;x<CollectSubjects.length;x++){
								Counter++;
								Subjects[x] = CollectSubjects[x].value;
								Notification += Counter+". "+CollectSubjects[x].value+"<br/> ";
							}

							if((Subjects.length>0)&&Subjects.length<=5){
								var Data = Array(StudentNumber,RegistrationCode,Subjects);
						        $.ajax({
						            url: 'RegistrarPrinting.php?PrintRegistrar',
						            type: 'POST',
						            data:{Data:Data},
						            success: function(Data) {
						            	$("#Printable").html(Data);
						            }
						        })
							    ModalConfirmations("Are you sure you want to enrol the following subjects?</br>"+Notification);
							    $("#Button_Execute").click(function(){
							        $("#ModalConfirmation").modal("hide");
							        $.ajax({
							            url: 'Registrar.php?EnrolSubjects',
							            type: 'POST',
							            data:{Data:Data},
							            success: function(Data) {
							            	if(Data == 0){
												$.post("Registrar.php?GeneratedCode",{},function(Data){
													$("#RegistrationCode").val(Data);
												})
							            		$("#StudentInformation").html("");
							            		$("#ShifterInformation").html("");
							            		$("#StudentIDInput").val("");
								                PrintDocx('Printable');
							            	}
							            	else
							            		ModalAlert("There was an error during the saving process. Refer the problem to the developer.");
							            }
							        })
							    })
							}
							else
			            		ModalAlert("The subject(s) you are about to enrol is out of range.");
						})
					})
				}
				else{
					$("#StudentInformation").html("");
					$("#ShifterData").removeClass('hidden');
					$.post("Registrar.php?ShiftStudent",{StudentNumber:StudentNumber},function(Data){
						$("#ShifterInformation").html(Data);
						$("#OldCourseInputs").removeClass("hidden");

						$("#ShifterSelectedCourse").change(function(){
							if($("#ShifterSelectedCourse").val() == 'New Course')
								$("#Button_Shift").addClass('disabled');
							else
								$("#Button_Shift").removeClass('disabled');

							$("#Button_Shift").click(function(){
								var DataSent = Array($("#ShifterSelectedCourse").val(),$("#StudentIDInput").val());
							    ModalConfirmations("Are you sure you want to shift the course to "+DataSent[0]);
							    $("#Button_Execute").click(function(){
							        $("#ModalConfirmation").modal("hide");
									$.post("Registrar.php?Shift",{Data:DataSent},function(Data){
										if(Data == 1){
										    ModalAlert("Successfully updated");

											$.post("Registrar.php?OldStudent",{StudentNumber:StudentNumber},function(Data){
												$("#ShifterInformation").html(Data);

												$(".AddEnrolSubject").click(function(){
													var index = $(".AddEnrolSubject").index(this), indexPlusOne = index+1;
													$("#SubjectsList tr:nth-child("+indexPlusOne+")").addClass('hidden');
													$("#SuggestedSubjectsList tr:nth-child("+indexPlusOne+")").removeClass('hidden');
													$("#AddSubjectToEnrol_"+index).addClass("AddSubjectToEnrol");
												})

												$(".RemoveEnrolSubject").click(function(){
													var index = $(".RemoveEnrolSubject").index(this), indexPlusOne = index+1;
													$("#SubjectsList tr:nth-child("+indexPlusOne+")").removeClass('hidden');
													$("#SuggestedSubjectsList tr:nth-child("+indexPlusOne+")").addClass('hidden');
													$("#AddSubjectToEnrol_"+index).removeClass("AddSubjectToEnrol");
												})

												$("#ButtonEnrol").click(function(){
													var CollectSubjects = $(".AddSubjectToEnrol"), Subjects = Array(), Notification = "", Counter = 0;
													for(x=0;x<CollectSubjects.length;x++){
														Counter++;
														Subjects[x] = CollectSubjects[x].value;
														Notification += Counter+". "+CollectSubjects[x].value+"<br/> ";
													}

													if((Subjects.length>0)&&Subjects.length<=5){
														var Data = Array(StudentNumber,RegistrationCode,Subjects);
												        $.ajax({
												            url: 'RegistrarPrinting.php?PrintRegistrar',
												            type: 'POST',
												            data:{Data:Data},
												            success: function(Data) {
												            	$("#Printable").html(Data);
												            }
												        })
													    ModalConfirmations2("Are you sure you want to enrol the following subjects?</br>"+Notification);
													    $("#Button_Execute2").click(function(){
													        $("#ModalConfirmation").modal("hide");
													        $.ajax({
													            url: 'Registrar.php?EnrolSubjects',
													            type: 'POST',
													            data:{Data:Data},
													            success: function(Data) {
													            	if(Data == 0){
																		$.post("Registrar.php?GeneratedCode",{},function(Data){
																			$("#RegistrationCode").val(Data);
																		})
													            		$("#StudentInformation").html("");
													            		$("#ShifterInformation").html("");
													            		$("#StudentIDInput").val("");
														                PrintDocx('Printable');
													            	}
													            	else
													            		ModalAlert("There was an error during the saving process. Refer the problem to the developer.");
													            }
													        })
													    })
													}
													else
									            		ModalAlert("The subject(s) you are about to enrol is out of range.");
												})
											})

										}
										else{
										    ModalAlert("There was an error updating the course to "+DataSent[0]);
										}
										return false;
									})
							    });
							})										
						});
					})
				}
			}
			else{
				$("#ErrorStudentIDInput").html(Data);
				$("#OldStudentData").addClass("hidden");
				$("#ShifterData").addClass("hidden");
			}		
		});
	});

	/*Adding of courses and subjects*/
	var course1 = $("input#CourseTitleX").keyup(function(){
		var DataSend = $("input#CourseTitleX").val();
		$.post("../Registrar/Validation.php?CourseTitleX",{DataInput:DataSend},function(Data){
			$("#ErrorCourseTitleX").html(Data);
			if(Data == 0) course1 = 1;
			else course1 = 0;

			if(ShowBTN(course1,course2,course3,0,0,0,0,0,0,0,0) == 3)
				$("#BtnCourseOkX").removeClass("disabled");
			else
				$("#BtnCourseOkX").addClass("disabled");
		});
	});

	var course2 = $("input#CourseCodeX").keyup(function(){
		var DataSend = $("input#CourseCodeX").val();
		$.post("../Registrar/Validation.php?CourseCodeX",{DataInput:DataSend},function(Data){
			$("#ErrorCourseCodeX").html(Data);
			if(Data == 0) course2 = 1;
			else course2 = 0;

			if(ShowBTN(course1,course2,course3,0,0,0,0,0,0,0,0) == 3)
				$("#BtnCourseOkX").removeClass("disabled");
			else
				$("#BtnCourseOkX").addClass("disabled");
		});
	});

	var course3 = $("input#DescriptiveTitleX").keyup(function(){
		var DataSend = $("input#DescriptiveTitleX").val();
		$.post("../Registrar/Validation.php?DescriptiveTitleX",{DataInput:DataSend},function(Data){
			$("#ErrorDescriptiveTitleX").html(Data);
			if(Data == 0) course3 = 1;
			else course3 = 0;

			if(ShowBTN(course1,course2,course3,0,0,0,0,0,0,0,0) == 3)
				$("#BtnCourseOkX").removeClass("disabled");
			else
				$("#BtnCourseOkX").addClass("disabled");
		});
	});
	/*End Adding of courses and subjects*/

	/* Assessment */
	var AssessmentCode = $("#AssessmentCode").keyup(function(){
		var DataSend = $("#AssessmentCode").val();
		$.post("../Registrar/Validation.php?AssessmentCode",{DataInput:DataSend},function(Data){
			$("#ErrorAssessmentCode").html(Data);
		});
	});
	/* End Assessment */

	/* Cashier */
	var AssessmentCode1 = $("#AssessmentCode").keyup(function(){
		var DataSend = $("#AssessmentCode").val();
		$.post("../Registrar/Validation.php?AssessmentCode",{DataInput:DataSend},function(Data){
			$("#ErrorAssessmentCode").html(Data);
		});
	});

	var AmountPaid = $("#AmountPaid").keyup(function(){
		var DataSend = $("#AmountPaid").val();
		$.post("../Registrar/Validation.php?AmountPaid",{DataInput:DataSend},function(Data){
			$("#ErrorAmountPaid").html(Data);
			if(Data == 0) AmountPaid = 1;
			else AmountPaid = 0;

			if(ShowBTN(AmountPaid,ReceiptNumber,0,0,0,0,0,0,0,0,0) == 2)
				$("#CashierBtn").removeClass("disabled");
			else
				$("#CashierBtn").addClass("disabled");
		});
	});

	var ReceiptNumber = $("#ReceiptNumber").keyup(function(){
		var DataSend = $("#ReceiptNumber").val();
		$.post("../Registrar/Validation.php?ReceiptNumber",{DataInput:DataSend},function(Data){
			$("#ErrorReceiptNumber").html(Data);
			if(Data == 0) ReceiptNumber = 1;
			else ReceiptNumber = 0;

			if(ShowBTN(AmountPaid,ReceiptNumber,0,0,0,0,0,0,0,0,0) == 2)
				$("#CashierBtn").removeClass("disabled");
			else
				$("#CashierBtn").addClass("disabled");
		});
	});
})
