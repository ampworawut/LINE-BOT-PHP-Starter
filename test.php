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

			//print_r($json);

			echo $json;

			echo "".$bc_contents['item'][0]['type']." : ".$bc_contents['item'][0]['today']."\r\n".$bc_contents['item'][1]['type']." : ".$bc_contents['item'][1]['today']."\r\n".$bc_contents['item'][2]['type']." : ".$bc_contents['item'][2]['today']."\r\n";
            ?>