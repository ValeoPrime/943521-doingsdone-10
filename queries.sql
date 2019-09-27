//Добавляем проекты

INSERT INTO projects SET project_title = 'Входящие', user_id = 1;
INSERT INTO projects SET project_title = 'Учеба', user_id = 1;
INSERT INTO projects SET project_title = 'Работа', user_id = 1;
INSERT INTO projects SET project_title = 'Домашние дела', user_id = 2;
INSERT INTO projects SET project_title = 'Авто', user_id = 2;
'
//Добав'ляем пользователей
INSERT INTO users SET date_of_registration = '10.05.19', email = 'vasya@mail.ru', user_name = 'VasiliyVelikiy', password = '123';
INSERT INTO users SET date_of_registration = '12.06.19', email = 'vanya@mail.ru', user_name = 'IvanVelikiy', password = '456';

//Добавляем задачи
INSERT INTO tasks SET date_of_creation = '12.06.19', status = 0, task_title = 'Собеседование в IT компании', task_file = '', deadline = '01.12.18', user_id = 1, project_id = 3;
INSERT INTO tasks SET date_of_creation = '12.06.19', status = 0, task_title = 'Выполнить тестовое задание', task_file = '', deadline = '25.12.18', user_id = 1, project_id = 3;
INSERT INTO tasks SET date_of_creation = '14.06.19', status = 1, task_title = 'Сделать задание первого раздела', task_file = '', deadline = '21.12.18', user_id = 2, project_id = 2;
INSERT INTO tasks SET date_of_creation = '17.06.19', status = 0, task_title = 'Встреча с другом', task_file = '', deadline = '21.12.18', user_id = 1, project_id = 1;
INSERT INTO tasks SET date_of_creation = '16.06.19', status = 0, task_title = 'Купить корм для кота', task_file = '', deadline = '00.00.00', user_id = 2, project_id = 4;
INSERT INTO tasks SET date_of_creation = '16.06.19', status = 0, task_title = 'Заказать пиццу', task_file = '', deadline = '00.00.00', user_id = 2, project_id = 4;
   
mysqli_query($link, 'CREATE FULLTEXT INDEX tasks_search ON tasks(task_title)'); //Создание индекса полнотекстового поиска    

//Получить список из всех проектов для одного пользователя;
SELECT * FROM projects WHERE user_id = 1;

//Получить список из всех задач для одного проекта;
SELECT * FROM tasks WHERE project_id = 3;

//Пометить задачу как выполненную;
UPDATE tasks SET status = 1 WHERE id = 2;

//Обновить название задачи по её идентификатору;
UPDATE tasks SET task_title = 'Собеседование в IT компании ОБНОВЛЕНО' WHERE id = 1;
