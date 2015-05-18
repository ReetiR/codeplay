<?php

$mysqli = new mysqli(server,username,password,db);
if (mysqli_connect_errno())
{
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>
