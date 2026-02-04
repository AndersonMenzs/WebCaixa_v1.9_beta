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
	include "./valor_ext.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R3.1.1.1";
	$dtRec     = date('Y-m-d');
	$dtComp    = date('Y-m-d');
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Cod       = trim($_POST['txtcod']);
	$Cod2      = trim($_POST['txtcod2']);
	$TipoDesp  = trim($_POST['txttipodesp']);
	$Valor     = trim($_POST['txtvalor']);
	$ValorF = number_format($Valor, 2, ",", ".");
	$Valor_ext    = valorPorExtenso($ValorF);
	$FPag      = trim($_POST['txtmodpag']);
	$Pass      = strtolower(trim($_POST['txtsen']));
	$colab		= trim($_POST['colab']);
	$mat_vend	= trim($_POST['mat_vend']);
	$Cliente	= trim($_POST['cliente']);
	$Senha     = sha1($Pass);
	$TipoRec   = '8';
	$tipoDocumento = 'CI';
	$TipoRef = trim($_POST['tiporef']);

	include "conexao.php";
	include "dbselect.php";

	// Obtendo a Sigla de Pagamento
	$sql = "select * from pgtos where codpag = '$TipoDesp' ";
	$rs  = mysqli_query($conec, $sql);
	$ln  = mysqli_fetch_array($rs);
	$SubTipo = $ln['siglapag'];
	mysqli_free_result($rs);

	// Obtendo Dados
	$sqlo = "select * from operador where pass = '$Senha' ";
	$rso  = mysqli_query($conec, $sqlo);
	$regso = mysqli_num_rows($rso); ?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>Sistema de Registro</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_cad.php";

	if ($ch == 'ok' or $ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm') {
		if ($regso > 0) {
			$lno  = mysqli_fetch_array($rso);
			$Mat = $lno['mat'];

			// Gravando o Registro
			$sqlr = "select * from registro order by datarec desc, reg desc";
			$rsr  = mysqli_query($conec, $sqlr) or die("Não foi possível acessar os Dados");
			$regsr = mysqli_num_rows($rsr);
			$lnr = mysqli_fetch_array($rsr);
			$Reg     = $lnr['reg'];
			$dtReceb = $lnr['datarec'];

			if ($regsr == 0 or $dtComp <> $dtReceb) {
				$Reg = 0;
			}
			$Reg  = $Reg + 1;

			// Recebendo o próximo número de registro CI
			$sqlr_ci = "select numdoc from registro where numdoc like 'CI%' order by reg desc";
			$rsr_ci  = mysqli_query($conec, $sqlr_ci) or die(" Não foi possível acessar os Dados");
			$regsr_ci = mysqli_num_rows($rsr_ci);
			$lnr_ci = mysqli_fetch_array($rsr_ci);
			$UltDoc_ci = $lnr_ci['numdoc'];

			if ($regsr_ci > 0) {
				$codigo_atual = $UltDoc_ci;
				$prefixo = substr($codigo_atual, 0, 2); // "CI"
				$numero = substr($codigo_atual, 2); // "222000"
				$novo_numero = intval($numero) + 1; // 222001
				$UltDoc_ci = $prefixo . str_pad($novo_numero, strlen($numero), '0', STR_PAD_LEFT);
				//echo $UltDoc_ci; // CI222001

			}

			// Recebendo o próximo número de registro Material de Consumo
			$sql_mc = "select numdoc from registro where numdoc like 'MC%' order by reg desc";
			$rsr  = mysqli_query($conec, $sql_mc) or die(" Não foi possível acessar os Dados");
			$regsr_mc = mysqli_num_rows($rsr);
			$lnr_mc = mysqli_fetch_array($rsr);
			$UltDoc_mc = $lnr_mc['numdoc'];

			if ($regsr_mc > 0) {
				$codigo_atual = $UltDoc_mc;
				$prefixo = substr($codigo_atual, 0, 2); // "MC"
				$numero = substr($codigo_atual, 2); // "222000"
				$novo_numero = intval($numero) + 1; // 222001
				$UltDoc_mc = $prefixo . str_pad($novo_numero, strlen($numero), '0', STR_PAD_LEFT);
				//echo $UltDoc_mc; // MC222001

			}

			// Recebendo o próximo número de registro Material de Divulgação
			$sqlr_md = "select numdoc from registro where numdoc like 'MD%' order by reg desc";
			$rsr  = mysqli_query($conec, $sqlr_md) or die(" Não foi possível acessar os Dados");
			$regsr_md = mysqli_num_rows($rsr);
			$lnr_md = mysqli_fetch_array($rsr);
			$UltDoc_md = $lnr_md['numdoc'];

			if ($regsr_md > 0) {
				$codigo_atual = $UltDoc_md;
				$prefixo = substr($codigo_atual, 0, 2); // "MD"
				$numero = substr($codigo_atual, 2); // "222000"
				$novo_numero = intval($numero) + 1; // 222001
				$UltDoc_md = $prefixo . str_pad($novo_numero, strlen($numero), '0', STR_PAD_LEFT);
				//echo $UltDoc_md; // MD222001
			}

			// Recebendo o próximo número de registro Material de Produção
			$sqlr_mp = "select numdoc from registro where numdoc like 'MP%' order by reg desc";
			$rsr_mp  = mysqli_query($conec, $sqlr_mp) or die(" Não foi possível acessar os Dados");
			$regsr_mp = mysqli_num_rows($rsr_mp);
			$lnr_mp = mysqli_fetch_array($rsr_mp);
			$UltDoc_mp = $lnr_mp['numdoc'];

			if ($regsr_mp > 0) {
				$codigo_atual = $UltDoc_mp;
				$prefixo = substr($codigo_atual, 0, 2); // "MP"
				$numero = substr($codigo_atual, 2); // "222000"
				$novo_numero = intval($numero) + 1; // 222001
				$UltDoc_mp = $prefixo . str_pad($novo_numero, strlen($numero), '0', STR_PAD_LEFT);
				//echo $UltDoc_mp; // MP222001

			}

			// Condições para atribuir o número do documento correto
			if ($TipoDesp == '1' or $TipoDesp == '5') {

				$sqlGr = "insert into registro values($Reg, '$UltDoc_ci', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$Valor', '$Mat', '', '$mat_vend', '$colab', '$Cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados");
			}

			if ($TipoDesp == '2') {

				$sqlGr = "insert into registro values($Reg, '$UltDoc_mc', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$Valor', '$Mat', '', '$mat_vend', '$colab', '$Cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados");
			}

			if ($TipoDesp == '3') {

				$sqlGr = "insert into registro values($Reg, '$UltDoc_md', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$Valor', '$Mat', '', '$mat_vend', '$colab', '$Cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados");
			}

			if ($TipoDesp == '4') {

				$sqlGr = "insert into registro values($Reg, '$UltDoc_mp', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$Valor', '$Mat', '', '$mat_vend', '$colab', '$Cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados");
			}

			// Preparando a Via Cliente 
	?>
			<form name="geraprod" method="post" action="via1newpag.php">
				<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
				<input type="hidden" name="txtsen" value="<?php echo $PC; ?>">
				<input type="hidden" name="txtreg" value="<?php echo $Reg; ?>">
				<input type="hidden" name="txtcod" value="<?php echo $Cod; ?>">
				<input type="hidden" name="txtcod2" value="<?php echo $Cod2; ?>">
				<input type="hidden" name="tiporec" value="<?php echo $TipoRec; ?>">
				<input type="hidden" name="formapag" value="<?php echo $FPag; ?>">
				<input type="hidden" name="dtrec" value="<?php echo $dtRec; ?>">
				<input type="hidden" name="txthora" value="<?php echo $hora; ?>">
				<input type="hidden" name="txtvalor" value="<?php echo $Valor; ?>">
				<input type="hidden" name="txtvalor_ext" value="<?php echo $Valor_ext; ?>">
				<input type="hidden" name="txttipodesp" value="<?php echo $TipoDesp; ?>">
				<input type="hidden" name="tiporef" value="<?php echo $TipoRef; ?>">
				<input type="hidden" name="txtmat" value="<?php echo $Mat; ?>"><br>
				<input type="hidden" name="mat_vend" value="<?php echo $mat_vend; ?>">
				<input type="hidden" name="ultdoc_ci" value="<?php echo $UltDoc_ci; ?>">
				<input type="hidden" name="ultdoc_mc" value="<?php echo $UltDoc_mc; ?>">
				<input type="hidden" name="ultdoc_md" value="<?php echo $UltDoc_md; ?>">
				<input type="hidden" name="ultdoc_mp" value="<?php echo $UltDoc_mp; ?>">
				<input type="hidden" name="txtcolab" value="<?php echo $colab; ?>">
				<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
				<p>
					<font size='6'><b>
							<center>Verifique se a impressora do <font color='gold'>
									<blink>Caixa</blink>
									<font color='#FFFFFF'> está ligada e com papel.
										<p>Logo após clique no <font color='gold'>
												<blink>botão abaixo</blink>
												<font color='#FFFFFF'>.</center>
						</b></font>
				</p><br>
				<center>
					<input id="ghost_click" type="submit" name="btimprime" value="Registrar">
				</center><br>
				<center>
					<font color='#FFFFFF' size='3'><span id="msg"></span></font>
				</center>
			</form>
		<?php

		} else {
		?>
			<font size='6'><b>
					<center>Senha <font color='gold'>
							<blink>Incorreta</blink><br>
							<font color='#FFFFFF'>ou<br>
								Usuário <font color='gold'>
									<blink>Não Autorizado</blink>
									<font color="#FFFFFF">!!!</center>
				</b></font><br>
			<center><a href='JavaScript:window.history.back()'><img src='images/voltar.gif'></a></center><br>
	<?php
		}
	}

	// Encerrando a Conexão
	$SisRot = "S-7.3.1.1.1";
	include "rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>