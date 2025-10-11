<?php
include './config/latestUpdate.php';

$info = array(
  'version' => $latestVersion['version'],
  'download_url' => "https://{$_SERVER['HTTP_HOST']}/gdps/download.php"
);

echo json_encode($info, JSON_UNESCAPED_SLASHES);
?>
