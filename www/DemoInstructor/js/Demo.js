$(document).ready(function(){
	$.ajax({
		url:"Harmony/Process.php?Demo",
		type:"POST",
		data:{Data:"Magic Word"},
		success: function(Data){
			console.log(Data);
		}
	})
})