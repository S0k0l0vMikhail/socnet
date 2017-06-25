<?php
  class users extends main
  {
    public function list_() // Вывод страницы другого пользователя
    {
      $sql = mysql_query($this->sql);
      if (mysql_num_rows($sql)>0)
      {
        $row_load = mysql_fetch_assoc($sql);
        $id_user = $row_load["id"];
        if ($id_user == $this->ids)
          printf("1'");
        else
          printf("0'");
        printf("%s'%s'", $row_load["lfm"], $row_load["city"]);
      }
    }

    public function load_()
    {
      $sql_load = mysql_query($this->sql);
      if (mysql_num_rows($sql_load)>0)
      {
        $row_load = mysql_fetch_assoc($sql_load);
        printf("%s'%s'", $row_load["lfm"], $row_load["city"]);
      }
    }

    public function __construct($action, $sql)
    {
      $this->sql = $sql;
      $this->ids = func_get_arg(2);
      $this->select_action($action);
    }
  }

?>
