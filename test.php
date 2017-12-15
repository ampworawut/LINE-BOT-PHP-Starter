<?php

$text = "weather bangkok";

			if (strpos($text,'temp')!== false){
        	$trimmed = str_replace("temp ", '', $text) ;
			$ow_request = "http://api.openweathermap.org/data/2.5/weather?appid=4170f37d550eea9a269901fe6eb64ed7&units=metric&q='.$trimmed.'";
    		$ow_response  = file_get_contents($ow_request);
    		$ow_contents  = json_decode($ow_response, true);
			$result = $ow_contents['main']['temp'];
			$replytext = $result;
			}

			echo $text;
			echo "\n";

			echo $trimmed;
			echo "\n";

			echo $replytext;
			echo "\n";

               ?>