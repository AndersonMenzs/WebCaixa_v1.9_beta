function checkdata() {
	with (document.taxaProd) {
		if (txtdoc.value == "0" || txtdoc.value == "" || txtdoc.value.length < 1) {
			alert("Número do Documento Incorreto!!!");
			txtdoc.select();
			txtdoc.focus();
			return false;
		}

		var rd_select = "no";
		for (var loop = 0; loop < rdtaxa.length; loop++) {
			if (rdtaxa[1].checked == true) {
				rd_select = "yes";
			}
		}

		if (lsPr1.value == "00" && lsPr2.value == "00" && lsPr3.value == "00" && lsPr4.value == "00") {
			alert("Nenhuma Forma de Pagamento Selecionada!!!");
			txt1.select();
			txt1.focus();
			return false;
		}

		if (lsPr1.value != "00" && (lsPr1.value == lsPr2.value || lsPr1.value == lsPr3.value || lsPr1.value == lsPr4.value) || lsPr2.value != "00" && (lsPr2.value == lsPr3.value || lsPr2.value == lsPr4.value) || lsPr3.value != "00" && (lsPr3.value == lsPr4.value)) {
			alert("Formas de Pagamento Repetidas!!!");
			txt1.select();
			txt1.focus();
			return false;
		}

		if ((txt1.value == "" && txt2.value == "" && txt3.value == "" && txt4.value == "") || (txt1.value == 0 && txt2.value == 0 && txt3.value == 0 && txt4.value == 0)) {
			alert("Nenhum Valor Informado!!!");
			txt1.select();
			txt1.focus();
			return false;
		}

		if ((lsPr1.value == "00" && (txt1.value != "" || txt1.value.length > 3)) || (lsPr1.value != "00" && (txt1.value == "" || txt1.value.length < 3))) {
			alert("Forma de Pagamento Inválida!!!");
			txt1.select();
			txt1.focus();
			return false;
		}

		if ((lsPr2.value == "00" && (txt2.value != "" || txt2.value.length > 3)) || (lsPr2.value != "00" && (txt2.value == "" || txt2.value.length < 3))) {
			alert("Forma de Pagamento Inválida!!!");
			txt2.select();
			txt2.focus();
			return false;
		}

		if ((lsPr3.value == "00" && (txt3.value != "" || txt3.value.length > 3)) || (lsPr3.value != "00" && (txt3.value == "" || txt3.value.length < 3))) {
			alert("Forma de Pagamento Inválida!!!");
			txt3.select();
			txt3.focus();
			return false;
		}

		if ((lsPr4.value == "00" && (txt4.value != "" || txt4.value.length > 3)) || (lsPr4.value != "00" && (txt4.value == "" || txt4.value.length < 3))) {
			alert("Forma de Pagamento Inválida!!!");
			txt4.select();
			txt4.focus();
			return false;
		}

		var vlrUnico = parseFloat(document.taxaProd.vlr_unico.value.replace('.', '').replace(',', '.')) || 0;
		var v1 = parseFloat(document.taxaProd.txt1.value.replace('.', '').replace(',', '.')) || 0;
		var v2 = parseFloat(document.taxaProd.txt2.value.replace('.', '').replace(',', '.')) || 0;
		var v3 = parseFloat(document.taxaProd.txt3.value.replace('.', '').replace(',', '.')) || 0;
		var soma = v1 + v2 + v3;

		// Arredonda para duas casas decimais
		vlrUnico = Math.round(vlrUnico * 100) / 100;
		soma = Math.round(soma * 100) / 100;

		if (vlrUnico > 0 && soma !== vlrUnico) {
			var diferenca = soma - vlrUnico;
			var msg = diferenca > 0 ?
				"A soma dos valores está MAIOR em R$ " + Math.abs(diferenca).toFixed(2) :
				"A soma dos valores está MENOR em R$ " + Math.abs(diferenca).toFixed(2);
			alert(msg);
			return false;
		}

		var valor1 = txt1.value * 1;
		var valor2 = txt2.value * 1;
		var valor3 = txt3.value * 1;
		var valor4 = txt4.value * 1;
		var soma = valor1 + valor2 + valor3 + valor4;
		var somaFx = soma.toFixed(2);
		soma = parseFloat(somaFx);

		var taxaAnt = txtAP.value * 1;
		var taxaProd = txtvrprod.value * 1;

		if (rd_select == "yes" && taxaAnt != soma && taxaProd != soma) {
			alert("Valor da Amizade Premiada Incorreto!!!");
			txt1.select();
			txt1.focus();
			return false;
		}

		if (rd_select == "no" && taxaProd != soma) {
			alert("Valor da Taxa Incorreto!!!");
			txt1.select();
			txt1.focus();
			return false;
		}
		submit();
	}
}
