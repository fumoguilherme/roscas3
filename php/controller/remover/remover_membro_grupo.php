<?php
/**
 * Created by PhpStorm.
 * User: TechJonas
 * Date: 07/26/2018
 * Time: 11:56
 */

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$membro_id = $_REQUEST["membro_id"];
$grupo_id = $_REQUEST["grupo_id"];

include_once ("../../dao/apagar.php");
include_once ("../../dao/pesquisa.php");

if(isset($membro_id) != null && isset($grupo_id) != null){

$apagar = apagar("membro_grupo","WHERE md5(codigo_grupo) = '$grupo_id' AND codigo_membro = '$membro_id'");

if($apagar){

    $dadosTabela = select("membro_grupo,membro_roscas", "membro_roscas.membro_nome,membro_roscas.membro_codigo", "WHERE md5(codigo_grupo) = '$grupo_id' AND membro_codigo = codigo_membro");

    $membroCount_roscas = count($dadosTabela);

    echo 'nr_inicio';

    echo '<p id="nr_membro" class="hidden" value="'.$membroCount_roscas.'">'.$membroCount_roscas.'</p>';

    echo 'nr_fim';


    echo "membrosinicio";

    if($dadosTabela){
    for ($i = 0; $i < $membroCount_roscas; $i++) {

        $membro_codigo = $dadosTabela[$i]['membro_codigo'];

        $membro_nome = $dadosTabela[$i]['membro_nome'];


        echo '
        
         <tr>
                                    <th scope="row">' . $membro_codigo . '</th>
                                    <td>' . $membro_nome . '</td>
                                     <td><span class="badge bg-blue-grey" onclick="removerMembro(this.id)" id="' . $membro_codigo . '_btremover">Remover</span> </td>

                                </tr>
        
        ';

    }
    }
    echo "membrosfim";

}else{

}

}