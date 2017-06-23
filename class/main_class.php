<?php
  class main{
    public $sql;
    public function add_(){

      $sql_ins = mysql_query($this->sql);
      if ($sql_ins)
        echo "<p>Добавление успешно выполнено";
      else
        echo "<p>Возникла ошибка при добавлении";
    }
    public function save_(){

      $sql_ins = mysql_query($this->sql);
      if ($sql_ins)
        echo "<p>Сохранение успешно выполнено";
      else
        echo "<p>Возникла ошибка при сохранении";
    }
    public function delete_(){

      $sql_ins = mysql_query($this->sql);
      if ($sql_ins)
        echo "<p>Удаление успешно выполнено";
      else
        echo "<p>Возникла ошибка при удалении";
    }

    
  }
?>
