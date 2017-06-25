<?php
  include "login.php"; // POST: login pass
  $type = prover($_POST["type"]); // Регистрация, фотоальбомы, фотографии, друзья, сообщения, группы
  $action = prover($_POST["action"]); // 1 - Добавление, 2 - Список, 3 - Загрузка, 4 - Редактирование, 5 - Удаление, ...

  $id = prover($_POST["id"]); // Идентификатор
  $alias = prover($_POST["alias"]); // Псевдоним пользователя (может отличаться от логина)
  $myemail = prover($_POST["myemail"]); // e-mail при регистрации
  $username = prover($_POST["username"]); // имя пользователя при регистрации
  $password = prover($_POST["password"]); // пароль при регистрации
  $password_r = prover($_POST["password_r"]); // подтверждение ввода пароля

  $lfm = prover($_POST["lfm"]); // ФИО пользователя
  $city = prover($_POST["city"]); // город (текст)

  $message_type = prover($_POST["message_type"]); // 0 - Входящее, 1 - Исходящее
  $message_text = prover($_POST["message_text"]); // Текст отправляемого сообщения

  include "class/main_class.php";
  include "class/reguser.php"; // Регистрация пользователя
  include "class/users.php"; // Пользователь
  include "class/city.php"; // Города
  include "class/friends.php"; // Друзья
  include "class/messages.php"; // Сообщения
  include "class/fotos.php"; // Фотографии
  include "class/fotoalbums.php"; // Фотоальбомы

  if ($status == 0)
  {
    switch($type)
    {
      case 1: // Пользователь
        $sql_list = "SELECT SOCIAL_user.id id, SOCIAL_user.lfm, SOCIAL_city.city
FROM SOCIAL_alias, SOCIAL_user
LEFT JOIN SOCIAL_city ON SOCIAL_city.id = SOCIAL_user.city
WHERE SOCIAL_alias.alias = '$alias' and SOCIAL_alias.id = SOCIAL_user.id";
        $sql_load = "SELECT $table_user.id, $table_user.login, $table_user.lfm, SOCIAL_city.city city 
FROM $table_user
LEFT JOIN SOCIAL_city ON SOCIAL_city.id = $table_user.city
WHERE $table_user.id = '$ids'"; // Загрузка
        $sql_edit = "UPDATE $table_user SET lfm = '$lfm' WHERE id = '$ids'"; // Редактирование
        $sql_delete = "UPDATE $table_user SET mydelete = 1 WHERE id = '$ids'"; // Удаление
        switch($action)
        {
          case 2: // Загрузка страницы другого пользователя
            $my_class = new users(2, $sql_list, $ids);
          break;
          case 3: // Загрузка
            $my_class = new users(3, $sql_load);
          break;
          case 4: // Редактирование
            $my_class = new users(4, $sql_edit);
          break;
          case 5: // Удаления
            $my_class = new users(5, $sql_delete);
          break;
        }
      break;
      case 2: // Город
        $sql_add = "INSERT INTO SOCIAL_city(city) VALUES (upper('$city'))"; // Добавление
        $sql_list = "SELECT id, city FROM SOCIAL_city WHERE city = '$city'"; // Список
        $sql_load = "SELECT id, city FROM SOCIAL_city WHERE city = upper('$city')"; // Загрузка
        switch($action)
        {
          case 2: // Список
            $my_class = new city(2, $sql_list);
          break;
          case 3: // Редактирование города, если он не существует, то выполнить добавление в таблицу
            $my_class = new city(3, $sql_load, $sql_add, $ids);
          break;
        }
      break;
      case 3: // Друзья
        $sql_add = "SELECT id FROM SOCIAL_alias WHERE alias = '$alias' and type = 2"; // Выбор идентификатора получателя
        $sql_list = "
SELECT SOCIAL_friends.id, SOCIAL_friends.friend_id, SOCIAL_friends.my_id
FROM SOCIAL_friends
WHERE 
(SOCIAL_friends.friend_id = '$ids' or SOCIAL_friends.my_id = '$ids') and 
(SOCIAL_friends.friend_accept = 1 and SOCIAL_friends.my_accept = 1)"; // Список всех друзей
        $sql_load = "
SELECT id 
FROM SOCIAL_friends 
WHERE (my_id = '$ids' or friend_id = '$ids') and friend_accept = '1' 
LIMIT 6"; // Загрузка на странице пользователя
        $sql_edit = "
UPDATE SOCIAL_friends 
SET friend_accept = '1', friend_date = curdate()
WHERE SOCIAL_friends.friend_id = '$ids' and SOCIAL_friends.id = '$id'"; // Принятие в друзья
        $sql_delete = "
UPDATE SOCIAL_friends 
SET my_accept = '0'
WHERE id = '$id' and my_id = '$ids'"; // Удаление из друзей
        switch($action)
        {
          case 1: // Добавление (ids, alias, mycomments)
            $my_class = new friends(1, $sql_add, $ids);
          break;
          case 2: // Список
            $my_class = new friends(2, $sql_list, $ids);
          break;
          case 3: // Загрузка
            $my_class = new friends(3, $sql_load);
          break;
          case 4: // Редактирование
            $my_class = new friends(4, $sql_edit);
          break;
          case 5: // Удаление
            $my_class = new friends(5, $sql_delete, $ids, $id);
          break;
        }
      break;
      case 4: // Система личных сообщений
        $sql_add = "SELECT id FROM SOCIAL_alias WHERE alias = '$alias' and type = 2"; // Выбор идентификатора получателя
        $sql_list = "
SELECT 
SOCIAL_messages.id, 
SOCIAL_messages.date, 
SOCIAL_user.lfm,
SOCIAL_messages.towhom_open, 
SOCIAL_messages.text_message
FROM SOCIAL_messages, SOCIAL_user
WHERE SOCIAL_messages.from_id = '$ids' and SOCIAL_user.id = SOCIAL_messages.towhom_id
"; // Список исходящих сообщений
        $sql_load = "
SELECT 
SOCIAL_messages.id, 
SOCIAL_messages.date, 
SOCIAL_user.lfm,
SOCIAL_messages.towhom_open, 
SOCIAL_messages.text_message
FROM SOCIAL_messages, SOCIAL_user
WHERE SOCIAL_messages.from_id = '$ids' and SOCIAL_user.id = SOCIAL_messages.towhom_id and SOCIAL_messages.id = '$id'
"; // Загрузка исходящего сообщения
        $sql_delete = "
UPDATE SOCIAL_messages 
SET from_delete = '1'
WHERE SOCIAL_messages.id = '$id' and SOCIAL_messages.from_id = '$ids'"; // Удаление исходящего сообщения
        switch($action)
        {
          case 1:
            $my_class = new messages(1, $sql_add, $message_text, $ids);
          break;
          case 2:
            $my_class = new messages(2, $sql_list, $message_type, $ids);
          break;
          case 3:
            $my_class = new messages(3, $sql_load, $message_type, $ids, $id);
          break;
          case 5:
            $my_class = new messages(5, $sql_delete, $message_type, $ids, $id);
          break;
        }
      break;
      case 5: // Фотографии
        $sql_add = ""; // Добавление
        $sql_list = ""; // Список
        $sql_load = ""; // Загрузка
        $sql_edit = ""; // Редактирование
        $sql_delete = ""; // Удаление
        switch($action)
        {
          case 1: // Добавление
            $my_class = new fotos(1, $sql_add);
          break;
          case 2: // Список
            $my_class = new fotos(2, $sql_list);
          break;
          case 3: // Загрузка
            $my_class = new fotos(3, $sql_load);
          break;
          case 4: // Редактирование
            $my_class = new fotos(4, $sql_load);
          break;
          case 5: // Удаление
            $my_class = new fotos(5, $sql_load);
          break;
        }
      break;
      case 6: // Фотоальбом
        $sql_add = "";
        $sql_list = "";
        $sql_load = "";
        $sql_edit = "";
        $sql_delete = "";
        switch($action)
        {
          case 1: // Добавление
            $my_class = new fotoalbums(1, $sql_add);
          break;
          case 2: // Список
            $my_class = new fotoalbums(2, $sql_list);
          break;
          case 3: // Загрузка
            $my_class = new fotoalbums(3, $sql_load);
          break;
          case 4: // Редактирование
            $my_class = new fotoalbums(4, $sql_edit);
          break;
          case 5: // Удаление
            $my_class = new fotoalbums(5, $sql_delete);
          break;
        }
      break;
// (Стена, Заметки, Комментарии,) Группы, ...
    }
  }
  else
  {
    switch($type)
    {
      case 0:      
        $sql_add = "INSERT INTO SOCIAL_user (login, pass, email) VALUES ('$username', '$password', '$myemail')";
        $sql_list = "SELECT id, login FROM $table_user LIMIT 5";
        $sql_load = "SELECT login, pass FROM $table_user WHERE email = '$myemail'";
        switch($action)
        {
          case 1: // Добавление (Регистрация)
            $my_class = new reguser(1, $sql_add, $password, $password_r, $username, $myemail);
          break;
          case 2: // Список
            $my_class = new reguser(2, $sql_list);
          break;
          case 3: // Загрузка (Восстановление)
            $my_class = new reguser(3, $sql_load, $myemail);
          break;
        }
      break;
    }
  }
?>
