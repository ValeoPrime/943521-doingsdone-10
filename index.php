<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);


require_once("functions.php");

require_once("data.php");
require_once ("init.php");

$projects = get_projects();

$task_counting=get_tasks();
$tasks=$task_counting;


if (empty($_SESSION)) {
    header("Location: unregistred_user.php");
}

if (isset($_SESSION['user']['id'])) {  //показ проектов для конкретного пользователя
    $userid = $_SESSION['user']['id'];
    $sql = "SELECT  id,  project_title FROM projects 
        WHERE user_id=$userid";
    if ($result = mysqli_query($link, $sql)) {
        $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
    };
}

if(isset($_GET['task_id'])) { //модификация таска, выполнен/не выполнен
    $task_id = $_GET['task_id'];
    $sql = "SELECT  * FROM tasks WHERE  id=$task_id  ";
    if ($result = mysqli_query($link, $sql)) {
        $task = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if ($task['0']["status"]==0){
            $sql = "UPDATE tasks SET status = 1 WHERE  id=$task_id  ";
            $result = mysqli_query($link, $sql);
        }
        else {
            $sql = "UPDATE tasks SET status = 0 WHERE  id=$task_id  ";
            $result = mysqli_query($link, $sql);
        }
    }
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $projects_id = $_GET['id'];
    $sql ="SELECT tasks.id, deadline, task_title, status, project_id FROM tasks
        JOIN projects ON tasks.project_id = projects.id WHERE projects.id=$projects_id ";
    if ($result = mysqli_query($link, $sql)) { // фильтрация по id проекта
        $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

else {
    $user_id=$_SESSION['user']['id'];
    $sql ="SELECT  tasks.id, deadline, task_title, status, project_id FROM tasks
        JOIN projects ON tasks.project_id = projects.id WHERE tasks.user_id=$user_id ";
    if ($result = mysqli_query($link, $sql)) { // таски для конкретного пользователя
        $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}



if (isset($_GET['tasks_for_today'])){
    $user_id=$_SESSION['user']['id'];
    $sql ="SELECT  tasks.id, deadline, task_title, status, project_id FROM tasks
        JOIN projects ON tasks.project_id = projects.id WHERE tasks.user_id=$user_id  AND deadline=CURDATE() ";
    if ($result = mysqli_query($link, $sql)) {
        $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
if (isset($_GET['tasks_for_tomorrow'])){
    $user_id=$_SESSION['user']['id'];
    $sql ="SELECT  tasks.id, deadline, task_title, status, project_id FROM tasks
        JOIN projects ON tasks.project_id = projects.id WHERE tasks.user_id=$user_id  AND deadline=CURDATE()+1 ";
    if ($result = mysqli_query($link, $sql)) {
        $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
if (isset($_GET['expired_tasks'])){
    $user_id=$_SESSION['user']['id'];
    $sql ="SELECT  tasks.id, deadline, task_title, status, project_id FROM tasks
        JOIN projects ON tasks.project_id = projects.id WHERE tasks.user_id=$user_id  AND deadline<CURDATE() ";
    if ($result = mysqli_query($link, $sql)) {
        $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

if (isset($_SESSION['user']['id'])) {  //счет тасков по проектам для конкретного пользователя
    $userid = $_SESSION['user']['id'];
    $sql = "SELECT  tasks.id, deadline, task_title, status, project_id, task_file FROM tasks 
        WHERE user_id=$userid";
    if ($result = mysqli_query($link, $sql)) {
        $task_counting = mysqli_fetch_all($result, MYSQLI_ASSOC);

    };
}

mysqli_query($link, 'CREATE FULLTEXT INDEX tasks_search ON tasks(task_title)');

$search = $_GET['q'] ?? '';

if ($search) {
    $sql = "SELECT  tasks.id, deadline, task_title, status, user_id, project_id FROM tasks "
        . "JOIN users ON tasks.user_id = users.id "
        . "WHERE MATCH(task_title) AGAINST(?)";

    $stmt = db_get_prepare_stmt($link, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (empty($tasks)) {
        print("Ничего не найдено по вашему запросу");

    }
}

foreach ($tasks as $key=>$value) { //Приводит дату таска в вид день месяц год

    if ($value ["deadline"]>0) {
        $date=strtotime($value ["deadline"]);
        $formatted_date = date("d-m-Y",$date);
        $tasks [$key]["deadline"]=$formatted_date;
    }
};

    $page_content = include_template("main.php", ["tasks" => $tasks, "projects" => $projects,
        "projects_id"=>$projects_id, "task_counting"=>$task_counting, "show_complete_tasks"=>$show_complete_tasks ] );

    $layout_content = include_template("layout.php", [
        'content' => $page_content,
        'user_name' => $_SESSION['user']['user_name'],
        'title' => 'Дела в порядке - Главная страница'
    ]);

    print($layout_content);





