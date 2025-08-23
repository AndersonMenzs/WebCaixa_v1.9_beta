function checkdata()
  {
   with(document.retif)
     {
	 if (txtaut.value == "" || txtaut.value == 0 || txtaut.value.length < 1)
	   {
	    alert("Número da Autenticação Incorreto!");
	    txtaut.value = "";
	    txtaut.select();
	    txtaut.focus();
	    return false;
	    }

	 if (txtfita.value == "" || txtfita.value == 0 || txtfita.value.length < 1)
	   {
	    alert("Número da Fita Incorreto!");
	    txtfita.select();
	    txtfita.value = "";
	    txtfita.focus();
	    return false;
	    }

      var cn = txtresp.value;
      var cn1 = 0;
      var cn2 = 0;
      var cn3 = 0;
      var cn4 = 0;
      var cn5 = 0;
      var cn6 = 0;
      var cn7 = 0;
      var dig = 0;

      if (txtresp.value == "" || txtresp.value.length < 2)
	{
	 alert("Matrícula Incorreta!");
	 txtresp.value = "";
	 txtresp.select();
	 txtresp.focus();
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
	   txtresp.value = "";
	   txtresp.select();
	   txtresp.focus();
	   return false;
	  }

	 if (txtvalor.value == "" || txtvalor.value == 0 || txtvalor.value.length < 4)
	   {
	    alert("Valor Incorreto!");
	    txtvalor.value = "";
	    txtvalor.select();
	    txtvalor.focus();
	    return false;
	    }

	 if (lsde.value == "00")
	   {
	    alert("Informe a Forma de Pagamento\na Registrada na Autenticação!");
	    return false;
	    }

	 if (lspara.value == "00")
	   {
	    alert("Informe a Forma de Pagamento Correta!");
	    return false;
	    }
      submit();
     }
  }
