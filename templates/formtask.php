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
    <a class="button button--transparent button--plus content__side-button" href="form-project.html">Добавить проект</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Добавление задачи</h2>

    <form class="form"  action="add.php" method="post" autocomplete="off"  enctype="multipart/form-data">
        <div class="form__row">

            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input <?php if (isset($errors['name'])): ; ?>
            form__input--error
                                        <?php endif;?>
            " type="text" name="name" id="name" value="" placeholder="Введите название">
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <select class="form__input form__input--select <?php if (isset($errors['project'])): ; ?>
            form__input--error
                                        <?php endif;?>
                            " name="project" id="project">
                <?php foreach ($projects as $value): ;?>

                    <option value="<?=$value["id"]; ?>"><?=$value["project_title"]; ?></option>

                <?php endforeach; ?>
            </select>

        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date <?php if (isset($errors['date'])): ; ?>
            form__input--error
                                        <?php endif;?>
            " type="text" name="date" id="date" value="" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
        </div>

        <div class="form__row">
            <label class="form__label" for="file">Файл</label>

            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="file" id="file" value="">

                <label class="button button--transparent" for="file">
                    <span>Выберите файл</span>
                </label>
            </div>
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




