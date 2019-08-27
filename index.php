<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);


require_once("functions.php");

require_once("data.php");
require_once ("init.php");

$projects = get_projects();
$tasks ="";
$task_counting=get_tasks();

if (isset($_GET['id']) && $_GET['id'] == '1') {
    $projects_id = '1';
}
elseif (isset($_GET['id']) && $_GET['id'] == '2') {
    $projects_id = '2';
}
elseif (isset($_GET['id']) && $_GET['id'] == '3') {
    $projects_id = '3';
}
elseif (isset($_GET['id']) && $_GET['id'] == '4') {
    $projects_id = '4';
}
elseif (isset($_GET['id']) && $_GET['id'] == '5') {
    $projects_id = '5';
}

else {
    $tasks=$task_counting;}

$sql ="SELECT  deadline, task_title, status, project_id FROM tasks
        JOIN projects ON tasks.project_id = projects.id WHERE projects.id=$projects_id";

if ($result = mysqli_query($link, $sql)) {
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

if ($_GET['id']> count($projects) or count($tasks)==0){

    print("страница не найдена, код ответа 404");


}
else {
    $page_content = include_template("main.php", ["tasks" => $tasks, "projects" => $projects,
        "projects_id"=>$projects_id, "task_counting"=>$task_counting ] );
    $layout_content = include_template("layout.php", [
        'content' => $page_content,
        'user_name' => "Константин",
        'title' => 'Дела в порядке - Главная страница'
    ]);
    print($layout_content);}





