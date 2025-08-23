<?php
	    if ($Modelo <> '')
	      {
	       $sql = "select * from fotog where modelo like '%$Modelo%' order by datafot desc";
	      } else if ($Respon <> '')
		       {
			$sql = "select * from fotog where cliente like '%$Respon%' order by datafot desc";
		       } else if ($CodCli <> '' and $CodCli <> '0000')
				{
				 $sql = "select * from fotog where codcli = '$CodCli' order by datafot desc";
				} else if ($dtFotog <> '')
					 {
					  $sql = "select * from fotog where datafot = '$FotReal' order by datafot desc";
					 } else if ($CPF <> '')
						  {
						   $sql = "select * from fotog where cpf = '$CPFReal' order by datafot desc";
						  } else {
							  $sql = "select * from fotog where operador = '$Vended' order by datafot desc";
							 }
	 $rs  = mysqli_query($conec_digital, $sql) or die ("File consultop Error #1. Contate seu Administrador");
	 $regs= mysqli_num_rows($rs);
?>