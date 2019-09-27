<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>
    <nav class="main-navigation">
        <ul class="main-navigation__list">

            <?php foreach($projects as $value): ;?>
                <li class="main-navigation__list-item
                        <?php if ($value["id"]===$projects_id): ;?>
                        main-navigation__list-item--active
                        <?php endif ?>
                        <?=$active_project; ?>">
                    <a class="main-navigation__list-item-link" href="/?id=<?=$value["id"]; ?>"><?=filter_text($value["project_title"]); ?></a>
                    <span class="main-navigation__list-item-count"><?=tasks_count($task_counting, $value["id"]); ?>
                </li>
            <?php endforeach; ?>

        </ul>
    </nav>
    <a class="button button--transparent button--plus content__side-button" href="form-project.php">Добавить проект</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Добавление проекта</h2>

    <form class="form"  action="form-project.php" method="post" autocomplete="off">
        <div class="form__row">
            <label class="form__label" for="project_name">Название <sup>*</sup></label>

            <input class="form__input
            <?php if (isset($errors['name'])or isset($errors['project_name_free'])): ; ?>
            form__input--error
            <?php endif;?>
            " type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">
            <?php if (isset($errors['name'])): ?>
                <p class="form__message">Укажите название проекта</p>
            <?php endif; ?>
            <?php if (isset($errors['project_name_free'])): ?>
                <p class="form__message">Проект с таким названием уже сущестует</p>
            <?php endif; ?>
        </div>
        <?php if (isset($errors)): ?>
            <div class="form__errors">
                <p>Пожалуйста, исправьте следующие ошибки:</p>
                <ul>
                    <?php foreach ($errors as $value): ?>
                        <li><strong><?= $value; ?>:</strong></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</main>
