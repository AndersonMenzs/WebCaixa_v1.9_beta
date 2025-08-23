<html>

  <head>
    <title>WebCaixa v1.19_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
	  body {
		margin-top: 3%;
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
	 $lg_user   = trim($_POST['txtuser']);
	   $user    = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40);
	 $Aut       = trim($_POST['txtreg']);
	   $AutFull = 10000 + $Aut;
	 $Reg       = substr($AutFull,1,4);
	 $NDoc      = trim($_POST['txtdoc']);
	 $SlgPag    = trim($_POST['tipopag']);
	 $dtRec     = trim($_POST['dtrec']);
	   $aRec    = substr($dtRec,2,2);
	   $mRec    = substr($dtRec,5,2);
	   $dRec    = substr($dtRec,8,2);
	 $dtAut     = $dRec.$mRec.$aRec;
	 $Opt       = $_POST['txthora'];
	 $VrEnt     = trim($_POST['txtvalor']);
	 $VrEntr    = number_format($VrEnt,2,',','');
	 $VrEntrF   = "R$ "."$VrEntr";
	 $Mat       = trim($_POST['txtmat']);

      // Pesquisando PC
	 include "conexao.php";
	 include "dbselect.php";
	 $sqlPC = "select pc from inicial";
	 $rsPC  = mysqli_query($conec, $sqlPC) or die ("Não foi possível acessar o PC");
	 $lnPC  = mysqli_fetch_array($rsPC);
	   $PC  = $lnPC['pc'];
 
       // Reduzindo a Matrícula
	  $MatRec = substr($Mat,1,6)."-".substr($Mat,7,1); ?>

    <font color="gold" size="6">
      <br><b><center><u><i>Sistema de Autenticação</i></u></center></b></font><?php

    // Imprimindo o Recibo
       $Aut1 = $Reg;
       $Aut2 = "$Reg$PC$NDoc$dtAut$VrEntrF$SlgPag$MatRec$Opt";

       shell_exec("echo $Aut2 > /dev/lp0");

    // Gravando a Spool
       include "dbselect.php";
       $sql = "insert into spool2 values ('$Aut1', '$Aut2')";
       $rs  = mysqli_query($conec, $sql) or die ("Não foi possível gravar a Spool");

    // Preparando Ficha Cliente ?>
       <form name="via1entr" method="post" action="via2ped.php">
	   <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
	   <input type="hidden" name="txtreg" value="<?php echo $Reg; ?>">
	   <input type="hidden" name="txtpc" value="<?php echo $PC; ?>">
	   <input type="hidden" name="rdopt" value="<?php echo $Opt; ?>">
	   <input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
	   <input type="hidden" name="dtaut" value="<?php echo $dtAut; ?>">
	   <input type="hidden" name="txtvalor" value="<?php echo $VrEnt; ?>">
	   <input type="hidden" name="siglapag" value="<?php echo $SlgPag; ?>">
	   <input type="hidden" name="txtmat" value="<?php echo $MatRec; ?>">
	   <br><br><br><br>
	   <font size='6'><b><center>Clique <font color='gold'><blink>no Botão Abaixo</blink><font color='#FFFFFF'> <br>
	   <p>para <font color='gold'><blink>Retornar</blink><font color='#FFFFFF'> ao Menu Principal.</center></b></font></p><br>
	   <center><input id="ghost_click" type="submit" name="btimprime" value="Fim de Operação"></center><br>
	   <center><font color='#FFFFFF' size='3'><span id="msg"></span></font></center>
       </form><?php

    // Encerrando a Conexão
       /* mysqli_free_result($rs);
       mysqli_free_result($rsPC);
       mysqli_free_result($rsRec);
       mysqli_free_result($rsFm);
       mysqli_free_result($rsApe); */
       $SisRot = "S-7.1.1.1";
       include "./rodape.php"; ?>

	   <script src="./js/ghost_click.js"></script>

  </body>

</html>
