function PieChart(ID,Title,Data){
    ID.highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: Title
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 50,
                dataLabels: {
                    enabled: true,
                    format: '{point.tag}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Students share',
            data: Data
        }]
    });
}

var Page = window.location, AjaxData;
if(Page.search === "?ChartCourse"){
    $.ajax({
        url: 'Registrar.php?ChartCourse',
        type: 'POST',
        data: {Data:"Masteral"},
        success: function(Data){
	    	Obj = JSON.parse(Data),Calc = 0;
            if(Obj.length>0){
                PieChart($("#CourseChart1"),"Masteral",Obj)
                $.each(Obj, function(Loop1, Value1) {
                    Calc = Calc + parseInt(Value1.y);
                    $("#CourseChartLegend1").append("<tr><td width='90%'><small>"+Value1.tag+". "+Value1.name+"</small></td><td align='center'>"+parseInt(Value1.y)+"</td></tr>");
                });
                $("#CourseChartLegend1").append("<tr><td width='90%'><small>Total</small></td><td align='center'>"+Calc+"</td></tr>");
            }
            else{
                $("#CourseChart1").html("No Students retrieved for "+Data[0]);
            }

        }
    });
    $.ajax({
        url: 'Registrar.php?ChartCourse',
        type: 'POST',
        data: {Data:"Doctoral"},
        success: function(Data){
            Obj = JSON.parse(Data),Calc = 0;
            if(Obj.length>0){
                PieChart($("#CourseChart2"),"Doctoral",Obj)
                $.each(Obj, function(Loop1, Value1) {
                    Calc = Calc + parseInt(Value1.y);
                    $("#CourseChartLegend2").append("<tr><td width='90%'><small>"+Value1.tag+". "+Value1.name+"</small></td><td align='center'>"+parseInt(Value1.y)+"</td></tr>");
                });
                $("#CourseChartLegend2").append("<tr><td width='90%'><small>Total</small></td><td align='center'>"+Calc+"</td></tr>");
            }
            else{
                $("#CourseChart2").html("No Students retrieved for "+Data[0]);
            }
        }
    });
}
else if(Page.search === "?ChartSemester"){
    $.ajax({
        url: 'Registrar.php?ChartSemester',
        type: 'POST',
        success: function(Data){
            Data = Data.split("<x>");
            Obj = JSON.parse(Data[1]),Calc = 0;
            if(Obj.length>0){
                PieChart($("#SemesterChart1"),Data[0],Obj)
                $.each(Obj, function(Loop1, Value1) {
                    Calc = Calc + Value1.y;
                    $("#SemesterChartLegend1").append("<tr><td width='90%'><small>"+Value1.tag+". "+Value1.name+"</small></td><td align='center'>"+Value1.y+"</td></tr>");
                });
                $("#SemesterChartLegend1").append("<tr><td width='90%'><small>Total</small></td><td align='center'>"+Calc+"</td></tr>");
            }
            else{
                $("#SemesterChart1").html("No Students retrieved for "+Data[0]);
            }
        }
    });
}
else if(Page.search === "?ChartYear"){
    $.ajax({
        url: 'Registrar.php?ChartYear',
        type: 'POST',
        data: {Data:"1st Sem"},
        success: function(Data){
            Data = Data.split("<x>");
            Obj = JSON.parse(Data[1]),Calc = 0;
            if(Obj.length>0){
                PieChart($("#YearChart1"),Data[0],Obj)
                $.each(Obj, function(Loop1, Value1) {
                    Calc = Calc + Value1.y;
                    $("#YearChartLegend1").append("<tr><td width='90%'><small>"+Value1.tag+". "+Value1.name+"</small></td><td align='center'>"+Value1.y+"</td></tr>");
                });
                $("#YearChartLegend1").append("<tr><td width='90%'><small>Total</small></td><td align='center'>"+Calc+"</td></tr>");
            }
            else{
                $("#YearChart1").html("No Students retrieved for "+Data[0]);
            }
        }
    });

    $.ajax({
        url: 'Registrar.php?ChartYear',
        type: 'POST',
        data: {Data:"2nd Sem"},
        success: function(Data){
            Data = Data.split("<x>");
            Obj = JSON.parse(Data[1]),Calc = 0;
            if(Obj.length>0){
                PieChart($("#YearChart2"),Data[0],Obj)
                $.each(Obj, function(Loop1, Value1) {
                    Calc = Calc + Value1.y;
                    $("#YearChartLegend2").append("<tr><td width='90%'><small>"+Value1.tag+". "+Value1.name+"</small></td><td align='center'>"+Value1.y+"</td></tr>");
                });
                $("#YearChartLegend2").append("<tr><td width='90%'><small>Total</small></td><td align='center'>"+Calc+"</td></tr>");
            }
            else{
                $("#YearChart2").html("No Students retrieved for "+Data[0]);
            }

        }
    });
}
else if(Page.search === "?ListCourse"){
    $.ajax({
        url: 'Registrar.php?ListCourse',
        type: 'POST',
        data: {Data:"Masteral"},
        success: function(Data){
            $("#CourseList1").html(Data);
        }
    });
    $.ajax({
        url: 'Registrar.php?ListCourse',
        type: 'POST',
        data: {Data:"Doctoral"},
        success: function(Data){
            $("#CourseList2").html(Data);
        }
    });
}
else if(Page.search === "?ListSemester"){
    $.ajax({
        url: 'Registrar.php?ListSemester',
        type: 'POST',
        success: function(Data){
            $("#SemesterList").html(Data);
        }
    });
}
else if(Page.search === "?ListYear"){
    $.ajax({
        url: 'Registrar.php?ListYear',
        type: 'POST',
        data: {Data:"1st Sem"},
        success: function(Data){
            $("#YearList1").html(Data);
        }
    });

    $.ajax({
        url: 'Registrar.php?ListYear',
        type: 'POST',
        data: {Data:"2nd Sem"},
        success: function(Data){
            $("#YearList2").html(Data);
        }
    });
}
