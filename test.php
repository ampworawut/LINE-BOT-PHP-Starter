<?php
header('Content-Type: text/html; charset=utf-8');
$text = "weather bangkok";

			if (strpos($text,'weather')!== false){
        	$trimmed = str_replace("weather ", '', $text) ;
			$ow_request = "http://api.openweathermap.org/data/2.5/weather?appid=4170f37d550eea9a269901fe6eb64ed7&units=metric&q=".$trimmed."";
    		$ow_response  = file_get_contents($ow_request);
    		$ow_contents  = json_decode($ow_response, true);
			$result = $ow_contents['main']['temp'];
			$replytext = $result;
			}

			echo $text;
			echo "<--- Text   ";

			echo $trimmed;
			echo "<--- Trimmed   ";

			echo $ow_request;
			echo "<--- ow_request   ";

			echo $ow_contents['main']['temp'];
			echo "<--- Data   ";

			echo $replytext;
			echo "<--- Final   ";

               ?>