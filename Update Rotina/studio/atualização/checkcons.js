function checkcli()
  {
   with(document.cadcons)
     {
      var rd_select = "no";
      for (var loop = 0; loop < rdnovo.length; loop++)
	 {
	  if (rdnovo[loop].checked == true)
	    {
	     rd_select = "yes";
	    }
	 }
      if (rd_select == "no")
	{
	 alert ("Voce precisa selecionar\n \"Ano Corrente\" ou \"Todos\"");
	 return false;
	}

      if (txtmod.value == "" && txtresp.value == "" && txtcodcli.value == "" && dtfotog.value == "" && txtcpf.value == "" && txtvend.value == "")
	{
	 alert("Nenhum Campo Informado!");
	 txtcodcli.value = "";
	 txtcodcli.select();
	 txtcodcli.focus();
	 return false; 
	}

      if (txtmod.value != "" && txtmod.value != " ")
	{
	 if (txtmod.value.length < 5)
	   {
	    alert("Nome do Modelo Muito Curto ou Incorreto!");
	    txtmod.value = "";
	    txtmod.select();
	    txtmod.focus();
	    return false; 
	   }
	}

      if (txtresp.value != "" && txtresp.value != " ")
	{
	 if (txtresp.value.length < 5)
	   {
	    alert("Nome do Responsável Muito Curto ou Incorreto!");
	    txtresp.value = "";
	    txtresp.select();
	    txtresp.focus();
	    return false; 
	   }
	}

      if (txtcodcli.value != "" && txtcodcli.value != " ")
	{
	 if (txtcodcli.value.length < 1 || txtcodcli.value == 0)
	   {
	    alert("Campo Código do Cliente Incorreto!");
	    txtcodcli.value = "";
	    txtcodcli.select();
	    txtcodcli.focus();
	    return false; 
	   }
	}

      if (dtfotog.value != "" && dtfotog.value != " ")
	{
	 var data = new Date();
	 var dia = data.getDate();
	 var mes = data.getMonth() + 1;
	 var ano = data.getYear();

	 if (ano < 1900)
	   {
	    ano = ano + 1900;
	   }

	 if (dtfotog.value == "" || dtfotog.value == " " || dtfotog.value.length != 10)
	   {
	    alert("Data do Fotografado Incorreta!");
	    dtfotog.value = "";
	    dtfotog.select();
	    dtfotog.focus();
	    return false;
           } else {
		   var Diafot = dtfotog.value.substr(0,2);
		   var Mesfot = dtfotog.value.substr(3,2);
		   var Anofot = dtfotog.value.substr(6,4);

		   if (Anofot > ano)
		     {
		      alert("Data do Fotografado Incorreta!");
		      dtfotog.value = "";
		      dtfotog.select();
		      dtfotog.focus();
		      return false;
		     }
		   if (Anofot == ano && Mesfot > mes)
		     {
		      alert("Data do Fotografado Incorreta!");
		      dtfotog.value = "";
		      dtfotog.select();
		      dtfotog.focus();
		      return false;
		     }
		   if (Anofot == ano && Mesfot == mes && Diafot > dia)
		     {
		      alert("Data do Fotografado Incorreta!");
		      dtfotog.value = "";
		      dtfotog.select();
		      dtfotog.focus();
		      return false;
		     }
		   if (Mesfot < 1 || Mesfot > 12)
		     {
		      alert("Data do Fotografado Incorreta!");
		      dtfotog.value = "";
		      dtfotog.select();
		      dtfotog.focus();
		      return false;
		     }
		   if ((Mesfot == 1 || Mesfot == 3 || Mesfot == 5 || Mesfot == 7 || Mesfot == 8 || Mesfot == 10 || Mesfot == 12) && (Diafot < 1 || Diafot > 31))
		     {
		      alert("Data do Fotografado Incorreta!");
		      dtfotog.value = "";
		      dtfotog.select();
		      dtfotog.focus();
		      return false;
		     }
		   if ((Mesfot == 4 || Mesfot == 6 || Mesfot == 9 || Mesfot == 11) && (Diafot < 1 || Diafot > 30))
		     {
		      alert("Data do Fotografado Incorreta!");
		      dtfotog.value = "";
		      dtfotog.select();
		      dtfotog.focus();
		      return false;
		     }
		   if ((Mesfot == 2 && Anofot % 4 == 0) && (Diafot < 1 || Diafot > 29))
		     {
		      alert("Data do Fotografado Incorreta!");
		      dtfotog.value = "";
		      dtfotog.select();
		      dtfotog.focus();
		      return false;
		     }
		   if ((Mesfot == 2 && Anofot % 4 != 0) && (Diafot < 1 || Diafot > 28))
		     {
		      alert("Data do Fotografado Incorreta!");
		      dtfotog.value = "";
		      dtfotog.select();
		      dtfotog.focus();
		      return false;
		     }
		   }
	}

      if (txtcpf.value != "" && txtcpf.value != " ")
	{
	 if (txtcpf.value.length < 14)
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
	   } else {
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
	   } else {
		   dv2 = 11 - dv2;
		  }

	 if (dig1 != dv1 || dig2 != dv2)
	   {
	    alert("CPF Incorreto!");
	    txtcpf.value = "";
	    txtcpf.select();
	    return false;
	   }
	}

      var cn = txtvend.value;
      var cn1 = 0;
      var cn2 = 0;
      var cn3 = 0;
      var cn4 = 0;
      var cn5 = 0;
      var cn6 = 0;
      var cn7 = 0;
      var dig = 0;

      if (txtvend.value != "" && txtvend.value != " ")
	{
	 if (txtvend.value.length < 2)
	   {
	    alert("Matrícula da Vendedora Incorreta!");
	    txtvend.value = "";
	    txtvend.select();
	    txtvend.focus();
	    return false; 
	   }

	 if (cn.length == 2)
	   {
	    cn1 = cn.substr(0,1) * 2;
	    dig = cn.substr(1,1);
	   } else if (cn.length == 3)
		    {
		     cn1 = cn.substr(0,1) * 3;
		     cn2 = cn.substr(1,1) * 2;
		     dig = cn.substr(2,1);
		    } else if (cn.length == 4)
			     {
			      cn1 = cn.substr(0,1) * 4;
			      cn2 = cn.substr(1,1) * 3;
			      cn3 = cn.substr(2,1) * 2;
			      dig = cn.substr(3,1);
			     } else if (cn.length == 5)
				      {
				       cn1 = cn.substr(0,1) * 5;
				       cn2 = cn.substr(1,1) * 4;
				       cn3 = cn.substr(2,1) * 3;
				       cn4 = cn.substr(3,1) * 2;
				       dig = cn.substr(4,1);
				      } else if (cn.length == 6)
					       {
						cn1 = cn.substr(0,1) * 6;
						cn2 = cn.substr(1,1) * 5;
						cn3 = cn.substr(2,1) * 4;
						cn4 = cn.substr(3,1) * 3;
						cn5 = cn.substr(4,1) * 2;
						dig = cn.substr(5,1);
					       } else if (cn.length == 7)
							{
							 cn1 = cn.substr(0,1) * 7;
							 cn2 = cn.substr(1,1) * 6;
							 cn3 = cn.substr(2,1) * 5;
							 cn4 = cn.substr(3,1) * 4;
							 cn5 = cn.substr(4,1) * 3;
							 cn6 = cn.substr(5,1) * 2;
							 dig = cn.substr(6,1);
							} else if (cn.length == 8)
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

	 if (dv  != dig || soma == 0)
	   {
	    alert("Matrícula da Vendedora ou Dígito Incorreto");
	    txtvend.value = "";
	    txtvend.select();
	    txtvend.focus();
	    return false;
	   }
      }
      submit();
     }
  }
