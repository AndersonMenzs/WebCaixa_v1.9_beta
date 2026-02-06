<html>

<head>
   <title>WebCaixa v1.19_beta</title>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <style type="text/css">
      body {
         margin-top: 5%;
         margin-left: 5%;
         margin-right: 5%;
         border: 3px solid gray;
         padding: 10px 10px 10px 10px;
         font-family: sans-serif;
      }

      .campos {
         background-color: #C0C0C0;
         font: 16px sans-serif;
         color: #000000;
      }
   </style>

   <script>
      function F5(event) {
         var tecla = document.all ? window.event.keyCode : event.which;
         if (document.all) {
            window.event.keyCode = 0;
            window.event.returnValue = false;
         }
         if (tecla == 116) return false;
      }

      document.onkeydown = F5;
   </script>

   <?php
   // Inserindo o Cabeçalho
   include "../cabecprs.php";
   ?>

   <SCRIPT LANGUAGE="JavaScript">
      <!-- Begin
      function putFocus(formInst, elementInst) {
         if (document.forms.length > 0) {
            document.forms[formInst].elements[elementInst].focus();
         }
      }
      //  End 
      -->
   </script>

   <Script>
      function validate(field) {
         var valid = "0123456789"
         var ok = "yes";
         var temp;
         for (var i = 0; i < field.value.length; i++) {
            temp = "" + field.value.substring(i, i + 1);
            if (valid.indexOf(temp) == "-1") ok = "no";
         }
         if (ok == "no") {
            alert("Entrada Incorreta! \n  Digite apenas algarismos!");
            field.focus();
            field.select();
         }
      }
      //  End -->
   </script>

   <script type="text/javascript" src="val_ped.js" charset="utf-8">
   </script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

   <?php
   // Obtendo o Login
   $Sis     = "S7";
   $Rot     = "S7R1";
   $lg_user = $_REQUEST['c_s'];
   $user = substr($lg_user, 0, 8);
   $pss  = substr($lg_user, 8, 40);
   $Mat_Vend = trim($_POST['mat_vend']);

   include "us_sist.php";
   if ($ch == 'no') {
      include "us_cad.php";
   } ?>

   <table width='100%' border='0' cellpadding='0' cellspacing='0'>
      <tr>
         <td width='9%'>
            <a href="servrec.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
         </td>
         <td width='82%' align='center'>
            <font color="gold" size="6"><b>
                  <center><u><i>SOLICITAÇÕES</i></u></center>
               </b></font><br><br><br>
         </td>
         <td width='9%'>
            <a href="servrec.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
         </td>
      </tr>
   </table>

   <?php

   if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
      <form name="frmest" method="post" action="estped.php" onsubmit="return checkdata()" autocomplete="off">
         <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
            <tr>
               <td colspan="2" align="center">
                  <font color='gold' size='5'><b><i>Autenticação Nº: &nbsp;</i></b></font>
                  <input type="text" id="txtaut" name="txtaut" size="4" maxlength="4" class="campos" onKeyUp="validate(this)">
                  <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
               </td>
            </tr>

            <tr>
               <td width="50%" align="center">
                  <font color='gold' size='5'><b><i>Book:</i></b></font>
                  <input id="rdopt" type="radio" name="rdopt" class="campos" value="BOOK">
               </td>
               <td width="50%" align="center">
                  <font color='gold' size='5'><b><i>Poster:</i></b></font>
                  <input id="rdopt" type="radio" name="rdopt" class="campos" value="POSTER">
               </td>
            </tr>
         </table><br>

         <table id="tab_ped" name="tab_ped" width="70%" border="5" cellpadding="10" cellspacing="0" align="center" style="display:none;">
            <thead>
               <tr>
                  <td width="25%" align="center">
                     <font color='#FFFFFF' size='5'><b><i>Vendedora</i></b></font>
                  </td>
                  <td width="25%" align="center">
                     <font color='#FFFFFF' size='5'><b><i>Cliente</i></b></font>
                  </td>
               </tr>
            </thead>
            <tbody id="tab_ped_body">
               <tr>
                  <td align="center" colspan="2">
                     <font color='gold' size='5'><b><i><?php echo $Vendedora; ?></i></b></font>
                  </td>
                  <td align="center">
                     <font color='lime' size='5'><b><i><?php echo $Cliente; ?></i></b></font>
                  </td>
               </tr>
            </tbody>
         </table><br>

         <table width="100%" border="0" cellspacing="0">
            <tr>
               <td width="9%"></td>
               <td width="82%" align="center">  
                  <input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
                  <input type="reset" name="btreset" value="Limpar">
               <td width="9%" align="right"></a>
               </td>
            </tr>
         </table>
      </form><?php
            } else { ?>
      <br><br><br><br><br>
      <font size='6'><b>
            <center>Acesso <font color='gold'>
                  <blink><u>não Autorizado</u>
                  </blink>
                  <font color='#FFFFFF'>!!!</center>
         </b></font><br><br><br>
      <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
   <?php
            }

            // Encerrando as Conexões
            $SisRot = "S-7.1";
            include "./rodape.php";
            mysqli_close($conec); ?>

   <!-- script para consultar ao digitar/confirmar autenticação -->
   <script>
      (function() {
         const radios = Array.from(document.querySelectorAll('input[name="rdopt"]'));
         const input = document.getElementById('txtaut');
         const tb_ped = document.getElementById('tab_ped');
         const tb_body = document.getElementById('tab_ped_body');
         if (!radios.length || !input || !tb_ped || !tb_body) return;

         function limparTabela() {
            tb_body.innerHTML = '';
         }

         function esc(v) {
            return String(v === null || v === undefined ? '' : v).replace(/</g, '&lt;').replace(/>/g, '&gt;');
         }

         function montarLinha(row) {
            return '<tr>' +
               '<td align="center">' + esc(row.vendedora || '') + '</td>' +
               '<td align="center">' + esc(row.cliente || '') + '</td>' +
               '</tr>';
         }

         function mostrarMensagem(msg, colspan = 5) {
            limparTabela();
            tb_body.innerHTML = '<tr><td colspan="' + colspan + '" align="center" style="color:gold;"><b>' + esc(msg) + '</b></td></tr>';
         }

         async function consultar(txt, tipo) {
            txt = (txt || '').toString().trim();
            tipo = (tipo || '').toString().trim();

            if (tipo === '') {
               tb_ped.style.display = 'none';
               limparTabela();
               return;
            }

            // Se não informou txtaut, pede ao usuário e não faz a consulta
            if (txt === '') {
               tb_ped.style.display = 'none';
               mostrarMensagem('Informe o número de autenticação antes de selecionar o tipo.');
               return;
            }

            tb_ped.style.display = 'table';

            try {
               const params = new URLSearchParams({
                  txtaut: txt,
                  rdopt: tipo
               });
               const res = await fetch('buscar_pedido.php', {
                  method: 'POST',
                  headers: {
                     'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                  },
                  body: params.toString()
               });

               if (!res.ok) throw new Error('Erro na requisição: ' + res.status);
               const data = await res.json();

               if (!Array.isArray(data) || data.length === 0) {
                  mostrarMensagem('Nenhum registro encontrado');
                  return;
               }

               limparTabela();
               tb_body.innerHTML = data.map(montarLinha).join('');
            } catch (err) {
               console.error(err);
               mostrarMensagem('Erro ao consultar. Veja console.');
            }
         }

         // Quando muda a seleção do tipo (rdopt) -> consulta usando valor de txtaut
         radios.forEach(function(r) {
            r.addEventListener('change', function() {
               if (this.checked) {
                  const tipo = this.value;
                  const txt = input.value.trim();
                  consultar(txt, tipo);
               }
            });
         });

         // Se o usuário editar o txtaut e já tiver um tipo selecionado, atualiza a tabela
         input.addEventListener('keyup', function(e) {
            if (e.key === 'Enter' || e.key === 'Return') {
               const checked = radios.find(r => r.checked);
               if (checked) consultar(this.value.trim(), checked.value);
            } else {
               // se apagar tudo, oculta tabela
               if (this.value.trim() === '') {
                  tb_ped.style.display = 'none';
                  limparTabela();
               }
            }
         });

         input.addEventListener('blur', function() {
            const checked = radios.find(r => r.checked);
            if (checked && this.value.trim() !== '') consultar(this.value.trim(), checked.value);
         });

         // inicialmente ocultar tabela
         tb_ped.style.display = 'none';
      })();
   </script>

</body>

</html>