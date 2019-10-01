<?php
session_start();

$_SESSION = [];
header("Location:unregistred_user.php");
