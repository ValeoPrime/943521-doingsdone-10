<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);


require_once("functions.php");

require_once("data.php");

$projects = get_projects();
$tasks = get_tasks();

$page_content = include_template("main.php", ["tasks" => $tasks, "projects" => $projects] );
$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user_name' => "Константин",
    'title' => 'Дела в порядке - Главная страница'
]);
print($layout_content);



