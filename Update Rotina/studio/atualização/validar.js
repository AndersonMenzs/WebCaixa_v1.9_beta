function checkdata()
  {
   with(document.audit)
     {
	 if (txtpc.value == "000" || txtpc.value.length != 3)
	   {
	    alert("PC Incorreto!");
	    txtpc.select();
	    txtpc.focus();
	    return false;
	    }

	 if (txtape.value == "" || txtape.value.length < 3)
	   {
	    alert("Campo Apelido em branco \n ou com menos de 3 caracteres");
	    txtape.select();
	    txtape.focus();
	    return false;
	    }

	 if (txtcofre.value == 0 || txtcofre.value == "" || txtcofre.value.length < 4)
	   {
	    alert("Valor do Cofre Incorreto!!!");
	    txtcofre.select();
	    txtcofre.focus();
	    return false;
	    }

	 if (txttroco.value == 0 || txttroco.value == "" || txttroco.value.length < 4)
	   {
	    alert("Valor de Troco Incorreto!!!");
	    txttroco.select();
	    txttroco.focus();
	    return false;
	    }

	 if (txtgav.value == 0 || txtgav.value == "" || txtgav.value.length < 4)
	   {
	    alert("Valor da Gaveta Incorreto!!!");
	    txtgav.select();
	    txtgav.focus();
	    return false;
	    }
      submit();
     }
  }
