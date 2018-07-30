<?php
/**
 * Created by PhpStorm.
 * User: TechJonas
 * Date: 07/23/2018
 * Time: 14:39
 */
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
date_default_timezone_set("Africa/Maputo");

include_once ("../../dao/pesquisa.php");

$codigo_usuario = $_SESSION["usuario_codigo"];
$nome_tecnico = $_SESSION["tecnico_nome"];
$email_tecnico = $_SESSION["tecnico_email"];

$dados = array('codigo_usuario'=>$codigo_usuario, 'nome_tecnico' => $nome_tecnico, 'email_tecnico'=>$email_tecnico);

echo json_encode($dados);
