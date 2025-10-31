function checkdata() {
	with (document.chaveiro) {
		if (qtde.value == "0" || qtde.value == "" || qtde.value.length < 1) {
			alert("Quantidade Incorreta!!!");
			qtde.select();
			qtde.focus();
			qtde.value = "";
			return false;
		}

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

		const valor1 = txt1.value * 1;
		const valor2 = txt2.value * 1;
		const valor3 = txt3.value * 1;
		let soma = valor1 + valor2 + valor3;
		const somaFx = soma.toFixed(2);
		soma = parseFloat(somaFx);

		const taxa = txtvrchav.value * 1 * qtde.value;

		if (taxa !== soma) {
			const diferenca = soma - taxa;
			const msg = diferenca > 0 ?
				"A soma dos valores está MAIOR em R$ " + Math.abs(diferenca).toFixed(2) :
				"A soma dos valores está MENOR em R$ " + Math.abs(diferenca).toFixed(2);
			alert(msg);
			return false;
		}
		submit();
	}
}
