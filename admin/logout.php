<?php


session_start();

session_unset();
session_destroy();
setcookie("name", "true", time() - 36400, "/forum");


header("location: index.php");
exit;

?>