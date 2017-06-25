<?php
  class city extends main
  {
    public function list_()
    {
      echo "<p>Функция лист вызвана";
    }

    public function load_()
    {
      $sql = mysql_query($this->sql);
      if (mysql_num_rows($sql)>0)
      {
        // Такой город есть
        $row_sql = mysql_fetch_assoc($sql);
        $id_city = $row_sql["id"];
      }
      else
      {
        // Такого города нет
        $this->sql = $this->sql_add;
        $this->add_();
        $id_city = $this->id_ins;
      }
      $ids = $this->ids;
      $this->sql = "UPDATE SOCIAL_user SET city = '$id_city' WHERE id = '$ids'";
      $this->save_();
    }

    public function __construct($action, $sql)
    {
      $this->sql = $sql;
      $this->sql_add = func_get_arg(2);
      $this->ids = func_get_arg(3);
      $this->select_action($action);
    }
  }
?>
