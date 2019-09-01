<?php
require_once("functions.php");

require_once("data.php");
require_once ("init.php");

$projects = get_projects();
$task_counting=get_tasks();
$upload_files=[];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//var_dump($_POST);

    $validation_fields = ['email', 'password', 'name'];
    $errors = [];

    $validation_rules = [
        'email' => function () {
            return validateFilled('email');
        },
//        'email' => function () {
//            return validateEmail('email');
//        },
        'password' => function () {
            return validateFilled('password');
        },
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

    $errors = array_filter($errors);
//    var_dump($errors);
    $new_user = [];
    array_push($new_user, $_POST ['email']);
    array_push($new_user, $_POST ['password']);
    array_push($new_user, $_POST ['name']);



    if (count($errors)) {
        $page_content = include_template('user_registration.php', [ 'errors' => $errors]);
    }
    else {
        $sql = 'INSERT INTO tasks (date_of_registration, email, user_name, password) 
            VALUES (NOW(), ?, ?, ?)';

        $stmt = db_get_prepare_stmt($link, $sql, $new_user);

        $res = mysqli_stmt_execute($stmt);

        if ($res) {
//                $last_id = mysqli_insert_id($link);

            header("Location: index.php"); //?id=" . $_POST ['project'])
            $page_content = include_template('user_registration.php', ["projects" => $projects, 'errors' => $errors,
                "task_counting" => $task_counting, "upload_files"=>$upload_files]);


        }
    }



}
else {
    $page_content = include_template('user_registration.php', []);
}


$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user_name' => "",
    'title' => 'Дела в порядке - Регистрация'
]);

print($layout_content);
