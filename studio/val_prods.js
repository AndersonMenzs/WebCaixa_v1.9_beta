function checkdata() {
	const form = document.prods;

	if (form.vlr_unico.value == "0" || form.vlr_unico.value == "" || form.vlr_unico.value.length < 1) {
		alert("Valor do Produto Vazio!!!");
		form.vlr_unico.select();
		form.vlr_unico.focus();
		return false;
	}

	if (form.lsPr1.value == "00" && form.lsPr2.value == "00" && form.lsPr3.value == "00") {
		alert("Nenhuma Forma de Pagamento Selecionada!!!");
		form.txt1.select();
		form.txt1.focus();
		return false;
	}

	if (form.lsPr1.value != "00" && (form.lsPr1.value == form.lsPr2.value || form.lsPr1.value == form.lsPr3.value) || form.lsPr2.value != "00" && (form.lsPr2.value == form.lsPr3.value)) {
		alert("Formas de Pagamento Repetidas!!!");
		form.txt1.select();
		form.txt1.focus();
		return false;
	}

	if ((form.txt1.value == "" && form.txt2.value == "" && form.txt3.value == "") || (form.txt1.value == 0 && form.txt2.value == 0 && form.txt3.value == 0)) {
		alert("Nenhum Valor Informado!!!");
		form.txt1.select();
		form.txt1.focus();
		return false;
	}

	if ((form.lsPr1.value == "00" && (form.txt1.value != "" || form.txt1.value.length > 3)) || (form.lsPr1.value != "00" && (form.txt1.value == "" || form.txt1.value.length < 3))) {
		alert("Forma de Pagamento Inválida!!!");
		form.txt1.select();
		form.txt1.focus();
		return false;
	}

	if ((form.lsPr2.value == "00" && (form.txt2.value != "" || form.txt2.value.length > 3)) || (form.lsPr2.value != "00" && (form.txt2.value == "" || form.txt2.value.length < 3))) {
		alert("Forma de Pagamento Inválida!!!");
		form.txt2.select();
		form.txt2.focus();
		return false;
	}

	if ((form.lsPr3.value == "00" && (form.txt3.value != "" || form.txt3.value.length > 3)) || (form.lsPr3.value != "00" && (form.txt3.value == "" || form.txt3.value.length < 3))) {
		alert("Forma de Pagamento Inválida!!!");
		form.txt3.select();
		form.txt3.focus();
		return false;
	}

	// =============================================
	// VALIDAÇÃO 5: Formas de Pagamento Repetidas
	// =============================================
	if (form.lsPr1.value != "00" && (form.lsPr1.value == form.lsPr2.value || form.lsPr1.value == form.lsPr3.value) ||
		form.lsPr2.value != "00" && (form.lsPr2.value == form.lsPr3.value)) {

		alert("Formas de Pagamento Repetidas!!!");

		// --- LIMPEZA DOS CAMPOS PRINCIPAIS ---
		form.vlr_unico.value = "";
		//form.vlr_recebido.value = "";
		//form.txtparc.value = "";
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
		form.vlr_unico.focus();
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

	// VALIDAÇÃO 10: Soma dos valores
	const valor1 = parseCurrencyToCents(form.txt1.value);
	const valor2 = parseCurrencyToCents(form.txt2.value);
	const valor3 = parseCurrencyToCents(form.txt3.value);
	const soma = valor1 + valor2 + valor3;
	const taxa = parseCurrencyToCents(form.vlr_unico.value);

	if (taxa !== soma) {
		const diferenca = (soma - taxa) / 100;
		const msg = diferenca > 0 ?
			"A soma dos valores está MAIOR em R$ " + Math.abs(diferenca).toFixed(2).replace('.', ',') :
			"A soma dos valores está MENOR em R$ " + Math.abs(diferenca).toFixed(2).replace('.', ',');
		alert(msg);
		return false;
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

/*	let rd_select = "no";
	for (let loop = 0; loop < form.rdbook.length; loop++) {
		if (form.rdbook[loop].checked == true) {
			rd_select = "yes";
		}
	}
	if (rd_select == "no") {
		alert("Você precisa selecionar \"SIM\" ou \"NÃO.\"");
		return false;
	}
	form.submit();
*/
