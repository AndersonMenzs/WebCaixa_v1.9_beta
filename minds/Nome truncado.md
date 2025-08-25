# Como Truncar Nomes no Formato "Primeiro Nome + Inicial do Sobrenome"

Para transformar nomes completos como "CAMILA ANDRADE FERREIRA" em "CAMILA A.", você pode usar a seguinte função em PHP:

## Solução em PHP

```php
function truncarNome($nomeCompleto) {
    // Dividir o nome em partes
    $partes = explode(' ', trim($nomeCompleto));
    
    // Se tiver apenas uma parte, retornar como está
    if (count($partes) <= 1) {
        return $nomeCompleto;
    }
    
    // Pegar o primeiro nome
    $primeiroNome = array_shift($partes);
    
    // Pegar a primeira letra do próximo sobrenome
    $inicialSobrenome = substr($partes[0], 0, 1) . '.';
    
    return $primeiroNome . ' ' . $inicialSobrenome;
}

// Exemplo de uso:
echo truncarNome('CAMILA ANDRADE FERREIRA'); // Retorna: CAMILA A.
echo truncarNome('JOÃO CARLOS DA SILVA');    // Retorna: JOÃO C.
echo truncarNome('MARIA');                   // Retorna: MARIA
```

## Versão para usar no seu arquivo `buscar_funcionarias.php`

```php
// ... (código existente)

while ($row = $result->fetch_assoc()) {
    // Truncar o nome antes de adicionar ao array
    $nomeTruncado = truncarNome($row['nome']);
    $resultados[] = $nomeTruncado;
}

// ... (restante do código existente)

// Adicionar a função auxiliar
function truncarNome($nomeCompleto) {
    $partes = explode(' ', trim($nomeCompleto));
    if (count($partes) <= 1) return $nomeCompleto;
    $primeiroNome = array_shift($partes);
    $inicialSobrenome = substr($partes[0], 0, 1) . '.';
    return $primeiroNome . ' ' . $inicialSobrenome;
}
```

## Solução em JavaScript (para fazer no frontend)

Se preferir fazer no lado do cliente:

```javascript
function truncarNome(nomeCompleto) {
    const partes = nomeCompleto.trim().split(' ');
    if (partes.length <= 1) return nomeCompleto;
    const primeiroNome = partes.shift();
    const inicialSobrenome = partes[0].charAt(0) + '.';
    return primeiroNome + ' ' + inicialSobrenome;
}

// Exemplo:
console.log(truncarNome('CAMILA ANDRADE FERREIRA')); // "CAMILA A."
```

## Considerações importantes:

1. **Nomes compostos**: Se precisar tratar nomes como "João Carlos" mantendo as duas primeiras partes, modifique a função
2. **Prefijos**: Para nomes com "DA", "DE", "DOS" etc., você pode querer pular essas partes
3. **Case sensitivity**: A função mantém o case original, você pode adicionar `ucfirst(strtolower())` se quiser uniformizar

## Versão aprimorada (ignorando preposições):

```php
function truncarNome($nomeCompleto) {
    $ignorar = ['de', 'da', 'das', 'do', 'dos', 'e'];
    $partes = explode(' ', trim($nomeCompleto));
    
    if (count($partes) <= 1) return $nomeCompleto;
    
    $primeiroNome = array_shift($partes);
    
    // Encontrar o primeiro sobrenome significativo
    $sobrenome = '';
    foreach ($partes as $parte) {
        if (!in_array(strtolower($parte), $ignorar)) {
            $sobrenome = $parte;
            break;
        }
    }
    
    $inicialSobrenome = $sobrenome ? substr($sobrenome, 0, 1) . '.' : '';
    
    return $primeiroNome . ($inicialSobrenome ? ' ' . $inicialSobrenome : '');
}
```