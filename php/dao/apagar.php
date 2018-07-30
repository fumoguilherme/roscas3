<?php

    require_once("conexao.php");
    require_once("fecha_conexao.php");


    function apagar($tabela,$where){

        $apagar = "DELETE FROM {$tabela} {$where} ";

        if($conexao = connect()){

            if(mysql_query($apagar,$conexao)){

                fechaConexao($conexao);
                return true;

            }else{

                echo("Query invalida");
                return false;
            }

        }else{
            //header('location:../../error.php');

            return false;

        }
    }

