<?php

// INCLUIR A CONEXÃO E BANCO DE DADOS
include_once 'conexao.php';
include_once 'dblog.php';

$colaboradores = filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_STRING);

// PESQUISAR NO BANCO DE DADOS NOME DO USUARIO REFERENTE A PALAVRA DIGITADA
$result_user = "SELECT pessoal.mat, pessoal.nome, pessoal.cpf, funcionarios.funcao FROM pessoal INNER JOIN funcionarios ON pessoal.mat = funcionarios.mat AND nome LIKE '%$colaboradores%' LIMIT 20";
$resultado_user = mysqli_query($conec, $result_user);

if(($resultado_user) AND ($resultado_user->num_rows != 0)) {

    while ($row_user = mysqli_fetch_assoc($resultado_user)) {

        $Mat  = $row_user['mat'];
        $m1 = substr($Mat,0,1);
        $m2 = substr($Mat,1,3);
        $m3 = substr($Mat,4,3);
        $dv = substr($Mat,7,1);
           $MatF  = "$m1.$m2.$m3-$dv";
        $Nome  = $row_user['nome'];
        $CPF   = $row_user['cpf'];
           $c1 = substr($CPF,0,3);
           $c2 = substr($CPF,3,3);
           $c3 = substr($CPF,6,3);
           $c4 = substr($CPF,9,2);
        $CPFF  = "$c1.$c2.$c3-$c4";
        $Funcao= $row_user['funcao'];
?>
<tr>
<td width=12% align="center">
    <font color='lime'><b><i><?php echo $MatF; ?></i></b>
    </font>
</td>
<td width=43% align="left">
    <font color='#FFFFFF'><b><i>&nbsp;<?php echo $Nome; ?></i></b>
    </font>
</td>
<td width=30% align="left"><?php
    $sqlF = "select ncargo from cargos where ccargo = '$Funcao' ";
    $rsF  = mysqli_query($conec, $sqlF) or die ("Não foi Possível Consultar o Cargos");
    $lnF  = mysqli_fetch_array($rsF);
      $FName = $lnF['ncargo']; ?>

    <font color='#FFFFFF'><b><i>&nbsp;<?php echo $FName; ?></i></b>
    </font>
</td>
<td width=15% align='center'>
    <font color='yellow'><b><i><?php echo $CPFF; ?></i></b>
    </font>
</td>
    </tr>
<?php

    }

}else {?>
    <center><font color='yellow'><b><h1>Nenhum Registro Encontrado.</h1></b></font></center>
    <center><font color='yellow'><b><h2>Por Favor, Refaça a Operação!</h2></b></font></center>
<?php 
}