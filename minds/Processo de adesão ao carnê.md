# *Processo de Adesão ao Carnê*

## WebDigital
- Adessão ao Carnê
    - *Pesquisa do Cliente ou Modelo*
    ========================
    nome_cli
    nome_mod
    dt_fotogr
    cpf
    codcli
    vendor

        - *Cadastramento de Dados do Cliente*
        ============================
        nome_cli*
        nome_mod*
        cpf*
        ~~endereco~~
        ~~num_end*~~
        ~~compl_end~~
        ~~bairro~~
        ~~cidade~~
        ~~estado~~
        ~~cep*~~
        tel_1*
        tel_2
        cel_1 (whatsapp)*
        cel_2
        email*
        ~~facebook~~
        ~~instagram~~
        pc*
        ~~num_carne*~~
        recibo (num_nota_fiscal)*
        pacote_fotográfico
        obs
            
            - *Confirmação da Pré Adesão do Carnê*
            =============================
            num_carne*
            num_nota_fiscal*
            
                - *Envio dos dados para WebCaixa >>>*

## WebCaixa
- Carnê
    - *Pesquisa de Cliente*
    ================
    nome_cli
    nome_mod
    dt_fotogr
    cpf
        - *Cadastramento de Dados do Cliente Para o Carnê*
        =======================================
        num_carne*
        num_cli
        num_nota_fiscal
        vlr_total_compra 
        vlr_entr *(pix, c.débito, c.crédito)*
        vlr_tx_dia_atraso
        quant_parc
        venc

            - *Contrato de Financiamento Para a Compra (Espelho)*
            =========================================
            num_carne*
            *impress_espelho >>>*
            *confirmar criação do carne*

                - *Criação do Carnê*
                ==============
                num_carne*
                *impress_carne >>>*

- Pagamento Carnê
    