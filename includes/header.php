<?php
use techdeals as PHP;

require_once "Session.php";
require_once "init.php";
require_once "Validator.php";
require_once "User.php";
require_once "Util.php";
require_once "Category.php";
require_once "UserRestrict.php";

$restrict = new PHP\UserRestrict();

$restrict->restrict();

$session = PHP\Session::getInstance();
$bdd = PHP\Database::getDatabase();
$user = PHP\User::getInstance();
$util = PHP\Util::class;
$category = PHP\Category::getCategory();
$validator = new PHP\Validator($session);

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="assets/icones/favicon.ico">
    <meta charset="utf-8"/>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=no" name="viewport"/>
    <meta content="TechDeals team" name="author"/>
    <title>TechDeals</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/custom/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="assets/custom/font_icons/icon_sets.css">
    <link rel="stylesheet" href="assets/custom/main.css">
</head>
<body class="colored">
