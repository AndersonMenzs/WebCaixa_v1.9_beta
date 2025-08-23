<html>

  <head>
    <title>WebCaixa v1.19_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
	  body {
		margin-top: 5%;
		margin-left: 5%;
		margin-right: 5%;
		border: 3px solid gray;
		padding: 10px 10px 10px 10px;
		font-family:sans-serif;
	       }
	  .campos {
	   background-color:#C0C0C0;
	   font: 12px sans-serif;
	   color:#000000;
		  }
	</style>

<script>
function F5(event) {
var tecla = document.all ? window.event.keyCode : event.which;
if (document.all) { window.event.keyCode = 0; window.event.returnValue = false; }
if (tecla == 116) return false;
}

document.onkeydown = F5;
</script>

	<?php
	  // Inserindo Cabeçalho
	     include "../cabecprs.php";
	?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF">
    <?php
      // Importando os Dados do Formulário
	 $Sis       = "S7";
	 $Rot       = "S7R1.1.1";
	 $dtRec     = date('Y-m-d');
	 $dtComp    = date('Y-m-d');
	 $lg_user   = trim($_POST['txtuser']);
	   $user    = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40);
	 $Aut       = trim($_POST['txtaut']);
	 $Reg       = $Aut;
	 $NDoc      = trim($_POST['txtdoc']);
	 $SlgPag    = trim($_POST['txtfpag']);
	 $VrEntr    = trim($_POST['txtvlrec']);
	 $Opt       = $_POST['rdopt'];
	 $Pass      = strtolower(trim($_POST['txtsen']));
	 $Senha     = sha1($Pass);

	 include "conexao.php";
	 include "dbselect.php";

      // Obtendo a Data Atual
	 $DataAtual = date('Ymd');

      // Obtendo Dados
	 $sqlo = "select * from operador where pass = '$Senha' ";
	 $rso  = mysqli_query($conec, $sqlo);
	 $regso= mysqli_num_rows($rso); ?>

    <font color="gold" size="6">
      <br><b><center><u><i>Autenticação de Solicitação</i></u></center></b></font><br><?php

  include "us_cad.php";

  if ($ch == 'ok' or $ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm')
    {
     if ($regso > 0)
       {
	$lno  = mysqli_fetch_array($rso);
	  $Mat = $lno['mat'];

	// Preparando a Via Cliente ?>
	   <form name="geracntentr" method="post" action="via1ped.php">
	      <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
	      <input type="hidden" name="txtreg" value="<?php echo $Reg; ?>">
	      <input type="hidden" name="tipopag" value="<?php echo $SlgPag; ?>">
	      <input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
	      <input type="hidden" name="dtrec" value="<?php echo $dtRec; ?>">
	      <input type="hidden" name="txthora" value="<?php echo $Opt; ?>">
	      <input type="hidden" name="txtvalor" value="<?php echo $VrEntr; ?>">
	      <input type="hidden" name="txtmat" value="<?php echo $Mat; ?>"><br>
	 <font size='6'><b><center>Coloque a <font color='gold'><blink>Última Via</blink><font color='#FFFFFF'> na Autenticadora e <br>
	 <p>Clique no <font color='gold'><blink>botão Abaixo</blink><font color='#FFFFFF'>.</center></b></font></p><br>
	       <center><input id="ghost_click" type="submit" name="btimprime" value="Autenticar"></center><br>
		   <center><font color='#FFFFFF' size='3'><span id="msg"></span></font></center>
	    </form><?php

	} else { ?>
	    <font size='6'><b><center>Senha <font color='gold'><blink>Incorreta</blink><br>
	    <font color='#FFFFFF'>ou<br>
	    Usuário <font color='gold'><blink>Não Autorizado</blink><font color="#FFFFFF">!!!</center></b></font><br>
	    <center><a href='JavaScript:window.history.back()'><img src='images/voltar.gif'></a></center><br><?php
	       }
    }

    // Encerrando a Conexão
       /* mysqli_free_result($rso);
       mysqli_free_result($rsGr);
       mysqli_free_result($rsx); */
       $SisRot = "S-7.1.1.1";
       include "./rodape.php"; ?>

	   <script src="./js/ghost_click.js"></script>

  </body>

</html>
