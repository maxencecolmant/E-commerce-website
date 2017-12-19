<?php
include_once  "includes\init.php";
include_once  "includes\Session.php";

$session->delete('connected');
header("Location: /index.php");