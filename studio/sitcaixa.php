<?php  // Preparando Variáveis
       $dataop = date("Y-m-d");
       $chcx   = "no";

    // Abrindo a Conexão
       include "conexao.php";

    // Selecionando o Banco de Dados Funcionários
       include "dbselect.php";

    // Consultando Tabela
       $sqlx = "select dtopen, dtclose from caixa where dtclose IS NULL";

    // Consultando o Registro
       $rsx = mysqli_query($conec, $sqlx) or die("Não foi possível acessar o Caixa");

    // Contando Registros
       $regsx = mysqli_num_rows($rsx);

    // Obtendo o Último Registro
       while ($lnx   = mysqli_fetch_array($rsx))
	    {
	     $Abert  = $lnx['dtopen'];
	     $Fecha  = $lnx['dtclose'];
	    }

    // Verificando Situação do Caixa
       if ($regsx > 0)
    	 {
          $chcx = 'f';
         } else if ($regsx == 0)
                  {
                   $sqlV  = "select dtopen, dtclose from caixa order by dtclose desc";
                   $rsV   = mysqli_query($conec, $sqlV) or die("Não foi possível acessar o Caixa");
                   $lnV   = mysqli_fetch_array($rsV);
            	     $Abr = $lnV['dtopen'];
            	     $Fch = $lnV['dtclose'];

                     if ($Fch < $dataop)
	            	   {
                	    $chcx = 'x';
                       }
        	      } else if ($Abert < $dataop)
	            		   {
	            		    $chcx = 'a';
	            		   }
    // Encerrando a Conexão
       mysqli_free_result($rsx);
?>
