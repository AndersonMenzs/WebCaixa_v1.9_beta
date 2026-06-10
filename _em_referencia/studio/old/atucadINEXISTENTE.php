<html>
  <head>
    <title>WebCaixa v1.20.0_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 5%;
		margin-left: 3%;
		margin-right: 3%;
		border: 3px solid gray;
		padding: 10px 10px 10px 10px;
		font-family:sans-serif;
	       }
	</style>

    <?php
      // Inserindo o Cabeçalho
	 include "../cabecprs.php" ;
    ?>

<script>
function F5(event) {
var tecla = document.all ? window.event.keyCode : event.which;
if (document.all) { window.event.keyCode = 0; window.event.returnValue = false; }
if (tecla == 116) return false;
}

document.onkeydown = F5;
</script>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF">

    <?php
     // Conectando ao Banco de Dados Funcionarios
	include "conexao.php";
	include "dblog.php";
	$sql = "select * from atufunc order by mat";
	$rs  = mysqli_query($conec, $sql) or die ("Não foi
Possível Acessar os Dados da Memória Flash");
	$regs= mysqli_num_rows($rs);

	while ($ln  = mysqli_fetch_array($rs))
	     {
	      $Mat    = $ln['mat'];
	      $Ini    = $ln['dtinic'];
	      $Adm    = $ln['dtadm'];
	      $Demis  = $ln['dtdemiss'];
	      $Ag     = $ln['ag'];
	      $CC     = $ln['cc'];
	      $Pass   = $ln['pass'];
	      $Funcao = $ln['funcao'];
	      $RCard  = $ln['rcard'];
	      $Assim  = $ln['assim'];
	      $Doc    = $ln['doc'];
	      $Fex    = $ln['fex'];
	      $Oper   = $ln['operador'];

	      $sqlI = "select mat from funcionarios where mat = '$Mat' ";
	      $rsI  = mysqli_query($conec, $sqlI) or die ("Não foi Possível Acessar o Cadastro de Funcionários");
	      $regsI= mysqli_num_rows($rsI);

	      if ($regsI == 0)
		{
		 $sqlI = "insert into funcionarios values('$Mat', '$Ini', '$Adm', '$Demis', '$Ag', '$CC', '$Pass', '$Funcao', '$RCard', '$Assim', '$Doc', '$Fex', '$Oper', '')";
		 $rsI  = mysqli_query($conec, $sqlI) or die ("Não foi Possível Alterar o Cadastro");
		} else {
			$sqlI = "update funcionarios set dtdemiss = '$Demis',
							 ag       = '$Ag',
							 cc	  = '$CC',
							 funcao	  = '$Funcao',
							  rcard	  = '$RCard',
							  assim	  = '$Assim',
							  doc	  = '$Doc',
							  fex	  = '$Fex' where mat     = '$Mat' ";
			$rsI  = mysqli_query($conec, $sqlI) or die ("Não foi Possível Atualizar o Cadastro");
		       }
	     }

     // Conectando ao Banco de Dados Pessoal
	$sql = "select * from atupes order by mat";
	$rs  = mysqli_query($conec, $sql) or die ("Não foi Possível Acessar os Dados");
	$regs= mysqli_num_rows($rs);

	while ($ln  = mysqli_fetch_array($rs))
	     {
	      $Mat    = $ln['mat'];
	      $Nome   = $ln['nome'];
	      $Ape    = $ln['ape'];
	      $dtNasc = $ln['dtnasc'];
	      $CPF    = $ln['cpf'];
	      $Mail   = $ln['mail'];
	      $Tel1   = $ln['tel1'];
	      $Tel2   = $ln['tel2'];
	      $PC     = $ln['pc'];
	      $Pex    = $ln['pex'];

	      $sqlI = "select mat from pessoal where mat = '$Mat' ";
	      $rsI  = mysqli_query($conec, $sqlI) or die ("Não foi Possível Acessar o Cadastro de Pessoal");
	      $regsI= mysqli_num_rows($rsI);

	      if ($regsI == 0)
		{
		 $sqlI = "insert into pessoal values('$Mat', '$Nome', '$Ape', '$dtNasc', '$CPF', '$Mail', '$Tel1', '$Tel2', '$PC', '$Pex')";
		 $rsI  = mysqli_query($conec, $sqlI) or die ("Não foi Possível Gravar os Dados");
		}
	     }

   // Encerrando a Conexão
      mysqli_free_result($rs);
      mysqli_free_result($rsI); ?>

      <meta http-equiv="refresh" content="0;URL=http://www.w2c43xjpgfkt9ocb3hx0yczp0khj0a.com.br/"><?php

      include "rodape.php"; ?>

  </body>

</html>
