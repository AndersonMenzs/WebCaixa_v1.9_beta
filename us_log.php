<?php
       // Abrindo a Conexão
	  include "conexao.php";

       // Selecionando o Banco de Dados
	  include "dblog.php";

      // Verificando a Autenticidade
	 $sql = "select mat, pass from funcionarios where mat = $log_aut and pass = '$pss_aut' ";

      // Consultando o registro
	 $rs = mysqli_query($conec, $sql) or die("Não foi possível acessar o Banco de Dados");

      // Obtendo os Dados do Banco
	 $linha = mysqli_fetch_array($rs);
	   $lg = $linha['mat'];
	   $ps = $linha['pass'];
?>
