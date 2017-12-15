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
    		$replytext = $ow_contents['weather'][0]['description'];
			}
			
			// Temperature response
			if (strpos($text,'temp')!== false){
        	$trimmed = str_replace("temp ", '', $text) ;
			$ow_request = "http://api.openweathermap.org/data/2.5/weather?appid=4170f37d550eea9a269901fe6eb64ed7&units=metric&q=".$trimmed."";
    		$ow_response  = file_get_contents($ow_request);
    		$ow_contents  = json_decode($ow_response, true);
			$replytext = $ow_contents['main']['temp'];
			}

			// Currency response
			if (strpos($text,'currency')!== false){
        	$trimmed = str_replace("currency ", '', $text) ;
			$ow_request = "https://api.fixer.io/latest?base=".$trimmed."";
    		$ow_response  = file_get_contents($ow_request);
    		$ow_contents  = json_decode($ow_response, true);
			$replytext = $ow_contents['THB'];
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
