<?php
/**
 * Created by PhpStorm.
 * User: guilherme.fumo
 * Date: 7/25/2018
 * Time: 10:18 AM
 */
/**
 * Created by PhpStorm.
 * User: TechJonas
 * Date: 07/23/2018
 * Time: 14:39
 */

date_default_timezone_set("Africa/Maputo");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

include_once ("../../dao/pesquisa.php");

$codigo_usuario = $_SESSION["usuario_codigo"];
$nome_tecnico = $_SESSION["tecnico_nome"];
$email_tecnico = $_SESSION["tecnico_email"];


$grupo_codigo = $_REQUEST["grupo_codigo"];

if($grupo_codigo==""){
    $grupo_roscas = select("grupo_roscas","grupo_codigo,grupo_nome","where grupo_estado like 'activo'");
}else{
    $grupo_roscas = select("grupo_roscas","grupo_codigo,grupo_nome","where grupo_codigo = '$grupo_codigo' AND grupo_estado like 'activo'");
}

if($grupo_roscas) {

    $grupoCount_roscas = count($grupo_roscas);

    for ($i = 0; $i < $grupoCount_roscas; $i++) {

        $grupo_codigo = $grupo_roscas[$i]['grupo_codigo'];

        $grupo_nome = $grupo_roscas[$i]['grupo_nome'];

        $membrosTotal_roscas = select("membro_grupo", "count(codigo_grupo) as 'total'","where codigo_grupo = '$grupo_codigo'");

        $total = $membrosTotal_roscas[0]['total'];

        echo '
          <tr>
             <th scope="row">' . substr_replace($grupo_codigo,"", 0, 3) . '</th>
             <td><a onclick="gotoGerirGrupo(this.id)" id="' . md5($grupo_codigo) . '_grupo">' . $grupo_nome . '</a></td>
             
             <td><span class="badge bg-blue-grey">'.$total.' Membros</span> </td>
          </tr>';
    }

}
