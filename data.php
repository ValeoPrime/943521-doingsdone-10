<?php

function get_projects() {

    $link = mysqli_connect("localhost", "root", "", "doings_done");
    mysqli_set_charset($link, "utf8");

    if ($link == false) {
        return ("Ошибка: Невозможно подключиться к MySQL ");

    } else {
        $sql = 'SELECT `project_title` FROM projects';
        $result = mysqli_query($link, $sql);
        if ($result) {
            $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

            return $projects;
        }
        else {
            return ("Шеф,Все пропало");

        }
    }


};

function get_tasks() {

    $link = mysqli_connect("localhost", "root", "", "doings_done");
    mysqli_set_charset($link, "utf8");

    if ($link == false) {
        return ("Ошибка: Невозможно подключиться к MySQL ");

    } else {
        $sql = 'SELECT task_title, deadline, status, project_id FROM tasks
        JOIN projects ON tasks.project_id = projects.id ';
        $result = mysqli_query($link, $sql);
        if ($result) {
            $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

            return var_dump($tasks);
        }
        else {
            return ("Шеф,Все пропало или нет?");

        }
    }



//    return [
//        [
//            "title"=>"Собеседование в IT компании",
//            "date"=>"01.12.2018",
//            "category"=>"Работа",
//            "completed"=>false
//        ],
//        [
//            "title"=>"Выполнить тестовое задание",
//            "date"=>"25.12.2018",
//            "category"=>"Работа",
//            "completed"=>false
//        ],
//        [
//            "title"=>"Сделать задание первого раздела",
//            "date"=>"21.12.2018",
//            "category"=>"Учеба",
//            "completed"=>true
//        ],
//        [
//            "title"=>"Встреча с другом",
//            "date"=>"22.12.2018",
//            "category"=>"Входящие",
//            "completed"=>false
//        ],
//        [
//            "title"=>"Купить корм для кота",
//            "date"=>"Нет",
//            "category"=>"Домашние дела",
//            "completed"=>false
//        ],
//        [
//            "title"=>"Заказать пиццу",
//            "date"=>"Нет",
//            "category"=>"Домашние дела",
//            "completed"=>false
//        ]
//    ];
};
