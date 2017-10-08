/*
Author:Rufo N. Gabrillo Jr.
Date:May 15, 2014
Discription: Thesis of Sir Clark Kim Castro. Enrolment System. AJAX/PHP/CSS3/HTML5
*/
$(document).ready(function(e) {
	$("#ShifterData").hide();
	$("#OldCourseInputs").hide();
	$("#OldInputStudent").hide();
	$("#OldStudentInformation").hide();

	$("#StudentType").change(function(){
		if($("#StudentType").val() == 'New' || $("#StudentType").val() == 'Transferee' || $("#StudentType").val() == 'Cross-Enrollee'){
			$("#NewStudent").hide(); $("#OldCourseInputs").hide(); $("#OldStudentInformation").hide(); $("#OldInputStudent").hide();
			$("#NewStudent").show(100); $("#OldStudentData").hide(); $("#ShifterInformation").hide(); $("#OldInputStudent").val("");
		}
		else if($("#StudentType").val() == 'Old'){
			$("#ShifterData").hide();
			$("#NewStudent").hide(); $("#ShifterInformation").hide(); $("#OldInputStudent").val("");  $("#OldInputStudent").hide(100);
			$("#OldCourseInputs").hide(100); $("#OldInputStudent").show(100); $("#OldStudentInformation").show(100);
		}
		else if($("#StudentType").val() == 'Shifter'){
			$("#NewStudent").hide(); $("#OldCourseInputs").hide(); $("#OldStudentInformation").hide(); $("#OldInputStudent").hide();
			$("#OldStudentData").hide(); $("#OldInputStudent").val(""); $("#OldInputStudent").show(100);
		}
	})
		
	//faculty loading of subjects
	var IndexSelect = 0;
	$(".FacultyLoad").click(function(){
		$(".Hidden").hide(); $(".FacultyLoad").show();  $(".FacultySubject").show();
		IndexSelect = $(".FacultyLoad").index(this);
		$("#"+IndexSelect).show(200);$("#F"+IndexSelect).hide(200);
		$("#FLoaded"+IndexSelect).hide();
		$("#FacultyCourse"+IndexSelect).change(function(){
			$.post("Registrar.php?SubjectListFaculty",{CourseTitle:$("#FacultyCourse"+IndexSelect).val(),StudentIDNumber:$("#IDNumber").text()},function(SubjectList){
				//document.getElementById("FacultyList"+IndexSelect).innerHTML = SubjectList;
				$("#FacultyList"+IndexSelect).html(SubjectList);
				
			});
		})
	})
	
	$("button#FacultySureLoad").click(function(){
		var Course = $("#FacultyCourse"+IndexSelect).val(), Subject = $("#FacultyList"+IndexSelect+" select").val(), TNO = $("#FacultyID"+IndexSelect).val(); 
		$("#PopUpShade").show(200).css({"background":"rgba(0,0,0,0.8)"});
		$("#PopUpInputDialog").hide(); $("#PopUpConfirmDialog").show();
		$("#PopUpTitleDialog").text("You are about to change the subject loaded."); // dito nagend
		$("#OK_BTN").click(function(){
			$("#PopUpShade").delay(500).hide(200);
			$.post("Registrar.php?FacultyLoading",{CourseTitle:Course,Subject:Subject,TNO:TNO},function(SubjectList){
				$(".Hidden").hide();
				$("#FacultyCourse"+IndexSelect).val(""); $("#FacultyList"+IndexSelect+" select").val("");
				$("#F"+IndexSelect).show(200); $("#FLoaded"+IndexSelect).text(SubjectList);
				BulaMessage("Faculty loaded with "+Subject,"Load",$("#F"+IndexSelect),3000);
				$("#FLoaded"+IndexSelect).delay(3000).show(100);
			});
		})
		$("#CANCEL_BTN").click(function(){
			$("#PopUpShade").delay(500).hide(200);
			$("#HiddenConfirmValue").val("CANCEL");
		})
	})
	$("button#FacultyCancelLoad").click(function(){
		$(".Hidden").hide(); $("#FLoaded"+IndexSelect).show(); $("#F"+IndexSelect).show(200);
	})
	
	$.post("Registrar.php?CourseList",{CourseTitle:$("#CourseTitle").val()},function(CourseList){
		document.getElementById("CourseContent").innerHTML = CourseList;
	});
	
	$.post("Registrar.php?RetrieveSubject",{StudentIDNumber:$("#IDNumber").text(),CourseTitle:$("#StudentCourse").val()},function(SubjectList){
		document.getElementById("SubjectContentList").innerHTML = SubjectList;
	}); // automatic Retrieving of enrolled subject listed
	
	$.post("Registrar.php?SubjectList",{CourseTitle:$("#StudentCourse").val(),StudentIDNumber:$("#SubjectStudentID").val()},function(SubjectList){
		document.getElementById("SubjectList").innerHTML = SubjectList;
	});
	$.post("Registrar.php?SubjectList",{CourseTitle:$("#StudentCourse").val(),StudentIDNumber:$("#IDNumber").text()},function(SubjectList){
		document.getElementById("SubjectList").innerHTML = SubjectList;
	});
	
	$("#SubjectContentList button").click(function(){
		alert(document.getElementById("SubjectContentList").innerHTML)
	})
	
	$.post("Registrar.php?SubjectList",{CourseTitle:$("#StudentCourse").val(),StudentIDNumber:$("#IDNumber").text()},function(SubjectList){
		document.getElementById("SubjectList").innerHTML = SubjectList;
		$.post("Registrar.php?CourseTip",{StudentCourseCode:$("#SubjectSelect").val(),StudentCourseTitle:$("#StudentCourse").val()},function(RegistrationData){
			$("div#DescriptiveTitle").text(RegistrationData);
		});				
	});
		
	$("#CourseSelection").change(function(){
		$.post("Registrar.php?SuggestedSubjects",{CourseTitle:$("#StudentCourse").val(),StudentIDNumber:$("#IDNumber").text()},function(SuggestedSubjectList){
		});

		$.post("Registrar.php?RetrieveSubject",{StudentIDNumber:$("#IDNumber").text(),CourseTitle:$("#StudentCourse").val()},function(SuggestedSubjectList){
			document.getElementById("SubjectContentList").innerHTML = SuggestedSubjectList;
		}); // automatic Retrieving of enrolled subject listed
		
		$.post("Registrar.php?SubjectList",{CourseTitle:$.trim($("#StudentCourse").val()),StudentIDNumber:$("#IDNumber").text()},function(SubjectList){
			document.getElementById("SubjectList").innerHTML = SubjectList;
			$.post("Registrar.php?CourseTip",{StudentCourseCode:$("#SubjectSelect").val(),StudentCourseTitle:$("#StudentCourse").val()},function(RegistrationData){
				$("div#DescriptiveTitle").text(RegistrationData);
			});				
		});

		$.post("Registrar.php?RegistrationCourse",{StudentCourse:$("#StudentCourse").val()},function(RegistrationData){
		});				
	})
	
	$("#SubjectList").change(function(){
		$.post("Registrar.php?CourseTip",{StudentCourseCode:$("#SubjectList select").val(),StudentCourseTitle:$("#StudentCourse").val()},function(RegistrationData){
			$("div#DescriptiveTitle").text(RegistrationData);
		});				
	});

	if($("#SubjectCourse").val() == null || $("#SubjectCourse").val() == ""){
	}
	else{
		$("#SubjectContent").show();
		$("#PopUpShade").toggle(200).css({"background":"rgba(0,0,0,0.8)"});
		$("#PersonalInformation").hide();
	}

	if($("#CourseTitle").val() == null || $("#CourseTitle").val() == ""){
	}
	else{
		$("#AddStudentDropDown").fadeOut(100);
		$("#PopUpShade").toggle(200).css({"background":"rgba(0,0,0,0.8)"});
		$("#StudentInfoDropDown").fadeOut(100);
		$("#PopUp").hide(100); 
		$("#PopUpError").hide(100); 
		$("#PopUpPicture").hide(100); 
	}


	if($("#Pops").val() == null || $("#Pops").val() == ""){
	}
	else{
		$("#PopUp").hide(100);
		$("#PopUpShade").toggle(200).css({"background":"rgba(0,0,0,0.8)"});
		$("#PopUpError").hide(100); 
	}

	$("#CourseTitle").change(function(){
		$.post("Registrar.php?CourseList",{CourseTitle:$("#CourseTitle").val()},function(CourseList){
			document.getElementById("CourseContent").innerHTML = CourseList;
		});
		$.post("Registrar.php?CourseSession",{Session:$("#CourseTitle").val()},function(CourseSession){
			var CourseTitle = CourseSession;
		});
	});
	
	$("#FilePicture").change(function(){
		var Picture = $("#FilePicture").val();
		$("#Data").text(Picture);
	});

	$("#FileSkip").click(function(){
		$.post("Registrar.php?SkipPicture",{DefaultPicture:"Default.png"},function(StudentData){
			$("#PopUpShade").fadeOut(200);
			$("#PopsError").val(null);
			ToZero();
		});
		$.post("Registrar.php?SessionKill",{ID:$("#IDNumber").text()},function(StudentData){
			document.getElementById("SubjectContentList").innerHTML = StudentData;
		});
	});

	$("#StudentIDNumber").keyup(function(){
		$.post("Cashier.php?StudentInfo",{StudentNumber:$("#StudentIDNumber").val()},function(StudentInfo){
			document.getElementById("StudentInformation").innerHTML = StudentInfo;
		});
		$.post("Cashier.php?RetrieveSubjectStudentData",{StudentIDNumber:$("#StudentIDNumber").val()},function(SubjectList){
			document.getElementById("EnrolledSubjectsList").innerHTML = SubjectList;
		}); // automatic Retrieving of enrolled subject listed
	})
	
	$("#BtnNext").click(function(){
		$("#AddStudentDropDown").fadeOut(100);
		$("#StudentInfoDropDown").fadeOut(100);
		$("#PopUp").hide(100); 
		$("#PopUpError").hide(100); 
		$("#PopUpPicture").show(100); 
		$("#SubjectContent").hide();
	})
	
	$("#AddSubject").click(function(){//SubjectStudentID
		$.post("Registrar.php?AddSubject",{CourseTitle:$("#StudentCourse").val(),StudentIDNumber:$("#IDNumber").text(),CourseCode:$("#SubjectSelect").val()},function(SubjectList){
			$.post("Registrar.php?RetrieveSubject",{StudentIDNumber:$("#IDNumber").text(),CourseTitle:$("#StudentCourse").val()},function(SubjectList){
				document.getElementById("SubjectContentList").innerHTML = SubjectList;
			}); // automatic Retrieving of enrolled subject listed
			$.post("Registrar.php?SubjectList",{CourseTitle:$("#StudentCourse").val(),StudentIDNumber:$("#IDNumber").text()},function(SubjectList){
				document.getElementById("SubjectList").innerHTML = SubjectList;
			});
			$.post("Registrar.php?CourseTipPlus1",{StudentIDNumber:$("#IDNumber").text(),StudentCourseCode:$("#SubjectSelect").val(),StudentCourseTitle:$("#StudentCourse").val()},function(RegistrationData){
				$("div#DescriptiveTitle").text(RegistrationData);
			});				
		});
	})

	$("#FacultyAddSubject").click(function(){
		$.post("Faculty.php?UpdateSubject",{CourseTitle:$("#StudentCourse").val(),CourseCode:$("#SubjectSelect").val(),Professor:$("#SubjectCourse").val()},function(SubjectList){
			document.getElementById("Instruct").innerHTML = SubjectList;
		});
	})


	$("#AddCourse").click(function(){
		$("#AddStudentDropDown").fadeOut(100);
		$("#PopUpShade").toggle(200).css({"background":"rgba(0,0,0,0.8)"});
		$("#StudentInfoDropDown").fadeOut(100);
		$("#PopUp").hide(100); 
		$("#PopUpError").hide(100);
		$("#PopUpPicture").hide(100); 
		$("#PopUpCourse").show();
		$("#EnrolledSubjectsList").hide();
	})

	$("#AddDoctoral").click(function(){
		$("#FacultyLoadingList").hide();
		$("#StudentsList").hide();
		$("#StudentsList").hide();
		$("#Registration").show();
		$.post("Registrar.php?CourseSelection",{Course:"Doctoral"},function(Data){
			document.getElementById("CourseSelection").innerHTML = Data;
		});
		$.post("Registrar.php?SessionAdd",{Program:"Doctoral"},function(SubjectList){
		});
		$.post("Registrar.php?StudentNumber",{Program:"D"},function(StudentNumber){
		//	$("#IDNumber").text(StudentNumber);
			//alert(StudentNumber);
		});
		$("#Registration").show();
		$("#AddStudentDropDown").fadeOut(100);
		$("#Program").text("Doctoral");
		$("#StudentInfoDropDown").fadeOut(100);
		$("#EnrolledSubjectsList").hide();
	})
	$("#AddMasteral").click(function(){
		$("#FacultyLoadingList").hide();
		$("#StudentsList").hide();
		$("#StudentsList").hide();
		$("#Registration").show();
		
		
		$.post("Registrar.php?CourseSelection",{Course:"Masteral"},function(Data){
			document.getElementById("CourseSelection").innerHTML = Data;
		});
		$.post("Registrar.php?SessionAdd",{Program:"Masteral"},function(SubjectList){
		});
		$.post("Registrar.php?StudentNumber",{Program:"M"},function(StudentNumber){
			//$("#IDNumber").text(StudentNumber);
			//alert(StudentNumber);
		});
		$("#Registration").show();
		$("#AddStudentDropDown").fadeOut(100);
		$("#Program").text("Masteral");
		$("#StudentInfoDropDown").fadeOut(100);
		$("#EnrolledSubjectsList").hide();
	})

	$("#CancelMe").click(function(){
		$.post("Registrar.php?SessionKill",{ID:$("#IDNumber").text()},function(StudentData){
			document.getElementById("SubjectContentList").innerHTML = StudentData;
		});
	})
		
	$("#AddGrade").click(function(){
		if($("#InputGrade").val() == null || $("#InputGrade").val() == ""){
			alert("No Grade input");
		}
		else{
			$.post("Faculty.php?AddGrade",{Grade:$("#InputGrade").val(),StudentID:$("#HiddenID").val(),Professor:$("#HiddenProfessor").val(),CourseCode:$("#HiddenCourseCode").val()},function(StudentData){
				$(".Floatright").text(StudentData);
				$("#Inputs").hide();
			});
		}
	})	

	$("#FacultyLoading").click(function(){
		$("#FacultyLoadingList").show();
		/*$("#StudentInformation").hide();
		$("#Registration").hide();
		$("#ViewDoctoral").hide();
		$("#ViewMasteral").hide();	*/
	})
	
	$("#AddButton").click(function(){
		$("#AddStudentDropDown").slideToggle(100);
		/*$("#StudentInfoDropDown").fadeOut(100); 
		$("#ChartDropDown").fadeOut(100);
		$("#EnrolledSubjectsList").hide();*/
	})
		
	$("#StudentInfo").click(function(){
		$("#StudentInfoDropDown").slideToggle(100);
		/*$("#ChartDropDown").fadeOut(100);
		$("#AddStudentDropDown").fadeOut(100);
		$("#EnrolledSubjectsList").hide();*/
	})
	
	$("#Doctoral").click(function(){
		$("#Locator").show();$("#StudentsList").show();
		$("#ViewDoctoral").show();
		/*$("#ViewMasteral").hide();	
		$("#FacultyLoadingList").hide();*/
		$("#StudentView").text("DOCTORAL");	
	})
	$("#Masteral").click(function(){
		$("#StudentInfoDropDown").slideToggle(100);
 		$("#Locator").show();$("#StudentsList").show();
		$("#ViewDoctoral").hide();
		$("#ViewMasteral").show();	 $("#FacultyLoadingList").hide();	
		$("#StudentInformation").hide();
		$("#StudentView").text("MASTERAL");	
	})
	$("#StudentView").click(function(){
		$("#Locator").show();
		$("#StudentInformation").hide();	
		$("#StudentView").text($("#StudentView").text());
		if($("#StudentView").text() == "DOCTORAL"){	
			$("#ViewDoctoral").show();
			$("#ViewMasteral").hide();	
		}
		else{
			$("#ViewDoctoral").hide();
			$("#ViewMasteral").show();	
		}
	})
	
	$(".SInfo").click(function(){
		var index = $(".SInfo").index(this),Units = $("#Hdn_units").val();
		$("#RecieptNumber"+index).keyup(function(){
			var OR = $("#RecieptNumber"+index).val();
			$.post("Registrar.php?Validation=OR",{OR:OR},function(Data){
				if(Data == 0){
					$("#ORMessage").html("<span class=\"label label-success\"><span class=\"glyphicon glyphicon-check\"></span> Valid receipt number</span>");
					$("#PrintUnits"+index).removeClass("disabled");
					$("#PrintGoodMoral"+index).removeClass("disabled");
					$("#PrintGrades"+index).removeClass("disabled");
					$("#PrintOTR"+index).removeClass("disabled");
				}
				else{
					$("#ORMessage").html("<span class=\"label label-danger\"><span class=\"glyphicon glyphicon-exclamation-sign\"></span> Invalid receipt number</span>");
					$("#PrintUnits"+index).addClass("disabled");
					$("#PrintGoodMoral"+index).addClass("disabled");
					$("#PrintGrades"+index).addClass("disabled");
					$("#PrintOTR"+index).addClass("disabled");
				}
			});
		});
		
		$("#PrintUnits"+index).click(function(){
			var OR = $("#RecieptNumber"+index).val(),SNO = $("#Hdn_SNO"+index).val(),Units = $("#Hdn_units"+index).val();
			$.post("Registrar.php?PrintUnits",{StudentIDNumber:SNO,Units:Units,OR:OR},function(Data){
				$("#PrintableUnits").html(Data);
				$("#ORX").text(OR);
				PrintDocx("PrintableUnits");
			});
		})		
		
		$("#PrintGoodMoral"+index).click(function(){
			var OR = $("#RecieptNumber"+index).val(),SNO = $("#Hdn_SNO"+index).val(),Units = $("#Hdn_units"+index).val();
			$.post("Registrar.php?PrintMoral",{StudentIDNumber:SNO,Units:Units,OR:OR},function(Data){
				$("#PrintableGoodMoral").html(Data);
				$("#MoralX").text(OR);
				PrintDocx("PrintableGoodMoral");
			});
		})	
			
		$("#PrintGrades"+index).click(function(){
			var OR = $("#RecieptNumber"+index).val(),SNO = $("#Hdn_SNO"+index).val(),Units = $("#Hdn_units"+index).val();
			$.post("Registrar.php?PrintGrades",{StudentIDNumber:SNO,Units:Units,OR:OR},function(Data){
				$("#PrintableGrades").html(Data);
				$("#GradeX").text(OR);
				PrintDocx("PrintableGrades");
			});
		})	
			
		$("#PrintOTR"+index).click(function(){
			var OR = $("#RecieptNumber"+index).val(),SNO = $("#Hdn_SNO"+index).val(),Units = $("#Hdn_units"+index).val();
			$.post("Registrar.php?PrintOTR",{StudentIDNumber:SNO,Units:Units,OR:OR},function(Data){
				$("#PrintableOTR").html(Data);
				$("#OTRX").text(OR);
				PrintDocx("PrintableOTR");
			});
		})		
	})
		
	
});


	function ToZero(){
		$("#SubjectSelect").val("");
		$("#StudentMonth").val("Month");
		$("#StudentDay").val("Day");
		$("#StudentYearOfBirth").val("Year");
		$("#StudentGender").val("Select Gender");
		$("#StudentCourse").val("Select Course");
		$("#StudentGivenName").val("");
		$("#StudentMiddleName").val("");
		$("#StudentFamilyName").val("");
		$("#StudentAddress").val("");
		$("#StudentMobileNumber").val("");
		$("#StudentGuardian").val("");
		$("#StudentGuardianContactNumber").val("");
	}
	
	function Bula(Message,ID){
		$(ID).text(Message);
		var Timer = setInterval(function(){$("#Program3").text("Adding a Course and Subjects");},2000);
	}
	function BulaMessage(Message,Message2,ID,Time){
		$(ID).text(Message);
		var Timer = setInterval(function(){$(ID).text(Message2)},Time);
	}
	function PrintDocx(ID){
		var prtContent = document.getElementById(ID);
		var WinPrint = window.open('', '', 'letf=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
		WinPrint.document.write(prtContent.innerHTML);
		WinPrint.document.close();
		WinPrint.focus();
		WinPrint.print();
		WinPrint.close();
	}
function InputDialog(Title,Message){
	$("#PopUpShade").show(200).css({"background":"rgba(0,0,0,0.8)"});
	$("#PopUpMessageInput").show(); $("#PopUpConfirmDialog").hide();
	$("span#PopUpTitleX").text(Title); $("span#PopUpInputMessageX").text(Message);	
}
function IsInt(Input){
	if(Math.floor(Input) == Input && $.isNumeric(Input))
		return true;
	else
		return false;
}
function FeedBackConfirm(Message){
	$("#PopUpShade").show(200).css({"background":"rgba(0,0,0,0.8)"});
	$("#PopUpInputDialog").hide(); $("#PopUpConfirmDialog").show();
	$("#PopUpTitleDialog").text(Message);
	$("#OK_BTN").click(function(){
		$("#PopUpShade").delay(500).hide(200);
		return true;
	})
	$("#CANCEL_BTN").click(function(){
		$("#PopUpShade").delay(500).hide(200);
		$("#HiddenConfirmValue").val("CANCEL");
	})
}

