function checkdata()
  {
   with(document.senhalt)
     {
      if (txtoldsen.value.length < 5)
	{
	 alert("Senha Anterior Incorreta");
	 txtoldsen.select();
	 txtoldsen.focus();
	 return false;
	 }

      if (txtnvsen.value.length < 6 || txtcfsen.value.length < 6)
	{
	 alert("As Senhas precisam conter Letras e Algarismos \n totalizando 6 Dígitos Alfanuméricos");
	 txtnvsen.select();
	 txtnvsen.focus();
	 return false;
	 }

       var senha = txtnvsen.value;

       if (!/[a-zA-Z]/.test(senha) || !/[0-9]/.test(senha))
         {
	 alert("As Senhas precisam conter Letras e Algarismos \n totalizando 6 Dígitos Alfanuméricos");
	 txtnvsen.select();
	 txtnvsen.focus();
	 return false;
	 }
	 
      if (txtcfsen.value.length < 6 || txtcfsen.value.length < 6)
	{
	 alert("As Senhas precisam conter Letras e Algarismos \n totalizando 6 Dígitos Alfanuméricos");
	 txtcfsen.select();
	 txtcfsen.focus();
	 return false;
	 }

       var senha = txtcfsen.value;

       if (!/[a-zA-Z]/.test(senha) || !/[0-9]/.test(senha))
         {
	 alert("As Senhas precisam conter Letras e Algarismos \n totalizando 6 Dígitos Alfanuméricos");
	 txtcfsen.select();
	 txtcfsen.focus();
	 return false;
	 }

       if (txtnvsen.value != txtcfsen.value)
         {
	 alert("As Senhas Não Conferem.");
	 txtcfsen.select();
	 txtcfsen.focus();
	 return false;
	 }
       submit();
     }
  }
