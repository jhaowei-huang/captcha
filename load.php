<?php
$dir = opendir("images");

while (($file = readdir($dir)) !== false)
  {
  	if($file != "." && $file != ".." && $file != "desktop.ini"){
		echo $file . "<br />";
	}
  }

  closedir($dir);
?> 