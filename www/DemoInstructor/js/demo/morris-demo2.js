function JSONParser(arr) {
    var out = "", i;
    for(i = 0; i < arr.length; i++) {
        out += '<a href="' + arr[i].Product + '">' + arr[i].Unit + '</a><br>';
    }
    console.log(out);
}

$(function() {
    var Process = 'PhpFiles/Process.php';

    $.ajax({
        url: Process+'?MonthlyReport',
        type: 'POST',
        success: function(Data){
            var Strings = '{"Bar":[{"Product":"Wow","Unit":"Bottle Small","Value":"9"},{"Product":"Patis","Unit":"Bottle Small","Value":"130"},{"Product":"Bagoong","Unit":"Bottle","Value":"10"},{"Product":"Patis","Unit":"Bottle","Value":"1"},{"Product":"Bagoong Special","Unit":"Bottle Small","Value":"0"},{"Product":"Bagoong","Unit":"Bottle Small","Value":"1"}]}';
            var obj = JSON.parse(Strings);
            
            var Data1 = obj.Bar;
            console.log(Data1);
            var Data2 = Array({
                    y: 'Jan',
                    a: 300,
                    b: 50,
                    c: 90
                }, {
                    y: 'Feb',
                    a: 10,
                    b: 50,
                    c: 70
                }, {
                    y: 'Mar',
                    a: 30,
                    b: 70,
                    c: 90
                }, {
                    y: 'Apr',
                    a: 76,
                    b: 52,
                    c: 67
                }, {
                    y: 'May',
                    a: 12,
                    b: 15,
                    c: 45
                }, {
                    y: 'Jun',
                    a: 80,
                    b: 97,
                    c: 53
                }, {
                    y: 'Jul',
                    a: 60,
                    b: 51,
                    c: 98
                }, {
                    y: 'Aug',
                    a: 60,
                    b: 51,
                    c: 98
                }, {
                    y: 'Sep',
                    a: 60,
                    b: 51,
                    c: 98
                }, {
                    y: 'Oct',
                    a: 60,
                    b: 51,
                    c: 98
                }, {
                    y: 'Nov',
                    a: 60,
                    b: 51,
                    c: 98
                }, {
                    y: 'Dec',
                    a: 60,
                    b: 51,
                });

            console.log(Data2);

            Morris.Bar({
                element: 'morris-bar-chart',
                data: Data1,
                xkey: 'Product',
                ykeys: ['Value'],
                labels: ['Product'],
                hideHover: 'auto',
                resize: true
                });
        }
    });

});
