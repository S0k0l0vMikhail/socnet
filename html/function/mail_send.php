<?php

  function mail_send($komu, $subject, $message)
  {
    $headers = "Content-type: text/plain; charset=\"utf-8\"\r\n" . "From: noreply@panzins.ru" . "\r\n" .
    "Reply-To: admin@panzins.ru" . "\r\n" .
    "X-Mailer: PHP/" . phpversion();

    mail($komu, $subject, $message, $headers);

    mail_notification($message);
  }

  function mail_notification($message)
  {
    $headers = "Content-type: text/plain; charset=\"utf-8\"\r\n" . "From: noreply@panzins.ru" . "\r\n" .
    "Reply-To: admin@panzins.ru" . "\r\n" .
    "X-Mailer: PHP/" . phpversion();
    mail("admin@panzins.ru", "mail_notification", $message, $headers);
  }

?>
