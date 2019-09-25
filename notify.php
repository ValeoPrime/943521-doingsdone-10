<?php
require_once 'vendor/autoload.php';
require_once 'init.php';

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$sql = "SELECT  id, user_name, email FROM users";
    if ($result = mysqli_query($link, $sql)) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
foreach ($users as $value) {
    $user_id=$value["id"];
    $sql = "SELECT  id, deadline, task_title, status FROM tasks JOIN users ON user_id = users.id 
    WHERE user_id=$user_id AND status='0'";
    if ($result = mysqli_query($link, $sql)) {
        $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if(!empty($tasks)){

            $text = '';
            foreach($tasks as $value) {
            $text .= $value['task_title'] . "\n";
            }

            $recipients = [];

            foreach ($users as $user) {
                $recipients[$user['email']] = $user['user_name'];
            }

            $message = new Swift_Message();
            $message->setSubject("Уведомление от сервиса «Дела в порядке»");
            $message->setFrom(['keks@phpdemo.ru' => 'DoingsDone']);
            $message->setBcc($recipients);

            $msg_content = include_template('task_email.php', ['text' => $text, 'users' => $users]);
            $message->setBody($msg_content, 'text/html');

            $result = $mailer->send($message);

            if ($result) {
                print("Рассылка успешно отправлена");
            }
            else {
                print("Не удалось отправить рассылку");
            }
        }
    }
}

