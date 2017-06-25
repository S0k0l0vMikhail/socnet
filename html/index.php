<?php
  include "conf_connect.php";
  include "html/header.html";

  include "function/friendly_url.php";

  $razdel = frurl();

//  echo "Значение = $razdel";

  $sql = mysql_query("
SELECT type, id
FROM $table_alias
WHERE alias = '$razdel'
");
  $type = 0;
  $id = 0;

  if (mysql_num_rows($sql)>0)
  {
    $row_sql = mysql_fetch_assoc($sql);
    $type = $row_sql["type"];
    $id = $row_sql["id"];
    if ($type == 2)
      $id = $razdel;

    echo "<div id = \"content\">Идет загрузка...</div>";
  }
  else
  {
    echo "<p>Такой страницы не существует";
  }

  echo "<script language=\"JavaScript\" type=\"text/javascript\">";
  include "scripts/panzin_framework_0.1.js";
  include "scripts/main.js";
  include "scripts/class_reguser.js";
  include "scripts/class_users.js";
  include "scripts/class_friends.js";
  include "scripts/class_messages.js";
  include "scripts/class_fotos.js";
  include "scripts/class_fotoalbums.js";
  echo "window.top.window.this_page($type, \"$id\");";
  echo "</script>";

  

  include "html/footer.html";
?>
