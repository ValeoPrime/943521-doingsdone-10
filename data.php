<?php
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

function get_category($category) {
    return($category);
};

get_category($projects);
get_category($tasks);
