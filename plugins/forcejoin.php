<?php

$callback_data_overhead = "ok-";
$channel_id = "@bafix";

if (isset($message['text'])) {

	$chat_id = $message['chat']['id'];
	$from_id = $message['from']['id'];
	$message_id = $message['message_id'];

	$chat_member = botRequest("getChatMember", array("chat_id" => $channel_id, "user_id" => $from_id));
	$joined_status = ["creator", "administrator", "member"];

	if(!in_array($chat_member['status'], $joined_status)) {
		$alert_message = "⚠️ | <a href='tg://user?id=$from_id'>کاربر عزیز</a> شما در کانال $channel_id عضو نیستید.\nنتیجه: پیام شما بصورت خودکار حذف شد.";
		botRequest("sendMessage", array("chat_id" => $chat_id, "text" => $alert_message,
		"reply_to_message_id" => $message_id, "parse_mode" => "HTML",
		"reply_markup" => array(
			"inline_keyboard" => array(
				array(
					array("text" => "باشه، عضو شدم.",
					"callback_data" => $callback_data_overhead.$from_id)
				)
		))
	));
		botRequest("deleteMessage", array("chat_id" => $chat_id, "message_id" => $message_id));
	}
}

if(isset($callback)) {
	$callback_message_id = $callback["message"]["message_id"];
	$callback_data = $callback['data'];

	// if overhead checked:
	if(strpos($callback_data, $callback_data_overhead) === 0){
		// remove the overhead
		$callback_data = substr($callback_data, 3);
		if($callback_data == $callback["from"]["id"]) {
			$chat_member = botRequest("getChatMember", array("chat_id" => $channel_id, "user_id" => $callback_data));
			$joined_status = ["creator", "administrator", "member"];
			if(in_array($chat_member['status'], $joined_status)){
				botRequest("answerCallbackQuery", array("callback_query_id" => $callback["id"], "text" => "✅ | باتشکر؛ عضویت شما در کانال $channel_id تایید شد. برای ادامه‌ی استفاده از گروه باید در کانال عضو بمانید.", "show_alert" => true));
				botRequest("deleteMessage", array("chat_id" => $callback["message"]["chat"]["id"], "message_id" => $callback_message_id));
			}
			else {
				botRequest("answerCallbackQuery", array("callback_query_id" => $callback["id"], "text" => "⚠️ | شما هنوز در کانال $channel_id عضو نشده اید.", "show_alert" => true));
			}
		} else {
			botRequest("answerCallbackQuery", array("callback_query_id" => $callback["id"], "text" => "⛔️ | این پیام مربوط به شما نیست.", "show_alert" => true, "cache_time" => 900));
		}
	}
}


