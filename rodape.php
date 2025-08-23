<hr size='2' color='gray'>

<?php // Obtendo Nome do Usuário
      include "conexao.php";
      include "dblog.php";

      $sqlR = "select ape from pessoal where mat = '$user' ";
      $rsR  = mysqli_query($conec, $sqlR) or die ("Não foi Possível Consultar Funcionários");
      $lnR  = mysqli_fetch_array($rsR);
	$Apld = $lnR['ape'];
      mysqli_free_result($rsR);
?>

<table width="100%" border="0" cellspacing="0">
  <tr>
     <td width="25%">
	<!-- <font face="sans-serif, Arial, Helvetica, Tahoma" size="4"><b><i><?php echo "Usuário: <font color='lime'>$Apld"; ?></font></i></b></font> -->
     </td>
     <td width="52%">
       <div align="center"><font face="Sans-serif, Arial, Helvetica, Tahoma" size="5"><i>"O maior e mais querido do Brasil".</i></font></div>
     </td>
     <td width="23%" rowspan="2" align="right"><font size="4" color="#FFFFFF"><b><i><center><?php //echo $SisRot; ?></center></i></b>
     </td>
  </tr>

  <tr>
     <td width="25%">&nbsp;</td>
     <td width="52%">
      <div align="center"><font face="Sans-serif, Arial, Helvetica, Tahoma" size="2"> 
        Contato: cpd.photoestrella@gmail.com - Tels: (21) 2121-5278 / (21) 99212-0108.</font></div>
    </td>
  </tr>
</table>
