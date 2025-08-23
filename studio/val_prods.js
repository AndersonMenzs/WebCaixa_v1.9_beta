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

      var rd_select = "no";
      for (var loop = 0; loop < rdbook.length; loop++)
	 {
	  if (rdbook[loop].checked == true)
	    {
	     rd_select = "yes";
	    }
	 }
      if (rd_select == "no")
	{
	 alert ("Você precisa selecionar \"SIM\" ou \"NÃO.\"");
	 return false;
	}
      submit();
     }
  }
