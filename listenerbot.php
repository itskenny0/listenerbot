<?php
$cfg = file_get_contents("listenerbot.cfg.json") or die("Config file not found.");
$map = json_decode($cfg) or die("Config file is not valid JSON.");

$input = file_get_contents("php://input"); 
$sJ = json_decode($input, true) or die("Invalid JSON input.");

if(empty($sJ['message']['photo']) && empty($sJ['message']['document'])) die(); // Only images and files are forwarded.
if(!isset($map[(string) $sJ['message']['chat']['id']])) die(); // Ignore messages from chats not mapped.

$reply['method'] = "forwardMessage";
$reply['from_chat_id'] = $sJ['message']['chat']['id'];
$reply['message_id'] = $sJ['message']['message_id'];
$reply['chat_id'] = $map[(string) $sJ['message']['chat']['id']];

header("Content-Type: application/json");
echo json_encode($reply);