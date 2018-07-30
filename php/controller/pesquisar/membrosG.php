<?php
/**
 * Created by PhpStorm.
 * User: TechJonas
 * Date: 07/25/2018
 * Time: 10:36
 */

date_default_timezone_set("Africa/Maputo");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

//$grupo_codigo = "GRP56785";
$grupo_codigo = $_REQUEST["grupo_codigo"];

include_once ("../../dao/pesquisa.php");

$membros = select("membro_roscas","membro_codigo,membro_nome");

$tamanho = count($membros);

$dados = array();

for($i=0; $i < $tamanho; $i++){

    $membro_id = $membros[$i]["membro_codigo"];

    $membro_grupo = select("membro_grupo","*","WHERE codigo_membro = '$membro_id' AND md5(codigo_grupo) = '$grupo_codigo'");

    if($membro_grupo){

        $dados[]=  array(
            'membro_dado'=>$membros[$i]['membro_codigo']." - ".$membros[$i]['membro_nome'],
            'membro_codigo'=>$membros[$i]['membro_codigo'],
            'membro_nome'=>$membros[$i]['membro_nome']


        );

    }

}

echo json_encode($dados);