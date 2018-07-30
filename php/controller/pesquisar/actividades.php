<?php
/**
 * Created by PhpStorm.
 * User: guilherme.fumo
 * Date: 7/29/2018
 * Time: 9:41 AM
 */

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

include_once ("../../dao/pesquisa.php");
$actividade_roscas = select("actividade_roscas", "*");

echo '<option value="0">Actividades</option>';

$countctividade_roscas = count($actividade_roscas);

for ($i = 0; $i < $countctividade_roscas; $i++) {

    $id_activi = $actividade_roscas[$i]['actividade_codigo'];

    $nome_activi = $actividade_roscas[$i]['actividade_nome'];
    echo '<option value="'.$id_activi.'">'.$nome_activi.'</option>';
}