<?php

if (!defined('URL')) {
    header("Location: /");
    exit();
}
echo "Home <br>";
echo "<a href='".URLADM . "login/logout'> Sair </a><br>";
