<?php
$imgremote="https://cdn.onesnowwarrior.cn/usr/plugins/Live2D/model/textures/01.png";
file_get_contents($imgremote);
ob_start();
readfile($imgremote);
?>