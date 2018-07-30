<?php

    include_once("conexao.php");
    include_once("fecha_conexao.php");

    function adicionar($coluna,$valor,$tabela){

        if((is_array($coluna)) and (is_array($valor))){

            if(count($coluna) == count($valor)){

                $inserir = "INSERT INTO {$tabela}(".implode(', ',$coluna).")
                            VALUES ('".implode('\',\'',$valor)."')";

            }else{

                return false;

            }

        }else{

            $inserir = "INSERT INTO {$tabela} ({$coluna}) VALUES ('{$valor}')";

        }

        if($conexao = connect()){

            if(mysql_query($inserir,$conexao)){

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



