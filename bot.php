<?php
require "config.php";

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
	// receive wrong update, must not happen
	// maybe a user opened this url?
	exit;
}

if (isset($update["message"])) {
	$message = $update["message"];
} elseif (isset($update["callback_query"])) {
	$callback = $update["callback_query"];
}

require "function.php";
require "plugin.php";