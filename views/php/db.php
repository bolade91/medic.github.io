<?php
  $host = "localhost";
  $user = "root";
  $pass = "teddybravoç&";

  $databaseName = "sample";
  $tableName = "booking_info";

  //--------------------------------------------------------------------------
  // 1) Connect to mysql database
  //--------------------------------------------------------------------------
  $con = mysql_connect($host,$user,$pass);
  $dbs = mysql_select_db($databaseName, $con);
?>