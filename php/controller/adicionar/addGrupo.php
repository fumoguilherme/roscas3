<?php
/**
 * Created by PhpStorm.
 * User: TechJonas
 * Date: 07/23/2018
 * Time: 15:09
 */

date_default_timezone_set("Africa/Maputo");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

include_once ("../../dao/adicionar.php");
include_once ("../../dao/pesquisa.php");
include_once ("../../dao/apagar.php");
include("../../controller/other/chaves.php");

$usuario_codigo = chave("usuario_roscas","USR","USR","usuario_codigo");

$nome_grupo = $_REQUEST["nome_grupo"];
$data_fim = $_REQUEST["data_fim"];
$periodicidade = $_REQUEST["periodicidade"];
$taxa_fs = $_REQUEST["taxa_fs"];
$taxa_at = $_REQUEST["taxa_at"];

if(isset($_REQUEST["nome_grupo"])){
   addGrupo($nome_grupo,$data_fim, $taxa_fs, $taxa_at);
}else{
    novaData($data_fim);
}

function addGrupo($nome_grupo, $data_fim, $taxa_fs, $taxa_at)
{

    $grp_id = chave("grupo_roscas", "GRP", "GRP", "grupo_codigo");

    $data_inicio = date_create()->format("Y-m-d H:i:s");

    $codigo_tecnico = $_SESSION["tecnico_codigo"];

    $fs_id = select("taxa_roscas", "taxa_codigo", "WHERE taxa_descricao LIKE 'FS'");
    $at_id = select("taxa_roscas", "taxa_codigo", "WHERE taxa_descricao LIKE 'AT'");

    $addGrupo = adicionar(array("grupo_codigo", "grupo_nome", "grupo_data_inicio", "grupo_data_fim", "grupo_data_criacao","grupo_estado", "codigo_periodo", "codigo_tecnico"),
        array($grp_id, $nome_grupo, $data_inicio, $data_fim, $data_inicio,'pendente', '1', $codigo_tecnico), "grupo_roscas");


    if ($addGrupo) {


        $addTaxaAT = adicionar(array("codigo_grupo", "codigo_taxa", "taxa_valor"),
            array($grp_id, $at_id[0]["taxa_codigo"], $taxa_at),
            "grupo_taxa"
        );

        $addTaxaFS = adicionar(array("codigo_grupo", "codigo_taxa", "taxa_valor"),
            array($grp_id, $fs_id[0]["taxa_codigo"], $taxa_fs),
            "grupo_taxa"
        );

        if ($addTaxaFS && $addTaxaAT) {

            $status = array(
                'estado' => 'sucesso',
                'grupo' => md5($grp_id)
            );

            echo json_encode($status);
        } else {

            apagar("grupo_roscas", "WHERE grupo_codigo = '$grp_id'");

            $status = array(
                'estado' => 'erro'
            );

            echo json_encode($status);
        }


    } else {
        $status = array(
            'estado' => 'erro'
        );

        echo json_encode($status);
    }
}


function novaData($data){

    $data_actual = date_create()->format("Y-m-d");

    $nova_data = date('Y-m-d', strtotime('+6 month', strtotime($data_actual)));

    $d1 = strtotime($data_actual);
    $d2 = strtotime($data);
    $min_date = min($d1, $d2);
    $max_date = max($d1, $d2);
    $i = 0;

    while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
        $i++;
    }

    if($nova_data > $data){
        $mensagem = array(
            'estado'=>'erro',
            'meses'=> $i
            );

        echo json_encode($mensagem);
    }else{
        $mensagem = array(
            'estado'=>'sucesso',
            'meses'=> $i
        );

        echo json_encode($mensagem);
    }


}

