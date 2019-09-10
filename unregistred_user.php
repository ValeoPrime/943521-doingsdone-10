<?php

require_once("functions.php");





$page_content = include_template("guest.php", ["tasks" => $tasks ] );

$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user_name' => "",
    'title' => 'Дела в порядке - Главная страница'
]);
print($layout_content);
