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

      var cnp = txtcpf.value;

      var cnp0  = cnp.substr(0,1)  * 10;
      var cnp1  = cnp.substr(1,1)  * 9;
      var cnp2  = cnp.substr(2,1)  * 8;
      var cnp3  = cnp.substr(3,1)  * 7;
      var cnp4  = cnp.substr(4,1)  * 6;
      var cnp5  = cnp.substr(5,1)  * 5;
      var cnp6  = cnp.substr(6,1)  * 4;
      var cnp7  = cnp.substr(7,1)  * 3;
      var cnp8  = cnp.substr(8,1)  * 2;
      var dig1  = cnp.substr(9,1);
      var dig2  = cnp.substr(10,1);
      var soma  = cnp0+cnp1+cnp2+cnp3+cnp4+cnp5+cnp6+cnp7+cnp8 ;
      var dv1   = soma%11;
	if (dv1 == 0 || dv1 == 1)
	  {
	   dv1 = 0;
	  }
	   else
	       {
		dv1 = 11 - dv1;
	       }

      var cpp   = txtcpf.value;
      var cpp0  = cpp.substr(0,1)  * 11;
      var cpp1  = cpp.substr(1,1)  * 10;
      var cpp2  = cpp.substr(2,1)  * 9;
      var cpp3  = cpp.substr(3,1)  * 8;
      var cpp4  = cpp.substr(4,1)  * 7;
      var cpp5  = cpp.substr(5,1)  * 6;
      var cpp6  = cpp.substr(6,1)  * 5;
      var cpp7  = cpp.substr(7,1)  * 4;
      var cpp8  = cpp.substr(8,1)  * 3;
      var cpp9  = cpp.substr(9,1)  * 2;
      soma = cpp0+cpp1+cpp2+cpp3+cpp4+cpp5+cpp6+cpp7+cpp8 +cpp9;
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

      if (txtnome.value == "" || txtnome.value == " ")
	{
	 alert("Informe o Nome a ser Cadastrado!");
	 txtnome.value = "";
	 txtnome.select();
	 return false; 
	}

      if (lsCargo.value == "00")
	{
	 alert("Selecione um Cargo!");
	 return false; 
	}

      if (contrasenha.value == "" || contrasenha.value.length != 6)
	{
	 alert("Contra-Senha Incorreta!");
	 contrasenha.value = "";
	 contrasenha.select();
	 return false; 
	}

    var MatAud = lsAud.value;
	var m0   = MatAud.substr(0,1);
	var m1   = MatAud.substr(1,1);
	var m2   = MatAud.substr(2,1);
	var m3   = MatAud.substr(3,1);
	var m4   = MatAud.substr(4,1);
	var m5   = MatAud.substr(5,1);
	var m6   = MatAud.substr(6,1);
	var m7   = MatAud.substr(7,1);
      var matinv = m7+m6+m5+m4+m3+m2+m1+m0;

      var parcX   = parseInt(cn) + 100000000;
      var parcR   = "" + parcX;
      var parcM0  = parcR.substr(8,1);
      var parcM1  = parcR.substr(7,1);
      var parcM2  = parcR.substr(6,1);
      var parcM3  = parcR.substr(5,1);
      var parcM4  = parcR.substr(4,1);
      var parcM5  = parcR.substr(3,1);
      var parcM6  = parcR.substr(2,1);
      var parcM7  = parcR.substr(1,1);
      var parcM   = parcM0 + parcM1 + parcM2 + parcM3 + parcM4 + parcM5 + parcM6 + parcM7;
      var parc0   = parcM * 1;
      var parc1   = parseInt(matinv);
      var parc2   = txtcod.value * 1;
      var Soma    = parc0 + parc1 + parc2;
      var SomaStr = Soma.toString();
      var ctsen   = SomaStr.substr(0,6);

      if (contrasenha.value != ctsen)
	{
	 alert("Contra-Senha Incorreta!");
	 contrasenha.value = "";
	 contrasenha.select();
	 return false; 
	}
      submit();
     }
  }
