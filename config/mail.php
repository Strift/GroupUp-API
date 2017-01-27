<?php

return array(
  "driver" => "smtp",
  "host" => "mailtrap.io",
  "port" => 2525,
  "from" => array(
      "address" => "from@example.com",
      "name" => "Example"
  ),
  "username" => "b2a4b7d84f7e31",
  "password" => "24c270ece9310d",
  "sendmail" => "/usr/sbin/sendmail -bs",
  "pretend" => false
);