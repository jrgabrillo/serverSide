function ModalAuthorize(Content){
	if(Content!=="")
	    $("#AuthorizeText").html(Content);
    $("#ModalAuthorize").modal("show");
}

function ModalAlert(Content){
    $("#ModalAlert").modal("show");
    $("#Modal_BodyUniversal").html(Content);
}

$(document).ready(function(e) {
	var URL = window.location;
	if(URL.pathname == "/EnrolmentSystem/Faculty/"){
		if(URL.search == '?FacultyReport'){
			$.post("Faculty.php?SetSessionConfirm",{Data:"OFF"},function(Data){})
			$("#DataContainer").addClass("hidden");
			$("#DataReport").removeClass("hidden");
			$("#SubmitGrades").addClass("hidden");

			$("#FacultyReportYear").change(function(){
				if($("#FacultyReportYear").val() != "Select year/sem"){
					$("#DataReportResult").html("");
					var Data = Array($("#FacultyReportYear").val(),$("#FacultyName").val());
					$.post("../Registrar/Registrar.php?FacultyReport",{Data:Data},function(Data){
						$("#DataReportResult").html(Data);
					});
				}
				else{
					$("#DataReportResult").html("<p class='text-center'>No Result</p>");
				}
			})
		}
		else if(URL.search == '?SubmitGrades'){
			$("#DataContainer").addClass("hidden");
			$("#DataReport").addClass("hidden");
			$("#SubmitGrades").removeClass("hidden");

			$("#Button_RegistrarAuthCode2").click(function(){
				$.post("../Registrar/Registrar.php?ConfirmToRegistrar",{Data:$("#RegistrarAuthCode2").val()},function(Data){
					if(Data == 1){
						$.post("Faculty.php?SetSessionConfirm",{Data:"ON"},function(Data){})
						$("#Notification_RegistrarAuthCode2").html("");
						$("#RegistrarAuthCode2Form").addClass("hidden");
						StudentsNoGradesList();
					}
					else{
						$("#RegistrarAuthCode2").val("");
						$("#Notification_RegistrarAuthCode2").html("Incorrect Authorization Code");
					}
				});
			})
			
			if($("#AuthorizationCodeStatus").val() === "ON"){
				$("#Notification_RegistrarAuthCode2").html("");
				$("#RegistrarAuthCode2Form").addClass("hidden");
				StudentsNoGradesList();
			}
		}
		else{
			$.post("Faculty.php?SetSessionConfirm",{Data:"OFF"},function(Data){})
			$.post("Faculty.php?StudentList",{},function(Data){
				$("#StudentsList").html(Data);
			
				$(".RatingInput").hide();
				$("input.Input").click(function(){
					var index = $("input.Input").index(this);
					console.log(index);
					$("span#Rating"+index).hide();
					$(".ReExam").hide(200);
					$(".Input").show(100);
					$(".RatingInput").hide(); $("#Input"+index).hide(100);
					$("#RatingInput"+index).show(100);

					$("#RateMe"+index).click(function(){
						var Rating = $("#Rating"+index).html();
						console.log(Rating);
						if(Rating === ""){
							$.post("Faculty.php?StudentRating",{TNO:$("#StudentsSubject"+index).val(),Rating:$("#RatingChoices"+index).val()},function(Data){
								$("span#Rating"+index).show();
								BulaMessage("Success!",$("#RatingChoices"+index).val(),$("span#Rating"+index),3000);
								$(".Input").show();
								$("span#Rating"+index).show();
								$(".Input").show();
								$("#Input"+index).val("Update Rating");
								$("#RatingInput"+index).hide();
							});
						}
						else{
						    ModalAuthorize();
						    $("#Button_Execute").click(function(){
						        $("#ModalAuthorize").modal("hide");
								$.post("../Registrar/Registrar.php?ConfirmToRegistrar",{Data:$("#RegistrarAuthCode").val()},function(Data){
									console.log(Data);
									$("#RegistrarAuthCode").val("");
									if(Data == 1){
										$.post("Faculty.php?StudentRating",{TNO:$("#StudentsSubject"+index).val(),Rating:$("#RatingChoices"+index).val()},function(Data){
											$("span#Rating"+index).show();
											BulaMessage("Success!",$("#RatingChoices"+index).val(),$("span#Rating"+index),3000);
											$(".Input").show();
											$("span#Rating"+index).show();
											$(".Input").show();
											$("#RatingInput"+index).hide();
										});
									}
									else{
								        $("#ModalAuthorize").modal("hide");
										ModalAlert("Invalid authorization code");
									}
								});
						    });
						}
					})
					$("#RateCancel"+index).click(function(){
						$("span#Rating"+index).show();
						$(".ReExam").show(200);
						$(".Input").show();
						$("#RatingInput"+index).hide();
					})
				})
				$(".ReExam").click(function(){
					var index = $(".ReExam").index(this),StudentID = $("#StudentsSubject"+index).val();
					console.log(StudentID);
					$("input.Input").hide();
					$(".ReExam").hide();	
					$("#RatingInput"+index).show(100);
					$("#ReExamNote"+index).html("<br/>Re-Exam Rating:");
					$("#RateMe"+index).click(function(){
						var Rating = $("#Rating"+index).html();
					    ModalAuthorize("You are about to enter the student's Re-exam rating. Once you enter the re-exam grade, you cannot alter the rating anymore. To verify your action, please enter the authorization code.");
					    $("#Button_Execute").click(function(){
					        $("#ModalAuthorize").modal("hide");
							$.post("../Registrar/Registrar.php?ConfirmToRegistrar",{Data:$("#RegistrarAuthCode").val()},function(Data){
								console.log(Data);
								$("#RegistrarAuthCode").val("");
								if(Data == 1){
									$.post("Faculty.php?StudentReExamRating",{TNO:$("#StudentsSubject"+index).val(),Rating:$("#RatingChoices"+index).val()},function(Data){
										$("span#Rating"+index).show();
										BulaMessage("Success!","INC/"+$("#RatingChoices"+index).val(),$("span#Rating"+index),3000);
										$("span#Rating"+index).show();
										$("#RatingInput"+index).hide();
										$("input.Input").hide();
										$("#ReExamNote"+index).html("");
									});
								}
								else{
							        $("#ModalAuthorize").modal("hide");
									ModalAlert("Invalid authorization code");
								}
							});
					    });
					})
					$("#RateCancel"+index).click(function(){
						$("#ReExamNote"+index).html("");
						$("span#Rating"+index).show();
						$(".ReExam").show(200);
						$(".Input").show();
						$("#RatingInput"+index).hide();
					})
				})
			});
			$("#DataContainer").removeClass("hidden");
			$("#DataReport").addClass("hidden");
			$("#SubmitGrades").addClass("hidden");
		}
	}
});

