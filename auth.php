<?php

require_once ("init.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validation_fields = ['email', 'password'];
    $errors = [];
    $validation_rules = [
        'email' => function () {
            return validateFilled('email');
        },
        'password' => function () {
            return validateFilled('password');
        }
    ];

    foreach ($_POST as $key => $value) {
        if (isset($validation_rules[$key])) {
            $rule = $validation_rules[$key];
            $errors[$key] = $rule();
        }
    }

    $errors = array_filter($errors);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($link, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (!count($errors) and $user["password"]) {
        if (password_verify($_POST['password'], $user['password'])) {
          $_SESSION['user'] = $user;
        }
        else {
            $errors['password'] = 'Неверный пароль';
        }
    }
    else {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if (count($errors)) {
        $page_content = include_template('auth.php', [ 'errors' => $errors]);
    }
    else {
            header("Location: /index.php");
            exit();
        }
}
else {
    $page_content = include_template('auth.php', []);
    if (isset($_SESSION['user'])) {
        header("Location: /index.php");
        exit();
    }
}

$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user_name' => $_SESSION['user']['user_name'],
    'title' => 'Дела в порядке - Главная страница'
]);
print($layout_content);
