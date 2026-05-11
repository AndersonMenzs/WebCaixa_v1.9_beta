<html>

<head>
	<title>WebCaixa v1.20.0_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-left: 5%;
			margin-right: 5%;
			border: 3px solid gray;
			padding: 10px 10px 10px 10px;
			font-family: sans-serif;
		}

		.campos {
			background-color: #C0C0C0;
			font: 12px sans-serif;
			color: #000000;
		}
	</style>


	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>

	<script>
		function F5(event) {
			var tecla = document.all ? window.event.keyCode : event.which;
			if (document.all) {
				window.event.keyCode = 0;
				window.event.returnValue = false;
			}
			if (tecla == 116) return false;
		}

		document.onkeydown = F5;
	</script>

	<SCRIPT LANGUAGE="JavaScript">
		<!-- Begin
		function putFocus(formInst, elementInst) {
			if (document.forms.length > 0) {
				document.forms[formInst].elements[elementInst].focus();
			}
		}
		//  End 
		-->
	</script>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">
	<?php
	/*$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	echo "<pre>";
	var_dump($dados);
	echo "</pre>";*/

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R1.1";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Aut       = trim($_POST['txtaut']);
	$AutFull = 10000 + $Aut;
	$AutF      = substr($AutFull, 1, 4);
	$Opt       = $_POST['rdopt'];
	$Mat_Vend  = $_POST['mat_vend'];
	$Vendedora = $_POST['vendedora'];
	$Cliente   = $_POST['cliente'];
	$Pct_ped   = $_POST['pct_ped'];
	$Tam_ped   = $_POST['tam_ped'];

	include "conexao.php";
	include "dbselect.php";

	// Obtendo a Data Atual
	$DataAtual = date('Ymd');

	// Obtendo Dados
	$sqlE = "select * from registro where reg = '$Aut' and (tiporec = 3 or tiporec = 4 or tiporec = 6 or tiporec = 7) and estorno <> 'x' and datarec = $DataAtual";
	$rsE  = mysqli_query($conec, $sqlE);
	$regE = mysqli_num_rows($rsE);

	// Arrays para armazenar múltiplos valores
	$ModPgtoE_array = array();
	$VlRec = 0;

	while ($lnE  = mysqli_fetch_array($rsE)) {
		$Aut      = $lnE['reg'];
		$NumDocE   = $lnE['numdoc'];
		$TipoRecE  = $lnE['tiporec'];
		$ModPgtoE_array[] = $lnE['modpgto']; // Armazena todas as formas de pagamento
		$DataRecE  = $lnE['datarec'];
		$HoraRecE  = $lnE['horarec'];
		$VlPago    = $lnE['vlrec'];
		$VlRec     = $VlRec + $VlPago;
		$OperadorE = $lnE['operador'];
		$Mat_Vend = $lnE['mat_vend'];
		$Vendedora = $lnE['vendedora'];
		$Cliente = $lnE['cliente'];
	}

	// Remove duplicatas e prepara a exibição das formas de pagamento
	$ModPgtoE_unique = array_unique($ModPgtoE_array);

	// Se há mais de uma forma de pagamento, exibe "Diversos"
	if (count($ModPgtoE_unique) > 1) {
		$ModPgtoE_display = 'Diversos';
		$SlgPag = 'Diversos';
		$SlgPag_a = 'DIV';
	} else {
		// Caso contrário, busca os dados da única forma de pagamento
		$ModPgtoE = $ModPgtoE_unique[0];
		$sqlM = "select modpag, siglapag from formapag where codpag = '$ModPgtoE' ";
		$rsM  = mysqli_query($conec, $sqlM) or die("Erro de Banco de Dados #2. Contate seu Administrador");
		$lnM  = mysqli_fetch_array($rsM);
		$ModPgtoE_display = $lnM['modpag'];
		$SlgPag  = $lnM['siglapag'];

		// Verificando cada forma de pagamento
		if ($ModPgtoE == '10') {
			$SlgPag_a = 'DIN';
		} elseif ($ModPgtoE == '20') {
			$SlgPag_a = 'CTD';
		} elseif ($ModPgtoE == '30') {
			$SlgPag_a = 'CTV';
		} elseif ($ModPgtoE == '70') {
			$SlgPag_a = 'PXQ';
		} elseif ($ModPgtoE == '71') {
			$SlgPag_a = 'PXC';
		}
	}

	$sqlR = "select * from tiporec where codrec = '$TipoRecE' ";
	$rsR  = mysqli_query($conec, $sqlR) or die("Erro de Banco de Dados #3. Contate seu Administrador");
	$lnR  = mysqli_fetch_array($rsR);
	$CodRec      = $lnR['codrec'];
	$NomeRec     = $lnR['nomerec'];
	mysqli_free_result($rsE);
	mysqli_free_result($rsR);

	// Consulta o número de documento e soma os valores
	$sqlP = "SELECT SUM(vlrec) AS vlrec FROM registro WHERE numdoc = '$NumDocE' AND datarec = '$DataRecE' AND estorno <> 'x' AND subtipo <> 'EST'";
	$rsP  = mysqli_query($conec, $sqlP) or die("Erro de Banco de Dados #4. Contate seu Administrador");
	$lnP  = mysqli_fetch_array($rsP);
	$VlRec = $lnP['vlrec'];
	$VlRecF    = number_format($VlRec, 2, ',', '.');

	?>

	<font color="gold" size="6">
		<b>
			<center><u><i>SOLICITAÇÃO DE ENVIO</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
		if ($regE > 0) { ?>
			<table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
				<form name="confentr" method="post" action="geraped.php">
					<tr>
						<td width="50%" align="center">
							<font color='gold' size='5'><b><i>Autenticação Nº</i></b></font>
						</td>
						<td width="50%" align="center">
							<font color='#FFFFFF' size='5'><b><i><?php echo $AutF; ?></i></b></font>
						</td>
					</tr>
					<?php
					if ($NumDocE <> 0) { ?>
						<tr>
							<td width="50%" align="center">
								<font color='gold' size='5'><b><i>Nº Documento</i></b></font>
							</td>
							<td width="50%" align="center">
								<font color='#FFFFFF' size='5'><b><i><?php echo $NumDocE; ?></i></b></font>
							</td>
						</tr>
					<?php
					} ?>

					<tr>
						<td width="50%" align="center">
							<font color='gold' size='5'><b><i>Tipo de Recebimento</i></b></font>
						</td>
						<td width="50%" align="center">
							<font color='#FFFFFF' size='5'><b><i>
										<blink><?php echo $NomeRec; ?></blink>
									</i></b></font>
						</td>
					</tr>

					<tr>
						<td width="50%" align="center">
							<font color='gold' size='5'><b><i>Pedido</i></b></font>
						</td>
						<td width="50%" align="center">
							<font color='#FFFFFF' size='5'><b><i>
										<blink>
											<?php
											if ($Pct_ped <> '') {
												echo $Pct_ped;
											?>
												<input type="hidden" name="pct_ped" value="<?php echo $Pct_ped; ?>">
											<?php } elseif ($Tam_ped <> '') {
												echo $Tam_ped;
											?>
												<input type="hidden" name="tam_ped" value="<?php echo $Tam_ped; ?>">
											<?php
											}
											?>
										</blink>
									</i></b></font>
						</td>
					</tr>

					<tr>
						<td width="50%" align="center">
							<font color='gold' size='5'><b><i>Forma de Pagamento</i></b></font>
						</td>
						<td width="50%" align="center">
							<font color='#FFFFFF' size='5'>
								<b>
									<i>
										<blink>
											<?php echo $ModPgtoE_display; ?>
										</blink>
									</i>
								</b>
							</font>
						</td>
					</tr>

					<tr>
						<td width="50%" align="center">
							<font color='gold' size='5'><b><i>Valor Cobrado</i></b></font>
						</td>
						<td width="50%" align="center">
							<font color='#FFFFFF' size='5'><b><i><?php echo "R$ " . $VlRecF; ?></i></b></font>
						</td>
					</tr>

					<tr>
						<td width="40%" align="center">
							<font color='gold' size='5'><b><i>Senha</i></b></font>
						</td>
						<td width="60%" align="center">
							<input type='password' name='txtsen' size='6' maxlength='6' class="campos" autofocus>
						</td>
					</tr>
			</table>

			<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
			<input type="hidden" name="txtaut" value="<?php echo $Aut; ?>">
			<input type="hidden" name="txtdoc" value="<?php echo $NumDocE; ?>">
			<input type="hidden" name="txtfpag" value="<?php echo $SlgPag_a; ?>">
			<input type="hidden" name="txtvlrec" value="<?php echo $VlRec; ?>">
			<input type="hidden" name="rdopt" value="<?php echo $Opt; ?>">
			<input type="hidden" name="txtmatvend" value="<?php echo $Mat_Vend; ?>">
			<input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
			<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
			<p>
				<center><input id="ghost_click" type="submit" name="btenvia" value="Continuar">
					<input type="button" name="btret" value="Retornar" OnClick="JavaScript:window.history.back()">
				</center>
			</p>
			<center>
				<font color='#FFFFFF' size='3'><span id="msg"></span></font>
			</center>
			</form><?php
				} else { ?>
			<br><br><br><br>
			<font size='6'><b>
					<center>Autenticação <font color='gold'>
							<blink><u>Inexistente</u>
							</blink>
							<font color='#FFFFFF'>!!!<br>ou<br>
								a Autenticação <font color='gold'>
									<blink><u>Não Pertence</u></blink>
									<font color='#FFFFFF'> ao Serviço!!!</center>
				</b></font><br>
			<center><a href='ped.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br>
		<?php
				}
			} else { ?>
		<br><br><br><br><br>
		<font size='6'><b>
				<center>Acesso <font color='gold'>
						<blink><u>não Autorizado</u>
						</blink>
						<font color='#FFFFFF'>!!!</center>
			</b></font><br><br><br>
		<center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br
			<?php
			}

			// Encerrando
			$SisRot = "S-7.1.1";
			include "./rodape.php"; ?>

			<script src="./js/ghost_click.js"></script>

</body>

</html>