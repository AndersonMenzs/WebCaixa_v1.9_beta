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
       var d0 = senha.substr(0,1);
       var d1 = senha.substr(1,1);
       var d2 = senha.substr(2,1);
       var d3 = senha.substr(3,1);
       var d4 = senha.substr(4,1);
       var d5 = senha.substr(5,1);

       if (d0 >= 0 && d0 <= 9 && d1 >= 0 && d1 <= 9 && d2 >= 0 && d2 <= 9 && d3 >= 0 && d3 <= 9 && d4 >= 0 && d4 <= 9 && d5 >= 0 && d5 <= 9)
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
       var d0 = senha.substr(0,1);
       var d1 = senha.substr(1,1);
       var d2 = senha.substr(2,1);
       var d3 = senha.substr(3,1);
       var d4 = senha.substr(4,1);
       var d5 = senha.substr(5,1);

       if (d0 >= 0 && d0 <= 9 && d1 >= 0 && d1 <= 9 && d2 >= 0 && d2 <= 9 && d3 >= 0 && d3 <= 9 && d4 >= 0 && d4 <= 9 && d5 >= 0 && d5 <= 9)
         {
	 alert("As Senhas precisam conter Letras e Algarismos \n totalizando 6 Dígitos Alfanuméricos");
	 txtcfsen.select();
	 txtcfsen.focus();
	 return false;
	 }
       submit();
     }
  }
