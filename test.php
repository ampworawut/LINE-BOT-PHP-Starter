<?php
			// Weather response
			if (strpos($text,'weather')!== false){
        	$trimmed = str_replace("weather ", '', $text) ;
			$ow_request = "http://api.openweathermap.org/data/2.5/weather?appid=4170f37d550eea9a269901fe6eb64ed7&units=metric&q=bangkok";
    		$ow_response  = file_get_contents($ow_request);
    		$ow_contents  = json_decode($ow_response, true);
			$replytext = $ow_contents['main']['temp'];

			echo $replytext;
			}

               ?>