function StudentsNoGradesList(){
	$.post("Faculty.php?StudentNoRatingList",{},function(Data){
		$("#StudentsNoGradesList").html(Data);
		$(".RatingInput").hide();
		$("input.Input").click(function(){
			var index = $("input.Input").index(this);
			$("span#Rating"+index).hide();
			$(".ReExam").hide(200);
			$(".Input").show(100);
			$(".RatingInput").hide(); $("#Input"+index).hide(100);
			$("#RatingInput"+index).show(100);

			$("#RateMe"+index).click(function(){
				var Rating = $("#Rating"+index).html();
				if(Rating === ""){
					$.post("Faculty.php?StudentRating",{TNO:$("#StudentsSubject"+index).val(),Rating:$("#RatingChoices"+index).val()},function(Data){
						StudentsNoGradesList();
						$("span#Rating"+index).show();
						BulaMessage("Success!",$("#RatingChoices"+index).val(),$("span#Rating"+index),3000);
						$(".Input").show();
						$("span#Rating"+index).show();
						$(".Input").show();
						$("#Input"+index).val("Update Rating");
						$("#RatingInput"+index).hide();
					});
				}
				else{
					$.post("Faculty.php?StudentRating",{TNO:$("#StudentsSubject"+index).val(),Rating:$("#RatingChoices"+index).val()},function(Data){
						StudentsNoGradesList();
						$("span#Rating"+index).show();
						BulaMessage("Success!",$("#RatingChoices"+index).val(),$("span#Rating"+index),3000);
						$(".Input").show();
						$("span#Rating"+index).show();
						$(".Input").show();
						$("#RatingInput"+index).hide();
					});
				}
			})
			$("#RateCancel"+index).click(function(){
				$("span#Rating"+index).show();
				$(".ReExam").show(200);
				$(".Input").show();
				$("#RatingInput"+index).hide();
			})
		})
		$(".ReExam").click(function(){
			var index = $(".ReExam").index(this),StudentID = $("#StudentsSubject"+index).val();
			$("input.Input").hide();
			$(".ReExam").hide();	
			$("#RatingInput"+index).show(100);
			$("#ReExamNote"+index).html("<br/>Re-Exam Rating:");
			$("#RateMe"+index).click(function(){
			var Rating = $("#Rating"+index).html();

			$.post("Faculty.php?StudentReExamRating",{TNO:$("#StudentsSubject"+index).val(),Rating:$("#RatingChoices"+index).val()},function(Data){
				StudentsNoGradesList();
				$("span#Rating"+index).show();
				BulaMessage("Success!","INC/"+$("#RatingChoices"+index).val(),$("span#Rating"+index),3000);
				$("span#Rating"+index).show();
				$("#RatingInput"+index).hide();
				$("input.Input").hide();
				$("#ReExamNote"+index).html("");
			});
			})
			$("#RateCancel"+index).click(function(){
				$("#ReExamNote"+index).html("");
				$("span#Rating"+index).show();
				$(".ReExam").show(200);
				$(".Input").show();
				$("#RatingInput"+index).hide();
			})
		})
	});
}

function BulaMessage(Message,Message2,ID,Time){
	ID.text(Message);
	var Timer = setInterval(function(){ID.text(Message2)},Time);
}
