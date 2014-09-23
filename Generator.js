var captchaClass = (function () {

	captchaClass = function (symbol, pos) {
		this.symbol = symbol;
		this.pos = pos;
	}

	return captchaClass;
})();

var Generator = new function() {
	this.max = 260;
	this.min = 40;
	this.records = [];
	this.captchaArray = [];

	this.genCharsAndPos = function() {
		// var i = Math.random();
		var counts = 0;
		var c;
		var px, py;
		var length = this.records.length;

		while (counts < 5) {
			c = String.fromCharCode(0x0041 +  Math.random() * (0x005A - 0x0041 + 1));
			// px = Math.floor(Math.random() * (this.max - this.min)) + this.min;
			// py = Math.floor(Math.random() * (this.max - this.min)) + this.min;
			var index = Math.floor(Math.random() * length);
			px = this.records[index].x;
			py = this.records[index].y;

			var loc = {
				x: px, 
				y: py
			};

			this.captchaArray.push(new captchaClass(c, loc));
			counts += 1;
		}
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

		this.records = records;
	}
};