<?php
if (isset($message['text'])) {
	
	$text = $message['text'];
	$chat_id = $message['chat']['id'];
	$from_id = $message['from']['id'];
	
	if($text == "!admin" and isAdmin($from_id)) {
		botRequest("sendMessage", array('chat_id' => $chat_id, "text" => "Welcome admin!"));
	}

}