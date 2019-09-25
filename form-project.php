<?php

require_once ("init.php");

$projects = get_projects($link);
$task_counting=get_tasks($link);

if (isset($_SESSION['user']['id'])) {  //показ проектов для конкретного пользователя
    $userid = $_SESSION['user']['id'];
    $sql = "SELECT   id, project_title FROM projects 
        WHERE user_id=$userid";
    if ($result = mysqli_query($link, $sql)) {
        $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

    };
}

if (isset($_SESSION['user']['id'])) {  //счет тасков по проектам для конкретного пользователя
    $userid = $_SESSION['user']['id'];
    $sql = "SELECT   deadline, task_title, status, project_id, task_file FROM tasks 
        WHERE user_id=$userid";
    if ($result = mysqli_query($link, $sql)) {
        $task_counting = mysqli_fetch_all($result, MYSQLI_ASSOC);
    };
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validation_fields = ['name'];
    $errors = [];
    $validation_rules = [
        'name' => function () {
            return validateFilled('name');
        }
    ];

    foreach ($_POST as $key => $value) {
        if (isset($validation_rules[$key])) {
            $rule = $validation_rules[$key];
            $errors[$key] = $rule();
        }
    }

    foreach ($projects as $value) { //Посик совпадений по названиям проектов НЕ УЧИТЫВАЕТ РЕГИСТР
        if ($_POST['name']==$value['project_title']){
            $errors['project_name_free']="Проект с таким названием уже сущестует";}

    };

    $errors = array_filter($errors); // обходит массив выкидывает оттуда значения нулл
    $new_project=[];// Нужен для выстраивания переменных как в запросе к бд
    array_push($new_project, $_POST ['name']);
    array_push($new_project, $_SESSION['user']['id']);

    if (count($errors)) {
        $page_content = include_template('projectform.php', ["projects" => $projects, 'errors' => $errors,
            "task_counting" => $task_counting]);
    }
    else {
        $sql = 'INSERT INTO projects (project_title, user_id) VALUES (?, ?)';
        $stmt = db_get_prepare_stmt($link, $sql, $new_project);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            header("Location: index.php"); //?id=" . $_POST ['project'])
        }
    }
}
else {
    $page_content = include_template('projectform.php', ["projects" => $projects, "task_counting" => $task_counting]);
}

$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user_name' => "",
    'title' => 'Дела в порядке - Главная страница'
]);

print($layout_content);
