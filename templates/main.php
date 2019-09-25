<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>
    <nav class="main-navigation">
        <ul class="main-navigation__list">

            <?php foreach($projects as $value): ;?>
                <li class="main-navigation__list-item
                <?php if ($value["id"]==$projects_id): ;?>
                main-navigation__list-item--active
                <?php endif ?>
                <?=$active_project; ?>">
                    <a class="main-navigation__list-item-link" href="/?id=<?=$value["id"]; ?>"><?=filter_text($value["project_title"]); ?></a>
                    <span class="main-navigation__list-item-count"><?=tasks_count($task_counting, $value["id"]); ?>
                </li>
            <?php endforeach; ?>

        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button"
       href="form-project.php" target="project_add">Добавить проект</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.php" method="get" autocomplete="off">
        <input class="search-form__input" type="text" name="q" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">

            <a href="/?alltasks" class="tasks-switch__item
            <?php if (isset($_GET['alltasks'])): ;?>
            tasks-switch__item--active
            <?php endif ?>
            ">Все задачи</a>
            <a href="/?tasks_for_today" class="tasks-switch__item
            <?php if (isset($_GET['tasks_for_today'])): ;?>
            tasks-switch__item--active
            <?php endif ?>
            ">Повестка дня</a>
            <a href="/?tasks_for_tomorrow" class="tasks-switch__item
            <?php if (isset($_GET['tasks_for_tomorrow'])): ;?>
            tasks-switch__item--active
            <?php endif ?>
            ">Завтра</a>
            <a href="/?expired_tasks" class="tasks-switch__item
            <?php if (isset($_GET['expired_tasks'])): ;?>
            tasks-switch__item--active
            <?php endif ?>
">Просроченные</a>

        </nav>

        <label class="checkbox">
            <input class="checkbox__input visually-hidden show_completed" type="checkbox"
                <?php if ($show_completed === '1'): ?>
                    checked
                <?php endif; ?>>

            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>

    <table class="tasks">

        <?php foreach($tasks as $value):;?>
            <tr class="tasks__item task
            <?php
            if ($value['status']==='1'): ?>
                                task--completed
            <?php endif ?>
            <?php if ($show_completed==='0' and $value["status"]==='1'): ?>
                            visually-hidden
            <?php endif ?>

            <?php
            $time_left=burning_task($value["deadline"]);
            ?>
            <?php if ($time_left>0 && $time_left<=24): ?>
                task--important
            <?php endif ?>
                            ">
                 <td class="task__select">
                      <label class="checkbox task__checkbox">

                          <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="<?=$value["id"]; ?>"
                        <?php if($value["status"]=='1'): ?>
                        checked
                        <?php endif ?>>

                          <span class="checkbox__text"><?=$value["task_title"]; ?> </span>

                    </label>
                        <?php if (!empty($value["task_file"]) ): ?>
                            <a href="uploads/<?= $value["task_file"]; ?>"><img src="img/download-link.png" width="14" height="16" alt="Загруженный файл"></a>
                        <?php endif; ?>
                </td>


                <td class="task__date"><?php
                    if ($value["deadline"]<= 0) { print ("Нет");}
                    else {print($value["deadline"]);}
                    ?></td>
                <td class="task__controls"></td>
            </tr>
        <?php endforeach ?>


    </table>
</main>
