<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$projects=["Входящие", "Учеба", "Работа", "Домашние дела", "Авто" ];

$tasks=[
    [
        "title"=>"Собеседование в IT компании",
        "date"=>"01.12.2018",
        "category"=>"Работа",
        "completed"=>false
    ],
    [
        "title"=>"Выполнить тестовое задание",
        "date"=>"25.12.2018",
        "category"=>"Работа",
        "completed"=>false
    ],
    [
        "title"=>"Сделать задание первого раздела",
        "date"=>"21.12.2018",
        "category"=>"Учеба",
        "completed"=>true
    ],
    [
        "title"=>"Встреча с другом",
        "date"=>"22.12.2018",
        "category"=>"Входящие",
        "completed"=>false
    ],
    [
        "title"=>"Купить корм для кота",
        "date"=>"Нет",
        "category"=>"Домашние дела",
        "completed"=>false
    ],
    [
        "title"=>"Заказать пиццу",
        "date"=>"Нет",
        "category"=>"Домашние дела",
        "completed"=>false
    ]
];

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

$page_content = include_template("main.php", ["tasks" => $tasks, "projects" => $projects] );
$layout_content = include_template("layout.php", [
    'content' => $page_content,
    'user_name' => "Константин",
    'title' => 'Дела в порядке - Главная страница'
]);
print($layout_content);
//?>

