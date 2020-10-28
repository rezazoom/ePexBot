<?php

$active_plugins = [
  "ping",
  "admin",
  "forcejoin",
  "autoleave"
];

foreach ($active_plugins as $plugin) {
	$plug = "plugins/".$plugin.".php";
	require "$plug";
}