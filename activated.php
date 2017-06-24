<?php
  include "conf_connect.php";

  if (isset($_GET["key"]))
    $key = prover($_GET["key"]);

  $sql = mysql_query("
SELECT id, email
FROM $table_user
WHERE activated = 0
");

  if (mysql_num_rows($sql)>0)
  {
    $row_sql = mysql_fetch_assoc($sql);
    do
    {
      $id = $row_sql["id"];
      $email = $row_sql["email"];
      $mykey = md5("$email-ksghrgiuk");
      if ($mykey == $key)
      {
        $sql_upd = mysql_query("UPDATE $table_user SET activated = 1 WHERE id = '$id'");
        if ($sql_upd)
          echo "<p>Активация успешно выполнена";
      }
    }
    while($row_sql = mysql_fetch_assoc($sql));
  }

?>
