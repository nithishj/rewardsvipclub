<?php
$con=mysql_connect("localhost","vipuser","password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
//  echo "failed";
  }
mysql_select_db("vip", $con);
?>