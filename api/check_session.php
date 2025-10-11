<?php
require_once "../incl/lib/GJPCheck.php";
include "../incl/lib/connection.php";		

header('Content-type: application/json');

if (!empty($_POST['accid']))
{
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	echo ($GJPCheck->check("", $_POST['accid']) == 1) ? json_encode(array("result" => true)) : json_encode(array("result" => false, "message" => "No session found."));
}
else
{
	echo json_encode(array("result" => false, "message" => "Invalid parameters."));
}



?>