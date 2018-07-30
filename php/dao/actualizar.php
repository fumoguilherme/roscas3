<?php

    require_once("conexao.php");
    require_once("fecha_conexao.php");

    function atualizar($coluna,$valor,$tabela,$where){

        if((is_array($coluna)) and (is_array($valor))){

            if(count($coluna) == count($valor)){

                $valor_coluna = NULL;

                for($i=0;$i<count($coluna);$i++){

                    $valor_coluna .="{$coluna[$i]} = '{$valor[$i]}',";
                }

                $valor_coluna = substr($valor_coluna,0,-1);

                $atualizar = "UPDATE {$tabela} SET {$valor_coluna} {$where}";

            }else{

                return false;

            }

        }else{

            $atualizar = "UPDATE {$tabela} SET {$coluna} = '{$valor}' {$where} ";

        }

        if($conexao = connect()){

            if(mysql_query($atualizar,$conexao)){

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

