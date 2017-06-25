<?php
  class messages extends main
  {
    public function add_()
    {
      if (empty($this->message_type))
        echo "<p>Текст сообщения не введен";
      else
      {
        $sql = mysql_query($this->sql); // Выбрать идентификатор получателя
        if (mysql_num_rows($sql)>0)
        {
          $row_sql = mysql_fetch_assoc($sql);
          $towhom_id = $row_sql["id"];
          if ($towhom_id == $this->ids)
            echo "<p>Отправлять сообщения самому себе нельзя";
          else
          {
            $ids = $this->ids;
            $text_message = $this->message_type;
            $sql_ins = mysql_query("INSERT INTO SOCIAL_messages(from_id, towhom_id, text_message) VALUES('$ids', '$towhom_id', '$text_message')");
            if ($sql_ins)
              echo "<p>Отправка сообщения успешно выполнена";
            else
              echo "<p>Произошла ошибка при отправке";
          }
        }
        else
          echo "<p>Такого пользователя нет";
      }
    }

    public function list_()
    {
      if ($this->message_type == 0)
      {
        $sql = mysql_query($this->sql); // Исходящие сообщения
        if (mysql_num_rows($sql)>0)
        {
          $row_sql = mysql_fetch_assoc($sql);
          do
          {
            printf("<p>%s %s %s", $row_sql["date"], $row_sql["lfm"], $row_sql["text_message"]);
          }
          while($row_sql = mysql_fetch_assoc($sql));
        }
        else
          echo "<p>Список сообщений пуст";
      }
      else
      {
        $ids = $this->ids;
        $this->sql = "SELECT 
SOCIAL_messages.id, 
SOCIAL_messages.date, 
SOCIAL_user.lfm,
SOCIAL_messages.towhom_open, 
SOCIAL_messages.text_message
FROM SOCIAL_messages, SOCIAL_user
WHERE SOCIAL_messages.towhom_id = '$ids' and SOCIAL_user.id = SOCIAL_messages.from_id";
        $sql = mysql_query($this->sql); // Входящие сообщения
        if (mysql_num_rows($sql)>0)
        {
          $row_sql = mysql_fetch_assoc($sql);
          do
          {
            printf("<p>%s %s %s", $row_sql["date"], $row_sql["lfm"], $row_sql["text_message"]);
          }
          while($row_sql = mysql_fetch_assoc($sql));
        }
        else
          echo "<p>Список сообщений пуст";
      }
    }

    public function load_()
    {
      if ($this->message_type == 0)
      {
        $sql = mysql_query($this->sql); // Загрузка исходящего сообщения
        if (mysql_num_rows($sql)>0)
        {
          $row_sql = mysql_fetch_assoc($sql);
          printf("<p>%s", $row_sql["towhom_id"]);
        }
      }
      else
      {
        $towhom_id = $this->ids;
        $id = $this->id;
        $this->sql = "SELECT 
SOCIAL_messages.id, 
SOCIAL_messages.date, 
SOCIAL_user.lfm,
SOCIAL_messages.towhom_open, 
SOCIAL_messages.text_message
FROM SOCIAL_messages, SOCIAL_user
WHERE SOCIAL_messages.tohom_id = '$towhom_id' and SOCIAL_user.id = SOCIAL_messages.towhom_id and SOCIAL_messages.id = '$id'";
        $sql = mysql_query($this->sql); // Загрузка входящего сообщения
        if (mysql_num_rows($sql)>0)
        {
          $row_sql = mysql_fetch_assoc($sql);
          printf("<p>%s %s", $row_sql["date"], $row_sql["text_message"]);
        }
      }
    }

    public function delete_()
    {
      if ($this->message_type == 0)
      {
        $sql = mysql_query($this->sql); // Удаление исходящего сообщения
        if ($sql)
          printf("<p>Удаление успешно выполнено");
        else
          printf("<p>Ошибка при удалении");
      }
      else
      {
        $towhom_id = $this->sql;
        $id = $this->id;
        $this->sql = "
UPDATE SOCIAL_messages 
SET towhom_delete = '1'
WHERE SOCIAL_messages.id = '$id' and SOCIAL_messages.towhom_id = '$towhom_id'
";
        $sql = mysql_query($this->sql); // Удаление входящего сообщения
        if ($sql)
          printf("<p>Удаление успешно выполнено");
        else
          printf("<p>Ошибка при удалении");
      }
    }

    public function __construct($action, $sql)
    {
      $this->sql = $sql;
      $this->message_type = func_get_arg(2);
      $this->ids = func_get_arg(3);
      $this->id = func_get_arg(4);
      $this->select_action($action);
    }
  }
?>
