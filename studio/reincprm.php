<form name="confcad" method="post" action="confreinc.php">
<table width="80%" border="7" cellpadding="5" cellspacing="0" align="center">
    <tr>
       <td width="20%" align="center">
	  <b><i>Matrícula</i></b>
       </td>
       <td width="60%" align="center">
	  <b><i>Nome do Operador</i></b>
       </td>
       <td width="20%" align="center">
	  <b><i>Apelido</i></b>
       </td>
    </tr>

    <tr>
       <td width="20%" align="center">
	  <b><i><?php echo $MatForm; ?></i></b>
       </td>
       <td width="60%" align="center">
	  <b><i><?php echo $NomeF; ?></i></b>
       </td>
       <td width="20%" align="center">
	  <b><i><?php echo $ApeF; ?></i></b>
       </td>
    </tr>
</table>

<br><font size="6"><center><b><i>Operador <font color="gold"><blink>não Cadastrado</blink><font color="#FFFFFF">!!!</i></b></center></font>
    <input type="hidden" name="txtop" value="<?php echo $MatOp; ?>">

    <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>"><br>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <td>
       <a href='operador.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a>
    </td>
    <td align="center">
       <center><input type="submit" name="cmdsub" value="CADASTRAR">
    </td>
    <td align="right">
       <a href='operador.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a>
    </td>
</table>
</form>
