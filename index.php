<?php
  include "conf_connect.php";
  include  "html/header.html";
  include "function/friendly_url.php";

  $razdel = frurl();
  //$razdel = reguser;
  $g = $_SERVER["REQUEST_URI"];

  echo "$razdel";

  $sql = mysql_query ("SELECT type, id FROM $table_alias WHERE alias = '$razdel'");

  $type = 0;
  $id = 0;

  if (mysql_num_rows ($sql)> 0) {
    $row_sql = mysql_fetch_assoc($sql);
    $type = $row_sql["type"];
    $id = $row_sql["id"];
    echo "<div id=\"content\">Идёт загрузка...</div>";
  }
    else {
      echo "<p>Такого раздела нет";
    }

  echo "<script language=\"JavaScript\" type=\"text/javascript\">";
  include "scripts/scripts.js";
  include "scripts/main.js";
  echo "window.top.window.this_page($type, $id);";
  //include "script/class_user.js";
  echo "</script>";


  include  "html/footer.html";
?>
