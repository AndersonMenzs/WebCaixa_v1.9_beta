function checkdata()
  {
   with(document.autoriza)
     {
	 if (lsPr.value == "000000")
	   {
	    alert("Selecione um Responsável!!!");
	    return false;
	    }
	 if (txtctrsen.value.length != 6)
	   {
	    alert("Senha Incorreta!!!");
	    txtctrsen.select();
	    txtctrsen.focus();
	    return false;
	    }
      submit();
     }
  }
