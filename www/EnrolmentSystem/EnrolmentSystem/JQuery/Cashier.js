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

function CalculateOtherFee(Value1,Value2,Operation){
	var ReturnValue = 0;
	if(Operation == "Addition")
		ReturnValue = Number(Value1)+Number(Value2);
	else{
		ReturnValue = Number(Value1)-Number(Value2);
		if(ReturnValue<0)
			ReturnValue = (Number(Value1)-Number(Value2))*-1;
	}

	return ReturnValue;
}

$(document).ready(function(e) {
	$.post("Cashier.php?Time",function(Clock){
		var Clock = Clock.split(" "), Time = Clock[1].split(":");
		Hours = Number(Time[0]), Minutes = Number(Time[1]), Seconds = Number(Time[2]);
		TimeBackup(Hours,Minutes,Hours);
	});

	var Page = window.location;
	if(Page.search == "?OtherFee"){
		$("#CollectionReport").addClass("hidden");
		$("#OtherFee").removeClass("hidden");
		$("#DataContainer").addClass("hidden");

		$.ajax({
			url:'Cashier.php?OtherFeeForm',
			type:'POST',
			success: function(Data){
				$("#OtherFee").html(Data)

				$("#OtherFeeStudentID").keyup(function(){
					$.ajax({
						url:'Cashier.php?OtherFee',
						type:'POST',
						data:{Data:$("#OtherFeeStudentID").val()},
						success: function(Data){
							$("#OtherFeeHolder").html(Data)

							$(".AddOtherFee").click(function(){
								var index = $(".AddOtherFee").index(this), IndexPlusOne = index+1, IndexPlusTwo = index+2;
								var FeeValue = $("input.OtherFeeValue:nth-child("+IndexPlusTwo+")").val();
								var OtherFeeTotal = $("#OtherFeeTotal").html();

								FeeValue = FeeValue.split("<x>");
								$("#TableOtherFeeListChosen tr:nth-child("+IndexPlusOne+")").removeClass('hidden');
								$("#TableOtherFeeList tr:nth-child("+IndexPlusOne+")").addClass('hidden');
								$("input.OtherFeeValue:nth-child("+IndexPlusTwo+")").addClass('SelectedOtherFeeValue');
									
								var a = CalculateOtherFee(FeeValue[0],OtherFeeTotal,"Addition");
								$("#OtherFeeTotal").html(a);
							})

							$(".RemoveOtherFee").click(function(){
								var index = $(".RemoveOtherFee").index(this), IndexPlusOne = index+1, IndexPlusTwo = index+2;
								var FeeValue = $("input.OtherFeeValue:nth-child("+IndexPlusTwo+")").val();
								var OtherFeeTotal = $("#OtherFeeTotal").html();

								FeeValue = FeeValue.split("<x>");
								$("#TableOtherFeeListChosen tr:nth-child("+IndexPlusOne+")").addClass('hidden');
								$("#TableOtherFeeList tr:nth-child("+IndexPlusOne+")").removeClass('hidden');
								$("input.OtherFeeValue:nth-child("+IndexPlusTwo+")").removeClass('SelectedOtherFeeValue');

								var a = CalculateOtherFee(FeeValue[0],OtherFeeTotal,"Subtraction");
								$("#OtherFeeTotal").html(a);
							})

							$("#OtherFeeSubmit").click(function(){
						    	var Data = Array($("#OtherFeeStudentID").val(),$("#OtherFeeOR").val(),$("#OtherFeeTotal").html());
								if(Data[1]=="" || Data[2] == "0")
									Modal_Alert("System","The required fields are emtpy. Check the OR Number or the Fees.");
								else{
								    ModalConfirmations("Confirm Submission.");
								    $("#Button_Execute").click(function(){
								        $("#ModalConfirmation").modal("hide");
										$.ajax({
											url:'Cashier.php?OtherFeePaid',
											type:'POST',
											data:{Data:Data},
											success: function(Data){
												if(Data == 1){
													window.location = Page.search;
												}
												else
													Modal_Alert("System","There was an error. If this instance happen again, refer to the developer.");
											}
										})
									})
								}
							})
						}
					})
				})
			}
		})
	}
	else if(Page.search == "?Report"){
		$("#CollectionReport").removeClass("hidden");
		$("#OtherFee").addClass("hidden");
		$("#DataContainer").addClass("hidden");

		$.ajax({
			url:'Cashier.php?CollectionReportForm',
			type:'POST',
			data:{Data:$("#SearchBox").val()},
			success: function(Data){
				$("#CollectionReport").html(Data)

				var DataReport = Array($("#SelectReportMonth").val(),$("#SelectReportYear").val());
				$.ajax({
					url:'Cashier.php?ReportQuery',
					type:'POST',
					data:{DataReport:DataReport},
					success: function(Data){
						$("#QueriedCollectionReport").html(Data)
						$.ajax({
							url:'CashierPrinting.php?ReportQuery',
							type:'POST',
							data:{Data:DataReport},
							success: function(Data){
								$("#Printable").html(Data);
							}
						})
					}
				})

				$("#SelectReportMonth").change(function(){
					var Data = Array($("#SelectReportMonth").val(),$("#SelectReportYear").val());
					if(Data[0] == "Month" || Data[1] == "Year")
						$("#ButtonReport").addClass('disabled')
					else
						$("#ButtonReport").removeClass('disabled')
				})

				$("#SelectReportYear").change(function(){
					var Data = Array($("#SelectReportMonth").val(),$("#SelectReportYear").val());
					if(Data[0] == "Month" || Data[1] == "Year")
						$("#ButtonReport").addClass('disabled')
					else
						$("#ButtonReport").removeClass('disabled')
				})

				$("#ButtonReport").click(function(){
					var DataReport = Array($("#SelectReportMonth").val(),$("#SelectReportYear").val());
					$.ajax({
						url:'Cashier.php?ReportQuery',
						type:'POST',
						data:{DataReport:DataReport},
						success: function(Data){
							$("#QueriedCollectionReport").html(Data)

							$.ajax({
								url:'CashierPrinting.php?ReportQuery',
								type:'POST',
								data:{Data:DataReport},
								success: function(Data){
									$("#Printable").html(Data);
								}
							})
						}
					})
				})

				$("#ButtonPrintReport").click(function(){
					PrintDocx("Printable");
				})
			}
		})

	}
	else if(Page.search == "?Home"){
		window.location = Page.pathname;
	}

	$("#HideAssessment").hide(); $("#Cashier").hide();

	$("#ShowAssessment").click(function(){
		$("#ShowAssessment").hide()
		$("#HideAssessment").show();
		$("#EnrolledSubjectsList").slideToggle();
	})

	$("#HideAssessment").click(function(){
		$("#ShowAssessment").show()
		$("#HideAssessment").hide();
		$("#EnrolledSubjectsList").slideToggle();
	})

	$.post("Cashier.php?CashierPaid",{AssessmentCode:$("#AssessmentCode").val()},function(PaymentList){
		$("#PaymentList").html(PaymentList);
	}); // automatic Retrieving of enrolled subject listed
	
	$.post("Cashier.php?StudentInfo",{AssessmentCode:$("#AssessmentCode").val()},function(StudentInfo){
		$("#StudentInformation").html(StudentInfo);
	});
		
	$("#AssessmentCode").keyup(function(){
		if($("#AssessmentCode").val().length == 6)
			$("#Cashier").show();
		else
			$("#Cashier").hide();
		
		$.post("Cashier.php?StudentInfo",{AssessmentCode:$("#AssessmentCode").val()},function(StudentInfo){
			$("#StudentInformation").html(StudentInfo);
	
			$.post("Cashier.php?RetrieveAssessment",{Data:$("#AssessmentCode").val()},function(SubjectList){
				$("#EnrolledSubjectsList").html(SubjectList);
			}); // automatic Retrieving of enrolled subject listed
			
			$.post("Cashier.php?Print",{AssessmentCode:$("#AssessmentCode").val()},function(SubjectList){
				$("#PrintStudentInformation").html(SubjectList);
			}); // automatic Retrieving of enrolled subject listed
			
			$.post("Cashier.php?CashierFees",{AssessmentCode:$("#AssessmentCode").val()},function(SubjectList){
				$("#CashierFees").html(SubjectList);
			}); // automatic Retrieving of enrolled subject listed

			$.post("Cashier.php?CashierPaid",{AssessmentCode:$("#AssessmentCode").val()},function(PaymentList){
				$("#PaymentList").html(PaymentList);
			}); // automatic Retrieving of enrolled subject listed

			$.post("Cashier.php?BalanceCheck",{AssessmentCode:$("#AssessmentCode").val()},function(SubjectList){
				if(SubjectList == "Fully Paid"){
					$("#CashierInputs").hide();
				}
				else{
					$("#CashierInputs").show();
				}
			});
		
			$("#CashierBtn").click(function(){
				var Amount = $("#AmountPaid").val(), Receipt = $("#ReceiptNumber").val(), Assessment = $("#AssessmentCode").val(), ErrorCount = 0;
				$("#AmountPaid").val(""); $("#ReceiptNumber").val("");
				$.post("Cashier.php?Cashier",{AssessmentCode:Assessment,Receipt:Receipt,Amount:Amount},function(SubjectList){
					$.post("Cashier.php?CashierPaid",{AssessmentCode:Assessment},function(PaymentList){
						document.getElementById("PaymentList").innerHTML = PaymentList;
					});
					
					$.post("Cashier.php?CashierFees",{AssessmentCode:Assessment},function(SubjectList){
						document.getElementById("CashierFees").innerHTML = SubjectList;
					});
					
					$.post("Cashier.php?BalanceCheck",{AssessmentCode:Assessment},function(SubjectList){
						if(SubjectList == "Fully Paid"){
							$("#CashierInputs").hide();
						}
					});
					$.post("Cashier.php?BalanceCheck",{AssessmentCode:Assessment},function(SubjectList){
						if(SubjectList == "Fully Paid"){
							$("#CashierInputs").hide();
						}
						else{
							$("#CashierInputs").show();
						}
					});
				});		
			})
		});
		
	})



	$("#SearchBox").keyup(function(e){
		if($("#SearchBox").val() == ""){
			$("#SearchResult").addClass("hidden")
			$("#DataContainer").removeClass("hidden")
		}
		else{
			$("#SearchResult").removeClass("hidden")
			$("#DataContainer").addClass("hidden")

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
        var Hash = event.target.hash, Page = window.location;
        if(typeof Hash !== "undefined" && Hash !== ""){
            var Hashes = Hash.split('#'), Reply = 1;
            if(Hashes[1] == "ViewProfile"){
                $.post("Cashier.php?StudentFee",{Data:Hashes[2]},function(Data){
                	Modal_lg('Assessment of fees',Data);
                });
            }
            else if(Hashes[1] == "OtherFee"){
            	$("#Modal_OtherFee").modal('show');
            }
        }

        history.pushState('', "page 2", Page.pathname);
    });
});

function Modal_Alert(Header,Content){
    $("#ModalAlert").modal("show");
    $("#Label_ModalAlert").html(Header);
    $("#Text_ModalAlert").html(Content);
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
	//WinPrint.print();
	WinPrint.close();
}

