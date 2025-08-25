<?php

/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/

// Variáveis de acesso (Use variáveis de ambiente se possível)
$host = "bd_vipp.mysql.dbaas.com.br";
$userdb   = "bd_vipp";
$pass   = "P@55#devmysql";
$dbname = "bd_vipp";
$port   = "3306";

$conec_web = mysqli_connect("$host", "$userdb", "$pass", "$dbname", $port);

?>
