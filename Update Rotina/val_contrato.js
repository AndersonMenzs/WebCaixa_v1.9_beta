function checkdata() {
	with (document.cntentr) {
		if (txtdoc.value == "0" || txtdoc.value == "" || txtdoc.value.length < 1) {
			alert("Número do Documento Incorreto!!!");
			txtdoc.select();
			txtdoc.focus();
			return false;
		}

		if (vlr_unico.value <= "0" || vlr_unico.value.length < 3) {
			alert("Insira o Valor Total!!!");
			vlr_unico.select();
			vlr_unico.focus();
			return false;
		}

		if (lsPr1.value == "00" && lsPr2.value == "00" && lsPr3.value == "00") {
			alert("Nenhuma Forma de Pagamento Selecionada!!!");
			txtvalor1.select();
			txtvalor1.focus();
			return false;
		}

		if (lsPr1.value != "00" && (lsPr1.value == lsPr2.value || lsPr1.value == lsPr3.value) || lsPr2.value != "00" && (lsPr2.value == lsPr3.value)) {
			alert("Formas de Pagamento Repetidas!!!");
			txtvalor1.select();
			txtvalor1.focus();
			return false;
		}

		if ((txtvalor1.value == "" && txtvalor2.value == "" && txtvalor3.value == "") || (txtvalor1.value == 0 && txtvalor2.value == 0 && txtvalor3.value == 0)) {
			alert("Nenhum Valor Informado!!!");
			txtvalor1.select();
			txtvalor1.focus();
			return false;
		}

		if ((lsPr1.value == "00" && (txtvalor1.value != "" || txtvalor1.value.length > 3)) || (lsPr1.value != "00" && (txtvalor1.value == "" || txtvalor1.value.length < 3))) {
			alert("Forma de Pagamento Inválida!!!");
			txtvalor1.select();
			txtvalor1.focus();
			return false;
		}

		if ((lsPr2.value == "00" && (txtvalor2.value != "" || txtvalor2.value.length > 3)) || (lsPr2.value != "00" && (txtvalor2.value == "" || txtvalor2.value.length < 3))) {
			alert("Forma de Pagamento Inválida!!!");
			txtvalor2.select();
			txtvalor2.focus();
			return false;
		}

		if ((lsPr3.value == "00" && (txtvalor3.value != "" || txtvalor3.value.length > 3)) || (lsPr3.value != "00" && (txtvalor3.value == "" || txtvalor3.value.length < 3))) {
			alert("Forma de Pagamento Inválida!!!");
			txtvalor3.select();
			txtvalor3.focus();
			return false;
		}

		var valor1 = txtvalor1.value * 1;
		var valor2 = txtvalor2.value * 1;
		var valor3 = txtvalor3.value * 1;
		var soma = valor1 + valor2 + valor3
		var somaFx = soma.toFixed(2);
		soma = parseFloat(somaFx);

		var taxa = vlr_unico.value * 1;

		if (taxa !== soma) {
			var diferenca = soma - taxa;
			var msg = diferenca > 0 ?
				"A soma dos valores está MAIOR em R$ " + Math.abs(diferenca).toFixed(2) :
				"A soma dos valores está MENOR em R$ " + Math.abs(diferenca).toFixed(2);
			alert(msg);
			return false;
		}
		submit();
	}
}
