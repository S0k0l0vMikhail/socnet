<?php
  include_once "login.php";

  $type = prover ($_POST["type"]); //регистрация, фото, друзья, сообщения, группы
  $action = prover ($_POST["myemail"]); // 1 добавлене, 2 список, 3 загрука, 4 редактирование, 5 удаление ...

  $id = prover($_POST["id"]);
  $myemail = prover($_POST["myemail"]);

  include "class/main_class.php";
  include "class/reguser.php"; //регистрация
  include "class/users.php"; //пользователи
  include "class/friends.php"; //друзья
  include "class/fotos.php"; //фото
  include "class/fotoalbums.php"; //фотоальбомы

  if ($status == 0)
  {
    //пользователь вошёл на сайт
    switch ($type)
    {
      case 1: // пользователь
      $sql_load = ""; // загрузка
      $sql_edit = ""; // редактирование
      $sql_delete = ""; // удаление
        switch ($action)
        {
          case 3: // загрузка
            $my_class = new users (3, $sql_load);
            break;
          case 4: // редактирование
            $my_class = new users (4, $sql_edit);
            break;
          case 5: // удаление
            $my_class = new users (5, $sql_delete);
            break;
        }
      break;
      case 2: // друзья
      $sql_add = ""; //добаление
      $sql_list = ""; //список
      $sql_load = ""; // загрузка
      $sql_edit = ""; // редактирование
      $sql_delete = ""; // удаление
        switch ($action)
        {
          case 1: // добавление
            $my_class = new friends (1, $sql_add);
            break;
          case 2: // список
            $my_class = new friends (2, $sql_list);
            break;
          case 3: // загрузка
            $my_class = new friends (3, $sql_load);
            break;
          case 4: // редактирование
            $my_class = new friends (4, $sql_edit);
            break;
          case 5: // удаление
            $my_class = new friends (5, $sql_delete);
            break;
        }
      break;
      case 3: // фото
      $sql_add = ""; //добаление
      $sql_list = ""; //список
      $sql_load = ""; // загрузка
      $sql_edit = ""; // редактирование
      $sql_delete = ""; // удаление
        switch ($action)
        {
          case 1: // добавление
            $my_class = new fotos (1, $sql_add);
            break;
          case 2: // список
            $my_class = new fotos (2, $sql_list);
            break;
          case 3: // загрузка
            $my_class = new fotos (3, $sql_load);
            break;
          case 4: // редактирование
            $my_class = new fotos (4, $sql_edit);
            break;
          case 5: // удаление
            $my_class = new fotos (5, $sql_delete);
            break;
        }
      break;
      case 4: // фотоальбом
      $sql_add = ""; //добаление
      $sql_list = ""; //список
      $sql_load = ""; // загрузка
      $sql_edit = ""; // редактирование
      $sql_delete = ""; // удаление
        switch ($action)
        {
          case 1: // добавление
            $my_class = new fotoalbums (1, $sql_add);
            break;
          case 2: // список
            $my_class = new fotoalbums (2, $sql_list);
            break;
          case 3: // загрузка
            $my_class = new fotoalbums (3, $sql_load);
            break;
          case 4: // редактирование
            $my_class = new fotoalbums (4, $sql_edit);
            break;
          case 5: // удаление
            $my_class = new fotoalbums (5, $sql_delete);
            break;
          }
        break;
  //стена, заметки, комментарии,группы, ...
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
