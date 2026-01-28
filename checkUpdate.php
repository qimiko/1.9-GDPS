<?php
include './config/latestUpdate.php';

$info = array(
  'version' => $latestVersion['version'],
  'download_url' => 'https://19gdps.com/download.php'
);

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($info, JSON_UNESCAPED_SLASHES);
?>
