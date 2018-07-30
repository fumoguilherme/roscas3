<?php
/**
 * Created by PhpStorm.
 * User: guilherme.fumo
 * Date: 1/31/2018
 * Time: 4:47 PM
 */

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

    // Start session
    session_start();

if (isset($_SESSION["id_usu"])) {

    echo $_SESSION["id_usu"]."/";
    echo $_SESSION["nome_usu"]."/";
    echo $_SESSION["apelido_usu"]."/";
    echo $_SESSION["email_usu"]."/";
    echo $_SESSION["telefone_usu"]."/";
}else{
    echo "notlogin/";
}





