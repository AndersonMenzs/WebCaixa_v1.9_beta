function checkdata()
  {
   with(document.confentr)
     {
      if (txtsen.value.length != 6 || txtsen.value == '')
	{
	 alert("Senha Incompleta ou Inexistente!!!");
	 txtsen.select();
	 txtsen.focus();
	 return false;
	}
      submit();
     }
  }
