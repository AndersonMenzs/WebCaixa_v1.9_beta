<?php
    // Abrindo a Conexão
       include "conexao.php";

    // Selecionando o Banco de Dados
       include "dbselect.php";

    // Autorizando o Login
       $sql = "select * from operador where mat = '$user' and pass = '$pss' ";

    // Consultando o registro
       $rs = mysqli_query($conec, $sql) or die("Não foi possível acessar o Banco de Dados");

    // Verificando se o Usuário Existe
       $regs = mysqli_num_rows($rs);

    // Obtendo os Dados do Banco
       if ($regs <> 0)
	 {
	  $ln = mysqli_fetch_array($rs);
	     $lg    = $ln['mat'];
	     $Senha = $ln['pass'];
	     $Cargo = $ln['cargo'];

	     if ($lg == $user and $pss == $Senha and $Cargo == 'Enc')
	       {
		$ch = 'ok-enc';
	       } else if ($lg == $user and $pss == $Senha and $Cargo == 'Cai')
			{
		       $ch = 'ok-cai';
			} else if ($lg == $user and $pss == $Senha and $Cargo == 'Ven')
				 {
				  $ch = 'ok-ven';
				 } else if ($lg == $user and $pss == $Senha and $Cargo == 'Prm')
				       {
					$ch = 'ok-prm';
				       } else if ($lg == $user and $pss == $Senha and $Cargo == 'Rec')
						{
						 $ch = 'ok-rec';
						} else if ($lg == $user and $pss == $Senha and $Cargo == 'Adm')
							 {
							  $ch = 'ok-adm';
							 } else if ($lg == $user and $pss == $Senha and $Cargo == 'Aud')
								  {
								   $ch = 'ok';
								  } else {
									  $ch = 'no';
									 }
	 }

    // Encerrando a Conexão
       mysqli_free_result($rs);
?>
