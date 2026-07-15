function checkdata() {
	const form = document.parcela;

	// PERGUNTA: É QUITAÇÃO E SOLICITAÇÃO DE BOOK/POSTER?
	/*const response = confirm('Deseja registrar uma QUITAÇÃO com SOLICITAÇÃO de BOOK ou POSTER?');
	
	if (response) {
		// SIM - redireciona para contrparc_solic.php
		form.action = 'contrparc_solic.php';
	} else {
		// NÃO - redireciona para confcntparc.php
		form.action = 'confcntparc.php';
	}*/

	// VALIDAÇÃO 1: Valor da Prestação vazio
	if (form.txtvalor.value == "0" || form.txtvalor.value == "" || form.txtvalor.value.length < 1) {
		alert("Valor da Prestação Está Vazio!!!");
		form.txtvalor.select();
		form.txtvalor.focus();
		return false;
	}

	// VALIDAÇÃO 2: Número da Prestação vazio
	if (form.txtparc.value == "0" || form.txtparc.value == "" || form.txtparc.value.length < 1) {
		alert("Número da Prestação Está Vazio!!!");
		form.txtparc.select();
		form.txtparc.focus();
		return false;
	}

	// VALIDAÇÃO 3: Nenhuma Forma de Pagamento selecionada
	if (form.lsPr1.value == "00" && form.lsPr2.value == "00" && form.lsPr3.value == "00") {
		alert("Nenhuma Forma de Pagamento Selecionada!!!");
		form.txt1.select();
		form.txt1.focus();
		return false;
	}

	// =============================================
	// VALIDAÇÃO 5: Formas de Pagamento Repetidas
	// =============================================
	if (form.lsPr1.value != "00" && (form.lsPr1.value == form.lsPr2.value || form.lsPr1.value == form.lsPr3.value) ||
		form.lsPr2.value != "00" && (form.lsPr2.value == form.lsPr3.value)) {

		alert("Formas de Pagamento Repetidas!!!");

		// --- LIMPEZA DOS CAMPOS PRINCIPAIS ---
		form.txtvalor.value = "";
		form.vlr_recebido.value = "";
		form.txtparc.value = "";
		// ---------------------------------------

		// --- LIMPEZA DOS CAMPOS HIDDEN E SPANS DE PARCELAS ---
		const txtparc_ini = document.getElementById('txtparc_ini');
		const txtparc_ult = document.getElementById('txtparc_ult');
		const parcial = document.getElementById('parcial');

		if (txtparc_ini) txtparc_ini.value = "";
		if (txtparc_ult) txtparc_ult.value = "";
		if (parcial) parcial.value = "";

		const PIni = document.getElementById('PIni');
		const PUlt = document.getElementById('PUlt');
		const Psep = document.getElementById('Psep');
		const Parcial = document.getElementById('Parcial');
		const labelQtdPrestacoes = document.getElementById('labelQtdPrestacoes');
		const labelParcial = document.getElementById('labelParcial');

		if (PIni) PIni.textContent = "";
		if (PUlt) PUlt.textContent = "";
		if (Psep) Psep.style.display = 'none';
		if (Parcial) Parcial.textContent = "";
		if (labelQtdPrestacoes) labelQtdPrestacoes.textContent = "Parcela(s)";
		if (labelParcial) labelParcial.textContent = "Parcial";
		// ---------------------------------------

		// --- LIMPEZA DOS CAMPOS DE FORMAS DE PAGAMENTO ---
		form.txt1.value = "";
		form.txt2.value = "";
		form.txt3.value = "";
		// ---------------------------------------

		// --- LIMPEZA ESPECÍFICA PARA CARTÕES DE CRÉDITO ---
		for (let i = 1; i <= 3; i++) {
			const parcCred = document.getElementById('parc_card_cred_' + i);
			if (parcCred) parcCred.value = "0";

			const tabela = document.getElementById('tb_parc_cred_' + i);
			if (tabela) tabela.style.display = 'none';
		}
		// ------------------------------------------------

		// --- RESET DOS SELECTS DE FORMAS DE PAGAMENTO ---
		form.lsPr1.value = "00";
		form.lsPr2.value = "00";
		form.lsPr3.value = "00";
		// ------------------------------------------------

		// Foco no primeiro campo para recomeçar
		form.txtvalor.focus();
		return false;
	}

	// VALIDAÇÃO 9: Parcelas obrigatórias para cartão de crédito
	for (let i = 1; i <= 3; i++) {
		const lsPr = document.getElementById('lsPr' + i);
		const parcCred = document.getElementById('parc_card_cred_' + i);
		
		if (lsPr && parcCred) {
			// Se a forma de pagamento é cartão de crédito (31)
			if (lsPr.value === '31') {
				// Verifica se a parcela está selecionada (valor diferente de "0")
				if (parcCred.value === '0' || parcCred.value === '') {
					alert("Você deve selecionar o número de parcelas para o CARTÃO CRÉDITO PARCELADO LOJA " + i + "!");
					parcCred.focus();
					return false;
				}
			}
		}
	}

	// VALIDAÇÃO 6: Nenhum Valor Informado
	if ((form.txt1.value == "" && form.txt2.value == "" && form.txt3.value == "") ||
		(form.txt1.value == 0 && form.txt2.value == 0 && form.txt3.value == 0)) {
		alert("Nenhum Valor Informado!!!");
		form.txt1.select();
		form.txt1.focus();
		return false;
	}

	// VALIDAÇÃO 7: Forma de Pagamento 1 inválida
	if ((form.lsPr1.value == "00" && (form.txt1.value != "" || form.txt1.value.length > 3)) ||
		(form.lsPr1.value != "00" && (form.txt1.value == "" || form.txt1.value.length < 3))) {
		alert("Forma de Pagamento Inválida!!!");
		form.txt1.select();
		form.txt1.focus();
		return false;
	}

	// VALIDAÇÃO 8: Forma de Pagamento 2 inválida
	if ((form.lsPr2.value == "00" && (form.txt2.value != "" || form.txt2.value.length > 3)) ||
		(form.lsPr2.value != "00" && (form.txt2.value == "" || form.txt2.value.length < 3))) {
		alert("Forma de Pagamento Inválida!!!");
		form.txt2.select();
		form.txt2.focus();
		return false;
	}

	// VALIDAÇÃO 9: Forma de Pagamento 3 inválida
	if ((form.lsPr3.value == "00" && (form.txt3.value != "" || form.txt3.value.length > 3)) ||
		(form.lsPr3.value != "00" && (form.txt3.value == "" || form.txt3.value.length < 3))) {
		alert("Forma de Pagamento Inválida!!!");
		form.txt3.select();
		form.txt3.focus();
		return false;
	}

	// VALIDAÇÃO 10: Soma dos valores
	const valor1 = parseCurrencyToCents(form.txt1.value);
	const valor2 = parseCurrencyToCents(form.txt2.value);
	const valor3 = parseCurrencyToCents(form.txt3.value);
	const soma = valor1 + valor2 + valor3;
	const taxa = parseCurrencyToCents(form.vlr_recebido.value);

	if (taxa !== soma) {
		const diferenca = (soma - taxa) / 100;
		const msg = diferenca > 0 ?
			"A soma dos valores está MAIOR em R$ " + Math.abs(diferenca).toFixed(2).replace('.', ',') :
			"A soma dos valores está MENOR em R$ " + Math.abs(diferenca).toFixed(2).replace('.', ',');
		alert(msg);
		return false;
	}

	const chkQuitacao = document.getElementById('chk_quitacao');
	if (chkQuitacao && chkQuitacao.checked) {
		const qtdeQuitacao = parseInt((document.getElementById('total_parcelas_contrato') || {}).value || '0', 10) || 0;
		const valorQuitacao = parseCurrencyToCents(form.txtvalor.value) * qtdeQuitacao;
		const parcial = parseCurrencyToCents((document.getElementById('parcial') || {}).value || '');

		if (qtdeQuitacao <= 0) {
			alert('Informe a quantidade de prestações a serem quitadas!');
			form.txtparc.focus();
			return false;
		}

		if (taxa !== valorQuitacao || soma !== valorQuitacao) {
			alert('Valor recebido incorreto para quitação.\nO valor correto é R$ ' + formatCentsToBR(valorQuitacao) + '.');
			form.vlr_recebido.focus();
			return false;
		}

		if (parcial > 0) {
			alert('Quitação não pode conter parcial. Ajuste o valor recebido.');
			form.vlr_recebido.focus();
			return false;
		}
	}

	return true;
}

// Função auxiliar para converter para centavos
function parseCurrencyToCents(str) {
	if (!str) return 0;
	str = String(str).trim().replace(/\s+/g, '');
	if (str === '') return 0;

	// Formato brasileiro: 1.234,56
	str = str.replace(/\./g, ''); // remove pontos de milhar
	str = str.replace(',', '.');   // vírgula decimal vira ponto

	const num = parseFloat(str);
	return isNaN(num) ? 0 : Math.round(num * 100);
}

function formatCentsToBR(cents) {
	return (cents / 100).toFixed(2).replace('.', ',');
}
