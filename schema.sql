CREATE DATABASE doings_done;


CREATE TABLE projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  project_title VARCHAR(60),
  user_id INT(10)
);

CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_of_creation DATE(10),
  status INT(1),
  task_title VARCHAR(80),
  task_file VARCHAR(30),
  deadline DATE(10),
  user_id INT(10),
  project_id INT(10)
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_of_registration DATE(10),
  email VARCHAR(40),
  user_name VARCHAR(40),
  password VARCHAR(70)
);

CREATE UNIQUE INDEX email ON users(email);
CREATE UNIQUE INDEX user ON users(user_name);
CREATE INDEX projects ON projects(project_title);
CREATE INDEX date ON tasks(date_of_creation);
CREATE INDEX status ON tasks(status);
CREATE INDEX task ON tasks(task_title);
CREATE INDEX deadline ON tasks(deadline);

//ЭТИ комментарии я перед проверкой удалял!!!//
// Типы данных CHAR- короткая строка; DATE дата; DATETIME дата+ время; INT -целое число; 
//CREATE INDEX имя_индекса ON таблица(поле); простой индекс
//CREATE UNIQUE INDEX имя_индекса ON таблица(поле); уникальный индекс