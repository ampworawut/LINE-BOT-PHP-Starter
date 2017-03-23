<?php
$access_token = 'zREzoi9Uh18o2iU5t9MBdtfaJm80p6yRTZwcmhU7Lpf';
$churl = 'www2.nanotec.or.th';

function isSiteAvailable($churl)
{
//check, if a valid url is provided
if(!filter_var($churl, FILTER_VALIDATE_URL))
{
return "URL provided wasn't valid";
}

//make the connection with curl
$cl = curl_init($churl);
curl_setopt($cl,CURLOPT_CONNECTTIMEOUT,10);
curl_setopt($cl,CURLOPT_HEADER,true);
curl_setopt($cl,CURLOPT_NOBODY,true);
curl_setopt($cl,CURLOPT_RETURNTRANSFER,true);

//get response
$response = curl_exec($cl);

curl_close($cl);

if ($response) {
  return "Site seems to be up and running!";
}else {
  return "Oops nothing found, the site is either offline or the domain doesn't exist";
  $messages = "Test";
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
