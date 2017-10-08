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

$(document).ready(function(e) {

	$.post("../Cashier/Cashier.php?Time",function(Clock){
		var Clock = Clock.split(" "), Time = Clock[1].split(":");
		Hours = Number(Time[0]), Minutes = Number(Time[1]), Seconds = Number(Time[2]);
		TimeBackup(Hours,Minutes,Hours);
	});

	$("#PrintMe").hide(); $("#ScholarshipOther").hide(); $("#PercentageOther").hide();$("#PercentageSelect").hide();

	$.post("Assessment.php?StudentInfo",{AssessmentCode:$("#AssessmentCode").val()},function(StudentInfo){
		$("#StudentInformation").html(StudentInfo);
	});

	$("#AssessmentCode").keyup(function(){
		if($("#AssessmentCode").val().length == 6){
			$("#PrintMe").show();
		}
		else if($("#AssessmentCode").val().length != 6){
			$("#PrintMe").hide();
		}
		$.post("Assessment.php?StudentInfo",{AssessmentCode:$("#AssessmentCode").val()},function(StudentInfo){
			$("#StudentInformation").html(StudentInfo);
		});
		$.post("Assessment.php?RetrieveSubjectStudentData",{AssessmentCode:$("#AssessmentCode").val()},function(SubjectList){
			$("#EnrolledSubjectsList").html(SubjectList);

			$.post("AssessmentPrinting.php?PrintAssessment",{AssessmentCode:$("#AssessmentCode").val()},function(SubjectList){
				$("#PrintStudentInformation").html(SubjectList);
			});

			$.post("Assessment.php?StudentScholarshipForm",{AssessmentCode:$("#AssessmentCode").val()},function(Data){
				$("#ScholarshipTable").html(Data);

				$("#Scholarship").change(function(){
					console.log($("#Scholarship").val());
					if($("#Scholarship").val() == "Others"){
						 $("#ScholarshipOther").removeClass('hidden');
					}
					else{
						 $("#ScholarshipOther").addClass('hidden');
					}

					if($("#Scholarship").val() == "No Scholarship"){
						 $("#PercentageSelect").addClass('hidden');
						 $("#ScholarshipOther").addClass('hidden');
					}
					else if($("#Scholarship").val() != "No Scholarship"){
						 $("#PercentageSelect").removeClass('hidden');
					}
				})

				$("#Percentage").change(function(){
					if($("#Percentage").val() == "Others"){
						$("#PercentageOther").removeClass('hidden');
					}
					else if($("#Percentage").val() != "Others"){
						$("#PercentageOther").addClass('hidden');
					}
				})

				$("#StudentScholarship").click(function(){
					var ScholarshipValue = $("#Scholarship").val(), 
						PercentageValue = $("#Percentage").val(), 
						TuitionFeeValue = Number($("#TmpTuitionFee").html()), 
						MiscFeeValue = Number($("#TmpMiscFee").html()), 
						TotalDiscount = 0,
						FinalTuition = 0,
						FinalFee = 0;

					if(ScholarshipValue == "Others")
						ScholarshipValue = $("#ScholarshipOtherInput").val();

					if(PercentageValue == "Others")
						PercentageValue = $("#PercentageOtherInput").val();

					var ScholarshipArray = Array(ScholarshipValue,Number(PercentageValue),TuitionFeeValue,MiscFeeValue);

					TotalDiscount = ScholarshipArray[2]*(ScholarshipArray[1]*0.01);
					FinalTuition = ScholarshipArray[2]-TotalDiscount;
					FinalFee = FinalTuition+MiscFeeValue;

					$("#TotalTuitionFeeNotice").html(ScholarshipArray[1]+"% discount on "+ScholarshipArray[0]+" &nbsp;");
					$("#TotalTuitionFee").html(FinalTuition);
					$("#TmpTotalFee").html(FinalFee);

					$("#TotalTuitionFeeNotice2").html(ScholarshipArray[1]+"% discount on "+ScholarshipArray[0]+" &nbsp;");
					$("#TotalTuitionFee2").html(FinalTuition);
					$("#TmpTotalFee2").html(FinalFee);

					$("#PrintMe").focus();
				});

			});

			$("#PrintAssessed").click(function( event ) {
				ScholarshipValue = $("#Scholarship").val();
				PercentageValue = $("#Percentage").val()

				if(ScholarshipValue == "Others")
					ScholarshipValue = $("#ScholarshipOtherInput").val();

				if(PercentageValue == "Others")
					PercentageValue = $("#PercentageOtherInput").val();

				var ArrayAssessment = Array(Number($("#TotalTuitionFee").html()),Number($("#TotalMiscFee").html()),$("#AssessmentCode").val(),ScholarshipValue,PercentageValue);

				$.ajax({
					url:'Assessment.php?SaveAssessed',
					type:'POST',
					data:{Data:ArrayAssessment},
					success: function(Data){
						console.log(Data);
						if(Data == 1){
			                PrintDocx('PrintStudentInformation');
							$.post("Assessment.php?StudentInfo",{AssessmentCode:""},function(Data){
								$("#StudentInformation").html(Data);
							})
			                $("#ScholarshipTable").html("");
			                $("#AssessmentCode").val("");
							$("#StudentInformation").html("");
							$("#EnrolledSubjectsList").html("");
						}
			            else
							Modal_Alert("System","An error occured during the process. Please seek developer's help.");
					}
				})
			})
		});
	})
	
	$("#SearchBox").keyup(function(e){
		if($("#SearchBox").val() == ""){
			$("#SearchResult").addClass("hidden")
			$("#RegistrarContent").removeClass("hidden")
		}
		else{
			$("#SearchResult").removeClass("hidden")
			$("#RegistrarContent").addClass("hidden")

			$.ajax({
				url:'../PhpFiles2/Process.php?Search',
				type:'POST',
				data:{Data:$("#SearchBox").val()},
				success: function(Data){
					$("#SearchResult").html(Data)

				}
			})
		}
	})

    $( "body" ).click(function( event ) {
        var Hash = event.target.hash;
        var Page = window.location;
        if(typeof Hash !== "undefined" && Hash !== ""){
            var Hashes = Hash.split('#'), Reply = 1;
            if(Hashes[1] == "ViewProfile"){
                $.post("../Cashier/Cashier.php?StudentFee",{Data:Hashes[2]},function(Data){
                	Modal_lg('Assessment of fees',Data);
                });
            }
        }

        var Fee = event.target.id;
        var Fee = Fee.split("_");
        if(Fee[0] === "FeeListValue"){
        	var FeeValue = $("#"+event.target.id);
        	var MiscValue = Number($("#TmpMiscFee").html());
        	var TuitionValue = Number($("#TotalTuitionFee").html());
	        if(FeeValue.prop("checked") == true){
	        	FeeValue = Number(FeeValue.val());
	        	$("#TmpMiscFee").html(MiscValue+FeeValue);
	        	$("#TotalMiscFee").html(MiscValue+FeeValue);
	        	$("#TmpTotalFee").html((MiscValue+FeeValue)+TuitionValue);
	        	$("#FeeListRow_"+Fee[1]).removeClass("hidden");	        	

	        	$("#TmpMiscFee2").html(MiscValue+FeeValue);
	        	$("#TotalMiscFee2").html(MiscValue+FeeValue);
	        	$("#TmpTotalFee2").html((MiscValue+FeeValue)+TuitionValue);
	        }
	        else{
	        	FeeValue = Number(FeeValue.val());
	        	$("#TmpMiscFee").html(MiscValue-FeeValue);
	        	$("#TotalMiscFee").html(MiscValue-FeeValue);
	        	$("#TmpTotalFee").html((MiscValue-FeeValue)+TuitionValue);
	        	$("#FeeListRow_"+Fee[1]).addClass("hidden");	        	

	        	$("#TmpMiscFee2").html(MiscValue-FeeValue);
	        	$("#TotalMiscFee2").html(MiscValue-FeeValue);
	        	$("#TmpTotalFee2").html((MiscValue-FeeValue)+TuitionValue);
	        }

        }
        history.pushState('', "page 2", Page.pathname);
    });

});

function Modal_lg(Header,Content){
    $("#Modal_Universal").modal("show");
    $("#myModalLabel").html(Header);
    $("#Modal_BodyUniversal").html(Content);
}

function Modal_Alert(Header,Content){
    $("#ModalAlert").modal("show");
    $("#Label_ModalAlert").html(Header);
    $("#Text_ModalAlert").html(Content);
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
