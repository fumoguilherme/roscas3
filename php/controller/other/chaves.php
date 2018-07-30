
<?php

    /**
     * Created by PhpStorm.
     * User: kleyton.marcos
     * Date: 5/12/2017
     * Time: 10:44 AM
     */


    include_once("../../dao/pesquisa.php");
    include_once("../../dao/actualizar.php");

    function chave($tabela,$codigo,$prefixo,$pass){

        $existe = 0;

        $query = select("gerador_codigo_roscas", "*","WHERE gerador_codigo like '$codigo'");

        for ($i=0;$i<count($query);$i++){

            $max = $query[$i]['gerador_max'];

            $min = $query[$i]['gerador_min'];
        }


        $aleatorio = rand($min,$max);

        $opcao = select($tabela, $pass);

        $querytotal = select($tabela, "COUNT(*) AS 'total'");

        $total = $querytotal[0]['total'];

        for ($i=0;$i<count($opcao);$i++){

            if(substr($opcao[$i][$pass],strlen("{$prefixo}")) == $aleatorio){

                $existe = 1;

            }
        }


        if($existe == 1){

            $difer = ($max-$min);

            if($difer == $total){

                atualizar(array("gerador_max","gerador_min"),array(($max*2),$max),"gerador_codigo_roscas","WHERE gerador_codigo like '$codigo'");

                $aleatorio = rand($max,($max*2));

            }else{

                $aleatorio = rand($min,$max);

            }

        }

        $id = "{$prefixo}{$aleatorio}";

        return $id;

    }

?>