function checkdata()
  {
   with(document.taxaProd)
     {
	 if (txtdoc.value == "0" || txtdoc.value == "" || txtdoc.value.length < 1)
	   {
	    alert("Número do Documento Incorreto!!!");
	    txtdoc.select();
	    txtdoc.focus();
	    return false;
	    }
	 if (txt.value <= "0" || txt.value.length < 3)
	   {
	    alert("Valor Incorreto!!!");
	    txt.select();
	    txt.focus();
	    return false;
	    }
	 if (lsPr1.value == "00")
	   {
	    alert("Selecione uma forma de Pagamento!!!");
	    return false;
	    }
      submit();
     }
  }
