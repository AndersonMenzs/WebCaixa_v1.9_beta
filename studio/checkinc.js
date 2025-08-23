function checkop()
  {
   with(document.cadop)
     {

      if (txtcpf.value == "" || txtcpf.value == 0 || txtcpf.value.length < 14)
	{
	 alert("O CPF precisa conter 11 Dígitos Numéricos");
	 txtcpf.value = "";
	 txtcpf.select();
	 txtcpf.focus();
	 return false;
	}

      if (txtcpf.value.substr(3,1) != "." || txtcpf.value.substr(7,1) != "." || txtcpf.value.substr(11,1) != "-")
	{
	 txtcpf.value = "";
	 alert("CPF Incorreto!");
	 txtcpf.select();
	 return false;
	}

      if (txtcpf.value.substr(0,1) == "." || txtcpf.value.substr(1,1) == "." || txtcpf.value.substr(2,1) == "." || txtcpf.value.substr(4,1) == "." || txtcpf.value.substr(5,1) == "." || txtcpf.value.substr(6,1) == "." || txtcpf.value.substr(8,1) == "." || txtcpf.value.substr(9,1) == "." || txtcpf.value.substr(10,1) == "." || txtcpf.value.substr(12,1) == "-" || txtcpf.value.substr(13,1) == "-")
	{
	 txtcpf.value = "";
	 alert("CPF Incorreto!");
	 txtcpf.select();
	 return false;
	}

      var cn = txtcpf.value;

      var cn0  = cn.substr(0,1)  * 10;
      var cn1  = cn.substr(1,1)  * 9;
      var cn2  = cn.substr(2,1)  * 8;
      var cn4  = cn.substr(4,1)  * 7;
      var cn5  = cn.substr(5,1)  * 6;
      var cn6  = cn.substr(6,1)  * 5;
      var cn8  = cn.substr(8,1)  * 4;
      var cn9  = cn.substr(9,1)  * 3;
      var cn10 = cn.substr(10,1) * 2;
      var dig1 = cn.substr(12,1);
      var dig2 = cn.substr(13,1);
      var soma = cn0+cn1+cn2+cn4+cn5+cn6+cn8+cn9+cn10;
      var dv1  = soma%11;
	if (dv1 == 0 || dv1 == 1)
	  {
	   dv1 = 0;
	  }
	   else
	       {
		dv1 = 11 - dv1;
	       }

      var cp  = txtcpf.value;
      var cp0 = cp.substr(0,1)  * 11;
      var cp1 = cp.substr(1,1)  * 10;
      var cp2 = cp.substr(2,1)  * 9;
      var cp4 = cp.substr(4,1)  * 8;
      var cp5 = cp.substr(5,1)  * 7;
      var cp6 = cp.substr(6,1)  * 6;
      var cp8 = cp.substr(8,1)  * 5;
      var cp9 = cp.substr(9,1)  * 4;
      var cp10= cp.substr(10,1) * 3;
      var cp12= cp.substr(12,1) * 2;
      soma = cp0+cp1+cp2+cp4+cp5+cp6+cp8+cp9+cp10+cp12;
      var dv2  = soma%11;
	if (dv2 == 0 || dv2 == 1)
	  {
	   dv2 = 0;
	  }
	   else
	       {
		dv2 = 11 - dv2;
	       }
      if (dig1 != dv1 || dig2 != dv2)
	{
	 alert("CPF Incorreto!");
	 txtcpf.value = "";
	 txtcpf.select();
	 return false;
	}

      if (txtnome.value == "" || txtnome.value == " " || txtnome.value.length < 5)
	{
	 alert("Campo Nome Muito Curto ou Incorreto!");
	 txtnome.value = "";
	 txtnome.select();
	 txtnome.focus();
	 return false; 
	}

      if (txtape.value == "" || txtape.value == " " || txtape.value.length < 3)
	{
	 alert("Campo Apelido Incorreto!");
	 txtape.value = "";
	 txtape.select();
	 txtape.focus();
	 return false; 
	}
      submit();
     }
  }
