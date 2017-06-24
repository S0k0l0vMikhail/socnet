<?php
  include "conf_connect.php";

  if ((isset($_POST["login"])) & (isset($_POST["pass"])))
  {
    $login = prover($_POST["login"]);
    $sql_login = mysql_query("SELECT id, pass, login, activated, email FROM $table_user WHERE login='$login' ");
    if (mysql_num_rows($sql_login)>0)
    {
      $userinfo = mysql_fetch_assoc($sql_login);
      $pass = prover($_POST["pass"]);
      $activated = $userinfo["activated"];
      $login = $userinfo["login"];
      $email = $userinfo["email"];
      if (strcmp($pass, $userinfo["pass"]) == 0)
      {
        $ids = $userinfo["id"];
        $status = 0;
        echo "0'";
      }
      else
      {
        $status = 2;
        echo "2'";
      }
    }
    else
    {
      $status = 3; //когда в базе нет совпадений по логину, и запрос возвращает ноль
      echo "3'"; // передаёт в массив res_login
    }
  }
  else
  {
    $status = 1; // когда $_POST["login"] & $_POST["pass"] пусты
    echo "1'";
  }

?>
