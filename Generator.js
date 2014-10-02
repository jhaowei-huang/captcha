var captchaClass = (function () {

	captchaClass = function (symbol, pos, fsize) {
		this.symbol = symbol;
		this.pos = pos;
		this.fsize = fsize;
	}

	return captchaClass;
})();

var Generator = new function() {
	this.max = 260;
	this.min = 40;
	this.records = [];
	this.captchaArray = [];

	this.genCharsAndPos = function(callback) {
		// var i = Math.random();
		var counts = 0;
		var c;
		var px, py;
		
		
		var index;
		var fsize;
		while (counts < 5) {
			c = String.fromCharCode(0x0041 +  Math.random() * (0x005A - 0x0041 + 1));
			// px = Math.floor(Math.random() * (this.max - this.min)) + this.min;
			// py = Math.floor(Math.random() * (this.max - this.min)) + this.min;
			var length = this.records.length;
			index = Math.floor(Math.random() * length);

			px = this.records[index].x;
			py = this.records[index].y;
			
			var loc = {
				x: px, 
				y: py
			};

			fsize = Math.floor(Math.random() * (90 - 30 + 1)) + 30;

			this.captchaArray.push(new captchaClass(c, loc, fsize));
			this.noOverlap(counts);
			counts += 1;
		}
		callback();
	};

	this.genColor =  function() {
		var newColor = "#" + (0x1000000+(Math.random()) * 0xffffff).toString(16).substr(1,6);
		return newColor;
	};

	this.shrink = function(records) {
		alert(records.length);
		for(var i = records.length - 1; i >= 0; i--) {
    		if(records[i].x <= this.min || records[i].x >= this.max || 
    		   records[i].y <= this.min || records[i].y >= this.max) {
				records.splice(i, 1);
			}
		}

		this.records = records;
	}

	this.noOverlap = function(index) {
		if (index >= 4) return;
		var x = this.captchaArray[index].pos.x;
		var y = this.captchaArray[index].pos.y;
		var s = this.captchaArray[index].fsize / 4;
		var minx = x - s;
		var miny = y - s;
		var maxx = x + s;
		var maxy = y + s;
		
		for(var i = this.records.length - 1; i >= 0; i--) {
    		if(this.records[i].x >= minx && this.records[i].y >= miny &&  
    		   this.records[i].x <= maxx && this.records[i].y <= maxy) {
				console.log(this.records[i].x + ", " + this.records[i].y);
				this.records.splice(i, 1);
				
			}
		}
	}
};