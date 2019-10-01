<?php
/**
 * Подсчет количества задач, внутри каждого отдельного проекта
 * @param array $task_list Массив с задачами для фильтрации по проектам
 * @param int $title_task ID проекта по которому отбираются задачи
 *
 * @return int $quantity_task Количество задач
 */
function tasks_count($task_list, $title_task) {
    $quantity_task=0;
    foreach ($task_list as $key=>$value) {
        if ($value["project_id"]===$title_task){
            $quantity_task=$quantity_task+1;
        };
    };
    return $quantity_task;
};

/**
 * Фильтрация текста, получаемого от пользователя для экранирования нежелательных символов
 * @param string $text_to_filter Текст для фильтрации
 *
 * @return string $text Отфильтрованный текст
 */

function filter_text($text_to_filter) {
    $text=htmlspecialchars($text_to_filter);
    return($text);
};

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
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

/**
 * Проверка остатка времени на выполнение задачи
 * @param int $date_tasks Дата задачи
 *
 * @return int $time_lefts Время в часах оставшиеся до окончания срока выполнения задачи
 * (сравнивает дату выполнения задачи с текущей датой)
 */

function burning_task($date_tasks) {
date_default_timezone_set("Europe/Moscow");
$current_date = time();
$secs_in_hour = 3600;
$task_date = strtotime($date_tasks);
$ts_diff = $task_date - $current_date;
$time_lefts = floor($ts_diff / $secs_in_hour); // округление полученного значения в меньшую сторону
return $time_lefts;

}

/**
 * Проверка, не устая ли переменная
 * @param string $name Переменная для проверки
 *
 * @return string Если пустая отдает текст
 * "Поле Название не должно быть пустой строкой"
 */
function validateFilled($name) {
    if (empty($_POST[$name])) {
        return "Поле Название не должно быть пустой строкой";
    }
}

/**
 * Проверка, существует ли проект с названием,
 * которое пытается добавить пользователь
 * @param string $link Ресурс подключения
 * @param string $project Название проекта
 *
 * @return string Если проект с таким названием есть отдает строку
 * "Проект с таким названием уже сущестует"
 */
function validateProject($link, $project) {
    $project_sql ="SELECT * FROM projects WHERE project_title='$project'";
    $result = mysqli_query($link, $project_sql);
    if ($result){
        return "Проект с таким названием уже сущестует";
    }
}

/**
 * Проверка, зарегистрирована ли почта,
 * под которой пытается регистрироваться пользователь
 * @param string $link Ресурс подключения
 * @param string $email Название почты
 *
 * @return string Если почта с таким названием есть отдает строку
 * "Почта занята"
 */
function validateEmail($link, $email) {
    $email_sql ="SELECT email FROM users WHERE email='$email'";
    $result = mysqli_query($link, $email_sql);
    if (mysqli_num_rows($result)>0 ){
        return "Указанный E-mail занят";
    }
}
/**
 * Проверка, соблюдения корректного ввода даты завершения задачи, ввода еще не прошедшей даты
 * @param int $date Проверяемая дата
 *
 * @return string Если дата в неверном формате или уже прошла отдает строку
 * "Дата выбрана в неверном формате или выбрана прошедшая дата"
 */

function validateDate($date) {
    if ( date('Y-m-d', strtotime($_POST[$date])) !== $_POST[$date] and !empty($_POST[$date])
        or date('Y-m-d', strtotime($_POST[$date]))<date('Y-m-d') and !empty($_POST[$date]) ) {
        return "Дата выбрана в неверном формате или выбрана прошедшая дата";
    }
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
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
/**
 * Получает список проектов из БД
 *
 * @param $link mysqli Ресурс соединения
 * @return array $projects Массив с проектами
 */

function get_projects($link) {

    if ($link === false) {
        return ("Ошибка: Невозможно подключиться к MySQL ");
    } else {
        $sql = 'SELECT id, project_title FROM projects';
        $result = mysqli_query($link, $sql);
        if ($result) {
            $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $projects;
        }
    }
};

/**
 * Получает список задач из БД
 *
 * @param $link mysqli Ресурс соединения
 * @return array $tasks Массив с задачами
 */

function get_tasks ($link) {

    if ($link === false) {
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
        }
    }
};

/**
 * Приводит дату задачи в вид день месяц год
 *
 * @param array $tasks Массив с задачами, дата формата: год, месяц, день
 * @return array $tasks Массив с задачами, дата формата: день, месяц, год
 */
function dateformat ($tasks) {
    foreach ($tasks as $key=>$value) {

        if ($value ["deadline"]>0) {
            $date=strtotime($value ["deadline"]);
            $formatted_date = date("d-m-Y",$date);
            $tasks [$key]["deadline"]=$formatted_date;
        }
    };
    return $tasks;
}


