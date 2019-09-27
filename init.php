<?php

require_once("functions.php");
session_start();

define('CACHE_DIR', basename(__DIR__ . DIRECTORY_SEPARATOR . 'cache'));
define('UPLOAD_PATH', basename(__DIR__ . DIRECTORY_SEPARATOR . 'uploads'));

$link = mysqli_connect("localhost", "root", "", "doings_done");
mysqli_set_charset($link, "utf8");
