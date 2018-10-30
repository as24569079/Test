$(function(){

	$("input:text").bind({ 
		focus:function(){ 
		if (this.value == this.defaultValue){ 
		this.value=""; 
		} 
	}, 
		blur:function(){ 
		if (this.value == ""){ 
		this.value = this.defaultValue; 
		} 
	} 
	}); 










})