<?php
  function frurl()
  {
    $pages_url = $_SERVER["REQUEST_URI"];
    $pages_url = mb_split("/", $pages_url);
    $count_url = -1;
    foreach($pages_url as $value)
    $count_url++;
    $razdel = $pages_url["$count_url"];
    $razdel = prover($razdel);
    return $razdel;
  }
?>
