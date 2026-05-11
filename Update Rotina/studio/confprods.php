<html>

<head>
	<title>WebCaixa v1.20.3_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-left: 2%;
			margin-right: 2%;
			border: 3px solid gray;
			padding: 10px 10px 10px 10px;
			font-family: sans-serif;
		}

		.campos {
			background-color: #C0C0C0;
			font: 16px sans-serif;
			color: #000000;
		}
	</style>

	<script>
		function putFocus(formInst, elementInst) {
			if (document.forms.length > 0) {
				document.forms[formInst].elements[elementInst].focus();
			}
		}

		function autotab(original, destination) {
			if (original.getAttribute && original.value.length == original.getAttribute("maxlength"))
				destination.focus()
		}

		function validpag(field) {
			var valid = "SN"
			var ok = "yes";
			var temp;
			for (var i = 0; i < field.value.length; i++) {
				temp = "" + field.value.substring(i, i + 1);
				if (valid.indexOf(temp) == "-1") ok = "no";
			}
			if (ok == "no") {
				alert("Entrada Incorreta! \n  Digite apenas \"S\" ou \"N\".");
				field.value = "";
				field.focus();
				field.select();
			}
		}
	</script>

	<script src="val_pgto.js"></script>

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.8.1";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Ref_Std   = trim($_POST['ref_std']);
	$NumDoc    = trim($_POST['txtdoc']);
	$NumDocF = 100000000 + $NumDoc;
	$NDoc      = substr($NumDocF, 1, 8);
	$FPag_1      = trim($_POST['lsPr1']);
	$FPag_2      = trim($_POST['lsPr2']);
	$FPag_3      = trim($_POST['lsPr3']);
	$Mat_Vend = trim($_POST['mat_vend']);
	$Vendedora = trim($_POST['vendedora']);
	$Cliente	= trim($_POST['cliente']);
	$txt1 = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
	$txt2 = isset($_POST['txt2']) ? (float) trim($_POST['txt2']) : 0;
	$txt3 = isset($_POST['txt3']) ? (float) trim($_POST['txt3']) : 0;
	$Valor     = $txt1 + $txt2 + $txt3;
	$ValorF    = number_format($Valor, 2, ",", ".");
	$Book = '';
	$Poster = '';
	$Produto = '';
	$ProdutoK = '';
	$Pct_Prod = '';
	$RdBook = '';
	$RdPoster = '';
	$RdTops = '';
	$RdKit = '';
	$RdProduto = '';
	$TipoTop = isset($_POST['tipo_top']) ? (int) trim($_POST['tipo_top']) : 0;
	$TotalKit = isset($_POST['qtde_tkit_1']) ? (int) trim($_POST['qtde_tkit_1']) : 0;
	$ItensProdutos = array();
	$TopsItens = array();
	$KitItens = array();
	$RadioSelecionado = isset($_POST['rdopt_radio']) ? trim($_POST['rdopt_radio']) : '';

	if ($RadioSelecionado == '' && isset($_POST['rdopt_tops']) && trim($_POST['rdopt_tops']) <> '') {
		$RadioSelecionado = trim($_POST['rdopt_tops']);
	}

	if ($RadioSelecionado == '' && isset($_POST['rdopt_kit']) && trim($_POST['rdopt_kit']) <> '') {
		$RadioSelecionado = trim($_POST['rdopt_kit']);
	}

	if ($RadioSelecionado == '' && isset($_POST['rdopt_produto']) && trim($_POST['rdopt_produto']) <> '') {
		$RadioSelecionado = trim($_POST['rdopt_produto']);
	}

	if (isset($_POST['rdopt_book']) && trim($_POST['rdopt_book']) <> '') {
		$Qtde_Book = isset($_POST['qtde_book']) ? trim($_POST['qtde_book']) : '';
		$Book = isset($_POST['ped_book']) ? trim($_POST['ped_book']) : '';
		$RdBook = 's';
		$ItensProdutos[] = $Qtde_Book . " x " . $Book;
	}

	if (isset($_POST['rdopt_poster']) && trim($_POST['rdopt_poster']) <> '') {
		$Qtde_Poster = isset($_POST['qtde_poster']) ? trim($_POST['qtde_poster']) : '';
		$Poster = isset($_POST['ped_poster']) ? trim($_POST['ped_poster']) : '';
		$RdPoster = 'n';
		$ItensProdutos[] = $Qtde_Poster . " x " . $Poster;
	}

	if ($RadioSelecionado == 'TOPS') {
		$RdTops = 't';
		if ($TipoTop < 1) {
			$TipoTop = 1;
		} elseif ($TipoTop > 10) {
			$TipoTop = 10;
		}

		for ($i = 1; $i <= $TipoTop; $i++) {
			$qtde = isset($_POST['qtde_top' . $i]) ? trim($_POST['qtde_top' . $i]) : '';
			$produtoTop = isset($_POST['ped_top_book' . $i]) ? trim($_POST['ped_top_book' . $i]) : '';

			if ($qtde <> '' && $produtoTop <> '') {
				$TopsItens[$i] = array('qtde' => $qtde, 'produto' => $produtoTop);
				$ItensProdutos[] = $qtde . " x " . $produtoTop;
			}
		}

		if (count($TopsItens) > 0) {
			$ProdutosTop = array();
			foreach ($TopsItens as $itemTop) {
				$ProdutosTop[] = $itemTop['produto'];
			}
			$Produto = implode(", ", $ProdutosTop);
		}
	}

	if ($RadioSelecionado == 'KIT') {
		$RdKit = 'pk';
		if ($TotalKit < 1) {
			$TotalKit = 1;
		} elseif ($TotalKit > 3) {
			$TotalKit = 3;
		}

		for ($i = 1; $i <= $TotalKit; $i++) {
			$qtde = isset($_POST['qtde_kit_' . $i]) ? trim($_POST['qtde_kit_' . $i]) : '';
			$produtoKit = isset($_POST['ped_tkit_' . $i]) ? trim($_POST['ped_tkit_' . $i]) : '';

			if ($qtde <> '' && $produtoKit <> '') {
				$KitItens[$i] = array('qtde' => $qtde, 'produto' => $produtoKit);
				if ($Pct_Prod == '') {
					$Pct_Prod = $produtoKit;
				}
				$ItensProdutos[] = $qtde . " x " . $produtoKit;
			}
		}
	}

	if ($RadioSelecionado == 'PRODUTO') {
		$Qtde_Produto = isset($_POST['qtde_prod']) ? trim($_POST['qtde_prod']) : '';
		$Produto = isset($_POST['ped_prod']) ? trim($_POST['ped_prod']) : '';
		$RdProduto = 'p';
		$ItensProdutos[] = $Qtde_Produto . " x " . $Produto;
	}

	if ($RdKit <> '') {
		$ProdutoK = $Pct_Prod;
	}

	if ($RdBook <> '') {
		$RdTipoProduto = 's';
	} elseif ($RdPoster <> '') {
		$RdTipoProduto = 'n';
	} elseif ($RdKit <> '') {
		$RdTipoProduto = 'pk';
	} else {
		$RdTipoProduto = 'p';
	}

	$Parcelas = trim($_POST['parcelas']);

	include "conexao.php";
	include "dbselect.php";

	// Contando as formas de pagamentos
	$Fspags = 0;

	if ($txt1 <> "") {
		$Fspags = $Fspags + 1;
	}
	if ($txt2 <> "") {
		$Fspags = $Fspags + 1;
	}

	if ($txt3 <> "") {
		$Fspags = $Fspags + 1;
	}

	if ($Fspags == 1) {
		if ($txt1 <> "") {
			$FPag = $FPag_1;
			$sql = "select * from formapag where codpag = '$FPag' ";
			$rs  = mysqli_query($conec, $sql);
			$ln  = mysqli_fetch_array($rs);
			$ModPag = $ln['modpag'];
			$FmRec  = $ln['siglapag'];
			mysqli_free_result($rs);
		} elseif ($txt2 <> "") {
			$FPag = $FPag_2;
			$sql = "select * from formapag where codpag = '$FPag' ";
			$rs  = mysqli_query($conec, $sql);
			$ln  = mysqli_fetch_array($rs);
			$ModPag = $ln['modpag'];
			$FmRec  = $ln['siglapag'];
			mysqli_free_result($rs);
		} elseif ($txt3 <> "") {
			$FPag = $FPag_3;
			$sql = "select * from formapag where codpag = '$FPag' ";
			$rs  = mysqli_query($conec, $sql);
			$ln  = mysqli_fetch_array($rs);
			$ModPag = $ln['modpag'];
			$FmRec  = $ln['siglapag'];
			mysqli_free_result($rs);
		}
	} else {
		$ModPag = "Diversas";
	}

	// Condição para nome em extensão para forma de pagamento
	if ($FmRec == "DIN") {
		$ModPag = "Dinheiro";
	} elseif ($FmRec == "CTD") {
		$ModPag = "Cartão Débito";
	} elseif ($FmRec == "CTV") {
		$ModPag = "Cartão Crédito";
	} elseif ($FmRec == "PXQ") {
		$ModPag = "Pix QR Code";
	} elseif ($FmRec == "PXC") {
		$ModPag = "Pix Cnpj";
	} elseif ($FmRec == "CPL") {
		$ModPag = "Cartão Crédito Parcelado Loja";
	}
	?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>VENDAS À VISTA</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
		<table width="80%" border="5" cellpadding="10" cellspacing="0" align="center">
			<form name="confentr" method="post" action="geraprods.php" onSubmit='JavaScript:return checkdata()'>
				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Documento Nº </i></b></font>
					</td>
					<td width="70%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo $NDoc; ?></i></b></font>
					</td>
				</tr>

				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Valor Pago</i></b></font>
					</td>
					<td width="70%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo "R$ " . $ValorF; ?></i></b></font>
					</td>
				</tr>

				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Forma de Pagamento</i></b></font>
					</td>
					<td width="70%" align="center">
						<font size='5' color='#FFFFFF'>
							<b>
								<i>
									<?php echo $ModPag; ?>
								</i>
							</b>
						</font>
					</td>
				</tr>
				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'>
							<b>
								<i>
									<?php
									// Verifica qual o produto foi escolhido
									if ($RdBook <> '' && $RdPoster <> '') {
										echo "Book e Poster:";
									} elseif ($RdBook <> '') {
										echo "Book:";
									} elseif ($RdPoster <> '') {
										echo "Poster:";
									} elseif ($RdTops <> '') {
										echo "Top's:";
									} elseif ($RdKit <> '') {
										echo "Produtos Kit:";
									} elseif ($RdProduto <> '') {
										echo "Produto:";
									}
									?>
								</i>
							</b>
						</font>
					</td>
					<td width="70%" align="center">
						<font color='#FFFFFF' size='5'><b><i>
									<blink>
										<?php
										echo implode("<br>", $ItensProdutos);
										?></blink>
								</i>
							</b>
						</font>
					</td>
				</tr>
				<tr>
					<td width="30%" align="center">
						<font color='gold' size='5'><b><i>Senha: </i></b></font>
					</td>
					<td width="70%" align="center">
						<input type='password' name='txtsen' size='6' maxlength='6' class="campos">
					</td>
				</tr>

		</table>

		<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
		<input type="hidden" name="ref_std" value="<?php echo $Ref_Std; ?>">
		<input type="hidden" name="txt1" value="<?php echo $txt1; ?>">
		<input type="hidden" name="txt2" value="<?php echo $txt2; ?>">
		<input type="hidden" name="txt3" value="<?php echo $txt3; ?>">
		<input type="hidden" name="txtvalor" value="<?php echo $Valor; ?>">
		<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
		<input type="hidden" name="lsPr1" value="<?php echo $FPag_1; ?>">
		<input type="hidden" name="lsPr2" value="<?php echo $FPag_2; ?>">
		<input type="hidden" name="lsPr3" value="<?php echo $FPag_3; ?>">
		<input type="hidden" name="parcelas" value="<?php echo $Parcelas; ?>">
		<input type="hidden" name="txtmodpag_ext" value="<?php echo $ModPag; ?>">
		<input type="hidden" name="txtmodpag" value="<?php echo $ModPag; ?>">
		<input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
		<input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
		<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
		<input type="hidden" name="qtde_book" value="<?php echo isset($Qtde_Book) ? $Qtde_Book : ''; ?>">
		<input type="hidden" name="pct_book" value="<?php echo $Book; ?>">
		<input type="hidden" name="rdbook" value="<?php echo $RdTipoProduto; ?>">
		<input type="hidden" name="qtde_poster" value="<?php echo isset($Qtde_Poster) ? $Qtde_Poster : ''; ?>">
		<input type="hidden" name="ped_poster" value="<?php echo $Poster; ?>">
		<input type="hidden" name="ped_prod" value="<?php echo $ProdutoK; ?>">
		<input type="hidden" name="qtde_prod" value="<?php echo isset($Qtde_Produto) ? $Qtde_Produto : ''; ?>">
		<input type="hidden" name="prod" value="<?php echo $Produto; ?>">
		<input type="hidden" name="tipo_top" value="<?php echo $TipoTop; ?>">
		<input type="hidden" name="qtde_tkit_1" value="<?php echo $TotalKit; ?>">
		<?php for ($i = 1; $i <= 10; $i++) { ?>
			<input type="hidden" name="qtde_top<?php echo $i; ?>" value="<?php echo isset($TopsItens[$i]) ? $TopsItens[$i]['qtde'] : ''; ?>">
			<input type="hidden" name="ped_top_book<?php echo $i; ?>" value="<?php echo isset($TopsItens[$i]) ? $TopsItens[$i]['produto'] : ''; ?>">
		<?php } ?>
		<?php for ($i = 1; $i <= 3; $i++) { ?>
			<input type="hidden" name="qtde_kit_<?php echo $i; ?>" value="<?php echo isset($KitItens[$i]) ? $KitItens[$i]['qtde'] : ''; ?>">
			<input type="hidden" name="ped_tkit_<?php echo $i; ?>" value="<?php echo isset($KitItens[$i]) ? $KitItens[$i]['produto'] : ''; ?>">
			<input type="hidden" name="ped_prod_<?php echo $i; ?>" value="<?php echo isset($KitItens[$i]) ? $KitItens[$i]['produto'] : ''; ?>">
		<?php } ?>
		<p>
			<center>
				<input id="ghost_click" type="submit" name="btenvia" value="Continuar">
				<input type="button" name="btret" value="Retornar" OnClick="JavaScript:window.history.back()">
			</center>
		</p>
		<center>
			<font color='#FFFFFF' size='3'><span id="msg"></span></font>
		</center>
		</form><?php

			} else { ?>
		<br><br><br><br><br>
		<font size='6'><b>
				<center>Acesso <font color='gold'>
						<blink><u>não Autorizado</u>
						</blink>
						<font color='#FFFFFF'>!!!</center>
			</b></font><br><br><br>
		<center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
			}

			// Encerrando a Conexão
			$SisRot = "S-7.2.8.1";
			include "rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>
