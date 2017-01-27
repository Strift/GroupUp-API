<?php

return array(
  "driver" => "smtp",
  "host" => "mailtrap.io",
  "port" => 2525,
  "from" => array(
      "address" => "noreply@group-up.com",
      "name" => "Group Up"
  ),
  "username" => "b2a4b7d84f7e31",
  "password" => "24c270ece9310d",
  "sendmail" => "/usr/sbin/sendmail -bs",
  "pretend" => false
);