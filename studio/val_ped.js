function checkdata()
  {
   with(document.frmest)
     {
	 if (txtaut.value == "0" || txtaut.value == "" || txtaut.value.length < 1)
	   {
	    alert("Número da Autenticação Incorreto!!!");
	    txtaut.select();
	    txtaut.focus();
	    return false;
	    }

      var rd_select = "no";
      for (var loop = 0; loop < rdopt.length; loop++)
	 {
	  if (rdopt[loop].checked == true)
	    {
	     rd_select = "yes";
	    }
	 }
      if (rd_select == "no")
	{
	 alert ("Voce precisa selecionar uma Opção!");
	 return false;
	}
      submit();
     }
  }
