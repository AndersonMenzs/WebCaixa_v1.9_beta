function checkdata() {
	with (document.taxaConc) {
		if (lsPr1.value == "00" && lsPr2.value == "00" && lsPr3.value == "00") {
			alert("Nenhuma Forma de Pagamento Selecionada!!!");
			txt1.select();
			txt1.focus();
			return false;
		}

		if (lsPr1.value != "00" && (lsPr1.value == lsPr2.value || lsPr1.value == lsPr3.value) || lsPr2.value != "00" && (lsPr2.value == lsPr3.value)) {
			alert("Formas de Pagamento Repetidas!!!");
			txt1.select();
			txt1.focus();
			return false;
		}

		if ((txt1.value == "" && txt2.value == "" && txt3.value == "") || (txt1.value == 0 && txt2.value == 0 && txt3.value == 0)) {
			alert("Nenhum Valor Informado!!!");
			txt1.select();
			txt1.focus();
			return false;
		}

		if ((lsPr1.value == "00" && (txt1.value != "" || txt1.value.length > 3)) || (lsPr1.value != "00" && (txt1.value == "" || txt1.value.length < 3))) {
			alert("Forma de Pagamento Inválida1!!!");
			txt1.select();
			txt1.focus();
			return false;
		}

		if ((lsPr2.value == "00" && (txt2.value != "" || txt2.value.length > 3)) || (lsPr2.value != "00" && (txt2.value == "" || txt2.value.length < 3))) {
			alert("Forma de Pagamento Inválida2!!!");
			txt2.select();
			txt2.focus();
			return false;
		}

		if ((lsPr3.value == "00" && (txt3.value != "" || txt3.value.length > 3)) || (lsPr3.value != "00" && (txt3.value == "" || txt3.value.length < 3))) {
			alert("Forma de Pagamento Inválida3!!!");
			txt3.select();
			txt3.focus();
			return false;
		}

		var valor1 = txt1.value * 1;
		var valor2 = txt2.value * 1;
		var valor3 = txt3.value * 1;
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
