<?php
$access_token = 'zREzoi9Uh18o2iU5t9MBdtfaJm80p6yRTZwcmhU7Lpf';
$churl = 'www555.nanotec.or.th';

$host = 'google.com';
if($socket =@ fsockopen($host, 80, $errno, $errstr, 30)) {
echo 'online!';
fclose($socket);
} else {
echo 'offline.';
$message = $churl."is Down!!!";
}

if($messages !== "") {

  $url = 'https://notify-api.line.me/api/notify';
  //$post = json_encode($data);
  $post = "Message=".$messages;
  $headers = array('Content-Type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $access_token);


			$ch = curl_init($url);
			//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "$post");
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";

echo "OK";
}
