<?php 
if (isset($message['text'])) {
	
	$text = $message['text'];
	$chat_id = $message['chat']['id'];
	$from_id = $message["from"]["id"];
	
	if($text == "!ping")
	{
		botRequest("sendMessage", array('chat_id' => $chat_id, "text" => "Pong!"));
	}
	// start command in private
	elseif (($text == "/start" OR $text == "!start") AND $chat_id == $from_id) 
	{
		botRequest("sendMessage", array('chat_id' => $chat_id, "text" => "سلام؛ به ایپکس خوش آمدید."));
	}
	elseif ($text == "!leave" AND isAdmin($from_id)) {
		botRequest("leaveChat", array('chat_id' => $chat_id));
	}

}