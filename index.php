<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);


require_once("functions.php");

require_once("data.php");
require_once ("init.php");

$projects = get_projects();
$tasks ="";
$task_counting=get_tasks();

if (empty($_SESSION)) {
    header("Location: unregistred_user.php");

}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $projects_id = $_GET['id'];
}
else {
    $tasks=$task_counting;
}

$sql ="SELECT  deadline, task_title, status, project_id FROM tasks
        JOIN projects ON tasks.project_id = projects.id WHERE projects.id=$projects_id ";

//var_dump($_SESSION);

if (isset($_SESSION['user']['id'])) {  //счет тасков по проектам для конкретного пользователя
    $userid = $_SESSION['user']['id'];
    $sql = "SELECT   deadline, task_title, status, project_id, task_file FROM tasks 
        WHERE user_id=$userid";
    if ($result = mysqli_query($link, $sql)) {
        $task_counting = mysqli_fetch_all($result, MYSQLI_ASSOC);

    };


}

if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];
    $sql ="SELECT  deadline, task_title, status, user_id, project_id FROM tasks WHERE user_id=$user_id";

}

if ($result = mysqli_query($link, $sql)) { // таски для конкретного пользователя
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

}

$project_sql ="SELECT id=$projects_id, project_title FROM projects";

//if ($project_sql==false or count($tasks)==0){
//
//    print("страница не найдена, код ответа 404");
// }
//

    $page_content = include_template("main.php", ["tasks" => $tasks, "projects" => $projects,
        "projects_id"=>$projects_id, "task_counting"=>$task_counting ] );

    $layout_content = include_template("layout.php", [
        'content' => $page_content,
        'user_name' => $_SESSION['user']['user_name'],
        'title' => 'Дела в порядке - Главная страница'
    ]);



    print($layout_content);
//}




