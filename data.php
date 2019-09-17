<?php

function get_projects() {

require("init.php");

    if ($link == false) {
        return ("Ошибка: Невозможно подключиться к MySQL ");

    } else {
        $sql = 'SELECT id, project_title FROM projects';
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


function get_tasks()
{

    require("init.php");

    if ($link == false) {
        return ("Ошибка: Невозможно подключиться к MySQL ");

    } else {
        $sql = 'SELECT   tasks.id, deadline, task_title, status, project_id, task_file FROM tasks 
        JOIN projects ON tasks.project_id = projects.id ORDER BY date_of_creation DESC';

        $result = mysqli_query($link, $sql);
        if ($result) {
            $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($tasks as $key=>$value) {

                if ($value ["deadline"]>0) {
                    $date=strtotime($value ["deadline"]);
                    $formatted_date = date("d-m-Y",$date);
                    $tasks [$key]["deadline"]=$formatted_date;
                }
            };

            return $tasks;



        } else {
            return ("Шеф,Все пропало или нет?");

        }
    }
};


