function checkdados()
  {
   with(document.frmcnt)
     {
      var data = new Date();
      var dia = data.getDate();
      var mes = data.getMonth() + 1;
      var ano = data.getYear();
	if (ano < 1900)
	  {
	   ano = ano + 1900;
	  }

      var txtDiae = txtdata.value.substr(0,2);
      var txtMese = txtdata.value.substr(3,2);
      var txtAnoe = txtdata.value.substr(6,4);

      if (txtdata.value.length != 10 || txtdata.value == "00/00/0000")
	{
	 alert("Data da Consultada Incorreta!");
	 txtdata.value = "";
	 txtdata.select();
	 return false;
	}
      if (txtdata.value.substr(2,1) != "/" || txtdata.value.substr(5,1) != "/")
	{
	 alert("Data da Consultada Incorreta!");
	 txtdata.value = "";
	 txtdata.select();
	 return false;
	}
      if (txtdata.value.substr(0,1) == "/" || txtdata.value.substr(1,1) == "/" || txtdata.value.substr(3,1) == "/" || txtdata.value.substr(4,1) == "/" || txtdata.value.substr(6,1) == "/" || txtdata.value.substr(7,1) == "/" || txtdata.value.substr(8,1) == "/" || txtdata.value.substr(9,1) == "/")
	{
	 alert("Data da Consultada Incorreta!");
	 txtdata.value = "";
	 txtdata.select();
	 return false;
	}
      if (txtAnoe < ano -1 || txtAnoe > ano)
	{
	 alert("Data da Consultada Incorreta!");
	 txtdata.value = "";
	 txtdata.select();
	 return false;
	}
      if (txtAnoe == ano && txtMese > mes)
	{
	 alert("Data da Consultada Incorreta!");
	 txtdata.value = "";
	 txtdata.select();
	 return false;
	}
      if (txtAnoe == ano && txtMese == mes && txtDiae > dia)
	{
	 alert("Data da Consultada Incorreta!");
	 txtdata.value = "";
	 txtdata.select();
	 return false;
	}
      if (txtMese < 1 || txtMese > 12)
	{
	 alert("Data da Consultada Incorreta!");
	 txtdata.value = "";
	 txtdata.select();
	 return false;
	}
      if ((txtMese == 1 || txtMese == 3 || txtMese == 5 || txtMese == 7 || txtMese == 8 || txtMese == 10 || txtMese == 12) && (txtDiae < 1 || txtDiae > 31))
	{
	 alert("Data da Consultada Incorreta!");
	 txtdata.value = "";
	 txtdata.select();
	 return false;
	}
      if ((txtMese == 4 || txtMese == 6 || txtMese == 9 || txtMese == 11) && (txtDiae < 1 || txtDiae > 30))
	{
	 alert("Data da Consultada Incorreta!");
	 txtdata.value = "";
	 txtdata.select();
	 return false;
	}
      if ((txtMese == 2 && txtAnoe % 4 == 0) && (txtDiae < 1 || txtDiae > 29))
	{
	 alert("Data da Consultada Incorreta!");
	 txtdata.value = "";
	 txtdata.select();
	 return false;
	}
      if ((txtMese == 2 && txtAnoe % 4 != 0) && (txtDiae < 1 || txtDiae > 28))
	{
	 alert("Data da Consultada Incorreta!");
	 txtdata.value = "";
	 txtdata.select();
	 return false;
	}

	 submit();
     }
  }
