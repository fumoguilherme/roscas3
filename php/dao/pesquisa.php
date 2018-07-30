<?php

    include_once("conexao.php");
    include_once("fecha_conexao.php");

    function select($tabela,$coluna="*",$where=NULL,$ordem=NULL,$limite=NULL){

        $sql = "SELECT {$coluna} FROM {$tabela} {$where} {$ordem} {$limite}";

        if($conexao = connect()){

            if($query = mysql_query($sql,$conexao)){

                if(mysql_num_rows($query)>0){

                    $resultados_totais = array();

                    while($resultado = mysql_fetch_assoc($query)){

                        $resultados_totais[] = $resultado;

                    }

                    fechaConexao($conexao);

                    return $resultados_totais;
                }else{

                    return false;

                }

            }else{

                return false;

            }

        }else{

            //header('location:../../error.php');

            return false;

        }

    }

