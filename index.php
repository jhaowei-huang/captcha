<!DOCTYPE html>
<html>
	<head>
		<link rel=stylesheet type="text/css" href="style.css">
		<script src = "jquery-2.1.1.min.js"></script>
		<script src = "jcanvas.min.js"></script>
		<script src = "Generator.js" async></script>
		<script src = "ImgProcessor.js" async></script>
		<script>
			var timerID;
			var counts = 0;
			var clicks = 0;
			var img = new Image();
			var imgSrc;

			$.ajax({
				type: "POST",
				url: "load.php",
				data: "",
				success: function(response){
					// alert(response);
					imgSrc = "images/" + getImgSrc(response);
				},
				error: function(xhr) {
					alert('Ajax request error');
				},
				async: false
			});

			function getImgSrc(input) {
				var tmp = input.split("<br />");
				var len = tmp.length - 2 ;
				return tmp[Math.floor(Math.random() * len)];
			}

			$(document).ready(function() {
				var intputImgURL;
				var w = document.getElementById("display").width,
					h = document.getElementById("display").height;
					
				img.src= imgSrc;
				img.onload = function() {
					var x_min = 40, x_max = 300 - x_min, 
						y_min = 40, y_max = 300 - y_min;

					$("#display").drawImage({
				  		source: img,
				  		x: w/2, y: h/2,
				  		width: w, height: h
					}).drawRect({
						layer: true,
					    draggable: false,
					    mask: true,
					    fillStyle: 'rgba(255, 255, 255, 0.1)',
					    x: w/2, y: h/2,
					    width: w, height: h
					});

					var process = new ImgProcessor();
					process.edgeDetect(img);
					Generator.records = process.record;
					Generator.shrink(process.record);
					Generator.genCharsAndPos(function () {
						var counts = 0;
						// var fl = $(".font_link").eq(0).attr("href");
						// var fontName = fl.replace("http://fonts.googleapis.com/css?family=","");
						// console.log(fontName);
						while(counts < 5) {
							$("#display").drawText({
								fillStyle: Generator.genColor(),
								x: Generator.captchaArray[counts].pos.x, 
								y: Generator.captchaArray[counts].pos.y,
								fontSize: Generator.captchaArray[counts].fsize,
								// fontFamily: fontName,
								text: Generator.captchaArray[counts].symbol,
								rotate: Generator.captchaArray[counts].rotate
							});
							$("#display").drawLine({
								strokeStyle: "#FF0000",
								strokeWidth: 3,
								x1: Generator.captchaArray[counts].pos.x + Generator.captchaArray[counts].fsize / 3, 
								y1: Generator.captchaArray[counts].pos.y + Generator.captchaArray[counts].fsize / 3,
								x2: Generator.captchaArray[counts].pos.x - Generator.captchaArray[counts].fsize / 3, 
								y2: Generator.captchaArray[counts].pos.y - Generator.captchaArray[counts].fsize / 3,
							});
							counts += 1;
						}
					});
					
					var str = "";
					for(var i = 0 ; i < 5 ; i++) {
						str += Generator.captchaArray[i].symbol;
					}
					
					$("#hint").html("HINT : " + str);
				}

				var canvas = document.getElementById("display");
				canvas.addEventListener("click", displayOnClick, false);

				timerID = setInterval("tik()", 100);
			});
			
			function displayOnClick(e) {
				var canvas = document.getElementById("display");
				var x = e.x - canvas.offsetLeft;
    			var y = e.y - canvas.offsetTop;
    			if(Verifier.isMatch(x, y)) {
    				$("#ans").html(Verifier.ans);
    			}
    			else
    				$("#ans").html(Verifier.ans);
			}

			function tik() {
				if(Verifier.isFailed) {
					clearInterval(timerID);
					alert("failed, " + document.getElementById("timer").innerHTML);
					return;
				}
				else if(Verifier.isCorrect){
					clearInterval(timerID);
					alert("pass, " + document.getElementById("timer").innerHTML);
					return;
				}
				document.getElementById("timer").innerHTML = "time : " + (counts++);
			}
		</script>
	</head>
	
	<body>		
		<p id = "p1"> img-based-CAPTCHA </p>
		<p id = "timer" style = "display:none"> Info. </p>
		<button id = "btn1"> Refresh </button>
		<HR>
		<h id = "hint"> HINT : </h> <BR>
		<canvas id = "display" width="300" height="300"></canvas> 
		<h id = "ans"></h>
	</body>
</html>

