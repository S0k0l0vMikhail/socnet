<?php
  function prover($con)
  {
    $element = array("'");
    $con = str_replace($element, "\'", $con);
    return $con;
  }
?>
