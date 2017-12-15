<?php
header('Content-Type: text/html; charset=utf-8');
//$text = "weather bangkok";

			//if (strpos($text,'oil')!== false){
        	//$trimmed = str_replace("oil ", '', $text) ;
			$bc_request = "https://crmmobile.bangchak.co.th/webservice/oil_price.aspx";
    		$bc_response  = file_get_contents($bc_request);
    		$bc_xml= simplexml_load_string($bc_response);
    		$json  = json_encode($bc_xml);
    		$bc_contents  = json_decode($json, true);
			$result = $bc_contents['main']['temp'];
			$replytext = $result;
			//}

			print_r($bc_contents);

			echo $text;
            ?>