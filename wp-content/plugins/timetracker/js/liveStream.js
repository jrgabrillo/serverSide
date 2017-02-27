(function($) {
	// var url = "http://localhost/projectmanagementsystem/serverSide/wp-content/plugins/timetracker/";
	var url = "../wp-content/plugins/timetracker/";
	$.ajax({
		url:url+"getData.php?getUsers",
		data:{data:""},
		type:'POST',
		success:function(e){
			var content = "", list = "";
			var data = JSON.parse(e);
			var _style = '';
			var screens = [];
			$.each(data,function(a,b){
				content += "<div class='mdl-cell mdl-cell--3-col no-margin'>"+
					          "<div>"+b[1].display_name+"</div>"+
					          "<div class='liveStream' data='"+b[1].ID+"'></div>"+
					        "</div>";
			});
			$("#display_content .mdl-grid").html(content);

			$.each(data,function(a,b){
				// $("#display_content .liveStream[data='"+b[1].ID+"']").html("xx");
				stream("#display_content .liveStream[data='"+b[1].ID+"']",b[1].ID);
			});

			console.log(data.length);
		}
	});

	function stream(selector,id){
		var screen = new Screen(id);
		screen.onaddstream = function(e) {
			$("#display_content .liveStream[data='"+id+"']").html(e.video);
		};

		screen.check();
	}
})(jQuery);