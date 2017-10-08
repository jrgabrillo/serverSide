// JavaScript Document
var FunctionLib = {};
var FunctionLib = Object.create(null);
FunctionLib = new Functions();

function Functions(){
	this.Slider = function(Selector,MaxPicture,TimeStamp,Fading){
		$("#Slider1").css({"display":"block"});
		var x=1,y=0,BGColors = Array("rgba(0,153,51,0.5)","rgba(102,51,204,0.5)","rgba(255,153,0,0.5)","rgba(0,153,51,0.5)");
		$("#OverLay").css({"background":BGColors[x-1]});
		//System AI(auto scroll)
		// border:1px solid rgba(0,153,51,1);
		var Timer = setInterval(function(){
				$("#OverLay").css({"background":BGColors[x-1]});
				if(x>=MaxPicture) x=1;
				$("#"+Selector+x).fadeIn(Fading);
				$("#"+Selector+y).hide();
				x=x+1;y=x-1;
			},TimeStamp);
	}
	this.ValidationEmpty = function(ID,ErrorID,FieldName){
		if(ID.val() == null || ID.val() == ""){
			ID.focus();
			ErrorID.text(FieldName+" is required.");
			return 1;
		}
		else if(ID.val() != null || ID.val() != ""){
			return 0;
		}
	}
	this.ValidationSQL = function(Input){
		$.post("PHPFILES/Index.php?ValidationSQL",{Input:Input},function(ReturnData){
		})
	}
	this.IsInt = function(Input){
		if(Math.floor(Input) == Input && $.isNumeric(Input))
			return true;
		else
			return false;
	}
	this.Percentage = function(Value,Total){
		if(IsInt(Value) == true){
			if(IsInt(Total) == true){
				var x = (Value * 100)/Total;
				return x.toFixed(2);
			}
		}
		else{
			return "Invalid value to percentage";
		}
	}




}

