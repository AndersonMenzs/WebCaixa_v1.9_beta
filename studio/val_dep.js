function checkdata()
  {
   with(document.deps)
     {
	 if (txtcod.value.length != 6)
	   {
	    alert("Envelope Incorreto!!!");
	    txtcod.select();
	    txtcod.focus();
	    return false;
	    }

	 if (txtvalor.value.length < 3)
	   {
	    alert("Valor Incorreto!!!");
	    txtvalor.select();
	    txtvalor.focus();
	    return false;
	    }

	 var recolhe = txtvalor.value * 100;
	 var caixa   = txtcaixa.value * 100;
	 if (recolhe > caixa)
	   {
	    alert("Saldo do Caixa Inferior ao Valor Informado!!!\n\nSaldo do Caixa: R$ " + txtcaixa.value + "\nRecolhimento:  R$ " + txtvalor.value);
	    txtcaixa.select();
	    txtcaixa.focus();
	    return false;
	    }

      var cn = txtreceb.value;
      var cn1 = 0;
      var cn2 = 0;
      var cn3 = 0;
      var cn4 = 0;
      var cn5 = 0;
      var cn6 = 0;
      var cn7 = 0;
      var dig = 0;

      if (txtreceb.value == "" || txtreceb.value.length < 2)
	{
	 alert("Matrícula Incorreta!");
	 txtreceb.select();
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
	   txtreceb.select();
	   txtreceb.focus();
	   return false;
	  }
      submit();
     }
  }
