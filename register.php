<?php

require_once ("init.php");

$projects = get_projects($link);
$task_counting=get_tasks($link);

$upload_files=[];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validation_fields = ['email', 'password', 'name'];
    $errors = [];
    $validation_rules = [

        'email' => function () {
            return validateFilled('email');
        },
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
    $errors['email_format'];
    if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)===false){
            $errors['email_format']=1;
    };

    $errors['email_free']=validateEmail($link, $_POST['email']);
    $errors = array_filter($errors);
    if (count($errors)) {
        $page_content = include_template('user_registration.php', [ 'errors' => $errors]);
    }
    else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $_POST ['password']=$password;
        $new_user = [];
        array_push($new_user, $_POST ['email']);
        array_push($new_user, $_POST ['password']);
        array_push($new_user, $_POST ['name']);

        $sql = 'INSERT INTO users (date_of_registration, email, password, user_name) 
            VALUES (NOW(), ?, ?, ?)';

        $stmt = db_get_prepare_stmt($link, $sql, $new_user);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            header("Location: index.php");
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
