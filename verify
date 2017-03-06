<?php
$access_token = 'IO6nb8Se9ZfhNmFNC6U2uNak/cAbHcAAbZVBaZOz6auFa6zDmaYjeW4gQp2x5KqRdnr5hibGeANCm+tsaGbHNgKGizu3U0oo0vwtq0e39nkHFWfHMMgKRgttK3ljdAH84lTd1ZEr7WEJNe6XdJHxSgdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
