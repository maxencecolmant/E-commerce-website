<?php

use techdeals as PHP;

require_once "./includes/Session.php";
require_once "./includes/init.php";
require_once "./includes/Validator.php";
require_once "./includes/User.php";
require_once "./includes/Util.php";

PHP\User::getInstance()->logout();