# Mudanças no WebCaixa

## Dia: 04/01/2024
### Comentado a função mysqli_free_result

Nos códigos localizados studio/index.php e o studio/abrecaixa.php apresentaram problemas na função *mysqli_free_result*. A função *mysqli_free_result* geralmente é usada para liberar a memória associada a resultados de consultas **SELECT** grandes e complexas, onde os dados são armazenados temporariamente para serem recuperados por linhas. No caso de uma consulta **DELETE**, não há um conjunto de resultados associado da mesma maneira, portanto, a chamada para *mysqli_free_result* não é estritamente necessária.

~~~php
if ($ini == 'ok' and ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') and ($chcx == 'x' or $chcx == 'a') and $AtuSen == 'ok')
			       {

					$sql = "DELETE FROM spool2";
					$rs = mysqli_query($conec, $sql) or die("Erro ao acessar o banco de dados. Entre em contato com o administrador.");
					//mysqli_free_result($rs);
					
					 ?>

				<tr>
				   <td>
				      <a href="abrecaixa.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a><font size='4'><b><i>- Abertura do Caixa</i></b></font>
				   </td>
				</tr><?php
			       }
~~~

### Adição da conexão ao bando de dados do WebDigital
~~~php

<?php
// Selecionando o Banco de Dados
$db_digital = mysqli_select_db($conec_digital, "dig206");

if (!$db_digital) {
    ?>
    <br><br><br>
    <font size='5' color='red'>
        <center>Você não tem permissão para acessar este Banco de Dados<br><br>
        Por favor, contate o seu Administrador Web</center>
    </font>
    <?php
} else {
    echo "Arquivo conectado!";
}
?>
~~~

## Dia: 16/01/2024
### Criação da tabela tb_produtos no BD WebDigital

~~~sql
CREATE TABLE pct_produtos (
    id_pct INT AUTO_INCREMENT PRIMARY KEY,
    pct_cod INT(4),
    pct_produtos VARCHAR(255)
);
~~~

### Inserção dos produtos dos pacotes fotográficos no BD WebDigital

~~~sql
INSERT INTO pct_produtos (pct_cod, pct_produtos) VALUES
(1000, 'PACOTE FOTOGRÁFICO VIPP'),
(1001, 'PACOTE FOTOGRÁFICO UNIVERSAL'),
(1002, 'PACOTE FOTOGRÁFICO STYLO'),
(1003, 'PACOTE FOTOGRÁFICO ESTRELINHA'),
(1004, 'PACOTE FOTOGRÁFICO PERSONALITÉ');
~~~

### Criação das tabelas no BD WebCaixa

#### Tabela de Clientes
~~~sql
CREATE TABLE Clientes (
    ClienteID INT PRIMARY KEY,
    Nome VARCHAR(255),
    Endereco VARCHAR(255)
    -- Outros campos relacionados ao cliente
);
~~~

#### Tabela de Produtos
~~~sql
CREATE TABLE Produtos (
    ProdutoID INT PRIMARY KEY,
    NomeProduto VARCHAR(255),
    Preco DECIMAL(10, 2)
    -- Outros campos relacionados ao produto
);
~~~

#### Tabela de Vendas
~~~sql
CREATE TABLE Vendas (
    VendaID INT PRIMARY KEY,
    ClienteID INT,
    DataVenda DATE,
    FOREIGN KEY (ClienteID) REFERENCES Clientes(ClienteID)
    -- Outros campos relacionados à venda
);
~~~

#### Tabela de Itens de Vendas
~~~sql
CREATE TABLE ItensVenda (
    ItemID INT PRIMARY KEY,
    VendaID INT,
    ProdutoID INT,
    Quantidade INT,
    PrecoUnitario DECIMAL(10, 2),
    FOREIGN KEY (VendaID) REFERENCES Vendas(VendaID),
    FOREIGN KEY (ProdutoID) REFERENCES Produtos(ProdutoID)
    -- Outros campos relacionados ao item de venda
);
~~~

#### Tabela de Carnês
~~~sql
CREATE TABLE ItensVenda (
    ItemID INT PRIMARY KEY,
    VendaID INT,
    ProdutoID INT,
    Quantidade INT,
    PrecoUnitario DECIMAL(10, 2),
    FOREIGN KEY (VendaID) REFERENCES Vendas(VendaID),
    FOREIGN KEY (ProdutoID) REFERENCES Produtos(ProdutoID)
    -- Outros campos relacionados ao item de venda
);
~~~

#### Tabela de Pagamentos
~~~sql
CREATE TABLE Pagamentos (
    PagamentoID INT PRIMARY KEY,
    VendaID INT,
    CarneID INT,
    DataPagamento DATE,
    ValorPago DECIMAL(10, 2),
    FOREIGN KEY (VendaID) REFERENCES Vendas(VendaID),
    FOREIGN KEY (CarneID) REFERENCES Carnes(CarneID)
    -- Outros campos relacionados ao pagamento
);
~~~

#### Tabela de Detalhes de Pagamento Inicial
~~~sql
CREATE TABLE DetalhesPagamentoInicial (
    DetalhePagamentoID INT PRIMARY KEY,
    VendaID INT,
    DataEscolhida DATE,
    ValorEntrada DECIMAL(10, 2),
    MetodoPagamento VARCHAR(50), -- Pode ser 'Dinheiro', 'Pix', 'Cartão Débito', 'Cartão Crédito'
    ValorPrimeiraPrestacao DECIMAL(10, 2),
    ValorSegundaPrestacao DECIMAL(10, 2),
    FOREIGN KEY (VendaID) REFERENCES Vendas(VendaID)
);
~~~

## Dia: 27/01/2024
### Criação da tabela taxas2 no BD WebCaixa



## Dia: 27/01/2024
### Criação da tabela tiporec2 no BD WebCaixa


## Dia: 12/02/2024
### Criação da tabela contratos_carnes no BD WebCaixa

~~~sql
CREATE TABLE contratos_carnes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cod_carne VARCHAR(10) UNIQUE,
    cpf_cliente VARCHAR(11),
    cliente VARCHAR(255),
    modelo VARCHAR(255),
    endereco_cliente VARCHAR(255),
    email_cliente VARCHAR(255),
    tel_fix_cliente VARCHAR(11),
    tel_cel_cliente VARCHAR(11),
    tel_rec_cliente VARCHAR(11),
    descricao_produto VARCHAR(255),
    nome_produto VARCHAR(255),
    vlr_total DECIMAL(10, 2),
    vlr_entrada DECIMAL(10, 2),
    tipo_pagamento_entrada VARCHAR(20),
    vlr_prest_ini_1 DECIMAL(10, 2),
    vlr_prest_ini_2 DECIMAL(10, 2),
    vlr_restante DECIMAL(10, 2),
    vlr_parcela DECIMAL(10, 2),
    qtd_parcela INT,
    dt_primeira_parcela DATE,
    dt_segunda_parcela DATE,
    prazo_entrega VARCHAR(20),
    vendor VARCHAR(8),
    nome_vendor VARCHAR(255),
    caixa VARCHAR(50),
    cod_pc VARCHAR(3),
    obs TEXT,
    dt_criada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

~~~

## Dia: 15/02/2024
### Configuração do MySQL para Aceitar Conexões Remotas

#### Editar o arquivo my.cnf (50-servers.cnf)

~~~txt
No MySQL, a porta padrão é a 3306. Se o seu servidor
MySQL estiver configurado para usar uma porta 
diferente, você precisará ajustar de acordo. No 
entanto, se você estiver usando a porta padrão, 
geralmente não precisa fazer nada no MySQL para 
"habilitar" a porta 3306, pois ela é a porta padrão de 
escuta.

O que você precisa garantir é que o MySQL esteja 
configurado para aceitar conexões remotas e que seu 
firewall permita o tráfego na porta 3306.

Aqui estão os passos gerais:

Configuração do MySQL para Aceitar Conexões Remotas:

    Abra o arquivo de configuração do MySQL. O caminho 
    do arquivo pode variar dependendo do sistema 
    operacional, mas geralmente é algo como /etc/mysql/
    my.cnf ou /etc/my.cnf.
    
    Localize a linha bind-address e comente-a ou 
    configure para o endereço IP do seu servidor. Isso 
    permite que o MySQL aceite conexões de qualquer 
    endereço IP.
    
    Exemplo:

    # Comentado ou remova a linha abaixo
    # bind-address = 127.0.0.1

    Para:

    # Comentado ou remova a linha abaixo
    # bind-address = 192.168.0.10 # ip estático do 
    WebCaixa
~~~

#### Configuração do MySQL para uma Porta Personalizada

~~~txt
Abra o arquivo de configuração do MySQL. O caminho do 
arquivo pode variar dependendo do sistema operacional, 
mas geralmente é algo como /etc/mysql/my.cnf ou /etc/
my.cnf.

Localize a seção [mysqld] no arquivo.

Adicione ou ajuste a linha port para a nova porta 
desejada. Por exemplo, se deseja usar a porta 28770, 
adicione a seguinte linha:

port = 28770

Salve as configurações e reinicie o servidor.
~~~

#### Configuração do Firewall para a Nova Porta

~~~txt
Abra a configuração do seu firewall. Se estiver usando 
o UFW, você pode fazer isso com o comando:

# sudo ufw allow 28770

Para verificar se a porta está habilitada:

# sudo ufw status

Reinicie o firewall:

# sudo ufw reload
~~~

#### Verifique as Permissões do Usuário no MariaDB

~~~txt
Certifique-se de que o usuário que está tentando 
conectar tem permissões adequadas para acessar o banco 
de dados de hosts remotos.

Acesse o mysql pelo terminal e insira este comando 
abaixo:

> GRANT ALL PRIVILEGES ON *.* TO 'root'@'192.168.0.100' 
IDENTIFIED BY 'newcxstd' WITH GRANT OPTION;

> FLUSH PRIVILEGES;

Saia do mysql e reinicie o serviço:

# sudo systemctl restart mariadb

Para acessar remotamente o banco de dados do servidor
WebDigital:

# Use o ip do servidor remoto, o usuário da máquina 
que está solicitando e porta
 
# mysql -h 192.168.0.70 -u root -p -P 28770


