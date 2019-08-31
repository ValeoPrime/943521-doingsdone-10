<?php
require_once("functions.php");

require_once("data.php");
require_once ("init.php");

$projects = get_projects();
$task_counting=get_tasks();
$upload_files=[];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $new_task=[];// Нужен для выстраивания переменных как в запросе к бд
    array_push($new_task, $_POST ['name']);
    array_push($new_task, $_FILES['file']['name']);
    if (empty($_POST ['date'])) {
        array_push($new_task, 0);
    }
    else {array_push($new_task, $_POST ['date']);}
//    array_push($new_task, $_POST ['date']);
    array_push($new_task, "1");
    array_push($new_task, $_POST ['project']);

    $validation_fields = ['name', 'project', 'date'];
    $errors = [];

    $validation_rules = [
        'name' => function () {
            return validateFilled('name');
        },
        'project' => function () {
            return validateProject('project');
        },
        'date' => function () {
            return validateDate('date');
        }

    ];

    foreach ($_POST as $key => $value) {
        if (isset($validation_rules[$key])) {
            $rule = $validation_rules[$key];
            $errors[$key] = $rule();
        }
    }

    $errors = array_filter($errors); // обходит массив выкидывает оттуда значения нулл



    if (isset($_FILES['file']['name']) and !empty($_FILES['file']['name'])) {
        $tmp_name = $_FILES['file']['tmp_name'];
        $path = $_FILES['file']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
//var_dump($file_type);

        if ($file_type !== "image/png" ) {
            $errors['file'] = 'Загрузите файл в формате png';

        } else {
            $filename = uniqid() . '.png';
            move_uploaded_file($tmp_name, 'uploads/' . $filename);
            $upload_files['path'] = $filename; //Ссылка на загруженный пользователем файл

        }
//        var_dump($filename);
    }


        if (count($errors)) {
            $page_content = include_template('formtask.php', ["projects" => $projects, 'errors' => $errors,
                "task_counting" => $task_counting]);
        }
        else {
            $sql = 'INSERT INTO tasks (date_of_creation, status, task_title, task_file, deadline, user_id, project_id) 
            VALUES (NOW(), 0, ?, ?, ?, ?, ?)';

            $stmt = db_get_prepare_stmt($link, $sql, $new_task);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
//                $last_id = mysqli_insert_id($link);

                header("Location: index.php"); //?id=" . $_POST ['project'])
                $page_content = include_template('formtask.php', ["projects" => $projects, 'errors' => $errors,
                    "task_counting" => $task_counting, "upload_files"=>$upload_files]);


            }
        }
}
else {
    $page_content = include_template('formtask.php', ["projects" => $projects, "task_counting" => $task_counting]);
}


$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user_name' => "Константин",
    'title' => 'Дела в порядке - Главная страница'
]);

print($layout_content);
var_dump($upload_files);




