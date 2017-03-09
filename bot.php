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
			date_default_timezone_set("Asia/Bangkok");
			// Build message to reply back
			if (strpos($text,'time')!== false){
			$replytext = date("H:i");
		}
			if (strpos($text,'weather') !== false){
		$request = 'http://api.openweathermap.org/data/2.5/weather?q=Bangkok&appid=4170f37d550eea9a269901fe6eb64ed7&units=metric';
    $response  = file_get_contents($request);
    $jsonobj  = json_decode($response, true);
    //print_r($jsonobj);
				$replytext = $jsonobj['main']['temp'];
			}
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
