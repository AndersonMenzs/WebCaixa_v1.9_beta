function checkdata()
  {
   with(document.chaveiro)
     {
	 if (txtdoc.value == "0" || txtdoc.value == "" || txtdoc.value.length < 1)
	   {
	    alert("Número do Documento Incorreto!!!");
	    txtdoc.select();
	    txtdoc.focus();
	    return false;
	    }

	 if (qtde.value == "0" || qtde.value == "" || qtde.value.length < 1)
	   {
	    alert("Quantidade Incorreta!!!");
	    qtde.select();
	    qtde.focus();
	    qtde.value="";
	    return false;
	    }

	 if (lsPr1.value == "00" && lsPr2.value == "00" && lsPr3.value == "00")
	   {
	    alert("Nenhuma Forma de Pagamento Selecionada!!!");
	    txt1.select();
	    txt1.focus();
	    return false;
	    }

	 if (lsPr1.value != "00" && (lsPr1.value == lsPr2.value || lsPr1.value == lsPr3.value) || lsPr2.value != "00" && (lsPr2.value == lsPr3.value))
	   {
	    alert("Formas de Pagamento Repetidas!!!");
	    txt1.select();
	    txt1.focus();
	    return false;
	   }

	 if ((txt1.value == "" && txt2.value == "" && txt3.value == "") || (txt1.value == 0 && txt2.value == 0 && txt3.value == 0))
	   {
	    alert("Nenhum Valor Informado!!!");
	    txt1.select();
	    txt1.focus();
	    return false;
	    }

	 if ((lsPr1.value == "00" && (txt1.value != "" || txt1.value.length > 3)) || (lsPr1.value != "00" && (txt1.value == "" || txt1.value.length < 3)))
	   {
	    alert("Forma de Pagamento Inválida-1!!!");
	    txt1.select();
	    txt1.focus();
	    txt1.value="";
	    return false;
	    }

	 if ((lsPr2.value == "00" && (txt2.value != "" || txt2.value.length > 3)) || (lsPr2.value != "00" && (txt2.value == "" || txt2.value.length < 3)))
	   {
	    alert("Forma de Pagamento Inválida-2!!!");
	    txt2.select();
	    txt2.focus();
	    txt2.value="";
	    return false;
	    }

	 if ((lsPr3.value == "00" && (txt3.value != "" || txt3.value.length > 3)) || (lsPr3.value != "00" && (txt3.value == "" || txt3.value.length < 3)))
	   {
	    alert("Forma de Pagamento Inválida-3!!!");
	    txt3.select();
	    txt3.focus();
	    txt3.value="";
	    return false;
	    }

	 var valor1 = txt1.value *1;
	 var valor2 = txt2.value *1;
	 var valor3 = txt3.value *1;
	 var soma_erro = valor1 + valor2 + valor3;
	 var soma   = parseFloat(soma_erro.toFixed(2));

	 var taxa_erro   = txtvrchav.value * 1 * qtde.value;
	 var taxa = parseFloat(taxa_erro.toFixed(2));

	 if (taxa != soma)
	   {
	    alert("Valor Incorreto!!!");
	    txt1.select();
	    txt1.focus();
	    return false;
	    }
      submit();
     }
  }
