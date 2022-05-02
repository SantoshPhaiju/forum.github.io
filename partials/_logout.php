<?php

echo "Logging you out. Please wait...";

session_start();
session_destroy();

setcookie("logout", "<p style='color: green; text-align: center; margin: 10px 0px;'>You are loggedout!</p>", time() + 3, "/");
setcookie("name", "true", time() - 36400, "/forum");
header('location: /forum/index.php');


?>