<?php
  //ini_set('display_errors',1);
  //error_reporting(E_ALL);

  $server_con = ''; // Адрес сервера mysql
  $username_con = ''; // Имя пользователя
  $password_con = ''; // Пароль
  $dbname_con = 'socialdb'; // Название базы данных

  $url = $_SERVER["HTTP_HOST"];
  $site1 = 'panzins.ru'; // Адрес сайта без www
  $site2 = 'www.panzins.ru'; // Адрес сайта с www
  if ($url != $site1 and $url != 'localhost' and $url != $site2)
  exit();

  $url_path = $_SERVER["REQUEST_URI"];
  if ($url == $site2)
  {
    header("Location: http://panzins.ru$url_path"); // Переадресация сайта с www на без www
    exit();
  }

  mysql_connect($server_con, $username_con, $password_con) or die("No connection");
  mysql_query('SET NAMES utf8') or die("Set names error");
  mysql_select_db($dbname_con) or die("No database");

  header('Content-Type:text/html; charset=utf-8');
  $table_log = "SOCIAL_log";
  $table_alias = "SOCIAL_alias";
  $table_user = "SOCIAL_user";

  include_once "function/func_prover.php";
  if ($url == 'localhost')
  $folder = "/www/social_net";
  if ($url == $site1 or $url == $site2)
  $folder = "http://panzins.ru";
  include "function/mail_send.php";
?>
