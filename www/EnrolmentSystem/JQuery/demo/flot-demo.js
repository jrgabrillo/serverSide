$(document).ready(function() {

    $.ajax({
        url: 'Process.php?Analytics',
        type: 'POST',
        success: function(Data){
            console.log(Data);
            var obj = JSON.parse(Data);
            console.log(obj.Analytics);
            $(function() {
                var plotObj = $.plot($("#flot-pie-chart"), obj.Analytics, {
                    series: {
                        pie: {
                            show: true
                        }
                    },
                    grid: {
                        hoverable: true
                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                        shifts: {
                            x: 20,
                            y: 0
                        },
                        defaultTheme: false
                    }
                });
            });
        }
    });                
});


