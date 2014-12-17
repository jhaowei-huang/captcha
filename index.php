<!DOCTYPE html>
<html>
	<head>
<!-- 	<?php
	$font_family =array("Eater", "Chango", "Concert One", "Cagliostro", "Gentium Basic", "Londrina Sketch", "IM Fell French Canon SC", "Emblema One", "Fredoka One", "Quantico", "Belgrano", "Graduate", "Cantata One", "Shadows Into Light", "Bangers", "Loved by the King", "Spirax", "Swanky and Moo Moo", "Belleza", "Pontano Sans", "Berkshire Swash", "Marko One", "Oleo Script", "Codystar", "Chicle", "Boogaloo", "Crafty Girls", "Bilbo", "Sancreek", "Limelight", "Felipa", "EB Garamond", "Voltaire", "Lovers Quarrel", "Righteous", "Black Ops One", "Mrs Sheppards", "Fredericka the Great", "Port Lligat Sans", "Ceviche One", "Italiana", "Metamorphous", "Krona One", "Alex Brush", "Homenaje", "Unkempt", "Lusitana", "The Girl Next Door", "talianno", "Bowlby One", "Henny Penny", "Antic Didone", "Cabin Condensed", "Spicy Rice", "Averia Sans Libre", "Mr Bedfort", "Merriweather", "Acme", "Podkova", "Nunito", "Dosis", "Karla", "Titan One", "Baumans", "Galdeano", "Jolly Lodger", "Economica", "Vollkorn", "Advent Pro", "Give You Glory", "Condiment", "Ubuntu Mono", "Shojumaru", "Allerta", "Yesteryear", "Bonbon", "Mrs Saint Delafield", "Shadows Into Light Two", "Passion One", "Rosarivo", "Comfortaa", "Sofia", "Magra", "Flamenco", "Rancho", "Great Vibes", "Amatic SC", "Lobster Two", "Nixie One", "Josefin Sans", "Junge", "Asul", "Erica One", "Viga", "Glegoo", "Orbitron", "Happy Monkey", "Rouge Script", "Share", "Stint Ultra Expanded", "Kranky", "Francois One", "Frijole", "Oswald", "Ruge Boogie", "Amethysta", "Herr Von Muellerhoff", "Princess Sofia", "Quicksand", "Londrina Outline", "Cookie", "Dorsa", "Dynalight", "Dawning of a New Day", "Norican", "Annie Use Your Telescope", "Aclonica", "Qwigley", "Diplomata", "Sue Ellen Francisco", "Raleway", "Bigshot One", "Meddon", "Delius Swash Caps", "Caesar Dressing", "Covered By Your Grace", "Ewert", "UnifrakturMaguntia", "Dancing Script", "Monoton", "Miltonian", "Calligraffitti", "Passero One"); 

	for($i = 0; $i < 5 ; $i++) {
		$family = $font_family[rand(0, count($font_family) - 1)];
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=$family\" class=\"font_link\">";
	}		
?> -->
		<link rel=stylesheet type="text/css" href="style.css">
		<script src = "jquery-2.1.1.min.js"></script>
		<script src = "jcanvas.min.js"></script>
		<script src = "Generator.js" async></script>
		<script src = "ImgProcessor.js" async></script>
		<script>
			var timerID;
			var counts = 0;
			var clicks = 0;
			$(document).ready(function() {
				var img = new Image();
				var intputImgURL;
				var w = document.getElementById("display").width,
					h = document.getElementById("display").height;
					
				img.src= "fish.jpg";
				img.onload = function() {
					var x_min = 40, x_max = 300 - x_min, 
						y_min = 40, y_max = 300 - y_min;

					$("#display").drawImage({
				  		source: img,
				  		x: w/2, y: h/2,
				  		width: w, height: h
					});

					var process = new ImgProcessor();
					process.edgeDetect(img);

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
					alert("failed");
					return;
				}
				else if(Verifier.isCorrect){
					clearInterval(timerID);
					alert("pass");
					return;
				}
				document.getElementById("timer").innerHTML = "time : " + (counts++);
			}
		</script>
	</head>
	
	<body>		
		<p id = "p1"> img-based-CAPTCHA </p>
		<p id = "timer" style = "display:block"> Info. </p>
		<button id = "btn1"> Refresh </button>
		<HR>
		<h id = "hint"> HINT : </h> <BR>
		<canvas id = "display" width="300" height="300"></canvas> 
		<h id = "ans"></h>
	</body>
</html>

