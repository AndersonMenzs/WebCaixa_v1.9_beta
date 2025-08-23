function checkdata()
  {
   with(document.cntentr)
     {
	 if (txtdoc.value == "0" || txtdoc.value == "" || txtdoc.value.length < 1)
	   {
	    alert("Número do Documento Incorreto!!!");
	    txtdoc.select();
	    txtdoc.focus();
	    return false;
	    }
	 if (txtvalor.value <= "0" || txtvalor.value.length < 3)
	   {
	    alert("Valor Incorreto!!!");
	    txtvalor.select();
	    txtvalor.focus();
	    return false;
	    }
	 if (lsPr.value == "00")
	   {
	    alert("Selecione uma forma de Pagamento!!!");
	    return false;
	    }
      submit();
     }
  }
