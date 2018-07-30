<?php
/**
 * Created by PhpStorm.
 * User: TechJonas
 * Date: 07/24/2018
 * Time: 16:45
 */


date_default_timezone_set("Africa/Maputo");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

include_once ("../../dao/pesquisa.php");

$token = $_REQUEST["token"];

$grupo_taxaFS = select("grupo_taxa,taxa_roscas","*","WHERE codigo_taxa = 'TC001' AND codigo_taxa = taxa_codigo AND md5(codigo_grupo) = '$token'");

$grupo_taxaAT = select("grupo_taxa,taxa_roscas","*","WHERE codigo_taxa = 'TC002' AND codigo_taxa = taxa_codigo AND md5(codigo_grupo) = '$token'");


$dados = select("grupo_roscas","grupo_nome","WHERE md5(grupo_codigo) = '$token'");


$status = array(

    'grupo_nome' => $dados[0]["grupo_nome"],
    'taxa_valorFS' => $grupo_taxaFS[0]['taxa_valor'],
    'taxa_valorAT' => $grupo_taxaAT[0]['taxa_valor']
);

echo json_encode($status);



