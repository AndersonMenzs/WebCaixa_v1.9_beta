function checkdata()
  {
   with(document.recsenha)
     {
      var cn = txtuser.value;
      var cn1 = 0;
      var cn2 = 0;
      var cn3 = 0;
      var cn4 = 0;
      var cn5 = 0;
      var cn6 = 0;
      var cn7 = 0;
      var dig = 0;

      if (txtuser.value == "" || txtuser.value.length < 2)
	{
	 alert("Matrícula Incorreta!");
	 txtuser.select();
	 return false; 
	}

      if (cn.length == 2)
	{
	 cn1 = cn.substr(0,1) * 2;
	 dig = cn.substr(1,1);
	}
	 else if (cn.length == 3)
		{
		 cn1 = cn.substr(0,1) * 3;
		 cn2 = cn.substr(1,1) * 2;
		 dig = cn.substr(2,1);
		}
	 	 else if (cn.length == 4)
			{
			 cn1 = cn.substr(0,1) * 4;
			 cn2 = cn.substr(1,1) * 3;
			 cn3 = cn.substr(2,1) * 2;
			 dig = cn.substr(3,1);
			}
		 	 else if (cn.length == 5)
				{
				 cn1 = cn.substr(0,1) * 5;
				 cn2 = cn.substr(1,1) * 4;
				 cn3 = cn.substr(2,1) * 3;
				 cn4 = cn.substr(3,1) * 2;
				 dig = cn.substr(4,1);
				}
			 	 else if (cn.length == 6)
					{
					 cn1 = cn.substr(0,1) * 6;
					 cn2 = cn.substr(1,1) * 5;
					 cn3 = cn.substr(2,1) * 4;
					 cn4 = cn.substr(3,1) * 3;
					 cn5 = cn.substr(4,1) * 2;
					 dig = cn.substr(5,1);
					}
				 	 else if (cn.length == 7)
						{
						 cn1 = cn.substr(0,1) * 7;
						 cn2 = cn.substr(1,1) * 6;
						 cn3 = cn.substr(2,1) * 5;
						 cn4 = cn.substr(3,1) * 4;
						 cn5 = cn.substr(4,1) * 3;
						 cn6 = cn.substr(5,1) * 2;
						 dig = cn.substr(6,1);
						}
				 	 else if (cn.length == 8)
						{
						 cn1 = cn.substr(0,1) * 8;
						 cn2 = cn.substr(1,1) * 7;
						 cn3 = cn.substr(2,1) * 6;
						 cn4 = cn.substr(3,1) * 5;
						 cn5 = cn.substr(4,1) * 4;
						 cn6 = cn.substr(5,1) * 3;
						 cn7 = cn.substr(6,1) * 2;
						 dig = cn.substr(7,1);
						}
      var soma = cn1+cn2+cn3+cn4+cn5+cn6+cn7;
      var dv  = soma%10;
	if (dv  != dig)
	  {
	   alert("Matrícula ou Dígito Incorreto");
	   txtuser.select();
	   txtuser.focus();
	   return false;
	  }


      if (txtcpf.value == "" || txtcpf.value == 0 || txtcpf.value.length != 11)
	{
	 alert("O CPF precisa conter 11 Dígitos Numéricos");
	 txtcpf.value = "";
	 txtcpf.select();
	 txtcpf.focus();
	 return false;
	}

      var cn = txtcpf.value;

      var cn0  = cn.substr(0,1)  * 10;
      var cn1  = cn.substr(1,1)  * 9;
      var cn2  = cn.substr(2,1)  * 8;
      var cn4  = cn.substr(3,1)  * 7;
      var cn5  = cn.substr(4,1)  * 6;
      var cn6  = cn.substr(5,1)  * 5;
      var cn8  = cn.substr(6,1)  * 4;
      var cn9  = cn.substr(7,1)  * 3;
      var cn10 = cn.substr(8,1) * 2;
      var dig1 = cn.substr(9,1);
      var dig2 = cn.substr(10,1);
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
      var cp4 = cp.substr(3,1)  * 8;
      var cp5 = cp.substr(4,1)  * 7;
      var cp6 = cp.substr(5,1)  * 6;
      var cp8 = cp.substr(6,1)  * 5;
      var cp9 = cp.substr(7,1)  * 4;
      var cp10= cp.substr(8,1) * 3;
      var cp12= cp.substr(9,1) * 2;
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

      if (contrasenha.value == "" || contrasenha.value.length != 6)
	{
	 alert("Contra111-Senha Incorreta!");
	 contrasenha.value = "";
	 contrasenha.select();
	 return false; 
	}

      var MatAud = lsAud.value;
	var m0  = MatAud.substr(0,1);
	var m1  = MatAud.substr(1,1);
	var m2  = MatAud.substr(2,1);
	var m3  = MatAud.substr(3,1);
	var m4  = MatAud.substr(4,1);
	var m5  = MatAud.substr(5,1);
	var m6  = MatAud.substr(6,1);
	var m7  = MatAud.substr(7,1);
      var matinv = m7+m6+m5+m4+m3+m2+m1+m0;

      var parc1  = matinv * 1;
      var parc2  = txtcod.value * 1;
      var Soma   = parc1 + parc2;
      var SomaStr = Soma.toString();
      var ctsen   = SomaStr.substr(0,6);

      if (contrasenha.value != ctsen)
	{
	 alert("Contra2222-Senha Incorreta!");
	 contrasenha.value = "";
	 contrasenha.select();
	 return false; 
	}
      submit();
     }
  }
