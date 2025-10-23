<?php
require 'Client.php';
require 'Embed.php';

function PostToHookByUrl($token, $em_title, $em_message, $em_colour) {
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

function PostToHook($em_title, $em_message, $em_colour = 0x5c00a8)
{
	include dirname(__FILE__)."/../../../config/connection.php";

	// rates
	PostToHookByUrl($webhookUrl, $em_title, $em_message, $em_colour);
}

function PostToAlt($em_title, $em_message, $em_colour = 0x5c00a8)
{
	include dirname(__FILE__)."/../../../config/connection.php";

	// sends
	PostToHookByUrl($webhookUrlAlt, $em_title, $em_message, $em_colour);
}

function PostToActions($em_title, $em_message, $em_colour = 0x5c00a8)
{
	include dirname(__FILE__)."/../../../config/connection.php";

	// sends
	PostToHookByUrl($webhookUrlActions, $em_title, $em_message, $em_colour);
}

?>
