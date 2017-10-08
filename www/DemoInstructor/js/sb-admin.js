$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
$(function() {
    $(window).bind("load resize", function() {
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    })
})

$(document).ready(function(){
    var Process = 'PhpFiles/Process.php';
    $.ajax({
        url: Process+'?CheckLogIn',
        type: 'POST',
		success: function(Data){
            if(Data == 0)
				window.location = 'index.html';
			else{
				var Obj = JSON.parse(Data);
				$('.UserType').html(Obj[1]);
				$('#UserType').html(Obj[1]);
				$("#AdminID").html(Obj[0]);

				if(Obj[4] != 'Admin'){
					$('#side-menu li:nth-child(1)').addClass("hidden");
					$('#side-menu li:nth-child(3)').addClass("hidden");
					$('#side-menu li:nth-child(4)').addClass("hidden");
					$('#Add_UnitPrice').addClass('disabled');
					$('#SystemUsers').addClass('hidden');
				}
			}
		}
	})  

    $('#BTN_Logout').click(function(){
	    $.ajax({
	        url: Process+'?LogOut',
	        type: 'POST',
	        success: function(Data){
				window.location = 'index.html';
	        }
	    })  
    })
})