<?php
  //ini_set('display_errors',1);
  //error_reporting(E_ALL);

  $server_con = 'localhost';
  $username_con = 'root';
  $password_con = '';
  $dbname_con = 'socialdb';

  $url = $_SERVER["HTTP_HOST"];
  $site1 = 'site.ru';
  $site2 = 'www.site.ru';
  if ($url != $site1 and $url != 'localhost' and $url != $site2)
  exit();

  $url_path = $_SERVER["REQUEST_URI"];
  if ($url == $site2)
  {
    header("Location: http://site.ru?$url_path");
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
  //$folder = "/www/social_net";
  $folder = "site.ru";
  if ($url == $site1 or $url == $site2)
  $folder = "http://site.ru";
  include "function/mail_send.php";
?>
