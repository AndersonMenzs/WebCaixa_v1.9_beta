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

	const valor1 = form.txt1.value * 1;
	const valor2 = form.txt2.value * 1;
	const valor3 = form.txt3.value * 1;
	let soma = valor1 + valor2 + valor3;
	const somaFx = soma.toFixed(2);
	soma = parseFloat(somaFx);

	const taxa = form.vlr_unico.value * 1;

	if (taxa !== soma) {
		const diferenca = soma - taxa;
		const msg = diferenca > 0 ?
			"A soma dos valores está MAIOR em R$ " + Math.abs(diferenca).toFixed(2) :
			"A soma dos valores está MENOR em R$ " + Math.abs(diferenca).toFixed(2);
		alert(msg);
		return false;
	}

	let rd_select = "no";
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
}
