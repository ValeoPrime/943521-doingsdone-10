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

};

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

?>
