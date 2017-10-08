$(function() {
    var Process = 'PhpFiles/Process.php';

    $.ajax({
        url: Process+'?MonthlyReport',
        type: 'POST',
        success: function(Data){
            //var Strings = '{"Bar":[{"Product":"Wow","Unit":"Bottle Small","Value":"9"},{"Product":"Patis","Unit":"Bottle Small","Value":"130"},{"Product":"Bagoong","Unit":"Bottle","Value":"10"},{"Product":"Patis","Unit":"Bottle","Value":"1"},{"Product":"Bagoong Special","Unit":"Bottle Small","Value":"0"},{"Product":"Bagoong","Unit":"Bottle Small","Value":"1"}]}';
            var obj = JSON.parse(Data);
            
            var Data1 = obj.Bar;
            console.log(Data1);

            Morris.Donut({
                element: 'morris-donut-chart',
                data: Data1,
                resize: true
            });
        }
    });



});
