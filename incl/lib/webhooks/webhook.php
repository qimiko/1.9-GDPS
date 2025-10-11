<?php
require 'Client.php';
require 'Embed.php';

function PostToHook($em_title, $em_message, $em_colour = 0x5c00a8)
{
	include dirname(__FILE__)."/../../../config/connection.php";

	// rates
	$token = $webhookUrl;
	$enabled = true;

	if ($enabled) {
		$webhook = new Client($token);
		$embed = new Embed();

		$embed->title("$em_title");
		$embed->description("$em_message");
		$embed->color($em_colour);

		$webhook->embed($embed)->send();
	}
}

function PostToAlt($em_title, $em_message, $em_colour = 0x5c00a8)
{
	include dirname(__FILE__)."/../../../config/connection.php";

	// sends
	$token = $webhookUrlAlt;
	$enabled = true;

	if ($enabled) {
		$webhook = new Client($token);
		$embed = new Embed();

		$embed->title("$em_title");
		$embed->description("$em_message");
		$embed->color($em_colour);

		$webhook->embed($embed)->send();
	}
}

?>
