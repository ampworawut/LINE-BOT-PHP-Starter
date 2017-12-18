<?php
$access_token = 'IO6nb8Se9ZfhNmFNC6U2uNak/cAbHcAAbZVBaZOz6auFa6zDmaYjeW4gQp2x5KqRdnr5hibGeANCm+tsaGbHNgKGizu3U0oo0vwtq0e39nkHFWfHMMgKRgttK3ljdAH84lTd1ZEr7WEJNe6XdJHxSgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			$replytext = "";
			$text = strtolower($text);
			//Time response
			if (strpos($text,'time')!== false){
			date_default_timezone_set("Asia/Bangkok");
			$replytext = date("H:i");
		}
			// Weather response
			if (strpos($text,'weather')!== false){
        	$trimmed = str_replace("weather ", '', $text) ;
			$ow_request = "http://api.openweathermap.org/data/2.5/weather?appid=4170f37d550eea9a269901fe6eb64ed7&units=metric&q=".$trimmed."";
    		$ow_response  = file_get_contents($ow_request);
    		$ow_contents  = json_decode($ow_response, true);
    		$replytext = "Weather in ".ucfirst($trimmed)." : ".$ow_contents['weather'][0]['description']."";
			}

			// Temperature response
			if (strpos($text,'temp')!== false){
        	$trimmed = str_replace("temp ", '', $text) ;
			$ow_request = "http://api.openweathermap.org/data/2.5/weather?appid=4170f37d550eea9a269901fe6eb64ed7&units=metric&q=".$trimmed."";
    		$ow_response  = file_get_contents($ow_request);
    		$ow_contents  = json_decode($ow_response, true);
			$replytext = "Temperature in ".ucfirst($trimmed)." : ".$ow_contents['main']['temp']." C";
			}

			// Currency response
			if (strpos($text,'currency')!== false){
        	$trimmed = str_replace("currency ", '', $text) ;
			$ow_request = "https://api.fixer.io/latest?base=".$trimmed."";
    		$ow_response  = file_get_contents($ow_request);
    		$ow_contents  = json_decode($ow_response, true);
			$replytext = "1 ".strtoupper($trimmed)." : ".$ow_contents['rates']['THB']." THB";
			}

			// OilPrice response
			if (strpos($text,'oil')!== false){
        	//$trimmed = str_replace("currency ", '', $text) ;
			$bc_request = "https://crmmobile.bangchak.co.th/webservice/oil_price.aspx";
    		$bc_response  = file_get_contents($bc_request);
    		$bc_xml= simplexml_load_string($bc_response);
    		$json  = json_encode($bc_xml);
    		$bc_contents  = json_decode($json, true);
			$result = "ราคาน้ำมันวันนี้ \n".$bc_contents['item'][0]['type']." : ".$bc_contents['item'][0]['today']."\n".$bc_contents['item'][1]['type']." : ".$bc_contents['item'][1]['today']."\n".$bc_contents['item'][2]['type']." : ".$bc_contents['item'][2]['today']."\n".$bc_contents['item'][3]['type']." : ".$bc_contents['item'][3]['today']."\n".$bc_contents['item'][4]['type']." : ".$bc_contents['item'][4]['today']."\n".$bc_contents['item'][5]['type']." : ".$bc_contents['item'][5]['today']."\n".$bc_contents['item'][6]['type']." : ".$bc_contents['item'][6]['today']."";
			$replytext = $result;
			}

			// OilPrice TMR response
			if (strpos($text,'oiltmr')!== false){
        	//$trimmed = str_replace("currency ", '', $text) ;
			$bc_request = "https://crmmobile.bangchak.co.th/webservice/oil_price.aspx";
    		$bc_response  = file_get_contents($bc_request);
    		$bc_xml= simplexml_load_string($bc_response);
    		$json  = json_encode($bc_xml);
    		$bc_contents  = json_decode($json, true);
			$result = "ราคาน้ำมันวันพรุ่งนี้ \n".$bc_contents['item'][0]['type']." : ".$bc_contents['item'][0]['tomorrow']."\n".$bc_contents['item'][1]['type']." : ".$bc_contents['item'][1]['tomorrow']."\n".$bc_contents['item'][2]['type']." : ".$bc_contents['item'][2]['tomorrow']."\n".$bc_contents['item'][3]['type']." : ".$bc_contents['item'][3]['tomorrow']."\n".$bc_contents['item'][4]['type']." : ".$bc_contents['item'][4]['tomorrow']."\n".$bc_contents['item'][5]['type']." : ".$bc_contents['item'][5]['tomorrow']."\n".$bc_contents['item'][6]['type']." : ".$bc_contents['item'][6]['tomorrow']."";
			$replytext = $result;
			}

			// SET Index response
			if (strpos($text,'setindex')!== false){
        	//$trimmed = str_replace("temp ", '', $text) ;
			$ow_request = "https://finance.google.com/finance?q=INDEXBKK:SET&output=json";
    		$ow_response  = file_get_contents($ow_request);
    		$ow_contents  = json_decode($ow_response, true);
			$replytext = "SET Index : ".$ow_contents['l']";
			}

			// Build message to reply back
		if ($replytext !== ""){
			$messages = [
				'type' => 'text',
				'text' => $replytext
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
	}
}
echo "OK";
