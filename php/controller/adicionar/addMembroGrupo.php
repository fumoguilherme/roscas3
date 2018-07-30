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

$membro_codigo = $_REQUEST["membro_id"];
$grupo_codigo = $_REQUEST["grupo_id"];
$codigo_tecnico = $_SESSION["tecnico_codigo"];
$data_inicio = date_create()->format("Y-m-d H:i:s");


$grupo = select("grupo_roscas","grupo_codigo","WHERE md5(grupo_codigo) = '$grupo_codigo'");

if($grupo) {

    $addMembroGrupo = adicionar(array("codigo_membro", "codigo_grupo", "codigo_tecnico", "membro_data_alocacao"),
        array($membro_codigo, $grupo[0]["grupo_codigo"], $codigo_tecnico, $data_inicio), "membro_grupo");

    if ($addMembroGrupo) {

        $dadosTabela = select("membro_grupo,membro_roscas", "membro_roscas.membro_nome,membro_roscas.membro_codigo", "WHERE md5(codigo_grupo) = '$grupo_codigo' AND membro_codigo = codigo_membro");

        $membroCount_roscas = count($dadosTabela);

        echo 'nr_inicio';

        echo '<p id="nr_membro" class="hidden" value="'.$membroCount_roscas.'">'.$membroCount_roscas.'</p>';

        echo 'nr_fim';


        echo "membrosinicio";


        for ($i = 0; $i < $membroCount_roscas; $i++) {

            $membro_codigo = $dadosTabela[$i]['membro_codigo'];

            $membro_nome = $dadosTabela[$i]['membro_nome'];


            echo '
        
         <tr>
                                    <th scope="row">' . $membro_codigo . '</th>
                                    <td>' . $membro_nome . '</td>
                                     <td><span class="badge bg-blue-grey" onclick="removerMembro(this.id)"  id="' . $membro_codigo . '_btremover">Remover</span> </td>

                                </tr>
        
        ';

        }

        echo "membrosfim";

    } else {
        $status = array(
            'estado' => 'erro'
        );

        echo json_encode($status);
    }
}else{
    $status = array(
        'estado' => 'erro'
    );

    echo json_encode($status);
}




