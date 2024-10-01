<?php
session_start();

session_unset();
session_destroy();

header("location: /NSS_NEW/index.php");
exit;
?>