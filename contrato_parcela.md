# TAREFA FINAL – ANÁLISE COMPLETA DE SITUAÇÕES DE CAIXA

**Regras fixas adotadas:**
- Total de parcelas: 12
- Valor de cada parcela: R$ 100,00
- Vencimento: dia 5 de cada mês

---

## SITUAÇÃO 1

**Descrição:** Cliente tem a prestação de R$ 100,00 e o valor recebido é de R$ 100,00 – está pagando somente a parcela 1.

| Campo | Informação |
|-------|------------|
| Parcela | 1/12 |
| Valor devido | R$ 100,00 |
| Valor recebido | R$ 100,00 |
| Diferença | R$ 0,00 |
| Status | Quitada |
| Saldo devedor após pagamento | R$ 1.100,00 (parcelas 2 a 12) |

**Lançamento contábil:**
- Débito: Caixa/Banco R$ 100,00
- Crédito: Clientes R$ 100,00

**Observações:** Pagamento em dia (considerando que ocorreu até o dia 5). Nenhum acréscimo ou desconto aplicado.

---

## SITUAÇÃO 2

**Descrição:** Cliente tem a prestação de R$ 100,00 e o valor recebido é de R$ 80,00 – está pagando somente uma parcial da parcela 1.

| Campo | Informação |
|-------|------------|
| Parcela | 1/12 |
| Valor devido | R$ 100,00 |
| Valor recebido | R$ 80,00 |
| Diferença | R$ 20,00 (em aberto) |
| Status | Parcialmente paga |
| Saldo devedor após pagamento | R$ 1.120,00 (R$ 20,00 da parcela 1 + R$ 1.100,00 das parcelas 2 a 12) |

**Lançamento contábil:**
- Débito: Caixa/Banco R$ 80,00
- Crédito: Clientes R$ 80,00

**Observações:**
- Os R$ 20,00 remanescentes da parcela 1 continuam em aberto.
- É necessário definir: será cobrado junto com a parcela 2? Haverá multa/juros sobre esse saldo?
- Data do pagamento é essencial para saber se houve atraso.

---

## SITUAÇÃO 3

**Descrição:** Cliente tem a prestação de R$ 100,00 e o valor recebido é de R$ 120,00 – está pagando a parcela 1 e uma parcial da 2 (R$ 20,00) para o próximo mês.

| Campo | Informação |
|-------|------------|
| Parcela 1 | Quitada (R$ 100,00) |
| Parcela 2 | Saldo remanescente: R$ 80,00 (R$ 20,00 adiantados) |
| Total recebido | R$ 120,00 |
| Saldo devedor após pagamento | R$ 1.080,00 (R$ 80,00 da parcela 2 + R$ 1.000,00 das parcelas 3 a 12) |

**Lançamento contábil:**
- Débito: Caixa/Banco R$ 100,00 (parcela 1)
- Débito: Caixa/Banco R$ 20,00 (adiantamento parcela 2)
- Crédito: Clientes R$ 100,00 (baixa parcela 1)
- Crédito: Adiantamento de clientes R$ 20,00

**Observações:**
- A parcela 2 terá saldo de R$ 80,00 no vencimento.
- É preciso definir como o sistema tratará esse adiantamento.
- Verificar se houve desconto por antecipação (se aplicável).

---

## SITUAÇÃO 4

**Descrição:** Cliente tem a prestação de R$ 100,00 e o valor recebido é de R$ 80,00, porque a cliente deixou no mês passado uma parcial de R$ 20,00 – então ela está pagando a parcela 2.

| Campo | Informação |
|-------|------------|
| Parcela 1 | Quitada (com aproveitamento do crédito de R$ 20,00) |
| Parcela 2 | Quitada (R$ 80,00 pagos agora + R$ 20,00 de crédito) |
| Total recebido agora | R$ 80,00 |
| Saldo devedor após pagamento | R$ 1.000,00 (parcelas 3 a 12) |

**Lançamento contábil:**
- Débito: Caixa/Banco R$ 80,00
- Débito: Crédito a utilizar R$ 20,00
- Crédito: Clientes R$ 100,00

**Observações (pontos críticos):**
- Os R$ 20,00 do mês passado sofreram multa/juros? Se a parcela 1 venceu no dia 5 e só foi quitada agora, deveria ter sido cobrado juros e multa.
- A parcela 2 está em dia? Se o pagamento ocorreu após o dia 5, também teria atraso.
- Recomenda-se definir uma regra clara para aproveitamento de créditos e cobrança de juros/multa.

---

## SITUAÇÃO 5

**Descrição:** Cliente tem a prestação de R$ 100,00 e o valor recebido é de R$ 220,00 – está pagando a 1 e a 2 parcelas e uma parcial da 3 de R$ 20,00.

| Campo | Informação |
|-------|------------|
| Parcela 1 | Quitada (R$ 100,00) |
| Parcela 2 | Quitada (R$ 100,00) |
| Parcela 3 | Saldo remanescente: R$ 80,00 (R$ 20,00 adiantados) |
| Total recebido | R$ 220,00 |
| Saldo devedor após pagamento | R$ 980,00 (R$ 80,00 da parcela 3 + R$ 900,00 das parcelas 4 a 12) |

**Lançamento contábil:**
- Débito: Caixa/Banco R$ 200,00 (parcelas 1 e 2)
- Débito: Caixa/Banco R$ 20,00 (adiantamento parcela 3)
- Crédito: Clientes R$ 200,00 (baixa parcelas 1 e 2)
- Crédito: Adiantamento de clientes R$ 20,00

**Observações:**
- A conta fecha perfeitamente: 100 + 100 + 20 = 220.
- A parcela 3 terá saldo de R$ 80,00 no vencimento.
- É necessário definir a regra de abatimento.
- Verificar se houve atraso nas parcelas 1 e/ou 2 e se multa/juros foram aplicados.

---

## QUADRO RESUMO GERAL

| Situação | Parcela | Valor Recebido | Status | Saldo Remanescente | Saldo Devedor Total Após |
|----------|---------|----------------|--------|---------------------|---------------------------|
| 1 | 1/12 | R$ 100,00 | Quitada | R$ 0,00 | R$ 1.100,00 |
| 2 | 1/12 | R$ 80,00 | Parcial | R$ 20,00 (parcela 1) | R$ 1.120,00 |
| 3 | 1/12 + adiantamento R$ 20,00 da 2/12 | R$ 120,00 | Parcela 1 quitada; Parcela 2 com saldo | R$ 80,00 (parcela 2) | R$ 1.080,00 |
| 4 | 2/12 (com crédito de R$ 20,00 da parcela 1) | R$ 80,00 | Parcela 2 quitada | R$ 0,00 | R$ 1.000,00 |
| 5 | 1/12 + 2/12 + adiantamento R$ 20,00 da 3/12 | R$ 220,00 | Parcelas 1 e 2 quitadas; Parcela 3 com saldo | R$ 80,00 (parcela 3) | R$ 980,00 |

---

## RECOMENDAÇÕES FINAIS

1. Definir política de aproveitamento de créditos – como tratar sobras de pagamento.
2. Definir política de cobrança de multa e juros – para saldos remanescentes em aberto após o vencimento.
3. Registrar sempre a data do pagamento – essencial para saber se há atraso.
4. Registrar a forma de pagamento – para conciliação bancária e rastreabilidade.
5. Manter um sistema (ou planilha) que controle saldos por parcela – evitando duplicidade.

---