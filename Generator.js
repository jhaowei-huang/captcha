var Generator = new function() {
	this.max = 270;
	this.min = 30;

	this.genChars = function() {
		var c = String.fromCharCode(0x0041 + Math.random() * (0x005A - 0x0041 + 1));
		return c;
	};
	this.genPos = function() {
		
		return Math.floor(Math.random() * (this.max - this.min)) + this.min;
	};
	this.genColor =  function() {
		var newColor = "#" + (0x1000000+(Math.random()) * 0xffffff).toString(16).substr(1,6);
		return newColor;
	};
	this.shrink = function(records) {
		for(var i = records.length - 1; i >= 0; i--) {
    		if(records[i].x <= this.min || records[i].x >= this.max || 
    		   records[i].y <= this.min || records[i].y >= this.max) {
				records.splice(i, 1);
			}
		}
		alert(records.length);
		return records;
	}
};