<?php
/**
 * Created by PhpStorm.
 * User: guilherme.fumo
 * Date: 1/31/2018
 * Time: 1:10 PM
 */

echo  strcmp("SIM0a","SIM0");
echo "gg";

function tempo($dateDiff){

    $dia="";

    $hora="";

    $min="";

    $seg="";

    if($dateDiff->d > 0){

        if($dateDiff->d > 1){

            $dia =$dateDiff->d." dias ";

        }else{

            $dia =$dateDiff->d." dia ";

        }
    }

    if($dateDiff->h > 0){


        if($dateDiff->h > 1){

            $hora =$dateDiff->h." horas e ";

        }else{

            $hora =$dateDiff->h." hora e ";

        }
    }

    if($dateDiff->i > 0){

        if($dateDiff->i > 1){

            $min =$dateDiff->i." mins ";

        }else{

            $min =$dateDiff->i." min ";

        }
    }

    if($dateDiff->s < 60 and $dia == 0 and $hora == 0 and $min == 0){

        $seg =$dateDiff->s." s";

    }

    return $dia.$hora.$min.$seg;
}

$dateStartProduc = new DateTime($publicacao_prod[0]['data_inicio_produc']);

$dateEndProduc   = new DateTime($publicacao_prod[0]['data_fim_produc']);

$dateDiffProduc = $dateStartProduc->diff($dateEndProduc);

tempo($dateDiffProduc);