<?php
session_start();
ob_start();

define('URL', 'http://localhost/site/');
define('URLADM', 'http://localhost/site/adm/');

define('CONTROLER', 'Home');
define('METODO', 'index');

//Credenciais de acesso ao BD
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'danilo');
