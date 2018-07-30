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

$membro_roscas = select("membro_roscas", "*");

$membroCount_roscas = count($membro_roscas);

for ($i = 0; $i < $membroCount_roscas; $i++) {

    $membro_codigo = $membro_roscas[$i]['membro_codigo'];

    $membro_nome = $membro_roscas[$i]['membro_nome'];

    echo '
          <tr>
             <th scope="row">'.($i+1).'</th>
             <td>
             <input type="checkbox" id="'.$membro_codigo.'" class="chk-col-light-green"/>
             <label for="'.$membro_codigo.'">'.$membro_nome.'</label>
             </td>
          </tr>';
}


