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
      submit();
     }
  }
