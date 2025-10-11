<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "./incl/lib/connection.php";
require_once "./incl/lib/GJPCheck.php";
require_once "./incl/lib/exploitPatch.php";
$ep = new exploitPatch();
$gjp = $ep->remove($_POST["gjp"]);
$id = $ep->remove($_POST["accountID"]);
if($id != "" AND $gjp != ""){
    $GJPCheck = new GJPCheck();
    $gjpresult = $GJPCheck->check($gjp,$id);
    if($gjpresult == 1){
        echo "1";
    } else{
        echo "-2";
    }
} else {
    echo "-1";
}
?>
