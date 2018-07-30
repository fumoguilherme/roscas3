<?php
/**
 * Created by PhpStorm.
 * User: kleyton.marcos
 * Date: 7/21/2017
 * Time: 12:13
 */

include_once ("../../dao/adicionar.php");
include_once ("../../dao/apagar.php");
include("../../controller/other/chaves.php");
include_once ("../../dao/pesquisa.php");

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$token = $_REQUEST["token"];

$membro_codigo = $_REQUEST["membro_codigo"];

$membro_FS = $_REQUEST["membro_FS"];

$membro_AT = $_REQUEST["membro_AT"];

$membro_Poup = $_REQUEST["membro_Poup"];

$membro_presenca = $_REQUEST["membro_presenca"];

$contribuicao_data = date("Y/m/d H:i:s");

$membro_grupo = select("membro_roscas,membro_grupo","*","WHERE membro_codigo = codigo_membro AND 

codigo_membro = '$membro_codigo' AND md5(codigo_grupo) = '$token'");


$grupo_taxaFS = select("grupo_taxa,taxa_roscas","*","WHERE codigo_taxa = 'TC001' AND codigo_taxa = taxa_codigo AND md5(codigo_grupo) = '$token'");

$grupo_taxaAT = select("grupo_taxa,taxa_roscas","*","WHERE codigo_taxa = 'TC002' AND codigo_taxa = taxa_codigo AND md5(codigo_grupo) = '$token'");

$codigo_tecnico = $_SESSION["tecnico_codigo"];


if ($codigo_tecnico!="") {

        if ($token!="" && $membro_codigo!="") {

            if ($membro_grupo) {

                $addcontribuicao = adicionar(array("codigo_membro", "codigo_grupo","contribuicao_presenca","contribuicao_valor", "contribuicao_data"),
                    array($membro_codigo, $membro_grupo[0]["codigo_grupo"],$membro_presenca, $membro_Poup, $contribuicao_data), "contribuicao_roscas");
                if($addcontribuicao){


                    if ($grupo_taxaFS) {
                        $addmembropagamentotaxaFS = adicionar(array("codigo_membro","codigo_grupo","codigo_taxa", "pagamento_data"),
                            array($membro_codigo, $membro_grupo[0]["codigo_grupo"],'TC001', $contribuicao_data), "membro_pagamento_taxa");
                    }

                    if ($grupo_taxaAT) {
                        $addmembropagamentotaxaAT = adicionar(array("codigo_membro","codigo_grupo","codigo_taxa", "pagamento_data"),
                            array($membro_codigo, $membro_grupo[0]["codigo_grupo"],'TC002', $contribuicao_data), "membro_pagamento_taxa");
                    }


                    if($addmembropagamentotaxaAT && $addmembropagamentotaxaFS){

                        $mensagem = array(

                            'estado' => 'sucesso',
                            'membro_nome' => $membro_grupo[0]['membro_nome'],
                            'membro_Poup' => $membro_Poup,
                            'membro_FS' => $membro_FS,
                            'membro_AT' => $membro_AT,
                            'contribuicao_data' => $contribuicao_data,
                            'tipo' => 'add'
                        );

                        echo json_encode($mensagem);
                    }else {

                        $mensagem = array(

                            'estado' => 'erro',
                            'tipo' => 'Tax'

                        );
                    }
                }


            }
            else {

                $mensagem = array(
                    'estado' => 'erro',
                    'tipo' => 'naoexistenogrupo'

                );

                echo json_encode($membro_grupo);

            }

        }else{
            $mensagem = array(
                'estado' => 'erro',
                'tipo'=>'selecaoMembroOuGrupo'

            );
            echo json_encode($mensagem);
        }
}else{
    $mensagem = array(

        'estado'=>'login'

    );
    echo json_encode($mensagem);
}
