<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "./incl/lib/connection.php";
require_once "./incl/lib/GJPCheck.php";

$id = GJPCheck::getAccountIDOrDie();

echo $id;
?>
