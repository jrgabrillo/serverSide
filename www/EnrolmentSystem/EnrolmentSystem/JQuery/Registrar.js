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
			ModalAlert("Database is about to back up in just a minute.")					
		}
		if(Hours===16&&Minutes===0&&Seconds===0){
			ModalAlert("Back up on process.")					
			$.post("Registrar.php?BackUp",{},function(Data){
				if(Data == 1){
					$("#BackupDBX").html("Backup Database")
					ModalAlert("Finished back up process.")					
				}
			});		
		}
		$("#Timely").html(Hours+':'+Minutes+':'+Seconds);
	},1000);
	return false;
}

$( document).ready(function(e) {
	var Page = window.location.search;
	var Counter = 0;
	var url = window.location;
	var URL = "http://localhost/EnrolmentSystem/Registrar/";
	$("#NewStudentPicture").hide();

	if(Page == "?Dashboard"){
		var Counter = 1;
		var DBTimer = setInterval(function(){
			$("#ImageLoading").html("<br/>");
			Counter++;
			if((Counter%2)==0){
				console.log("even");
				$("#ImageFlip").css({"transform":"rotateY(0deg)"});	
			}
			else{
				console.log("odd");
				$("#ImageFlip").css({"transform":"rotateY(-180deg)"});
			}
		},6000);
	}

	$.post("Registrar.php?Time",function(Clock){
		var Clock = Clock.split(" "), Time = Clock[1].split(":");
		Hours = Number(Time[0]), Minutes = Number(Time[1]), Seconds = Number(Time[2]);
		TimeBackup(Hours,Minutes,Hours);
	});

    $.ajax({
        url: 'StudentList.php?StudentsList',
        type: 'POST',
        data: window.location.search,
        success: function(Data){
            var obj = JSON.parse(Data);
            $('#StudentsList').dataTable({
                data:obj.Students,
                columns: [
                    { data: 'Picture' },
                    { data: 'Name' },
                    { data: 'Course' },
                    { data: 'Option' },
                ]
            });
        }
    });   

    /*

	$.post("Registrar.php?StudentNumber",{Program:$("#Program").text()},function(StudentNumber){
		//$("#IDNumber").text(StudentNumber);
		//alert(StudentNumber);
	});
    */             
	
	$("#ReportGeneration").click(function(){
		$("#ChartDropDown").show();
		$("#ListType").show();
		/*
			$("#StudentInfoDropDown").fadeOut(100); 
			$("#AddStudentDropDown").fadeOut(100);
			$("#EnrolledSubjectsList").hide();
		*/

		$("#ChartType").click(function(){
			$("#ChartTypeDropDown").toggle();
			$("#ListTypeDropDown").hide();		
		})
		
		$("#ListType").click(function(){
			$("#ChartTypeDropDown").hide();
			$("#ListTypeDropDown").toggle();		
		})	
	})
	
	$("#OldInputStudent").keyup(function(){
		if($("#OldInputStudent").val().length == 12){
		}
		else if($("#OldInputStudent").val().length != 12){
			$("#OldStudentInformation").text(""); $("#OldCourseInputs").hide();
		}
	})

	$("#ShifterAddMe").click(function(){
		var Num = $("#ShifterSubjects").val(), Counter=0, Checked = "";
		for(x=0;x<Num;x++){
			Counter=Counter+" / "+$("#ShifterCheckBoxChoose"+x).prop('checked')+" = "+$("#ShifterCheckBoxChoose"+x).val();
			if($("#ShifterCheckBoxChoose"+x).prop('checked') == true){
				Checked = Checked+$("#ShifterCheckBoxChoose"+x).val()+'/';
			}
		}
		if(Checked == null || Checked == ""){
			alert("No Subject enrolled.");
			$(".CheckBoxChoose").focus();
		}
		else{
			$.post("Registrar.php?ShifterAddSubjects",{NewCourse:$("#ShifterSelectedCourse").val(),StudentIDNumber:$("#StudentIDInput").val(),StudentCourseCode:Checked},function(RegistrationData){
				$.post("Registrar.php?OldAddSubjects",{StudentIDNumber:$("#StudentIDInput").val(),StudentCourseCode:Checked},function(RegistrationData){
					$.post("Registrar.php?OldPrint",{StudentIDNumber:$("#StudentIDInput").val(),StudentCourseCode:Checked},function(StudentData){
						$("#OldPrintable").html(StudentData)
						var prtContent = document.getElementById("OldPrintable");
						var WinPrint = window.open('', '', 'letf=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
						WinPrint.document.write(prtContent.innerHTML);
						WinPrint.document.close();
						WinPrint.focus();
						WinPrint.print();
						WinPrint.close();
						WinPrint.document.close();
					});
				});
			});
		}
		//Get The Copy of Shifting Students Documents
	})

	$("#OldAddSubject").click(function(){//SubjectStudentID
		var StudentIDNumber = $("#StudentIDInput").val(), CourseCode = $("#OldSubjectSelect").val();
		//alert(StudentIDNumber+" = "+CourseCode);
		$.post("Registrar.php?OldAddSubject",{StudentIDNumber:StudentIDNumber,CourseCode:CourseCode},function(SubjectList){
			$.post("Registrar.php?OldRetrieveSubject",{StudentIDNumber:StudentIDNumber},function(SuggestedSubjectList){
				$("#OldSubjectContentList").html(SuggestedSubjectList);
			}); // automatic Retrieving of enrolled subject listed

			$.post("Registrar.php?OldSubjectList",{StudentIDNumber:StudentIDNumber},function(SubjectList){
				$("#OldSubjectList").html(SubjectList);

				$.post("Registrar.php?OldCourseTip",{StudentIDNumber:StudentIDNumber,StudentCourseCode:$("#OldSubjectSelect").val()},function(RegistrationData){
					$("div#OldDescriptiveTitle").text(RegistrationData);
				});				
				$("#OldSubjectSelect").change(function(){
					$.post("Registrar.php?OldCourseTip",{StudentIDNumber:StudentIDNumber,StudentCourseCode:$("#OldSubjectSelect").val()},function(RegistrationData){
						$("div#OldDescriptiveTitle").text(RegistrationData);
					});				
				})
			});


		});
	})
	
	$("#OldAddMe").click(function(){
		var Num = $("#OldTmpEnrolledRow").val(), Counter=0, Checked = "";
		for(x=0;x<Num;x++){
			Counter=Counter+" / "+$("#OldCheckBoxChoose"+x).prop('checked')+" = "+$("#OldCheckBoxChoose"+x).val();
			if($("#OldCheckBoxChoose"+x).prop('checked') == true){
				Checked = Checked+$("#OldCheckBoxChoose"+x).val()+'/';
			}
		}
		if(Checked == null || Checked == ""){
			$(".CheckBoxChoose").focus();
		}
		else{
			$.post("Registrar.php?OldAddSubjects",{StudentIDNumber:$("#StudentIDInput").val(),StudentCourseCode:Checked},function(RegistrationData){
				$.post("Registrar.php?OldPrint",{StudentIDNumber:$("#StudentIDInput").val(),StudentCourseCode:Checked},function(StudentData){
					$("#OldPrintable").html(StudentData)
					var prtContent = document.getElementById("OldPrintable");
					var WinPrint = window.open('', '', 'letf=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
					WinPrint.document.write(prtContent.innerHTML);
					WinPrint.document.close();
					WinPrint.focus();
					WinPrint.print();
					WinPrint.close();
					WinPrint.document.close();
					$("#OldStudentData").addClass("hidden"); $("#ShifterData").addClass("hidden");
					$("#StudentIDInput").val("");
					$("#StudentIDInput").addClass("hidden"); $("#IDNumber").addClass("hidden");
				});
			});
		}
	})
	
	$("#OldCancelMe").click(function(){
		$("#NewStudent").addClass('hidden'); $("#OldStudentData").addClass('hidden'); $("#OldInputStudent").addClass('hidden');
		$("#NewStudent").removeClass('hidden');
		$("#AddStudentSessionChecker").val("OFF");
		$.post("Registrar.php?SessionKill",{ID:$("#IDNumber").text()},function(StudentData){
			document.getElementById("SubjectContentList").innerHTML = StudentData;
		});
		$("#StudentIDInput").val("");$("#StudentType").val("New");
		$("#PopUpShade").fadeOut(200);
	})	

	$(".FinalizeBTN").click(function(){
		var index = $(".FinalizeBTN").index(this), Program = $.trim($("#FinalizeStudentProgram").text()), StudentIDNumber = $.trim($("#StudentIDNumber"+index).text());
		$("#StudentCourse"+index).change(function(){
			$.post("Registrar.php?SuggestedSubjects",{CourseTitle:$("#StudentCourse").val(),StudentIDNumber:StudentIDNumber},function(SuggestedSubjectList){
			});
			$.post("Registrar.php?RetrieveSubject",{StudentIDNumber:StudentIDNumber,CourseTitle:$("#StudentCourse"+index).val()},function(SuggestedSubjectList){
				$("#SubjectContentList"+index).html(SuggestedSubjectList);
			}); // automatic Retrieving of enrolled subject listed
			
			$.post("Registrar.php?SubjectList",{Index:index,CourseTitle:$("#StudentCourse"+index).val(),StudentIDNumber:StudentIDNumber},function(SubjectList){
				$("#SubjectList"+index).html(SubjectList);

				$("#SubjectSelect"+index).change(function(){
					$.post("Registrar.php?CourseTip",{StudentCourseCode:$("#SubjectSelect"+index).val(),StudentCourseTitle:$("#StudentCourse"+index).val()},function(RegistrationData){
						$("div#DescriptiveTitle"+index).text(RegistrationData);
					});				
				})

				$.post("Registrar.php?CourseTip",{StudentCourseCode:$("#SubjectSelect"+index).val(),StudentCourseTitle:$("#StudentCourse"+index).val()},function(RegistrationData){
					$("div#DescriptiveTitle"+index).text(RegistrationData);
				});	
			});

			$.post("Registrar.php?RegistrationCourse",{StudentCourse:$("#StudentCourse").val()},function(RegistrationData){
			});	
		})

		$("#AddSubject"+index).click(function(){//SubjectStudentID
			$.post("Registrar.php?AddSubject",{CourseTitle:$("#StudentCourse"+index).val(),StudentIDNumber:StudentIDNumber,CourseCode:$("#SubjectSelect"+index).val()},function(SubjectList){
				$.post("Registrar.php?RetrieveSubject",{StudentIDNumber:StudentIDNumber,CourseTitle:$("#StudentCourse"+index).val()},function(SubjectList){
					$("#SubjectContentList"+index).html(SubjectList);
				}); // automatic Retrieving of enrolled subject listed

				$.post("Registrar.php?SubjectList",{Index:index,CourseTitle:$("#StudentCourse"+index).val(),StudentIDNumber:StudentIDNumber},function(SubjectList){
					$("#SubjectList"+index).html(SubjectList);
				});

				$.post("Registrar.php?CourseTipPlus1",{StudentIDNumber:StudentIDNumber,StudentCourseCode:$("#SubjectSelect"+index).val(),StudentCourseTitle:$("#StudentCourse"+index).val()},function(RegistrationData){
					$("div#DescriptiveTitle"+index).text(RegistrationData);
				});				
			});
		})

		$("#AddMe"+index).tooltip('show');

		$("#AddMe"+index).click(function(){
			var URL = window.location;
			var Num = $("#TmpEnrolledRow").val(), Counter=0, Checked = "";
			for(x=0;x<Num;x++){
				Counter=Counter+" / "+$("#CheckBoxChoose"+x).prop('checked')+" = "+$("#CheckBoxChoose"+x).val();
				if($("#CheckBoxChoose"+x).prop('checked') == true){
					Checked = Checked+$("#CheckBoxChoose"+x).val()+'/';
				}
			}
			$.post("Registrar.php?Registration",{StudentIDNumber:StudentIDNumber,StudentProgram:Program,EnrolledSubjects:Checked,CourseTitle:$("#StudentCourse"+index).val(),CodeGen:$("#CodeGen").val()},function(RegistrationData){
				alert("Enrollment process has been completed.");
				window.location.assign(URL);
				$('#Modal'+index).modal('hide');
			})
		})

		$('#Modal'+index).on('hide.bs.modal',function(e) {
			$(".CompleteArea").html(" ");
		})
	})
	
	$(".RatingChoices").hide();
	$(".EnterRating").click(function(){
		$(".EnterRating").show();
		$(".RatingChoices").hide();
		$("#Ratingx"+index).show();
		var index = $(".EnterRating").index(this);
		$("#Ratingx"+index).hide();
		$("#Rating"+index).show(200);
		$("input#BTN_Rating"+index).click(function(){
			var Rating = $("select#RatingChoice"+index).val(), RatingConfirm = confirm("Are you sure?"), StudentIDNumber = $.trim($("#RatingStudentIDNumber").val()), Subject = $.trim($("#RatingSubject"+index).text()), CourseTitle = $("#RatingCourseTitle").val(),Code = $("#RatingCode").val();
			if(RatingConfirm){
				$.post("Registrar.php?TmpRating",{Rating:Rating,Subject:Subject,CourseTitle:CourseTitle,Code:Code,StudentIDNumber:StudentIDNumber},function(Data){
					BulaMessage("Successfully Rated.",Rating,$("#Rating"+index),3000);
					$("#Rating"+index).delay(1000).hide(100);
					$("#Ratingx"+index).delay(1500).show(100);
					$("#Rated"+index).text(Rating);
				});		
				
				
			}
		})
	
		$("input#BTN_RatingCancel"+index).click(function(){
			$("#Ratingx"+index).show();$("#Rating"+index).hide();
		})
	})
	
	$("#BtnCourseOkX").click(function(){
		var ErrorCount = 0,
		FCourse = $("input#CourseTitleX").val(),
		FCourseTitle = $("select#ProgramTitleX").val(),
		FCourseCode = $("input#CourseCodeX").val(),
		FDescriptiveTitle = $("input#DescriptiveTitleX").val(),
		FCourseUnits = $("select#CourseUnitsX").val(),Lab = 0;
				
		if($("input#CHKCourseX").prop('checked') == true) Lab = 1;
		else Lab = "";

		$.post("Registrar.php?Course",{Course:FCourse,CourseProgram:FCourseTitle,CourseCode:FCourseCode,Lab:Lab,DescriptiveTitle:FDescriptiveTitle,CourseUnits:FCourseUnits},function(CourseData){
			$("#DataContainer").append(CourseData)
			ToZero(); $("input#CourseCodeX").val(""); $("input#DescriptiveTitleX").val("");
			$.post("Registrar.php?CourseList",{CourseTitle:$("input#CourseTitleX").val()},function(CourseList){
				$("#CourseContent").html(CourseList);
			});
		});
	});

	if(window.location == 'http://localhost/EnrolmentSystem/Registrar/?AddCourse'){
		$.post("Registrar.php?CourseList",{CourseTitle:""},function(CourseList){
			$("#CourseContent").html(CourseList);
		});	
	}

	var URL = "http://localhost/EnrolmentSystem/Registrar/";
	if(window.location == URL+'?ChartSemester'){
		$("#Data1Marker1").css({"background":"rgba(255,153,0,0.5)"}); $("#Data1Marker2").css({"background":"rgba(0,153,204,0.8)"});
		var ChartX = $("#Chart1").get(0).getContext("2d"),
		d1v1 = $.trim($("#Chart1Data1").text()), d1v2 = $.trim($("#Chart1Data2").text()),
		Data1 = [{value: +d1v1,color:"rgba(255,153,0,0.5)",label:Percentage(d1v1,(Number(d1v1)+Number(d1v2)))+"%"},{value : +d1v2,color : "rgba(0,153,204,0.8)",label:Percentage(d1v2,(Number(d1v1)+Number(d1v2)))+"%"}];
	}
	else if(window.location == URL+'?ChartCourse'){
		var DataColors = new Array("rgba(255,153,0,0.5)","rgba(0,153,204,0.8)","rgba(0,0,0,0.3)","rgba(0,102,0,0.2)","rgba(0,102,102,0.8)","rgba(102,0,0,0.8)","rgba(153,0,0,0.8)","rgba(255,255,0,0.8)","rgba(255,102,0,0.8)","rgba(255,102,153,0.8)","rgba(0,255,255,0.8)","rgba(102,0,255,0.8)","#E2EAE9","#D4CCC5","#949FB1","#4D5360"), DataX = new Array(), DataY = new Array();

		for(x=0;x<$("#Chart2Data1").val();x++){
			if(+$.trim($("#ChartMasteral"+x).text()) == 0){
				$("#DataMarker"+x).css({"background":DataColors[x]});	
				DataX.push({"value":0.02,"color":DataColors[x],"label":""});
			}
			else{
				$("#DataMarker"+x).css({"background":DataColors[x]});	
				DataX.push({"value":+$.trim($("#ChartMasteral"+x).text()),"color":DataColors[x],"label":Percentage(+$.trim($("#ChartMasteral"+x).text()),+$.trim($("#Chart2DataTotal1").text()))+"%"});
			}
		}
		for(x=0;x<$("#Chart2Data2").val();x++){
			if(+$.trim($("#ChartDoctoral"+x).text()) == 0){
				$("#DataMarker2"+x).css({"background":DataColors[x]});	
				DataY.push({"value":0.02,"color":DataColors[x],"label":""});
			}
			else{
				$("#DataMarker2"+x).css({"background":DataColors[x]});
				DataY.push({"value":+$.trim($("#ChartDoctoral"+x).text()),"color":DataColors[x],"label":Percentage(+$.trim($("#ChartDoctoral"+x).text()),+$.trim($("#Chart2DataTotal2").text()))+"%"});
			}
		}

		var ChartX = $("#Chart2A").get(0).getContext("2d");
		var ChartY = $("#Chart2B").get(0).getContext("2d");
		for(x=0;x<DataX.length;x++){
			var Data1 = DataX;
		}
		for(x=0;x<DataY.length;x++){
			var Data2 = DataY;
		}
		new Chart(ChartX).Pie(Data1);
		new Chart(ChartY).Pie(Data2);
	}
	else if(window.location == URL+'?ChartYear'){
		var ChartX = $("#Chart3A").get(0).getContext("2d"), ChartY = $("#Chart3B").get(0).getContext("2d"),
		d3v1 = $.trim($("#Chart3Data1").text()),d3v2 = $.trim($("#Chart3Data2").text()), 
		d3v3 = $.trim($("#Chart3Data3").text()),d3v4 = $.trim($("#Chart3Data3").text());
		var label1 = "", label2 = "", label3 = "", label4 = "";

		if(d3v1 == 0){d3v1 = 1; label1 = 0+"%";}
		else{label1 = Percentage(+d3v1,(Number(d3v1)+Number(d3v2)))+"%";}
		if(d3v2 == 0){d3v2 = 1; label2 = 0+"%";}
		else{label2 = Percentage(+d3v2,(Number(d3v1)+Number(d3v2)))+"%";}
		$("#Data3Marker1").css({"background":"rgba(255,153,0,0.5)"}); $("#Data3Marker2").css({"background":"rgba(0,153,204,0.8)"});
		var Data1 = [{value:+d3v1,color:"rgba(255,153,0,0.5)",label:label1},{value : +d3v2,color : "rgba(0,153,204,0.8)",label:label2}];
		
		if(d3v3 == 0){d3v3 = 1; label3 = 0+"%";}
		else{label3 = Percentage(+d3v3,(Number(d3v3)+Number(d3v4)))+"%";}
		if(d3v4 == 0){d3v4 = 1; label4 = 0+"%";}
		else{label4 = Percentage(+d3v3,(Number(d3v3)+Number(d3v4)))+"%";}
		$("#Data3Marker3").css({"background":"rgba(255,153,0,0.5)"}); $("#Data3Marker4").css({"background":"rgba(0,153,204,0.8)"});
		var Data2 = [{value:+d3v3,color:"rgba(255,153,0,0.5)",label:label3},{value:+d3v4,color : "rgba(0,153,204,0.8)",label:label4}];
		
		new Chart(ChartX).Pie(Data1);
		new Chart(ChartY).Pie(Data2);
	}
	new Chart(ChartX).Pie(Data1);

})

function Validation(ID,ErrorID,ErrorID2,FieldName){
	if(ID.val() == null || ID.val() == ""){
		ID.focus();
		ErrorID.text(FieldName+" is required.");
		return 1;
	}
	else if(ID.val() != null || ID.val() != ""){
		//document.getElementById(ErrorID2).innerHTML = '<br/>';
		return 0;
	}
}
function BulaMessage(Message,Message2,ID,Time){
	$(ID).text(Message);
	var Timer = setInterval(function(){$(ID).text(Message2)},Time);
}
function FeedBack(Message1,Message2){
	$("#PopUpShade").show(200).css({"background":"rgba(0,0,0,0.8)"});
	$("#PopUpInputDialog").hide(); $("#PopUpConfirmDialog").hide();
	BulaMessage(Message1,Message2,$("#PopUpMessage"),1000);
	$("#PopUpShade").delay(2000).hide(200);
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
function IsInt(Input){
	if(Math.floor(Input) == Input && $.isNumeric(Input))
		return true;
	else
		return false;
}
function Percentage(Value,Total){
	if(IsInt(Value) == true){
		if(IsInt(Total) == true){
			var x = (Value * 100)/Total;
			return x.toFixed(2);
		}
	}
	else{
		return "Invalid value to percentage";
	}	
}
