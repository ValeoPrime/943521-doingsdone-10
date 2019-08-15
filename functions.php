<?php
function tasks_count($task_list, $title_task) {
    $quantity_task=0;
    foreach ($task_list as $key=>$value) {
        if ($value["category"]===$title_task){
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
?>
