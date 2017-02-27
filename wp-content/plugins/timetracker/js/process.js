(function($) {
	// var url = "http://localhost/projectmanagementsystem/serverSide/wp-content/plugins/timetracker/";
	var url = "../wp-content/plugins/timetracker/";
	$.ajax({
		url:url+"getData.php?getFeeds",
		data:{data:""},
		type:'POST',
		success:function(e){
			var content = "", list = "";
			var data = JSON.parse(e);
			var _style = '';
			var screens = [];
			$.each(data,function(a,b){
				screens = JSON.parse(b[1]);
				list = "";
				$.each(screens,function(i,v){
					if(i>=5)
						_style = 'style="display:none;"';

					list += "<li "+_style+">"+(i+1)+". <img src='../wp-content/plugins/timetracker/img/screen/"+v.screen+"' width='100px' /><br/>"+v.date_time+"</li>";
				});
				content += "<div class='mdl-cell mdl-cell--4-col no-margin'>"+
					          "<div>"+b[0][1].display_name+"</div>"+
					          "<ul id='"+b[0][1].ID+"_display_screenList'>"+list+"</ul>"+
					          "<a class='display_loadMore' data-user='"+b[0][1].ID+"'>Load more</a>"+
					          "<a class='display_showLess' data-user='"+b[0][1].ID+"'>Show less</a>"+
					        "</div>";
			});
			$("#display_content .mdl-grid").html(content);

			setTimeout(function(){
				var size_li = screens.length;
				console.log(size_li);
				var x = 5;

				$('.display_loadMore').click(function(){
					var user = $(this).data();
				    x=(x+5 <= size_li) ? x+5 : size_li;
				    console.log(x);
				    $('#'+user.user+'_display_screenList li:lt('+x+')').show();
				});

				$('.display_showLess').click(function(){
					var user = $(this).data();
				    x=(x-5<=0) ? 5 : x-5;
				    console.log(x);
				    $('#'+user.user+'_display_screenList li').not(':lt('+x+')').hide();
				});
			},1000);
		}
	});
})(jQuery);


        
