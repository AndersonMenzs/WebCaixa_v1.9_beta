function checkdata() {
	const form = document.parcela;

	if (form.txtvalor.value > form.vlr_recebido.value) {
		alert("Valor da Prestação não pode ser maior que o Valor Recebido!!!");
		form.txtvalor.select();
		form.txtvalor.focus();
		return false;
	}

	if (form.txtvalor.value == "0" || form.txtvalor.value == "" || form.txtvalor.value.length < 1) {
		alert("Valor da Prestação Está Vazio!!!");
		form.txtvalor.select();
		form.txtvalor.focus();
		return false;
	}

	if (form.txtparc.value == "0" || form.txtparc.value == "" || form.txtparc.value.length < 1) {
		alert("Número da Prestação Está Vazio!!!");
		form.txtparc.select();
		form.txtparc.focus();
		return false;
	}

	/*if (form.txtnparc.value == "0" || form.txtnparc.value == "" || form.txtnparc.value.length < 1) {
		alert("Quantidade da Prestações Recebidas Está Vazio!!!");
		form.txtnparc.select();
		form.txtnparc.focus();
		return false;
	}*/

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

	const valor1 = form.txt1.value * 1;
	const valor2 = form.txt2.value * 1;
	const valor3 = form.txt3.value * 1;
	let soma = valor1 + valor2 + valor3;
	const somaFx = soma.toFixed(2);
	soma = parseFloat(somaFx);

	const taxa = form.vlr_recebido.value * 1;

	if (taxa !== soma) {
		const diferenca = soma - taxa;
		const msg = diferenca > 0 ?
			"A soma dos valores está MAIOR em R$ " + Math.abs(diferenca).toFixed(2) :
			"A soma dos valores está MENOR em R$ " + Math.abs(diferenca).toFixed(2);
		alert(msg);
		return false;
	}

	let rd_select = "no";
	for (var loop = 0; loop < rdaut.length; loop++) {
		if (rdaut[loop].checked == true) {
			rd_select = "yes";
		}
	}
	if (rd_select == "no") {
		alert("Voce precisa selecionar\n \"Carnê\" ou \"Avulso\"");
		return false;
	}
	form.submit();
}

function parseCurrencyToCents(str){
    if (!str) return 0;
    str = String(str).trim();
    if (str === '') return 0;
    // remove espaços
    str = str.replace(/\s+/g, '');

    var lastDot = str.lastIndexOf('.');
    var lastComma = str.lastIndexOf(',');
    var decimalSep = null;

    if (lastDot > -1 && lastComma > -1) {
        // quem vem por último é o separador decimal
        decimalSep = (lastDot > lastComma) ? '.' : ',';
    } else if (lastDot > -1) {
        // se houver um '.' e tiver exatamente 2 casas depois, trata como decimal
        decimalSep = (str.length - lastDot - 1 === 2) ? '.' : null;
    } else if (lastComma > -1) {
        decimalSep = (str.length - lastComma - 1 === 2) ? ',' : null;
    }

    if (decimalSep) {
        // remove o separador de milhares (o outro caractere) e transforma decimal em ponto
        if (decimalSep === ',') {
            str = str.replace(/\./g, ''); // remove pontos milhares
            str = str.replace(',', '.');  // vírgula -> ponto decimal
        } else { // decimalSep === '.'
            str = str.replace(/,/g, '');  // remove vírgulas milhares
            // ponto já é decimal
        }
    } else {
        // sem separador decimal claro: remove tudo que não é dígito
        str = str.replace(/[^\d]/g, '');
        // tratar como inteiro (centavos implícitos)
        var n = parseInt(str || '0', 10);
        return isNaN(n) ? 0 : n; // já em centavos se você digitar 100 => 100 centavos
    }

    var f = parseFloat(str);
    if (isNaN(f)) return 0;
    return Math.round(f * 100);
}
