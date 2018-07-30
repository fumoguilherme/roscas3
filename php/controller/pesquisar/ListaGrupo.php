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


include_once ("../../dao/pesquisa.php");

$grupo_codigo = $_REQUEST["grupo_codigo"];

if($grupo_codigo==""){
    $grupo_roscas = select("grupo_roscas","grupo_codigo,grupo_nome,grupo_data_inicio,grupo_data_fim","where grupo_estado like 'activo'");
}else{
    $grupo_roscas = select("grupo_roscas","grupo_codigo,grupo_nome,grupo_data_inicio,grupo_data_fim","where md5(grupo_codigo) = '$grupo_codigo' AND grupo_estado like 'activo'");
}

$tamanho = count($grupo_roscas);

$dados = array();

for($i=0; $i < $tamanho; $i++){

    $grupo_codigo = $grupo_roscas[$i]['grupo_codigo'];

    $membrosTotal_roscas = select("membro_grupo", "count(codigo_grupo) as 'total'","where codigo_grupo = '$grupo_codigo'");

    $total = $membrosTotal_roscas[0]['total'];

    if($grupo_roscas){

        $dados[]=  array(
            'grupo_dado'=>$grupo_roscas[$i]['grupo_codigo']." - ".$grupo_roscas[$i]['grupo_nome'],
            'grupo_codigo'=>$grupo_roscas[$i]['grupo_codigo'],
            'grupo_nome'=>$grupo_roscas[$i]['grupo_nome'],
            'grupo_data_inicio'=>$grupo_roscas[$i]['grupo_data_inicio'],
            'grupo_data_fim'=>$grupo_roscas[$i]['grupo_data_fim'],
            'totalmembro'=>$total



        );

    }

}

echo json_encode($dados);