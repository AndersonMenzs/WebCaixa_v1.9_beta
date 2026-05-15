function checkdata()
  {
   with(document.Form)
     {
      var data = new Date();
      var dia = data.getDate();
      var mes = data.getMonth() + 1;
      var ano = data.getYear() + 1900;

      var DiaInc = txtdtinc.value.substr(0,2);
      var MesInc = txtdtinc.value.substr(3,2);
      var AnoInc = txtdtinc.value.substr(6,4);
      if (txtdtinc.value == "" || txtdtinc.value == " " || txtdtinc.value.length != 10)
	{
	 alert("Data de Inclusão Incorreta!");
	 txtdtinc.select();
	 txtdtinc.focus();
	 return false;
	}

      if (AnoInc == "" || AnoInc > ano)
	{
	 alert("Data de Inclusão Incorreta!");
	 txtdtinc.select();
	 txtdtinc.focus();
	 return false;
	}

      if (AnoInc == ano && MesInc > mes)
	{
	 alert("Data de Inclusão Incorreta!");
	 txtdtinc.select();
	 txtdtinc.focus();
	 return false;
	}
      if (AnoInc == ano && MesInc == mes && DiaInc > dia)
	{
	 alert("Data de Inclusão Incorreta!");
	 txtdtinc.select();
	 txtdtinc.focus();
	 return false;
	}
      if (MesInc < 1 || MesInc > 12)
	{
	 alert("Data de Inclusão Incorreta!");
	 txtdtinc.select();
	 txtdtinc.focus();
	 return false;
	}
      if ((MesInc == 1 || MesInc == 3 || MesInc == 5 || MesInc == 7 || MesInc == 8 || MesInc == 10 || MesInc == 12) && (DiaInc < 1 || DiaInc > 31))
	{
	 alert("Data de Inclusão Incorreta!");
	 txtdtinc.select();
	 txtdtinc.focus();
	 return false;
	}
      if ((MesInc == 4 || MesInc == 6 || MesInc == 9 || MesInc == 11) && (DiaInc < 1 || DiaInc > 30))
	{
	 alert("Data de Inclusão Incorreta!");
	 txtdtinc.select();
	 txtdtinc.focus();
	 return false;
	}
      if ((MesInc == 2 && AnoInc % 4 == 0) && (DiaInc < 1 || DiaInc > 29))
	{
	 alert("Data de Inclusão Incorreta!");
	 txtdtinc.select();
	 txtdtinc.focus();
	 return false;
	}
      if ((MesInc == 2 && AnoInc % 4 != 0) && (DiaInc < 1 || DiaInc > 28))
	{
	 alert("Data de Inclusão Incorreta!");
	 txtdtinc.select();
	 txtdtinc.focus();
	 return false;
	}
      submit();
     }
  }
