function checkdata()
  {
   with(document.frmatual)
     {
      var data = new Date();
      var dia = data.getDate();
      var mes = data.getMonth() + 1;
      var ano = data.getYear() + 1900;

      var Diaprod = txtdtprod.value.substr(0,2);
      var Mesprod = txtdtprod.value.substr(3,2);
      var Anoprod = txtdtprod.value.substr(6,4);
      if (txtdtprod.value == "" || txtdtprod.value == " " || txtdtprod.value.length != 10)
	{
	 alert("Data da Produção Incorreta!");
	 txtdtprod.select();
	 txtdtprod.focus();
	 return false;
	}

      if (txtdtprod.value.substr(2,1) != "/" || txtdtprod.value.substr(5,1) != "/")
	{
	 alert("Data da Produção Incorreta!");
	 txtdtprod.select();
	 return false;
	}

      if (txtdtprod.value.substr(0,1) == "/" || txtdtprod.value.substr(1,1) == "/" || txtdtprod.value.substr(3,1) == "/" || txtdtprod.value.substr(4,1) == "/" || txtdtprod.value.substr(6,1) == "/" || txtdtprod.value.substr(7,1) == "/" || txtdtprod.value.substr(8,1) == "/" || txtdtprod.value.substr(9,1) == "/")
	{
	 alert("Data da Produção Incorreta!");
	 txtdtprod.select();
	 return false;
	}

      if (Anoprod == "" || Anoprod > ano)
	{
	 alert("Data da Produção Incorreta!");
	 txtdtprod.select();
	 txtdtprod.focus();
	 return false;
	}

      if (Anoprod == ano && Mesprod > mes)
	{
	 alert("Data da Produção Incorreta!");
	 txtdtprod.select();
	 txtdtprod.focus();
	 return false;
	}
      if (Anoprod == ano && Mesprod == mes && Diaprod > dia)
	{
	 alert("Data da Produção Incorreta!");
	 txtdtprod.select();
	 txtdtprod.focus();
	 return false;
	}
      if (Mesprod < 1 || Mesprod > 12)
	{
	 alert("Data da Produção Incorreta!");
	 txtdtprod.select();
	 txtdtprod.focus();
	 return false;
	}
      if ((Mesprod == 1 || Mesprod == 3 || Mesprod == 5 || Mesprod == 7 || Mesprod == 8 || Mesprod == 10 || Mesprod == 12) && (Diaprod < 1 || Diaprod > 31))
	{
	 alert("Data da Produção Incorreta!");
	 txtdtprod.select();
	 txtdtprod.focus();
	 return false;
	}
      if ((Mesprod == 4 || Mesprod == 6 || Mesprod == 9 || Mesprod == 11) && (Diaprod < 1 || Diaprod > 30))
	{
	 alert("Data da Produção Incorreta!");
	 txtdtprod.select();
	 txtdtprod.focus();
	 return false;
	}
      if ((Mesprod == 2 && Anoprod % 4 == 0) && (Diaprod < 1 || Diaprod > 29))
	{
	 alert("Data da Produção Incorreta!");
	 txtdtprod.select();
	 txtdtprod.focus();
	 return false;
	}
      if ((Mesprod == 2 && Anoprod % 4 != 0) && (Diaprod < 1 || Diaprod > 28))
	{
	 alert("Data da Produção Incorreta!");
	 txtdtprod.select();
	 txtdtprod.focus();
	 return false;
	}

      if ((txtvrprodn.value == "" || txtvrprodn.value == " " || txtvrprodn.value.length < 4) && (txtvrconcn.value == "" || txtvrconcn.value == " " || txtvrconcn.value.length < 4)) && (txtvrchavn.value == "" || txtvrchavn.value == " " || txtvrchavn.value.length < 4)) && (txtvrbeben.value == "" || txtvrbeben.value == " " || txtvrbeben.value.length < 4))
	{
	 alert("Nenhuma Alteração Registrada!");
	   return false;
          }

      if (txtvrprodn.value != "" && txtvrprodn.value != " " && txtvrprodn.value.length >= 4)
	{
	 var chaveP = confirm("Alterar a Taxa de Produção\nDE: R$ " + txtvrprod.value +
	 "   PARA: R$ " + txtvrprodn.value + "?") 
	if (chaveP != true)
          {
	   alert("Alteração Cancelada pelo Usuário");
	   return false;
          }
	}

      var Diaconc = txtdtconc.value.substr(0,2);
      var Mesconc = txtdtconc.value.substr(3,2);
      var Anoconc = txtdtconc.value.substr(6,4);
      if (txtdtconc.value == "" || txtdtconc.value == " " || txtdtconc.value.length != 10)
	{
	 alert("Data da Inscrição no Concurso Incorreto!");
	 txtdtconc.select();
	 txtdtconc.focus();
	 return false;
	}

      if (txtdtconc.value.substr(2,1) != "/" || txtdtconc.value.substr(5,1) != "/")
	{
	 alert("Data da Inscrição no Concurso Incorreto!");
	 txtdtconc.select();
	 return false;
	}

      if (txtdtconc.value.substr(0,1) == "/" || txtdtconc.value.substr(1,1) == "/" || txtdtconc.value.substr(3,1) == "/" || txtdtconc.value.substr(4,1) == "/" || txtdtconc.value.substr(6,1) == "/" || txtdtconc.value.substr(7,1) == "/" || txtdtconc.value.substr(8,1) == "/" || txtdtconc.value.substr(9,1) == "/")
	{
	 alert("Data da Inscrição no Concurso Incorreto!");
	 txtdtconc.select();
	 return false;
	}

      if (Anoconc == "" || Anoconc > ano)
	{
	 alert("Data da Inscrição no Concurso Incorreto!");
	 txtdtconc.select();
	 txtdtconc.focus();
	 return false;
	}

      if (Anoconc == ano && Mesconc > mes)
	{
	 alert("Data da Inscrição no Concurso Incorreto!");
	 txtdtconc.select();
	 txtdtconc.focus();
	 return false;
	}
      if (Anoconc == ano && Mesconc == mes && Diaconc > dia)
	{
	 alert("Data da Inscrição no Concurso Incorreto!");
	 txtdtconc.select();
	 txtdtconc.focus();
	 return false;
	}
      if (Mesconc < 1 || Mesconc > 12)
	{
	 alert("Data da Inscrição no Concurso Incorreto!");
	 txtdtconc.select();
	 txtdtconc.focus();
	 return false;
	}
      if ((Mesconc == 1 || Mesconc == 3 || Mesconc == 5 || Mesconc == 7 || Mesconc == 8 || Mesconc == 10 || Mesconc == 12) && (Diaconc < 1 || Diaconc > 31))
	{
	 alert("Data da Inscrição no Concurso Incorreto!");
	 txtdtconc.select();
	 txtdtconc.focus();
	 return false;
	}
      if ((Mesconc == 4 || Mesconc == 6 || Mesconc == 9 || Mesconc == 11) && (Diaconc < 1 || Diaconc > 30))
	{
	 alert("Data da Inscrição no Concurso Incorreto!");
	 txtdtconc.select();
	 txtdtconc.focus();
	 return false;
	}
      if ((Mesconc == 2 && Anoconc % 4 == 0) && (Diaconc < 1 || Diaconc > 29))
	{
	 alert("Data da Inscrição no Concurso Incorreto!");
	 txtdtconc.select();
	 txtdtconc.focus();
	 return false;
	}
      if ((Mesconc == 2 && Anoconc % 4 != 0) && (Diaconc < 1 || Diaconc > 28))
	{
	 alert("Data da Inscrição no Concurso Incorreto!");
	 txtdtconc.select();
	 txtdtconc.focus();
	 return false;
	}

      if (txtvrconcn.value != "" && txtvrconcn.value != " " && txtvrconcn.value.length >= 4)
	{
	 var chaveC = confirm("Alterar a Taxa de Inscrição no Concurso\nDE: R$ " + txtvrconc.value +
	 " PARA: R$ " + txtvrconcn.value + "?") 
	if (chaveC != true)
          {
	   alert("Alteração Cancelada pelo Usuário");
	   return false;
          }
	}

      var Diachav = txtdtchav.value.substr(0,2);
      var Meschav = txtdtchav.value.substr(3,2);
      var Anochav = txtdtchav.value.substr(6,4);
      if (txtdtchav.value == "" || txtdtchav.value == " " || txtdtchav.value.length != 10)
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtchav.select();
	 txtdtchav.focus();
	 return false;
	}

      if (txtdtchav.value.substr(2,1) != "/" || txtdtchav.value.substr(5,1) != "/")
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtchav.select();
	 return false;
	}

      if (txtdtchav.value.substr(0,1) == "/" || txtdtchav.value.substr(1,1) == "/" || txtdtchav.value.substr(3,1) == "/" || txtdtchav.value.substr(4,1) == "/" || txtdtchav.value.substr(6,1) == "/" || txtdtchav.value.substr(7,1) == "/" || txtdtchav.value.substr(8,1) == "/" || txtdtchav.value.substr(9,1) == "/")
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtchav.select();
	 return false;
	}

      if (Anochav == "" || Anochav > ano)
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtchav.select();
	 txtdtchav.focus();
	 return false;
	}

      if (Anochav == ano && Meschav > mes)
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtchav.select();
	 txtdtchav.focus();
	 return false;
	}
      if (Anochav == ano && Meschav == mes && Diachav > dia)
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtchav.select();
	 txtdtchav.focus();
	 return false;
	}
      if (Meschav < 1 || Meschav > 12)
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtchav.select();
	 txtdtchav.focus();
	 return false;
	}
      if ((Meschav == 1 || Meschav == 3 || Meschav == 5 || Meschav == 7 || Meschav == 8 || Meschav == 10 || Meschav == 12) && (Diachav < 1 || Diachav > 31))
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtchav.select();
	 txtdtchav.focus();
	 return false;
	}
      if ((Meschav == 4 || Meschav == 6 || Meschav == 9 || Meschav == 11) && (Diachav < 1 || Diachav > 30))
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtchav.select();
	 txtdtchav.focus();
	 return false;
	}
      if ((Meschav == 2 && Anochav % 4 == 0) && (Diachav < 1 || Diachav > 29))
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtchav.select();
	 txtdtchav.focus();
	 return false;
	}
      if ((Meschav == 2 && Anochav % 4 != 0) && (Diachav < 1 || Diachav > 28))
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtchav.select();
	 txtdtchav.focus();
	 return false;
	}

      if ((txtvrchavn.value == "" || txtvrchavn.value == " " || txtvrchavn.value.length < 4) && (txtvrconcn.value == "" || txtvrconcn.value == " " || txtvrconcn.value.length < 4))
	{
	 alert("Nenhuma Alteração Registrada!");
	   return false;
          }

      if (txtvrchavn.value != "" && txtvrchavn.value != " " && txtvrchavn.value.length >= 4)
	{
	 var chaveH = confirm("Alterar o Valor do Chaveiro\nDE: R$ " + txtvrchav.value +
	 "   PARA: R$ " + txtvrchavn.value + "?") 
	if (chaveH != true)
          {
	   alert("Alteração Cancelada pelo Usuário");
	   return false;
          }
	}

      var Diabebe = txtdtbebe.value.substr(0,2);
      var Mesbebe = txtdtbebe.value.substr(3,2);
      var Anobebe = txtdtbebe.value.substr(6,4);
      if (txtdtbebe.value == "" || txtdtbebe.value == " " || txtdtbebe.value.length != 10)
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtbebe.select();
	 txtdtbebe.focus();
	 return false;
	}

      if (txtdtbebe.value.substr(2,1) != "/" || txtdtbebe.value.substr(5,1) != "/")
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtbebe.select();
	 return false;
	}

      if (txtdtbebe.value.substr(0,1) == "/" || txtdtbebe.value.substr(1,1) == "/" || txtdtbebe.value.substr(3,1) == "/" || txtdtbebe.value.substr(4,1) == "/" || txtdtbebe.value.substr(6,1) == "/" || txtdtbebe.value.substr(7,1) == "/" || txtdtbebe.value.substr(8,1) == "/" || txtdtbebe.value.substr(9,1) == "/")
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtbebe.select();
	 return false;
	}

      if (Anobebe == "" || Anobebe > ano)
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtbebe.select();
	 txtdtbebe.focus();
	 return false;
	}

      if (Anobebe == ano && Mesbebe > mes)
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtbebe.select();
	 txtdtbebe.focus();
	 return false;
	}
      if (Anobebe == ano && Mesbebe == mes && Diabebe > dia)
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtbebe.select();
	 txtdtbebe.focus();
	 return false;
	}
      if (Mesbebe < 1 || Mesbebe > 12)
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtbebe.select();
	 txtdtbebe.focus();
	 return false;
	}
      if ((Mesbebe == 1 || Mesbebe == 3 || Mesbebe == 5 || Mesbebe == 7 || Mesbebe == 8 || Mesbebe == 10 || Mesbebe == 12) && (Diabebe < 1 || Diabebe > 31))
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtbebe.select();
	 txtdtbebe.focus();
	 return false;
	}
      if ((Mesbebe == 4 || Mesbebe == 6 || Mesbebe == 9 || Mesbebe == 11) && (Diabebe < 1 || Diabebe > 30))
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtbebe.select();
	 txtdtbebe.focus();
	 return false;
	}
      if ((Mesbebe == 2 && Anobebe % 4 == 0) && (Diabebe < 1 || Diabebe > 29))
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtbebe.select();
	 txtdtbebe.focus();
	 return false;
	}
      if ((Mesbebe == 2 && Anobebe % 4 != 0) && (Diabebe < 1 || Diabebe > 28))
	{
	 alert("Data do Chaveiro Incorreta!");
	 txtdtbebe.select();
	 txtdtbebe.focus();
	 return false;
	}

      if ((txtvrbeben.value == "" || txtvrbeben.value == " " || txtvrbeben.value.length < 4) && (txtvrconcn.value == "" || txtvrconcn.value == " " || txtvrconcn.value.length < 4))
	{
	 alert("Nenhuma Alteração Registrada!");
	   return false;
          }

      if (txtvrbeben.value != "" && txtvrbeben.value != " " && txtvrbeben.value.length >= 4)
	{
	 var bebeeH = confirm("Alterar o Valor do Bebê Estrella\nDE: R$ " + txtvrbebe.value +
	 "   PARA: R$ " + txtvrbeben.value + "?") 
	if (bebeeH != true)
          {
	   alert("Alteração Cancelada pelo Usuário");
	   return false;
          }
	}      submit();
     }
  }
