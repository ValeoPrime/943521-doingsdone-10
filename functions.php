<?php
function tasks_count($task_list, $title_task) {
    $quantity_task=0;
    foreach ($task_list as $key=>$value) {
        if ($value["project_id"]===$title_task){
            $quantity_task=$quantity_task+1;
        };
    };
    return $quantity_task;
};

function filter_text($text_to_filter) {
    $text=htmlspecialchars($text_to_filter);
    return($text);
};

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;

}

function burning_task($date_tasks) {
date_default_timezone_set("Europe/Moscow");
$current_date = time();

// В одном часе 3600 секунд
$secs_in_hour = 3600;
$task_date = strtotime($date_tasks);

$ts_diff = $task_date - $current_date;
$time_lefts = floor($ts_diff / $secs_in_hour); // округление полученного значения в меньшую сторону

return $time_lefts;

}


// Проверяет не пустая ли переменная
function validateFilled($name) {
    if (empty($_POST[$name])) {
        return "Имя задачи не должно быть пустой строкой";
    }


}
// Проверка есть ли проекты с таким id  в базе
function validateProject($projects_id) {

    $project_sql ="SELECT id=$projects_id FROM projects";
    $result = mysqli_query($link, $project_sql);
    if ($result==false ){
        return "Такого проекта не существует";
    }
    return null;
}

function validateEmail($email) {
    $email_sql ="SELECT email=$email FROM users";
    $result = mysqli_query($link, $email_sql);
    if ($result==true){
        return "Указанный емаил используется другим пользователем";
    }
    return null;
}


// Проверка есть ли проекты с таким id  в базе
function validateCategory($name, $allowed_list) {
    $id = $_POST[$name];

    if (!in_array($id, $allowed_list)) {
        return "Указана несуществующая категория";
    }
    return null;
}

function validateDate($date) {
    if ( date('Y-m-d', strtotime($_POST[$date])) !== $_POST[$date] and !empty($_POST[$date])
        or date('Y-m-d', strtotime($_POST[$date]))<date('Y-m-d') and !empty($_POST[$date]) ) {
        return "Дата выбрана в неверном формате или выбрана прошедшая дата"
        ;}
    else {return null;}

}


function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}


?>
