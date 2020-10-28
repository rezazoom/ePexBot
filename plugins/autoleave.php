<?php
if (isset($message["new_chat_members"])) {

	$new_member = $message["new_chat_members"];
	$chat_id = $message["chat"]["id"];
	$me = botRequest("getMe", array());

	// bot will autoleave if gets added to a non op_chat
	if($new_member[0]["username"] === $me["username"] AND strtolower($message["chat"]["username"]) != $op_chat) {
		botRequest("sendMessage", array('chat_id' => $chat_id, "text" => "Unauthorized access, leaving this chat."));
		botRequest("leaveChat", array("chat_id" => $chat_id));
	}
}