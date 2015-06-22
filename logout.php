<?php
require_once 'includes/global.inc.php';
$user_tools=new UserTools();
$user_tools->logout();
header('Location: index.php');
?>