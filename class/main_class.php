<?php
  class main
  {
    public $sql;
    public function add_()
	{
      $sql_ins = mysql_query($this->sql);
      if ($sql_ins)
        echo "<p>Добавление успешно выполнено";
      else
        echo "<p>Возникла ошибка при добавлении";
    }
	
    public function save_(){

      $sql_upd = mysql_query($this->sql);
      if ($sql_upd)
        echo "<p>Сохранение успешно выполнено";
      else
        echo "<p>Возникла ошибка при сохранении";
    }
    public function delete_(){

      $sql_delete = mysql_query($this->sql);
      if ($sql_delete)
        echo "<p>Удаление успешно выполнено";
      else
        echo "<p>Возникла ошибка при удалении";
    }

    public function select_action($action)
    {
      switch($action)
      {
        case 1:
          $this->add_();
        break;
        case 2:
          $this->list_();
        break;
        case 3:
          $this->load_();
        break;
        case 4:
          $this->save_();
        break;
        case 5:
          $this->delete_();
        break;
      }
    }


  }
?>
