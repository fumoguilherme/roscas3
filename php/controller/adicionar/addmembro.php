<?php
/**
 * Created by PhpStorm.
 * User: kleyton.marcos
 * Date: 7/21/2017
 * Time: 12:13
 */

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

include_once ("../../dao/adicionar.php");
include_once ("../../dao/apagar.php");
include("../../controller/other/chaves.php");


$usuario_codigo = chave("usuario_roscas","USR","USR","usuario_codigo");

$membro_codigo = chave("membro_roscas","CCOM","CCOM","membro_codigo");
$membro_sexo = $_REQUEST["membro_sexo"];
$membro_nome = $_REQUEST["membro_nome"];
$actividade_codigo = $_REQUEST["membro_actividade"];
$membro_contacto = $_REQUEST["membro_contacto"];

$endereco_codigo = chave("endereco_roscas","END","END","endereco_codigo");
$membro_endereco = $_REQUEST["membro_endereco"];

$herdeiro_codigo =  chave("herdeiro_roscas","HER","HER","herdeiro_codigo");
$membro_herdeiro = $_REQUEST["membro_herdeiro"];
$membro_grau = $_REQUEST["herdeiro_grau_parent"];

$documento_codigo =  chave("documento_roscas","DOC","DOC","documento_codigo");
$tipo_codigo_documento = $_REQUEST["tipo_codigo_documento"];
$documento_numero = $_REQUEST["documento_numero"];

$usuario_data_criacao = date("Y/m/d H:i:s");
//$membro_estado = "activo";

$senha = md5($membro_contacto);

$insp = 0;

$users = select("usuario_roscas", "usuario_contacto", "WHERE usuario_contacto='$membro_contacto'");

for ($i=0; $i < count($users);$i++){

    if($users[$i]['usuario_contacto'] === $membro_contacto){

        $insp = 1;
    }

}

$codigo_tecnico = $_SESSION["tecnico_codigo"];
if ($codigo_tecnico!="") {

    if (!$users) {

        $adicionarUser = adicionar(array("usuario_codigo", "usuario_nome", "usuario_contacto", "usuario_senha", "usuario_data_criacao"),
            array($usuario_codigo, $membro_nome, $membro_contacto, $senha, $usuario_data_criacao), "usuario_roscas");

        if ($adicionarUser) {

            $adicionarContacto = adicionar(array("codigo_usuario", "contacto_numero"),
                array($usuario_codigo, $membro_contacto), "contacto_roscas");
            if ($adicionarContacto) {

                $adicionarEndereco = adicionar(array("endereco_codigo", "endereco_avenida"),
                    array($endereco_codigo, $membro_endereco), "endereco_roscas");

                if ($adicionarEndereco) {

                    $adicionarDocumento = adicionar(array("documento_codigo", "documento_numero", "codigo_tipo"),
                        array($documento_codigo, $documento_numero, $tipo_codigo_documento), "documento_roscas");

                    if ($adicionarDocumento) {

                        $adicionarHerdeiro = adicionar(array("herdeiro_codigo", "herdeiro_nome", "herdeiro_grau_parent"),
                            array($herdeiro_codigo, $membro_herdeiro, $membro_grau), "herdeiro_roscas");
                        if ($adicionarHerdeiro) {

                            $adicionarMembro = adicionar(array("membro_codigo", "membro_nome", "actividade_codigo", "membro_sexo",
                                "codigo_herdeiro", "codigo_endereco", "codigo_documento", "codigo_tecnico", "codigo_usuario", "membro_data_criacao"),
                                array($membro_codigo, $membro_nome, $actividade_codigo, $membro_sexo, $herdeiro_codigo, $endereco_codigo, $documento_codigo,$codigo_tecnico, $usuario_codigo, $usuario_data_criacao), "membro_roscas");
                            if ($adicionarMembro) {

                                $mensagem = array(

                                    'estado' => 'sucesso',
                                    'membro_codigo' => $membro_codigo,
                                    'membro_nome' => $membro_nome,
                                    'tipo' => 'add'
                                );

                                echo json_encode($mensagem);


                            } else {
                                apagar("herdeiro_roscas", "WHERE herdeiro_codigo = '$herdeiro_codigo'");
                                apagar("documento_roscas", "WHERE documento_codigo = '$documento_codigo'");
                                apagar("endereco_roscas", "WHERE endereco_codigo = '$endereco_codigo'");
                                apagar("contacto_roscas", "WHERE contacto_numero = '$membro_contacto'");
                                apagar("usuario_roscas", "WHERE usuario_codigo = '$usuario_codigo'");
                                $mensagem = array(

                                    'estado' => 'erro',
                                    'tipo' => 'addmembro'
                                );

                                echo json_encode($mensagem);

                            }
                        } else {
                            apagar("documento_roscas", "WHERE documento_codigo = '$documento_codigo'");
                            apagar("endereco_roscas", "WHERE endereco_codigo = '$endereco_codigo'");
                            apagar("contacto_roscas", "WHERE contacto_numero = '$membro_contacto'");
                            apagar("usuario_roscas", "WHERE usuario_codigo = '$usuario_codigo'");

                            $mensagem = array(

                                'estado' => 'erro',
                                'tipo' => 'addherdeiro'
                            );

                            echo json_encode($mensagem);
                        }
                    } else {
                        apagar("endereco_roscas", "WHERE endereco_codigo = '$endereco_codigo'");
                        apagar("contacto_roscas", "WHERE contacto_numero = '$membro_contacto'");
                        apagar("usuario_roscas", "WHERE usuario_codigo = '$usuario_codigo'");

                        $mensagem = array(

                            'estado' => 'erro',
                            'tipo' => 'adddocumento'
                        );

                        echo json_encode($mensagem);
                    }
                } else {
                    apagar("contacto_roscas", "WHERE contacto_numero = '$membro_contacto'");
                    apagar("usuario_roscas", "WHERE usuario_codigo = '$usuario_codigo'");

                    $mensagem = array(

                        'estado' => 'erro',
                        'tipo' => 'addendereco'
                    );

                    echo json_encode($mensagem);

                }
            } else {
                apagar("usuario_roscas", "WHERE usuario_codigo = '$usuario_codigo'");
                $mensagem = array(

                    'estado' => 'erro',
                    'tipo' => 'addcontacto'
                );

                echo json_encode($mensagem);
            }
        } else {
            $mensagem = array(

                'estado' => 'erro',
                'tipo' => 'adduser'
            );

            echo json_encode($mensagem);
        }
    } else {
        $mensagem = array(

            'estado' => 'existe'

        );

        echo json_encode($mensagem);
    }
}else{
        $mensagem = array(

            'estado'=>'login'

        );

        echo json_encode($mensagem);
    }
