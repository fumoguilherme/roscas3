<?php

	function fechaConexao($conexao){
		
		$fecha = mysql_close($conexao);
		
		if(!$fecha){
			
			echo("Imposivel Fechar a conexao");
			
			return false;
		}else {
			
			return true;
		}
		
	}

