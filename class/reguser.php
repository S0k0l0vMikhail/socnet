<?php
  class reguser extends main
  {
    public function list_()
    {
    }

    public function __construct($action, $sql)
    {
      $this->sql = $sql;
      $password = func_get_arg(2);
      $password_r = func_get_arg(3);
      $username = func_get_arg(4);
      $myemail = func_get_arg(5);

      if ($action == 1)
      {
        if ($password != $password_r || mb_strlen($password)<6 || mb_strlen($password_r)>30)
          exit("'1'");
        else
        {
          $sql_check = mysql_query("SELECT id FROM SOCIAL_user WHERE login = '$username' or email = '$myemail'");
          if (mysql_num_rows($sql_check)>0)
            exit("'4'");
          else
          {
            if (empty($username) || mb_strlen($username)<6 || mb_strlen($username)>30)
              exit("'2'");
            else
            {
              if (empty($myemail) || mb_strlen($myemail)<9 || mb_strlen($myemail)>30)
                exit("'3'");
            }
          }
        }

        $key = "$myemail-ksghrgiukvberubreiojuiohgs";
        $key = md5($key);
        $message = "
\n
Уважаемый $username ваш e-mail был указан при регистрации на сайте http://panzins.ru\n
Для активации учетной записи скопируйте ссылку и перейдите по ней http://panzins.ru/activated.php?key=$key\n
Ссылка действительна в течении 24 часов, если учетная запись не будет активирована, то она будет удалена\n
С уважением, администрация сайта http://panzins.ru
\n
";
        mail_send($myemail, "Подтверждение регистрации пользователя", $message);
      }

      $this->select_action($action);
    }
  }

?>
