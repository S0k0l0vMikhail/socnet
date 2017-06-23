<?php
  function prover($con)
  {
    $element = array("'");
    $con = str_replace($element, ";appost;", $con);
    return htmlspecialchars(trim($con));
  }
?>
