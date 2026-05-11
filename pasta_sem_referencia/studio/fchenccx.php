<html>
  <head>
    <title>WebCaixa v1.20.0_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-left: 0%;
		margin-right: 0%;
		border: 3px solid gray;
		padding: 10px 10px 10px 10px;
		font-family:sans-serif;
	       }
	</style>

<script>
function F5(event) {
var tecla = document.all ? window.event.keyCode : event.which;
if (document.all) { window.event.keyCode = 0; window.event.returnValue = false; }
if (tecla == 116) return false;
}

document.onkeydown = F5;
</script><?php

     // Obtendo a Data Atual
	$DataAtual = date('Ymd'); ?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF">
    <?php include "../cabecprs.php";

     // Obtendo o Login
	$Sis     = "S7";
	$Rot       = "S7R5.2.1";
	$lg_user   = trim($_POST['txtuser']);
	  $user    = substr($lg_user,0,8);
	     $mat1 = substr($user,0,1);
	     $mat2 = substr($user,1,3);
	     $mat3 = substr($user,4,3);
	     $dv   = substr($user,7,1);
	$userF     = "$mat1.$mat2.$mat3-$dv";
	  $pss     = substr($lg_user,8,40);
	$Gaveta    = $_POST['txtcash'];
	$GavAut    = number_format($Gaveta,2,",",".");
	$ch        = '';
	$dtAbre    = trim($_POST['dtabre']);
	  $dty     = substr($dtAbre,0,4);
	  $dtm     = substr($dtAbre,5,2);
	  $dtd     = substr($dtAbre,8,2);
	$dataFch   = "$dtd/$dtm/$dty";
	$hora      = date("H:i");

	include "us_sist.php";
	if ($ch == 'no')
	  {
	   include "us_cad.php";
	  }

 if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok')
   { ?>
    <font size='4' color='gold'><b><u><i><center>FECHAMENTO DO CAIXA</center></i></u></b></font><?php

    // Obtendo Apelido
       include "conexao.php";
       include "dblog.php";
       $sqlP = "select ape from pessoal where mat = '$user' ";
       $rsP  = mysqli_query($conec, $sqlP) or die ("Não foi possível fechar o Caixa");
       $lnP = mysqli_fetch_array($rsP);
	  $app = $lnP['ape'];

    // Obtendo Dados do PC
       include "dbselect.php";
       $sqlI = "select * from inicial";
       $rsI  = mysqli_query($conec, $sqlI) or die ("Não foi possível fechar o Caixa");
       $lnI = mysqli_fetch_array($rsI);
	  $PC  = $lnI['pc'];
	  $Ape = $lnI['ape'];

    // Obtendo Dados para o Fechamento
       $sqlA = "select * from caixa where dtclose=0";
       $rsA  = mysqli_query($conec, $sqlA) or die ("Não foi possível fechar o Caixa");
       $regA = mysqli_num_rows($rsA);
       $lnA = mysqli_fetch_array($rsA);
	  $Fita         = $lnA['fita'];
	  $ano          = $lnA['ano'];
	  $dtOpen       = $lnA['dtopen'];
	    $opy        = substr($dtOpen,0,4);
	    $opm        = substr($dtOpen,5,2);
	    $opd        = substr($dtOpen,8,2);
	  $dtOpenGr     = "$opy$opm$opd";

	  $NTxProd      = $lnA['numtxprod'];
	  $VrTxProd     = $lnA['vrtxprod'];
	  $NConcurso    = $lnA['numconcurso'];
	  $VrConcurso   = $lnA['vrconcurso'];
	  $NContEnt     = $lnA['numcontent'];
	  $VrContEnt    = $lnA['vrcontent'];
	  $NContParc    = $lnA['numcontparc'];
	  $VrContParc   = $lnA['vrcontparc'];
	  $NPropEnt     = $lnA['numpropent'];
	  $VrPropEnt    = $lnA['vrpropent'];
	  $NPropParc    = $lnA['numpropparc'];
	  $VrPropParc   = $lnA['vrpropparc'];
	  $NResgate     = $lnA['numresgate'];
	  $VrResgate    = $lnA['vrresgate'];
	  $NEstorno     = $lnA['numestorno'];
	  $VrEstorno    = $lnA['vrestorno'];
          $ValorProd    = number_format($VrTxProd,2,",",".");
          $ValorConc    = number_format($VrConcurso,2,",",".");
          $ValorContEnt = number_format($VrContEnt,2,",",".");
          $ValorPropEnt = number_format($VrPropEnt,2,",",".");
          $ValorContParc= number_format($VrContParc,2,",",".");
          $ValorPropParc= number_format($VrPropParc,2,",",".");
          $ValorResg    = number_format($VrResgate,2,",",".");
          $ValorEstorno = number_format($VrEstorno,2,",",".");

	  $cashTot      = $lnA['cashtot'];
	  $cDebFinal    = $lnA['cdebfinal'];
	  $credTotV     = $lnA['credtotvist'];
	  $credTotPLoja = $lnA['credtotploja'];
	  $credTotPAdm  = $lnA['credtotpadm'];
	  $cheqTotV     = $lnA['cheqtotvist'];
	  $cheqTotPre   = $lnA['cheqtotpre'];
	  $NumPgtos     = $lnA['numpgtos'];
	  $Pgtos        = $lnA['pgtos'];
	  $Numerario    = $lnA['numerario'];
	  $DepClientes	= $lnA['totdepcli'];
          $inicial      = number_format($Numerario,2,",",".");
	  $Dinheiro     = number_format($cashTot,2,",",".");
	  $CardDeb      = number_format($cDebFinal,2,",",".");
	  $CardVista    = number_format($credTotV,2,",",".");
	  $CardParcLj   = number_format($credTotPLoja,2,",",".");
	  $CardParcAdm  = number_format($credTotPAdm,2,",",".");
	  $CheqTotal    = number_format($cheqTotV,2,",",".");
	  $CheqPre      = number_format($cheqTotPre,2,",",".");
	  $DepCli       = number_format($DepClientes,2,",",".");

    // Obtendo Dados para o Fechamento
       $sqlR = "select * from depositos where dtdep = '$DataAtual' ";
       $rsR  = mysqli_query($conec, $sqlR) or die ("Não foi possível acessaros Dados");
       while ($lnR = mysqli_fetch_array($rsR))
	    {
	     $Dep    = $lnR['valor'];
	     $Recolh = $Recolh + $Dep;
	    }

    // Totalizando Recebimentos
       $Entradas  = $cashTot + $cDebFinal + $credTotV + $credTotPLoja + $credTotPAdm + $cheqTotV + $cheqTotPre + $DepClientes;
       $DemaisTot = $cDebFinal + $credTotV + $credTotPLoja + $credTotPAdm + $cheqTotV + $cheqTotPre;
       $Geral     = $Recolh + $DemaisTot;
       $TotIn     = number_format($Entradas,2,",",".");
       $RecolTot  = number_format($Recolh,2,",",".");
       $TotOutros = number_format($DemaisTot,2,",",".");
       $TotGeral = number_format($Geral,2,",",".");

    // Totalizando Pagamentos
       $PgtoTot     = number_format($Pgtos,2,",",".");
       $TotOut = number_format($PgtoTot,2,",",".");

    // Calculando a Diferença de Caixa
       $Diferenca = ($Recolh + $Pgtos + $Gaveta) - ($Numerario + $cashTot);
       $DifCx = number_format($Diferenca,2,",",".");

       if ($Diferenca == 0)
	 {
	  $cd = '';
	 } else if ($Diferenca > 0)
		  {
		   $cd = '(FALTA)';
		  } else {
			  $cd = '(SOBRA)';
			 }

    // Totalizando Autenticações
       $TotAut = $NTxProd + $NConcurso + $NContEnt + $NContParc + $NPropEnt + $NPropParc + $NResgate + $NumPgtos + $NEstorno;?><p>

    <table width="100%" border="05" cellpadding="0" cellspacing="0" align="center">
       <tr>
	  <td rowspan='2'>
	     <font color='gold'><b><i>Dados da Abertura</i></b></font>
	  </td>
	  <td width='15%' align='center'>
	     <font color="gold"><b><i>Fita Nº</b></i></font>
	  </td>
	  <td width='15%' align='center'>
	     <font color="gold"><b><i>PC <b><i></b></i></font>
	  </td>
	  <td width='15%' align='center'>
	     <font color="gold"><b><i>Data</b></i></font>
	  </td>
	  <td width='25%' align='center'>
	     <font color="gold"><b><i>Operador</b></i></font>
	  </td>
	  <td width='15%' align='center'>
	     <font color="gold"><b><i>Saldo de Abertura</b></i></font>
	  </td>
       </tr>

       <tr>
	  <td width='15%' align='center'>
	     <b><i><b><i><?php echo "$Fita/$ano"; ?></i></b></b></i></font>
	  </td>
	  <td width='15%' align='center'>
	     <b><i><b><i><?php echo "$PC - $Ape"; ?></i></b></b></i></font>
	  </td>
	  <td width='15%' align='center'>
	     <b><i><b><i><?php echo $dataFch; ?></i></b></b></i></font>
	  </td>
	  <td width='25%' align='center'>
	     <b><i><b><i><?php echo "$userF ($app)"; ?></i></b></b></i></font>
	  </td>
	  <td width='15%' align='center'>
	     <b><i><b><i>R$ <?php echo $inicial; ?></i></b></b></i></font>
	  </td>
       </tr>
    </table></p>

    <table width="100%" border="05" cellpadding="0" cellspacing="0" align="center">
       <tr>
	  <td width='34%' align='center'>
	     <font color="gold"><b><i>FECHAMENTO POR TIPO DE SERVIÇO</b></i></font>
	  </td>
	  <td width='34%' align='center'>
	     <font color="gold"><b><i>FECHAMENTO POR FORMA DE RECEBIMENTO</b></i></font>
	  </td>
	  <td width='32%' align='center'>
	     <font color="gold"><b><i>TOTALIZAÇÕES: &nbsp;&nbsp;<font color='#FFFFFF'><blink><?php echo "$TotAut Autenticações"; ?></blink></b></i></font>
	  </td>
       </tr>

       <tr>
	  <td width='34%'>
	     <font color="gold"><b><i>Taxa de Produção: . . . . . </b></i></font>
	     <b><i><?php echo "$NTxProd itens --> R$ $ValorProd"; ?></i></b>
	  </td>
	  <td width='34%'>
	     <font color="gold"><b><i>Total em Dinheiro: . . . . . . . . . . . . </b></i></font>
	     <b><i>R$ <?php echo $Dinheiro; ?></i></b>
	  </td>
	  <td width='32%'>
	     <font color="gold"><b><i>&nbsp;Saldo Inicial:. . . . . . . . . . . . . . . . <font color='#FFFFFF'><?php echo "R$ $inicial"; ?> </b></i></font>
	  </td>
       </tr>

       <tr>
	  <td width='34%'>
	     <font color="gold"><b><i>Inscrição Concurso: . . . . </b></i></font>
	     <b><i><?php echo "$NConcurso itens --> R$ $ValorConc"; ?></i></b>
	  </td>
	  <td width='34%'>
	     <font color="gold"><b><i>Total em Cartao Débito: . . . . . . . . </b></i></font>
	     <b><i>R$ <?php echo $CardDeb; ?></i></b>
	  </td>
	  <td width='32%'>
	     <font color="gold"><b><i>&nbsp;Total Arrecadado: . . . . . . . . . . . . <font color='#FFFFFF'><?php echo "R$ $TotIn"; ?> </b></i></font>
	  </td>
       </tr>

       <tr>
	  <td width='34%'>
	     <font color="gold"><b><i>Contratos (Entrada): . . . . </b></i></font>
	     <b><i><?php echo "$NContEnt itens --> R$ $ValorContEnt"; ?></i></b>
	  </td>
	  <td width='34%'>
	     <font color="gold"><b><i>Cartao Crédito (A Vista):. . . . . . . . </b></i></font>
	     <b><i>R$ <?php echo $CardVista; ?></i></b>
	  </td>
	  <td width='32%'>
	     <font color="gold"><b><i>&nbsp;Recolhido em Dinheiro:. . . . . . . . <font color='#FFFFFF'><?php echo "R$ $RecolTot"; ?> </b></i></font>
	  </td>
       </tr>

       <tr>
	  <td width='34%'>
	     <font color="gold"><b><i>Contratos (Parcela): . . . .</b></i></font>
	     <b><i><?php echo "$NContParc itens --> R$ $ValorContParc"; ?></i></b>
	  </td>
	  <td width='34%'>
	     <font color="gold"><b><i>Cartao Crédito (Parc. Loja): . . . . . </b></i></font>
	     <b><i>R$ <?php echo $CardParcLj; ?></i></b>
	  </td>
	  <td width='32%'>
	     <font color="gold"><b><i>&nbsp;Outros Recolhimentos: . . . . . . . . <font color='#FFFFFF'><?php echo "R$ $TotOutros"; ?> </b></i></font>
	  </td>
       </tr>

       <tr>
	  <td width='34%'>
	     <font color="gold"><b><i>Propostas (Entrada):. . . . </b></i></font>
	     <b><i><?php echo "$NPropEnt itens --> R$ $ValorPropEnt"; ?></i></b>
	  </td>
	  <td width='34%'>
	     <font color="gold"><b><i>Cartao Crédito (Parc. Adm.): . . . . </b></i></font>
	     <b><i>R$ <?php echo $CardParcAdm; ?></i></b>
	  </td>
	  <td width='32%'>
	     <font color="gold"><b><i>&nbsp;Recolhimento Total:. . . . . . . . . . . </b></i></font><b><i>R$ <?php echo $TotGeral; ?><blink></font></i></b>
	  </td>
       </tr>

       <tr>
	  <td width='34%'>
	     <font color="gold"><b><i>Propostas (Parcela):. . . . </b></i></font>
			  <b><i><?php echo "$NPropParc itens --> R$ $ValorPropParc"; ?></i></b>
	  </td>
	  <td width='34%'>
	     <font color="gold"><b><i>Cheques (A Vista):. . . . . . . . . . . . </b></i></font>
	     <b><i>R$ <?php echo $CheqTotal; ?></i></b>
	  </td>
	  <td width='32%'>
	     <font color="gold"><b><i>&nbsp;Despesas:. . . . . . . . . . . . . . . . . . . </b></i></font><b><i>R$ <?php echo $PgtoTot; ?><blink></font></i></b>
	  </td>
       </tr>

       <tr>
	  <td width='34%'>
	     <font color="gold"><b><i>Resgate de Cheques: . . . </b></i></font>
	     <b><i><?php echo "$NResgate itens --> R$ $ValorResg"; ?></i></b>
	  </td>
	  <td width='34%'>
	     <font color="gold"><b><i>Cheques (Pre-datados):. . . . . . . . </b></i></font>
	     <b><i>R$ <?php echo $CheqPre; ?></i></b>
	  </td>
	  <td width='32%'>
	     <font color="gold"><b><i>&nbsp;Estornos: . . . . . . . . . . . . . . . . . . . </b></i></font><b><i>R$ <?php echo $ValorEstorno; ?><blink></font></i></b>
	  </td>
       </tr>

       <tr>
	  <td width='34%'>
	     <font color="gold"><b><i>Despesas:. . . . . . . . . . . . </b></i></font>
	     <b><i><?php echo "$NumPgtos itens --> R$ $PgtoTot"; ?></i></b>
	  </td>
	  <td width='34%'>
	     <font color="gold"><b><i>Depósito de Clientes: . . . . . . . . . </b></i></font>
	     <b><i><?php echo "R$ $DepCli"; ?></i></b>
	  <td width='32%'>
	     <font color="gold"><b><i>&nbsp;Saldo de Caixa (Gaveta):. . . . . . . . </b></i></font><b><i>R$ <?php echo $GavAut; ?><blink></font></i></b>
	  </td>
       </tr>

       <tr>
	  <td width='34%'>
	     <font color="gold"><b><i>Estorno: . . . . . . . . . . . . . <font color='#FFFFFF'><?php echo " $NEstorno itens --> R$ $ValorEstorno"; ?> </b></i></font>
	  </td>
	  <td width='34%'>&nbsp;</td>
	  <td width='32%'>&nbsp;</td>
       </tr>

       <tr>
	  <td colspan='3' align='center'>
	     <font color="gold"><b><i>&nbsp;Diferença de Caixa: . . . . . . . . . . . </b></i></font><b><i>R$ <?php echo $DifCx;
	      if ($DifCx <> 0)
		{ ?>
		 <font color='gold'><blink><?php echo $cd; ?><blink></font><?php
		} ?></i></b>
	  </td>

       </tr>
     </table><p>

   <p><center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/ok28.gif' border='0'></a></center></p><?php

    // Imprimindo os Dados
       $traco = "------------------------------------------------";
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo Fita Numero: '$Fita/$ano' > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");

       shell_exec("echo Estrella Photo Studio > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");

       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '* * * F E C H A M E N T O - D O - C A I X A * * ' > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");

       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo PC: '$PC - $Ape' > /dev/lp0");
       shell_exec("echo Data: '$dataFch' > /dev/lp0");
       shell_exec("echo Hora: $hora > /dev/lp0");
       shell_exec("echo Operador: '$userF ($app)' > /dev/lp0");

       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo 'Valor de Abertura:. . . . . . . . R$ $inicial' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");

       shell_exec("echo '----------------- RECEBIMENTOS -----------------' > /dev/lp0");
       shell_exec("echo 'POR TIPO DE SERVICO' > /dev/lp0");
       shell_exec("echo '-------------------' > /dev/lp0");
       shell_exec("echo 'Taxa de Producao:. . . . [$NTxProd] - R$ $ValorProd' > /dev/lp0");
       shell_exec("echo 'Inscricao Concurso:. . . [$NConcurso] - R$ $ValorConc' > /dev/lp0");
       shell_exec("echo 'Contrato(Entrada): . . . [$NContEnt] - R$ $ValorContEnt' > /dev/lp0");
       shell_exec("echo 'Contrato(Parcela): . . . [$NContParc] - R$ $ValorContParc' > /dev/lp0");
       shell_exec("echo 'Proposta(Entrada): . . . [$NPropEnt] - R$ $ValorPropEnt' > /dev/lp0");
       shell_exec("echo 'Resgate Cheques: . . . . [$NResgate] - R$ $ValorResg' > /dev/lp0");
       shell_exec("echo 'Despesas:. . . . . . . . [$NumPgtos] - R$ $TotOut' > /dev/lp0");
       shell_exec("echo 'Estorno: . . . . . . . . [$NEstorno] - R$ $ValorEstorno' > /dev/lp0");

       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo 'POR FORMA DE RECEBIMENTO' > /dev/lp0");
       shell_exec("echo '------------------------' > /dev/lp0");
       shell_exec("echo 'Dinheiro:. . . . . . . . . . . . R$ $Dinheiro' > /dev/lp0");
       shell_exec("echo 'Cartao de Debito:. . . . . . . . R$ $CardDeb' > /dev/lp0");
       shell_exec("echo 'Cartao Credito (a Vista):. . . . R$ $CardVista' > /dev/lp0");
       shell_exec("echo 'Cartao Credito (Parcelado Loja): R$ $CardParcLj' > /dev/lp0");
       shell_exec("echo 'Cartao Credito (Parc. Admnist.): R$ $CardParcAdm' > /dev/lp0");
       shell_exec("echo 'Cheques (A Vista): . . . . . . . R$ $CheqTotal' > /dev/lp0");
       shell_exec("echo 'Cheques (Pre-datados): . . . . . R$ $CheqPre' > /dev/lp0");
       shell_exec("echo 'Deposito de Clientes:. . . . . . R$ $DepCli' > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo 'Total de Recebimentos: . . . . . R$ $TotIn' > /dev/lp0");

       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '------------------ PAGAMENTOS ------------------' > /dev/lp0");
       shell_exec("echo 'Despesas:. . . . . . . . . . . . R$ $PgtoTot' > /dev/lp0");
       shell_exec("echo 'Recolhimentos: . . . . . . . . . R$ $RecolTot' > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       $TPgto = $Pgtos + $Recolh;
       $TotPgto = number_format($TPgto,2,",",".");
       shell_exec("echo 'Total de Pagamentos: . . . . . . R$ $TotPgto' > /dev/lp0");

       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '---------------- SALDO DE CAIXA ----------------' > /dev/lp0");
       shell_exec("echo 'Gaveta: . . . . . . . . . . . R$ $GavAut' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");

       shell_exec("echo 'Diferenca do Caixa:. . . R$ $DifCx $cd' > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo Visto do Caixa: --------------------------- > /dev/lp0");
       shell_exec("echo $traco > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");
       shell_exec("echo '\n' > /dev/lp0");

    // Salvando os Dados
       $sqlGr = "update caixa set dtclose   = '$dtOpenGr',
				  recolh    = '$Recolh',
				  difer     = '$Diferenca',
				  numerario = '$Gaveta',
				  operador  = '$user' where fita = '$Fita' ";
       $rsGr  = mysqli_query($conec, $sqlGr) or die ("Não foi possível fechar o Caixa");

   } else { ?>
	   <br><br><br><font size='6'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u></blink>
	   <font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	   <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
	  }

   // Encerrando a Conexão
      mysqli_free_result($rsA);
      mysqli_free_result($rsR);
      mysqli_free_result($rsGr);
      $SisRot = "S-7.5.2.1";
      include "rodape.php"; ?>
    </body>

</html>
