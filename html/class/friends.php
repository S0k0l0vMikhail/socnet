<?php
  class friends extends main
  {
    public function add_()
    {
      $sql = mysql_query($this->sql);
      $ids = $this->ids;
      if (mysql_num_rows($sql)>0)
      {
        $row_sql = mysql_fetch_assoc($sql);
        $friend_id = $row_sql["id"];
        if ($friend_id == $ids)
          echo "<p>Самого себя в друзья добавлять нельзя";
        else
        {
          $sql = mysql_query("
SELECT id 
FROM SOCIAL_friends 
WHERE (friend_id = '$friend_id' and my_id = '$ids') or (my_id = '$friend_id' and friend_id = '$ids')"); // Не был ли ранее он добавлен
          if (mysql_num_rows($sql)>0)
            echo "<p>Этот пользователь уже добавлен в друзья";
          else
          {
            $sql = mysql_query("INSERT INTO SOCIAL_friends(my_id, friend_id, mycomments) VALUES('$ids', '$friend_id', 'Этот пользователь хочет добавить вас в друзья')"); // Отправить заявку на добавление
            if ($sql)
              echo "<p>Заявка на добавление в друзья успешно отправлена";
            else
              echo "<p>Возникла ошибка при отправке заявки на добавление в друзья";
          }
        }
      }
      else
        echo "<p>Такого пользователя не существует'";
    }

    public function list_()
    {
      $sql = mysql_query($this->sql);
      $ids = $this->ids;
      if (mysql_num_rows($sql)>0)
      {
        $row_sql = mysql_fetch_assoc($sql);
        echo "<h2>Список друзей</h2>";
        do 
        {
          $friend_id = $row_sql["friend_id"];
          $my_id = $row_sql["my_id"];
          $id = $row_sql["id"];
          if ($my_id != $ids)
            $friend_id = $my_id;

          $sql = mysql_query("
SELECT id, lfm
FROM SOCIAL_user
WHERE id = '$friend_id'
");
          if (mysql_num_rows($sql)>0)
          {
            $row_sql = mysql_fetch_assoc($sql);
            printf("<p>%s <a href=\"#\" onclick=\"cfriends.delete_(%s);\">Удалить</a>", $row_sql["lfm"], $id);
          }
        }
        while($row_sql = mysql_fetch_assoc($sql));
      }

      $sql = mysql_query("SELECT SOCIAL_friends.id, SOCIAL_friends.my_id, SOCIAL_friends.friend_id, SOCIAL_friends.my_accept, SOCIAL_user.lfm
FROM SOCIAL_friends, SOCIAL_user
WHERE friend_id = '$ids' and friend_accept = '0' and my_accept = '1' and SOCIAL_user.id = SOCIAL_friends.my_id"); // Заявки отправленные мне
      if (mysql_num_rows($sql)>0)
      {
        $row_sql = mysql_fetch_assoc($sql);
        echo "<p>Заявки на добавление в друзья:";
        do
        {
          printf("<p>%s <a href=\"#\" onclick=\"cfriends.accept_(%s);\">Принять</a>",  $row_sql["lfm"], $row_sql["id"]);
        }
        while($row_sql = mysql_fetch_assoc($sql));
      }

      $sql = mysql_query("
SELECT SOCIAL_friends.id, SOCIAL_user.lfm
FROM SOCIAL_friends, SOCIAL_user
WHERE 
SOCIAL_friends.my_id = '$ids' and SOCIAL_friends.friend_accept = '0' and SOCIAL_friends.my_accept = '1' 
and SOCIAL_user.id = SOCIAL_friends.friend_id
"); // Заявки отправленные от меня (еще не одобренные)
      if (mysql_num_rows($sql)>0)
      {
        $row_sql = mysql_fetch_assoc($sql);
        echo "<h2>Мои заявки:</h2>";
        do
        {
          printf("<p>%s <a href=\"#\" onclick=\"cfriends.delete_(%s);\">Отменить</a>", $row_sql["lfm"], $row_sql["id"]);
        }
        while($row_sql = mysql_fetch_assoc($sql));
      }

      $sql = mysql_query("
SELECT SOCIAL_friends.my_id, SOCIAL_friends.friend_id
FROM SOCIAL_friends
WHERE (SOCIAL_friends.my_id = '$ids' or SOCIAL_friends.friend_id = '$ids') and (SOCIAL_friends.my_accept = 0 and SOCIAL_friends.friend_accept = 0) and SOCIAL_friends.friend_date != '0000-00-00'
"); // Удаленные друзья

      if (mysql_num_rows($sql)>0)
      {
        $row_sql = mysql_fetch_assoc($sql);
        echo "<h2>Удаленные друзья</h2>";
        do
        {
          $friend_id = $row_sql["friend_id"];
          $my_id = $row_sql["my_id"];
          if ($friend_id == $ids)
            $friend_id = $my_id;
          $sql = mysql_query("
SELECT lfm
FROM SOCIAL_user
WHERE id = '$friend_id'
");
          $row_sql = mysql_fetch_assoc($sql);
          printf("<p>%s", $row_sql["lfm"]);
        }
        while($row_sql = mysql_fetch_assoc($sql));
      }
    }

    public function load_()
    {
      $sql = mysql_query($this->sql);
      if (mysql_num_rows($sql)>0)
      {
        $row_sql = mysql_fetch_assoc($sql);
        echo "<p>Друзья:";
        do 
        {
          $friend_id = $row_sql["friend_id"];
          $my_id = $row_sql["my_id"];
          printf("<p>%s %s", $row_sql["friend_id"], $row_sql["my_id"]);
        }
        while($row_sql = mysql_fetch_assoc($sql));
      }
    }

    public function delete_()
    {
      $id = $this->id;
      $ids = $this->ids;
      $sql = mysql_query("SELECT my_id FROM SOCIAL_friends WHERE id = '$id'"); // Узнаем сначала кто-кого добавил?
      if (mysql_num_rows($sql)>0)
      {
        $row_sql = mysql_fetch_assoc($sql);
        $my_id = $row_sql["my_id"];
        if ($ids != $my_id)
        {
// Если инициатором на добавление в друзья были не вы
          $this->sql = "
UPDATE SOCIAL_friends 
SET friend_accept = '0'
WHERE id = '$id' and friend_id = '$ids'";
        }
        $sql = mysql_query($this->sql);
        if ($sql)
          echo "<p>Удаление успешно выполнено";
        else
          echo "<p>Ошибка при удалении";
      }
    }

    public function __construct($action, $sql)
    {
      $this->sql = $sql;
      $this->ids = func_get_arg(2);
      $this->id = func_get_arg(3);
      $this->select_action($action);
    }
  }

?>
