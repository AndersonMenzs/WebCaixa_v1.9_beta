function checkdata()
  {
   with(document.parcela)
     {
	 if (txtdoc.value == "0" || txtdoc.value == "" || txtdoc.value.length < 1)
	   {
	    alert("Número do Documento Incorreto!!!");
	    txtdoc.select();
	    txtdoc.focus();
	    return false;
	    }
	 if (txtparc.value == "0" || txtparc.value == "")
	   {
	    alert("Número da Prestação Incorreto!!!");
	    txtparc.select();
	    txtparc.focus();
	    return false;
	    }
	 if (txtnparc.value == "0" || txtnparc.value == "")
	   {
	    alert("Quantidade de Parcelas Incorreto!!!");
	    txtnparc.select();
	    txtnparc.focus();
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
      for (var loop = 0; loop < rdaut.length; loop++)
	 {
	  if (rdaut[loop].checked == true)
	    {
	     rd_select = "yes";
	    }
	 }
      if (rd_select == "no")
	{
	 alert ("Voce precisa selecionar\n \"Carnê\" ou \"Avulso\"");
	 return false;
	}
      submit();
     }
  }
