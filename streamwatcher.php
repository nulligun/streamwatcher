<?php

/*

mbp:build stevemulligan$ curl -H 'Client-ID: wx6ynt7kpj3d3tgrozk639fl2rs0qr' -X GET 'https://api.twitch.tv/helix/streams?user_id=p4uly'
{"data":[],"pagination":{}}mbp:build stevemulligan$ curl -H 'Client-ID: wx6ynt7kpj3d3tgrozk639fl2rs0qr' -X GET 'https://api.twitch.tv/helix/streams?user_login=p4uly'
{"data":[],"pagination":{}}mbp:build stevemulligan$ 
mbp:build stevemulligan$ curl -H 'Client-ID: wx6ynt7kpj3d3tgrozk639fl2rs0qr' -X GET 'https://api.twitch.tv/helix/streams?user_login=forsen'
{"data":[{"id":"33716663712","user_id":"22484632","user_name":"forsen","game_id":"498638","community_ids":["fd0eab99-832a-4d7e-8cc0-04d73deb2e54"],"type":"live","title":"@forsen, First time playing Anno.","viewer_count":9297,"started_at":"2019-04-16T12:10:43Z","language":"en","thumbnail_url":"https://static-cdn.jtvnw.net/previews-ttv/live_user_forsen-{width}x{height}.jpg","tag_ids":["6ea6bca4-4712-4ab9-a906-e3336a9d8039"]}],"pagination":{"cursor":"eyJiIjpudWxsLCJhIjp7Ik9mZnNldCI6MX19"}}mbp:build stevemulligan$ 
mbp:build stevemulligan$ 

*/

$curl = curl_init();
curl_setopt_array($curl, [
  CURLOPT_URL => 'https://api.twitch.tv/helix/streams?user_login=' . $argv[1],
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_HTTPHEADER => ['Client-ID: wx6ynt7kpj3d3tgrozk639fl2rs0qr']

]);

$server_output = curl_exec ($curl);

curl_close ($curl);

$obj = json_decode($server_output);
$filename = 'streamwatcher.' . $argv[1] . '.active';
if (count($obj->data) > 0) {
 if (!file_exists($filename)) {
   file_put_contents($filename, 'active');
   file_get_contents('https://maker.ifttt.com/trigger/stream_started/with/key/gssJoaD0y2gnLfKGFYUDfchPFrL7ZpUL3sD9RTB33Di');
 }
} else {
 if (file_exists($filename)) {
   unlink($filename);
   file_get_contents('https://maker.ifttt.com/trigger/stream_stopped/with/key/gssJoaD0y2gnLfKGFYUDfchPFrL7ZpUL3sD9RTB33Di');
 }
}

